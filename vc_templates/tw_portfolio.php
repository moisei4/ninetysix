<?php

/* ================================================================================== */
/*      Service Shortcode
  /* ================================================================================== */
wp_enqueue_script('waves-isotope');
$atts = shortcode_atts(array(
    'css' => '',
    'custom_class' => '',
    'element_class' => 'tw-element tw-portfolio tw-isotope-container',
    'element_dark' => '',
    'animation' => 'none',
    'animation_delay' => '',
    // ----------------
    'cats' => '',
    'count' => '',
    'ppadding' => '30',
    'column' => '3',
    'layout' => 'square',
    'filter' => 'none',
    'pagination' => 'simple',
    'not_in' => '',
        ), vc_map_get_attributes($this->getShortcode(), $atts));
$query = array(
    'post_type' => 'portfolio',
    'posts_per_page' => $atts['count'],
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
if (!empty($atts['not_in'])) {
    $query['post__not_in'] = array($atts['not_in']);
}
$cats = ($atts['filter'] === 'ajax' && !empty($_REQUEST['waves_isotope_filter'])) ? array($_REQUEST['waves_isotope_filter']) : (empty($atts['cats']) ? false : explode(",", $atts['cats']));
if ($cats) {
    $query['tax_query'] = Array(Array(
            'taxonomy' => 'portfolio_cat',
            'terms' => $cats,
            'field' => 'slug'
        )
    );
}

if (!is_tax()) {
    query_posts($query);
}

if (have_posts()) {

    $class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($atts['css'], ' '), $this->settings['base'], $atts);
    $output = waves_item($atts, $class);



    if ($atts['filter'] !== 'none') {
        $output .= '<div class="tw-filters">';
        $output .= '<ul class="filters clearfix ' . esc_attr($atts['filter']) . '" data-option-key="filter">';
        $output .= '<li class="tw-hoverline"><a href="#filter" data-option-value="*" class="show-all selected">' . esc_html__('Show All', 'ninetysix') . '</a></li>';
        if ($cats) {
            $filters = $cats;
        } else {
            $filters = get_terms('portfolio_cat');
        }
        foreach ($filters as $category) {
            if ($cats) {
                $category = get_term_by('slug', $category, 'portfolio_cat');
            }
            $output .= '<li' . ($atts['filter'] === 'ajax' ? '' : ' class="tw-hoverline hidden"') . '><a href="#filter" data-option-value=".category-' . esc_attr($category->slug) . '" title="' . esc_attr($category->name) . '">' . esc_html($category->name) . '</a></li>';
        }
        $output .= '</ul>';
        $output .= '</div>';
    }

    $isotop_style = ' style="margin-right: -' . $atts['ppadding'] . 'px;"';
    $article_style = ' style="padding-right: ' . $atts['ppadding'] . 'px"';

    $output .= '<div class="isotope-container" data-column="' . intval($atts['column']) . '"' . $isotop_style . '>';
    $atts['img_size'] = 'waves_portfolio_' . $atts['layout'][0] . $atts['column'];
    global $post;
    while (have_posts()) {
        the_post();


        $artClass = 'not-inited';
        $image = waves_image($atts['img_size'], true);
        $catalogs = wp_get_post_terms($post->ID, 'portfolio_cat');
        foreach ($catalogs as $catalog) {
            $artClass .= " category-" . $catalog->slug;
        }
        $content = '<div class="portfolio-content">';
        $content .= '<h2 class="portfolio-title tw-hoverline"><a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a></h2>';
        $cats = get_the_term_list($post->ID, 'portfolio_cat', '', '. ', '');
        if ($cats) {
            $content.='<p class="portfolio-meta">' . $cats . '</p>';
        }
        $content .= '</div>';

        $output .= '<article class="portfolio ' . esc_attr($artClass) . '"' . $article_style . '>';
        $output .= '<div class="portfolio-block">';
            $output .= '<div class="portfolio-thumb">';
            if($image){
                $output .= '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '"/>';
            }
            $output .= '<div class="image-overlay">';
            $output .= '<a href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '"></a>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= $content;
            $output .= '</div>';
        $output .= '</article>';
    }
    $output .= "</div>";
    ob_start();
    if ($atts['pagination'] == "simple") {
        waves_pagination();
    } elseif ($atts['pagination'] == "infinite") {
        waves_infinite();
    }
    $output .= ob_get_clean();

    $output .= "</div>";

    echo balanceTags($output);
}
wp_reset_query();
