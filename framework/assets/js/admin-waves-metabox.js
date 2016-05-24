/* Resize */
function showHidePostFormatField(){
    "use strict";
    var $CFrmt=jQuery('#post-formats-select input:radio:checked');
    if($CFrmt.length){
        jQuery('#page_options .ot-metabox-nav [href="#setting_'+$CFrmt.val().replace("0", "general")+'"]').click();  
    }
}
jQuery(window).load(function(){
    "use strict";
    /* Post format */
    showHidePostFormatField();
    jQuery('#post-formats-select input').change(showHidePostFormatField);
});