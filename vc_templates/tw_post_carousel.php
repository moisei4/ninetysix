<?php

/* ================================================================================== */
/*      Post Carousel
/* ================================================================================== */

$atts = shortcode_atts(array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-element tw-carousel-container tw-post-carousel',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // ----------------
    'cats'  => '',
    'count' => '6',
    'excerpt_count' => '',
    'img_height' => '200',
    'img_width' => '340',
), vc_map_get_attributes($this->getShortcode(),$atts));

$query = array(
    'post_type' => 'post',
    'posts_per_page' => $atts['count'],
);
$cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);
if ($cats) {
    $query['tax_query'] = Array(Array(
            'taxonomy' => 'category',
            'terms' => $cats,
            'field' => 'slug'
        )
    );
}
$class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );
$output = waves_item($atts,$class);
    query_posts($query);
        if (have_posts()) {
            wp_enqueue_script('waves-owl-carousel');
            global $post;
            $output .= '<div class="tw-carousel">';
            while(have_posts()){ the_post();
                    ob_start();
                    waves_blogcontent($atts);
                    $contentt = ob_get_clean();
                    $thumb = '';
                    if(!empty($atts['img_height'])){
                        $format = get_post_format() == "" ? "standard" : get_post_format();
                        $thumb = waves_standard_media($post, $atts);
                        if($thumb == ''){
                            $thumb = '<div class="no-thumb" data-twwidth="'.esc_attr($atts['img_width']).'" data-twheight="'.esc_attr($atts['img_height']).'"></div>';
                        }
                        $thumb = '<div class="carousel-thumb-container '.$format.'"><div class="carousel-thumb">'.$thumb.'</div></div>';
                    }
                    
                    $output .= '<div class="tw-owl-item">';
                            $output .= $thumb.'<div class="carousel-content">';
                                    $output .= '<h3 class="carousel-title"><a href="'.esc_url(get_permalink()).'">' . get_the_title() . '</a></h3>';
                                    $output .= '<p>'.strip_tags($contentt).'</p>';
                            $output .= '</div>';
                    $output .= "</div>";
            }
            $output .= "</div>";
        }
    wp_reset_query();

$output .= "</div>";
/* ================================================================================== */
echo balanceTags($output);