<?php
if (have_posts()) {
    wp_enqueue_script('waves-isotope');
    
    $atts = waves_get_options();
    
    $atts['grid_column'] = isset($atts['grid_column']) ? $atts['grid_column'] : 'col-md-4';
    $atts['img_size'] = 'waves_grid_thumb';

    echo '<div class="grid-blog clearfix">';
    echo '<div class="row">';
    echo '<div class="tw-isotope-container">';
    
    if ($atts['filter'] == 'true') {
        echo '<div class="tw-filters">';
            echo '<ul class="filters clearfix '.esc_attr($atts['filter']).'" data-option-key="filter">';
                echo '<li class="tw-hoverline"><a href="#filter" data-option-value="*" class="show-all selected">'.esc_html__('Show All', 'ninetysix').'</a></li>';
                if ($atts['cats']) {
                    $filters = $atts['cats'];
                } else {
                    $filters = get_terms('category');
                }
                foreach ($filters as $category) {
                    if ($atts['cats']) {
                        $category = get_term_by('slug', $category, 'category');
                    }
                    echo '<li class="tw-hoverline hidden"><a href="#filter" data-option-value=".category-' . esc_attr($category->slug) . '" title="' . esc_attr($category->name) . '">' . esc_html($category->name) . '</a></li>';
                }
            echo '</ul>';
        echo '</div>';
    }
    
    echo '<div class="isotope-container">';
    while (have_posts()) { the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class($atts['grid_column']); ?>>
            <?php 
            $format = get_post_format();
            $media = waves_entry_media($format, $atts);
            
            echo '<div class="entry-post">';                
               
                    ob_start();
                        waves_blogcontent($atts);
                    $blogcontent = ob_get_clean();
                    echo balanceTags($media);
                    echo '<div class="entry-date"><span>'.get_the_time(get_option('date_format')).'</span></div>';
                    echo '<h2 class="entry-title"><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h2>';
                    if(!empty($blogcontent)){
                        echo '<div class="entry-content clearfix">';
                            echo balanceTags($blogcontent);
                            if ((!(bool) preg_match('/<!--more(.*?)?-->/', $post->post_content) || !empty($atts['excerpt_count'])) && !empty($atts['more_text'])){
                                echo '<p class="more-link tw-hoverline"><a href="'.esc_url(get_permalink()).'"><span>'.esc_html($atts['more_text']).'</span><i class="ion-ios-arrow-thin-right"></i></a></p>';
                            }
                        echo '</div>';
                    }
                    
            echo '</div>';
            ?>
        </article><?php
    }
    echo '</div>';
    
    if($atts['pagination']=="simple"){
        waves_pagination();
    }elseif($atts['pagination']=="infinite"){
        waves_infinite($atts['infinite_auto']==='true'?'infinite-auto':'');
    } 
    
    echo '</div>';
    echo '</div>';
    echo '</div>';
  
    wp_reset_query();
}   
