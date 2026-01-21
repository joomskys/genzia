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
        'cms-gradient-render cms-gradient-'.$this->get_setting('overlay_style', 1)
    ]
]);
// Slider Content
$this->add_render_attribute('cms-slider-content', [
    'class' => 'cms-slider-content cms-overlay d-flex'
]);
// Container
$this->add_render_attribute('container', [
    'class' => [
        'container',
        //'justify-content-'.$default_align,
        //'text-'.$default_align,
    ]
]);
// Subtitle
$this->add_render_attribute('subtitle', [
    'class' => [
        'cms-slider-subtitle m-tb-n6 pb-12 empty-none',
        'text-on-dark',
        'text-lg',
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
        'cms-slider-title heading font-400',
        'empty-none cms-nl2br',
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
        'text-end',
        genzia_add_hidden_device_controls_render($settings, 'desc_'),
        'm-tb-n7 pt-55 pt-tablet-30'
    ],
    'data-cms-animation'       => 'description_animation',
    'data-cms-animation-delay' => 'description_animation_delay'
]);
// Buttons
$this->add_render_attribute('buttons', [
    'class' => [
        'cms-slider-buttons d-flex gap-24',
        'justify-content-end',
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
$this->add_render_attribute('features',[
    'class' => [
        'cms-features empty-none text-white lh-11',
        //'elementor-invisible',
        genzia_add_hidden_device_controls_render($settings, 'feature_'),
        'd-flex gapX-24 gapY-10',
        'justify-content-'.$default_align,
        'align-items-start'
    ]
]);

// Statics
$statics = $this->get_setting('statics',[]);
$this->add_render_attribute('statics',[
    'class' => [
        'cms-slide-statics d-flex empty-none',
        genzia_add_hidden_device_controls_render($settings, 'static_'),
        'bg-white cms-radius-rounded'
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
                            'class' => 'cms-slider-img img-cover',
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
                        <div class="d-flex gutter">
                            <div class="col-8 col-mobile-12">
                                <div class="cms-slider--content">
                                    <?php // Small Title ?>
                                    <div <?php ctc_print_html($this->get_render_attribute_string('subtitle')); ?>><?php
                                        echo ctc_print_html($cms_slide['subtitle']); 
                                    ?></div>
                                    <h1 <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php echo nl2br($cms_slide['title']); ?></h1>
                                </div>
                            </div>
                            <div class="col-4 col-mobile-12">
                                <div class="cms-slider-static-video d-flex justify-content-end pt" style="--pt:118px;--pt-tablet:40px;--pt-mobile:0;">
                                    <div class="cms-slider--static-video"> 
                                    <?php // Statics content 
                                        if(!empty($statics)){
                                            $scount = 0;
                                    ?>
                                        <div <?php ctc_print_html($this->get_render_attribute_string('statics')); ?>><?php 
                                            foreach ($statics as $s_key => $static) {
                                                $scount++;
                                                $s_item_key = [
                                                    'class' => [
                                                        'cms-slide-static',
                                                        'cms-box-56 bg-white',
                                                        'circle',
                                                        'p-4 overflow-hidden',
                                                        'elementor-invisible',
                                                        ($scount>1) ? 'ml-n16' : ''
                                                    ],
                                                    'data-settings' => wp_json_encode([
                                                        'animation'       => $this->get_setting('static_animation'),
                                                        'animation_delay' => ($this->get_setting('static_animation_delay') + $scount*100)
                                                    ]),
                                                    'data-title' => $static['title']
                                                ];
                                            ?>
                                                <div <?php ctc_print_html(genzia_render_attrs($s_item_key)); ?>>
                                                <?php
                                                        // Icon
                                                        genzia_elementor_icon_image_render($widget, $settings,[
                                                            'prefix'      => 'static_',  
                                                            'size'        => 40,
                                                            'color'       => $this->get_setting('static_color','accent-regular'),
                                                            'color_hover' => $this->get_setting('static_color','accent-regular'),
                                                            // icon
                                                            'icon_tag'    => 'div',
                                                            'icon_default' => [],
                                                            // image
                                                            'img_size'        => 'custom',
                                                            'img_custom_size' => ['width' => 48, 'height' => 48],
                                                            // default
                                                            'class'      => 'circle',
                                                            'before'     => '',
                                                            'after'      => '',
                                                            'echo'       => true   
                                                        ], $static);
                                                ?></div>
                                            <?php } ?>
                                        </div>
                                    <?php }
                                    // Video button
                                    genzia_elementor_button_video_render($widget, $cms_slide, [
                                        '_id'           => $cms_slide['_id'],   
                                        'name'          => 'video_link',
                                        'icon_class'    => 'cms-transition cms-box-48 circle bg-accent-regular text-white m-lr-auto',
                                        'icon_size'     => 10,
                                        'layout'        => '1 bg-white cms-radius-16 p-8',
                                        'class'         => genzia_add_hidden_device_controls_render($settings, 'btn_video_'),
                                        'inner_class'   => 'cms-radius-10 bg-bg-light p-12 text-center',
                                        'content_class' => 'd-flex gap-10 flex-column justify-content-center',
                                        'text'          => $cms_slide['video_text'],
                                        'text_class'    => 'text-btn font-700 mb-n5',
                                        'echo'          => true,
                                        'loop'          => true,
                                        'loop_key'      => $key, 
                                        'attrs'         => [
                                            'data-cms-animation'       => 'button_video_animation',
                                            'data-cms-animation-delay' => 'button_video_animation_delay'
                                        ]
                                    ]); ?>
                                    </div>
                                </div>
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
                                    
                                ?></div>
                                <?php // Features ?>
                                <div class="features-wrap w-100 align-self-end pb-25 pb-tablet-0">
                                    <div <?php ctc_print_html($this->get_render_attribute_string('feature_title')); ?>><?php 
                                        echo nl2br($cms_slide['feature_title']);
                                    ?></div>
                                    <div class="d-flex gap" style="--cms-gap:210px;--cms-gap-tablet:40px;--cms-gap-mobile:10px;">
                                        <div <?php ctc_print_html($this->get_render_attribute_string('features')); ?>><?php 
                                            // Features
                                            $fcount = 0;
                                            foreach ($features as $fkey => $feature) {
                                                $fcount++;
                                                $fitem_attrs = [
                                                    'href'  => $feature['furl'],
                                                    'class' => [
                                                        'feature-item d-flex gap-8',
                                                        'align-items-center',
                                                        'flex-nowrap',
                                                        'elementor-invisible',
                                                        'cms-underline cms-hover-underline',
                                                        'cms-hover-move-icon-right',
                                                        'text-btn',
                                                        'text-white text-hover-white'
                                                    ],
                                                    'data-settings' => wp_json_encode([
                                                        'animation'       => $this->get_setting('feature_animation', 'fadeInUp'),
                                                        'animation_delay' => ($this->get_setting('feature_animation_delay', 1200) + $fcount*100)
                                                    ])
                                                ];
                                        ?>
                                            <a <?php ctc_print_html(genzia_render_attrs($fitem_attrs)); ?>><?php 
                                                // Text
                                                echo esc_html($feature['ftitle']); 
                                                // Icon
                                                genzia_svgs_icon([
                                                    'icon'       => 'arrow-right',
                                                    'icon_size'  => 9,
                                                    'class'      => ''
                                                ]);
                                            ?></a>
                                        <?php
                                            }
                                        ?></div>
                                        <div <?php ctc_print_html($this->get_render_attribute_string('feature_desc')); ?>><?php 
                                            echo nl2br($cms_slide['feature_desc']);
                                        ?></div>
                                    </div>
                                </div>
                            </div>
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