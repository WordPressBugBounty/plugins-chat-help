<?php

/**
 * Import/Export for the React admin SPA.
 *
 * One place to move a site's ChatHelp data to another site or keep a copy of
 * it: the Global Chat settings, the Custom Chats (the `floating_widget` CPT and
 * its meta), the collected Leads, the WooCommerce settings, and the plugin
 * settings — each on its own, or all of them in one bundle.
 *
 * Everything is exchanged as ONE envelope shape, whatever the file format:
 *
 *   { type, version, exported_at, data: { <scope>: <payload>, … } }
 *
 * JSON stores it as-is; XML mirrors it element-for-element; CSV flattens it to
 * `scope,key,value` rows with non-scalar values JSON-encoded in the cell, which
 * is what lets a spreadsheet round-trip back through the importer unchanged.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Admin/Rest
 */

namespace ThemeAtelier\ChatHelp\Admin\Rest;

use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;

if (! defined('ABSPATH')) {
    die;
}

class ImportExportRest extends AbstractRestController
{
    const POST_TYPE = 'floating_widget';
    const META_KEY  = 'ch_meta';

    /** Export scopes → the option each one carries, where it is just an option. */
    const OPTION_SCOPES = [
        'global'      => 'cwp_option',
        'woocommerce' => 'ch_wooCommerce',
    ];

    /** The plugin-settings scope covers several options at once. */
    const SETTINGS_OPTIONS = ['ch_settings', 'ch_shortcode', 'assign_widget'];

    const SCOPES  = ['all', 'global', 'chats', 'leads', 'woocommerce', 'settings'];
    const FORMATS = ['json', 'csv', 'xml'];

    public function register_routes(): void
    {
        \register_rest_route(self::NS, '/tools/export', [
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [$this, 'export'],
                'permission_callback' => [$this, 'can_manage'],
            ],
        ]);

