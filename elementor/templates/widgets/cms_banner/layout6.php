<?php 
// Post thumnail as banner
$settings['banner']['id'] = !empty($settings['banner']['id']) ? $settings['banner']['id'] : get_post_thumbnail_id();
$img_class = genzia_nice_class([
	($settings['img_cover'] == 'yes') ? 'img-cover' : '',
	$this->get_setting('e_classes'),
	'cms-radius-16'
]);
// Title
$this->add_render_attribute('title',[
	'class' => [
		'cms-heading h5',
		'empty-none',
		'text-'.$this->get_setting('heading_color','heading-regular'),
		'pb-40 mt-nh5'
	]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php echo esc_html($settings['heading_text']); ?></div>
<?php
genzia_elementor_image_render($settings,[
	'name'                => 'banner',
	//'size'			  => '',
	'custom_size'         => ['width' => 760, 'height' => 507],
	'img_class'			  => $img_class,
	'max_height'       	  => true
]);
?>