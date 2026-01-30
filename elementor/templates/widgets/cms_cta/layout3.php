<?php
$this->add_inline_editing_attributes( 'text' );
$this->add_inline_editing_attributes( 'link_text' );
// Wrap
$this->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-cta',
		'cms-cta-'.$settings['layout'],
		'd-flex gap-30 justify-content-between',
		'flex-nowrap flex-mobile-wrap',
		'align-items-start'
	])
]);
// Text
$this->add_render_attribute('text', [
	'class' => [
		'cms-desc',
		'heading',
		'cms-nl2br',
		'text-xl m-tb-nxl',
		'text-'.$this->get_setting('text_color','sub-text'),
		'empty-none',
		'max-w'
	],
	'style' => '--max-w:488px;'
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div <?php ctc_print_html($this->get_render_attribute_string('text')) ?>><?php echo nl2br($settings['text']);?></div>
	<?php 
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
					'bg-'.$this->get_setting('link__icon_bg','white'),
					'text-'.$this->get_setting('link__icon_color','menu'),
					'bg-hover-'.$this->get_setting('link__icon_bg_hover','white'),
					'bg-on-hover-'.$this->get_setting('link__icon_bg_hover','white'),
					'text-hover-'.$this->get_setting('link__icon_color_hover','menu'),
					'text-on-hover-'.$this->get_setting('link__icon_color_hover','menu')
				])
			]),
			'class'            => [
				'cms-hover-move-icon-right'
			],
			'btn_color'        => 'primary-regular',
			'text_color'       => 'white',
			'btn_color_hover'  => 'accent-regular',
			'text_color_hover' => 'white'
		]);
	?>
</div>