<?php
$default_align = 'center';
$clients = $this->get_setting('clients', []);
if(empty($clients)) return;
// Media
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['image_custom_dimension']['width']) ? $settings['image_custom_dimension']['width'] : 301,
    'height' => !empty($settings['image_custom_dimension']['height']) ? $settings['image_custom_dimension']['height'] : 192
];
// Wrap
$this->add_render_attribute('wrap', [
    'class' => [
        'cms-clients',
        'cms-clients-'.$settings['layout'],
        'relative',
        'd-flex gutter-4',
        'justify-content-center',
        'flex-col-4 flex-col-mobile-3 flex-col-smobile-2'
    ]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
    <?php
    foreach ($clients as $key => $client) {
        $client['image_size'] = $settings['image_size'];
        $client['image_custom_dimension'] = $thumbnail_custom_dimension;
        // Link
        $link_key = $this->get_repeater_setting_key( 'link', 'cms_client_link', $key );
        $this->add_link_attributes( $link_key, $client['link'] );
        $this->add_render_attribute($link_key, [
            'class' => array_filter([
                'client--item',
                'text-center',
                //($key > 0 && $key < (count($clients) - 1)) ? 'text-center' : '',
                //($key == (count($clients) - 1)) ? 'text-end' : '',
                'd-flex align-items-center justify-content-'.$default_align,
                'cms-radius-10 bg-bg-light',
                'overflow-hidden',
                'elementor-invisible'
            ]),
            'aria-label' => $client['name'],
            'data-settings' => wp_json_encode([
                'animation' => 'fadeInUp'
            ])
        ]);
        ?>
        <div class="client-item">
            <a <?php ctc_print_html($this->get_render_attribute_string( $link_key )); ?>><?php
                genzia_elementor_image_render($client,[
                    'name'           => 'image',
                    'image_size_key' => 'image',
                    'img_class'      => 'skip-lazy',
                    'custom_size'    => $thumbnail_custom_dimension,
                    'before'         => '',
                    'after'          => ''
                ]);
            ?><span class="screen-reader-text"><?php echo esc_html($client['name']); ?></span></a>
        </div>
    <?php } ?>
</div>