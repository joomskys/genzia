<?php
// Silence is golden.
$args = [
    'title' => esc_html__('Header', 'genzia'),
    'fields' => array_merge(
        [
            'header_custom' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Custom Header','genzia'),
                'default'       => false,
                'default_value' => 'off'
            ]),
            'header_layout' => genzia_theme_header_layout_opts([
                'default'       => $default,
                'default_value' => $default_value,
                'required'      => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'header_menu' => [
                'type'     => CSH_Theme_Core::SELECT_FIELD,
                'title'    => esc_html__('Main Navigation', 'genzia'),
                'options'  => genzia_menu_list(),
                'default'  => '_1',
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'main_menu_color' => [
                'type'     => CSH_Theme_Core::LINK_COLOR_FIELD,
                'title'    => esc_html__('Menu Color', 'genzia'),
                'required' => ['header_custom','=','on']
            ],
            'header_bg_color' => [
                'type'  => CSH_Theme_Core::COLOR_FIELD,
                'title' => esc_html__('Background Color', 'genzia'),
                'required' => [
                    'header_custom', '=','on'
                ]
            ],
            'header_height' => [
                'type'     => 'dimensions',
                'title'    => esc_html__('Header Width / Height', 'genzia'),
                'subtitle' => esc_html__('Set width / height for your Header', 'genzia'),
                'width'    => false,
                'required' => [
                    'header_custom', '=','on'
                ]
            ],
            'extra' => [
                'type'  => CSH_Theme_Core::HEADING_FIELD,
                'title' => esc_html__('Extra Settings', 'genzia'),
                'required'      => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'header_sticky' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Header Sticky', 'genzia'),
                'subtitle'      => esc_html__('Header will be sticked when applicable.', 'genzia'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'header_sticky_mode' => genzia_select_opts([
                'title'         => esc_html__('Header Sticky Mode', 'genzia'),
                'subtitle'      => esc_html__('Header will when:', 'genzia'),
                'options'       => [
                    'scrollup' => esc_html__('Scroll UP','genzia'),
                    'always'  => esc_html__('Always', 'genzia')  
                ],
                'default'       => true,
                'default_value' => '0',
                'required' => [
                    'header_sticky', '=', 'on'
                ]
            ]),
            'header_transparent' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Header Transparent', 'genzia'),
                'subtitle'      => esc_html__('Header transparent use with background.', 'genzia'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'header_transparent_mobile' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Header Transparent Mobile', 'genzia'),
                'subtitle'      => esc_html__('Header transparent on Mobile Screen?', 'genzia'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'transparent_menu_color' => [
                'type'     => CSH_Theme_Core::LINK_COLOR_FIELD,
                'title'    => esc_html__('Menu Color', 'genzia'),
                'subtitle' => esc_html__('Header Transparent Menu Color','genzia'),
                'required' => ['header_transparent', '=', 'on']
            ],
            'transparent_menu_mobile_color' => [
                'type'     => CSH_Theme_Core::LINK_COLOR_FIELD,
                'title'    => esc_html__('Menu Mobile Color', 'genzia'),
                'subtitle' => esc_html__('Header Transparent Menu Color on Mobile','genzia'),
                'required' => ['header_transparent', '=', 'on']
            ],
            'header_transparent_bg_color' => [
                'type'     => CSH_Theme_Core::COLOR_FIELD,
                'title'    => esc_html__('Background Color', 'genzia'),
                'subtitle' => esc_html__('Header Transparent Background Color','genzia'),
                'required' => ['header_transparent', '=', 'on']
            ],
            'header_boxed' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Header Boxed', 'genzia'),
                'subtitle'      => esc_html__('Make header boxed','genzia'),
                'default'       => $default,
                'default_value' => $default_off,
                'required'      => ['header_custom','=','on']
            ]),
            'header_shadow' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Header Shadow', 'genzia'),
                'subtitle'      => esc_html__('Add shadow at bottom of header','genzia'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => ['header_custom','=','on']
            ]),
            'header_divider' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Divider', 'genzia'),
                'subtitle'      => esc_html__('Add divider at bottom of header','genzia'),
                'default'       => $default,
                'default_value' => $default_value,
                'required'      => ['header_custom','=','on']
            ]),
            'custom_logo' => [
                'type'  => CSH_Theme_Core::HEADING_FIELD,
                'title' => esc_html__('Logo Settings', 'genzia'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'logo' => [
                'type'  => CSH_Theme_Core::MEDIA_FIELD,
                'title' => esc_html__('Logo', 'genzia'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'logo_maxh' => [
                'type'     => 'dimensions',
                'title'    => esc_html__('Logo Dimensions', 'genzia'),
                'subtitle' => esc_html__('Enter number.', 'genzia'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'logo_mobile' => [
                'type'  => CSH_Theme_Core::MEDIA_FIELD,
                'title' => esc_html__('Logo Tablet & Mobile', 'genzia'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'logo_maxh_sm' => [
                'type'     => 'dimensions',
                'title'    => esc_html__('Logo Tablet & Mobile Dimensions', 'genzia'),
                'subtitle' => esc_html__('Enter number.', 'genzia'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],

            'logo_light' => [
                'type' => CSH_Theme_Core::MEDIA_FIELD,
                'title' => esc_html__('Logo - Header Transparent', 'genzia'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'logo_light_mobile' => [
                'type'  => CSH_Theme_Core::MEDIA_FIELD,
                'title' => esc_html__('Logo Tablet & Mobile - Header Transparent', 'genzia'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'custom_attribute' => [
                'type'  => CSH_Theme_Core::HEADING_FIELD,
                'title' => esc_html__('Attributes Settings', 'genzia'),
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ],
            'search_icon' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Search Icon', 'genzia'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'cart_icon' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Cart Icon', 'genzia'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'h_mail_on' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Show/Hide Email', 'genzia'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ]),
            'h_phone_on' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Show/Hide Phone', 'genzia'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ])
        ],
            genzia_theme_button_settings([
                'heading'       => '',
                'default'       => $default,
                'default_value' => $default_value 
            ]),
            genzia_theme_button_settings([
                'heading'       => '',
                'subheading'    => esc_html__('Button #2', 'genzia'),
                'name'          => 'h_btn2',
                'default'       => $default,
                'default_value' => $default_value 
            ]),
        [
            
            'show_header_social' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Show/Hide Social', 'genzia'),
                'default'       => $default,
                'default_value' => $default_value,
                'required' => [
                    'header_custom',
                    '=',
                    'on'
                ]
            ])
        ],
        genzia_woo_header_woocs_opts([
            'default'       => $default,
            'default_value' => $default_off,
            'required'      => [
                'header_custom',
                '=',
                'on'
            ]
        ]),
        genzia_woo_header_wishlist_opts([
            'default'       => $default,
            'default_value' => $default_off,
            'required'      => [
                'header_custom',
                '=',
                'on'
            ]
        ]),
        genzia_woo_header_compare_opts([
            'default'       => $default,
            'default_value' => $default_off,
            'required'      => [
                'header_custom',
                '=',
                'on'
            ]
        ]),
        genzia_header_login_opts([
            'default'       => $default,
            'default_value' => $default_off,
            'required'      => [
                'header_custom',
                '=',
                'on'
            ]
        ]),
        genzia_header_language_switcher_opts([
            'default'       => $default,
            'default_value' => $default_off,
            'required'      => [
                'header_custom',
                '=',
                'on'
            ]
        ]),
        genzia_header_side_nav_opts([
            'default'       => true,
            'default_value' => '-1', 
            'required'      => [
                'header_custom',
                '=',
                'on'
            ]
        ])
    )
];
return $args;