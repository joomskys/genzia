<?php
// Video Banner
$settings['image']['id'] = !empty($settings['image']['id']) ? $settings['image']['id'] : get_post_thumbnail_id();
// Wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-evideo',
		'cms-evideo-'.$settings['layout'],
		'relative'
	]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div class="absolute top left right z-top">
		<div class="container d-flex flex-nowrap justify-content-end" style="margin-top:-74px;">
		<?php 
			// Button Video
			genzia_elementor_button_video_render($this, $settings, [
				'name'       => 'video_link',
				// icon
				'icon'           => $this->get_setting('video_icon'),
				'icon_size'      => 15,
				'icon_color'     => $this->get_setting('video_icon_color', 'white'),
				'icon_class'     => 'circle bg-menu cms-box-',
				'icon_dimension' => 76,
				// text
				'text'       => $this->get_setting('video_text'),
				'text_class' => 'text-'.$this->get_setting('video_text_color', 'white'),
				// other
				'layout'        => 'circle-text',
				'class'         => 'cms-hover-change z-top elementor-invisible',
				'inner_class'   => '',
				// content
				'content_class' => '',
				//
				'echo'          => true,
				'default'       => true,
				'stroke'        => false,
				'stroke_opts'   => [
					'width'       => 188,
					'height'      => 188,
					'color'       => 'var(--cms-'.$this->get_setting('stroke_color', 'transparent').')',
					'color_hover' => 'var(--cms-'.$this->get_setting('stroke_color_hover', 'white').')',
					'stroke_dasharray' => '' //'10 10'	
				],
				//
				'circle_settings' => [
					'class'		 => 'font-500',
					'dimensions' => 148,
					'background' => 'accent-regular',
					'text'		 => $this->get_setting('video_text'),
					'text_size'	 => 23,
					'color'		 => $this->get_setting('video_text_color', 'white'),
					'style'		 => 'padding:7px;box-shadow:0 0 0 12px var(--cms-bg-dark);'
				],
				'attrs' => [
					'data-settings' => wp_json_encode([
						'animation' => 'fadeInLeft'
					])
				]
		    ]);
		    // Banner 
			genzia_elementor_image_render($settings,[
				'name'        => 'image',
				'size'        => 'custom',
				'custom_size' => ['width' => 148, 'height' => 148],
				'img_class'   => 'circle elementor-invisible',
				'attrs'       => [
					'style' => 'margin-inline-start:-12px;box-shadow:0 0 0 12px var(--cms-bg-dark);',
					'data-settings' => wp_json_encode([
						'animation' => 'fadeInRight'
					])
				] 	
			]);
		?>
		</div>
	</div>
	<?php 
		// Banner Background
		genzia_elementor_image_render($settings,[
			'name'        => 'banner_bg',
			'size'        => 'custom',
			'custom_size' => ['width' => 1600, 'height' => 864],
			'img_class'   => 'img-cover',
			'max_height'  => true
		]);
	?>
</div>