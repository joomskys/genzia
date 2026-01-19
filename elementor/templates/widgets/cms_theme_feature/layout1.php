<?php
$galleries = $this->get_setting('gallery',[]);
$bdr_color = $this->get_setting('item_bdr_color', 'divider');
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-genzia-features',
		'cms-genzia-features-'.$settings['layout'],
		'bg-white',
		'bdr-1 bdr-'.$bdr_color,
		'cms-radius-16',
		'p-40',
		'd-flex flex-column justify-content-between',
		'relative',
		'cms-shadow-2'
	],
	'style' => 'min-height:512px;'
]);
//Title
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-title heading empty-none',
		'text-'.$this->get_setting('title_color','heading-regular'),
		'h6 mt-nh6',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// Description
$this->add_render_attribute( 'desc', [
	'class' => [
		'cms-desc empty-none',
		'text-'.$this->get_setting('description_color','body'),
		'text-md',
		'pt-10',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// Gallery
$this->add_render_attribute('gallery-wrap',[
	'class' => [
		'd-flex gap-32 justify-content-between',
		'bdr-t-1 bdr-'.$bdr_color,
		'pt-32 pl-12 mt-32',
		'align-self-end',
		'relative',
		'w-100'
	]
]);
// Output HTMl
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php 
		// Icon
		genzia_elementor_icon_render( $settings['item_icon'], [], ['class' => 'absolute top right mt-16 mr-16', 'icon_size' => 6, 'icon_color' => 'accent-regular'] );
		// Banner
		genzia_elementor_image_render($settings,[
			'name'        => 'banner',
			'size'        => 'custom',
			'custom_size' => ['width' => 268, 'height' => 268],
			'img_class'	  => 'absolute bottom-center mb-20'
		]);
	?>
	<div class="align-sefl-start relative">
		<h6 <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php 
			echo nl2br($settings['title']);
		?></h6>
		<div <?php ctc_print_html($this->get_render_attribute_string('desc')); ?>><?php 
			echo nl2br($settings['description']);
		?></div>
	</div>
	<div <?php ctc_print_html($this->get_render_attribute_string('gallery-wrap')); ?>>
		<div class="cms-feature-gallery d-flex flex-auto"><?php 
			// Gallery
			foreach ($galleries as $key => $gallery) {
				$gallery['gallery'] = $gallery;
				genzia_elementor_image_render($gallery,[
					'name'        => 'gallery',
					'size'        => 'custom',  
					'img_class'   => 'circle',
					'custom_size' => ['width' => 36, 'height' => 36],
					'attrs' 	  => [
						'style' => 'border:2px solid white;margin-inline-start:-12px;'
					]
				]);
			}
			// Icon
			genzia_elementor_icon_render($settings['gallery_icon'], [], ['icon_size' => 12, 'icon_color' => 'white', 'class' => 'cms-box-36 circle bg-accent-regular bdr-2 bdr-white ml-n12']);
		?></div>
		<div class="cms-feature-gallery-desc text-xs text-sub-text flex-basic text-end"><?php 
			// Text
			echo nl2br($settings['gallery_desc']); 
			// Link
			genzia_elementor_link_render($this, $settings, [
				'name'             => 'gallery_link_',
				'text_color'       => 'accent-regular',
				'text_color_hover' => 'accent-regular',
				'class'            => 'cms-hover-underline'
			]);
		?></div>
	</div>
</div>