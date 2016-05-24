<?php
$atts = shortcode_atts( array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-element tw-partner',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // -----------------------
    'column' => 4,
),vc_map_get_attributes($this->getShortcode(),$atts));
$subItems=substr_count($content,'[tw_partner_item');
if($subItems<intval($atts['column'])){$atts['column']=$subItems;}
$class='column-'.$atts['column'].apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,vc_shortcode_custom_css_class($atts['css'],' '),$this->settings['base'],$atts);
$output = waves_item($atts,$class);
    $output .= do_shortcode($content);
$output .= '</div>';
echo balanceTags($output);