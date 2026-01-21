<?php
/**
 * Custom template tags for this theme.
 *
 * @package CMS Theme
 * @subpackage Genzia
 * 
 */
/**
 * Theme File
 * */
function genzia_theme_file_uri(){
    if(is_child_theme()){
        return get_parent_theme_file_uri() ;
    } else {
        return get_theme_file_uri();
    }
}
function genzia_theme_file_path(){
    if(is_child_theme()){
        return get_parent_theme_file_path() ;
    } else {
        return get_theme_file_path();
    }
}
/**
 * SVG Icons
 * 
*/
function genzia_svgs_icon($args = []){
    $args = wp_parse_args($args, [
        'icon'       => 'core/arrow-next',
        'icon_class' => 'cms-eicon',
        'icon_size'  => '',
        'icon_data'  => [],
        'class'      => '',
        'before'     => '',
        'after'      => '',
        'tag'        => 'span',
        'echo'       => true,
        'rtl'        => true,
        'attrs'      => [],
        'before_icon' => '',
        'after_icon'  => ''
    ]);
    if(empty($args['icon'])) return;
    //
    $icon_data = wp_parse_args($args['icon_data'], []);
    if(!empty($icon_data)){
        $args['attrs']['data-classes'] = wp_json_encode($icon_data);
    }
    //
    $icon_data_default_class = isset($args['icon_data']['default_class']) ? implode(' ', $args['icon_data']['default_class']) : '';
    $icon_classes = ['cms-svg-icon lh-0', $args['icon_class'], $args['class'], $icon_data_default_class ];
    if($args['rtl']) $icon_classes[] = 'rtl-flip empty-none';
    // attributes
    if(isset($args['attrs']['style'])){
        $args['attrs']['style'] .= ';--svg-size:'.$args['icon_size'].'px;';
    } else {
        $args['attrs']['style'] = '--svg-size:'.$args['icon_size'].'px;';
    }
    $icon_attrs = array_merge(
        [
            'class' => genzia_nice_class($icon_classes)
        ],
        $args['attrs']
    );
    // icon html
    ob_start();
        if(is_child_theme()){
            include get_template_directory() . '/assets/svgs/'.$args['icon'].'.svg';
        } else {
            include get_template_directory() . '/assets/svgs/'.$args['icon'].'.svg';
        }
    $icon_html = ob_get_clean();
    // html
    ob_start();
        printf('%s', $args['before']);
            printf('%1$s%2$s%3$s%4$s%5$s','<'.$args['tag'].' '.genzia_render_attrs($icon_attrs).'>',$args['before_icon'],$icon_html,$args['after_icon'], '</'.$args['tag'].'>');
        printf('%s', $args['after']);
    if($args['echo']){
        echo ob_get_clean();
    } else {
        return ob_get_clean();
    }
}
/**
 * Leading Zero
 * */
