<?php
/**
 * @package       1 Way Hash Functions
 * @description   Payment response, click2approve, click2decline, click2trash functionality
 *
 * Author: wpdevelop, oplugins
 * @link http://oplugins.com/
 * @email info@oplugins.com
 *
 * @version 1.0
 * @modified 2019-05-08
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly

////////////////////////////////////////////////////////////////////////////////
//  Functions relative to  Secret Hash
////////////////////////////////////////////////////////////////////////////////

//FixIn: 8.4.7.20.1


	/**
	 * Get URL to [booking_edit] page with 1 way hash
	 *
	 * @param $hash string  cGF5bWV...zSUxiLnU%3D
	 *
	 * @return  string      http://server.com/edit/?wpbc_hash=cGF5bWV...zSUxiLnU%3D
	 */
	function wpbc_get_1way_hash_url( $hash ) {

	    $edit_url_for_visitors = get_bk_option( 'booking_url_bookings_edit_by_visitors' );
	    $edit_url_for_visitors = wpbc_lang( $edit_url_for_visitors );

	    if ( strpos( $edit_url_for_visitors, '?' ) === false ) {
		    $my_hash_start_parameter = '';
		    if ( substr( $edit_url_for_visitors, - 1, 1 ) != '/' ) {
			    $my_hash_start_parameter .= '/';
		    }
		    $my_hash_start_parameter .= '?wpbc_hash=';
	    } else {
	        $my_hash_start_parameter = '&wpbc_hash=';
	    }

	    $edit_url_for_visitors .= $my_hash_start_parameter . $hash;

	    return $edit_url_for_visitors;
	}


/**
 * Parse 1 way secret HASH, usually  after  redirection to [bookingedit] page
 * and make output specific content based on paramters from the hash,
 * like approve or decline bookings, redirect, show some info.
 *
 * @param $hash string - Hash  from  Url    cGF5bWV...zSUxiLnU%3D
 *
 * @return string
 */
