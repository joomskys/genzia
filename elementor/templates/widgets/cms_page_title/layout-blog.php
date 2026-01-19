<?php
$default_align = 'center';
// Render Background Image
if(!empty($settings['bg_image']['id'])){
	$background_img = $settings['bg_image']['url'];
} elseif(get_the_post_thumbnail_url('', 'full')) {
	$background_img = get_the_post_thumbnail_url('', 'full');
} else {
	$background_img = $settings['bg_image']['url'];
}
//
$header_transparent = '';
if(genzia_get_opts('header_transparent', 'off', 'header_custom') == 'on'){
    $header_transparent = 'ptitle-header-transparent';
}
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-ptitle cms-ptitle-1',
		'cms-eptitle-'.$settings['layout'],
		'text-center',
		$header_transparent,
		'overflow-hidden'
	]
]);
// Container
$this->add_render_attribute('container',[
	'class' => [
		'container relative z-top',
		'pb'
	],
	'style' => '--pb:120px;--pb-tablet:70px;'
]);
// Title
$this->add_inline_editing_attributes( 'title', 'none' );
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-title cms-nl2br',
		'text-'.$this->get_setting('title_color','white'),
		'empty-none'
	]
]);
// CMS Content
$content_width = !empty($settings['content_width']['size']) ? $settings['content_width']['size'] : 600;
$this->add_render_attribute('cms--content',[
	'class' => [
		'cms--content',
        'max-w',
	],
	'style' => [
		'--max-w:'.$content_width.'px;'
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
	<div class="cms-overlay"><img src="<?php echo esc_url($background_img); ?>" alt="<?php echo get_bloginfo('name') ?>" title="<?php echo get_bloginfo('name') ?>" fetchpriority="high" loading="eager" decoding="sync" class="img-cover" data-parallax='{"y": 230}'/></div>
	<div <?php ctc_print_html($this->get_render_attribute_string('container')); ?>>
		<h1 <?php ctc_print_html( $this->get_render_attribute_string( 'title' ) ); ?>><?php echo nl2br( $this->get_setting('title', get_the_title()) ); ?></h1>
		<?php 
			genzia_breadcrumb([
	            'class'      => 'd-flex justify-content-center text-sm', 
	            'link_class' => 'text-white text-hover-white',
	            'before'     => '',
	            'after'      => ''
	        ]);
		?>
	</div>
</div>