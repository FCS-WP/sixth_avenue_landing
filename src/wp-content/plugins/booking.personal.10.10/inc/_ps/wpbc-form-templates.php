<?php
/**
 * @version     1.0
 * @package     Booking Calendar
 * @category    Default Form Templates
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


////////////////////////////////////////////////////////////////////////////////
// Booking Form Templates
////////////////////////////////////////////////////////////////////////////////            

/**
	 * Get Default Booking Form during activation of plugin or get  this data for init creation of custom booking form
 * 
 * @return string
 */
function wpbc_get_default_booking_form() {    
    
    $is_demo = wpbc_is_this_demo();

	$booking_form = wpbc_get__booking_form__template( 'standard' );

	if ( class_exists( 'wpdev_bk_personal' ) ) {
		$booking_form = wpbc_get__booking_form__template( '2_columns' );
	}

	if ( class_exists( 'wpdev_bk_biz_s' ) ) {
		$booking_form = wpbc_get__booking_form__template( '2_columns_times_2_hours' );
	}

	if ( ( $is_demo ) && ( class_exists( 'wpdev_bk_biz_s' ) ) ){
		// $booking_form = wpbc_get__booking_form__template( 'appointments30' );   // '2_columns_times_30_minutes_wizard' );  // FixIn: 10.7.1.4.
		$booking_form = wpbc_get__booking_form__template( 'appointments_service_b' );   // FixIn: 10.9.6.5.
	}

	if ( ( class_exists( 'wpdev_bk_biz_m' ) ) ) {
		$booking_form = wpbc_get__booking_form__template( '2_columns_hint_cost_nights' );
	}

	if ( ( class_exists( 'wpdev_bk_biz_l' ) )  ) {
		$booking_form = wpbc_get__booking_form__template( '2_columns_hint_availability' );
	}


	if ( ( class_exists( 'wpdev_bk_multiuser' ) )  ) {
		$booking_form = wpbc_get__booking_form__template( '2_columns_times_30_minutes_hints_coupon' );
	}

	if ( ( $is_demo ) && ( class_exists( 'wpdev_bk_multiuser' ) ) ) {

		$booking_form = wpbc_get__booking_form__template( '2_columns_hints_coupon' );
	}


	// <editor-fold     defaultstate="collapsed"                        desc="  ==  BETA  Examples  ==  "  >
	// -----------------------------------------------------------------------------------------------------------------
	// BETA  Examples:
	// -----------------------------------------------------------------------------------------------------------------
	if ( isset( $_SERVER['HTTP_HOST'] ) && ( 'beta' === $_SERVER['HTTP_HOST'] ) && ( class_exists( 'wpdev_bk_multiuser' ) ) ) {
		if ( ( defined( 'WP_BK_BETA_DATA_FILL_AS' ) ) && ( 'BL' === WP_BK_BETA_DATA_FILL_AS ) ) {
			$booking_form = wpbc_get__booking_form__template( '2_columns_hint_availability' );
		} else {
			$booking_form = wpbc_get__booking_form__template( '2_columns_times_30_minutes_hints_coupon' );
		}
	}
	// </editor-fold>


    return $booking_form;    
}
          

/**
	 * Get Default Form to SHOW during activation of plugin or get  this data for init creation of custom booking form
 * 
 * @return string
 */
