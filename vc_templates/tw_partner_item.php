<?php
$atts = shortcode_atts( array(
    'title'=>'',
    'link'=>'',
    'image'=>'',
),vc_map_get_attributes($this->getShortcode(),$atts));
$anchorOpen=$anchorClose='';
if($atts['link']!==''){$anchorOpen='<a href="'.esc_url($atts['link']).'" title="'.esc_attr($atts['title']).'">';$anchorClose='</a>';}
$lrg_img=wp_get_attachment_image_src($atts['image'], 'full');
$img= isset($lrg_img[0])?($anchorOpen.'<img alt="' . esc_attr($atts['title']) . '" src="' . esc_url($lrg_img[0]) . '" />'.$anchorClose):'';
$output = '<div class="partner-item">';
    $output .= '<div class="partner-inner">';
        $output.=$img;
    $output .= '</div>';
$output .= '</div>';
echo balanceTags($output);