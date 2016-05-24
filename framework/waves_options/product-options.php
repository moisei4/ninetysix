<?php

/**
 * Initialize the custom Meta Boxes. 
 */
add_action('admin_init', 'waves_product_options');

/**
 * Meta Boxes demo code.
 *
 * You can find all the available option types in theme-options.php.
 *
 * @return    void
 * @since     2.3.0
 */
function waves_product_options() {
    global $wpdb;
    /**
     * Create a custom meta boxes array that we pass to 
     * the OptionTree Meta Box API Class.
     */
    
    $my_meta_box = array(
        'id' => 'product_options',
        'title' => esc_html__('Product options', 'ninetysix'),
        'desc' => '',
        'pages' => array('product'),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'label' => esc_html__('General', 'ninetysix'),
                'id' => 'general',
                'type' => 'tab'
            ),
            array(
                'id' => 'product_video',
                'label' => esc_html__('Product video', 'ninetysix'),
                'desc' => esc_html__('Video url', 'ninetysix'),
                'std' => '',
                'type' => 'text',
            ),
            array(
                'id' => 'product_zoom',
                'label' => esc_html__('Product image zoom', 'ninetysix'),
                'std' => 'off',
                'type' => 'on-off',
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
