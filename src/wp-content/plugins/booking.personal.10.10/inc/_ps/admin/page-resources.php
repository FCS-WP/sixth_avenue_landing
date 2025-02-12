<?php /**
 * @version 1.0
 * @package Booking > Resources page
 * @category Settings page 
 * @author wpdevelop
 *
 * @web-site https://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 2016-08-13
 * 
 * This is COMMERCIAL SCRIPT
 * We are not guarantee correct work and support of Booking Calendar, if some file(s) was modified by someone else then wpdevelop.
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


/**
	 * Show Content
 *  Update Content
 *  Define Slug
 *  Define where to show
 */
class WPBC_Page_Settings__bresources extends WPBC_Page_Structure {


    public function in_page() {
        return 'wpbc-resources';
    }
    

    public function tabs() {
        
        $tabs = array();
                
        $tabs[ 'resources' ] = array(
	        				  'title' 		=> __( 'Resources', 'booking' ) //. '<span class="wpbc_new_label" style="float:none;padding:0 0 0 2em;">New</span>'			// Title of TAB
                            , 'hint'        => __('Customization of booking resources', 'booking')                      // Hint    
                            , 'page_title'  => ucwords( __('Booking resources','booking') )                               // Title of Page    
                            //, 'link'      => ''                                 // Can be skiped,  then generated link based on Page and Tab tags. Or can  be extenral link
                            //, 'position'  => 'left'                             // 'left'  ||  'right'  ||  ''
                            //, 'css_classes'=> ''                                // CSS class(es)
                            //, 'icon'      => ''                                 // Icon - link to the real PNG img
                            , 'font_icon' => 'wpbc_icn_checklist'           // CSS definition  of forn Icon
                            , 'default'   => true                              // Is this tab activated by default or not: true || false. 
                            //, 'disabled'  => false                              // Is this tab disbaled: true || false. 
                            , 'hided'     => true//( class_exists('wpdev_bk_biz_m') ) ? false : true                              // Is this tab hided: true || false.
                            , 'subtabs'   => array()   
                    );
        
        /*
        $subtabs = array();        
        $subtabs[ 'gcal' ] = array( 
                            'type' => 'subtab'                                  // Required| Possible values:  'subtab' | 'separator' | 'button' | 'goto-link' | 'html'
                            , 'title' => __('Google Calendar' ,'booking') . '  - ' . __('Events Import' ,'booking')         // Title of TAB    
                            , 'page_title' => __('Google Calendar' ,'booking') . ' ' . __('Settings' ,'booking')    // Title of Page   
                            , 'hint' => __('Customization of synchronization with Google Calendar' ,'booking')      // Hint    
                            , 'link' => ''                                      // link
                            , 'position' => ''                                  // 'left'  ||  'right'  ||  ''
                            , 'css_classes' => ''                               // CSS class(es)
                            //, 'icon' => 'http://.../icon.png'                 // Icon - link to the real PNG img
                            //, 'font_icon' => 'wpbc_icn_mail_outline'   // CSS definition of Font Icon
                            , 'default' =>  true                                // Is this sub tab activated by default or not: true || false. 
                            , 'disabled' => false                               // Is this sub tab deactivated: true || false. 
                            , 'checkbox'  => false                              // or definition array  for specific checkbox: array( 'checked' => true, 'name' => 'feature1_active_status' )   //, 'checkbox'  => array( 'checked' => $is_checked, 'name' => 'enabled_active_status' )
                            , 'content' => 'content'                            // Function to load as conten of this TAB
                        );        
        $tabs[ 'users' ]['subtabs'] = $subtabs;
        */
        
        return $tabs;
    }


