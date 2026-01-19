<?php
/**
 * Customize WooCommerce
 * 
 * **/
add_filter('admin_body_class', 'genzia_woocommerce_admin_body_class');
function genzia_woocommerce_admin_body_class($body_class){
    $body_class .= ' cms-custom-admin-body-class';
    if(genzia_get_opt('shop_thumbnail_custom', 'on') == 'on'){
        $body_class .= ' cms-custom-woo-image';
    }
    return $body_class;
}
//
add_action('customize_controls_print_styles', 'genzia_customize_controls_print_styles');
function genzia_customize_controls_print_styles(){
    if(genzia_get_opt('shop_thumbnail_custom', 'on') == 'on'){
?>
    <style>
        #accordion-section-woocommerce_product_images,
        #customize-control-woocommerce_thumbnail_cropping{
            display: none!important;
        }
    </style>
<?php
    }
}
// Custom image size
add_filter('genzia_woocommerce_args', 'genzia_custom_woocommerce_args');
function genzia_custom_woocommerce_args(){
    if(genzia_get_opt('shop_thumbnail_custom', 'off') == 'on'){
        $args = [
            'thumbnail_image_width'         => 400,
            'single_image_width'            => 600,
            'gallery_thumbnail_image_width' => 800,
            'product_grid'                  => array(
                'default_columns' => 3,
                'default_rows'    => 3,
                'min_columns'     => 1,
                'max_columns'     => 6,
                'min_rows'        => 1,
            )
        ];
    } else {
        $args = [];
    }
    return $args;
}
/**
 * Custom default Woo thumbnail size
 * 
 * https://woocommerce.com/document/image-sizes-theme-developers/
 *
 */
if(genzia_get_opt('shop_thumbnail_custom', 'off') == 'on'){   
    // Loop Products thumbnail 
    add_filter('woocommerce_get_image_size_thumbnail', function($size){
        $size['width']  = 600;
        $size['height'] = 600;
        $size['crop']   = ['center','center'];
        return $size;
    });
    // Image Sizes - Single
    add_filter( 'woocommerce_get_image_size_single', function ( $size ) {
        $size['width']  = 600;
        $size['height'] = 600;
        $size['crop']   = ['center','center'];
        return $size;
    } );
    // Gallery Image Thumb Sizes - Loop
    add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function ( $size ) {
        $size['width']  = 100;
        $size['height'] = 100;
        $size['crop']   = ['center','center'];
        return $size;
    } );
    /*add_filter('woocommerce_gallery_thumbnail_size', function($size){
        $size['width']  = 150;
        $size['height'] = 150;
        $size['crop']   = ['center','center'];
        return $size;
    });*/
}

/**
 * Rating HTML
 * 
 */ 
add_filter('woocommerce_get_star_rating_html', 'genzia_woocommerce_get_star_rating_html', 10, 3);
function genzia_woocommerce_get_star_rating_html( $html, $rating, $count = 0 ) {
    if ( 0 < $count ) {
        /* translators: 1: rating 2: rating count */
        $data_title = sprintf( _n( 'Rated %1$s out of 5 based on %2$s customer rating', 'Rated %1$s out of 5 based on %2$s customer ratings', $count, 'genzia' ), esc_html( $rating ),  esc_html( $count )  );
    } else {
        /* translators: %s: rating */
        $data_title = sprintf( esc_html__( 'Rated %s out of 5', 'genzia' ),  esc_html( $rating ) );
    }
    $star_icon       = genzia_svgs_icon(['icon' => 'core/star','icon_size' => 18, 'echo' => false]);
    $star_rated_icon = genzia_svgs_icon(['icon' => 'core/star','icon_size' => 18, 'echo' => false]);
    $star            = '<span class="cms-product-rate absolute top left d-flex flex-nowrap gap-5 text-divider">'.$star_icon.$star_icon.$star_icon.$star_icon.$star_icon.'</span>';
    $star_rated      = '<span class="cms-product-rated relative d-flex flex-nowrap gap-5 text-warning" style="width:' . ( ( $rating / 5 ) * 100 ) . '%">'.$star_rated_icon.$star_rated_icon.$star_rated_icon.$star_rated_icon.$star_rated_icon.'</span>';

    $html = '<div class="cms-product-star-rate relative pb-10" data-title="'. $data_title.'">'.$star.$star_rated.'</div>';

    return $html;
}
/**
 * Loop Product
 * Remove Page Title
 **/