function genzia_leading_zero($number, $args = []){
    $args = wp_parse_args($args, [
        'before' => '',
        'after'  => '',
        'echo'   => true,
        'number' => 2
    ]);
    ob_start();
        printf('%1$s%2$s%3$s', $args['before'], zeroise( $number, $args['number'] ), $args['after']);
    if($args['echo']){
        echo ob_get_clean();
    } else {
        return ob_get_clean();
    }
}
/**
 * Check is Blog page
 * 
*/
if(!function_exists('cms_is_blog')){
    function cms_is_blog(){
        if(is_home() || is_archive() || is_category() || is_tag() || is_author() || is_date() || is_post_type_archive() || is_tax() || is_search() ){
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Body CSS class
 * 
 */
add_filter('body_class', 'genzia_body_classes');
function genzia_body_classes($classes){
    global $wp_query;
    $page = $wp_query->get( 'page' );
    if ( ! $page || $page < 2 ) {
        $page = $wp_query->get( 'paged' );
    }
    // Mouse Cursor
    $classes[] = 'cms-theme-cursor';
    // Top Space
    if(genzia_get_opts('body_top_space')!=''){
        $classes[] = 'mt';
    }
    // Header Top
    $header_top_layout = genzia_get_opts('header_top_layout', '', 'header_top_custom');
    if(!in_array($header_top_layout, ['-1', '0', 'none', ''])){
        $classes[] = 'has-header-top';
    }
    // header layout
    $classes[] = 'cms-header-layout-'.genzia_get_opts('header_layout', '1', 'header_custom');
    // header transparent
    if(genzia_get_opts( 'header_transparent', 'off', 'header_custom') === 'on'){
        $classes[] = 'cms-header-transparent';
    }
    // header boxed
    $classes[] = 'cms-header-boxed-'.genzia_get_opts('header_boxed', 'off', 'header_custom');
    // Custom font
    $classes[] = 'cms-heading-font-'.genzia_get_opts('heading_font','default');
    // footer
    $footer_fixed = genzia_get_opts('footer_fixed', 'off', 'footer_custom');
    if($footer_fixed == 'on') $classes[] = 'cms-footer-fixed';
    // Custom Class
    $classes[] = genzia_get_page_opt('body_classes');
    // single product
    $product_layout  = genzia_get_opts('product_single_layout', 'single-product' ,'product_custom');
    $product_gallery = genzia_get_opts('product_gallery', 'vertical-left' ,'product_custom');
    if(is_singular('product')){
        $classes[] = $product_layout;
        $classes[] = 'cms-product-gallery-'.$product_gallery;
    }
    //
    return $classes;
}

/**
 * Archives Title
 * remove label
 * */
add_filter('get_the_archive_title', 'genzia_archive_title_remove_label');
function genzia_archive_title_remove_label($title){
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = get_the_author();
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    } elseif (is_home()) {
        $title = single_post_title('', false);
    }
    return $title;
}
/**
 * Page loading.
 * 
 **/
function genzia_page_loading(){
    $page_loading = genzia_get_opt('show_page_loading', false);
    if ($page_loading) { ?>
        <section id="cms-loadding" class="cms-loader">
            <div class="loading-spinner">
                <div class="cms-bounce1"></div>
                <div class="cms-bounce2"></div>
                <div class="cms-bounce3"></div>
            </div>
        </section>
    <?php }
}
/**
 * Header Top
 * 
 * **/
if(!function_exists('genzia_header_top')){
    function genzia_header_top($args = []){
        if( (!class_exists('CSH_Theme_Core') || !class_exists('\Elementor\Plugin')) || is_singular('cms-header-top') || is_singular('cms-footer')  || is_singular('cms-mega-menu')) return;
        $args = wp_parse_args($args, [
            'id'    => 'cms-header-top',
            'class' => ''
        ]);
        $header_top_layout = genzia_get_opts('header_top_layout', '', 'header_top_custom');
        // WPML
        if (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE != 'all' && !empty(ICL_LANGUAGE_CODE)) {
            $header_top_layout = apply_filters( 'wpml_object_id', $header_top_layout, 'cms-footer', true, ICL_LANGUAGE_CODE );
        }
        // End WPML

        if(in_array($header_top_layout, ['-1', '0', 'none', ''])) return;

        $cms_post = get_post($header_top_layout);

        if (!is_wp_error($cms_post) && $cms_post->ID == $header_top_layout){
            $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $header_top_layout );
            if(empty($content)){
                $content = $cms_post->post_content;
            }
        } else {
            $content = $cms_post->post_content;
        }
        if(empty($content)) return;
        // Classes 
        $classes = ['cms-header-top', $args['class'], $cms_post->post_name];
    ?>
    <div id="<?php echo esc_attr($args['id']);?>" class="<?php echo genzia_nice_class($classes); ?>"><?php 
        ctc_print_html($content);
    ?></div>
    <?php
    }
}
/**
 * Header layout.
 **/
function genzia_header_layout(){
    $header_layout = genzia_get_opts('header_layout', '1', 'header_custom');
    if ($header_layout == '0' || $header_layout == 'none' || is_singular('cms-header-top') || is_singular('cms-footer') || is_singular('cms-mega-menu')) return;
    get_template_part('template-parts/header/header-layout', $header_layout);
}

/**
 * Header
 * Header Wrap Classes
 * 
 * */
if(!function_exists('genzia_header_wrap_classes')){
    function genzia_header_wrap_classes($class = ''){
        $classes = array_filter([
            'site-header',
            (genzia_get_opts( 'header_boxed', 'off', 'header_custom') == 'on') ? 'header-boxed' : '',
            $class
        ]);
        return genzia_nice_class($classes);
    }
}
/**
 * Header
 * Header Class
 * **/
if(!function_exists('genzia_header_classes')){
    function genzia_header_classes($class = ''){
        $classes = [
            'cms-header',
            'header-layout-'.genzia_get_opts('header_layout','1', 'header_custom'),
            (genzia_get_opts( 'header_sticky', 'off', 'header_custom') == 'on') ? 'sticky-on' : '',
            (genzia_get_opts( 'header_sticky', 'off', 'header_custom') == 'on') ? 'sticky-'.genzia_get_opts( 'header_sticky_mode', 'off', 'header_sticky') : '',
            (genzia_get_opts( 'header_transparent', 'off', 'header_custom') == 'on') ? 'transparent-on header-transparent' : '',
            (genzia_get_opts( 'header_transparent_mobile', 'on', 'header_custom') == 'on') ? 'transparent-mobile-'.genzia_get_opts( 'header_transparent_mobile', 'on', 'header_custom') : '',
            // Custom Class
            $class
        ];
        if(genzia_get_opts( 'header_shadow', 'on', 'header_custom') === 'on'){
            $classes[] = 'header-shadow';
        }
        if(genzia_get_opts( 'header_divider', 'off', 'header_custom') === 'on'){
            $classes[] = 'header-divider';
        }
        return implode(' ', array_filter($classes));
    }
}

/**
 * Header Container class 
 * 
 * **/
if(!function_exists('genzia_header_container_classes')){
    function genzia_header_container_classes($class = ''){
        $classes = [
            'cms-header-main',
            $class
        ];
        return implode(' ', array_filter($classes));
    }
}
/**
 * Header Search 
 * 
 * */
if(!function_exists('genzia_header_search')){
    function genzia_header_search($args = []){
        $args = wp_parse_args($args, [
            'class'       => 'site-header-item menu-color',
            'echo'        => true,
            'icon'        => 'core/search',
            'icon_size'   => 20,
            'icon_class'  => '',  
            'text'        => '',
            'modal-mode'  => 'slide', // fade, slide
            'modal-slide' => 'top', // top, right, bottom, left, center, zoom-in, zoom-out
            'modal-class' => '',
            'modal-width' => '100vw',
            'modal-space' => 0,
            'placeholder' => '',
            'before'      => '',
            'after'       => '',
            //
            'modal-overlay-class' => '',
            'data'                => [
                'default_class'     => [],
                'sticky_class'      => [],
                'transparent_class' => []
            ]
        ]);
        $args['data'] = wp_parse_args($args['data'], [
            'default_class'     => [],
            'sticky_class'      => [],
            'transparent_class' => []
        ]);
        $search_on = genzia_get_opts('search_icon', 'off', 'header_custom');
        if($search_on != 'on') return;
        add_action('wp_footer', 'genzia_search_popup');
        $classes = ['cms-header-change', 'site-header-search cms-modal d-flex gap-10 align-items-center lh-1', $args['class']];
        $icon_classes = ['header-icon search-toggle', 'text-'.$args['icon_size'], $args['icon_class']];
        // Search icon 
        $search_icon = genzia_svgs_icon([
            'icon'      => $args['icon'],
            'icon_size' => $args['icon_size'],
            'class'     => genzia_nice_class($icon_classes),
            'echo'      => false
        ]);
    ob_start();
    printf('%s', $args['before']);
?>
    <div class="<?php echo implode(' ', array_filter($classes)); ?>" data-modal="#cms-modal-search" data-focus=".cms-search-field" data-modal-mode="<?php echo esc_attr($args['modal-mode']); ?>" data-modal-slide="<?php echo esc_attr($args['modal-slide']); ?>" data-modal-class="<?php echo esc_attr($args['modal-class']); ?>" <?php if(!empty($args['placeholder'])): ?>data-modal-placeholder="<?php echo esc_attr($args['placeholder']); ?>"<?php endif; ?> data-modal-width="<?php echo esc_attr($args['modal-width']) ?>" data-modal-space="<?php echo esc_attr($args['modal-space']); ?>" data-overlay-class="<?php echo esc_attr($args['modal-overlay-class']); ?>" data-classes='<?php echo wp_json_encode($args['data']); ?>'><?php  
            printf('%1$s%2$s', $search_icon, $args['text']); 
        ?></div>
<?php
    printf('%s', $args['after']);
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
/**
 * Header Search Popup
 */
function genzia_search_popup($args = []){
    $args = wp_parse_args($args, [
        'text'        => '<span class="close-text text-15 text-uppercase">'.esc_html__('Close','genzia').'</span>',
        'icon'        => genzia_svgs_icon(['icon' => 'core/close', 'echo' => false, 'icon_size' => 16]),
        'placeholder' => esc_html__('Type your search','genzia'),
        'btn_class'   => 'cms-header-search-form-btn btn text-20 text-white absolute top-left',
        'btn_text'    => esc_html__('Search','genzia'),
        'btn_icon'    => get_parent_theme_file_path() . '/assets/svgs/core/search.svg',
        'default_class' => 'd-flex flex-nowrap justify-content-between gap-20 flex-nowrap bg-white',
        'custom_class'  => 'bg-white'
    ]); 
    $placeholder               = genzia_get_opt('search_field_placeholder', esc_html__('Search', 'genzia'));
    $search_on                 = genzia_get_opts( 'search_icon', 'no' ); 
    $search_on_content         = genzia_get_opts('search_on_content', '_1');
    $search_on_content_content = genzia_get_opts('search_on_content_content', '_1');
    if($search_on == 'no') return;

    $wraps_classes     = [
        'cms-modal-html cms-modal-search', 
        'cms-transition'
    ];
    if($search_on_content != 'custom'){
        $container_classes[] = 'container';
    } else {
        $wraps_classes[] = 'cms-mousewheel';
    }
    // Search Form
    $header_searform_style = [
        '--cms-form-field-color:var(--cms-menu)',
        '--cms-form-field-height:46px',
        '--cms-form-field-border:none',
        '--cms-form-field-radius:none',
        '--cms-form-field-border-width:0',
        '--cms-form-field-border-color:var(--cms-accent)',
        '--cms-form-field-border-style:solid',
        '--cms-form-field-border-hover:none',
        '--cms-form-field-border:0 0 0 0 transparent inset',
        '--cms-form-field-padding-start:40px',
        '--cms-placeholder-color:var(--cms-body)',
        '--cms-placeholder-weight:400',
        '--cms-form-field-bg-color:transparent;',
        '--cms-form-field-bg-hover-color:transparent;',
        '--cms-form-field-border-width:0;',
        '--cms-form-field-border-width-hover:0;',
        // button
        '--cms-btn-padding:0',
        '--cms-form-btn-height:40px',
        '--cms-form-btn-color:var(--cms-menu)',
        '--cms-form-btn-bg:none',
        '--cms-form-btn-bg-hover:none',
        '--cms-form-btn-text-color:var(--cms-accent-regular)',
        '--cms-form-btn-text-color-hover:var(--cms-accent-regular)',
    ];
    ob_start();
    ?>
        <form method="get" class="cms-header-search-form d-flex align-items-center relative" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="<?php echo implode(';', $header_searform_style); ?>">
            <button type="submit" class="<?php echo esc_attr($args['btn_class']); ?>" data-title="<?php echo esc_attr($args['btn_text']) ?>"><?php include $args['btn_icon']; 
            ?></button>
            <input type="text" name="s" class="cms-search-field" placeholder="<?php echo esc_attr( $args['placeholder'] );?>"/>
        </form>
    <?php $search_form = ob_get_clean();
        switch ($search_on_content) {
        case 'custom':
        $wraps_classes[] = $args['custom_class'];
    ?>
        <div id="cms-modal-search" class="<?php echo genzia_nice_class($wraps_classes); ?>">
            <div class="cms-modal--content">
                <?php
                    printf('%s', \Elementor\Plugin::$instance->frontend->get_builder_content( $search_on_content_content )); 
                ?>
            </div>
            <span class="cms-modal--close cms-close absolute top right pt-40 pr-40 d-flex gap-10 align-items-center">
                <?php 
                    // text
                    printf('%1$s%2$s',$args['text'], $args['icon']);
                ?>
            </span>
        </div>
    <?php
            break;
        default :
        $wraps_classes[] = $args['default_class'];
    ?>
        <div id="cms-modal-search" class="<?php echo genzia_nice_class($wraps_classes); ?>">
            <div class="cms-modal--content flex-basic">
                <?php printf('%s', $search_form);?>
            </div>
            <span class="cms-modal--close cms-close d-flex align-items-center"><span class="text-menu text-hover-error text-20 lh-0 cms-box-46">
                <?php 
                    // text
                    printf('%1$s', $args['icon']);
                ?>
            </span></span>
        </div>
    <?php 
            break;
    }
}
/**
 * Header Search Plain
 * 
 * */
if(!function_exists('genzia_header_search_plain')){
    function genzia_header_search_plain($args = []){
        $args = wp_parse_args($args, [
            'class' => ''
        ]);
        $form_style = [
            '--cms-form-field-height:calc(var(--cms-header-height) - 1px)',
            '--cms-form-field-radius:0',
            '--cms-form-field-border-width:0',
            '--cms-form-field-border:none',
            '--cms-form-field-border-hover:none',
            '--cms-form-field-padding-start:60px',
            '--cms-form-btn-height:80px',
            '--cms-btn-padding:0',
            '--cms-form-btn-color:var(--cms-body-color)',
            '--cms-form-btn-bg:transparent',
            '--cms-form-btn-color-hover:var(--cms-body-color)',
            '--cms-form-btn-bg-hover:transparent',
        ];
    $classes = genzia_nice_class([
        'cms-search-plain relative',
        $args['class']
    ]);
?>
    <form method="get" class="<?php echo esc_attr($classes); ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="<?php echo implode(';', $form_style); ?>">
        <input type="text" name="s" class="cms-search-plain-input" placeholder="<?php echo esc_attr__('Search','genzia');?>"/>
        <button type="submit" class="cms-search-plain-btn btn absolute top-left box-80" data-title="<?php echo esc_attr__('Search','genzia');?>"><?php
            genzia_svgs_icon([
                'icon'      => 'core/search',
                'icon_size' => 20
            ]);
        ?></button>
    </form>
<?php
    }
}
/**
 * Header Search Toggle
 * 
 * */
if(!function_exists('genzia_header_search_toggle')){
    function genzia_header_search_toggle($args = []){
        $args = wp_parse_args($args, [
            'class' => '',
            'icon'        => 'core/search',
            'icon_size'   => 20,
            'icon_class'  => '',
        ]);
        $form_style = [
            '--cms-form-field-height:60px',
            //'--cms-form-field-radius:0',
            //'--cms-form-field-border-width:0',
            //'--cms-form-field-border:none',
            //'--cms-form-field-border-hover:none',
            '--cms-form-field-padding-start:50px',
            '--cms-form-btn-height:60px',
            '--cms-btn-padding:0',
            '--cms-form-btn-color:var(--cms-menu)',
            '--cms-form-btn-bg:transparent',
            '--cms-form-btn-color-hover:var(--cms-accent-regular)',
            '--cms-form-btn-bg-hover:transparent',
        ];
        $search_on = genzia_get_opts('search_icon', 'off', 'header_custom');
        if($search_on != 'on') return;
        $classes = genzia_nice_class([
            'cms-search-toggle',
            'relative',
            $args['class']
        ]);
        //
        $icon_classes = ['header-icon cms-toggle', 'text-'.$args['icon_size'], $args['icon_class']];
        // Search icon 
        $search_icon = genzia_svgs_icon([
            'icon'      => $args['icon'],
            'icon_size' => $args['icon_size'],
            'class'     => genzia_nice_class($icon_classes),
            'echo'      => false,
            'attrs'     => [
                'data-toggle' => '#cms-toggle-search',
                'data-focus' => '.cms-search-field'
            ],
            'before' => '<div class="cms-header-change site-header-search d-flex">',
            'after'  => '</div>'
        ]);
        $placeholder               = genzia_get_opt('search_field_placeholder', esc_html__('Search', 'genzia'));
        printf('%s', $search_icon);
?>
    <div id="cms-toggle-search" class="cms-toggle-content cms-toggle-search absolute right cms-transition">
        <form method="get" class="<?php echo esc_attr($classes); ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="<?php echo implode(';', $form_style); ?>">
            <input type="text" name="s" class="cms-search-field" placeholder="<?php echo esc_attr($placeholder);?>"/>
            <button type="submit" class="cms-search-plain-btn absolute top-left cms-box-60" data-title="<?php echo esc_attr__('Search','genzia');?>"><?php
                genzia_svgs_icon([
                    'icon'      => 'core/search',
                    'icon_size' => $args['icon_size']
                ]);
            ?></button>
        </form>
        <?php genzia_svgs_icon([
            'icon'      => 'core/close',
            'icon_size' => $args['icon_size'],
            'class'     => 'cms-toggle-close absolute top right cms-box-60 text-error',
            'echo'      => true,
            'attrs'     => [
                'data-toggle' => '#cms-toggle-search'
            ]
        ]); ?>
    </div>
<?php
    }
}
/**
 * Header Cart
 * 
 * */
if(!function_exists('genzia_header_cart')){
    function genzia_header_cart($args = []){
        $args = wp_parse_args($args, [
            'layout'     => 1, 
            'class'      => 'menu-color',
            'echo'       => true,
            'icon'       => 'core/cart',
            'icon_size'  => 20,
            'icon_class' => '',
            'text'       => '', 
            'position'   => 'dropdown', // dropdown, modal
            'offset'     => '0',
            'data'                => [
                'default_class'     => [],
                'sticky_class'      => [],
                'transparent_class' => []
            ],
            'data_icon'                => [
                'default_class'     => [],
                'sticky_class'      => [],
                'transparent_class' => []
            ]   
        ]);
        $args['data'] = wp_parse_args($args['data'], [
            'default_class'     => [],
            'sticky_class'      => [],
            'transparent_class' => []
        ]);
        $args['data_icon'] = wp_parse_args($args['data_icon'], [
            'default_class'     => [],
            'sticky_class'      => [],
            'transparent_class' => []
        ]);
        $cart_on = genzia_get_opts('cart_icon', 'off', 'header_custom');
        // fix show cart icon on single product page without theme option
        if(is_singular('product')) $cart_on = 'on';
        //
        if(!class_exists('Woocommerce') || $cart_on != 'on') return;
        $classes  =['cms-header-change','site-header-item site-header-cart lh-1', $args['class']];

        switch ($args['position']) {
            case 'modal':
                $classes[] = 'cms-modal';
                add_action('wp_footer', 'genzia_cart_content');
                break;
            
            default:
                $classes[] = 'relative cms-touchedside';
                add_action('genzia_cart_dropdown', 'genzia_cart_content_dropdown');
                break;
        }
        $icon_classes = ['cms-header-change','header-icon cart-icon', 'text-'.$args['icon_size'], $args['icon_class']];
        $cart_counter_classes = ['cart-counter cart_total'];
        
        $cart_icon = genzia_svgs_icon([
            'icon'      => $args['icon'],
            'icon_size' => $args['icon_size'],
            'class'     => genzia_nice_class($icon_classes), 
            'echo'      => false,
            'attrs'     => [
                'data-classes' => wp_json_encode($args['data_icon'])
            ]
        ]);
    ob_start();
?>
    <div class="<?php  echo implode(' ', array_filter($classes)); ?>" data-dropdown-offset="<?php echo esc_attr($args['offset']) ?>" data-modal="#cms-modal-cart" data-modal-mode="slide" data-modal-slide="right" data-modal-class="bg-white" data-classes='<?php echo wp_json_encode($args['data']); ?>'>
        <?php 
        switch ($args['layout']) {
            case '1':
                printf('%s', $args['text']); 
            ?>
                <div class="cms-cart-icon cms-counter-icon relative">
                    <?php printf('%s', $cart_icon); ?>
                    <span class="cms-count">
                        <span class="<?php echo genzia_nice_class($cart_counter_classes); ?>" data-count="<?php echo WC()->cart->cart_contents_count; ?>">
                            <?php 
                                echo sprintf( _n( '%d', '%d', WC()->cart->cart_contents_count, 'genzia' ), WC()->cart->cart_contents_count ); 
                            ?>
                        </span>
                    </span>
                </div>
            <?php
                break;
            case '2':
            ?>
                <span class="text-15 text-uppercase d-flex gap-5 align-items-center cms-cart-icon cms-counter-icon relative">
                    <?php printf('%1$s', $cart_icon); ?>
                    <span class="cms-count cms-hidden-desktop-menu">
                        <span class="<?php echo genzia_nice_class($cart_counter_classes); ?>" data-count="<?php echo WC()->cart->cart_contents_count; ?>">
                            <?php 
                                echo sprintf( _n( '%d', '%d', WC()->cart->cart_contents_count, 'genzia' ), WC()->cart->cart_contents_count ); 
                            ?>
                        </span>
                    </span>
                    <span class="cms-hidden-mobile-menu">
                        <?php printf('%1$s', $args['text']); ?> 
                        (<span class="<?php echo genzia_nice_class($cart_counter_classes); ?>" data-count="<?php echo WC()->cart->cart_contents_count; ?>"><?php 
                            echo sprintf( _n( '%d', '%d', WC()->cart->cart_contents_count, 'genzia' ), WC()->cart->cart_contents_count ); 
                        ?></span>)
                    </span>
            <?php
                break;
            case '3':
                printf('%s', $args['text']); 
            ?>
                <div class="cms-cart-icon cms-counter-icon relative">
                    <?php printf('%s', $cart_icon); ?>
                    <span class="<?php echo genzia_nice_class($cart_counter_classes); ?>" data-count="<?php echo WC()->cart->cart_contents_count; ?>">
                        <?php 
                            echo sprintf( _n( '%d', '%d', WC()->cart->cart_contents_count, 'genzia' ), WC()->cart->cart_contents_count ); 
                        ?>
                    </span>
                </div>
            <?php
                break;
        }
        ?>
        <?php do_action('genzia_cart_dropdown'); ?>
    </div>
<?php
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
/**
 * Header Cart
 * Update cart count
 * 
 * */
if(!function_exists('genzia_woocommerce_add_to_cart_fragments')){
    add_filter('woocommerce_add_to_cart_fragments', 'genzia_woocommerce_add_to_cart_fragments', 10, 1 );
    function genzia_woocommerce_add_to_cart_fragments( $fragments ) {
        if(!class_exists('WooCommerce')) return;
        ob_start();
        ?><span class="cart-counter cart_total" data-count="<?php echo WC()->cart->cart_contents_count;?>">
            <?php echo sprintf( _n( '%d', '%d', WC()->cart->cart_contents_count, 'genzia' ), WC()->cart->cart_contents_count ); ?>
        </span>
        <?php
        $fragments['.cart_total'] = ob_get_clean();
        return $fragments;
    }
}

/**
 * 
 * Cart Content
 * 
 */
function genzia_cart_content(){
    if (!class_exists('Woocommerce')) return;
    ob_start();
        genzia_svgs_icon([
            'icon'      => 'core/close',
            'icon_size' => 16,
            'class'     => 'cms-modal-close cms-close text-menu p-30 p-smobile-20 lh-0'
        ]);
    $close_icon = ob_get_clean();
?>
    <div id="cms-modal-cart" class="cms-modal-html cms-modal-slide cms-modal-cart cms-shadow-1">
        <?php printf('%s', $close_icon); ?>
        <h2 class="cms-cart-title text-size w-100 p-lr-40 p-lr-mobile-20 pt-25" style="--text-size:28px;margin-bottom:-10px;"><?php echo esc_html__('Shopping Cart','genzia'); ?></h2>
        <div class="cms-modal-content">
            <div class="widget_shopping_cart cms-mousewheel cms-mini-cart-modal">
                <div class="widget_shopping_cart_content">
                    <?php  woocommerce_mini_cart(); ?>
                </div>
            </div>
        </div>
    </div>
<?php
}

function genzia_cart_content_dropdown(){
    if (!class_exists('Woocommerce')) return;
?>
    <div class="cms-header-cart-dropdown cms--touchedside overflow-hidden">
        <div class="widget_shopping_cart cms-mousewheel">
            <div class="widget_shopping_cart_content"><?php 
                woocommerce_mini_cart(); 
            ?></div>
        </div>
    </div>
<?php
}

/**
 * Header Phone
 * */
if(!function_exists('genzia_header_phone_render')){
    function genzia_header_phone_render($args = []){
        $args = wp_parse_args($args, [
            'name'      => '',
            'class'     => '',
            'icon'      => 'core/phone',
            'icon_size' => 20,
            'icon_class' => '',
            'data'      => [
                'default'     => '',
                'transparent' => ''
            ],
            'text_wrap_class' => '',
            'text_class'      => 'text-md text-primary-regular',
            'phone_class'     => 'text-lg menu-color'
        ]);
        $phone_text = genzia_get_opt('h_phone'.$args['name'].'_text', '');
        $phone_number = genzia_get_opt('h_phone'.$args['name'].'_number', '');
        if(genzia_get_opts('h_phone'.$args['name'].'_on', 'off', 'header_custom') !== 'on' || empty($phone_number) ) return;
        $tel = str_ireplace(' ', '', $phone_number); // remove space for link
        // phone icon
        $icon_classes = ['phone-icon', 'phone-icon-outline', 'cms-ripple', 'text-'.$args['icon_size'], $args['icon_class'], 'bg-on-hover-accent-regular text-white text-hover-white text-on-hover-white cms-transition'];
        $phone_icon = genzia_svgs_icon([
            'icon'        => $args['icon'], 
            'icon_size'   => $args['icon_size'], 
            'class'       => genzia_nice_class($icon_classes), 
            'echo'        => false,
            'before_icon' => '<span class="cms--ripple"></span>'    
        ]);
        // 
        $classes = ['site-header-item', 'site-header-phone', 'd-flex gap-15', $args['class'], 'cms-hover-change'];
    ?>
        <a class="<?php echo genzia_nice_class($classes); ?>" data-classes='<?php echo wp_json_encode($args['data']); ?>' href="tel:<?php echo esc_attr($tel);?>"><?php 
            if(!empty($args['icon'])) printf('%s', $phone_icon);
            printf('<div class="cms-hidden-mobile-menu lh-1 '.$args['text_wrap_class'].'"><div class="phone-text %s">%s</div><div class="phone-number %s">%s</div></div>', $args['text_class'],$phone_text, $args['phone_class'], $phone_number);
        ?></a>
    <?php
    }
}
if(!function_exists('genzia_header_phone_render2')){
    function genzia_header_phone_render2($args = []){
        $args = wp_parse_args($args, [
            'name'      => '',
            'class'     => 'menu-color',
            'icon'      => 'core/phone',
            'icon_size' => 20,
            'icon_class' => '',
            'data'      => [
                'default'     => '',
                'transparent' => ''
            ],
            'text_wrap_class' => '',
            'text_class'      => 'text-md',
            'phone_class'     => 'text-md font-700'
        ]);
        $phone_text = genzia_get_opt('h_phone'.$args['name'].'_text', '');
        $phone_number = genzia_get_opt('h_phone'.$args['name'].'_number', '');
        if(genzia_get_opts('h_phone'.$args['name'].'_on', 'off', 'header_custom') !== 'on' || empty($phone_number) ) return;
        $tel = str_ireplace(' ', '', $phone_number); // remove space for link
        // phone icon
        $icon_classes = ['phone-icon', $args['icon_class']];
        $phone_icon = genzia_svgs_icon([
            'icon'        => $args['icon'], 
            'icon_size'   => $args['icon_size'], 
            'class'       => genzia_nice_class($icon_classes), 
            'echo'        => false,   
        ]);
        // 
        $classes = ['site-header-item', 'site-header-phone', 'd-flex gap-10', $args['class']];
    ?>
        <a class="<?php echo genzia_nice_class($classes); ?>" data-classes='<?php echo wp_json_encode($args['data']); ?>' href="tel:<?php echo esc_attr($tel);?>"><?php 
            if(!empty($args['icon'])) printf('%s', $phone_icon);
            printf('<div class="cms-hidden-mobile-menu lh-1 '.$args['text_wrap_class'].'"><div class="phone-number %s">%s</div></div>', $args['phone_class'], $phone_number);
        ?></a>
    <?php
    }
}
/**
 * Header Mail
 * */
if(!function_exists('genzia_header_mail_render')){
    function genzia_header_mail_render($args = []){
        $args = wp_parse_args($args, [
            'name'      => '',
            'class'     => '',
            'icon'      => 'core/email',
            'icon_size' => 20,
            'icon_class'=> ''
        ]);
        $email_text = genzia_get_opt('h_mail'.$args['name'].'_text', '');

        if(genzia_get_opts('h_mail'.$args['name'].'_on', 'off', 'header_custom') !== 'on' || empty($email_text) ) return;

        $classes = ['site-header-item d-flex gap-15 align-items-center', $args['class'], 'cms-hover-change'];
        // mail icon
        $icon_classes = genzia_nice_class(['site-header-item mail-icon', 'phone-icon-outline', 'cms-ripple', 'bg-hover-accent text-white text-hover-white bg-on-hover-accent-regular text-on-hover-white cms-transition', $args['icon_class']]);
        $mail_icon    = genzia_svgs_icon([
            'icon'        => $args['icon'],
            'icon_size'   => $args['icon_size'],
            'class'       => genzia_nice_class($icon_classes), 
            'echo'        => false,
            'before_icon' => '<span class="cms--ripple"></span>'
        ]);
    ?>
        <a class="<?php echo implode(' ', array_filter($classes)); ?>" href="mailto:<?php echo esc_attr($email_text);?>" aria-label="<?php echo esc_attr($email_text); ?>"><?php 
            if(!empty($args['icon'])) printf('%s', $mail_icon);
            printf('%s', '<span class="cms-hidden-mobile-menu">'.$email_text.'</span>');
        ?></a>
    <?php
    }
}
/**
 * Header Button
 * */
if(!function_exists('genzia_header_button_render')){
    function genzia_header_button_render($args = []){
        $args = wp_parse_args($args, [
            'name'        => 'h_btn',
            'class'       => 'btn',
            'icon'        => '',
            'icon_mobile' => '',
            'icon_size'   => 10,
            'icon_class'  => '',
            'data'        => [
                'default_class'     => [],
                'transparent_class' => [],
                'sticky_class'      => []
            ],
            'icon_data'        => [
                'default_class'     => [],
                'transparent_class' => [],
                'sticky_class'      => []
            ],
            'style'  => '',
            'before' => '',
            'after'  => '',
            //
            'text_class'  => 'cms-hidden-mobile-menu' 
        ]);
        $args_data = wp_parse_args($args['data'],[
            'default_class'     => [],
            'transparent_class' => [],
            'sticky_class'      => []
        ]);
        $show_button = genzia_get_opts($args['name'].'_on', 'off', 'header_custom');
        $h_btn_text = genzia_get_opts( $args['name'].'_text', '', $args['name'].'_on' );
        
        if($show_button !== 'on' || empty($h_btn_text)) return;

        $h_btn_link_type   = genzia_get_opts( $args['name'].'_link_type', 'page' , $args['name'].'_on');
        $h_btn_link        = genzia_get_opts( $args['name'].'_link', '', $args['name'].'_on' );
        $h_btn_link_custom = genzia_get_opts( $args['name'].'_link_custom', '#', $args['name'].'_on' );
        $h_btn_target      = genzia_get_opts( $args['name'].'_target', '_self' , $args['name'].'_on');
        if ( $h_btn_link_type == 'page' ) {
            $h_btn_url = get_permalink( $h_btn_link );
        } else {
            $h_btn_url = $h_btn_link_custom;
        }

        $attrs = [
            'class'        => $args['class'],
            'data-classes' => $args['data'],
            'style'        => $args['style'] 
        ];
        // icon
        $icon_classes = implode(' ',['cms-hidden-mobile-menu', $args['icon_class']]);
        $icon_mobile_classes = implode(' ',['cms-hidden-desktop-menu', $args['icon_class']]);
        $args['icon_mobile'] = !empty($args['icon_mobile']) ? $args['icon_mobile'] : $args['icon'];
        $icon = !empty($args['icon']) ? genzia_svgs_icon(['icon' => $args['icon'], 'class' => $icon_classes, 'icon_size' => $args['icon_size'], 'echo' => false, 'icon_data' => $args['icon_data']]) : '';
        $icon_mobile = !empty($args['icon_mobile']) ? genzia_svgs_icon(['icon' => $args['icon_mobile'], 'class' => $icon_mobile_classes,'icon_size' => $args['icon_size'], 'echo' => false, 'icon_data' => $args['icon_data']]) : '';

        $icons = $icon.$icon_mobile;

        printf('%s', $args['before']);
    ?>
        <a class="cms-header-change h-btn <?php echo esc_attr($attrs['class']); ?>" data-classes='<?php echo wp_json_encode($args_data); ?>' href="<?php echo esc_url( $h_btn_url ); ?>" target="<?php echo esc_attr( $h_btn_target ); ?>" style="<?php echo esc_attr($attrs['style']) ?>">
            <?php printf( '<span class="h-btn-text '.$args['text_class'].'">%1$s</span>%2$s', $h_btn_text, $icons ); ?>
            <span class="screen-reader-text"><?php echo esc_html($h_btn_text); ?></span> 
        </a>
    <?php
    printf('%s', $args['after']);
    }
}

/***
 * Header Wishlist
 */
if(!function_exists('genzia_is_wishlist_page')){
    function genzia_is_wishlist_page(){
        if(!class_exists('WPCleverWoosw')) {
            return false;
        } else {
            $woosw_settings = wp_parse_args(get_option('woosw_settings'), [
                'page_id' => ''
            ]); 
            $wpcsw_page   = $woosw_settings['page_id']; // Wishlist page
            $current_page = get_the_ID(); // current page
            if(!empty($wpcsw_page) && $wpcsw_page == $current_page){
                return true;
            } else {
                return false;
            }
        }
    }
}
if(!function_exists('genzia_header_wishlist')){
    function genzia_header_wishlist($args=[]){
        if(!class_exists('WPCleverWoosw')) return;
        $args = wp_parse_args($args,[
            'name'           => '',
            'class'          => '',
            'text'           => '',
            'icon'           => 'core/heart-alt',
            'icon_size'      => 20,
            'icon_class'     => '',   
            'before'         => '',
            'after'          => '',
            'link_class'     => 'menu-color',
            'count_color'    => '',
            'count_bg_color' => '',
            'data'                => [
                'default_class'     => [],
                'sticky_class'      => [],
                'transparent_class' => []
            ]
        ]);
        $args['data'] = wp_parse_args($args['data'], [
            'default_class'     => [],
            'sticky_class'      => [],
            'transparent_class' => []
        ]);

        if(genzia_get_opts('h_wishlist'.$args['name'].'_on', 'off', 'header_custom') !== 'on') return;
        $css_class = ['cms-header-wishlist relative', $args['class']];
        if(!genzia_is_wishlist_page()) {
            $css_class[] = 'woosw-menu';
            $url = WPCleverWoosw::get_url();
        } else {
            $url = '#';
        }
        $link_classes = ['cms-wishlist relative cms-counter-icon', $args['class'], $args['link_class']];
        $count_classes = ['header-count wishlist-count cms-count', $args['count_color'], $args['count_bg_color']];
        $icon_classes = ['wishlist-icon header-icon', 'text-'.$args['icon_size'], 'lh-0', 'd-flex', $args['icon_class']];
        printf('%s', $args['before']);
    ?>
        <a class="<?php echo genzia_nice_class($link_classes); ?>" href="<?php echo esc_url( $url ); ?>" data-classes='<?php echo wp_json_encode($args['data']); ?>'>
            <?php 
                // text
                printf('%s', $args['text']); 
                // icon
                genzia_svgs_icon(['icon' => $args['icon'], 'class' => genzia_nice_class($icon_classes), 'attrs' => ['data-count' => WPcleverWoosw::get_count()]]);
            ?>
            <span class="<?php echo genzia_nice_class($count_classes); ?>"><?php echo WPcleverWoosw::get_count(); ?></span>
        </a>
    <?php
        printf('%s', $args['after']);
    }
}
// Header Compare
if(!function_exists('genzia_header_compare')){
    function genzia_header_compare($args=[]){
        if(!class_exists('WPCleverWoosc')) return;
        $args = wp_parse_args($args,[
            'name'           => '',
            'class'          => '',
            'text'           => '',
            'icon'           => 'core/compare',
            'icon_size'      => 20,  
            'icon_class'     => '',
            'before'         => '',
            'after'          => '',
            'count_color'    => '',
            'count_bg_color' => '',
            'link_class'     => 'menu-color',
            'data'                => [
                'default_class'     => [],
                'sticky_class'      => [],
                'transparent_class' => []
            ]
        ]);
        $args['data'] = wp_parse_args($args['data'], [
            'default_class'     => [],
            'sticky_class'      => [],
            'transparent_class' => []
        ]);

        if(genzia_get_opts('h_compare'.$args['name'].'_on', 'off', 'header_custom') !== 'on') return;

        $css_class = ['cms-header-compare woosc-menu relative', $args['class']];
        $count_classes = ['header-count compare-count cms-count', $args['count_color'], $args['count_bg_color']];
        $icon_classes = ['compare-icon header-icon', 'text-'.$args['icon_size'], $args['icon_class']];
        $link_classes = genzia_nice_class(['cms-compare cms-counter-icon', $args['link_class']]);

        printf('%s', $args['before']);
    ?>
        <div class="<?php echo genzia_nice_class($css_class); ?>" data-classes='<?php echo wp_json_encode($args['data']); ?>'>
            <a class="<?php echo esc_attr($link_classes); ?>" href="<?php echo esc_url( WPcleverWoosc::get_url() ); ?>">
                <?php 
                    // text
                    printf('%s', $args['text']);
                    // icon
                    genzia_svgs_icon(['icon' => $args['icon'], 'class' => genzia_nice_class($icon_classes), 'attrs' => ['data-count' => WPcleverWoosc::get_count()]]);
                ?>
                <span class="<?php echo genzia_nice_class($count_classes); ?>"><?php echo WPcleverWoosc::get_count(); ?></span>
            </a>
        </div>
    <?php
        printf('%s', $args['after']);
    }
}
// Header Currency Switch
if(!function_exists('genzia_header_woocs')){
    function genzia_header_woocs($args = []){
        if(!class_exists('WOOCS_STARTER')) return;
        $args = wp_parse_args($args, [
            'name'             => '',
            'before'           => '',
            'after'            => '',
            'class'            => '',
            'item_class'       => '',
            'link_class'       => 'menu-color',
            'sub_link_class'   => '',           
            'show_flags'       => 'no',
            'show_money_signs' => 'no',
            'show_text'        => 'yes',
            'text_as'          => 'description', // value: name / description
        ]);
        if(genzia_get_opts('h_woocs'.$args['name'].'_on', 'off', 'header_custom') !== 'on') return;

        printf('%s', $args['before']);
            genzia_woocs_currency_switcher([
                'class'            => $args['class'],
                'item_class'       => $args['item_class'],
                'link_class'       => $args['link_class'],
                'sub_link_class'   => $args['sub_link_class'],           
                'show_flags'       => $args['show_flags'],
                'show_money_signs' => $args['show_money_signs'],
                'show_text'        => $args['show_text'],
                'text_as'          => $args['text_as'],
            ]);
        printf('%s', $args['after']);
    }
}
// Header Login 
if(!function_exists('genzia_header_login')){
    function genzia_header_login($args=[]){
        if(!function_exists('cshlg_link_to_login')) return;
        $args = wp_parse_args($args, [
            'name'                => '',
            'class'               => '',
            'icon'                => 'core/user',
            'icon_class'          => '',
            'icon_size'           => 18,
            'icon_mobile'         => '',
            'icon_mobile_class'   => '',
            'before'              => '',
            'after'               => '',
            'link_class'          => 'menu-color',
            'show_text'           => true,
            'login_text'          => '',
            'loggedin_text'       => '',
            'text_class'          => 'cms-hidden-mobile-menu',
            'modal-mode'          => 'fade',
            'modal-slide'         => 'center',
            'modal-class'         => 'center bg-white cms-radius-20',
            'modal-width'         => '400px',
            'modal-content-width' => '400px',
            'modal-space'         => '50px',
            //
            'data'                => [
                'default_class'     => [],
                'sticky_class'      => [],
                'transparent_class' => []
            ],
            'text_data' => [
                'default_class'     => [],
                'sticky_class'      => [],
                'transparent_class' => []
            ]
        ]);
        $args['icon_mobile'] = !empty($args['icon_mobile']) ? $args['icon_mobile'] : $args['icon'];
        //
        $args_data = wp_parse_args($args['data'],[
            'default_class'     => [],
            'sticky_class'      => [],
            'transparent_class' => []
        ]);
        $args_text_data = wp_parse_args($args['text_data'],[
            'default_class'     => [],
            'sticky_class'      => [],
            'transparent_class' => []
        ]);
        if(genzia_get_opts('h_login'.$args['name'].'_on', 'off', 'header_custom') !== 'on') return;
        $css_class = [];
        $link_classes = [
            'cms-header-change',
            'site-header-login site-header-item', 
            $args['class'],
            $args['link_class'],
            'header-icon'
        ];

        if(is_user_logged_in()) {
            $text = $args['loggedin_text'];
            if(class_exists('WooCommerce')){
                $url = get_permalink( get_option('woocommerce_myaccount_page_id') );
            } else {
                $url = get_edit_user_link();
            }
            $link_classes[] = '';
        } else {
            $text = $args['login_text'];
            $url = '#csh-login-wrap';
            $link_classes[] = 'cms-modal';
            //$link_classes[] = 'go_to_login_link';
        }
        $icon_classes = ['text-'.$args['icon_size'], $args['icon_class'], 'cms-hidden-mobile-menu'];
        $icon_mobile_classes = ['text-'.$args['icon_size'], $args['icon_mobile_class'], 'cms-hidden-desktop-menu'];
        //
        printf('%s', $args['before']);
    ?>
        <a href="<?php echo esc_url($url); ?>" class="<?php echo genzia_nice_class($link_classes);?>" data-modal="<?php echo esc_url($url); ?>" data-modal-mode="<?php echo esc_attr($args['modal-mode']) ?>" data-modal-class="<?php echo esc_attr($args['modal-class']) ?>" data-modal-slide="<?php echo esc_attr($args['modal-slide']) ?>" data-modal-width=<?php echo esc_attr($args['modal-width']); ?> data-modal-content-width="<?php echo esc_attr($args['modal-content-width']); ?>" data-modal-space="<?php echo esc_attr($args['modal-space']); ?>" data-classes='<?php echo wp_json_encode($args_data); ?>' aria-label="<?php esc_attr_e('Login','genzia'); ?>">
            <span class="screen-reader-text"><?php esc_html_e('Login','genzia'); ?></span>
            <?php 
            // text
            if(!empty($text)): ?><span class="<?php echo esc_attr($args['text_class']); ?>" data-classes=<?php echo wp_json_encode($args_text_data); ?>><?php printf('%s', $text);?></span><?php 
            endif;
            // icon
            genzia_svgs_icon(['icon' => $args['icon'], 'icon_size' => $args['icon_size'], 'class' => genzia_nice_class($icon_classes) ]);
            // icon mobile
            genzia_svgs_icon(['icon' => $args['icon_mobile'], 'icon_size' => $args['icon_size'], 'class' => genzia_nice_class($icon_mobile_classes) ]);
            ?>
        </a>
    <?php
        printf('%s', $args['after']);
    }
}
/**
 * Language Switcher
*/
if(!function_exists('genzia_header_language_switcher')){
    function genzia_header_language_switcher($args = []){
        if(!class_exists('TRP_Translate_Press')) return;
        $args = wp_parse_args($args, [
            'name'           => '',
            'before'         => '',
            'after'          => '',
            'img_size'       => 35,
            // config
            'class'          => '',
            'item_class'     => '',
            'link_class'     => 'menu-color',
            'sub_link_class' => 'text-15 font-400 cms-hover-underline',
            'show_flag'      => 'no',
            'show_name'      => 'yes',
            'name_as'        => 'full', // short
            'data'                => [
                'default_class'     => [],
                'sticky_class'      => [],
                'transparent_class' => []
            ]
        ]);
        if(genzia_get_opts('h_language'.$args['name'].'_on', 'off', 'header_custom') !== 'on') return;
        $args['data'] = wp_parse_args($args['data'], [
            'default_class'     => [],
            'sticky_class'      => [],
            'transparent_class' => []
        ]);
        printf('%s', $args['before']); 
            cms_language_switcher([
                'class'          => $args['class'],
                'item_class'     => $args['item_class'],
                'link_class'     => $args['link_class'],
                'sub_link_class' => $args['sub_link_class'],
                'show_flag'      => $args['show_flag'],
                'show_name'      => $args['show_name'],
                'name_as'        => $args['name_as'],
                'img_size'       => $args['img_size'],
                'data'           => $args['data']
            ]);
        printf('%s', $args['after']);
    }
}
/**
 * Header
 * Side Nav
 * */
if(!function_exists('genzia_header_side_nav_render')){
    function genzia_header_side_nav_render($args = []){
        $hide_sidebar_icon = genzia_get_opts( 'hide_sidebar_icon', 'off', 'header_custom' );
        $header_sidenav_layout = genzia_get_opts('header_sidenav_layout', 'none', 'hide_sidebar_icon');
        if ( in_array($header_sidenav_layout, ['-1', '0', 'none', '']) || $hide_sidebar_icon != 'on' || !apply_filters('genzia_enable_sidenav', false) ) return;
        $args = wp_parse_args($args, [
            'class'               => '',
            'modal-mode'          => 'slide', // fade
            'modal-slide'         => 'right', // left/right/up/down/zoom-in
            'modal-width'         => '416px',
            'modal-content-width' => '100%',
            'modal-space'         => 0,
            'modal-class'         => 'bg-white',
            'hide_mobile_nav'     => true, // true/false
            'text'                => '',
            'close-text'          => '',
            'icon_class'          => 'menu-color',
            'icon_size'           => 20,
            'data'                => [
                'default_class'     => [],
                'sticky_class'      => [],
                'transparent_class' => []
            ]
        ]);
        $args['data'] = wp_parse_args($args['data'], [
            'default_class'     => [],
            'sticky_class'      => [],
            'transparent_class' => []
        ]);
        $classes = array_filter(array_unique(['cms-header-change','site-side-navs cms-modal site-header-item', $args['class']]));
        if($args['hide_mobile_nav']){
            $classes[] = 'cms-hidden-mobile-menu';
        }
        $icon_classes = genzia_nice_class(['site-side-nav', $args['icon_class']]);
    ?>
        <div class="<?php echo genzia_nice_class($classes); ?>" data-modal="#cms-side-nav" data-modal-mode="<?php echo esc_attr($args['modal-mode']); ?>" data-modal-slide="<?php echo esc_attr($args['modal-slide']); ?>" data-modal-class="<?php echo esc_attr($args['modal-class']); ?>" data-modal-width="<?php echo esc_attr($args['modal-width']); ?>" data-modal-content-width="<?php echo esc_attr($args['modal-content-width']); ?>" data-modal-space="<?php echo esc_attr($args['modal-space']); ?>" data-close-text="<?php printf('%s', $args['close-text']); ?>" data-classes='<?php echo wp_json_encode($args['data']); ?>'>
            <?php 
                // text
                printf('%s', $args['text']);
                // icon
                genzia_svgs_icon([
                    'icon'      => 'core/side-menu',
                    'icon_size' => $args['icon_size'],
                    'class'     => $icon_classes
                ]);
            ?>
        </div>
    <?php
    }
}
add_action('wp_footer', 'genzia_header_side_nav_content_render');
if(!function_exists('genzia_header_side_nav_content_render')){
    function genzia_header_side_nav_content_render($args = []){
        $hide_sidebar_icon = genzia_get_opts( 'hide_sidebar_icon', 'off', 'header_custom' );
        if ( $hide_sidebar_icon !='on' || !apply_filters('genzia_enable_sidenav', false) ) return;
        $header_sidenav_layout = genzia_get_opts('header_sidenav_layout', 'none', 'hide_sidebar_icon');
        if(in_array($header_sidenav_layout, ['-1', '0', 'none', ''])) return;
        $cms_post = get_post($header_sidenav_layout);
        if (!is_wp_error($cms_post) && $cms_post->ID == $header_sidenav_layout && class_exists('CSH_Theme_Core') && class_exists('\Elementor\Plugin')){
            $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $header_sidenav_layout );
            if(empty($content)){
                $content = $cms_post->post_content;
            }
        } else {
            $content = $cms_post->post_content;
        }
        ?>
            <div id="cms-side-nav" class="cms-modal-html cms-modal-sidenav">
                <span class="cms-modal-close-- absolute top right z-top3 cms-close text-hover-error mt-40 mr-40 mt-mobile-20 mr-mobile-20 cms-transition">
                    <span class="screen-reader-text"><?php esc_html_e('Close','genzia'); ?></span>
                    <?php 
                        genzia_svgs_icon([
                            'icon'      => 'core/close',
                            'icon_size' => 20,
                            'class'     => 'close-icon' 
                        ]);
                    ?>
                </span>
                <div class="cms-modal-content h-100">
                    <div class="cms-sidenav-content cms-mousewheel h-100">
                        <div class="cms-sidenav--content h-100">
                            <?php printf('%s', $content); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
}
/**
 * Header
 * Side Nav
 * Toggle Effect
 * 
 * */
if(!function_exists('genzia_header_side_nav_toggle')){
    function genzia_header_side_nav_toggle($args = []){
        $hide_sidebar_icon = genzia_get_opts( 'hide_sidebar_icon', 'off', 'header_custom' );
        $header_sidenav_layout = genzia_get_opts('header_sidenav_layout', 'none', 'hide_sidebar_icon');
        if ( in_array($header_sidenav_layout, ['-1', '0', 'none', '']) || $hide_sidebar_icon != 'on' || !apply_filters('genzia_enable_sidenav', false) ) return;
        $args = wp_parse_args($args, [
            'class'               => '',
            'hide_mobile_nav'     => true, // true/false
            'text'                => '',
            'close-text'          => '',
            'icon_class'          => 'menu-color',
            'icon_size'           => 20,
            'data'                => [
                'default_class'     => [],
                'sticky_class'      => [],
                'transparent_class' => []
            ]
        ]);
        $args['data'] = wp_parse_args($args['data'], [
            'default_class'     => [],
            'sticky_class'      => [],
            'transparent_class' => []
        ]);
        $classes = array_filter(array_unique(['cms-header-change','site-side-navs site-header-item cms-toggle', $args['class']]));
        if($args['hide_mobile_nav']){
            $classes[] = 'cms-hidden-mobile-menu';
        }
        $icon_classes = genzia_nice_class(['site-side-nav', $args['icon_class']]);
    ?>
        <div class="<?php echo genzia_nice_class($classes); ?>" data-toggle="#cms-side-nav-toggle" data-classes='<?php echo wp_json_encode($args['data']); ?>'>
            <?php 
                // text
                printf('%s', $args['text']);
                // icon
                genzia_svgs_icon([
                    'icon'      => 'core/side-menu',
                    'icon_size' => $args['icon_size'],
                    'class'     => $icon_classes
                ]);
            ?>
        </div>
    <?php
        $header_sidenav_layout = genzia_get_opts('header_sidenav_layout', 'none', 'hide_sidebar_icon');
        if(in_array($header_sidenav_layout, ['-1', '0', 'none', ''])) return;
        $cms_post = get_post($header_sidenav_layout);
        if (!is_wp_error($cms_post) && $cms_post->ID == $header_sidenav_layout && class_exists('CSH_Theme_Core') && class_exists('\Elementor\Plugin')){
            $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $header_sidenav_layout );
            if(empty($content)){
                $content = $cms_post->post_content;
            }
        } else {
            $content = $cms_post->post_content;
        }
    ?>
    <div id="cms-side-nav-toggle" class="cms-toggle-content absolute top right bg-white p-40 p-lr-smobile-0 cms-radius-10 cms-transition min-w" style="--min-w:510px;--min-w-smobile:280px;">
        <?php printf('%s', $content); ?>
        <?php genzia_svgs_icon([
            'icon'      => 'core/close',
            'icon_size' => $args['icon_size'],
            'class'     => 'cms-toggle-close absolute top right cms-box-60 text-error',
            'echo'      => true,
            'attrs'     => [
                'data-toggle' => '#cms-side-nav-toggle'
            ]
        ]); ?>
    </div>
    <?php
    }
}
/**
 * Header
 * Socials
 * 
**/
if(!function_exists('genzia_header_social_render')){
    function genzia_header_social_render($args = []){
        $args = wp_parse_args($args, [
            'before'     => '',
            'after'      => '',
            'icon'       => '',
            'icon_size'  => 20,
            'icon_class' => '',
            'item_class' => '',
            'text_class' => '',
            'show_text'  => true,
            'echo'       => true,
            'before'     => '',
            'after'      => ''
        ]);

        $show_header_socical = genzia_get_opts( 'show_header_social', 'off', 'header_custom' );
        $header_socials = genzia_get_opts('header_socials', []);

        if(empty( $header_socials) || $show_header_socical != 'on') return;
        //
        $icon_class = genzia_nice_class([
            'cms-header-social-icon cms-icon',
            'text-'.$args['icon_size'],
            'lh-0',
            $args['icon_class']
        ]);
        $text_class = genzia_nice_class([
            'cms-hidden-mobile-menu empty-none',
            $args['text_class']
        ]);
        $item_class = genzia_nice_class([
            'd-flex gap-10 align-items-center',
            $args['item_class']
        ]);
        // before
        printf('%s', $args['before']);
        // socials list
        foreach ($header_socials as $key => $social) {
            $icon_mime = substr($social['icon']['url'], -4);
            ob_start();
                switch ($icon_mime) {
                    case '.svg':
                        include get_attached_file($social['icon']['id']);
                    break;
                    
                    default:
                        echo '<img src="'.$social['icon']['url'].'" width="'.$args['icon_size'].'" alt="'.get_bloginfo('name').'" />';
                        break;
                }
            $icon = ob_get_clean();
            if(!empty($social['icon']['url'])){
                $icon_html = $icon;
            } else {
                $icon_html = $social['text'];
            }
            $social_text = $args['show_text'] ?  '<span class="'.$text_class.'">'.$social['text'].'</span>' : '';
            // html
            printf('<a href="%1$s" class="%2$s"><span class="%3$s" style="--svg-size:'.$args['icon_size'].'px;">%4$s</span>%5$s</a>', $social['url'], $item_class, $icon_class, $icon_html, $social_text);
        }
        // after
        printf('%s', $args['after']);
    }
}
/**
 * Header Open Mobile Menu
 * 
 * */
if(!function_exists('genzia_open_mobile_menu')){
    function genzia_open_mobile_menu($args = []){
        $args = wp_parse_args($args, [
            'class'        => 'site-header-item',
            'hide_desktop' => true,
            'text'         => '',
            'icon_class'   => 'menu-color',
            'data'                => [
                'default_class'     => [],
                'sticky_class'      => [],
                'transparent_class' => []
            ]
        ]);
        $args['data'] = wp_parse_args($args['data'], [
            'default_class'     => [],
            'sticky_class'      => [],
            'transparent_class' => []
        ]);

        $classes = [
            'cms-header-change',
            'main-menu-mobile',
            $args['class']
        ];
        if($args['hide_desktop']) $classes[] = 'cms-hidden-desktop-menu';
    ?>
        <div id="main-menu-mobile" class="<?php echo genzia_nice_class($classes); ?>" data-classes='<?php echo wp_json_encode($args['data']); ?>'>
            <?php 
                // text
                printf('%s', $args['text']);
                // icon
                genzia_svgs_icon([
                    'icon'      => 'core/menu',
                    'class'     => 'open-menu d-flex align-items-center '.$args['icon_class'],
                    'icon_size' => 20
                ]);
            ?>
        </div>
    <?php
    }
}
/**
 * Header Tools Classes
 * 
 * */
if(!function_exists('genzia_header_has_tools')){
    function genzia_header_has_tools(){
        $search_on         = genzia_get_opts('search_icon', 'off', 'header_custom');
        $cart_on           = genzia_get_opts('cart_icon', 'off', 'header_custom');
        $social_on         = genzia_get_opts('show_header_social', 'off', 'header_custom');
        $hide_sidebar_icon = genzia_get_opts( 'hide_sidebar_icon', 'off', 'header_custom' );

        $h_btn_text   = genzia_get_opt( 'h_btn_text' );
        $h_btn2_text  = genzia_get_opt( 'h_btn2_text' );
        $h_btn_on = $h_btn2_on = $h_phone_on = 'off';
        if(genzia_get_opts('h_btn_on', 'off', 'header_custom') == 'on' && !empty($h_btn_text)){
            $h_btn_on = 'on';
        }
        if(genzia_get_opts('h_btn2_on', 'off', 'header_custom') == 'on' && !empty($h_btn2_text)){
            $h_btn2_on = 'on';
        };
        if(genzia_get_opts('h_phone_on', 'off', 'header_custom') == 'on' && !empty($phone_number) ){
            $h_phone_on = 'on';
        };
        if($search_on == 'on' || $cart_on == 'on' || $hide_sidebar_icon == 'on' || $social_on == 'on' || $h_btn_on == 'on' || $h_btn2_on == 'on' || $h_phone_on == 'on'){
            return true;
        } else {
            return false;
        }
    }
}
if(!function_exists('genzia_header_tools_classes')){
    function genzia_header_tools_classes($args = []){
        $args = wp_parse_args($args, [
            'class' => ''
        ]);
        $classes = ['site-tools'];
        
        $h_btn_text   = genzia_get_opt( 'h_btn_text' );
        $h_btn2_text  = genzia_get_opt( 'h_btn2_text' );
        $phone_number = genzia_get_opt( 'h_phone_number' );
        $h_btn_on     = $h_btn2_on = $h_phone_on = 'off';
        if(genzia_get_opts('h_btn_on', 'off', 'header_custom') == 'on' && !empty($h_btn_text)){
            $h_btn_on = 'on';
        }
        if(genzia_get_opts('h_btn2_on', 'off', 'header_custom') == 'on' && !empty($h_btn2_text)){
            $h_btn2_on = 'on';
        };
        if(genzia_get_opts('h_phone_on', 'off', 'header_custom') == 'on' && !empty($phone_number) ){
            $h_phone_on = 'on';
        };
        $search_on         = genzia_get_opts('search_icon', 'off', 'header_custom');
        $cart_on           = genzia_get_opts('cart_icon', 'off', 'header_custom');
        $social_on         = genzia_get_opts('show_header_social', 'off', 'header_custom');
        $hide_sidebar_icon = genzia_get_opts( 'hide_sidebar_icon', 'off', 'header_custom' );
        $header_sidenav_layout = genzia_get_opts('header_sidenav_layout', 'none', 'hide_sidebar_icon');
        $show_mobile_nav = ($hide_sidebar_icon == 'off' || ($hide_sidebar_icon == 'on' && !in_array($header_sidenav_layout, ['-1', '0', 'none', ''])) || !apply_filters('genzia_enable_sidenav', false) );

        if(genzia_header_has_tools()){
            $classes[] = 'has-tools';
        } else {
            $classes[] = 'cms-hidden-desktop-menu';
        }
        $classes[] = $args['class'];

        return genzia_nice_class($classes);
    }
}

/**
 * Page title layout
 **/
function genzia_page_title_fixed_layout(){
    if(is_singular(['post', 'product'])){
        $layout = '3';
    } else {
        $layout = genzia_get_opts('ptitle_layout', '', 'custom_ptitle');
    }
    //
    return $layout;
}
function genzia_page_title_layout($args = []){
    // remove page title on some custom post type
    if(is_404() || is_singular(['cms-header-top','cms-footer','cms-mega-menu', 'cms-practice', 'cms-service', 'cms-case', 'cms-career', 'cms-popup']) ) return;
    $header_transparent = '';
    if(genzia_get_opts('header_transparent', 'off', 'header_custom') == 'on'){
        $header_transparent = 'ptitle-header-transparent';
    }

    $args = wp_parse_args($args, [
        'show'      => genzia_get_opts('pagetitle', 'on', 'custom_ptitle'),
        'layout'    => genzia_page_title_fixed_layout(),
        'container' => 'container',
        'class'     => ''
    ]);
    // Configs
    $args['class'] = implode(' ', array_filter([
        'cms-ptitle',
        'cms-ptitle-'.$args['layout'],
        //'cms-lazy',
        'overflow-hidden',
        $header_transparent,
        $args['class']
    ]));
    if($args['show'] === 'off' || $args['layout'] === 'none' ) return;
    //
    get_template_part('template-parts/page-title', $args['layout'], $args);
}
/**
 * Get page title and description.
 *
 * @return array Contains 'title'
 */
function genzia_get_page_titles(){
    $title = '';
    // Default titles
    if (!is_archive()) {
        // Posts page view
        if (is_home()) {
            // Only available if posts page is set.
            if (
                !is_front_page() &&
                ($page_for_posts = get_option('page_for_posts'))
            ) {
                $title = get_post_meta($page_for_posts, 'ptitle_custom', true);
                if (empty($title)) {
                    $title = get_the_title($page_for_posts);
                }
            }
            if (is_front_page()) {
                $title = esc_html__('Blog', 'genzia');
            }
        }
        // Single page view
        elseif (is_page()) {
            $title = get_post_meta(get_the_ID(), 'ptitle_custom', true);
            if (!$title) {
                $title = get_the_title();
            }
        } elseif (is_404()) {
            $title = esc_html__('404', 'genzia');
        } elseif (is_search()) {
            $title = esc_html__('Search results', 'genzia');
        } else {
            $title = get_post_meta(get_the_ID(), 'ptitle_custom', true);
            if (!$title) {
                $title = get_the_title();
            }
        }
    } elseif (is_author()) {
        $title = esc_html__('Author:', 'genzia') . ' ' . get_the_author();
    }
    // Author
    else {
        $title = get_the_archive_title();
        if (class_exists('WooCommerce') && is_shop()) {
            $title = get_post_meta(wc_get_page_id('shop'), 'ptitle_custom', true);
            if (!$title) {
                $title = esc_html__('Our Shop', 'genzia');
            }
        }
    }

    return [
        'title' => $title,
    ];
}
/**
 * Prints HTML for breadcrumbs.
 */
function genzia_breadcrumb($args= []){
    if (!class_exists('CMS_Breadcrumb')) {
        return;
    }

    $breadcrumb = new CMS_Breadcrumb();
    $entries = $breadcrumb->get_entries();

    if (empty($entries)) {
        return;
    }
    $args = wp_parse_args($args, [
        'icon_home' => '',
        'class'     => '',
        'link_class'=> '',
        'before'    => '',
        'after'     => ''
    ]);
    $link_class = genzia_nice_class(['breadcrumb-entry', 'cms-hover-underline', $args['link_class']]);
    ob_start();

    foreach ($entries as $key => $entry) {
        $entry = wp_parse_args($entry, array(
            'label' => '',
            'url' => ''
        ));
        $breadcrumb_separate_icon = apply_filters('genzia_breadcrumb_separate_icon', 'genzia_breadcrumb_separate_icon');
        if (empty($entry['label'])) {
            continue;
        }

        echo '<li class="d-flex gap-8 align-items-center">';
            if (!empty($entry['url'])) {
                printf(
                    '<a class="%1$s" href="%2$s">%3$s%4$s</a>'.$breadcrumb_separate_icon,
                    $link_class,
                    esc_url($entry['url']),
                    $key === 0 ?  $args['icon_home'] : '',
                    esc_attr($entry['label'])
                );
            } else {
                printf('<span class="breadcrumb-entry text-line-1" >%s</span>', esc_html($entry['label']));
            }
        echo '</li>';
    }

    $output = ob_get_clean();

    if ($output) {
        printf('%s', $args['before']);
            printf('<ul class="%1$s">%2$s</ul>',implode(' ', array_filter(['cms-breadcrumb unstyled', $args['class']])), $output);
        printf('%s', $args['after']);
    }
}
add_filter('genzia_breadcrumb_separate_icon', 'genzia_breadcrumb_separate_icon');
function genzia_breadcrumb_separate_icon(){
    // icon
    return genzia_svgs_icon([
        'icon'      => 'bullet',
        'icon_size' => 4,
        'echo'      => false,
        'class'     => 'breadcrumb-separate'
    ]);
}
/**
 * Main Content 
 * 
 * **/
if(!function_exists('genzia_show_sidebar')){
    function genzia_show_sidebar($sidebar=''){
        $sidebar_on = genzia_get_opt('sidebar_on','off');
        if(empty($sidebar)){
            if(genzia_is_woocommerce()){
                $sidebar_name = 'sidebar-product';
            } else {
                $sidebar_name = 'sidebar-post';
            }
        } else {
            $sidebar_name = $sidebar;
        }
        $show_sidebar = ($sidebar_on === 'on' && is_active_sidebar($sidebar_name));
        return $show_sidebar;
    }
}
if(!function_exists('genzia_main_content_classes')){
    function genzia_main_content_classes($args = []){
        $args = wp_parse_args($args, [
            'class' => '',
            'sidebar' => ''
        ]);
        $classes = [
            'cms-main',
            $args['class']
        ];
        if(genzia_is_built_with_elementor()){
            $classes[] = 'is-elementor';
        } else {
            $classes[] = genzia_get_opts('content_width', 'container', 'on');
            if(genzia_is_woocommerce()){
                if(genzia_show_sidebar($args['sidebar']) && !is_singular('product') ){
                    $classes[] = 'cms-main-sidebar cms-woo-sidebar d-flex justify-content-center';
                } else {
                    $classes[] = 'cms-woo-content';
                }
            } elseif( (cms_is_blog() || is_single()) && genzia_show_sidebar($args['sidebar']) ){
                $classes[] = 'cms-main-sidebar d-flex justify-content-center';
            } else {
                $classes[] = 'no-sidebar';
            }
            // Post type archive
            if ( is_post_type_archive() ) {
                $post_type = get_query_var( 'post_type' );
                if ( is_array( $post_type ) ) {
                    $post_type = reset( $post_type );
                }
                $classes[] = 'cms-post-type-archive-' . sanitize_html_class( $post_type );
            }
        }
        $classes = apply_filters('genzia_main_content_classes', $classes);
        
        echo implode(' ', array_filter($classes));
    }
}
function genzia_content_has_sidebar_open($sidebar=''){
    $classes = ['cms-main-content'];
    if(genzia_is_built_with_elementor()){
        $has_sidebar = false;
    } else {
        if(genzia_is_woocommerce()){
            if(genzia_show_sidebar($sidebar) && !is_singular('product') ){
                $has_sidebar = true;
            } else {
                $has_sidebar = false;
            }
            $classes[] = 'main-content-shop';
        } elseif((cms_is_blog() || is_single()) && genzia_show_sidebar($sidebar)){
            $has_sidebar = true;
        } else {
            $has_sidebar = false;
        }
    }
    if(!$has_sidebar) return;
    ?>
    <div class="<?php echo genzia_nice_class($classes); ?>">
    <?php
}
function genzia_content_has_sidebar_close($sidebar=''){
    if(genzia_is_built_with_elementor()){
        $has_sidebar = false;
    } else {
        if(genzia_is_woocommerce()){
            if(genzia_show_sidebar($sidebar) && !is_singular('product') ){
                $has_sidebar = true;
            } else {
                $has_sidebar = false;
            }
        } elseif((cms_is_blog() || is_single()) && genzia_show_sidebar($sidebar)){
            $has_sidebar = true;
        } else {
            $has_sidebar = false;
        }
    }
    if(!$has_sidebar) return;
    ?>
    </div>
    <?php
}

/**
 * Footer layout
 **/
function genzia_footer(){
    if(is_singular('cms-header-top') || is_singular('cms-footer')  || is_singular('cms-mega-menu') || is_singular('cms-sidenav')) return;
    //get_template_part('template-parts/footer-layout','');
    $footer_layout = genzia_get_opts('footer_layout', '1', 'footer_custom');
    

    switch ($footer_layout){
        case 'none':
            break;
        case '1':
            genzia_footer_copyright();
            break;
        default : 
            genzia_footer_elementor_builder();
            break;
    }
}
/*
 * Footer css class
*/
if(!function_exists('genzia_footer_css_class')){
    function genzia_footer_css_class($args = []){
        $args = wp_parse_args($args, [
            'class' => ''
        ]);
        $footer_layout = genzia_get_opts( 'footer_layout', '1' );
        $footer_fixed = genzia_get_opts('footer_fixed', 'off', 'footer_custom');
        $css_classes = [
            'cms-footer',
            'relative',
        ];
        if(!in_array($footer_layout, ['-1', '0', '1', 'none'])) {
            $css_classes[] = 'cms-footer-elementor';
        } else {
            $css_classes[] = genzia_get_opts('content_width', 'container', 'on');
        }

        if($footer_fixed == 'on') $css_classes[] = 'cms-footer--fixed';
        echo implode(' ', array_filter($css_classes));
    }
}
if(!function_exists('genzia_default_copyright_text')){
    function genzia_default_copyright_text($text = '', $args = []){
        $args = wp_parse_args($args, [
            'link_color'       => 'text-accent-regular',
            'link_hover_color' => ''
        ]);
        if(!empty($text)){
            $default_copyright_text = str_replace(['[[copy]]', '[[year]]'], ['&copy;', date('Y')], $text);
        } else {
            $default_text = sprintf(esc_html__('&copy;%s %s, All Rights Reserved. With Love by %s ','genzia'), date('Y') , get_bloginfo('name'), '<a class="'.$args['link_color'].' '.$args['link_hover_color'].'" href="'.esc_url('https://7oroofthemes.com/').'" target="_blank" rel="nofollow" aria-label="'.get_bloginfo('name').' - ' .get_bloginfo('description').'">7oroof</a>');
            //
            $default_copyright_text = str_replace(['[[copy]]', '[[year]]'], ['&copy;', date('Y')], genzia_get_opts('footer_copyright', $default_text, 'footer_custom'));
        }
        return $default_copyright_text;
    }
}
if(!function_exists('genzia_footer_copyright')){
    function genzia_footer_copyright($args = []){
        $args = wp_parse_args($args, [
            'class' => ''
        ]);
        $classes = ['cms-copyright-text cms-footer-copyright', $args['class']];

        if(is_404()) $classes[] = 'text-center';
    ?>
    <div class="<?php echo implode(' ', array_filter($classes));?>">
        <?php echo genzia_default_copyright_text(); ?>
    </div>
    <?php
    }
}
/**
* Footer elementor builder
*
*/
if(!function_exists('genzia_footer_elementor_builder')){
    function genzia_footer_elementor_builder(){
        if(!class_exists('Elementor\Plugin') || !class_exists('CSH_Theme_Core')) return;
        $footer_layout = genzia_get_opts('footer_layout', '1', 'footer_custom');
        // WPML
        if (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE != 'all' && !empty(ICL_LANGUAGE_CODE)) {
            $footer_layout = apply_filters( 'wpml_object_id', $footer_layout, 'cms-footer', true, ICL_LANGUAGE_CODE );
        }
        // End WPML
        
        if(in_array($footer_layout, ['-1', '0', '1', 'none'])) return;
        $cms_post = get_post($footer_layout);
        if (!is_wp_error($cms_post) && $cms_post->ID == $footer_layout){
            $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $footer_layout );
            if(!empty($content)){
                ctc_print_html($content);
            } else {
            ?>
            <div class="<?php ctc_print_html(genzia_get_opts('content_width', 'container', 'on'));  ?> cms-copyright-text cms-footer-copyright" data-title="<?php echo esc_attr($cms_post->post_title); ?>">
                <?php ctc_print_html($cms_post->post_content); ?>
            </div>
            <?php 
            }
        }
    }
}

/**
 * Popup Content
 * 
 * **/
add_action('wp_footer', 'genzia_popup_content_render');
if(!function_exists('genzia_popup_content_render')){
    function genzia_popup_content_render($args = []){
        if(is_user_logged_in()) return;
        $args = wp_parse_args($args, [
            'hide_popup' => genzia_get_opts('hide_popup', 'off', 'popup_custom'),
            'animate'    => genzia_get_opts('popup_animate', 'cms-fadeInUp', 'popup_custom'),
            'position'   => genzia_get_opts('popup_position', 'align-items-end', 'popup_custom')
        ]);
        if(!class_exists('Elementor\Plugin') || !class_exists('CSH_Theme_Core')) return;
        $popup_layout = genzia_get_opts('popup_layout', '1', 'popup_custom');
        if(in_array($popup_layout, ['-1', '0', '1', 'none'])) return;
        $cms_post = get_post($popup_layout);

        $popup_classes = [
            'cms-sp cms-sp-holder cms-sp-prevent-session cms-overlay fixed d-flex',
            'p-40 p-tablet-20 p-mobile-0',
            $args['position']
        ];
        $popup_inner_classes = [
            'cms-sp-inner relative',
            $args['animate'],
            'cms-transition',
            'bg-white'
        ];
    ?>
        <div id="cms-subscribe-popup" class="<?php echo genzia_nice_class($popup_classes); ?>">
            <div class="<?php echo genzia_nice_class($popup_inner_classes); ?>">
                <a href="#" class="cms-sp-close absolute top-right text-white text-hover-error z-top3 p-20" aria-label="<?php esc_attr_e('Close','genzia'); ?>">
                    <span class="screen-reader-text"><?php esc_html_e('Close','genzia'); ?></span>
                    <?php
                    genzia_svgs_icon([
                        'icon'      => 'core/close',
                        'icon_size' => 16
                    ]);
                ?></a>
                <div class="cms-sp-content-container">
                    <div class="cms-sp-content-inner"><?php 
                        if (!is_wp_error($cms_post) && $cms_post->ID == $popup_layout){
                            $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $popup_layout );
                            if(!empty($content)){
                                ctc_print_html($content);
                            } else {
                                ctc_print_html($cms_post->post_content);
                            }
                        }
                    ?></div>
                    <?php if($args['hide_popup'] === 'on'){ ?>
                        <div class="cms-sp-prevent p-20">
                            <div class="cms-sp-prevent-inner d-flex gap-10 align-items-center justify-content-end text-15">
                                <input class="cms-sp-prevent-input" type="checkbox" name="cms-sp-prevent-input" id="cms-sp-prevent-input">
                                <label for="cms-sp-prevent-input" class="cms-sp-prevent-label"><?php echo esc_html__('Disable This Pop-up', 'genzia') ?></label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php
    }
}

/**
 * Post Term
 * 
 *  */
if(!function_exists('genzia_get_the_term_list')){
    function genzia_get_the_term_list( $post_id, $taxonomy, $sep = '', $class = '', $args = [] ) {
        //$terms = get_the_terms( $post_id, $taxonomy );
        $terms = wp_get_post_terms( $post_id, $taxonomy, array( 'orderby' => 'term_order' ) );
        if ( is_wp_error( $terms ) ) {
            return $terms;
        }
     
        if ( empty( $terms ) ) {
            return false;
        }
     
        $links = array();
     
        foreach ( $terms as $term ) {
            $link = get_term_link( $term, $taxonomy );
            if ( is_wp_error( $link ) ) {
                return $link;
            }
            $links[] = '<a href="' . esc_url( $link ) . '" class="'.genzia_nice_class(['cms-term', $class]).'">' . $term->name . '</a>';
        }
     
        /**
         * Filters the term links for a given taxonomy.
         *
         * The dynamic portion of the hook name, `$taxonomy`, refers
         * to the taxonomy slug.
         *
         * Possible hook names include:
         *
         *  - `term_links-category`
         *  - `term_links-post_tag`
         *  - `term_links-post_format`
         *
         * @since 2.5.0
         *
         * @param string[] $links An array of term links.
         */
        $term_links = apply_filters( "cms_term_links-{$taxonomy}", $links );  // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
     
        return implode( $sep, $term_links );
    }
}
/**
 * Term Lists
 * 
 * */
if(!function_exists('genzia_the_terms')){
    function genzia_the_terms( $post_id, $taxonomy, $sep = ', ', $class = '' , $args = []) {
        $args = wp_parse_args($args, [
            'before'      => '',
            'after'       => '',
            'before_term' => '',
            'after_term'  => ''  
        ]);
        $term_list = genzia_get_the_term_list( $post_id, $taxonomy, $sep, $class, $args );
        if ( is_wp_error( $term_list ) ) {
            return false;
        }
     
        /**
         * Filters the list of terms to display.
         *
         * @since 2.9.0
         *
         * @param string $term_list List of terms to display.
         * @param string $taxonomy  The taxonomy name.
         * @param string $sep       String to use between the terms.
         * @param string $class     CSS class to use in the terms.
         */
        printf ('%s', $args['before']);
            echo apply_filters( 'genzia_the_terms', $term_list, $taxonomy, $sep, $class );
        printf ('%s', $args['after']);
    }
}
/**
 * Post Title
 * 
 * */
if(!function_exists('genzia_entry_title')){
    function genzia_entry_title($args= []){
        $args=wp_parse_args($args, [
            'class' => 'text-heading text-hover-accent-regular',
            'style' => ''
        ]);
        $args['class'] = genzia_nice_class(array_filter(['h4 cms-post-title', $args['class']]));
    ?>
        <h2 <?php echo genzia_render_attrs($args); ?>>
            <a href="<?php echo esc_url( get_permalink() ); ?>" aria-label=<?php the_title() ?>>
                <?php 
                    // sticky icon
                    if ( is_sticky() ) {
                        genzia_svgs_icon([
                            'icon'      => 'core/thumbtack',
                            'icon_size' => 30
                        ]);
                    }
                    // title
                    the_title(); 
                ?>
            </a>
        </h2>
    <?php
    }
}
if(!function_exists('genzia_entry_single_title')){
    function genzia_entry_single_title($args = []){
        $args  = wp_parse_args($args, [
            'class' => '',
            'style' => ''
        ]);
        $args['class'] = genzia_nice_class(['cms-post-title', 'cms-post-single-title', $args['class'], 'empty-none']);
    ?>
        <h4 <?php echo genzia_render_attrs($args); ?>><?php 
            the_title();
        ?></h4>
    <?php
    }
}

/**
 * Post Thumbnail
 * 
 * */
if(!function_exists('genzia_entry_thumbnail')){
    function genzia_entry_thumbnail($args = []){
        if ( !has_post_thumbnail() ) return;
        $args = wp_parse_args($args, [
            'class'     => '',
            'size'      => 'medium',
            'img_class' => '',
            'content'   => '',
            'style'     => '',
            'priority'  => ''
        ]);
        $classes      = genzia_nice_class(['cms-post-thumbnail', 'relative', $args['class']]);
        $opt_prefix   = is_singular('post')?'post_':'archive_';
    ?>
        <div class="<?php echo esc_attr($classes); ?>"><?php
            genzia_the_post_thumbnail([
                'size'    => $args['size'],
                'class'   => $args['img_class'],
                'style'   => $args['style'],
                'priority' => $args['priority']
            ]);
            printf('%s', $args['content']);
        ?></div>
    <?php
    }
}
if(!function_exists('genzia_the_post_thumbnail')){
    function genzia_the_post_thumbnail($args = []){
        $args = wp_parse_args($args, [
            'size'    => 'medium',
            'class'   => '',
            'style'   => '',
            'priority' => ''
        ]);
        $img_attrs = [
            'class'   => $args['class'], 
            //'loading' => 'lazy', 
            'style'   => $args['style']
        ];
        if($args['priority']){
            $img_attrs['fetchpriority'] = 'hight';
        } else {
            $img_attrs['loading'] = 'lazy';
        }
        echo wp_get_attachment_image(get_post_thumbnail_id(), $args['size'], false, $img_attrs);
    }
}
/**
 * Get excerpt
 * The excerpt with custom length.
 * @return string      
 */
function genzia_get_the_excerpt($length = 55, $post = null){
    $post = get_post($post);

    if (empty($post) || 0 >= $length) {
        return '';
    }

    if (post_password_required($post)) {
        return esc_html__('Post password required.', 'genzia');
    }

    $content = apply_filters(
        'the_content',
        strip_shortcodes($post->post_content)
    );
    $content = str_replace(']]>', ']]&gt;', $content);

    $excerpt_more = apply_filters('genzia_excerpt_more', '&hellip;');
    $excerpt = wp_trim_words($content, $length, $excerpt_more);

    return $excerpt;
}
/**
* Print post excerpt based on length.
*
* @param integer $length
*/
if (!function_exists('genzia_entry_excerpt')) :
    function genzia_entry_excerpt($args)
    {
        $args = wp_parse_args($args, [
            'length' => 55,
            'class' => ''
        ]);
        $cms_the_excerpt = get_the_excerpt();
        $classes = ['cms-excerpt', $args['class']];
    ?>
    <div class="<?php echo genzia_nice_class($classes); ?>"><?php
        if (!empty($cms_the_excerpt)) {
            echo esc_html($cms_the_excerpt);
        } else {
            echo wp_kses_post(genzia_get_the_excerpt($args['length']));
        }
    ?></div>
    <?php
    }
endif;
/**
 * Post Page Link
 * */
function genzia_entry_link_pages(){
    wp_link_pages(array(
        'before'      => '<div class="cms-page-links d-flex pt-20">',
        'after'       => '</div>',
        'link_before' => '<span>',
        'link_after'  => '</span>',
    ));
}
/**
 * Post Readmore
 * */
if(!function_exists('genzia_entry_readmore')){
    function genzia_entry_readmore(){
    ?>
    <div class="absolute center">
        <a class="cms-readmore bg-white text-menu bg-hover-accent-regular text-hover-white cms-box-78 circle cms-hover-show zoom-out" href="<?php echo esc_url( get_permalink() ); ?>">
            <span class="screen-reader-text"><?php 
                // Text
                echo esc_html__( 'Explore More', 'genzia' );
            ?></span>
            <?php
            // Icon
            genzia_svgs_icon([
                'icon'      => 'plus',
                'icon_size' => 14
            ]);
        ?></a>
    </div>
    <?php
    }
}
/**
 * Post Author
 * 
 * */
if(!function_exists('genzia_post_author')){
    function genzia_post_author($args = []){
        $args = wp_parse_args($args, [
            'opt_prefix'  => 'archive_',
            'text'        => '',
            'link_class'  => ''
        ]);
        $author_on = (bool) genzia_get_opt($args['opt_prefix'].'author_on', true);
        if($author_on){
            genzia_the_author_posts_link([
                'text'       => $args['text'],
                'link_class' => $args['link_class']
            ]);
        }
    }
}
/**
 * Post Date
 * 
 * */
if(!function_exists('genzia_post_date')){
    function genzia_post_date($args = []){
        $args = wp_parse_args($args, [
            'opt_prefix'  => 'archive_'
        ]);
        $date_on = (bool) genzia_get_opt($args['opt_prefix'].'date_on', true);
        if($date_on){
            echo get_the_date();
        }
    }
}
/**
 * Prints post meta
 */
if (!function_exists('genzia_post_meta')) :
    function genzia_post_meta($args = [])
    {
        $args = wp_parse_args($args, [
            'opt_prefix'     => 'archive_',
            'class'          => '',
            'gap'            => '',
            'tax'            => 'category',
            'separator'      => '',
            //
            'show_cat'       => true,
            'show_date'      => true,
            'show_author'    => true,
            //
            'link_class'     => '',
            'cat_class'      => '',
            'cat_link_class' => '',
            'cat_separator'  => '',
            //
            'date_class'     => '',
            //
            'before'         => '',
            'after'          => ''
        ]);
        $classes = ['cms-post-meta', $args['class'], 'd-flex align-items-center'];
        if(!empty($args['gap'])) $classes[] = 'gap';
        $author_on     = (bool) genzia_get_opt($args['opt_prefix'].'author_on', true);
        $categories_on = (bool) genzia_get_opt($args['opt_prefix'].'categories_on', true);
        $date_on       = (bool) genzia_get_opt($args['opt_prefix'].'date_on', true);
        $comments_on   = (bool) genzia_get_opt($args['opt_prefix'].'comments_on', false);
        $metas = [];
        if ($author_on || $comments_on || $categories_on || $date_on) : ?>
            <div class="<?php echo implode(' ', array_filter($classes)); ?>" style="<?php echo esc_attr($args['gap']); ?>">
                <?php
                // Category
                if($args['show_cat'] && $categories_on){
                    ob_start();
                        $cat_classes = ['meta-item category empty-none', $args['cat_class']];
                        $cat_link_class = genzia_nice_class([$args['cat_link_class']]);
                    ?>
                        <div class="<?php echo genzia_nice_class($cat_classes); ?>">
                            <span class="cms-post-meta-cate-dot cms-box-8 bg-current d-inline-block mt-5 mr-8"></span>
                            <?php genzia_the_terms(get_the_ID(), $args['tax'], $args['cat_separator'], $cat_link_class); ?>
                        </div>
                    <?php
                    $metas[] = ob_get_clean(); 
                }
                // Date
                if ($date_on && $args['show_date']){ 
                    ob_start();
                ?>
                    <div class="meta-item date <?php echo esc_attr($args['date_class']); ?>"><?php echo get_the_date(); ?></div>
                <?php 
                    $metas[] = ob_get_clean(); 
                } 
                // Comments
                if ($comments_on){
                    ob_start();
                ?>
                    <div class="meta-item comment"><?php genzia_comment_number(['link_class' => 'd-flex text-accent gap-5 '.$args['link_class'], 'title_class' => 'text-body order-first']); ?></div>
                <?php 
                    $metas[] = ob_get_clean();
                }
                // Author
                if ($author_on && $args['show_author']) {
                    ob_start();
                ?>
                    <span class="separator"></span>
                    <div class="meta-item author">
                        <?php genzia_the_author_posts_link([
                            'text'       => '',
                            'link_class' => $args['link_class']
                        ]); ?>
                    </div>
                <?php 
                    $metas[] = ob_get_clean(); 
                }
                // Render HTML
                printf('%1$s%2$s%3$s', $args['before'], implode($args['separator'], $metas), $args['after']);
            ?>
            </div>
        <?php endif;
    }
endif;
/**
 * Author Post link
 * 
 * */
if(!function_exists('genzia_the_author_posts_link')){
    function genzia_the_author_posts_link($args = []){
        $args = wp_parse_args($args, [
            'id'         => '',   
            'text'       => '',
            'link_class' => '',
            'object'     => '',
            'before'     => '',
            'after'      => ''   
        ]);
        $post = get_post( $args['id'] );
        $user_id = $post->post_author;

        $link = sprintf(
            '%1$s<a href="%2$s" title="%3$s" class="%4$s" rel="author">%5$s</a>',
            $args['text'],
            esc_url( get_author_posts_url( $user_id , get_the_author_meta('user_nicename',$user_id ) ) ),
            /* translators: %s: Author's display name. */
            esc_attr( sprintf( esc_html__( 'Posts by %s', 'genzia' ), get_the_author_meta('display_name', $user_id ) ) ),
            $args['link_class'],
            get_the_author_meta('display_name', $user_id )
        );
        printf('%s', $args['before']);
        echo apply_filters( 'genzia_the_author_posts_link', $link );
        printf('%s', $args['after']);
    }
}
/**
 * Post Comment Count
 * */
if(!function_exists('genzia_comment_number')){
    function genzia_comment_number($args=[]){
        $args = wp_parse_args($args, [
            'title_class' => '',
            'link_class'  => ''  
        ]);
        $number = get_comments_number();
        switch ($number) {
            case '1':
                $html = number_format_i18n($number).' <span class="'.$args['title_class'].'">'.esc_html__('Comment','genzia').':</span>';
                break;
            default:
                $html = number_format_i18n($number).' <span class="'.$args['title_class'].'">'.esc_html__('Comments','genzia').':</span>';
                break;
        }
    ?>
        <a href="<?php the_permalink(); ?>" class="<?php echo esc_attr($args['link_class']); ?>"><?php printf('%s', $html);?></a>
    <?php
    }
}
/**
 * Prints tag list
 */
if (!function_exists('genzia_entry_tagged_in')){
    function genzia_entry_tagged_in($args = []) {
        $show_tag  = (bool)genzia_get_opt('post_tags_on', true);
        $args = wp_parse_args($args, [
            'class'      => '',
            'tag_class'  => '',
            'ul_class'   => 'wp-tag-cloud',
            'link_class' => 'tag-cloud-link',
            'title'      => ''
        ]);
        $tags_list = genzia_get_the_tag_list([
            'taxonomy'   => 'post_tag',
            'echo'       => false,
            'ul_class'   => $args['ul_class'],
            'link_class' => $args['link_class']
        ]);
        if (!$tags_list || !$show_tag) return;

    ?>
        <div class="<?php echo implode(' ', array_filter(['cms-post-tags', $args['class']])) ?>">
            <?php printf('%1$s', $args['title']); ?>
            <div class="tagcloud <?php echo esc_attr($args['tag_class']); ?>">
                <?php printf('%2$s', '', $tags_list); ?>
            </div>
        </div>
    <?php 
    }
}
function genzia_get_the_tag_list($args = []) {
    $args = wp_parse_args($args, [
        'post_id'    => null, 
        'taxonomy'   => '',
        'before'     => '',
        'after'      => '',
        'link_class' => '',
        'li_class'   => '',
        'ul_class'   => '',
        'echo'       => true
    ]);
    $terms = get_the_terms( $args['post_id'], $args['taxonomy'] );

    if ( is_wp_error( $terms ) ) {
        return $terms;
    }

    if ( empty( $terms ) ) {
        return false;
    }
    $ul_class = ['cms-term-list', $args['ul_class']];
    $li_class = ['cms-term-li',$args['li_class']];
    $a_class = ['cms-term-link', $args['link_class']];

    $links = array();

    foreach ( $terms as $term ) {
        $link = get_term_link( $term, $args['taxonomy'] );
        if ( is_wp_error( $link ) ) {
            return $link;
        }
        $links[] = '<li class="'.genzia_nice_class($li_class).'"><a href="' . esc_url( $link ) . '" class="'.genzia_nice_class($a_class).'" rel="'.$args['taxonomy'].'">' . $term->name . '</a></li>';
    }
    $term_links =  implode('', $links);
    ob_start();
    printf('%s', $args['before']);
?> 
    <ul class="<?php echo genzia_nice_class($ul_class); ?>" role="list">
        <?php printf('%s', $term_links); ?>
    </ul>
<?php
    printf('%s', $args['after']);

    if($args['echo']){
        echo ob_get_clean();
    } else {
        return ob_get_clean();
    }
}
/**
 * List socials share for post.
 * 
 * 
 */
function genzia_socials_share_default($args = []) {
    $args = wp_parse_args($args, [
        'class'       => '',
        'show'        => false,
        'title'       => '',
        'icon_size'   => 15,
        'inner_class' => '',
        'icon_class'  => ''
    ]);
    if(!$args['show']) return;
    $img_url = get_the_post_thumbnail_url();

    $link_classes = genzia_nice_class(['cms-social-link', 'text-'.$args['icon_size'], $args['icon_class']]);
    ?>
    <div class="<?php echo implode(' ', array_filter(['cms-post-share', 'align-items-center', $args['class']])) ?>">
        <?php printf('%s', $args['title']); ?>
        <div class="<?php echo genzia_nice_class(['cms-post--share d-flex gap-16 lh-0', $args['inner_class']]); ?>">
            <a title="<?php echo esc_attr__('Facebook', 'genzia'); ?>" aria-label="<?php echo esc_attr__('Facebook', 'genzia'); ?>" target="_blank" class="<?php echo esc_attr($link_classes); ?>"
               href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" 
               ><span class="screen-reader-text"><?php echo esc_html__('Facebook', 'genzia'); ?></span><?php
                genzia_svgs_icon([
                    'icon'      => 'core/facebook',
                    'icon_size' => 20
                ]);
           ?></a>
            <a title="<?php echo esc_attr__('Twitter', 'genzia'); ?>" aria-label="<?php echo esc_attr__('Twitter', 'genzia'); ?>" target="_blank" class="<?php echo esc_attr($link_classes); ?>"
               href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" 
               ><span class="screen-reader-text"><?php echo esc_html__('Twitter', 'genzia'); ?></span><?php 
               genzia_svgs_icon([
                    'icon'      => 'core/x',
                    'icon_size' => 20
                ]);
            ?></a>
            <a title="<?php echo esc_attr__('LinkedIn', 'genzia'); ?>" aria-label="<?php echo esc_attr__('LinkedIn', 'genzia'); ?>" target="_blank" class="<?php echo esc_attr($link_classes); ?>"
               href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" 
               ><span class="screen-reader-text"><?php echo esc_html__('LinkedIn', 'genzia'); ?></span><?php
               genzia_svgs_icon([
                    'icon'      => 'core/linkedin',
                    'icon_size' => 20
                ]);
           ?></a>
        </div>
    </div>
    <?php
}
function genzia_social_share_pinterest(){
    $img_url = '';
?>
    <a title="<?php echo esc_attr__('Pinterest', 'genzia'); ?>" target="_blank"
       href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo esc_url($img_url); ?>&description=<?php the_title(); ?>%20" 
       class="d-none"><?php 
       genzia_svgs_icon([
            'icon'      => 'core/pinterest',
            'icon_size' => 20
        ]);
    ?></a>
<?php
}

/* Author Social */
function genzia_get_user_social($args = []){
    $args = wp_parse_args($args, [
        'class'     => '',
        'gap'       => 15,
        'icon_size' => 20,
        'icon_class' => ''
    ]);
    //
    $user_facebook  = get_user_meta(get_the_author_meta('ID'), 'user_facebook', true);
    $user_twitter   = get_user_meta(get_the_author_meta('ID'), 'user_twitter', true);
    $user_linkedin  = get_user_meta(get_the_author_meta('ID'), 'user_linkedin', true);
    $user_skype     = get_user_meta(get_the_author_meta('ID'), 'user_skype', true);
    $user_youtube   = get_user_meta(get_the_author_meta('ID'), 'user_youtube', true);
    $user_vimeo     = get_user_meta(get_the_author_meta('ID'), 'user_vimeo', true);
    $user_tumblr    = get_user_meta(get_the_author_meta('ID'), 'user_tumblr', true);
    $user_rss       = get_user_meta(get_the_author_meta('ID'), 'user_rss', true);
    $user_pinterest = get_user_meta(get_the_author_meta('ID'), 'user_pinterest', true);
    $user_instagram = get_user_meta(get_the_author_meta('ID'), 'user_instagram', true);
    $user_yelp      = get_user_meta(get_the_author_meta('ID'), 'user_yelp', true);
    $user_tiktok    = get_user_meta(get_the_author_meta('ID'), 'user_tiktok', true);
    // 
    $classes    = ['user-social unstyled d-flex', 'align-items-start', 'gap-'.$args['gap'], 'lh-0', $args['class']];
    $icon_class = ['user-social-icon', 'text-'.$args['icon_size'], $args['icon_class']];

    ?>
    <div class="<?php echo genzia_nice_class($classes); ?>">
        <?php if (!empty($user_facebook)) { ?>
            <a href="<?php echo esc_url($user_facebook); ?>" class="<?php echo genzia_nice_class($icon_class); ?>"><?php 
                genzia_svgs_icon([
                    'icon'      => 'core/facebook',
                    'icon_size' => 20
                ]);
            ?></a>
        <?php } ?>
        <?php if (!empty($user_instagram)) { ?>
            <a href="<?php echo esc_url($user_instagram); ?>" class="<?php echo genzia_nice_class($icon_class); ?>"><?php
                genzia_svgs_icon([
                    'icon'      => 'core/instagram',
                    'icon_size' => 20
                ]);
            ?></a>
        <?php } ?>
        <?php if (!empty($user_tiktok)) { ?>
            <a href="<?php echo esc_url($user_tiktok); ?>" class="<?php echo genzia_nice_class($icon_class); ?>"><?php
                genzia_svgs_icon([
                    'icon'      => 'core/tik-tok',
                    'icon_size' => 20
                ]);
            ?></a>
        <?php } ?>
        <?php if (!empty($user_twitter)) { ?>
            <a href="<?php echo esc_url($user_twitter); ?>" class="<?php echo genzia_nice_class($icon_class); ?>"><?php
                genzia_svgs_icon([
                    'icon'      => 'core/x',
                    'icon_size' => 20
                ]);
            ?></a>
        <?php } ?>
        <?php if (!empty($user_linkedin)) { ?>
            <a href="<?php echo esc_url($user_linkedin); ?>" class="<?php echo genzia_nice_class($icon_class); ?>"><?php
                genzia_svgs_icon([
                    'icon'      => 'core/linkedin',
                    'icon_size' => 20
                ]);
            ?></a>
        <?php } ?>
        <?php if (!empty($user_rss)) { ?>
            <a href="<?php echo esc_url($user_rss); ?>" class="<?php echo genzia_nice_class($icon_class); ?>"><?php
                genzia_svgs_icon([
                    'icon'      => 'core/rss',
                    'icon_size' => 20
                ]);
            ?></a>
        <?php } ?>
        <?php if (!empty($user_skype)) { ?>
            <a href="<?php echo esc_url($user_skype); ?>" class="<?php echo genzia_nice_class($icon_class); ?>"><?php
                genzia_svgs_icon([
                    'icon'      => 'core/skype',
                    'icon_size' => 20
                ]);
            ?></a>
        <?php } ?>
        <?php if (!empty($user_pinterest)) { ?>
            <a href="<?php echo esc_url($user_pinterest); ?>" class="<?php echo genzia_nice_class($icon_class); ?>"><?php
                genzia_svgs_icon([
                    'icon'      => 'core/pinterest',
                    'icon_size' => 20
                ]);
            ?></a>
        <?php } ?>
        <?php if (!empty($user_vimeo)) { ?>
            <a href="<?php echo esc_url($user_vimeo); ?>" class="<?php echo genzia_nice_class($icon_class); ?>"><?php
                genzia_svgs_icon([
                    'icon'      => 'core/vimeo',
                    'icon_size' => 20
                ]);
            ?></a>
        <?php } ?>
        <?php if (!empty($user_youtube)) { ?>
            <a href="<?php echo esc_url($user_youtube); ?>" class="<?php echo genzia_nice_class($icon_class); ?>"><?php
                genzia_svgs_icon([
                    'icon'      => 'core/play',
                    'icon_size' => 20
                ]);
            ?></a>
        <?php } ?>
        <?php if (!empty($user_yelp)) { ?>
            <a href="<?php echo esc_url($user_yelp); ?>" class="<?php echo genzia_nice_class($icon_class); ?>"><?php 
                genzia_svgs_icon([
                    'icon'      => 'core/yelp',
                    'icon_size' => 20
                ]);
            ?></a>
        <?php } ?>
        <?php if (!empty($user_tumblr)) { ?>
            <a href="<?php echo esc_url($user_tumblr); ?>" class="<?php echo genzia_nice_class($icon_class); ?>"><?php
                genzia_svgs_icon([
                    'icon'      => 'core/tumblr',
                    'icon_size' => 20
                ]);
            ?></a>
        <?php } ?>

    </div> <?php
}
/**
 * Author Avatar
 * 
 * */
function genzia_avatar($args =[]){
    $args = wp_parse_args($args, [
        'custom' => false,
        'id'     => get_the_author_meta( 'ID' ),
        'width'  => 100,
        'height' => 100,
        'class'  => ''
    ]);
    global $blog_id, $wpdb;
    if ( ! is_object ( $args['id'] ) && ! empty( $args['id'] ) ) {
        // Find user by ID or e-mail address
        $user = is_numeric( $args['id'] ) ? get_user_by( 'id', $args['id'] ) : get_user_by( 'email', $args['id'] );

        // Get registered user ID
        $user_id = ! empty( $user ) ? $user->ID : '';
    } else {
        $user_id = $args['id'];
    }
    $wpua = get_user_meta( $user_id, $wpdb->get_blog_prefix( $blog_id ) . 'user_avatar', true );
    if(class_exists('One_User_Avatar') && $args['custom']){
        genzia_elementor_image_render([], [
            'attachment_id' => $wpua,
            'size'          => 'custom',
            'custom_size'   => ['width' => $args['width'], 'height' => $args['height']],
            'img_class'     => $args['class']
        ]);
    } else {
        echo get_avatar( get_the_author_meta( 'ID' ), $args['width'], '', '', [
            'size'       => $args['width'],
            'width'      => $args['width'], 
            'height'     => $args['height'], 
            'class'      => $args['class']
        ]);
    }
}
/**
 * Pagination Ajax
 * **/
add_action('wp_ajax_genzia_get_pagination_html', 'genzia_get_pagination_html');
add_action('wp_ajax_nopriv_genzia_get_pagination_html', 'genzia_get_pagination_html');
if (!function_exists('genzia_get_pagination_html')) {
    function genzia_get_pagination_html()
    {
        try {
            if (!isset($_POST['query_vars'])) {
                throw new Exception(__('Something went wrong while requesting. Please try again!', 'genzia'));
            }
            $query = map_deep($_POST['query_vars'], 'sanitize_text_field');
            if(isset($_POST['filter']) && !empty($_POST['filter'])){
                $query['tax_query'] = [
                    'relation'       => 'OR',
                ];
                $tmp = explode('|', sanitize_text_field($_POST['filter']));
                if (isset($tmp[0]) && isset($tmp[1])) {
                    $query['tax_query'][] = array(
                        'taxonomy' => $tmp[1],
                        'field' => 'slug',
                        'operator' => 'IN',
                        'terms' => array($tmp[0]),
                    );
                }
            }
            $query = new WP_Query($query);
            ob_start();
            genzia_posts_pagination($query, true);
            $html = ob_get_clean();
            wp_send_json(
                array(
                    'status' => true,
                    'message' => esc_html__('Load Successfully!', 'genzia'),
                    'data' => array(
                        'html' => $html,
                        'query_vars' => $_POST['query_vars'],
                        'post' => $query->have_posts()
                    ),
                )
            );
        } catch (Exception $e) {
            wp_send_json(array('status' => false, 'message' => $e->getMessage()));
        }
        die;
    }
}
add_action('wp_ajax_genzia_load_more_post_grid', 'genzia_load_more_post_grid');
add_action('wp_ajax_nopriv_genzia_load_more_post_grid', 'genzia_load_more_post_grid');
if (!function_exists('genzia_load_more_post_grid')) {
    function genzia_load_more_post_grid()
    {
        try {
            if (!isset($_POST['settings'])) {
                throw new Exception(__('Something went wrong while requesting. Please try again!', 'genzia'));
            }
            $settings = map_deep($_POST['settings'], 'sanitize_text_field');
            set_query_var('paged', $settings['paged']);
            extract(ctc_get_posts_of_grid($settings['post_type'], [
                'source' => isset($settings['source']) ? $settings['source'] : '',
                'orderby' => isset($settings['orderby']) ? $settings['orderby'] : 'date',
                'order' => isset($settings['order']) ? $settings['order'] : 'desc',
                'limit' => isset($settings['limit']) ? $settings['limit'] : '6',
                'post_ids' => '',
            ]));
            ob_start();
            genzia_get_post_grid($settings, $posts, $settings);
            $html = ob_get_clean();
            wp_send_json(
                array(
                    'status' => true,
                    'message' => esc_html__('Load Successfully!', 'genzia'),
                    'data' => array(
                        'html' => $html,
                        'paged' => $settings['paged'],
                        'posts' => $posts,
                        'max' => $max,
                    ),
                )
            );
        } catch (Exception $e) {
            wp_send_json(array('status' => false, 'message' => $e->getMessage()));
        }
        die;
    }
}
/**
 * Prints posts pagination based on query
 *
 * @param WP_Query $query Custom query, if left blank, this will use global query ( current query )
 *
 * @return void
 */
if(!function_exists('genzia_posts_pagination')){
    function genzia_posts_pagination($query = null, $ajax = false){
        if ($ajax) {
            add_filter('paginate_links', 'genzia_ajax_paginate_links');
        }

        $classes = array();

        if (empty($query)) {
            $query = $GLOBALS['wp_query'];
        }

        if (empty($query->max_num_pages) || !is_numeric($query->max_num_pages) || $query->max_num_pages < 2) {
            return;
        }

        $paged = $query->get('paged', '');

        if (!$paged && is_front_page() && !is_home()) {
            $paged = $query->get('page', '');
        }

        $paged = $paged ? intval($paged) : 1;

        $pagenum_link = html_entity_decode(get_pagenum_link());
        $query_args = array();
        $url_parts = explode('?', $pagenum_link);

        if (isset($url_parts[1])) {
            wp_parse_str($url_parts[1], $query_args);
        }

        $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
        $pagenum_link = trailingslashit($pagenum_link) . '%_%';
        $paginate_links_args = array(
            'base'      => $pagenum_link,
            'total'     => $query->max_num_pages,
            'current'   => $paged,
            'mid_size'  => 1,
            'add_args'  => array_map('urlencode', $query_args),
            'prev_text' => apply_filters('genzia_pagination_prev_arrow','Prev'),
            'next_text' => apply_filters('genzia_pagination_next_arrow','Next'),
            //
            //'before_page_number' => '<span>',
            //'after_page_number'  => '</span>'
        );
        if ($ajax) {
            $paginate_links_args['format'] = '?page=%#%';
        }
        $links = paginate_links($paginate_links_args);
        if ($links):
        ?>
            <nav class="navigation posts-pagination <?php echo esc_attr($ajax ? 'ajax' : ''); ?>">
                <div class="posts-page-links d-flex">
                    <?php
                        printf('%s', $links);
                    ?>
                </div>
            </nav>
        <?php
        endif;
    }
}

if(!function_exists('genzia_pagination_prev_arrow')){
    add_filter('genzia_pagination_prev_arrow', 'genzia_pagination_prev_arrow');
    function genzia_pagination_prev_arrow(){
        return genzia_svgs_icon([
            'icon'      => 'chevron-left',
            'icon_size' => 6,
            'echo'      => false 
        ]);
    }
}
if(!function_exists('genzia_pagination_next_arrow')){
    add_filter('genzia_pagination_next_arrow', 'genzia_pagination_next_arrow');
    function genzia_pagination_next_arrow(){
        return genzia_svgs_icon([
            'icon'      => 'chevron-right',
            'icon_size' => 6,
            'echo'      => false 
        ]);
    }
}
/**
 * Single Post
 * 
 * Display navigation to next/previous post when applicable.
 */
function genzia_post_nav_default($args = []){
    if(!genzia_get_opt('post_navigation_on', true)) return;
    global $post;
    $previous = (is_attachment()) ? get_post($post->post_parent) : get_adjacent_post(false, '', true);
    $next = get_adjacent_post(false, '', false);

    if (!$next && !$previous) {
        return;
    }

    $args = wp_parse_args($args, [
        'class' => ''
    ]);

    $next_post = get_next_post();
    $previous_post = get_previous_post();

    if (!empty($next_post) || !empty($previous_post)) {
        $nav_class = 'nav-item text-menu text-hover-white text-sm cms-box-60 cms-radius-10 bdr-1 bg-hover-accent-regular bdr-hover-accent-regular';
        ?>
        <div class="cms-nav-links d-flex gap justify-content-between <?php echo esc_attr($args['class']); ?>">
            <?php if (is_a($previous_post, 'WP_Post') && get_the_title($previous_post->ID) != '') {
                $prev_img_id = get_post_thumbnail_id($previous_post->ID);
                $prev_img_url = wp_get_attachment_image_src($prev_img_id, 'thumbnail');
                ?>
                <a class="nav-post-prev cms-hover-move-icon-left <?php echo esc_attr($nav_class); ?>" href="<?php echo esc_url(get_permalink($previous_post->ID)); ?>" aria-label="<?php echo esc_attr__('Prev Post', 'genzia'); ?>">
                    <?php genzia_svgs_icon([
                        'icon'      => 'chevron-left',
                        'icon_size' => 8,
                        'class'     => ''
                    ]); ?>
                    <span class="screen-reader-text"><?php echo esc_html__('Prev Post', 'genzia'); ?></span>
                </a>
            <?php } else { echo  '<span></span>';} ?>
            <?php if (is_a($next_post, 'WP_Post') && get_the_title($next_post->ID) != '') {
                $next_img_id = get_post_thumbnail_id($next_post->ID);
                $next_img_url = wp_get_attachment_image_src($next_img_id, 'thumbnail');
                ?>
                <a class="nav-post-next cms-hover-move-icon-right <?php echo esc_attr($nav_class); ?>" href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" aria-label="<?php echo esc_attr__('Next Post', 'genzia'); ?>">
                    <span class="screen-reader-text"><?php echo esc_html__('Next Post', 'genzia'); ?></span>
                    <?php genzia_svgs_icon([
                        'icon'      => 'chevron-right',
                        'icon_size' => 8,
                        'class'     => ''
                    ]); ?>
                </a>
            <?php } ?>
        </div>
    <?php }
}
/**
 * Single Post Comments
 * 
 * Custom Comment List
 * 
*/
function genzia_comment_list($comment, $args, $depth){
    $add_below = 'comment'; 
    $comment_classes = ['comment', empty($args['has_children'])?'':'parent'];
    ?>
    <div id="comment-<?php comment_ID(); ?>" <?php comment_class(implode(' ', array_filter($comment_classes)));?> >
        <div class="d-flex gap-24">
            <div class="comment-avatar flex-auto"><?php if ($args['avatar_size'] != 0) {
                echo get_avatar($comment, 88, '', '', ['width' => 88, 'height' => 88, 'class' => 'cms-radius-10']);
            } ?></div>
            <div class="comment-content flex-basic flex-mobile-auto flex-smobile-full">
                <?php if(is_singular('product')){
                    woocommerce_review_display_rating();
                    echo '<div class="star-rating-clearfix clearfix"></div>';
                } ?>
                <div class="comment-heading d-flex gap-20 align-items-center mt-n5 pb-10">
                    <div class="comment-name heading text-xl text-menu">
                        <?php printf('%s', get_comment_author()); ?>
                    </div>
                    <div class="comment-meta text-sm text-sub-text">
                        <?php echo get_comment_date('M j, Y').' - '.get_comment_date('h:s a'); ?>
                    </div>
                </div>
                <div class="comment-text text-md"><?php
                    // Comment text
                    comment_text();
                ?></div>
                <div class="comment-reply pt-12"><?php 
                    comment_reply_link(
                        array_merge($args, [
                          'add_below' => $add_below,
                          'depth'     => $depth,
                          'max_depth' => $args['max_depth'],
                          'reply_text' => genzia_svgs_icon(['icon' => 'arrow-right', 'icon_size' => 10, 'class' => 'cms-box-22 cms-radius-6 bg-accent-regular text-white', 'echo' => false]).esc_html__('Reply', 'genzia')
                        ])
                    ); 
                ?></div>
            </div>
            
        </div>
<?php }
/**
 * Single Post Comments
 * 
 * Comment Form
 * Move comment field to bottom
 * 
 * **/
//add_filter( 'comment_form_fields', 'genzia_comment_field_to_bottom' );
function genzia_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    unset( $fields['cookies'] );
    $fields['comment'] = $comment_field;
    return $fields;
}

/**
 * Single Post Comments
 * 
 * Comment Form
 * Comment form fields
**/
if(!function_exists('genzia_comment_form_args')){
    function genzia_comment_form_args($args = []){
        $args = wp_parse_args($args, []);
        global $post;
        $post_id       = $post->ID;
        $commenter     = wp_get_current_commenter();
        $user          = wp_get_current_user();
        $user_identity = $user->exists() ? $user->display_name : '';
        if ( ! isset( $args['format'] ) ) {
            $args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
        }

        $req   = get_option( 'require_name_email' );
        $html5 = 'html5' === $args['format'];

        // Define attributes in HTML5 or XHTML syntax.
        $required_attribute = ( $html5 ? ' required' : ' required="required"' );
        $checked_attribute  = ( $html5 ? ' checked' : ' checked="checked"' );

        // Identify required fields visually and create a message about the indicator.
        $required_indicator = ' *';//' ' . wp_required_field_indicator();
        $required_text      = ' ' . wp_required_field_message();

        $comment_note_before = sprintf(
            '<p class="comment-notes">%s%s</p>',
            sprintf(
                '<span id="email-notes">%s</span>',
                __( 'Your email address will not be published.', 'genzia' )
            ),
            $required_text
        );
        $btn_icon = genzia_svgs_icon(['class' => 'cms-box-48 cms-radius-6 bg-white text-menu', 'icon' => 'arrow-right','icon_size' => 12, 'echo' => false]);
        $cms_comment_fields = array(
            'id_form'              => 'commentform',
            'class_container'      => 'comment-respond', 
            'title_reply_before'   => '<h4 id="reply-title" class="comment-reply-title d-flex align-items-center gap-10">',
            'title_reply_after'    => '</h4>'.$comment_note_before,
            'title_reply'          => is_singular('product') ? esc_attr__('Add A Review','genzia') : esc_attr__( 'Leave A Reply', 'genzia'),
            'title_reply_to'       => is_singular('product') ? esc_attr__('Leave A Review To','genzia').'%s' : esc_attr__('Leave A Reply To','genzia').'%s',
            'cancel_reply_link'    => is_singular('product') ? esc_attr__('Cancel Review', 'genzia') : esc_attr__( 'Cancel Reply', 'genzia'),
            'id_submit'            => 'submit',
            'class_submit'         => 'btn-cmt-submit cms-btn btn-menu text-white btn-hover-accent-regular text-hover-white cms-hover-move-icon-right',
            'label_submit'         => is_singular('product') ? esc_attr__('Submit Review','genzia') : esc_attr__('Submit Comment','genzia'),
            'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s">'.$btn_icon.'%4$s</button>',
            'submit_field'         => '<div class="form-submit pt-25">%1$s %2$s</div>',
            'comment_notes_before' => '',
            'fields'               => [
                'open'   => '<div class="d-flex gutter-24 pt-24">',    
                'author' => sprintf(
                    '<div class="comment-form-author col-6 col-mobile-12">%1$s</div>',
                    sprintf(
                        '<input id="author" name="author" type="text" value="%s" size="30" maxlength="245" autocomplete="name"%s placeholder="%s"/>',
                        esc_attr( $commenter['comment_author'] ),
                        ( $req ? $required_attribute : '' ),
                        esc_html__( 'Your Name', 'genzia' ).$required_indicator
                    )
                ),
                'email'  => sprintf(
                    '<div class="comment-form-email col-6 col-mobile-12">%1$s</div>',
                    sprintf(
                        '<input id="email" name="email" %s value="%s" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email"%s placeholder="%s" />',
                        ( $html5 ? 'type="email"' : 'type="text"' ),
                        esc_attr( $commenter['comment_author_email'] ),
                        ( $req ? $required_attribute : '' ),
                        esc_html__( 'Email Address', 'genzia' ).$required_indicator
                    )
                ),
                'url' => sprintf(
                    '<div class="comment-form-url col-12">%1$s</div>',
                    sprintf(
                        '<input id="url" name="url" %s value="%s" size="30" maxlength="200" autocomplete="url" placeholder="%s" />',
                        ( $html5 ? 'type="url"' : 'type="text"' ),
                        esc_attr( $commenter['comment_author_url'] ),
                        esc_html__('Website', 'genzia')
                    )
                ),
                'close' => '</div>'
            ],
            'comment_field' => sprintf(
                '<div class="comment-form-comment mb-24">%1$s%2$s%3$s</div>',
                do_action('genzia_before_comment_field'),
                sprintf(
                    '<textarea id="comment" name="comment" cols="45" rows="4" maxlength="65525" %s placeholder="%s"></textarea>',
                    $required_attribute,
                    is_singular('product') ? esc_html__( 'Your review', 'genzia' ) : esc_html__( 'Your comment', 'genzia' )
                ),
                do_action('genzia_after_comment_field')
            )
        );
        return $cms_comment_fields;
    }
}
/**
 * Single Post
 * 
 * Comment Form
 * Comment reply link
**/
add_filter( 'comment_reply_link', 'genzia_comment_reply_link_class' );
if(!function_exists('genzia_comment_reply_link_class')){
    function genzia_comment_reply_link_class( $class ) {
        $class = str_replace( 'class="comment-reply-link', 'class="comment-reply-link d-inline-flex cms-hover-move-icon-right text-btn font-700 d-flex gap-8 align-items-center text-accent-regular text-hover-primary-regular', $class );
        return $class;
    }
}

/**
 * Single Post
 * 
 * Comment Form Styles
 * 
 * */
function genzia_comment_form_styles(){
    $form_style = [];
    echo implode(';', $form_style);
}
//
add_action('comment_form_after', 'genzia_comment_form_after');
function genzia_comment_form_after(){
    // Close style for comment form '.cms-cmt-style'
?>
    </div>
<?php }

/**
 * Get category taxomomy name by post type
 * 
 * */
function genzia_post_taxonomy_category($taxo = 'category'){
    switch ($taxo) {
        case 'category':
            $post_taxo    = 'category';
            $product_taxo = 'product_cat';
            break;
        case 'tag':
            $post_taxo    = 'post_tag';
            $product_taxo = 'product_tag';
            break;
    }
    switch (get_post_type()) {
        case 'cms-service':
            return 'service-'.$taxo;
        case 'porfolio':
            return 'portfolio-'.$taxo;
        case 'post':
            return $post_taxo;
        case 'product':
            return $product_taxo;
        default:
            return $taxo;
    }
}

function genzia_taxonomy_by_post_type($post_type = 'post', $taxo = 'category'){
    switch ($taxo) {
        case 'category':
            $post_taxo    = 'category';
            $product_taxo = 'product_cat';
            break;
        case 'tag':
            $post_taxo    = 'post_tag';
            $product_taxo = 'product_tag';
            break;
    }
    switch ($post_type) {
        case 'cms-service':
            return 'service-'.$taxo;
        case 'portfolio':
            return 'portfolio-'.$taxo;
        case 'post':
            return $post_taxo;
        case 'product':
            return $product_taxo;
        default:
            return $taxo;
    }
}
/**
 * 
 *   Theme Configs
 * 
*/
if (!function_exists('genzia_configs')) {
    function genzia_configs($value)
    {
        // accent color 
        $accent_color   = apply_filters('genzia_accent_color', [
            'regular'  => '#FF4400'
        ]);
        // primary color
        $primary_color   = apply_filters('genzia_primary_color', [
            'regular' => '#1B1A1A'
        ]);
        // Custom Color
        $custom_color = apply_filters('genzia_custom_color', [
            'menu'          => [
                'title' => esc_html__('Menu','genzia'),
                'value' => '#222222'
            ],
            'sub-text'      => [
                'title' => esc_html__('Sub Text','genzia'),
                'value' =>'#282828'
            ],
            'on-dark'          =>  [
                'title' => esc_html__('Desc Text Color On Dark','genzia'),
                'value' => '#F9F9F9'
            ],
            'on-dark2'          =>  [
                'title' => esc_html__('Secondary Desc Text Color On Dark','genzia'),
                'value' => '#BBBABA'
            ],
            'divider'       => [
                'title' => esc_html__('Divider','genzia'),
                'value' => '#EAEAEA'
            ],
            'divider-dark'      =>  [
                'title' => esc_html__('Divider Dark','genzia'),
                'value' => '#4C4C4C'
            ],
            'stroke' => [
                'title' => esc_html__('Tag Stroke','genzia'),
                'value' => '#404040'
            ],
            'stroke-white' => [
                'title' => esc_html__('Form Stroke/White','genzia'),
                'value' => '#F6F6F6'
            ],
            'stroke-dark' => [
                'title' => esc_html__('Form Stroke/Dark','genzia'),
                'value' => '#C6C6C6'
            ],
            'bg-light'      => [
                'title' => esc_html__('Background Light','genzia'),
                'value' => '#F6F6F6'
            ],
            'bg-light2' => [
                'title' => esc_html__('Background Light Secondary','genzia'),
                'value' => '#F5F5FC'
            ],
            'bg-dark'       => [
                'title' => esc_html__('Background Dark','genzia'),
                'value' => '#1B1A1A'
            ],
            'bg-image'       => [
                'title' => esc_html__('Background Image Container','genzia'),
                'value' => '#C0C0C0'
            ]
        ]);
        
        // logo
        $logo_w       = '135';
        $logo_h       = '32';
        $logo_w_sm    = '135';
        $logo_h_sm    = '32';
        $menu_color = [
            'regular' => $custom_color['menu']['value'],
            'hover'   => $accent_color['regular'],
            'active'  => $accent_color['regular'],
        ];
        $transparent_menu_color = [
            'regular' => '#ffffff', //$custom_color['menu']['value'],
            'hover'   => '#ffffff', //$primary_color['regular'], 
            'active'  => '#ffffff', //$primary_color['regular']
        ];
        $header_height = '60';
        $header_width = '620';
        // Body typo
        $body_font_default = apply_filters('genzia_body_font',[ 
            'font_family' => 'Manrope', 
            'font_style' => '400normal' 
        ]);
        $body_font         = genzia_get_opts('body_font', 'default');
        $body_font_typo    = ($body_font=='custom') ? genzia_get_opts('body_font_typo', $body_font_default, 'body_font') : $body_font_default;
        $body_color        = apply_filters('genzia_body_color',[
            'regular' => '#4B4B4B'
        ]);
        
        // Heading typo
        $heading_font_default = apply_filters('genzia_heading_font', [
            'font_family' => 'Funnel Display', 
            'font_style'  => '400normal'
        ]);
        $heading_font         = genzia_get_opts('heading_font', 'default');
        $heading_font_typo    = ($heading_font =='custom') ? genzia_get_opts('heading_font_typo', $heading_font_default, 'heading_font') : $heading_font_default;
        $heading_color        = apply_filters('genzia_heading_color', [
            'regular' => '#1B1A1A'
        ]);
        /**
         * Special typo
         * 
         * */
        $special_font_default = apply_filters('genzia_special_font', [
            'font_family' => 'DM Sans', 
            'font_style'  => '400normal'
        ]);
        $special_font = genzia_get_opts('special_font', 'default');
        $special_font_typo    = ($special_font =='custom') ? genzia_get_opts('special_font_typo', $special_font_default, 'special_font') : $special_font_default;
        // Buttons
        $btn_font     = apply_filters('genzia_btn_font', 'DM Sans');
        // Link
        $link_color = [
            'regular' => $custom_color['menu']['value'], //'$primary_color['regular'], 
            'hover'   => $accent_color['regular'], 
            'active'  => $accent_color['regular']
        ];
        // Meta
        $meta_color = apply_filters('genzia_meta_color', $custom_color['menu']['value']);

        $accent_color_cf = [];
        foreach ($accent_color as $key => $accent_color_value) {
            $accent_color_cf[$key] =  genzia_get_opts('accent_color', $accent_color, 'color_custom')[$key];
        }
        $primary_color_cf = [];
        foreach ($primary_color as $key => $primary_color_value) {
            $primary_color_cf[$key] =  genzia_get_opts('primary_color', $primary_color, 'color_custom')[$key];
        }
        $custom_color_cf = [];
        foreach ($custom_color as $key => $custom_color_value) {
            $custom_color_cf[$key] =  genzia_get_opts('custom_color', $custom_color, 'color_custom')[$key];
        }

        $heading_color_cf = [];
        foreach ($heading_color as $key => $heading_color_value) {
            $heading_color_cf[$key] =  genzia_get_opts('heading_color', $heading_color, 'color_custom')[$key];
        }

        // Page title
        $ptitle_bg_image = genzia_get_opts('page_title_bg', ['background-color' => 'var(--cms-primary-regular)', 'background-image' => ''], 'custom_ptitle')['background-image'];
        /*if(is_singular('post') && !empty(get_post_thumbnail_id())){
            $ptitle_bg_image = get_the_post_thumbnail_url();
        }*/
        // Shop Page ID
        $shop_page_id       = get_option( 'woocommerce_shop_page_id' );
        $shop_page_title_bg = get_post_meta($shop_page_id,'page_title_bg',true);
        if(is_singular('product') && !empty($shop_page_title_bg['background-image'])){
            $ptitle_bg_image = $shop_page_title_bg['background-image'];
        }
        // Container Width
        if(class_exists('\Elementor\Plugin')){
            $elementor_settings = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend();
            $_container_width   = $elementor_settings->get_settings_for_display( 'container_width' );
            $container_width    = isset($_container_width['size'])?$_container_width['size']:1216;
        } else {
            $container_width = 1216;
        }
        $configs = [
            'container_width' => $container_width, 
            // color
            'accent_color'    => $accent_color_cf,
            'primary_color'   => $primary_color_cf,
            'custom_color'    => $custom_color_cf,
            'heading_color'   => $heading_color_cf,
            'link_color' => [
                'regular' => genzia_get_opts('link_color', $link_color, 'color_custom')['regular'],
                'hover'   => genzia_get_opts('link_color', $link_color, 'color_custom')['hover'],
                'active'  => genzia_get_opts('link_color', $link_color, 'color_custom')['active'],
            ],
            // body typo
            'body' => [
                'bg'          => '#fff',
                'family'      => $body_font_typo['font_family'],
                'size'        => '18px',
                'weight'      => substr($body_font_typo['font_style'], 0, 3),
                'style'       => substr($body_font_typo['font_style'], 3),
                'color'       => genzia_get_opts('body_color', $body_color, 'color_custom')['regular'],
                'line-height' => '1.55556',
            ],
            // Heading typo
            'heading' => [
                'family'      => $heading_font_typo['font_family'],
                'weight'      => substr($heading_font_typo['font_style'], 0, 3),
                'style'       => substr($heading_font_typo['font_style'], 3),
                'line-height' => '1.11111'
            ],
            // Special typo
            'special' => [
                'family'      => $special_font_typo['font_family'],
                'weight'      => substr($special_font_typo['font_style'], 0, 3),
                'style'       => substr($special_font_typo['font_style'], 3),
                'line-height' => '1'
            ],
            // Meta
            'meta'  => [
                'color' => genzia_get_opts('meta_color', $meta_color)
            ],
            // Header 
            'header'    => [
                'height'         => genzia_get_opts('header_height', ['height' => $header_height], 'header_custom')['height'].'px',
                'width'          => genzia_get_opts('header_height', ['height' => $header_height], 'header_custom')['height'].'px',
                'bg'             => genzia_get_opts('header_bg_color', 'transparent', 'header_custom'),
                'transparent-bg' => genzia_get_opts('header_transparent_bg_color','transparent', 'header_custom'),
            ],
            // logo
            'logo'  => [
                'width'     => genzia_get_opts('logo_maxh',['width' => $logo_w, 'height' => $logo_h], 'header_custom')['width'],
                'height'    => genzia_get_opts('logo_maxh',['width' => $logo_w, 'height' => $logo_h], 'header_custom')['height'],
                'width-mobile'  => genzia_get_opts('logo_maxh_sm',['width' => $logo_w_sm, 'height' => $logo_h_sm],'header_custom')['width'],
                'height-mobile' => genzia_get_opts('logo_maxh_sm',['width' => $logo_w_sm, 'height' => $logo_h_sm],'header_custom')['height']
            ],
            // menu color
            'menu_color' => [
                'regular' => genzia_get_opts('main_menu_color', $menu_color, 'header_custom')['regular'],
                'hover'   => genzia_get_opts('main_menu_color', $menu_color, 'header_custom')['hover'],
                'active'  => genzia_get_opts('main_menu_color', $menu_color, 'header_custom')['active'],
            ],
            // transparent menu color
            'transparent_menu_color' => [
                'regular' => genzia_get_opts('transparent_menu_color', $transparent_menu_color, 'header_custom')['regular'],
                'hover'   => genzia_get_opts('transparent_menu_color', $transparent_menu_color, 'header_custom')['hover'],
                'active'  => genzia_get_opts('transparent_menu_color', $transparent_menu_color, 'header_custom')['active'],
            ],
            // transparent menu mobile color
            'transparent_menu_mobile_color' => [
                'regular' => genzia_get_opts('transparent_menu_mobile_color', $transparent_menu_color, 'header_custom')['regular'],
                'hover'   => genzia_get_opts('transparent_menu_mobile_color', $transparent_menu_color, 'header_custom')['hover'],
                'active'  => genzia_get_opts('transparent_menu_mobile_color', $transparent_menu_color, 'header_custom')['active'],
            ],
            // Dropdown

            // Page title
            'ptitle'  => [
                'color'      => '#fff',
                'bg-color'   => genzia_get_opts('page_title_bg', ['background-color' => '#C0C0C0', 'background-image' => ''], 'custom_ptitle')['background-color'],
                'bg-image'   => 'url('.$ptitle_bg_image.')',
                'bg-overlay' => genzia_get_opts('page_title_overlay', 'rgba(0,0,0,0)', 'custom_ptitle')
            ]
        ];
        return $configs[$value];
    }
}
if(!function_exists('genzia_theme_colors')){
    function genzia_theme_colors($args = []){
        $args = wp_parse_args($args, [
            'custom'   => true,
            'backdrop' => false
        ]);
        $colors = [
            'accent'    => genzia_configs('accent_color'),
            'primary'   => genzia_configs('primary_color'),
            'heading'   => genzia_configs('heading_color')
        ];
        $others = [
            'link' => genzia_configs('link_color'),
            'body' => ['color' => genzia_configs('body')['color']],
            'menu' => genzia_configs('menu_color')
        ];

        $customs = apply_filters('genzia_elementor_theme_custom_colors', []);

        $opts = ['' => esc_html__('Default','genzia')];
        foreach ($colors as $key => $value) {
            if(is_array($value)){
                foreach ($value as $_key => $_value) {
                    $opts[$key.'-'.$_key] = $key.' '.$_key.'('.$_value.')';
                }
            } else {
                $opts[$key] = $key.'('.$value.')';
            }
        }
        // Custom Color
        $custom_color = genzia_configs('custom_color');
        foreach ($custom_color as $key => $value) {
            if(is_array($value)){
                $opts[$key] = $value['title'].' ('.$value['value'].')';
            } else {
                $opts[$key] = $key.' ('.$value.')';
            }
        }
        //
        $opts['body']        = esc_html__('Body','genzia');
        $opts['white']       = esc_html__('White','genzia');
        $opts['transparent'] = esc_html__('Transparent','genzia');
        if($args['backdrop']){
            $opts['backdrop'] = esc_html__('Backdrop','genzia');
        }
        if($args['custom']){
            $customs['custom'] = esc_html__('Custom','genzia');
        }
        return array_merge($opts, $customs);
    }
}
if(!function_exists('genzia_theme_custom_colors')){
    function genzia_theme_custom_colors(){
        $color = [
            'white-10' => [
                'title' => esc_html__('White - 10%','genzia'),
                'value' => 'rgba(255,255,255, 0.1)'
            ],
            'white-50' => [
                'title' => esc_html__('White - 50%','genzia'),
                'value' => 'rgba(255,255,255, 0.5)'
            ],
            'divider-light' => [
                'title' => esc_html__('Diviver/ Divider Light','genzia'),
                'value' => 'rgba(234,234,234, 0.5)'
            ],
            'gradient-1' => [
                'title' => esc_html__('Mixed Gradient #1', 'genzia'),
                'value' => 'linear-gradient(69.88deg, var(--cms-accent-regular) 2.47%, var(--cms-warning) 98.44%)'
            ]
        ];
        return apply_filters('genzia_theme_custom_colors', $color);
    }
}

add_filter('genzia_elementor_theme_custom_colors', 'genzia_elementor_theme_custom_colors');
if(!function_exists('genzia_elementor_theme_custom_colors')){
    function genzia_elementor_theme_custom_colors(){
        $colors = genzia_theme_custom_colors();
        $_colors = [];
        foreach ($colors as $key => $color) {
            $_colors[$key] = $color['title'];
        }
        return $_colors;
    }
}
add_filter('genzia_elementor_theme_custom_colors_store', 'genzia_elementor_theme_custom_colors_store');
if(!function_exists('genzia_elementor_theme_custom_colors_store')){
    function genzia_elementor_theme_custom_colors_store(){
        $colors = genzia_theme_custom_colors();
        $_colors = [];
        foreach ($colors as $key => $color) {
            $_colors[$key] = [
                'id'    => $key,
                'label' => $color['title'],
                'group' => 'base'
            ];
        }
        return $_colors;
    }
}

if (!function_exists('genzia_hex_to_rgb')) {
    function genzia_hex_to_rgb($color)
    {

        $default = '0,0,0';

        //Return default if no color provided
        if (empty($color))
            return $default;

        //Sanitize $color if "#" is provided 
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb = array_map('hexdec', $hex);

        $output = implode(",", $rgb);

        //Return rgb(a) color string
        return $output;
    }
}

if (!function_exists('genzia_inline_styles')) {
    function genzia_inline_styles()
    {
        ob_start();
            // CSS Variable
            $accent_colors                 = genzia_configs('accent_color');
            $primary_colors                = genzia_configs('primary_color');
            $custom_colors                 = genzia_configs('custom_color');
            // Global
            $body                          = genzia_configs('body');
            $heading                       = genzia_configs('heading');
            $special                       = genzia_configs('special');
            $heading_colors                = genzia_configs('heading_color');
            $meta                          = genzia_configs('meta');
            $link_color                    = genzia_configs('link_color');
            // Header
            $header                        = genzia_configs('header');
            $logo                          = genzia_configs('logo');
            $menu_color                    = genzia_configs('menu_color');
            $transparent_menu_color        = genzia_configs('transparent_menu_color');
            $transparent_menu_mobile_color = genzia_configs('transparent_menu_mobile_color');
            // Page Title
            $ptitle                 = genzia_configs('ptitle');
            // Custom Color
            $customs_colors = genzia_theme_custom_colors();
            echo ':root{';
                // color rgb
                foreach ($accent_colors as $key => $value) {
                    if(is_array($value)){
                        printf('--cms-accent-%1$s-rgb: %2$s;', str_replace('#', '', $key), genzia_hex_to_rgb($value['value']));
                    } else {
                        printf('--cms-accent-%1$s-rgb: %2$s;', str_replace('#', '', $key), genzia_hex_to_rgb($value));
                    }
                }
                foreach ($primary_colors as $key => $value) {
                    if(is_array($value)){
                        printf('--cms-primary-%1$s-rgb: %2$s;', str_replace('#', '', $key), genzia_hex_to_rgb($value['value']));
                    } else {
                        printf('--cms-primary-%1$s-rgb: %2$s;', str_replace('#', '', $key), genzia_hex_to_rgb($value));
                    }
                }
                foreach ($custom_colors as $key => $value) {
                    if(is_array($value)){
                        printf('--cms-%1$s-rgb: %2$s;', str_replace('#', '', $key), genzia_hex_to_rgb($value['value']));
                    } else {
                        printf('--cms-%1$s-rgb: %2$s;', str_replace('#', '', $key), genzia_hex_to_rgb($value));
                    }
                }
                foreach ($heading_colors as $key => $value) {
                    if(is_array($value)){
                        printf('--cms-heading-%1$s-rgb: %2$s;', str_replace('#', '', $key), genzia_hex_to_rgb($value['value']));
                    } else {
                        printf('--cms-heading-%1$s-rgb: %2$s;', str_replace('#', '', $key), genzia_hex_to_rgb($value));
                    }
                }
                // color hex
                foreach ($accent_colors as $key => $value) {
                    if(is_array($value)){
                        printf('--cms-accent-%1$s: %2$s;', str_replace('#', '', $key), $value['value']);
                    } else{
                        printf('--cms-accent-%1$s: %2$s;', str_replace('#', '', $key), $value);
                    }
                }
                foreach ($primary_colors as $key => $value) {
                    if(is_array($value)){
                        printf('--cms-primary-%1$s: %2$s;', str_replace('#', '', $key), $value['value']);
                    } else {
                        printf('--cms-primary-%1$s: %2$s;', str_replace('#', '', $key), $value);
                    }
                }
                foreach ($custom_colors as $key => $value) {
                    if(is_array($value)){
                        printf('--cms-%1$s: %2$s;', str_replace('#', '', $key), $value['value']);
                    } else {
                        printf('--cms-%1$s: %2$s;', str_replace('#', '', $key), $value);
                    }
                }
                foreach ($heading_colors as $key => $value) {
                    if(is_array($value)){
                        printf('--cms-heading-%1$s: %2$s;', str_replace('#', '', $key), $value['value']);
                    } else {
                        printf('--cms-heading-%1$s: %2$s;', str_replace('#', '', $key), $value);
                    }
                }
                // Body
                foreach ($body as $key => $value) {
                    if($key === 'family') $value = $value.', sans-serif';
                    printf('--cms-body-%1$s: %2$s;', $key, $value);
                }
                // Heading
                foreach ($heading as $key => $value) {
                    if($key === 'family') $value = $value.', sans-serif';
                    printf('--cms-heading-%1$s: %2$s;', $key, $value);
                }
                // Special
                foreach ($special as $key => $value) {
                    if($key === 'family') $value = $value.', sans-serif';
                    printf('--cms-special-%1$s: %2$s;', $key, $value);
                }
                // meta
                foreach ($meta as $key => $value) {
                    printf('--cms-meta-%1$s: %2$s;', $key, $value);
                }
                // link color
                foreach ($link_color as $color => $value) {
                    printf('--cms-link-%1$s-color: %2$s;', $color, $value);
                }
                // Header
                foreach ($header as $key => $value) {
                    printf('--cms-header-%1$s: %2$s;', $key, $value);
                    if($key=='bg'){
                        printf('--cms-header-bg-rgb: %1$s;', genzia_hex_to_rgb($value));
                    }
                    if($key=='transparent-bg'){
                        printf('--cms-header-transparent-bg-rgb: %1$s;', genzia_hex_to_rgb($value));
                    }
                }
                // Logo
                foreach ($logo as $key => $value) {
                    printf('--cms-logo-%1$s: %2$s;', $key, $value.'px');
                }
                // Menu color
                foreach ($menu_color as $color => $value) {
                    printf('--cms-menu-%1$s: %2$s;', $color, $value);
                }
                // Menu color rgb
                foreach ($menu_color as $color => $value) {
                    printf('--cms-menu-%1$s-rgb: %2$s;', str_replace('#', '', $color), genzia_hex_to_rgb($value));
                }
                // Transparent Menu color
                foreach ($transparent_menu_color as $color => $value) {
                    printf('--cms-menu-transparent-%1$s: %2$s;', $color, $value);
                }
                // Transparent Menu color rgb
                foreach ($transparent_menu_color as $color => $value) {
                    printf('--cms-menu-transparent-%1$s-rgb: %2$s;', str_replace('#', '', $color), genzia_hex_to_rgb($value));
                }
                // Transparent Menu Mobile color
                foreach ($transparent_menu_mobile_color as $color => $value) {
                    printf('--cms-menu-transparent-mobile-%1$s: %2$s;', $color, $value);
                }
                // Transparent Menu Mobile color rgb
                foreach ($transparent_menu_mobile_color as $color => $value) {
                    printf('--cms-menu-transparent-mobile-%1$s-rgb: %2$s;', str_replace('#', '', $color), genzia_hex_to_rgb($value));
                }
                // Page title
                foreach ($ptitle as $key => $value) {
                    printf('--cms-ptitle-%1$s: %2$s;', $key, $value);
                }
                // Custom Color
                foreach ($customs_colors as $key => $value) {
                    printf('--cms-%1$s: %2$s;', $key, $value['value']);
                }
                // Popup
                printf('--cms-popup-max-width:'.genzia_get_opts('popup_max_w', ['width' => 620], 'popup_custom')['width'].'px;');
                // Content Width
                printf('--cms-content-width:'.genzia_content_width().'px');
                // WooCommerce Cart
                if(class_exists('WooCommerce') && (is_cart() || is_checkout())){
                    printf('--cms-form-btn-color:var(--cms-white);--cms-form-btn-bg:var(--cms-primary-regular);--cms-form-btn-color-hover:var(--cms-white);--cms-form-btn-bg-hover:var(--cms-accent);--cms-form-btn-height:60px;--cms-form-field-height:60px;--cms-form-field-border-width:1px;--cms-form-field-border-width-hover:1px;--cms-form-field-padding-start:24px;--cms-form-field-padding-end:24px;');
                }
            echo '}';
        return ob_get_clean();
    }
}
// end function for inline style

/**
 * Render Attributes
 * 
 * */
if(!function_exists('genzia_render_attrs')){
    function genzia_render_attrs($attrs = [], $echo = true){
        if(!is_array($attrs) || empty($attrs)) return;
        $atts = [];
        foreach ($attrs as $key => $attr) {
            $atts[] = $key.'=\''.implode(' ', array_filter((array)$attr)).'\'';
        }
        return implode(' ', array_filter($atts));
    }
}
/**
 * Render Iframe
 * */
function wealth_print_iframe($args = []){
    $args = wp_parse_args($args, [
        'loading'    => 'lazy',
        'src'        => '', 
        'title'      => '',
        'aria-label' => ''
    ]);
    $attrs = genzia_render_attrs($args);

    printf('%1$s%2$s %3$s %4$s %5$s%6$s', '<i', 'frame', $attrs, '>', '</i', 'frame>');
}
/**
 * Theme Options
 * 
 * **/
/**
 * Get Page List
 * @return array
 */
if (!function_exists('genzia_list_page')) {
    function genzia_list_page($default = [])
    {
        $page_list = array();
        if (!empty($default))
            $page_list[$default['value']] = $default['label'];
        $pages = get_pages(array('hierarchical' => 0, 'posts_per_page' => '-1'));
        foreach ($pages as $page) {
            $page_list[$page->ID] = $page->post_title;
        }
        return $page_list;
    }
}

/**
 * Get Post List
 * @return array
 */
if (!function_exists('genzia_list_post')) {
    function genzia_list_post($post_type = 'post', $default = false)
    {
        $post_list = array();
        if ($default) {
            $post_list['none'] = esc_html__('None', 'genzia');
            $post_list['-1'] = esc_html__('Default', 'genzia');
        }
        $posts = get_posts(array('post_type' => $post_type, 'posts_per_page' => '-1'));
        foreach ($posts as $post) {
            $post_list[$post->ID] = $post->post_title;
        }
        return $post_list;
    }
}

/**
 * Get theme option based on its id.
 *
 * @param string $opt_id Required. the option id.
 * @param mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 *
 * @return mixed
 */
function genzia_get_opt($opt_id, $default = false){
    $opt_name = genzia_get_opt_name();
    if (empty($opt_name)) {
        return $default;
    }
    global ${$opt_name};
    $options = !isset(${$opt_name}) || !isset(${$opt_name}[$opt_id]) ? get_option($opt_name) : ${$opt_name};
    if (!isset($options[$opt_id]) || $options[$opt_id] === '') {
        return $default;
    }
    if (is_array($options[$opt_id]) && is_array($default)) {
        foreach ($options[$opt_id] as $key => $value) {
            if (isset($default[$key]) && $value === '') {
                $options[$opt_id][$key] = $default[$key];
            }
        }
    }
    return $options[$opt_id];
}

/**
 * Get theme option based on its id.
 *
 * @param string $opt_id Required. the option id.
 * @param mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 *
 * @return mixed
 */
function genzia_get_page_opt($opt_id, $default = false){
    $page_opt_name = genzia_get_page_opt_name();
    if (empty($page_opt_name)) {
        return $default;
    }
    $id = get_the_ID();
    if (!is_archive() && is_home()) {
        if (!is_front_page()) {
            $page_for_posts = get_option('page_for_posts');
            $id = $page_for_posts;
        }
    }
    // Search
    if(is_search()){
        $id = '';
    }
    // Get page option for Shop Page
    if (class_exists('WooCommerce') && is_shop()) {
        $id = get_option('woocommerce_shop_page_id');
    }

    return $options = !empty($id) ? get_post_meta(intval($id), $opt_id, true) : $default;
}

/**
 *
 * Get post format values.
 *
 * @param $post_format_key
 * @param bool $default
 *
 * @return bool|mixed
 */
function genzia_get_post_format_value( $id = null, $post_format_key = '', $default = '' ) {
    global $post;
    if ( $id === null ) {
        $id = $post->ID;
    }

    return $value = ( ! empty( $id ) && '' !== get_post_meta( $id, $post_format_key, true ) ) ? get_post_meta( $id, $post_format_key, true ) : $default;
}

/**
 * Get option based on its id.
 * get option of theme and page
 *
 * @param  string $opt_id Required. the option id.
 * @param  mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 * @return mixed
 */
function genzia_get_opts($opt_id, $default = false, $dependency = ''){
    $theme_opt = genzia_get_opt($opt_id, $default);
    $_dependency = genzia_get_page_opt($dependency);
    if($dependency === 'on' || $_dependency === 'on' || $_dependency === 'custom'){
        $page_opt = genzia_get_page_opt($opt_id, $theme_opt);
        if ($page_opt !== null && $page_opt !== '' && $page_opt !== '-1') {
            if (is_array($page_opt) && is_array($theme_opt)) {
                foreach ($page_opt as $key => $value) {
                    foreach ($theme_opt as $key => $value) {
                        if (empty($page_opt[$key]) || $page_opt[$key] === 'px') {
                            $page_opt[$key] = $theme_opt[$key];
                        }
                    }
                }
            }
            if($page_opt!=='0'){
                $theme_opt = $page_opt;
            }
        }
    }
    return $theme_opt;
}

/**
 * Get opt_name for options instance args and for
 * getting option value.
 *
 * @return string
 */
function genzia_get_opt_name_default(){
    return apply_filters('genzia_opt_name', 'cms_theme_options');
}
function genzia_get_opt_name(){
    if (isset($_POST['opt_name']) && !empty($_POST['opt_name'])) {
        return sanitize_text_field($_POST['opt_name']);
    }
    $opt_name = genzia_get_opt_name_default();
    if (defined('ICL_LANGUAGE_CODE')) {
        if (ICL_LANGUAGE_CODE != 'all' && !empty(ICL_LANGUAGE_CODE)) {
            $opt_name = $opt_name . '_' . ICL_LANGUAGE_CODE;
        }
    }

    return $opt_name;
}

/**
 * Get opt_name for options instance args and for
 * getting option value.
 *
 * @return string
 */
function genzia_get_page_opt_name(){
    return apply_filters('genzia_page_opt_name', 'cms_page_options');
}

/**
 * Get opt_name for options instance args and for
 * getting option value.
 *
 * @return string
 */
function genzia_get_post_opt_name(){
    return apply_filters('genzia_post_opt_name', 'genzia_post_options');
}
/*====== End Theme Option ==========*/
/**
 * Ajax Pagination
 * Use in Element Post Grid/Blog
 * 
 * */
if (!function_exists('genzia_ajax_paginate_links')) {
    function genzia_ajax_paginate_links($link)
    {
        $parts = parse_url($link);
        if(isset($parts['query'])){
            parse_str($parts['query'], $query);
            if (isset($query['page']) && !empty($query['page'])) {
                return '#' . $query['page'];
            } else {
                return '#1';
            }
        }
    }
}

/**
 * Custom WP Menu
 * 
 * */
// Menu list for theme options, elementor element, ...
if(!function_exists('genzia_menu_list')){
    function genzia_menu_list(){
        $genzia_menu_list = [
            '_1'      => esc_html__('Default', 'genzia'),
            'primary' => esc_html__('Genzia Primary Menu', 'genzia')
        ];
        //$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
        $menus  = wp_get_nav_menus();
        if ( is_array( $menus ) && ! empty( $menus ) ) {
            foreach ( $menus as $single_menu ) {
                if ( is_object( $single_menu ) && isset( $single_menu->name, $single_menu->slug ) ) {
                    $genzia_menu_list[ $single_menu->term_id ] = $single_menu->name;
                }
            }
        }
        return apply_filters('genzia_menu_list', $genzia_menu_list);
    }
}
// add class to li 
function add_additional_class_on_li($classes, $item, $args) {
    if(isset($args->li_class) && !empty($args->li_class)) {
        $classes[] = $args->li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);
// add class to link
add_filter('nav_menu_link_attributes', function ($atts, $item, $args, $depth) {
    $atts['class'] = 'cms-menu-link';
    // For Level 1
    if(isset($args->lv1_class) && !empty($args->lv1_class) && $depth === 0){
        $atts['class'] .= ' '.$args->lv1_class;
    }
    // For all
    if(isset($args->link_class) && !empty($args->link_class)){
        $atts['class'] .= ' '.$args->link_class;
    }
    // For active/ancestor/parent  Menu Item
    if($item->current || $item->current_item_ancestor || $item->current_item_parent){
        $atts['class'] .= ' active';
    }
    return $atts;
}, 10, 4);

// Custom Menu title
add_filter('nav_menu_item_title', 'genzia_nav_menu_item_title', 10, 2);
function genzia_nav_menu_item_title($title, $args){
    //
    $title = '<span class="menu-title">'.$title.'</span>';
    //
    return $title;
}

/**
 * Mega Menu
 * 
 * **/
class Genzia_Mega_Menu_Walker extends Walker_Nav_Menu
{
    private $item;

    /**
     * Starts the list before the elements are added.
     *
     * @since 3.0.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of menu item. Used for padding.
     * @param array $args An array of wp_nav_menu() arguments.
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $sub_menu_class = isset($args->sub_menu_class) ? $args->sub_menu_class : '';
        $sub_menu_classes = implode(' ', array_filter(['sub-menu',$sub_menu_class]));
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"$sub_menu_classes\">\n";
    }

    /**
     * @see Walker::start_el()
     */
    public function start_el(&$output, $item, $depth = 0, $args = array('icon_class'=>'','attrs' => []), $id = 0)
    {
        $item_html = '';
        $megamenu = apply_filters('cms_enable_megamenu', false);

        if ('[divider]' === $item->title) {
            $output .= '<li class="menu-item-divider"></li>';
            return;
        }
        if ('[logo]' === $item->title) {
            $output .= '<li class="menu-item-logo cms-hidden-mobile-menu flex-basic d-flex justify-content-center">';
                ob_start();
                    get_template_part('template-parts/header/header-branding', '', apply_filters('genzia_menu_item_logo_args',[]) );
                $output .= ob_get_clean();
            $output .= '</li>';
            return;
        }

        $extra_menu_custom = apply_filters("cms_menu_edit", array());
        foreach ($extra_menu_custom as $key => $f) {
            $val = get_post_meta($item->ID, '_menu_item_' . $key, true);
            if (!empty($val)) {
                $item->classes[] = $val;
            }
        }
        // children/toggle icon 
        if($args->walker->has_children || (!empty($item->cms_megaprofile) && $megamenu) )
        {
            $args->old_link_after = $args->link_after;
            if($depth == 0){
                $args->link_after = $this->menu_parent_icon() . $args->link_after ;
            } else {
                $args->link_after = $this->menu_dropdown_parent_icon() . $args->link_after ;
            }
        }
        // custom icon for child-menu
        $cms_menu_child_icon = apply_filters('cms_menu_child_icon', false);
        if($cms_menu_child_icon && $depth > 0){
            $args->old_link_before = $args->link_before;
            $args->link_before = $cms_menu_child_icon . $args->link_before ;
        }
        // megamenu
        if (!empty($item->cms_megaprofile) && $megamenu) {
            $item->classes[] = 'megamenu';
            $item->classes[] = 'menu-item-has-children';
        }
        switch ($item->cms_megaprofile_full) {
            case '0':
                break;
            case '1':
                $item->classes[] = 'megamenu-full';
                break;
            default:
                $item->classes[] = 'megamenu-'.$item->cms_megaprofile_full;
                break;
        }

        if (!empty($item->cms_icon)) {
            $item->classes[] = 'has-icon';
            $icon_class = [
                'menu-icon',
                'order-'.$item->cms_icon_position,
                $item->cms_icon,
                $args->icon_class
            ];
            $item->title .= '<span class="' . implode(' ', array_filter($icon_class)) . '"></span>';
        }
        // Sub Menu
        parent::start_el($item_html, $item, $depth, $args, $id);

        // Link before
        if (isset($args->old_link_before)) {
            $args->link_before = $args->old_link_before;
            $args->old_link_before = '';
        }
        // link after
        if (isset($args->old_link_after)) {
            $args->link_after = $args->old_link_after;
            $args->old_link_after = '';
        }
        // mega menu
        if (!empty($item->cms_megaprofile)) {
            //$output = '';
            $megamenu_class = ['sub-menu sub-megamenu'];
            switch ($item->cms_megaprofile_full) {
                case '0':
                    $megamenu_class[] = 'cms-megamenu-auto';
                    break;
                case '1':
                    $megamenu_class[] = 'cms-megamenu-full';
                    break;
                default:
                    $megamenu_class[] = 'cms-megamenu-'.$item->cms_megaprofile_full;
                    break;
            }
            $megamenu_class = apply_filters('cms_megamenu_classes', $megamenu_class );
            $item_html .= '<div class="'.implode(' ', array_filter($megamenu_class)).'">';
                $item_html .= $this->get_megamenu($item->cms_megaprofile);
            $item_html .= '</div>';
        }

        $output .= $item_html;
    }

    public function get_megamenu($id)
    {
        $content = class_exists('\Elementor\Plugin') ? \Elementor\Plugin::$instance->frontend->get_builder_content( $id ) : '';
        $megamenu = apply_filters('cms_enable_megamenu', false);
        if ($megamenu && !empty($content))
            return  $content;
        else
            return false;
    }
    // Menu parent icon
    public function menu_parent_icon(){
        // icon
        return genzia_svgs_icon([
            'icon'      => 'core/chevron-down',
            'icon_size' => 8,
            'class'     => 'main-menu-toggle cms-hidden-mobile-menu pt-3',
            'echo'      => false
        ]).genzia_svgs_icon([
            'icon'      => 'arrow-right',
            'icon_size' => 10,
            'class'     => 'main-menu-toggle cms-hidden-desktop-menu',
            'echo'      => false
        ]);
    }
    // Menu Dropdown Parent Icon
    public function menu_dropdown_parent_icon(){
        // icon
        return genzia_svgs_icon([
            'icon'      => 'core/chevron-right',
            'icon_size' => 5,
            'class'     => 'main-menu-toggle xxx',
            'echo'      => false
        ]);
    }
}
/**
 * Menu Toggle
 * 
 */
class Genzia_Toggle_Menu_Walker extends Walker_Nav_Menu
{
    private $item;

    /**
     * Starts the list before the elements are added.
     *
     * @since 3.0.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of menu item. Used for padding.
     * @param array $args An array of wp_nav_menu() arguments.
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $sub_menu_class = isset($args->sub_menu_class) ? $args->sub_menu_class : '';
        $sub_menu_classes = implode(' ', array_filter(['sub-menu','sub-menu-toggle',$sub_menu_class]));
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"$sub_menu_classes\">\n";
    }

    /**
     * @see Walker::start_el()
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $item_html = '';
        $megamenu = apply_filters('cms_enable_megamenu', false);

        if ('[divider]' === $item->title) {
            $output .= '<li class="menu-item-divider"></li>';
            return;
        }

        $extra_menu_custom = apply_filters("cms_menu_edit", array());
        foreach ($extra_menu_custom as $key => $f) {
            $val = get_post_meta($item->ID, '_menu_item_' . $key, true);
            if (!empty($val)) {
                $item->classes[] = $val;
            }
        }
        // children/toggle icon 
        if($args->walker->has_children || (!empty($item->cms_megaprofile) && $megamenu) )
        {
            $args->old_link_after = $args->link_after;
            if($depth == 0){
                $args->link_after = $this->menu_parent_icon($args) . $args->link_after ;
            } else {
                $args->link_after = $this->menu_dropdown_parent_icon($args) . $args->link_after ;
            }
        }
        // megamenu
        if (!empty($item->cms_megaprofile) && $megamenu) {
            $item->classes[] = 'megamenu';
            $item->classes[] = 'menu-item-has-children';
        }

        if (!empty($item->cms_icon)) {
            $item->classes[] = 'has-icon';
            $icon_class = [
                'menu-icon',
                'order-'.$item->cms_icon_position,
                $item->cms_icon,
                $args->icon_class
            ];
            $item->title .= '<i class="' . implode(' ', array_filter($icon_class)) . '"></i>';
        }
        // Menu Icon 
        if(isset($args->menu_icon) && !empty($args->menu_icon)){
            $item->title =  $args->menu_icon. $item->title;
            //
            //$args->old_link_before = $args->link_before;
            //$args->link_before =  $args->menu_icon. $args->link_before;
        }
        
        // Show Taxonomy Count
        $tax_count = isset($args->count) ? (int) $args->count : '';
        if($tax_count === 1 && $item->type == 'taxonomy'){
            $taxonomy = get_term($item->object_id);
            //$item->title .= sprintf('&nbsp;<span class="cms-menu-count tax-count">(%d)</span>', $taxonomy->count);
            $args->old_link_after = $args->link_after;
            $args->link_after = sprintf('<span class="cms-menu-count tax-count style-1">(%d)</span>', $taxonomy->count) . $args->link_after ;
        }
        if($tax_count === 2 && $item->type == 'taxonomy'){
            $taxonomy = get_term($item->object_id);
            //$item->title .= sprintf('&nbsp;<span class="cms-menu-count tax-count">(%d)</span>', $taxonomy->count);
            $args->old_link_after = $args->link_after;
            $args->link_after = '<span class="cms-menu-count tax-count style-2">'.sprintf( _n( '%s item', '%s items', $taxonomy->count, 'genzia' ),  esc_html( $taxonomy->count ) ).'</span>' . $args->link_after ;
        }
        if($tax_count === 3 && $item->type == 'taxonomy'){
            $taxonomy = get_term($item->object_id);
            //$item->title .= sprintf('&nbsp;<span class="cms-menu-count tax-count">(%d)</span>', $taxonomy->count);
            $args->old_link_after = $args->link_after;
            $args->link_after = sprintf('<span class="cms-menu-count tax-count count">%d</span>', $taxonomy->count) . $args->link_after ;
        }
        // Show Taxonomy Image
        $tax_image = isset($args->tax_image) ? $args->tax_image : '';
        if($tax_image === '1' && $item->type == 'taxonomy'){
            $taxonomy = get_term($item->object_id);
            $thumbnail_id = get_term_meta( $taxonomy->term_id, 'thumbnail_id', true );
            //echo wp_get_attachment_image($thumbnail_id, 'full');
            $args->old_link_before = $args->link_before;
            $args->link_before = wp_get_attachment_image($thumbnail_id, 'full'). $args->link_before ;

        }
        parent::start_el($item_html, $item, $depth, $args, $id);

        if (isset($args->old_link_before)) {
            $args->link_before = $args->old_link_before;
            $args->old_link_before = '';
        }

        if (isset($args->old_link_after)) {
            $args->link_after = $args->old_link_after;
            $args->old_link_after = '';
        }

        if (!empty($item->cms_megaprofile)) {
            $item_html .= $this->get_megamenu($item->cms_megaprofile);
        }

        $output .= $item_html;
    }

    public function get_megamenu($id)
    {
        $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $id );
        $megamenu = apply_filters('cms_enable_megamenu', false);
        if ($megamenu)
            return '<ul class="sub-menu sub-megamenu sub-menu-toggle"><li>' . $content . '</li></ul>';
        else
            return false;
    }
    // Menu parent icon
    public function menu_parent_icon($args = array()){
        // icon
        $icon = (isset($args->parent_icon) && !empty($args->parent_icon)) ? $args->parent_icon : 'core/chevron-right';
        $icon_class = (isset($args->parent_icon_class) && !empty($args->parent_icon_class)) ? $args->parent_icon_class : '';
        return genzia_svgs_icon([
            'icon'      => $icon,
            'icon_size' => 6,
            'class'     => 'main-menu-toggle '.$icon_class,
            'echo'      => false
        ]);
    }
    // Menu Dropdown Parent Icon
    public function menu_dropdown_parent_icon($args = array()){
        // icon
        $icon = (isset($args->dropdown_parent_icon) && !empty($args->dropdown_parent_icon)) ? $args->dropdown_parent_icon : 'core/chevron-right';
        $icon_class = (isset($args->parent_icon_class) && !empty($args->parent_icon_class)) ? $args->parent_icon_class : '';
        return genzia_svgs_icon([
            'icon'      => $icon,
            'icon_size' => 6,
            'class'     => 'main-menu-toggle '.$icon_class,
            'echo'      => false
        ]);
    }
}
/**
 * Custom Menu Icons
 * Remove menu font icon
 * */
add_filter('cms_mega_menu/get_icons', 'genzia_cms_mega_menu_icons');
if(!function_exists('genzia_cms_mega_menu_icons')){
    function genzia_cms_mega_menu_icons(){
        $icons = [];
        return $icons;
    }
}
add_filter('cms_menu_child_icon', 'genzia_cms_menu_child_icon');
function genzia_cms_menu_child_icon(){
    $icon = genzia_svgs_icon([
        'icon'       => 'arrow-menu',
        'icon_size'  => 10,
        'icon_class' => 'menu-child--icon',
        'class'      => 'd-inline-block',
        'echo'       => false,
        'before'     => '<span class="menu-child-icon flex-auto">',
        'after'      => '</span>'
    ]);
    return $icon;
}

/**
 * Widget Search
 * 
 * */
if(function_exists('ctc_register_wp_widget')){
    add_action( 'widgets_init', function(){
        ctc_register_wp_widget( 'CMS_Search' );
    });

    class CMS_Search extends WP_Widget
    {
        function __construct()
        {
            parent::__construct(
                'cms_search',
                esc_html__( '*CMS Search', 'genzia' ),
                array(
                    'description'                 => esc_attr__( 'Shows search form.', 'genzia' ),
                    'customize_selective_refresh' => true,
                )
            );
        }

        /**
         * Outputs the HTML for this widget.
         *
         * @param array $args An array of standard parameters for widgets in this theme
         * @param array $instance An array of settings for this widget instance
         * @return void Echoes it's output
         **/
        function widget( $args, $instance )
        {
            $instance = wp_parse_args( (array) $instance, array(
                'title'       => '',
                'placeholder' => esc_html__('Search...', 'genzia')
            ) );

            $title = empty( $instance['title'] ) ? '' : $instance['title'];
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            $placeholder = empty( $instance['placeholder'] ) ? '' : $instance['placeholder'];

            printf( '%s', $args['before_widget']);

            if(!empty($title)){
                printf( '%s %s %s', $args['before_title'] , $title , $args['after_title']);
            }

            // Form Style
            $form_style = [
                '--cms-form-field-height:60px;',
                '--cms-form-field-border-color:transparent',
                '--cms-form-field-padding-end:60px',
                '--cms-form-field-padding-start:30px',
                '--cms-form-field-radius:10px;',
                //'--cms-placeholder-color:var(--cms-sub-text)',
                '--cms-form-btn-color:var(--cms-menu)',
                '--cms-form-btn-color-hover:var(--cms-accent)',
                '--cms-btn-padding:0 30px',
                '--cms-form-btn-bg:transparent',
                '--cms-form-btn-bg-hover:transparent'
            ];
        ?>
        <form method="get" class="cms-wgsearch-form relative" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="<?php echo implode(';', $form_style); ?>">
            <input type="text" name="s" class="cms-wgsearch-field w-100" placeholder="<?php echo esc_attr( $placeholder );?>"/>
            <button type="submit" class="absolute top right bottom"><?php 
                genzia_svgs_icon([
                    'icon'      => 'core/search',
                    'icon_size' => 20
                ]);
            ?></button>
        </form>
        <?php
            // search form
            //get_search_form(['placeholder' => $placeholder]);
            // after
            printf('%s', $args['after_widget']);
        }

        /**
         * Deals with the settings when they are saved by the admin. Here is
         * where any validation should be dealt with.
         *
         * @param array $new_instance An array of new settings as submitted by the admin
         * @param array $old_instance An array of the previous settings
         * @return array The validated and (if necessary) amended settings
         **/
        function update( $new_instance, $old_instance )
        {
            $instance                = $old_instance;
            $instance['title']       = sanitize_text_field( $new_instance['title'] );
            $instance['placeholder'] = sanitize_text_field( $new_instance['placeholder'] );
            return $instance;
        }

        /**
         * Displays the form for this widget on the Widgets page of the WP Admin area.
         *
         * @param array $instance An array of the current settings for this widget
         * @return void Echoes it's output
         **/
        function form( $instance )
        {
            $instance = wp_parse_args( (array) $instance, array(
                'title'         => esc_html__( 'Search', 'genzia' ),
                'placeholder'   => esc_html__( 'Search...', 'genzia' ),
            ) );

            $title     = $instance['title'] ? esc_attr( $instance['title'] ) : '';
            $placeholder     = $instance['placeholder'] ? esc_attr( $instance['placeholder'] ) : esc_html__( 'Search...', 'genzia' );
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'genzia' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'placeholder' ) ); ?>"><?php esc_html_e( 'Placeholder:', 'genzia' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'placeholder' ) ); ?>" name="<?php echo esc_attr($this->get_field_name( 'placeholder' ) ); ?>" type="text" value="<?php echo esc_attr( $placeholder ); ?>" />
            </p>
            <?php
        }
    }
}
/**
 * Recent Posts widgets
 *
 * @package CMS Theme
 * @subpackage 
 * @since 1.0
 * 
 */
if(function_exists('ctc_register_wp_widget')){
    add_action( 'widgets_init', function(){
        ctc_register_wp_widget( 'CMS_Recent_Posts_Widget' );
    });

    class CMS_Recent_Posts_Widget extends WP_Widget
    {
        function __construct()
        {
            parent::__construct(
                'cms_recent_posts',
                esc_html__( '*CMS Recent Posts', 'genzia' ),
                array(
                    'description' => esc_attr__( 'Shows your most recent posts.', 'genzia' ),
                    'customize_selective_refresh' => true,
                )
            );
        }

        /**
         * Outputs the HTML for this widget.
         *
         * @param array $args An array of standard parameters for widgets in this theme
         * @param array $instance An array of settings for this widget instance
         * @return void Echoes it's output
         **/
        function widget( $args, $instance )
        {
            $instance = wp_parse_args( (array) $instance, array(
                'title'     => '',
                'number'    => 3,
                'post_type' => 'post',
                'post_in'   => '',
                'layout'    => '1',
            ) );

            $title = empty( $instance['title'] ) ? '' : $instance['title'];
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            printf( '%s', $args['before_widget']);

            if(!empty($title)){
                printf( '%s %s %s', $args['before_title'] , $title , $args['after_title']);
            }

            $number = absint( $instance['number'] );
            /*if ( $number <= 0 || $number > 10) {
                $number = 4;
            }*/
            $post_type = $instance['post_type'];
            $post_in   = $instance['post_in'];
            $layout    = $instance['layout'];
            $sticky = '';
            if($post_in == 'featured') {
                $sticky = get_option( 'sticky_posts' );
            }
            $r = new WP_Query( array(
                'post_type'           => $post_type,
                'posts_per_page'      => $number,
                'no_found_rows'       => true,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
                'post__in'            => $sticky,
                'post__not_in'        => array(get_the_ID())
            ) );

            if ( $r->have_posts() ) { 
                $count = 0;
            ?>
                <div class="cms-posts layout-<?php echo esc_attr($layout);?>">
                    <?php while ( $r->have_posts() ) {
                        $r->the_post();
                        $count ++;
                        global $post;
                    ?>
                    <div class="cms-item d-flex gap-20 align-items-center <?php echo esc_attr($count>1?'mt-24':''); ?>">
                        <?php if(has_post_thumbnail()) { ?>
                            <div class="cms-thumb flex-auto max-w" style="--max-w:80px;"><?php genzia_the_post_thumbnail(['size' => 'thumbnail', 'class' => 'max-w cms-radius-10']); ?></div>
                        <?php } ?>
                        <div class="cms-content flex-basic mb-n7">
                            <?php
                                printf('<div class="cms--meta text-sm text-sub-text mt-n5">%1$s</div>', get_the_date('M j, Y'));
                                printf(
                                    '<a href="%1$s" aria-label="%2$s" class="text-md font-700 text-menu text-hover-accent-regular mb-n5 text-line-2">%3$s</a>',
                                    esc_url( get_permalink() ),
                                    esc_attr( get_the_title() ),
                                    get_the_title()
                                );
                            ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            <?php }
            wp_reset_postdata();
            printf('%s', $args['after_widget']);
        }

        /**
         * Deals with the settings when they are saved by the admin. Here is
         * where any validation should be dealt with.
         *
         * @param array $new_instance An array of new settings as submitted by the admin
         * @param array $old_instance An array of the previous settings
         * @return array The validated and (if necessary) amended settings
         **/
        function update( $new_instance, $old_instance )
        {
            $instance              = $old_instance;
            $instance['title']     = sanitize_text_field( $new_instance['title'] );
            $instance['number']    = absint( $new_instance['number'] );
            $instance['post_type'] = $new_instance['post_type'];
            $instance['post_in']   = $new_instance['post_in'];
            $instance['layout']    = $new_instance['layout'];
            return $instance;
        }

        /**
         * Displays the form for this widget on the Widgets page of the WP Admin area.
         *
         * @param array $instance An array of the current settings for this widget
         * @return void Echoes it's output
         **/
        function form( $instance )
        {
            $instance = wp_parse_args( (array) $instance, array(
                'title'         => esc_html__( 'Recent Posts', 'genzia' ),
                'post_type'     => 'post',
                'post_in'       => 'recent',
                'layout'        => '1',
                'number'        => 3,
            ) );

            $title     = $instance['title'] ? esc_attr( $instance['title'] ) : esc_html__( 'Recent Posts', 'genzia' );
            $number    = absint( $instance['number'] );
            $post_type = isset($instance['post_type']) ? esc_attr($instance['post_type']) : '';
            $post_in   = isset($instance['post_in']) ? esc_attr($instance['post_in']) : '';
            $layout    = isset($instance['layout']) ? esc_attr($instance['layout']) : '1';

            $post_type_list = ctc_get_post_type_options();
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'genzia' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('post_type')); ?>"><?php esc_html_e( 'Post Type', 'genzia' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr($this->get_field_id('post_type') ); ?>" name="<?php echo esc_attr($this->get_field_name('post_type') ); ?>">
                <?php 
                    foreach ($post_type_list as $key => $value) {
                    ?>
                        <option value="<?php echo esc_attr($key) ?>"<?php if( $post_type == $key ){ echo 'selected="selected"';} ?>><?php echo esc_html($value); ?></option>
                    <?php
                    }
                ?>
                </select>
            </p>
            <p><label for="<?php echo esc_attr($this->get_field_id('post_in')); ?>"><?php esc_html_e( 'Post in', 'genzia' ); ?></label>
             <select class="widefat" id="<?php echo esc_attr($this->get_field_id('post_in') ); ?>" name="<?php echo esc_attr($this->get_field_name('post_in') ); ?>">
                <option value="recent"<?php if( $post_in == 'recent' ){ echo 'selected="selected"';} ?>><?php esc_html_e('Recent', 'genzia'); ?></option>
                <option value="featured"<?php if( $post_in == 'featured' ){ echo 'selected="selected"';} ?>><?php esc_html_e('Featured', 'genzia'); ?></option>
             </select>
             </p>
              <p><label for="<?php echo esc_attr($this->get_field_id('layout')); ?>"><?php esc_html_e( 'Layout', 'genzia' ); ?></label>
             <select class="widefat" id="<?php echo esc_attr($this->get_field_id('layout') ); ?>" name="<?php echo esc_attr($this->get_field_name('layout') ); ?>">
                <option value="1"<?php if( $layout == '1' ){ echo 'selected="selected"';} ?>><?php esc_html_e('Default', 'genzia'); ?></option>
             </select>
             </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'genzia' ); ?></label>
                <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3" />
            </p>

            <?php
        }
    }
}
/**
 * Widget Menu
 * 
 * */
if(function_exists('ctc_register_wp_widget')){
    add_action( 'widgets_init', function(){
        ctc_register_wp_widget( 'CMS_Menu_Widget' );
    });
    class CMS_Menu_Widget extends WP_Widget {
        public function __construct() {
            $widget_ops = array(
                'description'                 => __( 'Add a navigation menu to your sidebar.','genzia' ),
                'customize_selective_refresh' => true,
                'show_instance_in_rest'       => true,
            );
            parent::__construct( 
                'cms_menu', 
                esc_html__( '*CMS Menu', 'genzia' ), 
                $widget_ops 
            );
        }
        public function widget( $args, $instance ) {
            // Get menu.
            $nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

            if ( ! $nav_menu ) {
                return;
            }
            $default_title = esc_html__( 'CMS Menu', 'genzia' );
            $title         = ! empty( $instance['title'] ) ? $instance['title'] : '';
            $layout        = ! empty( $instance['layout'] ) ? $instance['layout'] : '1';
            $count         = ! empty( $instance['count'] ) ? $instance['count'] : '';
            $link_classes  = ! empty( $instance['link_classes'] ) ? $instance['link_classes'].' ' : '';
            if($layout == '3') $link_classes .= 'cms-hover-move-icon-right'; 

            // Menu icon
            switch ($layout) {
                case '1':
                    $menu_icon = '';
                    $menu_text_class = '';
                    $link_classes .= '';
                    break;
                case '2':
                    $menu_icon = genzia_svgs_icon([
                        'icon'      => 'arrow-right',
                        'icon_size' => 13,
                        'echo'      => false,
                        'class'     => 'menu-icon pt-5'
                    ]);
                    $menu_text_class = 'gap-10';
                    $link_classes .= '';
                    break;
                default:
                    $menu_icon = '';
                    $menu_text_class = '';
                    break;
            }


            /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            printf('%s', $args['before_widget']);

            if ( $title ) {
                printf('%s', $args['before_title'] . $title . $args['after_title']);
            }

            $format = current_theme_supports( 'html5', 'navigation-widgets' ) ? 'html5' : 'xhtml';

            /**
             * Filters the HTML format of widgets with navigation links.
             *
             * @since 1.0
             *
             * @param string $format The type of markup to use in widgets with navigation links.
             *                       Accepts 'html5', 'xhtml'.
             */
            $format = apply_filters( 'cms_navigation_widgets_format', $format );

            if ( 'html5' === $format ) {
                // The title may be filtered: Strip out HTML and make sure the aria-label is never empty.
                $title      = trim( strip_tags( $title ) );
                $aria_label = $title ? $title : $default_title;

                wp_nav_menu([
                    'fallback_cb'          => '',
                    'menu'                 => $nav_menu,
                    'menu_class'           => 'cms-wg-menu cms-wg-menu-'.$layout,  
                    'menu_icon'            => $menu_icon,
                    'container'            => 'nav',
                    'container_aria_label' => $aria_label,
                    'items_wrap'           => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'count'                => $count, 
                    'walker'               => new Genzia_Toggle_Menu_Walker,
                    'link_class'           => $link_classes,
                    'theme_location'       => '',
                    'menu_text_class'      => $menu_text_class 
                ]);
            } else {
                wp_nav_menu([
                    'fallback_cb'    => '',
                    'menu'           => $nav_menu,
                    'menu_class'     => 'cms-wg-menu-'.$layout,  
                    'menu_icon'      => $menu_icon,
                    'count'          => $count, 
                    'walker'         => new Genzia_Toggle_Menu_Walker,
                    'link_class'     => $link_classes,
                    'theme_location' => '',
                    'menu_text_class'=> $menu_text_class 
                ]);
            }

            printf('%s', $args['after_widget']);
        }
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            if ( ! empty( $new_instance['title'] ) ) {
                $instance['title'] = sanitize_text_field( $new_instance['title'] );
            }
            if ( ! empty( $new_instance['layout'] ) ) {
                $instance['layout'] = (int) $new_instance['layout'];
            }
            if ( ! empty( $new_instance['nav_menu'] ) ) {
                $instance['nav_menu'] = (int) $new_instance['nav_menu'];
            }
            if ( ! empty( $new_instance['count'] ) ) {
                $instance['count'] = (int) $new_instance['count'];
            }
            if ( ! empty( $new_instance['link_classes'] ) ) {
                $instance['link_classes'] = $new_instance['link_classes'];
            }
            return $instance;
        }
        public function form( $instance ) {
            global $wp_customize;
            $title        = isset( $instance['title'] ) ? $instance['title'] : '';
            $layout       = isset( $instance['layout'] ) ? $instance['layout'] : '1';
            $nav_menu     = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
            $count        = isset( $instance['count'] ) ? $instance['count'] : '';
            $link_classes = isset( $instance['link_classes'] ) ? $instance['link_classes'] : '';

            // Get menus.
            $menus = wp_get_nav_menus();

            $empty_menus_style     = '';
            $not_empty_menus_style = '';
            if ( empty( $menus ) ) {
                $empty_menus_style = ' style="display:none" ';
            } else {
                $not_empty_menus_style = ' style="display:none" ';
            }

            $nav_menu_style = '';
            if ( ! $nav_menu ) {
                $nav_menu_style = 'display: none;';
            }

            // If no menus exists, direct the user to go and create some.
            ?>
            <p class="nav-menu-widget-no-menus-message" <?php echo esc_attr($not_empty_menus_style); ?>>
                <?php
                if ( $wp_customize instanceof WP_Customize_Manager ) {
                    $url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
                } else {
                    $url = admin_url( 'nav-menus.php' );
                }

                printf(
                    /* translators: %s: URL to create a new menu. */
                    __( 'No menus have been created yet. <a href="%s">Create some</a>.' , 'genzia'),
                    // The URL can be a `javascript:` link, so esc_attr() is used here instead of esc_url().
                    esc_attr( $url )
                );
                ?>
            </p>
            <div class="nav-menu-widget-form-controls" <?php echo esc_attr($empty_menus_style); ?>>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','genzia' ); ?></label>
                    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr( $title ); ?>" />
                </p>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id( 'layout' )); ?>"><?php esc_html_e( 'Layout' ,'genzia'); ?></label>
                    <select id="<?php echo esc_attr($this->get_field_id( 'layout' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'layout' )); ?>">
                        <option value="1" <?php selected( $layout, 1 ); ?>><?php esc_html_e( 'Blog Categories','genzia' ); ?></option>
                        <option value="2" <?php selected( $layout, 2 ); ?>><?php esc_html_e( 'Product Categories','genzia' ); ?></option>
                    </select>
                </p>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id( 'nav_menu' )); ?>"><?php esc_html_e( 'Select Menu:' ,'genzia'); ?></label>
                    <select id="<?php echo esc_attr($this->get_field_id( 'nav_menu' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'nav_menu' )); ?>">
                        <option value="0"><?php esc_html_e( '&mdash; Select &mdash;','genzia' ); ?></option>
                        <?php foreach ( $menus as $menu ) : ?>
                            <option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $nav_menu, $menu->term_id ); ?>>
                                <?php echo esc_html( $menu->name ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id( 'count' )); ?>"><?php esc_html_e( 'Show taxonomy items count?' ,'genzia'); ?></label>
                    <select id="<?php echo esc_attr($this->get_field_id( 'count' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'count' )); ?>">
                        <option value="0"><?php esc_html_e( 'None','genzia' ); ?></option>
                        <option value="1" <?php selected( $count, 1 ); ?>><?php esc_html_e( 'Number with ()','genzia' ); ?></option>
                        <option value="2" <?php selected( $count, 2 ); ?>><?php esc_html_e( 'Number with Text','genzia' ); ?></option>
                        <option value="3" <?php selected( $count, 3 ); ?>><?php esc_html_e( 'Number Circle','genzia' ); ?></option>
                    </select>
                </p>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id( 'link_classes' )); ?>"><?php esc_html_e( 'Link CSS class:','genzia' ); ?></label>
                    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'link_classes' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'link_classes' )); ?>" value="<?php echo esc_attr( $link_classes ); ?>" />
                </p>
                <?php if ( $wp_customize instanceof WP_Customize_Manager ) : ?>
                    <p class="edit-selected-nav-menu" style="<?php echo esc_attr($nav_menu_style); ?>">
                        <button type="button" class="button"><?php esc_html_e( 'Edit Menu','genzia' ); ?></button>
                    </p>
                <?php endif; ?>
            </div>
            <?php
        }
    }
}
/**
 * Widget Categories
 * */
