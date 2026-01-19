<?php
$default_align = 'center';
// Render Background Image
if(!empty($settings['bg_image']['id'])){
    $background_img = 'url('.$settings['bg_image']['url'].')';
} elseif(get_the_post_thumbnail_url('', 'full')) {
    $background_img = 'url('.get_the_post_thumbnail_url('', 'full').')';
} else {
    $background_img = 'var(--cms-ptitle-bg-image)';
}
// Wrap
$this->add_render_attribute('wrap',[
    'class' => [
        'cms-eptitle',
        'cms-eptitle-'.$settings['layout'],
        'cms-gradient-render cms-gradient-'.$this->get_setting('bg_overlay', 1),
        'text-'.$default_align,
        'text-white',
        'cms-bg-cover',
        'cms-lazy',
        'pt pb'
    ],
    'style' => [
        '--cms-bg-lazyload:'.$background_img.';background-image:var(--cms-bg-lazyload-loaded);',
        '--pt:calc(68px + var(--cms-wrap-header-height, 0px));',
        '--pb:66px;'
    ]
]);
// Breadcrumb
$this->add_render_attribute('breadcrumb',[
    'class' => [
        'cms-eptitle-breadcrumbs',
        'container',
        'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInUp'
    ])
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
    <div <?php ctc_print_html($this->get_render_attribute_string('breadcrumb')); ?>><?php 
        genzia_breadcrumb([
            'class'      => 'd-flex justify-content-center text-sm', 
            'link_class' => 'text-white text-hover-white',
            'before'     => '',
            'after'      => ''
        ]);
    ?></div>
</div>