add_filter('woocommerce_show_page_title', function (){ return false;});
/**
 * Loop Product
 * Remove Count
 **/
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
/**
 * Loop Product
 * Remove Catalog Ordering
 **/
remove_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering', 30);

/**
 * Loop Product
 * Add Count and Catalog Ordering
 **/
add_action('woocommerce_before_shop_loop', 'genzia_woocommerce_count_order', 20);
function genzia_woocommerce_count_order(){
?>
    <div class="cms-result-catalog d-flex gap-40 gap-mobile-20 justify-content-between align-items-center pb-40 text-sm" style="--cms-form-field-border-width:1px;--cms-form-field-border-width-hover:1px;--cms-form-select-padding-start:24px;--cms-form-select-padding-end:24px;"><?php
        woocommerce_result_count();
        woocommerce_catalog_ordering();
    ?></div>
<?php 
}
/**
 * Loop Product
 * Loop Product CSS class
 * */
add_filter('woocommerce_post_class', 'genzia_woocommerce_post_class', 10, 2);
function genzia_woocommerce_post_class($classes, $product){
    if(!is_singular('product')){
        $classes[] = 'cms-product-loop';
    } else {
        $classes[] = 'cms-product-single';
    }
    return $classes;
}
/**
 * Loop Product 
 * Wrap by div
 * 
*/
add_action('woocommerce_before_shop_loop_item', 'genzia_woocommerce_before_shop_loop_item', -99999);
function genzia_woocommerce_before_shop_loop_item(){
    echo '<div class="cms-hover-change relative pb-10">';
}
add_action('woocommerce_after_shop_loop_item', 'genzia_woocommerce_after_shop_loop_item', 99999);
function genzia_woocommerce_after_shop_loop_item(){
    echo '</div>';
}
/**
 * Loop Product 
 * Remove product link
 * 
 * */
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
/**
 * Loop Product
 * Sale
 * 
 * */
remove_action('woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash', 10);
add_action('genzia_woocommerce_before_loop_thumbnail_right', 'woocommerce_show_product_loop_sale_flash', 1);

/**
 * Loop Products
 * Product Thumbnail Hover
*/
if(!function_exists('genzia_woocommerce_get_product_thumbnail_second')){
    function genzia_woocommerce_get_product_thumbnail_second($size = 'woocommerce_thumbnail'){
        global $product;
        $gallery_ids = $product->get_gallery_image_ids();
        $image_size = apply_filters( 'single_product_archive_thumbnail_size', $size);
        $product_id = $product->get_id();
        $second_thumb_class = 'cms-overlay cms-second-image cms-transition cms-hover-show zoom-in';
        if(isset($gallery_ids['0'])){
            $second_thumb = wp_get_attachment_image($gallery_ids['0'], $image_size, false, ['class' => $second_thumb_class]);
        } else {
            $second_thumb = wp_get_attachment_image(get_post_thumbnail_id($product_id), $image_size, false, ['class' => $second_thumb_class]);
        }

        printf('%s',  $second_thumb );
    }
}
/**
 * Loop Product
 * Product Thumbnail
 * 
 * */