if(function_exists('ctc_register_wp_widget')){
    add_action( 'widgets_init', function(){
        ctc_register_wp_widget( 'CMS_Categories_Widget' );
    });
    class CMS_Categories_Widget extends WP_Widget
    {
        function __construct()
        {
            parent::__construct(
                'cms_categories',
                esc_html__( '*CMS Categories', 'genzia' ),
                array(
                    'description' => esc_attr__( 'A list or dropdown of categories.', 'genzia' ),
                    'customize_selective_refresh' => true,
                )
            );
        }

        function widget( $args, $instance )
        {
            static $first_dropdown = true;

            $default_title = esc_html__( 'Categories', 'genzia' );
            $title         = ! empty( $instance['title'] ) ? $instance['title'] : $default_title;

            /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            $count        = ! empty( $instance['count'] ) ? '1' : '0';
            $hierarchical = ! empty( $instance['hierarchical'] ) ? '1' : '0';
            $dropdown     = ! empty( $instance['dropdown'] ) ? '1' : '0';
            $included_cateogries     = ! empty( $instance['included_cateogries'] ) ? $instance['included_cateogries'] : '';

            printf('%s', $args['before_widget']);

            if ( $title ) {
                printf('%s',  $args['before_title'] . $title . $args['after_title']);
            }

            $cat_args = array(
                'orderby'      => 'name',
                'show_count'   => $count,
                'hierarchical' => $hierarchical,
                'include' => $included_cateogries,
                //'orderby' => 'term_order'
            );

            if ( $dropdown ) {
                printf( '<form action="%s" method="get">', esc_url( home_url() ) );
                $dropdown_id    = ( $first_dropdown ) ? 'cat' : "{$this->id_base}-dropdown-{$this->number}";
                $first_dropdown = false;

                echo '<label class="screen-reader-text" for="' . esc_attr( $dropdown_id ) . '">' . $title . '</label>';

                $cat_args['show_option_none'] = esc_html__( 'Select Category', 'genzia' );
                $cat_args['id']               = $dropdown_id;
                wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $cat_args, $instance ) );

                echo '</form>';
                ?>

                <script>
                /* <![CDATA[ */
                (function() {
                    var dropdown = document.getElementById( "<?php echo esc_js( $dropdown_id ); ?>" );
                    function onCatChange() {
                        if ( dropdown.options[ dropdown.selectedIndex ].value > 0 ) {
                            dropdown.parentNode.submit();
                        }
                    }
                    dropdown.onchange = onCatChange;
                })();
                /* ]]> */
                </script>

            <?php
            } else {
                $format = current_theme_supports( 'html5', 'navigation-widgets' ) ? 'html5' : 'xhtml';

                /** This filter is documented in wp-includes/widgets/class-wp-nav-menu-widget.php */
                $format = apply_filters( 'navigation_widgets_format', $format );

                if ( 'html5' === $format ) {
                    // The title may be filtered: Strip out HTML and make sure the aria-label is never empty.
                    $title      = trim( strip_tags( $title ) );
                    $aria_label = $title ? $title : $default_title;
                    echo '<nav aria-label="' . esc_attr( $aria_label ) . '">';
                }
                ?>

                <ul class="cms-category">
                    <?php
                    $cat_args['title_li'] = '';
                    wp_list_categories( apply_filters( 'widget_categories_args', $cat_args, $instance ) );
                    ?>
                </ul>

                <?php
                if ( 'html5' === $format ) {
                    echo '</nav>';
                }
            }

            printf('%s', $args['after_widget']);
        }

        function update( $new_instance, $old_instance )
        {
            $instance                 = $old_instance;
            $instance['title']        = sanitize_text_field( $new_instance['title'] );
            $instance['count']        = ! empty( $new_instance['count'] ) ? 1 : 0;
            $instance['hierarchical'] = ! empty( $new_instance['hierarchical'] ) ? 1 : 0;
            $instance['dropdown']     = ! empty( $new_instance['dropdown'] ) ? 1 : 0;
            $instance['included_cateogries']     = ! empty( $new_instance['included_cateogries'] ) ? $new_instance['included_cateogries'] : '';

            return $instance;
        }

        function form( $instance )
        {
            // Defaults.
            $instance     = wp_parse_args( (array) $instance, array( 'title' => '' ) );
            $count        = isset( $instance['count'] ) ? (bool) $instance['count'] : false;
            $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
            $dropdown     = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
            $included_cateogries     = isset( $instance['included_cateogries'] ) ? $instance['included_cateogries'] : '';
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__( 'Title', 'genzia' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
            </p>

            <p>
                <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id( 'dropdown' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'dropdown' )); ?>"<?php checked( $dropdown ); ?> />
                <label for="<?php echo esc_attr($this->get_field_id( 'dropdown' )); ?>"><?php echo esc_html__( 'Display as dropdown', 'genzia' ); ?></label>
                <br />

                <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id( 'count' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'count' )); ?>"<?php checked( $count ); ?> />
                <label for="<?php echo esc_attr($this->get_field_id( 'count' )); ?>"><?php echo esc_html__( 'Show post counts', 'genzia' ); ?></label>
                <br />

                <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id( 'hierarchical' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hierarchical' )); ?>"<?php checked( $hierarchical ); ?> />
                <label for="<?php echo esc_attr($this->get_field_id( 'hierarchical' )); ?>"><?php echo esc_html__( 'Show hierarchy', 'genzia' ); ?></label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('included_cateogries')); ?>"><?php echo esc_html__( 'Included Categories', 'genzia' ); ?></label>
                <?php
                $cat_args = array(
                    'walker'       => new Genzia_Walker_CategoryDropdown,
                    'id'           => $this->get_field_id('included_cateogries'),
                    'name'         => $this->get_field_name('included_cateogries') . '[]',
                    'orderby'      => 'name',
                    'show_count'   => true,
                    'hierarchical' => true,
                    'hide_empty'   => false,
                    'multiple'     => true,
                    'selected'     => $included_cateogries,
                );
                wp_dropdown_categories($cat_args);
                ?>
            </p>
            <?php
        }
    }
}

