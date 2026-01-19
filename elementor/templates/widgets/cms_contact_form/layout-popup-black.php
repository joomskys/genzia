<?php 
$ctf7_title = '';
$form_id = 'ctf7-form-'.$settings['ctf7_slug'].'-'.$this->get_id();
if(empty($settings['ctf7_slug']) || $settings['ctf7_slug'] === ''){
	$ctf7_title =  'title="Contact form 1"';
}
// Modal
$this->add_render_attribute('ctf7-modal-attrs',[
	'class'            => [
		'cms-ecf7-field-popup',
		'cms-ctf7-modal cms-modal cursor-pointer cursor'.$settings['popup_cursor_color'],
		'cms-transition',
		'cms-overlay',
		'z-top2'
	],
	'data-modal-move'  => '#'.$form_id.'-move',
	'data-modal'       => '#'.$form_id,
	'data-modal-mode'  => "slide",
	'data-modal-slide' => "up", 
	'data-modal-class' => "center"
]);
$this->add_render_attribute('popup-text',[
	'class' => [
		'cms-popup-text',
		'heading text-2xl lh-07',
		'text-'.$this->get_setting('ctf7_popup_title_color','white'),
		'text-hover-'.$this->get_setting('ctf7_popup_title_color_hover', 'accent-regular'),
		'text-on-hover-'.$this->get_setting('ctf7_popup_title_color_hover', 'accent-regular'),
		'd-flex justify-content-between flex-nowrap'
	],
	'data-direction'            => 'false',
	'data-speed'                => 10000,
	'data-spacebetween'         => 10,
	'data-hoverpause'           => 'no',
	'data-disableoninteraction' => 'yes',
	'data-loop'                 => 'yes'
]);
// wrap move
$this->add_render_attribute('wrap-move', [
	'id'    => $form_id.'-move'
]);
// wrap
$this->add_render_attribute('wrap', [
	'id'    => $form_id,
	'class' => [
		'cms-ecf7',
		'cms-ecf7-'.$settings['layout'],
		'cms-modal-html'
	],
	'style'						 => [
		'--cms-modal-width:1280px;',
		'--cms-modal-content-width:1280px;'
	]
]);
if(!empty($settings['ctf7_bg']['id'])){
	$this->add_render_attribute('wrap', [
		'class' => [
			'cms-bg-img cms-bg-cover',
			'p-110 p-lr-tablet-50 p-lr-mobile-20'
		]
	]);
}
// Small Title
$this->add_inline_editing_attributes('ctf7_small_title');
$this->add_render_attribute('ctf7_small_title', [
	'class' => [
		'cms-small empty-none',
		'text-'.$this->get_setting('small_title_color','accent-regular'),
		'text-md',
		'm-tb-n5 pb-20',
		'relative'
	]
]);
// title
$this->add_inline_editing_attributes('ctf7_title');
$this->add_render_attribute('ctf7_title', [
	'class' => [
		'cms-title cms-nl2br cms-heading empty-none',
		'text-'.$this->get_setting('title_color','heading-regular'),
		'm-tb-n5',
		'relative'
	]
]);
// description
$this->add_inline_editing_attributes('ctf7_description');
$this->add_render_attribute('ctf7_description', [
	'class' => [
		'cms-desc empty-none',
		'text-'.$this->get_setting('desc_color','body'),
		'text-lg',
		'm-tb-n5 pt-20',
		'relative'
	]
]);
// Form
$this->add_render_attribute('form', [
	'class' => [
		'ctf7--form'
	]
]);
// note
$this->add_inline_editing_attributes('ctf7_note');
$this->add_render_attribute('ctf7_note', [
	'class' => [
		'cms-note empty-none',
		'text-'.$this->get_setting('note_color','body'),
		'text-md text-italic',
		'm-tb-n5 pt-40'
	]
]);
?>
<div class="relative cms-hover-change cms-hover-icon-alternate">
	<div <?php ctc_print_html($this->get_render_attribute_string('popup-text')); ?>>
		<?php 
			// text
			ctc_print_html($this->get_setting('ctf7_popup_title', 'Get In Touch'));
			// icon
			genzia_svgs_icon([
				'icon'      => 'arrow-up-right-alternate',
				'icon_size' => 84
			]);
		?>
	</div>
	<div <?php ctc_print_html($this->get_render_attribute_string('ctf7-modal-attrs')) ?>>
	</div>
</div>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap-move')); ?>>
	<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
		<div class="cms-modal-content bg-white cms-radius-20">
			<div class="cms-modal--content cms-mousewheel">
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
		</div>
	</div>
</div>