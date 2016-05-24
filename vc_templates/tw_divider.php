<?php
/* ================================================================================== */
/*      Service Shortcode
/* ================================================================================== */
$atts = shortcode_atts(array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-element tw-divider',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // ----------------
    'type' => 'line',
    'title' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));

$class = 'type-'.$atts['type'];
$title = '';
if(!empty($atts['title'])){
    $class .= ' divider-with-title';
    $title .='<h5 class="divider-title waves-nested-bg">'.$atts['title'].'</h5>';
}

$class.=apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );
$output = waves_item($atts,$class);
    $output .='<div class="divider-line"></div>'.$title;
$output .= "</div>";
/* ================================================================================== */
echo balanceTags($output);