<?php /**
 * @version 1.0
 * @package Booking Calendar
 * @category Flex Toolbar for Booking Forms
 * @author wpdevelop
 *
 * @web-site https://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com
 *
 * @modified 2024-08-13
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit, if accessed directly


/**
 *  UI Flex Elements   ->   ../includes/_toolbar_ui/flex_ui_elements.php
 */

// ---------------------------------------------------------------------------------------------------------------------
//  Toolbar with UI elements 	for 	"Booking  Form"
// ---------------------------------------------------------------------------------------------------------------------

/**
 * Show toolbar for Booking Form
 *
 * @return void
 */
function wpbc_flex_toolbar__booking_form(  ) {

	// css class: wpbc_flex_toolbar_container

	?><div class="wpbc_ajx_toolbar wpbc_no_borders0"><?php
		?><div class="ui_container    ui_container_toolbar		ui_container_small    ui_container_custom_forms_selection    ui_container_actions_row_1"><?php

			// Select	- Custom Forms -
			if ( function_exists( 'wpbc_flex_toolbar__custom_forms' ) ) {
				wpbc_flex_toolbar__custom_forms();
			}


			// Reset	- Form Template -
			?><div class="ui_group ui_group___reset_form_templates" style="<?php echo ( class_exists( 'wpdev_bk_biz_m' ) ) ? 'margin-left:auto;' : ''; ?>"><?php

				?><div class="ui_element"><?php
					wpbc_flex_ui__dropdown_list__form_templates();														// Show reset form Drop down  list
				?></div><?php

				?><div class="ui_element"><?php
					wpbc_flex_ui__reset_form_template__button();
				?></div><?php

			?></div><?php



		?></div><?php
	?></div><?php

}