    /** Show Content of Settings page */
    public function content() {

        $this->css();
        
        ////////////////////////////////////////////////////////////////////////
        // Checking 
        ////////////////////////////////////////////////////////////////////////

        do_action( 'wpbc_hook_settings_page_header', 'resources');              // Define Notices Section and show some static messages, if needed
        
        if ( ! wpbc_is_mu_user_can_be_here('activated_user') ) return false;    // Check if MU user activated, otherwise show Warning message.
   
        // if ( ! wpbc_is_mu_user_can_be_here('only_super_admin') ) return false;  // User is not Super admin, so exit.  Basically its was already checked at the bottom of the PHP file, just in case.
        
        
        ////////////////////////////////////////////////////////////////////////
        // Load Data 
        ////////////////////////////////////////////////////////////////////////
        

        ////////////////////////////////////////////////////////////////////////
        //  S u b m i t   Main Form  
        ////////////////////////////////////////////////////////////////////////
        
        $submit_form_name = 'wpbc_bresources';                         // Define form name
        
        // $this->get_api()->validated_form_id = $submit_form_name;             // Define ID of Form for ability to  validate fields (like required field) before submit.
        
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
        if ( isset( $_POST['is_form_sbmitted_'. $submit_form_name ] ) ) {

            // Nonce checking    {Return false if invalid, 1 if generated between, 0-12 hours ago, 2 if generated between 12-24 hours ago. }
            $nonce_gen_time = check_admin_referer( 'wpbc_settings_page_' . $submit_form_name );  // Its stop show anything on submiting, if its not refear to the original page

            // Save Changes 
            $this->update();
        }                
        
        do_action('wpbc_bresources_check_submit_actions');

        ////////////////////////////////////////////////////////////////////////
        // JavaScript: Tooltips, Popover, Datepick (js & css) 
        ////////////////////////////////////////////////////////////////////////
        
        echo '<span class="wpdevelop">';
        
        wpbc_js_for_bookings_page();

        // Toolbar
        $this->toolbar();


        echo '</span>';

        ?><div class="clear" style="margin-bottom:5px;"></div><?php
        
        
        // Scroll links ////////////////////////////////////////////////////////
        if (0) {
        ?>
        <div class="wpdvlp-sub-tabs" style="background:none;border:none;box-shadow: none;padding:0;"><span class="nav-tabs" style="text-align:right;">
            <?php  if ( class_exists('wpdev_bk_personal') ) {  ?>
            <a href="javascript:void(0);" onclick="javascript:wpbc_scroll_to('#wpbc_booking_resource_table' );" original-title="" class="nav-tab go-to-link"><span><?php esc_html_e('Resources' ,'booking'); ?></span></a>
            <?php } ?>
        </span></div>
        <?php
        }
        
//        wpbc_toolbar_search_by_id__top_form( array(
//                                                    'search_form_id' => 'wpbc_booking_resources_search_form'
//                                                  , 'search_get_key' => 'wh_resource_id'
//                                                  , 'is_pseudo'      => false
//                                            ) );


	    do_action( 'wpbc_hook_settings_page_before_content_table', 'resources');              // Define Notices Section and show some static messages, if needed

        ////////////////////////////////////////////////////////////////////////
        // Content  ////////////////////////////////////////////////////////////
        ?>
        <div class="clear" style="margin-bottom:0px;"></div>
        <span class="metabox-holder">
            <form  name="<?php echo esc_attr( $submit_form_name ); ?>" id="<?php echo esc_attr( $submit_form_name ); ?>" action="" method="post" autocomplete="off">
                <?php 
                   // N o n c e   field, and key for checking   S u b m i t 
                   wp_nonce_field( 'wpbc_settings_page_' . $submit_form_name );
                ?><input type="hidden" name="is_form_sbmitted_<?php echo esc_attr( $submit_form_name ); ?>" id="is_form_sbmitted_<?php echo esc_attr( $submit_form_name ); ?>" value="1" /><?php
                ?><div class="clear"></div><?php

	            // Add hidden input SEARCH KEY field into  main form, if previosly was searching by ID or Title
	            wpbc_hidden_search_by_id_field_in_main_form( array( 'search_get_key' => 'wh_resource_id' ) );			// FixIn: 8.0.1.12.

                ?>
                <div class="clear" style="margin-top:20px;"></div>
                <div id="wpbc_booking_resource_table" class="wpbc_booking_resource_table wpbc_settings_row wpbc_settings_row_rightNO"><?php
                
                    // wpbc_open_meta_box_section( 'wpbc_settings_bresources_resources', __('Resources', 'booking') );
                        
                        $this->wpbc_resources_table__show();
                        
                    // wpbc_close_meta_box_section();
                ?>
                </div>
                <div class="clear"></div>                
                <select id="bulk-action-selector-bottom" name="bulk-action">
                    <option value="-1"><?php esc_html_e('Bulk Actions', 'booking'); ?></option>
                    <option value="edit"><?php esc_html_e('Edit', 'booking'); ?></option>
                    <option value="delete"><?php esc_html_e('Delete', 'booking'); ?></option>
                </select>    
                
                <a href="javascript:void(0);" onclick="javascript: jQuery('#wpbc_bresources').trigger( 'submit' );"
                  class="button button-primary wpbc_button_save" ><?php esc_html_e('Save Changes','booking'); ?></a>
                <a href="javascript:void(0);" id="wpbc_button_delete"
                  class="button wpbc_button_delete" style="display:none;background: #d9534f;border:#b92c28 1px solid;color:#eee;" ><?php esc_html_e('Delete','booking'); ?></a>
                
                    
                <span class="wpbc_button_delete" style="display:none;">
                    <div class="clear" style="height:10px;"></div>
                    <div class="wpbc-settings-notice notice-warning" style="text-align:left;">
                        <strong><?php esc_html_e('Note!' ,'booking'); ?></strong> <?php
                            /* translators: 1: ... */
                            echo wp_kses_post( sprintf( __( 'Please reassign exist booking(s) from selected resource(s) to other resources or delete exist booking(s) from  this resource(s). Otherwise you will have %1$slost bookings%2$s.', 'booking' )
                                    ,'<a href="' . wpbc_get_menu_url('booking') . '&wh_booking_type" >','</a>') );
                        ?>
                    </div>
                    <div class="clear" ></div>
                </span>    
                    
                    
            </form>
            <script type="text/javascript">
                jQuery('#bulk-action-selector-bottom').on( 'change', function(){    
                    if ( jQuery('#bulk-action-selector-bottom option:selected').val() == 'delete' ) { 
                        jQuery('.wpbc_button_delete').show();
                        jQuery('.wpbc_button_save').hide();
                    } else {
                        jQuery('.wpbc_button_delete').hide();
                        jQuery('.wpbc_button_save').show();
                    }
                } ); 
                jQuery('#wpbc_button_delete').on( 'click', function(){    
                    if ( wpbc_are_you_sure('<?php echo esc_js( __('Do you really want to do this ?' ,'booking') ); ?>') ) { 
                        jQuery('#wpbc_bresources').trigger( 'submit' );
                    }
                } ); 
            </script>
        </span>
        <?php       
    
        do_action( 'wpbc_hook_settings_page_footer', 'resources' );
        
        $this->enqueue_js();
    }


