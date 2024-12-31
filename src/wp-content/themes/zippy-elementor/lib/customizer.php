<?php
/**
 * _s Theme Customizer.
 *
 * @package _s
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function _s_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
//add_action( 'customize_register', '_s_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function _s_customize_preview_js() {
	wp_enqueue_script( '-s-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
//add_action( 'customize_preview_init', '_s_customize_preview_js' );


// Add the theme configuration
Uplands_Kirki::add_config( 'uplands_theme', array(
    'capability'    => 'edit_theme_options',
    'option_type'   => 'theme_mod',
) );

// Create a Panel for our theme options.
Uplands_Kirki::add_panel( 'themo_options', array(
    'priority'    => 10,
    'title'       => __( 'Theme Options', 'uplands' ),
    'description' => __( 'My Description', 'uplands' ),
) );


// LOGO SECTION
Uplands_Kirki::add_section( 'logo', array(
    'title'      => esc_attr__( 'Logo', 'uplands' ),
    'priority'   => 2,
    'panel'          => 'themo_options',
    'capability' => 'edit_theme_options',
) );

// Logo : Enable Retina Support.
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_retinajs_logo',
    'label'       => esc_html__( 'High-resolution/Retina Logo Support', 'uplands' ),
    'description' => esc_html__( 'Automatically serve up your high-resolution logo to devices that support them.', 'uplands' ),
    'section'     => 'logo',
    'default'     => '',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Logo : Height
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'number',
    'settings'    => 'themo_logo_height',
    'label'       => esc_html__( 'Logo Height', 'uplands' ),
    'description' => esc_html__( 'Set height and then \'Publish\' BEFORE uploading your logo.', 'uplands' ),
    'section'     => 'logo',
    'default'     => 100,
    'choices'     => array(
        'min'  => '10',
        'max'  => '300',
        'step' => '1',
    ),
    'output' => array(
        array(
            'element'  => '#logo img',
            'property' => 'max-height',
            'units'    => 'px',
        ),
        array(
            'element'  => '#logo img',
            'property' => 'width',
            'value_pattern' => 'auto'
        ),
    ),
) );

Uplands_Kirki::add_field( 'theme_config_id', [
    'type'        => 'custom',
    'settings'    => 'themo_logo_resize_help',
    'label'       => esc_html__('Resizing', 'uplands'),
    'section'     => 'logo',
    'default'     => '<div class="th-theme-support">' . __('To increase your logo size, set the new \'Logo Height\' above and \'Publish\' before you \'Remove\' and re-upload your logo. The theme resizes the logo during the upload process.', 'uplands') . '</div>',
    'priority'    => 10,
] );

// Logo : Logo Image
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'image',
    'settings'    => 'themo_logo',
    'label'       => esc_html__( 'Logo', 'uplands' ),
    'description' => esc_html__( 'For retina support, upload a logo that is twice the height set above.', 'uplands' ) ,
    'section'     => 'logo',
    'default'     => '',
    'priority'    => 10,
) );





// Logo : Transparent Switch
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_logo_transparent_header_enable',
    'label'       => esc_html__( 'Alternative logo', 'uplands' ),
    'description'       => esc_html__( 'Used as an option for transparency header', 'uplands' ),
    'section'     => 'logo',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Logo : Transparent Logo
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'image',
    'settings'    => 'themo_logo_transparent_header',
    'label'       => esc_html__( 'Alternative logo upload', 'uplands' ),
    'description' => esc_html__( 'For retina support, upload a logo that is twice the height set above.', 'uplands' ) ,
    'section'     => 'logo',
    'default'     => '',
    'priority'    => 10,
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_logo_transparent_header_enable',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_logo_transparent_header_enable',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );


// MENU SECTION
Uplands_Kirki::add_section( 'menu', array(
    'title'      => esc_attr__( 'Menu & Header', 'uplands' ),
    'priority'   => 2,
    'panel'          => 'themo_options',
    'capability' => 'edit_theme_options',
) );

// Menu : Top Nav Switch
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_top_nav_switch',
    'label'       => esc_html__( 'Top Bar', 'uplands' ),
    'section'     => 'menu',
    'default'     => '',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Menu : Top Nav Text
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'     => 'textarea',
    'settings' => 'themo_top_nav_text',
    'label'    => esc_html__( 'Top Bar Text', 'uplands' ),
    'section'  => 'menu',
    'default'  => esc_attr__( 'Welcome', 'uplands' ),
    'priority' => 10,
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_top_nav_switch',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_top_nav_switch',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );

// Menu : Icon Block

Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'repeater',
    'label'       => esc_attr__( 'Top Bar Icons', 'uplands' ),
    'description' => esc_html__( 'Use any', 'uplands' ). ' <a href="http://fontawesome.io/icons/" target="_blank">Font Awesome</a> icon (e.g.: fa fa-twitter). <a href="http://fontawesome.io/icons/" target="_blank">'.esc_html__( 'Full List Here', 'uplands' ).'</a>',
    'section'     => 'menu',
    'priority'    => 10,
    'row_label' => array(
        'type' => 'text',
        'value' => esc_attr__('Icon Block', 'uplands' ),
    ),
    'settings'    => 'themo_top_nav_icon_blocks',
    'default'     => array(
        array(
            'title' => esc_attr__( 'Contact Us', 'uplands' ),
            'themo_top_nav_icon'  => 'fa fa-envelope-open-o',
            'themo_top_nav_icon_url'  => 'mailto:contact@themovation.com',
            'themo_top_nav_icon_url_target'  => '',
        ),
        array(
            'title' => esc_attr__( 'How to Find Us', 'uplands' ),
            'themo_top_nav_icon'  => 'fa fa-map-o',
            'themo_top_nav_icon_url'  => '#',
            'themo_top_nav_icon_url_target'  => '',
        ),
        array(
            'title' => esc_attr__( '250-555-5555', 'uplands' ),
            'themo_top_nav_icon'  => 'fa fa-mobile',
            'themo_top_nav_icon_url'  => 'tel:250-555-5555',
            'themo_top_nav_icon_url_target'  => '',
        ),
        array(
            'themo_top_nav_icon'  => 'fa fa-twitter',
            'themo_top_nav_icon_url'  => 'http://twitter.com',
            'themo_top_nav_icon_url_target'  => '1',
        ),
    ),
    'fields' => array(
        'title' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Link Text', 'uplands' ),
            'default'     => '',
        ),
        'themo_top_nav_icon' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Icon', 'uplands' ),
            'default'     => '',
        ),
        'themo_top_nav_icon_url' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Link URL', 'uplands' ),
            'default'     => '',
        ),
        'themo_top_nav_icon_url_target' => array(
            'type'        => 'checkbox',
            'label'       => esc_attr__( 'Open Link in New Window', 'uplands' ),
            'default'     => '',
        ),
    ),
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_top_nav_switch',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_top_nav_switch',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );

// Menu : Header Style
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio',
    'settings'    => 'themo_header_style',
    'label'       => esc_html__( 'Header Style', 'uplands' ),
    'section'     => 'menu',
    'default'     => 'dark',
    'priority'    => 10,
    'choices'     => array(
        'dark'  => esc_attr__( 'Dark', 'uplands' ),
        'light' => esc_attr__( 'Light', 'uplands' ),
    ),
) );

// Menu : Dropdown Style
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio',
    'settings'    => 'themo_dropdown_style',
    'label'       => esc_html__( 'Dropdown Style', 'uplands' ),
    'section'     => 'menu',
    'default'     => 'light',
    'priority'    => 10,
    'choices'     => array(
        'dark'  => esc_attr__( 'Dark', 'uplands' ),
        'light' => esc_attr__( 'Light', 'uplands' ),
    ),
) );

//Dropdown Style

// Menu : Social Icno Switch
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_nav_social_switch',
    'label'       => esc_html__( 'Social Icons', 'uplands' ),
    'section'     => 'menu',
    'default'     => '',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Menu : Top Menu Margin
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'number',
    'settings'    => 'themo_nav_top_margin',
    'label'       => esc_html__( 'Navigation Top Margin', 'uplands' ),
    'description' => esc_html__( 'Set top margin value for the navigation bar', 'uplands' ),
    'section'     => 'menu',
    'default'     => 15,
    'choices'     => array(
        'min'  => '0',
        'max'  => '300',
        'step' => '1',
    ),
    'output' => array(
        array(
            'element'  => '.navbar .navbar-nav',
            'property' => 'margin-top',
            'units'    => 'px',
        ),
        array(
            'element'  => '.navbar .navbar-toggle',
            'property' => 'top',
            'units'    => 'px',
        ),
        array(
            'element'  => '.themo_cart_icon',
            'property' => 'margin-top',
            'value_pattern' => 'calc($px + 8px)'
        ),
    ),
) );




// Menu : Sticky Header
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_sticky_header',
    'label'       => esc_html__( 'Sticky Header', 'uplands' ),
    'section'     => 'menu',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );


// COLOR PANEL
Uplands_Kirki::add_section( 'color', array(
    'title'      => esc_attr__( 'Color', 'uplands' ),
    'priority'   => 2,
    'panel'          => 'themo_options',
    'capability' => 'edit_theme_options',
) );

// Color : Primary
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'color',
    'settings'    => 'color_primary',
    'label'       => esc_attr__( 'Primary Color', 'uplands' ),
    'description'       => esc_attr__( 'This color appears in button options, links, and some headings throughout the theme', 'uplands' ),
    'section'     => 'color',
    'default'     => '#74986a',
    'priority'    => 10,
    'choices'     => array(
        'alpha' => true,
    ),
    'output' => array(

        array(
            'element'  => '.btn-cta-primary,.navbar .navbar-nav>li>a:hover:after,.navbar .navbar-nav>li.active>a:after,.navbar .navbar-nav>li.active>a:hover:after,.navbar .navbar-nav>li.active>a:focus:after,form input[type=submit],html .woocommerce a.button.alt,html .woocommerce-page a.button.alt,html .woocommerce a.button,html .woocommerce-page a.button,.woocommerce #respond input#submit.alt:hover,.woocommerce a.button.alt:hover,.woocommerce #respond input#submit.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce button.button.alt:hover,.woocommerce input.button.alt:hover,.woocommerce #respond input#submit.disabled,.woocommerce #respond input#submit:disabled,.woocommerce #respond input#submit:disabled[disabled],.woocommerce a.button.disabled,.woocommerce a.button:disabled,.woocommerce a.button:disabled[disabled],.woocommerce button.button.disabled,.woocommerce button.button:disabled,.woocommerce button.button:disabled[disabled],.woocommerce input.button.disabled,.woocommerce input.button:disabled,.woocommerce input.button:disabled[disabled],.woocommerce #respond input#submit.disabled:hover,.woocommerce #respond input#submit:disabled:hover,.woocommerce #respond input#submit:disabled[disabled]:hover,.woocommerce a.button.disabled:hover,.woocommerce a.button:disabled:hover,.woocommerce a.button:disabled[disabled]:hover,.woocommerce button.button.disabled:hover,.woocommerce button.button:disabled:hover,.woocommerce button.button:disabled[disabled]:hover,.woocommerce input.button.disabled:hover,.woocommerce input.button:disabled:hover,.woocommerce input.button:disabled[disabled]:hover,.woocommerce #respond input#submit.alt.disabled,.woocommerce #respond input#submit.alt.disabled:hover,.woocommerce #respond input#submit.alt:disabled,.woocommerce #respond input#submit.alt:disabled:hover,.woocommerce #respond input#submit.alt:disabled[disabled],.woocommerce #respond input#submit.alt:disabled[disabled]:hover,.woocommerce a.button.alt.disabled,.woocommerce a.button.alt.disabled:hover,.woocommerce a.button.alt:disabled,.woocommerce a.button.alt:disabled:hover,.woocommerce a.button.alt:disabled[disabled],.woocommerce a.button.alt:disabled[disabled]:hover,.woocommerce button.button.alt.disabled,.woocommerce button.button.alt.disabled:hover,.woocommerce button.button.alt:disabled,.woocommerce button.button.alt:disabled:hover,.woocommerce button.button.alt:disabled[disabled],.woocommerce button.button.alt:disabled[disabled]:hover,.woocommerce input.button.alt.disabled,.woocommerce input.button.alt.disabled:hover,.woocommerce input.button.alt:disabled,.woocommerce input.button.alt:disabled:hover,.woocommerce input.button.alt:disabled[disabled],.woocommerce input.button.alt:disabled[disabled]:hover,p.demo_store,.woocommerce.widget_price_filter .ui-slider .ui-slider-handle,.th-conversion form input[type=submit],.th-conversion .with_frm_style input[type=submit],.th-pricing-column.th-highlight,.search-submit,.search-submit:hover,.widget .tagcloud a:hover,.footer .tagcloud a:hover,.btn-standard-primary-form form .frm_submit input[type=submit],.btn-standard-primary-form form .frm_submit input[type=submit]:hover,.btn-ghost-primary-form form .frm_submit input[type=submit]:hover,.btn-cta-primary-form form .frm_submit input[type=submit],.btn-cta-primary-form form .frm_submit input[type=submit]:hover,.th-widget-area form input[type=submit],.th-widget-area .with_frm_style .frm_submit input[type=submit],.elementor-widget-themo-header.elementor-view-stacked .th-header-wrap .elementor-icon,.elementor-widget-themo-service-block.elementor-view-stacked .th-service-block-w .elementor-icon',
            'property' => 'background-color',
        ),
        array(
            'element'  => 'a,.accent,.navbar .navbar-nav .dropdown-menu li.active a,.navbar .navbar-nav .dropdown-menu li a:hover,.navbar .navbar-nav .dropdown-menu li.active a:hover,.page-title h1,.inner-container>h1.entry-title,.woocommerce ul.products li.product .price,.woocommerce ul.products li.product .price del,.woocommerce .single-product .product .price,.woocommerce.single-product .product .price,.woocommerce .single-product .product .price ins,.woocommerce.single-product .product .price ins,.a2c-ghost.woocommerce a.button,.th-cta .th-cta-text span,.elementor-widget-themo-info-card .th-info-card-wrap .elementor-icon-box-title,.th-pricing-cost,#main-flex-slider .slides h1,.th-team-member-social a i:hover,.elementor-widget-toggle .elementor-toggle .elementor-toggle-title,.elementor-widget-toggle .elementor-toggle .elementor-toggle-title.active,.elementor-widget-toggle .elementor-toggle .elementor-toggle-icon,.elementor-widget-themo-header .th-header-wrap .elementor-icon,.elementor-widget-themo-header.elementor-view-default .th-header-wrap .elementor-icon,.elementor-widget-themo-service-block .th-service-block-w .elementor-icon,.elementor-widget-themo-service-block.elementor-view-default .th-service-block-w .elementor-icon,.elementor-widget-themo-header.elementor-view-framed .th-header-wrap .elementor-icon,.elementor-widget-themo-service-block.elementor-view-framed .th-service-block-w .elementor-icon',
            'property' => 'color',
        ),
        array(
            'element'  => '.btn-standard-primary,.btn-ghost-primary:hover,.pager li>a:hover,.pager li>span:hover,.a2c-ghost.woocommerce a.button:hover',
            'property' => 'background-color',
        ),
        array(
            'element'  => '.btn-standard-primary,.btn-ghost-primary:hover,.pager li>a:hover,.pager li>span:hover,.a2c-ghost.woocommerce a.button:hover,.btn-standard-primary-form form .frm_submit input[type=submit],.btn-standard-primary-form form .frm_submit input[type=submit]:hover,.btn-ghost-primary-form form .frm_submit input[type=submit]:hover,.btn-ghost-primary-form form .frm_submit input[type=submit]',
            'property' => 'border-color',
        ),
        array(
            'element'  => '.btn-ghost-primary,.btn-ghost-primary:focus,.th-portfolio-filters a.current,.a2c-ghost.woocommerce a.button,.btn-ghost-primary-form form .frm_submit input[type=submit]',
            'property' => 'color',
        ),
        array(
            'element'  => '.btn-ghost-primary,.th-portfolio-filters a.current,.a2c-ghost.woocommerce a.button,.elementor-widget-themo-header.elementor-view-framed .th-header-wrap .elementor-icon,.elementor-widget-themo-service-block.elementor-view-framed .th-service-block-w .elementor-icon',
            'property' => 'border-color',
        ),
        array(
            'element'  => 'form select:focus,form textarea:focus,form input:focus,.th-widget-area .widget select:focus,.search-form input:focus,form.searchform input[type=text]:focus',
            'property' => 'border-color',
            'suffix' => '!important',
        ),
    ),
) );

// Color : Accent
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'color',
    'settings'    => 'color_accent',
    'label'       => esc_attr__( 'Accent Color', 'uplands' ),
    'description'       => esc_attr__( 'This color appears in icons, button options, and a few details throughout the theme.', 'uplands' ),
    'section'     => 'color',
    'default'     => '#9d9684',
    'priority'    => 10,
    'choices'     => array(
        'alpha' => true,
    ),
    'output' => array(
      /*  array(
            'element'  => '',
            'property' => 'color',
        ), */
        array(
            'element'  => '.btn-cta-accent,.a2c-cta.woocommerce a.button,.a2c-cta.woocommerce a.button:hover,.btn-standard-accent-form form .frm_submit input[type=submit],.btn-standard-accent-form form .frm_submit input[type=submit]:hover,.btn-ghost-accent-form form .frm_submit input[type=submit]:hover,.btn-cta-accent-form form .frm_submit input[type=submit],.btn-cta-accent-form form .frm_submit input[type=submit]:hover',
            'property' => 'background-color',
        ),
        array(
            'element'  => 'body #booked-profile-page input[type=submit].button-primary,body div.booked-calendar input[type=submit].button-primary,body .booked-modal input[type=submit].button-primary,body div.booked-calendar .booked-appt-list .timeslot .timeslot-people button,body #booked-profile-page .booked-profile-appt-list .appt-block.approved .status-block',
            'property' => 'background',
            'suffix' => '!important',
        ),
        array(
            'element'  => 'body #booked-profile-page input[type=submit].button-primary,body div.booked-calendar input[type=submit].button-primary,body .booked-modal input[type=submit].button-primary,body div.booked-calendar .booked-appt-list .timeslot .timeslot-people button,.btn-standard-accent-form form .frm_submit input[type=submit],.btn-standard-accent-form form .frm_submit input[type=submit]:hover,.btn-ghost-accent-form form .frm_submit input[type=submit]:hover,.btn-ghost-accent-form form .frm_submit input[type=submit]',
            'property' => 'border-color',
            'suffix' => '!important',
        ),
        array(
            'element'  => '.btn-standard-accent,.btn-ghost-accent:hover',
            'property' => 'background-color',
        ),
        array(
            'element'  => '.btn-standard-accent,.btn-ghost-accent:hover',
            'property' => 'border-color',
        ),
        array(
            'element'  => '.btn-ghost-accent,.btn-ghost-accent:focus,.btn-ghost-accent-form form .frm_submit input[type=submit]',
            'property' => 'color',
        ),
        array(
            'element'  => '.btn-ghost-accent',
            'property' => 'border-color',
        ),
    ),
) );

