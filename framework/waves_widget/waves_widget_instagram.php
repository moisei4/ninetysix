<?php
if (!class_exists('Wavesl_instagram_widget')) {
    class Wavesl_instagram_widget extends WP_Widget {
        public function __construct() {
            parent::__construct(
                    'null-instagram-feed', esc_html__('Waves: Instagram', 'ninetysix'), array('classname' => 'null-instagram-feed', 'description' => esc_html__('Displays your latest Instagram photos', 'ninetysix'))
            );
        }

        public function widget($args, $instance) {
            wp_enqueue_style( 'waves-widget-instagram');
            wp_enqueue_script( 'waves-widget-instagram');
            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
            $username = empty($instance['username']) ? '' : $instance['username'];
            $limit = empty($instance['number']) ? 6 : $instance['number'];
            $size = empty($instance['size']) ? 'large' : $instance['size'];
            $target = empty($instance['target']) ? '_blank' : $instance['target'];
            $layout = empty($instance['layout']) ? 'simple' : $instance['layout'];
            $auto_play = empty($instance['auto_play']) ? 'false' : intval($instance['auto_play']);
            echo ($before_widget);
            if(!empty($title)){
                echo balanceTags($before_title . $title . $after_title);
            }
            if($username!==''){
                $media_array = $this->scrape_instagram($username, $limit);
                if (is_wp_error($media_array)) {
                    echo balanceTags($media_array->get_error_message());
                }else{
                    $ulclass = 'instagram-pics clearfix instagram-size-'.$size;
                    if($layout==='carousel'){
                        $ulclass.=' owl-carousel';
                        wp_enqueue_script('waves-owl-carousel');
                    } ?>
                    <ul class="<?php echo esc_attr($ulclass); ?>" data-auto-play="<?php echo esc_attr($auto_play); ?>"><?php
                        foreach($media_array as $item){
                            echo '<li><a href="' . esc_url($item['link']) . '" target="' . esc_attr($target) . '"><img src="' . esc_url($item[$size]) . '"  alt="' . esc_attr($item['description']) . '" title="' . esc_attr($item['description']) . '"/></a></li>';
                        } ?>
                    </ul><?php
                }
            }
            echo ($after_widget);
        }

        public function form($instance) {
            $instance = wp_parse_args((array) $instance, array('title' => esc_html__('Instagram', 'ninetysix'), 'username' => '', 'size' => 'large', 'number' => 9, 'target' => '_blank', 'layout' => 'simple'));
            $title = esc_attr($instance['title']);
            $username = esc_attr($instance['username']);
            $number = absint($instance['number']);
            $size = esc_attr($instance['size']);
            $target = esc_attr($instance['target']);
            $layout = esc_attr($instance['layout']); ?>
            <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'ninetysix'); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
            <p><label for="<?php echo esc_attr($this->get_field_id('username')); ?>"><?php esc_html_e('Username', 'ninetysix'); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('username')); ?>" name="<?php echo esc_attr($this->get_field_name('username')); ?>" type="text" value="<?php echo esc_attr($username); ?>" /></label></p>
            <p><label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of photos', 'ninetysix'); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" /></label></p>
            <p><label for="<?php echo esc_attr($this->get_field_id('size')); ?>"><?php esc_html_e('Photo size', 'ninetysix'); ?>:</label>
                <select id="<?php echo esc_attr($this->get_field_id('size')); ?>" name="<?php echo esc_attr($this->get_field_name('size')); ?>" class="widefat">
                    <option value="thumbnail" <?php selected('thumbnail', $size) ?>><?php esc_html_e('Thumbnail', 'ninetysix'); ?></option>
                    <option value="small" <?php selected('small', $size) ?>><?php esc_html_e('Small', 'ninetysix'); ?></option>
                    <option value="large" <?php selected('large', $size) ?>><?php esc_html_e('Large', 'ninetysix'); ?></option>
                    <option value="original" <?php selected('original', $size) ?>><?php esc_html_e('Original', 'ninetysix'); ?></option>
                </select>
            </p>
            <p><label for="<?php echo esc_attr($this->get_field_id('target')); ?>"><?php esc_html_e('Open links in', 'ninetysix'); ?>:</label>
                <select id="<?php echo esc_attr($this->get_field_id('target')); ?>" name="<?php echo esc_attr($this->get_field_name('target')); ?>" class="widefat">
                    <option value="_blank" <?php selected('_blank', $target) ?>><?php esc_html_e('New window (_blank)', 'ninetysix'); ?></option>
                    <option value="_self" <?php selected('_self', $target) ?>><?php esc_html_e('Current window (_self)', 'ninetysix'); ?></option>
                </select>
            </p>
            <p><label for="<?php echo esc_attr($this->get_field_id('layout')); ?>"><?php esc_html_e('Layout', 'ninetysix'); ?>:</label>
                <select id="<?php echo esc_attr($this->get_field_id('layout')); ?>" name="<?php echo esc_attr($this->get_field_name('layout')); ?>" class="widefat">
                    <option value="simple" <?php selected('simple', $layout) ?>><?php esc_html_e('Simple', 'ninetysix'); ?></option>
                    <option value="carousel" <?php selected('carousel', $layout) ?>><?php esc_html_e('Carousel', 'ninetysix'); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('auto_play')); ?>"><?php esc_html_e('Carousel Auto Play:','ninetysix'); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('auto_play')); ?>" name="<?php echo esc_attr($this->get_field_name('auto_play')); ?>" value="<?php echo esc_attr(isset($instance['auto_play']) ? $instance['auto_play'] : 0); ?>" type="number" min="0" step="100" />
            </p>
            <?php
        }

        public function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['username'] = trim(strip_tags($new_instance['username']));
            $instance['number'] = !absint($new_instance['number']) ? 9 : $new_instance['number'];
            $instance['auto_play'] = empty($new_instance['auto_play']) ? 0 : $new_instance['auto_play'];
            $instance['size'] = ( ( $new_instance['size'] == 'thumbnail' || $new_instance['size'] == 'large' || $new_instance['size'] == 'small' || $new_instance['size'] == 'original' ) ? $new_instance['size'] : 'large' );
            $instance['target'] = ( ( $new_instance['target'] == '_self' || $new_instance['target'] == '_blank' ) ? $new_instance['target'] : '_blank' );
            $instance['layout'] = ( ( $new_instance['layout'] == 'simple'|| $new_instance['layout'] == 'carousel' ) ? $new_instance['layout'] : 'simple' );
            
            return $instance;
        }

        // based on https://gist.github.com/cosmocatalano/4544576
        public function scrape_instagram($username, $slice = 9) {

            $username = strtolower($username);
            $username = str_replace('@', '', $username);

            if (false === ( $instagram = get_transient('instagram-media-5-' . sanitize_title_with_dashes($username)) )) {

                $remote = wp_remote_get('http://instagram.com/' . trim($username));

                if (is_wp_error($remote))
                    return new WP_Error('site_down', esc_html__('Unable to communicate with Instagram.', 'ninetysix'));

                if (200 != wp_remote_retrieve_response_code($remote))
                    return new WP_Error('invalid_response', esc_html__('Instagram did not return a 200.', 'ninetysix'));

                $shards = explode('window._sharedData = ', $remote['body']);
                $insta_json = explode(';</script>', $shards[1]);
                $insta_array = json_decode($insta_json[0], TRUE);

                if (!$insta_array)
                    return new WP_Error('bad_json', esc_html__('Instagram has returned invalid data.', 'ninetysix'));

                if (isset($insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'])) {
                    $images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
                } else {
                    return new WP_Error('bad_json_2', esc_html__('Instagram has returned invalid data.', 'ninetysix'));
                }

                if (!is_array($images))
                    return new WP_Error('bad_array', esc_html__('Instagram has returned invalid data.', 'ninetysix'));

                $instagram = array();

                foreach ($images as $image) {
                    $image['thumbnail_src'] = preg_replace("/^https:/i", "", $image['thumbnail_src']);
                    $image['thumbnail'] = str_replace('s640x640', 's160x160', $image['thumbnail_src']);
                    $image['small'] = str_replace('s640x640', 's320x320', $image['thumbnail_src']);
                    $image['large'] = $image['thumbnail_src'];
                    $image['display_src'] = preg_replace("/^https:/i", "", $image['display_src']);

                    if ($image['is_video'] == true) {
                        $type = 'video';
                    } else {
                        $type = 'image';
                    }

                    $caption = esc_html__('Instagram Image', 'ninetysix');
                    if (!empty($image['caption'])) {
                        $caption = $image['caption'];
                    }

                    $instagram[] = array(
                        'description' => $caption,
                        'link' => '//instagram.com/p/' . $image['code'],
                        'time' => $image['date'],
                        'comments' => $image['comments']['count'],
                        'likes' => $image['likes']['count'],
                        'thumbnail' => $image['thumbnail'],
                        'small' => $image['small'],
                        'large' => $image['large'],
                        'original' => $image['display_src'],
                        'type' => $type
                    );
                }

                // do not set an empty transient - should help catch private or empty accounts
                if (!empty($instagram)) {
                    $instagram = serialize($instagram);
                    set_transient('instagram-media-5-' . sanitize_title_with_dashes($username), $instagram, apply_filters('waves_instagram_cache_time', HOUR_IN_SECONDS * 2));
                }
            }

            if (!empty($instagram)) {
                $instagram = unserialize($instagram);
                return array_slice($instagram, 0, $slice);
            } else {
                return new WP_Error('no_images', esc_html__('Instagram did not return any images.', 'ninetysix'));
            }
        }

        public function images_only($media_item) {
            if ($media_item['type'] == 'image'){return true;}
            return false;
        }
    }
}
add_action('widgets_init', create_function('', 'return register_widget("Wavesl_instagram_widget");'));