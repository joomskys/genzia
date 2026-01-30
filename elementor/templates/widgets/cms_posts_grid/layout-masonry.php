<?php
$post_type   = $this->get_setting('post_type', 'post');
$tax         = array();
$taxonomy_by = $this->get_setting('taxonomy_by', 'category');
$source      = $this->get_setting('source_'.$post_type);
$orderby     = $this->get_setting('orderby', 'date');
$order       = $this->get_setting('order', 'desc');
$limit       = $this->get_setting('limit', 6);
$layout_type = 'grid';
$filter      = $this->get_setting('filter', 'false');
extract(ctc_get_posts_of_grid($post_type, [
    'source'   => $source,
    'orderby'  => $orderby,
    'order'    => $order,
    'limit'    => $limit
], [genzia_taxonomy_by_post_type($post_type, 'category')]));
$thumbnail_size             = $this->get_setting('thumbnail_size','large');
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['thumbnail_custom_dimension']['width']) ? $settings['thumbnail_custom_dimension']['width'] : 768,
    'height' => !empty($settings['thumbnail_custom_dimension']['height']) ? $settings['thumbnail_custom_dimension']['height'] : 534
];
$numn_line = !empty($this->get_setting('num_line')['size']) ? $this->get_setting('num_line')['size'] : 4;
$pagination_type = $this->get_setting('pagination_type', 'pagination');
// Posts Data
$readmore_text = $this->get_setting('readmore_text', esc_html__('Explore More','genzia'));
$posts_data = array(
    'post_type'                  => $post_type,
    'taxonomy'                   => genzia_taxonomy_by_post_type($post_type, $taxonomy_by),
    //
    'startPage'                  => $paged,
    'maxPages'                   => $max,
    'total'                      => $total,
    'perpage'                    => $limit,
    'nextLink'                   => $next_link,
    'pagination_type'            => $pagination_type,
    //
    'layout'                     => $settings['layout'],
    'source'                     => $source,
    'orderby'                    => $orderby,
    'order'                      => $order,
    'limit'                      => $limit,
    'thumbnail_size'             => $thumbnail_size,
    'thumbnail_custom_dimension' => $thumbnail_custom_dimension,
    'num_line'                   => $numn_line,
    'readmore_text'              => $readmore_text,
    //
    'item_class'    => '', //elementor-invisible
    'data-settings' => '', //wp_json_encode(['animation'=>'fadeInUp']),
    'element_id'    => $this->get_id()
);
// Wrap attributes
$this->add_render_attribute('wrap',[
    'class'           => ['cms-post-masonry', 'cms-grid'],
    'data-layout'     => $layout_type,
    'data-start-page' => $paged,
    'data-max-pages'  => $max,
    'data-total'      => $total,
    'data-perpage'    => $limit,
    'data-next-link'  => $next_link
]);
// Content attributes
$this->add_render_attribute('content',[
    'class' => [
        'cms-grid-content',
        'd-flex gutter',
    ]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
    <?php genzia_elementor_filter_render($widget, $settings, [
        'categories' => $categories,
        'class'      => 'relative z-top2 gap-8 mb-48 text-xs'
    ]); ?>
    <div class="cms-grid-content d-flex gutter gutter-custom-x gutter-custom-y" data-cursor="<?php echo esc_attr($readmore_text); ?>" style="--gutter-x:32px; --gutter-y:176px;--gutter-y-tablet:88px;--gutter-y-mobile:32px;"><?php 
        $count = 0;
        $small_item = $medium_item = $large_item = false;
        foreach ($posts as $key => $post){
        $count ++;
        if(in_array($count, [1, 5])){
            $medium_item = true;
        }
        // Items
        $item_key = $this->get_repeater_setting_key('item', 'cms_theme_posts_scroll_grow', $key);
        $this->add_render_attribute($item_key, [
            'class' => array_filter([
                'cms-item',
                (in_array($count, [1, 5, 7, 11]))? 'col-7' : '',
                (in_array($count, [2, 4, 8, 10]))? 'col-5' : '',
                (in_array($count, [3, 6, 9]))? 'col-8 m-lr-auto' : '',
                'col-mobile-12'
            ])
        ]);
        // Items Inner
        $item_inner_key = $this->get_repeater_setting_key('item-inner', 'cms_theme_posts_scroll_grow', $key);
        $this->add_render_attribute($item_inner_key, [
            'class' => array_filter([
                'cms--item',
                'm-lr-tablet-0',
                (in_array($count, [1, 7, 10]))? 'mr-70' : '',
                (in_array($count, [5, 8, 11]))? 'ml-70' : '',
                //
                (in_array($count, [2]))? 'ml-70' : '',
                (in_array($count, [4]))? 'mr-70' : '',
                'cms-parallax-tablet-no',
                'relative',
                'cms-hover-change'
            ]),
            'data-parallax' => wp_json_encode([
                'scale'   => "1.2",
                'opacity' => "1"
            ]),
        ]);

    ?>
        <div <?php ctc_print_html($this->get_render_attribute_string( $item_key )); ?>>
            <div <?php ctc_print_html($this->get_render_attribute_string( $item_inner_key )); ?>>
                <?php
                    // Post Image
                    ob_start();
                ?>
                    <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="cms-box-123 circle bg-accent-regular text-white bg-hover-primary-regular text-hover-white text-xs font-700 p-20 text-center absolute center z-top cms-hidden-min-tablet-extra"><?php 
                        ctc_print_html($readmore_text); 
                    ?></a>
                <?php
                    $readmore = ob_get_clean();
                    genzia_elementor_post_thumbnail_render($settings, [
                        'post_id'     => $post->ID,
                        'custom_size' => ['width' => 800, 'height' => 560],
                        'img_class'   => 'cms-radius-16', 
                        'max_height'  => true,
                        'before'      => '<div class="relative mb-33">',
                        'after'       => $readmore.'</div>'
                    ]);
                ?>
                <h6><?php echo get_the_title($post->ID);?></h6>
                <div class="cms-excerpt text-md text-line-1 pt-5 mb-n5"><?php 
                    echo wp_kses_post($post->post_excerpt);
                ?></div>
                <?php
                // Taxonomy
                genzia_the_terms($post->ID, $taxonomy_by, '', 'bg-white text-menu bdr-1 bdr-divider text-hover-white bg-hover-accent-regular bdr-hover-accent-regular cms-radius-4 p-lr-10 p-tb-5', ['before' => '<div class="d-flex gap-4 text-xs pt-30">', 'after' => '</div>']);
                ?>
                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="cms-overlay cms-hidden-mobile cms-cursor cms-cursor-text" data-cursor-text="<?php echo esc_attr($readmore_text); ?>" data-cursor-class="bg-accent-regular text-white">
                    <span class="screen-reader-text"><?php ctc_print_html($readmore_text); ?></span>
                </a>
            </div>
        </div>
    <?php } 
    ?></div>
    <?php if ($pagination_type == 'pagination') { ?>
        <div class="cms-grid-pagination mt-56 empty-none" data-loadmore="<?php echo esc_attr(json_encode($posts_data)); ?>"
             data-query="<?php echo esc_attr(json_encode($args)); ?>"><?php 
                genzia_posts_pagination($query, true); 
        ?></div>
    <?php }
    if (!empty($next_link) && $pagination_type == 'loadmore') { ?>
        <div class="cms-load-more text-center mt-32" data-loadmore="<?php echo esc_attr(json_encode($posts_data)); ?>" data-query="<?php echo esc_attr(json_encode($args)); ?>">
            <span class="cms-btn btn-menu text-white btn-hover-accent-regular text-hover-white cms-hover-change"><?php 
                echo esc_html__('Load More', 'genzia');
            ?></span>
        </div>
    <?php } 
    if($filter == 'true'){ //$pagination_type == 'false'
    ?>
        <div class="cms-grid-pagination d-none" data-loadmore="<?php echo esc_attr(json_encode($posts_data)); ?>"
             data-query="<?php echo esc_attr(json_encode($args)); ?>"><?php 
                genzia_posts_pagination($query, true); 
        ?></div>
    <?php
    }
    ?>
    <div class="cms-grid-overlay"></div>
</div>