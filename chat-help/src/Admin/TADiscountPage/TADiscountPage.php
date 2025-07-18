<?php
namespace ThemeAtelier\ChatHelp\Admin\TADiscountPage;

class TADiscountPage
{
	public function __construct()
	{
		add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
		// add_action('admin_notices', array($this, 'discount_admin_notice'));
		// add_action('admin_init', array($this, 'discount_admin_notice_dismissed'));
		// add_action('chat_help_before_upgrade_pro_menu', array($this, 'create_menu_page'));
	}

	public function admin_scripts()
	{
		$screen = get_current_screen();
		wp_enqueue_style('themeatelier_discount_page_style', plugins_url('assets/css/discount-page.css', __FILE__), '', '1.0');

		if ('whatsapp-chat_page_ta_discounts' == $screen->base) {
			wp_enqueue_style('themeatelier_discount_page_tailwind', plugins_url('assets/css/tailwind.css', __FILE__), '', '1.0');	
			$custom_css = '#wpcontent{padding-left: 0px;} .auto-fold #wpcontent {padding-left: 0px !important} #wpcontent *{box-sizing: border-box;}html{scroll-behavior: smooth;}';
			wp_add_inline_style( 'themeatelier_discount_page_style', $custom_css );
		}
	}

	public $args = array(
		'page_title'  => 'Best Black Friday WordPress Deals on Top Plugins Now! (2024)',
		'menu_title'  => 'Black Friday Offer',
		'menu_slug'   => 'ta_discounts',
		'icon_url'    => '',
		'menu_type'   => 'submenu',
		'parent_slug' => 'chat-help',
		'capability'  => 'manage_options',
		'position'    => 15
	);

	public function create_menu_page()
	{
		$args = $this->args;

		if ('menu' === $args['menu_type']) {
			add_menu_page(
				$args['page_title'] ?: $args['menu_title'],
				$args['menu_title'],
				$args['capability'],
				$args['menu_slug'],
				array($this, 'menu_page_content'),
				$args['icon_url'],
				$args['position']
			);
		} elseif ('submenu' === $args['menu_type']) {
			add_submenu_page(
				$args['parent_slug'],
				$args['page_title'] ?: $args['menu_title'],
				$args['menu_title'],
				$args['capability'],
				$args['menu_slug'],
				array($this, 'menu_page_content'), $args['position']
			);
		}
	}

