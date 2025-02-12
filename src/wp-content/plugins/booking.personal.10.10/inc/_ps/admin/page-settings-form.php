<?php
/**
 * @version     1.0
 * @package     Booking > Settings > Fields page - Saving booking form
 * @category    Settings API
 * @author      wpdevelop
 *
 * @web-site    https://wpbookingcalendar.com/
 * @email       info@wpbookingcalendar.com 
 * @modified    2016-04-15
 * 
 * This is COMMERCIAL SCRIPT
 * We are not guarantee correct work and support of Booking Calendar, if some file(s) was modified by someone else then wpdevelop.
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


require_once( WPBC_PLUGIN_DIR . '/inc/_ps/admin/form_advanced__auto_show_timeslots.php' );  	 						// Auto Load Time Slots Generator

/**
	 * Show Content
 *  Update Content
 *  Define Slug
 *  Define where to show
 */
class WPBC_Page_SettingsFormFields extends WPBC_Page_Structure {
    
	
    public function in_page() {
//        if (
//        	( ! wpbc_is_mu_user_can_be_here( 'only_super_admin' ) )
//        	&& ( ! wpbc_is_current_user_have_this_role('contributor') )
//		){            // If this User not "super admin",  then  do  not load this page at all
//            return (string) wp_rand(100000, 1000000);
//        }

        return 'wpbc-settings';
    }
    
	
    public function tabs() {
        
        $tabs = array();
                
        $tabs[ 'form' ] = array(
                              'title'     => __( 'Booking Form', 'booking')             // Title of TAB
                            , 'page_title'=> __( 'Fields Settings', 'booking')      // Title of Page    
                            , 'hint'      => __( 'Customize fields in booking form', 'booking')               // Hint
                            //, 'link'      => ''                                 // Can be skiped,  then generated link based on Page and Tab tags. Or can  be extenral link
                            //, 'position'  => ''                                 // 'left'  ||  'right'  ||  ''
                            //, 'css_classes'=> ''                                // CSS class(es)
                            //, 'icon'      => ''                                 // Icon - link to the real PNG img
                            , 'font_icon' => 'wpbc_icn_dashboard _customize dashboard rtt draw'         // CSS definition  of forn Icon
                            //, 'default'   => false                               // Is this tab activated by default or not: true || false. 
                            //, 'disabled'  => false                              // Is this tab disbaled: true || false. 
                            //, 'hided'     => false                              // Is this tab hided: true || false. 
                            , 'subtabs'   => array()   
                    );
        
        return $tabs;
    }

    
    public function content() {
        
        $this->css();

        ////////////////////////////////////////////////////////////////////////
        // Checking ////////////////////////////////////////////////////////////
        
        do_action( 'wpbc_hook_settings_page_header', 'form_field_settings');       // Define Notices Section and show some static messages, if needed
        
        if ( ! wpbc_is_mu_user_can_be_here('activated_user') ) return false;    // Check if MU user activated, otherwise show Warning message.
   
        // if ( ! wpbc_is_mu_user_can_be_here('only_super_admin') ) return false;  // User is not Super admin, so exit.  Basically its was already checked at the bottom of the PHP file, just in case.
        
        
        //////////////////////////////////////////////////////////////////////// 
        // Submit  /////////////////////////////////////////////////////////////
        
        $submit_form_name = 'wpbc_form_field';                             // Define form name
                
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
        if ( isset( $_POST['is_form_sbmitted_'. $submit_form_name ] ) ) {

            // Nonce checking    {Return false if invalid, 1 if generated between, 0-12 hours ago, 2 if generated between 12-24 hours ago. }
            $nonce_gen_time = check_admin_referer( 'wpbc_settings_page_' . $submit_form_name  );  // Its stop show anything on submiting, if its not refear to the original page

            // Save Changes 
            $this->update();
        }                

        ////////////////////////////////////////////////////////////////////////
        // Get Data from DB ////////////////////////////////////////////////////                
        $booking_form       =  get_bk_option( 'booking_form' );
        $booking_form_show  =  get_bk_option( 'booking_form_show' );
         
        $is_can = apply_bk_filter('multiuser_is_user_can_be_here', true, 'only_super_admin');
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
        if ( ( isset($_GET['booking_form']) ) && ( ( $is_can ) || ( get_bk_option( 'booking_is_custom_forms_for_regular_users' ) === 'On' ) ) ) {
            $my_booking_form_name = sanitize_text_field( wp_unslash( $_GET['booking_form'] ) );  /* phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing */ /* FixIn: sanitize_unslash */
            $booking_form       = apply_bk_filter('wpdev_get_booking_form',         $booking_form,      $my_booking_form_name,  false );

			$serialized_form_content = false;
			$what_to_return = 'content';
			$is_replace_simple_html = false;
	        $booking_form_show = apply_bk_filter( 'wpdev_get_booking_form_content', $booking_form_show, $my_booking_form_name, $serialized_form_content, $what_to_return, $is_replace_simple_html );
        }

		wpbc_js_for_bookings_page();


		// Tabs: Simple | Advanced
		wpbc_flex_toolbar__booking_form__top_tabs__ps();

		// Toolbar Content
		wpbc_flex_toolbar__booking_form();


        ////////////////////////////////////////////////////////////////////////
        // Content  ////////////////////////////////////////////////////////////
        ?>
        <div class="clear" style="margin-bottom:35px;"></div>
        <span class="metabox-holder">
            <form  name="<?php echo esc_attr( $submit_form_name ); ?>" id="<?php echo esc_attr( $submit_form_name ); ?>" action="" method="post">
                <?php 
                   // N o n c e   field, and key for checking   S u b m i t 
                   wp_nonce_field( 'wpbc_settings_page_' . $submit_form_name );
                ?><input type="hidden" name="is_form_sbmitted_<?php echo esc_attr( $submit_form_name ); ?>" id="is_form_sbmitted_<?php echo esc_attr( $submit_form_name ); ?>" value="1" /><?php
                
                ?><input type="hidden" name="reset_to_default_form" id="reset_to_default_form" value="" /><?php 
                     
                ?><div class="wpbc_settings_row wpbc_settings_row_left"><?php
                
                    // wpbc_open_meta_box_section( 'wpbc_settings_form_fields', __('Form fields', 'booking') );
                    wpbc_open_meta_box_section( 'wpbc_settings_form_fields', '<span style="text-transform: uppercase;letter-spacing: 1px;word-spacing: 10px;">' . esc_html__( 'Form fields', 'booking' ) . '</span>' );
                    $this->show_booking_form( $booking_form );
                    wpbc_close_meta_box_section();
                ?>
                </div>  
                <div class="wpbc_settings_row wpbc_settings_row_right"><?php                
                
                    wpbc_open_meta_box_section( 'wpbc_settings_form_fields_generator',
						'<span style="text-transform: uppercase;letter-spacing: 1px;word-spacing: 10px;">' . esc_html__( 'Shortcode Generator', 'booking' ) . '</span>' );
                    $this->show_fields_shortcodes_generator( $booking_form );                    
                    wpbc_close_meta_box_section();
                ?>
                </div>
                <div class="clear"></div>
                
                <div class="wpbc_settings_row wpbc_settings_row_left"><?php                
                
                    /* translators: 1: ... */
                    wpbc_open_meta_box_section( 'wpbc_settings_form_fields_show',
						'<span style="text-transform: uppercase;letter-spacing: 1px;word-spacing: 10px;">' . esc_html__( 'Content of booking fields data', 'booking' ) . '</span>'
						// sprintf(__( 'Content of booking fields data for email templates (%s-shortcode) and booking listing page' ,'booking'),'[content]')
					);
                    $this->show_content_data_form( $booking_form_show );                
                    wpbc_close_meta_box_section();
                
                ?>
                </div>  
                <div class="wpbc_settings_row wpbc_settings_row_right"><?php                
                
                    wpbc_open_meta_box_section( 'wpbc_settings_form_fields_show_help', __('Help', 'booking') );
                    $this->show_content_data_form_help( $booking_form );                    
                    wpbc_close_meta_box_section();
                ?>
                </div>
                <div class="clear"></div>
                <input type="submit" value="<?php esc_attr_e('Save Changes','booking'); ?>" class="button button-primary wpbc_submit_button" />
            </form>
        </span>
        <?php       
    
        do_action( 'wpbc_hook_settings_page_footer', 'form_field_settings' );
// Generate options Shortcode for times:	// FixIn: 7.1.2.6.
//		$hold = ''; $mold = '';
//		for ( $h = 8; $h < 22; $h ++ ) {				// HOURS
//			for ( $m = 0; $m < 60; $m = $m + 5 ) {		// Minutes (incriment)
//				if ( $hold != '' ) {
//
//					$title = '';		// Title:  AM / PM
//					$title = sprintf( "%d:%02d %s - %d:%02d %s", ($hold > 12) ? ($hold - 12) : $hold, $mold, ($hold > 12) ? 'PM' : 'AM', ($h > 12) ? ($h - 12) : $h, $m, ($h > 12) ? 'PM' : 'AM' ) . '@@';
//					printf( "\"" . $title . "%02d:%02d - %02d:%02d\" ", $hold, $mold, $h, $m );
//				}
//				$hold = $h;
//				$mold = $m;
//			}
//		}
				
	}

    
    /** Save Chanages */  
    public function update() {

        if (
             (
                ( ( isset($_POST['booking_form_new_name'])  )  && (! empty($_POST['booking_form_new_name']) ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
                ||
                ( ( isset($_GET['booking_form'])  ) && ($_GET['booking_form'] !== 'standard')  )  // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
             )
             /* && ($_POST['select_booking_form'] !== 'standard') /**/
           )
        {
            make_bk_action('wpbc_make_save_custom_booking_form');
        } else {
            
            // We can  not use here such code:
            // WPBC_Settings_API::validate_textarea_post_static( 'booking_form' );   or 	//wp_kses   wp_kses_post
            // because it's will  remove also JavaScript,  which  possible to  use for wizard form  or in some other cases.

			// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	        $booking_form      = trim( stripslashes( $_POST['booking_form'] ) );
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	        $booking_form_show = trim( stripslashes( $_POST['booking_form_show'] ) );

	        if ( wpbc_is_this_demo() ) {																				//FixIn: 9.7.3.3.1

		        $booking_form      = wpbc_form_escape_in_demo( $booking_form );
		        $booking_form_show = wpbc_form_escape_in_demo( $booking_form_show );

		        /**
		         * If we use any links or images or any  other URLs then  do  not save it in the live demos!
		         */
		        $protocols = implode( '|', array_map( 'preg_quote', wp_allowed_protocols() ) );

		        $is_exist_in_form = preg_match( '/(' . $protocols . '):/is', $booking_form );
		        $is_exist_in_data = preg_match( '/(' . $protocols . '):/is', $booking_form_show );
		        if ( ( $is_exist_in_form ) || ( $is_exist_in_data ) ) {
					//TODO: show error message of not ability to  save it
			        return;
		        }
	        }

	        update_bk_option( 'booking_form', 		$booking_form );
	        update_bk_option( 'booking_form_show', 	$booking_form_show );
       }
         
        wpbc_show_changes_saved_message();        
    }

        
    // <editor-fold     defaultstate="collapsed"                        desc=" CSS & JS  "  >
    
    /** CSS for this page */
    private function css() {
        ?>
        <style type="text/css">  
            .wpbc-help-message {
                border:none;
            }
            /* toolbar fix */
            .wpdevelop .visibility_container .control-group {
                margin: 2px 8px 3px 0;  /* margin: 0 8px 5px 0; */ /* FixIn:  9.5.4.8	*/
            }
            /* Selectbox element in toolbar */
            .visibility_container select optgroup{                            
                color:#999;
                vertical-align: middle;
                font-style: italic;
                font-weight: 400;
            }
            .visibility_container select option {
                padding:5px;
                font-weight: 600;
            }
	        .visibility_container select optgroup option{
                padding: 5px 20px;
                color:#555;
                font-weight: 400;
				font-style: normal;
            }
            #wpbc_create_new_custom_form_name_fields {
                width: 360px;
                display:none;
            }
            @media (max-width: 399px) {
                #wpbc_create_new_custom_form_name_fields {
                    width: 100%;
                }                
            }
        </style>
        <?php
    }
    
