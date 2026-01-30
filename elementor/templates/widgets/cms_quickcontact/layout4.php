<?php
	$border_classes = genzia_nice_class([
		'bdr-t-1 bdr-'.$this->get_setting('bdr_color','divider'),
		'cms-border',
	]);
	// Wrap 
	$this->add_render_attribute('wrap',[
		'class' => [
			'cms-eqc',
			'cms-eqc-'.$settings['layout'],
			genzia_elementor_get_responsive_class($widget, $settings, ['name' => 'align']),
			'bdr-b-1 bdr-'.$this->get_setting('bdr_color','divider'),
			'cms-border',
			'pb-25'
		]
	]);
	$qc_item_classes = [
		'cms-eqc-item',
		'elementor-invisible',
		'pt-28 pb-25',
		'd-block',
		$border_classes
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
					'text-'.$this->get_setting('email_color', $default_color),
					'text-hover-'.$this->get_setting('email_color_hover', $default_color_hover)
				]
			),
			'href'   => 'mailto:'.$settings['email'],
			'target' => '_blank',
			'data-settings' => wp_json_encode([
				'animation' => 'fadeInUp'
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
				'text-sm',
				'text-'.$this->get_setting('email_title_color','body'),
				'pb-10'
			]
		]);
		// email
		$this->add_inline_editing_attributes( 'email' );
		$this->add_render_attribute( 'email', [
			'class' => [
				'cms-email-text',
				'heading text-xl'
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
					'text-hover-'.$this->get_setting('phone_color_hover', $default_color_hover)
				]
			),
			'href' => 'tel:'.$phone_link,
			'data-settings' => wp_json_encode([
				'animation' => 'fadeInUp'
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
				'text-sm',
				'text-'.$this->get_setting('phone_title_color','body'),
				'pb-10'
			]
		]);
		// phone number
		$this->add_inline_editing_attributes('phone');
		$this->add_render_attribute( 'phone',[ 
			'class' => [
				'cms-phone-text',
				'heading text-xl'
			]
		]);
	// Adress
		$address     = $settings['address'];
		$map_zoom    = 14;
		$map_api_key = genzia_get_opt('gm_api_key');
		$map_params  = [
		    rawurlencode( $address ),
		    absint( $map_zoom )
		];
		$map_url = 'https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;iwloc=near';
		
		$this->add_render_attribute( 'address-item', [
			'class' => array_merge(
				$qc_item_classes,
				[
					'cms-address',
					'text-'.$this->get_setting('address_color', $default_color),
					'text-hover-'.$this->get_setting('address_color_hover', $default_color_hover)
				]
			),
			'href'   => vsprintf( $map_url, $map_params ),
			'target' => '_blank',
			'data-settings' => wp_json_encode([
				'animation' => 'fadeInUp'
			])
		]);
		// Address Icon
		$address_icon_class = [
			'cms-address-icon',
			'text-'.$icon_color
		];
		// address title
		$this->add_inline_editing_attributes( 'address_title' );
		$this->add_render_attribute( 'address_title', [
			'class' => [
				'cms-address-title empty-none',
				'text-sm',
				'text-'.$this->get_setting('address_title_color','body'),
				'pb-10'
			]
		]);
		// address
		$this->add_inline_editing_attributes( 'address' );
		$this->add_render_attribute( 'address', [
			'class' => [
				'cms-address-text',
				'heading text-xl'
			]
		]);
// Social
$icons = $this->get_setting('icons', []);
$this->add_render_attribute('socials',[
	'class' => [
		'd-flex gap-16 pt-32',
		'elementor-invisible',
		$border_classes
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php 
	// Phone
	if(!empty($settings['phone'])) { ?>
		<a <?php ctc_print_html( $this->get_render_attribute_string( 'phone-item' ) ); ?>>
			<div <?php ctc_print_html($this->get_render_attribute_string('phone_title')); ?>><?php echo esc_html($settings['phone_title']); ?></div>
			<div class="d-flex flex-nowrap gap-16 align-items-center">
				<?php 
				genzia_elementor_icon_render( $settings['phone_icon'], [], ['aria-hidden' => 'true', 'class' => $phone_icon_class, 'icon_size' => 16 ]);?>
				<div <?php ctc_print_html($this->get_render_attribute_string('phone')); ?>><?php echo esc_html($settings['phone']); ?></div>
			</div>
		</a>
	<?php }
	// Email
	if(!empty($settings['email'])){
	?>
		<a <?php ctc_print_html( $this->get_render_attribute_string( 'email-item' ) ); ?>>
			<div <?php ctc_print_html($this->get_render_attribute_string('email_title')); ?>><?php echo esc_html($settings['email_title']); ?></div>
			<div class="d-flex flex-nowrap gap-16 align-items-center">
				<?php 
					genzia_elementor_icon_render( $settings['email_icon'], [], ['aria-hidden' => 'true', 'class' => $email_icon_class, 'icon_size' => 20 ]); 
				?>
				<div <?php ctc_print_html($this->get_render_attribute_string('email')); ?>><?php echo esc_html($settings['email']); ?></div>
			</div>
		</a>
	<?php }
		// Address
		if(!empty($address)) { ?>
		<a <?php ctc_print_html( $this->get_render_attribute_string( 'address-item' ) ); ?>>
			<div <?php ctc_print_html($this->get_render_attribute_string('address_title')); ?>><?php echo esc_html($settings['address_title']); ?></div>
			<div class="d-flex flex-nowrap gap-16 align-items-center">
				<?php 
					genzia_elementor_icon_render( $settings['address_icon'], [], ['aria-hidden' => 'true', 'class' => $address_icon_class, 'icon_size' => 16 ]);
				?>
				<div <?php ctc_print_html($this->get_render_attribute_string('address')); ?>><?php echo esc_html($settings['address']); ?></div>
			</div>
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
						'text-menu',
						'text-hover-accent'
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