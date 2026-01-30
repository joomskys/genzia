<?php
$settings['bg_image']['id'] = !empty($settings['bg_image']['id']) ? $settings['bg_image']['id'] : get_post_thumbnail_id();
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-eptitle',
		'cms-eptitle-'.$settings['layout']
	]
]);
// Container
$this->add_render_attribute('container',[
	'class' => [
		'cms-content',
		'relative z-top2',
		'p-lr-48 p-lr-tablet-20'
	]
]);
// Title
$this->add_inline_editing_attributes('title');
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-nl2br lh-107',
		'cms-title',
		'text-'.$this->get_setting('title_color','heading-regular'),
		'empty-none',
		'elementor-invisible',
		'pt pb'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 300
	]),
	'style' => [
		'--max-w:'.$content_width.'px;',
		'--pt:calc(90px + var(--cms-wrap-header-height, 0px));',
		'--pt-tablet:calc(40px + var(--cms-wrap-header-height, 0px));',
		'--pb:97px;--pb-tablet:42px;'
	]
]);
// Features
$features = $this->get_setting('features', []);
$this->add_render_attribute('features', [
	'class' => [
		'cms-ptitle-features',
		'd-flex gutter-40',
		'flex-col-4 flex-col-mobile-2 flex-col-smobile-1',
		'pb'
	],
	'style' => '--pb:112px;--pb-tablet:60px;'
]);
$this->add_render_attribute('fitem', [
	'class' => [
		'cms-ptitle-feature-item'
	]
]);
$this->add_render_attribute('fitem-inner', [
	'class' => [
		'cms-ptitle-feature--item',
		'p-tb-25 p-lr-32 p-lr-smobile-20',
		'bdr-t-1 bdr-b-1 bdr-divider',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInRight'
	])
]);
$this->add_render_attribute('fitem-title', [
	'class' => [
		'cms-ptitle-feature-item-title',
		'text-md',
		'pb-3'
	]
]);
$this->add_render_attribute('fitem-value', [
	'class' => [
		'cms-ptitle-feature-item-value',
		'heading text-xl text-sub-text'
	]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div <?php ctc_print_html($this->get_render_attribute_string('container')); ?>>
		<h1 <?php ctc_print_html( $this->get_render_attribute_string('title') ); ?>><?php 
			echo nl2br( $this->get_setting('title', get_the_title())); 
		?></h1>
		<div <?php ctc_print_html($this->get_render_attribute_string('features')); ?>><?php 
			foreach ($features as $key => $feature) {
		?>
			<div <?php ctc_print_html($this->get_render_attribute_string('fitem')); ?>>
				<div <?php ctc_print_html($this->get_render_attribute_string('fitem-inner')); ?>>
					<div <?php ctc_print_html($this->get_render_attribute_string('fitem-title')); ?>><?php echo esc_html($feature['ftitle']); ?></div>
					<div <?php ctc_print_html($this->get_render_attribute_string('fitem-value')); ?>><?php echo esc_html($feature['fvalue']); ?></div>
				</div>
			</div>
		<?php
			}
		?></div>
	</div>
	<?php 
		genzia_elementor_image_render($settings,[
			'name'          => 'bg_image',
			'size'          => 'custom',
			'custom_size'   => ['width' => 1600, 'height' => 900],
			'class'         => '',
			'img_class'     => 'img-cover',
			'max_height'    => true,
			'as_background' => true,
			'as_background_class' => 'cms-bg-parallax'
		]);
	?>
</div>