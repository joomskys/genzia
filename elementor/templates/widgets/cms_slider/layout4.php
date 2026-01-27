<?php
//
$default_align = 'start';
$cms_slides = $this->get_setting('cms_slides', []);
$arrows     = $this->get_setting('arrows','');
$dots       = $this->get_setting('dots','');
$autoplay_speed = $this->get_setting('autoplay_speed',5000) - 500;
// Arrow
$arrows_classes = [
    'cms-slider-button-arrow',
    'cms-box-62',
    'text-white',
    genzia_add_hidden_device_controls_render($settings, 'arrows_'),
    'cms-hover-change',
    'cms-opacity-05',
    'cms-hover-opacity-1'
];
$arrows_prev_classes = genzia_nice_class(array_merge(
    $arrows_classes,
    [
        'cms-carousel-button-prev',
        'cms-hover-move-icon-left'
    ]
));
$arrows_next_classes = genzia_nice_class(array_merge(
    $arrows_classes,
    [
        'cms-carousel-button-next',
        'cms-hover-move-icon-right'
    ]
));
// Dots
$dots_type = $this->get_setting('dots_type', 'bullets');
$this->add_render_attribute('dots', [
    'class' => [
        'cms-carousel-dots',
        'cms-carousel-dots-'.$settings['dots_type'],
        genzia_add_hidden_device_controls_render($settings, 'dots_'),
        'absolute bottom z-top',
        'd-flex justify-content-center',
        'pb-20'
    ],
    'style' => [
        '--cms-dots-color:var(--cms-white-70);',
        '--cms-dots-hover-color:var(--cms-white);',
        '--cms-dots-hover-shadow:var(--cms-divider-light);',
        '--cms-dots-hover-opacity:0.35;'
    ]
]);
switch ($dots_type) {
    case 'bullets':
        $dot_gap = 10;
        break;
    case 'custom':
        $dot_gap = '40 gap-tablet-20';
        break;
    default:
        $dot_gap = 25;
        break;
}
$this->add_render_attribute('dots', [
    'class' => 'gap-'.$dot_gap
]);
// Wrapper
$this->add_render_attribute('wrap', [
    'class' => [
        'cms-eslider',
        'cms-eslider-'.$settings['layout'],
        'cms-carousel', 
        'swiper'
    ]
]);
// Wrapper Inner
$this->add_render_attribute('wrap-inner', [
    'class' => [
        'cms--eslider',
        'swiper-wrapper'
    ]
]);
// Slider Items
$this->add_render_attribute('slider-item', [
    'class' => [
        'cms-slider-item swiper-slide relative',
        'cms-gradient-render cms-gradient-'.$this->get_setting('overlay_style', 1),
        'cms-radius-16 overflow-hidden'
    ]
]);
// Slider Content
$this->add_render_attribute('cms-slider-content', [
    'class' => [
        'cms-slider-content cms-overlay d-flex',
        'p-tb'
    ],
    'style' => '--p-tb:112px;--p-tb-tablet:50px;'
]);
// Container
$this->add_render_attribute('container', [
    'class' => [
        'container',
        'd-flex',
        'h-100'
    ]
]);
// Subtitle
$this->add_render_attribute('subtitle', [
    'class' => [
        'cms-slider-subtitle pb-12 empty-none',
        'text-on-dark',
        'text-lg m-tb-nlg',
        genzia_add_hidden_device_controls_render($settings, 'subtitle_'),
        'd-flex gap-12 flex-nowrap',
        'justify-content-'.$default_align
    ],
    'data-cms-animation'       => 'subtitle_animation',
    'data-cms-animation-delay' => 'subtitle_animation_delay'
]);
// Title 
$this->add_render_attribute('title', [
    'class' => [
        'cms-slider-title',
        'empty-none cms-nl2br',
        'text-3xl text-mobile-h3 lh-09',
        'text-'.$this->get_setting('title_color','white'),
        genzia_add_hidden_device_controls_render($settings, 'title_'),
        'mt-n20'
    ],
    'data-cms-animation'       => 'title_animation',
    'data-cms-animation-delay' => 'title_animation_delay'
]);
// Description
$this->add_render_attribute('desc', [
    'class' =>  [
        'cms-slider-desc empty-none cms-nl2br',
        'text-on-dark',
        'text-lg',
        genzia_add_hidden_device_controls_render($settings, 'desc_'),
        'm-tb-n7'
    ],
    'data-cms-animation'       => 'description_animation',
    'data-cms-animation-delay' => 'description_animation_delay'
]);
// Buttons
$this->add_render_attribute('buttons', [
    'class' => [
        'cms-slider-buttons d-flex gap-24',
        'align-items-center',
        'pt-25',
        'empty-none'
    ]
]);
// Features Title
$this->add_render_attribute('feature_title',[
    'class' => [
        'feature-title',
        'heading',
        'text-xl text-white',
        'empty-none',
        'pb-15 mb-25',
        'bdr-b-1 bdr-divider-light',
        'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
        'animation'       => $this->get_setting('feature_animation', 'fadeInUp'),
        'animation_delay' => $this->get_setting('feature_animation_delay', 1200)
    ])
]);
// Features Desc
$this->add_render_attribute('feature_desc',[
    'class' => [
        'feature-desc',
        'text-md text-on-dark',
        'empty-none',
        'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
        'animation'       => $this->get_setting('feature_animation', 'fadeInUp'),
        'animation_delay' => ($this->get_setting('feature_animation_delay', 1200) + 200)
    ])
]);
// Features
$this->add_render_attribute('features-wrap',[
    'class' => [
        'cms-features-wrap empty-none',
        'text-end'
    ]
]);
$this->add_render_attribute('features',[
    'class' => [
        'cms-features empty-none',
        'text-white'
    ]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')) ?>>
    <div <?php ctc_print_html($this->get_render_attribute_string('wrap-inner')) ?>>
        <?php foreach ($cms_slides as $key => $cms_slide) { 
            $features = (array)json_decode($cms_slide['features'], true);
           
            if(empty($cms_slide['feature_title']) || empty($cms_slide['feature_desc']) || empty($features)){
                $this->add_render_attribute('cms-slider-content', [
                    'class' => 'align-items-center'
                ]);
            }
            ?>
            <div <?php ctc_print_html($this->get_render_attribute_string('slider-item')) ?>>
                <?php 
                    $cms_slide['lazy']       = false;
                    $cms_slide['image_size'] = 'full';

                    $image_attrs = [
                            'class' => 'cms-slider-img img-cover cms-radius-16',
                            'alt'   => get_bloginfo('name'),
                            'sizes' => '(min-width: 1200px) 100vw, 100vw',
                            'duration' => $autoplay_speed
                        ];
                        
                        // First slide optimization for LCP
                        if ( $key === 0 ) {
                            $image_attrs['loading'] = 'eager';
                            $image_attrs['fetchpriority'] = 'high';
                            $image_attrs['decoding'] = 'sync';
                        } else {
                            $image_attrs['loading'] = 'lazy';
                            $image_attrs['fetchpriority'] = 'low';
                            $image_attrs['decoding'] = 'async';
                        }
                        
                        if ( ! empty( $image_animation ) ) {
                            //$image_attrs['data-cms-animation'] = $image_animation;
                            //$image_attrs['data-cms-animation-delay'] = $image_animation_delay;
                        }
                    if(!empty($cms_slide['image']['id'])){
                        echo wp_get_attachment_image( $cms_slide['image']['id'], 'full', false, $image_attrs );
                    } else {
                        genzia_elementor_image_render($cms_slide, [
                            'size'      => 'full',
                            'img_class' => 'cms-slider-img img-cover', //cms-slider-img-effect
                            'duration'  => $autoplay_speed
                        ]);
                    }
                    // video
                    if($cms_slide['slide_type'] === 'video'){
                        genzia_elementor_video_background_render($widget, $settings, [
                            'url'      => $cms_slide['slide_video'], 
                            'loop'     => true, 
                            'loop_key' => $key,
                            'class'    => 'cms-overlay elementor-repeater-item-' . $cms_slide['_id'],
                            'fit'      => false 
                        ]);
                    }
                    // Title image
                    $title_img = genzia_elementor_image_render($cms_slide, [
                        'name'        => 'title_img',
                        'size'        => 'custom',
                        'custom_size' => ['width' => 224, 'height' => 86],
                        'img_class'   => 'cms-radius-rounded vertical-baseline',
                        'echo'        => false
                    ]);
                    $cms_slide['title'] = str_replace('{{title_img}}', $title_img, $cms_slide['title']);
                ?>
                <div <?php ctc_print_html($this->get_render_attribute_string('cms-slider-content')); ?>>
                    <div <?php ctc_print_html($this->get_render_attribute_string('container')); ?>>
                        <div class="d-flex justify-content-end w-100">
                            <div class="cms-slider--content-top max-w" style="--max-w:390px">
                                <div <?php ctc_print_html($this->get_render_attribute_string('desc')); ?>><?php echo nl2br($cms_slide['description']); ?></div>
                                <div <?php ctc_print_html($this->get_render_attribute_string('buttons')); ?>><?php
                                    // Button Primary
                                    if ( ! empty( $cms_slide['button_primary'] ) ) :
                                    $button_primary_link = $this->get_repeater_setting_key( 'button_primary_link', 'cms_slider', $key );
                                    $this->add_render_attribute( $button_primary_link, [
                                        'class' => [
                                            'cms-slider-btn',
                                            'text-white text-hover-white',
                                            genzia_add_hidden_device_controls_render($settings, 'btn1_'),
                                            'cms-hover-move-icon-right',
                                            'text-md font-700',
                                            'bdr-b-1 bdr-divider-light bdr-hover-white',
                                            'd-flex gap-12 align-items-center'
                                        ],
                                        'data-cms-animation'       => 'button_primary_animation',
                                        'data-cms-animation-delay' => 'button_primary_animation_delay'
                                    ]);
                                    $this->add_link_attributes( $button_primary_link, $cms_slide['button_primary_link'] );
                                ?>
                                    <a <?php ctc_print_html($this->get_render_attribute_string( $button_primary_link )); ?>><?php
                                        // icon
                                        genzia_svgs_icon([
                                            'icon'      => 'arrow-right',
                                            'icon_size' => 10
                                        ]);
                                        // text
                                        echo ctc_print_html($cms_slide['button_primary']);
                                    ?></a>
                                <?php endif;
                                    // Button Secondary
                                    if ( ! empty( $cms_slide['button_secondary'] ) ) :
                                        $button_secondary_link = $this->get_repeater_setting_key( 'button_secondary_link', 'cms_slider', $key );
                                        $this->add_render_attribute( $button_secondary_link, [
                                            'class' => [
                                                'cms-slider-btn',
                                                'text-white text-hover-white',
                                                genzia_add_hidden_device_controls_render($settings, 'btn2_'),
                                                'cms-hover-move-icon-right',
                                                'text-md font-700',
                                                'bdr-b-1 bdr-divider-light bdr-hover-white',
                                                'd-flex gap-12 align-items-center'
                                            ],
                                            'data-cms-animation'       => 'button_secondary_animation',
                                            'data-cms-animation-delay' => 'button_secondary_animation_delay'
                                        ]);
                                        $this->add_link_attributes( $button_secondary_link, $cms_slide['button_secondary_link'] );
                                ?>
                                    <a <?php ctc_print_html($this->get_render_attribute_string( $button_secondary_link )); ?>>
                                        <?php echo ctc_print_html( $cms_slide['button_secondary'] ); ?>
                                    </a>
                                <?php endif; 
                                    // Video button
                                    genzia_elementor_button_video_render($widget, $cms_slide, [
                                        '_id'           => $cms_slide['_id'],   
                                        'name'          => 'video_link',
                                        'icon_class'    => 'cms-transition',
                                        'icon_size'     => 10,
                                        'layout'        => '1',
                                        'class'         => '',
                                        'inner_class'   => '',
                                        'content_class' => genzia_nice_class([
                                            'text-md font-700',
                                            'text-white text-hover-white',
                                            'bdr-b-1 bdr-divider-light bdr-hover-white',
                                            'd-flex gap-12 align-items-center',
                                            genzia_add_hidden_device_controls_render($settings, 'btn_video_')
                                        ]),
                                        'text'          => $cms_slide['video_text'],
                                        'text_class'    => '',
                                        'echo'          => true,
                                        'loop'          => true,
                                        'loop_key'      => $key, 
                                        'attrs'         => [
                                            'data-cms-animation'       => 'button_video_animation',
                                            'data-cms-animation-delay' => 'button_video_animation_delay'
                                        ]
                                    ]);
                                ?></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-end align-self-end w-100 pt-50 pt-tablet-30">
                            <div class="flex-basic">
                                <div class="cms-slider--content">
                                    <?php // Small Title ?>
                                    <div <?php ctc_print_html($this->get_render_attribute_string('subtitle')); ?>><?php
                                        echo ctc_print_html($cms_slide['subtitle']); 
                                    ?></div>
                                    <h1 <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php echo nl2br($cms_slide['title']); ?></h1>
                                </div>
                            </div>
                            <?php // Features 
                            if(!empty($cms_slide['feature_title']) || !empty($cms_slide['feature_desc']) || !empty($features)){
                            ?>
                            <div <?php ctc_print_html($this->get_render_attribute_string('features-wrap')); ?>>
                                <?php if(!empty($cms_slide['feature_title'])){ ?>
                                    <div <?php ctc_print_html($this->get_render_attribute_string('feature_title')); ?>><?php 
                                        echo nl2br($cms_slide['feature_title']);
                                    ?></div>
                                <?php }
                                if(!empty($cms_slide['feature_desc'])){
                                ?>
                                    <div <?php ctc_print_html($this->get_render_attribute_string('feature_desc')); ?>><?php 
                                        echo nl2br($cms_slide['feature_desc']);
                                    ?></div>
                                <?php } ?>
                                <div <?php ctc_print_html($this->get_render_attribute_string('features')); ?>><?php 
                                    // Features
                                    $fcount = 0;
                                    foreach ($features as $fkey => $feature) {
                                        $fcount++;
                                        $fitem_attrs = [
                                            'href'  => $feature['furl'],
                                            'class' => [
                                                'feature-item d-flex gap-8',
                                                'justify-content-end',
                                                'align-items-center',
                                                'flex-nowrap',
                                                'elementor-invisible',
                                                'text-btn font-700',
                                                'text-white text-hover-white',
                                                'cms-hover-change',
                                                'mt-12'
                                            ],
                                            'data-settings' => wp_json_encode([
                                                'animation'       => $this->get_setting('feature_animation', 'fadeInUp'),
                                                'animation_delay' => ($this->get_setting('feature_animation_delay', 1200) + $fcount*100)
                                            ])
                                        ];
                                ?>
                                    <a <?php ctc_print_html(genzia_render_attrs($fitem_attrs)); ?>><?php 
                                        // Icon
                                        genzia_svgs_icon([
                                            'icon'       => 'arrow-right',
                                            'icon_size'  => 9,
                                            'class'      => 'cms-hover-show move-left cms-transition'
                                        ]);
                                        // Text
                                        echo esc_html($feature['ftitle']);
                                    ?></a>
                                <?php
                                    }
                                ?></div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    // Arrows
    if ($arrows == 'yes'){ 
        genzia_svgs_icon([
            'icon'      => 'arrow-prev',
            'icon_size' => 25,
            'class'     => $arrows_prev_classes,
            'tag'   => 'div'
        ]);
        genzia_svgs_icon([
            'icon'      => 'arrow-next',
            'icon_size' => 25,
            'class'     => $arrows_next_classes,
            'tag'   => 'div'
        ]);
    }
    // Dots
    if ($dots == 'yes') { ?>
        <div <?php ctc_print_html($this->get_render_attribute_string('dots')); ?>><?php 
            if($settings['dots_type'] == 'custom'){
                foreach ($cms_slides as $key => $dot){
            ?>
                <div class="dots-custom">
                    <div class="text-13 bdr-b-1 brd-divider pb-5"><?php genzia_leading_zero($key+1); ?>.</div>
                    <div class="font-700 pt-15 text-line-2"><?php echo ctc_print_html($dot['subtitle']); ?></div>
                </div>
            <?php
                }
            }
        ?></div>
    <?php } ?>
</div>