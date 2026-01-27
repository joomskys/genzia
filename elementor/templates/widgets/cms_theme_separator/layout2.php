<?php
// Large Heading
$this->add_render_attribute( 'separator', [
	'class' => array_filter([
		'cms-eseparate',
		'cms-eseparate-'.$settings['layout'],
		'relative',
		'd-flex gap-10 flex-nowrap',
		'align-items-center',
		$this->get_setting('e_classes')
	])
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
?>
<div <?php ctc_print_html( $this->get_render_attribute_string('separator')); ?>>
	<div <?php ctc_print_html($this->get_render_attribute_string('divider')); ?>></div>
	<?php
		// Icon
		genzia_elementor_icon_render( $settings['separaror_icon'], [], ['class' => $separator_icon_classes, 'icon_size' => 12 ] );
	?>
	<div <?php ctc_print_html($this->get_render_attribute_string('divider')); ?>></div>
</div>