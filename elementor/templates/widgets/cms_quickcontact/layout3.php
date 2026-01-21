<?php
// Wrap 
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-eqc',
		'cms-eqc-'.$settings['layout'],
		genzia_elementor_get_responsive_class($widget, $settings, ['name' => 'align']),
		'd-flex gutter',
		'flex-col-2 flex-col-smobile-1'
	]
]);
// Items
$qc_item_classes = [
	'cms-eqc-item',
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
				'text-'.$this->get_setting('email_color','accent-regular'),
				'text-hover-'.$this->get_setting('email_color_hover','primary-regular')
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
			'text-'.$this->get_setting('email_title_color','body'),
			'text-sm',
			'pt-20'
		]
	]);
	// email
	$this->add_inline_editing_attributes( 'email' );
	$this->add_render_attribute( 'email', [
		'class' => [
			'cms-email-text',
			'text-xl',
			'heading'
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
			'text-'.$this->get_setting('phone_title_color','body'),
			'text-sm',
			'pt-20'
		]
	]);
	// phone number
	$this->add_inline_editing_attributes('phone');
	$this->add_render_attribute( 'phone',[ 
		'class' => [
			'cms-phone-text',
			'text-xl',
			'heading'
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
			'text-'.$this->get_setting('time_title_color','body'),
			'text-sm',
			'pt-20'
		])
	]);
	// time
	$this->add_inline_editing_attributes( 'time' );
	$this->add_render_attribute( 'time', [
		'class' => [
			'cms-time-text',
			'text-xl',
			'heading'
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
				'text-hover-'.$this->get_setting('address_color_hover', $default_color_hover),
				'mb-25'
			]
		),
		'href'          => vsprintf( $map_url, $map_params ),
		'target'        => '_blank',
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
			'text-'.$this->get_setting('address_title_color','body'),
			'text-sm',
			'pt-20'
		]
	]);
	// address
	$this->add_inline_editing_attributes( 'address' );
	$this->add_render_attribute( 'address', [
		'class' => [
			'cms-address-text',
			'text-xl',
			'heading'
		]
	]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php 
	// Phone
	if(!empty($settings['phone'])) { ?>
	<div class="">
		<a <?php ctc_print_html( $this->get_render_attribute_string( 'phone-item' ) ); ?>>
			<?php genzia_elementor_icon_render( $settings['phone_icon'], [], ['class' => $phone_icon_class, 'icon_size' => 16 ]);?>
			<div <?php ctc_print_html($this->get_render_attribute_string('phone')); ?>><?php echo esc_html($settings['phone']); ?></div>
			<div <?php ctc_print_html($this->get_render_attribute_string('phone_title')); ?>><?php echo esc_html($settings['phone_title']); ?></div>
		</a>
	</div>
	<?php } 
	// Email
	if(!empty($settings['email'])){
	?>
	<div class="">
		<a <?php ctc_print_html( $this->get_render_attribute_string( 'email-item' ) ); ?>>
			<?php 
				genzia_elementor_icon_render( $settings['email_icon'], [], ['class' => $email_icon_class, 'icon_size' => 16 ]); 
			?>
			<div <?php ctc_print_html($this->get_render_attribute_string('email')); ?>><?php echo esc_html($settings['email']); ?></div>
			<div <?php ctc_print_html($this->get_render_attribute_string('email_title')); ?>><?php echo esc_html($settings['email_title']); ?></div>
		</a>
	</div>
	<?php }
	// Address
	if(!empty($address)) { ?>
	<div class="">
		<a <?php ctc_print_html( $this->get_render_attribute_string( 'address-item' ) ); ?>>
			<?php genzia_elementor_icon_render( $settings['address_icon'], [], ['class' => $address_icon_class, 'icon_size' => 16 ]);?>
			<div <?php ctc_print_html($this->get_render_attribute_string('address')); ?>><?php echo esc_html($settings['address']); ?></div>
			<div <?php ctc_print_html($this->get_render_attribute_string('address_title')); ?>><?php echo esc_html($settings['address_title']); ?></div>
		</a>
	</div>
	<?php }
	// Time
	if(!empty($settings['time'])){
	?>
	<div <?php ctc_print_html( $this->get_render_attribute_string( 'time-item' ) ); ?>>
		<?php 
			genzia_elementor_icon_render( $settings['time_icon'], [], ['class' => $time_icon_class, 'icon_size' => 16 ]);
		?>
		<div <?php ctc_print_html($this->get_render_attribute_string('time')); ?>><?php echo esc_html($settings['time']); ?></div>
		<div <?php ctc_print_html($this->get_render_attribute_string('time_title')); ?>>
			<?php echo esc_html($settings['time_title']); ?>
		</div>
		<div class="exclude-time text-error empty-none w-100 text-sm"><?php ctc_print_html($settings['exclude_time']); ?></div>
	</div>
	<?php } ?>
</div>