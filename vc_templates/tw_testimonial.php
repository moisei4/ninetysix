<?php
$atts = shortcode_atts( array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-element tw-testimonial',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // -----------------------
    'layout' => '',
),vc_map_get_attributes($this->getShortcode(),$atts));
$class=$atts['layout'];
$before=$after='';
if($atts['layout']!=='carousel'){
    $class.=' clearfix';
}
$class.=apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,vc_shortcode_custom_css_class($atts['css'],' '),$this->settings['base'],$atts);
$output = waves_item($atts,$class);
    if($atts['layout']==='carousel'){
        wp_enqueue_script('waves-roundabout',THEME_DIR . '/assets/js/jquery.waves-roundabout.min.js');
        $output .= '<div class="tw-roundabout">';
    }
        $output .= wpb_js_remove_wpautop($content);
    if($atts['layout']==='carousel'){
        $output .= '</div>';
        $output .= '<div class="tw-roundabout-desc">';
            $waves_parentAtts=waves_get_pa();
            if(isset($waves_parentAtts['testimonial_item_first'])){
                $output .= $waves_parentAtts['testimonial_item_first'];
            }
        $output .= '</div>';
    }
$output .= '</div>';
echo balanceTags($output);
waves_set_pa(false);