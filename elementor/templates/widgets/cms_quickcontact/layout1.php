<?php
	// Wrap 
	$this->add_render_attribute('wrap',[
		'class' => [
			'cms-eqc',
			'cms-eqc-'.$settings['layout'],
			genzia_elementor_get_responsive_class($widget, $settings, ['name' => 'align']),
			'd-flex gapX-24 gapY-10',
			genzia_elementor_get_responsive_class($widget, $settings, ['name' => 'align','prefix_class' => 'justify-content-'])
		]
	]);
	$qc_item_classes = [
		'cms-eqc-item',
		'd-flex gapX-10',
		'align-items-center',
		'flex-nowrap',
		'elementor-invisible'
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
	// Time
		$this->add_render_attribute( 'time-item', [
			'class' => array_merge(
				$qc_item_classes,
				[
					'cms-time',
					'text-'.$this->get_setting('time_color', $default_color),
					'text-hover-'.$this->get_setting('time_color_hover', $default_color_hover),
					'cms-transition'
				]
			),
			'data-settings' => wp_json_encode([
				'animation' => 'fadeInRight'
			])
		]);
		// time icon
		$time_icon_class = [
			'cms-time-icon',
			'text-'.$icon_color
		];
		// time title
		$this->add_inline_editing_attributes( 'time_title' );
		$this->add_render_attribute( 'time_title', [
			'class' => array_filter([
				'cms-time-title empty-none',
				'text-'.$this->get_setting('time_title_color'),
				'cms-hidden-mobile'
			])
		]);
		// time
		$this->add_inline_editing_attributes( 'time' );
		$this->add_render_attribute( 'time', [
			'class' => [
				'cms-time-text'
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
				'animation' => 'fadeInRight'
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
				'text-'.$this->get_setting('address_title_color'),
				'cms-hidden-mobile'
			]
		]);
		// address
		$this->add_inline_editing_attributes( 'address' );
		$this->add_render_attribute( 'address', [
			'class' => [
				'cms-address-text'
			]
		]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php 
	// Email
	if(!empty($settings['email'])){
	?>
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
		<a <?php ctc_print_html( $this->get_render_attribute_string( 'phone-item' ) ); ?>>
			<?php 
				genzia_elementor_icon_render( $settings['phone_icon'], [], ['aria-hidden' => 'true', 'class' => $phone_icon_class, 'icon_size' => 16 ]);?>
			<span>
				<span <?php ctc_print_html($this->get_render_attribute_string('phone_title')); ?>><?php echo esc_html($settings['phone_title']); ?></span>
				<span <?php ctc_print_html($this->get_render_attribute_string('phone')); ?>><?php echo esc_html($settings['phone']); ?></span>
			</span>
		</a>
	<?php } ?>
	<?php 
		// Address
		if(!empty($address)) { ?>
		<a <?php ctc_print_html( $this->get_render_attribute_string( 'address-item' ) ); ?>>
			<?php 
				genzia_elementor_icon_render( $settings['address_icon'], [], ['aria-hidden' => 'true', 'class' => $address_icon_class, 'icon_size' => 16 ]);?>
			<span>
				<span <?php ctc_print_html($this->get_render_attribute_string('address_title')); ?>><?php echo esc_html($settings['address_title']); ?></span>
				<span <?php ctc_print_html($this->get_render_attribute_string('address')); ?>><?php echo esc_html($settings['address']); ?></span>
			</span>
		</a>
	<?php }
		// Time
		if(!empty($settings['time'])){
		?>
		<div <?php ctc_print_html( $this->get_render_attribute_string( 'time-item' ) ); ?>>
			<?php 
				genzia_elementor_icon_render( $settings['time_icon'], [], ['aria-hidden' => 'true', 'class' => $time_icon_class, 'icon_size' => 16 ]);
			?>
			<span>
				<span <?php ctc_print_html($this->get_render_attribute_string('time_title')); ?>>
					<?php echo esc_html($settings['time_title']); ?>
				</span>
				<span <?php ctc_print_html($this->get_render_attribute_string('time')); ?>><?php echo esc_html($settings['time']); ?></span>
				<span class="exclude-time text-error empty-none w-100"><?php ctc_print_html($settings['exclude_time']); ?></span>
			</span>
		</div>
	<?php } ?>
</div>