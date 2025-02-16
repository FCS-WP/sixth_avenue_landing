<?php
/**
 * @version     1.0
 * @package     General Settings API - Saving different options
 * @category    Settings API
 * @author      wpdevelop
 *
 * @web-site    https://wpbookingcalendar.com/
 * @email       info@wpbookingcalendar.com 
 * @modified    2016-02-28
 * 
 * This is COMMERCIAL SCRIPT
 * We are not guarantee correct work and support of Booking Calendar, if some file(s) was modified by someone else then wpdevelop.
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


/**
	 * Booking resources Default and Count  - Settings ( Booking Listing ) page
 * 
 * @param array $fields 
 * @return array
 */
function wpbc_settings_booking_listing_br_default_count_p( $fields, $default_options_values ) {
    
    $field_options = array( 
                            '' => array(   
                                              'title' => __('All resources' ,'booking') 
                                            , 'attr'  => array ( 'class' => 'wpbc_parent_resource' , 'style' => 'border-bottom:1px solid #ccc;')         // Set bold!
                                        )
                          );    
    
    $bk_resources = wpbc_get_br_as_objects();  
    foreach ( $bk_resources as $br ) {
        
        if ( ! ( ( isset( $br->parent ) ) && ( $br->parent != 0 ) ) ) {         // Skip child booking resources
            
            $field_options[ $br->booking_type_id ] = array(   
                
                              'title' => $br->title
                            , 'attr' => array( 
                                                'class' => ( ( isset( $br->parent ) ) && ( $br->parent == 0 ) && ( isset( $br->count ) ) && ( $br->count > 1 ) ) 
                                                                ? 'wpbc_parent_resource' 
                                                                : ( ( ( isset( $br->parent ) ) && ( $br->parent != 0 ) ) 
                                                                                                                        ?  'wpbc_child_resource' 
                                                                                                                        : 'wpbc_single_resource'  
                                                                  )                                                                        
                                            ) 
                        );
        }
    }                    
    $fields['booking_default_booking_resource'] = array(   
                            'type'          => 'select'
                            , 'default'     => $default_options_values['booking_default_booking_resource']   //''            
                            , 'title'       => __('Default booking resource' ,'booking')
                            , 'description' => __('Select your default booking resource.' ,'booking')
                            , 'options'     => $field_options
                            , 'group'       => 'booking_listing'
                    );

	// -----------------------------------------------------------------------------------------------------------------
    $field_options = array();
    foreach ( array( 5, 10, 20, 25, 50 ) as $value ) {      // FixIn: 10.6.2.2.
        $field_options[ $value ] = $value;
    }
    $fields['booking_resourses_num_per_page'] = array(   
                            'type'          => 'select'
                            , 'default'     => $default_options_values['booking_resourses_num_per_page']   //'10'            
                            , 'title'       => __('Resources number per page', 'booking')
                            , 'description' => __('Select number of booking resources (single or parent) per page at Resource menu page' ,'booking')
                            , 'options'     => $field_options
                            , 'group'       => 'booking_listing'
                    );

    return $fields;
}
add_filter('wpbc_settings_booking_listing_br_default_count', 'wpbc_settings_booking_listing_br_default_count_p' ,10, 2);


/**
	 * Title in Timeline cells  - Settings ( Booking Listing ) page
 * 
 * @param array $fields 
 * @return array
 */
