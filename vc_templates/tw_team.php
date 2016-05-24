<?php
wp_enqueue_style( 'waves-widget-social');
$atts = shortcode_atts( array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'vc_row tw-element tw-team',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // -----------------------
    'layout' => '',
    'column'=>'vc_col-sm-12',
),vc_map_get_attributes($this->getShortcode(),$atts));
waves_set_pa($atts);
$class=$atts['layout'];
$class.=apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,vc_shortcode_custom_css_class($atts['css'],' '),$this->settings['base'],$atts);
$output  = waves_item($atts,$class);
        $output .= wpb_js_remove_wpautop($content);
$output .= '</div>';
echo balanceTags($output);
waves_set_pa(false);