// ---------------------------------------------------------------------------------------------------------------------
//  UI Elements
// ---------------------------------------------------------------------------------------------------------------------
function wpbc_flex_ui__dropdown_list__form_templates(){

	$id = 'select_default_form_template';

	$templates = wpbc_flex_ui__dropdown_list__form_templates__get_options();

	$params_select = array(
		'id'       => $id, 									// HTML ID  of element
		'name'     => $id,
		'options'  => $templates,
		'onchange' => ''
		// 'label' => __('Booking Form', 'booking') . ':'							// Label (optional)
		//	, 'style' => ''                     								// CSS of select element
		//	, 'class' => ''                     								// CSS Class of select element
		//	, 'multiple' => false
		//	, 'attr' => array()                 								// Any additional attributes, if this radio | checkbox element
		//	, 'disabled' => false
		//	, 'disabled_options' => array( 2, 30 )     							// If some options disabled, then it has to list here
		//	, 'value' => ( isset( $escaped_search_request_params[ 'next_days' ] ) ) ? $escaped_search_request_params[ 'next_days' ] : '183'	// Some Value from options array that selected by default
		//	, 'onfocus' =>  "console.log( 'ON FOCUS:', jQuery( this ).val(), 'in element:' , jQuery( this ) );"					// JavaScript code
	);



	wpbc_flex_label(
						array(
							'id'    => $id,
							'label' => __( 'Form Template', 'booking' ) . ':',
							'style' => 'font-weight:600;'                     // CSS of select element
						)
					);

	wpbc_flex_select( $params_select );
}


	/**
	 * Get list  of options for Predefined booking form templates
	 * @return array
	 */
	function wpbc_flex_ui__dropdown_list__form_templates__get_options(){

		$templates = array();

		$templates['selector_hint'] = array(
												'title' => __('Select', 'booking') . ' ' .  __('Form Template', 'booking')
												, 'id' => ''
												, 'name' => ''
												, 'style' => 'font-weight: 400;border-bottom:1px dashed #ccc;'
												, 'class' => ''
												, 'disabled' => false
												, 'selected' => false
												, 'attr' => array()
											);

		$templates[ 'optgroup_sf_s' ] = array(
												'optgroup' => true
												, 'close'  => false
												, 'title'  => '&nbsp;' . __('Standard Templates' ,'booking')
											);
		$templates[ 'standard' ] = array(
												'title' => __('Standard', 'booking')
												, 'id' => ''
												, 'name' => ''
												, 'style' => ''
												, 'class' => ''
												, 'disabled' => false
												, 'selected' => false
												, 'attr' => array()
											);
		$templates[ '2collumns' ] = array(
												'title' => __('Calendar next to form', 'booking')
												, 'id' => ''
												, 'name' => ''
												, 'style' => ''
												, 'class' => ''
												, 'disabled' => false
												, 'selected' => false
												, 'attr' => array()
											);
		// FixIn: 8.7.7.15.
		$templates[ 'fields2columns' ] = array(
												'title' => '2 ' . __('columns', 'booking')
												, 'id' => ''
												, 'name' => ''
												, 'style' => ''
												, 'class' => ''
												, 'disabled' => false
												, 'selected' => false
												, 'attr' => array()
											);

		// FixIn: 8.8.2.6.
		$templates[ 'fields3columns' ] = array(
												'title' => '3 ' . __('columns', 'booking')
												, 'id' => ''
												, 'name' => ''
												, 'style' => ''
												, 'class' => ''
												, 'disabled' => false
												, 'selected' => false
												, 'attr' => array()
											);

		// FixIn: 8.7.11.14.
		$templates[ 'fields2columnstimes' ] = array(
												'title' => __('2 columns with  times', 'booking')
												, 'id' => ''
												, 'name' => ''
												, 'style' => ''
												, 'class' => ''
												, 'disabled' => false
												, 'selected' => false
												, 'attr' => array()
											);

		if (class_exists('wpdev_bk_biz_s')) {


			$templates['payment'] = array(
												'title' => __('Payment', 'booking')
												, 'id' => ''
												, 'name' => ''
												, 'style' => ''
												, 'class' => ''
												, 'disabled' => false
												, 'selected' => false
												, 'attr' => array()
											);
			// FixIn: 8.1.1.5.
			$templates['paymentUS'] = array(
												'title' => __('Payment', 'booking') . ' (US)'
												, 'id' => ''
												, 'name' => ''
												, 'style' => ''
												, 'class' => ''
												, 'disabled' => false
												, 'selected' => false
												, 'attr' => array()
											);
			$templates[ 'optgroup_sf_e' ] = array( 'optgroup' => true, 'close'  => true );


			$templates[ 'optgroup_tf_s' ] = array(
													'optgroup' => true
													, 'close'  => false
													, 'title'  => '&nbsp;' . __('Times Templates' ,'booking')
												);
			// FixIn: 10.9.6.5.
			$templates['appointments_service_a'] = array(
												'title' => __('Appointments based on Service Duration', 'booking') . ' - 1',
												'id' => '', 'name' => '', 'style' => '', 'class' => '', 'disabled' => false, 'selected' => false, 'attr' => array()
											);
			$templates['appointments_service_b'] = array(
												'title' => __('Appointments based on Service Duration', 'booking') . ' - 2',
												'id' => '', 'name' => '', 'style' => '', 'class' => '', 'disabled' => false, 'selected' => false, 'attr' => array()
											);
			$templates['appointments30'] = array(
												//'title' => __('Time-Based Appointments', 'booking'),
												'title' => __('Appointments based on Time Slots', 'booking'),
												'id' => '', 'name' => '', 'style' => '', 'class' => '', 'disabled' => false, 'selected' => false, 'attr' => array()
											);
			$templates['times'] = array(
												'title' => __('Time slots', 'booking'),
												'id' => '', 'name' => '', 'style' => '', 'class' => '', 'disabled' => false, 'selected' => false, 'attr' => array()
											);
			$templates['times120'] = array(
												'title' => __('Time slots', 'booking') . ' 2 ' . __( 'hours', 'booking' ),
												'id' => '', 'name' => '', 'style' => '', 'class' => '', 'disabled' => false, 'selected' => false, 'attr' => array()
											);
			$templates['times60'] = array(
												'title' => __('Time slots', 'booking') . ' 1 ' . __( 'hour', 'booking' ),
												'id' => '', 'name' => '', 'style' => '', 'class' => '', 'disabled' => false, 'selected' => false, 'attr' => array()
											);
			$templates['times60_24h'] = array(
												'title' => __('Time slots', 'booking') . ' 1 ' . __( 'hour', 'booking' ). ' (24H)',
												'id' => '', 'name' => '', 'style' => '', 'class' => '', 'disabled' => false, 'selected' => false, 'attr' => array()
											);
			$templates['times30'] = array(
												'title' => __('Time slots', 'booking') . ' 30 ' . __( 'minutes', 'booking' ),
												'id' => '', 'name' => '', 'style' => '', 'class' => '', 'disabled' => false, 'selected' => false, 'attr' => array()
											);
			$templates['times15'] = array(
												'title' => __('Time slots', 'booking') . ' 15 ' . __( 'minutes', 'booking' ) . ' (AM/PM)',
												'id' => '', 'name' => '', 'style' => '', 'class' => '', 'disabled' => false, 'selected' => false, 'attr' => array()
											);
			$templates['endtime'] = array(
												'title' => __( 'Start Time', 'booking' ) . ' / ' . __( 'End Time', 'booking' ),
												'id' => '', 'name' => '', 'style' => '', 'class' => '', 'disabled' => false, 'selected' => false, 'attr' => array()
											);
			$templates['durationtime'] = array(
												'title' => __( 'Start Time', 'booking' ) . ' / ' . __( 'Duration Time', 'booking' ),
												'id' => '', 'name' => '', 'style' => '', 'class' => '', 'disabled' => false, 'selected' => false, 'attr' => array()
											);
		}

		$templates[ 'optgroup_tf_e' ] = array( 'optgroup' => true, 'close'  => true );


		$templates[ 'optgroup_af_s' ] = array(
												'optgroup' => true
												, 'close'  => false
												, 'title'  => '&nbsp;' . __('Advanced Templates' ,'booking')
											);
		$templates[ 'wizard' ] = array(
												'title' => __('Wizard (several steps)', 'booking')
												, 'id' => ''
												, 'name' => ''
												, 'style' => ''
												, 'class' => ''
												, 'disabled' => false
												, 'selected' => false
												, 'attr' => array()
											);
		// Other alternatives: 'wizard_times', 'wizard_times30', 'wizard_times15', 'wizard_times120', 'wizard_times60', 'wizard_times60_24h'
		$templates[ 'wizard_times30' ] = array(
												'title' => __('Wizard', 'booking') .  ' ('.__('Time slots', 'booking') . ' 30 ' . __( 'minutes', 'booking' ) . ')'
												, 'id' => ''
												, 'name' => ''
												, 'style' => ''
												, 'class' => ''
												, 'disabled' => false
												, 'selected' => false
												, 'attr' => array()
											);

		if (class_exists('wpdev_bk_biz_m')) {

			$templates['timesweek'] = array(
																'title' => __('Time slots for different weekdays', 'booking')
																, 'id' => ''
																, 'name' => ''
																, 'style' => ''
																, 'class' => ''
																, 'disabled' => false
																, 'selected' => false
																, 'attr' => array()
															);
			$templates['hints'] = array(
																'title' => __('Hints', 'booking')
																, 'id' => ''
																, 'name' => ''
																, 'style' => ''
																, 'class' => ''
																, 'disabled' => false
																, 'selected' => false
																, 'attr' => array()
															);
			// FixIn: 8.7.3.5.
			$templates['hints-dev'] = array(
																'title' => __('Hints', 'booking') . ' [' . __('days', 'booking') . ']'
																, 'id' => ''
																, 'name' => ''
																, 'style' => ''
																, 'class' => ''
																, 'disabled' => false
																, 'selected' => false
																, 'attr' => array()
															);
		}

		$templates[ 'optgroup_af_e' ] = array( 'optgroup' => true, 'close'  => true );

		return $templates;
	}

