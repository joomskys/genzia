<?php
/**
 * Functions and definitions
 *
 * @package CMS Theme
 * @subpackage Genzia
 * 
 */
//
remove_action('plugins_loaded', '_wp_add_additional_image_sizes', 0);
if (!function_exists('genzia_setup')):
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function genzia_setup()
	{
		// Make theme available for translation.
		load_theme_textdomain('genzia', get_template_directory() . '/languages');
		// Theme Support
		add_theme_support('post-thumbnails');
		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support(
			'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
				'navigation-widgets'
			]
		);
		add_theme_support(
			'custom-logo',
			[
				'height' => 100,
				'width' => 350,
				'flex-height' => true,
				'flex-width' => true,
			]
		);
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'primary' => esc_html__('Genzia Primary Menu', 'genzia')
		));
		/*
		 * WooCommerce.
		 */
		if (apply_filters('genzia_add_woocommerce_support', true)) {
			add_theme_support(
				'woocommerce',
				apply_filters('genzia_woocommerce_args', [])
			);
			//add_theme_support( 'wc-product-gallery-zoom' );
			if (!class_exists('\Elementor\Plugin')) {
				add_theme_support('wc-product-gallery-lightbox');
			}
			add_theme_support('wc-product-gallery-slider');
		}
	}
endif;
add_action('after_setup_theme', 'genzia_setup');

/**
 * Update Wordpress Configs
 * Change thumbnail size
 * Size list
 * https://developer.wordpress.org/reference/functions/add_image_size/#reserved-image-size-names
 * 
 * */
add_action('after_switch_theme', 'genzia_thumbnail_size');
if (!function_exists('genzia_thumbnail_size')) {
	function genzia_thumbnail_size()
	{
		/* Change default image thumbnail sizes in wordpress */
		$thumbnail_size = array(
			// Large
			'large_size_w' => 740,
			'large_size_h' => 514,
			'large_crop'   => 1,
			// Medium Large
			'medium_large_size_w' => 728,
			'medium_large_size_h' => 728,
			'medium_large_crop'   => 1,
			// Medium
			'medium_size_w' => 728,
			'medium_size_h' => 506,
			'medium_crop'   => 1,
			// thumbnail
			'thumbnail_size_w' => 80,
			'thumbnail_size_h' => 80,
			'thumbnail_crop'   => 1
		);
		foreach ($thumbnail_size as $option => $value) {
			if (get_option($option, '') != $value)
				update_option($option, $value);
		}
	}
}

// Remove 2X image size
add_action('init', 'genzia_remove_extra_image_sizes');
function genzia_remove_extra_image_sizes()
{
	$sizes = ['1536x1536', '2048x2048', 'trp-custom-language-flag'];
	foreach ($sizes as $size) {
		remove_image_size($size);
	}
}

/**
 *  Custom theme thumbnail size
 * https://developer.wordpress.org/reference/functions/add_image_size/#reserved-image-size-names
 * 
 **/
add_action('after_setup_theme', 'genzia_thumbnail_custom_sizes');
add_action('after_switch_theme', 'genzia_thumbnail_custom_sizes');
if (!function_exists('genzia_thumbnail_custom_sizes')) {
	function genzia_thumbnail_custom_sizes()
	{
		// Custom Thumbnail size
		//add_image_size('genzia_thumbnail_square', 100, 100, array( 'center', 'center' )); // use in EGrid Products Categories Filter
		// Custom size for single product
		//add_image_size('woocommerce_single_big', 700, 875, array( 'center', 'center' )); // use in single product Big Image
		//add_image_size('woocommerce_single_grid2', 620, 775, array( 'center', 'center' )); // use in single product Big Image
	}
}
/**
 *  Show custom size in list
 * https://developer.wordpress.org/reference/functions/add_image_size/#for-media-library-images-admin
 * 
 **/
