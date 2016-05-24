<?php
$atts = shortcode_atts( array(
        'css' => '',
        'custom_class' => '',
        'element_class' => 'tw-element tw-message',
        'element_dark' => '',
        'animation' => 'none',
        'animation_delay' => '',
        //---------------
        'type'  => 'info',
        'layout'  => 'simple',
), vc_map_get_attributes($this->getShortcode(),$atts) );

$class=apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );
$output = waves_item($atts,$class);
    $output .= '<div class="type-'.$atts['type'].' layout-'.$atts['layout'].'">';
        $output .= $content.'<i class="ion-ios-close-empty"></i>';
    $output .= '</div>';
$output .= '</div>';

//$output .= "\n\t\t" . '<div class="wpb_wrapper">';
//$output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content, true );
//$output .= "\n\t\t\t" . $content;
//$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
//$output .= "\n\t" . '</div> ' . $this->endBlockComment( '.wpb_text_column' );

echo balanceTags($output);