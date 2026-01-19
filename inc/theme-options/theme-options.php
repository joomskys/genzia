<?php
if(!class_exists('CSH_Theme_Core')) return;

// Set Location of Theme Options Menu
add_filter('tco_page_parent', 'genzia_tco_parent_page');
function genzia_tco_parent_page()
{
    $current_theme = wp_get_theme();
    if (is_child_theme()) {
        $current_theme = $current_theme->parent();
    }
    return $current_theme->get('TextDomain');
}

// Set Theme Options Name
add_filter('tco_theme_options_name', 'genzia_tco_theme_options_name');
add_filter('swa_ie_options_name', 'genzia_tco_theme_options_name');
function genzia_tco_theme_options_name()
{
    $opt_name = genzia_get_opt_name();
    return $opt_name;
}

add_filter('tco_theme_options_args', 'genzia_theme_options_args');

function genzia_theme_options_args()
{
    $default        = false;
    $default_value  = '1';
    $default_layout = '1';
    $default_on     = 'on';
    $default_off    = 'off';
    $custom_opts    = false;

    $general     = include get_template_directory() . '/inc/theme-options/args/general.php';
    $header_top  = include get_template_directory() . '/inc/theme-options/args/header-top.php';
    $header      = include get_template_directory() . '/inc/theme-options/args/header.php';
    $page_title  = include get_template_directory() . '/inc/theme-options/args/page-title.php';
    $content     = include get_template_directory() . '/inc/theme-options/args/content.php';
    $sidebar     = include get_template_directory() . '/inc/theme-options/args/sidebar.php';
    $shop        = include get_template_directory() . '/inc/theme-options/args/shop.php';
    $footer      = include get_template_directory() . '/inc/theme-options/args/footer.php';
    $api         = include get_template_directory() . '/inc/theme-options/args/api.php';
    $page_404    = include get_template_directory() . '/inc/theme-options/args/404-page.php';
    $popup       = include get_template_directory() . '/inc/theme-options/args/popup.php';

    $args = [
        'general'     => $general,
        'header_top'  => $header_top,
        'header'      => $header,
        'page-title'  => $page_title,
        'content'     => $content,
        'sidebar'     => $sidebar,  
        'footer'      => $footer,
        '404-page'    => $page_404,
    ];
    if(class_exists('WooCommerce')){
        $args['shop'] =  $shop;
    }
    $args['popup'] = $popup;
    $args['api'] = $api;

    return $args;
}
/**
 * Color list from theme configs
 * 
 * **/

