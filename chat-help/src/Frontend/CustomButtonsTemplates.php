<?php

namespace ThemeAtelier\ChatHelp\Frontend;

use ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers;

// don't call the file directly.
if (! defined('ABSPATH')) {
	exit;
}

class CustomButtonsTemplates
{
	public static $get_data;

	function __construct(array $args)
	{
		self::$get_data = $args;
	}
	// Template Style 1
	public function ctw_button_s1()
	{
		$iterate_data = self::$get_data;
		$atts         = $iterate_data;

		// button settings
		$agentPhoto       	= $atts['photo'];
		$background 		= $atts['background'];
		$hover_background 	= $atts['hover_background'];
		$text_color 		= $atts['text_color'];
		$hover_text_color 	= $atts['hover_text_color'];
		$border 			= $atts['border'];
		$border_style 		= $atts['border_style'];
		$border_color 		= $atts['border_color'];
		$border_hover_color = $atts['border_hover_color'];
		$icon_border 			= $atts['icon_border'];
		$icon_border_style 		= $atts['icon_border_style'];
		$icon_border_color 		= $atts['icon_border_color'];
		$icon_border_hover_color = $atts['icon_border_hover_color'];
		$padding 			= $atts['padding'];
		$top_label        	= $atts['top_label'];
		$main_label        	= $atts['main_label'];
		$onlineText        	= $atts['online'];
		$offline_text       = $atts['offline'];
		$message 			= $atts['message'];
		$message 			= Helpers::replacement_vars($message);
		$type_of_whatsapp 	= $atts['type_of_whatsapp'];
		$number 			= $atts['number'];
		$group 				= $atts['group'];
		$visibility 		= $atts['visibility'];
		$buttonSizes      	= $atts['sizes'];
		$buttonRounded 		= $atts['border_radius'];
		$icon_buttonRounded 		= $atts['icon_border_radius'];
		$avlTimezone 		= $atts['timezone'];
		$avlSunday    		= $atts['sunday'];
		$avlMonday    		= $atts['monday'];
		$avlTuesday   		= $atts['tuesday'];
		$avlWednesday 		= $atts['wednesday'];
		$avlThursday  		= $atts['thursday'];
		$avlFriday    		= $atts['friday'];
		$avlSaturday  		= $atts['saturday'];

		if ($type_of_whatsapp === 'group') {
			$gaAnalyticsAttr = 'data-group=' . $group . '';
		} else {
			$gaAnalyticsAttr = 'data-number=' . $number . '';
		}

		$options = get_option('cwp_option');
		$open_in_new_tab = isset($options['open_in_new_tab']) ? $options['open_in_new_tab'] : '';
		$open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';
		$url_for_desktop = isset($options['url_for_desktop']) ? $options['url_for_desktop'] : '';
		$url_for_mobile = isset($options['url_for_mobile']) ? $options['url_for_mobile'] : '';
		$url = Helpers::whatsAppUrl($number, $type_of_whatsapp, $group, $url_for_desktop, $url_for_mobile, $message);
	
?>
		<div class="button-wrapper"><div style="--wHelp-background: <?php echo esc_attr($background) ?>; --wHelp-hover-background: <?php echo esc_attr($hover_background) ?>; --wHelp-padding: <?php echo esc_attr($padding) ?>; --wHelp-border-radius: <?php echo esc_attr($buttonRounded); ?>; --wHelp-text-color: <?php echo esc_attr($text_color); ?>; --wHelp-text-hover-color: <?php echo esc_attr($hover_text_color); ?>; --wHelp-border: <?php echo esc_attr($border . ' ' . $border_style); ?>; --wHelp-border-color: <?php echo esc_attr($border_color); ?>; --wHelp-border-hover-color: <?php echo esc_attr($border_hover_color); ?>; --wHelp-icon-border: <?php echo esc_attr($icon_border . ' ' . $icon_border_style); ?>; --wHelp-icon-border-color: <?php echo esc_attr($icon_border_color); ?>; --wHelp-hover-icon-border-color: <?php echo esc_attr($icon_border_hover_color); ?>; --wHelp-icon-border-radius: <?php echo esc_attr($icon_buttonRounded); ?>;" <?php echo esc_attr($gaAnalyticsAttr) ?> <?php if ($avlTimezone) { ?> data-timezone="<?php echo esc_attr($avlTimezone); ?>" <?php } ?> class="wHelp_button shortcode_btn wHelp_button_advance wHelpButtons <?php echo esc_attr($visibility); ?> avatar-active <?php echo esc_attr($buttonSizes); ?>" data-availability='{ "sunday":"<?php echo esc_attr($avlSunday); ?>", "monday":"<?php echo esc_attr($avlMonday); ?>", "tuesday":"<?php echo esc_attr($avlTuesday); ?>", "wednesday":"<?php echo esc_attr($avlWednesday); ?>", "thursday":"<?php echo esc_attr($avlThursday); ?>", "friday":"<?php echo esc_attr($avlFriday); ?>", "saturday":"<?php echo esc_attr($avlSaturday); ?>" }'><?php if ($agentPhoto) { ?><div><img src="<?php echo esc_attr($agentPhoto); ?>" /></div><?php } ?><div class="info-wrapper"><?php if ($top_label) { ?><div class="info"><?php echo esc_html($top_label); ?></div><?php } if ($main_label) { ?><div class="wHelp_title"><?php echo esc_html($main_label); ?></div><?php } if ($onlineText) { ?><div class="online"><?php echo esc_html($onlineText); ?></div><?php } if ($offline_text) { ?><div class="offline"><?php echo esc_html($offline_text); ?></div><?php } ?></div><?php echo '<div><a href="' . esc_attr($url) . '" target="' . esc_attr($open_in_new_tab) . '" class="chat-link"></a></div>'; ?></div></div>
	<?php

	}

