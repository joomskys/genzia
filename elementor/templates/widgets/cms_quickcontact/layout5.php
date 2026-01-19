<?php
// Wrap 
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-eqc',
		'cms-eqc-'.$settings['layout'],
		genzia_elementor_get_responsive_class($widget, $settings, ['name' => 'align'])
	]
]);
// Title
$this->add_render_attribute('title', [
	'class' => [
		'cms-title empty-none',
		'text-'.$this->get_setting('title_color', 'sub-text'),
		'pb-25 mb-24 bdr-b-1 bdr-color bdr-'.$this->get_setting('bdr_color','divider')
	]
]);
// Items
$qc_item_classes = [
	'cms-eqc-item',
	'd-inline-flex gapX-10',
	'align-items-center',
	'flex-nowrap',
	'elementor-invisible',
	'heading text-xl'
];
$icon_color = $this->get_setting('icon_color','accent-regular');
$default_color = 'menu';
$default_color_hover = 'accent-regular';
// Email
	// Email item
	$this->add_render_attribute( 'email-item', [
		'class' => array_merge(
			$qc_item_classes,
			[
				'cms-email',
				'text-'.$this->get_setting('email_color','heading-regular'),
				'text-hover-'.$this->get_setting('email_color_hover','primary-regular'),
				'mt-n5',
				'cms-hover-underline'
			]
		),
		'href'   => 'mailto:'.$settings['email'],
		'target' => '_blank',
		'data-settings' => wp_json_encode([
			'animation' => 'fadeInRight'
		])
	]);
	// email icon
	$email_icon_class = genzia_nice_class([
		'cms-email-icon',
		'text-'.$icon_color
	]);
	// email title
	$this->add_inline_editing_attributes( 'email_title' );
	$this->add_render_attribute( 'email_title', [
		'class' => [
			'cms-email-title empty-none',
			'text-'.$this->get_setting('email_title_color'),
			'cms-hidden-mobile'
		]
	]);
	// email
	$this->add_inline_editing_attributes( 'email' );
	$this->add_render_attribute( 'email', [
		'class' => [
			'cms-email-text'
		]
	]);
// Phone
	$phone_link        = str_replace(' ', '', $settings['phone']);
	$this->add_render_attribute( 'phone-item',[ 
		'class' => array_merge(
			$qc_item_classes,
			[
				'cms-phone',
				'text-'.$this->get_setting('phone_color', $default_color),
				'text-hover-'.$this->get_setting('phone_color_hover', $default_color_hover),
				'mt-10',
				'cms-hover-underline'
			]
		),
		'href' => 'tel:'.$phone_link,
		'data-settings' => wp_json_encode([
			'animation' => 'fadeInRight'
		])
	]);
	// Phone Icon
	$phone_icon_class = [
		'cms-phone-icon',
		'text-'.$icon_color
	];
	// phone title
	$this->add_inline_editing_attributes('phone_title');
	$this->add_render_attribute( 'phone_title',[ 
		'class' => [
			'cms-phone-title empty-none',
			'text-'.$this->get_setting('phone_title_color'),
			'cms-hidden-mobile'
		]
	]);
	// phone number
	$this->add_inline_editing_attributes('phone');
	$this->add_render_attribute( 'phone',[ 
		'class' => [
			'cms-phone-text'
		]
	]);
// Social
$icons = $this->get_setting('icons', []);
$this->add_render_attribute('socials',[
	'class' => [
		'd-flex gap-8 pt-25',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php 
	// Email
	if(!empty($settings['email'])){
	?>
	<div class="clearfix"></div>
	<a <?php ctc_print_html( $this->get_render_attribute_string( 'email-item' ) ); ?>>
		<?php 
			genzia_elementor_icon_render( $settings['email_icon'], [], ['aria-hidden' => 'true', 'class' => $email_icon_class, 'icon_size' => 20 ]); 
		?>
		<span>
			<span <?php ctc_print_html($this->get_render_attribute_string('email_title')); ?>><?php echo esc_html($settings['email_title']); ?></span>
			<span <?php ctc_print_html($this->get_render_attribute_string('email')); ?>><?php echo esc_html($settings['email']); ?></span>
		</span>
	</a>
	<?php }
	// Phone
	if(!empty($settings['phone'])) { ?>
		<div class="clearfix"></div>
		<a <?php ctc_print_html( $this->get_render_attribute_string( 'phone-item' ) ); ?>>
			<?php 
				genzia_elementor_icon_render( $settings['phone_icon'], [], ['aria-hidden' => 'true', 'class' => $phone_icon_class, 'icon_size' => 16 ]);?>
			<span>
				<span <?php ctc_print_html($this->get_render_attribute_string('phone_title')); ?>><?php echo esc_html($settings['phone_title']); ?></span>
				<span <?php ctc_print_html($this->get_render_attribute_string('phone')); ?>><?php echo esc_html($settings['phone']); ?></span>
			</span>
		</a>
	<?php } ?>
	<div <?php ctc_print_html($this->get_render_attribute_string('socials')); ?>>
		<?php
			foreach ( $icons as $key => $value ) {
				$_id = isset( $value['_id'] ) ? $value['_id'] : '';			
				$link_key = $this->get_repeater_setting_key( 'link', 'icons', $key );
				$this->add_render_attribute( $link_key, [
					'class' => [
						'cms-social-item',
						'elementor-repeater-item-' . $_id,
						'text-white',
						'text-hover-white',
						'cms-box-44',
						'bg-menu',
						'bg-hover-accent-regular'
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