function genzia_color_list_opts($name = []){
    $colors = (array) genzia_configs($name);
    $opts = [];
    foreach ($colors as $key => $value) {
        if(is_array($value)){
            $opts[$key] = sprintf('%1$s %2$s', $value['title'], '<div class="label-desc">'.esc_html__('Default:','genzia').' '.$value['value'].'</div>');
        } else {
            $opts[$key] = sprintf('%1$s %2$s', ucfirst(str_replace(['-','_'], ' ', $key)), '<div class="label-desc">'.esc_html__('Default:','genzia').' '.$value.'</div>');
        }
    }
    return $opts;
}
/**
 * Get post thumbnail as image options
 * @return array
 *
*/
function genzia_list_post_thumbnail($post_type = 'post', $default = false, $args = []){
    $layouts = [];
    if($default){
        $layouts['-1'] = get_template_directory_uri() . '/assets/images/default-opt/default.jpg';
        $layouts['none'] = get_template_directory_uri() . '/assets/images/default-opt/none.jpg';
    }
    $layouts = array_unique($layouts + $args);
    $posts = get_posts(array('post_type' => $post_type,'posts_per_page' => '-1'));
    
    foreach($posts as $post){
        $layouts[$post->ID] = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), 'full');
    }
    return $layouts;
}
/**
 * Typography
**/
if(!function_exists('genzia_typography_opts')){
    function genzia_typography_opts($args = []){
        $default = [
            'body_font' => [
                'type'        => CSH_Theme_Core::SELECT_FIELD,
                'title'       => esc_html__('Body Font', 'genzia'),
                'options'     => [
                    'default' => esc_html__('Default', 'genzia'),
                    'custom'  => esc_html__('Custom', 'genzia'),
                ],
                'default'     => 'default'
            ],
            'body_font_typo' => [
                'type'     => CSH_Theme_Core::TYPOGRAPHY_FIELD,
                'title'    => esc_html__('Body Custom Font', 'genzia'),
                'subtitle' => esc_html__('This will be the default font of your website.', 'genzia'),
                'required' => [
                    'body_font',
                    '=',
                    'custom'
                ],
                'font_backup'  => false,
                'font_subsets' => false,
                'font_style'   => true, 
                'line_height'  => false,
                'font_size'    => false,
                'color'        => false,
                'output'       => [
                    '.dummy-body'
                ]
            ],
            'heading_font' => [
                'type'    => CSH_Theme_Core::SELECT_FIELD,
                'title'   => esc_html__('Heading Default Font', 'genzia'),
                'options' => [
                    'default' => esc_html__('Default', 'genzia'),
                    'custom'  => esc_html__('Custom', 'genzia'),
                ],
                'default' => 'default'
            ],
            'heading_font_typo' => [
                'type'     => CSH_Theme_Core::TYPOGRAPHY_FIELD,
                'title'    => esc_html__('Heading', 'genzia'),
                'subtitle' => esc_html__('This will be the default font for all Heading tags of your website.', 'genzia'),
                'output'   => [
                    '.dummy-heading'
                ],
                'required' => [
                    'heading_font',
                    '=',
                    'custom',
                ],
                'font_backup'  => false,
                'font_subsets' => false,
                'font_style'   => true,
                'line_height'  => false,
                'font_size'    => false,
                'color'        => false,    
            ],
            'special_font' => [
                'type'    => CSH_Theme_Core::SELECT_FIELD,
                'title'   => esc_html__('Special Default Font', 'genzia'),
                'options' => [
                    'default' => esc_html__('Default', 'genzia'),
                    'custom'  => esc_html__('Custom', 'genzia'),
                ],
                'default' => 'default'
            ],
            'special_font_typo' => [
                'type'     => CSH_Theme_Core::TYPOGRAPHY_FIELD,
                'title'    => esc_html__('Special', 'genzia'),
                'subtitle' => esc_html__('This will be the default font for all Special of your website.', 'genzia'),
                'output'   => [
                    '.dummy-special'
                ],
                'required' => [
                    'special_font',
                    '=',
                    'custom',
                ],
                'font_backup'  => false,
                'font_subsets' => false,
                'font_style'   => true,
                'line_height'  => false,
                'font_size'    => false,
                'color'        => false,    
            ]
        ];
        return [
            'title'  => esc_html__('Typographys', 'genzia'),
            'fields' => array_merge($default, $args)
        ];
    }
}
if(!function_exists('genzia_general_advanced_opts')){
    function genzia_general_advanced_opts($args = []){
        $args = wp_parse_args($args, [
            'custom' => false
        ]);
        $default = [];
        $default['body_classes'] = [
            'type'     => CSH_Theme_Core::TEXT_FIELD,
            'title'    => esc_html__('Body Class', 'genzia')
        ];
        if($args['custom']){
            $default['body_top_space_custom'] = genzia_theme_on_off_opts([
                'title'         => esc_html__('Custom Space','genzia'),
                'default'       => false,
                'default_value' => 'off'
            ]);
        }
        $default['body_top_space'] = [
            'type'     => CSH_Theme_Core::SLIDER_FIELD,
            'title'    => esc_html__('Body Top Space', 'genzia'),
            'required' => [
                'body_top_space_custom', '=', 'on'
            ]
        ];
        return [
            'title'  => esc_html__('Advanced', 'genzia'),
            'fields' => $default
        ];
    }
}
/**
 * ON/ OFF option
 * 
 * */
function genzia_theme_on_off_opts($args = []){
    $args = wp_parse_args($args, [
        'default'       => false,
        'default_value' => 'off',
        'title'         => esc_html__('On/Off', 'genzia'),
        'subtitle'      => '',
        'description'   => '',
        'required'      => '',
        'custom_opts'   => []
    ]);
    $opts = [
        'on' => esc_html__('On', 'genzia'),
        'off' => esc_html__('Off', 'genzia'),
    ];
    if($args['default']) {
        $opts['-1'] = esc_html__('Default','genzia');
        $args['default_value'] = '-1';
    }
    //if(!empty($args['custom_opts'])) $opts = $opts + $args['custom_opts'];
    return [
        'type'        => CSH_Theme_Core::BUTTON_SET_FIELD,
        'title'       => $args['title'],
        'subtitle'    => $args['subtitle'],
        'description' => $args['description'],
        'options'     => $opts+$args['custom_opts'],
        'default'     => $args['default_value'],
        'required'    => $args['required']
    ];
}
/**
 * Show/ Hide option
 * 
 * */
function genzia_theme_show_hide_opts($args = []){
    $args = wp_parse_args($args, [
        'default'       => false,
        'default_value' => 'off',
        'title'         => esc_html__('Show/Hide', 'genzia'),
        'subtitle'      => '',
        'description'   => '',
        'required'      => ''    
    ]);
    $opts = [
        'on' => esc_html__('Show', 'genzia'),
        'off' => esc_html__('Hide', 'genzia'),
    ];
    if($args['default']) {
        $opts['-1'] = esc_html__('Default','genzia');
        $args['default_value'] = '-1';
    }
    return [
        'type'        => CSH_Theme_Core::BUTTON_SET_FIELD,
        'title'       => $args['title'],
        'subtitle'    => $args['subtitle'],
        'description' => $args['description'],
        'options'     => $opts,
        'default'     => $args['default_value'],
        'required'    => $args['required']
    ];
}
/**
 * Select Options
 * 
 * */
