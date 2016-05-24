<?php get_header();

$waves_options['blog_layout'] = "simple";
$waves_options['more_text'] = esc_html__("Read more", 'ninetysix');
$waves_options['pagination'] = "simple";

waves_set_options($waves_options);

$width = ' col-md-7';
$space = '<div class="col-md-1">&nbsp;</div>';

?>
<div class="row"> 
    <?php echo ($space); ?>
    <div class="waves-main <?php echo esc_attr($waves_options['layout'].$width);?>">
        <h1 class="archive-title"><?php single_cat_title("", true);?></h1>
        <?php get_template_part("content"); ?>
    </div>
    <?php get_sidebar(); ?>
</div>
<?php get_footer();