//  TYPOGRAPHY SECTION
Uplands_Kirki::add_section( 'typography', array(
	'title'      => esc_attr__( 'Typography', 'uplands' ),
	'priority'   => 2,
	'capability' => 'edit_theme_options',
    'panel'          => 'themo_options',
) );


// Typography : Headings Text
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'typography',
    'settings'    => 'headers_typography',
    'label'       => esc_attr__( 'Headings Typography', 'uplands' ),
    'description' => esc_attr__( 'Select options for all headings.', 'uplands' ),
    'help'        => esc_attr__( 'The typography options you set here will override the Body Typography options for all headings on your site (post titles, widget titles etc).', 'uplands' ),
    'section'     => 'typography',
    'priority'    => 10,
    'default'     => array(
        'font-family'    => 'Merriweather',
        'variant'        => 'regular',
        'text-transform' => 'none',
    ),
    'output' => array(
        array(
            'element' => array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', '.h1', '.h2', '.h3', '.h4', '.h5', '.h6' ),
        ),
    ),
) );

// Typography : Body Text
Uplands_Kirki::add_field( 'uplands_theme', array(
	'type'        => 'typography',
	'settings'    => 'body_typography',
	'label'       => esc_attr__( 'Body Typography', 'uplands' ),
	'description' => esc_attr__( 'Select the main typography options for your site.', 'uplands' ),
	'help'        => esc_attr__( 'The typography options you set here apply to all content on your site.', 'uplands' ),
	'section'     => 'typography',
	'priority'    => 10,
	'default'     => array(
		'font-family'    => 'Poppins',
		'variant'        => 'regular',
		'font-size'      => '16px',
		'line-height'    => '1.65',
		'color'          => '#717171',
	),
	'output' => array(
		array(
			'element' => 'body,p,li',
		),
	),
) );



