<?php get_header();
the_post();
waves_seen_add();

$atts = waves_get_options();
$atts['img_size'] = 'waves_blog_thumb';
$width = ' col-md-7';
$space = '<div class="col-md-1"></div>';

$format = get_post_format() == "" ? "standard" : get_post_format();
$media = waves_entry_media($format, $atts);

if($atts['single_layout'] == 'full-width'){
    $space = '';
    $width = ' col-md-12';
}

?>
    <div class="row">
        <?php echo ($space); ?>
        <div class="waves-main <?php echo esc_attr($atts['single_layout'].$width);?>"><?php
            if(post_password_required()){
                the_content();
            }else{ ?>
                <article <?php post_class('single'); ?>>
                    <?php
                        if($media){
                            echo balanceTags($media);
                        } elseif(!empty($space)) {
                            echo waves_standard_media($post, $atts);        
                        }
                    ?>
                    <div class="entry-date"><span><?php echo get_the_time(get_option('date_format')); ?></span></div>
                    <h1 class="entry-title"><?php the_title(); ?></h1>    
                    <div class="entry-content">
                        <?php the_content(); ?>
                        <?php wp_link_pages(); ?>
                        <div class="clearfix"></div>
                    </div>            
                    <?php 
                        echo '<div class="entry-footer"><div class="row">';
                            $share_width = 'col-md-12';
                            $tags = get_the_tag_list(('<div class="entry-tags tw-hoverline"><span>'.esc_html__('Tags', 'ninetysix').'</span>'), ', ', '</div>');
                            if($tags){
                                echo '<div class="col-md-6">'.$tags.'</div>';
                                $share_width = 'col-md-6';
                            }
                            echo '<div class="'.$share_width.'">';
                                waves_post_share();
                            echo '</div>';
                        echo '</div></div>';
                    ?>
                </article>
                <?php 
                    $prev = get_adjacent_post(false,'',true) ;
                    $next = get_adjacent_post(false,'',false) ;
                ?>
                <div class="nextprev-postlink clearfix">                    
                    <div class="col-md-6">
                        <?php if ( isset($next->ID) ):
                            $pid = $next->ID; ?>
                            <div class="prev-post-link">
                                <a href="<?php echo esc_url(get_permalink( $pid )); ?>"><?php echo ('<span><i class="ion-ios-arrow-thin-left"></i>'.esc_html__('Newer', 'ninetysix').'</span><h4>'.get_the_title( $pid ).'</h4>'); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <?php if ( isset($prev->ID) ):
                            $pid = $prev->ID; ?>
                            <div class="next-post-link">
                                <a href="<?php echo esc_url(get_permalink( $pid )); ?>" title="<?php echo get_the_title( $pid );?>"><?php echo ('<span>'.esc_html__('Older', 'ninetysix').'<i class="ion-ios-arrow-thin-right"></i></span><h4>'.get_the_title( $pid ).'</h4>'); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                comments_template('', true);
            } ?>
        </div>
        <?php if($atts['single_layout'] == 'with-sidebar'){ get_sidebar(); } ?>
    </div>
<?php get_footer();