add_filter('image_size_names_choose', 'genzia_image_size_names_choose');
function genzia_image_size_names_choose($sizes)
{
	return array_merge($sizes, array(
		'medium_large' => esc_html__('Medium Large', 'genzia'),
	));
}
// Primary Location
add_action('cms_locations', function ($cms_locations) {
	return $cms_locations;
});

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 */

function genzia_content_width(){
	$content_width = apply_filters('genzia_content_width', 760);
	$GLOBALS['content_width'] = $content_width;
	return $content_width;
}
add_action('after_setup_theme', 'genzia_content_width', 0);

/**
 * Enqueue scripts and styles.
 */
function genzia_scripts()
{
	$theme = wp_get_theme(get_template());
	$min = genzia_get_opt('dev_mode', '0') === '1' ? '' : '.min';
	$theme_css_dependentcy = [];
	if (class_exists('\Elementor\Plugin')) {
		$theme_css_dependentcy[] = 'elementor-frontend';
	}
	// Theme style
	wp_enqueue_style('genzia', get_template_directory_uri() . '/assets/css/theme' . $min . '.css', $theme_css_dependentcy, $theme->get('Version'));
	wp_add_inline_style('genzia', genzia_inline_styles());
	// WP Comment
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
	// modernizr
	wp_enqueue_script('modernizr', get_template_directory_uri() . '/assets/js/modernizr.js', [], '3.6.0', [
		'in_footer' => true,
		'strategy' => 'defer'
	]);

	/* Theme JS */
	wp_enqueue_script('genzia-main', get_template_directory_uri() . '/assets/js/main' . $min . '.js', array('jquery'), $theme->get('Version'), [
		'in_footer' => true,
		'strategy' => 'defer'
	]);
	wp_localize_script('genzia-main', 'main_data', [
		'ajax_url' => admin_url('admin-ajax.php'),
		'get_posts_action' => 'genzia_load_more_post_grid',
		'get_pagination_action' => 'genzia_get_pagination_html',
	]);

	/*
	 * Elementor Widget JS
	 */
	// Elementor Custom
	wp_register_script('cms-elementor-custom', get_template_directory_uri() . '/elementor/js/elementor-custom.js', ['jquery'], $theme->get('Version'), [
		'in_footer' => true,
		'strategy' => 'defer'
	]);
	// CMS Carousel
	wp_register_script('cms-post-carousel-widget-js', get_template_directory_uri() . '/elementor/js/cms-post-carousel-widget.js', ['jquery'], $theme->get('Version'), [
		'in_footer' => true,
		'strategy' => 'defer'
	]);
	wp_register_script('cms-carousel-mousewheel', get_template_directory_uri() . '/elementor/js/cms-carousel-mousewheel.js', ['jquery'], $theme->get('Version'), [
		'in_footer' => true,
		'strategy' => 'defer'
	]);
	wp_register_script('cms-carousel-vertical', get_template_directory_uri() . '/elementor/js/cms-carousel-vertical.js', ['jquery'], $theme->get('Version'), [
		'in_footer' => true,
		'strategy' => 'defer'
	]);
	// Galleries
	wp_register_script('cms-galleries', get_template_directory_uri() . '/elementor/js/cms-galleries.js', ['jquery'], $theme->get('Version'), [
		'in_footer' => true,
		'strategy' => 'defer'
	]);
	// Process
	wp_register_script('cms-process', get_template_directory_uri() . '/elementor/js/cms-process.js', ['jquery'], $theme->get('Version'), [
		'in_footer' => true,
		'strategy' => 'defer'
	]);
	// Switcher
	wp_register_script('cms-switcher', get_template_directory_uri() . '/elementor/js/cms-switcher.js', ['jquery'], $theme->get('Version'), [
		'in_footer' => true,
		'strategy' => 'defer'
	]);
	// Pointer
	wp_register_script('cms-pointer', get_template_directory_uri() . '/elementor/js/cms-pointer.js', ['jquery'], $theme->get('Version'), [
		'in_footer' => true,
		'strategy' => 'defer'
	]);
	// jquery-parallax-scroll-js
	wp_enqueue_script('jquery-parallax-scroll', get_template_directory_uri() . '/elementor/js/parallax-scroll/jquery.parallax-scroll.js', ['jquery'], $theme->get('Version'), [
		'in_footer' => true,
		'strategy' => 'defer'
	]);
	wp_register_script('cms-video-widget-js', get_template_directory_uri() . '/elementor/js/cms-video-widget.js', ['jquery'], $theme->get('Version'), [
		'in_footer' => true,
		'strategy' => 'defer'
	]);
	wp_register_script('cms-slider-video', get_template_directory_uri() . '/elementor/js/cms-slider-video.js', ['jquery'], '1.0.0', [
		'in_footer' => true,
		'strategy' => 'defer'
	]);
	// Mouse Move Parallax cms-parallax-mouse-move
	wp_register_script('cms-parallax-mouse-move', get_template_directory_uri() . '/elementor/js/cms-parallax-mouse-move.js', [], $theme->get('Version'), [
		'in_footer' => true,
		'strategy' => 'defer'
	]);
	if (!((!class_exists('CSH_Theme_Core') || !class_exists('\Elementor\Plugin')) || is_singular('cms-header-top') || is_singular('cms-footer') || is_singular('cms-mega-menu')) && 'internal' !== get_option('elementor_css_print_method')) {
		$header_top_layout = genzia_get_opts('header_top_layout', '', 'header_top_custom');
		if (!in_array($header_top_layout, ['-1', '0', 'none', ''])) {
			$header_post = get_post($header_top_layout);
			if (!is_wp_error($header_post) && $header_post->ID == $header_top_layout) {
				\Elementor\Core\Files\CSS\Post::create($header_post->ID)->enqueue();
			}
		}

		$footer_layout = genzia_get_opts('footer_layout', '1', 'footer_custom');
		if (in_array($footer_layout, ['-1', '0', '1', 'none']))
			return;
		$footer_post = get_post($footer_layout);
		if (!is_wp_error($footer_post) && $footer_post->ID == $footer_layout) {
			\Elementor\Core\Files\CSS\Post::create($footer_post->ID)->enqueue();
		}
	}

}
add_action('wp_enqueue_scripts', 'genzia_scripts');

