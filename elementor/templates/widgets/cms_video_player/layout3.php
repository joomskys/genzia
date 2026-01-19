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
		'pt-112 pb-136 p-tb-tablet-80',
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
		'max-w'
	],
	'style' => '--max-w:840px;'
]);
// Heading Inner
$this->add_render_attribute('heading-inner',[
	'class' => [
		'cms-evideo--heading',
		'd-flex align-items-start',
		'gap'
	],
	'style' => '--cms-gap:80px;--cms-gap-smobile:20px;'
]);
// Heading Text
$this->add_render_attribute('heading-text',[
	'class' => [
		'cms-evideo-heading-text empty-none',
		'text-'.$this->get_setting('heading_color','white'),
		'text-size',
		'pb-50 pb-tablet-30',
		'elementor-invisible'
	],
	'style' => '--text-size:4.889rem;',
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// Heading Desc
$this->add_render_attribute('heading-desc',[
	'class' => [
		'cms-evideo-heading-desc',
		'text-'.$this->get_setting('desc_color','on-dark'),
		'text-lg',
		'm-tb-nlg',
		'max-w',
		'elementor-invisible'
	],
	'style' => '--max-w:400px;',
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInLeft'
	])
]);

// Heading Gallery
$galleries = $this->get_setting('gallery',[]);
$this->add_render_attribute('heading-gallery-wrap',[
	'class' => [
		'cms-evideo-gallery-wrap',
		'd-flex justify-content-between align-items-start',
		'gap-20',
		'pt-32',
		'bdr-t-1 bdr-'.$this->get_setting('bdr_color','divider-light'),
		'mt',
		'elementor-invisible'
	],
	'style' => '--mt:152px;',
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
$this->add_render_attribute('heading-gallery',[
	'class' => [
		'cms-evideo-gallery',
		'd-flex',
		'bg-white cms-radius-rounded'
	]
]);
// Heading Gallery Desc
$this->add_render_attribute('gallery-desc',[
	'class' => [
		'cms-evideo-gallery-desc',
		'text-'.$this->get_setting('gallery_desc_color','on-dark'),
		'text-lg'
	]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div class="container">
		<div <?php ctc_print_html($this->get_render_attribute_string('heading')); ?>>
			<h1 <?php ctc_print_html($this->get_render_attribute_string('heading-text')); ?>><?php 
				echo esc_html($settings['heading_text']);
			?></h1>
			<div <?php ctc_print_html($this->get_render_attribute_string('heading-inner')); ?>>
				<div <?php ctc_print_html($this->get_render_attribute_string('heading-desc')); ?>><?php 
					echo esc_html($settings['desc']);
				?></div>
				<?php 
					// Button
					genzia_elementor_link_render($this, $settings, [
						'mode'			   => 'btn',
						'class'            => 'cms-heading-btn cms-hover-change cms-hover-move-icon-right elementor-invisible',
						'btn_color'        => 'white',
						'text_color'       => 'menu',
						'btn_color_hover'  => 'accent-regular',
						'text_color_hover' => 'white',
						// Icons
						'text_icon' => genzia_svgs_icon([
							'icon'       => 'arrow-right',
							'icon_size'  => 10,
							'icon_class' =>  genzia_nice_class([
								'cms-eicon cms-heading-btn-icon',
								'cms-box-48 cms-radius-6',
								'bg-'.$this->get_setting('link__icon_bg','accent-regular'),
								'text-'.$this->get_setting('link__icon_color','white'),
								'bg-hover-'.$this->get_setting('link__icon_bg_hover','white'),
								'bg-on-hover-'.$this->get_setting('link__icon_bg_hover','white'),
								'text-hover-'.$this->get_setting('link__icon_color_hover','accent-regular'),
								'text-on-hover-'.$this->get_setting('link__icon_color_hover','accent-regular')
							]),
							'echo' => false
						]),
						'attrs' => [
							'data-settings' => wp_json_encode([
								'animation' => 'fadeInRight'
							])
						]
					]);
				?>
			</div>
		</div>
		<div <?php ctc_print_html($this->get_render_attribute_string('heading-gallery-wrap')); ?>>
			<div class="d-flex gap-24 align-items-center">
				<div <?php ctc_print_html($this->get_render_attribute_string('heading-gallery')); ?>><?php 
					$g_count = 0;
					foreach ($galleries as $g_key => $gallery) {
						$g_count ++;
						$gallery['gallery'] = $gallery;
						//
						$classes = genzia_nice_class([
							'cms-box-36 circle bg-white p-2',
							($g_count>1)?'ml-n8':''
						]);
						//
						genzia_elementor_image_render($gallery,[
							'name'        => 'gallery',
							'size'        => 'custom',  
							'img_class'   => 'circle',
							'custom_size' => ['width' => 32, 'height' => 32],
							'before'	  => '<div class="'.$classes.'">',
							'after'		  => '</div>'	
						]);
					}
				?></div>
				<div <?php ctc_print_html($this->get_render_attribute_string('gallery-desc')); ?>><?php 
					echo esc_html($settings['gallery_desc']);
				?></div>
			</div>
			<?php 
				// Button Video
				genzia_elementor_button_video_render($this, $settings, [
					'name'           => 'video_link',
					// icon
					'icon'           => $this->get_setting('video_icon'),
					'icon_size'      => 10,
					'icon_color'     => $this->get_setting('video_icon_color', 'menu'),
					'icon_class'     => ' cms-box- circle bg-white bg-on-hover-accent-regular text-on-hover-white',
					'icon_dimension' => 36,
					// text
					'text'       => $this->get_setting('video_text'),
					'text_class' => 'text-sm font-700 text-'.$this->get_setting('video_text_color', 'white'),
					// other
					'layout'        => '1',
					'class'         => '',
					'inner_class'   => '',
					// content
					'content_class' => 'd-flex align-items-center gap-8 cms-hover-change',
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
					]
			    ]);
			?>
		</div>
	</div>
</div>