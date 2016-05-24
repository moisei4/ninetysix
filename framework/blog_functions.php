<?php   
/* ================================================================================== */
/*      Blog Shortcode
/* ================================================================================== */

function waves_standard_media($post, $atts, $format = ''){
    $output = '';
    if (has_post_thumbnail($post->ID)) {
        $output .= '<div class="entry-media">';
            $output .= '<div class="tw-thumbnail">';
                $output .= waves_image($atts['img_size']);
                if(is_single()){
                    $img = waves_image('full' ,true);
                    $output .= '<div class="image-overlay">';
                    $output .= '<a href="'.esc_url($img['url']).'" rel="prettyPhoto['.esc_attr($post->ID).']" title="'.esc_attr(get_the_title()).'">';
                    $output .= '</a></div>';
                }else{
                    $output .= '<div class="image-overlay">';
                    $output .= '<a href="'.esc_url(get_permalink()).'" title="'.esc_attr(get_the_title()).'">';
                    $output .= '</a></div>';
                }       
                if($atts['img_size']!='waves_grid_thumb'){
                    switch ($format) {
                        case 'standard':
                            $output .= '<i class="ion-ios-paper-outline"></i>';break;
                        case 'image':
                        case 'gallery':
                            $output .= '<i class="ion-ios-camera-outline"></i>';break;
                        case 'video':
                            $output .= '<i class="ion-ios-videocam-outline"></i>';break;
                        case 'audio':
                            $output .= '<i class="ion-ios-play-outline"></i>';break;
                        case 'quote':
                            $output .= '<i class="tw-quote"></i>';break;
                        default:
                            $output .= '<i class="ion-ios-paper-outline"></i>';break;
                    }
                }
            $output .= '</div>';
        $output .= '</div>';
    }
    return $output;
}

function waves_entry_media($format, $atts) {
    global $post;
    if(!is_single() && has_post_thumbnail($post->ID)){
        return waves_standard_media($post, $atts, $format);
    }
    $output = '';
    switch ($format) {
        
        case 'image':
        case 'gallery':
        $imagess = get_post_meta( $post->ID, 'gallery_images', true );
         if ($imagess) {
             $images = explode(',',$imagess);
             wp_enqueue_script('waves-owl-carousel');
             $output .= '<div class="entry-media tw-carousel-container image-slide-container">';
                 $output .= '<div class="tw-carousel">';
                     foreach ($images as $image) {
                         $img = wp_get_attachment_image_src( $image, $atts['img_size'] );
                         $desc = get_post_field('post_excerpt', $image);
                         $output .= '<div class="tw-owl-item">';
                             $output .= '<img src="'.esc_url($img[0]).'"'.($desc ? ' title="'.$desc.'"' : '').' />';
                         $output .= '</div>';
                     }
                 $output .= '</div>';
             $output .= '</div>';
             break;
        }
        $output = waves_standard_media($post, $atts);
        break;
            
        case 'video':
            
            $embed = get_post_meta($post->ID, 'video_embed', true);
            
            if(wp_oembed_get( $embed )) {
                $output .= '<div class="entry-media">';
                        $output .= wp_oembed_get($embed);
                $output .= '</div>';
                break;
            } elseif(!empty($embed)){
                $output .= '<div class="entry-media">';
                        $output .= apply_filters("the_content", htmlspecialchars_decode($embed));
                $output .= '</div>';
                break;
            }
            $output = waves_standard_media($post, $atts);
            break;
            
        case 'audio':
            
            $mp3 = get_post_meta($post->ID, 'audio_mp3', true);
            $embed = get_post_meta($post->ID, 'audio_embed', true);
            if($mp3){
                $output .= '<div class="entry-media">';
                        $output .= apply_filters("the_content", '[audio src="'.esc_url($mp3).'"]');
                $output .= '</div>';
                break;
            } elseif(wp_oembed_get( $embed )) {
                $output .= '<div class="entry-media">';
                        $output .= wp_oembed_get($embed);
                $output .= '</div>';
                break;
            } elseif(!empty($embed)){
                $output .= '<div class="entry-media">';
                        $output .= apply_filters("the_content", htmlspecialchars_decode($embed));
                $output .= '</div>';
                break;
            }
            $output = waves_standard_media($post, $atts);
            break;
            
        case 'quote':
            $quote_text = get_post_meta($post->ID, 'quote_text', true);
            if (!empty($quote_text)) {
                    $output .= '<div class="entry-media"><blockquote>';
                    $output .= esc_html($quote_text);
                    $output .= "</blockquote></div>";
                    break;
            }
            $output = waves_standard_media($post, $atts);
            break;
            
        default: 
            waves_standard_media($post, $atts, $format);
            break;            
    }
    return $output;
}


function waves_blogcontent($atts) {
    global $post, $more;
    $more = 0;

    if (!empty($atts['excerpt_count'])) {
        echo apply_filters("the_excerpt", waves_excerpt(get_the_content(), $atts['excerpt_count']));
    } elseif (has_excerpt()) {
        the_excerpt();
    } else {
        $moretext = !empty($atts['more_text']) ? $atts['more_text'] : esc_html__('Read More','ninetysix');
        echo apply_filters('the_content', get_the_content($moretext));
    }
}

function waves_search_content($atts) {
    global $post, $more;
    $more = 0;
    
    if(has_excerpt()){
        the_excerpt();
    } elseif(!(bool) preg_match('/<!--more(.*?)?-->/', $post->post_content)){
        echo apply_filters("the_excerpt", waves_excerpt(get_the_content(), 30));
    } else{
        $moretext = !empty($atts['more_text']) ? $atts['more_text'] : esc_html__('Read More','ninetysix');
        echo apply_filters('the_content', get_the_content($moretext));
    }
}


function waves_excerpt($str, $length) {
    $str = explode(" ", strip_tags($str));
    return implode(" ", array_slice($str, 0, $length));
}

add_filter( 'the_content_more_link', 'waves_read_more_link', 10, 2);
function waves_read_more_link($content_more_link, $read_more_text) {
    $content_more_link = '<p class="more-link tw-hoverline"><a href="' . esc_url(get_permalink()) . '">'.$read_more_text.'<i class="ion-ios-arrow-thin-right"></i></a></p>';
    return $content_more_link;
}