<?php
wp_enqueue_script( 'jquery-ui-accordion' );
$atts = shortcode_atts( array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-element tw-accordion wpb_accordion wpb_content_element not-column-inherit',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // -----------------------
    'active_tab' => '1',
    'style' => 'style-1',
    'collapsible' => 'no',
    'disable_keyboard' => 'no',
    'el_class' => '',
),vc_map_get_attributes($this->getShortcode(),$atts));
$data=' data-collapsible="'.esc_attr($atts['collapsible']).'" data-vc-disable-keydown="'.esc_attr(('yes'===$atts['disable_keyboard']?'true':'false')).'" data-active-tab="'.esc_attr($atts['active_tab']).'"';
$class = $atts['style'].apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );
$output = waves_item($atts,$class,$data);
    $output .= '<div class="wpb_wrapper wpb_accordion_wrapper ui-accordion">';
        $output .= wpb_js_remove_wpautop( $content );
    $output .= '</div>';
$output .= '</div>';
echo balanceTags($output);