function wpbc_get_default_booking_form_show() {
    
    $is_demo = wpbc_is_this_demo();

	$booking_form = wpbc_get__booking_data__template( 'standard' );

	if ( class_exists( 'wpdev_bk_biz_s' ) ) {
		$booking_form = wpbc_get__booking_data__template( '2_columns_times_2_hours' );
	}

	if ( ( $is_demo ) && ( class_exists( 'wpdev_bk_biz_s' ) ) ){
		// $booking_form = wpbc_get__predefined_booking_data__template( 'appointments30' );                                        // FixIn: 10.7.1.4.
		$booking_form = wpbc_get__predefined_booking_data__template( 'appointments_service_b' );                                   // FixIn: 10.9.6.5.
	}

	if ( ( class_exists( 'wpdev_bk_biz_m' ) ) ) {
		$booking_form = wpbc_get__booking_data__template( '2_columns_hint_cost_nights' );
	}

	if ( ( class_exists( 'wpdev_bk_biz_l' ) ) ) {
		$booking_form = wpbc_get__booking_data__template( '2_columns_hint_availability' );
	}

	if ( ( class_exists( 'wpdev_bk_multiuser' ) ) ) {
		$booking_form = wpbc_get__booking_data__template( '2_columns_times_30_minutes_hints_coupon' );
	}


	// <editor-fold     defaultstate="collapsed"                        desc="  ==  BETA  Examples  ==  "  >
	// -----------------------------------------------------------------------------------------------------------------
	// BETA  Examples:
	// -----------------------------------------------------------------------------------------------------------------
	if ( isset( $_SERVER['HTTP_HOST'] ) && ( 'beta' === $_SERVER['HTTP_HOST'] ) && ( class_exists( 'wpdev_bk_multiuser' ) ) ) {
		if ( ( defined( 'WP_BK_BETA_DATA_FILL_AS' ) ) && ( 'BL' === WP_BK_BETA_DATA_FILL_AS ) ) {
			$booking_form = wpbc_get__booking_data__template( '2_columns_hint_availability' );
		} else {
			$booking_form = wpbc_get__booking_data__template( '2_columns_times_30_minutes_hints_coupon' );
		}
	}
	// </editor-fold>

    return $booking_form;
}


////////////////////////////////////////////////////////////////////////////////
// Search Form Templates
////////////////////////////////////////////////////////////////////////////////            

/**
	 * Default Search Form templates
 * 
 * @param string $search_form_type
 * @return string
 */