if(!function_exists('genzia_select_opts')){
    function genzia_select_opts($args = []){
        $args = wp_parse_args($args, [
            'title'         => 'Your title',
            'subtitle'      => '',
            'description'   => '',
            'default'       => false,
            'default_value' => 'opt1',
            'options'       => [
                'opt1'  => __('Options #1', 'genzia'),
                'opt2'  => __('Options #2', 'genzia')
            ],
            'required' => []
        ]);
        if($args['default']){
            $args['default_value'] = '0';
            $options = array_merge(
                [
                    '0' => __('Theme Default','genzia')
                ],
                $args['options']
            );
        } else {
            $options = $args['options'];
        }
        return [
            'title'         => $args['title'],
            'subtitle'      => $args['subtitle'],
            'description'   => $args['description'],
            'type'          => CSH_Theme_Core::SELECT_FIELD,
            'options'       => $options,
            'default'       => $args['default_value'],
            'required'      => $args['required']
        ];
    }
}
/**
 * Content Width
 * 
 * */
function genzia_theme_content_width_opts($args = []){
    $args = wp_parse_args($args, [
        'default'       => false,
        'default_value' => 'container',
        'title'         => esc_html__('Content Width','genzia'),
        'subtitle'      => '',
        'required'      => ''
    ]);
    $opts = [
        'container'        => esc_html__('Container', 'genzia'),
        'container-wide'   => esc_html__('Container Wide', 'genzia'),
        'container-full'  => esc_html__('Container Full', 'genzia')
    ];
    if($args['default']) {
        $opts['-1'] = esc_html__('Default','genzia');
        $args['default_value'] = '-1';
    }
    return [
        'type'     => CSH_Theme_Core::BUTTON_SET_FIELD,
        'title'    => $args['title'],
        'subtitle' => $args['subtitle'],
        'options'  => $opts,
        'default'  => $args['default_value'],
        'required' => $args['required']
    ];
}
function genzia_theme_content_width_render($args = []){
    $args = wp_parse_args($args, [
        'name'    => '',
        'default' => 'container'
    ]);
    $settings = genzia_get_opts($args['name'], $args['default']);
    if(!empty($settings)) return $args['prefix'].$settings;
}
/**
 * Content Alignment
 * **/
function genzia_them_content_align_opts($args = []){
    $args = wp_parse_args($args, [
        'default'       => false,
        'default_value' => '',
        'title'         => esc_html__('Content Alignment','genzia'),
        'subtitle'      => '',
        'required'      => ''
    ]);
    $opts = [
        'start'  => esc_html__('Start', 'genzia'),
        'center' => esc_html__('Center', 'genzia'),
        'end'    => esc_html__('End', 'genzia'),
    ];
    if($args['default']) {
        $opts['-1'] = esc_html__('Default','genzia');
        $args['default_value'] = '-1';
    }
    return [
        'type'     => CSH_Theme_Core::BUTTON_SET_FIELD,
        'title'    => $args['title'],
        'subtitle' => $args['subtitle'],
        'options'  => $opts,
        'default'  => $args['default_value'],
        'required' => $args['required']
    ];
}
function genzia_them_content_align_render($args = []){
    $args = wp_parse_args($args, [
        'name'    => '',
        'prefix'  => 'text-',
        'default' => 'start'
    ]);
    $settings = genzia_get_opts($args['name'], $args['default']);
    if(!empty($settings)) return $args['prefix'].$settings;
}
/**
 * Button Settings
 * 
 * **/
if(!function_exists('genzia_theme_button_settings')){
    function genzia_theme_button_settings($args = []){
        $args = wp_parse_args($args, [
            'name'          => 'h_btn',
            'heading'       => esc_html__('Button Settings','genzia'),
            'subheading'    => esc_html__('Button', 'genzia'),
            'default'       => false,
            'default_value' => 'off'
        ]);
        $button_settings = [];
        if(!empty($args['heading'])) {
            $button_settings[$args['name'].'_heading'] = [
                'type' => CSH_Theme_Core::HEADING_FIELD,
                'title' => $args['heading'],
            ];
        } 
        $button_settings[$args['name'].'_on'] = genzia_theme_on_off_opts([
            'default'       => $args['default'],    
            'default_value' => $args['default_value'],
            'title'         => esc_html__('Show/Hide', 'genzia'). ' '.$args['subheading']
        ]);
        $button_settings[$args['name'].'_text'] = [
            'type'  => CSH_Theme_Core::TEXT_FIELD,
            'title' => $args['subheading']. ' '.esc_html__('Text', 'genzia'),
            'required' => [
                $args['name'].'_on',
                '=',
                'on'
            ],
        ];
        $button_settings[$args['name'].'_link_type'] = [
            'type' => CSH_Theme_Core::BUTTON_SET_FIELD,
            'title' => $args['subheading']. ' '.esc_html__('Link Type', 'genzia'),
            'options' => [
                'page' => esc_html__('Page', 'genzia'),
                'custom' => esc_html__('Custom', 'genzia'),
            ],
            'default' => 'page',
            'required' => [
                $args['name'].'_on',
                '=',
                'on'
            ],
        ];
        $button_settings[$args['name'].'_link'] = [
            'type' => CSH_Theme_Core::SELECT_FIELD,
            'title' => $args['subheading']. ' '.esc_html__('Page Link', 'genzia'),
            'args' => [
                'post_type' => 'page',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
            ],
            'select2' => true,
            'required' => [
                $args['name'].'_link_type',
                '=',
                'page'
            ],
        ];
        $button_settings[$args['name'].'_link_custom'] = [
            'type' => CSH_Theme_Core::TEXT_FIELD,
            'title' => $args['subheading']. ' '.esc_html__('Custom Link', 'genzia'),
            'required' => [
                $args['name'].'_link_type',
                '=',
                'custom'
            ],
        ];
        $button_settings[$args['name'].'_target'] = [
            'type' => CSH_Theme_Core::BUTTON_SET_FIELD,
            'title' => $args['subheading']. ' '.esc_html__('Target', 'genzia'),
            'options' => [
                '_self' => esc_html__('Self', 'genzia'),
                '_blank' => esc_html__('Blank', 'genzia'),
            ],
            'default' => '_self',
            'required' => [
                $args['name'].'_on',
                '=',
                'on'
            ],
        ];
        //
        return $button_settings;
    }
}
/**
 * Phone Settings
 * **/
