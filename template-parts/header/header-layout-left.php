<?php
/**
 * Template part for displaying default header layout
 */
ob_start();
    // Button 01
    genzia_header_button_render([
        'class'      => 'cms-hidden-mobile-menu h-btn1 btn-menu-mobile cms-hover-move-icon-right btn btn-sm btn-accent-regular text-menu btn-hover-primary-regular text-hover-white',
        'data'       => [
            'default_class'     => ['btn-accent-regular','text-menu','btn-hover-primary-regular','text-hover-white'],
            'sticky_class'      => ['btn-accent-regular','text-menu','btn-hover-primary-regular','text-hover-white'],
            'transparent_class' => ['btn-accent-regular','text-menu','btn-hover-primary-regular','text-hover-white']
        ],
        'icon'        => 'arrow-right',
        'icon_mobile' => '',
        'icon_size'  => '17'
    ]);
    // Button 02
    genzia_header_button_render([
        'name'       => 'h_btn2',
        'class'      => 'cms-hidden-mobile-menu h-btn2 btn-menu-mobile cms-hover-move-icon-right btn btn-sm btn-primary-regular text-white btn-hover-accent-regular text-hover-menu',
        'data'       => [
            'default_class'     => ['btn-accent-regular','text-menu','btn-hover-primary-regular','text-hover-white'],
            'sticky_class'      => ['btn-accent-regular','text-menu','btn-hover-primary-regular','text-hover-white'],
            'transparent_class' => ['btn-accent-regular','text-menu','btn-hover-primary-regular','text-hover-white']
        ],
        'icon'        => 'arrow-right',
        'icon_mobile' => ''  
    ]);
    // Phone
    genzia_header_phone_render(['class' => 'cms-hidden-mobile-menu']);
    // Mail
    genzia_header_mail_render(['class' => 'cms-hidden-mobile-menu menu-color cms-hover-underline font-700']);
$desktop_menu_attrs = ob_get_clean();
?>
<?php genzia_header_top(); ?>
<header id="cms-header-wrap" class="<?php echo genzia_header_wrap_classes(); ?>">
    <div id="cms-header" class="<?php echo genzia_header_classes(); ?>">
        <div class="<?php echo genzia_header_container_classes('d-flex gap-30 justify-content-between'); ?>">
            <?php 
            // logo
            get_template_part('template-parts/header/header-branding', '', [
                'before' => '<div class="site-branding flex-auto d-flex justify-content-center pl-mobile-menu-20">',
                'after'  => '</div>',
            ]);
            ?>
            <div id="cms-header-left-show-menu" class="cms-header-left-show-menu d-flex justify-content-center align-items-center relative cms-hidden-mobile-menu menu-color"><?php 
                genzia_svgs_icon([
                    'icon'      => 'side-menu',
                    'icon_size' => 8,
                    'icon_class'     => 'open'
                ]);
                genzia_svgs_icon([
                    'icon'      => 'close',
                    'icon_size' => 16,
                    'icon_class'     => 'close'
                ]);
            ?></div>
            <?php
            // Navigation 
            get_template_part('template-parts/header/header-menu', '',[
                'before' => '<nav class="site-navigation site-navigation-dropdown flex-basic">', 
                'after'  => $desktop_menu_attrs.'</nav>' 
            ]);
            ?>
            <div class="<?php echo genzia_header_tools_classes(['class' => 'flex-auto d-flex gap-20 justify-content-end align-items-center pl-mobile-menu-20 pr-mobile-menu-20']); ?>">
                <?php
                // Button 01
                genzia_header_button_render([
                    'class'      => 'cms-hidden-desktop-menu h-btn1 btn-menu-mobile cms-hover-move-icon-right btn btn-sm btn-accent-regular text-menu btn-hover-primary-regular text-hover-white',
                    'data'       => [
                        'default_class'     => ['btn-accent-regular','text-menu','btn-hover-primary-regular','text-hover-white'],
                        'sticky_class'      => ['btn-accent-regular','text-menu','btn-hover-primary-regular','text-hover-white'],
                        'transparent_class' => ['btn-accent-regular','text-menu','btn-hover-primary-regular','text-hover-white']
                    ],
                    'icon'        => 'arrow-right',
                    'icon_mobile' => '',
                    'icon_size'  => '17'
                ]);
                // Button 02
                genzia_header_button_render([
                    'name'       => 'h_btn2',
                    'class'      => 'cms-hidden-desktop-menu h-btn2 btn-menu-mobile cms-hover-move-icon-right btn btn-sm btn-primary-regular text-white btn-hover-accent-regular text-hover-menu',
                    'data'       => [
                        'default_class'     => ['btn-primary-regular','text-white','btn-hover-accent-regular','text-hover-menu'],
                        'sticky_class'      => ['btn-primary-regular','text-white','btn-hover-accent-regular','text-hover-menu'],
                        'transparent_class' => ['btn-primary-regular','text-white','btn-hover-accent-regular','text-hover-menu']
                    ],
                    'icon'        => 'arrow-right',
                    'icon_mobile' => ''  
                ]);
                // Phone
                genzia_header_phone_render(['class'=>'cms-hidden-desktop-menu']);
                // Mail
                genzia_header_mail_render(['class' => 'cms-hidden-desktop-menu menu-color cms-hover-underline font-700']);
                // Currency Switch
                genzia_header_woocs([
                    'before' => '<div class="site-header-item">',
                    'after'  => '</div>'
                ]);
                // Language Switch
                genzia_header_language_switcher([
                    'before' => '<div class="cms-hidden-desktop-menu site-header-item site-header-language font-700">',
                    'after'  => '</div>'
                ]);
                // Login
                genzia_header_login();
                // Search icon
                genzia_header_search([
                    'text' => ''
                ]);
                // Wishlist
                genzia_header_wishlist();
                // Compare
                genzia_header_compare();
                // Cart icon
                genzia_header_cart([
                    'layout' => '1'
                ]);
                // Social
                genzia_header_social_render([
                    'show_text'  => false,
                    'item_class' => 'menu-color cms-hidden-mobile-menu',
                    'before' => '',
                    'after'  => ''
                ]);
                // Side Nav
                genzia_header_side_nav_render();
                
                // Mobile menu
                genzia_open_mobile_menu();
                ?>
            </div>
        </div>
    </div>
</header>