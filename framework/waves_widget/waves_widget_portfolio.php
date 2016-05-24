<?php
/* ------Widget Recetn Portpolio ------ */
class Waves_RecentPortWidget extends WP_Widget {
    public function Waves_RecentPortWidget() {
        $widget_ops = array('classname' => 'tw-portfolio-widget', 'description' => 'Themewaves recent portfolios.');
        parent::__construct(false, 'Themewaves recent portfolios', $widget_ops);
    }
    public function widget($args, $instance) {
        wp_enqueue_style( 'waves-widget-recent-port');
        global $post;
        extract(array(
            'title' => '',
            'number_posts' => 8,
            'post_order' => 'latest',
            'category' => ''
        ));
        $title = apply_filters('widget_title', $instance['title']);
        $post_count = 8;
        if (isset($instance['number_posts']))
            $post_count = $instance['number_posts'];
        $q['posts_per_page'] = $post_count;
        
        $cats = (array) $instance['category'];
        $q['paged'] = 1;
        $q['post_type'] = 'portfolio';
        if (count($cats) > 0) {
            $typ = 'portfolio_cat';
            $catq = array();
            foreach ($cats as $mycat) {
                $catq[] = $mycat;
            }
            $q['tax_query'] = Array(Array(
                    'taxonomy' => $typ,
                    'terms' => $catq,
                    'field' => 'id',
                )
            );
        }
        if ($instance['post_order'] == 'popular') {
            $q['orderby'] = 'meta_value';
            $q['meta_key'] = 'post_likeit';
        }
        query_posts($q);
        if (isset($args['before_widget']))
            echo ($args['before_widget']);
        if ($title != '')
            echo balanceTags($args['before_title'] . $title . $args['after_title']);
        echo '<div class="tw-recent-portfolios clearfix">';
        while (have_posts ()) : the_post();
            if (has_post_thumbnail($post->ID)) {
                $lrg_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
                $feat_img = $lrg_img[0];                        
                echo '<a href="'.esc_url(get_permalink()).'"><img src="' . esc_url($feat_img) . '" alt="' . esc_attr(get_the_title()) . '"/></a>';
            } else {
                echo '<a href="'.esc_url(get_permalink()).'"><span class="no-thumb"></span></a>';
            }
        endwhile;
        echo '</div>';
        if (isset($args['after_widget']))
            echo ($args['after_widget']);
        wp_reset_query();
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);

        $tax = get_object_taxonomies('portfolio');
        $instance['category'] = $_REQUEST['tax_input'][$tax[0]];
        $instance['number_posts'] = strip_tags($new_instance['number_posts']);
        $instance['post_order'] = strip_tags($new_instance['post_order']);
        return $instance;
    }

    public function form($instance) {
        //Output admin widget options form
        $instance = shortcode_atts(array(
                    'title' => '',
                    'number_posts' => 8,
                    'post_order' => 'latest',
                    'category' => '',
                    ), $instance);
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e("Title:", "ninetysix");?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>"  />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('post_order')); ?>">Post order:</label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('post_order')); ?>" name="<?php echo esc_attr($this->get_field_name('post_order')); ?>">
                <option value="latest" <?php if ($instance['post_order'] == 'latest') print 'selected="selected"'; ?>>Latest portfolios</option>
                <option value="popular" <?php if ($instance['post_order'] == 'popular') print 'selected="selected"'; ?>>Most liked portfolios</option>
            </select>
        </p>
        <p>If you were not selected for cats, it will show all categories.</p>
        <div id="<?php echo esc_attr($this->get_field_id('category')); ?>" style="height:150px; overflow:auto; border:1px solid #dfdfdf;"><?php
            $tax = get_object_taxonomies('portfolio');
            $selctedcat = false;
            if (isset($instance['category']) && $instance['category'] != ''){
                $selctedcat = $instance['category'];
            }
            wp_terms_checklist(0, array('taxonomy' => $tax[0], 'checked_ontop' => false, 'selected_cats' => $selctedcat)); ?>
        </div>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number_posts')); ?>">Number of posts to show:</label>
            <input  id="<?php echo esc_attr($this->get_field_id('number_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('number_posts')); ?>" value="<?php echo esc_attr($instance['number_posts']); ?>" size="3"  />
        </p><?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("Waves_RecentPortWidget");'));