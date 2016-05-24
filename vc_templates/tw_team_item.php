<?php
$waves_parentAtts=waves_get_pa();
$atts = shortcode_atts( array(
    'name'=>'',
    'position'=>'',
    'image'=>'',
    'socials'=>'',
    'link'=>'',
),vc_map_get_attributes($this->getShortcode(),$atts));

$class = $data = '';
$waves_parentAtts['animation_delay'] = intval($waves_parentAtts['animation_delay']) + 300;

$animData=waves_anim($waves_parentAtts);
if(!empty($animData)){$class.=' tw-animate-gen';$data.=$animData.' style="opacity:0;"';wp_enqueue_script( 'waypoints' );wp_enqueue_style('waves-animate', THEME_DIR . '/assets/css/animate.css');}

$output = '<div class="'.$waves_parentAtts['column'].$class.'"'.$data.'>';

    $social = $open = $close = '';
    
    $social_links=explode(",",$atts['socials']);
    
    if($waves_parentAtts['layout'] == 'layout2'){ 
            $social .= '<div class="layout_3">';
                $social .= '<div class="tw-social-color">';
                foreach($social_links as $social_link){
                    $social.=waves_social_link($social_link);
                }
                $social .= '</div>';
            $social .= '</div>';
    }else{
        $social .= '<div class="tw-social-color">';
        foreach($social_links as $social_link){
            if(!empty($social_link)){
                $socl = waves_social_name(esc_url($social_link));
                $social .= '<div><a title="'.esc_attr($socl['name']).'" href="'.esc_url($social_link).'" class="'.esc_attr($socl['name']).'">'.esc_attr($socl['name']).'.</a></div>';
            }
        }
        $social .= '</div>';
    }
    
    
    
    $linkimg=wp_get_attachment_image_src($atts['image'], 'full');
    
    if(!empty($atts['link'])){
        $open = '<a href="'.$atts['link'].'">';
        $close = '</a>';
    }
    
    
    $output .= '<div class="team-member">';
        $output .= '<div class="member-image">';
            if(!empty($linkimg[0])){
                $output .= '<div class="tw-thumbnail">';
                    $output .= '<img src="' . esc_url($linkimg[0]) . '"/>';
                    $output .= '<div class="image-overlay">';                    
                    if($social){ 
                        $output .= '<div class="member-social waves-va-middle">'.$social.'</div>';
                    } else {
                        $output .= '<a href="'.esc_url($linkimg[0]).'" title="'.esc_attr($atts['name']).'" rel="prettyPhoto['.$atts['image'].']">';
                        $output .= '</a>';
                    }
                    $output .='</div>';
                $output .='</div>';
            }
        $output .='</div>';
        $output .= '<div class="member-content">';
            $output .= '<div class="member-title">';
                $output .= '<h6>'.$open.esc_html($atts['name']).$close.'</h6>';
                if (!empty($atts['position'])){$output .= '<div class="member-pos">' . esc_html($atts['position']) . '</div>';}
            $output .= '</div>';
        $output .= '</div>';
    $output .= '</div>';
$output .= '</div>';
echo balanceTags($output);