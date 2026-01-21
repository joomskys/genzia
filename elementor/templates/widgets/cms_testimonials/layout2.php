<?php
$default_align  = 'start';
$testimonials   = $this->get_setting('testimonials', []);
$layout_mode    = $this->get_setting('layout_mode', 'grid');
$col_gap        = $this->get_setting('col_gap', 40);
//
// Arrows Dots
$arrows = $widget->get_setting('arrows');
$dots = $widget->get_setting('dots');
//
$this->add_render_attribute('arrows-dots',[
    'class' => [
        'cms-carousel-arrows-dots pt-40 empty-none',
        'd-flex gap-20 align-items-center',
        ($arrows == 'yes' && $dots == 'yes') ? 'justify-content-between' : 'justify-content-end',
        'w-100'
    ]
]);
// Arrows
$widget->add_render_attribute('arrows', [
    'class' => [
        'cms-swiper-buttons d-flex gap-12 flex-auto flex-smobile-full justify-content-smobile-end',
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
$arrows_classes_prev = genzia_nice_class(array_merge(['cms-carousel-button-prev prev cms-hover-move-icon-left mr-n12'],$arrows_classes));
$arrows_classes_next = genzia_nice_class(array_merge(['cms-carousel-button-next next cms-hover-move-icon-right'],$arrows_classes));
// Dots
$widget->add_render_attribute('dots', [
    'class' => [
        'flex-basic gap-12',
        'cms-carousel-dots cms-carousel-dots-circle',
        genzia_add_hidden_device_controls_render($settings, 'dots_'),
        ($arrows == 'yes') ? 'justify-content-end' : 'justify-content-center'
    ],
    'style' => [
        '--cms-dots-color:var(--cms-'.$widget->get_setting('dots_color','menu').');',
        '--cms-dots-hover-color:var(--cms-'.$widget->get_setting('dots_active_color','menu').');',
        '--cms-dots-hover-shadow:var(--cms-'.$widget->get_setting('dots_active_color','menu').');',
        '--cms-dots-hover-opacity:1;'
    ]
]);
// Wrap
$this->add_render_attribute('wrap', [
    'class' => [
        'cms-ettmn',
        'cms-ettmn-'.$settings['layout_mode'],
        'cms-ettmn-'.$settings['layout'],
        'text-'.$default_align,
        'relative'
    ]
]);
// Grid
if($layout_mode == 'grid'){
    $this->add_render_attribute('wrap', [
        'class' => [
            'd-flex',
            genzia_elementor_get_grid_columns($this, $settings, [
                'default'    => 1,
                'tablet'     => 1,
                'gap'        => $col_gap,
                'gap_prefix' => 'gutter-'
            ])
        ]
    ]);
}
// Description 
$widget->add_render_attribute('description',[
    'class' => [
       'cms-ttmn-desc',
       'heading text-xl',
       'text-'.$widget->get_setting('desc_color','heading-regular'),
       'mt-nxl'
    ]
]);
// Author Name
$widget->add_render_attribute('ttmn-author',[
    'class' => [
        'cms-ttmn--name empty-none',
        'text-md font-700',
        'text-'.$widget->get_setting('author_color', 'heading-regular')
    ]
]);
// Author Position
$widget->add_render_attribute('ttmn-author-pos',[
    'class' => [
        'cms-ttmn--pos',
        'text-md',
        'text-'.$widget->get_setting('author_pos_color', 'body')
    ]
]);
// Items
$this->add_render_attribute('ttmn-item',[
    'class' => [
        'cms-ttmn-item'
    ]
]);
// Items Inner
$widget->add_render_attribute('ttmn--item',[
    'class' => [
        'cms-ttmn--item',
        'p-40',
        'bdr-1 bdr-divider',
        'cms-shadow-2 cms-hover-shadow-1',
        'cms-transition',
        'relative',
        'cms-radius-16',
        'd-flex flex-column justify-content-between'
    ],
    'style' => 'min-height:512px;'
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
    <?php switch ($layout_mode) {
        case 'carousel':
            $this->add_render_attribute('ttmn-item', [
                'class' => 'cms-carousel-item swiper-slide'
            ]);
    ?>
        <div class="cms-carousel swiper" data-dots="custom">
            <div class="<?php genzia_swiper_wrapper_class($this); ?>">
    <?php
            break;
        case 'grid':
            $this->add_render_attribute('ttmn-item', [
                'class' => 'cms-ttmn-grid-item'
            ]);
            break;
    } ?>
        <?php 
            $count = 0;
            foreach ($testimonials as $key => $testimonial) {
        ?>
            <div <?php ctc_print_html($this->get_render_attribute_string('ttmn-item')); ?>>
                <div <?php ctc_print_html($widget->get_render_attribute_string('ttmn--item')); ?>>
                    <div class="align-self-start w-100">
                        <div class="d-flex gap-6 text-warning pb-23"><?php 
                            genzia_svgs_icon([
                                'icon'      => 'core/star',
                                'icon_size' => 18
                            ]);
                            genzia_svgs_icon([
                                'icon'      => 'core/star',
                                'icon_size' => 18
                            ]);
                            genzia_svgs_icon([
                                'icon'      => 'core/star',
                                'icon_size' => 18
                            ]);
                            genzia_svgs_icon([
                                'icon'      => 'core/star',
                                'icon_size' => 18
                            ]);
                            genzia_svgs_icon([
                                'icon'      => 'core/star',
                                'icon_size' => 18
                            ]);
                        ?></div>
                        <div <?php ctc_print_html($widget->get_render_attribute_string('description')); ?>><?php 
                            echo nl2br($testimonial['description']); 
                        ?></div>
                    </div>
                    <div class="cms-ttmn-info align-self-end pt-33 bdr-t-1 bdr-divider w-100 d-flex flex-nowrap gap-16 align-items-center">
                        <?php
                            genzia_elementor_image_render($testimonial,[
                                'name'           => 'image',
                                'image_size_key' => 'image',
                                'img_class'      => 'cms-ttmn--img circle',
                                'size'           => 'custom',
                                'custom_size'    => ['width' => 48, 'height' => 48],
                                'attrs'          => [],
                                'before'         => ''
                            ]);
                        ?>
                        <div class="">
                            <div <?php ctc_print_html($widget->get_render_attribute_string('ttmn-author')); ?>><?php 
                                echo esc_html($testimonial['name']); 
                            ?></div>
                            <div <?php ctc_print_html($widget->get_render_attribute_string('ttmn-author-pos')); ?>><?php 
                                echo esc_html($testimonial['position']); 
                            ?></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php switch ($layout_mode) {
        case 'carousel':
            // code...
    ?>
        </div>
    </div>
    <div <?php ctc_print_html($this->get_render_attribute_string('arrows-dots')); ?>><?php
        // Arrows
        if ($arrows == 'yes' && $layout_mode == 'carousel'){ ?>
            <div <?php ctc_print_html($this->get_render_attribute_string('arrows')); ?>>
                <?php 
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
                ?>
            </div>
        <?php }
        // Dots
        if ($dots == 'yes') { ?>
            <div <?php ctc_print_html($this->get_render_attribute_string('dots')); ?>></div>
        <?php } 
    ?></div>
    <?php
        break;
    default :
        // code...
        break;
    } ?>
</div>