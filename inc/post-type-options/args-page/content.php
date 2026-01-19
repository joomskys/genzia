<?php
// Silence is golden.
$args = [
    'title'  => esc_html__('Content', 'genzia'),
    'fields' => [
        'general' => [
            'title'  => esc_html__('General', 'genzia'),
            'fields' => [
                'content_width' => genzia_theme_content_width_opts([
                    'default'       => $default,
                    'default_value' => $default_value
                ])
            ]
        ]
    ]
];
return $args;