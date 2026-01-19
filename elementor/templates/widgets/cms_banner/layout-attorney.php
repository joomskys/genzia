<?php
//wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-ebanner',
		'cms-ebanner-' . $settings['layout'],
		'relative',
		$this->get_setting('css_classes')
	]
]);
$img_class = genzia_nice_class([
	($settings['img_cover'] == 'yes') ? 'img-cover' : '',
	$this->get_setting('e_classes'),
	'mb-25'
]);
// Email
$this->add_render_attribute('email',[
	'class'=>[
		'cms-email heading empty-none',
		'text-xl',
		'text-'.$this->get_setting('email_color','accent-regular'),
		'text-hover-'.$this->get_setting('email_color','accent-regular'),
		'cms-hover-underline',
		'd-inline-flex gap-15 align-items-center'
	],
	'href'   => 'mailto:'.$settings['email'],
	'target' => '_blank'
]);
// Phone
$this->add_render_attribute('phone',[
	'class' => [
		'cms-phone heading empty-none',
		'text-xl',
		'text-'.$this->get_setting('phone_color','menu'),
		'text-hover-'.$this->get_setting('phone_color','menu'),
		'cms-hover-underline',
		'mt-10',
		'd-inline-flex gap-15 align-items-center'
	],
	'href'   => 'tel:'.str_replace(' ', '', $settings['phone']),
	'target' => '_blank'
]);
// Social
$icons = $this->get_setting('icons', []);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php
	// Banner
	genzia_elementor_image_render($settings, [
		'name'        => 'banner',
		'custom_size' => ['width' => 384, 'height' => 484],
		'img_class'   => $img_class,
		'max_height'  => true
	]); ?>
	<a <?php ctc_print_html($this->get_render_attribute_string('email')); ?>><?php 
		genzia_elementor_icon_render($settings['email_icon'], [], [ 'aria-hidden' => 'true', 'class' => 'cms-icon text-heading-regular', 'icon_size' => 20]);
		//
		echo esc_html($settings['email']);
	?></a>
	<div class="clearfix"></div>
	<a <?php ctc_print_html($this->get_render_attribute_string('phone')); ?>><?php 
		genzia_elementor_icon_render($settings['phone_icon'], [], [ 'aria-hidden' => 'true', 'class' => 'cms-icon text-heading-regular', 'icon_size' => 16]);
		//
		echo esc_html($settings['phone']);
	?></a>
	<div class="d-flex gap-8 pt-15">
		<?php
			foreach ( $icons as $key => $value ) {
				$_id = isset( $value['_id'] ) ? $value['_id'] : '';			
				$link_key = $this->get_repeater_setting_key( 'link', 'icons', $key );
				$this->add_render_attribute( $link_key, [
					'class' => [
						'cms-social-item',
						'elementor-repeater-item-' . $_id,
						'text-menu',
						'text-hover-white',
						'cms-box-44 cms-radius-2',
						'bg-white',
						'bg-hover-menu',
						'bdr-1 bdr-divider-dark',
						'bdr-hover-menu'
					],
					'aria-label' => $value['title']
				]);
				$this->add_link_attributes( $link_key, $value['link'] );
		?>
		<a <?php ctc_print_html($this->get_render_attribute_string( $link_key )); ?>>
			<span class="screen-reader-text"><?php echo esc_html($value['title']); ?></span>
			<?php genzia_elementor_icon_render( $value['social_icon'], [], [ 'aria-hidden' => 'true', 'class' => 'cms-icon ', 'icon_size' => 20 ] ); ?>
		</a>
		<?php } ?>
	</div>
</div>