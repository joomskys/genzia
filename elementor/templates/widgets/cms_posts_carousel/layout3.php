<?php

$post_type   = $this->get_setting('post_type', 'post');
$tax         = array();
$taxonomy_by = $this->get_setting('taxonomy_by', 'category');
$source      = $this->get_setting('source_'.$post_type);
$orderby     = $this->get_setting('orderby', 'date');
$order       = $this->get_setting('order', 'desc');
$limit       = $this->get_setting('limit', 6);
extract(ctc_get_posts_of_grid( $post_type, [
    'source'   => $source,
    'orderby'  => $orderby,
    'order'    => $order,
    'limit'    => $limit
], [genzia_taxonomy_by_post_type($post_type,'category')]));

// Arrows
$arrows = $this->get_setting('arrows');
$this->add_render_attribute('arrows', [
    'class' => [
        'cms-swiper-buttons d-flex',
        genzia_add_hidden_device_controls_render($settings, 'arrows_'),
        'flex-auto',
    ]
]);
$arrows_classes = [
    'cms-carousel-button',
    'cms-box-58 circle',
    'text-'.$this->get_setting('arrows_color','menu'),
    'bg-'.$this->get_setting('arrows_bg_color','transparent'),
    'text-hover-'.$this->get_setting('arrows_hover_color','white'),
    'bg-hover-'.$this->get_setting('arrows_bg_hover_color','accent-regular'),
    'bdr-1 bdr-'.$this->get_setting('arrows_border_color','transparent'),
    'bdr-hover-'.$this->get_setting('arrows_border_hover_color','accent-regular')
];
$arrows_classes_prev = genzia_nice_class(array_merge(['cms-carousel-button-prev prev cms-hover-move-icon-left mr-n12'],$arrows_classes));
$arrows_classes_next = genzia_nice_class(array_merge(['cms-carousel-button-next next cms-hover-move-icon-right'],$arrows_classes));
// Dots
$dots = $this->get_setting('dots');
$this->add_render_attribute('dots', [
    'class' => [
        'flex-basic gap-12',
        'cms-carousel-dots cms-carousel-dots-circle',
        ($arrows=='yes') ? 'justify-content-end' : 'justify-content-center',
        genzia_add_hidden_device_controls_render($settings, 'dots_'),
    ],
    'style' => [
        '--cms-dots-color:var(--cms-menu);',
        '--cms-dots-hover-color:var(--cms-accent-regular);',
        '--cms-dots-hover-shadow:var(--cms-accent-regular);',
        '--cms-dots-hover-opacity:0.2;'
    ]
]);
// Arrows Dots
$this->add_render_attribute('arrows-dots',[
    'class' => [
        'd-flex gap-32 empty-none',
        ($arrows=='yes' && $dots=='yes') ? 'justify-content-between' : 'justify-content-end',
        'pt-40',
        'empty-none'
        //($arrows=='yes') ? 'pt-40' : ''
    ]
]);
// Thumbnail
$thumbnail_size             = $this->get_setting('thumbnail_size', 'large');
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['thumbnail_custom_dimension']['width']) ? $settings['thumbnail_custom_dimension']['width'] : 768,
    'height' => !empty($settings['thumbnail_custom_dimension']['height']) ? $settings['thumbnail_custom_dimension']['height']: 534
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
    'num_line'                   => !empty($this->get_setting('num_line')['size']) ? $this->get_setting('num_line')['size'] : 4,
    'readmore_text'              => $this->get_setting('readmore_text', esc_html__('Read More','genzia')),
    //
    'item_class'                 => 'cms-swiper-item swiper-slide',
    'data-settings'              => '',
    'element_id'                 => $this->get_id()
);
// Wrap attributes
$this->add_render_attribute('wrap',[
    'class'         => ['cms-post-carousel', 'cms-grid', 'cms-grid-'.$settings['layout']],
    'data-settings' => json_encode($posts_data)
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
    <?php genzia_elementor_filter_render($widget, $settings, [
        'categories' => $categories,
        'class'      => 'text-xs font-600'   
    ]); ?>
    <div class="cms-carousel swiper">
        <div class="<?php genzia_swiper_wrapper_class($this); ?>">
            <?php
                genzia_get_post_grid($settings, $posts, $posts_data);
            ?>
        </div>
    </div>
    <div <?php ctc_print_html($this->get_render_attribute_string('arrows-dots')); ?>><?php 
        // Arrows
        if ($arrows == 'yes'){ ?>
            <div <?php ctc_print_html($this->get_render_attribute_string('arrows')); ?>><?php 
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
    <?php } ?>
    <?php
        // Dots
        if ($dots == 'yes') { ?>
            <div <?php ctc_print_html($this->get_render_attribute_string('dots')); ?>></div>
        <?php }
    ?></div>
</div>