<?php 
// Post thumnail as banner
$settings['banner']['id'] = !empty($settings['banner']['id']) ? $settings['banner']['id'] : get_post_thumbnail_id();
$img_class = genzia_nice_class([
	($settings['img_cover'] == 'yes') ? 'img-cover' : '',
	$this->get_setting('e_classes')
]);
//wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-ebanner', 
		'cms-ebanner-'.$settings['layout'],
		'relative'
	]
]);
// Title
$this->add_render_attribute('title',[
	'class' => [
		'cms-title empty-none',
		'heading text-xl',
		'text-'.$this->get_setting('title_color', 'white')
	]
]);
// Description
$this->add_render_attribute('desc',[
	'class' => [
		'cms-desc empty-none',
		'text-md',
		'text-'.$this->get_setting('desc_color','on-dark'),
		'pt-10'
	]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>><?php
	genzia_elementor_image_render($settings,[
		'name'                => 'banner',
		//'size'			  => '',
		'custom_size'         => ['width' => 592, 'height' => 432],
		'img_class'			  => $img_class
	]);
?>
	<div class="absolute bottom left ml-24 mb-24 bg-backdrop p-32 max-w" style="--max-w:280px;">
		<div <?php ctc_print_html($this->get_render_attribute_string('title'));?>><?php ctc_print_html($settings['title']); ?></div>
		<div <?php ctc_print_html($this->get_render_attribute_string('desc'));?>><?php ctc_print_html($settings['desc']); ?></div>
	</div>
</div>