/**
 * Theme Scripts
 * 
 */
function genzia_theme_scripts()
{
	$theme = wp_get_theme(get_template());
	// GSAP
	wp_register_script('gsap', get_template_directory_uri() . '/assets/theme/gsap/gsap.min.js', [], '3.12.5', true);
	// Scroll Sticky Grow Up
	wp_register_script('cms-scroll-sticky-grow-up', get_template_directory_uri() . '/elementor/js/cms-scroll-sticky-grow-up.js', ['jquery', 'etc-scroller'], $theme->get('Version'), true);
	// Scroll Sticky Horizontal
	wp_register_script( 'cms-scroll-sticky-horizontal', get_template_directory_uri() . '/elementor/js/cms-scroll-sticky-horizontal.js', [ 'jquery' ], $theme->get( 'Version' ), true );
}
add_action('wp_enqueue_scripts', 'genzia_theme_scripts');

/**
 * Default Font 
 * */
if (!function_exists('genzia_default_fonts')) {
	function genzia_default_fonts()
	{
		$body_font = str_replace(' ', '+', genzia_configs('body')['family']);
		$heading_font = str_replace(' ', '+', genzia_configs('heading')['family']);
		$special_font = str_replace(' ', '+', genzia_configs('special')['family']);

		$body_font_opts = genzia_get_opts('body_font', 'default');
		$heading_font_opts = genzia_get_opts('heading_font', 'default');
		$special_font_opts = genzia_get_opts('special_font', 'default');

		?>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<?php if ($body_font_opts == 'default') { ?>
			<link
				href="https://fonts.googleapis.com/css2?family=<?php echo esc_html($body_font); ?>:wght@200..800&display=swap"
				rel="stylesheet" media="all">
		<?php }
		if ($heading_font_opts == 'default') {
			?>
			<link
				href="https://fonts.googleapis.com/css2?family=<?php echo esc_html($heading_font); ?>:wght@300..800&display=swap"
				rel="stylesheet" media="all">
			<?php
		}
		if ($special_font_opts == 'default') {
			?>
			<link href="https://fonts.googleapis.com/css2?family=<?php echo esc_html($special_font); ?>&display=swap"
				rel="stylesheet" media="all">
			<?php
		}
	}
}
add_action('wp_head', 'genzia_default_fonts', 1);
/**
 * Widgets
 * Just show widgets if it enable via theme option
 * **/