function wpbc_get_default_search_form_template( $search_form_type = '' ){     // FixIn: 6.1.0.1.

  switch ( $search_form_type ) {

	  // FixIn: 9.1.3.1.
	  // FixIn: 8.5.2.11.
      case 'standard_search_form':
              return '<div class="well">'                                           . '\n\r'
					.'	<r>'                                                        . '\n\r'
					.'		<c>'                                                    . '\n\r'
					.'			<l>Dates:</l> [search_check_in] <l>-</l> [search_check_out]' . '\n\r'
					.'		</c>'                                                   . '\n\r'
					.'		<c>'                                                    . '\n\r'
					.'			<l>Quantity:</l> [search_quantity "1" "2" "3" "4"]' . '\n\r'
					.'		</c>'                                                   . '\n\r'
					.'		<c class="checkbox_el"><l>[search_extend "2"] +/- 2 days</l></c>' . '\n\r'
					.'		<c>[search_button "Search"]</c>'                        . '\n\r'
					.'	 </r>'                                                      . '\n\r'
					.'	</div>';

      case 'standard_search_form2':
              return '<div class="well">'                                           . '\n\r'
					.'	<r>'                                                        . '\n\r'
					.'		<c>'                                                    . '\n\r'
					.'			<l>Check in:</l> [search_check_in]'                 . '\n\r'
					.'		</c>'                                                   . '\n\r'
					.'		<c>'                                                    . '\n\r'
					.'			<l>Check out:</l> [search_check_out]'               . '\n\r'
					.'		</c>'                                                   . '\n\r'
					.'		<c>'                                                    . '\n\r'
					.'			<l>Quantity:</l> [search_quantity "1" "2" "3" "4"]' . '\n\r'
					.'		</c>'                                                   . '\n\r'
					.'		<c class="checkbox_el"><l>[search_extend "2"] +/- 2 days</l></c>' . '\n\r'
					.'		<c>[search_button "Search"]</c>'                        . '\n\r'
					.'	 </r>'                                                      . '\n\r'
					.'	</div>';

      case 'single_day_search_form':
			return   '<div class="well">'                                           . '\n\r'
					.'	<r>'                                                        . '\n\r'
					.'		<c>'                                                    . '\n\r'
					.'			<l>Date:</l> [search_check_in]'                     . '\n\r'
					.'		</c>'                                                   . '\n\r'
					.'		<c>'                                                    . '\n\r'
					.'			<l>Quantity:</l> [search_quantity "1" "2" "3" "4"]' . '\n\r'
					.'		</c>'                                                   . '\n\r'
					.'		<c class="checkbox_el"><l>[search_extend "2"] +/- 2 days</l></c>' . '\n\r'
					.'		<c>[search_button "Search"]</c>'                        . '\n\r'
					.'	</r>'                                                       . '\n\r'
				    .'</div>';

      case 'timeslots_search_form':
		      return '<div class="well">'                                               . '\n\r'
					.'	<r>'                                                            . '\n\r'
					.'		<c> <l>Date:</l> [search_check_in] </c>'                    . '\n\r'
					.'		<c> <l>Time:</l> '                                          . '\n\r'
					.'			[search_time "---@@" "9:00 AM - 9:30 AM@@09:00 - 09:30"  "9:30 AM - 10:00 AM@@09:30 - 10:00"  "10:00 AM - 10:30 AM@@10:00 - 10:30"  "10:30 AM - 11:00 AM@@10:30 - 11:00"  "11:00 AM - 11:30 AM@@11:00 - 11:30"  "11:30 AM - 12:00 PM@@11:30 - 12:00"  "12:00 PM - 12:30 PM@@12:00 - 12:30"  "12:30 PM - 1:00 PM@@12:30 - 13:00"  "1:00 PM - 1:30 PM@@13:00 - 13:30"  "1:30 PM - 2:00 PM@@13:30 - 14:00"  "2:00 PM - 2:30 PM@@14:00 - 14:30"  "2:30 PM - 3:00 PM@@14:30 - 15:00"  "3:00 PM - 3:30 PM@@15:00 - 15:30"  "3:30 PM - 4:00 PM@@15:30 - 16:00"  "4:00 PM - 4:30 PM@@16:00 - 16:30"  "4:30 PM - 5:00 PM@@16:30 - 17:00"  "5:00 PM - 5:30 PM@@17:00 - 17:30"  "5:30 PM - 6:00 PM@@17:30 - 18:00"  "6:00 PM - 6:30 PM@@18:00 - 18:30"]'  . '\n\r'
					.' 		</c>'                                                       . '\n\r'
					.'		<c> <l>Service:</l> [selectbox Service "Any@@" "Health" "Technical Support" "Yoga Class" "Event Planning"] </c>' . '\n\r'
					.'		<c class="checkbox_el"><l>[search_extend "2"] +/- 2 days</l></c>' . '\n\r'
					.'		<c>[search_button "Search"]</c>'                            . '\n\r'
					.'	 </r>'                                                          . '\n\r'
					.'</div>';

      case 'advanced_search_form':
              return '<div class="well">'                                                           . '\n\r'
					.'	<r>'                                                                        . '\n\r'
					.'		<c><l>Dates:</l>'                                                       . '\n\r'
					.'			[search_check_in]'                                                  . '\n\r'
					.'		<l>-</l>'                                                               . '\n\r'
					.'			[search_check_out]'                                                 . '\n\r'
					.'		</c>'                                                                   . '\n\r'
					.'		<c><l>Quantity:</l>'                                                    . '\n\r'
					.'			[search_quantity "1" "2" "3" "4"]'                                  . '\n\r'
					.'		</c>'                                                                   . '\n\r'
					.'		<c><l>Location:</l>'                                                    . '\n\r'
					.'			[selectbox location "Any@@" "Spain" "France" "United States@@USA"]'    . '\n\r'
					.'		</c>'                                                                   . '\n\r'
					.'		<c><l>Max Capacity:</l>'                                                . '\n\r'
					.'			[selectbox max_capacity "Any@@" "1" "2" "3" "4"]'                      . '\n\r'
					.'		</c>'                                                                   . '\n\r'
					.'		<c><label>Amenity:</label>'                                             . '\n\r'
					.'			[selectbox amenity "---@@" "Parking@@parking" "WiFi@@wifi"]'           . '\n\r'
					.'		</c>'                                                                   . '\n\r'
					.'	</r>'                                                                       . '\n\r'
					.'	<r>'                                                                        . '\n\r'
					.'		<c class="checkbox_el"><l>[search_extend "2"] +/- 2 days</l></c>' . '\n\r'
					.'		<c>[search_button "Search"]</c>'                                        . '\n\r'
					.'	</r>'                                                                       . '\n\r'
					.'</div>';

      case 'rooms_search_form':
              return '<div class="well">'                                                           . '\n\r'
					.'	<r>'                                                                        . '\n\r'
					.'		<c>	<l>Dates:</l> [search_check_in]'                                    . '\n\r'
					.'			<l>-</l> [search_check_out]'                                        . '\n\r'
					.'		</c>'                                                                   . '\n\r'
					.'		<c><l>Rooms:</l> [search_quantity "1" "2" "3" "4"]</c>'                 . '\n\r'
					.'		<c><l>Adults:</l> [selectbox max_adults "--@@" "1" "2" "3" "4"]</c>'       . '\n\r'
					.'		<c><l>Children:</l> [selectbox max_children "--@@" "0" "1" "2" "3"]</c>'   . '\n\r'
					.'		<c><l>Location:</l>'                                                    . '\n\r'
					.'			[selectbox location "Any@@" "Spain" "France" "United States@@USA"]'    . '\n\r'
					.'		</c>'                                                                   . '\n\r'
					.'		<c class="checkbox_el"><l>[search_extend "2"] +/- 2 days</l></c>' . '\n\r'
					.'		<c>[search_button "Search"]</c>'     . '\n\r'
					.'	</r>'                                                                       . '\n\r'
					.'</div>';

      case 'rooms_search_form_bl':
              return '<div class="well">'                                                           . '\n\r'
					.'	<r>'                                                                        . '\n\r'
					.'		<c>	<l>Dates:</l> [search_check_in]'                                    . '\n\r'
					.'			<l>-</l> [search_check_out]'                                        . '\n\r'
					.'		</c>'                                                                   . '\n\r'
					.'		<c><l>Rooms:</l> [search_quantity "1" "2" "3" "4"]</c>'                 . '\n\r'
					.'		<c><l>Adults:</l> [selectbox max_adults "--@@" "1" "2" "3" "4"]</c>'       . '\n\r'
					.'		<c><l>Children:</l> [selectbox max_children "--@@" "0" "1" "2" "3"]</c>'   . '\n\r'
					.'		<c><l>Location:</l>'                                                    . '\n\r'
					.'			[selectbox location "Any@@" "Spain" "France" "Australia" "United States@@USA"]'    . '\n\r'
					.'		</c>'                                                                   . '\n\r'
					.'		<c class="checkbox_el"><l>[search_extend "2"] +/- 2 days</l></c>'       . '\n\r'
					.'		<c>[search_button "Search"]</c>'                                        . '\n\r'
					.'	</r>'                                                                       . '\n\r'
					.'</div>';

	  case 'timeslots_search_form__mu':
              return '<div class="well">'                                           . '\n\r'
					.'	<r>'                                                        . '\n\r'
					.'		<c><l>Date:</l> [search_check_in]</c>'                  . '\n\r'
					.'		<c>'                                                    . '\n\r'
					.'			<l>Time:</l> [search_time "--@@" "11 am - 11:30 am@@11:00 - 11:30"  "11:30 am - 12 pm@@11:30 - 12:00"  "12 pm - 12:30 pm@@12:00 - 12:30"  "12:30 pm - 1 pm@@12:30 - 13:00"  "1 pm - 1:30 pm@@13:00 - 13:30"  "1:30 pm - 2 pm@@13:30 - 14:00"  "2 pm - 2:30 pm@@14:00 - 14:30"  "2:30 pm - 3 pm@@14:30 - 15:00"  "3 pm - 3:30 pm@@15:00 - 15:30"]' . '\n\r'
					.'		</c>'                                                   . '\n\r'
					.'		<c>'                                                    . '\n\r'
					.'			<l>Service:</l> [selectbox Service "Any@@" "Health" "Tech Support@@Technical Support" "Yoga Class" "Events@@Event Planning"]' . '\n\r'
					.'		</c>'                                                   . '\n\r'
//					.'		<c>'                                                    . '\n\r'
//					.'			<l>Location:</l> [selectbox Location "Any@@" "In-person" "Online" "Phone" "Live Chat"]' . '\n\r'
//					.'		</c>'                                                   . '\n\r'
//					.'		<c>'                                                    . '\n\r'
//					.'			<l>[search_extend "2"] +/- 2 days</l>'              . '\n\r'
//					.'		</c>'                                                   . '\n\r'
					.'		<c>[search_button "Search"]</c>'                        . '\n\r'
					.'	 </r>'                                                      . '\n\r'
					.'	</div>';


      default:
		      return '<div class="well">'                                       . '\n\r'
					.'	<r>'                                                    . '\n\r'
					.'		<c> <l>Check-in:</l> [search_check_in]'             . '\n\r'
					.'			<spacer>width:4em;</spacer>'                    . '\n\r'
					.'		    <l>Check-out:</l> [search_check_out] </c>'      . '\n\r'
					.'		<c>[search_button "Search"]</c>'                    . '\n\r'
					.'	</r>'                                                   . '\n\r'
					.'</div>';
  }

}


