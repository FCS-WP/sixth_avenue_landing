<?php
/**
 * @version 1.0
 * @package     Abstarct Settings FlexTable Class
 * @category    Settings Table Class
 * @author wpdevelop
 *
 * @web-site https://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com
 *
 * @modified 2024-01-13		// FixIn: 9.9.0.7.
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


/** Settings FlexTable Class  */
abstract class WPBC_Settings_FlexTable {

    protected $id;

    protected $columns;

    protected $loaded_data;

    protected $url_sufix = '';                                                  // append to all links -  useful for anchor to  HTML section  with  specific ID,  Example: '#my_section'

    protected $callback_rows_func = false;                                      // Callback Function  for showing rows in table: 'function_name'  or array( $object, 'method' );

    protected $parameters = array();


    public function __construct( $id, $args = array() ){

        $this->id = $id;

        $defaults = array(
                              'id' => wp_rand( 1000000 , ( 10000000-1 ) )
                            , 'is_show_pseudo_search_form' => true
                            , 'url_sufix' => ''
                            , 'rows_func' => false
                            , 'columns'   => array()                            /** Example:
                                                                                array(
                                                                                    'check' => array( 'title' => '<input type="checkbox" value="" id="br-select-all" name="resource_id_all" />'
                                                                                                    , 'class' => 'check-column'
                                                                                                )
                                                                                    , 'id' => array(  'title' =>__( 'ID', 'booking' )
                                                                                                    , 'style' => 'width:5em;'
                                                                                                    , 'sortable' => true
                                                                                                )
                                                                                    , 'title' => array(   'title' => __( 'Resources' )
                                                                                                        , 'style' => 'width:20em;'
                                                                                                        , 'sortable' => true
                                                                                                    )
                                                                                    , 'gcalid' => array(  'title' => __( 'Google Calendar ID' )
                                                                                                        , 'style' => 'text-align:center;'
                                                                                                    )
                                                                                    , 'info' => array(    'title' => __( 'Info' )
                                                                                                        , 'class' => ''
                                                                                                        , 'style' => 'width:15em;text-align:center;'
                                                                                                    )
                                                                                )
                                                                                */
                        );
        $this->parameters = wp_parse_args( $args, $defaults );

        ////////////////////////////////////////////////////////////////////////

        $this->set_url_sufix( $this->parameters['url_sufix'] );

        $this->define_columns( $this->parameters['columns'] );

        $this->define_callback_rows_func( $this->parameters['rows_func'] );

        ////////////////////////////////////////////////////////////////////////

        $this->loaded_data = $this->load_data();                                //  Load Data for showing in Table (like booking resources from  cache )
    }


	// -----------------------------------------------------------------------------------------------------------------
    // Data
	// -----------------------------------------------------------------------------------------------------------------
    /**
	 * Load Data for showing in Table
     *
     * @return array
     */
    abstract public function load_data();


    /**
	 * Get sorted part of booking resources array for ONE Page
     *
     * @return array
     */
    abstract public function get_linear_data_for_one_page();


	// -----------------------------------------------------------------------------------------------------------------
    // Other Abstract
	// -----------------------------------------------------------------------------------------------------------------
    /**
	 * Get Actual sorting parameter from Data Class or some other source
     *  based on version and $_GET['orderby'] & $_GET['order'] params
     *
     * @return array( 'orderby' => 'id', 'order' => 'desc' )     ||     array('orderby' => 'title', 'order' => 'asc' ) ....
     */
    abstract public function get_sorting_params();


    /**
	 * Get ONLY the paramters that  possible to  use in pagination buttons
     *
     * @return array( 'page', 'tab', 'wh_resource_id' );
     */
    abstract public function gate_paramters_for_pagination();


    // Visual //////////////////////////////////////////////////////////////////

    /**
	 * Show Footer Row
     * It's must  be something like:
     *                              <div colspan="<?php echo count( $this->get_columns() ); ?>" style="text-align: center;"> ... Data .... </th>
     */
    abstract public function show_footer();


