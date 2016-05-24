/* Resize */
jQuery(window).resize(function(){
    "use strict";
    jQuery('.modal-opened .waves-modal-close-btn').click();
    /* Nested BG */
    jQuery('.waves-nested-bg').each(function(){
        var $curr=jQuery(this).css('backgound-color','');
        var $currColor='red';
        $curr.parents().each(function(){
            var $subColor=jQuery(this).css('background-color').replace(/ /gi,'');
            if($subColor!==''&&$subColor!=='transparent'&&$subColor!=='rgba(0,0,0,0)'){
                $currColor=$subColor;
                return false;
            }
        }).promise().done(function(){$curr.css('background-color',$currColor);});
    });
    /* waves-map-contact */
    jQuery('.waves-map').not(".styled").each(function(){
        jQuery(this).height(jQuery(this).children('.map').find('iframe').height());
    });

    /*  ThemeWaves Redraw */
    jQuery('.tw-redraw').each(function() {
        var $curr = jQuery(this);
        if (!$curr.hasClass('not-drawed')) {
            $curr.trigger('tw-animate');
        }
    });

    /* Mega Menu Resize */
    try{
        var $megaHeader    =jQuery('.waves-header-inner>.container>.row');
        var $megaHeaderLeft=0;
        var $megaHeaderWidth=0;
        if(jQuery('body').hasClass('theme-boxed')){
            $megaHeaderLeft=jQuery('#theme-layout').offset().left;
            $megaHeaderWidth=jQuery('#theme-layout').width();
        }else{
            $megaHeaderLeft =$megaHeader.closest('.container').offset().left+parseInt($megaHeader.closest('.container').css('padding-left').replace('px', ''), 10);
            $megaHeaderWidth=$megaHeader.closest('.container').width();
        }
        jQuery('.waves-mega-menu').each(function(){
            var $currMega=jQuery(this);
            var $currMegaWidth=0;
            var $liW=0;
            var $rem=0;
            var $currMegaLeft=0;
            var $colCnt  =parseInt($currMega.data('col').replace('column-', ''), 10);
            $currMega.css({'display':'block','opacity':'0','width':''});
            jQuery('>li',$currMega).each(function(){
                jQuery(this).css('width','');
                if(jQuery(this).width()>$liW){
                    $liW=jQuery(this).width();
                }
            }).promise().done(function(){
                $currMega.css('margin-left','0px').css('left','0px');
                $currMegaLeft=$currMega.offset().left;
                if($colCnt<=3){
                    $currMegaWidth=$liW*$colCnt;
                    $rem=($megaHeaderLeft+$megaHeaderWidth)-($currMegaLeft+$currMegaWidth);
                }else{
                    $currMegaWidth=$megaHeaderWidth;
                    $liW=$currMegaWidth/$colCnt;
                    $rem=$megaHeaderLeft-$currMegaLeft;
                }
                jQuery('>li',$currMega).width($liW);
                $currMega.width($currMegaWidth);
                
                if($rem<0){
                    $currMega.css('margin-left',$rem+'px');
                }else{
                    $currMega.css('margin-left','').css('left','');
                }
                
                $currMega.css({'display':'none','opacity':'','visibility':'hidden'});
            });
        });
    }catch(err){}
});
jQuery(document).ready(function($){
    "use strict";
    /* Waves Modals */
    var $mdlOverlay=$('.waves-modal-overlay');
    $('.waves-mbtn').each(function(){
        var $c=$(this);
        var $cMdl=$('.waves-modal-'+$c.data('mbtn'));
        var $wst=$(window).scrollTop();
        $c.click(function(e){e.preventDefault();
            if($c.hasClass('active')){
                $c.removeClass('active');
                $cMdl.removeClass('active');
                $('body').removeClass('modal-opened');
                $cMdl.css('padding-top','');
                $(window).scrollTop($wst);
            }else{
                var $mdlSpace=0;
                $('.waves-mbtn.active').click();
                $wst=$(window).scrollTop();
                $c.addClass('active');
                $('body').addClass('modal-opened');
                $cMdl.addClass('active').siblings('.waves-modal-item').removeClass('active');
                var $hdr=$('.waves-header');
                if($('body').hasClass('header-left-side')){
                    var $mdlSpaceTop=0;
                    if($('body').hasClass('admin-bar')){$mdlSpaceTop+=$('#wpadminbar').height();}
                    if($(window).width()<=480){
                        $mdlSpaceTop+=$hdr.height()+twItemTB($hdr);
                    }else{
                        $mdlSpace=$hdr.width()+twItemRL($hdr);
                    }
                    $cMdl.css({'margin-top':$mdlSpaceTop+'px','height':($(window).height()-$mdlSpaceTop)+'px'});
                    $mdlOverlay.css('top',$mdlSpaceTop+'px');
                    $cMdl.css('padding-left',$mdlSpace+'px');
                    $mdlOverlay.css('left',$mdlSpace+'px');
                }else{
                    $('body').addClass('header-small');
                    $mdlSpace=$hdr.height()+twItemTB($hdr);
                    if($('body').hasClass('admin-bar')){$mdlSpace+=$('#wpadminbar').height();}
                    $cMdl.css({'margin-top':$mdlSpace+'px','height':($(window).height()-$mdlSpace)+'px'});
                    $mdlOverlay.css('top',$mdlSpace+'px');
                }
            }
        });
    });
    $('.waves-modal-close-btn,.waves-modal-item').click(function(e){
        var $cls=(jQuery(this).hasClass('waves-modal-item')&&jQuery(this).hasClass('inside-clicked'))?false:true;
        jQuery(this).removeClass('inside-clicked');
        if($cls){e.preventDefault();$('.waves-mbtn.active').click();}
    });
    $('.waves-modal-inside').click(function(){jQuery(this).closest('.waves-modal-item').addClass('inside-clicked');});
    /* Widget instagram */
    if ($().owlCarousel !== undefined && $().owlCarousel !== 'undefined') {
        $('.null-instagram-feed>.owl-carousel').each(function () {
            var $cOwl = $(this);
            var $singleItem = $cOwl.closest('.bottom-area').hasClass('bottom-area') ? false : true;
            var $items = $cOwl.closest('.bottom-area').hasClass('bottom-area') ? 6 : 1;
            var $pagination = $cOwl.closest('.bottom-area').hasClass('bottom-area') ? false : true;
            var $navigation = $cOwl.closest('.bottom-area').hasClass('bottom-area') ? true : false;
            var $autoPlay = $cOwl.data('auto-play');
            if ($autoPlay === '') {
                $autoPlay = false;
            }
            $cOwl.owlCarousel({
                autoPlay: $autoPlay,
                navigationText: ["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"],
                navigation: $navigation,
                pagination: $pagination,
                items: $items,
                singleItem: $singleItem
            });
        });
    }
    /* Animated Background Colors */
    $('.btn-border').each(function(){
        var $color = $(this).css('color');
        var $bcolor = $(this).css('border-color');
        $(this).hover(function(){ 
                $(this).css('color',($color.replace(/ /gi,'')==='rgb(255,255,255)'||$color==='#ffffff'||$color==='#fff'?'#1f1f1f':'#fff'));
                $(this).css('background-color', $color);
                $(this).css('border-color', $color);
            },function(){
                $(this).css('color', $color);
                $(this).css('border-color', $bcolor);
                $(this).css('background-color', '');
            }
        );
    });
    $('.btn-flat').each(function(){
        var $bcolor = $(this).css('background-color');
        var $color = $(this).css('color');
        $(this).hover(function(){ 
                $(this).css('color',$bcolor);
                $(this).css('border-color',$bcolor);
                $(this).css('background-color', 'transparent');
            },function(){
                $(this).css('color', $color);
                $(this).css('background-color', $bcolor);
            }
        );
    });
    
    /* Animated Buttons on Animation Page please remove it after */
    jQuery('.animations a').click(function() {
        var $cls=jQuery(this).attr('id');
        jQuery('#animate-object').removeAttr('class');
            setTimeout(function(){jQuery('#animate-object').addClass($cls).addClass('animated');},10);
    });

    /* ThemeWaves Animate General - Init */
    $('.tw-animate-gen').each(function() {
        var $curr = $(this);
        var $currChild = $curr.children().eq(-1);
        if ($currChild.attr('id') === 'sidebar' || $currChild.hasClass('tw-pricing') || $currChild.hasClass('tw-our-team') || $currChild.hasClass('tw-blog')) {
            $currChild.children().addClass('tw-animate-gen').attr('data-animation', $curr.attr('data-animation')).attr('data-animation-delay', $curr.attr('data-animation-delay')).attr('data-animation-offset', $curr.attr('data-animation-offset')).css('opacity', '0');
            $curr.removeClass('tw-animate-gen').attr('data-animation', '').attr('data-animation-delay', '').attr('ddata-animation-offset', '').css('opacity', '');
        }
        if ($currChild.hasClass('carousel-anim')) {
            $currChild.find('ul.waves-carousel>li').css('opacity', '0');
            $curr.css('opacity', '');
        }
    });
    /* --------------- */
    $(window).resize();
});
jQuery(window).load(function() {
    "use strict";
    /* Google Map Style */
    jQuery('.tw-map').each(function(i){
        var $currMapID='waves-map-styled-'+i;
        var $currMap=jQuery(this);
        var $currMapStyle=$currMap.data('style');
        var $currMapMouse=$currMap.data('mouse');
        var $currMapLat=$currMap.data('lat');
        var $currMapLng=$currMap.data('lng');
        var $currMapZoom=$currMap.data('zoom');
        var $currMapArea=$currMap.children('.map').attr('id',$currMapID);
        
        var $map;
        var $center = new google.maps.LatLng($currMapLat,$currMapLng);
        var MY_MAPTYPE_ID = 'custom_style_'+i;
        $map = new google.maps.Map(
            document.getElementById($currMapID),
            {
                zoom: $currMapZoom,
                center: $center,
                mapTypeControlOptions:{
                    mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
                },
                mapTypeId: MY_MAPTYPE_ID
            }
        );
        $map.setOptions({scrollwheel:$currMapMouse});
        var $featureOpts = eval($currMap.data('json'));
        
        $map.mapTypes.set(MY_MAPTYPE_ID, new google.maps.StyledMapType($featureOpts,{name: $currMapStyle}));
        /* markers */
        if(jQuery().waypoint!==undefined&&jQuery().waypoint!=='undefined'){
            $currMap.waypoint(function() {
                $currMapArea.siblings('.map-markers').children('.map-marker').each(function(j){
                    var $currMar=jQuery(this);
                    var $currMarTitle=$currMar.data('title');
                    var $currMarLat=$currMar.data('lat');
                    var $currMarLng=$currMar.data('lng');
                    var $currMarIconSrc=$currMar.data('iconsrc');
                    var $currMarIconWidth=$currMar.data('iconwidth');
                    var $currMarIconHeight=$currMar.data('iconheight');

                    var markerOp={
                        position: new google.maps.LatLng($currMarLat,$currMarLng),
                        map: $map,
                        title: $currMarTitle,
                        animation: google.maps.Animation.DROP,
                        zIndex: j
                    };
                    if($currMarIconSrc&&$currMarIconWidth&&$currMarIconHeight){
                        markerOp.icon={
                            url: $currMarIconSrc,
                            size: new google.maps.Size($currMarIconWidth, $currMarIconHeight),
                            origin: new google.maps.Point(0,0),
                            anchor: new google.maps.Point(parseInt($currMarIconWidth,10)/2,$currMarIconHeight)
                        };
                    }
                    setTimeout(function() {
                        var marker = new google.maps.Marker(markerOp);
                        var infowindow = new google.maps.InfoWindow({content: $currMar.html()});
                        google.maps.event.addListener(marker, 'click', function() {
                            if(infowindow.getMap()){
                                infowindow.close();
                            }else{
                                infowindow.open($map,marker);
                            }
                        });
                    }, j * 300);
                });
            }, {triggerOnce: true, offset: 'bottom-in-view'});
        }
    });
    /*----------------------------Initial Functions-----------------------------------------------*/
    wavesReInit(jQuery('#theme-layout'));
    waves_carousel();
    /* ThemeWaves Animate General - Bind */
    jQuery('.tw-animate-gen').each(function() {
        var $curr = jQuery(this);
        var $currChild = $curr.children().eq(-1);
        var $removeClass = true;
        if ($curr.data('animation') === 'pulse' || $curr.data('animation') === 'floating' || $curr.data('animation') === 'tossing') {
            $removeClass = false;
        }
        $curr.bind('tw-animate', function() {
            var $currDelay = parseInt($curr.attr('data-animation-delay'), 10);
            if($currDelay<0){$currDelay=0;}
            setTimeout(function(){
                if ($currChild.hasClass('carousel-anim')) {
                    $currChild.find('ul.waves-carousel>li').each(function(i) {
                        var $currLi = jQuery(this);
                        setTimeout(function() {
                            $currLi.css('opacity', '');
                            $currLi.addClass('animated ' + $curr.data('animation'));
                            if ($removeClass) {
                                setTimeout(function() {
                                    $currLi.removeClass('animated');
                                    $currLi.removeClass($curr.data('animation'));
                                }, 3000);
                            }
                        }, 300 * i);
                    });
                } else {
                    $curr.css('opacity', '');
                    $curr.addClass('animated ' + $curr.data('animation'));
                    if ($removeClass) {
                        setTimeout(function() {
                            $curr.removeClass('animated');
                            $curr.removeClass($curr.data('animation'));
                        }, 3000);
                    }
                }
            },$currDelay);
        });
    });
    /* ThemeWaves Animate General and Custom */
    jQuery('.tw-animate-gen,.tw-animate').each(function() {
        var $curr = jQuery(this);
        var $currOffset = $curr.attr('data-animation-offset');
        if ($currOffset === '' || $currOffset === 'undefined' || $currOffset === undefined) {
            $currOffset = 'bottom-in-view';
        }
        if ($currOffset === 'none') {
            $curr.trigger('tw-animate');
        } else {
            if(jQuery().waypoint!==undefined&&jQuery().waypoint!=='undefined'){
                $curr.waypoint(function() {
                    $curr.trigger('tw-animate');
                }, {triggerOnce: true, offset: $currOffset});
            }
        }
    });
    jQuery(window).resize();
    jQuery(window).scroll();
});

