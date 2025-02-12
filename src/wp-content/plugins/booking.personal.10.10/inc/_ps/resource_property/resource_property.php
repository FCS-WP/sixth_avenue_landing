<?php
/**
 * @version     1.1
 * @package     Resources Properties - Metadata for booking resources from  wp_booking_types_meta  DB table
 * @category    Booking Resources
 * @author      wpdevelop
 *
 * @web-site    https://wpbookingcalendar.com/
 * @email       info@wpbookingcalendar.com
 * @modified    2016-02-28, 2024-01-19
 *
 * This is COMMERCIAL SCRIPT
 * We are not guarantee correct work and support of Booking Calendar, if some file(s) was modified by someone else then wpdevelop.
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


////////////////////////////////////////////////////////////////////////////////
// Get & Set Booking Resource Meta data
////////////////////////////////////////////////////////////////////////////////

global $wpbc_cache_booking_types_meta;

/**
 * Get metadata for booking resource, like Rates, Availability or "Valuation days"  [ USE CACHE ]
 *
 * @param int          $resource_id        - ID of booking resource
 * @param string    $meta_key           - type of meat,  for example: 'availability' | 'rates' | 'costs_depends' | 'fixed_deposit'
 * @return array						-
 *                    Array (
    							[0] => stdClass Object (
									[type_id] => 4
									[id] => 15
									[value] => a:2:{s:7:"general";s:2:"On";s:6:"filter";a:9:{i:1;s:2:"On";i:2;s:3:"Off";i:3;s:3:"Off";i:4;s:3:"Off";i:5;s:3:"Off";i:6;s:3:"Off";i:7;s:3:"Off";i:8;s:3:"Off";i:9;s:2:"On";}}
								)
							)
 *
 *  				 unserialize( $availability_res[0]->value ) =
																		Array (
																			[general] => On
																			[filter] => Array (
																					[1] => On
																					[2] => Off
																					[3] => Off
																					[4] => Off
																					[5] => Off
																					[6] => Off
																					[7] => Off
																					[8] => Off
																					[9] => On
																				)
																		)
 */
function wpbc_get_resource_meta( $resource_id, $meta_key ) {
    global $wpdb;

    if ( IS_USE_WPDEV_BK_CACHE ) {                                              // Use Cache
        global $wpbc_cache_booking_types_meta;

        if ( ! isset( $wpbc_cache_booking_types_meta ) )    $wpbc_cache_booking_types_meta = array();

        if ( ! isset( $wpbc_cache_booking_types_meta[$meta_key] ) ) {

            $wpbc_cache_booking_types_meta[$meta_key] = array();

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$result = $wpdb->get_results( $wpdb->prepare( "SELECT type_id, meta_id as id, meta_value as value FROM {$wpdb->prefix}booking_types_meta WHERE  meta_key = %s ", $meta_key ) );

            foreach ( $result as $value ) {

                if ( ! isset( $wpbc_cache_booking_types_meta[$meta_key][$value->type_id] ) )    $wpbc_cache_booking_types_meta[$meta_key][$value->type_id] = array();

                $wpbc_cache_booking_types_meta[$meta_key][$value->type_id][] = $value;
            }
            if ( ! isset( $wpbc_cache_booking_types_meta[$meta_key][$resource_id] ) )   return array();

            return $wpbc_cache_booking_types_meta[$meta_key][$resource_id];

        } else {

            if ( ! isset( $wpbc_cache_booking_types_meta[$meta_key][$resource_id] ) )   return array();

            return $wpbc_cache_booking_types_meta[$meta_key][$resource_id];
        }

    } else {                                                                    // Get info  1st  time

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$result = $wpdb->get_results( $wpdb->prepare( "SELECT meta_id as id, meta_value as value FROM {$wpdb->prefix}booking_types_meta WHERE type_id = %d AND meta_key = %s ", $resource_id, $meta_key ) );

		return $result;
    }
}


/**
 * Save metadata for booking resource, like Rates, Availability or "Valuation days"  [ update  CACHE ]
 *
 * Example: wpbc_save_resource_meta( $resource_id, 'availability', $availability );
 */
function wpbc_save_resource_meta( $resource_id, $meta_key, $data ) {

	$data = maybe_serialize( $data );

	global $wpdb;

	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
	$result = $wpdb->get_results( $wpdb->prepare( "SELECT count(type_id) as cnt FROM {$wpdb->prefix}booking_types_meta WHERE type_id = %d AND meta_key = %s ", $resource_id, $meta_key ) );

	if ( ( ! empty( $result ) ) && ( $result[0]->cnt > 0 ) ) {

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$sql = $wpdb->prepare( "UPDATE {$wpdb->prefix}booking_types_meta SET meta_value = %s WHERE type_id = %d  AND meta_key = %s ", $data, $resource_id, $meta_key );

	} else {
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$sql = $wpdb->prepare( "INSERT INTO {$wpdb->prefix}booking_types_meta ( type_id, meta_key, meta_value ) VALUES ( %d, %s, %s ) ", $resource_id, $meta_key, $data );
	}

	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
	if ( false === $wpdb->query( $sql ) ) {
		debuge_error( 'Error saving to DB', __FILE__, __LINE__ );

		return false;
	}

	// Update Cache data.
	global $wpbc_cache_booking_types_meta;
	unset( $wpbc_cache_booking_types_meta[ $meta_key ] );

	return true;
}


// FixIn: 9.9.0.14.
/**
 * Get Property (metadata) for specific booking resource
 *
 * @param $resource_id
 * @param $property_name
 *
 * @return false|mixed|string
 */
function wpbc_get_resource_property( $resource_id, $property_name ) {

	$resource_property_arr = wpbc_get_resource_meta( $resource_id, $property_name );

	$resource_property_val = false;

	if (
			( is_array( $resource_property_arr ) )
	     && ( count( $resource_property_arr ) > 0 )
	){

		$resource_property_val = maybe_unserialize( $resource_property_arr[0]->value );
	}

	return $resource_property_val;
}

/**
 * Save Property (metadata) for specific booking resource
 *
 * @param $resource_id
 * @param $property_name
 * @param $property_value
 *
 * @return false
 */
function wpbc_save_resource_property( $resource_id, $property_name, $property_value ) {

	$save_result = false;

	$resource_id = intval( $resource_id );

	if ( ! empty( $resource_id ) ) {
		$save_result = wpbc_save_resource_meta( $resource_id, $property_name, $property_value );

	}

	return $save_result;
}

