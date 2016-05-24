<?php
$waves_parentAtts=waves_get_pa();
$atts = shortcode_atts( array(
    'title' => '',
    'cc_percent' => '',
    'fi_text' => '',
    // Font Icon
    'icon' => 'none',
    'ionicons' => '',
    'fontawesome' => '',
    'openiconic' => '',
    'typicons' => '',
    'entypo' => '',
    'linecons' => '',
    'pixelicons' => '',
    'fi_image' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));
$data = '';
$data .= ' data-percent="0"';
$data .= ' data-padding="0"';
$data .= ' data-percent-update="' . esc_attr($atts['cc_percent']) . '"';
$data .= ' data-line-cap="butt"';
$data .= ' data-size="180"';
$data .= ' data-bar-color="#151515"';
$data .= ' data-track-color="#e6e6e6"';
$data .= ' data-animation-delay="'.esc_attr($waves_parentAtts['animation_delay']).'"';

if($waves_parentAtts['layout'] == 'layout2'){
    $data .= ' data-line-width="4"';
} else {
    $data .= ' data-line-width="1"';
}

$output = '<div class="tw-element '.$waves_parentAtts['column'].'">';
    $output .='<div class="tw-circle-chart-inner tw-animate"'.$data.'>';
        $output .='<span>';
            if($atts['icon']=='none'||empty($atts['icon'])){
                $atts['icon'] = 'fi_text';
                $atts['fi_text'] = $atts['cc_percent'].'%';
            }
            $output .=waves_icon($atts);
        $output .='</span>';
    $output .='</div>';
    $output .='<h5>';
        $output .=$atts['title'];
    $output .='</h5>';
    $output .= '<p>' . strip_tags($content) . '</p>';
$output .='</div>';
/* ================================================================================== */
echo balanceTags($output);