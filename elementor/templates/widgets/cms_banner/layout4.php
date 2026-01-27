<?php 
// Post thumnail as banner
//$settings['banner']['id'] = !empty($settings['banner']['id']) ? $settings['banner']['id'] : get_post_thumbnail_id();
$img_class = genzia_nice_class([
	'cms-radius-16',
	($settings['img_cover'] == 'yes') ? 'img-cover' : '',
	$this->get_setting('e_classes')
]);
// wrap
$img_width        = $this->get_setting('img_width',872);
$img_height       = $this->get_setting('img_height',611);
$img_scale_width  = $this->get_setting('img_scale_widht', 1885);
$img_scale_height = $this->get_setting('img_scale_height',920);
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-ebanner',
		'd-flex'
	],
	'data-parallax' => wp_json_encode([
		'width'     => $img_width,
		'height'    => $img_height,
		'width_to'  => $img_scale_width,
		'height_to' => $img_scale_height
	]),
	'style' => [
		'width:'.$img_width.'px;',
		'height:'.$img_scale_height.'px;',
	]
]);
// Banner
genzia_elementor_image_render($settings,[
	'name'        => 'banner',
	'size'		  => 'custom',	
	'custom_size' => ['width' => $img_scale_width, 'height' => $img_scale_height],
	'img_class'   => $img_class,
	'before'      => '<div class="d-flex justify-content-end overflow-hidden"><div '.$this->get_render_attribute_string('wrap').'>',
	'after'       => '</div></div>'	
]);
?>