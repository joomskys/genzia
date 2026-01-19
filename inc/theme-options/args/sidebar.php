<?php
// Silence is golden.
$args = [
    'title'    => esc_html__('Sidebar', 'genzia'),
    'sections' => [
        'general' => [
            'title' => esc_html__('General', 'genzia'),
            'fields' => [
                'sidebar_on' => genzia_theme_show_hide_opts([
                    'title'    => esc_html__('Show Sidebar', 'genzia'),
                    'subtitle' => esc_html__('Show/Hide sidebar on single post & archive page', 'genzia')
                ]),
                'sidebar_pos' => [
                    'type'    => CSH_Theme_Core::BUTTON_SET_FIELD,
                    'title'   => esc_html__('Sidebar Position','genzia'),
                    'options' => [
                        'order-first' => esc_html__('Left','genzia'),
                        'order-last'  => esc_html__('Right','genzia')
                    ],
                    'default' => 'order-last',
                    'required' => [
                        'sidebar_on', '=', 'on'
                    ]
                ]
            ]
        ]
    ]
];
return $args;