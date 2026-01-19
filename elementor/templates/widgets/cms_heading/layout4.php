<?php
// Large Heading
$this->add_inline_editing_attributes( 'heading_text' );
$this->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-title empty-none',
		'text-'.$this->get_setting('heading_color','heading-regular'),
		'cms-nl2br',
		'elementor-invisible',
		'm-tb-nh2',
		'text-center'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
// Description
$this->add_inline_editing_attributes( 'desc' );
$this->add_render_attribute( 'desc', [
	'class' => [
		'cms-desc empty-none',
		'heading text-xl',
		'text-'.$this->get_setting('desc_color','sub-text'),
		'cms-nl2br',
		'elementor-invisible',
		'pt-45 p-lr-48 p-lr-smobile-0',
		'text-center'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
?>
<h2 <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>><?php 
	echo nl2br( $settings['heading_text'] ); 
?></h2>
<div <?php ctc_print_html( $this->get_render_attribute_string( 'desc' ) ); ?>><?php 
	echo nl2br( $settings['desc'] ); 
?></div>