function genzia_widgets()
{
	// Register Theme Sidebars
	if (class_exists('CSH_Theme_Core')) {
		register_sidebar([
			'name' => esc_html__('Blog Sidebar', 'genzia'),
			'id' => 'sidebar-post',
			'description' => esc_html__('Add widgets here to show in Blog archive page and single post page', 'genzia'),
			'class' => 'cms-post-type-widget',
			'before_widget' => '<div id="%1$s" class="cms-widget cms-blog-widget relative %2$s">',
			'after_widget' => '</div>',
		]);

		// WooCommerce Sidebar
		if (class_exists('WooCommerce')) {
			register_sidebar([
				'name' => esc_html__('Shop Sidebar', 'genzia'),
				'id' => 'sidebar-product',
				'description' => esc_html__('Add widgets here to show in WooCommerce archive and single product page', 'genzia'),
				'class' => 'cms-post-type-widget',
				'before_widget' => '<div id="%1$s" class="cms-widget cms-shop-widget %2$s">',
				'after_widget' => '</div>',
				//'before_title'  => '<h3 class="cms-wgtitle">',
				//'after_title'	=> '</h3>'
			]);
		}
	}
}
add_action('widgets_init', 'genzia_widgets', 11);
/* Disable Widgets Block Editor */
add_filter('use_widgets_block_editor', '__return_false');
/**
 * Change default widget title structure
 */
if (!function_exists('genzia_widgets_structure')) {
	add_filter('widget_display_callback', 'genzia_widgets_structure');
	add_filter('register_sidebar_defaults', 'genzia_widgets_structure');
	function genzia_widgets_structure($args)
	{
		$args = wp_parse_args($args, [
			'class' => '',
			'title_class' => ''
		]);
		$title_class = [
			'cms-wgtitle',
			isset($args['title_class']) ? $args['title_class'] : ''
		];
		$args['before_title'] = '<h3 class="' . implode(' ', array_filter($title_class)) . '">';
		$args['after_title'] = '</h3>';
		return $args;
	}
}
/**
 * Remove Some CSS
 * 
 */
