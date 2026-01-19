<?php
$default_align  = 'start';
$tabs   = $this->get_setting('contents', []);
//
// Arrows
$arrows = $this->get_setting('arrows');
$this->add_render_attribute('arrows', [
    'class' => [
        'cms-swiper-buttons d-flex gap-12 flex-auto',
        genzia_add_hidden_device_controls_render($settings, 'arrows_')
    ]
]);
$arrows_classes = [
    'cms-carousel-button',
    'cms-box-48 cms-radius-6',
    'text-'.$this->get_setting('arrows_color','menu'),
    'bg-'.$this->get_setting('arrows_bg_color','transparent'),
    'text-hover-'.$this->get_setting('arrows_hover_color','white'),
    'bg-hover-'.$this->get_setting('arrows_bg_hover_color','menu'),
    'bdr-1 bdr-'.$this->get_setting('arrows_color','menu'),
    'bdr-hover-'.$this->get_setting('arrows_bg_hover_color','menu')
];
$arrows_classes_prev = genzia_nice_class(array_merge(['cms-carousel-button-prev prev'],$arrows_classes));
$arrows_classes_next = genzia_nice_class(array_merge(['cms-carousel-button-next next'],$arrows_classes));
// Dots
$dots = $this->get_setting('dots');
$this->add_render_attribute('dots', [
    'class' => [
        'flex-basic gap-12',
        'cms-carousel-dots cms-carousel-dots-custom',
        ($arrows == 'yes') ? 'justify-content-start':'justify-content-center',
        genzia_add_hidden_device_controls_render($settings, 'dots_'),
    ],
    'style' => [
        '--cms-dots-color:var(--cms-'.$this->get_setting('dots_color','menu').');',
        '--cms-dots-hover-color:var(--cms-'.$this->get_setting('dots_active_color','accent').');',
        '--cms-dots-hover-shadow:var(--cms-'.$this->get_setting('dots_active_color','accent').');',
        '--cms-dots-hover-opacity:0.2;'
    ]
]);
// Title
$this->add_render_attribute('title',[
    'class' => [
       'cms-title cms-heading',
       'm-tb-n5',
       'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInLeft'
    ])
]);
// Description 
$this->add_render_attribute('desc',[
    'class' => [
       'cms-desc',
       'pt-33',
       'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInLeft'
    ])
]);
// Banner 
$banner_custom_size = [
    'width'  => !empty($settings['banner_custom_dimension']['width']) ? $settings['banner_custom_dimension']['width'] : 560,
    'height' => !empty($settings['banner_custom_dimension']['height']) ? $settings['banner_custom_dimension']['height'] : 480
];
// Feature
$this->add_render_attribute('features-wrap', [
    'class' => [
        'cms-features empty-none',
        'pt-45',
        'text-sub-text font-700',
        'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInUp'
    ])
]);
$this->add_render_attribute('features-item',[
    'class' => [
        'cms-list',
        'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInUp'
    ])
]);
// Icons
$this->add_render_attribute('icon',[
    'class' => [
        'bg-accent-regular text-white font-700 text-md cms-radius-16',
        'absolute top left',
        'ml-n40 ml-tablet-n20 mt',
        'p-40',
        'elementor-invisible'
    ],
    'style' => "--mt:130px;width:190px;",
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInRight'
    ])
]);
// Items
$this->add_render_attribute('tab-item',[
    'class' => [
        'cms-tab-item',
        'swiper-slide'
    ]
]);
?>
<div class="cms-swiper-buttons-dots d-flex flex-mobile-wrap gap-40 gap-tablet-10 justify-content-between align-items-center empty-none pb-60"><?php
    // Dots
    if ($dots == 'yes') { ?>
    <div <?php ctc_print_html($this->get_render_attribute_string('dots')); ?>><?php 
        foreach ($tabs as $dot_key => $dot_content) { 
    ?>
        <div class="cms-swiper-pagination-custom bdr-1 cms-radius-6 p-tb-10 p-lr-30 bg-hover-menu text-hover-white bg-active-menu text-active-white"><?php ctc_print_html($dot_content['tab_title']);
         ?></div>
    <?php
        }
    ?></div>
    <?php }
    // Arrows
    if ($arrows == 'yes'){ ?>
        <div <?php ctc_print_html($this->get_render_attribute_string('arrows')); ?>>
            <?php 
                genzia_svgs_icon([
                    'icon'      => 'core/chevron-left',
                    'icon_size' => 8,
                    'class'     => $arrows_classes_prev,
                    'tag'       => 'div'
                ]);
                genzia_svgs_icon([
                    'icon'      => 'core/chevron-right',
                    'icon_size' => 8,
                    'class'     => $arrows_classes_next,
                    'tag'       => 'div'
                ]);
            ?>
        </div>
    <?php }
