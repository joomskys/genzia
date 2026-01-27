<?php
// Large Heading
$this->add_inline_editing_attributes( 'heading_text', 'none' );
$this->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-title',
		'text-'.$this->get_setting('heading_color','heading-regular'),
		'elementor-invisible',
		'cms-heading empty-none',
		'm-tb-n7',
		'cms-nl2br'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	]),
]);
?>
<h2 <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>