<?php
$waves_parentAtts=waves_get_pa();
$atts = shortcode_atts( array(
    'title'=>'',
    'price'=>'',
    'link'=>'',
),vc_map_get_attributes($this->getShortcode(),$atts));

$class = $data = '';
$waves_parentAtts['animation_delay'] = intval($waves_parentAtts['animation_delay']) + 300;

$animData=waves_anim($waves_parentAtts);
if(!empty($animData)){$class.=' tw-animate-gen';$data.=$animData.' style="opacity:0;"';wp_enqueue_script( 'waypoints' );wp_enqueue_style('waves-animate', THEME_DIR . '/assets/css/animate.css');}

$output = '<div class="pricing-column'.$class.'"'.$data.'>';
    $output .= '<div class="pricing-box">';
        $output .= '<header class="pricing-header">';
            $output .= '<h1>' . $atts['title'] . '</h1>';
            $output .= '<div class="pricing-top">';
                $price = explode( "|", $atts['price'] );
                $output .= isset($price[0]) ? ('<span class="price">' . $price[0] . '</span>') : '';
                $output .= isset($price[1]) ? ('<span class="symbol">' . str_replace(' ','<br />', $price[1]) . '</span>') : '';
            $output .= '</div>';
        $output .= '</header>';
        $output .= '<div class="pricing-content">';
            $output .= wpb_js_remove_wpautop($content, true);
        $output .= '</div>';
        $link = vc_build_link( $atts['link'] );
        if(!empty($link['url']) && !empty($link['title'])){
            $output .= '<footer class="pricing-footer">';
                $output .= do_shortcode('[tw_button link="' . esc_url($link['url']) . '" style="border btn-round" size="xs" target="'.$link['target'].'"]' . $link['title'] . '[/tw_button]');
            $output .= '</footer>';
        }
    $output .= '</div>';
$output .= '</div>';
echo balanceTags($output);