// Typography : Menu Text
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'typography',
    'settings'    => 'menu_typography',
    'label'       => esc_attr__( 'Menu Typography', 'uplands' ),
    'description' => esc_attr__( 'Select the typography options for your Menu.', 'uplands' ),
    'help'        => esc_attr__( 'The typography options you set here will override the Typography options for the main menu on your site.', 'uplands' ),
    'section'     => 'typography',
    'priority'    => 10,
    'default'     => array(
        'font-family'    => 'Poppins',
        'variant'        => 'regular',
        'font-size'      => '15px',
        'color'          => '#515151',
        'text-transform' => 'uppercase',
    ),
    'output' => array(
        array(
            'element' => array( '.navbar .navbar-nav > li > a, .navbar .navbar-nav > li > a:hover, .navbar .navbar-nav > li.active > a, .navbar .navbar-nav > li.active > a:hover, .navbar .navbar-nav > li.active > a:focus, .navbar .navbar-nav > li.th-accent' ),
        ),
    ),
) );


// Typography : Headings Text
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'typography',
    'settings'    => 'additional_fonts_1',
    'label'       => esc_attr__( 'Include Additional Fonts', 'uplands' ),
    'description' => esc_attr__( 'Use these inputs if you want to include additional font families or font weights.', 'uplands' ),
    'section'     => 'typography',
    'priority'    => 10,
    'default'     => array(
        'font-family'    => 'Merriweather',
        'variant'        => '700',
    ),
) );

Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'typography',
    'settings'    => 'additional_fonts_2',
    'section'     => 'typography',
    'priority'    => 10,
    'default'     => array(
        'font-family'    => 'Poppins',
        'variant'        => '700',
    ),
) );

// BLOG SECTION
Uplands_Kirki::add_section( 'blog', array(
    'title'      => esc_attr__( 'Blog', 'uplands' ),
    'priority'   => 2,
    'capability' => 'edit_theme_options',
    'panel'          => 'themo_options',
) );

Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_automatic_post_excerpts',
    'label'       => esc_html__( 'Enable Automatic Post Excerpts', 'uplands' ),
    'description'       => esc_html__( 'This option affects the Blog widget and the blog templates', 'uplands' ),
    'section'     => 'blog',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Blog. : Blog header switch
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_blog_index_layout_show_header',
    'label'       => esc_html__( 'Blog Homepage Header', 'uplands' ),
    'description' => esc_html__( 'Show / Hide header for Blog Homepage', 'uplands' ),
    'section'     => 'blog',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Blog : Blog Header Align
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'themo_blog_index_layout_header_float',
    'label'       => esc_html__( 'Blog Homepage Header Position ', 'uplands' ),
    'section'     => 'blog',
    'default'     => 'centered',
    'priority'    => 10,
    'choices'     => array(

        'left'   => array(
            esc_attr__( 'Left', 'uplands' ),
        ),
        'centered'   => array(
            esc_attr__( 'Centered', 'uplands' ),
        ),
        'right'   => array(
            esc_attr__( 'Right', 'uplands' ),
        ),

    ),
    'active_callback'  => array(
        array(
            array(
                'setting'  => 'themo_blog_index_layout_show_header',
                'operator' => '==',
                'value'    => 1,
            ),
            array(
                'setting'  => 'themo_blog_index_layout_show_header',
                'operator' => '==',
                'value'    => 'on',
            )
        )
    )
) );

// Blog : Blog Sidebar Position
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'themo_blog_index_layout_sidebar',
    'label'       => esc_html__( 'Blog Homepage Sidebar Position', 'uplands' ),
    'section'     => 'blog',
    'default'     => 'right',
    'priority'    => 10,
    'choices'     => array(

        'left'   => array(
            esc_attr__( 'Left', 'uplands' ),
        ),
        'full'   => array(
            esc_attr__( 'None', 'uplands' ),
        ),
        'right'   => array(
            esc_attr__( 'Right', 'uplands' ),
        ),

    ),
) );



