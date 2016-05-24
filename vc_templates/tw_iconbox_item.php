<?php
/* ================================================================================== */
/*      IconBox Shortcode
/* ================================================================================== */
$waves_parentAtts=waves_get_pa();
$atts = shortcode_atts(array(
    'title' => 'Iconbox Title',
    'morelink' => '',
    // Font Icon
    'icon' => 'fontawesome',
    'ionicons' => '',
    'fontawesome' => '',
    'openiconic' => '',
    'typicons' => '',
    'entypo' => '',
    'linecons' => '',
    'pixelicons' => '',
    'fi_image' => '',
    // Font Icon Style
    'fi_color' => '',
    'fi_bgcolor' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));
$class = $data = '';
$waves_parentAtts['index']++;
$waves_parentAtts['animation_delay'] = intval($waves_parentAtts['animation_delay']) + 300;

$animData=waves_anim($waves_parentAtts);
if(!empty($animData)){$class.=' tw-animate-gen';$data.=$animData.' style="opacity:0;"';wp_enqueue_script( 'waypoints' );wp_enqueue_style('waves-animate', THEME_DIR . '/assets/css/animate.css');}

$link = vc_build_link( $atts['morelink'] );

$output = '<div class="tw-element '.$waves_parentAtts['column'].$class.'"'.$data.'>';
    $btn = '';    
    if(!empty($link['url']) && !empty($link['title'])){
        $btn = '<div class="tw-hoverline"><a class="read-more" href="' . esc_url($link['url']) . '">' . esc_html($link['title']) . '<i class="ion-ios-arrow-thin-right"></i></a></div>';
    }


    $icon = waves_icon($atts,false,false);
    $output .= '<div class="tw-iconbox-box">';
        $output .= '<div class="tw-iconbox-icon">' . $icon . '</div>';
        $output .= '<div class="tw-iconbox-content">';
                $output .= '<h3>' . esc_html($atts['title']) . '</h3>';
                $output .= '<p>' . wp_kses($content,array('br' => array())) . '</p>';
                $output .= $btn;
        $output .= '</div>';
    $output .= "</div>";
    
$output .= "</div>";

/* ================================================================================== */
echo balanceTags($output);

$col2 = array(3,5,7,9);
$div2 = (in_array($waves_parentAtts['index'], $col2) && $waves_parentAtts['column']=='vc_col-sm-6');

$col3 = array(4,7,10,13);
$div3 = (in_array($waves_parentAtts['index'], $col3) && $waves_parentAtts['column']=='vc_col-sm-4');

$col4 = array(5,9,13,17);
$div4 = (in_array($waves_parentAtts['index'], $col4) && $waves_parentAtts['column']=='vc_col-sm-3');

if($div2 || $div3 || $div4){
    echo '</div><div class="vc_row">';
}