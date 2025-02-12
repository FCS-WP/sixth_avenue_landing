<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class WPBC_Field_Help_Checkbox extends WPBC_Field_Help_Select{

    public  $title = '';
    protected $help ='';
    
    protected $type = '';
    protected $htmlid = '';
    
    protected $update_js_function_name = '';
    
    
    function __construct( $params = array() ) {
        
        $this->type     = $params['type'];
        $this->htmlid   = $params['id'];
        $this->title    = $params['title'];
        $this->update_js_function_name = 'wpbc_'. $this->htmlid .'_field_help_update';
        if (isset($params['help'])){
            $this->help = $params['help'];
        }
        $this->js();
        $this->init();
        $this->setAdvancedParameters( $params );
    }

  
    public function init(){
        ?>        
        <div id="wpbc_field_help_section_<?php echo esc_attr( $this->htmlid ); ?>"
             class="wpbc_field_help_panel_background form-horizontal code_description wpbc_field_help_panel_field" 
             style="display:none;" >
			<?php /* ?>
            <div class="wpbc_field_help_panel_header"><?php echo esc_html( $this->title  ); ?></div><hr/>
            <?php */

            // Exmaple of shortcode with ALL parameters:
            // [checkbox* timeslots id:idd class:clsss label_first use_label_element exclusive default:on  "1" "2" "3" "4" "5"]

            
            $this->setRequiredField('one-row');
            
            $this->setNameField();      $this->setDefaultValueField();
            
            ?><div class="clear"></div><?php
            
            $this->setOptionsField();   $this->setTitlesField();
            
            $this->setUsingLabelsForFields('one-row');
            $this->setUsingFirstLabelsForFields('one-row');
			$this->setUsingWrapLabelForFields('one-row');
            $this->setExclusiveFields('one-row');
            
            
            $this->setIdField();        $this->setClassField();
            
            ?><div class="clear"></div><hr/><?php

            $this->setPutInFormField('one-row');

            $this->setPutInContentField('one-row');

			$this->setPutInContentField_val( 'one-row' );

            ?><div class="clear"></div><?php 
            
            if (! empty($this->help)) {
                
                ?><hr/><div class="wpbc-help-message"><?php
                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo $this->help; 
                
                ?></div><?php
            }
            ?>
            <script type="text/javascript">  <?php
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo $this->update_js_function_name; ?>(); </script>
        </div>            
        <?php
    }
 

    public function setUsingLabelsForFields($group_css){ ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>" style="white-space: nowrap;">
            <input type="checkbox"  style="width: auto; padding: 0px; margin: 0 5px 0 0;"
                   id="<?php echo esc_attr( $this->htmlid ); ?>_uselabels" name="<?php echo esc_attr( $this->htmlid ); ?>_uselabels"
                   onchange="javascript:<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $this->update_js_function_name; ?>();"
                   onclick="javascript:this.onchange();"
                   />
            <label class="" for="<?php echo esc_attr( $this->htmlid ); ?>_uselabels" style="width: auto; display: inline;"><?php
            /* translators: 1: ... */
            echo wp_kses_post( sprintf(__( 'Wrap each item with %s tag' ,'booking'),'<code>&lt;label&gt;</code>') ); ?>.</label>
        </div>
        <?php
    }

    
    public function setUsingFirstLabelsForFields($group_css){ ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>" style="white-space: nowrap;">
            <input type="checkbox"  style="width: auto; padding: 0px; margin: 0 5px 0 0;"
                   id="<?php echo esc_attr( $this->htmlid ); ?>_labelfirst" name="<?php echo esc_attr( $this->htmlid ); ?>_labelfirst"
                   onchange="javascript:<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $this->update_js_function_name; ?>();"
                   onclick="javascript:this.onchange();"
                   />
            <label class="" for="<?php echo esc_attr( $this->htmlid ); ?>_labelfirst" style="width: auto; display: inline;"><?php
            echo wp_kses_post( sprintf(__('Put a label before field' ,'booking'),'<code>&lt;label&gt;</code>') ); ?>.</label>
        </div>
        <?php
    }

	// FixIn: 9.8.13.2.
    public function setUsingWrapLabelForFields($group_css){ ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>" style="white-space: nowrap;">
            <input type="checkbox"  style="width: auto; padding: 0px; margin: 0 5px 0 0;"
                   id="<?php echo esc_attr( $this->htmlid ); ?>_labelwrap" name="<?php echo esc_attr( $this->htmlid ); ?>_labelwrap"
                   onchange="javascript:<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $this->update_js_function_name; ?>();"
                   onclick="javascript:this.onchange();"
                   />
            <label class="" for="<?php echo esc_attr( $this->htmlid ); ?>_labelwrap" style="width: auto; display: inline;"><?php
            echo wp_kses_post( sprintf(__('Wrap checkbox with a label' ,'booking'),'<code>&lt;label&gt;</code>') ); ?>.</label>
        </div>
        <?php
    }


    public function setExclusiveFields($group_css){ ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>" style="white-space: nowrap;">
            <input type="checkbox"  style="width: auto; padding: 0px; margin: 0 5px 0 0;"
                   id="<?php echo esc_attr( $this->htmlid ); ?>_exclusive" name="<?php echo esc_attr( $this->htmlid ); ?>_exclusive"
                   onchange="javascript:<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $this->update_js_function_name; ?>();"
                   onclick="javascript:this.onchange();"
                   />
            <label class="" for="<?php echo esc_attr( $this->htmlid ); ?>_exclusive" style="width: auto; display: inline;"><?php
            /* translators: 1: ... */
            echo wp_kses_post( sprintf( __( 'Make it %1$sexclusive%2$s', 'booking' ),'<strong>','</strong>') ); ?>.</label>
        </div>
        <?php
    }

    
    public function setDefaultValueField($group_css=''){
        ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>">
            <label for="<?php echo esc_attr( $this->htmlid ); ?>_default" class="control-label"><?php
                esc_html_e('Default value' ,'booking'); ?> (<?php esc_html_e('optional' ,'booking'); ?>):</label>
            <input type="text" 
                   name="<?php echo esc_attr( $this->htmlid ); ?>_default" id="<?php echo esc_attr( $this->htmlid ); ?>_default"
                   onchange="javascript:<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $this->update_js_function_name; ?>();"
                   onkeypress="javascript:this.onchange();" 
                   onpaste="javascript:this.onchange();" 
                   oninput="javascript:this.onchange();"
                   />
            <p class="help-block" ><?php
				/* translators: 1: ... */
				echo wp_kses_post( sprintf( __( 'One Value from %1$sOptions%2$s list or term %3$s for selection of all checkboxes', 'booking' ),'<strong>','</strong>', '<code><strong>on</strong></code>') ); ?></p>
        </div>
        <?php
    }

    
    public function setOptionsField($group_css=''){
        ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>">
            <label for="<?php echo esc_attr( $this->htmlid ); ?>_options" class="control-label"><strong><?php
                esc_html_e('Options' ,'booking'); ?></strong> (<?php esc_html_e('required' ,'booking'); ?>):</label>
            <textarea rows="5" style="width:100%"
                   name="<?php echo esc_attr( $this->htmlid ); ?>_options" id="<?php echo esc_attr( $this->htmlid ); ?>_options"
                   onchange="javascript:<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $this->update_js_function_name; ?>();"
                   onkeypress="javascript:this.onchange();" 
                   onpaste="javascript:this.onchange();" 
                   oninput="javascript:this.onchange();"
                   ></textarea>
            <p class="help-block"><?php esc_html_e('One option per line' ,'booking'); ?></p>
        </div>
        <?php        
    }

    
    public function setTitlesField($group_css=''){
        ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>">
            <label for="<?php echo esc_attr( $this->htmlid ); ?>_titles" class="control-label"><?php
                esc_html_e('Titles of options' ,'booking'); ?> (<?php esc_html_e('optional' ,'booking'); ?>):</label>
            <textarea rows="5" style="width:100%"
                   name="<?php echo esc_attr( $this->htmlid ); ?>_titles" id="<?php echo esc_attr( $this->htmlid ); ?>_titles"
                   onchange="javascript:<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $this->update_js_function_name; ?>();"
                   onkeypress="javascript:this.onchange();" 
                   onpaste="javascript:this.onchange();" 
                   oninput="javascript:this.onchange();"
                   ></textarea>
            <p class="help-block"><?php esc_html_e('One title per line' ,'booking'); ?></p>
        </div>
        <?php            
    }

    
    public function js(){
        /* General Format: [text name 9/19 id:88id class:77class "Default_value"] */
        ?><script type="text/javascript">

            function <?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $this->update_js_function_name; ?>(){

                var p_name      = '';
                var p_required  = '';                
                var p_id        = '';
                var p_class     = '';
                
                var p_default   = '';
                var p_options   = '';
                var p_titles    = '';
                
                var p_uselabels  = '';
                var p_labelfirst  = '';			// FixIn: 9.8.13.2.
                var p_labelwrap  = '';
                var p_exclusive  = '';

                if ( jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_uselabels').prop("checked") ) {
                    p_uselabels = ' use_label_element';
                }
                if ( jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_labelfirst').prop("checked") ) {
                    p_labelfirst = ' label_first';
                }
                if ( jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_labelwrap').prop("checked") ) {			// FixIn: 9.8.13.2.
                    p_labelwrap = ' label_wrap';
                }
                if ( jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_exclusive').prop("checked") ) {
                    p_exclusive = ' exclusive';
                }


                if ( jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_required').prop("checked") ) {
                    p_required = '*';
                }
                                
                if (jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_default').val() != '') {
                    p_default = jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_default').val().replace(/[\[\]\.,]/g,'').replace(/"/g,'&quot;').replace(/@@/g,'@');
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_default').val(p_default);
                    if (p_default != '') {                        
                        p_default = ' default:' + p_default;
                    }                    
                }
                
                
                // Set Name only Letters
                if (jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_name').val() != '') {
                    p_name = jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_name').val();
                    p_name = p_name.replace(/[^A-Za-z0-9_-]*[0-9]*$/g,'').replace(/[^A-Za-z0-9_-]/g,'');
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_name').val(p_name);
                }

                if (jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_id').val() != '') {
                    p_id = jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_id').val().replace(/[^A-Za-z-_0-9]/g, "");
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_id').val(p_id);
                    if (p_id != '')
                        p_id = ' id:' + p_id;
                }

                if (jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_class').val() != '') {
                    p_class = jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_class').val().replace(/[^A-Za-z-_0-9]/g, "");
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_class').val(p_class);
                    if (p_class != '')
                        p_class = ' class:' + p_class;
                }

                var p_titles_list = new Array();
                if (jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_titles').val() != '') {
                    p_titles = jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_titles').val().replace(/[\[\]]/g,'').replace(/"/g,'&quot;').replace(/@@/g,'@');
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_titles').val(p_titles);
                    if (p_titles != '') {
                        p_titles_list = p_titles.split(/\n/);
                    }                    
                }


                if (jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_options').val() != '') {
                    p_options = jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_options').val().replace(/[\[\]\.,]/g,'').replace(/"/g,'&quot;').replace(/@@/g,'@');
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_options').val(p_options);
                    if (p_options != '') {
                        var p_options_list = p_options.split(/\n/);
                        p_options = '';
                        jQuery.each(p_options_list, function(o_ind){
                            
                            if ( o_ind < p_titles_list.length ) 
                                p_options +=  ' "' + p_titles_list[o_ind] +'@@' + p_options_list[o_ind] + '"';
                            else
                                p_options +=  ' "' + p_options_list[o_ind] + '"';
                        });
                    }                    
                }


                if ( p_options == '' ) 
                     p_options = ' ""';
                    
                if ( p_name != '' ){
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_put_in_form').val('[<?php echo esc_attr( $this->get_type() ); ?>'
                            + p_required + ' ' 
                            + p_name 
                            + p_id 
                            + p_class
                            + p_default
                            + p_uselabels
							+ p_labelwrap
                            + p_labelfirst
                            + p_exclusive
                            + p_options
                            + ']');
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_put_in_content').val('['+p_name+']');
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_put_in_content_val').val('['+p_name+'_val]');
                } else {
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_put_in_form').val('');
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_put_in_content').val('');
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_put_in_content_val').val('');
                }
            }

        </script>
        <?php
    } 
}