// Blog. : Blog Single header switch
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_single_post_layout_show_header',
    'label'       => esc_html__( 'Blog Single Page Header', 'uplands' ),
    'description' => esc_html__( 'Show / Hide Page header for Blog Single', 'uplands' ),
    'section'     => 'blog',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Blog : Blog Single Header Align
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'themo_single_post_layout_header_float',
    'label'       => esc_html__( 'Blog Single Page Header Position ', 'uplands' ),
    'section'     => 'blog',
    'default'     => 'centered',
    'priority'    => 10,
    'choices'     => array(
        'left'   => array(
            esc_attr__( 'Left', 'uplands' ),
        ),
        'centered'   => array(
            esc_attr__( 'Centered', 'uplands' ),
        ),
        'right'   => array(
            esc_attr__( 'Right', 'uplands' ),
        ),

    ),
    'active_callback'  => array(
        array(
            array(
                'setting'  => 'themo_single_post_layout_show_header',
                'operator' => '==',
                'value'    => 1,
            ),
            array(
                'setting'  => 'themo_single_post_layout_show_header',
                'operator' => '==',
                'value'    => 'on',
            )
        )
    )
) );

// Blog : Blog Single Sidebar Position
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'themo_single_post_layout_sidebar',
    'label'       => esc_html__( 'Blog Single Sidebar Position', 'uplands' ),
    'section'     => 'blog',
    'default'     => 'right',
    'priority'    => 10,
    'choices'     => array(

        'left'   => array(
            esc_attr__( 'Left', 'uplands' ),
        ),
        'full'   => array(
            esc_attr__( 'None', 'uplands' ),
        ),
        'right'   => array(
            esc_attr__( 'Right', 'uplands' ),
        ),

    ),
) );


// Blog. : Default header switch
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_default_layout_show_header',
    'label'       => esc_html__( 'Archives Header', 'uplands' ),
    'description' => esc_html__( 'Show / Hide header for Archives, 404, Search', 'uplands' ),
    'section'     => 'blog',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Blog : Default Header Align
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'themo_default_layout_header_float',
    'label'       => esc_html__( 'Archives Header Position ', 'uplands' ),
    'section'     => 'blog',
    'default'     => 'centered',
    'priority'    => 10,
    'choices'     => array(

        'left'   => array(
            esc_attr__( 'Left', 'uplands' ),
        ),
        'centered'   => array(
            esc_attr__( 'Centered', 'uplands' ),
        ),
        'right'   => array(
            esc_attr__( 'Right', 'uplands' ),
        ),

    ),
    'active_callback'  => array(
        array(
            array(
                'setting'  => 'themo_default_layout_show_header',
                'operator' => '==',
                'value'    => 1,
            ),
            array(
                'setting'  => 'themo_default_layout_show_header',
                'operator' => '==',
                'value'    => 'on',
            )
        )
    )
) );

// Blog : Default Sidebar Position
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'themo_default_layout_sidebar',
    'label'       => esc_html__( 'Archives Sidebar Position', 'uplands' ),
    'section'     => 'blog',
    'default'     => 'right',
    'priority'    => 10,
    'choices'     => array(

        'left'   => array(
            esc_attr__( 'Left', 'uplands' ),
        ),
        'full'   => array(
            esc_attr__( 'None', 'uplands' ),
        ),
        'right'   => array(
            esc_attr__( 'Right', 'uplands' ),
        ),

    ),
) );

// Blog. : Category Masonry Style
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_blog_index_layout_masonry',
    'label'       => esc_html__( 'Masonry Style for Category Pages', 'uplands' ),
    'section'     => 'blog',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// WOOCOMMERCE SECTION
Uplands_Kirki::add_section( 'woo', array(
    'title'      => esc_attr__( 'Cart / WooCommerce', 'uplands' ),
    'priority'   => 2,
    'panel'          => 'themo_options',
    'capability' => 'edit_theme_options',
) );

// Woo : Cart Switch
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_woo_show_cart_icon',
    'label'       => esc_html__( 'Show Cart Icon', 'uplands' ),
    'description' => __( 'Show / Hide shopping cart icon in header', 'uplands' ),
    'section'     => 'woo',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Woo : Cart Icon
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'themo_woo_cart_icon',
    'label'       => esc_html__( 'Cart Icon', 'uplands' ),
    'description'        => esc_html__( 'Choose your shopping cart icon', 'uplands' ),
    'section'     => 'woo',
    'default'     => 'th-i-cart',
    'priority'    => 10,
    'choices'     => array(

        'th-i-cart'   => array(
            esc_attr__( 'Bag', 'uplands' ),
        ),
        'th-i-cart2'   => array(
            esc_attr__( 'Cart', 'uplands' ),
        ),
        'th-i-cart3'   => array(
            esc_attr__( 'Cart 2', 'uplands' ),
        ),
        'th-i-card'   => array(
            esc_attr__( 'Card', 'uplands' ),
        ),
        'th-i-card2'   => array(
            esc_attr__( 'Card 2', 'uplands' ),
        ),

    ),
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_woo_show_cart_icon',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_woo_show_cart_icon',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );

// Woo : Header Switch
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_woo_show_header',
    'label'       => esc_html__( 'Page Header', 'uplands' ),
    'description' => esc_html__( 'Show / Hide page header for woo categories, tags, taxonomies', 'uplands' ),
    'section'     => 'woo',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Woo : Header Align
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'themo_woo_header_float',
    'label'       => esc_html__( 'Align Page Header', 'uplands' ),
    'section'     => 'woo',
    'default'     => 'centered',
    'priority'    => 10,
    'choices'     => array(

        'left'   => array(
            esc_attr__( 'Left', 'uplands' ),
        ),
        'centered'   => array(
            esc_attr__( 'Centered', 'uplands' ),
        ),
        'right'   => array(
            esc_attr__( 'Right', 'uplands' ),
        ),
    ),
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_woo_show_header',
                'operator' => '==',
                'value'    => 1,
            ),
            array(
                'setting'  => 'themo_woo_show_header',
                'operator' => '==',
                'value'    => 'on',
            )
        )
    )
) );

// Woo : Sidebar Position
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'themo_woo_sidebar',
    'label'       => esc_html__( 'Sidebar Position for Woo categories', 'uplands' ),
    'section'     => 'woo',
    'default'     => 'right',
    'priority'    => 10,
    'choices'     => array(

        'left'   => array(
            esc_attr__( 'Left', 'uplands' ),
        ),
        'full'   => array(
            esc_attr__( 'None', 'uplands' ),
        ),
        'right'   => array(
            esc_attr__( 'Right', 'uplands' ),
        ),

    ),
) );

// SLIDER SECTION
Uplands_Kirki::add_section( 'slider', array(
    'title'      => esc_attr__( 'Slider', 'uplands' ),
    'priority'   => 2,
    'capability' => 'edit_theme_options',
    'panel'          => 'themo_options',
) );

// Slider : Autoplay
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_flex_autoplay',
    'label'       => esc_attr__( 'Auto Play', 'uplands' ),
    'description' => esc_attr__( 'Start slider automatically', 'uplands' ),
    'section'     => 'slider',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Slider : Animation
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio',
    'settings'    => 'themo_flex_animation',
    'label'       => esc_html__( 'Animation', 'uplands' ),
    'description'        => esc_html__( 'Controls the animation type, "fade" or "slide".', 'uplands' ),
    'section'     => 'slider',
    'default'     => 'fade',
    'priority'    => 10,
    'choices'     => array(
        'fade'   => array(
            esc_attr__( 'Fade', 'uplands' ),
        ),
        'slide' => array(
            esc_attr__( 'Slide', 'uplands' ),
        ),
    ),
) );

// Slider : Easing
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio',
    'settings'    => 'themo_flex_easing',
    'label'       => esc_html__( 'Easing', 'uplands' ),
    'description'        => esc_html__( 'Determines the easing method used in jQuery transitions.', 'uplands' ),
    'section'     => 'slider',
    'default'     => 'swing',
    'priority'    => 10,
    'choices'     => array(
        'swing'   => array(
            esc_attr__( 'Swing', 'uplands' ),
        ),
        'linear' => array(
            esc_attr__( 'Linear', 'uplands' ),
        ),
    ),
) );

