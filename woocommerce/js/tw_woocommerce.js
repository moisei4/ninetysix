jQuery(document).ready(function($) {
    $('#yith-wcwl-form .shop_table').addClass('shop_table_responsive');
    product_add_to_cart_click();
    var in_cart = jQuery('.widget_shopping_cart_content');
    if(in_cart.text().length == 0) {
        in_cart.html('<li class="empty">No products in the cart.</li>');
    }
    jQuery('.waves-btn').each(function(){
       jQuery(this).children('a').addClass('btn btn-flat'); 
    });
    setTimeout(function() {
        wcWidgetTitle();
    }, 1);
    setTimeout(function() {
        wcWidgetTitle();
    }, 500); 
   jQuery(document).ajaxComplete(function() {
        wcWidgetTitle();
    });
    /* Modal WC */
    $('.tw_product_container .yith-wcwl-wishlistaddedbrowse i, .tw_product_container .yith-wcwl-wishlistexistsbrowse i').live('click',function(){
        var $id=$(this).closest('div.show').removeClass('show').addClass('hide').siblings('.yith-wcwl-add-button').removeClass('hide').addClass('show').find('a').data('product-id');
        $('.waves-modal-wishlist [data-row-id="'+$id+'"] .remove_from_wishlist').click();
    });
    $('.tw_product_container .add_to_wishlist').live('click',function(){
        $(this).parent().addClass('showing');
    });
    $('.waves-modal-basket .remove').live('click',function(e){e.preventDefault();
        var $cA=$(this);
        $cA.closest('tr').fadeOut();
        $.get($cA.attr('href'));
    });
    $('.waves-modal-wishlist .remove_from_wishlist').live('click',function(e){e.preventDefault();
        var $cA=$(this);
        $('.tw_product_container .add-to-wishlist-'+$cA.closest('tr').data('row-id')+'>.show:not(.yith-wcwl-add-button)').removeClass('show').addClass('hide').siblings('.yith-wcwl-add-button').addClass('show').removeClass('hide');
        $cA.closest('tr').fadeOut();
        $.get($cA.attr('href'));
        waves_wishlist_icon(0);
    });
    $('.waves-modal-wishlist .add_to_cart').live('click',function(e){
        var $cA=$(this);
        var $cHref=$cA.attr('href');
        if($cHref.search('add-to-cart')!==-1){
            e.preventDefault();
            $('.tw_product_container .add-to-wishlist-'+$cA.closest('tr').data('row-id')+'>.show').removeClass('show').addClass('hide').siblings('.yith-wcwl-add-button').addClass('show').removeClass('hide');
            $cA.closest('tr').fadeOut(400,function(){$(this).remove();waves_wishlist_icon(0);});
            $.get($cHref);
        }
    });
    $( document ).ajaxComplete(function( event,request, settings ){
        try{
            if(settings.url.search('add-to-cart')>-1||settings.url.search('remove_item')>-1){
                /* Important:request.responseText inside if is it html */
                var $html=$(request.responseText).filter('.waves-modal-basket').find('.waves-modal-inside');
                $('.waves-modal-basket .waves-modal-inside').html($html.html());
            }
            if(settings.url.search('admin-ajax.php')>-1&&settings.data.search('add_to_wishlist')>-1){
                waves_wishlist_icon(1);
                jQuery.ajax({
                    type: "POST",
                    url: waves_script_data.home_uri,
                    success: function(response){
                        $('.waves-modal-wishlist tbody').first().html($(response).filter('.waves-modal-wishlist').find('tbody').first().html());
                        waves_wishlist_icon(0);
                    }
                });
            }
            if(settings.url.search('admin-ajax.php')>-1&&settings.data.search('remove_from_wishlist')>-1){waves_wishlist_icon(0);}
        }catch(err){}
    });
    waves_wishlist_icon(0);
    waves_product_layout();
    /* Additional Filter */
    $('.waves-filters-add').live('click',function(e){e.preventDefault();
        var $fltBtn=$(this);
        var $fltCont=$fltBtn.siblings('.waves-filters-add-content');
        if($fltBtn.hasClass('active')){
            $fltBtn.removeClass('active');
            $fltCont.removeClass('opened').slideUp();
        }else{
            $fltBtn.addClass('active');
            $fltCont.addClass('opened').slideDown();
        }
    });
    $('.tw-element.tw-product').each(function(i){
        var $cElement=$(this);
        var $cAddFilt=$cElement.find('.waves-filters-add-content');
        var $cAddFiltA=$cElement.find('.waves-filters-add-content li a');
        var $cPgntn=$cElement.find('.tw-pagination');
        var $currentFilter=$cElement.find('ul.filters');
        var $currentIsotopeContainer=$cElement.children('.isotope-container');
        $cAddFiltA.live('click',function(e){e.preventDefault();
            var $a=$(this);
            var $href=$a.attr('href');
            if(!$currentIsotopeContainer.hasClass('loading-ajax')){
                $currentIsotopeContainer.addClass('loading-ajax');
                jQuery.ajax({
                    type: "POST",
                    url: $href,
                    success: function(response){
                        var $res         = jQuery(response).find('.tw-element.tw-product').eq(i);
                        var $newElements = $res.children('.isotope-container');
                        var $newFilter   = $res.find('.waves-filters-add-content');
                        var $newPag      = $res.find('.tw-pagination');
                        $currentIsotopeContainer.removeClass('loading-ajax');
                        if($newElements.length){
                            $currentIsotopeContainer.html($newElements.html());
                            showIsotopeFilter($currentFilter,$currentIsotopeContainer.children('article'));
                        }
                        if($newFilter.length){$cAddFilt.html($newFilter.html());}
                        if($cPgntn.length){
                            if($newPag.length){
                                if($cPgntn.hasClass('tw-infinite-scroll')){
                                    $cPgntn.find('.next').attr('href',$newPag.find('.next').attr('href'));
                                }else{
                                    $cPgntn.html($newPag.html());
                                }
                                $cPgntn.show();
                            }else{
                                $cPgntn.hide();
                            }
                        }
                        /* Relayout */
                        var $infIntCnt=3;
                        var $infIntTimeout=1500;
                        if($currentIsotopeContainer.find('img').length){
                            $infIntCnt=1;
                            $infIntTimeout=5000;
                            $currentIsotopeContainer.find('img').unbind("load").bind("load",function(){
                                wavesRelayout($currentIsotopeContainer);
                            });
                        }
                        var $infInt=setInterval(function(){
                            if($infIntCnt--<0){clearInterval($infInt);}
                            wavesRelayout($currentIsotopeContainer);
                        },$infIntTimeout);
                    }
                });
            }
        });
    });
});
function waves_wishlist_icon($add){
    "use strict";
    var $icn='ion-android-favorite';
    var $icn_o='ion-android-favorite-outline';
    var $cnt=jQuery('.waves-modal-wishlist tbody>tr').length+$add;
    var $cntE=jQuery('.waves-modal-wishlist tbody>tr>.wishlist-empty').length;
    var $btn = jQuery('[data-mbtn="wishlist"]');
    $btn.children('span').remove();
    if($cnt>0&&$cntE<1){
        $btn.children('i').attr('class',$icn);
        $btn.append('<span>'+$cnt+'</span>');
    }else{
        $btn.children('i').attr('class',$icn_o);
    }
}
function product_add_to_cart_click()
{
	var jbody = jQuery('body');

	jbody.on('click', '.add_to_cart_button', function()
	{
		jQuery(this).parents('.product:eq(0)').addClass('adding-to-cart-loading').removeClass('added-to-cart-check');
	})
	
	jbody.bind('added_to_cart', function()
	{
		jQuery('.adding-to-cart-loading').removeClass('adding-to-cart-loading').addClass('added-to-cart-check');
	});
	
}
/* WC Widget Title */
/* ------------------------------------------------------------------- */
function wcWidgetTitle() {
    "use strict";
    jQuery('.widget_shopping_cart_content').each(function() {
        if (jQuery(this).find('.total>.amount').hasClass('amount')) {
            var $total = 0;
            jQuery(this).find('ul>li>.quantity').each(function() {
                var $cln = jQuery(this).clone();
                $cln.find('.amount').remove();
                $total += parseInt($cln.text().replace(' × ', ''), 10);
            });
            jQuery(this).siblings('.top-widget-title').find('span.count-cart').remove();
            jQuery(this).siblings('.top-widget-title').html('<span class="count-cart">'+$total+'</span>');
        }
    });
    jQuery('.loading-cart').removeClass('loading-cart');
}
jQuery(window).resize(function(){
    "use strict";
    jQuery('.tw-product-feature').each(function(){
        var $cFtr=jQuery(this);
        var $cFtrCln=$cFtr.siblings('.tw-product-feature-clone');
        if($cFtr.length&&$cFtrCln.length){
            $cFtrCln.height($cFtr.height());
        }
    });
});
/* Layout 3 */
function waves_product_layout(){
    jQuery('.tw-product.layout-3 .product_thumb').each(function(){
        var $thmb=jQuery('>a>img',jQuery(this));
        if($thmb.length){jQuery(this).css('background-image','url('+$thmb.attr('src')+')');}
    });
    jQuery('.tw-product.layout-3 .waves-slick-slide').each(function(){
        var $thmb=jQuery('>img',jQuery(this));
        if($thmb.length){jQuery(this).css('background-image','url('+$thmb.attr('src')+')');}
    });
}