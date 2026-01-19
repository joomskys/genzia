<?php
/**
 * Header Top
 * */
$header_top_layout = genzia_get_opts('header_top_layout', '', 'header_top_custom');
// WPML
if (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE != 'all' && !empty(ICL_LANGUAGE_CODE)) {
    $header_top_layout = apply_filters( 'wpml_object_id', $header_top_layout, 'cms-footer', true, ICL_LANGUAGE_CODE );
}
// End WPML
if(in_array($header_top_layout, ['0', 'none', ''])){
    $has_header_top = 'bdr-t-1 mt-32 mt-mobile-menu-10';
} else {
    $has_header_top = '';
}
/**
 * Template part for displaying default header layout
 */
$default_class = [
    'bg-white',
    (genzia_get_opts( 'header_shadow', 'on', 'header_custom') === 'on') ? 'header-shadow' : ''
];
$sticky_class  = array_merge($default_class, [
    'header-shadow',
    'bg-white',
    'p-lr-48 p-lr-mobile-menu-20'
]);
$ontop_class   = [
    (genzia_get_opts( 'header_shadow', 'on', 'header_custom') === 'on') ? 'header-shadow' : '',
    'header-transparent',
    'bdr-b-1 bdr-divider-30',
    $has_header_top,
    'm-lr-48 m-lr-mobile-menu-20'
];
$data_header_settings =[
    'default_class' => $default_class,
    'sticky_class'  => $sticky_class,
    'ontop_class'   => $ontop_class
];
//
$logo_class = [
    'site-branding',
    'flex-basic',
    //genzia_header_has_tools() ? 'justify-content-center' : 'justify-content-end'
];
//
$nav_class = [
    'site-navigation site-navigation-dropdown',
    'flex-auto',
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
    '--cms-header-offset-space:0px;'
];
// Nav Content
ob_start();
    // Button 01
    genzia_header_button_render([
        'class'      => 'cms-hover-move-icon-right cms-btn btn-accent-regular text-white btn-hover-primary-regular text-hover-white w-100 justify-content-between mt-25 cms-hidden-desktop-menu',
        'data'       => [
            'default_class'     => [],
            'transparent_class' => []
        ],
        'icon'        => 'arrow-right',
        'icon_mobile' => '',
        'icon_size'   => 10,
        'text_class'  => ''
    ]);
    // Button 02
    genzia_header_button_render([
        'name'       => 'h_btn2',
        'class'      => 'cms-hover-move-icon-right cms-btn btn-primary-regular text-white btn-hover-accent-regular text-hover-white w-100 justify-content-between mt-25 cms-hidden-desktop-menu',
        'data'       => [
            'default_class'     => [],
            'transparent_class' => []
        ],
        'icon'        => 'arrow-right',
        'icon_mobile' => '',
        'icon_size'   => 10,
        'text_class'  => ''
    ]);
$nav_content = ob_get_clean();

?>
<header id="cms-header-wrap" class="<?php echo genzia_header_wrap_classes(); ?>">
    <?php genzia_header_top(); ?>
    <div id="cms-header" class="<?php echo genzia_header_classes(implode(' ', $default_class )); ?>" data-settings='<?php echo wp_json_encode($data_header_settings); ?>' style="<?php echo implode(';', $header_style); ?>">
        <div class="<?php echo genzia_header_container_classes('d-flex gap-10 justify-content-between'); ?>">
            <?php 
            // logo
            get_template_part('template-parts/header/header-branding', '', [
                'before' => '<div class="'.genzia_nice_class($logo_class).'">',
                'after'  => '</div>',
            ]);
            // Navigation 
            get_template_part('template-parts/header/header-menu', '',[
                'before'     => '<nav class="'.genzia_nice_class($nav_class).'">', 
                'after'      => $nav_content.'</nav>'
            ]);
            ?>
            <div class="<?php echo genzia_header_tools_classes(['class' => 'flex-basic d-flex gap-20 justify-content-end align-items-center']); ?>">
                <?php
                    // Phone
                    genzia_header_phone_render([
                        'class'           => 'text-btn menu-color font-500',
                        'icon_size'       => 15,
                        'icon_class'      => 'cms-hidden-desktop-menu text-white',
                        'text_wrap_class' => 'd-flex gap-5 align-items-center',
                        'text_class'      => '',
                        'phone_text'      => esc_html__('Phone:','genzia'),
                        'phone_class'     => ''
                    ]);
                    // Mail
                    genzia_header_mail_render([
                        'class'      => 'text-btn menu-color font-500',
                        'icon_class' => 'cms-hidden-desktop-menu text-white',
                        'icon_size'  => 18,
                        'icon_class' => 'cms-hidden-desktop-menu text-white'
                    ]);
                    // Currency Switch
                    genzia_header_woocs([
                        'before' => '<div class="site-header-item">',
                        'after'  => '</div>'
                    ]);
                    // Button 01
                    genzia_header_button_render([
                        'class'      => 'h-btn1 cms-hover-move-icon-right cms-btn btn-md btn-accent-regular text-white btn-hover-primary-regular text-hover-white cms-hidden-mobile-menu',
                        'data'       => [
                            'default_class'     => ['btn-accent-regular','text-white','btn-hover-primary-regular','text-hover-white'],
                            'sticky_class'      => ['btn-accent-regular','text-white','btn-hover-primary-regular','text-hover-white'],
                            'transparent_class' => ['btn-white','text-menu','btn-hover-accent-regular','text-hover-white']
                        ],
                        'text_class'  => 'cms-hidden-mobile-menu',
                        'icon'        => 'arrow-right',
                        'icon_mobile' => '',
                        'icon_size'   => 10,
                        'style'       => ''
                    ]);
                    // Button 02
                    genzia_header_button_render([
                        'name'       => 'h_btn2',
                        'class'      => 'h-btn2 cms-hover-move-icon-right cms-btn btn-md btn-primary-regular text-white btn-hover-accent-regular text-hover-white cms-hidden-mobile-menu',
                        'data'       => [
                            'default_class'     => ['btn-primary-regular','text-white','btn-hover-accent-regular','text-hover-white'],
                            'sticky_class'      => ['btn-primary-regular','text-white','btn-hover-accent-regular','text-hover-white'],
                            'transparent_class' => ['btn-primary-regular','text-white','btn-hover-accent-regular','text-hover-white']
                        ],
                        'text_class'  => 'cms-hidden-mobile-menu',
                        'icon'        => '',
                        'icon_mobile' => 'arrow-right',
                        'icon_size'   => 10,
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