<?php
$counters      = $this->get_setting('counters', []);
if (empty($counters)) return;
//
$default_align = 'start';
$default_col   = 1;
$tablet_col    = 1;
$mobile_col    = 1;
// wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-ecounter',
		'cms-ecounter-' . $settings['layout'],
		'text-' . $default_align,
		'overflow-hidden'
	]
]);
// Number
$this->add_render_attribute('counter--number', [
	'class' => [
		'cms-counter-numbers',
		'text-nowrap',
		'h3',
		'text-'.$this->get_setting('number_color', 'accent-regular'),
		'd-flex flex-nowrap',
		'flex-smobile-full'
	],
	'style' => 'min-width:136px;'
]);
// Title
$this->add_inline_editing_attributes('title');
$this->add_render_attribute('title', [
	'class' => [
		'cms-counter-title cms-nl2br',
		'h6',
		'text-'.$this->get_setting('title_color', 'heading-regular'),
		'm-tb-n5'
	]
]);
// Description
$this->add_inline_editing_attributes('description');
$this->add_render_attribute('description', [
	'class' => [
		'cms-counter-desc cms-nl2br',
		'text-'.$this->get_setting('desc_color', 'body'),
		'pt-15',
		'mt-n5 mb-n7'
	]
]);
// Layout mode setting
// Carousel Settings
$this->add_render_attribute('carousel-settings', [
	'class' => [
		'cms-ecounter',
		'cms-ecounter-' . $settings['layout'],
		'cms-carousel swiper'
	]
]);
// Arrows
$arrows = $this->get_setting('arrows');
$this->add_render_attribute('arrows', [
	'class' => [
		'cms-swiper-buttons d-flex flex-auto',
		genzia_add_hidden_device_controls_render($settings, 'arrows_')
	]
]);
$arrows_classes = [
	'cms-carousel-button',
	'cms-box-58 circle',
	'text-' . $this->get_setting('arrows_color', 'menu'),
	'bg-' . $this->get_setting('arrows_bg_color', 'transparent'),
	'text-hover-' . $this->get_setting('arrows_hover_color', 'white'),
	'bg-hover-' . $this->get_setting('arrows_bg_hover_color', 'accent-regular'),
	'bdr-1 bdr-' . $this->get_setting('arrows_color', 'transparent'),
	'bdr-hover-' . $this->get_setting('arrows_bg_hover_color', 'accent-regular')
];
$arrows_classes_prev = genzia_nice_class(array_merge(['cms-carousel-button-prev prev mr-n12', 'cms-hover-move-icon-left'], $arrows_classes));
$arrows_classes_next = genzia_nice_class(array_merge(['cms-carousel-button-next next', 'cms-hover-move-icon-right'], $arrows_classes));
// Dots
$dots = $this->get_setting('dots');
$this->add_render_attribute('dots', [
	'class' => [
		'flex-basic gap-12',
		'cms-carousel-dots cms-carousel-dots-circle',
		($arrows == 'yes') ? 'justify-content-end' : 'justify-content-center',
		genzia_add_hidden_device_controls_render($settings, 'dots_'),
	],
	'style' => [
		'--cms-dots-color:var(--cms-menu);',
		'--cms-dots-hover-color:var(--cms-accent-regular);',
		'--cms-dots-hover-shadow:var(--cms-accent-regular);',
		'--cms-dots-hover-opacity:0.2;'
	]
]);
// Grid Settings
$this->add_render_attribute('grid-settings', [
	'class' => [
		'cms-ecounter',
		'cms-ecounter-' . $settings['layout'],
		'cms-counter-grid',
		'd-flex',
		genzia_elementor_get_grid_columns($widget, $settings, [
			'default'    => $default_col,
			'tablet'     => $tablet_col,
			'mobile'     => $mobile_col,
			'gap'        => 0,
			'gap_prefix' => 'gutter-'
		])
	]
]);
?>