if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {
    /**
     * Get the product thumbnail for the loop.
     */
    function woocommerce_template_loop_product_thumbnail() {
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    ?>
        <div class="cms-products-loop-thumbs relative overflow-hidden swiper-nav-vert bg-bg-light mb-15"><?php
            do_action('genzia_woocommerce_before_loop_thumbnail');
                echo woocommerce_get_product_thumbnail('woocommerce_thumbnail', ['class' => 'cms-hover-hide zoom-in']);
                genzia_woocommerce_get_product_thumbnail_second();
            do_action('genzia_woocommerce_after_loop_thumbnail');
    ?></div>
    <?php
    }
}

/**
 * Loop Products
 * Loop products thumbnail Top
 * 
 * */
add_action('genzia_woocommerce_before_loop_thumbnail','genzia_woocommerce_before_loop_thumbnail_top');
function genzia_woocommerce_before_loop_thumbnail_top(){
?>
    <div class="cms-products-loop-thumb-top absolute top w-100 d-flex justify-content-between p-12 z-top2">
        <div class="cms-products-loop-thumb-top-left"><?php
            do_action('genzia_woocommerce_before_loop_thumbnail_left');
        ?></div>
        <div class="cms-products-loop-thumb-top-right"><?php
            do_action('genzia_woocommerce_before_loop_thumbnail_right');
        ?></div>
    </div>
<?php
}
/**
 * Loop Products
 * Add to Cart button
 * 
 * */
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
add_action('genzia_woocommerce_after_loop_thumbnail', 'woocommerce_template_loop_add_to_cart', 2);
// add to cart button classes
add_filter('woocommerce_loop_add_to_cart_args', 'genzia_woocommerce_loop_add_to_cart_args', 10, 2);
function genzia_woocommerce_loop_add_to_cart_args($args, $product){
    $args['class'] = implode(
        ' ',
        array_filter(
            array(
                'cms-btn-addtocart',
                'cms-btn',
                'btn-menu text-white btn-hover-accent-regular text-hover-white cms-hover-move-icon-right',
                'w-100',
                'cms-hover-show move-up',
                'product_type_' . $product->get_type(),
                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : ''
            )
        )
    );
    return $args;
}
// Change loop add_to_cart HTML
add_filter('woocommerce_loop_add_to_cart_link', 'genzia_woocommerce_loop_add_to_cart_link', 10, 3);
if(!function_exists('genzia_woocommerce_loop_add_to_cart_link')){
    function genzia_woocommerce_loop_add_to_cart_link($button, $product, $args){
        $add_to_cart_icon = genzia_svgs_icon(['icon' => 'arrow-right','icon_size' => 10, 'class' => 'cms-icon hide-on-loading', 'echo' => false]);
        $add_to_cart_loading_icon = genzia_svgs_icon(['icon' => 'core/spinner','icon_size' => 15, 'class' => 'cms-spin show-on-loading loading', 'echo' => false]);
        return sprintf(
            '<div class="cms-loop-addtocart absolute bottom left right m-32"><a href="%1$s" data-quantity="%2$s" class="%3$s" %4$s>%5$s%6$s</a>%7$s</div>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
            esc_attr( isset( $args['class'] ) ? $args['class'] : '' ),
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            esc_html($product->add_to_cart_text()),
            // add to cart / loadding icon
            $add_to_cart_icon . $add_to_cart_loading_icon,
            // added to cart
            genzia_woocommerce_template_loop_added_to_cart([
                'class' => genzia_nice_class([
                    'cms-btn',
                    'btn-menu text-white btn-hover-accent-regular text-hover-white',
                    'cms-hover-move-icon-right',
                    'w-100',
                    'cms-hover-show move-up'
                ]),
                'icon_class' => ''
            ])
        );
    }
}
/**
 * Loop Product
 * Added to cart
 * 
 */
