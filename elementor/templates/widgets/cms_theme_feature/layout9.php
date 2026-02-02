<?php
$galleries = $this->get_setting('gallery',[]);
$bdr_color = $this->get_setting('item_bdr_color', 'divider');
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-genzia-features',
		'cms-genzia-features-'.$settings['layout']
	]
]);
//Title
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-title heading empty-none',
		'text-'.$this->get_setting('title_color','heading-regular'),
		'mt-nh4',
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
		'd-flex gap-32',
		'justify-content-between align-items-center',
		'bdr-t-1 bdr-'.$bdr_color,
		'pt-32 pl-12 mt-25'
	]
]);
// Output HTMl
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php
		// Banner
		genzia_elementor_image_render($settings,[
			'name'        => 'banner',
			'size'        => 'custom',
			'custom_size' => ['width' => 456, 'height' => 456],
			'img_class'	  => 'absolute bottom right',
			'attrs'		  => [
				'style' => 'margin-inline-end:-56px;margin-bottom:-56px;'
			]
		]);
	?>
	<div class="relative z-top2">
		<h4 <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php 
			echo nl2br($settings['title']);
		?></h4>
		<div <?php ctc_print_html($this->get_render_attribute_string('desc')); ?>><?php 
			echo nl2br($settings['description']);
		?></div>
		<?php 
			// Button
			genzia_elementor_link_render($this, $settings, [
				'name'             => 'btn_',
				'mode'		  	   => 'btn',
				'btn_color'		   => 'menu',	
				'text_color'       => 'white',
				'btn_color_hover'  => 'accent-regular',	
				'text_color_hover' => 'white',
				'class'            => 'mt-25 cms-hover-move-icon-right',
				// Icons
				'text_icon' => genzia_svgs_icon([
					'icon'       => 'arrow-right',
					'icon_size'  => 10,
					'icon_class' =>  genzia_nice_class([
						'cms-eicon cms-heading-btn-icon',
						'cms-box-48 cms-radius-6',
						'order-first',
						'bg-'.$this->get_setting('link__icon_bg','white'),
						'text-'.$this->get_setting('link__icon_color','menu'),
						'bg-hover-'.$this->get_setting('link__icon_bg_hover','white'),
						'bg-on-hover-'.$this->get_setting('link__icon_bg_hover','white'),
						'text-hover-'.$this->get_setting('link__icon_color_hover','accent-regular'),
						'text-on-hover-'.$this->get_setting('link__icon_color_hover','accent-regular')
					]),
					'echo' => false
				]),
				'after' => '<div class="pb-90 pb-tablet-40"></div>'
			]);
			// Phone
			genzia_elementor_link_render($this, $settings, [
				'name'             => 'phone_',
				'text_color'       => 'menu',
				'text_color_hover' => 'accent-regular',
				'class'            => 'text-xl heading d-flex gap-16 align-items-center',
				'text_icon' => genzia_svgs_icon([
					'icon'       => 'phone',
					'icon_size'  => 16,
					'icon_class' =>  genzia_nice_class([
						'text-accent-regular',
						'order-first'
					]),
					'echo' => false
				])
			]);
			// Email
			genzia_elementor_link_render($this, $settings, [
				'name'             => 'email_',
				'text_color'       => 'menu',
				'text_color_hover' => 'accent-regular',
				'class'            => 'text-xl heading d-flex gap-16 align-items-center mt-25 pt-25 bdr-t-1 bdr-'.$bdr_color,
				'text_icon' => genzia_svgs_icon([
					'icon'       => 'at-sign',
					'icon_size'  => 16,
					'icon_class' =>  genzia_nice_class([
						'text-accent-regular',
						'order-first'
					]),
					'echo' => false
				])
			]);
		?>
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
</div>