// Slider : Animation Loop
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_flex_animationloop',
    'label'       => esc_attr__( 'Animation Loop', 'uplands' ),
    'description' => esc_attr__( 'Gives the slider a seamless infinite loop.', 'uplands' ),
    'section'     => 'slider',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Slider : Smooth Height
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_flex_smoothheight',
    'label'       => esc_attr__( 'Smooth Height', 'uplands' ),
    'description' => esc_attr__( 'Animate the height of the slider smoothly for slides of varying height.', 'uplands' ),
    'section'     => 'slider',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Slider : Slide Speed
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'slider',
    'settings'    => 'themo_flex_slideshowspeed',
    'label'       => esc_html__( 'Slideshow Speed', 'uplands' ),
    'description'        => esc_html__( 'Set the speed of the slideshow cycling, in milliseconds', 'uplands' ),
    'section'     => 'slider',
    'default'     => 4000,
    'choices'     => array(
        'min'  => '0',
        'max'  => '15000',
        'step' => '100',
    ),
) );

// Slider : Animation Speed
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'slider',
    'settings'    => 'themo_flex_animationspeed',
    'label'       => esc_html__( 'Animation Speed', 'uplands' ),
    'description' => esc_html__( 'Set the speed of animations, in milliseconds', 'uplands' ),
    'section'     => 'slider',
    'default'     => 550,
    'choices'     => array(
        'min'  => '0',
        'max'  => '1200',
        'step' => '50',
    ),
) );

// Slider : Randomize
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_flex_randomize',
    'label'       => esc_attr__( 'Randomize', 'uplands' ),
    'description' => esc_attr__( 'Randomize slide order, on load', 'uplands' ),
    'section'     => 'slider',
    'default'     => '0',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Slider : Puse on hover
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_flex_pauseonhover',
    'label'       => esc_attr__( 'Pause on Hover', 'uplands' ),
    'description' => esc_attr__( 'Pause the slideshow when hovering over slider, then resume when no longer hovering.', 'uplands' ),
    'section'     => 'slider',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Slider : Touch
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_flex_touch',
    'label'       => esc_attr__( 'Touch', 'uplands' ),
    'description' => esc_attr__( 'Allow touch swipe navigation of the slider on enabled devices.', 'uplands' ),
    'section'     => 'slider',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Slider : Dir Nav
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_flex_directionnav',
    'label'       => esc_attr__( 'Direction Nav', 'uplands' ),
    'description' => esc_attr__( 'Create previous/next arrow navigation.', 'uplands' ),
    'section'     => 'slider',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Slider : Paging Control
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_flex_controlNav',
    'label'       => esc_attr__( 'Paging Control', 'uplands' ),
    'description' => esc_attr__( 'Create navigation for paging control of each slide.', 'uplands' ),
    'section'     => 'slider',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// MISC. SECTION
Uplands_Kirki::add_section( 'misc', array(
    'title'      => esc_attr__( 'Misc.', 'uplands' ),
    'priority'   => 2,
    'panel'          => 'themo_options',
    'capability' => 'edit_theme_options',
) );

// Misc. : Rounded Buttons
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio',
    'settings'    => 'themo_button_style',
    'label'       => esc_html__( 'Button Style', 'uplands' ),
    'section'     => 'misc',
    'default'     => 'square',
    'priority'    => 10,
    'choices'     => array(
        'square'  => esc_attr__( 'Squared', 'uplands' ),
        'round'   => esc_attr__( 'Rounded', 'uplands' ),
    ),
    'output' => array(
        array(
            'element'  => '.simple-conversion form input[type=submit],.simple-conversion .with_frm_style input[type=submit],.search-form input',
            'property' => 'border-radius',
            'value_pattern' => ' 0',
            'suffix' => '!important',
            'exclude' => array('round'),
        ),
        array(
            'element'  => '.nav-tabs > li > a, .frm_forms form input[type=text], .frm_forms form input[type=email], .frm_forms form input[type=url], .frm_forms form input[type=password], .frm_forms form input[type=number], .frm_forms form input[type=tel], .frm_style_formidable-style.with_frm_style input[type=text], .frm_style_formidable-style.with_frm_style input[type=password], .frm_style_formidable-style.with_frm_style input[type=email], .frm_style_formidable-style.with_frm_style input[type=number], .frm_style_formidable-style.with_frm_style input[type=url], .frm_style_formidable-style.with_frm_style input[type=tel], .frm_style_formidable-style.with_frm_style input[type=file], .frm_style_formidable-style.with_frm_style input[type=search], .woocommerce form input[type=text], .woocommerce form input[type=password], .woocommerce form input[type=email], .woocommerce form input[type=number], .woocommerce form input[type=url], .woocommerce form input[type=tel], .woocommerce form input[type=file], .woocommerce form input[type=search], .select2-container--default .select2-selection--single, .woocommerce form textarea, .woocommerce .woocommerce-info, .woocommerce form.checkout_coupon, .woocommerce form.login, .woocommerce form.register',
            'property' => 'border-radius',
            'value_pattern' => ' 0',
            'exclude' => array('round'),
        ),
        array(
            'element'  => '.btn, .btn-cta, .btn-sm,.btn-group-sm > .btn, .btn-group-xs > .btn, .pager li > a,.pager li > span, .form-control, #respond input[type=submit], body .booked-modal button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce div.product form.cart .button, .search-form input, .search-submit, .th-accent, .headhesive--clone.banner[data-transparent-header=\'true\'] .th-accent, .elementor-widget-themo-info-card .th-info-card-wrap, .th-pkg-img img, .th-pkg-content, .th-pkg-info, .map-info, .mas-blog-post .post-inner, .mas-blog-post img, .flex-direction-nav a, .widget .tagcloud a, .woocommerce form select, .woocommerce-cart select, .woocommerce nav.woocommerce-pagination ul li',
            'property' => 'border-radius',
            'value_pattern' => ' 0',
            'exclude' => array('round'),
        ),
        array(
            'element'  => 'form input[type=submit],.with_frm_style .frm_submit input[type=submit],.with_frm_style .frm_submit input[type=button],.frm_form_submit_style, .with_frm_style.frm_login_form input[type=submit], .widget input[type=submit],.widget .frm_style_formidable-style.with_frm_style input[type=submit], .th-port-btn, body #booked-profile-page input[type=submit], body #booked-profile-page button, body div.booked-calendar input[type=submit], body div.booked-calendar button, body .booked-modal input[type=submit], body .booked-modal button,.th-widget-area form input[type=submit],.th-widget-area .with_frm_style .frm_submit input[type=submit],.th-widget-area .widget .frm_style_formidable-style.with_frm_style input[type=submit]',
            'property' => 'border-radius',
            'value_pattern' => ' 0',
            'exclude' => array('round'),
        ),
    ),
) );

// Misc : Content Preloader
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_preloader',
    'label'       => esc_html__( 'Content Preloader', 'uplands' ),
    'description'       => esc_html__( 'Enables preloader site wide.', 'uplands' ),
    'section'     => 'misc',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );


// Misc. : FBoxed mode vs full width
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_boxed_layout',
    'label'       => esc_html__( 'Boxed Layout', 'uplands' ),
    'section'     => 'misc',
    'default'     => '',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Misc. : Boxed mode BG Colour
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'color',
    'settings'    => 'themo_boxed_bg_color', //themo_boxed_layout_background
    'label'       => esc_attr__( 'Background Color', 'uplands' ),
    'section'     => 'misc',
    'default'     => '#FFF',
    'priority'    => 10,
    'choices'     => array(
        'alpha' => true,
    ),
    'output' => array(
        array(
            'element'  => 'body',
            'property' => 'background-color',
        ),

    ),
    'active_callback'  => array(
        array(
            array(
                'setting'  => 'themo_boxed_layout',
                'operator' => '==',
                'value'    => 1,
            ),
            array(
                'setting'  => 'themo_boxed_layout',
                'operator' => '==',
                'value'    => 'on',
            )
        )
    )

) );

// Misc. : Boxed mode BG Image
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'image',
    'settings'    => 'themo_boxed_bg_image',
    'label'       => esc_html__( 'Background Image', 'uplands' ),
    'section'     => 'misc',
    'default'     => '',
    'priority'    => 10,
    'output' => array(
        array(
            'element'  => 'body',
            'property' => 'background-image',
        ),
        array(
            'element'  => 'body',
            'property' => 'background-attachment',
            'value_pattern' => 'fixed',
        ),
        array(
            'element'  => 'body',
            'property' => 'background-size',
            'value_pattern' => 'cover',
        ),

    ),
    'active_callback'  => array(
        array(
            array(
                'setting'  => 'themo_boxed_layout',
                'operator' => '==',
                'value'    => 1,
            ),
            array(
                'setting'  => 'themo_boxed_layout',
                'operator' => '==',
                'value'    => 'on',
            )
        )
    )
) );

