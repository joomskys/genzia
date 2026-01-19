<?php
$default_align  = 'start';
$testimonials   = $this->get_setting('testimonials', []);
$layout_mode    = $this->get_setting('layout_mode', 'grid');
$col_gap        = $this->get_setting('col_gap', 40);
//
$arrows = $this->get_setting('arrows');
$dots = $this->get_setting('dots');
// Arrows Dots
$this->add_render_attribute('arrows-dots',[
    'class' => [
        'd-flex gap-32',
        'flex-auto',
        'col-7 col-tablet-9 col-smobile-12'
    ]
]);
// Arrows
$this->add_render_attribute('arrows', [
    'class' => [
        'cms-swiper-buttons d-flex',
        genzia_add_hidden_device_controls_render($settings, 'arrows_')
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
$this->add_render_attribute('dots', [
    'class' => [
        'cms-carousel-dots cms-carousel-dots-custom',
        genzia_add_hidden_device_controls_render($settings, 'dots_'),
        'relative',
        'flex-basic'
    ],
    'style' => [
        '--cms-dots-color:var(--cms-'.$this->get_setting('dots_color','menu').');',
        '--cms-dots-hover-color:var(--cms-'.$this->get_setting('dots_active_color','accent-regular').');',
        '--cms-dots-hover-shadow:var(--cms-'.$this->get_setting('dots_active_color','accent-regular').');',
        '--cms-dots-hover-opacity:1;'
    ]
]);
// Dots Custom
$widget->add_render_attribute('dots-custom', [
    'class' => [
        'cms-ttmn-dots-custom',
        'cms-opacity-0 cms-active-opacity-1',
        //'bg-'.$widget->get_setting('dots_color','bg-light'),
        //'bg-hover-'.$widget->get_setting('dots_active_color','bg-light'),
        //'bg-active-'.$widget->get_setting('dots_active_color','bg-light'),
        'cms-transition',
        'absolute top left'
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
$this->add_render_attribute('description',[
    'class' => [
       'cms-ttmn-desc',
       'h4',
       'text-'.$this->get_setting('desc_color','heading-regular'),
       'm-tb-n5',
       'swiper-nav-vert',
       'col-7 col-tablet-9 col-smobile-12'
    ]
]);
// Author Name
$this->add_render_attribute('ttmn-author',[
    'class' => [
        'cms-ttmn--name h6 empty-none',
        'text-'.$this->get_setting('author_color', 'heading-regular')
    ]
]);
// Author Position
$this->add_render_attribute('ttmn-author-pos',[
    'class' => [
        'cms-ttmn--pos',
        'text-md',
        'text-'.$this->get_setting('author_pos_color', 'body')
    ]
]);
// Items
$this->add_render_attribute('ttmn-item',[
    'class' => [
        'cms-ttmn-item'
    ]
]);
// Element Heading 
// Small Heading
$this->add_inline_editing_attributes( 'smallheading_text' );
$this->add_render_attribute( 'smallheading_text', [
    'class' => [
        'elementor-invisible',
        'cms-small cms-nl2br',
        'text-'.$this->get_setting('smallheading_color','accent-regular'),
        'text-lg',
        'empty-none',
        'w-100',
        'pb-33'
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInUp',
        'animation_delay' => 100
    ])
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
                <div class="d-flex gutter justify-content-between">
                    <div class="cms-ttmn-avatar col-5 col-tablet-3 col-smobile-12 d-flex">
                        <div <?php ctc_print_html( $this->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php 
                            echo nl2br( $settings['smallheading_text'] ); 
                        ?></div>
                        <?php
                            genzia_elementor_image_render($testimonial,[
                                'name'           => 'image',
                                'image_size_key' => 'image',
                                'img_class'      => 'cms-ttmn--img',
                                'size'           => 'custom',
                                'custom_size'    => ['width' => 208, 'height' => 250],
                                'before'         => '<div class="ttmn-avatar relative align-self-end">',
                                'after'          => genzia_svgs_icon([
                                    'icon'       => 'quote',
                                    'icon_size'  => 48,
                                    'class'      => 'absolute top left mt-8 ml-8 text-white',
                                    'echo'       => false
                                ]).'</div>'
                            ]);
                        ?>
                    </div>
                    <div <?php ctc_print_html($this->get_render_attribute_string('description')); ?>>
                        <div class="pb" style="--pb:140px;--pb-mobile:0;"><?php 
                            echo nl2br($testimonial['description']); 
                        ?></div>
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
    <div class="cms-arrows-dots d-flex justify-content-end mt" style="--mt:-58px;--mt-mobile:30px;">
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
                <div <?php ctc_print_html($this->get_render_attribute_string('dots')); ?>>
                    <?php 
                        foreach ($testimonials as $dot_key => $dot) {
                    ?>
                        <div <?php ctc_print_html($this->get_render_attribute_string('dots-custom')); ?>>
                            <div <?php ctc_print_html($widget->get_render_attribute_string('ttmn-author')); ?>><?php 
                                echo esc_html($dot['name']); 
                            ?></div>
                            <div <?php ctc_print_html($widget->get_render_attribute_string('ttmn-author-pos')); ?>><?php 
                                echo esc_html($dot['position']); 
                            ?></div>
                        </div>
                    <?php
                        }
                    ?>
                </div>
            <?php } 
        ?></div>
    </div>
        <?php
            break;
        default :
            // code...
            break;
    } ?>
</div>