function waves_carousel() {
    "use strict";
    if(jQuery().owlCarousel!==undefined&&jQuery().owlCarousel!=='undefined'){
        jQuery('.tw-carousel-container').each(function() {
            var $currCrslCont=jQuery(this);
            var $items = parseInt($currCrslCont.data('items'),10)?parseInt($currCrslCont.data('items'),10):1;
            var $itemsDesktop = false;     /*[1199,4]*/
            var $itemsDesktopSmall = [979,2];/*[979,3]*/
            var $itemsTablet = [768,1];      /*[768,2]*/
            var $itemsTabletSmall = false; /*false or [768,2]*/
            var $itemsMobile = [479,1];    /*[479,1]*/
            var $itemsCustom = false;      /*false or [479,1]*/
            var $singleItem = false;
            var $auto = $currCrslCont.data('autoplay')===''?false:$currCrslCont.data('autoplay');
            var $navigation = false;
            var $pagination = true;
            var $navigationText = ["<i class='ion-ios-arrow-left'></i>","<i class='ion-ios-arrow-right'></i>"];
            var $currentCrsl = $currCrslCont.find('.tw-carousel');
            if (jQuery(this).hasClass('tw-post-carousel')) {
                $items = 3;
            } else if ($currCrslCont.hasClass('image-slide-container')) {
                $currCrslCont.addClass('verif');
                $itemsDesktopSmall = [979,1];
            }
            $currentCrsl.owlCarousel({
                items : $items,
                itemsDesktop :     $itemsDesktop,
                itemsDesktopSmall :$itemsDesktopSmall,
                itemsTablet:       $itemsTablet,
                itemsTabletSmall:  $itemsTabletSmall,
                itemsMobile :      $itemsMobile,
                itemsCustom :      $itemsCustom,
                autoPlay: $auto,
                singleItem:$singleItem,
                slideSpeed:800,
                pagination:$pagination,
                paginationSpeed:900,
                rewindSpeed:500,
                navigationText : $navigationText,
                autoHeight : false,
                navigation : $navigation,
                afterAction : function(elem){
    /*              Waves Custom Auto Height */
                    var $max=0;
                    var $visItems=this.owl.visibleItems;
                    var n=$visItems.length;
                    setTimeout(function(){
                        jQuery('.tw-post-carousel .no-thumb').each(function(){
                            var $currIcon=jQuery(this);
                            var $currWidth=$currIcon.width();
                            var $diff=parseInt($currIcon.data('twwidth'),10)/parseInt($currIcon.data('twheight'),10);
                            $currIcon.height($currWidth/$diff);
                        });
                        jQuery('>.owl-wrapper-outer>.owl-wrapper>.owl-item',elem).removeClass('owl-visible-first').removeClass('owl-visible').removeClass('owl-visible-last');
                        for (var i = 0; i < n; i++) {
                            var $curr=jQuery('>.owl-wrapper-outer>.owl-wrapper>.owl-item',elem).eq($visItems[i]).addClass('owl-visible');
                            if($curr.height()>$max){$max=$curr.height();}
                            if(i===0){$curr.addClass('owl-visible-first');}
                            if((i+1)===n){$curr.addClass('owl-visible-last');}
                        }
                        jQuery('>.owl-wrapper-outer',elem).animate({height:$max},500);
                    },100);
                }
            });
        });
    }
}

