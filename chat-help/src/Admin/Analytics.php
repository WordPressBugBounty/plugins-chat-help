<?php

namespace ThemeAtelier\ChatHelp\Admin;

use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;

if (! defined('ABSPATH')) {
    die;
}

class Analytics
{
    function __construct()
    {
        AnalyticsStore::register();
        add_action('rest_api_init', [$this, 'register_rest_routes']);
        add_action('wp_footer', [AnalyticsTracker::class, 'render_script']);
    }

    public function register_rest_routes()
    {
        // Normally answered by AnalyticsTracker::maybe_handle_early() before this
        // is registered. Public by design: visitors are anonymous, and handle()
        // checks the signed token, origin and rate limit before any database work.
        register_rest_route('chat-help/v1', '/analytics/track', [
            'methods'             => WP_REST_Server::CREATABLE,
            'callback'            => [$this, 'track_event'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('chat-help/v1', '/analytics', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [$this, 'get_summary'],
            'permission_callback' => [$this, 'admin_permission'],
        ]);

        register_rest_route('chat-help/v1', '/analytics/chart', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [$this, 'get_chart'],
            'permission_callback' => [$this, 'admin_permission'],
        ]);

        register_rest_route('chat-help/v1', '/analytics/devices', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [$this, 'get_devices'],
            'permission_callback' => [$this, 'admin_permission'],
        ]);

        register_rest_route('chat-help/v1', '/analytics/tables', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [$this, 'get_tables'],
            'permission_callback' => [$this, 'admin_permission'],
        ]);
    }

    public function admin_permission()
    {
        return current_user_can('manage_options');
    }

    public function track_event(WP_REST_Request $request)
    {
        return new WP_REST_Response(null, AnalyticsTracker::handle((string) $request->get_body()));
    }

    public function get_summary(WP_REST_Request $request)
    {
        AnalyticsStore::refresh();
        [$from, $to, $widget] = $this->resolve_filters($request->get_params());

        $data = AnalyticsStore::cached('summary', [$from, $to, $widget], static function () use ($from, $to, $widget) {
            $totals = AnalyticsStore::totals($from, $to, $widget);

            return [
                'visitors'        => $totals['visitor'],
                'views'           => $totals['view'],
                'conversions'     => $totals['conversion'],
                'conversion_rate' => $totals['visitor'] > 0 ? round(($totals['conversion'] / $totals['visitor']) * 100, 1) : 0,
            ];
        });

        // Leads are read live, outside the cache. See AnalyticsStore::leads_count().
        $data['total_leads'] = AnalyticsStore::leads_count($from, $to);
        $data['data_status'] = AnalyticsStore::status();

        return new WP_REST_Response($data);
    }

    public function get_chart(WP_REST_Request $request)
    {
        AnalyticsStore::refresh();
        $params               = $request->get_params();
        [$from, $to, $widget] = $this->resolve_filters($params);

        $period   = $params['period'] ?? 'this_week';
        $group_by = in_array($period, ['this_year', 'last_year'], true) ? 'month' : 'day';

        $by_month = 'month' === $group_by;

        $data = AnalyticsStore::cached('chart', [$from, $to, $widget, $group_by], function () use ($from, $to, $widget, $group_by, $by_month) {
            $labels   = $this->build_label_range($from, $to, $group_by);
            $datasets = [
                'visitors'    => array_fill(0, count($labels), 0),
                'views'       => array_fill(0, count($labels), 0),
                'conversions' => array_fill(0, count($labels), 0),
                'leads'       => array_fill(0, count($labels), 0),
            ];

            $index_map = array_flip($labels);
            $type_map  = ['visitor' => 'visitors', 'view' => 'views', 'conversion' => 'conversions'];
            foreach (AnalyticsStore::series($from, $to, $widget, $by_month) as $row) {
                if (isset($index_map[$row->bucket], $type_map[$row->event_type])) {
                    $datasets[$type_map[$row->event_type]][$index_map[$row->bucket]] = (int) $row->cnt;
                }
            }

            return ['labels' => $labels, 'datasets' => $datasets];
        });

        // Leads are read live, outside the cache. See AnalyticsStore::leads_count().
        $index_map = array_flip($data['labels']);
        foreach (AnalyticsStore::leads_series($from, $to, $by_month) as $row) {
            if (isset($index_map[$row->bucket])) {
                $data['datasets']['leads'][$index_map[$row->bucket]] = (int) $row->cnt;
            }
        }

        return new WP_REST_Response($data);
    }

    public function get_devices(WP_REST_Request $request)
    {
        AnalyticsStore::refresh();
        [$from, $to, $widget] = $this->resolve_filters($request->get_params());

        $data = AnalyticsStore::cached('devices', [$from, $to, $widget], static function () use ($from, $to, $widget) {
            $result = [
                'desktop' => ['visitors' => 0, 'views' => 0, 'conversions' => 0],
                'mobile'  => ['visitors' => 0, 'views' => 0, 'conversions' => 0],
                'other'   => ['visitors' => 0, 'views' => 0, 'conversions' => 0],
            ];

            $type_map = ['visitor' => 'visitors', 'view' => 'views', 'conversion' => 'conversions'];
            foreach (AnalyticsStore::devices($from, $to, $widget) as $row) {
                $device = isset($result[$row->device_type]) ? $row->device_type : 'other';
                if (isset($type_map[$row->event_type])) {
                    $result[$device][$type_map[$row->event_type]] += (int) $row->cnt;
                }
            }

            return $result;
        });

        return new WP_REST_Response($data);
    }

    public function get_tables(WP_REST_Request $request)
    {
        // Traffic Breakdown (countries / pages / browsers) is Pro-only. The
        // free dashboard renders a locked preview and never calls this, but
        // the data is withheld server-side too (defence-in-depth).
        return new WP_REST_Response([
            'pro'     => true,
            'message' => __('Traffic Breakdown is a Pro feature. Upgrade to see countries, pages, and browsers.', 'chat-help'),
        ], 403);
    }

    /**
     * @return array{0:string,1:string,2:?int} From date, to date, widget id or null for all.
     */
    private function resolve_filters(array $params)
    {
        $widget_id = $params['widget_id'] ?? 'all';

        $valid = static function ($date) {
            return is_string($date) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) ? $date : '';
        };

        [$from, $to] = $this->resolve_period($params['period'] ?? 'this_week', $valid($params['date_from'] ?? ''), $valid($params['date_to'] ?? ''));

        return [$from, $to, ('all' !== $widget_id && is_numeric($widget_id)) ? (int) $widget_id : null];
    }

    private function resolve_period($period, $date_from = '', $date_to = '')
    {
        $now = current_time('timestamp');

        switch ($period) {
            case 'last_week':
                $dow         = (int) gmdate('N', $now);
                $this_monday = $now - ($dow - 1) * DAY_IN_SECONDS;
                $last_monday = $this_monday - 7 * DAY_IN_SECONDS;
                $from        = gmdate('Y-m-d', $last_monday);
                $to          = gmdate('Y-m-d', $last_monday + 6 * DAY_IN_SECONDS);
                break;
            case 'this_month':
                $from = gmdate('Y-m-01', $now);
                $to   = gmdate('Y-m-t', $now);
                break;
            case 'last_month':
                $first_of_this = gmmktime(0, 0, 0, (int) gmdate('m', $now), 1, (int) gmdate('Y', $now));
                $last_ts       = $first_of_this - DAY_IN_SECONDS;
                $from          = gmdate('Y-m-01', $last_ts);
                $to            = gmdate('Y-m-t', $last_ts);
                break;
            case 'this_year':
                $from = gmdate('Y-01-01', $now);
                $to   = gmdate('Y-12-31', $now);
                break;
            case 'last_year':
                $year = (int) gmdate('Y', $now) - 1;
                $from = "{$year}-01-01";
                $to   = "{$year}-12-31";
                break;
            case 'custom':
                $from = ! empty($date_from) ? sanitize_text_field($date_from) : gmdate('Y-m-d', $now - 6 * DAY_IN_SECONDS);
                $to   = ! empty($date_to)   ? sanitize_text_field($date_to)   : gmdate('Y-m-d', $now);
                break;
            default: // this_week
                $dow  = (int) gmdate('N', $now);
                $from = gmdate('Y-m-d', $now - ($dow - 1) * DAY_IN_SECONDS);
                $to   = gmdate('Y-m-d', $now + (7 - $dow) * DAY_IN_SECONDS);
        }

        return [$from, $to];
    }

    private function build_label_range($from, $to, $group_by)
    {
        $labels = [];
        $start  = strtotime($from);
        $end    = strtotime($to);

        if ($group_by === 'month') {
            while ($start <= $end) {
                $labels[] = gmdate('Y-m', $start);
                $start    = gmmktime(0, 0, 0, (int) gmdate('m', $start) + 1, 1, (int) gmdate('Y', $start));
            }
        } else {
            while ($start <= $end) {
                $labels[] = gmdate('Y-m-d', $start);
                $start   += DAY_IN_SECONDS;
            }
        }

        return $labels;
    }
}
