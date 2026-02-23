<?php
// Silence is golden.
$args = [
    'title'  => esc_html__('SEO', 'genzia'),
    'fields' => [
        'portfolio_slug' => [
            'type'        => CSH_Theme_Core::TEXT_FIELD,
            'title'       => esc_html__('Portfolio Slug', 'genzia'),
            'subtitle'    => esc_html__('Enter portfolio slug you want', 'genzia'),
            'description' => '',
            'default'     => 'portfolio',
        ],
        'service_slug' => [
            'type'        => CSH_Theme_Core::TEXT_FIELD,
            'title'       => esc_html__('Service Slug', 'genzia'),
            'subtitle'    => esc_html__('Enter Service slug you want', 'genzia'),
            'default'     => 'services',
        ]
    ]
];
return $args;