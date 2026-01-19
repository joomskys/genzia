<?php
// Silence is golden.
$fields_default = [
    'pagetitle' => genzia_theme_show_hide_opts([
        'title'         => esc_html__('Page Title', 'genzia'),
        'default'       => $default,
        'default_value' => $default_on,
        'required' => [
            'custom_ptitle',
            '=',
            'on'
        ]
    ]),
    'ptitle_custom' => [
        'title'         => esc_html__('Custom Title', 'genzia'),
        'type'          => CSH_Theme_Core::TEXT_FIELD,
        'required'      => [
            'pagetitle',
            '=',
            'on'
        ]
    ],
    'ptitle_layout'  => genzia_theme_ptitle_layout_opts([
        'default'       => $default,
        'default_value' => $default_value,
        'required'      => [
            'pagetitle',
            '=',
            'on'
        ]
    ]),
    'ptitle_heading' => [
        'type'     => CSH_Theme_Core::HEADING_FIELD,
        'title'    => esc_html__('Background Settings', 'genzia'),
        'required' => [
            'pagetitle',
            '=',
            'on'
        ]
    ],
    'page_title_bg' => [
        'type'     => CSH_Theme_Core::BACKGROUND_FIELD,
        'title'    => esc_html__('Background', 'genzia'),
        'subtitle' => esc_html__('Choose Background color and image', 'genzia'),
        'required' => [
            'pagetitle',
            '=',
            'on'
        ],
        'background-repeat'     => false,
        'background-size'       => false,
        'background-position'   => false,
        'background-attachment' => false
    ],
    'page_title_overlay' => [
        'type'     => CSH_Theme_Core::RGBA_COLOR_FIELD,
        'title'    => esc_html__('Overlay Background Color', 'genzia'),
        'required' => [
            'pagetitle',
            '=',
            'on'
        ]
    ]
];
$fields = [];
if($custom_opts){
    $fields = [
        'custom_ptitle' => genzia_theme_on_off_opts([
            'title'         => esc_html__('Custom Page Title','genzia'),
            'default'       => false,
            'default_value' => 'off'
        ])
    ];
}
$args = [
    'title'  => esc_html__('Page Tile', 'genzia'),
    'fields' => $fields + $fields_default
];
return $args;