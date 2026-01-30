<?php
// Video Banner
$settings['image']['id'] = !empty($settings['image']['id']) ? $settings['image']['id'] : get_post_thumbnail_id();
// Wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-evideo',
		'cms-evideo-'.$settings['layout'],
		'relative',
		'overflow-hidden',
		'cms-radius-16'
	]
]);
// Title
$this->add_render_attribute('title',[
	'class' => [
		'cms-heading h5',
		'empty-none',
		'text-'.$this->get_setting('heading_color','heading-regular'),
		'pb-40 mt-nh5'
	]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php echo esc_html($settings['heading_text']); ?></div>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php 
		// Banner 
		genzia_elementor_image_render($settings,[
			'name'        => 'image',
			//'size'      => '',
			'custom_size' => ['width' => 760, 'height' => 507],
			'img_class'   => 'img-cover',
			'max_height'  => true,
			'min_height'  => true	
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
				'width'            => 196,
				'height'           => 196,
				'color'            => 'var(--cms-'.$this->get_setting('stroke_color', 'transparent').')',
				'color_hover'      => 'var(--cms-'.$this->get_setting('stroke_color_hover', 'white').')',
				'stroke_dasharray' => ''	
			]
	    ]);
	?>
</div>