        \register_rest_route(self::NS, '/tools/import', [
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [$this, 'import'],
                'permission_callback' => [$this, 'can_manage'],
            ],
        ]);
    }

    /**
     * POST /tools/export — { scope, format } → the file's name, type and body.
     *
     * The body comes back as a string rather than a download: the SPA writes it
     * to a Blob, so the export goes through the same authenticated fetch as
     * everything else instead of a second, cookie-only request.
     */
    public function export(WP_REST_Request $request): WP_REST_Response
    {
        $scope  = (string) $request->get_param('scope');
        $format = (string) $request->get_param('format');

        if (! \in_array($scope, self::SCOPES, true)) {
            return new WP_REST_Response(['message' => \__('Unknown export type.', 'chat-help')], 400);
        }
        if (! \in_array($format, self::FORMATS, true)) {
            return new WP_REST_Response(['message' => \__('Unknown file format.', 'chat-help')], 400);
        }

        $data = [];
        foreach ($this->scopes_for($scope) as $one) {
            $data[$one] = $this->collect($one);
        }

        $envelope = [
            'type'        => $scope,
            'version'     => \defined('CHAT_HELP_VERSION') ? CHAT_HELP_VERSION : '',
            'exported_at' => \gmdate('c'),
            'data'        => $data,
        ];

        $slug = 'chat-help-' . $scope . '-' . \gmdate('Y-m-d');

        if ($format === 'csv') {
            return \rest_ensure_response([
                'filename' => $slug . '.csv',
                'mime'     => 'text/csv',
                'content'  => $this->to_csv($envelope),
            ]);
        }

        if ($format === 'xml') {
            return \rest_ensure_response([
                'filename' => $slug . '.xml',
                'mime'     => 'application/xml',
                'content'  => $this->to_xml($envelope),
            ]);
        }

        return \rest_ensure_response([
            'filename' => $slug . '.json',
            'mime'     => 'application/json',
            'content'  => \wp_json_encode($envelope, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
        ]);
    }

    /**
     * POST /tools/import — { content, format } → what was written.
     *
     * The format is what the file is parsed AS; the envelope inside decides
     * what is imported, so a bundle exported as CSV restores the same things
     * the JSON one does.
     */
    public function import(WP_REST_Request $request): WP_REST_Response
    {
        $content = (string) $request->get_param('content');
        $format  = (string) $request->get_param('format');

        if (\trim($content) === '') {
            return new WP_REST_Response(['message' => \__('The file is empty.', 'chat-help')], 400);
        }

        $envelope = $this->parse($content, $format);
        if ($envelope === null) {
            return new WP_REST_Response([
                'message' => \__('This file could not be read as a ChatHelp export.', 'chat-help'),
            ], 400);
        }

        $data = isset($envelope['data']) && \is_array($envelope['data']) ? $envelope['data'] : [];
        if (! $data) {
            return new WP_REST_Response([
                'message' => \__('This export contains nothing to import.', 'chat-help'),
            ], 400);
        }

        $imported = [];
        foreach ($data as $scope => $payload) {
            if (! \in_array($scope, self::SCOPES, true) || $scope === 'all') {
                continue;
            }
            $count = $this->apply($scope, $payload);
            if ($count !== null) {
                $imported[$scope] = $count;
            }
        }

        if (! $imported) {
            return new WP_REST_Response([
                'message' => \__('Nothing in this file matched a known export type.', 'chat-help'),
            ], 400);
        }

        return \rest_ensure_response(['imported' => $imported]);
    }

    /** The scopes one export covers. */
    private function scopes_for(string $scope): array
    {
        return $scope === 'all'
            ? ['global', 'chats', 'leads', 'woocommerce', 'settings']
            : [$scope];
    }

    /** Read one scope's current data. */
    private function collect(string $scope): array
    {
        if (isset(self::OPTION_SCOPES[$scope])) {
            $value = \get_option(self::OPTION_SCOPES[$scope], []);
            return \is_array($value) ? $value : [];
        }

        if ($scope === 'settings') {
            $out = [];
            foreach (self::SETTINGS_OPTIONS as $key) {
                $value = \get_option($key, []);
                $out[$key] = \is_array($value) ? $value : [];
            }
            return $out;
        }

        if ($scope === 'chats') {
            $items = [];
            $posts = \get_posts([
                'post_type'      => self::POST_TYPE,
                'posts_per_page' => -1,
                'post_status'    => ['publish', 'draft', 'pending', 'private'],
                'orderby'        => 'date',
                'order'          => 'DESC',
            ]);
            foreach ($posts as $post) {
                $meta = \get_post_meta($post->ID, self::META_KEY, true);
                $items[] = [
                    'title'  => $post->post_title,
                    'status' => $post->post_status,
                    'meta'   => \is_array($meta) ? $meta : [],
                ];
            }
            return $items;
        }

        if ($scope === 'leads') {
            global $wpdb;
            $table = $wpdb->prefix . 'chat_help_leads';
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared, PluginCheck.Security.DirectDB.UnescapedDBParameter -- The plugin's own leads table; the name is $wpdb->prefix . 'chat_help_leads'.
            $rows = $wpdb->get_results("SELECT field, meta, agent_name, created_at FROM {$table} ORDER BY id ASC", ARRAY_A);
            return \is_array($rows) ? $rows : [];
        }

        return [];
    }

    /**
     * Write one scope back. Returns how many records were written, or null when
     * the payload was not usable.
     */
    private function apply(string $scope, $payload): ?int
    {
        if (isset(self::OPTION_SCOPES[$scope])) {
            if (! \is_array($payload)) {
                return null;
            }
            \update_option(self::OPTION_SCOPES[$scope], $payload);
            return 1;
        }

        if ($scope === 'settings') {
            if (! \is_array($payload)) {
                return null;
            }
            $written = 0;
            foreach (self::SETTINGS_OPTIONS as $key) {
                if (isset($payload[$key]) && \is_array($payload[$key])) {
                    \update_option($key, $payload[$key]);
                    $written++;
                }
            }
            return $written;
        }

        if ($scope === 'chats') {
            if (! \is_array($payload)) {
                return null;
            }
            $statuses = ['publish', 'draft', 'pending', 'private'];
            $written  = 0;
            foreach ($payload as $item) {
                if (! \is_array($item)) {
                    continue;
                }
                $title  = isset($item['title']) ? \sanitize_text_field((string) $item['title']) : '';
                $status = (isset($item['status']) && \in_array($item['status'], $statuses, true))
                    ? $item['status']
                    : 'draft';
                $meta = (isset($item['meta']) && \is_array($item['meta'])) ? $item['meta'] : [];
                if ($title === '' && ! $meta) {
                    continue;
                }
                // Imported chats are new posts, never overwrites: an import is
                // additive so it can never destroy a chat the site already has.
                $new_id = \wp_insert_post([
                    'post_type'   => self::POST_TYPE,
                    'post_title'  => $title !== '' ? $title : \__('Imported Chat', 'chat-help'),
                    'post_status' => $status,
                ]);
                if (\is_wp_error($new_id) || ! $new_id) {
                    continue;
                }
                if ($meta) {
                    \update_post_meta($new_id, self::META_KEY, $meta);
                }
                $written++;
            }
            return $written;
        }

        if ($scope === 'leads') {
            if (! \is_array($payload)) {
                return null;
            }
            global $wpdb;
            $table   = $wpdb->prefix . 'chat_help_leads';
            $written = 0;
            foreach ($payload as $row) {
                if (! \is_array($row)) {
                    continue;
                }
                $field = isset($row['field']) ? $row['field'] : '';
                $meta  = isset($row['meta']) ? $row['meta'] : '';
                // The columns are LONGTEXT holding JSON; a file that carries
                // them already decoded (JSON export, XML) is re-encoded here.
                if (\is_array($field)) {
                    $field = \wp_json_encode($field);
                }
                if (\is_array($meta)) {
                    $meta = \wp_json_encode($meta);
                }
                $data = [
                    'field'      => (string) $field,
                    'meta'       => (string) $meta,
                    'agent_name' => isset($row['agent_name']) ? \sanitize_text_field((string) $row['agent_name']) : '',
                ];
                if (! empty($row['created_at'])) {
                    $data['created_at'] = (string) $row['created_at'];
                }
                // phpcs:ignore WordPress.DB.DirectDatabaseQuery
                if ($wpdb->insert($table, $data)) {
                    $written++;
                }
            }
            return $written;
        }

        return null;
    }

    /** Parse a file body into the envelope, by the format it claims to be. */
    private function parse(string $content, string $format): ?array
    {
        if ($format === 'csv') {
            return $this->from_csv($content);
        }
        if ($format === 'xml') {
            return $this->from_xml($content);
        }

        $decoded = \json_decode($content, true);
        if (! \is_array($decoded)) {
            return null;
        }
        // A file exported by the older per-screen exporters is a bare
        // `{ items: [...] }` list of chats, not an envelope. Accept it.
        if (! isset($decoded['data']) && isset($decoded['items']) && \is_array($decoded['items'])) {
            return ['data' => ['chats' => $decoded['items']]];
        }
        return $decoded;
    }

    /** Envelope → `scope,key,value` rows. Non-scalars are JSON in the cell. */
    private function to_csv(array $envelope): string
    {
        $handle = \fopen('php://temp', 'r+'); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen -- An in-memory php://temp stream for fputcsv() / fgetcsv(); nothing is written to disk.
        \fputcsv($handle, ['scope', 'key', 'value']);

        foreach ($envelope['data'] as $scope => $payload) {
            if (\is_array($payload)) {
                foreach ($payload as $key => $value) {
                    \fputcsv($handle, [
                        $scope,
                        (string) $key,
                        \is_scalar($value) || $value === null
                            ? (string) $value
                            : \wp_json_encode($value),
                    ]);
                }
                continue;
            }
            \fputcsv($handle, [$scope, '', (string) $payload]);
        }

        \rewind($handle);
        $csv = (string) \stream_get_contents($handle);
        \fclose($handle); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose -- An in-memory php://temp stream for fputcsv() / fgetcsv(); nothing is written to disk.

        return $csv;
    }

    /** The same rows back, with JSON cells decoded where they were encoded. */
    private function from_csv(string $content): ?array
    {
        $handle = \fopen('php://temp', 'r+'); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen -- An in-memory php://temp stream for fputcsv() / fgetcsv(); nothing is written to disk.
        \fwrite($handle, $content); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fwrite -- An in-memory php://temp stream for fputcsv() / fgetcsv(); nothing is written to disk.
        \rewind($handle);

        $header = \fgetcsv($handle);
        if (! $header || \count($header) < 3) {
            \fclose($handle); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose -- An in-memory php://temp stream for fputcsv() / fgetcsv(); nothing is written to disk.
            return null;
        }

        $data = [];
        while (($row = \fgetcsv($handle)) !== false) {
            if (\count($row) < 3) {
                continue;
            }
            [$scope, $key, $value] = $row;
            $decoded = \json_decode((string) $value, true);
            $value   = $decoded === null ? $value : $decoded;
            if ($key === '') {
                $data[$scope][] = $value;
                continue;
            }
            // A numeric key is a list index (chats, leads); anything else is an
            // option key. Casting keeps a list a list rather than turning it
            // into a map of "0", "1", …
            $data[$scope][\is_numeric($key) ? (int) $key : $key] = $value;
        }
        \fclose($handle); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose -- An in-memory php://temp stream for fputcsv() / fgetcsv(); nothing is written to disk.

        return $data ? ['data' => $data] : null;
    }

    /** Envelope → XML, one element per scope, values JSON-encoded in leaves. */
    private function to_xml(array $envelope): string
    {
        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<chat_help type="' . \esc_attr((string) $envelope['type']) . '" version="'
            . \esc_attr((string) $envelope['version']) . '" exported_at="'
            . \esc_attr((string) $envelope['exported_at']) . '">' . "\n";

        foreach ($envelope['data'] as $scope => $payload) {
            $xml .= '  <scope name="' . \esc_attr((string) $scope) . '">'
                . '<![CDATA[' . \wp_json_encode($payload) . ']]>'
                . '</scope>' . "\n";
        }

        return $xml . '</chat_help>' . "\n";
    }

    /** XML → envelope. */
    private function from_xml(string $content): ?array
    {
        $previous = \libxml_use_internal_errors(true);
        // LIBXML_NONET: never let a document fetch an external entity.
        $doc = \simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NONET);
        \libxml_clear_errors();
        \libxml_use_internal_errors($previous);

        if ($doc === false) {
            return null;
        }

        $data = [];
        foreach ($doc->scope as $node) {
            $name = (string) $node['name'];
            if ($name === '') {
                continue;
            }
            $decoded = \json_decode((string) $node, true);
            $data[$name] = \is_array($decoded) ? $decoded : [];
        }

        return $data ? ['data' => $data] : null;
    }
}
