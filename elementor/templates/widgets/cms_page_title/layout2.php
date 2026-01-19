<?php
$default_align = 'start';
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
		'cms-lazy'
	],
	'style' => [
		'--cms-bg-lazyload:'.$background_img.';background-image:var(--cms-bg-lazyload-loaded);'
	]
]);
// Container
$this->add_render_attribute('container',[
	'class' => [
		'cms-content container',
		'relative z-top2',
		'd-flex justify-content-'.$default_align
	]
]);
// Content
$content_width = !empty($settings['content_width']['size']) ? $settings['content_width']['size'] : 584;
$this->add_render_attribute('cms--content',[
	'class' => [
		'cms--content',
		'max-w',
		'pt pb'
	],
	'style' => [
		'--max-w:'.$content_width.'px;',
		'--pt:calc(121px + var(--cms-wrap-header-height, 0px));',
		'--pt-tablet:calc(60px + var(--cms-wrap-header-height, 0px));',
		'--pb:124px;--pb-tablet:53px;'
	]
]);
// Small Title
$this->add_render_attribute( 'small-title', [
	'class' => [
		'cms-nl2br lh-107',
		'cms-small',
		'text-'.$this->get_setting('small_title_color','on-dark'),
		'empty-none',
		'elementor-invisible',
		'pb-10'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 100
	]),
]);
// Title
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-nl2br lh-107',
		'cms-title',
		'text-'.$this->get_setting('title_color','white'),
		'empty-none',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 300
	]),
]);
// Description
$this->add_render_attribute( 'desc', [
	'class' => [
		'cms-desc',
		'cms-nl2br',
		'text-lg',
		'text-'.$this->get_setting('desc_color','on-dark'),
		'empty-none',
		'elementor-invisible',
		'pt-10'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 500
	]),
]);
// Breadcrumb
$this->add_render_attribute('breadcrumb',[
	'class' => [
		'cms-eptitle-breadcrumbs',
		'container',
		'elementor-invisible',
		'pb-32'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// Buttons
$this->add_render_attribute('buttons', [
	'class' => [
		'buttons pt-33 empty-none',
		'd-flex gap-24',
		'justify-content-'.$default_align
	]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div <?php ctc_print_html($this->get_render_attribute_string('container')); ?>>
		<div <?php ctc_print_html($this->get_render_attribute_string('cms--content')); ?>>
			<div <?php ctc_print_html( $this->get_render_attribute_string( 'small-title' ) ); ?>><?php 
				echo nl2br( $settings['small_title'] ); 
			?></div>
			<h1 <?php ctc_print_html( $this->get_render_attribute_string( 'title' ) ); ?>><?php 
				echo nl2br( $this->get_setting('title', get_the_title()) ); 
			?></h1>
			<div <?php ctc_print_html( $this->get_render_attribute_string( 'desc' ) ); ?>><?php 
				echo nl2br( $this->get_setting('desc','') ); 
			?></div>
			<div <?php ctc_print_html($this->get_render_attribute_string('buttons')); ?>><?php 
				// Button
				genzia_elementor_link_render($widget, $settings, [
					'name'             => 'link1_',
					'mode'             => 'btn',
					'text_icon'        => genzia_svgs_icon([
						'icon'      => 'arrow-right',
						'icon_size' => 10,
						'echo'      => false
					]),
					'class'            => [
						'cms-hover-move-icon-right',
						'elementor-invisible'
					],
					//'btn_prefix'       => 'btn-outline-',
					//'btn_hover_prefix' => 'btn-hover-',
					'btn_color'        => 'white',
					'text_color'       => 'menu',
					'btn_color_hover'  => 'accent-regular',
					'text_color_hover' => 'white',
					'before'           => '',
					'after'            => '',
					'attrs'			   => [
						'data-settings' => wp_json_encode([
							'animation'       => 'fadeInLeft',
							'animation_delay' => 700
						])
					]
				]);
				// Button
				genzia_elementor_link_render($widget, $settings, [
					'name'             => 'link2_',
					'mode'             => 'btn',
					'text_icon'        => '',
					'class'            => [
						'elementor-invisible'
					],
					'btn_prefix'       => 'btn-outline-',
					'btn_hover_prefix' => 'btn-hover-',
					'btn_color'        => 'white',
					'text_color'       => 'white',
					'btn_color_hover'  => 'white',
					'text_color_hover' => 'menu',
					'before'           => '',
					'after'            => '',
					'attrs'			   => [
						'data-settings' => wp_json_encode([
							'animation'       => 'fadeInRight',
							'animation_delay' => 700
						])
					]
				]);
			?></div>
		</div>
	</div>
	<div <?php ctc_print_html($this->get_render_attribute_string('breadcrumb')); ?>><?php 
		genzia_breadcrumb([
            'class'      => 'text-sm d-flex justify-content-center', 
            'link_class' => 'text-white text-hover-white',
            'before'     => '',
            'after'      => ''
        ]);
	?></div>
</div>