<?php
// Small Heading
$this->add_inline_editing_attributes( 'smallheading_text' );
$this->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-small',
		'elementor-invisible',
		'cms-smallheading cms-nl2br',
		'text-lg',
		'text-'.$this->get_setting('smallheading_color','accent-regular'),
		'empty-none',
		'm-tb-nlg',
		'pb-10',
		'd-flex gap-8 flex-nowrap'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp',
		'animation_delay' => 100
	])
]);
$small_icon_classes = genzia_nice_class([
	'cms-small-icon pt-7',
	'text-'.$this->get_setting('smallheading_icon_color', 'accent-regular')
]);
// Large Heading
$this->add_inline_editing_attributes( 'heading_text', 'none' );
$this->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-title',
		'text-'.$this->get_setting('heading_color','heading-regular'),
		'cms-nl2br',
		'elementor-invisible',
		'cms-heading empty-none',
		'm-tb-n7'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
?>
<div <?php ctc_print_html( $this->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php 
	// Icon
	genzia_elementor_icon_render( $settings['smallheading_icon'], [], [ 'aria-hidden' => 'true', 'class' => $small_icon_classes, 'icon_size' => 12 ] );
	// Text
	echo nl2br( $settings['smallheading_text'] ); 
?></div>
<h3 <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>>
	<?php echo nl2br( $settings['heading_text'] ); ?>
</h3>