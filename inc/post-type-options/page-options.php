<?php
// Silence is Golden
if(!class_exists('CSH_Theme_Core')) return;
//
add_filter('tco_page_page_options_args', 'genzia_page_options_args');
function genzia_page_options_args(){
    $default       = true;
    $default_value = $default_on = $default_off = $default_width = '-1';
    $custom_opts   = true;

    $header_top = include get_template_directory() . '/inc/theme-options/args/header-top.php';
    $header     = include get_template_directory() . '/inc/post-type-options/args-page/header.php';
    $page_title = include get_template_directory() . '/inc/post-type-options/args-page/page-title.php';
    $footer     = include get_template_directory() . '/inc/theme-options/args/footer.php';
    $popup      = include get_template_directory() . '/inc/theme-options/args/popup.php';

    $general = [
        'title' => esc_html__('General','genzia'),
        'sections' => [
            'colors' => [
                'title' => esc_html__('Colors', 'genzia'),
                'fields' => [
                    'color_custom' => genzia_theme_on_off_opts([
                        'title'         => esc_html__('Custom Color','genzia'),
                        'default'       => false,
                        'default_value' => 'off'
                    ]),
                    'accent_color' => [
                        'type'        => CSH_Theme_Core::COLOR_SET_FIELD,
                        'title'       => esc_html__('Accent Color', 'genzia'),
                        'options'     => genzia_color_list_opts('accent_color'),
                        'required' => [
                            'color_custom', '=', 'on'
                        ]
                    ],
                    'primary_color' => [
                        'type'        => CSH_Theme_Core::COLOR_SET_FIELD,
                        'title'       => esc_html__('Primary Color', 'genzia'),
                        'options'     => genzia_color_list_opts('primary_color'),
                        'required' => [
                            'color_custom', '=', 'on'
                        ]
                    ],
                    'heading_color' => array(
                        'type'    => CSH_Theme_Core::COLOR_SET_FIELD,
                        'title'   => esc_html__('Heading Color', 'genzia'),
                        'options' => genzia_color_list_opts('heading_color'),
                        'required' => [
                            'color_custom', '=', 'on'
                        ]
                    ),
                    'body_color' => array(
                        'type'    => CSH_Theme_Core::COLOR_SET_FIELD,
                        'title'   => esc_html__('Body Color', 'genzia'),
                        'options' => [
                            'regular' => sprintf('%s (%s)', esc_html__('Default','genzia'), genzia_configs('body')['color'])
                        ],
                        'required' => [
                            'color_custom', '=', 'on'
                        ]
                    ),
                    'link_color' => [
                        'type' => CSH_Theme_Core::LINK_COLOR_FIELD,
                        'title' => esc_html__('Link Color', 'genzia'),
                        'required' => [
                            'color_custom', '=', 'on'
                        ]
                    ],
                    'custom_color' => [
                        'type'        => CSH_Theme_Core::COLOR_SET_FIELD,
                        'title'       => esc_html__('Other Color', 'genzia'),
                        'options' => genzia_color_list_opts('custom_color'),
                        'required' => [
                            'color_custom', '=', 'on'
                        ]
                    ]
                ]
            ],
            'typos'    => genzia_typography_opts(),
            'advanced' => genzia_general_advanced_opts(['custom' => true])
        ]
    ];

    $content = [
        'title'  => esc_html__('Content', 'genzia'),
        'fields' => [
            'content_width' => genzia_theme_content_width_opts([
                'default'       => $default,
                'default_value' => $default_value
            ])
        ]
    ];

    $args = [  
        'general'    => $general,
        'header-top' => $header_top,
        'header'     => $header,
        'page-title' => $page_title,
        'content'    => $content,
        'footer'     => $footer,
        'popup'      => $popup,
    ];

    return $args;
}