    /** Save Chanages */  
    public function update() {

	    make_bk_action( 'wpbc_reinit_booking_resource_cache' );
//        if (  ( wpbc_is_this_demo() ) ||  ( ! class_exists( 'wpdev_bk_personal' ) )  )
//            return;

        global $wpdb;

        $wpbc_br_table = new WPBC_BR_Table( 'resources_submit' );
        $linear_resources_for_one_page = $wpbc_br_table->get_linear_data_for_one_page();
                
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
        if ( isset( $_POST['bulk-action' ] ) )
            $submit_action = sanitize_text_field( wp_unslash( $_POST['bulk-action' ] ) );  /* phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing */ /* FixIn: sanitize_unslash */
        else 
            $submit_action = 'edit';
        
        $bulk_action_arr_id = array();
        
        foreach ( $linear_resources_for_one_page as $resource_id => $resource ) {

            // Check posts of only visible on page booking resources 
            // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
            if ( isset( $_POST['booking_resource_' . $resource_id ] ) ) {

                    switch ( $submit_action ) {
                        case 'delete':                                          // Delete

                            // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
                            if ( isset( $_POST['br-select-' . $resource_id ] ) )
                                    $bulk_action_arr_id[] = intval( $resource_id );
                            break;

                        default:                                                // Edit

								// Update number of booking resources per page											// FixIn: 9.9.0.22.
								// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
								if ( ! empty( $_POST['booking_resourses_num_per_page'] ) ) {
									$booking_resourses_num_per_page = intval( $_POST['booking_resourses_num_per_page'] );  // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
									if ( ( $booking_resourses_num_per_page > 0 ) && ( $booking_resourses_num_per_page < 501 ) ) {
										update_bk_option( 'booking_resourses_num_per_page', $booking_resourses_num_per_page );
									}
								}

                                // Validate POST value
                                $validated_value = WPBC_Settings_API::validate_text_post_static( 'booking_resource_' . $resource_id );

                                //if ( $validated_value != $resource['title'] ) {               // Check  if its different from  original value in DB

                                    // Need this complex query  for ability to  define different paramaters in differnt versions.
                                    $sql_arr = apply_filters(   'wpbc_resources_table__update_sql_array'
                                                                        , array(
                                                                                'sql'       => array(
                                                                                                      'start'   => "UPDATE {$wpdb->prefix}bookingtypes SET "
                                                                                                    , 'params' => array( 'title = %s' )                         
                                                                                                    , 'end'    => " WHERE booking_type_id = %d"
                                                                                            )
                                                                                , 'values'  => array( $validated_value )
                                                                            )
                                                                        , $resource_id, $resource 
                                                        );                
                                    $sql_arr['values'][] = intval( $resource_id );              // last parameter  for " WHERE booking_type_id = %d "
							// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.PreparedSQLPlaceholders.UnfinishedPrepare
							$sql = $wpdb->prepare( $sql_arr['sql']['start'] . implode( ', ', $sql_arr['sql']['params'] ) . $sql_arr['sql']['end'], $sql_arr['values'] );

							// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
							if ( false === $wpdb->query( $sql ) ) {
								debuge_error( 'Error saving to DB', __FILE__, __LINE__ );
							}

									// Update Resource Property - Shortcode  											// FixIn: 9.9.0.14.
									// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
									if ( isset( $_POST[ 'booking_resource_shortcode_' . $resource_id ] ) ) {
										$validated_shortcode_value = WPBC_Settings_API::validate_text_post_static( 'booking_resource_shortcode_' . $resource_id );

										wpbc_save_resource_property( $resource_id, 'shortcode_default', $validated_shortcode_value );
									}

                                    wpbc_show_changes_saved_message();   
                            break;
                    }

                    
                //}
            }

        }


        
        if ( ! empty( $bulk_action_arr_id ) ) {
            
                    switch ( $submit_action ) {
                        
                        case 'delete':                                          // Delete

							// Check booking resources in demo that  does not possible to  delete						// FixIn: 9.4.2.2.
	                        if ( wpbc_is_this_demo() ) {
		                        $new_bulk_action_arr_id = array();
		                        foreach ( $bulk_action_arr_id as $resource_id ) {

									$maximum_safe_resource_id = 4;
									if ( class_exists( 'wpdev_bk_biz_l' ) ) {
										$maximum_safe_resource_id = 12;
									}
									if ( class_exists( 'wpdev_bk_multiuser' ) ) {
										$maximum_safe_resource_id = 17;
									}

									if ( $resource_id > $maximum_safe_resource_id ) {
										$new_bulk_action_arr_id[] = $resource_id;
									} else {
										wpbc_show_message( sprintf( 'Booking resource ID=%d can not be deleted, because this is demo.', $resource_id ), 5 );
									}
		                        }
								$bulk_action_arr_id = $new_bulk_action_arr_id;
	                        }
	                        if ( ! empty( $bulk_action_arr_id ) ) {
								$bulk_action_arr_id = implode( ',', $bulk_action_arr_id );

		                        $sql = "DELETE FROM {$wpdb->prefix}bookingtypes WHERE booking_type_id IN ({$bulk_action_arr_id})";

								// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
								if ( false === $wpdb->query( $sql ) ) {
									debuge_error( 'Error during deleting items in DB', __FILE__, __LINE__ );
								}

		                        do_action( 'wpbc_deleted_booking_resources', $bulk_action_arr_id );                     // FixIn: 10.0.0.35.

								wpbc_show_message( __( 'Deleted', 'booking' ), 5 );
							}
                        default:                                                // Edit
                            break;
                    }
        }
        
        make_bk_action( 'wpbc_reinit_booking_resource_cache' );

        
        
        
        /**
        // Get Validated Email fields
        $validated_fields = $this->get_api()->validate_post();        
        $validated_fields = apply_filters( 'wpbc_fields_before_saving_to_db__bresources', $validated_fields );   //Hook for validated fields.        
//debuge($validated_fields);                
        $this->get_api()->save_to_db( $validated_fields );
        */
        
             
        
        // Old way of saving:
        // update_bk_option( 'booking_cache_expiration' , WPBC_Settings_API::validate_text_post_static( 'booking_cache_expiration' ) );
    }



    // <editor-fold     defaultstate="collapsed"                        desc=" CSS  &   JS   "  >
    