// Misc. : Enable Retina Find Replace script.
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_retinajs',
    'label'       => esc_html__( 'High-resolution/Retina Image Support', 'uplands' ),
    'description' => esc_html__( 'Automatically serve up high-resolution images to devices that support them.', 'uplands' ),
    'section'     => 'misc',
    'default'     => '',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Misc. : Retina Image Sizes Generator
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_retina_support',
    'label'       => esc_html__( 'High-resolution/Retina Image Generator', 'uplands' ),
    'description' => esc_html__( 'Automatically generate high-resolution/retina image sizes (@2x) when uploaded to your Media Library.', 'uplands' ),
    'section'     => 'misc',
    'default'     => '',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );


// Misc. : Custom Tour CPT Slug
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'     => 'text',
    'settings' => 'themo_portfolio_rewrite_slug',
    'label'       => esc_html__( 'Portfolio Custom Slug', 'uplands' ),
    'description'       => esc_html__( 'Optionally change the permalink slug for the Course Guide custom post type', 'uplands' ),
    'section'     => 'misc',
    'priority' => 10,
) );

// Misc. : Event header switch
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'tribe_events_layout_show_header',
    'label'       => esc_html__( 'Events Header', 'uplands' ),
    'description' => esc_html__( 'Show / Hide header for Events pages', 'uplands' ),
    'section'     => 'misc',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Misc. : Events Header Align
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'tribe_events_layout_header_float',
    'label'       => esc_html__( 'Events Header Position ', 'uplands' ),
    'section'     => 'misc',
    'default'     => 'centered',
    'priority'    => 10,
    'choices'     => array(

        'left'   => array(
            esc_attr__( 'Left', 'uplands' ),
        ),
        'centered'   => array(
            esc_attr__( 'Centered', 'uplands' ),
        ),
        'right'   => array(
            esc_attr__( 'Right', 'uplands' ),
        ),

    ),
    'active_callback'  => array(
        array(
            array(
                'setting'  => 'tribe_events_layout_show_header',
                'operator' => '==',
                'value'    => 1,
            ),
            array(
                'setting'  => 'tribe_events_layout_show_header',
                'operator' => '==',
                'value'    => 'on',
            )
        )
    )
) );

// Misc. : Events Sidebar Position
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'tribe_events_layout_sidebar',
    'label'       => esc_html__( 'Events Sidebar Position', 'uplands' ),
    'section'     => 'misc',
    'default'     => 'right',
    'priority'    => 10,
    'choices'     => array(

        'left'   => array(
            esc_attr__( 'Left', 'uplands' ),
        ),
        'full'   => array(
            esc_attr__( 'None', 'uplands' ),
        ),
        'right'   => array(
            esc_attr__( 'Right', 'uplands' ),
        ),

    ),
) );

// WIDGET SECTION
Uplands_Kirki::add_section( 'themo_widgets', array(
    'title'      => esc_attr__( 'Theme Widgets', 'uplands' ),
    'priority'   => 2,
    'panel'      => 'themo_options',
    'capability' => 'edit_theme_options',
) );


// Footer : Footer Logo (Widget)
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'image',
    'settings'    => 'themo_footer_logo',
    'label'       => esc_html__( 'Footer Logo', 'uplands' ),
    'description' => '<p>' . esc_html__( 'Upload the logo you would like to use in your footer widget.', 'uplands' ) . '</p>' ,
    'section'     => 'themo_widgets',
    'default'     => '',
    'priority'    => 10,
) );


// Footer : Footer Logo URL
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'     => 'text',
    'settings' =>  'themo_footer_logo_url',
    'label'       => esc_html__( 'Footer Logo Link', 'uplands' ),
    'description' => esc_html__( 'e.g. mailto:stay@themovation.com, /contact, http://google.com:', 'uplands' ),
    'section'     => 'themo_widgets',
    'priority' => 10,
) );


// Footer : Footer Logo URL
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'     => 'checkbox',
    'settings' =>  'themo_footer_logo_url_target',
    'label'       => esc_html__( 'Open Link in New Window', 'uplands' ),
    'section'     => 'themo_widgets',
    'priority' => 10,
) );

// Footer : Footer Social
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'repeater',
    'label'       => esc_html__( 'Social Media Accounts', 'uplands' ),
    'description'        => esc_html__( 'For use with the "Social Icons" Widget. Add your social media accounts here. Use any', 'uplands' ). ' Social icon (e.g.: fa fa-twitter). <a href="http://fontawesome.io/icons/" target="_blank">'.esc_html__( 'Full List Here', 'uplands' ).'</a>',
    'section'     => 'themo_widgets',
    'priority'    => 10,
    'row_label' => array(
        'type' => 'text',
        'value' => esc_attr__('Social Icon', 'uplands' ),
    ),
    'settings'    => 'themo_social_media_accounts',
    'default'     => array(
        array(
            'title' => esc_attr__( 'Facebook', 'uplands' ),
            'themo_social_font_icon'  => 'fa fa-facebook',
            'themo_social_url'  => 'https://www.facebook.com',
            'themo_social_url_target'  => 1,
        ),
        array(
            'title' => esc_attr__( 'Twitter', 'uplands' ),
            'themo_social_font_icon'  => 'fa fa-twitter',
            'themo_social_url'  => 'https://twitter.com',
            'themo_social_url_target'  => 1,
        ),
        array(
            'title' => esc_attr__( 'Instagram', 'uplands' ),
            'themo_social_font_icon'  => 'fa fa-instagram',
            'themo_social_url'  => '#',
            'themo_social_url_target'  => 1,
        ),

    ),
    'fields' => array(
        'title' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Name', 'uplands' ),
            'default'     => '',
        ),
        'themo_social_font_icon' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Social Icon', 'uplands' ),
            'default'     => '',
        ),
        'themo_social_url' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Social Link', 'uplands' ),
            'default'     => '',
        ),
        'themo_social_url_target' => array(
            'type'        => 'checkbox',
            'label'       => esc_attr__( 'Open Link in New Window', 'uplands' ),
            'default'     => '',
        ),
    )
) );

// Footer : Footer Payments Accepted
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'repeater',
    'label'       => esc_html__( 'Payments Accepted', 'uplands' ),
    'description' => esc_html__( 'For use with the "Payments Accepted" Widget. Add your accepted payments types here.', 'uplands' ),
    'section'     => 'themo_widgets',
    'priority'    => 10,
    'row_label' => array(
        'type' => 'text',
        'value' => esc_attr__('Payment Info', 'uplands' ),
    ),
    'settings'    => 'themo_payments_accepted',
    'default'     => array(
        array(
            'title' => esc_attr__( 'Visa', 'uplands' ),
            'themo_payments_accepted_logo'  => '',
            'themo_payment_url'  => 'https://visa.com',
            'themo_payment_url_target'  => 1,
        ),
        array(
            'title' => esc_attr__( 'PayPal', 'uplands' ),
            'themo_payments_accepted_logo'  => '',
            'themo_payment_url'  => 'https://paypal.com',
            'themo_payment_url_target'  => 1,
        ),
        array(
            'title' => esc_attr__( 'MasterCard', 'uplands' ),
            'themo_payments_accepted_logo'  => '',
            'themo_payment_url'  => 'https://mastercard.com',
            'themo_payment_url_target'  => 1,
        ),
    ),
    'fields' => array(
        'title' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Name', 'uplands' ),
            'default'     => '',
        ),
        'themo_payments_accepted_logo' => array(
            'type'        => 'image',
            'label'       => esc_attr__( 'Logo', 'uplands' ),
            'default'     => '',
        ),
        'themo_payment_url' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Link', 'uplands' ),
            'default'     => '',
        ),
        'themo_payment_url_target' => array(
            'type'        => 'checkbox',
            'label'       => esc_attr__( 'Open Link in New Window', 'uplands' ),
            'default'     => '',
        ),
    )
) );