function wpbc_parse_one_way_hash( $hash ){

	$parsed_response = wpbc_check_secret_hash( $hash );


	if ( false === $parsed_response ) {

		return '<strong>' . esc_html__('Error' ,'booking') . '</strong>! ' . 'Wrong secret booking hash in URL!' ;

	} else {

		ob_start();

		switch ( $parsed_response[0] ) {

			case 'payment':

				// list( $response_type, $response_source, $booking_hash, $response_action ) = $parsed_response;
				make_bk_action( 'wpbc_payment_response', $parsed_response );


				break;

			case 'click2approve':

				list( $response_type, $response_source, $booking_hash, $response_action ) = $parsed_response;

				$my_booking_id_type = wpbc_hash__get_booking_id__resource_id( $booking_hash );

				if ( ! empty( $my_booking_id_type ) ) {

					list( $booking_id, $resource_id ) = $my_booking_id_type;

					// Approve booking and send email, if activated
					wpbc_auto_approve_booking( $booking_id );

					// Get booking details
					$booking_data   = wpbc_db_get_booking_details( $booking_id );
					$replace_params = wpbc_get_booking_different_params_arr( $booking_data->booking_id, $booking_data->form, $resource_id );

					// Show Message
					/* translators: 1: ... */
					echo '<h3>' . sprintf( esc_html__( 'Booking %s have been approved.', 'booking'), ' (ID = ' . esc_attr( $booking_data->booking_id )  . ') ') . '</h3>';
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo $replace_params['content'];

				} else {
					return '<strong>' . esc_html__('Oops!' ,'booking') . '</strong> ' . esc_html__('We could not find your booking. The link you used may be incorrect or has expired. If you need assistance, please contact our support team.' ,'booking');
				}

				break;

			case 'click2decline':

				list( $response_type, $response_source, $booking_hash, $response_action ) = $parsed_response;

				$my_booking_id_type = wpbc_hash__get_booking_id__resource_id( $booking_hash );

				if ( ! empty( $my_booking_id_type ) ) {

					list( $booking_id, $resource_id ) = $my_booking_id_type;

					// Set booking as Pending booking and send email, if activated
					wpbc_auto_pending_booking( $booking_id, ' - ' );

					// Get booking details
					$booking_data   = wpbc_db_get_booking_details( $booking_id );
					$replace_params = wpbc_get_booking_different_params_arr( $booking_data->booking_id, $booking_data->form, $resource_id );

					// Show Message
					/* translators: 1: ... */
					echo '<h3>' . wp_kses_post( sprintf( __( 'Booking %s have been set as pending.', 'booking'), ' (ID = ' . $booking_data->booking_id  . ') ') ) . '</h3>';
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo $replace_params['content'];

				} else {
					return '<strong>' . esc_html__('Oops!' ,'booking') . '</strong> ' . esc_html__('We could not find your booking. The link you used may be incorrect or has expired. If you need assistance, please contact our support team.' ,'booking');
				}

				break;

			case 'click2trash':

				list( $response_type, $response_source, $booking_hash, $response_action ) = $parsed_response;

				$my_booking_id_type = wpbc_hash__get_booking_id__resource_id( $booking_hash );

				if ( ! empty( $my_booking_id_type ) ) {

					list( $booking_id, $resource_id ) = $my_booking_id_type;

					// Trash booking and send email, if activated
					wpbc_auto_cancel_booking( $booking_id ,  ' - ' );

					// Get booking details
					$booking_data   = wpbc_db_get_booking_details( $booking_id );
					$replace_params = wpbc_get_booking_different_params_arr( $booking_data->booking_id, $booking_data->form, $resource_id );

					// Show Message
					/* translators: 1: ... */
					echo '<h3>' . wp_kses_post( sprintf( __( 'Booking %s have been moved to trash.', 'booking'), ' (ID = ' . $booking_data->booking_id  . ') ')  ). '</h3>';
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo $replace_params['content'];

				} else {
					return  '<strong>' . esc_html__('Oops!' ,'booking') . '</strong> ' . esc_html__('We could not find your booking. The link you used may be incorrect or has expired. If you need assistance, please contact our support team.' ,'booking');
				}

				break;

			default:
				// Default
		}

		$output = ob_get_clean();

		return $output;
	}
}


	// FixIn: 8.4.7.25.

	/**
	 * Get URL to page to  "Approve" the booking with  "1 click"  by  using  1 way Hash     -   shortcode [click2approve]
	 * in the Booking > Settings > Emails page for New (admin) email.
	 *
	 * @param $booking_id int
	 *
	 * @return string   - URL to  page
	 *                  Its require correct  configuration  of [bookingedit] at the Booking > Settings General page.
	 */
	function wpbc_get_url_click2approve( $booking_id ){

		$return_url = '';

		$my_booking_hash_type = wpbc_hash__get_booking_hash__resource_id( $booking_id );

		if ( ! empty( $my_booking_hash_type ) ) {

			list( $booking_hash, $resource_id ) = $my_booking_hash_type;
			//$booking_data = wpbc_db_get_booking_details( $booking_id );

			$hash_1_way = wpbc_get_secret_hash( array(
												'click2approve', 'email_link',
												$booking_hash, 'approve'
			) );

			$return_url = wpbc_get_1way_hash_url( $hash_1_way );
		}
		return $return_url;
	}

	// FixIn: 8.4.7.26.

	/**
	 * Get URL to page to  "Decline" the booking with  "1 click"  by  using  1 way Hash     -   shortcode [click2decline]
	 * in the Booking > Settings > Emails page for New (admin) email.
	 *
	 * @param $booking_id int
	 *
	 * @return string   - URL to  page
	 *                  Its require correct  configuration  of [bookingedit] at the Booking > Settings General page.
	 */
	function wpbc_get_url_click2decline( $booking_id ){

		$return_url = '';

		$my_booking_hash_type = wpbc_hash__get_booking_hash__resource_id( $booking_id );

		if ( ! empty( $my_booking_hash_type ) ) {

			list( $booking_hash, $resource_id ) = $my_booking_hash_type;
			//$booking_data = wpbc_db_get_booking_details( $booking_id );

			$hash_1_way = wpbc_get_secret_hash( array(
												'click2decline', 'email_link',
												$booking_hash, 'decline'
			) );

			$return_url = wpbc_get_1way_hash_url( $hash_1_way );
		}
		return $return_url;
	}

	// FixIn: 8.4.7.27.

	/**
	 * Get URL to page to  "Trash" the booking with  "1 click"  by  using  1 way Hash     -   shortcode [click2trash]
	 * in the Booking > Settings > Emails page for New (admin) email.
	 *
	 * @param $booking_id int
	 *
	 * @return string   - URL to  page
	 *                  Its require correct  configuration  of [bookingedit] at the Booking > Settings General page.
	 */
	function wpbc_get_url_click2trash( $booking_id ){

		$return_url = '';

		$my_booking_hash_type = wpbc_hash__get_booking_hash__resource_id( $booking_id );

		if ( ! empty( $my_booking_hash_type ) ) {

			list( $booking_hash, $resource_id ) = $my_booking_hash_type;
			//$booking_data = wpbc_db_get_booking_details( $booking_id );

			$hash_1_way = wpbc_get_secret_hash( array(
												'click2trash', 'email_link',
												$booking_hash, 'trash'
			) );

			$return_url = wpbc_get_1way_hash_url( $hash_1_way );
		}
		return $return_url;
	}

