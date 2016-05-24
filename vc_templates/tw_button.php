<?php
$atts=shortcode_atts(array(
    'link' => '',
    'target' => '_self',
    'style' => 'flat',
    'size' => 'm',
    'color' => '',
    'margin' => '',
    // Font Icon
    'icon' => 'none',
    'ionicons' => '',
    'fontawesome' => 'fa fa-info-circle',
    'openiconic' => '',
    'typicons' => '',
    'entypo' => '',
    'linecons' => '',
    'pixelicons' => '',
    'fi_image' => '',
),vc_map_get_attributes($this->getShortcode(),$atts));
$icon=$btnclass=$style=$target='';
if(!empty($atts['icon_class'])){$icon='<i class="fi '.$atts['icon_class'].'"></i>';}
if(empty($icon)){$icon=waves_icon($atts);}
if(!empty($atts['target'])){
    $target = ' target="'.$atts['target'].'"';
}
$link = vc_build_link( $atts['link'] );
$btnclass.=!empty($atts['style']) ? (' btn-' . $atts['style']) : '';
$btnclass.= !empty($atts['size']) ? (' btn-' . $atts['size']) : '';
if (!empty($atts['margin'])) {
    $margins = explode( ",", $atts['margin'] );
    foreach($margins as $key => $margin){
        if(!empty($margin)){
            if($key == 0)
                $style.="margin-top:".$margin.'px;';
            elseif($key == 1)
                $style.="margin-right:".$margin.'px;';
            elseif($key == 2)
                $style.="margin-bottom:".$margin.'px;';
            elseif($key == 3)
                $style.="margin-left:".$margin.'px;';
        }
    }
}
if (!empty($atts['color'])) {
    $style .= (($atts['style'] === 'border' || $atts['style'] === 'border btn-round') ? ('color:' . esc_attr($atts['color']).';border-color:' . esc_attr($atts['color']) . ';') : ('background-color:' . esc_attr($atts['color']))) . ';';
}
$output='<a href="'.esc_url($link['url']).'" title="'.esc_attr($link['title']).'" class="btn'.$btnclass.'" style="'.$style.'"'.$target.'>' . esc_html($link['title']) .$icon.'</a>';
if(!empty($content)){
    $output='<a href="'.esc_url($atts['link']).'" class="btn'.$btnclass.'" style="'.$style.'">' . esc_html($content) .$icon.'</a>';
}
echo balanceTags($output);