// Footer : Footer Contact Details
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'repeater',
    'label'       => esc_html__( 'Contact Details', 'uplands' ),
    'description' => esc_html__( 'For use with the "Contact Info" Widget. Add your contact info here. Use any', 'uplands' ). ' <a href="http://fontawesome.io/icons/" target="_blank">Font Awesome</a> icon (e.g.: fa fa-twitter). <a href="http://fontawesome.io/icons/" target="_blank">'.esc_html__( 'Full List Here', 'uplands' ).'</a>',
    'section'     => 'themo_widgets',
    'priority'    => 10,
    'row_label' => array(
        'type' => 'text',
        'value' => esc_attr__('Contact Info', 'uplands' ),
    ),
    'settings'    => 'themo_contact_icons',
    'default'     => array(
        array(
            'title' => esc_attr__( 'contact@themovation.com', 'uplands' ),
            'themo_contact_icon'  => 'fa fa-envelope-open-o',
            'themo_contact_icon_url'  => 'mailto:contact@ourdomain.com',
            'themo_contact_icon_url_target'  => 1,
        ),
        array(
            'title' => esc_attr__( '1-800-222-4545', 'uplands' ),
            'themo_contact_icon'  => 'fa fa-mobile',
            'themo_contact_icon_url'  => 'tel:800-222-4545',
            'themo_contact_icon_url_target'  => 1,
        ),
        array(
            'title' => esc_attr__( 'Location', 'uplands' ),
            'themo_contact_icon'  => 'fa fa-map-o',
            'themo_contact_icon_url'  => '#',
            'themo_contact_icon_url_target'  => 0,
        ),

    ),
    'fields' => array(
        'title' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Name', 'uplands' ),
            'default'     => '',
        ),
        'themo_contact_icon' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Icon', 'uplands' ),
            'default'     => '',
        ),
        'themo_contact_icon_url' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Link', 'uplands' ),
            'default'     => '',
        ),
        'themo_contact_icon_url_target' => array(
            'type'        => 'checkbox',
            'label'       => esc_attr__( 'Open Link in New Window', 'uplands' ),
            'default'     => '',
        ),
    )
) );



// FOOTER SECTION
Uplands_Kirki::add_section( 'footer', array(
    'title'      => esc_attr__( 'Footer', 'uplands' ),
    'priority'   => 2,
    'panel'      => 'themo_options',
    'capability' => 'edit_theme_options',
) );



// Upper Footer : Widget Switch
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_footer_widget_switch',
    'label'       => esc_html__( 'Upper Footer', 'uplands' ),
    //'description' => esc_html__( 'Show / hide upper footer widgets area', 'uplands' ),
    'section'     => 'footer',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Footer : Footer Columns
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio',
    'settings'    => 'themo_footer_columns',
    'label'       => esc_html__( 'Upper Footer Columns', 'uplands' ),
    'section'     => 'footer',
    'default'     => '4',
    'priority'    => 10,
    'choices'     => array(
        '1'   => esc_attr__( '1 Column', 'uplands' ),
        '2' => esc_attr__( '2 Columns', 'uplands' ),
        '3'  => esc_attr__( '3 Columns', 'uplands' ),
        '4'  => esc_attr__( '4 Columns', 'uplands' ),
    ),
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_footer_widget_switch',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_footer_widget_switch',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );

// Footer : Title Colour
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'color',
    'settings'    => 'themo_footer_widget_title_colour',
    'label'       => __( 'Upper Footer Title Color', 'uplands' ),
    'section'     => 'footer',
    'default'     => '#FFFFFF',
    'output' => array(
        array(
            'element'  => '.th-upper-footer h1.widget-title, .th-upper-footer h2.widget-title, 
            .th-upper-footer h3.widget-title, .th-upper-footer h4.widget-title, .th-upper-footer h5.widget-title,
            .th-upper-footer h6.widget-title, .th-upper-footer a:hover',
            'property' => 'color',
            'exclude' => array( false )
        ),
    ),
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_footer_widget_switch',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_footer_widget_switch',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );

// Footer : Widget Title Underland
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_footer_remove_title_underline',
    'label'       => esc_html__( 'Upper Footer Title Underline', 'uplands' ),
    'section'     => 'footer',
    'default'     => '',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
    'output' => array(
        array(
            'element'  => '.footer .widget-title',
            'property' => 'border-bottom',
            'value_pattern' => 'none',
            'exclude' => array( true )
        ),
        array(
            'element'  => '.footer .widget-title',
            'property' => 'padding-bottom',
            'value_pattern' => '0px',
            'exclude' => array( true )
        ),
        array(
            'element'  => '.footer .widget-title, .footer h3.widget-title',
            'property' => 'padding-bottom',
            'value_pattern' => '0px',
            'exclude' => array( true ),
            'suffix' => '!important',
        ),
        array(
            'element'  => '.footer .widget-title, .footer h3.widget-title',
            'property' => 'margin-bottom',
            'value_pattern' => '18px',
            'exclude' => array( true )
        ),
        array(
            'element'  => '.footer .widget-title:after',
            'property' => 'display',
            'value_pattern' => 'none',
            'exclude' => array( true )
        ),
        //
    ),
    //padding-bottom: 20px
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_footer_widget_switch',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_footer_widget_switch',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );

// Footer : Text Colour
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'color',
    'settings'    => 'themo_footer_widget_border_colour',
    'label'       => __( 'Upper Footer Title Underline Color', 'uplands' ),
    'section'     => 'footer',
    'default'     => '#d2d2d2',
    'choices'     => array(
        'alpha' => true,
    ),
    'output' => array(
        array(
            'element'  => '.footer input[type=text], .footer input[type=email],
            .footer input[type=url], .footer input[type=password],
            .footer input[type=number], .footer input[type=tel],
            .footer textarea, .footer select',
            'property' => 'border-color',
            'exclude' => array( false ),
            'suffix' => '!important',
        ),
        array(
            'element'  => '.footer .meta-border, .footer ul li, .footer .widget ul li,
            .footer .widget-title,
            .footer .widget.widget_categories li a, .footer .widget.widget_pages li a, .footer .widget.widget_nav_menu li a',
            'property' => 'border-bottom-color',
            'exclude' => array( false )
        ),
        array(
            'element'  => '.footer .widget-title:after',
            'property' => 'background-color',
            'exclude' => array( false )
        ),
        //

    ),
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_footer_widget_switch',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_footer_widget_switch',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );

// Footer : Text Colour
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'color',
    'settings'    => 'themo_footer_widget_text_colour',
    'label'       => __( 'Upper Footer Text Color', 'uplands' ),
    'section'     => 'footer',
    'default'     => '#d2d2d2',
    'output' => array(
        array(
            'element'  => '.th-upper-footer p, .th-upper-footer a, .th-upper-footer ul li, .th-upper-footer ol li, .th-upper-footer .soc-widget i',
            'property' => 'color',
            'exclude' => array( false )
        ),
    ),
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_footer_widget_switch',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_footer_widget_switch',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );







// Footer : Background Colour
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'color',
    'settings'    => 'themo_footer_background_colour',
    'label'       => __( 'Upper Footer Background Color', 'uplands' ),
    'section'     => 'footer',
    'default'     => '#212E31',
    'choices'     => array(
        'alpha' => true,
    ),
    'output' => array(

        array(
            'element'  => '.th-upper-footer',
            'property' => 'background',
        ),

    ),
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_footer_widget_switch',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_footer_widget_switch',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );


// Footer 2 : Widget Switch
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_footer2_widget_switch',
    'label'       => esc_html__( 'Lower Footer', 'uplands' ),
    //'description' => esc_html__( 'Show / hide lower footer widgets area', 'uplands' ),
    'section'     => 'footer',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Footer : Widget Title Underland
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_footer2_divder',
    'label'       => esc_html__( 'Section Divider', 'uplands' ),
    //'description' => esc_html__( 'Show / Hide section divider', 'uplands' ),
    'section'     => 'footer',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
    'output' => array(
        array(
            'element'  => '.th-lower-footer .th-separator',
            'property' => 'border-top',
            'value_pattern' => '1px solid #dcdcdc',
            'exclude' => array( false )
        ),
        array(
            'element'  => '.th-lower-footer .th-widget-area',
            'property' => 'padding-top',
            'value_pattern' => '50px',
            'exclude' => array( false )
        ),
        array(
            'element'  => '.th-lower-footer',
            'property' => 'padding-top',
            'value_pattern' => '0px',
            'exclude' => array( false ),
            'suffix' => '!important'
        ),
    ),
    //padding-bottom: 20px
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_footer2_widget_switch',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_footer2_widget_switch',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );

// Lower Footer : Text Colour
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'color',
    'settings'    => 'themo_footer2_divider_colour',
    'label'       => __( 'Section Divider Color', 'uplands' ),
    'section'     => 'footer',
    'default'     => '#888888',
    'choices'     => array(
        'alpha' => true,
    ),
    'output' => array(
        array(
            'element'  => '.th-lower-footer .th-separator',
            'property' => 'border-top-color',
            'exclude' => array( false )
        ),

    ),
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_footer_widget_switch',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_footer_widget_switch',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );

// Footer 2 : Footer Columns
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'radio',
    'settings'    => 'themo_footer2_columns',
    'label'       => esc_html__( 'Lower Footer Columns', 'uplands' ),
    'section'     => 'footer',
    'default'     => '2',
    'priority'    => 10,
    'choices'     => array(
        '1'   => esc_attr__( '1 Column', 'uplands' ),
        '2' => esc_attr__( '2 Columns', 'uplands' ),
        '3'  => esc_attr__( '3 Columns', 'uplands' ),
        '4'  => esc_attr__( '4 Columns', 'uplands' ),
    ),
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_footer2_widget_switch',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_footer2_widget_switch',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );

// Footer : Title Colour
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'color',
    'settings'    => 'themo_footer2_widget_title_colour',
    'label'       => __( 'Lower Footer Title Color', 'uplands' ),
    'section'     => 'footer',
    'default'     => '#FFFFFF',
    'output' => array(
        array(
            'element'  => '.th-lower-footer h1.widget-title, .th-lower-footer h2.widget-title, .th-lower-footer h3.widget-title, .th-lower-footer h4.widget-title,
             .th-lower-footer h5.widget-title, .th-lower-footer h6.widget-title, .th-lower-footer a:hover',
            'property' => 'color',
            'exclude' => array( false )
        ),
    ),
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_footer2_widget_switch',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_footer2_widget_switch',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );

// Footer : Text Colour
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'color',
    'settings'    => 'themo_footer2_widget_text_colour',
    'label'       => __( 'Lower Footer Text Color', 'uplands' ),
    'section'     => 'footer',
    'default'     => '#d2d2d2',
    'output' => array(
        array(
            'element'  => '.th-lower-footer p, .th-lower-footer a, .th-lower-footer ul li, .th-lower-footer ol li, .th-lower-footer .soc-widget i',
            'property' => 'color',
            'exclude' => array( false )
        ),
    ),
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_footer2_widget_switch',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_footer2_widget_switch',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );



// Footer : Background Colour
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'color',
    'settings'    => 'themo_footer2_background_colour',
    'label'       => __( 'Lower Footer Background Color', 'uplands' ),
    'section'     => 'footer',
    'default'     => '#212E31',
    'choices'     => array(
        'alpha' => true,
    ),
    'output' => array(

        array(
            'element'  => '.th-lower-footer',
            'property' => 'background',
        ),

    ),
    'active_callback'    => array(
        array(
            array(
                'setting'  => 'themo_footer2_widget_switch',
                'operator' => '==',
                'value'    => true,
            ),
            array(
                'setting'  => 'themo_footer2_widget_switch',
                'operator' => '==',
                'value'    => 'on',
            )
        ),
    ),
) );

// START PLUGINS SECTION
Uplands_Kirki::add_section('plugins', array(
    'title' => esc_attr__('Plugins', 'uplands'),
    'priority' => 2,
    'panel' => 'themo_options',
    'capability' => 'edit_theme_options',
));

Uplands_Kirki::add_field('uplands_theme', array(
    'type' => 'custom',
    'settings' => 'themo_plugins_heading',
    'label' => esc_html__('Enabling bundled plugins', 'uplands'),
    'section' => 'plugins',
    'priority' => 10,
    'default' => '<div class="th-theme-support">' . __('1 - Enable any of the listed bundled plugins.</p></p>2 - Publish your changes</p><p>3 - Follow the admin notice instructions on the WordPress dashboard to install.</p>', 'uplands') . '</div>',
));

// Plugins : WooCommerce
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_tgmpa_booked',
    'label'       => esc_html__( 'Booked', 'uplands' ),
    'section'     => 'plugins',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Plugins : WooCommerce
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_tgmpa_woocommerce',
    'label'       => esc_html__( 'WooCommerce', 'uplands' ),
    'section'     => 'plugins',
    'default'     => '',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Plugins : Master Slider Pro
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_tgmpa_masterslider',
    'label'       => esc_html__( 'Master Slider Pro', 'uplands' ),
    'section'     => 'plugins',
    'default'     => '',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Plugins : Formidable
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_tgmpa_formidable',
    'label'       => esc_html__( 'Formidable Forms', 'uplands' ),
    'section'     => 'plugins',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Plugins : Simple Page Ordering
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_tgmpa_simple_page_ordering',
    'label'       => esc_html__( 'Simple Page Ordering', 'uplands' ),
    'description' => esc_html__( 'Recommended for drag and drop sort ordering of custom post types.', 'uplands' ),
    'section'     => 'plugins',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Plugins : Widget Logic
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_tgmpa_widget_logic',
    'label'       => esc_html__( 'Widget Logic', 'uplands' ),
    'description' => esc_html__( 'Recommended for displaying/hiding widgets on specific pages and areas.', 'uplands' ),
    'section'     => 'plugins',
    'default'     => 'on',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'uplands' ),
        'off' => esc_attr__( 'Disable', 'uplands' ),
    ),
) );

// Plugins : Elementor Header & Footer
Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'        => 'switch',
    'settings'    => 'themo_tgmpa_header_footer',
    'label'       => esc_html__( '(BETA) Elementor Header & Footer', 'bellevue' ),
    'description' => esc_html__( 'Customize your header and footer. ', 'bellevue' ),
    'section'     => 'plugins',
    'default'     => '',
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'bellevue' ),
        'off' => esc_attr__( 'Disable', 'bellevue' ),
    ),
) );

// END PLUGINS SECTION



if ( defined('ENVATO_HOSTED_SITE') ) {
    // this is an envato hosted site so Skip
}else {
// SUPPORT SECTION
    Uplands_Kirki::add_section('support', array(
        'title' => esc_attr__('Theme Support', 'uplands'),
        'priority' => 2,
        'panel' => 'themo_options',
        'capability' => 'edit_theme_options',
    ));

// Support : Custom
Uplands_Kirki::add_field('uplands_theme', array(
        'type' => 'custom',
        'settings' => 'themo_help_heading',
        'label' => esc_html__('Yes, we offer support', 'uplands'),
        'section' => 'support',
        'priority' => 10,
        'default' => '<div class="th-theme-support">' . __('We want to make sure this is a great experience for you.</p> <p > If you have any questions, concerns or comments please contact us through the links below.', 'uplands') . '</div>',
    ));

Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'     => 'custom',
    'settings' => 'themo_help_support_includes',
    'label'       => esc_html__( 'Theme support includes', 'uplands' ),
    'section'     => 'support',
    'priority' => 10,
    'default'     => '<div class="th-theme-support">' . __( '<ul><li class="dashicons-before dashicons-yes">Availability of the author to answer questions</li><li class="dashicons-before dashicons-yes">Answering technical questions about item\'s features</li><li class="dashicons-before dashicons-yes">Assistance with reported bugs and issues</li><li class="dashicons-before dashicons-yes">Help with included 3rd party assets</li></ul>', 'uplands' ) . '</div>',
) );

Uplands_Kirki::add_field( 'uplands_theme', array(
    'type'     => 'custom',
    'settings' => 'themo_help_support_not_includes',
    'label'       => esc_html__( 'However, theme support does not include:', 'uplands' ),
    'section'     => 'support',
    'priority' => 10,
    'default'     => '<div class="th-theme-support">' . __( '<ul><li class="dashicons-before dashicons-no">Customization services</li><li class="dashicons-before dashicons-no">Installation services</li></ul>', 'uplands' ) . '</div>',
) );

    Uplands_Kirki::add_field('uplands_theme', array(
        'type' => 'custom',
        'settings' => 'themo_help_support_links',
        'label' => esc_html__('Where to get help', 'uplands'),
        'section' => 'support',
        'priority' => 10,
        'default' => '<div class="th-theme-support">' . sprintf(__('<p class="dashicons-before dashicons-admin-links"> Check out our <a href="%1$s" target="_blank">helpful guides</a>, <a href="%2$s" target="_blank">online documentation</a> and <a href="%3$s" target="_blank">rockstar support</a>.</p>', 'uplands'), 'http://themovation.helpscoutdocs.com/', 'http://themovation.helpscoutdocs.com/', 'https://themovation.ticksy.com/') . '</div>',
    ));
}