if (!function_exists('etc_remove_scripts')) {
	add_action('wp_enqueue_scripts', 'etc_remove_scripts', 999);
	add_action('wp_footer', 'etc_remove_styles', 999);
	add_action('wp_header', 'etc_remove_styles', 999);
	function etc_remove_scripts()
	{
		$default = ['isotope'];
		$scripts = apply_filters('etc_remove_scripts', $default);
		foreach ($scripts as $script) {
			wp_dequeue_script($script);
			//wp_genzia_deregister_script( $script );
		}
	}
}
if (!function_exists('etc_remove_styles')) {
	add_action('wp_enqueue_scripts', 'etc_remove_styles', 999);
	add_action('wp_footer', 'etc_remove_styles', 999);
	add_action('wp_header', 'etc_remove_styles', 999);
	function etc_remove_styles()
	{
		$default = ['gglcptch', 'isotope'];
		$styles = apply_filters('etc_remove_styles', $default);
		foreach ($styles as $style) {
			wp_dequeue_style($style);
			//wp_genzia_deregister_style( $style );
		}
	}
}
if (!function_exists('genzia_remove_styles')) {
	add_filter('etc_remove_styles', 'genzia_remove_styles');
	function genzia_remove_styles($styles)
	{
		$_styles = [
			// newsletter
			'newsletter',
			// elementor
			'elementor-frontend-legacy',
			// woo
			'woocommerce-smallscreen',
			'woocommerce-general',
			'woocommerce-layout',
			'wc-blocks-vendors-style',
			'wc-blocks-style',
			// theme core
			'oc-css',
			'etc-main-css',
			'progressbar-lib-css',
			'slick-css',
			'tco-main-css',
			// language switcher
			//'trp-floater-language-switcher-style',
			//'trp-language-switcher-style',
			// csh login
			//'widget_style',
			//'cshlg_layout_1',
			// WPC Smart Wishlist
			//'woosw-frontend',
			// WPC Smart Quick View
			//'woosq-frontend',
			// WPC Badge Management
			//'wpcbm-frontend',
			// WPC Variations Swatches
			//'wpcvs-frontend',
			// WPC Product Size Chart
			//'wpcsc-frontend'
		];
		$styles = array_merge($styles, $_styles);
		return $styles;
	}
}

/**
 *  Add admin styles 
 * 
 * */
function genzia_admin_style()
{
	$theme = wp_get_theme(get_template());
	//admin
	wp_enqueue_style('genzia-admin-style', get_template_directory_uri() . '/assets/admin/admin.css');
	// import demo
	wp_enqueue_style('genzia-get-started-css', get_template_directory_uri() . '/assets/admin/get-started.css');
	wp_enqueue_script('genzia-get-started-js', get_template_directory_uri() . '/assets/admin/get-started.js', ['jquery'], $theme->get('Version'), true);
	wp_localize_script('genzia-get-started-js', 'main_data', array('ajax_url' => admin_url('admin-ajax.php')));
	// Widget Gallery
	wp_enqueue_script('cms-media-gallery-widget', get_template_directory_uri() . '/assets/admin/media-gallery-widget.js', array('media-widgets'));
	// Widget CTA
	//wp_enqueue_script('cms-media-image-widget', get_template_directory_uri() . '/assets/admin/media-image-widget.js', array( 'media-widgets' ) );
}
add_action('admin_enqueue_scripts', 'genzia_admin_style');

/**
 * Check if is build with Elementor
 * 
 * **/
if (!function_exists('genzia_is_built_with_elementor')) {
	function genzia_is_built_with_elementor()
	{
		if (cms_is_blog() || is_404())
			return false;
		if (class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor()) {
			return true;
		} else {
			return false;
		}
	}
}
/**
 * Check if is Elementor preview mode
 * 
 * **/
if (!function_exists('genzia_is_elementor_preview_mode')) {
	function genzia_is_elementor_preview_mode()
	{
		if (!class_exists('\Elementor\Plugin'))
			return false;
		return \Elementor\Plugin::$instance->preview->is_preview_mode();
	}
}

/**
 * Custom Elementor Editor
 * */
add_action('elementor/editor/before_enqueue_scripts', function () {
	wp_enqueue_style('genzia-elementor-custom-editor', get_template_directory_uri() . '/assets/admin/elementor-panel.css', array(), '1.0.0');
});
add_action('elementor/preview/enqueue_styles', function () {
	wp_enqueue_style('genzia-elementor-custom-editor', get_template_directory_uri() . '/assets/admin/elementor-panel.css', array(), '1.0.0');
	wp_enqueue_style('genzia-elementor-custom-editor', get_template_directory_uri() . '/assets/admin/elementor-preview.css', array(), '1.0.0');
});
/**
 * Custom template tags for this theme.
 * 
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Theme Functions
 */
require_once get_template_directory() . '/inc/theme-functions.php';

/**
 * Breadcrumb.
 */
