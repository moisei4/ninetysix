<?php
$waves_parentAtts=waves_get_pa();
$atts = shortcode_atts( array(
    'img' => '',
    'text' => '',
    'name' => '',
    'position' => '',
),vc_map_get_attributes($this->getShortcode(),$atts));
$name = !empty($atts['name']) ? ('<h4 class="testimonial-name">'.$atts['name'].'</h4>') : '';
$position = !empty($atts['position']) ? ('<div class="testimonial-pos">'.$atts['position'].'</div>') : '';
$output ='<div class="testimonial-item">';             
    if(!empty($atts['img'])){
        $img = wp_get_attachment_image_src($atts['img'],'thumbnail');
        if (!empty($img[0])){
            $output.='<img class="testimonial-img" src="'.esc_url($img[0]).'" />';
        }
    }
    $dsc='<div class="testimonial-content"><p>'.strip_tags($content).'</p></div><div class="testimonial-meta">'.$name.', '.$position.'</div>';
    $output.='<div class="testimonial-desc">';
        $output.=$dsc;
    $output.='</div>';
$output.='</div>';
if(!isset($waves_parentAtts['testimonial_item_first'])){
    $waves_parentAtts['testimonial_item_first']=$dsc;
    waves_set_pa($waves_parentAtts);
}
echo balanceTags($output);