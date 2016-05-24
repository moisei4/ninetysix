<?php get_header();
$waves_options['blog_layout'] = waves_option("blog_layout", "simple-side");
$waves_options['more_text'] = waves_option("more_text", "Read more");
$waves_options['pagination'] = waves_option("pagination", "simple");

$noside = array('simple', 'grid');
$grid = array('grid', 'grid-side');

$width = ' col-md-7';
$space = '<div class="col-md-1">&nbsp;</div>';
if(in_array($waves_options['blog_layout'], $grid)){
    $waves_options['filter'] = 'false';
    $waves_options['excerpt_count'] = waves_option("excerpt_count");
    $space = '';
    $width = ' col-md-12'; 
    if(in_array($waves_options['blog_layout'], array('grid-side'))){
        $waves_options['grid_column'] = 'col-md-6';
        $width = ' col-md-9';    
    }
} elseif($waves_options['blog_layout']=='simple'){
    $space = '';
}
waves_set_options($waves_options);
?>
<div class="row"> 
    <?php echo ($space); ?>
    <div class="waves-main <?php echo esc_attr($waves_options['blog_layout'].$width);?>">
        <?php 
        if(in_array($waves_options['blog_layout'], $grid)){
            get_template_part("content", "grid");
        } else {
            get_template_part("content");
        }        
        ?>
    </div>
    <?php 
        if(!in_array($waves_options['blog_layout'], $noside)){
            get_sidebar();
        }
    ?>
</div>
<?php get_footer();