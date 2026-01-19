<?php
// Silence is golden.
$args = [
    'title' => esc_html__('404 Page', 'genzia'),
    'fields' => [
        'title_404_page' => [
            'type' => CSH_Theme_Core::TEXTAREA_FIELD,
            'title' => esc_html__('Title', 'genzia'),
        ],
        'content_404_page' => [
            'type' => CSH_Theme_Core::TEXTAREA_FIELD,
            'title' => esc_html__('Content', 'genzia'),
        ],
        'btn_text_404_page' => [
            'type' => CSH_Theme_Core::TEXT_FIELD,
            'title' => esc_html__('Button Text', 'genzia'),
            'description' => esc_html__('Default: Take me go back home', 'genzia'),
        ],
    ],
];
return $args;