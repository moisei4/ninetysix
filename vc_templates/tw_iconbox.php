<?php
/* ================================================================================== */
/*      IconBox Shortcode
/* ================================================================================== */
$atts = shortcode_atts(array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-iconbox',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // ----------------
    'layout' => 'top-simple',
    'column' => 'vc_col-sm-12',
), vc_map_get_attributes($this->getShortcode(),$atts));
$waves_parentAtts['layout'] = $atts['layout'];
$waves_parentAtts['column'] = $atts['column'];
$waves_parentAtts['animation'] = $atts['animation'];
$waves_parentAtts['animation_delay'] = $atts['animation_delay'];
$waves_parentAtts['index'] = 1;
waves_set_pa($waves_parentAtts);
$atts['animation'] = 'none';

$class = '';
if(!empty($atts['layout'])){
    $class.=' '.$atts['layout'].'-iconbox';
}
$class .=apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );
$output = waves_item($atts,$class);
    $output .= '<div class="vc_row">';
        $output .= wpb_js_remove_wpautop($content);
    $output .= "</div>";
$output .= "</div>";
/* ================================================================================== */
echo balanceTags($output);
waves_set_pa(false);