	// -----------------------------------------------------------------------------------------------------------------
    //  Structure
	// -----------------------------------------------------------------------------------------------------------------
    /**
	 * Define Collumns for table
     *
     * @param array $collumns
     * Example:
                array(
                        'check'     => array( 'title' => '', 'attr' => array( 'class' => '', 'style' => ''  ), 'sortable' => true )
                      , 'id'        => array( 'title' => __('ID'), 'attr' => array( 'class' => '', 'style' => ''  ), 'sortable' => true )
                      , 'resources' => array( 'title' => __('Resources'), 'attr' => array( 'class' => '', 'style' => ''  ), 'sortable' => true )
                      , 'gcalid'    => array( 'title' => __('Google Calendar ID'), 'attr' => array( 'class' => '', 'style' => ''  ) )
                      , 'actions'   => array( 'title' => __('Actions'), 'attr' => array( 'class' => '', 'style' => ''  ) )
                )

     */
    public function define_columns( $collumns = array() ) {

       $this->columns = $collumns;
    }


    /**
	 * Get header columns array
     *
     * @return array
     */
    public function get_columns() {

       return $this->columns;
    }


    /**
	 * Define function name (or array for obj) to call  for showing rows in table
     *
     * @param $callback_rows_func
     */
    public function define_callback_rows_func( $callback_rows_func ) {
        $this->callback_rows_func = $callback_rows_func;
    }


    /** Display Table Columns - Header | Footer*/
    public function print_column_headers( $is_header = true ) {

        if ( $is_header ) {
            foreach ( $this->get_columns() as $col_id => $col_value ) {

	            $is_sortable = ( ! empty( $col_value['sortable'] ) );

                $active_sort = $this->get_sorting_params();                     // array( 'orderby' => 'id', 'order' => 'asc');

                ?><div <?php
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo ( ( ! empty( $col_value['id'] ) ) ? ( ' id="' . esc_attr( $col_value['id'] ) . '" ' ) : '' );
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo( ( ! empty( $col_value['class'] ) ) ? ( ' class="wpbc_flextable_col wpbc_flextable_col_head ' . esc_attr( $col_value['class'] ) . '" ' ) : '' );
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo( ( ! empty( $col_value['style'] ) ) ? ( ' style="' . esc_attr( $col_value['style'] ) . '" ' ) : '' );
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo( ( ! empty( $col_value['attr'] ) )  ? ( ' ' . $this->get_custom_attr_static( $col_value['attr'] ) . ' ' ) : '' );
				?>><?php
                        if ( $is_sortable ) {
                            													// First  parameter  will overwrite by $_GET['page'] parameter
                            $exclude_params = array();                          //  array( 'page_num', 'orderby', 'order' );
                                                                                //  if using "only_these_parameters",  then this parameter  does not require

                            $only_these_parameters  = $this->gate_paramters_for_pagination();       // array( 'page', 'tab', 'wh_resource_id' );

                            $wpbc_admin_url         = wpbc_get_params_in_url( wpbc_get_bookings_url( false, false ), $exclude_params, $only_these_parameters );

                            $order = 'asc';                                     // Default order

                            if ( $active_sort['orderby'] == $col_id ) {
                                if ( $active_sort['order'] == 'asc' )           // Change order if its actual order right now
                                    $order = 'desc';
                                else
                                    $order = 'asc';
                            }

                            ?><a href="<?php echo esc_url( $wpbc_admin_url . '&orderby=' . $col_id . '&order=' . $order . $this->url_sufix ); ?>"><?php
                        }
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $col_value['title'];

                            if ( $is_sortable ) {

                                if ( $active_sort['orderby'] == $col_id ) {
                                    ?> <span aria-hidden="true" class="<?php
                                            echo ( $active_sort['order'] == 'asc' ) ? 'wpbc_icn_vertical_align_top' : 'wpbc_icn_vertical_align_bottom'; ?>"
                                        ></span><?php
                                } else {
                                    ?> <span class="wpbc_icn_swap_vert" aria-hidden="true"></span><?php
                                }
                                ?></a><?php
                            }

                   ?></div><?php
            }
        } else {
            $this->show_footer();
        }
    }


