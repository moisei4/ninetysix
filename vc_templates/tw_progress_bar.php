<?php
$atts = shortcode_atts( array(
        'css' => '',
        'custom_class' => '',
        'element_class' => 'tw-element tw-progress vc_progress_bar wpb_content_element',
        'element_dark' => '',
        'animation' => 'none',
        'animation_delay' => '',
        //---------------
	'values' => '',
	'units' => '',
	'layout' => ''
), vc_map_get_attributes($this->getShortcode(),$atts) );

wp_enqueue_script( 'waypoints' );

$class=$atts['layout'];
$class.=apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );
$output = waves_item($atts,$class);

$graph_lines = explode( ",", $atts['values'] );
$max_value = 0.0;
$graph_lines_data = array();
foreach ( $graph_lines as $line ) {
	$new_line = array();
	$data = explode( "|", $line );
	$new_line['value'] = isset( $data[0] ) ? $data[0] : 0;
	$new_line['percentage_value'] = isset( $data[1] ) && preg_match( '/^\d{1,2}\%$/', $data[1] ) ? (float) str_replace( '%', '', $data[1] ) : false;
	if ( $new_line['percentage_value'] != false ) {
		$new_line['label'] = isset( $data[2] ) ? $data[2] : '';
	} else {
		$new_line['label'] = isset( $data[1] ) ? $data[1] : '';
	}        
	if ( $new_line['percentage_value'] === false && $max_value < (float) $new_line['value'] ){
		$max_value = $new_line['value'];
	}

	$graph_lines_data[] = $new_line;
}

foreach ( $graph_lines_data as $line ) {
	$unit = '';
        if(( $atts['units'] != '' )){
            $unit .= '<span class="vc_label_units">' . $line['value'] . $atts['units'] . '</span>';
        }
	$output .= '<div class="vc_single_bar">';
	$output .= '<span class="vc_label">' . $line['label'] . '</span>'.$unit;
	if ( $line['percentage_value'] !== false ) {
		$percentage_value = $line['percentage_value'];
	} elseif ( $max_value > 100.00 ) {
		$percentage_value = (float) $line['value'] > 0 && $max_value > 100.00 ? round( (float) $line['value'] / $max_value * 100, 4 ) : 0;
	} else {
		$percentage_value = $line['value'];
	}
	$output .= '<span class="vc_bar" data-percentage-value="' . ( $percentage_value ) . '" data-value="' . $line['value'] . '"></span>';
	$output .= '</div>';
}

$output .= '</div>';

echo balanceTags($output);