require_once get_template_directory() . '/inc/classes/class-breadcrumb.php';

/**
 * Add Template Woocommerce
 */
add_filter('is_woocommerce', 'genzia__is_woocommerce');
function genzia__is_woocommerce()
{
	if (class_exists('WooCommerce') && (is_product_taxonomy() || is_product())) {
		return true;
	}
	return false;
}
if (!function_exists('genzia_is_woocommerce')) {
	function genzia_is_woocommerce()
	{
		if (class_exists('WooCommerce') && (is_woocommerce() || is_shop() || is_cart() || is_checkout() || is_account_page() || is_singular('product'))) {
			return true;
		}
		return false;
	}
}
if (!function_exists('genzia_is_shop')) {
	function genzia_is_shop()
	{
		if (class_exists('WooCommerce') && (is_shop())) {
			return true;
		}
		return false;
	}
}
if (class_exists('WooCommerce')) {
	require_once(get_template_directory() . '/woocommerce/wc-function-hooks.php');
}
/**
 * Contact Form 7
 * */
if (class_exists('WPCF7')) {
	require_once(get_template_directory() . '/inc/extensions/cf7.php');
}
/**
 * Contact Form 7
 * Remove auto p
 * */
add_filter('wpcf7_autop_or_not', '__return_false');
/**
 * Translate Presss
 * */
if (class_exists('TRP_Translate_Press')) {
	require_once(get_template_directory() . '/inc/extensions/translatepress.php');
}
/**
 * FOX - WooCommerce Currency Swithcher
 * 
 * */
if (class_exists('WOOCS_STARTER')) {
	require_once(get_template_directory() . '/inc/extensions/woocs.php');
}
/**
 * Theme Options
 */
require get_template_directory() . '/inc/theme-options/theme-options.php';

/**
 * Post Type Options
 */
// Page Options
require get_template_directory() . '/inc/post-type-options/page-options.php';
// Single Portfolio Options
require get_template_directory() . '/inc/post-type-options/portfolio-options.php';
// Single Product Options
require get_template_directory() . '/inc/post-type-options/product-options.php';

/**
 * CSS Generator.
 */
if (!class_exists('CSS_Generator')) {
	require_once get_template_directory() . '/inc/classes/class-css-generator.php';
}

/**
 * Enable Custom Post type
 * 
 * **/
// Portfolio
add_filter('genzia_enable_portfolio', 'genzia_enable_portfolio');
if (!function_exists('genzia_enable_portfolio')) {
	function genzia_enable_portfolio()
	{
		return true;
	}
}
// Service
add_filter('genzia_enable_service', 'genzia_enable_service');
if (!function_exists('genzia_enable_service')) {
	function genzia_enable_service()
	{
		return true;
	}
}
// Header Top
add_filter('genzia_enable_header_top', 'genzia_enable_header_top');
if (!function_exists('genzia_enable_header_top')) {
	function genzia_enable_header_top()
	{
		return true;
	}
}
// Footer
add_filter('genzia_enable_footer', 'genzia_enable_footer');
if (!function_exists('genzia_enable_footer')) {
	function genzia_enable_footer()
	{
		return true;
	}
}
// Side Navigation
add_filter('genzia_enable_sidenav', 'genzia_enable_sidenav');
if (!function_exists('genzia_enable_sidenav')) {
	function genzia_enable_sidenav()
	{
		return true;
	}
}
// Pop Up
add_filter('genzia_enable_popup', 'genzia_enable_popup');
if (!function_exists('genzia_enable_popup')) {
	function genzia_enable_popup()
	{
		return true;
	}
}
/**
 * Enable mega menu
 **/
add_filter('cms_enable_megamenu', 'genzia_enable_megamenu');
if (!function_exists('genzia_enable_megamenu')) {
	function genzia_enable_megamenu()
	{
		return true;
	}
}
/**
 * Mega menu Full Width
 * 
 * */
