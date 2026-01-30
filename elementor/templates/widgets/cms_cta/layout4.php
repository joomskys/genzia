<?php
$this->add_inline_editing_attributes( 'text' );
$this->add_inline_editing_attributes( 'link_text' );
// Render Background Image
if(!empty($settings['banner']['id'])){
	$background_img = $settings['banner']['url'];
} elseif(get_the_post_thumbnail_url('', 'full')) {
	$background_img = get_the_post_thumbnail_url('', 'full');
} else {
	$background_img = $settings['banner']['url'];
}
// Wrap
$this->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-cta',
		'cms-cta-'.$settings['layout'],
		'p-tb-48 p-lr-40 p-lr-smobile-20',
		'cms-bg-cover',
		'cms-lazy',
		'cms-gradient-render cms-gradient-1',
		'cms-radius-16',
		'overflow-hidden'
	]),
	'style' => [
		'--cms-bg-lazyload:url('.$background_img.');background-image:var(--cms-bg-lazyload-loaded);'
	]
]);
// Heading
$this->add_render_attribute('heading', [
	'class' => [
		'cms-title',
		'cms-nl2br empty-none',
		'text-'.$this->get_setting('heading_color','white'),
		'm-tb-nh6',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// Text
$this->add_render_attribute('text', [
	'class' => [
		'cms-desc',
		'cms-nl2br empty-none',
		'text-md m-tb-nmd',
		'text-'.$this->get_setting('text_color','on-dark'),
		'pt-32',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div class="relative z-top2">
		<h6 <?php ctc_print_html($this->get_render_attribute_string('heading')) ?>><?php echo nl2br($settings['heading']);?></h6>
		<div <?php ctc_print_html($this->get_render_attribute_string('text')) ?>><?php echo nl2br($settings['text']);?></div>
		<div class="space" style="height: 104px;"></div>
		<?php 
			// Button
			genzia_elementor_link_render($widget, $settings, [
				'name'             => 'link_',
				'mode'             => 'btn',
				'text_icon'        => genzia_svgs_icon([
					'icon'      => 'arrow-right',
					'icon_size' => 10,
					'echo'      => false,
					'class'     => genzia_nice_class([
						'cms-eicon cms-heading-btn-icon',
						'cms-box-48 cms-radius-6',
						'bg-'.$this->get_setting('link__icon_bg','accent-regular'),
						'text-'.$this->get_setting('link__icon_color','white'),
						'bg-hover-'.$this->get_setting('link__icon_bg_hover','white'),
						'bg-on-hover-'.$this->get_setting('link__icon_bg_hover','white'),
						'text-hover-'.$this->get_setting('link__icon_color_hover','menu'),
						'text-on-hover-'.$this->get_setting('link__icon_color_hover','menu')
					])
				]),
				'class'            => [
					'cms-hover-move-icon-right',
					'w-100 justify-content-between',
					'elementor-invisible'
				],
				'btn_color'        => 'white',
				'text_color'       => 'menu',
				'btn_color_hover'  => 'primary-regular',
				'text_color_hover' => 'white',
				'attrs'			   => [
					'data-settings' => wp_json_encode([
						'animation' => 'fadeInUp'
					])
				]	
			]);
			// Mail
			genzia_elementor_link_render($widget, $settings, [
				'name'             => 'email_',
				'mode'             => 'link',
				'text_icon'        => '',
				'class'            => [
					'cms-hover-underline',
					'text-md'
				],
				'text_color'       => 'white',
				'text_color_hover' => 'white',
				'before'		   => '<div class="text-center pt-15 mb-n5">',
				'after'			   => '</div>'
			]);
		?>
	</div>
</div>