    /** Display Table Rows */
    public function print_rows() {


        $data_rows = $this->get_linear_data_for_one_page();

				// For folders
				if ( count( $data_rows ) > 0 ) {
					$prior_key = false;
					foreach ( $data_rows as $row_key_id => $data_arr ) {

						if ( ! empty( $data_arr['parent'] ) ) {
							// Child
							$prior_key = $row_key_id;
						} else {
							// Single or parent
							if ( $prior_key !== false ) {
								$data_rows[ $prior_key ]['last_child'] = 1;
								$prior_key = false;
							}
						}
					}
				}
				if ( ( isset( $prior_key ) ) && ( $prior_key !== false ) ) {
					$data_rows[ $prior_key ]['last_child'] = 1;
				}

        $i = -1;
        if ( count( $data_rows ) > 0 ) {
            foreach ( $data_rows as $row_key_id => $data_arr ) {
                $i++;

                    if ( $this->callback_rows_func === false ) {
                        ?><div class="wpbc_flextable_row wpbc_no_results_row"><div class="wpbc_flextable_col"><?php
                                echo 'Error. Does not defined WPBC_Settings_Table::callback_rows_func';
                        ?></div></div><?php

                        return;
                    }

                call_user_func_array( $this->callback_rows_func, array( $i,  $data_arr ) );
            }
        } else {
            ?><div class="wpbc_flextable_row wpbc_no_results_row"><div class="wpbc_flextable_col"><?php
				esc_html_e( 'No results found.', 'booking' );
            ?></div></div><?php
        }
    }


        // Support Visual Functions, that possible to override

        /**
	 	 * Get array of CSS classes for DIV element before  Table
         *
         * @return array            - array( 'wpbc_resources_table' );
         */
        public function div_before_table_css_classes() {

            return array( 'wpbc_resources_flextable' );
        }

        /**
	 	 * Get array of CSS classes for Table
         *
         * @return array            - array( 'sortable' );
         */
        public function table_css_classes() {

            return array();                     // array( 'sortable' );
        }

        ////////////////////////////////////////////////////////////////////////


    /** Display Table */
    public function display() {

        do_action( 'wpbc_before_showing_settings_flextable', $this->id );

        ?>
        <div class="wpbc_selectable_table <?php echo esc_attr( implode( ' ', $this->div_before_table_css_classes() ) ); ?>">
            <div class="wpbc_flextable <?php echo esc_attr( implode( ' ', $this->table_css_classes() ) ); ?>">
                <div class="wpbc_selectable_head">
                    <div class="wpbc_flextable_row">
                        <?php
							$this->print_column_headers();
							do_action( 'wpbc_selectable_head__content_after', $this->id );
						?>
                    </div>
                </div>

                <div class="wpbc_selectable_body">
                        <?php $this->print_rows(); ?>
                </div>
                <div class="wpbc_selectable_foot">
                    <div class="wpbc_flextable_row">
                        <?php
							$this->print_column_headers( false );
							do_action( 'wpbc_selectable_foot__content_after', $this->id );								// FixIn: 9.9.0.22.
						?>
                    </div>
                </div>
            </div>
        </div>
        <?php

        do_action( 'wpbc_after_showing_settings_flextable', $this->id );
    }


	// -----------------------------------------------------------------------------------------------------------------
    // Support
	// -----------------------------------------------------------------------------------------------------------------
    /**
	 * Get custom attributes
     *
     * @param  array $field
     * @return string
     */
    protected static function get_custom_attr_static( $field ) {

        $attributes = array();

        if ( ! empty( $field['attr'] ) && is_array( $field['attr'] ) ) {

            foreach ( $field['attr'] as $attr => $attr_v ) {
                $attributes[] = esc_attr( $attr ) . '="' . esc_attr( $attr_v ) . '"';
            }
        }

        return implode( ' ', $attributes );
    }

    public function set_url_sufix( $param ) {
        $this->url_sufix = $param;
    }

}