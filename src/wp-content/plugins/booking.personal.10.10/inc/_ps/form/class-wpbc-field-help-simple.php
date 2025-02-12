<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class WPBC_Field_Help_Simple extends WPBC_Field_Help_Text {

    public    $title = '';
    protected $help = array();
    
    protected $type = '';
    protected $htmlid = '';
    
    protected $update_js_function_name = '';
    
    
    function __construct( $params = array() ) {
        //                                   cols/rows
        //Format [textarea* textarea_-740_name 50x17 id:idd class:clsss "def"]
        
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
    
    // Ovveride structure
    public function init(){
        ?>        
        <div id="wpbc_field_help_section_<?php echo esc_attr( $this->htmlid ); ?>"
             class="wpbc_field_help_panel_background form-horizontal code_description wpbc_field_help_panel_field" 
             style="display:none;" >
			<?php /* ?>
            <div class="wpbc_field_help_panel_header"><?php echo esc_html( $this->title  ); ?></div><hr/><?php
			*/

            $this->setPutInFormField('one-row');

            ?><div class="clear"></div><?php 
            
            foreach ($this->help as $help_text_section) {
                if (! empty($help_text_section))
                    $this->setHelpInfo( $help_text_section, 'one-row');
            }
            
            ?><div class="clear"></div>
            <script type="text/javascript">  <?php
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo $this->update_js_function_name; ?>(); </script>
        </div>            
        <?php
    }
    
    
    public function setHelpInfo($help_text_section, $group_css=''){
        
        ?><div class="wpbc-help-message <?php echo esc_attr( $group_css ); ?>"><?php
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $help_text_section ; 
        
        ?></div><hr/><?php
    }
     
    
    public function js(){
        /* General Format: [captcha] */
        ?><script type="text/javascript">
            function <?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $this->update_js_function_name; ?>(){
                
                jQuery('#<?php echo esc_attr( $this->htmlid ); ?>_put_in_form').val('[<?php echo esc_attr( $this->get_type() ); ?>]');
            
            }
        </script>
        <?php
    } 
}
