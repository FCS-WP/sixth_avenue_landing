<?php
/* Themovation Theme Options */
if ( function_exists( 'get_theme_mod' ) ) {
	/* Footer Widget Switch */
	
	$themo_footer_widget_switch = get_theme_mod( 'themo_footer_widget_switch', true );
    $themo_footer2_widget_switch = get_theme_mod( 'themo_footer2_widget_switch', false );


	/* Footer  Copyright*/
	$themo_footer_copyright = do_shortcode(get_theme_mod( 'themo_footer_copyright' )); // Get Google Analytics Tracking Code
	$themo_footer_copyright_output = "";
	if ($themo_footer_copyright > ""){
		$themo_footer_copyright_output = "<span class='footer_copy'>".$themo_footer_copyright."</span>";
	}

	/* Footer  Credit */
	$themo_footer_credit = get_theme_mod( 'themo_footer_credit' ); // Get Google Analytics Tracking Code
	$themo_footer_credit_output = "";
	$themo_footer_spacer = "";
	if ($themo_footer_credit > ""){
		$themo_footer_credit_output = "<span class='footer_credit'>".$themo_footer_credit."</span>";

	}

    $themo_footer_spacer = false;
    if ($themo_footer_copyright > "" && $themo_footer_credit > ""){
        $themo_footer_spacer = " - ";
    }


	/* Themovation Theme Options */
	if ( function_exists( 'get_theme_mod' ) ) {
		/* Footer  Columns */
		$themo_footer_columns = get_theme_mod( 'themo_footer_columns', 2 );
		$bootstrap_footer_column_class = ''; // Bootstrap 3 grid column size
		switch ($themo_footer_columns) {
			case 1:
				$bootstrap_footer_column_class = "col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2";
				break;
			case 2:
				$bootstrap_footer_column_class = "col-sm-6";
				break;
			case 3:
				$bootstrap_footer_column_class = "col-md-4 col-sm-6";
				break;
			case 4:
				$bootstrap_footer_column_class = "col-md-3 col-sm-6";
				break;
		}
	}

    /* Themovation Theme Options Footer 2 */
    if ( function_exists( 'get_theme_mod' ) ) {
        /* Footer  Columns */
        $themo_footer2_columns = get_theme_mod( 'themo_footer2_columns', 2 );
        $bootstrap_footer2_column_class = ''; // Bootstrap 3 grid column size
        switch ($themo_footer2_columns) {
            case 1:
                $bootstrap_footer2_column_class = "col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2";
                break;
            case 2:
                $bootstrap_footer2_column_class = "col-sm-6";
                break;
            case 3:
                $bootstrap_footer2_column_class = "col-md-4 col-sm-6";
                break;
            case 4:
                $bootstrap_footer2_column_class = "col-md-3 col-sm-6";
                break;
        }
    }

	
}
/* END Theme Options */
?>

<?php
if ($themo_footer_widget_switch || $themo_footer2_widget_switch || $themo_footer_copyright_output > "" || $themo_footer_credit_output > ""){ ?>
<div class="prefooter"></div>

<footer class="footer" role="contentinfo">
    <?php
    // Footer Widget Area / Enabled / Disabled via Theme Options
    if ($themo_footer_widget_switch){ ?>
    <div class="th-upper-footer">
        <div class="container">
            <div class="footer-widgets row th-widget-area">
            <?php // Footer column 1
            if ( is_active_sidebar('sidebar-footer-1') ) {?>
                <div class="footer-area-1 <?php echo sanitize_text_field($bootstrap_footer_column_class); ?>">
                <?php dynamic_sidebar('sidebar-footer-1'); ?>
                </div>
            <?php } ?>
            <?php // Footer column 2
            if ( is_active_sidebar('sidebar-footer-2') ) {?>
                <div class="footer-area-2 <?php echo sanitize_text_field($bootstrap_footer_column_class); ?>">
                <?php dynamic_sidebar('sidebar-footer-2'); ?>
                </div>
            <?php } ?>
             <?php // Footer column 3
            if ( is_active_sidebar('sidebar-footer-3') ) {?>
                <div class="footer-area-3 <?php echo sanitize_text_field($bootstrap_footer_column_class); ?>">
                <?php dynamic_sidebar('sidebar-footer-3'); ?>
                </div>
            <?php } ?>
             <?php // Footer column 4
            if ( is_active_sidebar('sidebar-footer-4') ) {?>
                <div class="footer-area-4 <?php echo sanitize_text_field($bootstrap_footer_column_class); ?>">
                <?php dynamic_sidebar('sidebar-footer-4'); ?>
                </div>
            <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>

    <?php
    // LOWER FOOTER
    // Footer Widget Area / Enabled / Disabled via Theme Options
    if ($themo_footer2_widget_switch){ ?>
        <div class="th-lower-footer">
            <div class="th-separator"></div>
            <div class="container">
                <div class="footer-widgets row th-widget-area">
                    <?php // Footer 2 column 1
                    if ( is_active_sidebar('sidebar-footer2-1') ) {?>
                        <div class="footer-area-1 <?php echo sanitize_text_field($bootstrap_footer2_column_class); ?>">
                            <?php dynamic_sidebar('sidebar-footer2-1'); ?>
                        </div>
                    <?php } ?>
                    <?php // Footer 2 column 2
                    if ( is_active_sidebar('sidebar-footer2-2') ) {?>
                        <div class="footer-area-2 <?php echo sanitize_text_field($bootstrap_footer2_column_class); ?>">
                            <?php dynamic_sidebar('sidebar-footer2-2'); ?>
                        </div>
                    <?php } ?>
                    <?php // Footer 2 column 3
                    if ( is_active_sidebar('sidebar-footer2-3') ) {?>
                        <div class="footer-area-3 <?php echo sanitize_text_field($bootstrap_footer2_column_class); ?>">
                            <?php dynamic_sidebar('sidebar-footer2-3'); ?>
                        </div>
                    <?php } ?>
                    <?php // Footer 2 column 4
                    if ( is_active_sidebar('sidebar-footer2-4') ) {?>
                        <div class="footer-area-4 <?php echo sanitize_text_field($bootstrap_footer2_column_class); ?>">
                            <?php dynamic_sidebar('sidebar-footer2-4'); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</footer>

<?php } ?>