/**
 * Widget Categories
 * Custom HTML output
*/
if(!function_exists('genzia_widget_categories_args')){
    add_filter('widget_categories_args', 'genzia_widget_categories_args');
    add_filter('woocommerce_product_categories_widget_args', 'genzia_widget_categories_args');
    //add_filter('widget_cms_taxonomies_args', 'genzia_widget_categories_args');
    function genzia_widget_categories_args($cat_args){
        $cat_args['walker'] = new Genzia_Categories_Walker_Dropdown;
        return $cat_args; 
    }
}

class Genzia_Walker_CategoryDropdown extends Walker {

    /**
     * What the class handles.
     *
     * @since 2.1.0
     * @var string
     *
     * @see Walker::$tree_type
     */
    public $tree_type = 'category';

    /**
     * Database fields to use.
     *
     * @since 2.1.0
     * @todo Decouple this
     * @var string[]
     *
     * @see Walker::$db_fields
     */
    public $db_fields = array(
        'parent' => 'parent',
        'id'     => 'term_id',
    );

    /**
     * Starts the element output.
     *
     * @since 2.1.0
     * @since 5.9.0 Renamed `$category` to `$data_object` and `$id` to `$current_object_id`
     *              to match parent class for PHP 8 named parameter support.
     *
     * @see Walker::start_el()
     *
     * @param string  $output            Used to append additional content (passed by reference).
     * @param WP_Term $data_object       Category data object.
     * @param int     $depth             Depth of category. Used for padding.
     * @param array   $args              Uses 'selected', 'show_count', and 'value_field' keys, if they exist.
     *                                   See wp_dropdown_categories().
     * @param int     $current_object_id Optional. ID of the current category. Default 0.
     */
    public function start_el( &$output, $data_object, $depth = 0, $args = array(), $current_object_id = 0 ) {
        // Restores the more descriptive, specific name for use within this method.
        $category = $data_object;
        $pad      = str_repeat( '&nbsp;', $depth * 3 );

        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters( 'list_cats', $category->name, $category );

        if ( isset( $args['value_field'] ) && isset( $category->{$args['value_field']} ) ) {
            $value_field = $args['value_field'];
        } else {
            $value_field = 'term_id';
        }

        $output .= "\t<option class=\"level-$depth\" value=\"" . esc_attr( $category->{$value_field} ) . '"';

        // Type-juggling causes false matches, so we force everything to a string.

        $selected = $args['selected'];
        if(is_array($selected)){
            if (in_array((string) $category->{$value_field}, $selected)) {
                $output .= ' selected="selected"';
            }
        }
        else{
            if ( (string) $category->{$value_field} === (string) $args['selected'] ) {
                $output .= ' selected="selected"';
            }
        }
        
        $output .= '>';
        $output .= $pad . $cat_name;
        if ( $args['show_count'] ) {
            $output .= '&nbsp;&nbsp;(' . number_format_i18n( $category->count ) . ')';
        }
        $output .= "</option>\n";
    }
}

