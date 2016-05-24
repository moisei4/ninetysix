<?php
if(current_user_can('edit_theme_options')){
    /* Welcome */
    add_action('admin_menu','waves_menu_welcome',8);
    function waves_menu_welcome(){
        add_menu_page('ThemeWaves Page','ThemeWaves','administrator', 'waves-welcome', 'waves_menu_welcome_print', WAVES_FW_DIR.'assets/img/themewaves-20x20.png', 3 );
        add_submenu_page('waves-welcome','Welcome Page','Welcome', 'administrator', 'waves-welcome', 'waves_menu_welcome_print');
    }
    function waves_menu_welcome_print(){
        require_once(WAVES_FW_PATH.'waves_welcome/welcome.php');
    }
    /* TGM Plugins */
    if(is_admin()){require_once(WAVES_FW_PATH.'waves_welcome/tgm_plugins/tgm-plugins.php');}
}