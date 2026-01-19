<?php
// Video Banner
$settings['image']['id'] = !empty($settings['image']['id']) ? $settings['image']['id'] : get_post_thumbnail_id();
// Wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-evideo',
		'cms-evideo-'.$settings['layout'],
		'relative',
		'cms-gradient-render cms-gradient-1',
		'overflow-hidden'
	]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
<?php 
	// Banner 
	genzia_elementor_image_render($settings,[
		'name'        => 'image',
		//'size'      => '',
		'custom_size' => ['width' => 736, 'height' => 570],
		'img_class'   => 'img-cover',
		'max_height'  => true,
		'attrs'		  => [
			'style' => 'min-height:400px;'
		] 	
	]);
	// Button Video
	genzia_elementor_button_video_render($this, $settings, [
		'name'       => 'video_link',
		// icon
		'icon'           => $this->get_setting('video_icon'),
		'icon_size'      => 15,
		'icon_color'     => $this->get_setting('video_icon_color', 'white'),
		'icon_class'     => 'absolute center circle bg-backdrop cms-box-',
		'icon_dimension' => 132,
		// text
		'text'       => $this->get_setting('video_text'),
		'text_class' => 'text-'.$this->get_setting('video_text_color', 'white'),
		// other
		'layout'        => '1',
		'class'         => 'absolute center cms-hover-change',
		'inner_class'   => '',
		// content
		'content_class' => '',
		//
		'echo'          => true,
		'default'       => true,
		'stroke'        => true,
		'stroke_opts'   => [
			'width'       => 188,
			'height'      => 188,
			'color'       => 'var(--cms-'.$this->get_setting('stroke_color', 'transparent').')',
			'color_hover' => 'var(--cms-'.$this->get_setting('stroke_color_hover', 'white').')',
			'stroke_dasharray' => '' //'10 10'	
		]
    ]);
?>
</div>