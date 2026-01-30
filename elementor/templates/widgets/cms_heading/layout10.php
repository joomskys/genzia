<?php
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-eheading',
		'cms-eheading-'.$settings['layout'],
		'd-flex gutter'
	]
]);
// Small Heading
$this->add_inline_editing_attributes( 'smallheading_text' );
$this->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-small',
		'elementor-invisible',
		'cms-nl2br',
		'text-sm',
		'text-'.$this->get_setting('smallheading_color','sub-text'),
		'empty-none',
		'm-tb-nsm',
		'cms-sticky',
		'd-flex gap-8 flex-nowrap'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInLeft',
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
		'cms-title cms-nl2br empty-none',
		'mt-nh4',
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
		'heading text-xl text-'.$this->get_setting('desc_color','sub-text'),
		'elementor-invisible',
		'pt-55 pt-tablet-30'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
// Description #2
$this->add_inline_editing_attributes( 'desc2' );
$this->add_render_attribute( 'desc2', [
	'class' => [
		'cms-desc2 cms-nl2br empty-none',
		'text-'.$this->get_setting('desc2_color','body'),
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
$features2 = $this->get_setting('features2', []);
$this->add_render_attribute('features', [
	'class' => [
		'cms-eheading-features',
		'empty-none',
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
<div <?php ctc_print_html( $this->get_render_attribute_string( 'wrap' ) ); ?>>
	<div class="col-5 col-tablet-4 col-mobile-12">
		<div <?php ctc_print_html( $this->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php
			// Icon
			genzia_elementor_icon_render( $settings['smallheading_icon'], [], [ 'aria-hidden' => 'true', 'class' => $small_icon_classes, 'icon_size' => 12 ] );
			// Text
			echo nl2br( $settings['smallheading_text'] ); 
		?></div>
	</div>
	<div class="col-7 col-tablet-8 col-mobile-12">
		<h4 <?php ctc_print_html( $this->get_render_attribute_string('heading_text')); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h4>
		<div <?php ctc_print_html( $this->get_render_attribute_string('desc')); ?>><?php echo nl2br( $settings['desc'] ); ?></div>
		<div <?php ctc_print_html( $this->get_render_attribute_string('desc2')); ?>><?php echo nl2br( $settings['desc2'] ); ?></div>
		<div class="d-flex gutter-16 flex-col-2 flex-col-smobile-1 pt-40">
			<div <?php ctc_print_html( $this->get_render_attribute_string('features')); ?>><?php
				$count = 0;
				foreach ($features as $fkey => $feature) {
					$count++;
				//
				$fitem_key = $this->get_repeater_setting_key('fitem', 'cms_heading', $fkey);
				$this->add_render_attribute($fitem_key, [
					'class' => [
						'd-flex gap-12 align-items-center',
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
			<div <?php ctc_print_html( $this->get_render_attribute_string('features')); ?>><?php
				$count2 = 0;
				foreach ($features2 as $fkey2 => $feature2) {
					$count2++;
				//
				$fitem_key2 = $this->get_repeater_setting_key('fitem', 'cms_heading', $fkey2);
				$this->add_render_attribute($fitem_key2, [
					'class' => [
						'd-flex gap-12 align-items-center',
						($count2>1) ? 'pt-16' : ''
					]
				])
			?>
				<div <?php ctc_print_html($this->get_render_attribute_string($fitem_key2)); ?>><?php 
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
					echo esc_html($feature2['ftitle']);
				?></div>
			<?php
				}
			?></div>
		</div>
	</div>
</div>
