<?php

/**
 * Initialize the custom Meta Boxes. 
 */
add_action('admin_init', 'waves_page_options');

/**
 * Meta Boxes demo code.
 *
 * You can find all the available option types in theme-options.php.
 *
 * @return    void
 * @since     2.3.0
 */
function waves_page_options() {
    global $wpdb;
    /**
     * Create a custom meta boxes array that we pass to 
     * the OptionTree Meta Box API Class.
     */
    $feature_area = array(
        array(
            'value' => '',
            'label' => esc_html__('Title', 'ninetysix'),
        ),
        array(
            'value' => 'slider',
            'label' => esc_html__('Slider', 'ninetysix'),
        ),
        array(
            'value' => 'embed',
            'label' => esc_html__('Google Map', 'ninetysix'),
        ),
        array(
            'value' => 'image',
            'label' => esc_html__('Featured Image', 'ninetysix'),
        ),
        array(
            'value' => 'none',
            'label' => esc_html__('None', 'ninetysix'),
        ),
    );
       
    $slider = array(array('value'=>'','label'=>'None'));
    if ( defined('MSWP_AVERTA_VERSION') ) {
        $masters = get_mastersliders();
    }        
    $layer_table = $wpdb->prefix . "layerslider";
    if($wpdb->get_results($wpdb->prepare( "SHOW TABLES LIKE %s", $layer_table ))){
        $layers = $wpdb->get_results($wpdb->prepare( "SELECT * FROM $layer_table
                                        WHERE flag_hidden = %s AND flag_deleted = %s
                                        ORDER BY date_c ASC LIMIT 100", '0', '0' ));
    }
    $revo_table = $wpdb->prefix . "revslider_sliders";
    if($wpdb->get_results($wpdb->prepare( "SHOW TABLES LIKE %s", $revo_table ))){
        $revos = $wpdb->get_results($wpdb->prepare( "SELECT * FROM $revo_table WHERE id <> %s",''));
    }
    
    
    if(!empty($masters)) {
            foreach($masters as $key => $item) {
                $name = empty($item['title']) ? ('Unnamed('.$item['ID'].')') : $item['title'];
                $slider[] = array( 'value' => esc_attr('[masterslider id=\''.$item['ID'].'\']'), 'label' => esc_html($name).' (master)');
            }
    }
    if(!empty($layers)) {
            foreach($layers as $key => $item) {
                $name = empty($item->name) ? ('Unnamed('.$item->id.')') : $item->name;
                $slider[] = array( 'value' => esc_attr('[layerslider id=\''.$item->id.'\']'), 'label' => esc_html($name).' (layer)');
            }
    }
    if(!empty($revos)) {
            foreach($revos as $key => $item) {
                $name = empty($item->title) ? ('Unnamed('.$item->id.')') : $item->title;
                $slider[] = array( 'value' => esc_attr('[rev_slider '.$item->id.']'), 'label' => esc_html($name).' (revo)');
            }
    }
    
    $my_meta_box = array(
        'id' => 'page_options',
        'title' => esc_html__('Page Options', 'ninetysix'),
        'desc' => '',
        'pages' => array('page'),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'label'       => esc_html__( 'General', 'ninetysix' ),
                'id'          => 'general',
                'type'        => 'tab'
            ),
            array(
                'id' => 'feature_area',
                'label' => esc_html__('Page Title Section', 'ninetysix'),
                'std' => '',
                'type' => 'select',
                'choices' => $feature_area
            ),
            array(
                'id' => 'slider',
                'label' => esc_html__('Slider ?', 'ninetysix'),
                'std' => '',
                'type' => 'select',
                'choices' => $slider,
                'condition'   => 'feature_area:is(slider)'
            ),
            array(
                'id' => 'embed',
                'label' => esc_html__('Embed ?', 'ninetysix'),
                'std' => '',
                'type' => 'textarea',
                'condition'   => 'feature_area:is(embed)'
            ),
            array(
                'label'       => esc_html__( 'Header and Footer', 'ninetysix' ),
                'id'          => 'header_footer',
                'type'        => 'tab'
            ),
            array(
                'label'       => esc_html__( 'Enable advanced options', 'ninetysix' ),
                'id'          => 'header_advanced',
                'type'        => 'on-off',
                'desc'        => sprintf(esc_html__( 'Shows the Advanced options when set to %s.', 'ninetysix' ), '<code>on</code>'),
                'std'         => 'off'
            ),
            array(
                'id' => 'header',
                'label' => esc_html__('Choose Header Type', 'ninetysix'),
                'std' => '',
                'type' => 'select',
                'condition'   => 'header_advanced:is(on)',
                'choices' => array(
                    array(
                        'value' => '',
                        'label' => esc_html__('Default', 'ninetysix'),
                    ),
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
            ),
            array(
                'id' => 'header_layout',
                'label' => esc_html__('Header & Footer Content Layout', 'ninetysix'),
                'std' => '',
                'type' => 'select',
                'desc' => esc_html__('Only the Content will changed', 'ninetysix'),
                'condition'   => 'header_advanced:is(on)',
                'choices' => array(
                    array(
                        'value' => '',
                        'label' => esc_html__('Default', 'ninetysix'),
                    ),
                    array(
                        'value' => 'boxed',
                        'label' => esc_html__('Boxed', 'ninetysix'),
                    ),
                    array(
                        'value' => 'full',
                        'label' => esc_html__('Full', 'ninetysix'),
                    ),
                )
            ),
            array(
                'id' => 'header_color',
                'label' => esc_html__('Header & Footer Color Scheme', 'ninetysix'),
                'std' => '',
                'type' => 'select',
                'desc' => esc_html__('If you chosen the Light then Header & Footer Layout colors will be White and other text are come from Typography options.', 'ninetysix'),
                'condition'   => 'header_advanced:is(on)',
                'choices' => array(
                    array(
                        'value' => '',
                        'label' => esc_html__('Default', 'ninetysix'),
                    ),
                    array(
                        'value' => 'header-light',
                        'label' => esc_html__('Light', 'ninetysix'),
                    ),
                    array(
                        'value' => 'header-dark',
                        'label' => esc_html__('Dark', 'ninetysix'),
                    ),
                )
            ),
            array(
                'id' => 'footer_layout',
                'label' => esc_html__('Footer Widget Layout', 'ninetysix'),
                'std' => '',
                'type' => 'select',
                'condition'   => 'header_advanced:is(on)',
                'choices' => array(
                    array(
                        'value' => '',
                        'label' => esc_html__('Default', 'ninetysix'),
                    ),
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
            )
        )
    );
    

    /**
     * Register our meta boxes using the 
     * ot_register_meta_box() function.
     */
    if (function_exists('ot_register_meta_box'))
        ot_register_meta_box($my_meta_box);
}