	// Template style 2
	public function ctw_button_s2()
	{
		$iterate_data = self::$get_data;
		$atts         = $iterate_data;

		// button settings
		$background 		= $atts['background'];
		$hover_background 	= $atts['hover_background'];
		$text_color 		= $atts['text_color'];
		$hover_text_color 	= $atts['hover_text_color'];
		$icon_color 		= $atts['icon_color'];
		$hover_icon_color 	= $atts['hover_icon_color'];
		$icon_bg_color 		= $atts['icon_background'];
		$hover_icon_bg_color = $atts['hover_icon_background'];
		$border 			= $atts['border'];
		$border_style 		= $atts['border_style'];
		$border_color 		= $atts['border_color'];
		$border_hover_color = $atts['border_hover_color'];
		$icon_border 			= $atts['icon_border'];
		$icon_border_style 		= $atts['icon_border_style'];
		$icon_border_color 		= $atts['icon_border_color'];
		$icon_border_hover_color = $atts['icon_border_hover_color'];
		$padding 			= $atts['padding'];
		$main_label     	= $atts['main_label'];
		$message 			= $atts['message'];
		$message 			= Helpers::replacement_vars($message);
		$type_of_whatsapp 	= $atts['type_of_whatsapp'];
		$number 			= $atts['number'];
		$group 				= $atts['group'];
		$visibility 		= $atts['visibility'];
		$buttonSizes   		= $atts['sizes'];
		$buttonRounded 		= $atts['border_radius'];
		$icon_buttonRounded = $atts['icon_border_radius'];
		$icon_bg = $atts['icon_bg'] === 'yes' ? 'icon_bg' : '';
		$icon = isset($atts['icon']) ? $atts['icon'] : '';

		if ($type_of_whatsapp === 'group') {
			$gaAnalyticsAttr = 'data-group=' . $group . '';
		} else {
			$gaAnalyticsAttr = 'data-number=' . $number . '';
		}

		$options = get_option('cwp_option');
		$open_in_new_tab = isset($options['open_in_new_tab']) ? $options['open_in_new_tab'] : '';
		$open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';
		$url_for_desktop = isset($options['url_for_desktop']) ? $options['url_for_desktop'] : '';
		$url_for_mobile = isset($options['url_for_mobile']) ? $options['url_for_mobile'] : '';
		$url = Helpers::whatsAppUrl($number, $type_of_whatsapp, $group, $url_for_desktop, $url_for_mobile, $message);

	?>
<div class="button-wrapper"><a style="--wHelp-background: <?php echo esc_attr($background) ?>; --wHelp-hover-background: <?php echo esc_attr($hover_background) ?>; --wHelp-padding: <?php echo esc_attr($padding) ?>; --wHelp-border-radius: <?php echo esc_attr($buttonRounded); ?>; --wHelp-text-color: <?php echo esc_attr($text_color); ?>; --wHelp-text-hover-color: <?php echo esc_attr($hover_text_color); ?>; --wHelp-icon-normal-color: <?php echo esc_attr($icon_color); ?>; --wHelp-icon-hover-color: <?php echo esc_attr($hover_icon_color); ?>; --wHelp-icon-normal-bg-color: <?php echo esc_attr($icon_bg_color); ?>; --wHelp-icon-hover-bg-color: <?php echo esc_attr($hover_icon_bg_color); ?>; --wHelp-border: <?php echo esc_attr($border . ' ' . $border_style); ?>; --wHelp-border-color: <?php echo esc_attr($border_color); ?>; --wHelp-border-hover-color: <?php echo esc_attr($border_hover_color); ?>; --wHelp-icon-border: <?php echo esc_attr($icon_border . ' ' . $icon_border_style); ?>; --wHelp-icon-border-color: <?php echo esc_attr($icon_border_color); ?>; --wHelp-hover-icon-border-color: <?php echo esc_attr($icon_border_hover_color); ?>; --wHelp-icon-border-radius: <?php echo esc_attr($icon_buttonRounded); ?>;" <?php echo esc_attr($gaAnalyticsAttr) ?> target="<?php echo esc_attr($open_in_new_tab) ?>" href="<?php echo esc_attr($url); ?>" class="wHelp_button shortcode_btn chat_help_analytics <?php echo esc_attr($buttonSizes . ' ' . $visibility); ?>"><?php if ($icon == 'yes') { ?><span class="bubble__icon <?php echo esc_attr($icon_bg); ?>"><i class="icofont-brand-whatsapp"></i></span><?php } echo esc_attr($main_label); ?></a></div>
<?php

	}
	
} // End Class
