<?php
/**
 * @version 1.0
 * @package     Common reused UI elements in Flex Tables
 * @category    FlexTable Class - Booking Resources
 * @author wpdevelop
 *
 * @web-site https://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com
 *
 * @modified 2024-03-31		// FixIn: 10.0.0.17.
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


// =====================================================================================================================
// Labels
// =====================================================================================================================

/**
 * Cost - Label  --  FlexTable Reused UI
 *
 * @param $resource_id
 * @param $resource_cost
 *
 * @return void
 */
function wpbc_flextable_reused_ui__label_cost( $resource_id, $resource_cost ) {

	if ( class_exists( 'wpdev_bk_biz_s' ) ){

		$currency = wpbc_get_currency_symbol_for_user( $resource_id );

		?><div class="ui_element"><a  href="javascript:void(0);" onclick="javascript: jQuery( '#flextable_header_tab__cost').trigger('click');" class="wpbc_label wpbc_label_cost"><?php

			echo wp_kses_post( $currency ) , '<strong>' , wp_kses_post( $resource_cost ), '</strong>';

		?></a></div><?php
	}
}


/**
 * Default Form - Label  --  FlexTable Reused UI
 *
 * @param $resource_default_form
 *
 * @return void
 */
function wpbc_flextable_reused_ui__label_default_form( $resource_default_form ) {

	if ( class_exists( 'wpdev_bk_biz_m' ) ){

		if ( ( ! empty( $resource_default_form ) ) && ( 'standard' !== $resource_default_form ) ) {
		?><div class="ui_element"><?php

			?><a href="javascript:void(0);" onclick="javascript: jQuery( '#flextable_header_tab__default_form').trigger('click');"
				class="wpbc_label wpbc_label_resource_default_form"><?php
			echo '<span style="font-size:07px;padding: 0 1em 0 0;line-height: 2em;">' . esc_html__( 'Default Form', 'booking' ) . '</span>';
					?><strong><?php echo esc_html( $resource_default_form ); ?></strong></a><?php

		?></div><?php
		}
	}
}



/**
 * Capacity Number - Label  --  FlexTable Reused UI
 *
 * @param $resource_parent
 * @param $resource_capacity
 *
 * @return void
 */
function wpbc_flextable_reused_ui__label_capacity_number( $resource_capacity ){

    if ( class_exists( 'wpdev_bk_biz_l' ) ){
		if ( intval($resource_capacity ) > 1 ) {
			?><div class="ui_element wpbc_flextable_labels"><?php
					?><a href="javascript:void(0);" onclick="javascript: jQuery( '#flextable_header_tab__capacity,#flextable_header_tab__labels').trigger('click');"
						 title="<?php echo esc_attr( __( 'Capacity', 'booking' ) ) . ': ' . esc_attr( $resource_capacity ); ?>"
						 class="wpbc_label wpbc_label_resource_parent wpbc_label_capacity_number tooltip_top"><strong><?php echo esc_html( $resource_capacity ); ?></strong></a><?php
			?></div><?php
		}
    }
}


/**
 * Parent | Child | Single - Label  --  FlexTable Reused UI
 *
 * @param $resource_parent
 * @param $resource_capacity
 *
 * @return void
 */
function wpbc_flextable_reused_ui__label_parent_child( $resource_parent, $resource_capacity ){

    if ( class_exists( 'wpdev_bk_biz_l' ) ){

		?><div class="ui_element"><?php

			if ( intval($resource_capacity ) > 1 ) {
				?><a href="javascript:void(0);" onclick="javascript: jQuery( '#flextable_header_tab__capacity').trigger('click');"
					class="wpbc_label wpbc_label_resource_parent"><?php esc_html_e( 'Capacity' , 'booking' ); ?>: <strong><?php echo esc_html( $resource_capacity ); ?></strong></a><?php
			} else {
				if ( empty( $resource_parent ) ) {
					?><a href="javascript:void(0);" onclick="javascript: jQuery( '#flextable_header_tab__capacity').trigger('click');"
						class="wpbc_label wpbc_label_resource_single"><?php echo esc_html( strtoupper(__( 'Single' , 'booking' ) ) ); ?></a><?php
				} else {
					?><a href="javascript:void(0);" onclick="javascript: jQuery( '#flextable_header_tab__capacity').trigger('click');"
						 class="wpbc_label wpbc_label_resource_child"><?php echo esc_html( strtoupper(__( 'Child' , 'booking' ) ) ); ?></a><?php

				}
			}

		?></div><?php

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
		if ( ( ! empty( $_GET['show_all_resources'] ) ) && ( ! empty( $resource_parent ) ) ) {
			$resources_cache              = wpbc_br_cache();
			$resource_list                = $resources_cache->get_single_parent_resources();
			$is__parent_resource_existing = false;
			foreach ( $resource_list as $single_par_resource ) {
				if ( $resource_parent == $single_par_resource['id'] ) {
					$is__parent_resource_existing = true;
					break;
				}
			}
			if ( ! $is__parent_resource_existing ) {
				?>
				<div class="ui_element"><?php
				?><a href="javascript:void(0);"
					 onclick="javascript: jQuery( '#flextable_header_tab__capacity').trigger('click');"
					 class="wpbc_label wpbc_label_resource_lost"><?php
				echo esc_html( strtoupper( __( 'Lost booking resource', 'booking' ) ) ); ?></a><?php
				?></div><?php
			}
		}
	}
}


