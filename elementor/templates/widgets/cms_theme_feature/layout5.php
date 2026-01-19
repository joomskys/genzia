<?php
$galleries = $this->get_setting('gallery',[]);
$bdr_color = $this->get_setting('item_bdr_color', 'divider');
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-genzia-features',
		'cms-genzia-features-'.$settings['layout'],
		'bg-white',
		'bdr-1 bdr-'.$bdr_color,
		'cms-radius-16',
		'd-flex justify-content-between',
		'relative',
		'cms-shadow-2',
		'overflow-hidden'
	],
	'style' => 'min-height:512px;'
]);
//Title
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-title heading empty-none',
		'text-'.$this->get_setting('title_color','heading-regular'),
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
		'text-'.$this->get_setting('description_color','body'),
		'text-md',
		'pt-10',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
$this->add_render_attribute( 'banner', [
	'class' => [
		'cms-banner empty-none',
		'align-self-end',
		'w-100'
	]
]);
// Output HTMl
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php 
		// Icon
		genzia_elementor_icon_render( $settings['item_icon'], [], ['class' => 'absolute top right mt-16 mr-16', 'icon_size' => 6, 'icon_color' => 'accent-regular'] );
	?>
	<div class="align-sefl-start relative p-40 w-100">
		<h6 <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php 
			echo nl2br($settings['title']);
		?></h6>
		<div <?php ctc_print_html($this->get_render_attribute_string('desc')); ?>><?php 
			echo nl2br($settings['description']);
		?></div>
	</div>
	<div <?php ctc_print_html($this->get_render_attribute_string('banner')); ?>>
		<?php // Banner
		genzia_elementor_image_render($settings,[
			'name'        => 'banner',
			'size'        => 'custom',
			'custom_size' => ['width' => 392, 'height' => 230],
			'img_class'	  => 'align-self-end'
		]); ?>
	</div>
</div>