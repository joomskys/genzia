<?php
// Silence is golden.
$args = [
    'title' => esc_html__('General','genzia'),
    'sections' => [
        'colors' => [
            'title' => esc_html__('Colors', 'genzia'),
            'fields' => [
                'accent_color' => [
                    'type'        => CSH_Theme_Core::COLOR_SET_FIELD,
                    'title'       => esc_html__('Accent Color', 'genzia'),
                    'options'     => genzia_color_list_opts('accent_color')
                ],
                'primary_color' => [
                    'type'        => CSH_Theme_Core::COLOR_SET_FIELD,
                    'title'       => esc_html__('Primary Color', 'genzia'),
                    'options'     => genzia_color_list_opts('primary_color')
                ],
                'heading_color' => array(
                    'type'    => CSH_Theme_Core::COLOR_SET_FIELD,
                    'title'   => esc_html__('Heading Color', 'genzia'),
                    'options' => genzia_color_list_opts('heading_color')
                ),
                'body_color' => array(
                    'type'    => CSH_Theme_Core::COLOR_SET_FIELD,
                    'title'   => esc_html__('Body Color', 'genzia'),
                    'options' => [
                        'regular' => sprintf('%s (%s)', esc_html__('Default','genzia'), genzia_configs('body')['color'])
                    ]
                ),
                'link_color' => [
                    'type' => CSH_Theme_Core::LINK_COLOR_FIELD,
                    'title' => esc_html__('Link Color', 'genzia')
                ],
                // Custom Color
                'custom_color' => [
                    'type'        => CSH_Theme_Core::COLOR_SET_FIELD,
                    'title'       => esc_html__('Other Color', 'genzia'),
                    'options'     => genzia_color_list_opts('custom_color')
                ],
            ]
        ],
        'typos'     => genzia_typography_opts(),
        'advanced'  => genzia_general_advanced_opts(),
        'tools' => [
            'title'  => esc_html__('Tools', 'genzia'),
            'fields' => [
                'show_page_loading' => [
                    'type'     => CSH_Theme_Core::SWITCH_FIELD,
                    'title'    => esc_html__('Enable Page Loading', 'genzia'),
                    'subtitle' => esc_html__('Enable page loading effect when you load site.', 'genzia'),
                ],
                'back_totop_on' => [
                    'type'     => CSH_Theme_Core::SWITCH_FIELD,
                    'title'    => esc_html__('Back to Top Button', 'genzia'),
                    'subtitle' => esc_html__('Show back to top button when scrolled down.', 'genzia'),
                    'default'  => 1,
                ],
                'dev_mode' => [
                    'type'        => CSH_Theme_Core::SWITCH_FIELD,
                    'title'       => esc_html__('Dev Mode (not recommended)', 'genzia'),
                    'description' => esc_html__('no minimize , generate css over time...', 'genzia'),
                ],
            ],
        ]
    ]
];
return $args;