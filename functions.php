<?php

// theme textdomain - must be loaded before redux
load_theme_textdomain( 'shopkeeper', get_template_directory() . '/languages' );
define( 'GETBOWTIED_VISUAL_COMPOSER_IS_ACTIVE', defined( 		'WPB_VC_VERSION' ) );

/******************************************************************************/
/***************************** Theme Options **********************************/
/******************************************************************************/

if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/settings/redux/ReduxCore/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/settings/redux/ReduxCore/framework.php' );
}
if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/settings/shopkeeper.config.php' ) ) {
    require_once( dirname( __FILE__ ) . '/settings/shopkeeper.config.php' );
}

global $shopkeeper_theme_options;


/******************************************************************************/
/******************************** Includes ************************************/
/******************************************************************************/

require_once('inc/helpers/helpers.php');

if ( is_admin() ) 
{
	if ( ! class_exists('Getbowtied_Admin_Pages') )
	{
		require_once( get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php' );
		require_once( get_template_directory() . '/inc/tgm/plugins.php' );
	}
}

//Include Custom Posts
require('inc/custom-posts/portfolio.php');


include('inc/custom-styles/custom-styles.php'); // Load Custom Styles
include('inc/templates/post-meta.php'); // Load Post meta template
include('inc/templates/template-tags.php'); // Load Template Tags
include('inc/widgets/social-media.php'); // Load Widget Social Media


//Include Shortcodes
include('inc/shortcodes/product-categories.php');
include('inc/shortcodes/socials.php');
include('inc/shortcodes/from-the-blog.php');
include('inc/shortcodes/google-map.php');
include('inc/shortcodes/banner.php');
include('inc/shortcodes/icon-box.php');
include('inc/shortcodes/portfolio.php');
include('inc/shortcodes/add-to-cart.php');
include('inc/shortcodes/wc-mod-product.php');
include('inc/shortcodes/slider.php');


//Include Metaboxes
include_once('inc/metaboxes/page.php');
include_once('inc/metaboxes/post.php');
include_once('inc/metaboxes/portfolio.php');
include_once('inc/metaboxes/product.php');


//Custom Menu
include_once('inc/custom-menu/custom-menu.php');


//Quick View
include_once('inc/woocommerce/quick_view.php');

//Product Layout
include_once('inc/woocommerce/product-layout.php');


//Theme welcome page
if (is_admin()):
	include_once('inc/admin/admin.php');
endif;


/******************************************************************************/
/*************************** Visual Composer **********************************/
/******************************************************************************/

if (class_exists('WPBakeryVisualComposerAbstract')) {
	
	add_action( 'init', 'visual_composer_stuff' );
	function visual_composer_stuff() {
		
		//disable update
		// Vc_Manager::getInstance()->disableUpdater(true);

		
		//enable vc on post types
		if(function_exists('vc_set_default_editor_post_types')) vc_set_default_editor_post_types( array('post','page','product','portfolio') );
		
		// Modify and remove existing shortcodes from VC
		include_once('inc/shortcodes/visual-composer/custom_vc.php');
		
		// VC Templates
		$vc_templates_dir = get_template_directory() . '/inc/shortcodes/visual-composer/vc_templates/';
		vc_set_shortcodes_templates_dir($vc_templates_dir);
		
		// Add new shortcodes to VC
		include_once('inc/shortcodes/visual-composer/from-the-blog.php');
		include_once('inc/shortcodes/visual-composer/social-media-profiles.php');
		include_once('inc/shortcodes/visual-composer/google-map.php');
		include_once(locate_template('inc/shortcodes/visual-composer/banner.php'));
		include_once('inc/shortcodes/visual-composer/icon-box.php');
		include_once('inc/shortcodes/visual-composer/portfolio.php');
		include_once(locate_template('inc/shortcodes/visual-composer/slider.php'));
		
		// Add new Shop shortcodes to VC
		if (class_exists('WooCommerce')) {
			// include_once('inc/shortcodes/visual-composer/wc-recent-products.php');
			// include_once('inc/shortcodes/visual-composer/wc-featured-products.php');
			// include_once('inc/shortcodes/visual-composer/wc-products-by-category.php');
			// include_once('inc/shortcodes/visual-composer/wc-products-by-attribute.php');
			// include_once('inc/shortcodes/visual-composer/wc-product-by-id-sku.php');
			// include_once('inc/shortcodes/visual-composer/wc-products-by-ids-skus.php');
			// include_once('inc/shortcodes/visual-composer/wc-sale-products.php');
			// include_once('inc/shortcodes/visual-composer/wc-top-rated-products.php');
			// include_once('inc/shortcodes/visual-composer/wc-best-selling-products.php');
			// include_once('inc/shortcodes/visual-composer/wc-add-to-cart-button.php');
			// include_once('inc/shortcodes/visual-composer/wc-product-categories.php');
			include_once('inc/shortcodes/visual-composer/wc-product-categories-grid.php');
		}
		
		// Remove vc_teaser
		if (is_admin()) :
			function remove_vc_teaser() {
				remove_meta_box('vc_teaser', '' , 'side');
			}
			add_action( 'admin_head', 'remove_vc_teaser' );
		endif;
	
	}

}

add_action( 'vc_before_init', 'shopkeeper_vcSetAsTheme' );
function shopkeeper_vcSetAsTheme() {
    vc_manager()->disableUpdater(true);
	vc_set_as_theme();
}


/******************************************************************************/
/****************************** Ajax url **************************************/
/******************************************************************************/

add_action('wp_head','shopkeeper_ajaxurl');
function shopkeeper_ajaxurl() {
?>
    <script type="text/javascript">
        var shopkeeper_ajaxurl = '<?php echo admin_url('admin-ajax.php', 'relative'); ?>';
    </script>
<?php
}


//==============================================================================
// Localize dynamic add to cart message
//==============================================================================
add_action('wp_head','shopkeeper_dynamic_added_to_cart_message');
function shopkeeper_dynamic_added_to_cart_message() {
?>
	<script type="text/javascript">
		var addedToCartMessage = "<?php printf( esc_html__( '%s has been added to your cart.', 'woocommerce' ), '' ); ?>";
	</script>
<?php 
}


/******************************************************************************/
/*********************** shopkeeper setup *************************************/
/******************************************************************************/


if ( ! function_exists( 'shopkeeper_setup' ) ) :
function shopkeeper_setup() {
	
	global $shopkeeper_theme_options;

	// frontend presets
	if (isset($_GET["preset"])) { 
		$preset = $_GET["preset"];
	} else {
		$preset = "";
	}

	if ($preset != "") {
		if ( file_exists( dirname( __FILE__ ) . '/_presets/'.$preset.'.json' ) ) {
		$theme_options_json = file_get_contents( dirname( __FILE__ ) . '/_presets/'.$preset.'.json' );
		$shopkeeper_theme_options = json_decode($theme_options_json, true);
		}
	}
	
	/** Theme support **/
	add_theme_support( 'title-tag' );
	add_theme_support( 'menus' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce');
	function custom_header_custom_bg() {
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );
	}
   	
	add_post_type_support('page', 'excerpt');
	
	
	/** Add Image Sizes **/
	$shop_catalog_image_size = get_option( 'shop_catalog_image_size' );
	$shop_single_image_size = get_option( 'shop_single_image_size' );
	add_image_size('product_small_thumbnail', (int)$shop_catalog_image_size['width']/3, (int)$shop_catalog_image_size['height']/3, isset($shop_catalog_image_size['crop']) ? true : false); // made from shop_catalog_image_size
	add_image_size('shop_single_small_thumbnail', (int)$shop_single_image_size['width']/3, (int)$shop_single_image_size['height']/3, isset($shop_catalog_image_size['crop']) ? true : false); // made from shop_single_image_size
	add_image_size( 'blog-isotope', 620, 500, true ); 
	
	/** Register menus **/	
	register_nav_menus( array(
		'top-bar-navigation' => __( 'Top Bar Navigation', 'shopkeeper' ),
		'main-navigation' => __( 'Main Navigation', 'shopkeeper' ),
		'footer-navigation' => __( 'Footer Navigation', 'shopkeeper' ),
	) );
	
	if ( (isset($shopkeeper_theme_options['main_header_off_canvas'])) && (trim($shopkeeper_theme_options['main_header_off_canvas']) == "1" ) ) {
		register_nav_menus( array(
			'secondary_navigation' => __( 'Secondary Navigation (Off-Canvas)', 'shopkeeper' ),
		) );
	}
	
	if ( (isset($shopkeeper_theme_options['main_header_layout'])) && ( $shopkeeper_theme_options['main_header_layout'] == "2" || $shopkeeper_theme_options['main_header_layout'] == "22" ) ) {
		register_nav_menus( array(
			'centered_header_left_navigation' => __( 'Centered Header - Left Navigation', 'shopkeeper' ),
			'centered_header_right_navigation' => __( 'Centered Header - Right Navigation', 'shopkeeper' ),
		) );
	}
	
	/** WooCommerce Number of products displayed per page **/	
	if ( (isset($shopkeeper_theme_options['products_per_page'])) ) {
		add_filter( 'loop_shop_per_page', create_function( '$cols', 'return ' . $shopkeeper_theme_options['products_per_page'] . ';' ), 20 );
	}

	/******************************************************************************/
	/* WooCommerce remove review tab **********************************************/
	/******************************************************************************/
	if ( (isset($shopkeeper_theme_options['review_tab'])) && ($shopkeeper_theme_options['review_tab'] == "0" ) ) {
	add_filter( 'woocommerce_product_tabs', 'shopkeeper_remove_reviews_tab', 98);
		function shopkeeper_remove_reviews_tab($tabs) {
			unset($tabs['reviews']);
			return $tabs;
		}
	}
}
endif; // shopkeeper_setup
add_action( 'after_setup_theme', 'shopkeeper_setup' );

/******************************************************************************/
/**************************** Enqueue styles **********************************/
/******************************************************************************/

// frontend
function shopkeeper_styles() {
	
	global $shopkeeper_theme_options;

	if ( (isset($shopkeeper_theme_options['smooth_transition_between_pages'])) && ($shopkeeper_theme_options['smooth_transition_between_pages'] == "1" ) ) {
		wp_enqueue_style('shopkeeper-page-in-out', get_template_directory_uri() . '/css/page-in-out.css', NULL, getbowtied_theme_version(), 'all' );
	}
	wp_enqueue_style('shopkeeper-styles', get_template_directory_uri() . '/css/styles.css', NULL, getbowtied_theme_version(), 'all' );

	wp_enqueue_style('shopkeeper-icon-font', get_template_directory_uri() . '/inc/fonts/shopkeeper-icon-font/style.css', NULL, getbowtied_theme_version(), 'all' );	
	
	wp_enqueue_style('shopkeeper-font-awesome', get_template_directory_uri() . '/inc/fonts/font-awesome/css/font-awesome.min.css', NULL, '4.6.3', 'all' );
	wp_enqueue_style('shopkeeper-font-linea-arrows', get_template_directory_uri() . '/inc/fonts/linea-fonts/arrows/styles.css', NULL, getbowtied_theme_version(), 'all' );
	wp_enqueue_style('shopkeeper-font-linea-basic', get_template_directory_uri() . '/inc/fonts/linea-fonts/basic/styles.css', NULL, getbowtied_theme_version(), 'all' );
	wp_enqueue_style('shopkeeper-font-linea-basic_elaboration', get_template_directory_uri() . '/inc/fonts/linea-fonts/basic_elaboration/styles.css', NULL, getbowtied_theme_version(), 'all' );
	wp_enqueue_style('shopkeeper-font-linea-ecommerce', get_template_directory_uri() . '/inc/fonts/linea-fonts/ecommerce/styles.css', NULL, getbowtied_theme_version(), 'all' );
	wp_enqueue_style('shopkeeper-font-linea-music', get_template_directory_uri() . '/inc/fonts/linea-fonts/music/styles.css', NULL, getbowtied_theme_version(), 'all' );
	wp_enqueue_style('shopkeeper-font-linea-software', get_template_directory_uri() . '/inc/fonts/linea-fonts/software/styles.css', NULL, getbowtied_theme_version(), 'all' );
	wp_enqueue_style('shopkeeper-font-linea-weather', get_template_directory_uri() . '/inc/fonts/linea-fonts/weather/styles.css', NULL, getbowtied_theme_version(), 'all' );	
	
	wp_enqueue_style('shopkeeper-fresco', get_template_directory_uri() . '/css/fresco/fresco.css', NULL, '1.3.0', 'all' );	
	
	if ( isset($shopkeeper_theme_options['main_header_layout']) ) {		
		if ( $shopkeeper_theme_options['main_header_layout'] == "1" || $shopkeeper_theme_options['main_header_layout'] == "11" ) {
			wp_enqueue_style('shopkeeper-header-default', get_template_directory_uri() . '/css/header-default.css', NULL, getbowtied_theme_version(), 'all' );
		} 		
		elseif ( $shopkeeper_theme_options['main_header_layout'] == "2" || $shopkeeper_theme_options['main_header_layout'] == "22" ) {
			wp_enqueue_style('shopkeeper-header-centered-2menus', get_template_directory_uri() . '/css/header-centered-2menus.css', NULL, getbowtied_theme_version(), 'all' );
		}
		elseif ( $shopkeeper_theme_options['main_header_layout'] == "3" ) {
			wp_enqueue_style('shopkeeper-header-centered-menu-under', get_template_directory_uri() . '/css/header-centered-menu-under.css', NULL, getbowtied_theme_version(), 'all' );
		} 		
	}		
	else {	
		wp_enqueue_style('shopkeeper-header-default', get_template_directory_uri() . '/css/header-default.css', NULL, getbowtied_theme_version(), 'all' );	
	}
	
	wp_enqueue_style('shopkeeper-default-style', get_stylesheet_uri());

}
add_action( 'wp_enqueue_scripts', 'shopkeeper_styles', 99 );



// admin area
function shopkeeper_admin_styles() {
    if ( is_admin() ) {
        
		wp_enqueue_style("wp-color-picker");
		wp_enqueue_style("shopkeeper_admin_styles", get_template_directory_uri() . "/css/wp-admin-custom.css", false, getbowtied_theme_version(), "all");
		
		if (class_exists('WPBakeryVisualComposerAbstract')) { 
			wp_enqueue_style('shopkeeper_visual_composer', get_template_directory_uri() .'/css/visual-composer.css', false, getbowtied_theme_version(), 'all');
			wp_enqueue_style('shopkeeper-font-linea-arrows', get_template_directory_uri() . '/inc/fonts/linea-fonts/arrows/styles.css', false, getbowtied_theme_version(), 'all' );
			wp_enqueue_style('shopkeeper-font-linea-basic', get_template_directory_uri() . '/inc/fonts/linea-fonts/basic/styles.css', false, getbowtied_theme_version(), 'all' );
			wp_enqueue_style('shopkeeper-font-linea-basic_elaboration', get_template_directory_uri() . '/inc/fonts/linea-fonts/basic_elaboration/styles.css', false, getbowtied_theme_version(), 'all' );
			wp_enqueue_style('shopkeeper-font-linea-ecommerce', get_template_directory_uri() . '/inc/fonts/linea-fonts/ecommerce/styles.css', false, getbowtied_theme_version(), 'all' );
			wp_enqueue_style('shopkeeper-font-linea-music', get_template_directory_uri() . '/inc/fonts/linea-fonts/music/styles.css', false, getbowtied_theme_version(), 'all' );
			wp_enqueue_style('shopkeeper-font-linea-software', get_template_directory_uri() . '/inc/fonts/linea-fonts/software/styles.css', false, getbowtied_theme_version(), 'all' );
			wp_enqueue_style('shopkeeper-font-linea-weather', get_template_directory_uri() . '/inc/fonts/linea-fonts/weather/styles.css', false, getbowtied_theme_version(), 'all' );
		}
    }
}
add_action( 'admin_enqueue_scripts', 'shopkeeper_admin_styles' );







/******************************************************************************/
/*************************** Enqueue scripts **********************************/
/******************************************************************************/

// frontend

function shopkeeper_scripts_header_priority_0() {

	global $shopkeeper_theme_options;

	if ( (isset($shopkeeper_theme_options['smooth_transition_between_pages'])) && ($shopkeeper_theme_options['smooth_transition_between_pages'] == "1" ) ) {
		wp_enqueue_script('shopkeeper-nprogress', get_template_directory_uri() . '/js/components/nprogress.js', NULL, getbowtied_theme_version(), FALSE);
		wp_enqueue_script('shopkeeper-page-in-out', get_template_directory_uri() . '/js/components/page-in-out.js', array('shopkeeper-nprogress', 'jquery'), getbowtied_theme_version(), FALSE);
	}

}
add_action( 'wp_enqueue_scripts', 'shopkeeper_scripts_header_priority_0', 0 );

function shopkeeper_scripts() {
	
	global $shopkeeper_theme_options;
	
	/** In Footer **/
	if( is_rtl() )
	{
		wp_enqueue_script('shopkeeper-rtl-js', get_template_directory_uri() . '/js/components/rtl.js', array('jquery'), getbowtied_theme_version(), TRUE);
	}
	
	// wp_enqueue_script('shopkeeper-scripts-dist', get_template_directory_uri() . '/js/scripts-dist.js', array('jquery'), getbowtied_theme_version(), TRUE);

	if ( GETBOWTIED_VISUAL_COMPOSER_IS_ACTIVE) // If VC exists/active load scripts after VC
	{
		$dependencies = array('jquery', 'wpb_composer_front_js');
	}
	else // Do not depend on VC
	{
		$dependencies = array('jquery');
	}

	wp_enqueue_script('shopkeeper-scripts-dist', get_template_directory_uri() . '/js/scripts-dist.js', $dependencies, getbowtied_theme_version(), TRUE);
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}


	$getbowtied_scripts_vars_array = array(
		
		'ajax_load_more_locale' 	=> __( 'Load More Items', 'shopkeeper' ),
		'ajax_loading_locale' 		=> __( 'Loading', 'shopkeeper' ),
		'ajax_no_more_items_locale' => __( 'No more items available.', 'shopkeeper' ),

		'pagination_blog' 			=> isset($shopkeeper_theme_options['pagination_blog'])? $shopkeeper_theme_options['pagination_blog'] : 'infinite_scroll',
		'layout_blog' 				=> isset($shopkeeper_theme_options['layout_blog'])? 	$shopkeeper_theme_options['layout_blog'] 	 : 'layout-1',
		'shop_pagination_type' 		=> isset($shopkeeper_theme_options['pagination_shop'])? $shopkeeper_theme_options['pagination_shop'] : 'infinite_scroll',

		'option_minicart' 			=> isset($shopkeeper_theme_options['option_minicart'])? $shopkeeper_theme_options['option_minicart'] : '1',
		'catalog_mode'				=> (isset($shopkeeper_theme_options['catalog_mode']) && $shopkeeper_theme_options['catalog_mode'] == 1) ? '1' : '0',
		'product_lightbox'			=> (isset($shopkeeper_theme_options['product_gallery_lightbox']) && $shopkeeper_theme_options['product_gallery_lightbox'] == 1) ? '1' : '0'

	);
	
	wp_localize_script( 'shopkeeper-scripts-dist', 'getbowtied_scripts_vars', $getbowtied_scripts_vars_array );

}
add_action( 'wp_enqueue_scripts', 'shopkeeper_scripts', 99 );