add_filter('cms_enable_megamenu_full_width', 'genzia_enable_megamenu_full_width');
if (!function_exists('genzia_enable_megamenu_full_width')) {
	function genzia_enable_megamenu_full_width()
	{
		return true;
	}
}
add_filter('megamenu_full_width_opts', 'genzia_megamenu_full_width_opts');
if (!function_exists('genzia_megamenu_full_width_opts')) {
	function genzia_megamenu_full_width_opts($opts)
	{
		$opts[] = [
			'name' => 'container',
			'title' => esc_html__('Container', 'genzia')
		];
		return $opts;
	}
}
/* Enable onepage */
add_filter('cms_enable_onepage', 'genzia_enable_onepage');
if (!function_exists('genzia_enable_onepage')) {
	function genzia_enable_onepage()
	{
		return false;
	}
}
/*
 * Get Started
 */
if (is_admin()) {
	require_once get_template_directory() . '/inc/get-started.php';
}

/**
 * Register block styles.
 * 
 */
//add_action( 'init', 'genzia_block_styles' );
if (!function_exists('genzia_block_styles')):
	/**
	 * Register custom block styles
	 *
	 * @since Genzia 1.0
	 * @return void
	 */
	function genzia_block_styles()
	{
		register_block_style(
			'core/genzia',
			array(
				'name' => 'arrow-icon-genzia',
				'label' => __('Arrow icon', 'genzia')
			)
		);
	}
endif;

/**
 * Register pattern categories.
 */
//add_action( 'init', 'genzia_pattern_categories' );
if (!function_exists('genzia_pattern_categories')):
	/**
	 * Register pattern categories
	 *
	 * @since 1.0
	 * @return void
	 */
	function genzia_pattern_categories()
	{
		register_block_pattern_category(
			'genzia_page',
			array(
				'label' => _x('Pages', 'Block pattern category', 'genzia'),
				'description' => __('A collection of full page layouts.', 'genzia'),
			)
		);
	}
endif;

/**
 * Registers an editor stylesheet for the theme.
 */
//add_action( 'admin_init', 'genzia_theme_add_editor_styles' );
function genzia_theme_add_editor_styles()
{
	add_editor_style('custom-editor-style.css');
}

/**
 * Guten Block
 * 
 * */
//add_action( 'after_setup_theme', 'genzia_setup_gutenblocks' );
if (!function_exists('genzia_setup_gutenblocks')):
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function genzia_setup_gutenblocks()
	{
		/**
		 * Gutenberg
		 * Block 
		 * */
		add_theme_support("wp-block-styles");
		add_theme_support("responsive-embeds");
		add_theme_support("align-wide");
		add_theme_support("custom-header", []);
		add_theme_support("custom-background", []);
	}
endif;

/**
 *  Enable Upload SVG
 *
 */
add_filter('upload_genzia_mimes', 'genzia_mime_types');
function genzia_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
}