/* Item Right Left Width */
/* ------------------------------------------------------------------- */
function wavesReInit($selector){
    "use strict";
    /* PrettyPhoto */
    jQuery("a[rel^='prettyPhoto']",$selector).prettyPhoto({
        deeplinking: false,
        social_tools: false,
        default_width: 720,
        default_height: 410
    });
    /* Video Responsive */
    jQuery('.waves-main iframe').each(function(){
        if(!jQuery(this).closest('.ls-slide').hasClass('ls-slide')&&!jQuery(this).hasClass('fluidvids-elem')){
            jQuery(this).addClass('makeFluid');
        }
    });
    Fluidvids.init({
        selector: '.waves-main iframe.makeFluid',
        players: ['www.youtube.com', 'player.vimeo.com']
    });
    jQuery('.waves-main iframe').removeClass('makeFluid');
    /* PrettyPhoto */
    if (jQuery().slick !== undefined && jQuery().slick !== 'undefined') {
        jQuery('.tw-product-images').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            prevArrow: '<i class="ion-ios-arrow-thin-left"></i>',
            nextArrow: '<i class="ion-ios-arrow-thin-right"></i>',
            fade: true,
            adaptiveHeight: false,
            asNavFor: '.tw-product-thumbs'
        });
        jQuery('.tw-product-thumbs').slick({
            arrows: false,
            slidesToShow: 6,
            asNavFor: '.tw-product-images',
            dots: false,
            vertical: true,
            centerMode: false,
            focusOnSelect: true
        });
    }
}

