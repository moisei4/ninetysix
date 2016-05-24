<?php
class Waves_ThemeWaves{
    var $theme_name;
    public function __construct() {
        $this->constants();
        $this->init_theme();
        $this->requires();
    }
    public function init_theme(){
        if(is_child_theme()){
            $temp_obj = wp_get_theme();
            $theme_obj = wp_get_theme($temp_obj->get('Template'));
        } else {
            $theme_obj = wp_get_theme();
        }
        $this->theme_name = $theme_obj->get('Name');
        
        add_action( 'after_setup_theme',  array(&$this, 'setup_theme'));
        add_action( 'wp_enqueue_scripts', array(&$this, 'scripts'), 20);
        add_action('widgets_init', array(&$this, 'widgets_init'));
        add_filter('widget_text', 'do_shortcode');
        add_filter( 'widget_title', array(&$this, 'widget_title' )); //Uses the built in filter function.  The title of the widget is passed to the function.
        add_filter('body_class', array(&$this,'body_class'));
        if(is_admin()){
            global $pagenow;
            if(isset($_GET['activated'])&&$pagenow=="themes.php" ) {
                header( 'Location: '.admin_url().'admin.php?page=ot-theme-options');
            }
        }
        add_filter('get_search_form', array(&$this,'searchform'));
        /* Wordpress Edit Gallery */
        add_filter('use_default_gallery_style', '__return_false');
        add_filter('wp_get_attachment_link', array(&$this,'pretty_photo'), 10, 5);
    }
    public function constants(){
        define('THEMENAME', str_replace(' ','-',strtolower($this->theme_name)));
        define('THEME_PATH', trailingslashit(get_template_directory()));
        define('THEME_DIR', trailingslashit(get_template_directory_uri()));
        define('WAVES_FW_PATH',THEME_PATH.'framework/');
        define('WAVES_FW_DIR', THEME_DIR .'framework/');
        define('STYLESHEET_PATH', trailingslashit(get_stylesheet_directory()));
        define('STYLESHEET_DIR', trailingslashit(get_stylesheet_directory_uri()));
    }
    public function requires(){
        require_once (THEME_PATH . "framework/theme_functions.php");
        require_once (THEME_PATH . "framework/blog_functions.php");
        require_once (THEME_PATH . "woocommerce/tw_woocommerce.php");
        require_once (THEME_PATH . "framework/theme_css.php");
        require_once (THEME_PATH . "framework/waves_framework.php");
    }
    public function setup_theme() {
        add_editor_style();
        add_theme_support('post-thumbnails');
        add_theme_support('post-formats', array('gallery', 'video', 'audio', 'quote'));
        add_theme_support( 'title-tag' );
        add_theme_support('automatic-feed-links');
        add_theme_support('woocommerce');
        load_theme_textdomain('ninetysix', THEME_PATH . 'languages/');
        register_nav_menus(array('main' => esc_html__('Main Menu','ninetysix')));
        
        add_image_size('waves_featured_img', 1170, 600, true);
        
        add_image_size('waves_blog_thumb', 670, 370, true);
        add_image_size('waves_grid_thumb', 420, 250, true);
        
        add_image_size('waves_portfolio_s2', 600, 600, true);
        add_image_size('waves_portfolio_h2', 600, 420, true);
        add_image_size('waves_portfolio_v2', 600, 660, true);
        add_image_size('waves_portfolio_m2', 600);
        
        add_image_size('waves_portfolio_s3', 400, 400, true);
        add_image_size('waves_portfolio_h3', 400, 280, true);
        add_image_size('waves_portfolio_v3', 400, 440, true);
        add_image_size('waves_portfolio_m3', 400);
        
        add_image_size('waves_portfolio_s4', 300, 300, true);
        add_image_size('waves_portfolio_h4', 300, 270, true);
        add_image_size('waves_portfolio_v4', 300, 330, true);
        add_image_size('waves_portfolio_m4', 390);
    }
    public function scripts() {
        wp_localize_script( 'jquery', 'waves_script_data', array(
            'home_uri' => esc_url(home_url('/')),
        ));

        wp_deregister_style('font-awesome');
        wp_enqueue_style('waves-bootstrap', THEME_DIR . '/assets/css/bootstrap.min.css');
        wp_enqueue_style('waves-fontawesome', THEME_DIR . '/assets/css/font-awesome.min.css');
        wp_enqueue_style('waves-ionfonts', THEME_DIR . '/assets/css/ionicons.min.css');
        wp_enqueue_style('waves-prettyphoto', THEME_DIR . '/assets/css/prettyPhoto.css');
        if (waves_woocommerce()){
            wp_register_style('waves-product-slider', THEME_DIR . '/woocommerce/css/tw_product_slider.css');
            wp_register_style('waves-product-easyzoom', THEME_DIR . '/woocommerce/css/tw_easyzoom.css');
            wp_enqueue_style('waves-woocommerce', THEME_DIR . '/woocommerce/css/tw_woocommerce.css');
        }
        wp_enqueue_style('waves-themewaves', STYLESHEET_DIR . '/style.css');
        wp_enqueue_style('waves-responsive', THEME_DIR . '/assets/css/responsive.css');

        wp_enqueue_script('waves-scripts', THEME_DIR . '/assets/js/scripts.js', array('jquery'), false, true);
        if(waves_option('scroll')==='smooth'){
            wp_enqueue_script('waves-scroll', THEME_DIR . '/assets/js/smoothscroll.js', false, false, true);
        }elseif(waves_option('scroll')==='simplr-smooth'){
            wp_enqueue_script('waves-scroll', THEME_DIR . '/assets/js/jquery.simplr.smoothscroll.min.js', false, false, true);
        }
        if(!isset($_POST['customized'])&&waves_option('preloader', 'none')!=='none'){
            wp_enqueue_style ('waves-animsition', THEME_DIR . '/assets/css/animsition.min.css');
            wp_enqueue_script('waves-animsition', THEME_DIR . '/assets/js/jquery.animsition.min.js', false, false, true);
        }
        if (is_single() && comments_open()){
            wp_enqueue_script('comment-reply');
        }
        if (waves_woocommerce()){
            wp_register_script('waves-product-slider', THEME_DIR . '/woocommerce/js/tw_product_slider.js');
            wp_register_script('waves-product-easyzoom', THEME_DIR . '/woocommerce/js/tw_easyzoom.js');
            wp_enqueue_script('waves-woocommerce', THEME_DIR . '/woocommerce/js/tw_woocommerce.js', false, false, true);
        }
        wp_register_script('waves-owl-carousel',THEME_DIR . '/assets/js/owl-carousel.min.js');
        wp_register_script('waves-isotope',THEME_DIR . '/assets/js/jquery.waves-isotope.min.js');
        wp_register_script('waves-vimeo', 'https://f.vimeocdn.com/js/froogaloop2.min.js');
        wp_enqueue_script('waves-script', THEME_DIR . '/assets/js/waves-script.js');
        wp_enqueue_script('waves-themewaves', THEME_DIR . '/assets/js/themewaves.js');
    }
    public function widgets_init() {
        register_sidebar(array(
            'name' => 'Default sidebar',
            'id' => 'default-sidebar',
            'before_widget' => '<aside class="widget %2$s" id="%1$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        /* footer sidebar */
        $grid = '3-3-3-3';
        $i = 1;
        foreach (explode('-', $grid) as $g) {
            register_sidebar(array(
                'name' => esc_html__("Footer sidebar ", "ninetysix") . $i,
                'id' => "footer-sidebar-$i",
                'description' => esc_html__('The footer sidebar widget area', 'ninetysix'),
                'before_widget' => '<aside class="widget %2$s" id="%1$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            $i++;
        }
    }
    public function widget_title($html_widget_title) {

	$html_widget_title_tagopen = '['; //Our HTML opening tag replacement
	$html_widget_title_tagclose = ']'; //Our HTML closing tag replacement

	$html_widget_title = str_replace($html_widget_title_tagopen, '<', $html_widget_title);
	$html_widget_title = str_replace($html_widget_title_tagclose, '>', $html_widget_title);
        
        $html_widget_title = str_replace(array('&quot;','&#8220;','&#8221;'), '"', $html_widget_title );        

	return $html_widget_title;
    }
    public function body_class($classes) {
        global $post,$waves_options;        
        
        $waves_options['layout'] = waves_option('layout');
        $waves_options['header'] = waves_option('header');
        $waves_options['header_layout'] = waves_option('header_layout');
        $waves_options['header_color'] = waves_option('header_color');
        $waves_options['footer_layout'] = waves_option('footer_layout');

        if(is_page() && waves_metabox('header_advanced')=='on'){
            $waves_options['header'] = waves_metabox('header') ? waves_metabox('header') : $waves_options['header'];
            $waves_options['header_layout'] = waves_metabox('header_layout') ? waves_metabox('header_layout') : $waves_options['header_layout'];
            $waves_options['header_color'] = waves_metabox('header_color') ? waves_metabox('header_color') : $waves_options['header_color'];
            $waves_options['footer_layout'] = waves_metabox('footer_layout') ? waves_metabox('footer_layout') : $waves_options['footer_layout'];
        }
        
        $waves_options['hf_cont_class'] = $waves_options['header_layout']==='full' ? 'container-fluid' : 'container';
        
        $classes[] = $waves_options['header'];
        $classes[] = $waves_options['header_color'];
        if(!isset($_POST['customized'])&&waves_option('preloader', 'none')!=='none'){$classes[] = 'loading';}
        // Waves Composer Class
        if(is_page()){
            $vc_enabled = get_post_meta($post->ID, '_wpb_vc_js_status', true);
            if($vc_enabled == 'true'){
                $classes[] = 'waves-composer';
            }
        }
        return $classes;
    }
    public function searchform() {
        $form = '<form method="get" class="searchform" action="' . esc_url(home_url('/')) . '" >
        <div class="input">
        <input type="text" value="' . get_search_query() . '" name="s" placeholder="' . esc_html__('Keyword ...', 'ninetysix') . '" />
            <button type="submit" class="button-search"><i class="ion-ios-search-strong"></i></button>
        </div>
        </form>';
        return $form;
    }
    public function pretty_photo($content, $id, $size, $permalink) {
        if (!$permalink)
            $content = preg_replace("/<a/", "<a rel=\"prettyPhoto[gallery]\"", $content, 1);
        $content = preg_replace("/<\/a/", "<span class=\"image-overlay\"></span></a", $content, 1);
        return $content;
    }
}
$waves_ThemeWaves = new Waves_ThemeWaves();

if (!isset($content_width)){
    $content_width = 1170;
}

function waves_get_ID_by_slug($slug){
    $page = get_page_by_path($slug);
    return isset($page->ID)?$page->ID:'';
}
function waves_get_slug_by_ID($id) {
    $post = get_post($id);
    return isset($post->post_name)?$post->post_name:'';
}

// Waves Social Login Button
function waves_get_gf_family_by_id($gf_id){
    $gfs=get_theme_mod( 'ot_google_fonts', array());
    return isset($gfs[$gf_id]['family'])?$gfs[$gf_id]['family']:false;
}

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
add_action( 'vc_before_init', 'waves_vcSetAsTheme' );
function waves_vcSetAsTheme(){
    vc_set_as_theme();
}