<?php
/**
 * Enqueue scripts and stylesheets
 */ 
function roots_scripts() {

	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	/********************************
	Bootstrap + Vendor CSS / JS
	 ********************************/
	wp_register_script('t-vendor-footer', get_template_directory_uri() . '/assets/js/vendor/vendor_footer.js', array('jquery'), '1.2', true);
	wp_enqueue_script('t-vendor-footer');

	
	/********************************
		Main JS - Theme helpers
	********************************/  
  	wp_register_script('roots-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.3', true);
	wp_enqueue_script('roots-main');

	
	/********************************
		Main Stylesheet
	********************************/  
	wp_register_style('roots-app',  get_template_directory_uri() . '/assets/css/app.css', array(), '1');
	wp_enqueue_style('roots-app');


    /********************************
    WooCommerce
     ********************************/
    // If woocommerce enabled then ensure shortcodes are respected inside our html metaboxes.
    if ( class_exists( 'woocommerce' ) ) {
        global $post;
        if(isset($post->ID) && $post->ID > 0){
            $themo_meta_data = get_post_meta($post->ID); // get all post meta data
            foreach ( $themo_meta_data as $key => $value ){ // loop
                $pos_html = strpos($key, 'themo_html_'); // Get position of 'themo_html_' in each key.
                $pos_content = strpos($key, '_content'); // Get position of '_content' in each key.
                if($pos_html == 0 && $pos_content > 0 && isset($value) && is_array($value) && isset($value[0]) && strstr( $value[0], '[product_page' )){
                    global $woocommerce;
                    $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
                    wp_enqueue_script( 'prettyPhoto', $woocommerce->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto' . $suffix . '.js', array( 'jquery' ), $woocommerce->version, true );
                    wp_enqueue_script( 'prettyPhoto-init', $woocommerce->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto.init' . $suffix . '.js', array( 'jquery' ), $woocommerce->version, true );
                    wp_enqueue_style( 'woocommerce-prettyPhoto-css', $woocommerce->plugin_url() . '/assets/css/prettyPhoto.css' );
                }
            }
        }
    }
		
	/********************************
		Child Theme
	********************************/
	if (is_child_theme()) {
		wp_register_style('roots-child', get_stylesheet_uri());
		wp_enqueue_style('roots-child');
	}

  
}
add_action('wp_enqueue_scripts', 'roots_scripts', 100);


