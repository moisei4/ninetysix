<?php

//This will Control the Color of Light or Dark
function waves_ColorLuminance($color, $percent) {
    $color = str_replace("#", "", $color);
    if (strlen($color) == 3) {
        $R = hexdec(substr($color, 0, 1) . substr($color, 0, 1));
        $G = hexdec(substr($color, 1, 1) . substr($color, 1, 1));
        $B = hexdec(substr($color, 2, 1) . substr($color, 2, 1));
    } else {
        $R = hexdec(substr($color, 0, 2));
        $G = hexdec(substr($color, 2, 2));
        $B = hexdec(substr($color, 4, 2));
    }

    $R = intval($R);
    $G = intval($G);
    $B = intval($B);

    $R = round($R * (100 + $percent) / 100);
    $G = round($G * (100 + $percent) / 100);
    $B = round($B * (100 + $percent) / 100);

    $R = (string) dechex(($R < 255) ? $R : 255);
    $G = (string) dechex(($G < 255) ? $G : 255);
    $B = (string) dechex(($B < 255) ? $B : 255);

    $RR = (strlen($R) == 1) ? ("0" . $R) : $R;
    $GG = (strlen($G) == 1) ? ("0" . $G) : $G;
    $BB = (strlen($B) == 1) ? ("0" . $B) : $B;

    return "#" . $RR . $GG . $BB;
}

function waves_option_styles() {
    //Body
    $body_typography = waves_option('body_typography');
    $body_color = isset($body_typography['font-color']) ? $body_typography['font-color'] : '#888888';
    $body_font = isset($body_typography['font-family']) ? waves_get_gf_family_by_id($body_typography['font-family']) : 'Abel';
    $body_size = isset($body_typography['font-size']) ? $body_typography['font-size'] : '16px';
    //Heading
    $heading_typography = waves_option('heading_typography');
    $heading_color = isset($heading_typography['font-color']) ? $heading_typography['font-color'] : '#151515';
    $heading_font = isset($heading_typography['font-family']) ? waves_get_gf_family_by_id($heading_typography['font-family']) : 'Abel';
    //H1
    $heading_h1 = waves_option('heading_h1');
    $h1 = isset($heading_h1['font-size']) ? $heading_h1['font-size'] : '30px';
    //H2
    $heading_h2 = waves_option('heading_h2');
    $h2 = isset($heading_h2['font-size']) ? $heading_h2['font-size'] : '24px';
    //H1
    $heading_h3 = waves_option('heading_h3');
    $h3 = isset($heading_h3['font-size']) ? $heading_h3['font-size'] : '18px';
    //H1
    $heading_h4 = waves_option('heading_h4');
    $h4 = isset($heading_h4['font-size']) ? $heading_h4['font-size'] : '16px';
    //H1
    $heading_h5 = waves_option('heading_h5');
    $h5 = isset($heading_h5['font-size']) ? $heading_h5['font-size'] : '14px';
    //H1
    $heading_h6 = waves_option('heading_h6');
    $h6 = isset($heading_h6['font-size']) ? $heading_h6['font-size'] : '12px';
    ?>
    <style type="text/css" id="waves-css">
        body{
            color: <?php echo esc_attr($body_color); ?>;
            font-family:<?php echo esc_attr($body_font); ?>;
            font-size: <?php echo esc_attr($body_size); ?>;
        }
        h1, h2, h3, h4, h5, h6{
            color: <?php echo esc_attr($heading_color); ?>;
            font-family:<?php echo esc_attr($heading_font); ?>;
        }
        h1{
            font-size: <?php echo esc_attr($h1); ?>;
        }
        h2{
            font-size: <?php echo esc_attr($h2); ?>;
        }
        h3{
            font-size: <?php echo esc_attr($h3); ?>;
        }
        h4{
            font-size: <?php echo esc_attr($h4); ?>;
        }
        h5{
            font-size: <?php echo esc_attr($h5); ?>;
        }
        h6{
            font-size: <?php echo esc_attr($h6); ?>;
        }
        <?php echo waves_option('custom_css');?>
    </style><?php
}

add_action('wp_head', 'waves_option_styles', 100);
