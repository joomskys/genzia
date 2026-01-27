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
				'order-first',
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