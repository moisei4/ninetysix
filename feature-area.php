<?php
if (is_page()) {
    $feature = '';
    $type = get_post_meta($post->ID, 'feature_area', true);
    if ($type == "slider") {
        $revSl=get_post_meta($post->ID, 'slider', true);
        $echoSlider=true;
        $echoSlider=waves_rev_check($revSl,$echoSlider);
        if($echoSlider){$feature = do_shortcode($revSl);}else{$feature=esc_html__('Select Slider','ninetysix');}
    } elseif ($type == "embed") {
        $feature = do_shortcode(htmlspecialchars_decode(get_post_meta($post->ID, 'embed', true)));
    } elseif ($type == "image") {
        $img = waves_image('full' ,true);
        if(!empty($img['url'])){
            $feature .= '<div class="feature-area">';
                $feature .= '<div class="featured-img" style="background-image: url('.esc_url($img['url']).')"></div>';
            $feature .= '</div>';
        }
    } elseif ($type != "none"){
        $feature .= '<div class="feature-title">';
            $feature .= '<h1>'.get_the_title().'</h1>';
        $feature .= '</div>';
    }
    if($feature){
        echo '<div class="feature-area">';
            echo '<div class="container">';
                echo ($feature);
            echo '</div>';
        echo '</div>';
    }
} elseif(is_singular('post')){
    $layout = get_post_meta($post->ID, 'single_layout', true);
    if(empty($layout)){
        $layout = waves_option('single_layout', 'with-sidebar');
    }
    $waves_options['single_layout'] = $layout;
    waves_set_options($waves_options);
    if($waves_options['single_layout'] == 'full-width'){
        $img = waves_image('full' ,true);
        if(!empty($img['url'])){
            echo '<div class="feature-area">';
                echo '<div class="featured-img" style="background-image: url('.esc_url($img['url']).')"></div>';
            echo '</div>';
        }
    }
} elseif(is_singular('portfolio')){
    $feature = '';
    $type = get_post_meta($post->ID, 'feature_area', true);
    $layout = get_post_meta($post->ID, 'single_layout', true);
    if(empty($layout)){
        $layout = waves_option('portfolio_layout', 'with-sidebar');
    }
    $waves_options['single_layout'] = $layout;
    
    waves_set_options($waves_options);
    if($type == 'slider'){
        echo do_shortcode(get_post_meta($post->ID, 'slider', true));   
    } elseif($type == 'images'){
        $c_start = '<div class="container">';
        $c_end = '</div>';
        $img_size = 'waves_featured_img';
        if($waves_options['single_layout'] == 'full-width'){
            $c_start = $c_end = '';
            $img_size = 'full';
        }
        $imagess = get_post_meta( $post->ID, 'images', true );
         if ($imagess) {
            $images = explode(',',$imagess);
            wp_enqueue_script('waves-owl-carousel');
            $feature .= '<div class="feature-area">'.$c_start;
                $feature .= '<div class="tw-carousel-container image-slide-container">';
                    $feature .= '<div class="tw-carousel">';
                        foreach ($images as $image) {
                            $img = wp_get_attachment_image_src( $image, 'full' );
                            $desc = get_post_field('post_excerpt', $image);
                            $feature .= '<div class="tw-owl-item">';
                                $feature .= '<img src="'.esc_url($img[0]).'"'.($desc ? ' title="'.$desc.'"' : '').' />';
                            $feature .= '</div>';
                        }
                    $feature .= '</div>';
                $feature .= '</div>';
            $feature .= $c_end.'</div>';
            echo balanceTags($feature);
        }
    } elseif($type!='none'){
        $c_start = '<div class="container">';
        $c_end = '</div>';
        $img_size = 'waves_featured_img';
        if($waves_options['single_layout'] == 'full-width'){
            $c_start = $c_end = '';
            $img_size = 'full';
        }
        $img = waves_image('full' ,true);
        if(!empty($img['url'])){
            echo '<div class="feature-area">'.$c_start;
                echo '<div class="featured-img" style="background-image: url('.esc_url($img['url']).')"></div>';
            echo ($c_end.'</div>');
        }
    }    
}