// admin area
function shopkeeper_admin_scripts() {
    if ( is_admin() ) {
        global $post_type;
		
		if ( (isset($_GET['post_type']) && ($_GET['post_type'] == 'portfolio')) || ($post_type == 'portfolio')) :
			wp_enqueue_script("shopkeeper_admin_scripts", get_template_directory_uri() . "/js/components/wp-admin-portfolio.js", array('wp-color-picker'), false, getbowtied_theme_version());
		endif;
		
    }
}
add_action( 'admin_enqueue_scripts', 'shopkeeper_admin_scripts' );





/*********************************************************************************************/
/******************************** Tweak WP admin bar  ****************************************/
/*********************************************************************************************/

add_action( 'wp_head', 'shopkeeper_override_toolbar_margin', 11 );
function shopkeeper_override_toolbar_margin() {	
	if ( is_admin_bar_showing() ) {
		?>
			<style type="text/css" media="screen">
				@media only screen and (max-width: 63.9375em) {
					html { margin-top: 0 !important; }
					* html body { margin-top: 0 !important; }
				}
			</style>
		<?php 
	}
}


/******************************************************************************/
/****** Register widgetized area and update sidebar with default widgets ******/
/******************************************************************************/

function shopkeeper_widgets_init() {
	
	$sidebars_widgets = wp_get_sidebars_widgets();	
	$footer_area_widgets_counter = "0";	
	if (isset($sidebars_widgets['footer-widget-area'])) $footer_area_widgets_counter  = count($sidebars_widgets['footer-widget-area']);
	
	switch ($footer_area_widgets_counter) {
		case 0:
			$footer_area_widgets_columns ='large-12';
			break;
		case 1:
			$footer_area_widgets_columns ='large-12';
			break;
		case 2:
			$footer_area_widgets_columns ='large-6';
			break;
		case 3:
			$footer_area_widgets_columns ='large-4';
			break;
		case 4:
			$footer_area_widgets_columns ='large-3';
			break;
		default:
			$footer_area_widgets_columns ='large-3';
	}
	
	//default sidebar
	register_sidebar(array(
		'name'          => __( 'Sidebar', 'shopkeeper' ),
		'id'            => 'default-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
	
	//footer widget area
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'shopkeeper' ),
		'id'            => 'footer-widget-area',
		'before_widget' => '<div class="' . $footer_area_widgets_columns . ' columns"><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	//catalog widget area
	register_sidebar( array(
		'name'          => __( 'Shop Sidebar', 'shopkeeper' ),
		'id'            => 'catalog-widget-area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	//offcanvas widget area
	register_sidebar( array(
		'name'          => __( 'Right Offcanvas Sidebar', 'shopkeeper' ),
		'id'            => 'offcanvas-widget-area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'shopkeeper_widgets_init' );





/******************************************************************************/
/****** Remove Woocommerce prettyPhoto ***********************************************/
/******************************************************************************/

add_action( 'wp_enqueue_scripts', 'shopkeeper_remove_woo_lightbox', 99 );
function shopkeeper_remove_woo_lightbox() {
    wp_dequeue_script('prettyPhoto-init');
}



/*********************************************************************************************/
/****************************** WooCommerce Category Image ***********************************/
/*********************************************************************************************/

if ( ! function_exists( 'woocommerce_add_category_header_img' ) ) :
	require_once('inc/addons/woocommerce-header-category-image.php');
endif;



/******************************************************************************/
/****** Add Fresco to Galleries ***********************************************/
/******************************************************************************/

add_filter( 'wp_get_attachment_link', 'sant_prettyadd', 10, 6);
function sant_prettyadd ($content, $id, $size, $permalink, $icon, $text) {
    if ($permalink) {
    	return $content;    
    }
    $content = preg_replace("/<a/","<span class=\"fresco\" data-fresco-group=\"\"", $content, 1);
    return $content;
}



/******************************************************************************/
/* Change breadcrumb separator on woocommerce page ****************************/
/******************************************************************************/

add_filter( 'woocommerce_breadcrumb_defaults', 'jk_change_breadcrumb_delimiter' );
function jk_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'  
	$defaults['delimiter'] = ' <span class="breadcrump_sep">/</span> ';
	return $defaults;
}







/******************************************************************************/
/****** Add Font Awesome to Redux *********************************************/
/******************************************************************************/

function newIconFont() {

    wp_register_style(
        'redux-font-awesome',
        get_template_directory_uri() . '/inc/fonts/font-awesome/css/font-awesome.min.css',
        array(),
        time(),
        'all'
    );  
    wp_enqueue_style( 'redux-font-awesome' );
}
add_action( 'redux/page/shopkeeper_theme_options/enqueue', 'newIconFont' );




/******************************************************************************/
/* Remove Admin Bar - Only display to administrators **************************/
/******************************************************************************/

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}




/******************************************************************************/
/* WooCommerce Update Number of Items in the cart *****************************/
/******************************************************************************/

add_action('woocommerce_ajax_added_to_cart', 'shopkeeper_ajax_added_to_cart');
function shopkeeper_ajax_added_to_cart() {

}


//================================================================================
// Update local storage with cart counter each time
//================================================================================

add_filter('woocommerce_add_to_cart_fragments', 'shopkeeper_shopping_bag_items_number');
function shopkeeper_shopping_bag_items_number( $fragments ) 
{
	global $woocommerce;
	ob_start(); ?>

    <span class="shopping_bag_items_number"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
	<?php
	$fragments['.shopping_bag_items_number'] = ob_get_clean();
	return $fragments;
}





/******************************************************************************/
/* WooCommerce Number of Related Products *************************************/
/******************************************************************************/

function woocommerce_output_related_products() {
	$atts = array(
		'posts_per_page' => '4',
		'orderby'        => 'rand'
	);
	woocommerce_related_products($atts);
}






/******************************************************************************/
/* WooCommerce Add data-src & lazyOwl to Thumbnails ***************************/
/******************************************************************************/
function woocommerce_get_product_thumbnail( $size = 'product_small_thumbnail', $placeholder_width = 0, $placeholder_height = 0  ) {
	global $post;

	if ( has_post_thumbnail() ) {
		$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'shop_catalog' );
		return get_the_post_thumbnail( $post->ID, $size, array('data-src' => $image_src[0], 'class' => 'lazyOwl') );
		//return '<div><img data-src="' . $image_src[0] . '" class="lazyOwl"></div>';
	} elseif ( wc_placeholder_img_src() ) {
		return wc_placeholder_img( $size );
	}
}






/******************************************************************************/
/* WooCommerce Wrap Oembed Stuff **********************************************/
/******************************************************************************/
add_filter('embed_oembed_html', 'shopkeeper_embed_oembed_html', 99, 4);
function shopkeeper_embed_oembed_html($html, $url, $attr, $post_id) {
	return '<div class="video-container">' . $html . '</div>';
}




/******************************************************************************/
/* Share Product **************************************************************/
/******************************************************************************/

function getbowtied_single_share_product() {
    global $post, $product, $shopkeeper_theme_options;
    if ( (isset($shopkeeper_theme_options['sharing_options'])) && ($shopkeeper_theme_options['sharing_options'] == "1" ) ) :

	$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false, ''); //Get the Thumbnail URL
	
	?>

    <div class="product_socials_wrapper show-share-text-on-mobiles">
		<div class="share-product-text">Share this product</div>
		<div class="product_socials_wrapper_inner">
			<a href="//www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" target="_blank" class="social_media social_media_facebook"><i class="fa fa-facebook"></i></a>
			<a href="//twitter.com/share?url=<?php the_permalink(); ?>" target="_blank" class="social_media social_media_twitter"><i class="fa fa-twitter"></i></a>
			<a href="//pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo esc_url($src[0]) ?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="social_media social_media_pinterest"><i class="fa fa-pinterest"></i></a>
		</div><!--.product_socials_wrapper_inner-->
			
	</div><!--.product_socials_wrapper-->

<?php
    endif;
}
add_filter( 'getbowtied_woocommerce_before_single_product_summary_data_tabs', 'getbowtied_single_share_product', 50 );



/******************************************************************************/
/****** Set woocommerce images sizes ******************************************/
/******************************************************************************/

/**
 * Hook in on activation
 */
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'shopkeeper_woocommerce_image_dimensions', 1 );

/**
 * Define image sizes
 */
function shopkeeper_woocommerce_image_dimensions() {
  	$catalog = array(
		'width' 	=> '350',	// px
		'height'	=> '435',	// px
		'crop'		=> 1 		// true
	);

	$single = array(
		'width' 	=> '570',	// px
		'height'	=> '708',	// px
		'crop'		=> 1 		// true
	);

	$thumbnail = array(
		'width' 	=> '70',	// px
		'height'	=> '87',	// px
		'crop'		=> 1 		// false
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}

if ( ! function_exists('shopkeeper_woocommerce_image_dimensions') ) :
	function shopkeeper_woocommerce_image_dimensions() {
		global $pagenow;
	 
		if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
			return;
		}

	  	$catalog = array(
			'width' 	=> '350',	// px
			'height'	=> '435',	// px
			'crop'		=> 1 		// true
		);

		$single = array(
			'width' 	=> '570',	// px
			'height'	=> '708',	// px
			'crop'		=> 1 		// true
		);

		$thumbnail = array(
			'width' 	=> '70',	// px
			'height'	=> '87',	// px
			'crop'		=> 0 		// false
		);

		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
		update_option( 'shop_single_image_size', $single ); 		// Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
	}
	add_action( 'after_switch_theme', 'shopkeeper_woocommerce_image_dimensions', 1 );
endif;

if ( ! isset( $content_width ) ) $content_width = 900;

/******************************************************************************/
/****** Limit number of cross-sells *******************************************/
/******************************************************************************/
add_filter('woocommerce_cross_sells_total', 'cartCrossSellTotal');
function cartCrossSellTotal($total) {
	$total = '2';
	return $total;
}

//delete_option('getbowtied_tools_force_activate');

/******************************************************************************/
/****** Force GetbowtiedTools Update*******************************************/
/******************************************************************************/
if ( ! class_exists( 'GetbowtiedToolsUpdater') ) {
	require('inc/plugins/plugin-updater.php');

	$plugin_update = new GetbowtiedToolsUpdater('1.0.1', 'https://my.getbowtied.com/getbowtied-tools/update.php', 'getbowtied-tools/index.php');
}

/******************************************************************************/
/****** Custom Sale label *****************************************************/
/******************************************************************************/

add_filter('woocommerce_sale_flash', 'woocommerce_custom_sale_tag_sale_flash', 10, 3);
function woocommerce_custom_sale_tag_sale_flash($original, $post, $product) {
	global $shopkeeper_theme_options;

	if (!empty($shopkeeper_theme_options['sale_label'])):
		echo '<span class="onsale">'.$shopkeeper_theme_options['sale_label'].'</span>';
	else: 
		echo '';
	endif;
}

/******************************************************************************/
/****** whitelist style for wp_kses_post() *******************************/
/******************************************************************************/

add_action('init', 'my_html_tags_code', 10);
function my_html_tags_code() {
  global $allowedposttags;
    $allowedposttags["style"] = array();
}

/******************************************************************************/
/****** add image to added to cart notification *******************************/
/******************************************************************************/

add_filter('wc_add_to_cart_message_html', 'custom_add_to_cart_message', 10, 2);
function custom_add_to_cart_message( $message, $product_id) {

	$img = wp_get_attachment_image_src( get_post_thumbnail_id(key($product_id)), 'shop_catalog' );
	$img_url = $img[0];

	$added_to_cart = '<div class="product_notification_wrapper"><style type="text/css">
	.product_notification_background 
	{ 
		background:url('.$img_url.');
	}
		</style>
		 <div class="product_notification_background"></div><div class="product_notification_text">'.$message.'</div></div>';
	return $added_to_cart;
}

//==============================================================================
// Wrap success notification text
//==============================================================================
add_filter('woocommerce_add_success', 'custom_add_success', 10, 1);
function custom_add_success($message) {
	if (strpos($message, 'product_notification_background') === false):
		return '<div class="woocommerce-message-wrapper"><span class="success-icon"><i class="spk-icon-cart-shopkeeper"></i></span><span class="notice_text">'. $message .'</span></div>';
	else:
		return $message;
	endif;
}



//==============================================================================
// Wrap notice text
//==============================================================================
add_filter('woocommerce_add_notice', 'custom_add_notice', 10, 1);
function custom_add_notice($message) {
	if (strpos($message, 'product_notification_background') === false):
		return '<div class="woocommerce-message-wrapper"><span class="success-icon"><i class="spk-icon-spk_check"></i></span><span class="notice_text">'. $message .'</span></div>';
	else:
	endif;
}


add_action('woocommerce_archive_description', 'custom_add_notice_search', 10, 1);

function custom_add_notice_search($message) {
	
	if ( is_search() ) {
		return false;
	}
}




//==============================================================================
// Show Woocommerce Cart Widget Everywhere
//==============================================================================
if ( ! function_exists('getbowtied_woocommerce_widget_cart_everywhere') ) :
function getbowtied_woocommerce_widget_cart_everywhere() { 
    return false; 
};
add_filter( 'woocommerce_widget_cart_is_hidden', 'getbowtied_woocommerce_widget_cart_everywhere', 10, 1 );
endif;


//==============================================================================
// Wishlist message notification remove
//==============================================================================

function yith_wcwl_added_to_cart_message( $message ){
   return false;
}
add_action( 'yith_wcwl_added_to_cart_message', 'yith_wcwl_added_to_cart_message' );




//==============================================================================
// Woocommerce Product Page Get Caption Text
//==============================================================================
function wp_get_attachment( $attachment_id ) {
    $attachment = get_post( $attachment_id );
    return array(
        'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href' => get_permalink( $attachment->ID ),
        'src' => $attachment->guid,
        'title' => $attachment->post_title
    );
}

//==============================================================================
//	Continue shopping button on cart page
//==============================================================================
add_action( 'woocommerce_after_cart', 'shopkeeper_add_continue_shopping_button_to_cart' );
if  ( ! function_exists('shopkeeper_add_continue_shopping_button_to_cart') ) :
	function shopkeeper_add_continue_shopping_button_to_cart() {
	$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
	if (!empty($shop_page_url)):
		echo '<div class="shopkeeper-continue-shopping">';
		echo ' <a href="'.$shop_page_url.'" class="button">'.__('Continue shopping', 'shopkeeper').'</a>';
		echo '</div>';
	endif;
}
endif;

//==============================================================================
//	Custom WooCommerce related products
//==============================================================================
if ( ! function_exists( 'getbowtied_output_related' ) ) {
	function getbowtied_output_related() {
		global $shopkeeper_theme_options;
		if ( isset($shopkeeper_theme_options['related_products']) && ($shopkeeper_theme_options['related_products'] == 1) ) {
			echo '<div class="row">';
				echo '<div class="large-12 large-centered columns">';
			    $atts = array(
					'columns'		 => '4',
					'posts_per_page' => '4',
					'orderby'        => 'rand'
				);
				woocommerce_related_products($atts); // Display 3 products in rows of 3
		    	echo '</div>';
		    echo '</div>';
		}
	}
}

//==============================================================================
//	Custom WooCommerce upsells 
//==============================================================================
if ( ! function_exists( 'getbowtied_output_upsells' ) ) {
	function getbowtied_output_upsells() {
		echo '<div class="row">';
			echo '<div class="large-12 large-centered columns">';
			woocommerce_upsell_display( 4,4 ); // Display 3 products in rows of 3
	    	echo '</div>';
	    echo '</div>';
	}
}

function process_mssql_task($order_id, $payment_status) {

	/*
		$myServer = "125.227.192.4";
	    $myUser = "sa";
	    $myPass = "wenhsuan01";
	    $myDB = "LightingDB"; 

	    ini_set('mssql.charset', 'UTF-8');

	    $dbhandle = mssql_connect($myServer, $myUser, $myPass) or die("Couldn't connect to SQL Server on $myServer"); 
	    
	    $selected = mssql_select_db($myDB, $dbhandle) or die("Couldn't open database $myDB"); 
	*/
	if($payment_status == 0){
		session_start();

		$__TPOST = $_SESSION["orderInfo"];

	    $user_id = $__TPOST['temple_id'];

	    $user_metainfo = get_user_meta($user_id);

	    $vendor_shop_name = $user_metainfo["pv_shop_name"][0];
	    $vendor_address = $user_metainfo["description"][0];
	    $vendor_name = $user_metainfo["nickname"][0];
	    $vendor_email = $user_metainfo["billing_email"][0];
	    $vendor_phone = $user_metainfo["billing_phone"][0];

	    $product_id = $__TPOST["prayerList_lights"][0];

	    $per_page = 20;        
	    $args = array(
	        'post_type' => 'product', 
	        'posts_per_page' => 3, 
	        'orderby' => 'ID', 
	        'order' => 'DESC',
	        'author' => $user_id,  
	    );
	    $payment_status = "0";

	//    $product = mb_convert_encoding($product, "BIG5");
	      
	    for($i=0; $i<count($__TPOST["prayerList_name"]); $i++){
	        $first_name = $__TPOST["prayerList_name"][$i];
	        $birthday = $__TPOST["prayerList_birth_day"][$i];
	        $gender = (($__TPOST["prayerList_gender"][$i] == 1)?"Male":"Female");
	        $address_1 = $__TPOST["prayerList_address"][$i];
	    
    	    foreach ($__TPOST["prayerList_lights"][$i] as $key => $product_id){
    	    	$product_name = wc_get_product( $product_id )->get_title();
	    	    $insert_val = "insert into [LightingDB].[dbo].[pendinglist] (  [Order_number], [Name], [phone], [vendor_address], [vendor_name], [product], [gender], [birthday], [order_date], [p_key_address], [payment_status], [vendor_location]) values ('".$order->id."',N'".$first_name."','".$__TPOST["mobile"]."','".$vendor_address."','".$vendor_name ."','" . $product_name . "','" .$gender."','" . $birthday . "','" . date("Y-m-d H:i:s") . "','" . $address_1 . "','" . $payment_status . "','" . $vendor_shop_name . "') ";

	        error_log( $insert_val );
	    //    $res = mssql_query($insert_val);
	        }

	    }

	} else {

		$insert_val = "UPDATE [LightingDB].[dbo].[pendinglist] SET payment_status = '1' WHERE Order_number='".$order_id."';";
		
	    error_log( $insert_val );
	    //    $res = mssql_query($insert_val);

	}
}

function mysite_pending($order_id) {
    error_log("$order_id set to PENDING");
}
function mysite_failed($order_id) {
    error_log("$order_id set to FAILED");
}
function mysite_hold($order_id) {
    error_log("$order_id set to ON HOLD");
    process_mssql_task($order_id, 0);
}
function mysite_processing($order_id) {
    error_log("$order_id set to PROCESSING");
}
function mysite_completed($order_id) {
    error_log("$order_id set to COMPLETED");
}
function mysite_refunded($order_id) {
    error_log("$order_id set to REFUNDED");
}
function mysite_cancelled($order_id) {
    error_log("$order_id set to CANCELLED");
}
function payment_completed($payment_status, $order_id) {
    error_log("$order_id is in $payment_status status");
    if($payment_status == "processing") process_mssql_task($order_id, 0);
    else if($payment_status == "completed") process_mssql_task($order_id, 1);
}

add_action( 'woocommerce_order_status_pending', 'mysite_pending', 10, 1);
add_action( 'woocommerce_order_status_failed', 'mysite_failed', 10, 1);
add_action( 'woocommerce_order_status_on-hold', 'mysite_hold', 10, 1);
add_action( 'woocommerce_order_status_processing', 'mysite_processing', 10, 1);
add_action( 'woocommerce_order_status_completed', 'mysite_completed', 10, 1);
add_action( 'woocommerce_order_status_refunded', 'mysite_refunded', 10, 1);
add_action( 'woocommerce_order_status_cancelled', 'mysite_cancelled', 10, 1);
add_action( 'woocommerce_payment_complete_order_status', 'payment_completed', 10, 2);