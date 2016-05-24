<?php get_header(); ?>
<?php
the_post();
$waves_options = waves_get_options();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('single-portfolio'); ?>><?php
    if(post_password_required()){
        the_content();
    } else {
        echo '<div class="row">';
            echo '<div class="col-md-3">';
                echo '<h1 class="portfolio-title">'.get_the_title().'</h1>';
                $cats = get_the_term_list( $post->ID, 'portfolio_cat', '<div class="tw-hoverline">', ', ', '</div>' );
                echo ($cats);
            echo '</div>';
            $link1 = $link2 = $client_html = '';
            $url = waves_metabox('project_url');
            $project_url = $url ? ('<a class="project-link btn btn-border" href="'.esc_url($url).'">'.waves_option('portfolio_button', esc_html__('Launch Project', 'ninetysix')).'</a>') : '';;
            
            if($waves_options['single_layout'] != 'full-width'){
                $meta_width = 'col-md-12';
                $content_width = 'col-md-5';
                $sidebar_width = 'col-md-4';
                $link1 = $project_url;
            } else {
                $meta_width = 'col-md-4';
                $content_width = 'col-md-9';
                $sidebar_width = 'col-md-12';
                $link2 = $project_url;
            }
            $client = waves_metabox('client');
            
            if ($client != ''){
                if($waves_options['single_layout'] == 'full-width'){
                    $meta_width = 'col-md-3';
                }
                $client_html .= '<div class="meta-item '.esc_attr($meta_width).'"><h3 class="meta-title">'.waves_option('portfolio_client', esc_html__('Client', 'ninetysix')).'</h3>';
                $client_html .= '<span>'.esc_html($client).'</span></div>';
            }
            if($waves_options['single_layout'] == 'full-width'){
                $client_html .= '<div class="meta-item '.esc_attr($meta_width).'"><h3 class="meta-title">'.waves_option('portfolio_cat', esc_html__('Categories', 'ninetysix')).'</h3>';
                $client_html .= $cats.'</div>';
            }
            
            echo '<div class="'.esc_attr($content_width).'">';
                echo '<h3 class="meta-title">'.waves_option('portfolio_desc', esc_html__('Description', 'ninetysix')).'</h3>';
                the_content();
            echo '</div>';
            echo '<div class="'.esc_attr($sidebar_width).'"><div class="portfolio-meta"><div class="row">';
                
                echo '<div class="meta-item '.esc_attr($meta_width).'"><h3 class="meta-title">'.waves_option('portfolio_date', esc_html__('Date', 'ninetysix')).'</h3>';
                echo '<span>'.get_the_time('j F Y').'</span></div>';
                
                echo ($client_html);
                
                echo '<div class="meta-item '.esc_attr($meta_width).'"><h3 class="meta-title">'.waves_option('portfolio_share', esc_html__('Share', 'ninetysix')).'</h3>';
                echo '<span>'.waves_post_share().'</span></div>';
                
            echo '</div>'.$link1.'</div></div>';

        echo '</div><!-- .row -->';
        
        $p_content = waves_metabox('content_page');
        $p_gallery = waves_metabox('gallery');
        if($p_content){
            echo apply_filters('the_content', get_post_field('post_content', $p_content));
        } elseif($p_gallery){
            echo do_shortcode('[tw_gallery images="'.$p_gallery.'"]');
        }

        echo ($link2);
    } ?>
</article>
<?php 
    $ppage = waves_option('portfolio_page');
    if($ppage){
        ob_start();
        previous_post_link('%link', '<i class="ion-ios-arrow-thin-left"></i>');
        $prev = ob_get_clean();
        ob_start();
        next_post_link('%link', '<i class="ion-ios-arrow-thin-right"></i>');
        $next = ob_get_clean(); ?>
        <div class="single-portfolio-navigation">
            <?php echo balanceTags($prev?$prev:'<i class="ion-ios-arrow-thin-left"></i>');?>
            <a href="<?php echo esc_url(get_permalink($ppage));?>"><?php echo '<i class="ion-grid"></i>';?></a>
            <?php echo balanceTags($next?$next:'<i class="ion-ios-arrow-thin-right"></i>'); ?>
        </div>
    <?php }
get_footer();