<?php
// wrap
$this->add_render_attribute('wrap', [
	'id'    => 'cms-ecf7-'.$this->get_id(),
	'class' => [
		'cms-ecf7',
		'cms-ecf7-' . $settings['layout'],
		'cms-form',
		'bg-white',
		'p-48 p-lr-smobile-20',
		'cms-radius-16',
		'cms-shadow-1'
	],
	'style' => genzia_elementor_form_style_render($this, $settings, [])
]);
// Small Title
$this->add_inline_editing_attributes('ctf7_small_title');
$this->add_render_attribute('ctf7_small_title', [
	'class' => [
		'cms-small empty-none',
		'text-'.$this->get_setting('small_title_color','accent-regular'),
		'text-md',
		'm-tb-n5 pb-20',
		'elementor-invisible',
		'relative'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// title
$this->add_inline_editing_attributes('ctf7_title');
$this->add_render_attribute('ctf7_title', [
	'class' => [
		'cms-title cms-nl2br cms-heading empty-none',
		'font-500',
		'text-'.$this->get_setting('title_color','heading-regular'),
		'm-tb-nh6',
		'elementor-invisible',
		'relative'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// description
$this->add_inline_editing_attributes('ctf7_description');
$this->add_render_attribute('ctf7_description', [
	'class' => [
		'cms-desc empty-none',
		'text-'.$this->get_setting('desc_color','body'),
		'text-lg',
		'm-tb-nlg pt-20',
		'elementor-invisible',
		'relative'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// Form
$this->add_render_attribute('form', [
	'class' => [
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// note
$this->add_inline_editing_attributes('ctf7_note');
$this->add_render_attribute('ctf7_note', [
	'class' => [
		'cms-note empty-none',
		'text-'.$this->get_setting('note_color','body'),
		'text-md text-italic',
		'm-tb-n5 pt-40',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php
		// Icon
		genzia_elementor_icon_image_render($this, $settings, [
			'name'         => 'ctf7_title_icon',
			'class'        => 'mb-40',
			'size'         => 64,
			'color'        => 'accent-regular',
			'icon_tag'     => 'div',
			'default_icon' => []
		]);
	?>
	<div <?php ctc_print_html($this->get_render_attribute_string('ctf7_small_title')); ?>><?php 
		ctc_print_html($settings['ctf7_small_title']);
	?></div>
	<h6 <?php ctc_print_html($this->get_render_attribute_string('ctf7_title'));?>><?php
		// Text
		echo nl2br($settings['ctf7_title']); 
	?></h6>
	<div <?php ctc_print_html($this->get_render_attribute_string('ctf7_description')); ?>><?php 
		echo nl2br($settings['ctf7_description']);
	?></div>
	<?php
	if (!empty($settings['ctf7_small_title']) || !empty($settings['ctf7_title']) || !empty($settings['ctf7_description']) || !empty($icon)) {
		echo '<div style="padding-top:37px;"></div>';
	}
	?>
	<div <?php ctc_print_html($this->get_render_attribute_string('form')); ?>>
		<?php echo do_shortcode('[contact-form-7 id="' . esc_attr($settings['ctf7_slug']) . '"]'); ?>
	</div>
	<div <?php ctc_print_html($this->get_render_attribute_string('ctf7_note')); ?>><?php
	  echo nl2br($settings['ctf7_note']);
	  ?></div>
</div>