<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php
	// Start Counter 
	switch ($settings['layout_mode']) {
		case 'carousel':
			?>
			<div <?php ctc_print_html($this->get_render_attribute_string('carousel-settings')); ?>>
				<div class="swiper-wrapper">
					<?php
					break;
		default:
			?>
					<div <?php ctc_print_html($this->get_render_attribute_string('grid-settings')); ?>>
						<?php
						break;
	}
	// Start Item
	$count = 0;
	foreach ($counters as $key => $counter) {
		$count++;
		$data_counter = $this->get_repeater_setting_key('counter-number', 'cms_counter', $key);
		$this->add_render_attribute($data_counter, [
			'class' => [
				'cms-counter-number elementor-counter-number'
			],
			'data-duration' => $counter['duration'],
			'data-to-value' => $counter['ending_number'],
			'data-delimiter' => !empty($counter['thousand_separator_char']) ? $counter['thousand_separator_char'] : ',',
		]);
		// Items
		$counter_item_key = $this->get_repeater_setting_key('counter-item', 'cms_counter', $key);
		$this->add_render_attribute($counter_item_key, [
			'class' => [
				'counter-item',
				($settings['layout_mode'] === 'carousel') ? 'swiper-slide' : '',
				'hover-icon-bounce'
			]
		]);
		// Item Inner
		$counter_item_inner_key = $this->get_repeater_setting_key('counter-item-inner', 'cms_counter', $key);
		$this->add_render_attribute($counter_item_inner_key, [
			'class' => [
				'counter--item',
				'd-flex flex-nowrap flex-smobile-wrap align-items-center gap-32',
				'p-tb-20',
				'bdr-b-1 bdr-'.$this->get_setting('border_color','divider'),
				($count == 1) ? 'bdr-t-1' : '',
				'cms-bdr'
			]
		]);
		if ($settings['layout_mode'] == 'grid') {
			// Item Inner
			$this->add_render_attribute($counter_item_inner_key, [
				'class' => [
					'elementor-invisible',
				],
				'data-settings' => wp_json_encode([
					'animation'       => 'fadeInUp',
					'animation_delay' => $count * 100
				])
			]);
		}
		?>
	<div <?php ctc_print_html($this->get_render_attribute_string($counter_item_key)); ?>>
		<div <?php ctc_print_html($this->get_render_attribute_string($counter_item_inner_key)); ?>>
			<div <?php ctc_print_html($this->get_render_attribute_string('counter--number')) ?>>
				<span class="prefix"><?php echo esc_html($counter['prefix']); ?></span>
				<span <?php ctc_print_html($this->get_render_attribute_string($data_counter)); ?>><?php echo esc_html($counter['starting_number']); ?></span>
				<span class="suffix"><?php echo esc_html($counter['suffix']); ?></span>
			</div>
			<div class="flex-basic">
				<?php
				// Counter Icon
				genzia_elementor_icon_image_render($widget, $settings, [
					'name'        => 'counter_icon',
					'size'        => 64,
					'color'       => $widget->get_setting('icon_color', 'accent-regular'),
					'color_hover' => $widget->get_setting('icon_color_hover', 'accent-regular'),
					'class'       => 'cms-counter-icon mb-30',
					'tag'         => 'div'
				], $counter);
				?>
				<?php
				// Title
				if ($counter['title']): ?>
					<div <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php
					   echo nl2br($counter['title']);
					   ?></div>
				<?php endif;
				// Description
				if ($counter['description']): ?>
					<div <?php ctc_print_html($this->get_render_attribute_string('description')); ?>>
						<?php echo nl2br($counter['description']); ?></div>
				<?php endif;
				// Link
				if ($counter['link_text']):
					// Link
					$link_key = $this->get_repeater_setting_key('link', 'cms_counter', $key);
					$this->add_render_attribute( $link_key , [
						'class' => [
							'cms-link',
							'text-btn',
							'text-'.$this->get_setting('link_color', 'menu'),
							'text-hover-'.$this->get_setting('link_color_hover','accent-regular'),
							'mt-23',
							'cms-hover-move-icon-right',
							'elementor-invisible'
						],
						'data-settings' => wp_json_encode([
							'animation'       => 'fadeInUp',
							'animation_delay' => 200
						])
					]);
					$this->add_link_attributes( $link_key , $counter['link_url'] );
					?>
					<a <?php ctc_print_html($this->get_render_attribute_string($link_key)); ?>><?php 
						echo esc_html($counter['link_text']);
						// icon
						genzia_svgs_icon([
							'icon'       => 'arrow-right',
							'icon_size'  => 9,
							'icon_class' => 'cms-icon'
						]);
					?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
	} // end foreach
	
	switch ($settings['layout_mode']) {
		case 'carousel':
			?>
					</div>
				</div>
				<div class="cms-swiper-buttons-dots d-flex gap-20 align-items-center justify-content-between empty-none pt"
					style="--pt:23px;"><?php
					// Arrows
					if ($arrows == 'yes') { ?>
						<div <?php ctc_print_html($this->get_render_attribute_string('arrows')); ?>><?php
						  genzia_svgs_icon([
								'icon'      => 'arrow-left',
								'icon_size' => 11,
								'class'     => $arrows_classes_prev,
								'tag'       => 'div'
						  ]);
						  genzia_svgs_icon([
								'icon'      => 'arrow-right',
								'icon_size' => 11,
								'class'     => $arrows_classes_next,
								'tag'       => 'div'
						  ]);
						  ?></div>
					<?php }
					// Dots
					if ($dots == 'yes') { ?>
						<div <?php ctc_print_html($this->get_render_attribute_string('dots')); ?>></div>
					<?php }
					?>
				</div>
				<?php
				break;
		default:
			?>
			</div>
			<?php
			break;
	}
	// End Counter
	?>
</div>
<div class="d-flex gap-24 pt-32 empty-none"><?php 
	// Button #1
	genzia_elementor_link_render($this, $settings, [
		'name'      => 'btn1_',
		'mode'      => 'btn',
		'text_icon' => genzia_svgs_icon([
			'icon'      => 'arrow-right',
			'icon_size' => 10,
			'echo'      => false
		]),
		'class' => [
			'cms-hover-move-icon-right',
			'elementor-invisible'
		],
		'btn_color'        => 'accent-regular',
		'text_color'       => 'white',
		'btn_color_hover'  => 'menu',
		'text_color_hover' => 'white',
		'before'           => '',
		'after'            => '',
		'attrs'			   => [
			'data-settings' => wp_json_encode([
				'animation' => 'fadeInLeft'
			])
		]
	]);
	// Button #2
	genzia_elementor_link_render($this, $settings, [
		'name'      => 'btn2_',
		'mode'      => 'btn',
		'text_icon' => '',
		'class'     => [
			'cms-hover-move-icon-right',
			'elementor-invisible'
		],
		'btn_prefix'	   => 'btn-outline-',
		'btn_hover_prefix' => 'btn-hover-',
		'btn_color'        => 'menu',
		'text_color'       => 'menu',
		'btn_color_hover'  => 'menu',
		'text_color_hover' => 'white',
		'before'           => '',
		'after'            => '',
		'attrs'			   => [
			'data-settings' => wp_json_encode([
				'animation' => 'fadeInRight'
			])
		]
	]);
?></div>