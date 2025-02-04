<?php
/**
 * Roots includes
 */
include( get_template_directory() . '/lib/init.php');            // Initial theme setup and constants
include( get_template_directory() . '/lib/wrapper.php');         // Theme wrapper class
include( get_template_directory() . '/lib/config.php');          // Configuration
include( get_template_directory() . '/lib/titles.php');          // Page titles
include( get_template_directory() . '/lib/cleanup.php');         // Cleanup
include( get_template_directory() . '/lib/nav.php');             // Custom nav modifications
include( get_template_directory() . '/lib/comments.php');        // Custom comments modifications
include( get_template_directory() . '/lib/widgets.php');         // Sidebars and widgets
include( get_template_directory() . '/lib/scripts.php');         // Scripts and stylesheets
include( get_template_directory() . '/lib/custom.php');          // Custom functions
include( get_template_directory() . '/lib/class-tgm-plugin-activation.php');    // Bundled Plugins
include( get_template_directory() . '/lib/plugin-update-checker/plugin-update-checker.php');

/**
 * Define Elementor Partner ID
 */
if ( ! defined( 'ELEMENTOR_PARTNER_ID' ) ) {
    define( 'ELEMENTOR_PARTNER_ID', 2129 );
}

/**
 * Recommend the Kirki plugin
 */
include( get_template_directory() . '/lib/include-kirki.php');          // Customizer options
/**
 * Load the Kirki Fallback class
 */
include( get_template_directory() . '/lib/uplands-kirki.php');
/**
 * Customizer additions.
 */
include( get_template_directory(). '/lib/customizer.php');


// Activate Option Tree in the theme rather than as a plugin
//add_filter( 'ot_theme_mode', '__return_true' );
add_filter( 'ot_show_pages', '__return_false' );

//include_once(get_template_directory() . '/option-tree/ot-loader.php');
//include_once(get_template_directory() . '/option-tree/meta-boxes.php' ); // LOAD META BOXES


// Envato WP Theme Setup Wizard
// Set Envato Username - DISABLED FOR NOW
add_filter('uplands_theme_setup_wizard_username', 'uplands_set_theme_setup_wizard_username', 10);
add_filter('uplandschildtheme_theme_setup_wizard_username', 'uplands_set_theme_setup_wizard_username', 10);
if( ! function_exists('uplands_set_theme_setup_wizard_username') ){
    function uplands_set_theme_setup_wizard_username($username){
        return 'themovation';
    }
}

// Envato WP Theme Setup Wizard
// Set Envato Script URL - DISABLED FOR NOW
add_filter('uplands_theme_setup_wizard_oauth_script', 'uplands_set_theme_setup_wizard_oauth_script', 10);
add_filter('uplandschildtheme_theme_setup_wizard_oauth_script', 'uplands_set_theme_setup_wizard_oauth_script', 10);
if( ! function_exists('uplands_set_theme_setup_wizard_oauth_script') ){
    function uplands_set_theme_setup_wizard_oauth_script($oauth_url){
        return 'http://app.themovation.com/envato/api/server-script.php';
    }
}

// Envato WP Theme Setup Wizard
// Set Custom Default Content Titles and Descriptions
add_filter('uplands_theme_setup_wizard_default_content', 'uplands_theme_setup_wizard_default_content_script', 10);
add_filter('uplandschildtheme_theme_setup_wizard_default_content', 'uplands_theme_setup_wizard_default_content_script', 10);
if( ! function_exists('uplands_theme_setup_wizard_default_content_script') ){
    function uplands_theme_setup_wizard_default_content_script($default){

        // Check all by default
        $default['checked'] = 1;

        // Add user friendly titles and descriptions
        if (isset($default['title'])){
            switch($default['title']) {
                case 'Media':
                    $default['title'] = 'Media Files';
                    $default['description'] = 'Media from the demo, mostly photos and graphics.';
                    break;
                case 'Portfolio':
                    $default['title'] = 'Portfolio';
                    $default['description'] = 'Portfolio pages as seen on the demo.';
                    break;
                case 'Posts':
                    $default['title'] = 'Blog Posts';
                    $default['description'] = 'Blog Posts as seen on the demo.';
                    break;
                case 'Pages':
                    $default['description'] = 'Pages as seen on the demo.';
                    break;
                case 'My Library':
                    $default['title'] = 'Templates';
                    $default['description'] = 'Page Builder Templates for rapid page creation.';
                    break;
                case 'Widgets':
                    $default['description'] = 'Widgets as seen on the demo.';
                    break;
                case 'Forms':
                    $default['description'] = 'Formidable Forms as seen on the demo.';
                    break;
            }

        }

        return $default;
    }
}

