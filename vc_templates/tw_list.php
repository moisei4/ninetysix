<?php
$atts = shortcode_atts( array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-element tw-list',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // -----------------------
    'items' => '',
    'color' => '',
    // Font Icon
    'icon' => 'fontawesome',
    'ionicons' => '',
    'fontawesome' => 'fa-check',
    'openiconic' => '',
    'typicons' => '',
    'entypo' => '',
    'linecons' => '',
    'pixelicons' => '',
    'fi_image' => '',
),vc_map_get_attributes($this->getShortcode(),$atts));
vc_icon_element_fonts_enqueue($atts['icon']);
if($atts['icon']==='fi_image'){
    $lrg_img=wp_get_attachment_image_src($atts['fi_image'], 'full');
    $iconimg= isset($lrg_img[0])?'<img src="' . esc_url($lrg_img[0]) . '" />':'';
}
$class=apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,vc_shortcode_custom_css_class($atts['css'],' '),$this->settings['base'],$atts);
$output = waves_item($atts,$class);
    $output .= '<ul>';
            $items = explode( ",", $atts['items'] );
            if(isset($iconimg)){
                foreach($items as $item){
                    $output .='<li>'.$iconimg.$item.'</li>';
                }
            } else {
                foreach($items as $item){
                    $data = explode( "|", $item );
                    $color = ' style="color:'.(!empty($data[2]) ? $data[2] : $atts['color']).';"';
                    if(!empty($data[1])){
                        $output .='<li><i class="fi '.esc_attr($data[1]).'"'.$color.'></i>'.$data[0].'</li>';
                    } else{
                        $output .='<li><i class="fi '.esc_attr($atts[$atts['icon']]).'"'.$color.'></i>'.$data[0].'</li>';
                    }
                }
            }
    $output .= '</ul>';
$output .= '</div>';
echo balanceTags($output);