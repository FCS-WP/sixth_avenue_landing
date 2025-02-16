<?php
/*
This is COMMERCIAL SCRIPT
We are not guarantee correct work and support of Booking Calendar, if some file(s) was modified by someone else then wpdevelop.
*/

// ---------------------------------------------------------------------------------------------------------------------
//  S u p p o r t    f u n c t i o n s
// ---------------------------------------------------------------------------------------------------------------------

	/**
	* Get array of booking resources Objects
	 *
	 * @return array
	 */
	function wpbc_get_br_as_objects(){

		$br_cache = wpbc_br_cache();  // Init booking resources cache

		$all_resources = $br_cache->get_resources();

		foreach ($all_resources as $key => $value) {
			 $all_resources[$key] = json_decode( wp_json_encode( $value ) );       // Turn array into an object
			 $all_resources[$key]->ID = $all_resources[$key]->id;
		}

		return $all_resources;
	}


function get__default_type() {

	if ( class_exists( 'wpdev_bk_multiuser' ) ) {  // If MultiUser so
		$bk_multiuser = apply_bk_filter( 'get_default_bk_resource_for_user', false );
		if ( $bk_multiuser !== false ) {
			return $bk_multiuser;
		}
	}

	global $wpdb;
	$mysql      = "SELECT booking_type_id as id FROM  {$wpdb->prefix}bookingtypes ORDER BY id ASC LIMIT 1";
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
	$types_list = $wpdb->get_results( $mysql );
	if ( count( $types_list ) > 0 ) {
		$types_list = $types_list[0]->id;
	} else {
		$types_list = 1;
	}

	return $types_list;

}


/**
 * Get title (name) of booking resource from DB
 *
 * @param $resource_id
 *
 * @return string
 */
function wpbc_db__get_resource_title( $resource_id = 1 ) {

	global $wpdb;

	$resource_id = intval( $resource_id );

	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$types_list = $wpdb->get_results( "SELECT title FROM {$wpdb->prefix}bookingtypes  WHERE booking_type_id = {$resource_id}" );

	if ( $types_list ) {
		return wp_strip_all_tags( $types_list[0]->title );        // FixIn: 8.8.3.17.
	} else {
		return '';
	}
}


	function get_booking_resource_attr( $type_id = '' ){

		$type_id = intval( $type_id );

		global $wpdb;
		if ( ! empty( $type_id ) ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			$types_list = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}bookingtypes  WHERE booking_type_id = {$type_id}" );
			if ( $types_list ) {
				return $types_list[0];
			} else {
				return false;
			}
		} else {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
			$types_list = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}bookingtypes" );
			if ( $types_list ) {
				return $types_list;
			} else {
				return false;
			}
		}


	}


	function wpdebk_get_keyed_all_bk_resources($blank){
		// Get All Booking types in array with Keys using bk res ID
		$booking_types = array();
		$booking_types_res = wpbc_get_br_as_objects();
		foreach ($booking_types_res as $value) {
			$booking_types[$value->id] = $value;
		}
		return $booking_types;
	}
	add_bk_filter('wpdebk_get_keyed_all_bk_resources', 'wpdebk_get_keyed_all_bk_resources');

// ---------------------------------------------------------------------------------------------------------------------
//  S Q L   Modifications  for  Booking Listing
// ---------------------------------------------------------------------------------------------------------------------

	// Keyword
	function get_p_bklist_sql_keyword($blank, $wh_keyword ){
		$sql_where = '';
		global $wpdb;

		if ( $wh_keyword !== '' ) {
			$sql_where .= " AND  ( bk.form LIKE '%" . $wpdb->esc_like($wh_keyword) . "%' ";
			$sql_where .= " OR  bk.sync_gid LIKE '%" . $wpdb->esc_like($wh_keyword) . "%' ";    // FixIn: 8.5.1.1.
			$sql_where .= " OR  bk.remark LIKE '%" . $wpdb->esc_like($wh_keyword) . "%' ";		 // FixIn: 8.5.1.1.
			$sql_where .= ")";
		}
		return $sql_where;
	}
	add_bk_filter('get_bklist_sql_keyword', 'get_p_bklist_sql_keyword');


	// Resources
	function get_p_bklist_sql_resources($blank, $wh_booking_type, $wh_approved, $wh_booking_date, $wh_booking_date2 ){
		global $wpdb;
		$sql_where = '';

		if ( ! empty($wh_booking_type) )  {
			// P
			$sql_where.=   " AND (  " ;
			$sql_where.=   "       ( bk.booking_type IN  ( ". $wh_booking_type ." ) ) " ;     // BK Resource conections

			// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
			if ( ( isset($_REQUEST['view_mode']) ) && ( $_REQUEST['view_mode']== 'vm_calendar' ) ) {
				// Skip the bookings from the children  resources, if we are in the Calendar view mode at the admin panel
				$sql_where .= apply_bk_filter('get_l_bklist_sql_resources_for_calendar_view', ''  , $wh_booking_type, $wh_approved, $wh_booking_date, $wh_booking_date2 );
			} else {
				//  BL
				$sql_where .= apply_bk_filter('get_l_bklist_sql_resources', ''  , $wh_booking_type, $wh_approved, $wh_booking_date, $wh_booking_date2 );
			}
			// P
			$sql_where.=   "     )  " ;
		}

		return $sql_where;
	}
	add_bk_filter('get_bklist_sql_resources', 'get_p_bklist_sql_resources');

    
// ---------------------------------------------------------------------------------------------------------------------
//  A D M I N    B O O K I N G     C A L E N D A R      O V E R V I E W     P A N E L
// ---------------------------------------------------------------------------------------------------------------------

	// Get inline title for days in admin panel at calendar
	function get_title_for_showing_in_day( $bk_id, $bookings, $what_show_in_day_template='[id]'){
		/* ?></div></div></div></div><?php
		debuge($bk_id, $bookings[$bk_id]->form_data['_all_fields_']);/**/

		$x_pos = $y_pos = 0;
		$x_pos = strpos($what_show_in_day_template,'[' ) ;
		$y_pos = strpos($what_show_in_day_template,']' ) ;

		while ($x_pos !== false) {

			$what_show_in_day_title = substr( $what_show_in_day_template, ($x_pos+1), ($y_pos- $x_pos-1) ) ;
			switch ($what_show_in_day_title) {
			  case 'id':
				  $title_in_day =  $bk_id ; break;
			  default:
				 //$title_in_day  =   $bookings[$bk_id]->form_data['_all_'][ $what_show_in_day_title . $bookings[$bk_id]->booking_type ] ;    break;
				 if ( isset($bookings[$bk_id]->form_data['_all_fields_'][ $what_show_in_day_title ]) )
						$title_in_day  =   $bookings[$bk_id]->form_data['_all_fields_'][ $what_show_in_day_title ] ;
				 else   $title_in_day  =  '';
				 break;

			}

			$what_show_in_day_template = substr( $what_show_in_day_template, 0, $x_pos) . $title_in_day . substr( $what_show_in_day_template, ($y_pos+1) );

			if ( ($x_pos !== false) && ($x_pos<= strlen($what_show_in_day_template))  )
						$x_pos = strpos($what_show_in_day_template,'[', $x_pos) ;
			else        $x_pos = false;
			if ($x_pos !== false)  $y_pos = strpos($what_show_in_day_template,']', $x_pos) ;

		}
		return  $what_show_in_day_template;
	}
