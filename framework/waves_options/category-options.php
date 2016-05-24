<?php
global $waves_categoryOptions;
$waves_categoryOptions = Array(
    Array(
         'name' => 'attr_color',
         'title' => esc_html__('Color ?', 'ninetysix'),
         'type' => 'color',
         'description' => '',
         'std' => ''
    ),
);
function waves_category_meta_add($metaArray) {
    foreach ($metaArray as $meta) {
        $val = $meta["std"];
        $output = '<div class="form-field type-'.esc_attr($meta['type']).'">';
            $output .= '<label for="term_meta[' . esc_attr($meta['name']) . ']">' . esc_html($meta['title']) . '</label>';
            switch ($meta['type']) {
                case 'color':
                    $output .= '<input name="term_meta[' . esc_attr($meta['name']) . ']" class="waves-category-color" data-type="color" type="text" value="' . esc_attr($val) . '" style="width:100px;background-color:' . esc_attr($val) . '" />';
                    $output .= '<div style="background-color: '.esc_attr($val).'" class="color-info"></div>';
                    break;
                case 'text':
                    $output .= '<input name="term_meta[' . esc_attr($meta['name']) . ']" type="text" value="' . esc_attr($val) . '" />';
                    break;
                case 'checkbox':
                    $output .= '<input type="hidden" name="term_meta['.esc_attr($meta['name']).']" value="0"/>';
                    $output .= '<input type="checkbox" class="yesno" name="term_meta['.esc_attr($meta['name']).']" value="1"'.checked($val, 1, false).' />';           
                    break;
                case 'radio':
                    foreach($meta['options'] as $meta_option){              
                        $output .= '<div class="radio-images">';
                            $output .= '<p><input type="radio" name="term_meta[' . esc_attr($meta['name']) . ']" value="' . esc_attr( $meta_option['value'] ) . '"' . checked( $val, $meta_option['value'], false ) . ' class="option-tree-ui-radio option-tree-ui-images" /><label>' . esc_attr( $meta_option['label'] ) . '</label></p>';
                            $output .= '<img src="' . esc_url( $meta_option['src'] ) . '" alt="' . esc_attr( $meta_option['label'] ) .'" title="' . esc_attr( $meta_option['label'] ) .'" class="radio-image ' . ( $val == $meta_option['value'] ? ' radio-image-selected' : '' ) . '" />';
                        $output .= '</div>';
                    }
                    break;
            }
            $output .= '<br /><p>' . esc_html($meta['description']) . '</p>';
        $output .= '</div>';
        echo balanceTags($output);
    }
}
function waves_category_meta_edit($metaArray, $id) {
    $options = get_option("taxonomy_$id");
    $output = '';
    foreach ($metaArray as $meta) {
        $val = isset($options[$meta['name']]) ? esc_attr($options[$meta['name']]) : '';
        $output .= '<tr class="form-field type-'.esc_attr($meta['type']).'">';
            $output .= '<th scope="row" valign="top"><label for="term_meta[' . esc_attr($meta['name']) . ']">' . esc_html($meta['title']) . '</label></th>';
            $output .= '<td class="form-field type-'.esc_attr($meta['type']).'">';
                switch ($meta['type']) {
                    case 'color':
                        $output .= '<input name="term_meta[' . esc_attr($meta['name']) . ']" class="waves-category-color" data-type="color" type="text" value="' . esc_attr($val) . '" style="width:100px;background-color:' . esc_attr($val) . '" />';
                        $output .= '<div style="background-color: '.esc_attr($val).'" class="color-info"></div>';
                        break;
                    case 'text':
                        $output .= '<input name="term_meta[' . esc_attr($meta['name']) . ']" type="text" value="' . esc_attr($val) . '" />';
                        break;
                    case 'checkbox':
                        $output .= '<input type="hidden" name="term_meta['.esc_attr($meta['name']).']" value="0"/>';
                        $output .= '<input type="checkbox" class="yesno" name="term_meta['.esc_attr($meta['name']).']" value="1"'.checked($val, 1, false).' />';           
                        break;
                    case 'radio':
                        foreach ($meta['options'] as $meta_option) {
                            $checked=$meta_option['value'] == $val ? 'checked ' : '';                  
                            $output .= '<div class="radio-images">';
                                $output .= '<p><input type="radio" name="term_meta[' . esc_attr($meta['name']) . ']" value="' . esc_attr( $meta_option['value'] ) . '"' . checked( $val, $meta_option['value'], false ) . ' class="option-tree-ui-radio option-tree-ui-images" /><label>' . esc_attr( $meta_option['label'] ) . '</label></p>';
                                $output .= '<img src="' . esc_url( $meta_option['src'] ) . '" alt="' . esc_attr( $meta_option['label'] ) .'" title="' . esc_attr( $meta_option['label'] ) .'" class="radio-image ' . ( $val == $meta_option['value'] ? ' radio-image-selected' : '' ) . '" />';
                            $output .= '</div>';
                        }
                        break;
                }
                $output .= '<br /><span class="description">' . esc_html($meta['description']) . '</span>';
            $output .= '</td>';
        $output .= '</tr>';
    }
    echo balanceTags($output);
}
$taxonomyName = 'pa_color';
add_action($taxonomyName . '_add_form_fields', 'waves_category_add',        10, 2);
add_action('created_' . $taxonomyName,         'waves_save_category_meta', 10, 2);
add_action($taxonomyName . '_edit_form_fields','waves_category_edit',       10, 2);
add_action('edited_' . $taxonomyName,          'waves_save_category_meta', 10, 2);
function waves_category_add($tag) {
    global $waves_categoryOptions;
    $id = isset($tag) && isset($tag->term_id) ? $tag->term_id : '';
    waves_category_meta_add($waves_categoryOptions, $id);
}
function waves_category_edit($tag) {
    global $waves_categoryOptions;
    $id = isset($tag) && isset($tag->term_id) ? $tag->term_id : '';
    waves_category_meta_edit($waves_categoryOptions, $id);
}
function waves_save_category_meta($id) {
    if (isset($_POST['term_meta'])) {
        $keys = array_keys($_POST['term_meta']);
        foreach ($keys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        if (isset($_POST['term_meta_category_bg'])) {
            $term_meta['category_bg'] = $_POST['term_meta_category_bg'];
        }
        update_option("taxonomy_$id", $term_meta);
    } else if (isset($_POST['term_meta_category_bg'])) {
        $term_meta['category_bg'] = $_POST['term_meta_category_bg'];
        update_option("taxonomy_$id", $term_meta);
    }
}
add_action('admin_print_scripts', 'cat_admin_scripts');
add_action('admin_print_styles', 'cat_admin_styles');
if (!function_exists('cat_admin_scripts')) {
    function cat_admin_scripts() {
        wp_register_script('category-js',       WAVES_FW_DIR.'assets/js/admin-category.js');
        wp_register_script('waves-colorpicker', WAVES_FW_DIR.'assets/js/admin-colorpicker.js');
        wp_enqueue_script('category-js');
        wp_enqueue_script('waves-colorpicker');
    }
}
if (!function_exists('cat_admin_styles')) {
    function cat_admin_styles() {
        wp_register_style('category-css',     WAVES_FW_DIR.'assets/css/admin-category.css', false, '1.00', 'screen');
        wp_register_style('waves-colorpicker',WAVES_FW_DIR.'assets/css/admin-colorpicker.css', false, '1.00', 'screen');
        wp_enqueue_style('category-css');
        wp_enqueue_style('waves-colorpicker');
    }
}