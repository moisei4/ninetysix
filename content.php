<?php
if (have_posts()) {
    $atts = waves_get_options();
    $atts['img_size'] = 'waves_blog_thumb';
    $content_func = 'waves_blogcontent';
    if(is_search()){
        $content_func = 'waves_search_content';
    }    
    while (have_posts()) { the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php 
            $format = get_post_format();
            $media = waves_entry_media($format, $atts);
            
            echo '<div class="entry-post">';                
               
                    ob_start();
                        call_user_func($content_func, $atts);
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
    if($atts['pagination']=="simple"){
        waves_pagination();
    }elseif($atts['pagination']=="infinite"){
        waves_infinite('simple'.($atts['infinite_auto']==='true'?' infinite-auto':''));
    }
}   