/**
 * Genzia_Categories_Walker_Tree
 *
 * @package CMS Theme
 * @subpackage 
 * @since 1.0
 *
 */
class Genzia_Categories_Walker_Tree extends Walker_Category {
    /**
     * Starts the list before the elements are added.
     *
     * @since 2.1.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Used to append additional content. Passed by reference.
     * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
     * @param array  $args   Optional. An array of arguments. Will only append content if style argument
     *                       value is 'list'. See wp_list_categories(). Default empty array.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' !== $args['style'] ) {
            return;
        }

        $indent  = str_repeat( "\t", $depth );
        $output .= "$indent<ul class='cms-children cms-tree'>\n";
    }
    /**
     * Starts the element output.
     *
     * @since 2.1.0
     *
     * @see Walker::start_el()
     *
     * @param string $output   Used to append additional content (passed by reference).
     * @param object $category Category data object.
     * @param int    $depth    Optional. Depth of category in reference to parents. Default 0.
     * @param array  $args     Optional. An array of arguments. See wp_list_categories(). Default empty array.
     * @param int    $id       Optional. ID of the current category. Default 0.
     */
    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters(
            'list_cats',
            esc_attr( $category->name ),
            $category
        );
 
        // Don't generate an element if the category name is empty.
        if ( ! $cat_name ) {
            return;
        }
 
