<?php
$atts = shortcode_atts( array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-element tw-map',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // -----------------------
    'json'=>'',
    'mouse_wheel'=>'false',
    'style_name'=>'Styled',
    'height'=>400,
    'lat'=>'40.0712145',
    'lng'=>'-83.4495123',
    'zoom'=>'8',
    'contact'=>'false',
    'map_title'=>'',
    'map_desc'=>'',
    'map_contact'=>'0',
    'map_bg_color'=>'',
    'markers'=>array(),
),vc_map_get_attributes($this->getShortcode(),$atts));
$atts['json']=rawurldecode(waves_decode(strip_tags($atts['json'])));
wp_enqueue_script('waypoints');
wp_enqueue_script('waves-googleapi-map', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', false, false, true);
$class=apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,vc_shortcode_custom_css_class($atts['css'],' '),$this->settings['base'],$atts);
$data=' data-style="'.esc_attr($atts['style_name']).'" data-mouse="'.esc_attr($atts['mouse_wheel']).'" data-lat="'.esc_attr($atts['lat']).'" data-lng="'.esc_attr($atts['lng']).'" data-zoom="'.esc_attr($atts['zoom']).'" data-json="'.esc_attr($atts['json']).'"';
$style=$atts['height']?('height:'.esc_attr($atts['height']).'px;'):'';
$output  = waves_item($atts,$class,$data,$style);
    $output .='<div class="map"></div>';
    $output .='<div class="map-markers">';
        $iconDefault=THEME_DIR."/assets/img/map-marker.png";
        $markers = (array) vc_param_group_parse_atts( $atts['markers'] );
        foreach($markers as $marker){
            $marker = shortcode_atts( array(
                'css' => '',
                'title' => '',
                'lat' => '',
                'lng' => '',
                'icon' => '',
                'icon_width' => '',
                'icon_height' => '',
                'content' => '',
            ),$marker);
            $icon=$marker['icon'];
            if($icon){
                $icon=wp_get_attachment_image_src($icon,'full');
                $icon=isset($icon[0])?$icon[0]:$iconDefault;
            }else{
                $icon=$iconDefault;
            }
            $data=' data-title="'.esc_attr($marker['title']).'" data-lat="'.esc_attr($marker['lat']).'" data-lng="'.esc_attr($marker['lng']).'" data-iconsrc="'.esc_url($icon).'" data-iconwidth="'.esc_attr($marker['icon_width']).'" data-iconheight="'.esc_attr($marker['icon_height']).'"';
            $output.= '<div class="map-marker"'.$data.'>';
                if($marker['title']){$output .='<h3>'.esc_html($marker['title']).'</h3>';}
                $output .='<div class="marker-content">';
                    $output .= do_shortcode($marker['content']);
                $output .='</div>';
            $output .='</div>';
        }
    $output .='</div>';
    if($atts['contact']==='true'){
        $output .='<div class="tw-map-contact" style="'.esc_attr('background-color:'.$atts['map_bg_color'].';').'">';
            if($atts['map_title']  ){$output.='<h2>'.esc_html($atts['map_title']).'</h2>';}
            if($atts['map_desc']  ){$output.='<p>'.esc_html($atts['map_desc']).'</p>';}
            if($atts['map_contact']){$output.=do_shortcode('[contact-form-7 id="'.esc_attr($atts['map_contact']).'"]');}
        $output .='</div>';
    }                                           
$output .='</div>';
echo balanceTags($output);