if(!function_exists('genzia_theme_phone_settings')){
    function genzia_theme_phone_settings($args = []){
        $args = wp_parse_args($args, [
            'name'        => '',
            'default'     => false,  
            'default_opt' => 'off'
        ]);
        return [
            'show_phone'.$args['name'] => [
                'type'  => CSH_Theme_Core::HEADING_FIELD,
                'title' => esc_html__('Phone', 'genzia').' '.$args['name'],
            ],
            'h_phone'.$args['name'].'_on' => genzia_theme_on_off_opts([
                'default'       => $args['default'],
                'default_value' => 'off',
                'title'         => esc_html__('Show/Hide Phone', 'genzia').' '.$args['name']
            ]),
            'h_phone'.$args['name'].'_text' => [
                'type'        => CSH_Theme_Core::TEXT_FIELD,
                'title'       => esc_html__('Phone Text', 'genzia'),
                'placeholder' => 'Need assistance?',
                /*'required'    => [
                    'h_phone'.$args['name'].'_on',
                    '=',
                    'on'
                ]*/
            ],
            'h_phone'.$args['name'].'_number' => [
                'type'        => CSH_Theme_Core::TEXT_FIELD,
                'title'       => esc_html__('Phone Number', 'genzia'),
                'placeholder' => '+2 0106124541',
                /*'required'    => [
                    'h_phone'.$args['name'].'_on',
                    '=',
                    'on'
                ]*/
            ]
        ];
    }
}
/**
 * Mail Settings
 * **/
if(!function_exists('genzia_theme_mail_settings')){
    function genzia_theme_mail_settings($args = []){
        $args = wp_parse_args($args, [
            'name'        => '',
            'default'     => false,  
            'default_opt' => 'off'
        ]);
        return [
            'show_mail'.$args['name'] => [
                'type'  => CSH_Theme_Core::HEADING_FIELD,
                'title' => esc_html__('Mail', 'genzia').' '.$args['name'],
            ],
            'h_mail'.$args['name'].'_on' => genzia_theme_on_off_opts([
                'default'       => $args['default'],
                'default_value' => 'off',
                'title'         => esc_html__('Show/Hide Mail', 'genzia').' '.$args['name']
            ]),
            'h_mail'.$args['name'].'_text' => [
                'type'        => CSH_Theme_Core::TEXT_FIELD,
                'title'       => esc_html__('Your Email', 'genzia'),
                'placeholder' => 'Genzia@cmssuperheroes.com',
                'required'    => [
                    'h_mail'.$args['name'].'_on',
                    '=',
                    'on'
                ]
            ]
        ];
    }
}
// WooCS Currency Switcher
if(!function_exists('genzia_woo_header_woocs_opts')){
    function genzia_woo_header_woocs_opts($args = []){
        if(!class_exists('WOOCS_STARTER')) return [];
        $args = wp_parse_args($args, [
            'name'        => '',
            'default'     => false,  
            'default_opt' => 'off',
            'required'    => []
        ]);
        return [
            'show_woocs'.$args['name'] => [
                'type'  => CSH_Theme_Core::HEADING_FIELD,
                'title' => esc_html__('Currency Switcher', 'genzia').' '.$args['name'],
                'required' => $args['required']
            ],
            'h_woocs'.$args['name'].'_on' => genzia_theme_on_off_opts([
                'default'       => $args['default'],
                'default_value' => 'off',
                'title'         => esc_html__('Show/Hide Currency Switcher', 'genzia').' '.$args['name'],
                'required' => $args['required']
            ])
        ];
    }
}
// WPC Smart Wishlist
if(!function_exists('genzia_woo_header_wishlist_opts')){
    function genzia_woo_header_wishlist_opts($args = []){
        if(!class_exists('WPCleverWoosw')) return [];
        $args = wp_parse_args($args, [
            'name'        => '',
            'default'     => false,  
            'default_opt' => 'off',
            'required'    => []
        ]);
        return [
            'show_wishlist'.$args['name'] => [
                'type'  => CSH_Theme_Core::HEADING_FIELD,
                'title' => esc_html__('Wishlist', 'genzia').' '.$args['name'],
                'required' => $args['required']
            ],
            'h_wishlist'.$args['name'].'_on' => genzia_theme_on_off_opts([
                'default'       => $args['default'],
                'default_value' => 'off',
                'title'         => esc_html__('Show/Hide Wishlist', 'genzia').' '.$args['name'],
                'required' => $args['required']
            ])
        ];
    }
}
// WPC Smart Compare
if(!function_exists('genzia_woo_header_compare_opts')){
    function genzia_woo_header_compare_opts($args = []){
        if(!class_exists('WPCleverWoosc')) return [];
        $args = wp_parse_args($args, [
            'name'        => '',
            'default'     => false,  
            'default_opt' => 'off',
            'required'    => []
        ]);
        return [
            'show_compare'.$args['name'] => [
                'type'  => CSH_Theme_Core::HEADING_FIELD,
                'title' => esc_html__('Compare', 'genzia').' '.$args['name'],
                'required' => $args['required']
            ],
            'h_compare'.$args['name'].'_on' => genzia_theme_on_off_opts([
                'default'       => $args['default'],
                'default_value' => 'off',
                'title'         => esc_html__('Show/Hide Compare', 'genzia').' '.$args['name'],
                'required' => $args['required']
            ])
        ];
    }
}
/** 
 * Login
 * */
