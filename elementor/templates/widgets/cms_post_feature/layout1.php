<?php 
$default_align = 'center';
//wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-epf', 
		'cms-epf-'.$this->get_setting('layout'),
		'text-'.$default_align
	]
]);
$attachment_id = !empty($settings['banner']['id']) ? $settings['banner']['id'] : get_post_thumbnail_id();
// get video from post option
$video_url   = genzia_get_post_format_value(get_the_ID(), 'video', '');
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
<?php
  // Taxonomy
  genzia_the_terms(get_the_ID(), genzia_post_taxonomy_category('tag'), '', 'bg-menu text-white bg-hover-accent-regular text-hover-white p-tb-2 p-lr-8', [
      'before' => '<div class="d-flex gap-6 justify-content-center text-xs mb-24">', 
      'after'  => '</div>'
  ]);
  // Post Title
  the_title('<div class="d-flex justify-content-center pb-32"><h1 class="cms-title h4 cms-heading mt-n7 max-w" style="--max-w:660px;">','</h1></div>');
	// Post Feature Image
	genzia_elementor_image_render($settings,[
		'name'                => 'banner',
		'attachment_id'				=> $attachment_id,
		'size'								=> 'custom',
		'custom_size'         => ['width' => 864, 'height' => 576],
		'img_class'						=> '',
		'before'							=> '<div class="relative">',
		'after'								=> genzia_elementor_button_video_render($widget, $settings, [
			'name'       => 'video_link',
			// icon
			'icon'       => [
				'value'   => [
          'url' => genzia_theme_file_path().'/assets/svgs/core/play.svg'
        ],
        'library' => 'svg'
			],
			'icon_size'	 => 15,
			'icon_color' => $this->get_setting('video_text_color', 'white'),
			'icon_class' => 'absolute center cms-box-132 circle bg-backdrop bg-hover-accent-regular bg-on-hover-accent-regular',
			// text
			'text'       => $this->get_setting('video_text'),
			'text_class' => 'text-'.$this->get_setting('video_text_color', 'accent'),
			// other
			'layout'        => '1',
			'class'         => 'absolute center cms-hover-change',
			'inner_class'   => 'relative',
			// content
			'content_class' => '',
			//
			'echo'          => false,
			'default'       => '',
			//
			'stroke'        => true,
			'stroke_opts'   => [
				'width'            => 196,
				'height'           => 196,
				'color'            => 'var(--cms-'.$this->get_setting('stroke_color', 'transparent').')',
				'color_hover'      => 'var(--cms-'.$this->get_setting('stroke_color_hover', 'white').')',
				'stroke_dasharray' => ''	
			]
		]).'</div>'
	]);
?>
</div>