<?php
/**
 * Redefining Health functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Redefining_Health
 */
if ( ! function_exists( 'redefining_health_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function redefining_health_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Redefining Health, use a find and replace
	 * to change 'redefining-health' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'redefining-health', get_template_directory() . '/languages' );
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'redefining-health' ),
	) );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'redefining_health_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	remove_theme_support( 'wc-product-gallery-zoom' );

	// add_theme_support( 'woocommerce', array(
	// 'thumbnail_image_width' => 300,
	// 'single_image_width' => 600,
	// ));

}
endif;
add_action( 'after_setup_theme', 'redefining_health_setup' );
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function redefining_health_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'redefining_health_content_width', 640 );
}
add_action( 'after_setup_theme', 'redefining_health_content_width', 0 );
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function redefining_health_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar 1', 'redefining-health' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'redefining-health' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'redefining_health_widgets_init' );
/**
 * Enqueue scripts and styles.
 */
function redefining_health_scripts() {
	wp_enqueue_style( 'redefining-health-style', get_stylesheet_uri() );
	// wp_enqueue_style( 'bootstrap', get_template_directory_uri() .'/css/bootstrap.css',array(),'3.3.7' );
	wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css',array(),'3.3.7' );
	wp_enqueue_style( 'fontAwesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'fonts-css', get_template_directory_uri() . '/fonts/fonts.css?v='.time() );
	wp_enqueue_style( 'custom-css', get_template_directory_uri() . '/css/custom.css?v='.time() );
	wp_enqueue_style( 'cusom-wocommerce', get_template_directory_uri() . '/css/woo-additional.css?v='.time() );
	if( !is_admin()){
	    wp_deregister_script( 'jquery' );
	    // wp_register_script('jquery', get_template_directory_uri().'/js/jquery-3.2.1.min.js', false,'3.2.1',true);
	    wp_register_script('jquery', get_template_directory_uri().'/js/jquery-1.12.4.min.js', false,'1.12.4',true);
	    wp_enqueue_script('jquery');
	}
	//wp_enqueue_script( 'jquery-js', get_template_directory_uri() . '/js/jquery-3.2.1.min.js', array(), '3.2.1', true );
	wp_enqueue_script( 'redefining-health-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'redefining-health-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script( 'bootstrap-min-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.3.7', true );
	// wp_enqueue_script( 'sprout-video-js', get_template_directory_uri() . '/js/sprout-video.js', array(), '1', true );
	wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/js/custom.js', array(), '1', true  );
}
add_action( 'wp_enqueue_scripts', 'redefining_health_scripts' );
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';
/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
require_once('wp-bootstrap-navwalker.php');
// Woo Commerce
require_once('inc/woo-functions.php');
// Videos
require_once('inc/videos.php');
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'  => 'Theme General Settings',
    'menu_title'  => 'Theme Settings',
    'menu_slug'   => 'theme-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ));
}

add_filter( 'woocommerce_page_title', 'woo_shop_page_title');
function woo_shop_page_title( $page_title ) {
	if( 'Shop' == $page_title) {
	    return "Store";              
	}
}
/**
 * These functions will add WooCmmerce or Easy Digital Downloads cart icons/menu items to the "top_nav" WordPress menu area (if it exists).
 * Please customize the following code to fit your needs.
 */
/**
 * This function adds the WooCommerce or Easy Digital Downloads cart icons/items to the top_nav menu area as the last item.
 */
add_filter( 'wp_nav_menu_items', 'my_wp_nav_menu_items', 10, 2 );
function my_wp_nav_menu_items( $items, $args, $ajax = false ) {		
	// Top Navigation Area Only
	if ( ( isset( $ajax ) && $ajax ) || ( property_exists( $args, 'theme_location' ) && $args->theme_location === 'primary' ) ) {
		// WooCommerce
		if ( class_exists( 'woocommerce' ) ) {
			$css_class = 'menu-item menu-item-type-cart menu-item-type-woocommerce-cart';
			// Is this the cart page?
			if ( is_cart() )
				$css_class .= ' current-menu-item';
			$items .= '<li class="' . esc_attr( $css_class ) . '">';
				/*  get_cart_url */
				$items .= '<a class="cart-contents" href="' . esc_url( WC()->cart->get_cart_url() ) . '">';
					$items .= '<i class="fa fa-shopping-cart"></i> (<span class="count">' .  wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'simple-shop' ), WC()->cart->get_cart_contents_count() ) ) . '</span>)';
				$items .= '</a>';
				$items .= '<ul class="dropdown-menu">';
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_data ) {						
						$cart_items = $cart_data['data']->get_data();
						$items .= '<li><a href="'.get_permalink($cart_items['id']).'">'.$cart_items['name'].'</a></li>';
					}				
					/*  get_cart_url */
					$items .= '<li><a href="'. esc_url( WC()->cart->get_cart_url() ) .'">TOTAL : '.wp_kses_data( WC()->cart->get_cart_total() ).'</a></li>';
				$items.= '</ul>';
			$items .= '</li>';
		}		
	}
	return $items;
}
/**
 * This function updates the Top Navigation WooCommerce cart link contents when an item is added via AJAX.
 */
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['desc_tab'] );      	// Remove the description tab
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab_custom' );
function woo_new_product_tab_custom( $tabs ) {
	// Adds the new tab
	$tabs['suggested_use_tab'] = array(
		'title' 	=> __( 'Suggested Use', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'woo_new_product_tab_content_custom'
	);
	return $tabs;
}
function woo_new_product_tab_content_custom() {
	// The new tab content
	// global $product;
	echo "<h2> Suggested Use </h2>";
	echo get_field('suggested_use');
}
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {
	if (isset($tabs['description']) ? $tabs['description'] : '') {
		$tabs['description']['title'] = __( 'Description / Ingredients' );
	}
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_reorder_tabs', 98 );
function woo_reorder_tabs( $tabs ) {
	// Reviews first
	// if (isset($tabs['additional_information']) ? $tabs['additional_information'] : '') {
	// 	$tabs['additional_information']['priority'] = 2;
	// }
	if (isset($tabs['description']) ? $tabs['description'] : '') {
		$tabs['description']['priority'] = 1;
	}
	$tabs['suggested_use_tab']['priority'] = 2;
	$tabs['reviews']['priority'] = 3;	// Additional information third
	return $tabs;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'my_woocommerce_add_to_cart_fragments' );
function my_woocommerce_add_to_cart_fragments( $fragments ) {
	// Add our fragment
	$fragments['li.menu-item-type-woocommerce-cart'] = my_wp_nav_menu_items( '', new stdClass(), true );
	return $fragments;
}
function is_chrome(){
	return(eregi("chrome", $_SERVER['HTTP_USER_AGENT']));
}
function before_tabs(){
	global $product;
	   $videos = get_field('videos');
	   // foreach ($videos as $conditionVids) {
	   // 	$arrVids[$arrVidNum] = $conditionVids['embed_videos'];
	   // }
	   if ($videos) {
	   		?>
	   		<div class="appvidSection">
		   		<div class="downloadableTitle">
					<div class="midContents">
						<p class="boxesTitle theStoreBg">Application & Testimonials</p>
						<img src="<?php echo get_template_directory_uri().'/images/dual-divider.png'; ?>" />
					</div>
				</div>
		   		<?php
			   	foreach ($videos as $videoDatas) {
			   		$vidArr[] = $videoDatas['product_video'];
			   		?>
			   		<div class="col-md-3 vidBoxes vidboxPop">
			   		<?php echo get_field('embed',$videoDatas['product_video']->ID); ?>
			   		</div>
			   		<?php
			   }
			echo "</div>";
			// echo "<pre>";
			// var_dump($vidArr);
			// echo "</pre>";
	   }
	  ?>
		  <div id="modalProduct" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			      </div>
			      <div class="modal-body">
			      	<button id="productLeftArrow" class="btn productArrows" href=""><i class="fa fa-angle-left iconSize"></i></button>
			      	<button id="productRightArrow" class="btn productArrows" href=""><i class="fa fa-angle-right iconSize"></i></button>
			      	<div class="imageProd"></div>
			      	<div class="imageThumbs">
			      		<?php 
			      			if ( has_post_thumbnail( $product->get_id() ) ) {
	                        $attachment_ids[0] = get_post_thumbnail_id( $product->get_id() );
	                        $attachment = wp_get_attachment_image_src($attachment_ids[0], 'full' ); 
	                     ?>    
	                        <img class="modThumbProductImg" src="<?php echo $attachment[0]; ?>" style="width:120px;height: auto;">
	                    <?php 
	                		} 
				      		$attachment_ids = $product->get_gallery_image_ids();
	                        foreach( $attachment_ids as $attachment_id ) 
	                        {
	                          $image_link = wp_get_attachment_url( $attachment_id );
	                          ?>
	                          <img class="modThumbProductImg" src="<?php echo $image_link; ?>" style="width:120px;height: auto;">
	                          <?php
	                        }   
				      	 ?>
			      	 </div>
			      </div>
			    </div>
			  </div>
			</div>
	  <?php
}	

add_action('wp_ajax_load_post_by_ajax', 'load_post_by_ajax');
add_action('wp_ajax_nopriv_load_post_by_ajax', 'load_post_by_ajax');
function load_post_by_ajax(){
	check_ajax_referer('load_more_posts', 'security');
	$paged = $_POST['page'];
	$query = new WP_Query( 
		array( 
			'post_type' => 'videos', 
			's' => @$_GET['sv'],
			'posts_per_page' => 10,
			'orderby' => 'title',
			'order'   => 'DESC',
			'paged' => $paged
			) 
		);                  
	if ( $query->have_posts() ) :
	?>
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>   
	        <div class="col-md-6 withoutPaddingLeft">
				<?php 
				$embed = get_field('embed');
				$video = get_field('video');
				if ($embed) {
					echo getEmdedVideo( get_field('embed') ); 
				}else{
					echo getEmdedVideo( get_field('video') ); 
				}
				?>
				<p class="videoTitlePage"><?php the_title(); ?></p>
			</div>
	    <?php endwhile; wp_reset_postdata(); ?>
		<?php endif; ?>
		<div class="clearfix"></div>
	<?php
	die();
}

// function filter_plugin_updates( $value ) {
//     unset( $value->response['ga-google-analytics/ga-google-analytics.php'] );
//     unset( $value->response['gravityforms/gravityforms.php'] );
//     unset( $value->response['jetpack/jetpack.php'] );
//     unset( $value->response['smntcs-google-webmaster-tools/smntcs-google-webmaster-tools.php'] );
//     unset( $value->response['social-media-buttons-toolbar/social-media-buttons-toolbar.php'] );
//     unset( $value->response['woocommerce/woocommerce.php'] );
//     unset( $value->response['woocommerce-gateway-paypal-powered-by-braintree/woocommerce-gateway-paypal-powered-by-braintree.php'] );
//     unset( $value->response['woocommerce-services/woocommerce-services.php'] );
//     unset( $value->response['woocommerce-gateway-stripe/woocommerce-gateway-stripe.php'] );
//     unset( $value->response['wordpress-importer/wordpress-importer.php'] );
//     unset( $value->response['wpdiscuz/wpdiscuz.php'] );
//     return $value;
// }
// add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );

// add_filter('upload_size_limit', 'upload_max_increase_upload');
// function upload_max_increase_upload() {
//     return 262144000;
// }
