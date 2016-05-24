<?php
$atts = shortcode_atts(array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-element tw-blog',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // ----------------
    'cats'  => '',
    'posts_per_page' => '',
    'blog_layout' => 'simple',
    'more_text' => '',
    'excerpt_count' => '',
    'filter' => '',
    'pagination' => 'simple',
    'infinite_auto' => 'false',
    'not_in' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));
$class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );

$atts['custom_class'] .= $class;
    
echo waves_item($atts);
$query = Array(
    'post_type' => 'post',
    'posts_per_page' => $atts['posts_per_page'],
);
if ($atts['pagination'] == "simple" || $atts['pagination'] == "infinite") {
    global $paged;
    if (get_query_var('paged')) {
        $paged = get_query_var('paged');
    } elseif (get_query_var('page')) {
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }
    $query['paged'] = $paged;
}
$atts['cats'] = empty($atts['cats']) ? false : explode(",", $atts['cats']);
if ($atts['cats']) {
    $query['tax_query'] = Array(Array(
            'taxonomy' => 'category',
            'terms' => $atts['cats'],
            'field' => 'slug'
        )
    );
}
waves_set_options($atts);
query_posts($query);
    if($atts['blog_layout']==='grid'){
        get_template_part("content", "grid");
    } else {
        get_template_part("content");
    }
wp_reset_query();
echo '</div>';