if(!function_exists('genzia_header_login_opts')){
    function genzia_header_login_opts($args = []){
        if(!function_exists('cshlg_link_to_login')) return [];
        $args = wp_parse_args($args, [
            'name'        => '',
            'default'     => false,  
            'default_opt' => 'off',
            'required'    => []
        ]);
        return [
            'show_login'.$args['name'] => [
                'type'  => CSH_Theme_Core::HEADING_FIELD,
                'title' => esc_html__('Login', 'genzia').' '.$args['name'],
                'required' => $args['required']
            ],
            'h_login'.$args['name'].'_on' => genzia_theme_on_off_opts([
                'default'       => $args['default'],
                'default_value' => 'off',
                'title'         => esc_html__('Show/Hide Login', 'genzia'),
                'required' => $args['required']
            ])
        ];
    }
}
/**
 * Language Switcher
 * */
if(!function_exists('genzia_header_language_switcher_opts')){
    function genzia_header_language_switcher_opts($args = []){
        if(!class_exists('TRP_Translate_Press') ) return array();
        $args = wp_parse_args($args, [
            'name'        => '',
            'default'     => false,  
            'default_opt' => 'off',
            'required'    => [] 
        ]);
        return [
            'show_language'.$args['name'] => [
                'type'  => CSH_Theme_Core::HEADING_FIELD,
                'title' => esc_html__('Language Switcher', 'genzia').' '.$args['name'],
                'required' => $args['required']
            ],
            'h_language'.$args['name'].'_on' => genzia_theme_on_off_opts([
                'default'       => $args['default'],
                'default_value' => 'off',
                'title'         => esc_html__('Show/Hide Language Switcher', 'genzia'),
                'required' => $args['required']
            ])
        ];
    }
}
/**
 * Header layout 
 * 
 * */