function wpbc_flex_ui__reset_form_template__button(){

	$id = 'select_default_form_template';

	$el_id = 'ui_btn_' . $id;

	$params  =  array(
		'type'             => 'button' ,
		'title'            => '', //__( 'Reset', 'booking' ) . '&nbsp;&nbsp;',  							// Title of the button
		'hint'             => array( 'title' => __( 'Reset booking form to the selected form template', 'booking' ), 'position' => 'top' ),  	// Hint
		'link'             => 'javascript:void(0)',  													// Direct link or skip  it
		'action'           => " var sel_res_val = document.getElementById('{$id}').options[ document.getElementById('{$id}').selectedIndex ].value;"
							. " if   ( sel_res_val == 'selector_hint') { "
							. "    wpbc_field_highlight( '#{$id}' ); return;"
							. " }"
							. "    wpbc_reset__form_configuration( sel_res_val ); "
							. "    wpbc_reset__form_data( sel_res_val ); " ,
		'icon' 			   => array(
									'icon_font' => 'wpbc_icn_settings_backup_restore wpbc_icn_system_update_alt0',
									'position'  => 'left',
									'icon_img'  => ''
								),
		'class'            => 'wpbc_ui_button wpbc_ui_button_danger',  														// ''  | 'wpbc_ui_button_primary'
		'style'            => '',																		// Any CSS class here
		'mobile_show_text' => true,																		// Show  or hide text,  when viewing on Mobile devices (small window size).
		'attr'             => array( 'id' => $el_id )
	);

	wpbc_flex_button( $params );

}


