<?php

if ( ! defined( 'ABSPATH' ) ) exit;
if (file_exists(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-info.php')) { require_once(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-info.php' ); }
if (file_exists(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-text.php')) { require_once(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-text.php' ); }
    if (file_exists(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-button.php')) { require_once(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-button.php' ); }
    if (file_exists(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-textarea.php')) { require_once(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-textarea.php' ); }
    if (file_exists(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-select.php')) { require_once(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-select.php' ); }
        if (file_exists(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-checkbox.php')) { require_once(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-checkbox.php' ); }
            if (file_exists(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-radio.php')) { require_once(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-radio.php' ); }
    if (file_exists(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-simple.php')) { require_once(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-simple.php' ); }
        if (file_exists(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-simple2.php')) { require_once(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-field-help-simple2.php' ); }
/**
 * WPBC_Form_Help Class
 * 
 * Help system for the shortcodes in the booking form
 */
class WPBC_Form_Help {

    /*public $elements =array(    
                                                                                'calendar',
                                                                                'text',
                                                                                'select',
                                                                                'checkbox',
                                                                                'textarea',
                                                                                'captcha',
                                                                                'email',
                                                                                'submit'                                                
                                                                                'cost_corrections',
                                                                                'country',
                                                                                'coupon',        
                                                                                'time',
                                                                                'starttime', 'endtime',
                                                                                'select starttime', 'select endtime',
                                                                                'select rangetime', 
                                                                                'select durationtime', 
      
                                                                                *  COST HINTS:
                                                                                * 
                                                                                *  'hints','cost_hint','original_cost_hint','additional_cost_hint',       
                                                                                *  [deposit_hint], [balance_hint], 
                                                                                * 
                                                                                *  Dates HINTS:
                                                                                * 
                                                                                *  [check_in_date_hint], [check_out_date_hint], 
                                                                                *  [start_time_hint], [end_time_hint], 
                                                                                *  [selected_dates_hint], [selected_timedates_hint], 
                                                                                *  [selected_short_dates_hint], [selected_short_timedates_hint], 
                                                                                *  [days_number_hint], [nights_number_hint]
                                                                                * 
                                                                                * 
                                                                                'lang',

                                                                                'conditions FIELDS'

                                                                                'conditions Times'

                                                                                'rangetime - in multiple exclusive selectbox'
     * 
    );*/

    public $fields = array();
    public $form_id;
    public $version;
    
    public function __construct($params) {
        
        if (isset($params['id'])) 
            $this->form_id = $params['id'];
        
        if (isset($params['version'])) 
            $this->version = $params['version'];
        else 
            $this->version = 'personal';
        
        $this->init();
    
    }
    
