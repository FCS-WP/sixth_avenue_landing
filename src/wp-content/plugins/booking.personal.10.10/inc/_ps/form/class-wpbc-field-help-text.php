<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class WPBC_Field_Help_Text {

    public    $title = '';
    private   $help = array();
    
    protected $type = '';
    protected $htmlid = '';
    
    protected $update_js_function_name = '';
    
    
    function __construct( $params = array() ) {
        
        $this->type     = $params['type'];
        $this->htmlid   = $params['id'];
        $this->title    = $params['title'];
        $this->update_js_function_name = 'wpbc_'. $this->htmlid .'_field_help_update';
        if (isset($params['help'])){
            if (is_array($params['help']))
                $this->help   = $params['help'];
            else 
                $this->help[] = $params['help'];
        }
        $this->js();
        $this->init();
        $this->setAdvancedParameters( $params );

    }

    
    public function get_type(){
        return $this->type;
    }
    
    
    public function show(){
       ?><script type="text/javascript">
            jQuery("#wpbc_field_help_section_<?php echo esc_attr( $this->htmlid ); ?>").show();
       </script><?php 
    }
    
    
    public function hide(){
       ?><script type="text/javascript">
            jQuery("#wpbc_field_help_section_<?php echo esc_attr( $this->htmlid ); ?>").hide();
       </script><?php 
    }
    
    
    public function setAdvancedParameters( $params ){
        // Set Advanced parameters to the Parameters. //////////////////////////
        if (isset($params['advanced'])){
            foreach ($params['advanced'] as $parameter_name => $parameter_value) {
                
                // Settings Properties, like: CHECKED, SELECTED, DISABLED
                if ( isset($parameter_value['prop'] ) ) {

                    ?><script type="text/javascript"><?php

                    foreach ($parameter_value['prop'] as $prop_name=>$prop_value) { ?>
                     jQuery("#<?php echo esc_attr( $this->htmlid . $parameter_name ); ?>").prop("<?php echo esc_attr( $prop_name ); ?>",<?php echo (($prop_value)?'true':'false'); ?>);
                    <?php } 

                    ?></script><?php 
                }

                // Settings Values to the Fields
                if ( isset($parameter_value['value'] ) ) {

                    ?><script type="text/javascript">                                    
                     jQuery("#<?php echo esc_attr( $this->htmlid . $parameter_name ); ?>").val("<?php
						 // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						 echo $parameter_value['value']; ?>");
                    </script><?php 
                }

                // Settings CSS to the INPUTS
                if ( isset($parameter_value['css'] ) ) {

                    ?><script type="text/javascript"><?php

                    foreach ($parameter_value['css'] as $style_prop_name=>$style_prop_value) { ?>
                     jQuery("#<?php echo esc_attr( $this->htmlid . $parameter_name ); ?>").parent().css("<?php echo esc_attr( $style_prop_name ); ?>","<?php echo esc_attr( $style_prop_value ); ?>");
                    <?php } 

                    ?></script><?php 
                }
                // Settings CSS to the INPUTS
                if ( isset($parameter_value['label'] ) ) {

                    ?><script type="text/javascript"><?php

                    foreach ($parameter_value['label'] as $style_prop_name=>$style_prop_value) { 
                        if ($style_prop_name == 'html') { ?>                       
                     jQuery("#<?php echo esc_attr( $this->htmlid . $parameter_name ); ?>").parent().find("label").html("<?php echo esc_attr( $style_prop_value ); ?>");
                        <?php } 
                    }

                    ?></script><?php 
                }
            }
        }
        ////////////////////////////////////////////////////////////////////////        
        ?><script type="text/javascript">  <?php
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $this->update_js_function_name; ?>(); </script><?php
    }
    
    
    public function init(){
        ?>        
        <div id="wpbc_field_help_section_<?php echo esc_attr( $this->htmlid ); ?>"
             class="wpbc_field_help_panel_background form-horizontal code_description wpbc_field_help_panel_field" 
             style="display:none;" >
			<?php /* ?>
            <div class="wpbc_field_help_panel_header"><?php echo esc_html( $this->title  ); ?></div><hr/>
            <?php  */

            $this->setRequiredField('one-row');

            $this->setNameField();      $this->setDefaultValueField();

            $this->setIdField();        $this->setClassField();

            $this->setSizeField();      $this->setMaxlengthField();
            
            if ($this->type == 'text')
                $this->setPlaceholderField('one-row');
            
            ?><div class="clear"></div><hr/><?php

            $this->setPutInFormField('one-row');

            $this->setPutInContentField('one-row');

            ?><div class="clear"></div><?php
            if (count($this->help)>0) echo '<hr/>';
            foreach ($this->help as $help_text_section) {
                if (! empty($help_text_section))
                    $this->setHelpInfo( $help_text_section, 'one-row');
            }
            ?><div class="clear"></div>            
        </div>            
        <?php
    }
 
    
    public function setHelpInfo($help_text_section, $group_css=''){
        
        ?><div class="wpbc-help-message <?php echo esc_attr( $group_css ); ?>"><?php
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $help_text_section ; 
        
        ?></div><hr/><?php
    }
    
    
    public function setRequiredField($group_css=''){
        ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>" style="white-space: nowrap;">
            <input type="checkbox"  style="width: auto; padding: 0px; margin: 0 5px 0 0;"
                   id="<?php echo esc_attr( $this->htmlid ); ?>_required" name="<?php echo esc_attr( $this->htmlid ); ?>_required"
                   onchange="javascript:<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $this->update_js_function_name; ?>();"
                   onclick="javascript:this.onchange();"
                   />
            <label class="" for="<?php echo esc_attr( $this->htmlid ); ?>_required" style="width: auto; display: inline;"><?php
            /* translators: 1: ... */
            echo wp_kses_post( sprintf( __( 'Set as %1$srequired%2$s', 'booking' ),'<strong>','</strong>') ); ?>.</label>
        </div>
        <?php
    }
    
    
    public function setNameField($group_css=''){
        ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>">
            <label for="<?php echo esc_attr( $this->htmlid ); ?>_name" class="control-label"><strong><?php
                esc_html_e('Name' ,'booking'); ?></strong> (<?php esc_html_e('required' ,'booking'); ?>):</label>
            <input type="text" value="unique_field<?php //echo time(); ?>_name" 
                   name="<?php echo esc_attr( $this->htmlid ); ?>_name" id="<?php echo esc_attr( $this->htmlid ); ?>_name"
                   onchange="javascript:<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $this->update_js_function_name; ?>();"
                   onkeypress="javascript:this.onchange();" 
                   onpaste="javascript:this.onchange();" 
                   oninput="javascript:this.onchange();"
                   />
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
        </div>
        <?php
    }

    
    public function setIdField($group_css=''){
        ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>">
            <label for="<?php echo esc_attr( $this->htmlid ); ?>_id" class="control-label"><code><?php
                esc_html_e('ID' ,'booking'); ?></code> (<?php esc_html_e('optional' ,'booking'); ?>):</label>
            <input type="text" 
                   name="<?php echo esc_attr( $this->htmlid ); ?>_id" id="<?php echo esc_attr( $this->htmlid ); ?>_id"
                   onchange="javascript:<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $this->update_js_function_name; ?>();"
                   onkeypress="javascript:this.onchange();" 
                   onpaste="javascript:this.onchange();" 
                   oninput="javascript:this.onchange();"                   
                   />            
        </div>
        <?php
    }

    
    public function setPlaceholderField($group_css=''){
        ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>">
            <label for="<?php echo esc_attr( $this->htmlid ); ?>_placeholder" class="control-label"><code><?php
            esc_html_e('Placeholder' ,'booking'); ?></code> (<?php esc_html_e('optional' ,'booking'); ?>):</label>
            <input type="text" 
                   name="<?php echo esc_attr( $this->htmlid ); ?>_placeholder" id="<?php echo esc_attr( $this->htmlid ); ?>_placeholder"
                   onchange="javascript:<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $this->update_js_function_name; ?>();"
                   onkeypress="javascript:this.onchange();" 
                   onpaste="javascript:this.onchange();" 
                   oninput="javascript:this.onchange();"
                   />            
        </div>
        <?php
    }
        
    


    public function setClassField($group_css=''){
        ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>">
            <label for="<?php echo esc_attr( $this->htmlid ); ?>_class" class="control-label"><code><?php
            esc_html_e('Class' ,'booking'); ?></code> (<?php esc_html_e('optional' ,'booking'); ?>):</label>
            <input type="text" 
                   name="<?php echo esc_attr( $this->htmlid ); ?>_class" id="<?php echo esc_attr( $this->htmlid ); ?>_class"
                   onchange="javascript:<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $this->update_js_function_name; ?>();"
                   onkeypress="javascript:this.onchange();" 
                   onpaste="javascript:this.onchange();" 
                   oninput="javascript:this.onchange();"
                   />            
        </div>
        <?php
    }

    
    public function setSizeField($group_css=''){
        ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>">
            <label for="<?php echo esc_attr( $this->htmlid ); ?>_size" class="control-label"><code><?php
                esc_html_e('Size' ,'booking'); ?></code> (<?php esc_html_e('optional' ,'booking'); ?>):</label>
            <input type="text" 
                   name="<?php echo esc_attr( $this->htmlid ); ?>_size" id="<?php echo esc_attr( $this->htmlid ); ?>_size"
                   onchange="javascript:<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $this->update_js_function_name; ?>();"
                   onkeypress="javascript:this.onchange();" 
                   onpaste="javascript:this.onchange();" 
                   oninput="javascript:this.onchange();"
                   />            
        </div>
        <?php
    }

    
    public function setMaxlengthField($group_css=''){
        ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>">
            <label for="<?php echo esc_attr( $this->htmlid ); ?>_maxlength" class="control-label"><code><?php
                esc_html_e('Maxlength' ,'booking'); ?></code> (<?php esc_html_e('optional' ,'booking'); ?>):</label>
            <input type="text" 
                   name="<?php echo esc_attr( $this->htmlid ); ?>_maxlength" id="<?php echo esc_attr( $this->htmlid ); ?>_maxlength"
                   onchange="javascript:<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $this->update_js_function_name; ?>();"
                   onkeypress="javascript:this.onchange();" 
                   onpaste="javascript:this.onchange();" 
                   oninput="javascript:this.onchange();"
                   />            
        </div>
        <?php
    }
    
    
    public function setPutInFormField($group_css=''){
        ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>">
			<code><span style="font-size: 1.1em;font-weight: 600;"><?php esc_html_e( 'Shortcode for Form Field', 'booking' ); ?>:</span></code><br>
            <label for="<?php echo esc_attr( $this->htmlid ); ?>_put_in_form" class="control-label"><?php
                echo wp_kses_post( sprintf(__('Copy and paste this shortcode into the form at left side' ,'booking'),'&amp;') ); ?></label>
            <input 
                name="<?php echo esc_attr( $this->htmlid ); ?>_put_in_form" id="<?php echo esc_attr( $this->htmlid ); ?>_put_in_form"
                class="put-in" type="text"  readonly="readonly" name="text" 
                onfocus="this.select()"
                />
        </div>
        <?php
    }
    
    
    public function setPutInContentField($group_css=''){
        ?>
		<hr>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>">
			<code><span style="font-size: 1.1em;font-weight: 600;"><?php esc_html_e( 'Shortcode for Content of field data', 'booking' ); ?>:</span></code><br>
            <label for="<?php echo esc_attr( $this->htmlid ); ?>_put_in_content" class="control-label"><?php
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped, WordPress.WP.I18n.MissingTranslatorsComment
                printf( __( 'Put this code in %1$sContent of Booking Fields%2$s and in %3$sEmail Templates%4$s', 'booking' )
                        ,'<code><a href="javascript:void(0)" onclick="javascript:jQuery(\'.visibility_container\').css(\'display\',\'none\');jQuery(\'#visibility_container_form_content_data\').css(\'display\',\'block\');jQuery(\'.nav-tab\').removeClass(\'booking-submenu-tab-selected\');jQuery(\'.booking-submenu-tab-content\').addClass(\'booking-submenu-tab-selected\');">','</a></code>','<code><a href="' . esc_url( wpbc_get_settings_url() ) . '&tab=email" >'
                        ,'</a></code>'); ?></label>
            <input 
                name="<?php echo esc_attr( $this->htmlid ); ?>_put_in_content" id="<?php echo esc_attr( $this->htmlid ); ?>_put_in_content"
                class="put-in" type="text" readonly="readonly" 
                onfocus="this.select()" 
                />
        </div>
        <?php
    }

    public function setPutInContentField_val($group_css=''){
        ?>
        <div class="parameter-group <?php echo esc_attr( $group_css ); ?>">
			<code><span style="font-size: 1.1em;font-weight: 600;"><?php esc_html_e( 'Shortcode for Selected option title', 'booking' ); ?>:</span></code><br>
            <label for="<?php echo esc_attr( $this->htmlid ); ?>_put_in_content_val" class="control-label"><?php
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped, WordPress.WP.I18n.MissingTranslatorsComment
                printf( __( 'Put this code in %1$sContent of Booking Fields%2$s and in %3$sEmail Templates%4$s', 'booking' )
                        ,'<code><a href="javascript:void(0)" onclick="javascript:jQuery(\'.visibility_container\').css(\'display\',\'none\');jQuery(\'#visibility_container_form_content_data\').css(\'display\',\'block\');jQuery(\'.nav-tab\').removeClass(\'booking-submenu-tab-selected\');jQuery(\'.booking-submenu-tab-content\').addClass(\'booking-submenu-tab-selected\');">','</a></code>','<code><a href="' . esc_url( wpbc_get_settings_url() ) . '&tab=email" >'
                        ,'</a></code>'); ?></label>
            <input
                name="<?php echo esc_attr( $this->htmlid ); ?>_put_in_content_val" id="<?php echo esc_attr( $this->htmlid ); ?>_put_in_content_val"
                class="put-in" type="text" readonly="readonly"
                onfocus="this.select()"
                />
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
                var p_default   = '';
                var p_id        = '';
                var p_class     = '';
                var p_placeholder = '';
                var p_size      = '';
                var p_maxlength = '';

                if ( jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_required').prop("checked") ) {
                    p_required = '*';
                }
                // Set Name only Letters
                if (jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_name').val() != '') {
                    p_name = jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_name').val();
                    p_name = p_name.replace(/[^A-Za-z0-9_-]*[0-9]*$/g,'').replace(/[^A-Za-z0-9_-]/g,'');
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_name').val(p_name);
                }
                // Any characters, but without [ ] and "
                if (jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_default').val() != '') {
                    p_default = jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_default').val().replace(/[\[\]]/g,'').replace(/"/g,'&quot;');
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_default').val(p_default);
                    if (p_default != '')
                        p_default = ' "' +  p_default + '"';
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
                
                if ( jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_placeholder').length )
                if (jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_placeholder').val() != '') {
                    
                    p_placeholder = jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_placeholder').val().replace(/[^A-Za-z-_0-9\s]/g, "");
                    p_placeholder = p_placeholder.replace(/[\s]/g, "_");
                    
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_placeholder').val(p_placeholder);
                    if (p_placeholder != '')
                        p_placeholder = ' placeholder:' + p_placeholder;
                }
                
                
                // Set Size only 0-9
                if (jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_size').val() != '') {
                    p_size = jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_size').val();
                    p_size = p_size.replace(/[^0-9]/g,'');
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_size').val(p_size);
                    if (p_size != '')
                        p_size = ' ' + p_size + '/';
                }
                // Set Max Length only 0-9
                if (jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_maxlength').val() != '') {

                    p_maxlength = jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_maxlength').val();
                    p_maxlength = p_maxlength.replace(/[^0-9]/g,'');
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_maxlength').val(p_maxlength);
                    if (p_maxlength != '')
                        if (p_size == '') 
                            p_maxlength = ' /' + p_maxlength;            
                }

                if (p_name != ''){
                    jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_put_in_form').val('[<?php echo esc_attr( $this->get_type() ); ?>'
                            + p_required + ' ' 
                            + p_name 
                            + p_size 
                            + p_maxlength 
                            + p_id 
                            + p_class 
                            + p_placeholder
                            + p_default 
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

