<?php

/**
 * Analytics ingest: the POST /chat-help/v1/analytics/track request path.
 *
 * Keep this file identical in ChatHelp and ChatHelp Pro, apart from the
 * namespace. Only one of them runs at a time and both write to the same table.
 *
 * maybe_handle_early() runs while the plugin file is being included, so this
 * class can only use what WordPress has loaded by then: no pluggable functions
 * (wp_salt(), wp_get_current_user()), no user, no later plugins, no theme.
 *
 * @package chat-help
 */

namespace ThemeAtelier\ChatHelp\Admin;

if (! defined('ABSPATH')) {
    die;
}

class AnalyticsTracker
{
    const ROUTE = 'chat-help/v1/analytics/track';

    /** Largest accepted request body, in bytes. */
    const MAX_BODY = 16384;

    /** Most events accepted in one request. The client sends one request per page view. */
    const MAX_EVENTS = 20;

    /** Requests allowed per minute. */
    const LIMIT_IP      = 60;
    const LIMIT_SESSION = 30;

    /**
     * Minimum token lifetime, in days. Tokens sit in page HTML, so this must
     * outlast the page cache. WordPress nonces last at most 24 hours, which is
     * why they are not used here.
     */
    const TOKEN_DAYS = 7;

    const EVENT_TYPES = ['visitor', 'view', 'conversion'];
    const DEVICES     = ['desktop', 'mobile', 'other'];

    /**
     * Shared by the client and server checks, so it must be valid in both PCRE
     * and JavaScript. The lookbehind spares the CUBOT phone brand.
     */
    const BOT_PATTERN = '(?<!cu)bot(?:\b|_)|crawl|spider|slurp|mediapartners|adsbot|bingpreview|facebookexternalhit|embedly|lighthouse|pagespeed|gtmetrix|pingdom|uptime|headless|phantomjs|puppeteer|playwright|semrush|ahrefs|mj12|dotbot|petalbot|bytespider|gptbot|claudebot|ccbot|perplexity|curl\/|wget\/|python-|go-http|java\/|okhttp|axios\/|node-fetch|libwww';

    /**
     * Answers a track request before the rest of WordPress loads, then exits.
     *
     * This is what makes the call cheap on a real site. A REST request boots
     * every plugin, the theme and `init`, which is where nearly all of the time
     * goes on a busy host. The registered REST route stays as a fallback for
     * URLs this check does not recognise, such as a rest_url_prefix filter
     * added by a plugin that has not loaded yet.
     */
    public static function maybe_handle_early(): void
    {
        if (! self::is_track_request()) {
            return;
        }

        $status = self::handle((string) file_get_contents('php://input', false, null, 0, self::MAX_BODY + 1));

        if (! headers_sent()) {
            http_response_code($status);
            header('Cache-Control: no-store');
        }
        exit;
    }

