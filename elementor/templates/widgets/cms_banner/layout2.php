<?php 
//wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-ebanner', 
		'cms-ebanner-'.$settings['layout'],
		'relative',
		$this->get_setting('css_classes'),
		'd-inline'
	]
]);
$img_class = genzia_nice_class([
	($settings['img_cover'] == 'yes') ? 'img-cover' : '',
	$this->get_setting('e_classes')
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>><?php 
	genzia_elementor_image_render($settings,[
		'name'        => 'banner',
		'custom_size' => ['width' => 312, 'height' => 394],
		'img_class'   => $img_class,
		'max_height'  => true
	]);
	genzia_svgs_icon([
		'icon'       => 'core/quote',
		'icon_size'  => 64,
		'class'		 => 'absolute top right mt-8 mr-8 text-white'
	]);
?></div>