if(!function_exists('genzia_woocommerce_template_loop_added_to_cart')){
  function genzia_woocommerce_template_loop_added_to_cart($args = []){
    $args = wp_parse_args($args, [
      'layout'     => 'text',
      'class'      => '',
      'icon_class' => ''
    ]);
    $classes = [
      'added_to_cart',
      $args['class']
    ];
    ob_start();
    ?>
      <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="<?php echo genzia_nice_class($classes); ?>" data-title="<?php esc_attr_e('View Cart','genzia');?>"> 
        <?php 
            // text
            switch ($args['layout']) {
              case 'text':
                echo esc_html__('View Cart','genzia');
                genzia_svgs_icon(['icon' => 'arrow-right','icon_size' => 11, 'class' => $args['icon_class'], 'echo' => true]);
                break;
              default :
                // icon
                genzia_svgs_icon(['icon' => 'arrow-right','icon_size' => 11, 'class' => $args['icon_class'], 'echo' => true]);
                echo '<span class="screen-reader-text">'.esc_html__('View Cart','genzia').'</span>';
                break;
            }
        ?>
      </a>
    <?php
    $html =  ob_get_clean();
    return $html;
  }
}
/**
 * Loop Product
 * Product Title
 * 
 * */
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
if(!function_exists('woocommerce_template_loop_product_title')){
    function woocommerce_template_loop_product_title(){ ?>
    <div class="cms-product-loop-bottom">
        <a href="<?php echo esc_url(get_the_permalink());?>" class="cms-product-loop-title cms-heading text-xl text-menu text-hover-accent-regular"><?php 
            echo get_the_title();
        ?></a>
        <div class="text-md text-accent-regular pt-7"><?php 
            woocommerce_template_loop_price();
        ?></div>
    </div>
<?php
    }
}
/**
 * Loop Product
 * Product Rate
 * 
 * */
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

/**
 * Pagination
 * Custom next/prev icon
 */ 
add_filter('woocommerce_pagination_args', 'genzia_woocommerce_pagination_args');
if(!function_exists('genzia_woocommerce_pagination_args')){
    function genzia_woocommerce_pagination_args($default){
        $default = array_merge($default, [
            'prev_text' => apply_filters('genzia_pagination_prev_arrow','Prev'),
            'next_text' => apply_filters('genzia_pagination_next_arrow','Next'),
            'type'      => 'plain',
            //
            'before_page_number' => '<span>',
            'after_page_number'  => '</span>'
        ]);
        return $default;
    }
}

