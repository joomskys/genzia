<?php
// Silence is golden.
$args = [
    'title' => esc_html__('Api', 'genzia'),
    'fields' => [
        'gm_api_key' => [
            'type'        => CSH_Theme_Core::TEXT_FIELD,
            'title'       => esc_html__('Google Maps API Key', 'genzia'),
            'subtitle'    => esc_html__('Register a Google Maps Api key then put it in here.', 'genzia'),
            'description' => 'AIzaSyC08_qdlXXCWiFNVj02d-L2BDK5qr6ZnfM',
            'default'     => '',
        ],
        'openai_api_key' => [
            'type'        => CSH_Theme_Core::TEXT_FIELD,
            'title'       => esc_html__('Open AI API Key', 'genzia'),
            'subtitle'    => esc_html__('Make a Open AI Api key then put it in here.', 'genzia'),
            'default'     => '',
        ]
    ]
];
return $args;