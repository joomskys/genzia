<?php
$post_type   = $widget->get_setting('post_type', 'post');
$tax         = array();
$taxonomy_by = $widget->get_setting('taxonomy_by', 'category');
$source      = $widget->get_setting('source_'.$post_type);
$orderby     = $widget->get_setting('orderby', 'date');
$order       = $widget->get_setting('order', 'desc');
$limit       = $widget->get_setting('limit', 6);
$layout_type = 'grid';
$filter      = $widget->get_setting('filter', 'false');
$bdr_color       = $this->get_setting('bdr_color', 'divider');
$bdr_color_hover = $this->get_setting('bdr_color_hover', 'divider');
extract(ctc_get_posts_of_grid($post_type, [
    'source'   => $source,
    'orderby'  => $orderby,
    'order'    => $order,
    'limit'    => $limit
], [genzia_taxonomy_by_post_type($post_type, 'category')]));

$thumbnail_size             = $widget->get_setting('thumbnail_size','large');
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['thumbnail_custom_dimension']['width']) ? $settings['thumbnail_custom_dimension']['width'] : 592,
    'height' => !empty($settings['thumbnail_custom_dimension']['height']) ? $settings['thumbnail_custom_dimension']['height'] : 532
];
$numn_line = !empty($widget->get_setting('num_line')['size']) ? $widget->get_setting('num_line')['size'] : 4;
$pagination_type = $widget->get_setting('pagination_type', 'pagination');
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
    'readmore_text'              => $widget->get_setting('readmore_text', esc_html__('Explore More','genzia')),
    //
    'item_class'    => '', //elementor-invisible
    'data-settings' => '', //wp_json_encode(['animation'=>'fadeInUp']),
    'element_id'    => $this->get_id(),
    'bdr_color'       => $bdr_color,
    'bdr_color_hover' => $bdr_color_hover
);
// Wrap attributes
$widget->add_render_attribute('wrap',[
    'id'              => $this->get_name() . '-' . $this->get_id(),
    'class'           => ['cms-post-grid', 'cms-grid', 'cms-grid-'.$settings['layout']],
    'data-layout'     => $layout_type,
    'data-start-page' => $paged,
    'data-max-pages'  => $max,
    'data-total'      => $total,
    'data-perpage'    => $limit,
    'data-next-link'  => $next_link
]);
// Content attributes
$widget->add_render_attribute('content',[
    'class' => [
        'cms-grid-content',
        'd-flex',
        genzia_elementor_get_grid_columns($widget, $settings, [
            'default' => 2,
            'tablet'  => 2,
            'gap'     => 32
        ])
    ]
]);
?>
<div <?php ctc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <?php genzia_elementor_filter_render($widget, $settings, [
        'categories' => $categories,
        'class'      => 'mb-40 text-sm font-600'   
    ]); ?>

    <div <?php ctc_print_html($widget->get_render_attribute_string('content')); ?>><?php
        genzia_get_post_grid($settings, $posts, $posts_data);
    ?></div>
    <?php if ($pagination_type == 'pagination') { ?>
        <div class="cms-grid-pagination mt-40 empty-none" data-loadmore="<?php echo esc_attr(json_encode($posts_data)); ?>"
             data-query="<?php echo esc_attr(json_encode($args)); ?>"><?php 
                genzia_posts_pagination($query, true); 
        ?></div>
    <?php }
    if (!empty($next_link) && $pagination_type == 'loadmore') { ?>
        <div class="cms-load-more text-center mt-40" data-loadmore="<?php echo esc_attr(json_encode($posts_data)); ?>" data-query="<?php echo esc_attr(json_encode($args)); ?>">
            <span class="btn btn-outline-menu text-menu btn-hover-outline-menu text-hover-menu cms-hover-change">
                <span class="cms-on-hover-underline"><?php echo esc_html__('Load More', 'genzia') ?></span>
            </span>
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