/**
 * Single Product
 * Review count & link 
*/
//remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
//add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11);
if ( ! function_exists( 'woocommerce_template_single_rating' ) ) {
    /**
     * Output the product rating.
     */
    function woocommerce_template_single_rating() {
        if ( !post_type_supports( 'product', 'comments' ) || ! wc_review_ratings_enabled() ) {
            return;
        }
        global $product;
        $rating_count = $product->get_rating_count();
        $review_count = $product->get_review_count();
        $average      = $product->get_average_rating();

        $review_url =  get_the_permalink($product->get_id()).'#reviews';

        //if ( $rating_count > 0 ) : 
            ?>
            <div class="woocommerce-product-rating">
                <?php echo wc_get_rating_html( $average, $rating_count ); // WPCS: XSS ok. ?>
                <?php if ( comments_open() ) : ?>
                    <?php //phpcs:disable ?>
                    <a href="<?php echo esc_attr($review_url); ?>" class="woocommerce-review-link text-menu text-btn font-500" rel="nofollow">(<?php printf( _n( '%s Review', '%s Reviews', $review_count, 'genzia' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?> / <?php esc_html_e('Add review','genzia'); ?>)</a>
                    <?php // phpcs:enable ?>
                <?php endif ?>
            </div>
        <?php 
        //endif;
    }
}
/**
 * Single Product
 * Custom Add To Cart 
 * Change Variation product add-to-cart form
 * 
**/
remove_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);
add_action('woocommerce_before_variations_form', 'woocommerce_single_variation', 0);

/**
 * Single Product 
 * Share
 * 
 * <a class="g-social hover-effect d-none" title="<?php echo esc_attr__('Google Plus', 'genzia'); ?>" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="cmsi-google-plus-g"></i></a>
 * <a class="pin-social hover-effect d-none" title="<?php echo esc_attr__('Pinterest', 'genzia'); ?>" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url(the_post_thumbnail_url('full')); ?>&media=&description=<?php the_title(); ?>"><i class="cmsi-pinterest"></i></a>
 * <a class="instagram-social hover-effect" title="<?php echo esc_attr__('Instagram', 'genzia'); ?>" target="_blank"
           href="https://www.instagram.com/"><i class="cmsi-instagram"></i></a>
 * <a class="tiktok-social hover-effect" title="<?php echo esc_attr__('Tiktok', 'genzia'); ?>" target="_blank"
           href="https://www.tiktok.com/"><i class="cmsi-tik-tok"></i></a>
 * 
*/
add_action('woocommerce_share', 'genzia_social_share_product');
function genzia_social_share_product(){ 
    $product_share = genzia_get_opts('product_share', 'off', 'product_custom');
    if($product_share === 'off') return;
    $product_share_class = [
        'text-white text-hover-white',
        'cms-box-48 cms-radius-2',
        'bg-primary-regular bg-hover-accent-regular'
    ];
    ?>
    <div class="cms-product-share d-flex align-items-center gap-6 pt-32 mt-25 bdr-t-1 bdr-divider">
        <?php // Facebook ?>
        <a class="fb-social <?php echo genzia_nice_class($product_share_class); ?>" title="<?php echo esc_attr__('Facebook', 'genzia'); ?>" target="_blank"
           href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>">
           <span class="screen-reader-text"><?php echo esc_html__('Facebook', 'genzia'); ?></span>
           <?php 
           genzia_svgs_icon([
            'icon'      => 'core/facebook',
            'icon_size' => 20
           ]);
        ?></a>
        <?php // Twitter ?>
        <a class="tw-social <?php echo genzia_nice_class($product_share_class); ?>" title="<?php echo esc_attr__('Twitter', 'genzia'); ?>" target="_blank"
           href="https://twitter.com/home?status=<?php the_permalink(); ?>">
           <span class="screen-reader-text"><?php echo esc_html__('Twitter', 'genzia'); ?></span>
           <?php 
            genzia_svgs_icon([
                'icon'      => 'core/x',
                'icon_size' => 20
            ]);
        ?></a>
        <?php // LinkedIn ?>
        <a class="li-social <?php echo genzia_nice_class($product_share_class); ?>" title="<?php echo esc_attr__('LinkedIn', 'genzia'); ?>" target="_blank"
               href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>">
               <span class="screen-reader-text"><?php echo esc_html__('LinkedIn', 'genzia'); ?></span>
               <?php 
           genzia_svgs_icon([
            'icon'      => 'core/linkedin',
            'icon_size' => 20
           ]);
        ?></a>
    </div>
    <?php
}
/**
 * Single Product
 * Review callback function 
 * make it callback same as default blog review
*/
remove_action('woocommerce_review_meta','woocommerce_review_display_meta', 10);
remove_action('woocommerce_review_comment_text','woocommerce_review_display_comment_text', 10);
if(!function_exists('genzia_woocommerce_product_review_list_args')){
    add_filter('woocommerce_product_review_list_args', 'genzia_woocommerce_product_review_list_args');
    function genzia_woocommerce_product_review_list_args($args){
        $args['style']      = 'div';
        $args['short_ping'] = 'true';
        $args['callback']   = 'genzia_comment_list';
        return $args;
    }
}
/**
 * Single Product
 * Comment form Args
 * 
*/
if(!function_exists('genzia_woocommerce_product_review_comment_form_args')){
    add_filter('woocommerce_product_review_comment_form_args', 'genzia_woocommerce_product_review_comment_form_args');
    function genzia_woocommerce_product_review_comment_form_args($comment_form){
        $comment_form = genzia_comment_form_args();
        return $comment_form;
    }
}
/**
 * Single Product
 * Upsell, Cross Sell, Related
 *
 */
// related
/*add_filter('woocommerce_output_related_products_args', function($args){
    $args['posts_per_page'] = 3;
    $args['columns'] = 3;
    return $args;
});*/
// upsell
//add_filter('woocommerce_upsells_columns', function(){ return 3;});
//add_filter('woocommerce_upsells_total', function(){ return 3;});
// Cross sell
//add_filter('woocommerce_cross_sells_columns' , function(){ return 3;});
//add_filter('woocommerce_cross_sells_total' , function(){ return 3;});

/**
 * Single Product 
 * Added to Cart Message
 * 
 * */
add_filter('wc_add_to_cart_message_html', 'genzia_wc_add_to_cart_message_html', 10, 3);
if(!function_exists('genzia_wc_add_to_cart_message_html')){
    function genzia_wc_add_to_cart_message_html($message, $products, $show_qty ){
        $titles = array();
        $count  = 0;

        if ( ! is_array( $products ) ) {
            $products = array( $products => 1 );
            $show_qty = false;
        }

        if ( ! $show_qty ) {
            $products = array_fill_keys( array_keys( $products ), 1 );
        }

        foreach ( $products as $product_id => $qty ) {
            /* translators: %s: product name */
            $titles[] = apply_filters( 'woocommerce_add_to_cart_qty_html', ( $qty > 1 ? absint( $qty ) . ' &times; ' : '' ), $product_id ) . apply_filters( 'woocommerce_add_to_cart_item_name_in_quotes', sprintf( _x( '&ldquo;%s&rdquo;', 'Item name in quotes', 'genzia' ), strip_tags( get_the_title( $product_id ) ) ), $product_id );
            $count   += $qty;
        }

        $titles = array_filter( $titles );
        /* translators: %s: product name */
        $added_text = sprintf( _n( '%s has been added to your cart.', '%s have been added to your cart.', $count, 'genzia' ), wc_format_list_of_items( $titles ) );

        // Output success messages.
        $wp_button_class = 'cms-single-viewcart cms-btn btn-md btn-primary-regular text-white btn-hover-accent-regular text-hover-white order-last cms-hover-move-icon-right';
        //
        if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
            $message   = sprintf( '%s <a href="%s" tabindex="1" class="%s" style="--cms-btn-padding:0 24px;">%s%s</a>', 
                esc_html( $added_text ),
                esc_url( $return_to ), 
                esc_attr( $wp_button_class ), 
                esc_html__( 'Continue shopping', 'genzia' ),
                genzia_svgs_icon(['icon' => 'arrow-right','icon_size' => 10, 'echo' => false])
            );
        } else {
            $message = sprintf( '%s <a href="%s" tabindex="1" class="%s" style="--cms-btn-padding:0 24px;">%s%s</a>', 
                esc_html( $added_text ),
                esc_url( wc_get_cart_url() ), 
                esc_attr( $wp_button_class ),
                esc_html__( 'View cart', 'genzia' ), 
                genzia_svgs_icon(['icon' => 'arrow-right','icon_size' => 10, 'echo' => false])
            );
        }
        return $message;
    }
}
/**
 * Loop 
 * 
 * Quantity Form
 * 
**/
add_action( 'woocommerce_before_quantity_input_field', 'genzia_woocommerce_before_quantity_input_field', 99999);
if(!function_exists('genzia_woocommerce_before_quantity_input_field')){
    function genzia_woocommerce_before_quantity_input_field(){
?>  
    <span class="cms-qty-act cms-qty-down"><?php genzia_svgs_icon(['icon' => 'core/minus','icon_size' => 14]) ?></span>
<?php
    }
}
add_action( 'woocommerce_after_quantity_input_field', 'genzia_woocommerce_after_quantity_input_field', -99999 );
if(!function_exists('genzia_woocommerce_after_quantity_input_field')){
    function genzia_woocommerce_after_quantity_input_field(){
?>  
    <span class="cms-qty-act cms-qty-up"><?php genzia_svgs_icon(['icon' => 'core/plus','icon_size' => 14]) ?></span>
<?php
    } // close .cms-quantity , prioty 99999/-99999 to make sure just wrap input box
}