    private function init(){
                
        $this->fields[] = array(
                                'class_type' => 'info',
                                'type'  => 'general',
                                'id'    => 'wpbc_general',  
                                'title' => __('General Information' ,'booking'),
                                'help'  => array(
                                     '<strong>' . esc_html__('Shortcodes' ,'booking') . '.</strong> '
                                               . sprintf(__('You can generate the form fields for your form (at the left side) by selection specific field in the above selectbox.' ,'booking'),'<code><strong>[email* email]</strong></code>')
                                    /* translators: 1: ... */
                                    .'<br/>'   . sprintf( __( 'Please read more about the booking form fields configuration %1$shere%2$s.', 'booking' ),'<a href="https://wpbookingcalendar.com/faq/booking-form-fields/" target="_blank">', '</a>' )

                                    ,'<strong>' . esc_html__('HTML' ,'booking') . '.</strong> ' .
                                                 /* translators: 1: ... */
                                                 sprintf( __( 'You can use any %1$sHTML tags%2$s in the booking form. Please use the HTML tags carefully. Be sure, that all "open" tags (like %3$s) are closed (like this %4$s).', 'booking' )
                                                            ,'<strong>','</strong>'
                                                            ,'<code>&lt;div&gt;</code>'
                                                            ,'<code>&lt;/div&gt;</code>'
                                                         )
                                    
                                    ,'<strong>' . esc_html__('Default Form Templates' ,'booking') . '.</strong> ' .
                                                 /* translators: 1: ... */
                                                 sprintf( __( 'You can reset your active form template by selecting default %1$sform template%2$s at the top toolbar. Please select the form template and click on %3$sReset%4$s button for resetting only active form (Booking Form or Content of Booking Fields form). Click  on %5$sBoth%6$s button if you want to reset both forms: Booking Form and Content of Booking Fields form.', 'booking' )
                                                            ,'<strong>','</strong>'
                                                            ,'<strong>','</strong>'
                                                            ,'<strong>','</strong>'
                                                         )
                                                 )
                               , 'selector_style'=>'font-weight: 600;margin-bottom:5px;'                               
                               );

			$this->fields[] = array( 'optgroup' => '<optgroup label="&nbsp;'  . esc_attr( __( 'Custom HTML Shortcodes', 'booking' ) ) . '">' );
            $this->fields[] = array(
								'class_type' => 'info',
								'type'       => 'custom_html_shortcodes',
								'id'         => 'wpbc_custom_html_shortcodes',
                                'title'      =>  __( 'Simple HTML' ,'booking' ) . '&nbsp;  | &nbsp;' .  __( 'New', 'booking' ) . ' ' ,
                                'help'  => array(
                                  sprintf( __('Booking Calendar supercharged with new simple way to configure rows and several columns for you fields configuration.' ,'booking') , '<strong>' , '</strong>')

                                ,'<strong>'.esc_html__('Configuration' ,'booking') . '</strong>'
                                . '<br/>' . esc_html__( 'Row: ', 'booking' ) . '<code><strong>&lt;r&gt;...&lt;/r&gt;</strong></code>'
                                . '<br/>' . esc_html__( 'Columns: ', 'booking' ) . '<code><strong>&lt;c&gt;...&lt;/c&gt;</strong></code>'
                                . '<br/>' . esc_html__( 'Labels: ', 'booking' ) . '<code><strong>&lt;l&gt;...&lt;/l&gt;</strong></code>'
                                . '<br/>' . esc_html__( 'Spacer: ', 'booking' ) . '<code><strong>&lt;spacer&gt;&lt;/spacer&gt;</strong></code>'

                                , '<strong>'.__('Row with 1 column:' ,'booking') . '</strong>'
                                . '<code><pre>&lt;r&gt;  &lt;c&gt; ... &lt;/c&gt;  &lt;/r&gt;</pre></code>'
                                . '<strong>'.__('Row with 2 columns:' ,'booking') . '</strong>'
                                . '<code><pre>&lt;r&gt;  &lt;c&gt;..&lt;/c&gt; &lt;c&gt;..&lt;/c&gt;  &lt;/r&gt;</pre></code>'
                                . '<strong>'.__('Row with 3 columns:' ,'booking') . '</strong>'
                                . '<code><pre>&lt;r&gt;<br>  &lt;c&gt;...&lt;/c&gt;<br>  &lt;c&gt;...&lt;/c&gt;<br>  &lt;c&gt;...&lt;/c&gt;<br>&lt;/r&gt;</pre></code>'

                                , '<strong>'.__('Examples' ,'booking') . '</strong>'.'<hr> '
                                . '<strong>'.__('Row with 3 fields' ,'booking') . '</strong>'.'<br> '
                                . '<br><pre>'
                                .'&lt;r&gt;'.'<br>'
								. '  &lt;c&gt;' . '&lt;l&gt;First Name (required):&lt;/l&gt;&lt;br&gt; [text* name]' . ' &lt;/c&gt;' . '<br>'
								. '  &lt;c&gt;' . '&lt;l&gt;Middle Name:&lt;/l&gt;&lt;br&gt; [text middlename]' 	 . ' &lt;/c&gt;' . '<br>'
								. '  &lt;c&gt;' . '&lt;l&gt;Last Name:&lt;/l&gt;&lt;br&gt; [text secondname]' 		 . ' &lt;/c&gt;' . '<br>'
                                .'&lt;/r&gt;'.'<br>'
                                , '<strong>'.__('Horizontal Spacer:' ,'booking') . '</strong>'.'<br> '
                                . '<code><strong>&lt;spacer&gt;&lt;/spacer&gt;</strong></code>'.'<br> '
                                . '<code><strong>&lt;spacer&gt;width:1em;&lt;/spacer&gt;</strong></code>'.'<br> '
                                , '<strong>'.__('Vertical Spacer:' ,'booking') . '</strong>'.'<br> '
                                . '<code><strong>&lt;spacer&gt;height:10px;&lt;/spacer&gt;</strong></code>'

                                                )
                               );

        $this->fields[] = array('optgroup' => '</optgroup>');
        $this->fields[] = array('optgroup' => '<optgroup label="&nbsp;'.__('Required Fields in Booking Form' ,'booking').'">'); 
        
        $this->fields[] = array(
                                'class_type' => 'simple',
                                'type'  => 'calendar',
                                'id'    => 'wpbc_calendar',  
                                'title' => __('Calendar' ,'booking'),
                                'help'  => array(
                                                /* translators: 1: ... */
                                                '<strong>' . esc_html__('Important!' ,'booking') . '</strong> ' . sprintf(__( 'You must to have this shortcode:%s in the form.' ,'booking'),'<code><strong>[calendar]</strong></code>')
                                              , ( ( ($this->version == 'biz_m') || ($this->version == 'biz_l') )?(
                                                sprintf(__('You can insert several calendars of different resources into the form allowing you to book several resources during one booking process.' ,'booking'),'<strong>','</strong>')                                              
                                                /* translators: 1: ... */
                                                . '<br/>'. sprintf(__( 'Example: %s.' ,'booking'),'<br/><code>[calendar] [calendar id=2] [calendar id=3]</code>')
                                                /* translators: 1: ... */
                                                . '<br/>'. sprintf( __( 'where %1$s – default calendar %2$s (you can select desired resource of calendar by inserting shortcode into page)%3$s', 'booking' ),'<code>[calendar]</code>','<em>','</em>')
												/* translators: 1: ... */
                                                . '<br/>'. sprintf( __( '%1$s – calendar of booking resource with %2$s', 'booking' ),'<code>[calendar id=2]</code>','ID=2')
												/* translators: 1: ... */
                                                . '<br/>'. sprintf( __( '%1$s – calendar of booking resource with %2$s', 'booking' ),'<code>[calendar id=3]</code>','ID=3')
												/* translators: 1: ... */
                                                . '<br/>'. sprintf( __( 'Please check more about this feature %1$shere%2$s.', 'booking' ),'<a href="https://wpbookingcalendar.com/faq/booking-many-different-items-via-one-booking-form/" target="_blank">','</a>')
                                                      ):'')
                                              /* translators: 1: ... */
                                              , '<strong>' . esc_html__('Important!' ,'booking') . '</strong> '. sprintf( __( 'You can %1$suse this shortcode only once%2$s in the form.', 'booking' ),'<strong>','</strong>')
                                                )
                                , 'selector_style'=>'border-top: 1px dashed #999999;'
                               ); 
        
        $this->fields[] = array(
                                'class_type' => 'text',
                                'type'  => 'email',
                                'id'    => 'wpbc_email',  
                                'title' => __('Email Field' ,'booking'),
                                /* translators: 1: ... */
                                'help'  => '<strong>' . esc_html__('Important!' ,'booking') . '</strong> ' . sprintf(__( 'You must have this shortcode:%s in the booking form.' ,'booking'),'<code><strong>[email* email]</strong></code>') . ' ' . __('This is the primary email field, which is used for sending emails to visitors.' ,'booking')
                               );
        
        
        $this->fields[] = array('optgroup' => '</optgroup>'); 
        $this->fields[] = array('optgroup' => '<optgroup label="&nbsp;'.__('Standard Fields' ,'booking').'">'); 
        
        $this->fields[] = array(
                                'class_type' => 'text',            
                                'type'  => 'text',
                                'id'    => 'wpbc_text',  
                                'title' => __('Text' ,'booking') 
                                , 'selector_style'=>'border-top: 1px dashed #999999;'
                               );
        
        
        $this->fields[] = array(
                                'class_type' => 'textarea',
                                'type'  => 'textarea',
                                'id'    => 'wpbc_textarea',  
                                'title' => __('Textarea' ,'booking') 
                               );

        $this->fields[] = array(
                                'class_type' => 'select',
                                'type'  => 'selectbox',
                                'id'    => 'wpbc_select',  
                                'title' => __('Drop Down' ,'booking')
                                ,'advanced' => array( 
                                             '_options' => array(
                                                          'value' => '1\n2\n3\n4'
                                                       ),
                                            )            
                               );

        $this->fields[] = array(
                                'class_type' => 'checkbox',
                                'type'  => 'checkbox',
                                'id'    => 'wpbc_checkbox',  
                                'title' => __('Checkbox(es)' ,'booking') 
                               );
        
        $this->fields[] = array(
                                'class_type' => 'radio',
                                'type'  => 'radio',
                                'id'    => 'wpbc_radio',  
                                'title' => __('Radio Button(s)' ,'booking') 
                                ,'advanced' => array( 
                                             '_options' => array(
                                                          'value' => '1\n2\n3\n4'
                                                       ),
                                            )                        
                               );
  
        $this->fields[] = array(
                                'class_type' => 'simple',
                                'type'  => 'captcha',
                                'id'    => 'wpbc_captcha',  
                                'title' => __('CAPTCHA' ,'booking')
                              , 'help'  => array(
                                              /* translators: 1: ... */
                                              sprintf(__( 'Insert %s shortcode to prevent SPAM bookings.' ,'booking') ,'<strong>CAPTCHA</strong>')
                                              , '<strong>' . esc_html__('Important!' ,'booking') . '</strong> '.
												/* translators: 1: ... */
												sprintf( __( 'You can %1$suse this shortcode only once%2$s in the form.', 'booking' ),'<strong>','</strong>')
                                          )
                               );
        
      
        $this->fields[] = array(
                                'class_type' => 'button',
                                'type'  => 'submit',
                                'id'    => 'wpbc_submit',  
                                'title' => __('Submit Button' ,'booking')
                                
                               );   
        
//        if ( in_array( $this->version, array('biz_s','biz_m', 'biz_l') ) ) {											//FixIn: TimeFreeGenerator
            
            $this->fields[] = array('optgroup' => '</optgroup>');             
            
            $this->fields[] = array('optgroup' => '<optgroup label="&nbsp;'.__('Times Fields' ,'booking').'">');

            $this->fields[] = array(
                        'class_type' => 'select',
                        'type'  => 'selectbox',
                        'id'    => 'wpbc_rangetime_select',  
                        'title' => __('Time Slot List' ,'booking'),
                        'help'  => array(
                                        /* translators: 1: ... */
                                        sprintf( __( 'Select the %1$s using the predefined %2$sTime List%3$s.', 'booking' ) ,'<strong>'.__('Time Slot' ,'booking').'</strong>','<strong>','</strong>')
                                        /* translators: 1: ... */
                                        . ' ' . sprintf( __( 'Please note, %1$sthe use of the time shortcode%2$s. If you select a date with some booked time slots, this time field will %3$sdisable booked times slots%4$s (set them as grayed).', 'booking' ),'<strong>','</strong>','<strong>','</strong>')
										/* translators: 1: ... */
                                        . ' ' . sprintf( __( 'It works only in %1$ssingle day selection%2$s mode.', 'booking' ), '<strong>', '</strong>' )
                                        . ' ' . __('Also some early versions of the IE do not support disabling of the options in the selectboxes.' ,'booking')
                                        . ' ' . __('Even if visitor selects the booked timeslot, system will not allow them to make the booking.' ,'booking')
                            
                                        , '<strong>' . esc_html__('Important!' ,'booking') . '</strong> '
										/* translators: 1: ... */
                                        . sprintf( __( 'Please note, in the %1$sOptions list%2$s you can use times in military time format %3$s(24 Hour Time)%4$s only.', 'booking' ),'<strong>','</strong>','<strong>','</strong>')
                                        /* translators: 1: ... */
                                        , '<strong>' . esc_html__('Important!' ,'booking') . '</strong> '. sprintf( __( 'You can %1$suse this shortcode only once%2$s in the form.', 'booking' ),'<strong>','</strong>')
                                        /* translators: 1: ... */
                                        .' '. sprintf( __( 'If you use this shortcode, %1$syou can not use any other time shortcodes%2$s in the form.', 'booking' ), '<strong>', '</strong>' )
                                        )
                        ,'advanced' => array( 
                                             '_name' => array(
                                                          'value' => 'rangetime'
                                                        , 'prop' => array( 'disabled'=>true )
                                                        , 'css' => array()
                                                       ),
                                             // Set Options Titles and Default value          
                                             '_options' => array(
                                                          'value' => '10:00 - 12:00\n12:00 - 14:00\n14:00 - 16:00\n16:00 - 18:00\n18:00 - 20:00'
                                                       ),
                                             '_titles' => array(
                                                          'value' => '10:00 AM - 12:00 PM\n12:00 PM - 02:00 PM\n02:00 PM - 04:00 PM\n04:00 PM - 06:00 PM\n06:00 PM - 08:00 PM'
                                                       ),
                                             '_default' => array(
                                                        'prop' => array( 'disabled'=>true )
                                                        , 'css' => array('display'=>'none')
                                                       ),
                            
                                             // Disable and Hide the Allow multiple selections           
                                             // This option Allow the Multiple Exclusive selection in the Selectbox with rangetime name
                                             //'_multiple'=> array(
                                             //           'prop' => array( 'disabled'=>true )
                                             //           , 'css' => array('display'=>'none')
                                             //          ),  
                                             '_multiple'=> array(
                                                        'label' => array( 'html' => "Long selection view")
                                                       ),  
                                                                       
                                             // Set  Required field to 100% for correct Loyout Format           
                                             '_required'=> array(
                                                         'css' => array('float'=>'left')
                                                       )
                                          )  
                        , 'selector_style'=>'border-top: 1px dashed #999999;'                                               
                       ); 
        if ( in_array( $this->version, array('biz_s','biz_m', 'biz_l') ) ) {											//FixIn: TimeFreeGenerator
            $this->fields[] = array(
                        'class_type' => 'simple2',
                        'type'  => 'starttime',
                        'id'    => 'wpbc_starttime',  
                        'title' => __('Start Time - Text field' ,'booking'),
                        'help'  => array(
                                        /* translators: 1: ... */
                                        sprintf(__( 'Enter %s in text field.' ,'booking') ,'<strong>'.__('Start Time' ,'booking').'</strong>')
                                        . '<br/>'. 
                                        /* translators: 1: ... */
                                        sprintf( __( 'Please note: this field only supports military time format %1$s(24 Hour Time)%2$s.', 'booking' ),'<strong>','</strong>')
                                        /* translators: 1: ... */
                                        , '<strong>' . esc_html__('Important!' ,'booking') . '</strong> '. sprintf( __( 'You can %1$suse this shortcode only once%2$s in the form.', 'booking' ),'<strong>','</strong>')
                                        /* translators: 1: ... */
                                        .' '. sprintf(__( 'You can also use the %s in the form.' ,'booking'), '<strong>' . esc_html__('End Time' ,'booking') .'</strong> ' . __('or' ,'booking') .' <strong>' . esc_html__('Duration Time' ,'booking') .'</strong> ' . __('fields' ,'booking') )
                                        )
                       ); 
            $this->fields[] = array(
                        'class_type' => 'simple2',
                        'type'  => 'endtime',
                        'id'    => 'wpbc_endtime',  
                        'title' => __('End Time - Text field' ,'booking'),
                        'help'  => array(
                                        /* translators: 1: ... */
                                        sprintf(__( 'Enter %s in text field.' ,'booking') ,'<strong>'.__('End Time' ,'booking').'</strong>')
                                        . '<br/>'. 
                                        /* translators: 1: ... */
                                        sprintf( __( 'Please note: this field only supports military time format %1$s(24 Hour Time)%2$s.', 'booking' ),'<strong>','</strong>')
                                        /* translators: 1: ... */
                                        , '<strong>' . esc_html__('Important!' ,'booking') . '</strong> '. sprintf( __( 'You can %1$suse this shortcode only once%2$s in the form.', 'booking' ),'<strong>','</strong>')
                                        /* translators: 1: ... */
                                        .' '. sprintf(__( 'You can also use the %s in the form.' ,'booking'), '<strong>' . esc_html__('Start Time' ,'booking') .'</strong> ' . __('or' ,'booking') .' <strong>' . esc_html__('Duration Time' ,'booking') .'</strong> ' . __('fields' ,'booking') )
                                        )
                       ); 
            
            $this->fields[] = array(
                        'class_type' => 'select',
                        'type'  => 'selectbox',
                        'id'    => 'wpbc_starttime_select',  
                        'title' => __('Start Time - Drop Down list' ,'booking'),
                        'help'  => array(
                                        /* translators: 1: ... */
                                        sprintf( __( 'Select the %1$s using the predefined %2$sTime List%3$s.', 'booking' ) ,'<strong>'.__('Start Time' ,'booking').'</strong>','<strong>','</strong>')
                                        , '<strong>' . esc_html__('Important!' ,'booking') . '</strong> '
                                        /* translators: 1: ... */
                                        . sprintf( __( 'Please note, in the %1$sOptions list%2$s you can  use times in military time format %3$s(24 Hour Time)%4$s only.', 'booking' ),'<strong>','</strong>','<strong>','</strong>')
                                        /* translators: 1: ... */
                                        , '<strong>' . esc_html__('Important!' ,'booking') . '</strong> '. sprintf( __( 'You can %1$suse this shortcode only once%2$s in the form.', 'booking' ),'<strong>','</strong>')
                                        /* translators: 1: ... */
                                        .' '. sprintf(__( 'You can also use the %s in the form.' ,'booking'), '<strong>' . esc_html__('End Time' ,'booking') .'</strong> ' . __('or' ,'booking') .' <strong>' . esc_html__('Duration Time' ,'booking') .'</strong> ' . __('fields' ,'booking') )
                                        )
                        ,'advanced' => array( 
                                             '_name' => array(
                                                          'value' => 'starttime'
                                                        , 'prop' => array( 'disabled'=>true )
                                                        , 'css' => array()
                                                       ),
                                             // Set Options Titles and Default value          
                                             '_options' => array(
                                                          'value' => '08:00\n08:30\n09:00\n09:30\n10:00\n10:30\n11:00\n11:30\n12:00\n12:30\n13:00\n13:30\n14:00\n14:30\n15:00\n15:30\n16:00\n16:30\n17:00\n17:30\n18:00\n18:30\n19:00\n19:30\n20:00\n20:30\n21:00'
                                                       ),
                                             '_titles' => array(
                                                          'value' => ''	// '11:00 AM\n01:00 PM\n03:00 PM'
                                                       ),
                                             '_default' => array( 'value' => '' ),
                            
                                             // Disable and Hide the Allow multiple selections           
                                             '_multiple'=> array(
                                                        'prop' => array( 'disabled'=>true )
                                                        , 'css' => array('display'=>'none')
                                                       ),                            
                                             // Set  Required field to 100% for correct Loyout Format           
                                             '_required'=> array(
                                                         'css' => array('width'=>'100%')
                                                       )
                                          )                
                       ); 
            $this->fields[] = array(
                        'class_type' => 'select',
                        'type'  => 'selectbox',
                        'id'    => 'wpbc_endtime_select',  
                        'title' => __('End Time - Drop Down list' ,'booking'),
                        'help'  => array(
                                        /* translators: 1: ... */
                                        sprintf( __( 'Select the %1$s using the predefined %2$sTime List%3$s.', 'booking' ) ,'<strong>'.__('End Time' ,'booking').'</strong>','<strong>','</strong>')
                                        , '<strong>' . esc_html__('Important!' ,'booking') . '</strong> '
                                        /* translators: 1: ... */
                                        . sprintf( __( 'Please note, in the %1$sOptions list%2$s you can use times in military time format %3$s(24 Hour Time)%4$s only.', 'booking' ),'<strong>','</strong>','<strong>','</strong>')
                                        /* translators: 1: ... */
                                        , '<strong>' . esc_html__('Important!' ,'booking') . '</strong> '. sprintf( __( 'You can %1$suse this shortcode only once%2$s in the form.', 'booking' ),'<strong>','</strong>')
                                        /* translators: 1: ... */
                                        .' '. sprintf(__( 'You can also use the %s in the form.' ,'booking'), '<strong>' . esc_html__('Start Time' ,'booking') .'</strong> ' . __('or' ,'booking') .' <strong>' . esc_html__('Duration Time' ,'booking') .'</strong> ' . __('fields' ,'booking') )
                                        )
                        ,'advanced' => array( 
                                             '_name' => array(
                                                          'value' => 'endtime'
                                                        , 'prop' => array( 'disabled'=>true )
                                                        , 'css' => array()
                                                       ),
                                             // Set Options Titles and Default value          
                                             '_options' => array(
                                                          'value' => '08:00\n09:00\n10:00\n11:00\n12:00\n13:00\n14:00\n15:00\n16:00\n17:00\n18:00\n19:00\n20:00\n21:00\n22:00\n23:00'
                                                       ),
                                             '_titles' => array(
                                                          'value' => ''
                                                       ),
                                             '_default' => array('value' => ''),
                            
                                             // Disable and Hide the Allow multiple selections           
                                             '_multiple'=> array(
                                                        'prop' => array( 'disabled'=>true )
                                                        , 'css' => array('display'=>'none')
                                                       ),                            
                                             // Set  Required field to 100% for correct Loyout Format           
                                             '_required'=> array(
                                                         'css' => array('width'=>'100%')
                                                       )
                                          )                
                       ); 
            
            $this->fields[] = array(
                        'class_type' => 'select',
                        'type'  => 'selectbox',
                        'id'    => 'wpbc_durationtime_select',  
                        'title' => __('Duration Time - Drop Down list' ,'booking'),
                        'help'  => array(
                                        /* translators: 1: ... */
                                        sprintf( __( 'Select the %1$s using the predefined %2$sTime List%3$s.', 'booking' ) ,'<strong>'.__('Duration Time' ,'booking').'</strong>','<strong>','</strong>')
                                        , '<strong>' . esc_html__('Important!' ,'booking') . '</strong> '
                                        /* translators: 1: ... */
                                        . sprintf( __( 'Please note, in the %1$sOptions list%2$s you can use times in military time format %3$s(24 Hour Time)%4$s only.', 'booking' ),'<strong>','</strong>','<strong>','</strong>')
                                        /* translators: 1: ... */
                                        , '<strong>' . esc_html__('Important!' ,'booking') . '</strong> '. sprintf( __( 'You can %1$suse this shortcode only once%2$s in the form.', 'booking' ),'<strong>','</strong>')
                                        /* translators: 1: ... */
                                        .' '. sprintf(__( 'You can also use the %s in the form.' ,'booking'), '<strong>' . esc_html__('Start Time' ,'booking') .'</strong> '  . __('field' ,'booking') )
                                        )
                        ,'advanced' => array( 
                                             '_name' => array(
                                                          'value' => 'durationtime'
                                                        , 'prop' => array( 'disabled'=>true )
                                                        , 'css' => array()
                                                       ),
                                             // Set Options Titles and Default value          
                                             '_options' => array(
                                                          'value' => '00:15\n00:30\n00:45\n01:00\n01:30'
                                                       ),
                                             '_titles' => array(
                                                          'value' => '15 min\n30 min\n45 min\n1 hour\n1 hour 30 min'
                                                       ),
                                             '_default' => array('value' => ''),
                            
                                             // Disable and Hide the Allow multiple selections           
                                             '_multiple'=> array(
                                                        'prop' => array( 'disabled'=>true )
                                                        , 'css' => array('display'=>'none')
                                                       ),                            
                                             // Set  Required field to 100% for correct Loyout Format           
                                             '_required'=> array(
                                                         'css' => array('width'=>'100%')
                                                       )
                                          )                
                       ); 
            if ( in_array( $this->version, array('biz_m', 'biz_l') ) )
            $this->fields[] = array(
                                'class_type' => 'info',
                                'type'  => 'times_week',
                                'id'    => 'wpbc_times_week',  
                                'title' => __('Different time slots, for the different week days' ,'booking'),
                                'help'  => array(
                                '<strong>'.__('Description' ,'booking') . '</strong>'.'<br> '     
                                . sprintf( __('This feature provides the possibility to use the different time slot selections in the booking form for the different week days or different days - which are assigned to the specific season filters. So each week day (day of specific season filter) can have a different time slots list.' ,'booking') , '<strong>' , '</strong>')
                                
                                ,'<strong>'.__('Configuration' ,'booking') . '</strong>'.'<br> '     
                                /* translators: 1: ... */
                                . sprintf( __( 'The general structure of the configuration %1$scondition rule%2$s is as follows', 'booking' ) , '<strong>' , '</strong>')
                                . '<br><pre>'
                                .'[condition name="FILTER-NAME" type="FILTER-TYPE" value="VALUE"]'.'<br>'
                                .'     CONTENT (any HTML or form fields shortcodes), showing if this condition is TRUE'.'<br>'
                                .'[/condition]'.'<br>'
                                .'</pre>'        
                                .'<br>'.'<strong>'.__('Parameters' ,'booking') . '</strong>'.':'         
                                /* translators: 1: ... */
                                .'<br>'. sprintf( __( '%1$sname%2$s – the unique name of the condition group, containing several conditions with different values. For example, if you want to have specific HTML content for the different week days, you can have several conditions, with the same name but with different value parameters in conditions. Please check more about it, in the examples.', 'booking' ) , '<strong>' , '</strong>')
                                /* translators: 1: ... */
                                .'<br>'. sprintf( __( '%1$stype%2$s – type of the condition. There are 2 types of condition: "weekday" and "season". "weekday" – is the condition rule based on the selected day of week value, like Monday, Tuesday, etc… . "season" – is the condition rule based on the "season filter" name of selected date. In other words the condition is TRUE if the selected day belongs to a season filter in the Season Filters page.', 'booking' ) , '<strong>' , '</strong>')
                                /* translators: 1: ... */
                                .'<br>'. sprintf( __( '%1$svalue%2$s – value of the specific conditions. If the value is true, the content of the conditions will show in the booking form. You can have the default value (empty – "", or like this – "*") for showing the content of this condition, if all other conditions are FALSE, or at initial stage, when the date in calendar is not yet selected.', 'booking' ) , '<strong>' , '</strong>')
                               
                                , '<strong>'.__('Examples' ,'booking') . '</strong>'.'<hr> '      
                                . '<strong>'.__('Week days conditions.' ,'booking') . '</strong>'.'<br> '         
                                . '<br><pre>'
                                .'[condition name="weekday-condition" type="weekday" value="*"]'.'<br>'
                                .'     Default:   [selectbox rangetime  "10:00 - 11:00" "11:00 - 12:00" "12:00 - 13:00" "13:00 - 14:00" "14:00 - 15:00" "15:00 - 16:00" "16:00 - 17:00" "17:00 - 18:00"]'.'<br>'
                                .'[/condition]'.'<br>'
                                .'[condition name="weekday-condition" type="weekday" value="1,2"]'.'<br>'
                                .'     Monday, Tuesday:    [selectbox rangetime  "10:00 - 12:00" "12:00 - 14:00"]'.'<br>'
                                .'[/condition]'.'<br>'
                                .'[condition name="weekday-condition" type="weekday" value="3,4"]'.'<br>'
                                .'     Wednesday, Thursday:  [selectbox rangetime  "14:00 - 16:00" "16:00 - 18:00" "18:00 - 20:00"]'.'<br>'
                                .'[/condition]'.'<br>'
                                .'[condition name="weekday-condition" type="weekday" value="5,6,0"]'.'<br>'
                                .'     Friday, Saturday, Sunday: [selectbox rangetime "10:00 - 12:00" "12:00 - 14:00" "14:00 - 16:00" "16:00 - 18:00" "18:00 - 20:00"]'.'<br>'
                                .'[/condition]'.'<br>'
                                .'</pre>'        
                                .'<br>'.'<strong>'.__('Parameters' ,'booking') . '</strong>'.':'         
                                . '<br><strong>*</strong> - ' . __('default value, if no dates are selected, or none exist conditions are true.' ,'booking')
                                . '<br><strong>0</strong> - ' . __('Sunday' ,'booking') . ', '
                                . '<br><strong>1</strong> - ' . __('Monday' ,'booking') . ', '
                                . '<br><strong>2</strong> - ' . __('Tuesday' ,'booking') . ', '
                                . '<br><strong>3</strong> - ' . __('Wednesday' ,'booking') . ', '
                                . '<br><strong>4</strong> - ' . __('Thursday' ,'booking') . ', '
                                . '<br><strong>5</strong> - ' . __('Friday' ,'booking') . ', '
                                . '<br><strong>6</strong> - ' . __('Saturday' ,'booking') . ', '
                                .'<br>'.__('You can use the several values, separated by comma.' ,'booking') 
                                    
                                . '<hr>'.'<strong>'.__('Season filters conditions.' ,'booking') . '</strong>'.'<br> '             
                                . '<br><pre>'
                                .'[condition name="season-times" type="season" value="*"]'.'<br>'
                                .'     Default: [selectbox rangetime "14:00 - 16:00" "16:00 - 18:00" "18:00 - 20:00"]'.'<br>'
                                .'[/condition]'.'<br>'
                                .'[condition name="season-times" type="season" value="High_season"]'.'<br>'
                                .'     High season: [selectbox rangetime  "10:00 - 12:00" "12:00 - 14:00" "14:00 - 16:00" "16:00 - 18:00" "18:00 - 20:00"]'.'<br>'
                                .'[/condition]'.'<br>'
                                .'[condition name="season-times" type="season" value="Low_season"]'.'<br>'
                                .'     Low season: [selectbox rangetime "12:00 - 14:00" "14:00 - 16:00"'.'<br>'
                                .'[/condition]'.'<br>'
                                .'</pre>'        
                                .'<br>'.'<strong>'.__('Parameters' ,'booking') . '</strong>'.':'         
                                . '<br><strong>High_season</strong> - ' . __('Season filter on the Season Filters page,' ,'booking') . ', '
                                . '<br><strong>Low_season</strong> - ' . __('Season filter on the Season Filters page' ,'booking') . ' '
                                .'<br>'.__('You can use the several values, separated by comma.' ,'booking') 
                                    
                               , '<strong>'.__('Additional info' ,'booking') . '</strong>'
                                /* translators: 1: ... */
                                .'<br>'.sprintf( __( 'Please use  %1$sSingle day%2$s selection mode in the General Booking Settings page at calendar section.', 'booking' ) , '<strong>' , '</strong>')
                                /* translators: 1: ... */
                                .'<br>'.sprintf( __( 'Please check more about this feature at  %1$sthis page%2$s', 'booking' ) , '<a href="https://wpbookingcalendar.com/faq/different-time-slots-selections-for-different-days/" target="_blank">' , '</a>')
                                    
                                                )
                               );
        }
        
        $this->fields[] = array('optgroup' => '</optgroup>');             
        $this->fields[] = array('optgroup' => '<optgroup label="&nbsp;'.__('Advanced Fields' ,'booking').'">');


        $this->fields[] = array(
                                'class_type' => 'text',
                                'type'  => 'time',
                                'id'    => 'wpbc_time',  
                                'title' => __('Time Field' ,'booking'),
                                'help'  => array(
                                    /* translators: 1: ... */
                                    sprintf( __( 'Enter the %1$sTime%2$s using the text field.', 'booking' ) ,'<strong>','</strong>')
                                    /* translators: 1: ... */
                                    . '<br> '.sprintf( __( 'Please note: this field only supports military time format %1$s(24 Hour Time)%2$s.', 'booking' ),'<strong>','</strong>')
                                    ,'<strong>' . esc_html__('Important!' ,'booking') . '</strong> '
                                               . sprintf(__('This field does not impact to availability (booking for the specific time) .' ,'booking'),'<strong>','</strong>') 
                                               . ' ' . __('The value of this field is just saved into DB.' ,'booking')
                                    )
                                , 'selector_style'=>'border-top: 1px dashed #999999;'
                               );

	    // FixIn: 8.9.4.12.
        $this->fields[] = array(
                        'class_type' => 'simple2',
                        'type'  => 'country',
                        'id'    => 'wpbc_country',  
                        'title' => __('Country List' ,'booking'),
                        'help'  => array(
                                        __('Select the country from the predefined country list.' ,'booking') 
                                      /* translators: 1: ... */
                                      . '<br/>'. sprintf(__( 'You can customize the country list at this file: %s' ,'booking'),'<code><strong>../core/lang/wpdev-country-list.php</strong></code>')
                                      , sprintf(__('You can insert this field with default selected value.' ,'booking'),'<strong>','</strong>')
                                        /* translators: 1: ... */
                                        . '<br/>'. sprintf( __( 'Example: %1$s - %2$s"United States"%3$s is selected by default.', 'booking' ),'<br/><code>[country "US"] </code>','<strong>','</strong>')
                                      /* translators: 1: ... */
                                      , '<strong>' . esc_html__('Important!' ,'booking') . '</strong> '. sprintf( __( 'You can %1$suse this shortcode only once%2$s in the form.', 'booking' ),'<strong>','</strong>')
                                        )
                       ); 
            
            $this->fields[] = array(
                                'class_type' => 'info',
                                'type'  => 'lang',
                                'id'    => 'wpbc_section_lang',
                                'title' => __('Language Sections' ,'booking'),
                                'help'  => array(
                                sprintf( __('Plugin support configurations of the booking form are available in different languages.' ,'booking') , '<strong>' , '</strong>')
                                . ' ' .  __('The active language of the booking form depends on the active locale of the site.' ,'booking')    
                                . ' ' .  __('Booking Calendar supports WPML and qTranslate plugins for dynamic changing of website locale.' ,'booking')    
                                                                        
                                . '<hr>' . esc_html__('Usage' ,'booking') . ': '
                                /* translators: 1: ... */
                                . '<br><code>'.'[lang=LOCALE]'.'</code> - ' . sprintf(__( 'start new translation section in specific language, where %s - locale of the translation.' ,'booking'), '<em>LOCALE</em>') . ' '
                                    
                                . '<hr>' . esc_html__('Example' ,'booking') . ': '
                                . '<br><code>Thank you for your booking.[lang=fr_FR]Je vous remercie de votre reservation.</code> - '. __('English and French translation' ,'booking') . ' '
                                    
                                . '<hr>' . esc_html__('Example' ,'booking') . ' '
                                . __('of configuration booking form in English and French languages' ,'booking')   
                                . '<br><pre>'
                                .'[calendar]'.'<br>'
                                .'&lt;p&gt;First Name (required):  [text* name] &lt;/p&gt;'.'<br>'
                                .'&lt;p&gt;Last Name (required):  [text* secondname] &lt;/p&gt;'.'<br>'
                                .'&lt;p&gt;Email (required):  [email* email] &lt;/p&gt;'.'<br>'
                                .'&lt;p&gt;Visitors:  [selectbox visitors "1" "2" "3" "4"]&lt;/p&gt;'.'<br>'
                                .'&lt;p&gt;Details: [textarea details] &lt;/p&gt;'.'<br>'
                                .'&lt;p&gt;[submit "Send"]&lt;/p&gt;'.'<br>'.'<br>'
                                .'[lang=fr_FR]'.'<br>'.'<br>'
                                .'[calendar]'.'<br>'
                                .'&lt;p&gt;Prénom (obligatoire):  [text* name] &lt;/p&gt;'.'<br>'
                                .'&lt;p&gt;Deuxième prénom (requis)   [text* secondname] &lt;/p&gt;'.'<br>'
                                .'&lt;p&gt;Email (obligatoire)   [email* email] &lt;/p&gt;'.'<br>'
                                .'&lt;p&gt;Visiteurs :  [selectbox visitors "1" "2" "3" "4"]&lt;/p&gt;'.'<br>'
                                .'&lt;p&gt;Détails : [textarea details] &lt;/p&gt;'.'<br>'
                                .'&lt;p&gt;[submit "Envoyer"]&lt;/p&gt;'.'<br>'                                    
                                    .'</pre>'
                                . '<hr><code>' . '[wpml]Some Text to translate[/wpml]' . '</code> - '     
                                . sprintf( __('Register and Translate everything in WPML plugin. Translation can be done at the WPML > "String translation" page. Required WPML 3.2 with String Translation plugin.' ,'booking') , '<strong>' , '</strong>')
                                                 )
                               );
            if ( in_array( $this->version, array('biz_m', 'biz_l') ) )
            $this->fields[] = array(
                                'class_type' => 'info',
                                'type'  => 'fields_week',
                                'id'    => 'wpbc_fields_week',  
                                'title' => __('Different form fields, for the different week days' ,'booking'),
                                'help'  => array(
                                '<strong>'.__('Description' ,'booking') . '</strong>'.'<br> '     
                                . sprintf( __('This feature provides the possibility to show the different form fields or any other HTML content in the booking form, depending on the selection of specific week day in calendar or different days, which are assigned to the specific season filters' ,'booking') , '<strong>' , '</strong>')
                                
                                ,'<strong>'.__('Configuration' ,'booking') . '</strong>'.'<br> '     
                                /* translators: 1: ... */
                                . sprintf( __( 'The general structure of the configuration %1$scondition rule%2$s is as follows', 'booking' ) , '<strong>' , '</strong>')
                                . '<br><pre>'
                                .'[condition name="FILTER-NAME" type="FILTER-TYPE" value="VALUE"]'.'<br>'
                                .'      CONTENT (any HTML or form fields shortcodes), showing if these condition is TRUE'.'<br>'
                                .'[/condition]'.'<br>'
                                .'</pre>'        
                                .'<br>'.'<strong>'.__('Parameters' ,'booking') . '</strong>'.':'         
                                /* translators: 1: ... */
                                .'<br>'. sprintf( __( '%1$sname%2$s – the unique name of the condition group, containing several conditions with different values. For example, if you want to have specific HTML content for the different week days, you can have several conditions, with the same name but with different value parameters in conditions. Please check more about it, in the examples.', 'booking' ) , '<strong>' , '</strong>')
                                /* translators: 1: ... */
                                .'<br>'. sprintf( __( '%1$stype%2$s – type of the condition. There are 2 types of condition: "weekday" and "season". "weekday" – is the condition rule based on the selected day of week value, like Monday, Tuesday, etc… . "season" – is the condition rule based on the "season filter" name of selected date. In other words the condition is TRUE if the selected day belongs to a season filter in the Season Filters page.', 'booking' ) , '<strong>' , '</strong>')
                                /* translators: 1: ... */
                                .'<br>'. sprintf( __( '%1$svalue%2$s – value of the specific conditions. If the value is true, so then the content of the conditions will show in the booking form. You can have the default value (empty – "", or like this – "*") for showing the content of this condition, if all other conditions are FALSE, or at initial stage, when the date in calendar is not yet selected.', 'booking' ) , '<strong>' , '</strong>')
                               
                                , '<strong>'.__('Examples' ,'booking') . '</strong>'.'<hr> '      
                                . '<strong>'.__('Week days conditions.' ,'booking') . '</strong>'.'<br> '         
                                . '<br><pre>'
                                .'[condition name="weekday-condition" type="weekday" value="*"]'.'<br>'
                                .'     Default:   [selectbox rangetime  "10:00 - 11:00" "11:00 - 12:00" "12:00 - 13:00" "13:00 - 14:00" "14:00 - 15:00" "15:00 - 16:00" "16:00 - 17:00" "17:00 - 18:00"]'.'<br>'
                                .'[/condition]'.'<br>'
                                .'[condition name="weekday-condition" type="weekday" value="1,2"]'.'<br>'
                                .'     Monday, Tuesday:    [selectbox rangetime  "10:00 - 12:00" "12:00 - 14:00"]'.'<br>'
                                .'[/condition]'.'<br>'
                                .'[condition name="weekday-condition" type="weekday" value="3,4"]'.'<br>'
                                .'     Wednesday, Thursday:  [selectbox rangetime  "14:00 - 16:00" "16:00 - 18:00" "18:00 - 20:00"]'.'<br>'
                                .'[/condition]'.'<br>'
                                .'[condition name="weekday-condition" type="weekday" value="5,6,0"]'.'<br>'
                                .'     Friday, Saturday, Sunday: [selectbox rangetime "10:00 - 12:00" "12:00 - 14:00" "14:00 - 16:00" "16:00 - 18:00" "18:00 - 20:00"]'.'<br>'
                                .'[/condition]'.'<br>'
                                .'</pre>'        
                                .'<br>'.'<strong>'.__('Parameters' ,'booking') . '</strong>'.':'         
                                . '<br><strong>*</strong> - ' . __('default value, if no dates are selected, or none exist conditions are true.' ,'booking')
                                . '<br><strong>0</strong> - ' . __('Sunday' ,'booking') . ', '
                                . '<br><strong>1</strong> - ' . __('Monday' ,'booking') . ', '
                                . '<br><strong>2</strong> - ' . __('Tuesday' ,'booking') . ', '
                                . '<br><strong>3</strong> - ' . __('Wednesday' ,'booking') . ', '
                                . '<br><strong>4</strong> - ' . __('Thursday' ,'booking') . ', '
                                . '<br><strong>5</strong> - ' . __('Friday' ,'booking') . ', '
                                . '<br><strong>6</strong> - ' . __('Saturday' ,'booking') . ', '
                                .'<br>'.__('You can use several values, separated by comma.' ,'booking') 
                                    
                                . '<hr>'.'<strong>'.__('Season filters conditions.' ,'booking') . '</strong>'.'<br> '             
                                . '<br><pre>'
                                .'[condition name="season-times" type="season" value="*"]'.'<br>'
                                .'     Default: [selectbox rangetime "14:00 - 16:00" "16:00 - 18:00" "18:00 - 20:00"]'.'<br>'
                                .'[/condition]'.'<br>'
                                .'[condition name="season-times" type="season" value="High_season"]'.'<br>'
                                .'     High season: [selectbox rangetime  "10:00 - 12:00" "12:00 - 14:00" "14:00 - 16:00" "16:00 - 18:00" "18:00 - 20:00"]'.'<br>'
                                .'[/condition]'.'<br>'
                                .'[condition name="season-times" type="season" value="Low_season"]'.'<br>'
                                .'     Low season: [selectbox rangetime "12:00 - 14:00" "14:00 - 16:00"'.'<br>'
                                .'[/condition]'.'<br>'
                                .'</pre>'        
                                .'<br>'.'<strong>'.__('Parameters' ,'booking') . '</strong>'.':'         
                                . '<br><strong>High_season</strong> - ' . __('Season filter on the Season Filters page,' ,'booking') . ', '
                                . '<br><strong>Low_season</strong> - ' . __('Season filter on the Season Filters page' ,'booking') . ' '
                                .'<br>'.__('You can use several values, separated by a comma.' ,'booking') 
                                    
                               , '<strong>'.__('Additional info' ,'booking') . '</strong>'
                                /* translators: 1: ... */
                                .'<br>'.sprintf( __( 'Please use  %1$sSingle day%2$s selection mode in the General Booking Settings page at calendar section.', 'booking' ) , '<strong>' , '</strong>')
                                /* translators: 1: ... */
                                .'<br>'.sprintf( __( 'Please check more about this feature at  %1$sthis page%2$s', 'booking' ) , '<a href="https://wpbookingcalendar.com/faq/different-time-slots-selections-for-different-days/" target="_blank">' , '</a>')
                                    
                                                )
                               );
        
        $this->fields[] = array('optgroup' => '</optgroup>'); 
        
        if ( in_array( $this->version, array('biz_m', 'biz_l') ) ) {
            
            $this->fields[] = array('optgroup' => '<optgroup label="&nbsp;'.__('Cost Fields' ,'booking').'">');
            
            $this->fields[] = array(
                                    'class_type' => 'simple',
                                    'type'  => 'cost_corrections',
                                    'id'    => 'wpbc_cost_corrections',  
                                    'title' => __('Cost Correction Field' ,'booking')
                                  , 'help'  => array(
                                                  /* translators: 1: ... */
                                                  sprintf( __( 'This field is visible only in Admin Panel at %1$sAdd booking page%2$s.', 'booking' ),'<strong>','</strong>')
                                                        /* translators: 1: ... */
                                                        .'<br/>'. sprintf( __( 'Use this field for %1$scorrecting the cost%2$s during adding new booking.', 'booking' ) ,'<strong>','</strong>' )
                                                  /* translators: 1: ... */
                                                  , '<strong>' . esc_html__('Important!' ,'booking') . '</strong> '. sprintf( __( 'You can %1$suse this shortcode only once%2$s in the form.', 'booking' ),'<strong>','</strong>')
                                                )
                                    , 'selector_style'=>'border-top: 1px dashed #999999;'
                                   );

            if ($this->version == 'biz_l')
                $this->fields[] = array(
                                    'class_type' => 'text',
                                    'type'  => 'coupon',
                                    'id'    => 'wpbc_coupon',  
                                    'title' => __('Discount Coupon field' ,'booking'),
                                    'help'  => array(
                                                    sprintf(__('Please use this field for possibility to use coupon discounts by your visitors.' ,'booking'),'<code><strong>[coupon my_coupon]</strong></code>') 
                                                        /* translators: 1: ... */
                                                        . ' ' . sprintf( __( 'You can configure the discount coupon codes at this %1$spage%2$s.', 'booking' ),'<a href="' . esc_url( wpbc_get_settings_url() ) . '&tab=email">','</a>')
                                                    /* translators: 1: ... */
                                                    , '<strong>' . esc_html__('Important!' ,'booking') . '</strong> '. sprintf( __( 'You can %1$suse this shortcode only once%2$s in the form.', 'booking' ),'<strong>','</strong>')
                                        )
                                   );
                

            $this->fields[] = array('optgroup' => '</optgroup>');
            
            
            $this->fields[] = array('optgroup' => '<optgroup label="&nbsp;'.__('Hints for your form' ,'booking').'">');
            
            $this->fields[] = array(
                                'class_type' => 'info',
                                'type'  => 'cost_hints',
                                'id'    => 'wpbc_cost_hints',  
                                'title' => __('Cost Hints' ,'booking'),
                                'help'  => array(
                                /* translators: 1: ... */
                                sprintf( __( 'Insert these shortcodes into form to %1$sshow info in real time %2$s(after selection of the dates in calendar or options in checkboxes or selectboxes)%3$s.', 'booking' ) , '<strong>' , '</strong><em>','</em>' )
                                    
                                . '<hr><code><strong>'.'[cost_hint]'.'</strong></code> - ' . __('Full cost of the booking.' ,'booking') . ' '
                                    
                                . '<br><code><strong>'.'[original_cost_hint]'.'</strong></code> - ' . __('Cost of the booking for the selected dates only.' ,'booking') . ' '
                                    
                                . '<br><code><strong>'.'[additional_cost_hint]'.'</strong></code> - ' . __('Additional cost, which depends on the fields selection in the form.' ,'booking') . ' '
                                    
                                . '<hr><code><strong>'.'[deposit_hint]'.'</strong></code> - ' . __('The deposit cost of the booking.' ,'booking') . ' '
                                    
                                . '<br><code><strong>'.'[balance_hint]'.'</strong></code> - ' . __('Balance cost of the booking - difference between deposit and full cost.' ,'booking') . ' '
                                    
                                . ( ( class_exists( 'wpdev_bk_biz_l' ) ) ? '<br><code><strong>'.'[coupon_discount_hint]'.'</strong></code> - ' . __('Coupon discount value of the booking.' ,'booking') . ' ' : '' )
                                                 )
                                   , 'selector_style'=>'border-top: 1px dashed #999999;'
                               );
        $this->fields[] = array(
                                'class_type' => 'info',
                                'type'  => 'time_hints',
                                'id'    => 'wpbc_date_time_hints',  
                                'title' => __('Dates and Times Hints' ,'booking'),
                                'help'  => array(
                                /* translators: 1: ... */
                                sprintf( __( 'Insert these shortcodes into form to %1$sshow info in real time %2$s(after selection of the dates in calendar or options in checkboxes or selectboxes)%3$s.', 'booking' ) , '<strong>' , '</strong><em>','</em>' )
                                    
                                . '<hr><code><strong>'.'[check_in_date_hint]'.'</strong></code> - ' . __('Selected Check In date.' ,'booking') . ' '
                                . __('Example:' ,'booking').'<strong>'.'11/25/2025'.'</strong>'
                                    
                                . '<br><code><strong>'.'[check_out_date_hint]'.'</strong></code> - ' . __('Selected Check Out date.' ,'booking') . ' '
                                . __('Example:' ,'booking').'<strong>'.'11/27/2025'.'</strong>'
								// FixIn: 8.0.2.12.
                                . '<br><code><strong>'.'[check_out_plus1day_hint]'.'</strong></code> - ' . __('Selected Check Out date.' ,'booking') . ' + 1 ' . __('day', 'booking') . ' '
                                . __('Example:' ,'booking').'<strong>'.'11/28/2025'.'</strong>'

                                . '<hr><code><strong>'.'[start_time_hint]'.'</strong></code> - ' . __('Selected Start Time.' ,'booking') . ' '
                                . __('Example:' ,'booking').'<strong>'.'10:00'.'</strong>'
                                    
                                . '<br><code><strong>'.'[end_time_hint]'.'</strong></code> - ' . __('Selected End Time.' ,'booking') . ' '
                                . __('Example:' ,'booking').'<strong>'.'12:00'.'</strong>'
                                    
                                . '<hr><code><strong>'.'[selected_dates_hint]'.'</strong></code> - ' . __('All selected dates.' ,'booking') . ' '
                                . __('Example:' ,'booking').'<strong>'.'11/25/2025, 11/26/2025, 11/27/2025'.'</strong>'
                                    
                                . '<br><code><strong>'.'[selected_timedates_hint]'.'</strong></code> - ' . __('All selected dates with times.' ,'booking') . ' '
                                . __('Example:' ,'booking').'<strong>'.'11/25/2025 10:00, 11/26/2025, 11/27/2025 12:00'.'</strong>'
                                    
                                . '<br><code><strong>'.'[selected_short_dates_hint]'.'</strong></code> - ' . __('All selected dates in "short" format.' ,'booking') . ' '
                                . __('Example:' ,'booking').'<strong>'.'11/25/2025 - 11/27/2025'.'</strong>'
                                    
                                . '<br><code><strong>'.'[selected_short_timedates_hint]'.'</strong></code> - ' . __('All selected dates with times in "short" format..' ,'booking') . ' '
                                . __('Example:' ,'booking').'<strong>'.'11/25/2025 10:00 - 11/27/2025 12:00'.'</strong>'
                                    
                                . '<hr><code><strong>'.'[days_number_hint]'.'</strong></code> - ' . __('Number of selected days.' ,'booking') . ' '
                                . __('Example:' ,'booking').'<strong>'.'3'.'</strong>'
                                    
                                . '<br><code><strong>'.'[nights_number_hint]'.'</strong></code> - ' . __('Number of selected nights.' ,'booking') . ' '
                                . __('Example:' ,'booking').'<strong>'.'2'.'</strong>'
                                . '<br><code><strong>'.'[cancel_date_hint]'.'</strong></code> - ' . __('14 dates before selected Check In date.' ,'booking') . ' '
                                . __('Example:' ,'booking').'<strong>'.'11/11/2025'.'</strong>'
								// FixIn: 10.0.0.31.
                                . '<br><code><strong>'.'[pre_checkin_date_hint]'.'</strong></code> - '
															/* translators: 1: ... */
															. sprintf( __( 'This shortcode is used in the booking form to display the date %1$sN days before%2$s the selected check-in date.', 'booking' )
					                                                  , '<a href="'.wpbc_get_settings_url( true, false ) . '&scroll_to_section=wpbc_general_settings_form_tab">', '</a>' )
                                                 )
                               );
								// FixIn: 9.7.3.16.
            // FixIn: 6.1.1.15.
            $this->fields[] = array(
                                'class_type' => 'info',
                                'type'  => 'other_hints',
                                'id'    => 'wpbc_other_hints',  
                                'title' => __('Other Hints' ,'booking'),
                                'help'  => array(
	                                ( ( class_exists( 'wpdev_bk_biz_l' ) )
										  ? ('<code><strong>'.'[capacity_hint]' .'</strong></code> - ' . __('displays the available (remaining) slots for selected dates and times on a calendar with a specific capacity' ,'booking') . '. ')
										  : '')
                                . '<hr><code><strong>'.'[resource_title_hint]'                  .'</strong></code> - ' . __('title of booking resource' ,'booking') . '. '
                                . '<br><code><strong>'.'[bookingresource show=\'id\']'          .'</strong></code> - ' . __('ID of booking resource.' ,'booking') . ' '
                                . '<br><code><strong>'.'[bookingresource show=\'title\']'       .'</strong></code> - ' . __('title of booking resource' ,'booking') . '. '                                    
                                . '<br><code><strong>'.' [bookingresource show=\'cost\']'       .'</strong></code> - ' . __('cost of booking resource.' ,'booking') . ' '                                    
                                //. '<br><code><strong>'.'[bookingresource show=\'capacity\']'    .'</strong></code> - ' . __('capacity of booking resource.' ,'booking') . ' '
                                //. '<br><code><strong>'.'[bookingresource show=\'maxvisitors\']' .'</strong></code> - ' . __('maximum number of visitors per booking resource.' ,'booking') . ' '
                                                 )
                                   
                               );
        
            $this->fields[] = array('optgroup' => '</optgroup>');
            
        }
		$this->fields[] = array('optgroup' => '<optgroup label="&nbsp;'.__('Other' ,'booking').'">');
            
        $this->fields[] = array(
                                'class_type' => 'info',
                                'type'  => 'steps_timeline',
                                'id'    => 'wpbc_steps_timeline',
                                'title' => __('Steps Timeline Progress Indicator' ,'booking'),
                                'help'  => array(
                                	  	'<div style="line-height: 1.6em;margin: 0 0 15px;font-size: 18px;">' .
                                	  		__('Show a progress indicator for multi-step booking forms.' ,'booking') .
										'</div>'
									. "<input name='wpbc_steps_timeline_put_in_form' id='wpbc_steps_timeline_put_in_form' value='[steps_timline steps_count=\"3\" active_step=\"1\"]' class='put-in' type='text' readonly='readonly' onfocus='this.select()'>"
	                                //.   '<code><strong>'.'[steps_timline steps_count="3" active_step="1"]'.'</strong></code>'
                                    	. '<div style="line-height: 1.6em;margin: 15px 0 0;font-size: 18px;">' .
                                	  		__( 'Parameters', 'booking' ) .': ' .
										'</div>'
                                    . '<code><strong>'.'steps_count="3"'.'</strong></code> - ' . __('Defines total number of steps' ,'booking') . ' '
                                    . '<br><code><strong>'.'active_step="1"'.'</strong></code> - ' . __('Highlights the current step' ,'booking') . ' '
									. '<br><code><strong>'.'color="#619d40"'.'</strong></code> - ' . __('Optional parameter to customize step color' ,'booking') . ' '
                                 )
                                , 'selector_style'=>'border-top: 1px dashed #999999;'
                               );

        $this->fields[] = array(
                                'class_type' => 'info',
                                'type'  => 'tips_and_tricks_hints',
                                'id'    => 'wpbc_tips_and_tricks_hints',
                                'title' => __('Tips and Tricks' ,'booking'),
                                'help'  => array(
                                /* translators: 1: ... */
                                sprintf( __( '%1$sEmail verification field%2$s.', 'booking' ) , '<strong>' , '</strong>' )
                                . '<hr/>'
                                /* translators: 1: ... */
                                . sprintf( __( 'To create verification email, you need to use special CSS class in other email field. This CSS class must start with this reserved words: %1$s and then have to go the name of your primary email field: %2$s', 'booking' ), '<em>"same_as_"</em>', '<em>"class:<strong>same_as_</strong>email"</em>' ) . '<br/>'
                                . '<strong>' . esc_html__('Example' ,'booking')  .  ':</strong>'  . '<br/>'
                                . '<code><strong>'.'[email* other_verify_email class:same_as_email]'.'</strong></code> - ' . __('confirmation email field of the primary email field' ,'booking') . ' '
                              /* translators: 1: ... */
                              , sprintf( __( '%1$sValidate Text Field for Digits%2$s.', 'booking' ) , '<strong>' , '</strong>' )		// FixIn: 9.8.13.1.
                                . '<hr/>'
                                /* translators: 1: ... */
                                . sprintf( __( '%1$sDescription of usage%2$s.', 'booking' ) , '<strong>' , '</strong>' ) . '<br/>'
                                . __('This feature ensures that a specific field only accepts a certain number of digits, providing control over the entered data.', 'booking' ) . '<br/>'
                                . '<strong>' . esc_html__('Examples' ,'booking')  .  ':</strong>'  . '<br/>'
                                . '<code><strong>'.'[text* dig_field class:validate_as_digit] '.'</strong></code> - ' . __('Validates the text field as a digit field.' ,'booking') .  '<br>'
                                . '<code><strong>'.'[text* phone class:validate_digit_9]  '.'</strong></code> - ' . __('Validates a phone number with exactly 9 digits.' ,'booking') .  '<br>'
                                . '<code><strong>'.'[text* zip class:validate_digit_5]  '.'</strong></code> - ' . __('Validates a zip code with exactly 5 digits.' ,'booking') .  '<br>'
                                 )
                                , 'selector_style'=>'border-top: 1px dashed #999999;'
                               );

		// FixIn: 9.4.3.6.
        $this->fields[] = array(
                                'class_type' => 'info',
                                'type'  => 'legend_items',
                                'id'    => 'wpbc_legend_items',
                                'title' => __('Calendar Legend' ,'booking'),
                                'help'  => array(
                                	  /* translators: 1: ... */
                                	  sprintf( __( '%1$sShow calendar dates legend in any place of booking form.%2$s', 'booking' ) , '<div style="line-height: 1.6em;margin: 0 0 15px;font-size: 18px;">' , '</div>' )
	                                .     '<code><strong>'.'[legend_items]'.'</strong></code> - ' . __('Show legend items relative settings at the Booking Settings General page in "Form" section' ,'booking') . ' '
                                    . '<br><code><strong>'.'[legend_items items="available,unavailable,pending,approved,partially"]'.'</strong></code> - ' . __('Show only specific sorted, legend items' ,'booking') . ' '
                                    . '<br><code><strong>'.'[legend_items is_vertical="1"]'.'</strong></code> - ' . __('Show legend items in a column' ,'booking') . ' '
                                    . '<br><code><strong>'.'[legend_items text_for_day_cell=""]'.'</strong></code> - ' . __('Show date number in legend' ,'booking') . ' '
									. '<br><code><strong>'.'[legend_items text_for_day_cell="N"]'.'</strong></code> - ' . __('Show specific symbol in legend' ,'booking') . ' '
									. '<br><code><strong>'.'[legend_items text_for_day_cell="&amp;nbsp;"]'.'</strong></code> - ' . __('Show empty space in legend' ,'booking') . ' '
									. '<br><code><strong>'.'[legend_items items="available,unavailable,pending,approved,partially" is_vertical="1" text_for_day_cell=""]'.'</strong></code> '
                                 )
                                , 'selector_style'=>'border-top: 1px dashed #999999;'
                               );


        
        
		$this->fields[] = array('optgroup' => '</optgroup>');

    }
    
    
    public function show(){
        
        $this->js_and_css();
        
        ?>
<!--        <div style="float:right;margin:10px 0px !important;width:40%;" class="wpdevelop booking_settings_row">-->
        <div class="wpdevelop booking_settings_row">
            <?php // Tags Selector ?>       
            <div id="wpbc_field_help_selector" class="wpbc_field_help_panel_background form-horizontal">
				<div class="wpbc_field_help_selector__container">
					<div class="wpbc_field_help_selector__selectbox">
                        <select name="select_form_help_shortcode" id="select_form_help_shortcode" onchange="javascript:load_specific_help_section(this.value);">
                            <?php
                            foreach ($this->fields as $field_types_key => $field_params) {

								if ( isset( $field_params['optgroup'] ) ) {
									// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									echo $field_params['optgroup'];
								}

								if ( isset( $field_params['title'] ) ) {
									// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									echo '<option style="padding-top:4px;padding-bottom:4px;' . ( ( isset( $field_params['selector_style'] ) ) ? $field_params['selector_style'] : '' ) . '" value="' . $field_params['id'] . '">' . $field_params['title'] . '</option>';
								}
                            }
                            ?>
                        </select>
					</div>
					<div class="wpbc_field_help_selector__icon">
						<div class="ui_element" style="margin-left: 0px;margin-right: 0px;">
							<a href="https://wpbookingcalendar.com/faq/#booking-form-setup"
							   class="tooltip_top wpbc-bi-question-circle"
							   data-original-title="<?php esc_attr_e('Select option to configure or show help info about tags' ,'booking'); ?>"></a>
						</div>
					</div>
				</div>
            </div>
            <div style="clear:both;height:10px; width:100%;"></div>
            <?php 
            
            $info_Fields =array();
            foreach ($this->fields as $key => $field_data) {
                
                if (! isset($field_data['class_type'])) continue;
                
                if ( $field_data['class_type'] == 'info') {
                    $info_Fields[] = new WPBC_Field_Help_Info( $field_data );
                
                } else if ( $field_data['class_type'] == 'text') {
                    $info_Fields[] = new WPBC_Field_Help_Text( $field_data );                    
                
                } else if ( $field_data['class_type'] == 'textarea') {
                    $info_Fields[] = new WPBC_Field_Help_Textarea( $field_data );                    
                
                } else if ( $field_data['class_type'] == 'select') {
                    $info_Fields[] = new WPBC_Field_Help_Select( $field_data );                    
                } else if ( $field_data['class_type'] == 'selectbox') {
                    $info_Fields[] = new WPBC_Field_Help_Select( $field_data );

                } else if ( $field_data['class_type'] == 'checkbox') {
                    $info_Fields[] = new WPBC_Field_Help_Checkbox( $field_data );                    
                
                } else if ( $field_data['class_type'] == 'simple') {
                    $info_Fields[] = new WPBC_Field_Help_Simple( $field_data );                    
                
                } else if ( $field_data['class_type'] == 'simple2') {
                    $info_Fields[] = new WPBC_Field_Help_Simple2( $field_data );                    
                
                } else if ( $field_data['class_type'] == 'button') {
                    $info_Fields[] = new WPBC_Field_Help_Button( $field_data );                    
                    
                } else if ( $field_data['class_type'] == 'radio') {
                    $info_Fields[] = new WPBC_Field_Help_Radio( $field_data );                    
                
                }
            }
            
            // Show first shortcode help
            reset($info_Fields);
            $info_Fields[key($info_Fields)]->show();                            
            
            ?>
        </div>
    <?php
    }

    
    // CSS for the Help sections 
    public function js_and_css(){
    ?>
    <script type="text/javascript">
        function load_specific_help_section(section_id){
            // Hide all sections firstly
            jQuery('.wpbc_field_help_panel_field').hide();
            // Show require section
            jQuery('#wpbc_field_help_section_'+section_id).show();
        }
    </script><?php
    
    ?>
    <style type="text/css" media="screen">
		.wpbc_field_help_selector__container{
			display: flex;
			flex-flow: row nowrap;
			justify-content: flex-start;
			align-items: center;
		}
		.wpbc_field_help_selector__selectbox{
			flex: 1 1 auto;
		}
		.wpbc_field_help_selector__icon{
			flex: 0 0 10px;
  			margin-left: 10px;
		}
        /* Background of the Panel */
        #wpbc_field_help_selector {
            padding:10px;
            width: 100%;
			margin-bottom: -20px;
        }
        #wpbc_field_help_selector select {
            height: 40px;
			  width: 100%;
			  margin: 0px;
			  font-size: 14px;
			  font-weight: 600;
			  line-height: 2.2;
        }
        .wpbc_field_help_panel_background {
            background: #fff;
            height: auto;
            padding: 5px;
            width: 100%;
            overflow: hidden;
        }
        .wpbc_field_help_panel_field {
            padding:10px;
        }
        /* Header in the panel */
        .wpbc_field_help_panel_header {
            color: #777777;
            
            font-size: 24px;
            font-weight: 400;
            line-height: 1em;
            margin: 0 0 0 5px;
        }
        .wpbc_field_help_panel_field hr {
            
            border-color: #E5E5E5 #F4F4F4 #FFFFFF;
            box-sizing: border-box;            
            -moz-box-sizing: border-box;
            -moz-float-edge: margin-box;
            -webkit-box-sizing: border-box;
            -webkit-float-edge: margin-box;
            border-image: none;
            border-style: solid none;
            border-width: 1px 0;
            margin: 5px 0;
            color: gray;
            display: block;
            height: 2px;            
        }
        .wpbc_field_help_panel_background.wpbc_field_help_panel_field label,
        .wpbc_field_help_panel_background.wpbc_field_help_panel_field select,
        .wpbc_field_help_panel_background.wpbc_field_help_panel_field input{
            margin-bottom: 0px;
            width:100%;
        }
        .wpbc_field_help_panel_background.wpbc_field_help_panel_field label{
            line-height: 1.8em;
            white-space: nowrap;
        }
        .wpdevelop.booking_settings_row .wpbc_field_help_panel_background.wpbc_field_help_panel_field label.control-label {
            text-align: left;
        }
        .wpbc_field_help_panel_background.wpbc_field_help_panel_field .put-in {
			/*
            cursor: pointer;
            font-weight: 600;
            background: none repeat scroll 0 0 #E9E9E9;
            border: 1px solid #BBBBBB;
			*/
        }
        .parameter-group{
            width:46%;
            float:left;
            padding:0 2%;
            margin:5px 0;
        }
        .parameter-group code a,
        .parameter-group code a:hover{
            text-decoration: underline;
            color:#0088CC;
        }
        .parameter-group.one-row{
            width:96%;
        }
    </style>
    <?php    
    }
}
