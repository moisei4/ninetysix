<?php
$atts = shortcode_atts( array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'ui-tabs-panel wpb_ui-tabs-hide vc_clearfix',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // -----------------------
    'title' => '',
    'tab_id' => '',
),vc_map_get_attributes($this->getShortcode(),$atts));
$class= apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );
$atts['custom_id']='tab-'.(empty($atts['tab_id'])?sanitize_title($atts['title']):$atts['tab_id']);
$output = waves_item($atts,$class);
    $output .= ($content===''||$content===' ')?esc_html__( "Empty tab. Edit page to add content here.", 'ninetysix' ):wpb_js_remove_wpautop($content);
$output .= '</div>';
echo balanceTags($output);