<?php
$this->add_inline_editing_attributes('text');
// Icon
$icon_class = genzia_nice_class([
	'rtl-flip order-' . $this->get_setting('icon_align', 'last')
]);
genzia_elementor_link_render($widget, $settings, [
	'mode'      => 'link',
	'text_icon' => genzia_elementor_icon_render(
		$settings['btn_icon'],
		[
			'library' => 'svg',
			'value' => [
				'url' => genzia_theme_file_path() . '/assets/svgs/arrow-up-right.svg'
			]
		],
		[
			'aria-hidden' => 'true',
			'icon_size'   => 10,
			'class'       => $icon_class,
			'echo'        => false
		]
	),
	'class' => array_filter(array_unique([
		$this->get_setting('size'),
		$settings['btn_w'],
		'cms-hover-move-icon-right',
		'cms-underline cms-hover-underline',
		'text-btn font-500',
		'cms-link'
	])),
	'text_color_hover' => 'accent-regular'
]);
?>