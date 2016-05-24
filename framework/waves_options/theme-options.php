<?php
/* Admin OT Style */
add_action( 'admin_enqueue_scripts', 'waves_admin_ot_style');
function waves_admin_ot_style(){
    wp_enqueue_style('waves-admin-style',WAVES_FW_DIR.'assets/css/admin-waves-ot-style.css');
    wp_enqueue_script('waves-metabox',   WAVES_FW_DIR.'assets/js/admin-waves-metabox.js');
}

/**
 * Initialize the custom Theme Options.
 */
add_action('init', 'waves_theme_options');

/**
 * Build the custom settings & update OptionTree.
 *
 * @return    void
 * @since     2.0
 */
function waves_theme_options() {
    /* OptionTree is not loaded yet, or this is not an admin request */
    if(!function_exists('ot_settings_id')||!is_admin()){return false;}
    /**
     * Get a copy of the saved settings array. 
     */
    $saved_settings=get_option(ot_settings_id(),array());
    /**
     * Custom settings array that will eventually be 
     * passes to the OptionTree Settings API Class.
     */
    
    
    /* General Options - general_options */
    $custom_settings['sections'][] = array(
        'id' => 'general_options',
        'title' => esc_html__('General Options', 'ninetysix')
    );
    $custom_settings['settings'][] = array(
        'id' => 'layout',
        'label' => esc_html__('Main Theme Layout', 'ninetysix'),
        'std' => 'full',
        'type' => 'select',
        'desc' => esc_html__('Only the Content will changed', 'ninetysix'),
        'section' => 'general_options',
        'choices' => array(
            array(
                'value' => 'full',
                'label' => esc_html__('Fullwidth', 'ninetysix'),
            ),
            array(
                'value' => 'boxed',
                'label' => esc_html__('Boxed', 'ninetysix'),
            ),
        )
    );
    $custom_settings['settings'][] = array(
        'id' => 'smooth_scroll',
        'label' => esc_html__('Smooth Scroll', 'ninetysix'),
        'std' => 'off',
        'type' => 'on-off',
        'section' => 'general_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'preloader',
        'label' => esc_html__('Preloader', 'ninetysix'),
        'std' => 'none',
        'type' => 'select',
        'desc' => 'If you enabled this then Ajax Animation and preloader will work on your website and ',
        'section' => 'general_options',
        'choices' => array(
            array(
                'value' => 'none',
                'label' => esc_html__('None', 'ninetysix'),
            ),
            array(
                'value' => 'fade-#',
                'label' => esc_html__('FADE', 'ninetysix'),
                'src' => ''
            ),
            array(
                'value' => 'fade-#-down-sm',
                'label' => esc_html__('FADE DOWN SMALL', 'ninetysix'),
                'src' => ''
            ),
            array(
                'value' => 'fade-#-down',
                'label' => esc_html__('FADE DOWN', 'ninetysix'),
                'src' => ''
            ),
            array(
                'value' => 'fade-#-down-lg',
                'label' => esc_html__('FADE DOWN LARGE', 'ninetysix'),
                'src' => ''
            ),
            array(
                'value' => 'fade-#-up-sm',
                'label' => esc_html__('FADE UP SMALL', 'ninetysix'),
                'src' => ''
            ),
            array(
                'value' => 'fade-#-up',
                'label' => esc_html__('FADE UP', 'ninetysix'),
                'src' => ''
            ),
            array(
                'value' => 'fade-#-up-lg',
                'label' => esc_html__('FADE UP LARGE', 'ninetysix'),
                'src' => ''
            ),
            array(
                'value' => 'fade-#-left-sm',
                'label' => esc_html__('FADE LEFT SMALL', 'ninetysix'),
                'src' => ''
            ),
            array(
                'value' => 'fade-#-left',
                'label' => esc_html__('FADE LEFT', 'ninetysix'),
                'src' => ''
            ),
            array(
                'value' => 'fade-#-left-lg',
                'label' => esc_html__('FADE LEFT LARGE', 'ninetysix'),
                'src' => ''
            ),
            array(
                'value' => 'fade-#-right-sm',
                'label' => esc_html__('FADE RIGHT SMALL', 'ninetysix'),
                'src' => ''
            ),
            array(
                'value' => 'fade-#-right',
                'label' => esc_html__('FADE RIGHT', 'ninetysix'),
                'src' => ''
            ),
            array(
                'value' => 'fade-#-right-lg',
                'label' => esc_html__('FADE RIGHT LARGE', 'ninetysix'),
                'src' => ''
            ),
        )
    );
    $custom_settings['settings'][] = array(
                'id' => 'custom_css',
                'label' => esc_html__('Custom CSS', 'ninetysix'),
                'desc' => esc_html__('Custom CSS section will give you able to insert your own CSS rules to apply on NinetySix theme.', 'ninetysix'),
                'std' => '',
                'type' => 'css',
                'section' => 'general_options',
                'rows' => '15'
    );
    
    /* Logo & Favicon - logo_options */
    $custom_settings['sections'][] = array(
        'id' => 'logo_options',
        'title' => esc_html__('Logo & Favicon', 'ninetysix')
    );
    $custom_settings['settings'][] = array(
        'id' => 'logo',
        'label' => esc_html__('Logo Image', 'ninetysix'),
        'std' => get_template_directory_uri() . '/assets/img/logo.png',
        'type' => 'upload',
        'section' => 'logo_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'logo_light',
        'label' => esc_html__('Light Logo Image', 'ninetysix'),
        'std' => get_template_directory_uri() . '/assets/img/logo2.png',
        'type' => 'upload',
        'section' => 'logo_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'logo2x',
        'label' => esc_html__('Retina Logo Image', 'ninetysix'),
        'desc' => esc_html__('2x logo size, for screens with high DPI.', 'ninetysix'),
        'type' => 'upload',
        'section' => 'logo_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'logo2x_light',
        'label' => esc_html__('Retina Light Logo Image', 'ninetysix'),
        'desc' => esc_html__('2x logo size, for screens with high DPI.', 'ninetysix'),
        'type' => 'upload',
        'section' => 'logo_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'fav_icon',
        'label' => esc_html__('Fav Icon', 'ninetysix'),
        'std' => get_template_directory_uri() . '/assets/img/favicon.ico',
        'type' => 'upload',
        'section' => 'logo_options',
    );
    
    /* Header Options - header_options */
    $custom_settings['sections'][] = array(
        'id' => 'header_options',
        'title' => esc_html__('Header & Footer', 'ninetysix')
    );
    $custom_settings['settings'][] = array(
        'id' => 'header',
        'label' => esc_html__('Choose Header Type', 'ninetysix'),
        'std' => 'header-normal',
        'type' => 'select',
        'section' => 'header_options',
        'choices' => array(
            array(
                'value' => 'header-normal',
                'label' => esc_html__('Normal', 'ninetysix'),
            ),
            array(
                'value' => 'header-logo-center',
                'label' => esc_html__('Logo Center', 'ninetysix'),
            ),
            array(
                'value' => 'header-left-side',
                'label' => esc_html__('Left Side', 'ninetysix'),
            ),
        )
    );
    $custom_settings['settings'][] = array(
        'id' => 'header_layout',
        'label' => esc_html__('Header & Footer Content Layout', 'ninetysix'),
        'std' => 'boxed',
        'type' => 'select',
        'desc' => esc_html__('Only the Content will changed', 'ninetysix'),
        'section' => 'header_options',
        'choices' => array(
            array(
                'value' => 'boxed',
                'label' => esc_html__('Boxed', 'ninetysix'),
            ),
            array(
                'value' => 'full',
                'label' => esc_html__('Full', 'ninetysix'),
            ),
        )
    );
    
    $custom_settings['settings'][] = array(
        'id' => 'header_color',
        'label' => esc_html__('Header & Footer Color Scheme', 'ninetysix'),
        'std' => 'header-light',
        'type' => 'select',
        'desc' => esc_html__('If you chosen the Light then Header & Footer Layout colors will be White and other text are come from Typography options.', 'ninetysix'),
        'section' => 'header_options',
        'choices' => array(
            array(
                'value' => 'header-light',
                'label' => esc_html__('Light', 'ninetysix'),
            ),
            array(
                'value' => 'header-dark',
                'label' => esc_html__('Dark', 'ninetysix'),
            ),
        )
    );
    $custom_settings['settings'][] = array(
        'id' => 'footer_layout',
        'label' => esc_html__('Footer Widget Layout', 'ninetysix'),
        'std' => '6-6',
        'type' => 'select',
        'desc' => 'You can insert Widgets on Appearence -> Widget section.',
        'section' => 'header_options',
        'choices' => array(
            array(
                'value' => 'none',
                'label' => esc_html__('None', 'ninetysix'),
            ),
            array(
                'value' => '3-3-3-3',
                'label' => esc_html__('4 columns', 'ninetysix'),
                'src' => ''
            ),
            array(
                'value' => '4-4-4',
                'label' => esc_html__('3 columns', 'ninetysix'),
                'src' => ''
            ),
            array(
                'value' => '6-6',
                'label' => esc_html__('2 columns', 'ninetysix'),
                'src' => ''
            ),
            array(
                'value' => '12',
                'label' => esc_html__('1 column', 'ninetysix'),
                'src' => ''
            ),
        )
    );
    $custom_settings['settings'][] = array(
        'id' => 'search_on_header',
        'label' => esc_html__('Search on Header', 'ninetysix'),
        'std' => 'on',
        'type' => 'on-off',
        'desc' => 'Simple Search icon has displayed and you can disable it.',
        'section' => 'header_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'wishlist_on_header',
        'label' => esc_html__('Wishlist on Header', 'ninetysix'),
        'std' => 'on',
        'type' => 'on-off',
        'desc' => 'Wishlist is Widget and it is simple plugin',
        'section' => 'header_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'cart_on_header',
        'label' => esc_html__('Cart on Header', 'ninetysix'),
        'std' => 'on',
        'type' => 'on-off',
        'desc' => 'Woocommerce Cart Function',
        'section' => 'header_options',
    );
    
    /* Typography Options - typography_options */
    $custom_settings['sections'][] = array(
        'id' => 'typography_options',
        'title' => esc_html__('Typography Options', 'ninetysix')
    );
    $custom_settings['settings'][] = array(
        'id' => 'waves_theme_fonts',
        'label' => esc_html__('Theme Fonts', 'ninetysix'),
        'std' => array(
            array(
                'family' => 'abel',
                'variants' => array('regular'),
                'subsets' => array('latin')
            )
        ),
        'type' => 'google-fonts',
        'section' => 'typography_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'body_typography',
        'label' => esc_html__('Body Typography', 'ninetysix'),
        'std' => array(
            'font-color' => '#888888',
            'font-family' => 'abel',
            'font-size' => '16px'
        ),
        'type' => 'typography',
        'section' => 'typography_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'heading_typography',
        'label' => esc_html__('Heading Typography', 'ninetysix'),
        'std' => array(
            'font-color' => '#151515',
            'font-family' => 'abel'
        ),
        'type' => 'typography',
        'section' => 'typography_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'heading_h1',
        'label' => esc_html__('H1 font size', 'ninetysix'),
        'std' => array(
            'font-size' => '30px'
        ),
        'type' => 'typography',
        'section' => 'typography_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'heading_h2',
        'label' => esc_html__('H2 font size', 'ninetysix'),
        'std' => array(
            'font-size' => '24px'
        ),
        'type' => 'typography',
        'section' => 'typography_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'heading_h3',
        'label' => esc_html__('H3 font size', 'ninetysix'),
        'std' => array(
            'font-size' => '18px'
        ),
        'type' => 'typography',
        'section' => 'typography_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'heading_h4',
        'label' => esc_html__('H4 font size', 'ninetysix'),
        'std' => array(
            'font-size' => '16px'
        ),
        'type' => 'typography',
        'section' => 'typography_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'heading_h5',
        'label' => esc_html__('H5 font size', 'ninetysix'),
        'std' => array(
            'font-size' => '14px'
        ),
        'type' => 'typography',
        'section' => 'typography_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'heading_h6',
        'label' => esc_html__('H6 font size', 'ninetysix'),
        'std' => array(
            'font-size' => '12px'
        ),
        'type' => 'typography',
        'section' => 'typography_options',
    );


    /* Blog Options - post_options */
    $custom_settings['sections'][] = array(
        'id' => 'blog_options',
        'title' => esc_html__('Blog Options', 'ninetysix')
    );
    $custom_settings['settings'][] = array(
        'id' => 'blog_layout',
        'label' => esc_html__('Blog layout?', 'ninetysix'),
        'std' => 'simple-side',
        'type' => 'select',
        'section' => 'blog_options',
        'choices' => array(
            array(
                'value' => 'simple-side',
                'label' => esc_html__('Simple with sidebar', 'ninetysix'),
            ),
            array(
                'value' => 'simple',
                'label' => esc_html__('Simple without sidebar', 'ninetysix'),
            ),
            array(
                'value' => 'grid-side',
                'label' => esc_html__('Grid with sidebar', 'ninetysix'),
            ),
            array(
                'value' => 'grid',
                'label' => esc_html__('Grid without sidebar', 'ninetysix'),
            ),
        )
    );
    $custom_settings['settings'][] = array(
        'id' => 'excerpt_count',
        'label' => esc_html__('Excerpt word lenght', 'ninetysix'),
        'std' => '20',
        'type' => 'text',
        'desc' => esc_html__( 'Only integer value.', 'ninetysix' ),
        'section' => 'blog_options',
        'condition'   => 'blog_layout:contains(grid)'
    );
    $custom_settings['settings'][] = array(
        'id' => 'more_text',
        'label' => esc_html__('Read More text', 'ninetysix'),
        'std' => 'More',
        'type' => 'text',
        'section' => 'blog_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'pagination',
        'label' => esc_html__('Pagination?', 'ninetysix'),
        'std' => 'simple',
        'type' => 'select',
        'section' => 'blog_options',
        'choices' => array(
            array(
                'value' => 'simple',
                'label' => esc_html__('Simple', 'ninetysix'),
            ),
            array(
                'value' => 'infinite',
                'label' => esc_html__('Infinite', 'ninetysix'),
            ),
        )
    );
    
    /* Post Options - post_options */
    $custom_settings['sections'][] = array(
        'id' => 'post_options',
        'title' => esc_html__('Post Options', 'ninetysix')
    );
    $custom_settings['settings'][] = array(
        'id' => 'single_layout',
        'label' => esc_html__('Post layout?', 'ninetysix'),
        'std' => 'right',
        'type' => 'select',
        'section' => 'post_options',
        'choices' => array(
            array(
                'value' => 'with-sidebar',
                'label' => esc_html__('With Sidebar', 'ninetysix'),
            ),
            array(
                'value' => 'full-width',
                'label' => esc_html__('Full width', 'ninetysix'),
            ),
        )
    );
    $custom_settings['settings'][] = array(
        'id' => 'feature_show',
        'label' => esc_html__('Featured media show on single?', 'ninetysix'),
        'std' => 'on',
        'type' => 'on-off',
        'section' => 'post_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'post_share',
        'label' => esc_html__('Post social share on single?', 'ninetysix'),
        'std' => 'on',
        'type' => 'on-off',
        'section' => 'post_options',
    );
    /* Portfolio Options - portfolio_options */
    $custom_settings['sections'][] = array(
        'id' => 'portfolio_options',
        'title' => esc_html__('Portfolio Options', 'ninetysix')
    );
    $custom_settings['settings'][] = array(
        'id' => 'portfolio_slug',
        'label' => esc_html__('Portfolio Slug', 'ninetysix'),
        'std' => 'portfolio',
        'type' => 'text',
        'section' => 'portfolio_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'portfolio_layout',
        'label' => esc_html__('Single portfolio layout?', 'ninetysix'),
        'std' => 'right',
        'type' => 'select',
        'section' => 'portfolio_options',
        'choices' => array(
            array(
                'value' => 'with-sidebar',
                'label' => esc_html__('2 columns', 'ninetysix'),
            ),
            array(
                'value' => 'full-width',
                'label' => esc_html__('1 column', 'ninetysix'),
            ),
        )
    );
    $custom_settings['settings'][] = array(
        'id' => 'portfolio_page',
        'label' => esc_html__('Select Portfolio Page', 'ninetysix'),
        'std' => '',
        'type' => 'page-select',
        'section' => 'portfolio_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'portfolio_desc',
        'label' => esc_html__('Description text', 'ninetysix'),
        'std' => 'Description',
        'type' => 'text',
        'section' => 'portfolio_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'portfolio_button',
        'label' => esc_html__('Button text', 'ninetysix'),
        'std' => 'Launch Project',
        'type' => 'text',
        'section' => 'portfolio_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'portfolio_client',
        'label' => esc_html__('Client text', 'ninetysix'),
        'std' => 'Client',
        'type' => 'text',
        'section' => 'portfolio_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'portfolio_cat',
        'label' => esc_html__('Categories text', 'ninetysix'),
        'std' => 'Categories',
        'type' => 'text',
        'section' => 'portfolio_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'portfolio_date',
        'label' => esc_html__('Date text', 'ninetysix'),
        'std' => 'Date',
        'type' => 'text',
        'section' => 'portfolio_options',
    );
    $custom_settings['settings'][] = array(
        'id' => 'portfolio_share',
        'label' => esc_html__('Share text', 'ninetysix'),
        'std' => 'Share',
        'type' => 'text',
        'section' => 'portfolio_options',
    );
    
    /* Woocommerce Options - woocommerce_options */
    if (waves_woocommerce()){
        $custom_settings['sections'][] = array(
            'id' => 'woocommerce_options',
            'title' => esc_html__('Woocommerce', 'ninetysix')
        );
        $custom_settings['settings'][] = array(
            'id' => 'woocommerce_layout',
            'label' => esc_html__('Shop page layout?', 'ninetysix'),
            'std' => '3-columns',
            'type' => 'select',
            'section' => 'woocommerce_options',
            'choices' => array(
                array(
                    'value' => '3-columns',
                    'label' => esc_html__('3 columns', 'ninetysix'),
                ),
                array(
                    'value' => '4-columns',
                    'label' => esc_html__('4 columns', 'ninetysix'),
                ),
            )
        );
        $custom_settings['settings'][] = array(
            'id' => 'woocommerce_single',
            'label' => esc_html__('Shop single layout?', 'ninetysix'),
            'std' => 'layout-1',
            'type' => 'select',
            'section' => 'woocommerce_options',
            'choices' => array(
                array(
                    'value' => 'layout-1',
                    'label' => esc_html__('Layout 1', 'ninetysix'),
                ),
                array(
                    'value' => 'layout-2',
                    'label' => esc_html__('Layout 2', 'ninetysix'),
                ),
            )
        );
        $custom_settings['settings'][] = array(
            'id' => 'woo_per_page',
            'label' => esc_html__('Products per page', 'ninetysix'),
            'std' => '',
            'type' => 'text',
            'section' => 'woocommerce_options',
        );
        $custom_settings['settings'][] = array(
            'id' => 'woo_breadcrumb',
            'label' => esc_html__('Breadcrumb on product single?', 'ninetysix'),
            'std' => 'on',
            'type' => 'on-off',
            'section' => 'woocommerce_options',
        );
    }

    /* allow settings to be filtered before saving */
    $custom_settings = apply_filters(ot_settings_id() . '_args', $custom_settings);

    /* settings are not the same update the DB */
    if ($saved_settings !== $custom_settings) {
        update_option(ot_settings_id(), $custom_settings);
    }

    /* Lets OptionTree know the UI Builder is being overridden */
    global $ot_has_custom_theme_options;
    $ot_has_custom_theme_options = true;
}

add_filter('ot_recognized_typography_fields', 'waves_ot_typo', 10, 2);
function waves_ot_typo($args, $field_id){
    if($field_id == 'body_typography'){
        return array('font-color', 'font-family', 'font-size');
    } elseif($field_id == 'heading_typography'){
        return array('font-color', 'font-family');
    }
    return array('font-size');
}
