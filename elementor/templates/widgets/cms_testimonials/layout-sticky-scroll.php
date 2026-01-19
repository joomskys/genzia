<?php
$default_align  = 'start';
$testimonials   = $this->get_setting('testimonials', []);
// Wrap
$this->add_render_attribute('wrap', [
    'class' => [
        'cms-ettmn',
        'cms-ettmn-'.$settings['layout'],
        'relative'
    ]
]);
// Description 
$this->add_render_attribute('description',[
    'class' => [
       'cms-ttmn-desc',
       'h4',
       'text-'.$this->get_setting('desc_color','heading-regular'),
       'm-tb-nh4'
    ]
]);
// Author Name
$this->add_render_attribute('ttmn-author',[
    'class' => [
        'cms-ttmn--name empty-none',
        'text-md font-700',
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
// Element Heading 
// Small Heading
$this->add_inline_editing_attributes( 'smallheading_text' );
$this->add_render_attribute( 'smallheading_text', [
    'class' => [
        'cms-small cms-nl2br',
        'text-'.$this->get_setting('smallheading_color','heading-regular'),
        'text-2xl',
        'h-100vh',
        'cms-sticky',
        'd-flex align-items-center justify-content-center',
        'text-center'
    ],
    'data-parallax' => wp_json_encode([
        'scale' => 1.5
    ])
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
    <h2 <?php ctc_print_html( $this->get_render_attribute_string( 'smallheading_text' ) ); ?>>
        <span class="cms-gradient-render cms-gradient-4"><?php 
        echo nl2br( $settings['smallheading_text'] ); 
        ?></span>
    </h2>
    <?php 
        $count = 0;
        foreach ($testimonials as $key => $testimonial) {
            $count++;
        //
        $item_key = $this->get_repeater_setting_key('item','cms_testimonial', $key);
        $this->add_render_attribute($item_key,[
            'class' => [
                'cms-ttmn-item',
                'cms-shadow-1',
                'bg-white',
                'cms-radius-16',
                'p-64 p-smobile-20',
                'relative',
                //'elementor-invisible'
            ],
            'style' => array_filter([
                'max-width:672px;',
                (in_array($count, [2,5])) ? 'transform:rotate(-5deg);' : '',
                (in_array($count, [3,6])) ? 'transform:rotate(5deg);' : '',
            ]),
            'data-settings' => wp_json_encode([
                'animation' => 'rotateInUpRight',
                'animation_delay' => 500
            ])
        ]);
    ?>
        <div class="h-100vh cms-sticky d-flex align-items-center justify-content-center">
            <div <?php ctc_print_html($this->get_render_attribute_string($item_key)); ?>>
                <?php 
                    genzia_svgs_icon([
                        'icon'      => 'dots',
                        'icon_size' => 12,
                        'class'     => 'absolute top right mt-30 mr-30 text-accent-regular'
                    ]);
                ?>
                <div <?php ctc_print_html($this->get_render_attribute_string('description')); ?>>
                    <?php 
                        echo nl2br($testimonial['description']); 
                    ?>
                </div>
                <div class="cms-ttmn-info pt-120 pt-tablet-40 d-flex flex-nowrap gap-12 align-items-center">
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
</div>