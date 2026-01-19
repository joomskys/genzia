<?php
// wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-ecf7',
		'cms-ecf7-' . $settings['layout'],
		'cms-form',
		'bg-white',
		'relative z-top',
		'p-56 p-lr-smobile-16',
		'cms-radius-8',
		'cms-shadow-2',
		'col-7 col-mobile-12'
	]
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
		'text-'.$this->get_setting('title_color','heading-regular'),
		'm-tb-n5',
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
		'm-tb-n5 pt-15',
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
// Banner Title
$this->add_render_attribute('banner-title',[
	'class' => [
		'cms-banner-title h4',
		'text-'.$this->get_setting('banner_title_color', 'white'),
		'align-self-start m-tb-n8'
	]
]);
// Banner Desc
$this->add_render_attribute('banner_desc',[
	'class' => [
		'cms-banner-desc',
		'text-'.$this->get_setting('banner_desc_color', 'on-dark'),
		'w-100'
	]
]);
// Banner Email
$this->add_render_attribute('banner-email',[
	'class' => [
		'cms-email',
		'text-'.$this->get_setting('email_color','white'),
		'text-hover-'.$this->get_setting('email_color_hover','white'),
		'cms-hover-underline'
	],
	'href' => 'mailto:'.$settings['email']
]);
// Banner Phone
$this->add_render_attribute('banner-phone', [
	'class' => [
		'cms-phone',
		'text-'.$this->get_setting('phone_color', 'white'),
		'text-hover-'.$this->get_setting('phone_color_hover','white'),
		'cms-hover-underline'
	],
	'href' => 'tel:'.$settings['phone']
]);
?>
<div class="d-flex cms-hover-icon-alternate">
	<div class="col-5 col-mobile-12 relative mr-n12 cms-radius-8 overflow-hidden cms-gradient-render cms-gradient-4 d-flex justify-content-between p-56 p-lr-tablet-20 p-lr-smobile-16">
		<?php 
			genzia_elementor_image_render($settings,[
				'name'        => 'banner',
				'size'        => 'full',
				'custom_size' => ['width' => 530, 'height' => 677],
				'img_class'   => 'img-cover absolute top left'
			]);
		?>
		<div <?php ctc_print_html($this->get_render_attribute_string('banner-title')); ?>>
			<?php 
				// Title
				echo esc_html($settings['banner_title']); 
				// Icon
				genzia_svgs_icon([
					'icon'      => 'arrow-up-right-alternate',
					'icon_size' => 72,
					'tag'		=> 'div',
					'class'	    => 'mt-30'
				]);
			?>
		</div>
		<div class="align-self-end d-flex justify-content-between mb-n7 pt-40">
			<div <?php ctc_print_html($this->get_render_attribute_string('banner_desc')); ?>><?php echo esc_html($settings['banner_desc']) ?></div>
			<div class="bdr-t-1 bdr-divider-light m-tb-24 w-100"></div>
			<a <?php ctc_print_html($this->get_render_attribute_string('banner-email')); ?>><?php echo esc_html($settings['email']) ?></a>
			<a <?php ctc_print_html($this->get_render_attribute_string('banner-phone')); ?>><?php echo esc_html($settings['phone']) ?></a>
		</div>
	</div>
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
			echo '<div style="padding-top:30px;"></div>';
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