<?php
$default_align = 'start';
$testimonials = $this->get_setting('testimonials', []);

// Wrap
$this->add_render_attribute('wrap', [
    'class' => [
        'cms-ettmn',
        'cms-ettmn-' . $settings['layout'],
        'text-' . $default_align,
        'relative',
        'd-flex',
        'flex-col-5'
    ]
]);
// Items
$this->add_render_attribute('ttmn-item', [
    'class' => [
        'cms-ttmn-item'
    ]
]);
// Element Heading
// Small Heading
$this->add_inline_editing_attributes('smallheading_text');
$this->add_render_attribute('smallheading_text', [
    'class' => [
        'cms-small',
        'elementor-invisible',
        'cms-nl2br',
        'text-sm',
        'text-' . $this->get_setting('smallheading_color', 'sub-text'),
        'empty-none',
        'm-tb-nsm',
        'pb-15',
        'd-flex gap-8 flex-nowrap'
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInLeft',
        'animation_delay' => 100
    ])
]);
$small_icon_classes = genzia_nice_class([
    'cms-small-icon pt-7',
    'text-' . $this->get_setting('smallheading_icon_color', 'accent-regular')
]);
// Large Heading
$this->add_inline_editing_attributes('heading_text');
$this->add_render_attribute('heading_text', [
    'class' => [
        'cms-title empty-none',
        'text-' . $this->get_setting('heading_color', 'heading-regular'),
        'cms-nl2br',
        'elementor-invisible',
        'm-tb-nh2'
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInUp',
        'animation_delay' => 200
    ])
]);
?>
<div class="cms-ttmn-eheading max-w pb" style="--max-w:848px;--pb:75px;--pb-tablet:40px;">
    <div <?php ctc_print_html($this->get_render_attribute_string('smallheading_text')); ?>><?php
      // Icon
      genzia_elementor_icon_render($settings['smallheading_icon'], [], ['aria-hidden' => 'true', 'class' => $small_icon_classes, 'icon_size' => 12]);
      // Text
      echo nl2br($settings['smallheading_text']);
      ?></div>

    <h2 <?php ctc_print_html($this->get_render_attribute_string('heading_text')); ?>><?php
      echo nl2br($settings['heading_text']);
      ?></h2>
</div>
<div class="cms-ettmn-section">
    <div class="cms-ettmn-wrapper">
        <div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
            <?php
            $count = 0;
            foreach ($testimonials as $key => $testimonial) {
                if ($count >= 5) {
                    break;
                }
                $count++;
                // Item Inner
                $item_inner_key = $this->get_repeater_setting_key('ttmn--item', 'cms_testimonial', $key);
                $this->add_render_attribute($item_inner_key, [
                    'class' => array_filter([
                        'cms-ttmn--item',
                        'p-40',
                        'cms-shadow-2 cms-hover-shadow-1',
                        'cms-transition',
                        'relative',
                        'cms-radius-16',
                        'd-flex flex-column justify-content-between',
                        ($count % 2 == 0) ? 'bg-menu' : 'bg-white'
                    ]),
                    'style' => [
                        ($count % 2 == 0) ? 'transform:rotate(-5deg);' : 'transform:rotate(5deg);',
                        'margin-inline-start:-32px;'
                    ]
                ]);
                // Description 
                $item_desc = $this->get_repeater_setting_key('description', 'cms_testimonial', $key);
                $this->add_render_attribute($item_desc, [
                    'class' => [
                        'cms-ttmn-desc',
                        'heading text-xl',
                        ($count % 2 == 0) ? 'text-white' : 'text-heading-regular',
                        'mt-nxl'
                    ]
                ]);
                // Author Name
                $item_author = $this->get_repeater_setting_key('ttmn-author', 'cms_testimonial', $key);
                $this->add_render_attribute($item_author, [
                    'class' => [
                        'cms-ttmn--name empty-none',
                        'text-md font-700',
                        ($count % 2 == 0) ? 'text-white' : 'text-heading-regular',
                    ]
                ]);
                // Author Position
                $item_position = $this->get_repeater_setting_key('ttmn-author-pos', 'cms_testimonial', $key);
                $this->add_render_attribute($item_position, [
                    'class' => [
                        'cms-ttmn--pos',
                        'text-md',
                        ($count % 2 == 0) ? 'text-on-dark' : 'text-body',
                    ]
                ]);
                ?>
                <div <?php ctc_print_html($this->get_render_attribute_string('ttmn-item')); ?>>
                    <div <?php ctc_print_html($widget->get_render_attribute_string($item_inner_key)); ?>>
                        <div class="align-self-start w-100">
                            <div class="d-flex gap-6 text-warning pb-23">
                                <?php
                                genzia_svgs_icon([
                                    'icon' => 'core/star',
                                    'icon_size' => 18
                                ]);
                                genzia_svgs_icon([
                                    'icon' => 'core/star',
                                    'icon_size' => 18
                                ]);
                                genzia_svgs_icon([
                                    'icon' => 'core/star',
                                    'icon_size' => 18
                                ]);
                                genzia_svgs_icon([
                                    'icon' => 'core/star',
                                    'icon_size' => 18
                                ]);
                                genzia_svgs_icon([
                                    'icon' => 'core/star',
                                    'icon_size' => 18
                                ]);
                                ?>
                            </div>
                            <div <?php ctc_print_html($widget->get_render_attribute_string($item_desc)); ?>>
                                <?php
                                echo nl2br($testimonial['description']);
                                ?>
                            </div>
                        </div>
                        <div class="cms-ttmn-info align-self-end mt pt-33 bdr-t-1 bdr-divider w-100 d-flex flex-nowrap gap-16 align-items-center"
                            style="--mt:90px;--mt-tablet:40px;">
                            <?php
                            genzia_elementor_image_render($testimonial, [
                                'name' => 'image',
                                'image_size_key' => 'image',
                                'img_class' => 'cms-ttmn--img circle',
                                'size' => 'custom',
                                'custom_size' => ['width' => 48, 'height' => 48],
                                'attrs' => [],
                                'before' => ''
                            ]);
                            ?>
                            <div class="">
                                <div <?php ctc_print_html($widget->get_render_attribute_string($item_author)); ?>>
                                    <?php
                                    echo esc_html($testimonial['name']);
                                    ?>
                                </div>
                                <div <?php ctc_print_html($widget->get_render_attribute_string($item_position)); ?>>
                                    <?php
                                    echo esc_html($testimonial['position']);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>