/**
 * Checkout Page
 * **/
add_action('woocommerce_checkout_before_order_review_heading', function(){echo '<div class="cms-orderreview-wrap"><div class="cms-orderreview cms-sticky">';}, -9999);
add_action('woocommerce_checkout_after_order_review', function(){echo '</div></div>';}, 9999);

/**
 * Checkout Page
 * custom Place Order button
 * 
 * */
add_filter('woocommerce_order_button_html', 'genzia_woocommerce_order_button_html');
if(!function_exists('genzia_woocommerce_order_button_html')){
    function genzia_woocommerce_order_button_html($button){
        // The text of the button
        $order_button_text = apply_filters( 'woocommerce_order_button_text', esc_html__( 'Place order', 'genzia' ) );
        // button
        $button = '<button type="submit" class="cms-btn btn-menu text-white btn-hover-accent-regular text-hover-white w-100" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>';

        return $button;
    }
}

/**
 * Mini Cart
 * Change product thumbnail size
 * 
 * **/
function genzia_mini_cart_item_thumbnail( $thumb, $cart_item, $cart_item_key ) {
    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
    return $_product->get_image( apply_filters('genzia_widget_product_thumbnail_size', 'woocommerce_gallery_thumbnail') );
}
add_filter( 'woocommerce_cart_item_thumbnail', 'genzia_mini_cart_item_thumbnail', 10, 3 );
add_filter('genzia_widget_product_thumbnail_size', function(){ return 'woocommerce_gallery_thumbnail';});
/**
 * Mini Cart
 * View Cart Button
 * */
