<?php
$default_align = 'center';
$clients = $this->get_setting('clients', []);
if(empty($clients)) return;
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
    'cms-box-58 circle',
    'text-'.$this->get_setting('arrows_color','menu'),
    'bg-'.$this->get_setting('arrows_bg_color','transparent'),
    'text-hover-'.$this->get_setting('arrows_hover_color','white'),
    'bg-hover-'.$this->get_setting('arrows_bg_hover_color','menu'),
    'bdr-1 bdr-'.$this->get_setting('arrows_border_color','menu'),
    'bdr-hover-'.$this->get_setting('arrows_border_hover_color','menu')
];
$arrows_classes_prev = genzia_nice_class(array_merge(['cms-carousel-button-prev prev'],$arrows_classes));
$arrows_classes_next = genzia_nice_class(array_merge(['cms-carousel-button-next next'],$arrows_classes));
// Dots
$dots = $this->get_setting('dots');
$this->add_render_attribute('dots', [
    'class' => [
        'flex-basic gap-12',
        'cms-carousel-dots cms-carousel-dots-bullets',
        ($arrows == 'yes') ? 'justify-content-end':'justify-content-center',
        genzia_add_hidden_device_controls_render($settings, 'dots_'),
    ],
    'style' => [
        '--cms-dots-color:var(--cms-'.$this->get_setting('dots_color','menu').');',
        '--cms-dots-hover-color:var(--cms-'.$this->get_setting('dots_active_color','primary-regular').');',
        '--cms-dots-hover-shadow:var(--cms-'.$this->get_setting('dots_active_color','primary-regular').');',
        '--cms-dots-hover-opacity:0.2;'
    ]
]);
// Media
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['image_custom_dimension']['width']) ? $settings['image_custom_dimension']['width'] : 150,
    'height' => !empty($settings['image_custom_dimension']['height']) ? $settings['image_custom_dimension']['height'] : 60
];
// Wrap
$this->add_render_attribute('wrap', [
    'class' => [
        'cms-clients',
        'cms-clients-'.$settings['layout'],
        'relative'
    ]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
    <div class="cms-carousel swiper relative text-center">
        <div class="swiper-wrapper">
            <?php
            foreach ($clients as $key => $client) {
                $client['image_size'] = $settings['image_size'];
                $client['image_custom_dimension'] = $thumbnail_custom_dimension;
                // Link
                $link_key = $this->get_repeater_setting_key( 'link', 'cms_client_link', $key );
                $this->add_link_attributes( $link_key, $client['link'] );
                $this->add_render_attribute($link_key, [
                    'class' => array_filter([
                        'client-item swiper-slide',
                        'text-center',
                        //($key > 0 && $key < (count($clients) - 1)) ? 'text-center' : '',
                        //($key == (count($clients) - 1)) ? 'text-end' : '',
                        'd-flex align-items-center justify-content-'.$default_align
                    ]),
                    'aria-label' => $client['name']
                ]);
                ?>
                <a <?php ctc_print_html($this->get_render_attribute_string( $link_key )); ?>><?php
                    genzia_elementor_image_render($client,[
                        'name'           => 'image',
                        'image_size_key' => 'image',
                        'img_class'      => 'swiper-nav-vert skip-lazy',
                        'custom_size'    => $thumbnail_custom_dimension,
                        'before'         => '',
                        'after'          => ''
                    ]);
                ?><span class="screen-reader-text"><?php echo esc_html($client['name']); ?></span></a>
            <?php } ?>
        </div>
    </div>
    <?php 
        if ($arrows == 'yes' || $dots == 'yes') { ?>
        <div class="cms-carousel-arrows-dots d-flex pt-15">
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
        // Dots
        if ($dots == 'yes') { ?>
            <div <?php ctc_print_html($this->get_render_attribute_string('dots')); ?>></div>
        <?php }
        if ($arrows == 'yes' || $dots == 'yes') {
        ?>
            </div>
        <?php }
    ?>
</div>