        $link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';
        if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
            /**
             * Filters the category description for display.
             *
             * @since 1.2.0
             *
             * @param string $description Category description.
             * @param object $category    Category object.
             */
            $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
        }
 
        $link .= '>';

        if ( $args['has_children'] && $args['hierarchical'] && ( empty( $args['max_depth'] ) || $args['max_depth'] > $depth + 1 ) ) {
            $link .= '<span class="title">'.$cat_name.'</span>';
            if ( ! empty( $args['show_count'] ) ) {
                $link .= ' <span class="count">' . number_format_i18n( $category->count ) . '</span>';
            }
        } else {
            $link .= '<span class="title">'.$cat_name.'</span>';
            if ( ! empty( $args['show_count'] ) ) {
                $link .= ' <span class="count">' . number_format_i18n( $category->count ) . '</span>';
            }
        }

        $link .= '</a>';

        if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
            $link .= ' ';
 
            if ( empty( $args['feed_image'] ) ) {
                $link .= '(';
            }
 
            $link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';
 
            if ( empty( $args['feed'] ) ) {
                $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s','genzia' ), $cat_name ) . '"';
            } else {
                $alt = ' alt="' . $args['feed'] . '"';
                $name = $args['feed'];
                $link .= empty( $args['title'] ) ? '' : $args['title'];
            }
 
            $link .= '>';
 
            if ( empty( $args['feed_image'] ) ) {
                $link .= $name;
            } else {
                $link .= "<img src='" . $args['feed_image'] . "'$alt" . ' />';
            }
            $link .= '</a>';
 
            if ( empty( $args['feed_image'] ) ) {
                $link .= ')';
            }
        }
        if ( 'list' == $args['style'] ) {
            $output .= "\t<li";
            $css_classes = array(
                'cms-item',
                'cms-menu-item'
            );
            if($args['has_children']){
                $css_classes[] =  'parents';
            }
            if ( ! empty( $args['current_category'] ) ) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms( $category->taxonomy, array(
                    'include' => $args['current_category'],
                    'hide_empty' => false,
                ) );
 
                foreach ( $_current_terms as $_current_term ) {
                    if ( $category->term_id == $_current_term->term_id ) {
                        $css_classes[] = 'current current-cat';
                    } elseif ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] = 'current-parent current-cat-parent';
                    }
                    while ( $_current_term->parent ) {
                        if ( $category->term_id == $_current_term->parent ) {
                            $css_classes[] =  'current-ancestor current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                    }
                }
            }
 
            /**
             * Filters the list of CSS classes to include with each category in the list.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             * @param array  $css_classes An array of CSS classes to be applied to each list item.
             * @param object $category    Category data object.
             * @param int    $depth       Depth of page, used for padding.
             * @param array  $args        An array of wp_list_categories() arguments.
             */
            $css_classes = implode( ' ', apply_filters( 'cms_tree_category_css_class', $css_classes, $category, $depth, $args ) );
 
            $output .=  ' class="' . $css_classes . '"';
            $output .= ">$link\n";
        } elseif ( isset( $args['separator'] ) ) {
            $output .= "\t$link" . $args['separator'] . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    }
}
/**
 * Genzia_Categories_Walker_Dropdown
 *
 * @version 1.0
 * @package 
 * @since   1.0
 *
 */
