<?php
/* Conf */
add_filter( 'ot_theme_mode', '__return_true' );
add_filter( 'ot_show_pages', '__return_true' );
add_filter('ot_show_options_ui', '__return_false');
add_filter('ot_show_docs', '__return_false');
/* Customize Theme Options */
add_filter('ot_theme_options_parent_slug','waves_ot_theme_options_parent_slug');
function waves_ot_theme_options_parent_slug(){return is_admin()?'waves-welcome':'admin.php';}
add_filter('ot_register_pages_array'     ,'waves_ot_register_pages_array');
function waves_ot_register_pages_array($array) {
    unset($array[0]);
    $array[1]['parent_slug'] = 'waves-welcome';
    $array[1]['page_title'] = esc_html__('Options Import/Export','ninetysix');
    $array[1]['menu_title'] = esc_html__('Options Utils','ninetysix');
    return $array;
}
/* Loads OptionTree */
require_once THEME_PATH.'option-tree/ot-loader.php';
/* Loads Theme Options */
require_once WAVES_FW_PATH.'waves_options/theme-options.php';
require_once WAVES_FW_PATH.'waves_options/category-options.php';
require_once WAVES_FW_PATH.'waves_options/post-options.php';
require_once WAVES_FW_PATH.'waves_options/page-options.php';
require_once WAVES_FW_PATH.'waves_options/portfolio-options.php';
require_once WAVES_FW_PATH.'waves_options/product-options.php';