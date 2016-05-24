jQuery(document).ready(function(){
    "use strict";
    jQuery('.waves-category-color[data-type="color"]').each(function(){
        var $currentInput=jQuery(this);
        jQuery($currentInput.siblings(".color-info")).ColorPicker({
            onShow: function (colpkr) {
                jQuery(colpkr).find('.colorpicker_hex>input').val($currentInput.val().replace('#','')).change();
                jQuery(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                jQuery(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb, el) {
                $currentInput.siblings('.color-info').css('background-color','#' + hex);
                $currentInput.val('#' + hex).change().trigger('input');
            }
        });
        $currentInput.unbind('input change').bind('input change',function(){
            if(jQuery(this).val()===''){
                jQuery(this).val(' ');
            }else if(jQuery(this).val().search(' ')!==-1){
                jQuery(this).val(jQuery(this).val().replace(/ /gi,''));
            }
            $currentInput.siblings('.color-info').css('background-color',jQuery(this).val());
        });
        jQuery(this).change();
    });
});