</div><?php
$waves_options = waves_get_options();
$grid = $waves_options['footer_layout'];
if ($grid != 'none') { ?>
    <div class="waves-footer layout-<?php echo esc_attr($grid);?>">
        <!-- Start Container-->
        <div class="<?php echo esc_attr($waves_options['hf_cont_class']); ?>">
            <div class="row">
                <?php
                $i = 1;
                foreach (explode('-', $grid) as $g) {
                    echo '<div class="col-md-' . esc_attr($g) . '">';
                        if(!dynamic_sidebar("footer-sidebar-$i")){
                            print '<aside class="widget">';
                            print '<h3 class="widget-title">Footer sidebar '.esc_attr($i).'</h3>';
                            print 'There is no widget. You should add your widgets into <strong>';
                            print 'Footer sidebar '.esc_attr($i);
                            print '</strong> sidebar area on <strong>Appearance => Widgets</strong> of your dashboard.';
                            print '</aside>';
                        }
                    echo '</div>';
                    $i++;
                }
                ?>
            </div>
        </div>
        <!-- End Container -->
    </div><?php
}
?>
</div><?php
$gotop = esc_html__('Scroll to top', 'ninetysix');
echo '<a id="scrollUp" href="#" title="' . esc_attr($gotop) . '"><i class="ion-chevron-up"></i></a>'; ?>
<?php wp_footer(); ?>
</body>
</html>