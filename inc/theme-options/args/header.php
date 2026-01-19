<?php
// Silence is golden.
$args = [
    'title'    => esc_html__('Header', 'genzia'),
    'sections' => [
        'general' => [
            'title' => esc_html__('General', 'genzia'),
            'fields' => [
                'header_layout' => genzia_theme_header_layout_opts([
                    'default'       => $default,
                    'default_value' => $default_value
                ]),
                'header_menu' => [
                    'type'    => CSH_Theme_Core::SELECT_FIELD,
                    'title'   => esc_html__('Main Navigation', 'genzia'),
                    'options' => genzia_menu_list(),
                    'default' => 'primary'
                ],
                'main_menu_color' => [
                    'type'  => CSH_Theme_Core::LINK_COLOR_FIELD,
                    'title' => esc_html__('Menu Color', 'genzia')
                ],
                'header_bg_color' => [
                    'type'  => CSH_Theme_Core::COLOR_FIELD,
                    'title' => esc_html__('Background Color', 'genzia')
                ],
                'header_height' => [
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Header Width / Height', 'genzia'),
                    'subtitle' => esc_html__('Set width / height for your Header', 'genzia'),
                    'width'    => false
                ],
                'extra' => [
                    'type'  => CSH_Theme_Core::HEADING_FIELD,
                    'title' => esc_html__('Extra Settings', 'genzia')
                ],
                'header_sticky' => genzia_theme_on_off_opts([
                    'title'         => esc_html__('Header Sticky', 'genzia'),
                    'subtitle'      => esc_html__('Header will be sticked when applicable.', 'genzia')
                ]),
                'header_sticky_mode' => genzia_select_opts([
                    'title'         => esc_html__('Header Sticky Mode', 'genzia'),
                    'subtitle'      => esc_html__('Header will when:', 'genzia'),
                    'options'       => [
                        'scrollup' => esc_html__('Scroll UP','genzia'),
                        'always'  => esc_html__('Always', 'genzia')  
                    ],
                    'default_value' => 'scrollup',
                    'required' => [
                        'header_sticky', '=', 'on'
                    ]
                ]),
                'header_boxed' => genzia_theme_on_off_opts([
                    'title'         => esc_html__('Header Boxed', 'genzia'),
                    'subtitle'      => esc_html__('Make header boxed','genzia'),
                    'default'       => $default,
                    'default_value' => $default_off
                ]),
                'header_shadow' => genzia_theme_on_off_opts([
                    'title'         => esc_html__('Header Shadow', 'genzia'),
                    'subtitle'      => esc_html__('Add shadow at bottom of header','genzia'),
                    'default'       => $default,
                    'default_value' => $default_on
                ]),
                'header_divider' => genzia_theme_on_off_opts([
                    'title'         => esc_html__('Divider', 'genzia'),
                    'subtitle'      => esc_html__('Add divider at bottom of header','genzia'),
                    'default'       => $default,
                    'default_value' => $default_off
                ])
            ]
        ],
        'logo' => [
            'title'  => esc_html__('Logo', 'genzia'),
            'fields' => [
                'logo' => [
                    'type'  => CSH_Theme_Core::MEDIA_FIELD,
                    'title' => esc_html__('Logo', 'genzia')
                ],
                'logo_maxh' => [
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Logo Dimensions', 'genzia'),
                    'subtitle' => esc_html__('Enter number.', 'genzia')
                ],
                'logo_mobile' => [
                    'type'  => CSH_Theme_Core::MEDIA_FIELD,
                    'title' => esc_html__('Logo Tablet & Mobile', 'genzia')
                ],
                'logo_maxh_sm' => [
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Logo Tablet & Mobile Dimensions', 'genzia'),
                    'subtitle' => esc_html__('Enter number.', 'genzia')
                ],
            ],
        ],
        'header_ontop' => [
            'title' => esc_html__('Header Transparent', 'genzia'),
            'fields' => [
                'header_transparent' => genzia_theme_on_off_opts([
                    'title'         => esc_html__('Header Transparent', 'genzia'),
                    'subtitle'      => esc_html__('Header transparent use with background.', 'genzia'),
                    'default_value' => $default_off
                ]),
                'logo_light' => [
                    'type' => CSH_Theme_Core::MEDIA_FIELD,
                    'title' => esc_html__('Logo', 'genzia')
                ],
                'logo_light_mobile' => [
                    'type'  => CSH_Theme_Core::MEDIA_FIELD,
                    'title' => esc_html__('Logo Tablet & Mobile', 'genzia')
                ],
                'transparent_menu_color' => [
                    'type' => CSH_Theme_Core::LINK_COLOR_FIELD,
                    'title' => esc_html__('Menu Color', 'genzia')
                ],
                'header_transparent_bg_color' => [
                    'type'  => CSH_Theme_Core::COLOR_FIELD,
                    'title' => esc_html__('Background Color', 'genzia')
                ]
            ]
        ],
        'attributes' => [
            'title' => esc_html__('Attributes','genzia'),
            'fields' => array_merge(
                [
                    'search_icon' => genzia_theme_on_off_opts([
                        'title'         => esc_html__('Search Icon', 'genzia'),
                        'default'       => $default,
                        'default_value' => $default_off
                    ]),
                    'search_on_content' => array(
                        'type'     => CSH_Theme_Core::SELECT_FIELD,
                        'title'    => esc_html__('Search Content As', 'genzia'),
                        'options'  => [
                            '_1'     => esc_html__('Default','genzia'),
                            'custom' => esc_html__('Custom', 'genzia')
                        ],
                        'default'  => '_1',
                        'description' => sprintf(esc_html__('%sClick Here%s to add your custom content.','genzia'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=cms-popup#add_new' ) ) . '" target="_blank">','</a>'),
                        'required' => array( 0 => 'search_icon', 1 => '=', 2 => 'on' )
                    ),
                    'search_on_content_content' => array(
                        'type'        => CSH_Theme_Core::SELECT_FIELD,
                        'title'       => esc_html__('Choose custom search content', 'genzia'),
                        'description' => esc_html__('Choose custom search content','genzia'),    
                        'options'     => genzia_list_elementor_template(),
                        'default'     => '_1',
                        'required'    => array( 0 => 'search_on_content', 1 => '=', 2 => 'custom' ),
                    ),
                    // Cart
                    'cart_icon' => genzia_theme_on_off_opts([
                        'title'         => esc_html__('Cart Icon', 'genzia'),
                        'default'       => $default,
                        'default_value' => $default_off
                    ])
                ],
                genzia_woo_header_woocs_opts([
                    'default'       => $default,
                    'default_value' => $default_off
                ]),
                genzia_woo_header_wishlist_opts([
                    'default'       => $default,
                    'default_value' => $default_off
                ]),
                genzia_woo_header_compare_opts([
                    'default'       => $default,
                    'default_value' => $default_off
                ]),
                genzia_header_login_opts([
                    'default'       => $default,
                    'default_value' => $default_off
                ]),
                genzia_header_language_switcher_opts([
                    'default'       => $default,
                    'default_value' => $default_off
                ]),
                genzia_theme_phone_settings([
                    'default'       => $default,
                    'default_value' => $default_off 
                ]),
                genzia_theme_mail_settings([
                    'default'       => $default,
                    'default_value' => $default_off 
                ]),
                genzia_theme_button_settings([
                    'default'       => $default,
                    'default_value' => $default_off 
                ]),
                genzia_theme_button_settings([
                    'heading'       => esc_html__('Button Settings #2', 'genzia'),
                    'name'          => 'h_btn2',
                    'default'       => $default,
                    'default_value' => $default_off 
                ]),
                genzia_header_side_nav_opts([
                    'default'       => $default,
                    'default_value' => $default_off 
                ]),
                genzia_header_social_opts([
                    'default'       => $default,
                    'default_value' => $default_off
                ])
            )
        ]
    ]
];
return $args;