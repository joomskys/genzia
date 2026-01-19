<?php
$post_type       = $widget->get_setting('post_type', 'post');
$tax             = array();
$taxonomy_by     = $widget->get_setting('taxonomy_by', 'category');
$source          = $widget->get_setting('source_'.$post_type);
$orderby         = $widget->get_setting('orderby', 'date');
$order           = $widget->get_setting('order', 'desc');
$limit           = $widget->get_setting('limit', 6);
$bdr_color       = $this->get_setting('bdr_color', 'divider');
$bdr_color_hover = $this->get_setting('bdr_color_hover', 'menu');
extract(ctc_get_posts_of_grid( $post_type, [
    'source'   => $source,
    'orderby'  => $orderby,
    'order'    => $order,
    'limit'    => $limit
], [genzia_taxonomy_by_post_type($post_type,'category')]));
// Arrows
$arrows = $widget->get_setting('arrows');
$widget->add_render_attribute('arrows', [
    'class' => [
        'cms-swiper-buttons d-flex gap-12 flex-auto',
        genzia_add_hidden_device_controls_render($settings, 'arrows_')
    ]
]);
$arrows_classes = [
    'cms-carousel-button',
    'cms-box-58 circle',
    'text-'.$widget->get_setting('arrows_color','menu'),
    'bg-'.$widget->get_setting('arrows_bg_color','transparent'),
    'text-hover-'.$widget->get_setting('arrows_hover_color','white'),
    'bg-hover-'.$widget->get_setting('arrows_bg_hover_color','accent-regular'),
    'bdr-1 bdr-'.$widget->get_setting('arrows_border_color','transparent'),
    'bdr-hover-'.$widget->get_setting('arrows_border_hover_color','accent-regular')
];
$arrows_classes_prev = genzia_nice_class(array_merge(['cms-carousel-button-prev prev cms-hover-move-icon-left mr-n12  '],$arrows_classes));
$arrows_classes_next = genzia_nice_class(array_merge(['cms-carousel-button-next next cms-hover-move-icon-right'],$arrows_classes));
// Dots
$dots = $widget->get_setting('dots');
$widget->add_render_attribute('dots', [
    'class' => [
        'flex-basic gap-12',
        'cms-carousel-dots cms-carousel-dots-circle',
        ($arrows == 'yes') ? 'justify-content-end':'justify-content-center',
        genzia_add_hidden_device_controls_render($settings, 'dots_'),
    ],
    'style' => [
        '--cms-dots-color:var(--cms-'.$widget->get_setting('dots_color','menu').');',
        '--cms-dots-hover-color:var(--cms-'.$widget->get_setting('dots_active_color','primary-regular').');',
        '--cms-dots-hover-shadow:var(--cms-'.$widget->get_setting('dots_active_color','primary-regular').');',
        '--cms-dots-hover-opacity:0.2;'
    ]
]);
// Thumbnail
$thumbnail_size             = $widget->get_setting('thumbnail_size', 'large');
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['thumbnail_custom_dimension']['width']) ? $settings['thumbnail_custom_dimension']['width'] : 768,
    'height' => !empty($settings['thumbnail_custom_dimension']['height']) ? $settings['thumbnail_custom_dimension']['height']: 768
];
// Posts Data
$posts_data = array(
    'post_type'                  => $post_type,
    'taxonomy'                   => genzia_taxonomy_by_post_type($post_type, $taxonomy_by),
    
    'layout'                     => $settings['layout'],   
    'source'                     => $source,
    'orderby'                    => $orderby,
    'order'                      => $order,
    'limit'                      => $limit,
    'thumbnail_size'             => $thumbnail_size,
    'thumbnail_custom_dimension' => $thumbnail_custom_dimension,
    'num_line'                   => !empty($widget->get_setting('num_line')['size']) ? $widget->get_setting('num_line')['size'] : 4,
    'readmore_text'              => $widget->get_setting('readmore_text', esc_html__('Explore More','genzia')),
    //
    'item_class'                 => 'cms-swiper-item swiper-slide',
    'data-settings'              => '',
    'element_id'                 => $this->get_id(),
    'bdr_color'                  => $bdr_color,
    'bdr_color_hover'            => $bdr_color_hover
);
// Wrap attributes
$widget->add_render_attribute('wrap',[
    'id'            => $this->get_name() . '-' . $this->get_id(),
    'class'         => ['cms-post-carousel', 'cms-grid', 'cms-grid-'.$settings['layout']],
    'data-settings' => json_encode($posts_data)
]);
?>
<div <?php ctc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <?php genzia_elementor_filter_render($widget, $settings, [
        'categories' => $categories
    ]); ?>
    <div class="cms-carousel swiper">
        <div class="<?php genzia_swiper_wrapper_class($this); ?>">
            <?php
                genzia_get_post_grid($settings, $posts, $posts_data);
            ?>
        </div>
    </div>
    <div class="d-flex justify-content-between gap-32 pt-40 empty-none"><?php
        // Arrows
        if ($arrows == 'yes'){ ?>
            <div <?php ctc_print_html($widget->get_render_attribute_string('arrows')); ?>><?php 
                genzia_svgs_icon([
                    'icon'      => 'arrow-left',
                    'icon_size' => 11,
                    'class'     => $arrows_classes_prev,
                    'tag'       => 'div'
                ]);
                genzia_svgs_icon([
                    'icon'      => 'arrow-right',
                    'icon_size' => 11,
                    'class'     => $arrows_classes_next,
                    'tag'       => 'div'
                ]);
            ?></div>
        <?php }
        // Dots
        if ($dots == 'yes') { ?>
            <div <?php ctc_print_html($widget->get_render_attribute_string('dots')); ?>></div>
        <?php }
    ?></div>
    <?php 
        // Link
        genzia_elementor_link_render($widget, $settings, [
            'name'      => 'link1_',
            'mode'      => 'btn',
            'text_icon' => genzia_svgs_icon([
                'icon'      => 'arrow-right',
                'icon_size' => 11,
                'echo'      => false
            ]),
            'class'            => [
                'elementor-invisible',
                'cms-hover-move-icon-right'
            ],
            'btn_color'        => 'menu', 
            'text_color'       => 'white',
            'btn_color_hover'  => 'accent-regular',
            'text_color_hover' => 'menu',
            'attrs'            => [
                'data-settings' => wp_json_encode([
                    'animation'       => 'fadeInUp',
                    'animation_delay' => 200
                ])
            ],
            'before' => '<div class="mt-40 m-lr-auto text-center">',
            'after'  => '</div>'
        ]);
    ?>
</div>