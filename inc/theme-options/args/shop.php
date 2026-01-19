<?php
// Silence is golden.
$args = [
    'title'    => esc_html__('Shop', 'genzia'),
    'sections' => [
        'shop'     => [
            'title'      => esc_html__('General', 'genzia'),
            'fields'     => [
                // Custom thumbnail
                'shop_thumbnail_heading' => [
                    'type'     => CSH_Theme_Core::HEADING_FIELD,
                    'title'    => esc_html__('Shop Thumbnail Dimension', 'genzia'),
                ],
                'shop_thumbnail_custom' => genzia_theme_on_off_opts([
                    'title'         => esc_html__('Custom Dimension by Theme', 'genzia'),
                    'default'       => false,
                    'default_value' => 'on',
                    'description'      => esc_html__('When this option is ON, you can not change shop thumbnail dimension via Appearance/Customize/WooCommerce/Product Images','genzia')
                ])
            ]
        ],
        'single'   => genzia_single_product_opts()
    ]
];

return $args;