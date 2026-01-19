<?php
// Large Heading
$this->add_render_attribute( 'separator', [
	'class' => [
		'cms-eseparate',
		'cms-eseparate-'.$settings['layout'],
		'relative',
		'd-flex gap-10 flex-nowrap',
		'align-items-center'
	]
]);
$separator_icon_classes = genzia_nice_class([
	'cms-separate-icon',
	'text-'.$this->get_setting('separator_icon_color', 'accent-regular'),
	'flex-auto'
]);
// Divider
$this->add_render_attribute('divider',[
	'class' => [
		'flex-basic',
		'bdr-t-1 bdr-'.$this->get_setting('separator_color','divider')
	]
]);
// Divider Left
$divider_classes = genzia_nice_class([
	'divider',
	'absolute',
	'bdr-l-1 bdr-'.$this->get_setting('separator_color','divider')
]);
$this->add_render_attribute('divider-left',[
	'class' => [
		$divider_classes,
		'left'
	],
	'style' => [
		'height:114px;',
		'margin-inline-start:48px;'
	]
]);
$this->add_render_attribute('divider-right',[
	'class' => [
		$divider_classes,
		'right'
	],
	'style' => [
		'height:114px;',
		'margin-inline-end:48px;' 
	]
]);
?>
<div <?php ctc_print_html( $this->get_render_attribute_string('separator')); ?>>
	<div <?php ctc_print_html($this->get_render_attribute_string('divider')); ?>></div>
	<?php
		// Icon
		genzia_elementor_icon_render( $settings['separaror_icon'], [], ['class' => $separator_icon_classes, 'icon_size' => 12 ] );
	?>
	<div <?php ctc_print_html($this->get_render_attribute_string('divider')); ?>></div>
	<div <?php ctc_print_html( $this->get_render_attribute_string('divider-left')); ?>></div>
	<div <?php ctc_print_html( $this->get_render_attribute_string('divider-right')); ?>></div>
</div>