function wpbc_settings_booking_listing_timeline_title_in_day_p( $fields, $default_options_values ) {
    
	// <editor-fold     defaultstate="collapsed"                        desc=" Start / End time for Calendar Overview "  >
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// FixIn: 8.1.3.31.
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $fields['booking_calendar_overview_start_time_prefix'] = array( 'type' => 'pure_html', 'group' => 'booking_calendar_overview'  // FixIn: 8.9.4.4.
                                , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_calendar_overview_start_time">
                                                        <th scope="row">
                                                            <label class="wpbc-form-selectbox" for="set_gen_booking_calendar_overview_start_time">'
                                                            .   wp_kses_post(  __('Start - end time' ,'booking') )
                                                            . '</label>
                                                        </th>
                                                        <td><fieldset>'
                        );

    //  Start time
    $fields['booking_calendar_overview_start_time_label'] = array(
                                'type'    => 'pure_html'
                                , 'group' => 'booking_calendar_overview'  // FixIn: 8.9.4.4.
                                , 'html'  => WPBC_Settings_API::label_static( 'set_gen_booking_calendar_overview_start_time'
                                                                            , array(   'title'=> __('Start time', 'booking'), 'label_css' => 'margin: 0.25em 0 !important;vertical-align: middle;' ) )
        );
    $field_options = range(0, 23);
    $fields['booking_calendar_overview_start_time'] = array(
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_calendar_overview_start_time']   //'1'
                                , 'title'       => __('Start time', 'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'booking_calendar_overview'  // FixIn: 8.9.4.4.
                                , 'tr_class'    => ''
                                , 'css'         => 'margin-right:20px'
                                , 'only_field'  => true
                        );
    //  End time
    $fields['booking_calendar_overview_end_time_label'] = array(
                                  'type'  => 'pure_html'
                                , 'group' => 'booking_calendar_overview'  // FixIn: 8.9.4.4.
                                , 'html'  => WPBC_Settings_API::label_static( 'set_gen_booking_calendar_overview_end_time'
                                                                            , array(   'title'=> __('End time', 'booking'), 'label_css' => 'margin: 0.25em 0 !important;vertical-align: middle;' ) )
        );
    $field_options = array_combine( range(24, 1, -1), range(24, 1, -1) );
    $fields['booking_calendar_overview_end_time'] = array(
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_calendar_overview_end_time']   //'30'
                                , 'title'       => __('End time', 'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'booking_calendar_overview'  // FixIn: 8.9.4.4.
                                , 'tr_class'    => ''
                                , 'only_field'  => true
                        );

    $fields['booking_calendar_overview_start_time_sufix'] = array(
                                'type'          => 'pure_html'
                                , 'group'       => 'booking_calendar_overview'  // FixIn: 8.9.4.4.
                                , 'html'        => '          <p class="description">'
                                                                /* translators: 1: ... */
                                                                . sprintf( __( 'Select start and end time showing for Calendar Overview in %1$sDay%2$s view mode', 'booking' ),'<b>','</b>')
                                                        . '   </p>
                                                           </fieldset>
                                                        </td>
                                                    </tr>'
                        );

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
    $field_options = range(0, 23);
    $fields['booking_calendar_overview_start_time'] = array(
                            'type'          => 'select'
                            , 'default'     => $default_options_values['booking_calendar_overview_start_time']   //'10'
                            , 'title'       => __('Start Time for aalendar Overview', 'booking')
                            , 'description' => __('Select number of booking resources (single or parent) per page at Resource menu page' ,'booking')
                            , 'options'     => $field_options
                            , 'group'       => 'booking_timeline'    // FixIn: 8.5.2.20.
                    );

    $field_options = array_combine( range(24, 1, -1), range(24, 1, -1) );
    $fields['booking_calendar_overview_end_time'] = array(
                            'type'          => 'select'
                            , 'default'     => $default_options_values['booking_calendar_overview_end_time']   //'10'
                            , 'title'       => __('End Time for aalendar Overview', 'booking')
                            , 'description' => __('Select number of booking resources (single or parent) per page at Resource menu page' ,'booking')
                            , 'options'     => $field_options
                            , 'group'       => 'booking_timeline'    // FixIn: 8.5.2.20.
                    );
*/
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// </editor-fold>


    $fields['booking_default_title_in_day_for_calendar_view_mode'] = array(
                            'type'          => 'text'
                            , 'default'     => $default_options_values['booking_default_title_in_day_for_calendar_view_mode']   //'[id]:[name]'
                            , 'title'         => __('Booking title' ,'booking')
                            /* translators: 1: ... */
                            , 'description'   => sprintf( __( 'Type %1$sdefault title of bookings%2$s in calendar view mode at Booking Listing page (You can use the shortcodes from the bottom form of Settings Fields page).', 'booking' ),'<b>','</b>')
                            , 'group'       => 'booking_calendar_overview'  // FixIn: 8.9.4.4.
                            , 'css'         => 'width:100%;'
                            , 'placeholder' => '[id]:[name]'
        );


    //  Divider  ///////////////////////////////////////////////////////////////
    //$fields['hr_booking_listing_after_is_show_popover_in_timeline_front_end'] = array( 'type' => 'hr', 'group' => 'booking_timeline' );  // FixIn: 8.5.2.20.

    $fields['booking_default_title_in_day_for_timeline_front_end'] = array(  
                            'type'          => 'text'
                            , 'default'     => $default_options_values['booking_default_title_in_day_for_timeline_front_end']   //'[id]:[name]'
                            , 'title'         => __('Booking title' ,'booking')
                            /* translators: 1: ... */
                            , 'description'   => sprintf( __( 'Type %1$sdefault title of bookings%2$s in %3$stimeline at front-end side%4$s. You can use the shortcodes from the bottom form of Settings Fields page.', 'booking' ),'<b>','</b>','<b>','</b>')
                            , 'group'       => 'booking_timeline'    // FixIn: 8.5.2.20.
                            , 'css'         => 'width:100%;'
                            , 'placeholder' => '[id]:[name]'
        );    
    $fields['booking_is_show_popover_in_timeline_front_end'] = array(   
                            'type'          => 'checkbox'
                            , 'default'     => $default_options_values['booking_is_show_popover_in_timeline_front_end']   //'Off'            
                            , 'title'       =>  __('Booking details in popover' ,'booking')
                            /* translators: 1: ... */
                            , 'label'       => sprintf( __( 'Check this box if you want to %1$sshow popover with booking details%2$s in timeline at %3$sfront-end%4$s side.', 'booking' ),'<b>','</b>','<b>','</b>' )
                            , 'group'       => 'booking_timeline'    // FixIn: 8.5.2.20.
        );         

    return $fields;    
}
add_filter('wpbc_settings_booking_listing_timeline_title_in_day', 'wpbc_settings_booking_listing_timeline_title_in_day_p' ,10, 2);






/**
	 * Show / Hide some options  - Booking > Settings General page
 *
 * @param array $fields
 * @return array
 */
function wpbc_settings_booking_show_hide_options_p( $fields, $default_options_values ) {

	// FixIn: 8.4.5.4.
	$fields['booking_send_emails_off_addbooking'] = array(
                            'type'          => 'checkbox'
                            , 'default'     => $default_options_values['booking_send_emails_off_addbooking']         //'On'
                            , 'title'       => __('Deactivate send email option at Add Booking page' ,'booking')
                            , 'label'       => __('Check this box if you want to deactivate by default option "Send email" at Add Booking page.' ,'booking')
                            , 'description' => ''
                            , 'group'       => 'booking_listing'
    );

	// FixIn: 9.6.3.5.

	// Warning! The resource was not changed. Current dates are already booked there.
	// FixIn: 8.4.5.4.
	$fields['booking_change_resource_skip_checking'] = array(
                            'type'          => 'checkbox'
                            , 'default'     => $default_options_values['booking_change_resource_skip_checking']         //'On'
                            , 'title'       => __('Force change booking resource for exist booking' ,'booking')
                            , 'label'       => __('Check this box if you want to skip checking availability of new booking resource during changing booking resource of exist booking at Booking Listing page.' ,'booking')
                            , 'description' => ''
                            , 'group'       => 'booking_listing'
    );

	// FixIn: 8.6.1.10.
	$fields['booking_log_booking_actions'] = array(
                            'type'          => 'checkbox'
                            , 'default'     => $default_options_values['booking_log_booking_actions']         //'On'
                            , 'title'       => __('Logging actions for booking' ,'booking')
                            , 'label'       => __('Check this box if you want to log approving or rejection of bookings and add it to your booking notes.' ,'booking')
                            , 'description' => ''
                            , 'group'       => 'booking_listing'
    );


    return $fields;
}
add_filter('wpbc_settings_booking_show_hide_options', 'wpbc_settings_booking_show_hide_options_p' ,10, 2);


/**
	 * URL to edit bookings & HASH  - Settings ( Advanced ) page
 * 
 * @param array $fields 
 * @return array
 */
function wpbc_settings_edit_url_hash_p( $fields, $default_options_values ) {

	// Divider.
	// $fields['hr_url_bookings_edit_by_visitors'] = array( 'type' => 'hr', 'group' => 'advanced' ); //.

	$fields['booking_url_bookings_edit_by_visitors'] = array(
		'type'        => 'text',
		//site_url() . '/booking/edit/'.
		'default'     => $default_options_values['booking_url_bookings_edit_by_visitors'],
		'title'       => '<a id="url_booking_edit" href="#url_booking_edit" style="text-decoration: none;color:#23282d;">' . esc_html__( 'URL to edit bookings', 'booking' ) . '</a>',
		/* translators: 1: ... */
		'description' => sprintf( __( 'Type URL for %1$svisitors%2$s to edit bookings. You must insert %3$s shortcode into this page.', 'booking' ), '<b>', '</b>', '<code>[bookingedit]</code>' ) . ' ' /* translators: 1: ... */ . sprintf( __( 'Please read more info about configuration of this parameter %1$shere%2$s', 'booking' ), '<a href="https://wpbookingcalendar.com/faq/configure-editing-cancel-payment-bookings-for-visitors/" target="_blank">', '</a>' ),
		'group'       => 'bookings_options',
		'css'         => 'width:100%;',
		'placeholder' => site_url() . '/booking-edit/',
	);

	// FixIn: 8.1.3.5.1.
	$fields['booking_url_bookings_listing_by_customer'] = array(
		'type'        => 'text',
		// site_url() . '/booking/edit/'.
		'default'     => $default_options_values['booking_url_bookings_listing_by_customer'],
		'title'       => __( 'URL of page for customer bookings listing', 'booking' ),
		/* translators: 1: ... */
		'description' => sprintf( __( 'Type URL for %1$svisitors%2$s to view own bookings. You must insert %3$s shortcode into this page.', 'booking' ), '<b>', '</b>', '<code>[bookingcustomerlisting]</code>' ) . ' ' /* translators: 1: ... */ . sprintf( __( 'Please read more info about configuration of this parameter %1$shere%2$s', 'booking' ), '<a href="https://wpbookingcalendar.com/faq/configure-customer-bookings-listing/" target="_blank">', '</a>' ),
		'group'       => 'bookings_options',
		'css'         => 'width:100%;',
		'placeholder' => site_url() . '/bookings-listing/',
	);

	$fields['booking_is_change_hash_after_approvement'] = array(
		'type'        => 'checkbox',
		'default'     => $default_options_values['booking_is_change_hash_after_approvement'],
		'title'       => __( 'Change hash after booking is approved or declined', 'booking' ),
		'label'       => __( 'Check this box if you want to change the booking hash after approval or rejection. If this box is checked, the visitor will not be able to edit or cancel the booking.', 'booking' ),
		'description' => '',
		'group'       => 'bookings_options',
	);

	return $fields;
}

add_filter( 'wpbc_settings_edit_url_hash', 'wpbc_settings_edit_url_hash_p', 10, 2 );
