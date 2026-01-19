<?php
/**
 * Template part for displaying default header layout
 */
$default_class = [
    'bg-white',
    (genzia_get_opts( 'header_shadow', 'on', 'header_custom') === 'on') ? 'header-shadow' : ''
];
$sticky_class  = [
    'bg-white',
    'header-shadow',
    //(genzia_get_opts( 'header_shadow', 'on', 'header_custom') === 'on') ? 'header-shadow' : ''
];
$ontop_class   = [
    (genzia_get_opts( 'header_shadow', 'on', 'header_custom') === 'on') ? 'header-shadow' : '',
    'header-transparent'
];
$data_header_settings =[
    'default_class' => $default_class,
    'sticky_class'  => $sticky_class,
    'ontop_class'   => $ontop_class
];
//
$logo_class = [
    'site-branding',
    'flex-auto',
    //genzia_header_has_tools() ? 'justify-content-center' : 'justify-content-end',
    'cms-hidden-desktop-menu'
];
// Custom Logo 
add_filter('genzia_menu_item_logo_args', function(){
    return [
        'link_class' => 'mt-n42'
    ];
});
//
$nav_class = [
    'site-navigation site-navigation-dropdown',
    'flex-basic',
    //'justify-content-start',
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
    // Button 01
    genzia_header_button_render([
        'class'      => 'cms-hover-move-icon-right btn btn-accent-regular text-white btn-hover-primary-regular text-hover-white w-100 justify-content-between mt-25 cms-hidden-desktop-menu',
        'data'       => [
            'default_class'     => [],
            'transparent_class' => []
        ],
        'icon'        => 'arrow-right',
        'icon_mobile' => '',
        'icon_size'   => 8,
        'text_class'  => ''
    ]);
    // Button 02
    genzia_header_button_render([
        'name'       => 'h_btn2',
        'class'      => 'cms-hover-move-icon-right btn btn-primary-regular text-white btn-hover-accent-regular text-hover-white w-100 justify-content-between mt-25 cms-hidden-desktop-menu',
        'data'       => [
            'default_class'     => [],
            'transparent_class' => []
        ],
        'icon'        => '',
        'icon_mobile' => '',
        'icon_size'   => 8,
        'text_class'  => ''
    ]);
$nav_content = ob_get_clean();
?>
<header id="cms-header-wrap" class="<?php echo genzia_header_wrap_classes(); ?>">
    <?php genzia_header_top(); ?>
    <div id="cms-header" class="<?php echo genzia_header_classes('w-100 p-lr-40 p-lr-mobile-menu-20 '.implode(' ', $default_class )); ?>" data-settings='<?php echo wp_json_encode($data_header_settings); ?>' style="<?php echo implode(';', $header_style); ?>">
        <div class="<?php echo genzia_header_container_classes('flex-basic d-flex gap-32 justify-content-between p-lr-24 p-lr-mobile-menu-12'); ?>">
            <?php 
            // logo
            get_template_part('template-parts/header/header-branding', '', [
                'before'     => '<div class="'.genzia_nice_class($logo_class).'">',
                'after'      => '</div>',
                'link_class' => ''
            ]);
            // Button 01
            genzia_header_button_render([
                'class'      => 'h-btn1 cms-hover-move-icon-right btn btn-md btn-outline-menu text-menu btn-hover-menu text-hover-white',
                'data'       => [
                    'default_class'     => ['btn-outline-menu','text-menu','btn-hover-menu','text-hover-white'],
                    'sticky_class'      => ['btn-outline-menu','text-menu','btn-hover-menu','text-hover-white'],
                    'transparent_class' => ['btn-outline-white','text-white','btn-hover-white','text-hover-menu']
                ],
                'text_class'  => 'cms-hidden-mobile-menu',
                'icon'        => 'arrow-right',
                'icon_mobile' => '',
                'icon_size'   => 13,
                'style'       => '',
                'before'      => '<div class="flex-auto align-self-center cms-hidden-mobile-menu">',
                'after'       => '</div>' 
            ]);
            // Navigation 
            get_template_part('template-parts/header/header-menu', '',[
                'before'     => '<nav class="'.genzia_nice_class($nav_class).'">', 
                'after'      => $nav_content.'</nav>'
            ]);
            ?>
            <div class="<?php echo genzia_header_tools_classes(['class' => 'flex-auto d-flex gap-20 justify-content-end align-items-center']); ?>">
                <?php
                    // Phone
                    genzia_header_phone_render();
                    // Mail
                    genzia_header_mail_render(['class' => 'menu-color']);
                    // Currency Switch
                    genzia_header_woocs([
                        'before' => '<div class="site-header-item">',
                        'after'  => '</div>'
                    ]);
                    // Button 02
                    genzia_header_button_render([
                        'name'       => 'h_btn2',
                        'class'      => 'h-btn2 cms-hover-move-icon-right btn btn-md btn-accent-regular text-menu btn-hover-primary-regular text-hover-white mr-12 mr-mobile-menu-0',
                        'data'       => [
                            'default_class'     => ['btn-accent-regular','text-menu','btn-hover-primary-regular','text-hover-white'],
                            'sticky_class'      => ['btn-accent-regular','text-menu','btn-hover-primary-regular','text-hover-white'],
                            'transparent_class' => ['btn-accent-regular','text-menu','btn-hover-primary-regular','text-hover-white']
                        ],
                        'text_class'  => 'cms-hidden-mobile-menu',
                        'icon'        => 'arrow-right',
                        'icon_mobile' => '',
                        'icon_size'   => 8,
                        'style'       => ''
                    ]);
                    // Language Switch
                    genzia_header_language_switcher([
                        'before'     => '<div class="site-header-item site-header-language font-700">',
                        'after'      => '</div>',
                        'img_size'   => 20,
                        'show_flag'  => 'yes',
                        'show_name'  => 'no',
                        'link_class' => 'cms-transition cms-hover-zoomout',
                        'data'       => [
                            'default_class'     => [],
                            'sticky_class'      => [],
                            'transparent_class' => []
                        ]
                    ]);
                    // Search icon
                    genzia_header_search([
                        'text'  => '',
                        'class' => 'cms-transition cms-hover-zoomout',
                        'data'  => [
                            'default_class'     => [],
                            'sticky_class'      => [],
                            'transparent_class' => []
                        ]
                    ]);
                    // Login
                    genzia_header_login([
                        'class' => 'cms-transition cms-hover-zoomout',
                        'data'  => [
                            'default_class'     => [],
                            'sticky_class'      => [],
                            'transparent_class' => []
                        ]
                    ]);
                    // Wishlist
                    genzia_header_wishlist([
                        'class' => 'cms-transition cms-hover-zoomout',
                        'data'  => [
                            'default_class'     => [],
                            'sticky_class'      => [],
                            'transparent_class' => []
                        ]
                    ]);
                    // Compare
                    genzia_header_compare([
                        'class' => 'cms-transition cms-hover-zoomout',
                        'data'  => [
                            'default_class'     => [],
                            'sticky_class'      => [],
                            'transparent_class' => []
                        ]
                    ]);
                    // Cart icon
                    genzia_header_cart([
                        'class'      => 'pt-3',
                        'icon_class' => 'cms-eicon cms-transition cms-hover-zoomout',   
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
                        'item_class' => 'menu-color cms-hover-zoomout',
                        'before'     => '<div class="site-header-social d-flex gap-20 align-items-center cms-header-height cms-hidden-mobile-menu">',
                        'after'      => '</div>'
                    ]);
                    // Side Nav
                    genzia_header_side_nav_render([
                        'class'      => 'cms-transition cms-hover-zoomout',
                        'icon_class' => '',
                        'data'       => [
                            'default_class'     => [],
                            'sticky_class'      => [],
                            'transparent_class' => []
                        ]
                    ]);
                    // Mobile menu
                    genzia_open_mobile_menu([
                        'class'      => 'cms-transition cms-hover-zoomout',
                        'icon_class' => 'inherit',
                        'data'       => [
                            'default_class'     => [],
                            'sticky_class'      => [],
                            'transparent_class' => []
                        ]
                    ]);
                ?>
            </div>
        </div>
    </div>
</header>