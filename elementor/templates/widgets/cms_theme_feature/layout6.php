<?php
$chatbot = $this->get_setting('chatbot',[]);
$bdr_color = $this->get_setting('item_bdr_color', 'divider');
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-genzia-features',
		'cms-genzia-features-'.$settings['layout'],
		'bg-bg-dark',
		'cms-gradient-render cms-gradient-2',
		'cms-radius-16',
		'd-flex align-items-end',
		'relative',
		'cms-shadow-2',
		'text-end'
	],
	'style' => [
		'min-height:512px;',
	]
]);
// Title
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-title heading empty-none',
		'text-'.$this->get_setting('title_color','white'),
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
		'text-'.$this->get_setting('description_color','on-dark'),
		'text-md',
		'pt-10',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// Output HTMl
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php 
		// Banner
		genzia_elementor_image_render($settings,[
			'name'        => 'banner',
			'size'        => 'custom',
			'custom_size' => ['width' => 344, 'height' => 374],
			'img_class'	  => 'm-lr-auto relative z-top'
		]);
	?>
	<div class="align-sefl-end relative mt-n10 pb-33 p-lr-40 w-100">
		<h6 <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php 
			echo nl2br($settings['title']);
		?></h6>
		<div <?php ctc_print_html($this->get_render_attribute_string('desc')); ?>><?php 
			echo nl2br($settings['description']);
		?></div>
	</div>
</div>