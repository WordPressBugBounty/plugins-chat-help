<?php

/**
 * Floating Widget (metabox) REST controller for the React admin SPA.
 *
 * Replaces the Codestar metabox that used to render on the `floating_widget`
 * post edit screen. Serves the `ch_meta` field schema (registered by
 * WidgetOptions via the SchemaRegistry) plus the post's saved values, and
 * persists title/status + the serialized `ch_meta` blob — the exact same meta
 * key the frontend already reads, so existing widgets keep working unchanged.
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

class MetaRest extends AbstractRestController
{
    /** The floating-widget post type. */
    const POST_TYPE = 'floating_widget';

    /** The serialized meta key the frontend reads. */
    const META_KEY = 'ch_meta';

    public function register_routes(): void
    {
        // Collection: list (GET) + create (POST).
        \register_rest_route(self::NS, '/widgets', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [$this, 'list_widgets'],
                'permission_callback' => [$this, 'can_manage'],
            ],
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [$this, 'create_widget'],
                'permission_callback' => [$this, 'can_manage'],
            ],
        ]);

        // Editor schema for a brand-new widget (registered before {id}).
        \register_rest_route(self::NS, '/widgets/schema', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [$this, 'get_widget_schema'],
            'permission_callback' => [$this, 'can_manage'],
        ]);

        // Bulk actions (trash/restore/delete/publish/draft/duplicate).
        \register_rest_route(self::NS, '/widgets/bulk', [
            'methods'             => WP_REST_Server::CREATABLE,
            'callback'            => [$this, 'bulk_widgets'],
            'permission_callback' => [$this, 'can_manage'],
        ]);

        // Export selected/all widgets (title + status + ch_meta) as JSON.
        \register_rest_route(self::NS, '/widgets/export', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [$this, 'export_widgets'],
            'permission_callback' => [$this, 'can_manage'],
        ]);

        // Import widgets from an exported JSON payload.
        \register_rest_route(self::NS, '/widgets/import', [
            'methods'             => WP_REST_Server::CREATABLE,
            'callback'            => [$this, 'import_widgets'],
            'permission_callback' => [$this, 'can_manage'],
        ]);

        // Duplicate (registered before {id} so "duplicate" isn't matched as an id).
        \register_rest_route(self::NS, '/widgets/(?P<id>\d+)/duplicate', [
            'methods'             => WP_REST_Server::CREATABLE,
            'callback'            => [$this, 'duplicate_widget'],
            'permission_callback' => [$this, 'can_manage'],
        ]);

        // Restore a trashed widget.
        \register_rest_route(self::NS, '/widgets/(?P<id>\d+)/restore', [
            'methods'             => WP_REST_Server::CREATABLE,
            'callback'            => [$this, 'restore_widget'],
            'permission_callback' => [$this, 'can_manage'],
        ]);

        // Single widget: read / update / delete.
        \register_rest_route(self::NS, '/widgets/(?P<id>\d+)', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [$this, 'get_widget'],
                'permission_callback' => [$this, 'can_manage'],
            ],
            [
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => [$this, 'update_widget'],
                'permission_callback' => [$this, 'can_manage'],
            ],
            [
                'methods'             => WP_REST_Server::DELETABLE,
                'callback'            => [$this, 'delete_widget'],
                'permission_callback' => [$this, 'can_manage'],
            ],
        ]);
    }

    /**
     * Human-readable label for a `chat_layout` key, matching the "Choose Your
     * Chat Experience" options in FloatingChatFields. Unknown/empty falls back to
     * the field default (form).
     *
     * @param string $key The stored chat_layout value.
     * @return string
     */
    private function layout_label(string $key): string
    {
        $map = [
            'off'              => \__('Disable Chat', 'chat-help'),
            'form'             => \__('Form Chat', 'chat-help'),
            'agent'            => \__('Single Agent', 'chat-help'),
            'agent_input'      => \__('Pre-Chat Message', 'chat-help'),
            'button'           => \__('Chat Button', 'chat-help'),
            'multi'            => \__('Multi-Agent', 'chat-help'),
            'multi_agent_form' => \__('Multi-Agent Form', 'chat-help'),
        ];
        return $map[$key] ?? $map['form'];
    }

    /** Normalized schema tree + flat defaults for the ch_meta sections. */
    private function widget_schema(): array
    {
        $sections = $this->get_registered_sections(self::META_KEY);
        $defaults = $this->collect_defaults($sections);

        // New layouts start with the Global Chat WhatsApp number/group so users
        // don't retype them per widget. The schema declares no default for these
        // ids, so this only fills what would otherwise be empty; a widget's own
        // saved values still win via merge_defaults on read.
        $global = \ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers::global_whatsapp_defaults();
        if ('' !== $global['number']) {
            $defaults['opt-number'] = $global['number'];
        }
        if ('' !== $global['group']) {
            $defaults['opt-group'] = $global['group'];
        }

        return [
            // Chat Layouts shares Global Chat's field/option Pro boundary
            // (ProFeatures::SHARES): the free layout fields are editable, and the
            // Pro-only fields/options are stamped `pro` so the React editor renders
            // just those read-only with a badge — exactly like Global Chat.
            'schema'   => $this->apply_pro_flags($this->normalize_sections($sections), self::META_KEY),
            'defaults' => $defaults,
        ];
    }

    /** GET /widgets — list all floating widgets for the React table. */
    public function list_widgets(WP_REST_Request $request): WP_REST_Response
    {
        $status = \sanitize_key((string) $request->get_param('status'));
        $query_status = ($status && $status !== 'all')
            ? $status
            : ['publish', 'draft', 'pending', 'private'];

        $posts = \get_posts([
            'post_type'      => self::POST_TYPE,
            'post_status'    => $query_status,
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);

        $items = [];
        foreach ($posts as $post) {
            $meta   = \get_post_meta($post->ID, self::META_KEY, true);
            $layout = (\is_array($meta) && ! empty($meta['chat_layout'])) ? (string) $meta['chat_layout'] : 'form';
            $items[] = [
                'id'           => $post->ID,
                'title'        => $post->post_title !== '' ? $post->post_title : \__('(no title)', 'chat-help'),
                'status'       => $post->post_status,
                'layout'       => $layout,
                'layout_label' => $this->layout_label($layout),
                'date'         => \get_the_date('M j, Y', $post),
                'date_raw'     => \get_the_date('Y-m-d', $post),
            ];
        }

        $counts = \wp_count_posts(self::POST_TYPE);
        return \rest_ensure_response([
            'items'  => $items,
            'total'  => \count($items),
            'counts' => [
                'all'     => (int) ($counts->publish ?? 0) + (int) ($counts->draft ?? 0) + (int) ($counts->pending ?? 0) + (int) ($counts->private ?? 0),
                'publish' => (int) ($counts->publish ?? 0),
                'draft'   => (int) ($counts->draft ?? 0),
                'trash'   => (int) ($counts->trash ?? 0),
            ],
        ]);
    }

    /** GET /widgets/schema — schema + defaults for a fresh widget. */
    public function get_widget_schema(WP_REST_Request $request): WP_REST_Response
    {
        return \rest_ensure_response($this->widget_schema());
    }

    /** GET /widgets/{id} — post fields + ch_meta values (merged with defaults) + schema. */
    public function get_widget(WP_REST_Request $request): WP_REST_Response
    {
        $id   = (int) $request['id'];
        $post = \get_post($id);
        if (! $post || $post->post_type !== self::POST_TYPE) {
            return new WP_REST_Response(['message' => 'Not found.'], 404);
        }

        $schema = $this->widget_schema();
        $meta   = \get_post_meta($id, self::META_KEY, true);
        $meta   = \is_array($meta) ? $meta : [];

        return \rest_ensure_response([
            'post'   => [
                'id'     => $post->ID,
                'title'  => $post->post_title,
                'status' => $post->post_status,
            ],
            'schema' => $schema['schema'],
            // Fill inheriting fields (empty or saved as '') with the current
            // Global Chat values for display; persist_meta strips them back out.
            'values' => $this->fill_global_fallback_values(
                \array_merge($schema['defaults'], $meta),
                self::META_KEY
            ),
        ]);
    }

    /** POST /widgets — create a new widget (returns the new id). */
    public function create_widget(WP_REST_Request $request): WP_REST_Response
    {
        $title  = \sanitize_text_field((string) $request->get_param('title'));
        $status = $this->valid_status((string) $request->get_param('status'));

        $id = \wp_insert_post([
            'post_type'   => self::POST_TYPE,
            'post_title'  => $title !== '' ? $title : \__('Untitled Widget', 'chat-help'),
            'post_status' => $status,
        ], true);

        if (\is_wp_error($id)) {
            return new WP_REST_Response(['message' => $id->get_error_message()], 500);
        }

        $this->persist_meta($id, $request);

        return \rest_ensure_response(['id' => $id]);
    }

    /** PUT /widgets/{id} — update title/status + ch_meta. */
    public function update_widget(WP_REST_Request $request): WP_REST_Response
    {
        $id   = (int) $request['id'];
        $post = \get_post($id);
        if (! $post || $post->post_type !== self::POST_TYPE) {
            return new WP_REST_Response(['message' => 'Not found.'], 404);
        }

        $update = ['ID' => $id];
        if ($request->get_param('title') !== null) {
            $update['post_title'] = \sanitize_text_field((string) $request->get_param('title'));
        }
        if ($request->get_param('status') !== null) {
            $update['post_status'] = $this->valid_status((string) $request->get_param('status'));
        }
        if (\count($update) > 1) {
            \wp_update_post($update);
        }

        $this->persist_meta($id, $request);

        return \rest_ensure_response(['saved' => true, 'id' => $id]);
    }

    /** Sanitize + persist the ch_meta blob (type-aware, using the schema). */
    private function persist_meta(int $id, WP_REST_Request $request): void
    {
        $values = $request->get_param('values');
        if (! \is_array($values)) {
            return;
        }
        $sections  = $this->get_registered_sections(self::META_KEY);
        $types     = $this->collect_field_types($sections);
        $sanitized = $this->sanitize_values($values, $types);
        // Chat Layouts shares Global Chat's field/option Pro boundary (see
        // ProFeatures::SHARES). Free users build free layouts here; Pro-only
        // fields/options are stripped so they can never be saved, even via a
        // crafted request — the React editor already renders them read-only.
        $sanitized = $this->strip_pro_keys($sanitized, self::META_KEY, $sections);
        // A number/group equal to the current global is the editor's display
        // fill coming back, not a user override — store '' so the widget keeps
        // inheriting the Global Chat values.
        $sanitized = $this->strip_global_fallback_values($sanitized, self::META_KEY);
        \update_post_meta($id, self::META_KEY, $sanitized);
    }

    /** DELETE /widgets/{id} — trash, or force-delete when already trashed / ?force=1. */
    public function delete_widget(WP_REST_Request $request): WP_REST_Response
    {
        $id = (int) $request['id'];
        if (\get_post_type($id) !== self::POST_TYPE) {
            return new WP_REST_Response(['message' => 'Not found.'], 404);
        }

        $force = (bool) $request->get_param('force');
        if ($force || \get_post_status($id) === 'trash') {
            \wp_delete_post($id, true);
            return \rest_ensure_response(['deleted' => true, 'id' => $id]);
        }

        \wp_trash_post($id);
        return \rest_ensure_response(['trashed' => true, 'id' => $id]);
    }

    /** POST /widgets/{id}/duplicate — clone a widget (title + ch_meta) as a draft. */
    public function duplicate_widget(WP_REST_Request $request): WP_REST_Response
    {
        $id   = (int) $request['id'];
        $post = \get_post($id);
        if (! $post || $post->post_type !== self::POST_TYPE) {
            return new WP_REST_Response(['message' => 'Not found.'], 404);
        }

        $new_id = $this->duplicate_one($post);
        if (\is_wp_error($new_id)) {
            return new WP_REST_Response(['message' => $new_id->get_error_message()], 500);
        }

        return \rest_ensure_response(['duplicated' => true, 'id' => $new_id]);
    }

    /** Clone a widget (title + ch_meta) as a draft. Returns new id or WP_Error. */
    private function duplicate_one(\WP_Post $post)
    {
        $new_id = \wp_insert_post([
            'post_type'   => self::POST_TYPE,
            /* translators: %s: original widget title. */
            'post_title'  => \sprintf(\__('%s (Copy)', 'chat-help'), $post->post_title),
            'post_status' => 'draft',
        ], true);

        if (\is_wp_error($new_id)) {
            return $new_id;
        }

        $meta = \get_post_meta($post->ID, self::META_KEY, true);
        if (\is_array($meta)) {
            \update_post_meta($new_id, self::META_KEY, $meta);
        }

        return $new_id;
    }

    /** POST /widgets/{id}/restore — restore a trashed widget to its prior status. */
    public function restore_widget(WP_REST_Request $request): WP_REST_Response
    {
        $id = (int) $request['id'];
        if (\get_post_type($id) !== self::POST_TYPE) {
            return new WP_REST_Response(['message' => 'Not found.'], 404);
        }
        \wp_untrash_post($id);
        return \rest_ensure_response(['restored' => true, 'id' => $id]);
    }

    /** POST /widgets/bulk — apply an action to many widgets at once. */
    public function bulk_widgets(WP_REST_Request $request): WP_REST_Response
    {
        $action = \sanitize_key((string) $request->get_param('action'));
        $ids    = (array) $request->get_param('ids');
        $ids    = \array_values(\array_filter(
            \array_map('intval', $ids),
            fn ($id) => \get_post_type($id) === self::POST_TYPE
        ));

        if (! $ids) {
            return new WP_REST_Response(['message' => 'No valid items.'], 400);
        }

        $allowed = ['trash', 'restore', 'delete', 'publish', 'draft', 'duplicate'];
        if (! \in_array($action, $allowed, true)) {
            return new WP_REST_Response(['message' => 'Invalid action.'], 400);
        }

        $count = 0;
        foreach ($ids as $id) {
            switch ($action) {
                case 'trash':
                    \wp_trash_post($id);
                    break;
                case 'restore':
                    \wp_untrash_post($id);
                    break;
                case 'delete':
                    \wp_delete_post($id, true);
                    break;
                case 'publish':
                case 'draft':
                    \wp_update_post(['ID' => $id, 'post_status' => $action]);
                    break;
                case 'duplicate':
                    $post = \get_post($id);
                    if ($post) {
                        $this->duplicate_one($post);
                    }
                    break;
            }
            $count++;
        }

        return \rest_ensure_response(['success' => true, 'count' => $count]);
    }

    /** GET /widgets/export — export all (or ?ids=1,2,3) widgets as JSON. */
    public function export_widgets(WP_REST_Request $request): WP_REST_Response
    {
        $args = [
            'post_type'      => self::POST_TYPE,
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post_status'    => ['publish', 'draft', 'pending', 'private'],
        ];
        $ids_param = (string) $request->get_param('ids');
        if ($ids_param !== '') {
            $args['post__in'] = \array_map('intval', \explode(',', $ids_param));
        }

        $items = [];
        foreach (\get_posts($args) as $post) {
            $meta = \get_post_meta($post->ID, self::META_KEY, true);
            $items[] = [
                'title'  => $post->post_title,
                'status' => $post->post_status,
                'meta'   => \is_array($meta) ? $meta : [],
            ];
        }

        return \rest_ensure_response([
            'version' => \defined('CHAT_HELP_VERSION') ? CHAT_HELP_VERSION : '',
            'items'   => $items,
        ]);
    }

    /** POST /widgets/import — create widgets from an exported JSON payload. */
    public function import_widgets(WP_REST_Request $request): WP_REST_Response
    {
        $items = $request->get_param('items');
        if (! \is_array($items)) {
            return new WP_REST_Response(['message' => 'Invalid payload.'], 400);
        }

        $statuses = ['publish', 'draft', 'pending', 'private'];
        $imported = 0;
        foreach ($items as $item) {
            if (! \is_array($item)) {
                continue;
            }
            $title  = isset($item['title']) ? \sanitize_text_field($item['title']) : '';
            $status = (isset($item['status']) && \in_array($item['status'], $statuses, true))
                ? $item['status']
                : 'draft';
            $meta   = (isset($item['meta']) && \is_array($item['meta'])) ? $item['meta'] : [];

            if ($title === '' && ! $meta) {
                continue;
            }

            $new_id = \wp_insert_post([
                'post_type'   => self::POST_TYPE,
                'post_title'  => $title !== '' ? $title : \__('Imported Layout', 'chat-help'),
                'post_status' => $status,
            ], true);
            if (\is_wp_error($new_id)) {
                continue;
            }
            if ($meta) {
                \update_post_meta($new_id, self::META_KEY, $meta);
            }
            $imported++;
        }

        return \rest_ensure_response(['imported' => $imported]);
    }

    /** Whitelist post statuses the editor may set. */
    private function valid_status(string $status): string
    {
        $allowed = ['publish', 'draft', 'pending', 'private'];
        return \in_array($status, $allowed, true) ? $status : 'draft';
    }
}
