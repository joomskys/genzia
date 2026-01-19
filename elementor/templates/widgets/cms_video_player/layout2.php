<?php
// Video Banner
$settings['image']['id'] = !empty($settings['image']['id']) ? $settings['image']['id'] : get_post_thumbnail_id();
// Wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-evideo',
		'cms-evideo-'.$settings['layout'],
		'relative',
		'bdr-l-1 bdr-r-1 bdr-divider',
		'm-lr-auto'
	],
	'style' => 'max-width:864px;padding-top:62px;'
]);
// Heading
$this->add_render_attribute('heading',[
	'class' => [
		'heading empty-none',
		'text-xl',
		'pb-55 pb-tablet-40',
		'p-lr-20',
		'text-center',
		'm-lr-auto',
		'elementor-invisible'
	],
	'style' => 'max-width:600px;',
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
$heading_icon_classes = genzia_nice_class([
	'cms-heading-icon',
	'text-'.$this->get_setting('heading_icon_color', 'accent-regular'),
	'pb-55'
]);
?>
<div class="absolute bottom left bg-divider" style="width:1px;height: 113px; margin-inline-start:32px;margin-bottom: 17px;"></div>
<div class="absolute bottom right bg-divider" style="width:1px;height: 113px; margin-inline-end:32px;margin-bottom: 17px;"></div>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div class="absolute top-center w-100vw bdr-t-1 bdr-divider"></div>
	<div class="absolute bottom-center w-100vw bdr-t-1 bdr-divider" style="margin-bottom:74px;"></div>
	<div <?php ctc_print_html($this->get_render_attribute_string('heading')); ?>><?php
		// Icon
		genzia_elementor_icon_render( $settings['heading_icon'], [], ['class' => $heading_icon_classes, 'icon_size' => 8], 'div');
		// Text
		echo nl2br($settings['heading_text']);
	?></div>
	<div class="d-flex flex-nowrap justify-content-center relative z-top">
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
					'style'		 => 'padding:7px;box-shadow:0 0 0 16px white;'
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
					'style' => 'margin-inline-start:-16px;box-shadow:0 0 0 16px white;',
					'data-settings' => wp_json_encode([
						'animation' => 'fadeInRight'
					])
				] 	
			]);
		?>
	</div>
</div>