if (class_exists('Elementor\Plugin')) {
	require_once get_template_directory() . '/elementor/core/elementor.php';

	// Register new category for Elementor
	function genzia_elementor_category($elements_manager)
	{
		$elements_manager->add_category(
			'genzia-widgets',
			[
				'title' => esc_html__('Genzia', 'genzia'),
				'icon' => 'fa fa-plug',
			]
		);
	}
	add_action('elementor/elements/categories_registered', 'genzia_elementor_category');

	function genzia_elementor_register_widgets($widgets_manager)
	{
		require_once get_template_directory() . '/elementor/core/widget-base.php';
		// 01 Accordion
		require_once get_template_directory() . '/elementor/core/widgets/cms_accordion.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Accordion());
		// 02 Banner
		require_once get_template_directory() . '/elementor/core/widgets/cms_banner.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Banner());
		// 03 Client
		require_once get_template_directory() . '/elementor/core/widgets/cms_clients.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Clients());
		// 04 Copyright
		require_once get_template_directory() . '/elementor/core/widgets/cms_copyright.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Copyright());
		// 05 Counter
		require_once get_template_directory() . '/elementor/core/widgets/cms_counter.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Counter());
		// 06 Call to Action
		require_once get_template_directory() . '/elementor/core/widgets/cms_cta.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Cta());
		// 07 Google Map
		require_once get_template_directory() . '/elementor/core/widgets/cms_google_map.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Google_Map());
		// 08 Heading
		require_once get_template_directory() . '/elementor/core/widgets/cms_heading.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Heading());
		// 09 Navigation Menu
		require_once get_template_directory() . '/elementor/core/widgets/cms_navigation_menu.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Navigation_Menu());
		// 10 Page Title
		require_once get_template_directory() . '/elementor/core/widgets/cms_page_title.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Page_Title());
		// 11 Post Carousel
		require_once get_template_directory() . '/elementor/core/widgets/cms_posts_carousel.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Posts_Carousel());
		// 12 Post Grid
		require_once get_template_directory() . '/elementor/core/widgets/cms_posts_grid.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Posts_Grid());
		// 13 Pricing
		require_once get_template_directory() . '/elementor/core/widgets/cms_pricing.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Pricing());
		// 14 Process
		require_once get_template_directory() . '/elementor/core/widgets/cms_process.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Process());
		// 15 Quick Contact
		require_once get_template_directory() . '/elementor/core/widgets/cms_quickcontact.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Quick_Contact());
		// 16 Slider
		require_once get_template_directory() . '/elementor/core/widgets/cms_slider.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Sliders());
		// 17 Social Icons
		require_once get_template_directory() . '/elementor/core/widgets/cms_social_icons.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Social_Icons());
		// 18 Tabs
		require_once get_template_directory() . '/elementor/core/widgets/cms_tabs.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Tabs());
		// 19 Teams
		require_once get_template_directory() . '/elementor/core/widgets/cms_teams.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Teams());
		// 20 Testimonial
		require_once get_template_directory() . '/elementor/core/widgets/cms_testimonials.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Testimonials());
		// 21 Text Scroll
		require_once get_template_directory() . '/elementor/core/widgets/cms_text_scroll.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Text_Scroll());
		// 22 Video
		require_once get_template_directory() . '/elementor/core/widgets/cms_video_player.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Video_Player());
		// 23
		if (class_exists('WPCF7')) {
			require_once get_template_directory() . '/elementor/core/widgets/cms_contact_form.php';
			$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Contact_Form());
		}
		// 24
		if (class_exists('Newsletter')) {
			require_once get_template_directory() . '/elementor/core/widgets/cms_newsletter.php';
			$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Newsletter());
		}
		// 25
		if (class_exists('TRP_Translate_Press')) {
			require_once get_template_directory() . '/elementor/core/widgets/cms_language_switcher.php';
			$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Language_Switcher());
		}
		// 26
		if (class_exists('WooCommerce')) {
			// WooCommerce
			require_once get_template_directory() . '/elementor/core/widgets/cms_products.php';
			$widgets_manager->register(new \Genzia\Elementor\Widgets\CMS_Widget_Products());
		}
		// 27
		require_once get_template_directory() . '/elementor/core/widgets/cms_theme_scroll_sticky_grow_up.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Theme_Scroll_Sticky_Grow_Up());
		// 28
		require_once get_template_directory() . '/elementor/core/widgets/cms_theme_feature.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Genzia_Feature());
		// 29
		require_once get_template_directory() . '/elementor/core/widgets/cms_theme_posts_scroll_grow.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Genzia_Posts_Scroll_Grow());
		// 30
		require_once get_template_directory() . '/elementor/core/widgets/cms_theme_separator.php';
		$widgets_manager->register(new \Genzia\Elementor\Widgets\Widget_Genzia_Separator());
		
	}
	add_action('elementor/widgets/register', 'genzia_elementor_register_widgets');
}