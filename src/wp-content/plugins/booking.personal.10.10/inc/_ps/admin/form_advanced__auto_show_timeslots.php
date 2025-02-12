<?php
/**
 * @version 1.0
 * @package     Auto Load Time Slots Generator
 * @category    WP Booking Calendar > Settings > Booking Form page
 * @author wpdevelop
 *
 * @web-site https://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com
 *
 * @modified 2024-09-24
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


/**
 * Auto Load Time Slots Generator
 *
 * @param $page string
 */
function wpbc_hook_settings_page_footer__auto_show_timeslots_generator( $page ){

	if ( 'form_field_settings'  === $page ) {

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
		if ( ( isset( $_GET['field_type'] ) ) && ( 'timeslots' === $_GET['field_type'] ) ) {
			?>
			<script type="text/javascript">
				 jQuery(document).ready(function() {
					 jQuery( '#select_form_help_shortcode').val('wpbc_rangetime_select').trigger('change');
					 wpbc_blink_element('#wpbc_field_help_section_wpbc_rangetime_select', 4, 350);
				 });
			</script>
			<?php
		}
	}

}
add_action('wpbc_hook_settings_page_footer', 'wpbc_hook_settings_page_footer__auto_show_timeslots_generator');

