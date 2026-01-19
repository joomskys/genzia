<?php
// Video Banner
$settings['image']['id'] = !empty($settings['image']['id']) ? $settings['image']['id'] : get_post_thumbnail_id();

if($settings['lightbox']!='yes' && !empty($settings['image']['id'])){
	$this->add_render_attribute('wrap', [
		'style' => 'background-image:url('.wp_get_attachment_url($settings['image']['id']).');'
	]);
}
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-evideo',
		'cms-evideo-'.$settings['layout'],
		($settings['lightbox'] != 'yes') ? 'cms-evideo-playback' : '',
		($settings['video_fit'] === 'yes') ? 'cms-evideo-fit' : '',
		'relative'
	]
]);
// YT Video
$this->add_render_attribute('yt-video',[
	'class'           => 'yt-video relative z-top-2',
	'data-video-link' => $this->get_setting('video_link'),
	'style'           => 'width: 100%;height:100%;'
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php 
		if($settings['lightbox']!='yes'){
	?>
	<div class="cms-gradient-render cms-gradient-5 cms-overlay"></div>
	<div <?php ctc_print_html($this->get_render_attribute_string('yt-video')); ?>></div>
	<?php } ?>
	<?php
		genzia_elementor_image_render($settings, [
			'custom_size'   => ['width' => 1500,'height' => 800],
			'img_class'     => 'img-cover',
			'before'        => '',
			'max_height'	=> true,
			'attrs'         => [
				'style' => 'min-height:420px;'
			]
	    ]);
	?>
	<?php
		// button video
		genzia_elementor_button_video_render($widget, $settings, [
			'name'       => 'video_link',
			// icon
			'icon'       => $this->get_setting('video_icon'),
			'icon_size'	 => 15,
			'icon_color' => $this->get_setting('video_text_color', 'white'),
			'icon_class' => 'cms-box-124 bg-backdrop bg-hover-white bg-on-hover-white text-on-hover-menu text-hover-menu circle z-top absolute center',
			// text
			'text'       => '',
			'text_class' => '',
			// other
			'layout'        => '1',
			'class'         => 'absolute center z-top cms-hover-change',
			'inner_class'   => 'inner_class',
			// content
			'content_class' => '',
			//
			'echo'          => true,
			//'default'       => '',
			'stroke'        => true,
			'stroke_opts'   => [
				'width'       => 310,
				'height'      => 310,
				'color'       => 'var(--cms-'.$this->get_setting('stroke_color', 'white').')',
				'color_hover' => 'var(--cms-'.$this->get_setting('stroke_color_hover', 'white').')'		
			],
			'autoplay'		=> $this->get_setting('autoplay'),
			//
			'lightbox' => $this->get_setting('lightbox'),
			'before'   => '',
			'after'	   => ''
	    ]);
	?>
</div>