// Envato WP Theme Setup Wizard
// Custom logo for Installer
add_filter('envato_setup_logo_image', 'envato_set_setup_logo_image', 10);
if( ! function_exists('envato_set_setup_logo_image') ){
    function envato_set_setup_logo_image($image_url){
        $logo_main = get_template_directory_uri() . '/assets/images/setup_logo.png' ;
        return $logo_main;
    }
}


// Envato WP Theme Setup Wizard
// Update Term IDs for Our Custom Post Stype saved inside _elementor_data Post Meta
/*
 * Takes page elementor widget name, page title and term slugs as an array
 * updates elementor json string to update term(s) during an import.
 */
if( ! function_exists('themo_update_elm_widget_select_term_id') ) {
    function themo_update_elm_widget_select_term_id($elmwidgetname, $pagetitle, $termslug = array())
    {
        // premature exit?
        if (!isset($termslug) || !isset($pagetitle) || !isset($elmwidgetname)) {
            return;
        } else {
            $pageobj = get_page_by_title($pagetitle); // get page object
            $pageid = false;
            if(isset($pageobj->ID)){
                $pageid = $pageobj->ID; // get page ID
            }

            // loop through all slugs requested and get terms ids
            foreach ($termslug as $slug) {
                $termid = term_exists($slug); // get term ID
                $termids[] = $termid; // add to array, we'll use this later.
            }

            // premature exit?
            if (!isset($termids) || !isset($pageid)) {
                return;
            } else {

                $data = get_post_meta($pageid, '_elementor_data', TRUE); // get elm json string

                /*if (!is_array($data)){
                    $data = json_decode($data, true); // decode that mofo
                }*/

                // We are looking for something very specific so let's grab it and go.
                // Does key exist? Does it match to the elm widget name passed in?

                if (isset($data[0]['elements'][0]['elements'][0]['widgetType']) && $data[0]['elements'][0]['elements'][0]['widgetType'] = $elmwidgetname) {
                    // make sure there is a term group setting.
                    if (!isset($data[0]['elements'][0]['elements'][0]['settings']['group'])) {
                        return;
                    } else {
                        $data[0]['elements'][0]['elements'][0]['settings']['group'] = $termids; //set updated term ids
                        //$newJsonString = json_encode($data); // encode the json data
                        update_post_meta($pageid, '_elementor_data',$data); // update post meta with new json string.
                    }
                }

            }

        }

    }
}

// Envato WP Theme Setup Wizard
// Hook to find / replace tour terms. Fires only during theme import profess.
if( ! function_exists('themo_post_content_import_hook') ) {
    function themo_post_content_import_hook()
    {
        th_update_elm_widget_select_term_id('themo-tour-grid', 'Home 1', array('packages'));
        th_update_elm_widget_select_term_id('themo-tour-grid', 'Tour Index', array('guided','packages','rafting','specials','whitewater'));
    }
}
add_action( 'themo_post_content_import', 'themo_post_content_import_hook', 10, 2 );


// Envato WP Theme Setup Wizard
//add_filter( 'uplands_enable_setup_wizard', '__return_true' );
//add_filter( 'uplandschildtheme_enable_setup_wizard', '__return_true' );

include( get_template_directory() . '/plugins/envato_setup/envato_setup_init.php');     // Custom functions
include( get_template_directory() . '/plugins/envato_setup/envato_setup.php');          // Custom functions

add_action( 'after_switch_theme', 'themo_check_theme_setup', 10, 2 );
function themo_check_theme_setup($old_theme_name, $old_theme = false){

    // Compare versions.
    if ( version_compare(PHP_VERSION, THEMO_REQUIRED_PHP_VERSION, '<') ) :

        // Theme not activated info message.
        add_action( 'admin_notices', 'themo_admin_notice_phpversion' );
        function themo_admin_notice_phpversion() {
            ?>
            <div class="update-nag">
                <?php _e( 'Hello, we ran into a small problem, but it\'s an easy fix. Your version of <strong>PHP</strong>', 'uplands'); ?> <strong><?php echo PHP_VERSION; ?></strong> <?php _e( 'is unsupported. We recommend <strong>PHP 7+</strong>, however, the theme should work with <strong>PHP</strong>','uplands') ?> <strong><?php echo THEMO_REQUIRED_PHP_VERSION; ?>+</strong>. <?php _e( 'Please ask your web host to upgrade your version of PHP before activating this theme. If you need help, please contact the <a href="https://themovation.ticksy.com/" target="_blank">Embark support team here.</a>', 'uplands' ); ?> <br />
            </div>
            <?php
        }

        // Switch back to previous theme.
        switch_theme( $old_theme->stylesheet );
        return false;

    endif;
}

function stratus_register_elementor_locations( $elementor_theme_manager ) {

    $elementor_theme_manager->register_all_core_location();

}
add_action( 'elementor/theme/register_locations', 'stratus_register_elementor_locations' );