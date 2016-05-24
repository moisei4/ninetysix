<?php
$atts = shortcode_atts( array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-element tw-gallery',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    /*--------------- */
    'images' => '',
    'type' => 'portfolio_m2',
    'ppadding' => '30',
), vc_map_get_attributes($this->getShortcode(),$atts) );
$class=apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );


$item_style = $start = $end = '';
if($atts['type'] != 'slider'){
    $gallery_style = ' style="margin: 0 -'.$atts['ppadding'].'px -'.$atts['ppadding'].'px 0;"';
    $item_style = ' style="padding: 0 '.$atts['ppadding'].'px '.$atts['ppadding'].'px 0;"';
    if($atts['type']=='portfolio_m2' || $atts['type']=='portfolio_m3'){
        wp_enqueue_script('waves-isotope');   
        $start = '<div class="gallery-isotope '.$atts['type'].'"'.$gallery_style.'>';
        $end = '</div>';
    }
}
    
$output = waves_item($atts,$class);
    $images = explode(',',$atts['images']);
    $size = 'waves_'.($atts['type'] == 'slider' ? 'featured_img' : $atts['type']);
    $output .= $start;
        foreach($images as $image){
            $output .= '<div class="tw-gallery-item"'.$item_style.'>';
                $output .= '<a href="'.esc_url(waves_get_image_by_id($image,true,'full')).'" rel="prettyPhoto['.$atts['images'].']">';
                    $output .= waves_get_image_by_id($image,false,$size);
                    $output .= '<span class="image-overlay"></span>';
                $output .= '</a>';
            $output .= '</div>';
        }
    $output .= $end;
$output .= '</div>';

echo balanceTags($output);