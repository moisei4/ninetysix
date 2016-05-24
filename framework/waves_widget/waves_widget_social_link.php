<?php
/* ------Widget Social ------ */
class Waves_Socialswidget extends WP_Widget {

    public function Waves_Socialswidget() {
        $widget_ops = array('classname' => 'sociallinkswidget', 'description' => 'Displays your social profile.');

        parent::__construct(false, 'Themewaves Social', $widget_ops);
    }

    public function widget($args, $instance) {
        wp_enqueue_style( 'waves-widget-social');
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        echo ($before_widget);
            if ($title){echo balanceTags($before_title . $title . $after_title);}
            echo '<div class="tw-social-icon '.(!empty($instance['layout'])? $instance['layout'] :'').' clearfix">';
                if($instance['layout'] == 'layout_4'){
                    echo '<div class="tw-social-color">';
                    $social_links=explode("\n",$instance['social']);
                    foreach($social_links as $social_link){
                        if(!empty($social_link)){
                            $social = waves_social_name(esc_url($social_link));
                            echo '<a href="'.esc_url($social_link).'" class="'.esc_attr($social['name']).'">'.esc_html($social['name']).'.</a>';
                        }                        
                    }
                    echo '</div>';
                } elseif($instance['layout'] == 'layout_3'){
                    echo '<div class="tw-social-color">';
                        $social_links=explode("\n",$instance['social']);
                        foreach($social_links as $social_link){echo waves_social_link($social_link);}
                    echo '</div>';
                } elseif(!empty($instance['social'])){
                    $social_links=explode("\n",$instance['social']);
                    foreach($social_links as $social_link){echo waves_social_link($social_link);}
                }
            echo '</div>';
        echo ($after_widget);
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance = $new_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    public function form($instance) {?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo isset($instance['title']) ? $instance['title'] : ''; ?>"  />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('layout')); ?>"><?php echo esc_html('Select Layout.'); ?>:</label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('style')); ?>" name="<?php echo esc_attr($this->get_field_name('layout')); ?>">
                <option value="layout_1"<?php if(!empty($instance['layout'])&&$instance['layout']==='layout_1'){echo ' selected="selected"';} ?>>Icons Circle Border</option>
                <option value="layout_2"<?php if(!empty($instance['layout'])&&$instance['layout']==='layout_2'){echo ' selected="selected"';} ?>>Icons Square Border</option>
                <option value="layout_3"<?php if(!empty($instance['layout'])&&$instance['layout']==='layout_3'){echo ' selected="selected"';} ?>>Icons Only</option>
                <option value="layout_4"<?php if(!empty($instance['layout'])&&$instance['layout']==='layout_4'){echo ' selected="selected"';} ?>>Name Only</option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('social')); ?>"><?php echo esc_html__('Enter social links. Example:facebook.com/themewaves. NOTE: Divide value sets with linebreak "Enter"', 'ninetysix'); ?>:</label>
            <textarea class="widefat" rows="20" id="<?php echo esc_attr($this->get_field_id('social')); ?>" name="<?php echo esc_attr($this->get_field_name('social')); ?>"><?php echo isset($instance['social']) ? $instance['social'] : ''; ?></textarea>
        </p><?php
    }
}

add_action('widgets_init', create_function('', 'return register_widget("Waves_Socialswidget");'));