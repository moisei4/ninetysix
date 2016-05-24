<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $woocommerce, $product;

$prettyPhoto = true;

wp_enqueue_style('waves-product-slider');
wp_enqueue_script('waves-product-slider');

$zoom_class = '';
$zoom = waves_metabox('product_zoom');
if($zoom == 'on'){
    $zoom_class = ' class="easyzoom"';
    wp_enqueue_script('waves-product-easyzoom');
    wp_enqueue_style('waves-product-easyzoom');
}

?>
<div id="product-thumb" class="tw-product-thumbs">
	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
</div>

<div id="product-slider" class="tw-product-images">
        <?php
            $gallery_id = rand(1000, 9999);
            // Featured image
            if ( has_post_thumbnail() ) {
            
                $image = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
                
                if ( $prettyPhoto ) {
                    $zoom_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                    $zoom_link_open = sprintf( '<a href="%s" rel="prettyPhoto['.$gallery_id.']">', esc_url( $zoom_image[0] ), intval( $zoom_image[1] ), intval( $zoom_image[2] ) );
                    $zoom_link_close = '</a>';
                } else {
                    $zoom_link_open = $zoom_link_close = '';
                }
                
                echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div'.$zoom_class.'>%s%s%s</div>', $zoom_link_open, $image, $zoom_link_close ), $post->ID );
                
            } else {
                
                echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div><img src="%s" alt="%s" /></div>', wc_placeholder_img_src(), esc_attr__( 'Placeholder', 'woocommerce' ) ), $post->ID );
            
            }
            
            // Gallery images
            $attachment_ids = $product->get_gallery_attachment_ids();
            
            if ( $attachment_ids ) {
                foreach ( $attachment_ids as $attachment_id ) {
                    $image_link = wp_get_attachment_url( $attachment_id );
        
                    if ( ! $image_link ) {
						continue;
					}
                            
                    $image = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
                    
                    if ( $prettyPhoto ) {
                        $zoom_image = wp_get_attachment_image_src( $attachment_id, 'full' );
                        $zoom_link_open = sprintf( '<a href="%s" rel="prettyPhoto['.$gallery_id.']">', esc_url( $zoom_image[0] ), intval( $zoom_image[1] ), intval( $zoom_image[2] ) );
                        $zoom_link_close = '</a>';
                    } else {
                        $zoom_link_open = $zoom_link_close = '';
                    }
                    
                    echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div'.$zoom_class.'>%s%s%s</div>', $zoom_link_open, $image, $zoom_link_close ), $post->ID );
                }
                
            }
        ?>
</div>
<?php
$video = waves_metabox('product_video');
if($video){
    echo '<div class="product-video">';
        echo '<a href="'.$video.'" rel="prettyPhoto"><i class="ion-play"></i>'.esc_html__('Watch Video', 'ninetysix').'</a>';
    echo '</div>';
}