    // </editor-fold>
    

    
    // <editor-fold     defaultstate="collapsed"                        desc=" C O N T E N T   F o r m s "  >

    
    /** Show Booking Form  - in Settings page */
    private function show_booking_form( $booking_form ) {

    	// FixIn: 8.4.7.18.
    	if (
    		( function_exists( 'wpbc_codemirror') )
    		&& ( is_user_logged_in() && 'false' !== wp_get_current_user()->syntax_highlighting )
		) {
    		$is_use_code_mirror = true;
		} else {
    		$is_use_code_mirror = false;
		}


    	if ( $is_use_code_mirror ) {


		    ?><textarea id="booking_form" name="booking_form" style="width:100%;height:200px;"><?php

		    echo( ! empty( $booking_form ) ? esc_textarea( $booking_form ) : '' );

		    ?></textarea><?php

			wpbc_codemirror()->set_codemirror( array(
												'textarea_id' => '#booking_form'
												// , 'preview_id'   => '#wpbc_add_form_html_preview'
			) );

	    } else {

			wp_editor( $booking_form,
			   'booking_form',
			   array(
					 'wpautop'       => false
				   , 'media_buttons' => false
				   , 'textarea_name' => 'booking_form'
				   , 'textarea_rows' => 27
				   , 'tinymce' => false                                 // Remove Visual Mode from the Editor
				   , 'editor_class'  => 'wpbc-textarea-tinymce'         // Any extra CSS Classes to append to the Editor textarea
				   , 'teeny' => true                                    // Whether to output the minimal editor configuration used in PressThis
				   , 'drag_drop_upload' => false                        // Enable Drag & Drop Upload Support (since WordPress 3.9)
				   )
			 );
			//echo '<textarea id="booking_form" name="booking_form" class="darker-border" style="width:100%;" rows="33">' . htmlspecialchars($booking_form, ENT_NOQUOTES ) . '</textarea>';
		}
        ?><div class="clear"></div><?php
    }
    
    
    /** Show Content Fields Data Form  - in Settings page */
    private function show_content_data_form( $booking_form_show ) {

		// FixIn: 8.4.7.18.
		if (
    		( function_exists( 'wpbc_codemirror') )
    		&& ( is_user_logged_in() && 'false' !== wp_get_current_user()->syntax_highlighting )
		) {
    		$is_use_code_mirror = true;
		} else {
    		$is_use_code_mirror = false;
		}

    	if ( $is_use_code_mirror ) {


		    ?><textarea id="booking_form_show" name="booking_form_show" style="width:100%;height:200px;"><?php

		    echo( ! empty( $booking_form_show ) ? esc_textarea( $booking_form_show ) : '' );

		    ?></textarea><?php

			wpbc_codemirror()->set_codemirror( array(
												'textarea_id' => '#booking_form_show'
												// , 'preview_id'   => '#wpbc_add_form_html_preview'
			) );

	    } else {

			wp_editor( $booking_form_show,
			   'booking_form_show',
			   array(
					 'wpautop'       => false
				   , 'media_buttons' => false
				   , 'textarea_name' => 'booking_form_show'
				   , 'textarea_rows' => 9
				   , 'tinymce' => false         // Remove Visual Mode from the Editor
				   // , 'default_editor' => 'html'
				   , 'editor_class'  => 'wpbc-textarea-tinymce'      // Any extra CSS Classes to append to the Editor textarea
				   , 'teeny' => true            // Whether to output the minimal editor configuration used in PressThis
				   , 'drag_drop_upload' => false //Enable Drag & Drop Upload Support (since WordPress 3.9)
				   )
			);
        }
        //echo '<textarea id="booking_form_show" name="booking_form_show" class="darker-border" style="width:100%;" rows="12">' . htmlspecialchars($booking_form_show, ENT_NOQUOTES ) . '</textarea>';
    }

    
    /** Show Shortcode Fields Generator for Booking Form  - in Settings page */
    private function show_fields_shortcodes_generator( $booking_form ) {
        
        if ( class_exists('WPBC_Form_Help') ) {

            $default_Form_Help = new WPBC_Form_Help( array(
                                                        'id'=>'booking_form',
                                                        'version'=> wpbc_get_plugin_version_type()
                                                        )
                                                   );
            $default_Form_Help->show();               
        }  
        
        ?><div class="clear"></div><?php
    }
    
    
    /** Show Help section for Content Fields Data Form  - in Settings page */
    private function show_content_data_form_help( $param ) {
        
        ?>
        <div  class="wpbc-help-message">
            <span class="description"><strong><?php
					/* translators: 1: [content] - shortcode. */
					echo wp_kses_post(  sprintf(__( 'Content of booking fields data for email templates (%s-shortcode) and booking listing page' ,'booking'),'[content]') ); ?></strong></span><br/><hr/>
            <span class="description"><strong><?php echo wp_kses_post( sprintf( __( 'Use these shortcodes for customization: ' ,'booking')) ); ?></strong></span><br/><br/>
            <span class="description"><?php
				/* translators: 1: ... */
				echo wp_kses_post( sprintf( __( '%s - inserting data from fields of booking form' ,'booking'),'<code>[field_name]</code>') ); ?></span><hr/>
            <span class="description wpdevelop"><?php
				/* translators: 1: ... */
				echo wp_kses_post( sprintf(__('%s - custom HTML shortcode, for definition of booking field' ,'booking'),'<code><strong>&lt;f&gt;...&lt;/f&gt;</strong></code>') );?>.
				                      <?php esc_html_e('Configuration' ,'booking'); echo ': <code><strong>&lt;f&gt;</strong></code><strong>[field_name]</strong><code><strong>&lt;/f&gt;</strong></code>';?></span><br/>
				                      <?php esc_html_e('Example' ,'booking');
									  		echo ': <code><strong>&lt;b&gt;First Name&lt;/b&gt;: &lt;f&gt;[name]&lt;/f&gt;&lt;br&gt;</strong></code>';
									  ?></span><hr/>
            <span class="description"><?php
				/* translators: 1: ... */
				echo wp_kses_post( sprintf(__('%s - inserting new line' ,'booking'),'<code>&lt;br&gt;</code>') );?></span><br/>
            <span class="description">
                <?php
                echo '<strong>' . esc_html__('HTML' ,'booking') . '.</strong> '
                     /* translators: 1: ... */
                     . wp_kses_post( sprintf( __( 'You can use any %1$sHTML tags%2$s in the booking form. Please use the HTML tags carefully. Be sure, that all "open" tags (like %3$s) are closed (like this %4$s).', 'booking' )
                                   ,'<strong>','</strong>'
                                   ,'<code>&lt;div&gt;</code>'
                                   ,'<code>&lt;/div&gt;</code>'
                                ) );
                ?>
            </span>
        </div>        
        <?php 
        //echo '<hr />';    
        
    }
    
    // </editor-fold>
    
}
add_action('wpbc_menu_created', array( new WPBC_Page_SettingsFormFields() , '__construct') );    // Executed after creation of Menu