remove_action('woocommerce_widget_shopping_cart_buttons','woocommerce_widget_shopping_cart_button_view_cart');
if ( ! function_exists( 'woocommerce_widget_shopping_cart_button_view_cart' ) ) {

    /**
     * Output the view cart button.
     */
    function woocommerce_widget_shopping_cart_button_view_cart() {
        $wp_button_class = wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '';
        echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="btn-viewcart btn btn-menu text-white btn-hover-outline-menu text-hover-menu cms-hover-change w-100 justify-content-between cms-hover-move-icon-right">' . esc_html__( 'View cart', 'genzia' ) . genzia_svgs_icon(['icon' => 'arrow-right','icon_size' => 11, 'echo' => false]).'</a>';
    }
}
/**
 * Mini Cart
 * Checkout Button
 * */
if ( ! function_exists( 'woocommerce_widget_shopping_cart_proceed_to_checkout' ) ) {

    /**
     * Output the proceed to checkout button.
     */
    function woocommerce_widget_shopping_cart_proceed_to_checkout() {
        //wc_get_checkout_url()
        echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="btn-checkout cms-btn btn-accent-regular text-white btn-hover-primary-regular text-hover-white  cms-hover-change w-100 cms-hover-move-icon-right">'.esc_html__( 'Proceed To Checkout', 'genzia' ).genzia_svgs_icon(['icon' => 'arrow-right','icon_size' => 10, 'echo' => false]).'</a>';
    }
}
/**
 * Mini Cart
 * Sub total
 * */
if ( ! function_exists( 'woocommerce_widget_shopping_cart_subtotal' ) ) {
    /**
     * Output to view cart subtotal.
     *
     * @since 3.7.0
     */
    function woocommerce_widget_shopping_cart_subtotal() {
    ?>
        <div class="cms-mini-cart-subtotal d-flex gap-15 text-lg text-sub-text bdr-t-1 bdr-divider pt-25 mt-32">
            <div class="title"><?php echo esc_html__( 'Total:', 'genzia' ) ?></div>
            <div class="total"><?php echo WC()->cart->get_cart_subtotal(); ?></div>
        </div>
    <?php
    }
}