    /** CSS for this page */
    private function css() {
        ?>
        <style type="text/css">  
            .wpbc-help-message {
                border:none;
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
                font-weight: 600;
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
    
    
    
    /**
	 * Add Custon JavaScript - for some specific settings options
     *      Executed After post content, after initial definition of settings,  and possible definition after POST request.
     * 
     * @param type $menu_slug
     */
    private function enqueue_js(){                                                        
        
        // JavaScript //////////////////////////////////////////////////////////////
        
        $js_script = '';
        
        /*
        //Show|Hide grayed section      
        $js_script .= " 
                        if ( ! jQuery('#bresources_booking_gcal_auto_import_is_active').is(':checked') ) {   
                            jQuery('.wpbc_tr_auto_import').addClass('hidden_items'); 
                        }
                      ";        
        // Hide|Show  on Click      Checkbox
        $js_script .= " jQuery('#bresources_booking_gcal_auto_import_is_active').on( 'change', function(){    
                                if ( this.checked ) { 
                                    jQuery('.wpbc_tr_auto_import').removeClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_tr_auto_import').addClass('hidden_items');
                                }
                            } ); ";                     
        // Hide|Show  on Click      Radion
        $js_script .= " jQuery('input[name=\"paypal_pro_hosted_solution\"]').on( 'change', function(){    
                                jQuery('.wpbc_sub_settings_paypal_account_type').addClass('hidden_items'); 
                                if ( jQuery('#paypal_type_standard').is(':checked') ) {   
                                    jQuery('.wpbc_sub_settings_paypal_standard').removeClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_sub_settings_paypal_pro_hosted').removeClass('hidden_items');
                                }
                            } ); ";        
        */
        ////////////////////////////////////////////////////////////////////////
        
        
        // Eneque JS to  the footer of the page
        wpbc_enqueue_js( $js_script );                
    }

    // </editor-fold>
    
    
	// -----------------------------------------------------------------------------------------------------------------
    // Toolbar
	// -----------------------------------------------------------------------------------------------------------------
    /** Show Toolbar  - Add new booking resources */
    private function toolbar() {
        
        wpbc_add_new_booking_resource_toolbar();        
    }
    
	// -----------------------------------------------------------------------------------------------------------------
    //   B o o k i n g      R e s o u r c e s      T a b l e 
	// -----------------------------------------------------------------------------------------------------------------
    /** Show booking resources table */
    public function wpbc_resources_table__show() {    
        // echo ( ( wpbc_is_this_demo() ) ? wpbc_get_warning_text_in_demo_mode() . '<div class="clear" style="height:20px;"></div>' : '' );
        
        $columns = array();
        $columns[ 'check' ] = array( 'title' => '<input type="checkbox" value="" id="br-select-all" name="resource_id_all" />'
                                        , 'class' => 'wpbc_flextable_col_check check-column'
                                    );
        $columns[ 'id' ] = array(         'title' =>__( 'ID', 'booking' )
                                        , 'style' => 'width:5em;'
                                        , 'class' => 'wpbc_flextable_col_id'
                                        , 'sortable' => true 
                                    );
        $columns[ 'title' ] = array(      'title' => __( 'Resource Name', 'booking' )
                                        , 'style' => ''
                                        , 'class' => 'wpbc_flextable_col_title'
                                        , 'sortable' => true
                                    );
//        $columns = apply_filters ('wpbc_resources_table_header__cost_title' , $columns );
//        $columns = apply_filters ('wpbc_resources_table_header__customform_title' , $columns );
//        $columns = apply_filters ('wpbc_resources_table_header__parentchild_title' , $columns );
//        $columns = apply_filters ('wpbc_resources_table_header__info_title' , $columns );
//        $columns = apply_filters ('wpbc_resources_table_header__user_title' , $columns );
//	    if ( ( ! class_exists( 'wpdev_bk_biz_l' ) ) || ( 0 ) ) {
//			$columns[ 'shortcode' ] = array(      'title' => __( 'Shortcode for page', 'booking' )
//									, 'style' => 'text-align:center;'
//									, 'sortable' => false
//									, 'class' => ''
//								);
//		}
//		$columns[ 'actions' ] = array(      'title' => __( 'Actions', 'booking' )
//								, 'style' => 'text-align:center;'
//								, 'sortable' => false
//								, 'class' => ''
//							);
		$columns[ 'other' ] = array(      'title' => wpbc_resource_page__get_dropdown_menu_view()//__( '...', 'booking' )
								, 'style' => ''
								, 'sortable' => false
								, 'class' => 'wpbc_flextable_col_other'
							);

        $wpbc_br_table = new WPBC_BR_FlexTable(
                            'resources' 
                            , array(
                                  'url_sufix'   =>  '#wpbc_resources_link'
                                , 'rows_func'   =>  array( $this, 'wpbc_resources_table__show_rows' ) 
                                , 'columns'     =>  $columns
                                , 'is_show_pseudo_search_form' => false
                            )
                        );

        $wpbc_br_table->display();             
    }   
    

    /**
	 * Show rows for booking resource table
     * 
     * @param int $row_num
     * @param array $resource
     */
    public function wpbc_resources_table__show_rows( $row_num, $resource ) {

        $css_class = ' wpbc_resource_row';
        if ( class_exists( 'wpdev_bk_biz_l' ) ) {

                if ( intval($resource['count'] ) > 1 ) {  
                    $css_class .= ' wpbc_resource_parent wpbc_resource_capacity' . $resource['count'] ;
                } else {

                    if ( empty( $resource['parent'] ) ) {
                        $css_class .= ' wpbc_resource_single';
                    } else {
                        $css_class .= ' wpbc_resource_child';
                    }
                }
        }
		// FixIn: 9.9.0.6.
        ?><div class="wpbc_flextable_row wpbc_resource_row_main wpbc_list_row wpbc_row<?php echo esc_attr( $css_class ); ?>" id="resource_<?php echo esc_attr( $resource['id'] ); ?>"><?php
			// =========================================================================================================
			// Checkbox
			// =========================================================================================================
			?><div class="wpbc_flextable_col wpbc_flextable_col_check check-column">
					<label class="screen-reader-text" for="br-select-<?php echo esc_attr( $resource['id' ] ); ?>"><?php echo esc_js(__('Select Booking Resource', 'booking')); ?></label>
					<input type="checkbox"  style="margin-top: 1px;"
								   id="br-select-<?php echo esc_attr( $resource['id' ] ); ?>"
								   name="br-select-<?php echo esc_attr( $resource['id' ] ); ?>"
								   value="resource_<?php echo esc_attr( $resource['id' ] ); ?>"
						/>
			</div><?php
			// =========================================================================================================
			// ID
			// =========================================================================================================
			?><div class="wpbc_flextable_col wpbc_flextable_col_id">
				<div class="wpbc_listing_col wpbc_col_booking_labels wpbc_col_labels wpbc_label_resource_id_container">
					<span class="wpbc_label wpbc_label_booking_id wpbc_label_resource_id">
						<?php echo wp_kses_post( $resource['id' ] ); ?>
					</span>
				</div>
			</div><?php

			?><div class="wpbc_flextable_col wpbc_resource_name"><?php

					// =================================================================================================
					// Folders
					// =================================================================================================
					$resource_capacity   = ( ! empty( $resource['count'] ) ) ? $resource['count'] : 1;
					$resource_parent     = ( ! empty( $resource['parent'] ) ) ? $resource['parent'] : 0;
					$resource_last_child = ( ! empty( $resource['last_child'] ) ) ? $resource['last_child'] : 0;
					wpbc_flextable_reused_ui__folders_icons( $resource_parent, $resource_capacity, $resource_last_child );

					// =========================================================================================================
					// Title
					// =========================================================================================================
					?><div class="wpbc_flextable_col wpbc_flextable_col_title">
						<input type="text" class="large-text"
							   style="float:right;<?php echo ( ( ! empty( $resource['parent'] ) ) ? 'width:90%;font-weight:400;' : 'width:99%;font-weight:600;' ); ?>"
								 id="booking_resource_<?php echo esc_attr( $resource['id' ] ); ?>"
							   name="booking_resource_<?php echo esc_attr( $resource['id' ] ); ?>"
							   value="<?php echo esc_attr( $resource['title'] ); ?>"
						/>
					</div><?php

			?></div><?php
			// =========================================================================================================
			// Labels
			// =========================================================================================================
		    ?><div class="wpbc_flextable_col wpbc_flextable_labels">
					<div class="wpbc_resource_field__labels">
						<div class="wpbc_ajx_toolbar">
							<div class="ui_container ui_container_small">
								<div class="ui_group ui_group__labels">
								<?php
									if ( class_exists( 'wpdev_bk_biz_s' ) ) {
										// Cost Label
										wpbc_flextable_reused_ui__label_cost( $resource['id'], $resource['cost'] );
									}
									if ( class_exists( 'wpdev_bk_biz_m' ) ) {
										// Default Form
										$resource_default_form = ( ! empty( $resource['default_form'] ) ) ? $resource['default_form'] : '';
										wpbc_flextable_reused_ui__label_default_form( $resource_default_form );
									}
									if ( class_exists( 'wpdev_bk_biz_l' ) ) {
										// Parent | Child | Single
										$resource_capacity = ( ! empty( $resource['count'] ) ) ? $resource['count'] : 1;
										$resource_parent   = ( ! empty( $resource['parent'] ) ) ? $resource['parent'] : 0;
										wpbc_flextable_reused_ui__label_parent_child( $resource_parent, $resource_capacity );
									}
									if ( class_exists( 'wpdev_bk_multiuser' ) ) {
										// User Owner Label
										$resource_user_id = ( ! empty( $resource['users'] ) ) ? $resource['users'] : 0;
										wpbc_flextable_reused_ui__label_user_owner( $resource_user_id );
									}
								?>
								</div>
							</div>
						</div>
					</div>
			</div><?php

			// =========================================================================================================
			// Different Data
			// =========================================================================================================
		    ?><div class="wpbc_flextable_col wpbc_flextable_col_other wpbc_other_resource_fields">
					<div class="wpbc_resource_field__switchable wpbc_resource_field__publish">
						<div class="wpbc_ajx_toolbar">
							<div class="ui_container ui_container_small">
								<div class="ui_group ui_group__shortcode">
									<div class="ui_element" style="flex: 1 1 auto;margin: 0 0px 0 0;">
										<?php
										// Get property  of booking resource: "shortcode_default"  (such function use cache )		// FixIn: 9.9.0.14.
										$shortcode_default_value = wpbc_get_resource_property( intval( $resource['id'] ), 'shortcode_default' );
										$shortcode_default_value = empty( $shortcode_default_value ) ? '' : $shortcode_default_value;		// Check  if value == false
										/*
										?>
										<input type="text"
											   value="<?php echo ( ! empty( $shortcode_default_value ) )
												   				  ? esc_attr( $shortcode_default_value )
												   				  : '[booking resource_id=' . intval( $resource['id'] ) . ']';
											   	   ?>"
											   id="booking_resource_shortcode_<?php echo intval( $resource['id' ] ); ?>"
											   name="booking_resource_shortcode_<?php echo intval( $resource['id' ] ); ?>"
											   readonly="readonly"
											   onfocus="this.select()"
											   class="shortcode_text_field large-text put-in"
											   />
										<?php
										*/
										?>
										<div  id="div_booking_resource_shortcode_<?php echo intval( $resource['id' ] ); ?>"
												   name="div_booking_resource_shortcode_<?php echo intval( $resource['id' ] ); ?>"
												   class="shortcode_text_field large-text put-in"
											   ><?php echo ( ! empty( $shortcode_default_value ) )
												   				  ? esc_attr( $shortcode_default_value )
												   				  : '[booking resource_id=' . intval( $resource['id'] ) . ']';
										?></div>
										<input type="hidden"
											   value="<?php echo ( ! empty( $shortcode_default_value ) )
												   				  ? esc_attr( $shortcode_default_value )
												   				  : '[booking resource_id=' . intval( $resource['id'] ) . ']';
											   	   ?>"
											   id="booking_resource_shortcode_<?php echo intval( $resource['id' ] ); ?>"
											   name="booking_resource_shortcode_<?php echo intval( $resource['id' ] ); ?>"
											   />
									</div>
									<div class="ui_element" style="margin-left: 0px;margin-right: 0px;">
									   <a href="https://wpbookingcalendar.com/faq/#shortcodes" class="tooltip_top wpbc-bi-question-circle"	title="<?php esc_attr_e( 'Learn how to integrate the booking form into a page using the shortcode.','booking'); ?>"></a>
									</div>
								</div>
								<div class="ui_group ui_group__publish_btn">
									<div class="ui_element" style="margin: 0 15px 0 0;">
										<a href="javascript:void(0)" onclick="javascript:wpbc_resource_page_btn_click(<?php echo intval( $resource['id'] ); ?>);"
										   id="ui_btn_erase_availability" class="wpbc_ui_control wpbc_ui_button wpbc_ui_button_danger0 tooltip_top "
										   title="<?php esc_attr_e( 'Customize Booking Calendar shortcode','booking'); ?>"  >
												<span style="display: none;"><?php esc_html_e('Customize','booking'); ?>&nbsp;&nbsp;&nbsp;</span>
												<i class="menu_icon icon-1x wpbc_icn_tune"></i>
										</a>
									</div>
									<div class="ui_element" style="margin: 0 2px 0 0;">
										<a class="wpbc_ui_control wpbc_ui_button wpbc_ui_button_primary tooltip_top "
										   href="javascript:void(0);" onclick="javascript: wpbc_modal_dialog__show__resource_publish( <?php echo esc_attr( $resource['id'] ); ?> );"
											title="<?php esc_attr_e('Embed your booking form into the page', 'booking'); ?>">
											<span style=" "><?php esc_html_e( 'Publish', 'booking' ); ?></span>
											<i class="menu_icon icon-1x wpbc_icn_tune" style="display: none;"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="wpbc_resource_field__switchable wpbc_resource_field__cost">
						<div class="wpbc_ajx_toolbar">
							<div class="ui_container ui_container_small">
								<div class="ui_group ui_group__cost_field">
									<?php do_action( 'wpbc_resources_table_show_col__cost_field', $row_num, $resource ); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="wpbc_resource_field__switchable wpbc_resource_field__default_form">
						<div class="wpbc_ajx_toolbar">
							<div class="ui_container ui_container_small">
								<div class="ui_group ui_group__customform_field">
									<div class="ui_element" style="flex:1 1 auto;">
										<?php do_action( 'wpbc_resources_table_show_col__customform_field',  	$row_num, $resource ); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="wpbc_resource_field__switchable wpbc_resource_field__parent_child_priority">
						<div class="wpbc_ajx_toolbar">
							<div class="ui_container ui_container_small">
								<div class="ui_group ui_group__parent_field">
									<?php do_action( 'wpbc_resources_table_show_col__parentchild_field',  	$row_num, $resource ); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="wpbc_resource_field__switchable wpbc_resource_field__user_owner">
						<div class="wpbc_ajx_toolbar">
							<div class="ui_container ui_container_small">
								<div class="ui_group ui_group__user_field">
									<div class="ui_element">
										<?php do_action( 'wpbc_resources_table_show_col__user_field',         	$row_num, $resource ); ?>
									</div>
									<?php
									if ( isset( $resource['users'] ) ) {
										do_action( 'wpbc_show_simulate_login_button', $resource['users'] );				// FixIn: 10.0.0.15.
									}
									?>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
        <?php
    }

}
add_action('wpbc_menu_created', array( new WPBC_Page_Settings__bresources() , '__construct') );    // Executed after creation of Menu


/**
	 * Validate some fields during saving to DB
 *  Skip  saving some pseudo  options,  instead of that  creare new real  option.
 * 
 * @param array $validated_fields
 * @return type
 */
function wpbc_fields_before_saving_to_db__bresources( $validated_fields ) {
    
    /*
    // Set  new option based on pseudo  options
    $validated_fields['booking_gcal_events_form_fields'] = array( 'Tada' );
    // Unset  several pseudo options.
    unset( $validated_fields['booking_gcal_events_form_fields_title'] );
    */
    
    return $validated_fields;
}
add_filter('wpbc_fields_before_saving_to_db__bresources', 'wpbc_fields_before_saving_to_db__bresources');


/**
 * Flex Table   -  H e a d e r    T a b s
 */
function wpbc_resource_page__get_dropdown_menu_view() {

	ob_start();
	ob_clean();

	?><span class="wpbc_flextable_header_tabs__resources wpdevelop"><?php			// Class 'wpdevelop' here required for correct  showing dropdown menu in this Tabs

	wpbc_flextable_header_tabs_html_container_start();

		wpbc_bs_display_tab(   array(
											'title'         => __('Publish', 'booking')
											, 'font_icon'   => 'wpbc_icn_publish'
											, 'hint' 		=> array( 'title' => __('Show Publish Options' ,'booking') , 'position' => 'top' )
											, 'onclick'     =>  "jQuery('.wpbc_resource_field__switchable').hide();"
																. "jQuery('.wpbc_resource_field__publish').show();"
																. "jQuery('.wpbc_flextable_header_tabs__resources .nav-tab').removeClass('nav-tab-active');"
																. "jQuery(this).addClass('nav-tab-active');"
																. "jQuery('.nav-tab i.icon-white').removeClass('icon-white');"
																. "jQuery('.nav-tab-active i').addClass('icon-white');"
											, 'default'     => true
											, 'attr'  => array( 'id' => 'flextable_header_tab__publish' )
							) );

		if ( class_exists( 'wpdev_bk_biz_s' ) ){
			wpbc_bs_display_tab(   array(
											'title'         => __('Cost', 'booking')
											, 'font_icon'   => 'wpbc_icn_payments'
											, 'hint' 		=> array( 'title' => __('Show Cost Options' ,'booking') , 'position' => 'top' )
											, 'onclick'     =>  "jQuery('.wpbc_resource_field__switchable').hide();"
																. "jQuery('.wpbc_resource_field__cost').show();"
																. "jQuery('.wpbc_flextable_header_tabs__resources .nav-tab').removeClass('nav-tab-active');"
																. "jQuery(this).addClass('nav-tab-active');"
																. "jQuery('.nav-tab i.icon-white').removeClass('icon-white');"
																. "jQuery('.nav-tab-active i').addClass('icon-white');"
											, 'default'     => false
											, 'attr'  => array( 'id' => 'flextable_header_tab__cost' )
							) );
		}

		if ( class_exists( 'wpdev_bk_biz_m' ) ){
			wpbc_bs_display_tab(   array(
											'title'         => __('Default Form', 'booking')
											, 'font_icon'   => 'wpbc_icn_dashboard'
											, 'hint' 		=> array( 'title' => __('Show Default Form Options' ,'booking') , 'position' => 'top' )
											, 'onclick'     =>  "jQuery('.wpbc_resource_field__switchable').hide();"
																. "jQuery('.wpbc_resource_field__default_form').show();"
																. "jQuery('.wpbc_flextable_header_tabs__resources .nav-tab').removeClass('nav-tab-active');"
																. "jQuery(this).addClass('nav-tab-active');"
																. "jQuery('.nav-tab i.icon-white').removeClass('icon-white');"
																. "jQuery('.nav-tab-active i').addClass('icon-white');"
											, 'default'     => false
											, 'attr'  => array( 'id' => 'flextable_header_tab__default_form' )

							) );
		}

		if ( class_exists( 'wpdev_bk_biz_l' ) ){
			wpbc_bs_display_tab(   array(
											'title'         => __('Capacity', 'booking')
											, 'font_icon'   => 'wpbc_icn_folder_copy'
											, 'hint' 		=> array( 'title' => __('Show Capacity Options' ,'booking') , 'position' => 'top' )
											, 'onclick'     =>  "jQuery('.wpbc_resource_field__switchable').hide();"
																. "jQuery('.wpbc_resource_field__parent_child_priority').show();"
																. "jQuery('.wpbc_flextable_header_tabs__resources .nav-tab').removeClass('nav-tab-active');"
																. "jQuery(this).addClass('nav-tab-active');"
																. "jQuery('.nav-tab i.icon-white').removeClass('icon-white');"
																. "jQuery('.nav-tab-active i').addClass('icon-white');"
											, 'default'     => false
											, 'attr'  => array( 'id' => 'flextable_header_tab__capacity' )

							) );
		}

		if ( class_exists( 'wpdev_bk_multiuser' ) ) {

			$is_can = apply_bk_filter( 'multiuser_is_user_can_be_here', true, 'only_super_admin' );
			if ( $is_can ) {

				wpbc_bs_display_tab(   array(
											'title'         => __('Owner', 'booking')
											, 'font_icon'   => 'wpbc_icn_people_alt'
											, 'hint' 		=> array( 'title' => __('Show User Owner of booking resources' ,'booking') , 'position' => 'top' )
											, 'onclick'     =>  "jQuery('.wpbc_resource_field__switchable').hide();"
																. "jQuery('.wpbc_resource_field__user_owner').show();"
																. "jQuery('.wpbc_flextable_header_tabs__resources .nav-tab').removeClass('nav-tab-active');"
																. "jQuery(this).addClass('nav-tab-active');"
																. "jQuery('.nav-tab i.icon-white').removeClass('icon-white');"
																. "jQuery('.nav-tab-active i').addClass('icon-white');"
											, 'default'     => false
											, 'attr'  => array( 'id' => 'flextable_header_tab__user_owner' )

							) );
			}
		}


		// -------------------------------------------------------------------------------------------------------------
		// ORDER BY options
		// -------------------------------------------------------------------------------------------------------------
		$sort_order_items_arr = array();
		$sort_font_icon = 'wpbc_icn_swap_vert';
		// Cost
		if ( class_exists( 'wpdev_bk_biz_s' ) ){

			$sort_url =  wpbc_get_resources_url( true, false ) .  '&orderby=cost'
							   . ( ( ( ! empty( $_GET['order'] ) ) && ( 'asc' === $_GET['order'] ) ) ? '&order=desc' : '&order=asc' )  // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
							   . '#wpbc_resources_link';

			$sort_icn = '';
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
			if ( ( ! empty( $_GET['orderby'] ) ) && ( 'cost' === $_GET['orderby'] ) ) {
				$sort_icn	= ( ( ( ! empty( $_GET['order'] ) ) && ( 'asc' === $_GET['order'] ) )    // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
									? ' <span aria-hidden="true" class="wpbc_icn_vertical_align_top"></span>'
									: ' <span aria-hidden="true" class="wpbc_icn_vertical_align_bottom"></span>'
								);
				$sort_font_icon = ( ( ( ! empty( $_GET['order'] ) ) && ( 'asc' === $_GET['order'] ) ) ? 'wpbc_icn_vertical_align_top' : 'wpbc_icn_vertical_align_bottom' );    // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
			}

			$sort_order_items_arr[] = array(
				'type'  => 'link',
				'title' => __( 'Cost', 'booking' ) . $sort_icn,
				'url'   => $sort_url
			);
		}

		// Priority
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
		if ( class_exists( 'wpdev_bk_biz_l' ) ){
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
			if ( empty( $_GET['orderby'] ) ){
				$_GET['orderby'] = 'prioritet';
				$_GET['order'] = 'asc';
			}
			$sort_url =  wpbc_get_resources_url( true, false ) .  '&orderby=prioritet'
							   . ( ( ( ! empty( $_GET['order'] ) ) && ( 'asc' === $_GET['order'] ) ) ? '&order=desc' : '&order=asc' )    // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
							   . '#wpbc_resources_link';

			$sort_icn = '';
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
			if ( ( ! empty( $_GET['orderby'] ) ) && ( 'prioritet' === $_GET['orderby'] ) ) {
				$sort_icn	= ( ( ( ! empty( $_GET['order'] ) ) && ( 'asc' === $_GET['order'] ) )    // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
									? ' <span aria-hidden="true" class="wpbc_icn_vertical_align_top"></span>'
									: ' <span aria-hidden="true" class="wpbc_icn_vertical_align_bottom"></span>'
								);
				$sort_font_icon = ( ( ( ! empty( $_GET['order'] ) ) && ( 'asc' === $_GET['order'] ) ) ? 'wpbc_icn_vertical_align_top' : 'wpbc_icn_vertical_align_bottom' );    // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
			}

			$sort_order_items_arr[] = array(
				'type'  => 'link',
				'title' => __( 'Priority', 'booking' ) . $sort_icn,
				'url'   => $sort_url
			);
		}

		// Users
		if ( class_exists( 'wpdev_bk_multiuser' ) ) {

			$is_can = apply_bk_filter( 'multiuser_is_user_can_be_here', true, 'only_super_admin' );
			if ( $is_can ) {

				$sort_url =  wpbc_get_resources_url( true, false ) .  '&orderby=users'
								   . ( ( ( ! empty( $_GET['order'] ) ) && ( 'asc' === $_GET['order'] ) ) ? '&order=desc' : '&order=asc' )    // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
								   . '#wpbc_resources_link';

				$sort_icn = '';
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
				if ( ( ! empty( $_GET['orderby'] ) ) && ( 'users' === $_GET['orderby'] ) ) {
					$sort_icn	= ( ( ( ! empty( $_GET['order'] ) ) && ( 'asc' === $_GET['order'] ) )    // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
										? ' <span aria-hidden="true" class=" wpbc_icn_vertical_align_top"></span>'
										: ' <span aria-hidden="true" class=" wpbc_icn_vertical_align_bottom"></span>'
									);
					$sort_font_icon = ( ( ( ! empty( $_GET['order'] ) ) && ( 'asc' === $_GET['order'] ) ) ? 'wpbc_icn_vertical_align_top' : 'wpbc_icn_vertical_align_bottom' );    // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
				}

				$sort_order_items_arr[] = array(
					'type'  => 'link',
					'title' => __( 'Users', 'booking' ) . $sort_icn,
					'url'   => $sort_url
				);
			}
		}

		if ( ! empty( $sort_order_items_arr ) ) {

				wpbc_bs_dropdown_menu( array(
											'title'     => '',										//__( 'Options', 'booking' ) . '&nbsp;',
											'font_icon' => $sort_font_icon, 						//'wpbc_icn_more_vert0 wpbc_icn_swap_vert',
											//'position'  => 'right',
											//'style'   => 'margin-left: auto;',        			// Right align
											'items'     => $sort_order_items_arr
								));
		}
		// -------------------------------------------------------------------------------------------------------------


	wpbc_flextable_header_tabs_html_container_end();

	?></span><?php

	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

// FixIn: 9.9.0.22.
/**
 * Define selectbox for the number of booking resources per page in footer (near pagination)  of Resources Flex table.
 * @param $id
 *
 * @return void
 */
function wpbc_selectable_foot__content_after__number_per_page( $id ){

	$is_can = apply_bk_filter( 'multiuser_is_user_can_be_here', true, 'only_super_admin' );
	if ( ! $is_can ) {
		return;
	}

	$items_per_page = intval( get_bk_option( 'booking_resourses_num_per_page' ) );

    $field_options = array();
    foreach ( array( 5, 10, 20, 25, 50  ) as $value ) {		// FixIn: 10.6.2.2.
        $field_options[ $value ] = $value;
    }
	//__('Resources number per page', 'booking')
	//__('Select number of booking resources (single or parent) per page at Resource menu page' , 'booking' ); ?><div class="wpbc-ajax-pagination_items_per_page">
		<div class="ui_element">
			<select class="wpbc_items_per_page wpbc_ui_control wpbc_ui_select " autocomplete="off" name="booking_resourses_num_per_page" id="booking_resourses_num_per_page">
				<?php
				foreach ( $field_options as $field_option_key => $field_option_val ) {

					$is_selected = ( $field_option_key == $items_per_page ) ? " selected='SELECTED' " : '';
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo "<option value='{$field_option_key}' {$is_selected}>{$field_option_val}</option>";
				}
				?>
			</select>
		</div>
		<div class="ui_element">
			<label class="wpbc_ui_control_label"><?php esc_html_e('per page', 'booking' ); ?></label>
		</div>
	</div><?php

}
add_action('wpbc_selectable_foot__content_after', 'wpbc_selectable_foot__content_after__number_per_page');