    private static function is_track_request(): bool
    {
        if ('POST' !== ($_SERVER['REQUEST_METHOD'] ?? '') || wp_installing()) {
            return false;
        }

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Only compared to a fixed route; the request is authorized in handle().
        if (isset($_GET['rest_route']) && '/' . self::ROUTE === untrailingslashit(sanitize_text_field(wp_unslash($_GET['rest_route'])))) {
            return true;
        }

        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Only compared to a fixed route.
        $path = (string) wp_parse_url(wp_unslash($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
        $tail = '/' . rest_get_url_prefix() . '/' . self::ROUTE;

        return substr(untrailingslashit($path), -strlen($tail)) === $tail;
    }

    /**
     * Validates a request and stores its events.
     *
     * Every rejection happens before the database is touched, and a stored
     * request runs exactly one INSERT.
     *
     * @param string $body Raw request body.
     * @return int HTTP status for the response.
     */
    public static function handle(string $body): int
    {
        if (strlen($body) > self::MAX_BODY) {
            return 413;
        }

        // A success, so crawlers have no reason to retry.
        if (self::is_bot()) {
            return 204;
        }

        $data = json_decode($body, true);
        if (! is_array($data)) {
            return 400;
        }

        if (! self::is_same_site()) {
            return 403;
        }

        $legacy = ! isset($data['events']);
        if (! self::is_authorized($data, $legacy)) {
            return 403;
        }

        $session = $legacy ? ($data['session_id'] ?? '') : ($data['sid'] ?? '');
        $session = is_string($session) ? substr((string) preg_replace('/[^A-Za-z0-9_-]/', '', $session), 0, 64) : '';

        if (! self::within_rate_limit($session)) {
            return 429;
        }

        $events = self::normalize_events($data, $legacy);
        if (! $events) {
            return 400;
        }

        $device = $legacy ? ($data['device_type'] ?? '') : ($data['device'] ?? '');
        $device = in_array($device, self::DEVICES, true) ? $device : 'desktop';

        return self::insert($events, $session, $device) ? 204 : 503;
    }

    /**
     * Builds the event list from a batch, or from a single-event request sent by
     * a tracker cached before this version.
     *
     * @return array<int,array{0:string,1:int,2:string}> Type, widget id, page.
     */
    private static function normalize_events(array $data, bool $legacy): array
    {
        $raw = $legacy
            ? [['type' => $data['event_type'] ?? '', 'widget' => $data['widget_id'] ?? 0, 'page' => $data['page_url'] ?? '']]
            : $data['events'];

        if (! is_array($raw)) {
            return [];
        }

        $events = [];
        foreach (array_slice($raw, 0, self::MAX_EVENTS) as $event) {
            if (! is_array($event) || ! in_array($event['type'] ?? '', self::EVENT_TYPES, true)) {
                continue;
            }
            $widget   = $event['widget'] ?? 0;
            $events[] = [
                $event['type'],
                is_scalar($widget) ? absint($widget) : 0,
                self::clean_page($event['page'] ?? ''),
            ];
        }

        return $events;
    }

    /**
     * Reduces a page value to its path. Query strings would create an unbounded
     * number of "pages" in the summary tables.
     *
     * @param mixed $page Client-supplied page.
     */
    private static function clean_page($page): string
    {
        if (! is_string($page) || '' === $page) {
            return '';
        }
        $path = wp_parse_url($page, PHP_URL_PATH);
        if (! is_string($path) || '/' !== substr($path, 0, 1)) {
            return '';
        }
        return substr(esc_url_raw($path), 0, 500);
    }

    /**
     * Writes all events with one multi-row INSERT.
     *
     * Uses $wpdb->query() rather than $wpdb->insert(), which runs SHOW FULL
     * COLUMNS first to check charsets. Values are already reduced to safe text.
     */
    private static function insert(array $events, string $session, string $device): bool
    {
        global $wpdb;

        $country = self::detect_country();
        $browser = self::detect_browser();
        $rows    = [];
        foreach ($events as $event) {
            $rows[] = $wpdb->prepare(
                '(%d,%s,%s,%s,%s,%s,%s)',
                $event[1],
                $event[0],
                $device,
                $country,
                $browser,
                $event[2],
                $session
            );
        }

        $table      = $wpdb->prefix . 'chat_help_analytics';
        $suppressed = $wpdb->suppress_errors(true);
        // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter -- Plugin's own table; every row comes from $wpdb->prepare() above.
        $result = $wpdb->query("INSERT INTO `$table` (widget_id,event_type,device_type,country,browser,page_url,session_id) VALUES " . implode(',', $rows));
        $wpdb->suppress_errors($suppressed);

        return false !== $result;
    }

    /**
     * A browser cannot forge Origin or Referer, so a value naming another site
     * means another site's page is calling us. Absent headers are allowed: the
     * token still applies. Matching the request's own host keeps multi-domain
     * setups working, where a page and its REST URL share a host other than home.
     */
    private static function is_same_site(): bool
    {
        $source = $_SERVER['HTTP_ORIGIN'] ?? ($_SERVER['HTTP_REFERER'] ?? ''); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Only its host is compared.
        if ('' === $source || 'null' === $source) {
            return true;
        }

        $host = wp_parse_url((string) $source, PHP_URL_HOST);
        if (! $host) {
            return false;
        }

        $allowed = [
            wp_parse_url((string) get_option('home'), PHP_URL_HOST),
            wp_parse_url('//' . ($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST), // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Only compared.
        ];
        $strip   = static function ($name) {
            // example.com and www.example.com are the same site.
            return preg_replace('/^www\./', '', strtolower((string) $name));
        };

        return in_array($strip($host), array_map($strip, $allowed), true);
    }

    private static function is_authorized(array $data, bool $legacy): bool
    {
        if ($legacy) {
            // Pages cached before this version post single events with no token.
            return (int) get_option(AnalyticsStore::OPTION_LEGACY_UNTIL, 0) > time();
        }
        return is_string($data['token'] ?? null) && self::verify_token($data['token']);
    }

    /**
     * A signed expiry. The value changes once a day, so it does not defeat page
     * caching.
     */
    public static function create_token(): string
    {
        $expires = (int) (floor(time() / DAY_IN_SECONDS) + self::TOKEN_DAYS + 1) * DAY_IN_SECONDS;
        return $expires . '.' . self::sign((string) $expires);
    }

    private static function verify_token(string $token): bool
    {
        $parts = explode('.', $token, 2);
        return 2 === count($parts)
            && ctype_digit($parts[0])
            && (int) $parts[0] > time()
            && hash_equals(self::sign($parts[0]), $parts[1]);
    }

    private static function sign(string $value): string
    {
        return hash_hmac('sha256', 'chat-help-track|' . $value, self::secret());
    }

    /**
     * wp_salt() is not available this early, so this reads the wp-config.php
     * constants it would use.
     */
    private static function secret(): string
    {
        return (defined('AUTH_KEY') ? AUTH_KEY : '') . (defined('NONCE_SALT') ? NONCE_SALT : '') . ABSPATH;
    }

    /**
     * Per-minute limits, counted in the temp directory so that no request does
     * extra database work. Fails open: losing the limiter must not lose data.
     */
    private static function within_rate_limit(string $session): bool
    {
        $ok = self::hit('ip' . self::client_ip(), (int) apply_filters('chat_help_analytics_limit_ip', self::LIMIT_IP));
        if ($ok && '' !== $session) {
            $ok = self::hit('s' . $session, (int) apply_filters('chat_help_analytics_limit_session', self::LIMIT_SESSION));
        }
        return $ok;
    }

    private static function hit(string $key, int $limit): bool
    {
        $dir = self::rate_limit_dir();
        // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged, WordPress.WP.AlternativeFunctions.file_system_operations_mkdir -- WP_Filesystem cannot be loaded this early; failure is handled.
        if (! is_dir($dir) && ! @mkdir($dir, 0700, true) && ! is_dir($dir)) {
            return true;
        }

        // Cleaned from this path, not cron: cron can run under the CLI, whose temp
        // directory may differ from the web server's.
        if (1 === random_int(1, 100)) {
            self::clean_rate_limit_files();
        }

        $file = $dir . gmdate('YmdHi') . '-' . hash_hmac('md5', $key, self::secret());
        // Appending one byte under a lock makes the file size an atomic counter.
        // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged, WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents -- As above.
        if (false === @file_put_contents($file, '.', FILE_APPEND | LOCK_EX)) {
            return true;
        }
        clearstatcache(true, $file);

        return filesize($file) <= $limit;
    }

    private static function rate_limit_dir(): string
    {
        return get_temp_dir() . 'chat-help-rl-' . md5(ABSPATH) . '/';
    }

    /**
     * Removes counters from earlier minutes.
     */
    private static function clean_rate_limit_files(): void
    {
        $current = gmdate('YmdHi');
        foreach ((array) glob(self::rate_limit_dir() . '*') as $file) {
            if (is_string($file) && 0 !== strpos(basename($file), $current)) {
                @unlink($file); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged, WordPress.WP.AlternativeFunctions.unlink_unlink -- Another request may have removed it first.
            }
        }
    }

    /**
     * REMOTE_ADDR only: forwarding headers are client-controlled. Sites behind a
     * proxy can supply the real address through the filter. IPv6 is grouped by
     * /64 because one visitor usually holds the whole block.
     */
    private static function client_ip(): string
    {
        $ip = (string) apply_filters('chat_help_analytics_client_ip', $_SERVER['REMOTE_ADDR'] ?? ''); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Only hashed, never stored.
        if (false !== strpos($ip, ':')) {
            $packed = @inet_pton($ip); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged -- Invalid input falls back to the raw value.
            if (false !== $packed) {
                return bin2hex(substr($packed, 0, 8));
            }
        }
        return $ip;
    }

    public static function is_bot(): bool
    {
        $agent = (string) ($_SERVER['HTTP_USER_AGENT'] ?? ''); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Only matched against a pattern.
        return '' === $agent || 1 === preg_match('/' . self::BOT_PATTERN . '/i', $agent);
    }

    private static function detect_country(): string
    {
        foreach (['HTTP_CF_IPCOUNTRY', 'HTTP_X_COUNTRY_CODE', 'HTTP_GEOIP_COUNTRY_CODE'] as $header) {
            $value = (string) ($_SERVER[$header] ?? ''); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Must be exactly two letters to be used.
            if (2 === strlen($value) && ctype_alpha($value)) {
                return strtoupper($value);
            }
        }
        return '';
    }

    private static function detect_browser(): string
    {
        $agent = (string) ($_SERVER['HTTP_USER_AGENT'] ?? ''); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Only matched against patterns.
        $map   = [
            'Edge'    => '/Edg\//i',
            'Opera'   => '/OPR\/|Opera\//i',
            'Yandex'  => '/YaBrowser\//i',
            'Samsung' => '/SamsungBrowser\//i',
            'Chrome'  => '/Chrome\/[0-9]/i',
            'Firefox' => '/Firefox\/[0-9]/i',
            'Safari'  => '/Safari\/[0-9]/i',
            'IE'      => '/MSIE |Trident\//i',
        ];
        foreach ($map as $name => $pattern) {
            if (preg_match($pattern, $agent)) {
                return $name;
            }
        }
        return 'Other';
    }

    /**
     * Whether the current visitor should be tracked at all.
     *
     * Bots are deliberately not filtered here. A crawler can be the request
     * that fills a page cache, and every real visitor would then get a page with
     * no tracker. The script and the endpoint filter them instead.
     */
    private static function should_render(): bool
    {
        if (! is_user_logged_in() || ! current_user_can('edit_posts')) {
            return true;
        }
        $settings = get_option('ch_settings');
        return ! empty($settings['analytics_track_editors']);
    }

    /**
     * Prints the tracker. Hooked to wp_footer.
     */
    public static function render_script(): void
    {
        if (! self::should_render()) {
            return;
        }

        $config = [
            'url'       => esc_url_raw(rest_url(self::ROUTE)),
            'token'     => self::create_token(),
            'bots'      => self::BOT_PATTERN,
            'maxEvents' => self::MAX_EVENTS,
        ];

        wp_print_inline_script_tag('(' . self::script() . ')(' . wp_json_encode($config) . ');');
    }

    /**
     * Sends at most one request per page view.
     *
     * Events queue until the page is hidden or unloaded. Anything that happens
     * after that one request has gone is kept in sessionStorage and sent with the
     * next page view in the session. A conversion in that position is lost only
     * if the visitor never loads another page in the tab.
     */
    private static function script(): string
    {
        return <<<'JS'
function(cfg){
var ua=navigator.userAgent||"",bots;
try{bots=new RegExp(cfg.bots,"i");}catch(e){bots=/bot|crawl|spider/i;}
if(navigator.webdriver||!ua||bots.test(ua))return;
var store=null;try{store=window.sessionStorage;store.setItem("ch_t","1");store.removeItem("ch_t");}catch(e){store=null;}
function read(k){try{return store?store.getItem(k):null;}catch(e){return null;}}
function write(k,v){try{if(store)store.setItem(k,v);}catch(e){}}
function device(){if(/tablet|ipad|playbook|silk/i.test(ua))return"other";if(/mobile|android|iphone|ipod|blackberry|iemobile|opera mini/i.test(ua))return"mobile";return"desktop";}
var sid=read("ch_sid");if(!sid){sid=Math.random().toString(36).slice(2)+Date.now().toString(36);write("ch_sid",sid);}
var dev=device(),queue=[],sent=false,PENDING="ch_pending";
function takePending(){var raw=read(PENDING);if(!raw)return;write(PENDING,"");try{var list=JSON.parse(raw);if(list&&list.length)queue=list.concat(queue);}catch(e){}}
function keep(list){var cur=[];try{cur=JSON.parse(read(PENDING)||"[]")||[];}catch(e){}write(PENDING,JSON.stringify(cur.concat(list).slice(-cfg.maxEvents)));}
function track(type,widget){var ev={type:type,widget:Number(widget)||0,page:location.pathname};if(sent){keep([ev]);}else{queue.push(ev);}}
function flush(){
if(sent||!queue.length)return;
sent=true;
var batch=queue.slice(0,cfg.maxEvents),rest=queue.slice(cfg.maxEvents);queue=[];
if(rest.length)keep(rest);
var body=JSON.stringify({token:cfg.token,sid:sid,device:dev,events:batch});
var ok=false;
try{if(navigator.sendBeacon)ok=navigator.sendBeacon(cfg.url,new Blob([body],{type:"text/plain;charset=UTF-8"}));}catch(e){}
if(!ok&&window.fetch){try{fetch(cfg.url,{method:"POST",body:body,keepalive:true,credentials:"omit",headers:{"Content-Type":"text/plain;charset=UTF-8"}}).catch(function(){});}catch(e){}}
}
document.addEventListener("visibilitychange",function(){if(document.visibilityState==="hidden")flush();});
window.addEventListener("pagehide",flush);
window.addEventListener("pageshow",function(e){if(e.persisted){sent=false;takePending();}});
takePending();
if(store&&!read("ch_visited")){write("ch_visited","1");track("visitor",0);}
function setup(){
var bubbles=document.querySelectorAll(".wHelp_bubble");
if(!bubbles.length)return;
if("IntersectionObserver"in window){var observer=new IntersectionObserver(function(entries){entries.forEach(function(entry){if(entry.isIntersecting){track("view",entry.target.getAttribute("data-widget-id")||0);observer.unobserve(entry.target);}});},{threshold:0.5});bubbles.forEach(function(el){observer.observe(el);});}
document.addEventListener("click",function(e){
if(e.target.closest(".layout_button")){track("conversion",0);return;}
var link=e.target.closest(".wHelp_woo_btn,.chat_help_analytics");if(link&&!link.hasAttribute("data-tab")){track("conversion",0);return;}
if(e.target.closest(".wHelp__send-message.chat_help_link:not(.agent_input)")){track("conversion",0);return;}
var agent=e.target.closest(".chat_help_multi_user:not(.avatar-inactive)");if(agent&&!agent.hasAttribute("data-tab")){track("conversion",0);}
},{passive:true});
document.addEventListener("submit",function(e){var id=e.target.id;if(id==="wHelp_form"||id==="agent_input")track("conversion",0);});
}
if(document.readyState==="loading"){document.addEventListener("DOMContentLoaded",setup);}else{setup();}
}
JS;
    }
}
