<?php

/**
 * Analytics storage: schema, daily aggregation, retention and report queries.
 *
 * Keep this file identical in ChatHelp and ChatHelp Pro, apart from the
 * namespace. The tables, options and cron hooks are shared, so a site can move
 * between free and Pro, or run either at an older version, without any data
 * step. The raw table keeps its 3.7.1 columns, so older code can still read and
 * write it.
 *
 * @package chat-help
 */

namespace ThemeAtelier\ChatHelp\Admin;

// All SQL here runs on the plugin's own tables, whose names are built from
// $wpdb->prefix. Variable fragments come from $wpdb->prepare().
// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.PreparedSQL.NotPrepared, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.SchemaChange

if (! defined('ABSPATH')) {
    die;
}

class AnalyticsStore
{
    /** Bump when the schema changes. Shared by free and Pro. */
    const DB_VERSION = '1';

    const OPTION_DB_VERSION   = 'chat_help_analytics_db_version';
    const OPTION_LEGACY_UNTIL = 'chat_help_analytics_legacy_until';
    const OPTION_STATE        = 'chat_help_analytics_state';

    const CRON_AGGREGATE = 'chat_help_analytics_aggregate';
    const CRON_RETENTION = 'chat_help_analytics_retention';

    const DEFAULT_RETENTION_DAYS = 90;

    /** Raw ids covered by one aggregation transaction. */
    const AGGREGATE_BATCH = 20000;
    /** Seconds one cron run may spend aggregating or purging. */
    const CRON_BUDGET = 20;
    /** Seconds of aggregation allowed inside the admin request that upgrades. */
    const UPGRADE_BUDGET = 5;
    /** Raw rows younger than this are left for the next run, in case an earlier id has not committed yet. */
    const SETTLE_SECONDS = 10;
    /** Seconds a dashboard request may spend catching up on new events. */
    const REFRESH_BUDGET = 3;
    /** Seconds a dashboard request waits for another one that is already catching up. */
    const REFRESH_WAIT = 5;

    const PURGE_BATCH = 1000;
    /** Seconds to wait before more work when a cron run hits its budget. */
    const CONTINUE_DELAY = 60;

    /** Days that tokenless single-event requests stay accepted after an upgrade. */
    const LEGACY_DAYS = 7;

    const CACHE_TTL = 15 * MINUTE_IN_SECONDS;

    public static function raw_table(): string
    {
        return $GLOBALS['wpdb']->prefix . 'chat_help_analytics';
    }

    public static function daily_table(): string
    {
        return $GLOBALS['wpdb']->prefix . 'chat_help_analytics_daily';
    }

    public static function dim_table(): string
    {
        return $GLOBALS['wpdb']->prefix . 'chat_help_analytics_daily_dim';
    }

    public static function leads_table(): string
    {
        return $GLOBALS['wpdb']->prefix . 'chat_help_leads';
    }

    /**
     * Registers cron handlers and the upgrade check.
     */
    public static function register(): void
    {
        add_action('init', [self::class, 'maybe_upgrade'], 5);
        add_action('admin_init', [self::class, 'schedule']);
        add_action('wp', [self::class, 'schedule']);
        add_action(self::CRON_AGGREGATE, [self::class, 'run_aggregate_cron']);
        add_action(self::CRON_RETENTION, [self::class, 'run_retention_cron']);
    }

    /**
     * Runs the migration once per schema version. The version option is
     * autoloaded, so this check costs no query on normal requests.
     */
    public static function maybe_upgrade(): void
    {
        if (self::DB_VERSION !== (string) get_option(self::OPTION_DB_VERSION)) {
            self::upgrade();
        }
    }

    public static function activate(): void
    {
        self::maybe_upgrade();
        self::schedule();
    }

    public static function deactivate(): void
    {
        // If the other edition stays active, it schedules these again on its next request.
        wp_clear_scheduled_hook(self::CRON_AGGREGATE);
        wp_clear_scheduled_hook(self::CRON_RETENTION);
    }

