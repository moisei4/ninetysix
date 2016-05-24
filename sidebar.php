<div class="tw-sidebar col-md-3">
    <section class="clearfix">
        <?php
        if(is_single()){
            $tw_author = false;
            $author = waves_metabox('post_authorr');
            if($author == "true"){
                $tw_author = true;
            }elseif($author != "false"){
                if(waves_option('post_author') == 'true'){
                    $tw_author = true;
                }
            }
            if($tw_author){
                waves_author();
            }
        }
        if(!dynamic_sidebar('default-sidebar')) {
            print 'There is no widget. You should add your widgets into <strong>';
            print 'Default';
            print '</strong> sidebar area on <strong>Appearance => Widgets</strong> of your dashboard. <br/><br/>';
        ?>
            <aside id="archives" class="widget">
                <div class="tw-widget-title-container">
                    <h3 class="widget-title"><?php esc_html_e('Archives', 'ninetysix'); ?></h3>
                    <span class="tw-title-border"></span>
                </div>
                <ul class="side-nav">
                    <?php wp_get_archives(array('type' => 'monthly')); ?>
                </ul>
            </aside>
        <?php } ?>
    </section>
</div>