if(!function_exists('genzia_theme_header_layout_opts')){
    function genzia_theme_header_layout_opts($args = []){
        $args = wp_parse_args($args, [
            'default'       => false,
            'default_value' => '1',
            'required'      => ''
        ]);
        $header_layout = [];
        if($args['default']){
            $header_layout['-1'] = get_template_directory_uri() . '/assets/images/header-layout/h-default.jpg';
            $header_layout['none'] = get_template_directory_uri() . '/assets/images/header-layout/h0.jpg';
        }
        // Theme Layout
        $layouts = [
            '1'    => get_template_directory_uri() . '/assets/images/header-layout/h1.webp',
            '2'    => get_template_directory_uri() . '/assets/images/header-layout/h2.webp',
            '3'    => get_template_directory_uri() . '/assets/images/header-layout/h3.webp',
            '4'    => get_template_directory_uri() . '/assets/images/header-layout/h4.webp',
            //'5'    => get_template_directory_uri() . '/assets/images/header-layout/h5.webp',
            //'6'    => get_template_directory_uri() . '/assets/images/header-layout/h6.webp',
            //'left' => get_template_directory_uri() . '/assets/images/header-layout/h-left.jpg',
        ];
        return [
            'type'     => CSH_Theme_Core::IMAGE_SELECT_FIELD,
            'title'    => esc_html__('Layout', 'genzia'),
            'subtitle' => esc_html__('Select a layout for header.', 'genzia'),
            'options'  => array_unique ($header_layout + $layouts),
            'default'  => $args['default_value'],
            'required' => $args['required']
        ];
    }
}
/**
 * Header Side Nav Options
**/
if(!function_exists('genzia_header_side_nav_opts')){
    function genzia_header_side_nav_opts($args=[]){
        $args = wp_parse_args($args, [
            'default'        => '',
            'default_value'  => '',
            'default_layout' => '',
            'required'       => []
        ]);
        if($args['default']){
            $args['default_value'] = '-1';
        }
        if(!apply_filters('genzia_enable_sidenav', false)) return array();
        
        return [
            'hide_sidebar_icon_heading' => [
                'type'     => CSH_Theme_Core::HEADING_FIELD,
                'title'    => esc_html__('Hidden Side Navigation Settings','genzia'),
                'required' => $args['required']
            ],
            'hide_sidebar_icon' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Hidden Side Navigation', 'genzia'),
                'default'       => $args['default'],
                'default_value' => $args['default_value'],
                'required'      => $args['required']
            ]),
            'header_sidenav_layout' => [
                'type'        => CSH_Theme_Core::IMAGE_SELECT_FIELD,
                'title'       => esc_html__('Hidden Side Navigation Layout', 'genzia'),
                'subtitle'    => esc_html__('Select a layout for upper side nav area.', 'genzia'),
                'description' => sprintf(esc_html__('%sClick Here%s to add your custom side nav layout.','genzia'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=cms-sidenav' ) ) . '" target="_blank">','</a>'),
                'placeholder' => esc_html__('Default','genzia'),
                'options'     => genzia_list_post_thumbnail('cms-sidenav', $args['default']),
                'default'     => $args['default_layout'],
                'required' => [
                    'hide_sidebar_icon', "=", 'on'
                ]
            ]
        ];
    }
}
/**
 * Header Socials
 * 
**/
if(!function_exists('genzia_header_social_opts')){
    function genzia_header_social_opts($args = []){
        $args = wp_parse_args($args, [
            'default'        => '',
            'default_value'  => '',
            'default_layout' => '',
            'required'       => []
        ]);
        if($args['default']){
            $args['default_value'] = '-1';
        }
        return [
            'header_social_heading' => [
                'type'     => CSH_Theme_Core::HEADING_FIELD,
                'title'    => esc_html__('Header Socials','genzia'),
                'required' => $args['required']
            ],
            'show_header_social' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Show/Hide Social', 'genzia'),
                'default'       => $args['default'],
                'default_value' => $args['default_value'],
                'required'      => $args['required']
            ]),
            'header_socials' => [
                'type'        => CSH_Theme_Core::REPEATER_FIELD,
                'title'       => __('Add your Header Social', 'genzia'),
                'fields' => [
                    'icon' => [
                        'type'        => CSH_Theme_Core::MEDIA_FIELD,
                        'title'       => __('Icon', 'genzia'),
                        'default'     => '' 
                    ],
                    'url' => [
                        'type'  => CSH_Theme_Core::TEXT_FIELD,
                        'title' => __('Social URL','genzia')
                    ],
                    'text' => [
                        'type'  => CSH_Theme_Core::TEXT_FIELD,
                        'title' => __('Social Text','genzia')
                    ]
                ],
                'title_field' => 'text'
            ]
        ];
    }
}