    public static function schedule(): void
    {
        if (! wp_next_scheduled(self::CRON_AGGREGATE)) {
            wp_schedule_event(time() + MINUTE_IN_SECONDS, 'hourly', self::CRON_AGGREGATE);
        }
        if (! wp_next_scheduled(self::CRON_RETENTION)) {
            wp_schedule_event(time() + HOUR_IN_SECONDS, 'daily', self::CRON_RETENTION);
        }
    }

    /**
     * Creates or alters the tables. Existing rows are never changed.
     */
    public static function upgrade(): void
    {
        global $wpdb;

        if (! self::lock('schema')) {
            return;
        }

        $raw_exists = (bool) $wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', self::raw_table()));

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta(self::schema());
        self::drop_unused_indexes();

        $state = self::state();
        if (! $state['target']) {
            $state['target'] = (int) $wpdb->get_var('SELECT MAX(id) FROM `' . self::raw_table() . '`');
            update_option(self::OPTION_STATE, $state, false);
        }

        // Only an upgrading site can have pages cached with the old tracker.
        if ($raw_exists && $state['target'] && ! get_option(self::OPTION_LEGACY_UNTIL)) {
            update_option(self::OPTION_LEGACY_UNTIL, time() + self::LEGACY_DAYS * DAY_IN_SECONDS, true);
        }

        update_option(self::OPTION_DB_VERSION, self::DB_VERSION, true);
        self::unlock('schema');
        self::schedule();

        // Existing data is imported in the background, with a head start when an
        // admin is waiting. A visitor's request never does this work.
        if ($state['target'] && $state['cursor'] < $state['target']) {
            if (is_admin() && ! wp_doing_ajax()) {
                self::aggregate(self::UPGRADE_BUDGET);
            }
            self::schedule_continuation(self::CRON_AGGREGATE);
        }
    }

