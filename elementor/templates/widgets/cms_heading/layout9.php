<?php
// Large Heading
$this->add_inline_editing_attributes( 'heading_text', 'none' );
$this->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-title cms-nl2br empty-none',
		'text-lg mt-nlg font-500',
		'text-'.$this->get_setting('heading_color','sub-text'),
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	]),
]);
// Description
$this->add_inline_editing_attributes( 'desc' );
$this->add_render_attribute( 'desc', [
	'class' => [
		'cms-desc cms-nl2br empty-none',
		'text-'.$this->get_setting('desc_color','body'),
		'elementor-invisible',
		'pt-25'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
// Feature
$features = $this->get_setting('features', []);
$this->add_render_attribute('features', [
	'class' => [
		'cms-eheading-features',
		'empty-none',
		'pt-32',
		'text-md font-500',
		'text-sub-text',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
?>
<div <?php ctc_print_html( $this->get_render_attribute_string('heading_text')); ?>><?php echo nl2br( $settings['heading_text'] ); ?></div>
<div <?php ctc_print_html( $this->get_render_attribute_string('desc')); ?>><?php echo nl2br( $settings['desc'] ); ?></div>
<div <?php ctc_print_html( $this->get_render_attribute_string('features')); ?>><?php
	$count = 0;
	foreach ($features as $fkey => $feature) {
		$count++;
	//
	$fitem_key = $this->get_repeater_setting_key('fitem', 'cms_heading', $fkey);
	$this->add_render_attribute($fitem_key, [
		'class' => [
			'd-flex flex-nowrap gap-12 align-items-center',
			($count>1) ? 'pt-16' : ''
		]
	])
?>
	<div <?php ctc_print_html($this->get_render_attribute_string($fitem_key)); ?>><?php 
		// Icon
		genzia_svgs_icon([
			'icon' => 'dot',
			'icon_size' => 6,
			'class' => genzia_nice_class([
				'cms--ficon',
				'flex-auto',
				'cms-box-22 circle',
				'bg-bg-light',
				'text-accent-regular'
			])
		]);
		// text
		echo esc_html($feature['ftitle']);
	?></div>
<?php
	}
?></div>
