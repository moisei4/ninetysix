<?php
$atts = shortcode_atts( array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-element tw-pricing',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // -----------------------
),vc_map_get_attributes($this->getShortcode(),$atts));
waves_set_pa($atts);
$atts['animation'] = 'none';
$column=substr_count($content,'[tw_pricingtable_item');
$class=apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,vc_shortcode_custom_css_class($atts['css'],' '),$this->settings['base'],$atts);
$output = waves_item($atts,'column-'.$column.$class);
    $output .= wpb_js_remove_wpautop($content);
$output .= '</div>';
echo balanceTags($output);
waves_set_pa(false);