/**
 * Header TOp Options
**/
if(!function_exists('genzia_header_top_opts')){
    function genzia_header_top_opts($args=[]){
        $args = wp_parse_args($args, [
            'default'        => false,
            'default_value'  => 'none',
            'default_on'     => 'off',
            'custom'         => false   
        ]);
        if($args['default']){
            $args['default_value'] = '-1';
        }
        $custom_fields = [];
        if($args['custom']){
            $custom_fields['header_top_custom'] = genzia_theme_on_off_opts([
                'title'         => esc_html__('Custom Header Top','genzia'),
                'default'       => false
            ]);
        }
        $default_fields = [
            'header_top_layout' => array(
                'type'        => CSH_Theme_Core::IMAGE_SELECT_FIELD,
                'title'       => esc_html__('Layout', 'genzia'),
                'subtitle'    => esc_html__('Select a layout for upper header top area.', 'genzia'),
                'description' => sprintf(esc_html__('%sClick Here%s to add your custom header top layout.','genzia'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=cms-header-top' ) ) . '" target="_blank">','</a>'),
                'placeholder' => esc_html__('Default','genzia'),
                'options'     => genzia_list_post_thumbnail('cms-header-top', $args['default'], [
                    'none' => get_template_directory_uri() . '/assets/images/default-opt/none.jpg'
                ]),
                'default'     => $args['default_value'],
                'required' => [
                    'header_top_custom', "=", 'on'
                ]
            )
        ];
        // Return
        return [
            'title'      => esc_html__('Header Top', 'genzia'),
            'fields'     => $custom_fields + $default_fields
        ];
    }
}
/**
 * Page Title layout 
 * 
 * */
if(!function_exists('genzia_theme_ptitle_layout_opts')){
    function genzia_theme_ptitle_layout_opts($args = []){
        $args = wp_parse_args($args, [
            'default'       => false,
            'default_value' => '1',
            'required'      => ''
        ]);
        $ptitle_layout = [];
        if($args['default']){
            $ptitle_layout['-1'] = get_template_directory_uri() . '/assets/images/default-opt/default.jpg';
            $ptitle_layout['none'] = get_template_directory_uri() . '/assets/images/default-opt/none.jpg';
        }
        // Theme Layout
        $layouts = [
            '1'    => get_template_directory_uri() . '/assets/images/ptitle-layout/ptitle-1.webp',
            '2'    => get_template_directory_uri() . '/assets/images/ptitle-layout/ptitle-2.webp',
            '3'    => get_template_directory_uri() . '/assets/images/ptitle-layout/ptitle-3.webp'
        ];
        return [
            'type'     => CSH_Theme_Core::IMAGE_SELECT_FIELD,
            'title'    => esc_html__('Layout', 'genzia'),
            'subtitle' => esc_html__('Select a layout for page title.', 'genzia'),
            'options'  => array_unique ($ptitle_layout + $layouts),
            'default'  => $args['default_value'],
            'required' => $args['required']
        ];
    }
}
/**
 * Footer Options
**/
if(!function_exists('genzia_footer_opts')){
    function genzia_footer_opts($args=[]){
        $args = wp_parse_args($args, [
            'default'        => false,
            'default_value'  => '1',
            'default_on'     => 'off',
            'custom'         => false   
        ]);
        if($args['default']){
            $args['default_value'] = '-1';
        }
        $custom_fields = [];
        if($args['custom']){
            $custom_fields['footer_custom'] = genzia_theme_on_off_opts([
                'title'         => esc_html__('Custom Footer','genzia'),
                'default'       => false
            ]);
        }
        $current_year = date('Y');
        $theme_name = get_bloginfo('name');

        $default_fields = [
            'footer_copyright' => [
                'type'        => CSH_Theme_Core::TEXTAREA_FIELD,
                'title'       => esc_html__('Copyright Settings','genzia'),
                'subtitle'    => esc_html__('Add your copyright text','genzia'),
                'description' => esc_html__( 'Use [[copy]] for &copy;, [[year]] for current year', 'genzia'),
                'placeholder' => '&copy; '.$current_year.' '. $theme_name.', All Rights Reserved. With Love by 7oroof.com',
                'required'    => [
                    'footer_custom', '=', 'on',
                    'footer_layout', '=', 1
                ]
            ],
            'footer_layout' => array(
                'type'        => CSH_Theme_Core::IMAGE_SELECT_FIELD,
                'title'       => esc_html__('Layout', 'genzia'),
                'subtitle'    => esc_html__('Select a layout for upper footer area.', 'genzia'),
                'description' => sprintf(esc_html__('%sClick Here%s to add your custom footer layout.','genzia'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=cms-footer' ) ) . '" target="_blank">','</a>'),
                'placeholder' => esc_html__('Default','genzia'),
                'options'     => genzia_list_post_thumbnail('cms-footer', $args['default'], [
                    '1' => get_template_directory_uri() . '/assets/images/footer-layout/default.webp'
                ]),
                'default'     => $args['default_value'],
                'required' => [
                    'footer_custom', '=', 'on'
                ]
            ),
            'footer_fixed' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Footer Fixed', 'genzia'),
                'subtitle'      => esc_html__('Make footer fixed at bottom?', 'genzia'),
                'default'       => $args['default'],
                'default_value' => $args['default_on'], 
                'required' => [
                    'footer_custom', '=', 'on'
                ]
            ])
        ];
        // Return
        return [
            'title'      => esc_html__('Footer', 'genzia'),
            'fields'     => $custom_fields + $default_fields
        ];
    }
}
/**
 * WooCommerce Options
 * ====================
 * 
 * */
/**
 * Single Product Options
 * **/
if(!function_exists('genzia_single_product_opts')){
    function genzia_single_product_opts($args = []){
        $args = wp_parse_args($args, [
            'default'      => false
        ]);
        if($args['default']){
            $custom_opts = [
                'product_custom' => genzia_theme_on_off_opts([
                    'title'         => esc_html__('Custom Product','genzia'),
                    'default'       => false,
                    'default_value' => 'off'
                ])
            ];
            $required = [
                'product_custom',
                '=',
                'on'
            ];
            $on_off_default = true;
            $product_single_layout_default = '0';
            $product_single_gallery_default = '0';
        } else {
            $custom_opts = [];
            $required = '';
            $on_off_default = false;
            $product_single_layout_default = 'single-product';
            $product_single_gallery_default = 'slider';
        }
        return array(
            'title'      => esc_html__('Single Products', 'genzia'),
            'fields'     => array_merge(
                $custom_opts,
                array(
                    //
                    'product_layout_and_content' => [
                        'type'     => CSH_Theme_Core::HEADING_FIELD,
                        'title'    => esc_html__('Layout & Content', 'genzia'),
                        'required' => $required
                    ],
                    'product_single_layout' => genzia_select_opts([
                        'title'         => esc_html__('Layout', 'genzia'),
                        'subtitle'      => esc_html__('Choose layout for single product','genzia'),
                        'default'       => $args['default'],
                        'default_value' => $product_single_layout_default,
                        'options'       => [
                            'single-product'       => esc_html__('WooCommerce Default','genzia')
                        ],
                        'required' => $required
                    ]),
                    // Product Gallery 
                    'product_gallery' => genzia_select_opts([
                        'title'         => esc_html__('Gallery Layout', 'genzia'),
                        'subtitle'      => esc_html__('Choose layout for single product Gallery','genzia'),
                        'default'       => $args['default'],
                        'default_value' => $product_single_gallery_default,
                        'options'       => [
                            'slider'         => esc_html__('Slider','genzia'),
                        ],
                        'required' => $required
                    ]),
                    // Product share
                    'product_share' => genzia_theme_on_off_opts([
                        'title'         => esc_html__('Share', 'genzia'),
                        'default'       => $on_off_default,
                        'default_value' => 'off',
                        'required'      => $required
                    ])
                )
            )
        );
    }
}

/**
 * Pop Ups Options
**/
if(!function_exists('genzia_popup_opts')){
    function genzia_popup_opts($args=[]){
        $args = wp_parse_args($args, [
            'default'        => false,
            'default_value'  => 'none',
            'default_on'     => 'off',
            'custom'         => false ,
            'animate_value'  => 'cms-fadeInUp',
            'position_value' => 'align-items-end' 
        ]);
        if($args['default']){
            $args['default_value'] = '-1';
            $args['animate_value'] = $args['position_value'] = '-1';
        }
        $custom_fields = [];
        if($args['custom']){
            $custom_fields['popup_custom'] = genzia_theme_on_off_opts([
                'title'         => esc_html__('Custom Pop Up','genzia'),
                'default'       => false
            ]);
        }
        $default_fields = [
            'popup_layout' => array(
                'type'        => CSH_Theme_Core::IMAGE_SELECT_FIELD,
                'title'       => esc_html__('Layout', 'genzia'),
                'subtitle'    => esc_html__('Select a layout for upper Pop-Up area.', 'genzia'),
                'description' => sprintf(esc_html__('%sClick Here%s to add your custom popup layout.','genzia'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=cms-popup' ) ) . '" target="_blank">','</a>'),
                'placeholder' => esc_html__('Default','genzia'),
                'options'     => genzia_list_post_thumbnail('cms-popup', $args['default'], [
                    'none' => get_template_directory_uri() . '/assets/images/default-opt/none.jpg'
                ]),
                'default'     => $args['default_value'],
                'required' => [
                    'popup_custom', "=", 'on'
                ]
            ),
            'hide_popup' => genzia_theme_on_off_opts([
                'title'         => esc_html__('Show Hide popup option','genzia'),
                'default'       => false,
                'required' => [
                    'popup_custom', "=", 'on'
                ]
            ]),
            'popup_animate'    => genzia_select_opts([
                'title'         => esc_html__('Animation Style', 'genzia'),
                'default'       => $args['default'],
                'default_value' => $args['animate_value'],
                'options'       => [
                    'cms-fadeInUp'    => esc_html__('Fade In Up','genzia'),
                    'cms-fadeInLeft'  => esc_html__('Fade In Left','genzia'), 
                    'cms-fadeInRight' => esc_html__('Fade In Right','genzia')
                ],
                'required' => [
                    'popup_custom', "=", 'on'
                ]
            ]),
            'popup_position'   => genzia_select_opts([
                'title'         => esc_html__('Position', 'genzia'),
                'default'       => $args['default'],
                'default_value' => $args['position_value'],
                'options'       => [
                    'align-items-start'                         => esc_html__('Top - Start','genzia'),
                    'align-items-start justify-content-end'     => esc_html__('Top - End','genzia'), 
                    'align-items-center'                        => esc_html__('Center - Start','genzia'),
                    'align-items-center justify-content-center' => esc_html__('Center - Center','genzia'),
                    'align-items-center justify-content-end'    => esc_html__('Center - End','genzia'),
                    'align-items-end'                           => esc_html__('Bottom - Start','genzia'),
                    'align-items-end justify-content-end'       => esc_html__('Bottom - End','genzia'), 
                ],
                'required' => [
                    'popup_custom', "=", 'on'
                ]
            ]),
            'popup_max_w' => [
                'type'     => 'dimensions',
                'title'    => esc_html__('Popup Width', 'genzia'),
                'subtitle' => esc_html__('Enter number.', 'genzia'),
                'height'   => false,
                'required' => [
                    'popup_custom', "=", 'on'
                ]
            ]
        ];
        // Return
        return [
            'title'      => esc_html__('Pop Up', 'genzia'),
            'fields'     => $custom_fields + $default_fields
        ];
    }
}

/***
 * Get CMS PopUp template
*/
if(!function_exists('genzia_list_elementor_template')){
    function genzia_list_elementor_template(){
        $elementor_templates = get_posts([
            'post_type'   => 'cms-popup',
            'numberposts' => -1,
            'post_status' => 'publish',
        ]);
        $elementor_templates_opt = [
            '_1' => esc_html__( 'Select Template', 'genzia' ),
        ];
        if($elementor_templates){
            foreach ($elementor_templates as $template) {
                $elementor_templates_opt[$template->ID] = $template->post_title;
            }
        }
        return $elementor_templates_opt;
    }
}