/* Item Top Bottom Height */
/* ------------------------------------------------------------------- */
function twItemTB($item) {
    "use strict";
    $item = jQuery($item);
    var $itemMarginTB = parseInt($item.css('margin-top').replace('px', ''), 10) + parseInt($item.css('margin-bottom').replace('px', ''), 10);
    var $itemPaddingTB = parseInt($item.css('padding-top').replace('px', ''), 10) + parseInt($item.css('padding-bottom').replace('px', ''), 10);
    var $itemBorderTB  = parseInt($item.css('border-top-width').replace('px',''),10) + parseInt($item.css('border-bottom-width').replace('px',''),10);
    var $itemTB = $itemMarginTB + $itemPaddingTB + $itemBorderTB;
    return $itemTB;
}
/* Item Right Left Width */
/* ------------------------------------------------------------------- */
function twItemRL($item) {
    "use strict";
    $item = jQuery($item);
    var $itemMarginRL  = parseInt($item.css('margin-left').replace('px', '')      ,10) + parseInt($item.css('margin-right').replace('px', '')      ,10);
    var $itemPaddingRL = parseInt($item.css('padding-left').replace('px', '')     ,10) + parseInt($item.css('padding-right').replace('px', '')     ,10);
    var $itemBorderRL  = parseInt($item.css('border-left-width').replace('px', ''),10) + parseInt($item.css('border-right-width').replace('px', ''),10);
    var $itemRL = $itemMarginRL + $itemPaddingRL + $itemBorderRL;
    return $itemRL;
}