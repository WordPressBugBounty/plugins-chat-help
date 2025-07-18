<?php

namespace ThemeAtelier\ChatHelp\Frontend;

use ThemeAtelier\ChatHelp\Helpers\Helpers;

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
		$number = $atts['number'];

		// visibility
		if ($atts['visibility'] === 'only-desktop') {
			$buttonVisibility = 'wHelp-desktop-only';
		} elseif ($atts['visibility'] === 'only-tablet') {
			$buttonVisibility = 'wHelp-tablet-only';
		} elseif ($atts['visibility'] === 'only-tablet-mobile') {
			$buttonVisibility = 'wHelp-mobile-tablet-only';
		} else {
			$buttonVisibility = 'wHelp-show-everywhere';
		}

		$buttonRounded    = $atts['rounded'];
		$buttonSizes      = $atts['sizes'];
		$agentPhoto       = $atts['photo'];
		$primaryColor 		= $atts['primary_color'];
		$secondaryColor 	= $atts['secondary_color'];
		$padding = $atts['padding'];

		$agent_name        = $atts['name'];
		$agent_designation = $atts['designation'];
		$label_text        = $atts['label'];
		$onlineText        = $atts['online'];
		$offline_text       = $atts['offline'];
		// availablity
		$avlTimezone = $atts['timezone'];
		$avlSunday    = $atts['sunday'];
		$avlMonday    = $atts['monday'];
		$avlTuesday   = $atts['tuesday'];
		$avlWednesday = $atts['wednesday'];
		$avlThursday  = $atts['thursday'];
		$avlFriday    = $atts['friday'];
		$avlSaturday  = $atts['saturday'];
		$bg_color = $atts['bg_color'];
		$bg_color = $bg_color == 'true' ? 'wHelp-btn-bg' : '';
?>
		<div class="button-wrapper">
			<div style="--color-primary: <?php echo esc_attr($primaryColor) ?>; --color-secondary: <?php echo esc_attr($secondaryColor) ?>; --padding: <?php echo esc_attr($padding) ?>;" <?php if ($avlTimezone) { ?> data-timezone="($avlTimezone); ?>" <?php } ?> class="wHelpButtons wHelp-button-4 <?php echo esc_attr($bg_color . ' ' . $buttonVisibility); ?> <?php echo esc_attr($buttonRounded); ?> avatar-active <?php echo esc_attr($buttonSizes); ?>" data-btnavailablety='{ "sunday":"<?php echo esc_attr($avlSunday); ?>", "monday":"<?php echo esc_attr($avlMonday); ?>", "tuesday":"<?php echo esc_attr($avlTuesday); ?>", "wednesday":"<?php echo esc_attr($avlWednesday); ?>", "thursday":"<?php echo esc_attr($avlThursday); ?>", "friday":"<?php echo esc_attr($avlFriday); ?>", "saturday":"<?php echo esc_attr($avlSaturday); ?>" }'>
				<?php if ($agentPhoto) { ?>
					<img src="<?php echo esc_attr($agentPhoto); ?>" />
				<?php } ?>
				<div class="info-wrapper">
					<?php if ($agent_name || $agent_designation) { ?>
						<p class="info">
							<?php
							if ($agent_name) {
							?>
								<?php echo esc_html($agent_name); ?><?php } ?> <?php
																				if ($agent_designation) {
																				?>
									/ <?php echo esc_html($agent_designation); ?><?php } ?></p>
					<?php } ?>
					<?php if ($label_text) { ?>
						<p class="title"><?php echo esc_html($label_text); ?></p>
					<?php } ?>
					<?php if ($onlineText) { ?>
						<p class="online"><?php echo esc_html($onlineText); ?></p>
					<?php } ?>
					<?php if ($offline_text) { ?>
						<p class="offline"><?php echo esc_html($offline_text); ?></p>
					<?php } ?>
				</div>

				<?php
				$options                 = get_option('cwp_option');
                $url_for_desktop = isset($options['url_for_desktop']) ? $options['url_for_desktop'] : '';
                $url_for_mobile = isset($options['url_for_mobile']) ? $options['url_for_mobile'] : '';
                $url = Helpers::whatsAppUrl($number, '', '', $url_for_desktop, $url_for_mobile);
				$open_in_new_tab = isset($options['open_in_new_tab']) ? $options['open_in_new_tab'] : '';
				$open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';
				echo '<a href="' . esc_url($url) . '" target="' . esc_attr($open_in_new_tab) . '" class="chat-link"></a>';
				?>
			</div>
		</div>
	<?php
	}

	// // Template style 2
	public function ctw_button_s2()
	{
		$iterate_data = self::$get_data;
		$atts         = $iterate_data;
		$shortcode_number = $atts['number'];
		$primaryColor = $atts['primary_color'];
		$secondaryColor = $atts['secondary_color'];
		$padding = $atts['padding'];

		$options = get_option('cwp_option');
        $open_in_new_tab = isset($options['open_in_new_tab']) ? $options['open_in_new_tab'] : '';

		// visibility
		if ($atts['visibility'] === 'only-desktop') {
			$buttonVisibility = 'wHelp-desktop-only';
		} elseif ($atts['visibility'] === 'only-tablet') {
			$buttonVisibility = 'wHelp-tablet-only';
		} elseif ($atts['visibility'] === 'only-tablet-mobile') {
			$buttonVisibility = 'wHelp-mobile-tablet-only';
		} else {
			$buttonVisibility = 'wHelp-show-everywhere';
		}
		$buttonSizes   = $atts['sizes'];
		$buttonRounded = $atts['rounded'];
		$labelText     = $atts['label'];
		$bg_color = $atts['bg_color'];
		$bg_color = $bg_color == 'true' ? 'wHelp-btn-bg' : '';

		$url_for_desktop = isset($options['url_for_desktop']) ? $options['url_for_desktop'] : '';
        $url_for_mobile = isset($options['url_for_mobile']) ? $options['url_for_mobile'] : '';
        $url = Helpers::whatsAppUrl($shortcode_number, '', '', $url_for_desktop, $url_for_mobile);
        $open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';
	?>

		<div class="button-wrapper">
			<a style="--color-primary: <?php echo esc_attr($primaryColor) ?>; --color-secondary: <?php echo esc_attr($secondaryColor) ?>; --padding: <?php echo esc_attr($padding) ?>;" target="<?php echo esc_attr($open_in_new_tab) ?>" href="<?php echo esc_url($url); ?>" class="wHelp-button-2 <?php echo esc_attr($bg_color . ' ' . $buttonSizes); ?> <?php echo esc_attr($buttonVisibility); ?> <?php echo esc_attr($buttonRounded); ?>">
				<i class="icofont-brand-whatsapp"></i><?php echo esc_attr($labelText); ?>
			</a>
		</div>
<?php
	}
} // End Class