function wpbc_flex_toolbar__booking_form__top_tabs__ps(){

	wpbc_bs_toolbar_tabs_html_container_start();

	if ( wpbc_is_mu_user_can_be_here( 'only_super_admin' ) ) {                                                    // FixIn: 8.2.1.23.


			wpbc_bs_display_tab(   array(
												'title'         => __('Simple Form', 'booking')
												, 'hint' 		=> array( 'title' => __('Customize booking form in a simple setup' ,'booking') , 'position' => 'bottom' )
												, 'onclick'     =>    "jQuery( '#is_use_simple_booking_form' ).prop( 'checked', true );document.forms['form_is_use_simple_booking_form'].submit();"
																	. "jQuery('#toolbar_booking_resources .nav-tab').removeClass('nav-tab-active');"
																	. "jQuery(this).addClass('nav-tab-active');"
																	. "jQuery('.nav-tab i.icon-white').removeClass('icon-white');"
																	. "jQuery('.nav-tab-active i').addClass('icon-white');"
												, 'attr' => array( 'style' => 'order:1;' )			// In paid version  set it as second tab
												, 'font_icon'   => 'wpbc_icn_format_align_left'
												, 'default'     => ( 'On' == get_bk_option( 'booking_is_use_simple_booking_form' ) )
								) );
			wpbc_bs_display_tab(   array(
												'title'         => __('Advanced Form', 'booking')
												, 'hint' 		=> array( 'title' => __('Customize booking form in a advanced setup' ,'booking') , 'position' => 'bottom' )
												, 'onclick'     =>    "jQuery( '#is_use_simple_booking_form' ).prop( 'checked', false );document.forms['form_is_use_simple_booking_form'].submit();"
																	. "jQuery('.ui_container_options').show();"
																	. "jQuery('#toolbar_booking_resources .nav-tab').removeClass('nav-tab-active');"
																	. "jQuery(this).addClass('nav-tab-active');"
																	. "jQuery('.nav-tab i.icon-white').removeClass('icon-white');"
																	. "jQuery('.nav-tab-active i').addClass('icon-white');"
												, 'font_icon'   => 'wpbc_icn_dashboard'
												, 'default'     =>  ( 'On' != get_bk_option( 'booking_is_use_simple_booking_form' ) )

								) );

			//	echo '<span class="wpdevelop" style="margin-left:auto;order:99;display:none;">'; wpbc_bs_dropdown_menu_help(); echo '</span>';


	} else {
		// Regular users in MU
		wpbc_bs_display_tab(   array(
											'title'         => __('Form Fields Setup', 'booking')
											, 'hint' 		=> array( 'title' => ( 'On' == get_bk_option( 'booking_is_use_simple_booking_form' ) )
																					? __('Customize booking form in a advanced setup' ,'booking')
																					: __('Customize booking form in a simple setup' ,'booking'),
																	  'position' => 'bottom' )
											, 'onclick'     =>    ""
											, 'attr' => array( 'style' => 'order:0;' )			// In paid version  set it as second tab
											, 'font_icon'   => 'wpbc_icn_format_align_left'
											, 'default'     => true
							) );
	}
	wpbc_bs_toolbar_tabs_html_container_end();
}




		/**
		 * Use simple booking form -- checkbox at toolbar  in Booking > Settings > Form page.
		 */
		/**
		 * Add form for switching to  simple or Advanced booking form  at  the top  of the page.
		 *
		 * @param type $page
		 */
		function wpbc_html_form_toolbar_use_simple_booking_form( $page ) {

			if ( ! wpbc_is_mu_user_can_be_here('only_super_admin') ) return false;    	// if 'regular user'  then  exit

			if (
					( 'form_field_free_settings' === $page )
				 || ( 	   'form_field_settings' === $page )
			) {
				$submit_form_name = 'form_is_use_simple_booking_form';

				// Submit
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
				if ( ( isset( $_POST[ 'is_form_sbmitted_' . $submit_form_name ] ) ) && ( ! empty( $_POST[ 'is_form_sbmitted_' . $submit_form_name ] ) ) ) {

					// Nonce checking    {Return false if invalid, 1 if generated between, 0-12 hours ago, 2 if generated between 12-24 hours ago. }
					$nonce_gen_time = check_admin_referer( 'wpbc_settings_page_' . $submit_form_name );  // Its stop show anything on submiting, if its not refear to the original page

					$is_use_simple_booking_form = isset( $_POST['is_use_simple_booking_form'] ) ? 'On' : 'Off';

					// Save Changes
					update_bk_option( 'booking_is_use_simple_booking_form', $is_use_simple_booking_form );

					wpbc_show_changes_saved_message();

					// Reload Page
					?><script type="text/javascript"> window.location.href = '<?php
							// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							echo ( wpbc_get_settings_url() ) . '&tab=form'; ?>'; </script><?php
				}

				// Form
				?>
				<form name="<?php echo esc_attr( $submit_form_name ); ?>" action="" method="post" id="<?php echo esc_attr( $submit_form_name ); ?>"><?php

					wp_nonce_field( 'wpbc_settings_page_' . $submit_form_name );
					?><input type="hidden" name="is_form_sbmitted_<?php echo esc_attr( $submit_form_name ); ?>" id="is_form_sbmitted_<?php echo esc_attr( $submit_form_name ); ?>" value="1" /><?php
					?><input type="checkbox" name="is_use_simple_booking_form" id="is_use_simple_booking_form" style="display: none;"
							 value="<?php echo esc_attr( get_bk_option( 'booking_is_use_simple_booking_form' ) ); ?>"/><?php

				?></form><?php
			}
		}
		add_action('wpbc_hook_settings_page_header',     'wpbc_html_form_toolbar_use_simple_booking_form' );
