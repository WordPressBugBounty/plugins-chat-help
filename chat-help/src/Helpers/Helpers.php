<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Helpers
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Helpers;

/**
 * The Helpers class to manage all public facing stuffs.
 *
 * @since 1.0.0
 */
class Helpers
{

	/**
	 * The min of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $min   The slug of this plugin.
	 */
	private $min;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct()
	{
		$this->min = defined('WP_DEBUG') && WP_DEBUG ? '' : '.min';
		add_filter('kses_allowed_protocols', [$this, 'allow_whatsapp_protocol']);
	}

	public function allow_whatsapp_protocol($protocols)
	{
		$protocols[] = 'whatsapp';
		return $protocols;
	}

	/**
	 * Register the All scripts for the public-facing side of the site.
	 *
	 * @since    2.0
	 */
	public function register_all_scripts()
	{
		wp_register_style('ico-font', CHAT_HELP_ASSETS . 'css/icofont' . $this->min . '.css', array(), '1.0.0', 'all');
		wp_register_style('chat-help-style', CHAT_HELP_ASSETS . 'css/chat-help-style' . $this->min . '.css', array(), CHAT_HELP_VERSION, 'all');
		wp_register_style('chat-help-help', CHAT_HELP_ASSETS . 'css/help' . $this->min . '.css', array(), CHAT_HELP_VERSION, 'all');

		wp_register_script('moment-timezone-with-data', CHAT_HELP_ASSETS . 'js/moment-timezone-with-data' . $this->min . '.js', array('jquery'), CHAT_HELP_VERSION, true);
		wp_register_script('jquery_validate', CHAT_HELP_ASSETS . 'js/jquery.validate' . $this->min . '.js', array('jquery'), CHAT_HELP_VERSION, true);
		wp_register_script('chat-help-script', CHAT_HELP_ASSETS . 'js/chat-help-script' . $this->min . '.js', array('jquery'), CHAT_HELP_VERSION, true);
	}

	public static function user_availability($optAvailablity)
	{
		$days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

		$availability = [];
		foreach ($days as $day) {
			$from = !empty($optAvailablity["availablity-$day"]['from']) ? $optAvailablity["availablity-$day"]['from'] : '00:00';
			$to = !empty($optAvailablity["availablity-$day"]['to']) ? $optAvailablity["availablity-$day"]['to'] : '23:59';

			$availability[$day] = "$from-$to";
		}

		return wp_json_encode($availability);
	}

	/**
	 * Custom Template locator .
	 *
	 * @param  mixed $template_name template name .
	 * @param  mixed $default_path default path .
	 * @return string
	 */
	public static function chat_help_locate_template($template_name, $default_path = '')
	{
		if (! $default_path) {
			$default_path = CHAT_HELP_DIR_PATH . 'src/Frontend/Templates/';
		}
		$template = locate_template($template_name);
		if (! $template) {
			$template = $default_path . $template_name;
		}
		// Return what we found.
		return $template;
	}

	public static function should_display_element($options)
	{
		$visibilities = !empty($options['visibility']) ? $options['visibility'] : [];

		$visibility_by_theme_page = !empty($options['visibility_by_theme_page']) ? $options['visibility_by_theme_page'] : [];
		$theme_page_target = isset($visibility_by_theme_page['theme_page_target']) ? $visibility_by_theme_page['theme_page_target'] : '';
		$theme_page_all = isset($visibility_by_theme_page['theme_page_all']) ? $visibility_by_theme_page['theme_page_all'] : '';
		$theme_page = !empty($visibility_by_theme_page['theme_page']) ? $visibility_by_theme_page['theme_page'] : [];
		$theme_page = array_combine($theme_page, $theme_page);
		$visibility_by_page = !empty($options['visibility_by_page']) ? $options['visibility_by_page'] : [];
		$page_target 		= isset($visibility_by_page['page_target']) ? $visibility_by_page['page_target'] : '';
		$page_all 			= isset($visibility_by_page['page_all']) ? $visibility_by_page['page_all'] : '';
		$page 				= !empty($visibility_by_page['page']) ? $visibility_by_page['page'] : [];

		$current_page_id = get_queried_object_id();

		if (!empty($visibilities)) {
			foreach ($visibilities as $key => $visibility) {

				switch ($visibility) {
					case 'theme_page':
						if (in_array('theme_page', $visibilities)) {
							$page_conditions = array(
								'post_page'        => is_home(),
								'search_page'      => is_search(),
								'404_page'         => is_404(),
							);

							foreach ($page_conditions as $page_key => $is_page) {
								if ($is_page) {
									if ($theme_page_target == 'include') {
										if ($theme_page_all || empty($theme_page)) {
											return true;
										} else {
											if (in_array($page_key, $theme_page)) {
												return true;
											} else {
												return false;
											}
										}
									} else {
										if ($theme_page_all || empty($theme_page)) {
											return false;
										} else {
											if (in_array($page_key, $theme_page)) {
												return false;
											} else {
												return true;
											}
										}
									}
								}
							}
						}
						break;
					case 'page':
						if (in_array('page', $visibilities)) {
							if (is_page()) {
								if ($page_target == 'include') {
									if ($page_all || empty($page)) {
										return true;
									} else {
										if (in_array($current_page_id, $page)) {
											return true;
										} else {
											return false;
										}
									}
								} else {
									if ($page_all || empty($page)) {
										return false;
									} else {
										if (in_array($current_page_id, $page)) {
											return false;
										} else {
											return true;
										}
									}
								}
							}
						}
						break;
				}
			}
		} else {
			return true;
		}
	}

