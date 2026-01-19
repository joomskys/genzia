<?php 
// Post thumnail as banner
//$settings['banner']['id'] = !empty($settings['banner']['id']) ? $settings['banner']['id'] : get_post_thumbnail_id();
$img_class = genzia_nice_class([
	($settings['img_cover'] == 'yes') ? 'img-cover' : '',
	$this->get_setting('e_classes')
]);
?>
<?php
genzia_elementor_image_render($settings,[
	'name'                => 'banner',
	//'size'			  => '',
	'custom_size'         => ['width' => 664, 'height' => 784],
	'img_class'			  => $img_class,
	'as_background'       => $settings['as_background'],
	'as_background_class' => $settings['bg_pos'].' '.$this->get_setting('e_classes'),
	'max_height'       	  => $settings['max_height']
]);
?>