/**
 * Resource Owner - Label  --  FlexTable Reused UI
 *
 * @param $resource_user_id
 *
 * @return void
 */
function wpbc_flextable_reused_ui__label_user_owner( $resource_user_id ) {

	if ( class_exists( 'wpdev_bk_multiuser' ) ) {

		$logged_in_user = wpbc_mu__wp_get_current_user();
		$logged_in_user_id = $logged_in_user->ID;
		if (
				( isset( $resource_user_id ) )
			&&  ( $logged_in_user_id != $resource_user_id )
		) {

			$is_can = apply_bk_filter( 'multiuser_is_user_can_be_here', true, 'only_super_admin' );
			if ( $is_can ) {

				// $booking_resource_user_id = apply_bk_filter('get_user_of_this_bk_resource', false, $resource['id' ] );
				// $is_booking_resource_user_super_admin = apply_bk_filter('is_user_super_admin',  $booking_resource_user_id );

				$wpbc_users_cache = wpbc_users_cache();
				$wpbc_users_cache->set_sorting_params( 'ID', 'ASC' );

				// Data loaded only once on first  request,  next  it got from the static variable
				$all_users = $wpbc_users_cache->get_activated_users_only();

				foreach ( $all_users as $single_user ) {

					if ( $resource_user_id == $single_user['id'] ) {

						// $single_user['role'] = maybe_unserialize($single_user['role']);
						// $single_user['role'] = array_keys($single_user['role']);
						// $single_user['role'] = implode( ',',  $single_user['role'] );

						?><div class="ui_element"><?php
							?><a href="javascript:void(0);" onclick="javascript: jQuery( '#flextable_header_tab__user_owner').trigger('click');"
								class="wpbc_label wpbc_label_user_owner"><?php
								echo '<span style="font-size:07px;padding: 0 1em 0 0;line-height: 2em;">'
										. esc_html__( 'User', 'booking' )
										//. ' [' . $single_user['role'] . ']'
									 . '</span>';
								echo '<strong>', wp_kses_post( $single_user['display_name'] ), '</strong>';
							?></a><?php
						?></div><?php
					}
				}
			}
		}
	}
}


// =====================================================================================================================
// Folders
// =====================================================================================================================

/**
 * Resource Folder Icons - Parent / Child resources  --  FlexTable Reused UI
 *
 * @param $resource_parent
 * @param $resource_capacity
 * @param $resource_last_child
 *
 * @return void
 */
function wpbc_flextable_reused_ui__folders_icons( $resource_parent, $resource_capacity, $resource_last_child ){

	if ( class_exists( 'wpdev_bk_biz_l' ) ) {

		// If child elements
		if( ! empty( $resource_parent ) ){
			?><div class="wpbc_flextable_col wpbc_flextable_col_folder_structure"><?php

				$last_el_class = ( ! empty( $resource_last_child) ) ? 'wpbc_flextable_col_folder_line_vertical__last' : '';

				?><i class="wpbc_flextable_col_folder_line_vertical <?php echo esc_attr( $last_el_class ); ?>"></i><?php

				?><i class="wpbc_flextable_col_folder_line_horizontal"  style=""></i><?php

			?></div><?php
		}

		// If parent element
		if  ( intval($resource_capacity ) > 1 ) {

			?><div class="ui_element wpbc_show_hide_children wpbc_show_hide_children_icon"><a href="javascript:void(0)"
							   onclick="javascript:jQuery('.wpbc_resource_child').toggle(500);jQuery('.wpbc_show_hide_children').toggle();"
							   title="<?php echo esc_attr( __( 'Hide Children Resources', 'booking' ) ); ?>"
							   class="wpbc_ui_control tooltip_top wpbc_ui_button0"><i
				class="menu_icon icon-1x wpbc_icn_folder_open"></i><span></span></a></div><?php

			?><div class="ui_element wpbc_show_hide_children wpbc_show_hide_children_icon" style="display:none;"><a href="javascript:void(0)"
							   onclick="javascript:jQuery('.wpbc_resource_child').toggle(500);jQuery('.wpbc_show_hide_children').toggle();"
							   title="<?php echo esc_attr( __( 'Show Children Resources', 'booking' ) ); ?>"
							   class="wpbc_ui_control tooltip_top wpbc_ui_button0"><i
				class="menu_icon icon-1x wpbc_icn_folder"></i><span></span></a></div><?php
		}
	}
}