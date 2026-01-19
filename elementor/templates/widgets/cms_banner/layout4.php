<?php 
// Post thumnail as banner
$settings['banner']['id'] = !empty($settings['banner']['id']) ? $settings['banner']['id'] : get_post_thumbnail_id();
$img_class = genzia_nice_class([
	($settings['img_cover'] == 'yes') ? 'img-cover' : '',
	$this->get_setting('e_classes')
]);
// Button #2
$this->add_render_attribute( 'link', [
	'class' => [
		'cms-ebanner relative cms-hover-icon-alternate',
		'elementor-invisible',
		'd-inline-block'
	],
	'title'         => $settings['link_title'],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInRight',
		'animation_delay' => 200
	])
]);
$this->add_link_attributes( 'link', $settings['link_url'] );
?>
<?php
	genzia_elementor_image_render($settings,[
		'name'        => 'banner',
		'custom_size' => ['width' => 592, 'height' => 680],
		'img_class'   => $img_class,
		'max_height'  => true,
		'before'      => '<a '.$this->get_render_attribute_string('link').'>',
		'after'       => genzia_svgs_icon([
			'icon'       => 'arrow-down-right-alternate',
			'icon_size'  => 104,
			'class'		 => 'absolute bottom right mr-32 mb-32 text-white',
			'echo'		 => false
		]).'</a>'	
	]);
?>