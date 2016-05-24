<?php

/**
 * Initialize the custom Meta Boxes. 
 */
add_action('admin_init', 'waves_portfolio_options');

/**
 * Meta Boxes demo code.
 *
 * You can find all the available option types in theme-options.php.
 *
 * @return    void
 * @since     2.3.0
 */
function waves_portfolio_options() {
    global $wpdb;
    /**
     * Create a custom meta boxes array that we pass to 
     * the OptionTree Meta Box API Class.
     */
    $single_layout = array(
        array(
            'value' => '',
            'label' => esc_html__('Default', 'ninetysix'),
            'src' => THEME_DIR . '/assets/img/slider_ot_option.png'
        ),
        array(
            'value' => 'with-sidebar',
            'label' => esc_html__('With sidebar', 'ninetysix'),
            'src' => THEME_DIR . '/assets/img/content_1.png'
        ),
        array(
            'value' => 'full-width',
            'label' => esc_html__('Without Sidebar', 'ninetysix'),
            'src' => THEME_DIR . '/assets/img/content_2.png'
        )
    );
    
    $feature_area = array(
        array(
            'value' => '',
            'label' => esc_html__('Featured Image', 'ninetysix'),
        ),
        array(
            'value' => 'images',
            'label' => esc_html__('Image slider', 'ninetysix'),
        ),
        array(
            'value' => 'slider',
            'label' => esc_html__('Revolution Slider', 'ninetysix'),
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
        'id' => 'portfolio_options',
        'title' => esc_html__('Portfolio options', 'ninetysix'),
        'desc' => '',
        'pages' => array('portfolio'),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'label' => esc_html__('General', 'ninetysix'),
                'id' => 'general',
                'type' => 'tab'
            ),
            array(
                'id' => 'single_layout',
                'label' => esc_html__('Single post layout', 'ninetysix'),
                'desc' => esc_html__('Change the Single Post Layout Style. You can change all Post Layout Styles on Theme Options.', 'ninetysix'),
                'std' => '',
                'type' => 'radio-image',
                'choices' => $single_layout,
                'section' => 'general'
            ),
            array(
                'id' => 'feature_area',
                'label' => esc_html__('Featured Section', 'ninetysix'),
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
                'label' => esc_html__('Images of Slider', 'ninetysix'),
                'id' => 'images',
                'type' => 'gallery',
                'desc' => esc_html__('Note: This option will work only you have chosen POST FORMAT -> GALLERY', 'ninetysix'),
                'condition'   => 'feature_area:is(images)'
            ),
            array(
                'id' => 'content_page',
                'label' => esc_html__('Select Content Page', 'ninetysix'),
                'std' => '',
                'type' => 'page-select'
            ),
            array(
                'label' => esc_html__('Gallery', 'ninetysix'),
                'id' => 'gallery',
                'type' => 'gallery',
                'desc' => esc_html__('Note: This option will work only you have chosen POST FORMAT -> GALLERY', 'ninetysix'),
                'condition'   => 'content_page:is()'
            ),
            array(
                'label' => esc_html__('Client', 'ninetysix'),
                'id' => 'client',
                'type' => 'text',
            ),
            array(
                'label' => esc_html__('Project url', 'ninetysix'),
                'id' => 'project_url',
                'type' => 'text',
            ),
        )
    );

    /**
     * Register our meta boxes using the 
     * ot_register_meta_box() function.
     */
    if (function_exists('ot_register_meta_box'))
        ot_register_meta_box($my_meta_box);
    
}