class Genzia_Categories_Walker_Dropdown extends Walker_Category {
    /**
     * Starts the list before the elements are added.
     *
     * @since 2.1.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Used to append additional content. Passed by reference.
     * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
     * @param array  $args   Optional. An array of arguments. Will only append content if style argument
     *                       value is 'list'. See wp_list_categories(). Default empty array.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' !== $args['style'] ) {
            return;
        }

        $indent  = str_repeat( "\t", $depth );
        $output .= "$indent<ul class='children cms-dropdown'>\n";
    }
    /**
     * Starts the element output.
     *
     * @since 2.1.0
     *
     * @see Walker::start_el()
     *
     * @param string $output   Used to append additional content (passed by reference).
     * @param object $category Category data object.
     * @param int    $depth    Optional. Depth of category in reference to parents. Default 0.
     * @param array  $args     Optional. An array of arguments. See wp_list_categories(). Default empty array.
     * @param int    $id       Optional. ID of the current category. Default 0.
     */
    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters(
            'list_cats',
            esc_attr( $category->name ),
            $category
        );
 
        // Don't generate an element if the category name is empty.
        if ( ! $cat_name ) {
            return;
        }
 
        $link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';
        if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
            /**
             * Filters the category description for display.
             *
             * @since 1.2.0
             *
             * @param string $description Category description.
             * @param object $category    Category object.
             */
            $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
        }
 
        $link .= '>';

        $title_class = 'title';
        // 'current_category' can be an array, so we use `get_terms()`.
        $_current_terms = get_terms( $category->taxonomy, array(
            'include' => $args['current_category'],
            'hide_empty' => false,
        ) );
        foreach ( $_current_terms as $_current_term ) {
            if ( $category->term_id == $_current_term->term_id && is_category()) {
                $title_class .= ' current';
            }
        }

        if ( $args['has_children'] && $args['hierarchical'] && ( empty( $args['max_depth'] ) || $args['max_depth'] > $depth + 1 ) ) {
            $link .= '<span class="'.$title_class.'">'.$cat_name.'</span>';
            if ( ! empty( $args['show_count'] ) ) {
                //$link .= ' <span class="count">' . number_format_i18n( $category->count ) . '</span>';
            }
            $dropdown_arrow = '<span class="cms-menu-toggle"></span>';
        } else {
            $link .= '<span class="'.$title_class.'">'.$cat_name.'</span>';
            if ( ! empty( $args['show_count'] ) ) {
                $link .= ' <span class="count">' . number_format_i18n( $category->count ) . '</span>';
            }
            $dropdown_arrow = '';
        }

        $link .= $dropdown_arrow.'</a>';
        
        if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
            $link .= ' ';
 
            if ( empty( $args['feed_image'] ) ) {
                $link .= '(';
            }
 
            $link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';
 
            if ( empty( $args['feed'] ) ) {
                $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s','genzia' ), $cat_name ) . '"';
            } else {
                $alt = ' alt="' . $args['feed'] . '"';
                $name = $args['feed'];
                $link .= empty( $args['title'] ) ? '' : $args['title'];
            }
 
            $link .= '>';
 
            if ( empty( $args['feed_image'] ) ) {
                $link .= $name;
            } else {
                $link .= "<img src='" . $args['feed_image'] . "'$alt" . ' />';
            }
            $link .= '</a>';
 
            if ( empty( $args['feed_image'] ) ) {
                $link .= ')';
            }
        }
        if ( 'list' == $args['style'] ) {
            $output .= "\t<li";
            $css_classes = array(
                'cms-list-item',
                'cms-widget-menu-item'
            );
            if($args['has_children']){
                $css_classes[] = 'parents';
            }
            if ( ! empty( $args['current_category'] ) ) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms( $category->taxonomy, array(
                    'include' => $args['current_category'],
                    'hide_empty' => false,
                ) );
 
                foreach ( $_current_terms as $_current_term ) {
                    if ( $category->term_id == $_current_term->term_id ) {
                        $css_classes[] = 'current current-cat';
                    } elseif ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] = 'current-parent current-cat-parent';
                    }
                    while ( $_current_term->parent ) {
                        if ( $category->term_id == $_current_term->parent ) {
                            $css_classes[] =  'current-ancestor current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                    }
                }
            }
 
            /**
             * Filters the list of CSS classes to include with each category in the list.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             * @param array  $css_classes An array of CSS classes to be applied to each list item.
             * @param object $category    Category data object.
             * @param int    $depth       Depth of page, used for padding.
             * @param array  $args        An array of wp_list_categories() arguments.
             */
            $css_classes = implode( ' ', apply_filters( 'cms_dropdown_category_css_class', $css_classes, $category, $depth, $args ) );
 
            $output .=  ' class="' . $css_classes . '"';
            $output .= ">$link\n";
        } elseif ( isset( $args['separator'] ) ) {
            $output .= "\t$link" . $args['separator'] . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    }
}

