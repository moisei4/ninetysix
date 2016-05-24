<?php
$ex='';
if(!isset($_POST['customized'])){wp_enqueue_script('jquery-ui-tabs');}else{$ex='_';}
$atts = shortcode_atts( array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-element wpb_content_element tw-tabs wpb_tabs'.$ex,
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // -----------------------
    'interval' => 0,
    'style' => '',
),vc_map_get_attributes($this->getShortcode(),$atts));

preg_match_all( '/vc_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
$tab_titles = array();
if(isset($matches[1])){$tab_titles=$matches[1];}
$klass = $atts['style']=='style-2' ? ' class="tw-hoverline"' : '';
$tabs_nav = '<ul class="wpb_tabs_nav ui-tabs-nav vc_clearfix">';
    foreach($tab_titles as $tab){
        $tab_atts=shortcode_parse_atts($tab[0]);
        $icon=waves_icon($tab_atts);
        if(isset($tab_atts['title'])){$tabs_nav .= '<li'.$klass.'><a href="#tab-'.(isset($tab_atts['tab_id'])?$tab_atts['tab_id']:sanitize_title($tab_atts['title'])).'">'.$icon.$tab_atts['title'].'</a></li>';}
    }
$tabs_nav .= '</ul>';
$class = $atts['style'].apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,vc_shortcode_custom_css_class($atts['css'],' '),$this->settings['base'],$atts);
$data='';
if(!empty($atts['interval'])){
    $data=' data-interval="'.esc_attr($atts['interval']).'"';
    wp_enqueue_script( 'jquery_ui_tabs_rotate' );
}
$output = waves_item($atts,$class,$data);
    $output .= '<div class="wpb_wrapper wpb_tour_tabs_wrapper ui-tabs vc_clearfix">';
        $output .= $tabs_nav;
        $output .= wpb_js_remove_wpautop($content);
    $output .= '</div> ';
$output .= '</div> ';

echo balanceTags($output);