	/**
	 * WhatsApp URL
	 *
	 * @return string
	 */
	public static function whatsAppUrl($whatsapp_number, $type_of_whatsapp = 'number', $whatsapp_group = '', $url_for_desktop = '', $url_for_mobile = '', $message = '')
	{
		// Detect the device type based on the User-Agent - Check if 'HTTP_USER_AGENT' exists in $_SERVER before using it
		$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'])) : '';

		if ($type_of_whatsapp === 'number') {
			if (wp_is_mobile() || preg_match('/iPhone|Android|iPod|iPad|webOS|BlackBerry|Windows Phone|Opera Mini|IEMobile|Mobile/', $user_agent)) {
				if ($url_for_mobile == 'protocol') {
					$url = 'whatsapp://send?phone=' . $whatsapp_number;
					if (!empty($message)) {
						$url .= '&text=' . rawurlencode($message);
					}
				} else {
					$url = 'https://wa.me/' . $whatsapp_number;
					if (!empty($message)) {
						$url .= '?text=' . rawurlencode($message);
					}
				}
			} else {
				if ($url_for_desktop == 'api') {
					$url = 'https://wa.me/' . $whatsapp_number;
					if (!empty($message)) {
						$url .= '?text=' . rawurlencode($message);
					}
				} else {
					$url = 'https://web.whatsapp.com/send?phone=' . $whatsapp_number;
					if (!empty($message)) {
						$url .= '&text=' . rawurlencode($message);
					}
				}
			}
		} else {
			$url = $whatsapp_group;
		}
		return $url;
	}

	/**
	 * WooCommerce Product instanceof
	 *
	 * @return null
	 */
	private static function is_valid_wc_product($product)
	{
		return $product instanceof \WC_Product;
	}

	/**
	 * Global replacement vars
	 *
	 * @return string
	 */

