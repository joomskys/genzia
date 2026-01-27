<?php
// Small Heading
$this->add_inline_editing_attributes( 'smallheading_text' );
$this->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-small',
		'elementor-invisible',
		'cms-smallheading cms-nl2br',
		'text-xl',
		'text-'.$this->get_setting('smallheading_color','sub-text'),
		'empty-none',
		'm-tb-nxl',
		'text-center'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 100
	])
]);
$small_icon_classes = genzia_nice_class([
	'cms-small-icon pb-30',
	'text-'.$this->get_setting('smallheading_icon_color', 'accent-regular'),
	'text-center'
]);
?>
<?php 
	// Icon
	genzia_elementor_icon_render( $settings['smallheading_icon'], [], [ 'aria-hidden' => 'true', 'class' => $small_icon_classes, 'icon_size' => 12 ], 'div' );
?>
<div <?php ctc_print_html( $this->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php 
	// Text
	echo nl2br( $settings['smallheading_text'] ); 
?></div>