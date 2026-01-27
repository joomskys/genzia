<?php
// Video Banner
$settings['image']['id'] = !empty($settings['image']['id']) ? $settings['image']['id'] : get_post_thumbnail_id();
// Render Background Image
if(!empty($settings['image']['id'])){
	$background_img = 'url('.$settings['image']['url'].')';
} elseif(get_the_post_thumbnail_url('', 'full')) {
	$background_img = 'url('.get_the_post_thumbnail_url('', 'full').')';
} else {
	$background_img = 'var(--cms-ptitle-bg-image)';
}
// Wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-evideo',
		'cms-evideo-'.$settings['layout'],
		'relative',
		'overflow-hidden',
		'cms-radius-16',
		'pt-120 pb-136 p-tb-tablet-80',
		'p-lr-48 p-lr-smobile-20',
		'cms-bg-cover',
		'cms-lazy'
	],
	'style' => [
		'--cms-bg-lazyload:'.$background_img.';background-image:var(--cms-bg-lazyload-loaded);'
	]
]);
// Heading
$this->add_render_attribute('heading',[
	'class' => [
		'cms-evideo-heading',
		'text-'.$this->get_setting('heading_color','white'),
		'max-w',
		'elementor-invisible',
		'text-size lh-1'
	],
	'style' => [
		'--max-w:840px;',
		'--text-size:4.889rem;--text-size-smobile:3rem;'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// Desc & Button
$this->add_render_attribute('desc-button',[
	'class' => [
		'd-flex gap-32',
		'align-items-end',
		'justify-content-between',
		'pt'
	],
	'style' => '--pt:165px;--pt-smobile:50px;'
]);
// Desc
$this->add_render_attribute('desc',[
	'class' => [
		'cms-desc',
		'text-lg',
		'text-'.$this->get_setting('desc_color','on-dark'),
		'max-w',
		'flex-basic flex-smobile-full',
		'elementor-invisible'
	],
	'style' => [
		'--max-w:484px;'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// Gallery
$galleries = $this->get_setting('gallery',[]);
$this->add_render_attribute('gallery',[
	'class' => [
		'cms-evideo-gallery',
		'd-flex',
		'bg-white cms-radius-rounded',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<h1 <?php ctc_print_html($this->get_render_attribute_string('heading')); ?>><?php 
		echo esc_html($settings['heading_text']);
	?></h1>
	<div <?php ctc_print_html($this->get_render_attribute_string('desc-button')); ?>>
		<div <?php ctc_print_html($this->get_render_attribute_string('desc')); ?>><?php 
			echo esc_html($settings['desc']);
		?></div>
		<div class="flex-auto">
			<div <?php ctc_print_html($this->get_render_attribute_string('gallery')); ?>><?php 
				$g_count = 0;
				foreach ($galleries as $g_key => $gallery) {
					$g_count ++;
					$gallery['gallery'] = $gallery;
					//
					$classes = genzia_nice_class([
						'cms-box-56 circle bg-white p-4',
						($g_count>1)?'ml-n16':''
					]);
					//
					genzia_elementor_image_render($gallery,[
						'name'        => 'gallery',
						'size'        => 'custom',  
						'img_class'   => 'circle',
						'custom_size' => ['width' => 48, 'height' => 48],
						'before'	  => '<div class="'.$classes.'">',
						'after'		  => '</div>'	
					]);
				}
			?></div>
			<?php 
			    // Video button
                genzia_elementor_button_video_render($this, $settings, [
                    ///'_id'           => $cms_slide['_id'],   
                    'name'          => 'video_link',
                    'icon_class'    => 'cms-transition cms-box-48 circle bg-accent-regular text-white m-lr-auto',
                    'icon_size'     => 10,
                    'layout'        => '1 bg-white cms-radius-16 p-8',
                    'class'         => 'elementor-invisible',
                    'inner_class'   => 'cms-radius-10 bg-bg-light p-12 text-center',
                    'content_class' => 'd-flex gap-10 flex-column justify-content-center',
                    'text'          => $this->get_setting('video_text'),
                    'text_class'    => 'text-btn font-700 mb-n5',
                    'echo'          => true,
                    'attrs'         => [
                        'data-settings' => wp_json_encode([
                        	'animation' => 'fadeInUp'
                        ])
                    ]
                ]);
			?>
		</div>
	</div>
</div>