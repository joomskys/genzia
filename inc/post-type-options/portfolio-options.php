<?php
if(!class_exists('CSH_Theme_Core') || !class_exists('WooCommerce')) return;

add_filter('tco_portfolio_page_options_args', 'genzia_portfolio_options_args');
function genzia_portfolio_options_args(){
    $default       = true;
    $default_value = $default_on = $default_off = $default_width = '-1';
    $custom_opts   = true;
    //
    $header     = include get_template_directory() . '/inc/post-type-options/args-page/header.php';
    //
    $args = [  
        'header'     => $header,
    ];
    return $args;
}