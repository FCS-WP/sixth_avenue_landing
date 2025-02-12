<?php
/**
 * @version     1.0
 * @package     Booking Calendar
 * @category    A c t i v a t e    &    D e a c t i v a t e
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


/** A c t i v a t e */
function wpbc_booking_activate_p() {
    
	// -----------------------------------------------------------------------------------------------------------------
    // DB Tables
	// -----------------------------------------------------------------------------------------------------------------
    if ( true ) {
        
        global $wpdb;

        $charset_collate = '';
        $wp_queries = array();

        if ( ( ! wpbc_is_table_exists( 'bookingtypes' ) ) ) {                       // Cehck if tables not exist yet

            if ( !empty( $wpdb->charset ) )
                $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
            if ( !empty( $wpdb->collate ) )
                $charset_collate .= " COLLATE $wpdb->collate";

            $wp_queries[] = "CREATE TABLE {$wpdb->prefix}bookingtypes (
                             booking_type_id bigint(20) unsigned NOT NULL auto_increment,
                             title varchar(200) NOT NULL default '',
                             PRIMARY KEY  (booking_type_id)
                            ) $charset_collate;";

            $wp_queries[] = $wpdb->prepare( "INSERT INTO {$wpdb->prefix}bookingtypes ( title ) VALUES ( %s );", __( 'Default', 'booking' ) );
            $wp_queries[] = $wpdb->prepare( "INSERT INTO {$wpdb->prefix}bookingtypes ( title ) VALUES ( %s );", __( 'Apartment#1', 'booking' ) );
            $wp_queries[] = $wpdb->prepare( "INSERT INTO {$wpdb->prefix}bookingtypes ( title ) VALUES ( %s );", __( 'Apartment#2', 'booking' ) );
            $wp_queries[] = $wpdb->prepare( "INSERT INTO {$wpdb->prefix}bookingtypes ( title ) VALUES ( %s );", __( 'Apartment#3', 'booking' ) );

            if ( ! wpbc_is_this_demo() ) {
                $booking__text_description = trim( 
                                                    $wpdb->prepare( '%s', __( 'Please, reserve an apartment with fresh flowers.', 'booking' ) )
                                                    , "'^~" 
                                                );
                $wp_queries[] = "INSERT INTO {$wpdb->prefix}booking ( form, modification_date ) VALUES (
                             'text^name1^Victoria~text^secondname1^Smith~email^email1^victoria@wpbookingcalendar.com~text^phone1^458-77-88~selectbox-one^visitors1^2~selectbox-one^children1^0~textarea^details1^" . $booking__text_description . "~checkbox^term_and_condition1[]^I Accept term and conditions', NOW() );";
            }
			foreach ( $wp_queries as $wp_q ) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_q );
			}

            if ( ! wpbc_is_this_demo() ) {
                $temp_id = $wpdb->insert_id;
                $wp_queries_sub = "INSERT INTO {$wpdb->prefix}bookingdates (
                                 booking_id,
                                 booking_date
                                ) VALUES
                                ( " . $temp_id . ", CURDATE()+ INTERVAL 6 day ),
                                ( " . $temp_id . ", CURDATE()+ INTERVAL 7 day ),
                                ( " . $temp_id . ", CURDATE()+ INTERVAL 8 day );";
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_queries_sub );
            }
        }

		if ( class_exists( 'wpdev_bk_multiuser' ) ) {
			if ( wpbc_is_field_in_table_exists( 'bookingtypes', 'users' ) == 0 ) {
				$simple_sql = "ALTER TABLE {$wpdb->prefix}bookingtypes ADD users BIGINT(20) DEFAULT '1'";
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $simple_sql );
			}
		}
		if ( wpbc_is_field_in_table_exists( 'booking', 'remark' ) == 0 ) { // Add remark field
			$simple_sql = "ALTER TABLE {$wpdb->prefix}booking ADD remark TEXT";
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
			$wpdb->query( $simple_sql );
		}
		if ( wpbc_is_field_in_table_exists( 'bookingtypes', 'import' ) == 0 ) {
			$simple_sql = "ALTER TABLE {$wpdb->prefix}bookingtypes ADD import text";
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
			$wpdb->query( $simple_sql );
		}
		if ( wpbc_is_field_in_table_exists( 'bookingtypes', 'export' ) == 0 ) {                                            //FixIn: 8.0
			$simple_sql = "ALTER TABLE {$wpdb->prefix}bookingtypes ADD export TEXT AFTER import";
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
			$wpdb->query( $simple_sql );
		}
		// FixIn: 9.2.3.3    // Added creation 'hash' field to the file ..\core\wpbc-activation.php - for all  Booking Calendar versions.


		// Booking Types   M E T A  table                                                                               // FixIn: 9.9.0.13.
		if ( ( ! wpbc_is_table_exists( 'booking_types_meta' ) ) ) {
			$wp_queries   = array();
			$wp_queries[] = "CREATE TABLE {$wpdb->prefix}booking_types_meta (
                 meta_id bigint(20) unsigned NOT NULL auto_increment,
                 type_id bigint(20) NOT NULL default 0,
                 meta_key varchar(200) NOT NULL default '',
                 meta_value text ,
                 PRIMARY KEY  (meta_id)
                ) $charset_collate;";

			foreach ( $wp_queries as $wp_q ) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_q );
			}
		}
	}


	// -----------------------------------------------------------------------------------------------------------------
	// Demos.
	// -----------------------------------------------------------------------------------------------------------------
	if ( wpbc_is_this_demo() ) {

		// update_bk_option( 'booking_skin', '/css/skins/traditional-times.css' );
		// update_bk_option( 'booking_skin', '/css/skins/24_9__light_square_1.css' );
		update_bk_option( 'booking_skin', '/css/skins/24_9__green_2.css' );
		update_bk_option( 'booking_is_show_legend', 'On' );                                                             // FixIn: 9.0.1.8.

		update_bk_option( 'booking_is_use_captcha', 'On' );
		update_bk_option( 'booking_url_bookings_edit_by_visitors', site_url() . '/booking/edit/' );
		update_bk_option( 'booking_url_bookings_listing_by_customer', site_url() . '/booking/listing/' );               // FixIn: 8.1.3.5.1.
		update_bk_option( 'booking_type_of_day_selections', 'multiple' );


		$remark_text = 'Here can be some note about this booking...';
		$update_sql  = "UPDATE {$wpdb->prefix}booking AS bk SET bk.remark='$remark_text' WHERE bk.booking_id=1;";
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
		$wpdb->query( $update_sql );

	} else {
		wpbc_create_page_bookingedit();                     // FixIn: 9.6.2.10.
	}

	// FixIn: 10.0.0.21.
	// wpbc_disable_auto_update_for_pro();  //.
}
add_bk_action( 'wpbc_other_versions_activation',   'wpbc_booking_activate_p'   );


/** D e a c t i v a t e */
function wpbc_booking_deactivate_p() {

	// -----------------------------------------------------------------------------------------------------------------
	// DB Tables
	// -----------------------------------------------------------------------------------------------------------------
	global $wpdb;
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery.SchemaChange
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}bookingtypes" );
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery.SchemaChange
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}booking_types_meta" );                                           // FixIn: 9.9.0.13.

}

add_bk_action( 'wpbc_other_versions_deactivation', 'wpbc_booking_deactivate_p' );


/**
 * Disable Auto Update of Booking Calendar plugin.
 *
 * @return void
 */
function wpbc_disable_auto_update_for_pro() {
	// FixIn: 10.0.0.21.

	// Get all plugins,  that  can  be auto-updated.
	$update_sufix = 'update';
	$option       = 'auto_' . $update_sufix . '_plugins';
	$auto_updates = (array) get_site_option( $option, array() );

	// Remove Booking Calendar.
	$asset        = 'booking/wpdev-booking.php';
	$auto_updates = array_diff( $auto_updates, array( $asset ) );

	// Update.
	update_site_option( $option, $auto_updates );
}