<?php
wp_enqueue_script( 'jquery-ui-accordion' );
$atts = shortcode_atts( array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-element tw-toggle vc_toggle',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // -----------------------
    'title' => '',
    'open' => 'false',
    'el_id' => '',
    'style' => 'style-1',
),vc_map_get_attributes($this->getShortcode(),$atts));
$class = $atts['style'].apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );
if($atts['open']=== 'true'){$class.=' vc_toggle_active';}
if(!empty($atts['el_id'])){$atts['custom_id']=$atts['el_id'];}

$output = waves_item($atts,$class);
    $output .= '<div class="tw-toggle-section">';
        $output .= '<div class="vc_toggle_title"><h4>'.$atts['title'].'</h4></div>';
        $output .= '<div class="vc_toggle_content">'.wpb_js_remove_wpautop( $content ).'</div>';
    $output .= '</div>';
$output .= '</div>';
echo balanceTags($output);