	public function menu_page_content()
	{
?>
		<section id="hero" class="blackfriday-hero bg-[#111] py-12 lg:py-20 text-white">
			<div class="container text-center">
				<h2 class="aclonica-regular mb-2 mt-0 text-xl uppercase text-white lg:text-xl">Black Friday Exclusive Deals</h2>
				<h2 class="aclonica-regular mb-8 mt-0 text-5xl text-white md:text-6xl lg:text-7xl">Up to 40% OFF</h2>
					<p>Starts: Wednesday, 20th November, 12 PM AEDT</p>
					<p>Ends: Tuesday, 3rd December, 11:59 PM AEDT</p>
					<p>To convert the campaign start and end AEDT times to your timezone, <a class="text-white" target="_blank" href="https://savvytime.com/converter/aedt">click here</a>.</p>
					<div class=" mt-5 flex flex-wrap justify-center gap-2 text-center align-middle">
						<a class="inline-block rounded-3xl !bg-[#3464e0] !py-1.5 px-4 text-base !text-white no-underline duration-300 ease-linear hover:!bg-[#000000] lg:!py-2 lg:px-6" href="#wp_plugins">Wp Plugins</a>
						<a class="inline-block rounded-3xl !bg-[#3464e0] !py-1.5 px-4 text-base !text-white no-underline duration-300 ease-linear hover:!bg-[#000000] lg:!py-2 lg:px-6" href="#event">Event Addons</a>
						<a class="inline-block rounded-3xl !bg-[#3464e0] !py-1.5 px-4 text-base !text-white no-underline duration-300 ease-linear hover:!bg-[#000000] lg:!py-2 lg:px-6" href="#elementor">Elementor Addons</a>
						<a class="inline-block rounded-3xl !bg-[#3464e0] !py-1.5 px-4 text-base !text-white no-underline duration-300 ease-linear hover:!bg-[#000000] lg:!py-2 lg:px-6" href="#html_js">HTML & JS Templates</a>
					</div>
			</div>
		</section>
		<section id="wp_plugins" class="py-12 lg:py-20 bg-secondary">
			<div class="container">
				<div class="mb-12 text-center">
					<h2 class="mb-2 mt-0 text-ta-section-title">
						Powerful WordPress Plugins
					</h2>
					<p class="text-xl m-0">Explore our top-rated WordPress plugins designed to elevate your website. These plugins offer reliable, user-friendly features to take your site to the next level. Grab them at unbeatable Black Friday prices!</p>
				</div>
				<div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
					<!-- Single product start -->
					<div class="overflow-hidden transition-all duration-300 bg-white border border-solid border-gray-300 hover:border-primary rounded shadow-xl hover:shadow-none">
						<div class="p-5 px-5 pb-6">
							<div class="flex items-start justify-between gap-3 mb-5">
								<div class="inline-block p-1 bg-secondary border rounded border-slate-200">
									<a class="no-underline" href="https://1.envato.market/gbdm79" target="_blank">
										<img src="https://s3.envato.com/files/405653361/Thumbnail.jpg" alt="Thumbnial" class="max-w-[100px] rounded-sm" />
									</a>
								</div>
								<div class="text-right">
									<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300 mb-2">
										Flat 40% Off
									</div>
									<div class="font-bold pricing">
										<del>$29</del> <sup class="font-bold text-[#7535FB] text-lg">$</sup> <span class="font-bold text-[#7535FB] text-4xl">17</span><sub>/Lifetime</sub>
									</div>
								</div>
							</div>

							<h3 class="mt-3 mb-2 text-2xl leading-6 leading-8">
								<a target="_blank" class="no-underline text-font-color hover:text-[#7535FB] transition-all duration-300" href="https://1.envato.market/gbdm79">Greet.wp - Video bubble WordPress plugin</a>
							</h3>
							<p class="text-lg mt-0">
								Greet is a powerful, user-friendly video bubble plugin for WordPress, expertly designed to create dynamic, personalized, and engaging welcome experiences for your website visitors.
							</p>

							<div class="flex gap-2 flex-wrap">
								<a target="_blank" href="http://wp-plugins.themeatelier.net/greet/" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 bg-white rounded-full border-2 hover:!text-white ease-linear duration-300 inline-block border-solid border-[#7535FB] leading-6 hover:bg-[#7535fb] !text-[#7535fb]">Demo</a>
								<a target="_blank" href="https://1.envato.market/gbdm79" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 rounded-3xl !text-white  ease-linear duration-300 inline-block !bg-[#7535fb] hover:!bg-[#000000]">Buy Now</a>
							</div>
						</div>
					</div>
					<!-- Single product end -->

					<!-- Single product start -->
					<div class="overflow-hidden transition-all duration-300 bg-white border border-solid border-gray-300 hover:border-primary rounded shadow-xl hover:shadow-none">
						<div class="p-5 px-5 pb-6">
							<div class="flex items-start justify-between gap-3 mb-5">
								<div class="inline-block p-1 bg-secondary border rounded border-slate-200">
									<a href="https://1.envato.market/LPeXVY" target="_blank">
										<img src="https://s3.envato.com/files/435013314/Thumbnail.png" alt="Thumbnail" class="max-w-[100px] rounded-sm" />
									</a>
								</div>
								<div class="text-right">
									<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300 mb-2">
										Flat 30% Off
									</div>
									<div class="font-bold pricing">
										<del>$29</del> <sup class="font-bold text-[#19BC9E] text-lg">$</sup> <span class="font-bold text-[#19BC9E] text-4xl">20</span> <sub>/Lifetime</sub>
									</div>
								</div>

							</div>

							<h3 class="mt-3 mb-2 text-2xl leading-6 leading-8">
								<a target="_blank" class="no-underline text-font-color hover:text-[#19BC9E] transition-all duration-300" href="https://1.envato.market/LPeXVY">Nilam - Domain For Sale & Auction Plugin</a>
							</h3>
							<p class="text-lg mt-0">
								Turn your domains into cash quickly with the Domain For Sale WordPress Plugin—the perfect tool for transforming your unused domain names into profitable business opportunities.
							</p>

							<div class="flex gap-2 flex-wrap">
								<a target="_blank" href="https://wp-plugins.themeatelier.net/nilam/" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 bg-white rounded-full border-2 hover:!text-white ease-linear duration-300 inline-block border-solid border-[#19BC9E] leading-6 hover:bg-[#19BC9E] !text-[#19BC9E]">Demo</a>
								<a target="_blank" href="https://1.envato.market/LPeXVY" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 rounded-3xl !text-white  ease-linear duration-300 inline-block !bg-[#19BC9E] hover:!bg-[#000000]">Buy Now</a>
							</div>
						</div>
					</div>
					<!-- Single product end -->
					<!-- Single product start -->
					<div class="overflow-hidden transition-all duration-300 bg-white border border-solid border-gray-300 hover:border-primary rounded shadow-xl hover:shadow-none">
						<div class="p-5 px-5 pb-6">
							<div class="flex items-start justify-between gap-3 mb-5">
								<div class="inline-block p-1 bg-secondary border rounded border-slate-200">
									<a href="http://1.envato.market/darkify" target="_blank">
										<img src="https://s3.envato.com/files/479349553/Thumbnail.png" alt="Thumbnail" class="max-w-[100px] rounded-sm" />
									</a>
								</div>
								<div class="text-right">
									<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300 mb-2">
										Flat 40% Off
									</div>
									<div class="font-bold pricing">
										<del>$29</del> <sup class="font-bold text-[#171717] text-lg">$</sup> <span class="font-bold text-[#171717] text-4xl">17</span> <sub>/Lifetime</sub>
									</div>
								</div>
							</div>

							<h3 class="mt-3 mb-2 text-2xl leading-6 leading-8">
								<a target="_blank" class="no-underline text-font-color hover:text-[#171717] transition-all duration-300" href="http://1.envato.market/darkify">Darkify -WordPress Dark Mode Plugin</a>
							</h3>
							<p class="text-lg mt-0">
								Darkify – is an extremely advanced dark mode plugin for any WordPress website. The plugin has the option to enable a dark mode switcher for the front end and also WordPress admin.
							</p>
							<div class="flex gap-2 flex-wrap">
								<a target="_blank" href="https://wp-plugins.themeatelier.net/" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 bg-white rounded-full border-2 hover:!text-white ease-linear duration-300 inline-block border-solid border-[#171717] leading-6 hover:bg-[#171717] !text-[#171717]">Demo</a>
								<a target="_blank" href="http://1.envato.market/darkify" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 rounded-3xl !text-white  ease-linear duration-300 inline-block !bg-[#171717] hover:!bg-[#000000]">Buy Now</a>
							</div>
						</div>
					</div>
					<!-- Single product end -->

					<!-- Single product start -->
					<div class="overflow-hidden transition-all duration-300 bg-white border border-solid border-gray-300 hover:border-primary rounded shadow-xl hover:shadow-none">
						<div class="p-5 px-5 pb-6">
							<div class="flex items-start justify-between gap-3 mb-5">
								<div class="inline-block p-1 bg-secondary border rounded border-slate-200">
									<a href="http://1.envato.market/bookify" target="_blank">
										<img src="https://s3.envato.com/files/485327030/Thumbnail.jpg" alt="Thumbnail" class="max-w-[100px] rounded-sm" />
									</a>
								</div>
								<div class="text-right">
									<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300 mb-2">
										Flat 40% Off
									</div>
									<div class="font-bold pricing">
										<del>$29</del> <sup class="font-bold text-[#C27B7F] text-lg">$</sup> <span class="font-bold text-[#C27B7F] text-4xl">17</span> <sub>/Lifetime</sub>
									</div>
								</div>
							</div>

							<h3 class="mt-3 mb-2 text-2xl leading-6 leading-8">
								<a target="_blank" class="no-underline text-font-color hover:text-[#C27B7F] transition-all duration-300" href="http://1.envato.market/bookify">Bookify - Smart Book Showcase For WordPress</a>
							</h3>
							<p class="text-lg mt-0">
								"Smart Book Showcase for WordPress" is the ideal plugin for authors, publishers, and book lovers to beautifully display books, integrating seamlessly with WordPress for easy, stylish book showcasing.
							</p>

							<div class="flex gap-2 flex-wrap">
								<a target="_blank" href="https://wp-plugins.themeatelier.net/bookify" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 bg-white rounded-full border-2 hover:!text-white ease-linear duration-300 inline-block border-solid border-[#C27B7F] leading-6 hover:bg-[#C27B7F] !text-[#C27B7F]">Demo</a>
								<a target="_blank" href="http://1.envato.market/bookify" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 rounded-3xl !text-white  ease-linear duration-300 inline-block !bg-[#C27B7F] hover:!bg-[#000000]">Buy Now</a>
							</div>
						</div>
					</div>
					<!-- Single product end -->

					<!-- Single product start -->
					<div class="overflow-hidden transition-all duration-300 bg-white border border-solid border-gray-300 hover:border-primary rounded shadow-xl hover:shadow-none">
						<div class="p-5 px-5 pb-6">
							<div class="flex items-start justify-between gap-3 mb-5">
								<div class="inline-block p-1 bg-secondary border rounded border-slate-200">
									<a href="https://1.envato.market/catshowcase" target="_blank">
										<img src="https://s3.envato.com/files/493176077/Thumbnail.jpg" alt="Thumbnail" class="max-w-[100px] rounded-sm" />
									</a>
								</div>
								<div class="text-right">
									<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300 mb-2">
										Flat 35% Off
									</div>
									<div class="font-bold pricing">
										<del>$29</del> <sup class="font-bold text-[#68449C] text-lg">$</sup> <span class="font-bold text-[#68449C] text-4xl">18</span> <sub>/Lifetime</sub>
									</div>
								</div>
							</div>
							<h3 class="mt-3 mb-2 text-2xl leading-6 leading-8">
								<a target="_blank" class="no-underline text-font-color hover:text-[#68449C] transition-all duration-300" href="https://1.envato.market/catshowcase">CatShowcase - Category Showcase for WooCommerce</a>
							</h3>
							<p class="text-lg mt-0">
								CatShowcase presents WooCommerce categories in a sleek sliding format, ideal for featuring new arrivals, spotlighting specific categories, or organizing products in a visually appealing way.
							</p>
							<div class="flex gap-2 flex-wrap">
								<a target="_blank" href="https://wp-plugins.themeatelier.net/productify/catshowcase/" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 bg-white rounded-full border-2 hover:!text-white ease-linear duration-300 inline-block border-solid border-[#68449C] leading-6 hover:bg-[#68449C] !text-[#68449C]">Demo</a>
								<a target="_blank" href="https://1.envato.market/catshowcase" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 rounded-3xl !text-white  ease-linear duration-300 inline-block !bg-[#68449C] hover:!bg-[#000000]">Buy Now</a>
							</div>
						</div>
					</div>
					<!-- Single product end -->

					<!-- Single product start -->
					<div class="overflow-hidden transition-all duration-300 bg-white border border-solid border-gray-300 hover:border-primary rounded shadow-xl hover:shadow-none">
						<div class="p-5 px-5 pb-6">
							<div class="flex items-start justify-between gap-3 mb-5">
								<div class="inline-block p-1 bg-secondary border rounded border-slate-200">
									<a href="http://1.envato.market/942x4" target="_blank">
										<img src="https://s3.envato.com/files/268542419/thumbnail.png" class="max-w-[100px] rounded-sm" />
									</a>
								</div>
								<div class="text-right">
									<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300 mb-2">
										Flat 40% Off
									</div>
									<div class="font-bold pricing">
										<del>$29</del> <sup class="font-bold text-[#03B677] text-lg">$</sup> <span class="font-bold text-[#03B677] text-4xl">17</span> <sub>/Lifetime</sub>
									</div>
								</div>
							</div>
							<h3 class="mt-3 mb-2 text-2xl leading-6 leading-8">
								<a target="_blank" class="no-underline text-font-color hover:text-[#03B677] transition-all duration-300" href="http://1.envato.market/942x4">Bizreview - Business Review WordPress Plugin</a>
							</h3>
							<p class="text-lg mt-0">
								The best suitable plugin if you want to show your business reviews from different platforms like Google review, Facebook review, Trustpilot, Yelp, etc. There has different carousels to showcase.
							</p>
							<div class="flex gap-2 flex-wrap">
								<a target="_blank" href="https://wp-plugins.themeatelier.net/bizreview/" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 bg-white rounded-full border-2 hover:!text-white ease-linear duration-300 inline-block border-solid border-[#03B677] leading-6 hover:bg-[#03B677] !text-[#03B677]">Demo</a>
								<a target="_blank" href="http://1.envato.market/942x4" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 rounded-3xl !text-white  ease-linear duration-300 inline-block !bg-[#03B677] hover:!bg-[#000000]">Buy Now</a>
							</div>
						</div>
					</div>
					<!-- Single product end -->

				</div>
				<div class="container flex justify-center mt-12">
					<a target="_blank" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 bg-white rounded-full border-2 hover:!text-white ease-linear duration-300 inline-block border-solid border-[#016189] leading-6 hover:bg-[#016189] !text-[#016189]" href="https://1.envato.market/ta-plugins">
						Check All Items
					</a>
				</div>
			</div>
		</section>

		<section id="event" class="py-12 lg:py-20 bg-white">
			<div class="container">
				<div class="mb-12 text-center">
					<h2 class="mb-2 mt-0 text-ta-section-title">
						The Event Calendar Add-ons
					</h2>
					<p class="text-xl m-0">
						Keep your audience informed and engaged with our versatile Event Calendar add-ons. These add-ons allow you to customize, manage, and showcase your events with ease. Don’t miss out on these limited-time deals!
					</p>
				</div>
				<div class="grid gap-8 md:grid-cols-2">
					<!-- Single product Start -->
					<div class="overflow-hidden transition-all duration-300 border border-solid border-gray-300 hover:border-primary rounded shadow-xl bg-secondary hover:shadow-none">
						<div class="p-5 px-5 pb-6">
							<div class="flex items-start gap-5 mb-3">
								<div class="inline-block p-1 bg-white border rounded border-slate-200">
									<a href="https://1.envato.market/dOKoyQ" target="_blank">
										<img src="https://s3.envato.com/files/501589935/Thumbnail.png" alt="Thumbnail" class="max-w-[100px] rounded-sm" />
									</a>
								</div>
								<div>
									<div class="flex gap-2 flex-wrap">
										<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300 mb-3">
											Bundle
										</div>
										<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300 mb-3">
											Flat 30% Off
										</div>
									</div>

									<h3 class="m-0 text-2xl leading-6 leading-8">
										<a target="_blank" class="no-underline text-font-color hover:text-[#0015B5] transition-all duration-300" href="https://1.envato.market/dOKoyQ">The Events Calendar Addons Bundle</a>
									</h3>
								</div>
							</div>
							<p class="text-lg mt-0">
								Elevate your WordPress event management with the Ultimate Events Calendar Bundle, featuring five powerful add-ons for The Events Calendar. Enjoy complete control over event displays, with layouts for showcasing events, venues, organizers, and custom single pages.
							</p>

							<div class="flex gap-2 flex-wrap">
								<a target="_blank" href="https://ta-demo-nu.vercel.app/event-bundle/#demo" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 bg-white rounded-full border-2 hover:!text-white ease-linear duration-300 inline-block border-solid border-[#0015B5] leading-6 hover:bg-[#0015B5] !text-[#0015B5]">Demo</a>
								<a target="_blank" href="https://1.envato.market/dOKoyQ" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 rounded-3xl !text-white  ease-linear duration-300 inline-block !bg-[#0015B5] hover:!bg-[#000000]">Buy Now For <del>$39</del> $27</a>
							</div>
						</div>
					</div>
					<!-- Single product end -->
					<!-- Single product Start -->
					<div class="overflow-hidden transition-all duration-300 border border-solid border-gray-300 hover:border-primary rounded shadow-xl bg-secondary hover:shadow-none">
						<div class="p-5 px-5 pb-6">
							<div class="flex items-start gap-5 mb-3">
								<div class="inline-block p-1 bg-white border rounded border-slate-200">
									<a href="https://1.envato.market/eventful" target="_blank">
										<img src="https://s3.envato.com/files/483743042/Thumbnail.png" alt="Thumbnail" class="max-w-[100px] rounded-sm" />
									</a>
								</div>
								<div>
									<div class="flex gap-2 flex-wrap">
										<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300 mb-3">
											Flat 35% Off
										</div>
									</div>
									<h3 class="m-0 text-2xl leading-6 leading-8">
										<a target="_blank" class="no-underline text-font-color hover:text-[#263AD0] transition-all duration-300" href="https://1.envato.market/eventful">Events Showcase For The Events Calendar</a>
									</h3>
								</div>
							</div>
							<p class="text-lg mt-0">
								Greet is a powerful, user-friendly video bubble plugin for WordPress, designed to create dynamic and engaging welcome experiences for your website visitors.
							</p>
							<div class="flex gap-2 flex-wrap">
								<a target="_blank" href="https://wp-plugins.themeatelier.net/eventful" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 bg-white rounded-full border-2 hover:!text-white ease-linear duration-300 inline-block border-solid border-[#263AD0] leading-6 hover:bg-[#263AD0] !text-[#263AD0]">Demo</a>
								<a target="_blank" href="https://1.envato.market/eventful" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 rounded-3xl !text-white  ease-linear duration-300 inline-block !bg-[#263AD0] hover:!bg-[#000000]">Buy Now For <del>$29</del> $18</a>
							</div>
						</div>
					</div>
					<!-- Single product end -->
				</div>
			</div>
		</section>

		<section id="elementor" class="py-12 lg:py-20 bg-secondary">
			<div class="container">
				<div class="mb-12 text-center">
					<h2 class="mb-2 mt-0 text-ta-section-title">
						Premium Elementor Add-ons
					</h2>
					<p class="text-xl m-0">Create stunning web pages effortlessly with our exclusive Elementor add-ons.These tools make it easy to add custom widgets, animations, and features that bring your ideas to life. Get them now at a special Black Friday discount!</p>
				</div>
				<div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
					<!-- Single product start -->
					<div class="overflow-hidden transition-all duration-300 bg-white border border-solid border-gray-300 hover:border-primary rounded shadow-xl hover:shadow-none">
						<div class="p-5 px-5 pb-6">
							<div class="flex items-start justify-between gap-3 mb-5">
								<div class="inline-block p-1 bg-secondary border rounded border-slate-200">
									<a href="https://1.envato.market/LXBYPY" target="_blank">
										<img src="https://s3.envato.com/files/490407469/Thumbnail.png" alt="Thumbnail" class="max-w-[100px] rounded-sm" />
									</a>
								</div>
								<div class="text-right">
									<div class="flex gap-2 mb-2">
										<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
											Flat 40% Off
										</div>

										<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
											Elementor
										</div>
									</div>
									<div class="font-bold pricing">
										<del>$29</del> <sup class="font-bold text-[#0015B5] text-lg">$</sup> <span class="font-bold text-[#0015B5] text-4xl">17</span> <sub>/Lifetime</sub>
									</div>
								</div>
							</div>
							<h3 class="mt-3 mb-2 text-2xl leading-6 leading-8">
								<a target="_blank" class="no-underline text-font-color hover:text-[#0015B5] transition-all duration-300" href="https://1.envato.market/LXBYPY">Events Showcase For Elementor & Events Calendar</a>
							</h3>
							<p class="text-lg mt-0">
								“Eventful – Events Showcase for Elementor” is a user-friendly plugin offering Carousel and Grid layouts with five grid styles, enabling dynamic, stylish event displays that match any site’s design—no coding required for all skill levels.
							</p>
							<div class="flex gap-2 flex-wrap">
								<a target="_blank" href="https://wp-plugins.themeatelier.net/eventful/eventful-el-carousel/" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 bg-white rounded-full border-2 hover:!text-white ease-linear duration-300 inline-block border-solid border-[#0015B5] leading-6 hover:bg-[#0015B5] !text-[#0015B5]">Demo</a>
								<a target="_blank" href="https://1.envato.market/LXBYPY" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 rounded-3xl !text-white  ease-linear duration-300 inline-block !bg-[#0015B5] hover:!bg-[#000000]">Buy Now</a>
							</div>
						</div>
					</div>
					<!-- Single product end -->

					<!-- Single product start -->
					<div class="overflow-hidden transition-all duration-300 bg-white border border-solid border-gray-300 hover:border-primary rounded shadow-xl hover:shadow-none">
						<div class="p-5 px-5 pb-6">
							<div class="flex items-start justify-between gap-3 mb-5">
								<div class="inline-block p-1 bg-secondary border rounded border-slate-200">
									<a href="https://1.envato.market/essential-elementor" target="_blank">
										<img src="https://s3.envato.com/files/500778298/Thumbnail.png" alt="Thumbnail" class="max-w-[100px] rounded-sm" />
									</a>
								</div>
								<div class="text-right">
									<div class="flex gap-2 mb-2">
										<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
											Flat 30% Off
										</div>

										<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
											Bundle
										</div>
									</div>
									<div class="font-bold pricing">
										<del>$39</del> <sup class="font-bold text-[#93003A] text-lg">$</sup> <span class="font-bold text-[#93003A] text-4xl">27</span> <sub>/Lifetime</sub>
									</div>
								</div>
							</div>

							<h3 class="mt-3 mb-2 text-2xl leading-6 leading-8">
								<a target="_blank" class="no-underline text-font-color hover:text-[#93003A] transition-all duration-300" href="https://1.envato.market/essential-elementor">Essential Addons Bundle for Elementor Page Builder</a>
							</h3>
							<p class="text-lg mt-0">
								The "Essential Addons Bundle for Elementor" is a curated plugin collection crafted to enhance your WordPress experience, boosting site functionality, user engagement, and overall performance for website owners.
							</p>
							<div class="flex gap-2 flex-wrap">
								<a target="_blank" href="https://ta-demo-nu.vercel.app/essential-elementor" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 bg-white rounded-full border-2 hover:!text-white ease-linear duration-300 inline-block border-solid border-[#93003A] leading-6 hover:bg-[#93003A] !text-[#93003A]">Demo</a>
								<a target="_blank" href="https://1.envato.market/essential-elementor" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 rounded-3xl !text-white  ease-linear duration-300 inline-block !bg-[#93003A] hover:!bg-[#000000]">Buy Now</a>
							</div>
						</div>
					</div>
					<!-- Single product end -->

					<!-- Single product start -->
					<div class="overflow-hidden transition-all duration-300 bg-white border border-solid border-gray-300 hover:border-primary rounded shadow-xl hover:shadow-none">
						<div class="p-5 px-5 pb-6">
							<div class="flex items-start justify-between gap-3 mb-5">
								<div class="inline-block p-1 bg-secondary border rounded border-slate-200">
									<a href="https://1.envato.market/postify-for-elementor" target="_blank">
										<img src="https://s3.envato.com/files/489764066/Thumbnail.png" alt="Thumbnail" class="max-w-[100px] rounded-sm" />
									</a>
								</div>
								<div class="text-right">
									<div class="flex gap-2 mb-2">
										<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
											Flat 40% Off
										</div>

										<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
											Elementor
										</div>
									</div>
									<div class="mb-5 font-bold pricing">
										<del>$29</del> <sup class="font-bold text-[#03ABB0] text-lg">$</sup> <span class="font-bold text-[#03ABB0] text-4xl">17</span> <sub>/Lifetime</sub>
									</div>
								</div>
							</div>

							<h3 class="mt-3 mb-2 text-2xl leading-6 leading-8">
								<a target="_blank" class="no-underline text-font-color hover:text-[#03ABB0] transition-all duration-300" href="https://1.envato.market/postify-for-elementor">Smart Post Layout for Elementor</a>
							</h3>
							<p class="text-lg mt-0">
								Smart Post Layout for Elementor is a powerful plugin crafted for Elementor, showcasing blog posts elegantly. With two layouts (Carousel and Grid) and five themes, it enhances appeal, boosts views, and is optimized for fast loading.
							</p>

							<div class="flex gap-2 flex-wrap">
								<a target="_blank" href="https://wp-plugins.themeatelier.net/postify/postify-el-carousel/" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 bg-white rounded-full border-2 hover:!text-white ease-linear duration-300 inline-block border-solid border-[#03ABB0] leading-6 hover:bg-[#03ABB0] !text-[#03ABB0]">Demo</a>
								<a target="_blank" href="https://1.envato.market/postify-for-elementor" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 rounded-3xl !text-white  ease-linear duration-300 inline-block !bg-[#03ABB0] hover:!bg-[#000000]">Buy Now</a>
							</div>
						</div>
					</div>
					<!-- Single product end -->
				</div>
			</div>
		</section>

		<section id="html_js" class="py-12 bg-white lg:py-20">
			<div class="container">
				<div class="mb-12 text-center">
					<h2 class="mb-2 mt-0 text-ta-section-title">
						HTML & JavaScript Templates
					</h2>
					<p class="text-xl m-0">Kickstart your next project with our collection of responsive HTML and JavaScript templates. These templates are crafted for flexibility and high performance. Enjoy substantial savings on Black Friday!</p>
				</div>

				<div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
					<!-- Single product start -->
					<div class="overflow-hidden transition-all duration-300 border border-solid border-gray-300 hover:border-primary rounded shadow-xl bg-secondary hover:shadow-none">
						<div class="p-5 px-5 pb-6">
							<div class="flex items-start justify-between gap-3 mb-5">
								<div class="inline-block p-1 bg-white border rounded border-slate-200">
									<a href="https://1.envato.market/wonted" target="_blank">
										<img src="https://previews.customer.envatousercontent.com/files/397760666/Thumbnail.jpg" alt="Thumbnail" class="max-w-[100px] rounded-sm" />
									</a>
								</div>
								<div class="text-right">
									<div class="flex gap-2 mb-2">
										<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
											Flat 35% Off
										</div>

										<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
											HTML
										</div>
									</div>
									<div class="font-bold pricing">
										<del>$21</del> <sup class="font-bold text-[#c27b7f] text-lg">$</sup> <span class="font-bold text-[#c27b7f] text-4xl">13</span> <sub>/Lifetime</sub>
									</div>

								</div>
							</div>

							<h3 class="mt-3 mb-2 text-2xl leading-6 leading-8">
								<a target="_blank" class="no-underline text-font-color hover:text-[#c27b7f] transition-all duration-300" href="https://1.envato.market/wonted">Wonted - Book & Author Landing page</a>
							</h3>
							<p class="text-lg mt-0">
								A responsive, modern single-page template for authors, featuring 6 unique homepages and 50+ customizable components to showcase books, eBooks, audiobooks, podcasts, and portfolios, built with HTML5, CSS3, and Bootstrap.
							</p>
							<div class="flex gap-2 flex-wrap">
								<a target="_blank" href="https://ta-demo-nu.vercel.app/wonted" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 bg-white rounded-full border-2 hover:!text-white ease-linear duration-300 inline-block border-solid border-[#c27b7f] leading-6 hover:bg-[#c27b7f] !text-[#c27b7f]">Demo</a>
								<a target="_blank" href="https://1.envato.market/wonted" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 rounded-3xl !text-white  ease-linear duration-300 inline-block !bg-[#c27b7f] hover:!bg-[#000000]">Buy Now</a>
							</div>
						</div>
					</div>
					<!-- Single product end -->

					<!-- Single product start -->
					<div class="overflow-hidden transition-all duration-300 border border-solid border-gray-300 hover:border-primary rounded shadow-xl bg-secondary hover:shadow-none">
						<div class="p-5 px-5 pb-6">
							<div class="flex items-start justify-between gap-3 mb-5">
								<div class="inline-block p-1 bg-white border rounded border-slate-200">
									<a href="https://1.envato.market/jWP0qZ" target="_blank">
										<img src="https://s3.envato.com/files/424320673/Thumbnail.jpg" alt="Thumbnail" class="max-w-[100px] rounded-sm" />
									</a>
								</div>
								<div class="text-right">
									<div class="flex gap-2 mb-2">
										<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
											Flat 30% Off
										</div>

										<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
											JavaScript
										</div>
									</div>

									<div class="font-bold pricing">
										<del>$14</del> <sup class="font-bold text-[#148C7F] text-lg">$</sup> <span class="font-bold text-[#148C7F] text-4xl">9</span> <sub>/Lifetime</sub>
									</div>
								</div>

							</div>

							<h3 class="mt-3 mb-2 text-2xl leading-6 leading-8">
								<a target="_blank" class="no-underline text-font-color hover:text-[#148C7F] transition-all duration-300" href="https://1.envato.market/jWP0qZ">WhatsHelp - WhatsApp Help and Support for JavaScript</a>
							</h3>
							<p class="text-lg mt-0">
								WhatsHelp enables visitors to message you on WhatsApp in just three quick clicks for direct consultation. They can easily connect via the bubble or plugin buttons, turning website visits into valuable potential customers.
							</p>
							<div class="flex gap-2 flex-wrap">
								<a target="_blank" href="https://js-plugins.themeatelier.net/whtshelp/" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 bg-white rounded-full border-2 hover:!text-white ease-linear duration-300 inline-block border-solid border-[#148C7F] leading-6 hover:bg-[#148C7F] !text-[#148C7F]">Demo</a>
								<a target="_blank" href="https://1.envato.market/jWP0qZ" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 rounded-3xl !text-white  ease-linear duration-300 inline-block !bg-[#148C7F] hover:!bg-[#000000]">Buy Now</a>
							</div>
						</div>
					</div>
					<!-- Single product end -->


					<!-- Single product start -->
					<div class="overflow-hidden transition-all duration-300 border border-solid border-gray-300 hover:border-primary rounded shadow-xl bg-secondary hover:shadow-none">
						<div class="p-5 px-5 pb-6">
							<div class="flex items-start justify-between gap-3 mb-5">
								<div class="inline-block p-1 bg-white border rounded border-slate-200">
									<a href="https://1.envato.market/7m3oGd" target="_blank">
										<img src="https://s3.envato.com/files/435525132/Thumbnail.jpg" alt="Thumbnail" class="max-w-[100px] rounded-sm" />
									</a>
								</div>
								<div class="text-right">
									<div class="flex gap-2 mb-2">
										<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
											Flat 30% Off
										</div>
										<div class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
											JavaScript
										</div>
									</div>
									<div class="mb-5 font-bold pricing">
										<del>$14</del> <sup class="font-bold text-[#016189] text-lg">$</sup> <span class="font-bold text-[#016189] text-4xl">9</span> <sub>/Lifetime</sub>
									</div>
								</div>
							</div>

							<h3 class="mt-3 mb-2 text-2xl leading-6 leading-8">
								<a target="_blank" class="no-underline text-font-color hover:text-[#016189] transition-all duration-300" href="https://1.envato.market/7m3oGd">Ask - FAQ plugin with Video, Audio, Contact form support</a>
							</h3>
							<p class="text-lg mt-0">
								ASK is a modern and stylish FAQ plugin that offers both Tab and Accordion layouts. It supports text, audio, and video answers, helping audiences quickly find information and enhancing your site’s unique, contemporary appeal.
							</p>
							<div class="flex gap-2 flex-wrap">
								<a target="_blank" href="https://js-plugins.themeatelier.net/ask/index.html" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 bg-white rounded-full border-2 hover:!text-white ease-linear duration-300 inline-block border-solid border-[#016189] leading-6 hover:bg-[#016189] !text-[#016189]">Demo</a>
								<a target="_blank" href="https://1.envato.market/7m3oGd" class="text-base no-underline !py-1.5 lg:!py-2 px-4 lg:px-6 rounded-3xl !text-white  ease-linear duration-300 inline-block !bg-[#016189] hover:!bg-[#000000]">Buy Now</a>
							</div>
						</div>
					</div>
					<!-- Single product end -->
				</div>
			</div>
		</section>
		<?php
	}

	public function discount_admin_notice()
	{
		// Get the current user ID and screen information
		$user_id = get_current_user_id();
		$screen  = get_current_screen();

		// Generate URLs for dismiss action and discount page
		$dismiss_url = wp_nonce_url(
			add_query_arg('themeatelier_discount_dismissed', 'true'),
			'themeatelier_discount_dismissed_nonce',
			'nonce'
		);


		$discount_url =  add_query_arg( 'page', 'ta_discounts', admin_url( 'admin.php' ) );

		// Only show the notice if the user meta 'themeatelier_discount_dismissed' does not exist
		if (!get_user_meta($user_id, 'themeatelier_discount_dismissed', true) && 'whatsapp-chat_page_ta_discounts' !== $screen->base) {
		?>
			<div class="themeatelier_discount_page_header notice updated is-dismissible">
				<img src="<?php echo esc_url(plugins_url('assets/icons/black-friday.svg', __FILE__)); ?>">
				<div>
					<h3>Black Friday Bonanza on ThemeAtelier Premium Plugins!</h3>
					<p>This Black Friday, unlock the ultimate power for your projects with an exclusive 40% discount on our premium plugins! Elevate your WordPress game with cutting-edge features at the best price of the year. Don’t miss this once-a-year opportunity to supercharge your projects with unbeatable savings.</p>
					<a class="button" href="<?php echo esc_url($discount_url); ?>/#wp_plugins">Grab the Deal</a>
					<a href="<?php echo esc_url($dismiss_url); ?>" class="notice-dismiss"></a>
				</div>
			</div>
<?php
		}
	}


	public function discount_admin_notice_dismissed()
	{
		$user_id = get_current_user_id();

		// Check if the URL parameter is present and the nonce is valid
		if (! empty($_GET['themeatelier_discount_dismissed'])) {
			check_admin_referer('themeatelier_discount_dismissed_nonce', 'nonce');
			// Add user meta to prevent the notice from displaying again
			add_user_meta($user_id, 'themeatelier_discount_dismissed', 'true', true);
		}
	}
}