/**
 * Widget Tag Cloud WP 
 * Change separator text, font size, ...
 * Hook filter: widget_tag_cloud_args, woocommerce_product_tag_cloud_widget_args
 * 
 * @package CMS Theme
 * @subpackage 
 * @since 1.0
 * 
*/
add_filter('widget_tag_cloud_args', 'genzia_widget_tag_cloud_args');
add_filter('woocommerce_product_tag_cloud_widget_args', 'genzia_widget_tag_cloud_args');
if(!function_exists('genzia_widget_tag_cloud_args')){
    function genzia_widget_tag_cloud_args($args){
        $_args =[
            'smallest'  => 12,
            'largest'   => 12,
            'unit'      => 'px',
            'separator' => '',
            'format'    => 'list' // list, flat
        ];
        $args = wp_parse_args($args, $_args);
        return $args;
    }
}

if(!function_exists('genzia_wp_dropdown_cats')){
    add_filter('wp_dropdown_cats', 'genzia_wp_dropdown_cats', 10, 2);
    function genzia_wp_dropdown_cats($output, $parsed_args){
        $output = preg_replace('/<select([^>]*)>/', '<select$1 egrid-products-category-filter>', $output);
        if(isset($parsed_args['multiple']) && $parsed_args['multiple'] == true){
            $output = preg_replace('/<select([^>]*)>/', '<select$1 multiple>', $output);
        }

        return $output;
    }
}

/**
 * Widget API: Genzia_Widget_Media_Gallery class
 *
 * @package CMS Theme
 * @subpackage 
 * @since 1.0.0
 */
if(function_exists('ctc_register_wp_widget')){
    add_action( 'widgets_init', function(){
        ctc_register_wp_widget( 'Genzia_Widget_Media_Gallery' );
    });
    class Genzia_Widget_Media_Gallery extends WP_Widget_Media {
        /**
         * Constructor.
         *
         * @since 1.0.0
         */
        public function __construct() {
            parent::__construct(
                'cms_media_gallery',
                __( '*CMS Gallery', 'genzia' ),
                array(
                    'description' => __( 'Displays an image gallery.','genzia' ),
                    'mime_type'   => 'image',
                )
            );

            $this->l10n = array_merge(
                $this->l10n,
                array(
                    'no_media_selected' => __( 'No images selected', 'genzia' ),
                    'add_media'         => _x( 'Add Images', 'label for button in the gallery widget; should not be longer than ~13 characters long', 'genzia' ),
                    'replace_media'     => '',
                    'edit_media'        => _x( 'Edit Gallery', 'label for button in the gallery widget; should not be longer than ~13 characters long' , 'genzia'),
                )
            );
        }
        /**
         * Get schema for properties of a widget instance (item).
         *
         * @since 1.0.0
         *
         * @see WP_REST_Controller::get_item_schema()
         * @see WP_REST_Controller::get_additional_fields()
         * @link https://core.trac.wordpress.org/ticket/35574
         *
         * @return array Schema for properties.
         */
        public function get_instance_schema() {
            $schema = array(
                'title'          => array(
                    'type'                  => 'string',
                    'default'               => '',
                    'sanitize_callback'     => 'sanitize_text_field',
                    'description'           => __( 'Title for the widget', 'genzia' ),
                    'should_preview_update' => false,
                ),
                'custom_url'          => array(
                    'type'                  => 'string',
                    'default'               => '',
                    'sanitize_callback'     => 'sanitize_text_field',
                    'description'           => __( 'Custom URL', 'genzia' ),
                    'should_preview_update' => false,
                ),
                'image_size_w'          => array(
                    'type'                  => 'string',
                    'default'               => 90,
                    //'sanitize_callback'     => 'sanitize_text_field',
                    'description'           => __( 'Image Size Width', 'genzia' ),
                    //'should_preview_update' => false,
                ),
                'image_size_h'          => array(
                    'type'                  => 'string',
                    'default'               => 90,
                    //'sanitize_callback'     => 'sanitize_text_field',
                    'description'           => __( 'Image Size Height', 'genzia' ),
                    //'should_preview_update' => false,
                ),
                'ids'            => array(
                    'type'              => 'array',
                    'items'             => array(
                        'type' => 'integer',
                    ),
                    'default'           => array(),
                    'sanitize_callback' => 'wp_parse_id_list',
                ),
                'columns'        => array(
                    'type'    => 'integer',
                    'default' => 3,
                    'minimum' => 1,
                    'maximum' => 6,
                ),
                'size'           => array(
                    'type'    => 'string',
                    'enum'    => array_merge( get_intermediate_image_sizes()), // array( 'full', 'custom' ) 
                    'default' => 'thumbnail',
                ),
                'link_type'      => array(
                    'type'                  => 'string',
                    'enum'                  => array( 'none' ), //'post', 'file',
                    'default'               => 'none',
                    'media_prop'            => 'link',
                    'should_preview_update' => false,
                ),
                'orderby_random' => array(
                    'type'                  => 'boolean',
                    'default'               => false,
                    'media_prop'            => '_orderbyRandom',
                    'should_preview_update' => false,
                ),
            );

            /** This filter is documented in wp-includes/widgets/class-wp-widget-media.php */
            $schema = apply_filters( "widget_{$this->id_base}_instance_schema", $schema, $this );

            return $schema;
        }

        /**
         * Render the media on the frontend.
         *
         * @since 1.0.0
         *
         * @param array $instance Widget instance props.
         */
        public function render_media( $instance ) {
            $instance = array_merge( wp_list_pluck( $this->get_instance_schema(), 'default' ), $instance );
            $shortcode_atts = array_merge(
                $instance,
                array(
                    'link' => $instance['link_type'],
                )
            );
            // @codeCoverageIgnoreStart
            if ( $instance['orderby_random'] ) {
                $shortcode_atts['orderby'] = 'rand';
            }
            // @codeCoverageIgnoreEnd
            //echo gallery_shortcode( $shortcode_atts );
            // Custom layout
            $custom_image_size_w = !empty($instance['image_size_w']) && is_numeric($instance['image_size_w']) ? $instance['image_size_w'] : '';
            $custom_image_size_h = !empty($instance['image_size_h']) && is_numeric($instance['image_size_h']) ? $instance['image_size_h'] : $custom_image_size_w;
            $custom_image_size = [$custom_image_size_w, $custom_image_size_h];
            //
            $image_size = (!empty($custom_image_size_w) || !empty($custom_image_size_h)) ? $custom_image_size : $instance['size'];
        ?>
            <div class="cms-wg-gallery d-flex flex-col-<?php echo esc_attr($instance['columns']); ?> gutter-10">
                <?php foreach ($instance['ids'] as $key => $id) {
                ?>
                    <a href="<?php echo esc_url($instance['custom_url']) ?>" class="cms-hover-change relative">
                        <span class="gallery-icon cms-box-48 circle absolute center cms-transition cms-hover-show bg-white text-menu bg-hover-accent-regular text-hover-white"><?php 
                            genzia_svgs_icon([
                                'icon'      => 'core/instagram',
                                'icon_size' => 20
                            ]);
                        ?></span>
                        <?php 
                            echo wp_get_attachment_image($id, $image_size, false, ['loading' => 'lazy']); 
                        ?>
                    </a>
                <?php
                } ?>
            </div>
        <?php
        }

        /**
         * Loads the required media files for the media manager and scripts for media widgets.
         *
         * @since 1.0.0
         */
        public function enqueue_admin_scripts() {
            parent::enqueue_admin_scripts();

            $handle = 'cms-media-gallery-widget';
            wp_enqueue_script( $handle );

            $exported_schema = array();
            foreach ( $this->get_instance_schema() as $field => $field_schema ) {
                $exported_schema[ $field ] = wp_array_slice_assoc( $field_schema, array( 'type', 'default', 'enum', 'minimum', 'format', 'media_prop', 'should_preview_update', 'items' ) );
            }
            wp_add_inline_script(
                $handle,
                sprintf(
                    'wp.mediaWidgets.modelConstructors[ %s ].prototype.schema = %s;',
                    wp_json_encode( $this->id_base ),
                    wp_json_encode( $exported_schema )
                )
            );

            wp_add_inline_script(
                $handle,
                sprintf(
                    '
                        wp.mediaWidgets.controlConstructors[ %1$s ].prototype.mime_type = %2$s;
                        _.extend( wp.mediaWidgets.controlConstructors[ %1$s ].prototype.l10n, %3$s );
                    ',
                    wp_json_encode( $this->id_base ),
                    wp_json_encode( $this->widget_options['mime_type'] ),
                    wp_json_encode( $this->l10n )
                )
            );
        }
        /**
     * Render form template scripts.
     *
     * @since 4.9.0
     */
    public function render_control_template_scripts() {
        //parent::render_control_template_scripts();
        ?>
        <script type="text/html" id="tmpl-widget-media-<?php echo esc_attr( $this->id_base ); ?>-control">
            <# var elementIdPrefix = 'el' + String( Math.random() ) + '_' #>
            <p>
                <label for="{{ elementIdPrefix }}title"><?php esc_html_e( 'Title:', 'genzia' ); ?></label>
                <input id="{{ elementIdPrefix }}title" type="text" class="widefat title">
            </p>
            <p>
                <label for="{{ elementIdPrefix }}custom_url"><?php esc_html_e( 'Custom URL', 'genzia' ); ?></label>
                <input id="{{ elementIdPrefix }}custom_url" type="text" class="widefat custom_url">
            </p>
            <table>
                <tr><td colspan="2"><strong><?php esc_html_e( 'Image Size (Number Only!)', 'genzia' ); ?></strong></td></tr>
                <tr>
                    <td>
                        <?php // Image size Width ?>
                        <label for="{{ elementIdPrefix }}image_size_w"><?php esc_html_e( 'Width', 'genzia' ); ?></label>
                        <input id="{{ elementIdPrefix }}image_size_w" type="number" class="widefat image_size_w">
                        <?php // Image Size Height ?>
                    </td>
                    <td>
                        <label for="{{ elementIdPrefix }}image_size_h"><?php esc_html_e( 'Height', 'genzia' ); ?></label>
                        <input id="{{ elementIdPrefix }}image_size_h" type="number" class="widefat image_size_h">
                    </td>
                </tr>
            </table>
            <p></p>
            <div class="media-widget-preview <?php echo esc_attr( $this->id_base ); ?>">
                <div class="attachment-media-view">
                    <button type="button" class="select-media button-add-media not-selected">
                        <?php echo esc_html( $this->l10n['add_media'] ); ?>
                    </button>
                </div>
            </div>
            <p class="media-widget-buttons">
                <button type="button" class="button edit-media selected">
                    <?php echo esc_html( $this->l10n['edit_media'] ); ?>
                </button>
            <?php if ( ! empty( $this->l10n['replace_media'] ) ) : ?>
                <button type="button" class="button change-media select-media selected">
                    <?php echo esc_html( $this->l10n['replace_media'] ); ?>
                </button>
            <?php endif; ?>
            </p>
            <div class="media-widget-fields">
            </div>
        </script>
        <script type="text/html" id="tmpl-wp-media-widget-gallery-preview">
            <#
            var ids = _.filter( data.ids, function( id ) {
                return ( id in data.attachments );
            } );
            #>
            <# if ( ids.length ) { #>
                <ul class="gallery media-widget-gallery-preview" role="list">
                    <# _.each( ids, function( id, index ) { #>
                        <# var attachment = data.attachments[ id ]; #>
                        <# if ( index < 6 ) { #>
                            <li class="gallery-item">
                                <div class="gallery-icon">
                                    <img alt="{{ attachment.alt }}"
                                        <# if ( index === 5 && data.ids.length > 6 ) { #> aria-hidden="true" <# } #>
                                        <# if ( attachment.sizes.thumbnail ) { #>
                                            src="{{ attachment.sizes.thumbnail.url }}" width="{{ attachment.sizes.thumbnail.width }}" height="{{ attachment.sizes.thumbnail.height }}"
                                        <# } else { #>
                                            src="{{ attachment.url }}"
                                        <# } #>
                                        <# if ( ! attachment.alt && attachment.filename ) { #>
                                            aria-label="
                                            <?php
                                            echo esc_attr(
                                                sprintf(
                                                    /* translators: %s: The image file name. */
                                                    esc_html__( 'The current image has no alternative text. The file name is: %s' , 'genzia'),
                                                    '{{ attachment.filename }}'
                                                )
                                            );
                                            ?>
                                            "
                                        <# } #>
                                    />
                                    <# if ( index === 5 && data.ids.length > 6 ) { #>
                                    <div class="gallery-icon-placeholder">
                                        <p class="gallery-icon-placeholder-text" aria-label="
                                        <?php
                                            printf(
                                                /* translators: %s: The amount of additional, not visible images in the gallery widget preview. */
                                                __( 'Additional images added to this gallery: %s', 'genzia' ),
                                                '{{ data.ids.length - 5 }}'
                                            );
                                        ?>
                                        ">+{{ data.ids.length - 5 }}</p>
                                    </div>
                                    <# } #>
                                </div>
                            </li>
                        <# } #>
                    <# } ); #>
                </ul>
            <# } else { #>
                <div class="attachment-media-view">
                    <button type="button" class="placeholder button-add-media"><?php echo esc_html( $this->l10n['add_media'] ); ?></button>
                </div>
            <# } #>
        </script>
        <?php
        }
        protected function has_content( $instance ) {
            if ( ! empty( $instance['ids'] ) ) {
                $attachments = wp_parse_id_list( $instance['ids'] );
                foreach ( $attachments as $attachment ) {
                    if ( 'attachment' !== get_post_type( $attachment ) ) {
                        return false;
                    }
                }
                return true;
            }
            return false;
        }
    }
}
/**
 * Follow Us widgets
 *
 * @package CMS Theme
 * @subpackage Spark AI
 * @since 1.0
 * 
 */
if(function_exists('ctc_register_wp_widget')){
    add_action( 'widgets_init', function(){
        ctc_register_wp_widget( 'CMS_Follow_Us_Widget' );
    });

    class CMS_Follow_Us_Widget extends WP_Widget
    {
        function __construct()
        {
            parent::__construct(
                'cms_follow_us',
                esc_html__( '*CMS Follow Us', 'genzia' ),
                array(
                    'description' => esc_attr__( 'Shows your social networks.', 'genzia' ),
                    'customize_selective_refresh' => true,
                )
            );
        }

        /**
         * Outputs the HTML for this widget.
         *
         * @param array $args An array of standard parameters for widgets in this theme
         * @param array $instance An array of settings for this widget instance
         * @return void Echoes it's output
         **/
        function widget( $args, $instance )
        {
            $instance = wp_parse_args( (array) $instance, array(
                'title'   => '',
                'url1'    => 'https://facebook.com/',
                'icon1'   => 'facebook',
                'url2'    => 'https://instagram.com/',
                'icon2'   => 'instagram',
                'url3'    => 'https://tiktok.com/',
                'icon3'   => 'tik-tok', 
                'url4'    => 'https://x.com/',
                'icon4'   => 'x', 
                'url5'    => '',
                'icon5'   => '',
                'url6'    => '',
                'icon6'   => '', 
            ) );
            $title = empty( $instance['title'] ) ? '' : $instance['title'];
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            printf( '%s', $args['before_widget']);

            if(!empty($title)){
                printf( '%s %s %s', $args['before_title'] , $title , $args['after_title']);
            }
        ?>
        <div class="cms-wg-follow-us">
            <?php  if(!empty($instance['url1']) && !empty($instance['icon1'])){ ?>
                <a href="<?php echo esc_url($instance['url1']) ?>" target="_blank" class="text-20"><?php
                    genzia_svgs_icon([
                        'icon'      => 'core/'.$instance['icon1'],
                        'icon_size' => 20
                    ]);
                ?></a>
            <?php }
            if(!empty($instance['url2']) && !empty($instance['icon2'])){ ?>
                <a href="<?php echo esc_url($instance['url2']) ?>" target="_blank" class="text-20"><?php
                    genzia_svgs_icon([
                        'icon'      => 'core/'.$instance['icon2'],
                        'icon_size' => 20
                    ]);
                ?></a>
            <?php }
            if(!empty($instance['url3']) && !empty($instance['icon3'])){ ?>
                <a href="<?php echo esc_url($instance['url3']) ?>" target="_blank" class="text-20"><?php
                    genzia_svgs_icon([
                        'icon'      => 'core/'.$instance['icon3'],
                        'icon_size' => 20
                    ]);
                ?></a>
            <?php }
            if(!empty($instance['url4']) && !empty($instance['icon4'])){ ?>
                <a href="<?php echo esc_url($instance['url4']) ?>" target="_blank" class="text-20"><?php
                    genzia_svgs_icon([
                        'icon'      => 'core/'.$instance['icon4'],
                        'icon_size' => 20
                    ]);
                ?></a>
            <?php }
            if(!empty($instance['url5']) && !empty($instance['icon5'])){ ?>
                <a href="<?php echo esc_url($instance['url5']) ?>" target="_blank" class="text-20"><?php
                    genzia_svgs_icon([
                        'icon'      => 'core/'.$instance['icon5'],
                        'icon_size' => 20
                    ]);
                ?></a>
            <?php }
            if(!empty($instance['url6']) && !empty($instance['icon6'])){ ?>
                <a href="<?php echo esc_url($instance['url6']) ?>" target="_blank" class="text-20"><?php
                    genzia_svgs_icon([
                        'icon'      => 'core/'.$instance['icon6'],
                        'icon_size' => 20
                    ]);
                ?></a>
            <?php } ?>
        </div>
        <?php
            printf('%s', $args['after_widget']);
        }

        /**
         * Deals with the settings when they are saved by the admin. Here is
         * where any validation should be dealt with.
         *
         * @param array $new_instance An array of new settings as submitted by the admin
         * @param array $old_instance An array of the previous settings
         * @return array The validated and (if necessary) amended settings
         **/
        function update( $new_instance, $old_instance )
        {
            $instance          = $old_instance;
            $instance['title'] = sanitize_text_field( $new_instance['title'] );

            $instance['url1']  = $new_instance['url1'];
            $instance['icon1'] = $new_instance['icon1'];
            $instance['url2']  = $new_instance['url2'];
            $instance['icon2'] = $new_instance['icon2'];
            $instance['url3']  = $new_instance['url3'];
            $instance['icon3'] = $new_instance['icon3'];
            $instance['url4']  = $new_instance['url4'];
            $instance['icon4'] = $new_instance['icon4'];
            $instance['url5']  = $new_instance['url5'];
            $instance['icon5'] = $new_instance['icon5'];
            $instance['url6']  = $new_instance['url6'];
            $instance['icon6'] = $new_instance['icon6'];

            return $instance;
        }

        /**
         * Displays the form for this widget on the Widgets page of the WP Admin area.
         *
         * @param array $instance An array of the current settings for this widget
         * @return void Echoes it's output
         **/
        function form( $instance )
        {
            $instance = wp_parse_args( (array) $instance, array(
                'title'   => esc_html__( 'CMS Follow Us', 'genzia' ),
                'url1'    => 'https://facebook.com/',
                'icon1'   => 'facebook',
                'url2'    => 'https://instagram.com/',
                'icon2'   => 'instagram',
                'url3'    => 'https://tiktok.com/',
                'icon3'   => 'tik-tok', 
                'url4'    => 'https://twitter.com/',
                'icon4'   => 'twitter', 
                'url5'    => '',
                'icon5'   => '',
                'url6'    => '',
                'icon6'   => '', 
            ) );
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'genzia' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
            </p>
            <?php for ($i=1; $i <= 6 ; $i++) { ?>
                <table>
                    <tr><td colspan="2"><strong><?php echo esc_html__('Network','genzia').' '.$i; ?></strong></td></tr>
                    <tr>
                        <td>
                            <label for="<?php echo esc_attr($this->get_field_id( 'url'.$i ) ); ?>"><?php echo esc_html__( 'Url', 'genzia' ); ?></label>
                            <input class="" id="<?php echo esc_attr($this->get_field_id( 'url'.$i ) ); ?>" name="<?php echo esc_attr($this->get_field_name( 'url'.$i ) ); ?>" type="text" value="<?php echo esc_attr( $instance['url'.$i]); ?>" />
                        </td>
                        <td>
                            <label for="<?php echo esc_attr($this->get_field_id( 'icon'.$i ) ); ?>"><?php echo esc_html__( 'Icon', 'genzia' ); ?></label>
                            <input class="" id="<?php echo esc_attr($this->get_field_id( 'icon'.$i ) ); ?>" name="<?php echo esc_attr($this->get_field_name( 'icon'.$i ) ); ?>" type="text" value="<?php echo esc_attr( $instance['icon'.$i] ); ?>" />
                        </td>
                    </tr>
                </table>
                <?php
            }
        }
    }
}

/**
 * Call To Action widgets
 *
 * @package CMS Theme
 * @subpackage Spark AI
 * @since 1.0
 * 
 */
if(function_exists('ctc_register_wp_widget')){
    add_action( 'widgets_init', function(){
        ctc_register_wp_widget( 'CMS_CTA' );
    });
    // Enqueue additional admin scripts
    add_action('admin_enqueue_scripts', 'ctup_cta_script');
    function ctup_cta_script() {
        wp_enqueue_media();
        wp_enqueue_script('cms-widget', get_template_directory_uri() . '/assets/admin/widget.js', [], '1.0.0', true);
    }
    // Widget
    class CMS_CTA extends WP_Widget {
        function __construct(){
            parent::__construct(
                'cms_cta',
                esc_html__( '*CMS CTA', 'genzia' ),
                array(
                    'description' => esc_attr__( 'CMS Call to Action.', 'genzia' ),
                    'customize_selective_refresh' => true,
                )
            );
        }

        function widget($args, $instance) {
            $instance = wp_parse_args( (array) $instance, array(
                'title'     => '',
                'desc'      => '',
                'btn_text'  => '',
                'btn_link'  => '',
                'email'     => '',
                'image_uri' => '',
                'image_id'  => ''
            ) );
            $title = empty( $instance['title'] ) ? '' : $instance['title'];
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            printf( '%s', $args['before_widget']);
            //
            if(!empty($title)){
                //printf( '%s %s %s', $args['before_title'] , $title , $args['after_title']);
            }
        if(!empty($instance['image_uri'])){
    ?>
        <div class="bg-gradient-1 cms-overlay"></div>
        <img src="<?php echo esc_url($instance['image_uri']); ?>" class="cms-overlay img-cover" alt="<?php echo get_bloginfo('name'); ?>" title="<?php echo get_bloginfo('name'); ?>" />
    <?php } ?>
        <div class="cms--widget relative z-top text-white">
            <?php if(!empty($instance['title'])){ ?>
                <h3 class="heading text-24 text-white mt-n5">
                    <?php echo esc_html($instance['title']); ?>
                </h3>
            <?php } ?>
            <?php if(!empty($instance['desc'])){ ?>
                <div class="cms-desc text-grey text-16 lh-1625 pt-20">
                    <?php echo esc_html($instance['desc']); ?>
                </div>
            <?php } ?>
            <?php if(!empty($instance['btn_text'])){ ?>
                <a href="<?php echo esc_url($instance['btn_link']); ?>" class="btn bg-white text-menu bg-gradient-hover-1 text-hover-white w-100 justify-content-between mt" style="--mt:100px;">
                    <?php 
                        // text
                        echo esc_html($instance['btn_text']); 
                        // icon
                        genzia_svgs_icon([
                            'icon'  => 'arrow-right',
                            'class' => 'text-15'
                        ]);
                    ?>
                </a>
            <?php } ?>
            <?php if(!empty($instance['email'])){ ?>
                <div class="text-center pt-20">
                    <a href="mailto:<?php echo esc_url($instance['email']); ?>" class="text-center text-white text-hover-white text-16 cms-hover-underline">
                        <?php echo esc_html($instance['email']); ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php
            printf( '%s', $args['after_widget']);

        }

        function update($new_instance, $old_instance) {
            $instance              = $old_instance;
            $instance['title']     = sanitize_text_field( $new_instance['title'] );
            $instance['desc']      = sanitize_text_field( $new_instance['desc'] );
            $instance['btn_text']  = sanitize_text_field( $new_instance['btn_text'] );
            $instance['btn_link']  = $new_instance['btn_link'];
            $instance['email']     = $new_instance['email'];
            $instance['image_uri'] = $new_instance['image_uri'];
            $instance['image_id']  = $new_instance['image_id'];
            return $instance;
        }

        function form($instance) {
            $instance = wp_parse_args( (array) $instance, array(
                'title'     => '',
                'desc'      => '',
                'btn_text'  => '',
                'btn_link'  => '',
                'email'     => '',
                'image_uri' => '',
                'image_id'  => ''
            ) );
    ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title','genzia'); ?></label>
            <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('desc')); ?>"><?php esc_html_e('Description','genzia'); ?></label>
            <textarea name="<?php echo esc_attr($this->get_field_name('desc')); ?>" rows="10" id="<?php echo esc_attr($this->get_field_id('desc')); ?>" class="widefat" ><?php echo esc_html($instance['desc']); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('btn_text')); ?>"><?php esc_html_e('Button Text','genzia'); ?></label>
            <input type="text" name="<?php echo esc_attr($this->get_field_name('btn_text')); ?>" id="<?php echo esc_attr($this->get_field_id('btn_text')); ?>" value="<?php echo esc_attr($instance['btn_text']); ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('btn_link')); ?>"><?php esc_html_e('Button Link','genzia'); ?></label>
            <input type="text" name="<?php echo esc_attr($this->get_field_name('btn_link')); ?>" id="<?php echo esc_attr($this->get_field_id('btn_link')); ?>" value="<?php echo esc_attr($instance['btn_link']); ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('email')); ?>"><?php esc_html_e('Email','genzia'); ?></label>
            <input type="text" name="<?php echo esc_attr($this->get_field_name('email')); ?>" id="<?php echo esc_attr($this->get_field_id('email')); ?>" value="<?php echo esc_attr($instance['email']); ?>" class="widefat" />
        </p>
        <div>
            <label for="<?php echo esc_attr($this->get_field_id( 'image_uri' )); ?>"><?php esc_html_e('Background Image', 'genzia') ?></label>
            <p>
                <img class="<?php echo esc_attr($this->id); ?>_img" src="<?php echo (!empty($instance['image_uri'])) ? $instance['image_uri'] : ''; ?>" style="max-width: 100%;"/>
                <input type="url" class="widefat hidden <?php echo esc_attr($this->id); ?>_url" name="<?php echo esc_attr($this->get_field_name( 'image_uri' )); ?>" value="<?php echo esc_attr($instance['image_uri']); ?>" placeholder="<?php esc_attr_e('Choose your background','genzia'); ?>"/>
                <input type="text" class="widefat hidden <?php echo esc_attr($this->id); ?>_id" name="<?php echo esc_attr($this->get_field_name( 'image_id' )); ?>" value="<?php echo esc_attr($instance['image_id']); ?>" />
            </p>
            <p>
                <input type="button" id="<?php echo esc_attr($this->id); ?>" class="button button-primary cms_upload_media" value="<?php echo !empty($instance['image_uri']) ? esc_html__('Change Background', 'genzia') : esc_html__('Upload Background', 'genzia'); ?>" />
            </p>
        </div>

    <?php
        }
    }
}
/**
 * Media 
 * Custom Image attributes
 * Lazy loading 
 * 
 * */
//add_filter('wp_lazy_loading_enabled', '__return_true');
//add_filter('wp_get_attachment_image_attributes', function($attr){ $attr['loading'] = 'lazy'; return $attr;});
?>