/**
	 * Default Search Results templates
 * 
 * @param string $search_form_type
 * @return string
 */
function wpbc_get_default_search_results_template( $search_form_type = '' ){

    switch ($search_form_type) {                    

      case 'standard_search_results':
			  return '<r>'                                                              . '\n\r'
					.'	<c>'                                                            . '\n\r'
					.'		<a href="[search_result_url]" >[search_result_title]</a>'     . '\n\r'
					.'	</c>'                                                           . '\n\r'
					.'</r>'                                                             . '\n\r'
					.'<r>'                                                              . '\n\r'
					.'	<c><a href="[search_result_url]" >[search_result_image]</a></c>'  . '\n\r'
					.'	<c class="c_minimized">'                                        . '\n\r'
					.'		[search_result_info]'                                             . '\n\r'
					.'		<div>'                                                      . '\n\r'
					.'			<spacer>height:1em;</spacer>'                           . '\n\r'
					.'			Availability: [available_count] / [resource_capacity]'  . '\n\r'
					.'  			Check in/out: <strong>[search_check_in]</strong> -' . '\n\r'
					.'  				  		  <strong>[search_check_out]</strong>'  . '\n\r'
					.'		</div>'                                                     . '\n\r'
					.'	</c>'                                                           . '\n\r'
					.'	<c class="c_column">'                                           . '\n\r'
					.'		<div>Cost: <strong>[cost_hint]</strong></div>'              . '\n\r'
					.'		<spacer>height:1em;</spacer>'                               . '\n\r'
					.'		[search_result_button "Book Now"]'                      . '\n\r'
					.'	</c>'                                                           . '\n\r'
					.'</r>'                                                             . '\n\r';
      case 'simple_search_results':
			  return '<r>'                                                              . '\n\r'
					.'	<c>'                                                            . '\n\r'
					.'		<a href="[search_result_url]" >[search_result_image]</a>'     . '\n\r'
					.'	</c>'                                                           . '\n\r'
					.'	<c class="c_minimized">'                                        . '\n\r'
					.'		<r><c><a href="[search_result_url]" >[search_result_title]</a></c></r>'   . '\n\r'
					.'		[search_result_info]'                                             . '\n\r'
					.'	</c>'                                                           . '\n\r'
					.'	<c class="c_column">'                                           . '\n\r'
					.'		<div>Cost: <strong>[cost_hint]</strong></div>'              . '\n\r'
					.'		<spacer>height:1em;</spacer>'                               . '\n\r'
					.'		[search_result_button "Book Now"]'                      . '\n\r'
					.'	</c>'                                                           . '\n\r'
					.'</r>';
      case 'compact_search_results':
			  return '<r>'                                                              . '\n\r'
					.'	<c><a href="[search_result_url]" >[search_result_image]</a></c>'  . '\n\r'
					.'	<c class="c_minimized">'                                        . '\n\r'
					.'		<r><c><a href="[search_result_url]" >[search_result_title]</a></c></r>'   . '\n\r'
					.'		[search_result_info]'                                             . '\n\r'
					.'		<div>'                                                      . '\n\r'
					.'			<spacer>height:1em;</spacer>'                           . '\n\r'
					.'			Availability: [available_count] item(s).'       . '\n\r'
					.'  			Check in/out: <strong>[search_check_in]</strong> -' . '\n\r'
					.'  				  		  <strong>[search_check_out]</strong>'  . '\n\r'
					.'		</div>'                                                     . '\n\r'
					.'	</c>'                                                           . '\n\r'
					.'	<c class="c_column">'                                           . '\n\r'
					.'		<div>Cost: <strong>[cost_hint]</strong></div>'              . '\n\r'
					.'		<spacer>height:1em;</spacer>'                               . '\n\r'
					.'		[search_result_button "Book Now"]'                      . '\n\r'
					.'	</c>'                                                           . '\n\r'
					.'</r>';
		  case 'old_search_results':
				   return '<div class="wpdevelop search_results_container">' . '\n\r'
                 . '  ' . '	  <div class="search_results_a">' . '\n\r'
                 . '  ' . '		  <div class="search_results_b">' . '\n\r'
                 . '  ' . '			  <a href="[search_result_url]" class="wpbc_book_now_link">' . '\n\r'
                 . '  ' . '				  [search_result_title]' . '\n\r'
                 . '  ' . '			  </a>' . '\n\r'
                 . '  ' . '		  </div>' . '\n\r'
                 . '  ' . '		  <div class="search_results_b">' . '\n\r'
                 . '  ' . '		  	  [search_result_image]' . '\n\r'
                 . '  ' . '		  </div>' . '\n\r'
                 . '  ' . '		  <div class="search_results_b">' . '\n\r'
                 . '  ' . '		  	  [search_result_info]' . '\n\r'
                 . '  ' . '		  </div>' . '\n\r'
                 . '  ' . '		  <div class="search_results_b">' . '\n\r'
                 . '  ' . '			' . __('Availability' ,'booking').': [available_count] item(s).' . '\n\r'
                 . '  ' . '			Check in/out: <strong>[search_check_in]</strong> -' . '\n\r'
                 . '  ' . '						  <strong>[search_check_out]</strong>' . '\n\r'
                 . '  ' . '		  </div>' . '\n\r'
                 . '  ' . '	  </div>' . '\n\r'
                 . '  ' . '	  <div class="search_results_a2">' . '\n\r'
                 . '  ' . '		<div class="search_results_b2">' . '\n\r'
                 . '  ' . '			Cost: <strong>[cost_hint]</strong>' . '\n\r'
                 . '  ' . '		</div>' . '\n\r'
                 . '  ' . '  	    <div class="search_results_b2">' . '\n\r'
                 . '  ' . '			[search_result_button "Book now"]' . '\n\r'
                 . '  ' . '		</div>' . '\n\r'
                 . '  ' . '	  </div>' . '\n\r'
                 . '  ' . '</div>';

      case 'advanced_search_results':
			  return '<r>'                                                                          . '\n\r'
					.'	<c><a href="[search_result_url]" >[search_result_image]</a></c>'             . '\n\r'
					.'	<c class="c_minimized">'                                                    . '\n\r'
					.'		<r>'                                                                    . '\n\r'
					.'		  <c><a href="[search_result_url]" >[search_result_title]</a></c>'       . '\n\r'
					.'		  <c><div class="booking_search_result_title">[cost_hint]</div></c>'    . '\n\r'
					.'		</r>'                                                                   . '\n\r'
					.'		[search_result_info]<spacer>height:1em;</spacer>'                       . '\n\r'
					.'		<r>'                                                                    . '\n\r'
					.'			<div>'                                                              . '\n\r'
					.'				Available: <strong>[available_count]</strong>'                  . '\n\r'
					.'				Check in/out: <strong>[search_check_in]</strong> -'             . '\n\r'
					.'							  <strong>[search_check_out]</strong>'              . '\n\r'
					.'			</div>'                                                             . '\n\r'
					.'		</r>'                                                                   . '\n\r'
					.'	</c>'                                                                       . '\n\r'
					.'</r>'                                                                         . '\n\r'
					.'<r>'                                                                          . '\n\r'
					.'	<c></c>'                                                                    . '\n\r'
					.'	<c>[search_result_button "Book Now"]</c>'                               . '\n\r'
					.'</r>';

      case 'advanced_search_results_bl':
			  return '<r>'                                                                          . '\n\r'
					.'	<c><a href="[search_result_url]" >[search_result_image]</a></c>'             . '\n\r'
					.'	<c class="c_minimized">'                                                    . '\n\r'
					.'		<r>'                                                                    . '\n\r'
					.'		  <c><a href="[search_result_url]" >[search_result_title]</a></c>'       . '\n\r'
					.'		  <c><div class="booking_search_result_title" >[cost_hint]</div></c>'    . '\n\r'
					.'		</r>'                                                                   . '\n\r'
					.'		[search_result_info]<spacer>height:1em;</spacer>'                       . '\n\r'
					.'		<r>'                                                                    . '\n\r'
					.'			<div>'                                                              . '\n\r'
					.'				Available: <strong>[available_count]</strong> from [resource_capacity] | ' . '\n\r'
					.'				Check in/out: <strong>[search_check_in]</strong> -'             . '\n\r'
					.'							  <strong>[search_check_out]</strong> | '           . '\n\r'
				  	.'				Adults: <strong>[max_adults]</strong> | '                   . '\n\r'
				  	.'				Children: <strong>[max_children]</strong> | '               . '\n\r'
				  	.'				<strong>[location]</strong> | '                                 . '\n\r'
				  	.'				<strong>[amenity]</strong>'                                     . '\n\r'
					.'			</div>'                                                             . '\n\r'
					.'		</r>'                                                                   . '\n\r'
					.'	</c>'                                                                       . '\n\r'
					.'</r>'                                                                         . '\n\r'
					.'<r>'                                                                          . '\n\r'
					.'	<c></c>'                                                                    . '\n\r'
					.'	<c>[search_result_button "Book Now"]</c>'                               . '\n\r'
					.'</r>';

      case 'advanced_search_results__mu':
			  return '<r>'                                                                          . '\n\r'
					.'	<c><a href="[search_result_url]" >[search_result_image]</a></c>'             . '\n\r'
					.'	<c class="c_minimized">'                                                    . '\n\r'
					.'		<r>'                                                                    . '\n\r'
					.'		  <c><a href="[search_result_url]" >[search_result_title]</a></c>'       . '\n\r'
					.'		  <c><div class="booking_search_result_title" >[cost_hint]</div></c>'    . '\n\r'
					.'		</r>'                                                                   . '\n\r'
					.'		[search_result_info]<spacer>height:1em;</spacer>'                       . '\n\r'
					.'		<r>'                                                                    . '\n\r'
					.'			<div>'                                                              . '\n\r'
					.'				Date: <strong>[search_check_in]</strong> |'                     . '\n\r'
					.'				Time: <strong>[search_time]</strong> |'                         . '\n\r'
					.'				<strong>[Service]</strong> |'                                   . '\n\r'
			         .'				Contact: <strong>[Location]</strong>'                           . '\n\r'
					.'			</div>'                                                             . '\n\r'
					.'		</r>'                                                                   . '\n\r'
					.'	</c>'                                                                       . '\n\r'
					.'</r>'                                                                         . '\n\r'
					.'<r>'                                                                          . '\n\r'
					.'	<c></c>'                                                                    . '\n\r'
					.'	<c>[search_result_button "Book Now"]</c>'                                   . '\n\r'
					.'</r>';

      default:
			  return '<r>'                                                              . '\n\r'
					.'	<c>'                                                            . '\n\r'
					.'		<a href="[search_result_url]">[search_result_image]</a>'     . '\n\r'
					.'	</c>'                                                           . '\n\r'
					.'	<c class="c_minimized">'                                        . '\n\r'
					.'		<r><c><a href="[search_result_url]">[search_result_title]</a></c></r>'   . '\n\r'
					.'		[search_result_info]'                                             . '\n\r'
					.'	</c>'                                                           . '\n\r'
					.'	<c class="c_column">'                                           . '\n\r'
					.'		[search_result_button "Book Now"]'                      . '\n\r'
					.'	</c>'                                                           . '\n\r'
					.'</r>';
    }                      
}
