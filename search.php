<?php get_header();
$waves_options['blog_layout'] = "simple-side";
$waves_options['pagination'] = "simple";
$waves_options['more_text'] = waves_option("more_text", "Read more");

$noside = array('simple', 'grid');
$grid = array('grid', 'grid-side');

$width = ' col-md-7';
$space = '<div class="col-md-1">&nbsp;</div>';
waves_set_options($waves_options);
?>
<div class="row"> 
    <?php echo ($space); ?>
    <div class="waves-main <?php echo esc_attr($waves_options['blog_layout'].$width);?>">
        <?php 
        if (have_posts ()) {
            get_template_part("content");    
        } else { ?>
            <div id="error404-container">
                <h3 class="error404"><?php esc_html_e("Sorry, but nothing matched your search criteria. Please try again with some different keywords.", "ninetysix");?></h3>
                <?php get_search_form(); ?>
                <br/>
                <div class="error-404-child"></div>

                <div class="tw-404-error"><p><?php esc_html_e("For best search results, mind the following suggestions:", "ninetysix");?></p>
                    <ul class="borderlist">
                        <li><?php esc_html_e("Always double check your spelling.", "ninetysix");?></li>
                        <li><?php esc_html_e("Try similar keywords, for example: tablet instead of laptop.", "ninetysix");?></li>
                        <li><?php esc_html_e("Try using more than one keyword.", "ninetysix");?></li>
                    </ul>
                </div>
            </div><?php
        }
        ?>
    </div>
    <?php get_sidebar(); ?>
</div>
<?php get_footer();