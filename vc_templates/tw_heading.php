<?php
/* ================================================================================== */
/*      Heading Shortcode
/* ================================================================================== */
$atts = shortcode_atts(array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-element tw-heading',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // ----------------
    'title' => '',
    'title_align' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));
$class=!empty($atts['title_align'])?($atts['title_align'].' '):'';
$class.=apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );
$output = waves_item($atts,$class);

    if(!empty($atts['title'])){
        $output .= '<h3 class="heading-title">'.esc_html($atts['title']).'</h3>';
    }
    
$output .= "</div>";
/* ================================================================================== */
echo balanceTags($output);