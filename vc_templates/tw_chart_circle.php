<?php
/* ================================================================================== */
/*      Circle Chart Shortcode
/* ================================================================================== */
wp_enqueue_script( 'waypoints' );
wp_enqueue_script('waves-easy-pie-chart', THEME_DIR . '/assets/js/jquery.easy-pie-chart.js', false, false, true);
$atts = shortcode_atts( array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'vc_row tw-circle-chart clearfix',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // ----------------
    'column' => 'vc_col-sm-12',
    'layout' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));

waves_set_pa($atts);

$class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );
$output = waves_item($atts,$class);
        $output .= wpb_js_remove_wpautop($content);
$output .='</div>';
/* ================================================================================== */
echo balanceTags($output);
waves_set_pa(false);