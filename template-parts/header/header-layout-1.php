<?php
/**
 * Template part for displaying default header layout
 */
$header_classes = 'pt-32 pt-mobile-menu-20';
$default_class = [
    $header_classes,
    'mb-16',
    'bg-white',
    (genzia_get_opts( 'header_shadow', 'on', 'header_custom') === 'on') ? 'header-shadow' : ''
];
$sticky_class  = array_merge($default_class, [
    'header-shadow',
    'bg-white',
    'w-100',
    'p-tb-10'
]);
$ontop_class   = [
    $header_classes,
    'bg-transparent',
    (genzia_get_opts( 'header_shadow', 'on', 'header_custom') === 'on') ? 'header-shadow' : '',
    'header-transparent'
];
$data_header_settings =[
    'default_class' => $default_class,
    'sticky_class'  => $sticky_class,
    'ontop_class'   => $ontop_class
];
//
$header_left_classes = [
    'flex-auto d-flex gap p-lr-24 p-lr-mobile-menu-20 bg-backdrop cms-radius-10',
    (genzia_get_opts( 'header_transparent', 'on', 'header_custom') === 'on') ? '' : 'bg-white cms-shadow-3'
];
$logo_class = [
    'site-branding',
    'flex-auto',
    //genzia_header_has_tools() ? 'justify-content-center' : 'justify-content-end'
];
//
$nav_class = [
    'site-navigation site-navigation-dropdown',
    //'flex-basic',
    //'d-flex',
    //'justify-content-end',
    //genzia_header_has_tools() ? 'justify-content-center' : 'justify-content-end'
];
$header_style = [
    '--cms-menu-outline:transparent',
    '--cms-menu-outline-hover:transparent',
    '--cms-menu-outline-active:var(--cms-menu-active)',
    //
    '--cms-menu-transparent-outline:transparent',
    '--cms-menu-transparent-outline-hover:var(--cms-divider-50)',
    '--cms-menu-transparent-outline-active:var(--cms-divider-50)',
    // offset
    '--cms-header-offset-space:0;'
];
// Nav Content
ob_start();
    echo '<div class="d-flex justify-content-center gap-20 pt-20 cms-hidden-desktop-menu">';
        // Button 01
        genzia_header_button_render([
            'class'      => 'cms-hover-move-icon-right cms-btn btn-accent-regular text-white btn-hover-primary-regular text-hover-white cms-hover-move-icon-right cms-hover-change',
            'data'       => [
                'default_class'     => [],
                'transparent_class' => []
            ],
            'icon'        => 'arrow-right',
            'icon_mobile' => '',
            'icon_size'   => 10,
            'icon_class'  => 'cms-box-48 cms-radius-6 order-first cms-header-change',
            'icon_data'   => [
                'default_class'     => ['bg-white', 'text-menu', 'bg-on-hover-accent-regular', 'text-on-hover-white'],
                'transparent_class' => ['bg-white', 'text-menu', 'bg-on-hover-accent-regular', 'text-on-hover-white'],
                'sticky_class'      => ['bg-white', 'text-menu', 'bg-on-hover-accent-regular', 'text-on-hover-white']
            ],
            'text_class'  => ''
        ]);
        // Button 02
        genzia_header_button_render([
            'name'       => 'h_btn2',
            'class'      => 'cms-hover-move-icon-right cms-btn btn-primary-regular text-white btn-hover-accent-regular text-hover-white cms-hover-move-icon-right cms-hover-change',
            'data'       => [
                'default_class'     => [],
                'transparent_class' => []
            ],
            'icon'        => 'arrow-right',
            'icon_mobile' => '',
            'icon_size'   => 10,
            'icon_class'  => 'cms-box-48 cms-radius-6 order-first cms-header-change',
            'icon_data'   => [
                'default_class'     => ['bg-white', 'text-menu', 'bg-on-hover-primary-regular', 'text-on-hover-white'],
                'transparent_class' => ['bg-white', 'text-menu', 'bg-on-hover-primary-regular', 'text-on-hover-white'],
                'sticky_class'      => ['bg-white', 'text-menu', 'bg-on-hover-primary-regular', 'text-on-hover-white']
            ],
            'text_class'  => ''
        ]);
    echo '</div>';
