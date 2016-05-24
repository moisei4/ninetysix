<?php
/* Waves Widget */
$wavesWidgets=waves_scandir(WAVES_FW_PATH.'waves_widget/');
if(is_array($wavesWidgets)){
    foreach($wavesWidgets as $widget){
        $widgetFile=WAVES_FW_PATH.'waves_widget/'.$widget;
        if(file_exists($widgetFile)){require_once($widgetFile);}
    }
}
/* Waves Modals */
require_once(WAVES_FW_PATH.'waves_modals/waves_modals.php');
/* Waves Custom Menu */
require_once(WAVES_FW_PATH.'waves_custom_menu/waves_custom_menu.php');
/* Waves Options */
require_once(WAVES_FW_PATH.'waves_options/waves_options.php');
/* Waves Welcome */
require_once(WAVES_FW_PATH.'waves_welcome/waves_welcome.php');