?></div>
<div class="cms-carousel swiper">
    <div class="swiper-wrapper">
        <?php foreach ($tabs as $key => $tab) { 
            //
            $features = json_decode($tab['features'], true);
        ?>
            <div <?php ctc_print_html($this->get_render_attribute_string('tab-item')); ?>>
                <div class="d-flex gutter">
                    <div class="col-5 col-tablet-6 col-mobile-12">
                        <h4 <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php echo esc_html($tab['title']); ?></h4>
                        <div <?php ctc_print_html($this->get_render_attribute_string('desc')); ?>><?php 
                            ctc_print_html($tab['desc']); 
                        ?></div>
                        <div <?php ctc_print_html($this->get_render_attribute_string('features-wrap')); ?>><?php
                            if(!empty($features)){ 
                                $count_feature = 0;
                                foreach ( $features as $fkey => $cms_feature ):
                                    $count_feature++;
                                    // Items
                                    $fitem_key = $this->get_repeater_setting_key( 'fitem', 'cms_tabs', $fkey );
                                    $this->add_render_attribute($fitem_key, [
                                        'class' => [
                                            'cms-item',
                                            'hover-icon-bounce',
                                            'p-tb-12',
                                            'bdr-divider',
                                            ($count_feature > 1) ? 'bdr-t-1' : '',
                                            'd-flex gap-12 flex-nowrap',
                                            'elementor-invisible'
                                        ],
                                        'data-settings' => wp_json_encode([
                                            'animation'       => 'fadeInUp',
                                            'animation_delay' => 100
                                        ])
                                    ]);
                                    //
                                    $ftitle_key = $this->get_repeater_setting_key( 'ftitle', 'cms_tabs', $fkey );
                                    $this->add_render_attribute($ftitle_key, [
                                        'class' => [
                                            'feature-title',
                                            'flex-basic'
                                        ]
                                    ]);
                                ?>
                                    <div <?php ctc_print_html($this->get_render_attribute_string($fitem_key)); ?>>
                                        <?php
                                            genzia_svgs_icon([
                                                'icon'       => 'core/check',
                                                'icon_size'  => 10,
                                                'icon_class' => 'cms-icon pt-12 text-accent-regular'
                                            ]);
                                        ?>
                                        <div <?php ctc_print_html( $this->get_render_attribute_string( $ftitle_key ) ); ?>><?php echo esc_html( $cms_feature['ftitle'] ) ?></div>
                                    </div>
                                <?php endforeach;
                            } 
                        ?></div>
                        <?php 
                            // Button
                            genzia_elementor_link_render($widget, $tab, [
                                'name'      => 'link1_',
                                'loop'      => true,
                                'loop_key'  => $key,
                                'mode'      => 'btn',
                                'text_icon' => '',
                                'class'            => ['btn-lg','justify-content-between','cms-hover-change','cms-hover-move-icon-right','elementor-invisible','mt-30'],
                                'btn_color'        => $this->get_setting('btn_color','menu'),
                                'text_color'       => $this->get_setting('btn_text_color','white'),
                                'btn_color_hover'  => $this->get_setting('btn_color_hover','menu'),
                                'text_color_hover' => $this->get_setting('btn_text_color_hover','white'),
                                'attrs'            => [
                                    'data-settings' => wp_json_encode([
                                        'animation'       => 'fadeInLeft',
                                        'animation_delay' => 200
                                    ])
                                ],
                                'after_text'      => ''
                            ]);
                        ?>
                    </div>
                    <div class="col-7 col-tablet-6 col-mobile-12">
                        <div class="cms-sticky ml-70 ml-tablet-0 <?php echo esc_attr($this->get_setting('banner_class')); ?>" style="--cms-sticky:0;">
                            <?php
                                genzia_elementor_image_render($tab,[
                                    'name'           => 'banner',
                                    'image_size_key' => 'banner',
                                    'img_class'      => 'cms-tab-banner cms-radius-tltrbr-24 elementor-invisible img-cover',
                                    'size'           => $this->get_setting('banner_size','custom'),
                                    'custom_size'    => $banner_custom_size,
                                    'attrs'          => [
                                        'data-settings' => wp_json_encode([
                                            'animation' => 'fadeInRight'
                                        ])
                                    ],
                                    'min_height' => true,
                                    'max_height' => true,
                                    'before'     => '',
                                    'after'      => ''
                                ]);
                            ?>
                            <div <?php ctc_print_html($this->get_render_attribute_string('icon')); ?>>
                                <?php 
                                // Icon
                                genzia_elementor_icon_render( $tab['icon'], [], [ 'aria-hidden' => 'true', 'class' => 'cms-icon mb-40', 'icon_size' => 64, 'icon_color' => 'white', 'icon_color_hover' => 'white'], 'div' );
                                ?>
                                <div class="m-tb-n7"><?php 
                                    // title
                                    ctc_print_html($tab['icon_title']);
                                ?></div>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>