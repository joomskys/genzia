<?php 
$img_class = genzia_nice_class([
	($settings['img_cover'] == 'yes') ? 'img-cover' : '',
	$this->get_setting('e_classes')
]);
?>
<div class="cms-ebanner cms-ebanner-3 relative d-inline-block"><?php 
	// Banner
	genzia_elementor_image_render($settings,[
		'name'        => 'banner',
		'custom_size' => ['width' => 312, 'height' => 394],
		'img_class'   => $img_class
	]);
?></div>