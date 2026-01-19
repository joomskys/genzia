<?php
if(!class_exists('CSH_Theme_Core') || !class_exists('WooCommerce')) return;

add_filter('tco_product_page_options_args', 'genzia_product_options_args');
function genzia_product_options_args(){
    $general = [
        'title' => esc_html__('General','genzia'),
        'sections' => [
            'single' => genzia_single_product_opts([
                'default' => true
            ])
        ]
    ];
    $args = [  
        'general' => $general,
    ];
    return $args;
}