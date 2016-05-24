<?php
$atts = shortcode_atts( array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-accordion-tab wpb_accordion_section group',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // -----------------------
    'title' => "Section",
    // Font Icon
    'icon' => 'fontawesome',
    'ionicons' => '',
    'fontawesome' => '',
    'openiconic' => '',
    'typicons' => '',
    'entypo' => '',
    'linecons' => '',
    'pixelicons' => '',
    'fi_image' => '',
    'fi_text' => '',
    // Font Icon Style
    'fi_color' => '',
    'fi_border_color' => '',
    'fi_bg_color' => '',
    'fi_size' => '',
    'fi_padding' => '',
    'fi_border' => '',
    'fi_round' => '',
),vc_map_get_attributes($this->getShortcode(),$atts));
$class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,vc_shortcode_custom_css_class($atts['css'],' '),$this->settings['base'],$atts);

$icon=waves_icon($atts);

$output = waves_item($atts,$class);
    $output .= '<h3 class="wpb_accordion_header ui-accordion-header"><a href="#' . sanitize_title( $atts['title'] ) . '">'.$icon . $atts['title'] . '</a></h3>';
    $output .= '<div class="wpb_accordion_content ui-accordion-content vc_clearfix">';
        $output .= ($content===''||$content===' ')?esc_html__( "Empty section. Edit page to add content here.", 'ninetysix' ):wpb_js_remove_wpautop($content);
    $output .= '</div>';
$output .= '</div>';
echo balanceTags($output);