    private static function schema(): array
    {
        global $wpdb;
        $charset = $wpdb->get_charset_collate();
        $raw     = self::raw_table();
        $daily   = self::daily_table();
        $dim     = self::dim_table();
        $leads   = self::leads_table();

        return [
            "CREATE TABLE $raw (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            widget_id BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
            event_type VARCHAR(20) NOT NULL,
            device_type VARCHAR(10) NOT NULL DEFAULT 'desktop',
            country VARCHAR(3) NOT NULL DEFAULT '',
            browser VARCHAR(30) NOT NULL DEFAULT '',
            page_url VARCHAR(500) NOT NULL DEFAULT '',
            session_id VARCHAR(64) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            KEY idx_created_at (created_at)
        ) $charset;",
            "CREATE TABLE $daily (
            stat_date DATE NOT NULL,
            widget_id BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
            event_type VARCHAR(20) NOT NULL,
            device_type VARCHAR(10) NOT NULL DEFAULT 'desktop',
            total INT(10) UNSIGNED NOT NULL DEFAULT 0,
            PRIMARY KEY  (stat_date,widget_id,event_type,device_type),
            KEY idx_widget_date (widget_id,stat_date)
        ) $charset;",
            "CREATE TABLE $dim (
            dimension VARCHAR(10) NOT NULL,
            stat_date DATE NOT NULL,
            widget_id BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
            event_type VARCHAR(20) NOT NULL,
            dim_hash CHAR(32) NOT NULL,
            dim_value VARCHAR(500) NOT NULL DEFAULT '',
            total INT(10) UNSIGNED NOT NULL DEFAULT 0,
            PRIMARY KEY  (dimension,stat_date,widget_id,event_type,dim_hash)
        ) $charset;",
            "CREATE TABLE $leads (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            field LONGTEXT NOT NULL,
            meta LONGTEXT NOT NULL,
            agent_name VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            KEY idx_created_at (created_at)
        ) $charset;",
        ];
    }

    /**
     * Reports no longer read the raw table, so these indexes only slow every
     * INSERT. 3.7.1 code re-creates them if a site runs it again.
     */
    private static function drop_unused_indexes(): void
    {
        global $wpdb;
        $table = self::raw_table();
        foreach (['idx_widget_event_date', 'idx_device', 'idx_country', 'idx_browser'] as $index) {
            if ($wpdb->get_results($wpdb->prepare("SHOW INDEX FROM `$table` WHERE Key_name = %s", $index))) {
                $wpdb->query("ALTER TABLE `$table` DROP INDEX `$index`");
            }
        }
    }

    /**
     * @return array{cursor:int,target:int,at:int} Last aggregated raw id, raw id
     *         that the initial import must reach, and time of the last run.
     */
    public static function state(): array
    {
        $state = get_option(self::OPTION_STATE);
        return [
            'cursor' => (int) ($state['cursor'] ?? 0),
            'target' => (int) ($state['target'] ?? 0),
            'at'     => (int) ($state['at'] ?? 0),
        ];
    }

    /**
     * Report data is incomplete until the initial import reaches its target.
     */
    public static function is_backfilling(?array $state = null): bool
    {
        $state = $state ?? self::state();
        return $state['cursor'] < $state['target'];
    }

    public static function status(): array
    {
        $state = self::state();
        return [
            'backfilling' => self::is_backfilling($state),
            'progress'    => $state['target'] ? min(100, (int) floor($state['cursor'] / $state['target'] * 100)) : 100,
            'updated_at'  => $state['at'],
        ];
    }

    public static function run_aggregate_cron(): void
    {
        if (! self::aggregate(self::CRON_BUDGET)) {
            self::schedule_continuation(self::CRON_AGGREGATE);
        }
    }

    public static function run_retention_cron(): void
    {
        if (! self::purge(self::CRON_BUDGET)) {
            self::schedule_continuation(self::CRON_RETENTION);
        }
    }

    private static function schedule_continuation(string $hook): void
    {
        // The argument stops WordPress treating this as a duplicate of the
        // recurring event when that is due within 10 minutes. Handlers ignore it.
        wp_schedule_single_event(time() + self::CONTINUE_DELAY, $hook, ['continue']);
    }

    /**
     * Rolls raw events into the summary tables, oldest first.
     *
     * The cursor moves in the same transaction as the counts, so a crash
     * repeats a batch cleanly instead of counting it twice. Reading before
     * opening the transaction means live INSERTs are never blocked by locks on
     * the raw table.
     *
     * @param int $budget Seconds to spend.
     * @return bool True when there is nothing left to do.
     */
    public static function aggregate(int $budget, int $wait = 0): bool
    {
        if (! self::lock('aggregate', $wait)) {
            return true; // Another run is on it.
        }

        $deadline = microtime(true) + $budget;
        $done     = false;

        do {
            $done = self::aggregate_batch();
            if (! $done) {
                usleep(50000); // Leave room for other sites on the server.
            }
        } while (! $done && microtime(true) < $deadline);

        self::unlock('aggregate');
        return $done;
    }

    /**
     * @return bool True when no settled raw rows remain.
     */
    private static function aggregate_batch(): bool
    {
        global $wpdb;

        $raw   = self::raw_table();
        $state = self::state();

        $to = self::next_batch_end($state['cursor']);

        if (! $to) {
            // All settled rows are counted. Anything left is seconds old and belongs
            // to the next run, so the initial import is finished.
            $state['at']     = time();
            $state['target'] = min($state['target'], $state['cursor']);
            update_option(self::OPTION_STATE, $state, false);
            return true;
        }

        $range = $wpdb->prepare('id > %d AND id <= %d AND created_at IS NOT NULL', $state['cursor'], $to);

        $daily   = self::read_rows("SELECT DATE(created_at) AS d, widget_id AS w, event_type AS e, device_type AS v, COUNT(*) AS c FROM `$raw` WHERE $range GROUP BY DATE(created_at), widget_id, event_type, device_type");
        $country = self::read_dimension('country', $range);
        $page    = self::read_dimension('page_url', $range);
        $browser = self::read_dimension('browser', $range);
        if (null === $daily || null === $country || null === $page || null === $browser) {
            return true; // Try again on the next run.
        }

        $wpdb->query('START TRANSACTION');
        $ok = self::write_daily($daily)
            && self::write_dimension('country', $country)
            && self::write_dimension('page', $page)
            && self::write_dimension('browser', $browser);

        if ($ok) {
            $state['cursor'] = $to;
            $state['at']     = time();
            $ok              = false !== update_option(self::OPTION_STATE, $state, false);
        }

        if (! $ok) {
            $wpdb->query('ROLLBACK');
            wp_cache_delete(self::OPTION_STATE, 'options');
            return true;
        }
        $wpdb->query('COMMIT');

        return false;
    }

    /**
     * Picks the last raw id for the next batch, or 0 if nothing is ready.
     *
     * Rows are read in id order, so a row still uncommitted must stay ahead of the
     * cursor: committed behind it, it would be missed forever. Skipping very recent
     * rows covers that. The search works on id, not created_at, because imported or
     * restored rows can have ids out of date order, and it starts from the next
     * existing id so a large gap cannot stall it.
     */
    private static function next_batch_end(int $cursor): int
    {
        global $wpdb;
        $raw   = self::raw_table();
        $first = (int) $wpdb->get_var($wpdb->prepare("SELECT MIN(id) FROM `$raw` WHERE id > %d", $cursor));
        if (! $first) {
            return 0;
        }
        return (int) $wpdb->get_var($wpdb->prepare(
            "SELECT MAX(id) FROM `$raw` WHERE id >= %d AND id < %d AND (created_at IS NULL OR created_at < NOW() - INTERVAL %d SECOND)",
            $first,
            $first + self::AGGREGATE_BATCH,
            self::SETTLE_SECONDS
        ));
    }

    /**
     * @return array[]|null Rows, or null if the query failed.
     */
    private static function read_rows(string $sql): ?array
    {
        global $wpdb;
        $rows = $wpdb->get_results($sql, ARRAY_A);
        return '' === $wpdb->last_error ? (array) $rows : null;
    }

    /**
     * Grouping includes the hash because the collation is case-insensitive: two
     * URLs differing only in case stay separate rows, and the report merges them
     * as it always did.
     */
    private static function read_dimension(string $column, string $range): ?array
    {
        $raw = self::raw_table();
        return self::read_rows(
            "SELECT DATE(created_at) AS d, widget_id AS w, event_type AS e, MD5(`$column`) AS h, `$column` AS val, COUNT(*) AS c
             FROM `$raw` WHERE $range AND `$column` != ''
             GROUP BY DATE(created_at), widget_id, event_type, `$column`, MD5(`$column`)"
        );
    }

    private static function write_daily(array $rows): bool
    {
        global $wpdb;
        $table = self::daily_table();
        foreach (array_chunk($rows, 500) as $chunk) {
            $values = [];
            foreach ($chunk as $row) {
                $values[] = $wpdb->prepare('(%s,%d,%s,%s,%d)', $row['d'], $row['w'], $row['e'], $row['v'], $row['c']);
            }
            $result = $wpdb->query("INSERT INTO `$table` (stat_date,widget_id,event_type,device_type,total) VALUES " . implode(',', $values) . ' ON DUPLICATE KEY UPDATE total = total + VALUES(total)');
            if (false === $result) {
                return false;
            }
        }
        return true;
    }

    private static function write_dimension(string $dimension, array $rows): bool
    {
        global $wpdb;
        $table = self::dim_table();
        foreach (array_chunk($rows, 500) as $chunk) {
            $values = [];
            foreach ($chunk as $row) {
                $values[] = $wpdb->prepare('(%s,%s,%d,%s,%s,%s,%d)', $dimension, $row['d'], $row['w'], $row['e'], $row['h'], $row['val'], $row['c']);
            }
            $result = $wpdb->query("INSERT INTO `$table` (dimension,stat_date,widget_id,event_type,dim_hash,dim_value,total) VALUES " . implode(',', $values) . ' ON DUPLICATE KEY UPDATE total = total + VALUES(total)');
            if (false === $result) {
                return false;
            }
        }
        return true;
    }

    public static function retention_days(): int
    {
        $settings = get_option('ch_settings');
        $days     = $settings['analytics_retention_days'] ?? self::DEFAULT_RETENTION_DAYS;
        return is_numeric($days) ? max(0, (int) $days) : self::DEFAULT_RETENTION_DAYS;
    }

    /**
     * Deletes old raw events in small batches. Only rows already counted in the
     * summary tables qualify, so reports cannot lose data here.
     *
     * @param int $budget Seconds to spend.
     * @return bool True when nothing is left to delete.
     */
    public static function purge(int $budget): bool
    {
        global $wpdb;

        $days = self::retention_days();
        if ($days < 1) {
            return true; // 0 means keep raw events forever.
        }

        $raw    = self::raw_table();
        $cursor = self::state()['cursor'];
        if (! $cursor) {
            return true; // Nothing has been aggregated yet, so nothing may go.
        }
        $deadline = microtime(true) + $budget;

        do {
            $deleted = $wpdb->query($wpdb->prepare(
                "DELETE FROM `$raw` WHERE created_at < NOW() - INTERVAL %d DAY AND id <= %d ORDER BY created_at LIMIT %d",
                $days,
                $cursor,
                self::PURGE_BATCH
            ));
            if (false === $deleted) {
                return true;
            }
            if ($deleted < self::PURGE_BATCH) {
                return true;
            }
            usleep(100000);
        } while (microtime(true) < $deadline);

        return false;
    }

    /**
     * Per-process locks on one connection, so overlapping cron runs cannot both
     * advance the cursor. MySQL releases them if the connection drops.
     */
    private static function lock(string $name, int $wait = 0): bool
    {
        global $wpdb;
        return 1 === (int) $wpdb->get_var($wpdb->prepare('SELECT GET_LOCK(%s, %d)', self::lock_name($name), $wait));
    }

    private static function unlock(string $name): void
    {
        global $wpdb;
        $wpdb->get_var($wpdb->prepare('SELECT RELEASE_LOCK(%s)', self::lock_name($name)));
    }

    private static function lock_name(string $name): string
    {
        return 'ch_' . $name . '_' . substr(md5(DB_NAME . $GLOBALS['wpdb']->prefix), 0, 16);
    }

    /**
     * Brings the summaries up to date before a report is read, so the dashboard
     * shows events from a few seconds ago instead of waiting for the hourly cron.
     *
     * Runs only on the admins' report requests. The dashboard sends several at
     * once: one does the work and the others wait for it, so all of them answer
     * with the same numbers. When nothing is new this costs one primary-key read.
     */
    public static function refresh(): void
    {
        global $wpdb;
        $newest = (int) $wpdb->get_var('SELECT MAX(id) FROM `' . self::raw_table() . '`');
        if ($newest > self::state()['cursor']) {
            self::aggregate(self::REFRESH_BUDGET, self::REFRESH_WAIT);
            wp_cache_delete(self::OPTION_STATE, 'options');
        }
    }

    /**
     * Caches a report result for 15 minutes. The key holds resolved dates, so a
     * "this week" entry cannot outlive its week. Partial numbers from the initial
     * import are never cached.
     *
     * @return mixed
     */
    public static function cached(string $name, array $args, callable $build)
    {
        $state       = self::state();
        $backfilling = self::is_backfilling($state);
        // The cursor is part of the key, so newly counted events replace a cached
        // result at once. The cache only saves repeat views of unchanged data.
        $key = 'chat_help_rep_' . md5(self::DB_VERSION . $name . $state['cursor'] . wp_json_encode($args));

        if (! $backfilling) {
            $hit = get_transient($key);
            if (false !== $hit) {
                return $hit;
            }
        }

        $data = $build();
        if (! $backfilling) {
            set_transient($key, $data, self::CACHE_TTL);
        }
        return $data;
    }

    /**
     * WHERE fragment for a report. Dates in the summary tables are the same
     * DATE(created_at) values the raw reports grouped by. No dates means all time.
     */
    private static function report_where(?string $from, ?string $to, ?int $widget): string
    {
        global $wpdb;
        $where = '';
        if ($from && $to) {
            $where .= $wpdb->prepare(' AND stat_date >= %s AND stat_date <= %s', $from, $to);
        }
        if (null !== $widget) {
            $where .= $wpdb->prepare(' AND widget_id = %d', $widget);
        }
        return $where;
    }

    /**
     * @return array<string,int> Event type => total.
     */
    public static function totals(?string $from, ?string $to, ?int $widget): array
    {
        global $wpdb;
        $where = self::report_where($from, $to, $widget);
        $rows  = $wpdb->get_results('SELECT event_type, SUM(total) AS cnt FROM `' . self::daily_table() . "` WHERE 1=1 $where GROUP BY event_type");

        $totals = ['visitor' => 0, 'view' => 0, 'conversion' => 0];
        foreach ((array) $rows as $row) {
            $totals[$row->event_type] = (int) $row->cnt;
        }
        return $totals;
    }

    /**
     * @return object[] Rows of bucket, event_type, cnt.
     */
    public static function series(?string $from, ?string $to, ?int $widget, bool $by_month): array
    {
        global $wpdb;
        $where  = self::report_where($from, $to, $widget);
        $bucket = $by_month ? "DATE_FORMAT(stat_date, '%Y-%m')" : 'stat_date';
        return (array) $wpdb->get_results("SELECT $bucket AS bucket, event_type, SUM(total) AS cnt FROM `" . self::daily_table() . "` WHERE 1=1 $where GROUP BY bucket, event_type ORDER BY bucket ASC");
    }

    /**
     * @return object[] Rows of device_type, event_type, cnt.
     */
    public static function devices(?string $from, ?string $to, ?int $widget): array
    {
        global $wpdb;
        $where = self::report_where($from, $to, $widget);
        return (array) $wpdb->get_results('SELECT device_type, event_type, SUM(total) AS cnt FROM `' . self::daily_table() . "` WHERE 1=1 $where GROUP BY device_type, event_type");
    }

    /**
     * Top values of one dimension.
     *
     * @param string $dimension country, page or browser.
     * @return object[] Rows of label, views, conversions.
     */
    public static function top_values(string $dimension, ?string $from, ?string $to, ?int $widget, int $limit = 10): array
    {
        global $wpdb;
        $where = $wpdb->prepare(' AND dimension = %s', $dimension) . self::report_where($from, $to, $widget);
        return (array) $wpdb->get_results(
            "SELECT dim_value AS label,
                    SUM(CASE WHEN event_type = 'view' THEN total ELSE 0 END) AS views,
                    SUM(CASE WHEN event_type = 'conversion' THEN total ELSE 0 END) AS conversions
             FROM `" . self::dim_table() . "` WHERE 1=1 $where
             GROUP BY dim_value ORDER BY views DESC, label ASC LIMIT " . (int) $limit
        );
    }

    /**
     * Leads are counted from their own table rather than a summary, because
     * deleting a lead must lower the total, and are never cached, so a new lead
     * shows at once. The table is small and now indexed on date.
     */
    public static function leads_count(?string $from, ?string $to): int
    {
        global $wpdb;
        $where = ($from && $to) ? $wpdb->prepare(' WHERE created_at >= %s AND created_at <= %s', $from . ' 00:00:00', $to . ' 23:59:59') : '';
        return (int) $wpdb->get_var('SELECT COUNT(*) FROM `' . self::leads_table() . "`$where");
    }

    /**
     * @return object[] Rows of bucket, cnt.
     */
    public static function leads_series(?string $from, ?string $to, bool $by_month): array
    {
        global $wpdb;
        $where  = ($from && $to) ? $wpdb->prepare(' WHERE created_at >= %s AND created_at <= %s', $from . ' 00:00:00', $to . ' 23:59:59') : '';
        $bucket = $by_month ? "DATE_FORMAT(created_at, '%Y-%m')" : 'DATE(created_at)';
        return (array) $wpdb->get_results("SELECT $bucket AS bucket, COUNT(*) AS cnt FROM `" . self::leads_table() . "`$where GROUP BY bucket ORDER BY bucket ASC");
    }
}
