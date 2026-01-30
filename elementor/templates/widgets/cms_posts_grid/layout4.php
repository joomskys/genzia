<?php
$post_type   = $this->get_setting('post_type', 'post');
$tax         = array();
$taxonomy_by = $this->get_setting('taxonomy_by', 'category');
$source      = $this->get_setting('source_'.$post_type);
$orderby     = $this->get_setting('orderby', 'date');
$order       = $this->get_setting('order', 'desc');
$limit       = $this->get_setting('limit', 3);
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
    'width'  => !empty($settings['thumbnail_custom_dimension']['width']) ? $settings['thumbnail_custom_dimension']['width'] : 736,
    'height' => !empty($settings['thumbnail_custom_dimension']['height']) ? $settings['thumbnail_custom_dimension']['height'] : 516
];
$numn_line = !empty($this->get_setting('num_line')['size']) ? $this->get_setting('num_line')['size'] : 1;
$pagination_type = $this->get_setting('pagination_type', 'pagination');
// Posts Data
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
    'readmore_text'              => $this->get_setting('readmore_text', esc_html__('Explore More','genzia')),
    //
    'item_class'    => '', //elementor-invisible
    'data-settings' => '', //wp_json_encode(['animation'=>'fadeInUp']),
    'element_id'    => $this->get_id()
);
// Wrap attributes
$this->add_render_attribute('wrap',[
    'class'           => ['cms-post-grid', 'cms-grid', 'cms-grid-'.$settings['layout']],
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
        'd-flex gutter-custom-x gutter-custom-y',
        genzia_elementor_get_grid_columns($widget, $settings, [
            'default'    => 2,
            'tablet'     => 2,
            'gap'        => '',
            'gap_prefix' => ''
        ])
    ],
    'style' => '--gutter-x:32px;--gutter-y:64px;'
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
    <?php genzia_elementor_filter_render($widget, $settings, [
        'categories' => $categories
    ]); ?>

    <div <?php ctc_print_html($this->get_render_attribute_string('content')); ?>><?php
        genzia_get_post_grid($settings, $posts, $posts_data);
    ?></div>
    <?php if ($pagination_type == 'pagination') { ?>
        <div class="cms-grid-pagination mt-40 empty-none" data-loadmore="<?php echo esc_attr(json_encode($posts_data)); ?>"
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