$nav_content = ob_get_clean();
//
$header_tools_classes = [
    'flex-auto d-flex gap-20 gap-xsmobile-10 align-items-center bg-backdrop cms-radius-10 p-lr-24 p-lr-xsmobile-10 cms-header-height',
    (genzia_get_opts( 'header_transparent', 'on', 'header_custom') === 'on') ? '' : 'bg-white cms-shadow-3'
];
?>
<header id="cms-header-wrap" class="<?php echo genzia_header_wrap_classes(); ?>">
    <?php genzia_header_top(); ?>
    <div id="cms-header" class="<?php echo genzia_header_classes(implode(' ', $default_class )); ?>" data-settings='<?php echo wp_json_encode($data_header_settings); ?>' style="<?php echo implode(';', $header_style); ?>">
        <div class="<?php echo genzia_header_container_classes('d-flex gap-32 gap-mobile-menu-10 justify-content-between align-items-start p-lr-48 p-lr-mobile-menu-20'); ?>">
            <div class="<?php echo genzia_nice_class($header_left_classes); ?>" style="--cms-gap:80px;">
                <?php 
                // logo
                get_template_part('template-parts/header/header-branding', '', [
                    'before' => '<div class="'.genzia_nice_class($logo_class).'">',
                    'after'  => '</div>',
                ]);
                // Navigation 
                get_template_part('template-parts/header/header-menu', '',[
                    'before'     => '<nav class="'.genzia_nice_class($nav_class).'">', 
                    'after'      => $nav_content.'</nav>',
                    'menu_class' => '' //'menu-inline-underline'
                ]);
                ?>
            </div>
            <div class="<?php echo genzia_header_tools_classes(['class' => 'flex-auto d-flex gap-8 justify-content-end align-items-center']); ?>">
                <div class="<?php echo genzia_nice_class($header_tools_classes); ?>">
                    <?php
                        // Phone
                        genzia_header_phone_render2([
                            'class' => 'menu-color pr-30 pr-mobile-menu-0'
                        ]);
                        // Mail
                        genzia_header_mail_render([
                            'class' => 'menu-color pr-30 pr-mobile-menu-0'
                        ]);
                        // Currency Switch
                        genzia_header_woocs([
                            'before' => '<div class="site-header-item">',
                            'after'  => '</div>'
                        ]);
                        // Language Switch
                        genzia_header_language_switcher([
                            'before'     => '<div class="site-header-item site-header-language font-700">',
                            'after'      => '</div>',
                            'img_size'   => 20,
                            'show_flag'  => 'yes',
                            'show_name'  => 'no',
                            'link_class' => 'cms-transition',
                            'data'       => [
                                'default_class'     => [],
                                'sticky_class'      => [],
                                'transparent_class' => []
                            ]
                        ]);
                        // Search Toggle
                        genzia_header_search_toggle();
                        // Login
                        genzia_header_login([
                            'class' => 'cms-transition',
                            'data'  => [
                                'default_class'     => [],
                                'sticky_class'      => [],
                                'transparent_class' => []
                            ]
                        ]);
                        // Wishlist
                        genzia_header_wishlist([
                            'class' => 'cms-transition',
                            'data'  => [
                                'default_class'     => [],
                                'sticky_class'      => [],
                                'transparent_class' => []
                            ]
                        ]);
                        // Compare
                        genzia_header_compare([
                            'class' => 'cms-transition',
                            'data'  => [
                                'default_class'     => [],
                                'sticky_class'      => [],
                                'transparent_class' => []
                            ]
                        ]);
                        // Cart icon
                        genzia_header_cart([
                            'class'      => 'pt-3',
                            'icon_class' => 'cms-eicon cms-transition',   
                            'text'       => '',
                            'data_icon'  => [
                                'default_class'     => [],
                                'sticky_class'      => [],
                                'transparent_class' => []
                            ]
                        ]);
                        // Social
                        genzia_header_social_render([
                            'show_text'  => false,
                            'item_class' => 'menu-color',
                            'before'     => '<div class="site-header-social d-flex gap-20 align-items-center cms-header-height cms-hidden-mobile-menu">',
                            'after'      => '</div>'
                        ]);
                        // Side Nav
                        genzia_header_side_nav_toggle();
                        // Mobile menu
                        genzia_open_mobile_menu([
                            'class'      => 'cms-transition',
                            'icon_class' => 'inherit',
                            'data'       => [
                                'default_class'     => [],
                                'sticky_class'      => [],
                                'transparent_class' => []
                            ]
                        ]);
                    ?>
                </div>
                <?php 
                    // Button 01
                    genzia_header_button_render([
                        'class'      => 'h-btn1 cms-shadow-3 cms-btn btn-white text-menu btn-hover-accent-regular text-hover-white cms-hover-move-icon-right cms-hidden-mobile-menu cms-hover-change',
                        'data'       => [
                            'default_class'     => ['btn-white','text-menu','btn-hover-accent-regular','text-hover-white'],
                            'sticky_class'      => ['btn-accent-regular','text-white','btn-hover-primary-regular','text-hover-white'],
                            'transparent_class' => ['btn-white','text-menu','btn-hover-accent-regular','text-hover-white']
                        ],
                        'text_class'  => 'cms-hidden-mobile-menu',
                        'icon'        => 'arrow-right',
                        'icon_mobile' => '',
                        'icon_size'   => 12,
                        'icon_class'  => 'cms-box-48 cms-radius-6 order-first cms-header-change',
                        'icon_data'   => [
                            'default_class'     => ['bg-accent-regular', 'text-white', 'bg-on-hover-white', 'text-on-hover-accent-regular'],
                            'transparent_class' => ['bg-accent-regular', 'text-white', 'bg-on-hover-white', 'text-on-hover-accent-regular', 'bg-hover-white','text-hover-accent-regular'],
                            'sticky_class'      => ['bg-white', 'text-menu', 'bg-on-hover-accent-regular', 'text-on-hover-white']
                        ],
                    ]);
                    // Button 02
                    genzia_header_button_render([
                        'name'       => 'h_btn2',
                        'class'      => 'h-btn2 cms-btn btn-primary-regular text-white btn-hover-accent-regular text-hover-white cms-hidden-mobile-menu cms-hover-move-icon-right cms-hover-change',
                        'data'       => [
                            'default_class'     => ['btn-primary-regular','text-white','btn-hover-accent-regular','text-hover-menu'],
                            'sticky_class'      => ['btn-primary-regular','text-white','btn-hover-accent-regular','text-hover-menu'],
                            'transparent_class' => ['btn-primary-regular','text-white','btn-hover-accent-regular','text-hover-menu']
                        ],
                        'text_class'  => 'cms-hidden-mobile-menu',
                        'icon'        => 'arrow-right',
                        'icon_mobile' => '',
                        'icon_size'   => 12,
                        'icon_class'  => 'cms-box-48 cms-radius-6 order-first cms-header-change',
                        'icon_data'   => [
                            'default_class'     => ['bg-white', 'text-menu', 'bg-on-hover-primary-regular', 'text-on-hover-white'],
                            'transparent_class' => ['bg-white', 'text-menu', 'bg-on-hover-primary-regular', 'text-on-hover-white'],
                            'sticky_class'      => ['bg-white', 'text-menu', 'bg-on-hover-primary-regular', 'text-on-hover-white']
                        ],
                        'style'       => ''
                    ]);
                ?>
            </div>
        </div>
    </div>
</header>