	public static function replacement_vars($message, $form = false, $formData = '', $product_id = null, $override_currentURL = '', $override_currentTitle = '')
	{
		// vars for all types
		global $wp;
		if ($product_id) {
			$product = wc_get_product($product_id); // Manually load product object
		} else {
			global $product;
		}
		$remove = function () {
			return '-';
		};
		add_filter('document_title_separator', $remove);
		$title = wp_get_document_title();
		remove_filter('document_title_separator', $remove);
		$siteTitle = get_bloginfo('name');
		$currentTitle = $override_currentTitle ?: $title;
		$siteURL = get_site_url();
		$currentURL = $override_currentURL ?: home_url($wp->request);
		$siteEmail = get_bloginfo('admin_email');
		$date    = date('F j, Y, H:i (h:i A) (\G\M\T O)');
		$ip = esc_sql(sanitize_text_field($_SERVER['REMOTE_ADDR']));

		// 🔁 Define a list of conditional tag rules
		$conditional_blocks = [
			'PRODUCT' => self::is_valid_wc_product($product),
			'NOT_PRODUCT' => !self::is_valid_wc_product($product),
			'LOGGEDIN' => is_user_logged_in(),
			'NOT_LOGGEDIN' => !is_user_logged_in(),
		];

		// 🔄 Loop through each block and apply conditional logic
		foreach ($conditional_blocks as $key => $condition) {
			$pattern = '/\{' . $key . '_START\}(.*?)\{' . $key . '_END\}/s';
			if ($condition) {
				// Keep content inside block
				$message = preg_replace_callback($pattern, function ($matches) {
					return $matches[1];
				}, $message);
			} else {
				// Remove entire block
				$message = preg_replace($pattern, '', $message);
			}
		}


		$variables = array('{siteTitle}', '{currentTitle}', '{siteURL}', '{currentURL}', '{siteEmail}', '{date}', '{ip}');
		$values = array($siteTitle, $currentTitle, $siteURL, $currentURL, $siteEmail, $date, $ip);
		if (!self::is_valid_wc_product($product)) {
			$product = null;
		}

		if (self::is_valid_wc_product($product)) {
			$productName = $product->get_name();
			$productSlug = $product->get_slug();
			$productPrice = $product->get_price();
			$productRegularPrice = $product->get_regular_price();
			$productSalePrice = $product->get_sale_price();
			$productSku = $product->get_sku();
			$productStockStatus = $product->get_stock_status();
			$product_variables = array('{productName}', '{productSlug}', '{productPrice}', '{productRegularPrice}', '{productSalePrice}', '{productSku}', '{productStockStatus}');
			$product_values = array($productName, $productSlug, $productPrice, $productRegularPrice, $productSalePrice, $productSku, $productStockStatus);
			$variables = array_merge($variables, $product_variables);
			$values = array_merge($values, $product_values);
		}

		if ($form) {
			$fields_label = [];
			$fields_data = [];
			$field_index = 1;
			$options = get_option('cwp_option');
			$form_editor = isset($options['form_editor']) ? $options['form_editor'] : '';
			foreach ($form_editor as $field_id => $form_field) {
				$field_name = isset($form_field['field_select']) ? $form_field['field_select'] : '';
				switch ($field_name) {
					case 'text':
						$field_label = isset($form_field['label']) ? $form_field['label'] : '';
						$fields_label['label_' . $field_index] = $field_label;

						$dynamic_id = Helpers::generate_safe_field_id($field_label, 'chat_help_text_' . esc_attr($field_id));
						$fields_data['text_' . $field_index] = sanitize_text_field($formData[$dynamic_id] ?? '');
						break;
					case 'textarea':
						$field_label = isset($form_field['label']) ? $form_field['label'] : '';
						$fields_label['label_' . $field_index] = $field_label;
						$dynamic_id = Helpers::generate_safe_field_id($field_label, 'chat_help_textarea_' . esc_attr($field_id));
						$fields_data['textarea_' . $field_index] = sanitize_textarea_field($formData[$dynamic_id] ?? '');
				}
				$field_index++;
			}

			$form_fields = '';
			foreach ($fields_label as $key => $label) {
				$index = str_replace('label_', '', $key);
				foreach ($fields_data as $data_key => $value) {
					if (strpos($data_key, "_$index") !== false) {
						$form_fields .= "$label: $value, ";
						break;
					}
				}
			}
			$form_fields = rtrim($form_fields, ', ');
			foreach ($fields_data as $key => $value) {
				$variables[] = '{' . $key . '}';
				$values[] = $value;
			}
			$variables[] = '{form_fields}';
			$values[] = $form_fields;
		}

		$replace_vars = trim(str_replace($variables, $values, $message));
		return $replace_vars;
	}

	/**
	 * Generate a safe, unique field ID from a label.
	 *
	 * Converts to lowercase, replaces spaces with underscores, removes special chars,
	 * and appends a suffix if the same key already exists.
	 *
	 * @param string $label Field label.
	 * @param string $fallback Fallback ID if label is empty.
	 * @return string Safe, unique field ID.
	 */
	public static function generate_safe_field_id($label, $fallback = '')
	{
		static $used_keys = [];

		if (!empty($label)) {
			// make safe key
			$key = strtolower(trim($label));
			$key = preg_replace('/\s+/', '_', $key);          // spaces → underscore
			$key = preg_replace('/[^a-z0-9_]/', '', $key);   // remove special chars

			// handle duplicates
			if (isset($used_keys[$key])) {
				$used_keys[$key]++;
				$key .= '_' . $used_keys[$key];
			} else {
				$used_keys[$key] = 0; // first occurrence
			}

			return $key;
		}

		// fallback if label empty
		return $fallback;
	}
}
