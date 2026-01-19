<?php
// Wrap
$this->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-eprocess',
		'cms-eprocess-' . $settings['layout'],
		'd-flex',
		genzia_elementor_get_grid_columns($this, $settings, [
			'prefix_class' => 'flex-col-',
			'default' => 2,
			'tablet' => 2,
			'mobile' => 1,
			'gap' => 40,
			//'gap_prefix'   => ''
		])
	])
]);
// Count
$this->add_render_attribute('count', [
	'class' => [
		'm-tb-n5 text-lg',
		'text-' . $this->get_setting('icon_start_color', 'heading-regular'),
		'pb-40'
	]
]);
// Process Lists
$process = $this->get_setting('process_list', []);
// Feature
$this->add_render_attribute('features-wrap', [
	'class' => [
		'cms-features',
		'pt-23',
		'text-' . $this->get_setting('feature_color', 'body')
	]
]);
$this->add_render_attribute('features-item', [
	'class' => [
		'cms-list'
	]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>><?php
  $count = 0;
  $zindex = '';
  $animation_delay = 1;
  foreach ($process as $key => $_process) {
	  $count++;
	  $animation_delay++;
	  $features = json_decode($_process['features'], true);
	  // Items
  	$item_key = $this->get_repeater_setting_key('item_key', 'cms_process', $key);
	  $this->add_render_attribute($item_key, [
	  	'class' => [
	  		'cms-process',
	  		'elementor-invisible',
	  	],
	  	'data-settings' => wp_json_encode([
	  		'animation' => 'fadeInUp',
	  		'animation_delay' => $animation_delay * 100
	  	])
	  ]);
	  // Items Inner
  	$item_inner_key = $this->get_repeater_setting_key('item_inner_key', 'cms_process', $key);
	  $this->add_render_attribute($item_inner_key, [
	  	'class' => [
	  		'cms--process',
	  		'hover-icon-bounce',
	  		'd-flex flex-nowrap col-gap',
	  	],
	  	'style' => [
	  		'--cms-col-gap:96px;--cms-col-gap-mobile-extra:32px;'
	  	]
	  ]);
	  // Item Small Title
  	$small_key = $this->get_repeater_setting_key('small_key', 'cms_process', $key);
	  $this->add_render_attribute($small_key, [
	  	'class' => [
	  		'cms-small empty-none',
	  		'text-md',
	  		'text-' . $this->get_setting('psmalltitle_color', 'primary-regular'),
	  		'm-tb-n5 pb-20'
	  	]
	  ]);
	  // Item Title
  	$title_key = $this->get_repeater_setting_key('title_key', 'cms_process', $key);
	  $this->add_render_attribute($title_key, [
	  	'class' => [
	  		'cms-pc-title',
	  		'cms-heading empty-none',
	  		'text-' . $this->get_setting('ptitle_color', 'heading-regular'),
	  		'mt-n5'
	  	]
	  ]);
	  // Item Desc
  	$desc_key = $this->get_repeater_setting_key('desc_key', 'cms_process', $key);
	  $this->add_render_attribute($desc_key, [
	  	'class' => [
	  		'cms-pdesc empty-none',
	  		'text-' . $this->get_setting('pdesc_color', 'body'),
	  		'text-lg',
	  		'pt',
	  		'm-tb-n5'
	  	],
	  	'style' => '--pt:75px;--pt-mobile:30px;'
	  ]);
	  ?>
		<div <?php ctc_print_html($this->get_render_attribute_string($item_key)); ?>>
			<div <?php ctc_print_html($this->get_render_attribute_string($item_inner_key)); ?>>
				<div class="flex-auto d-flex flex-column justify-content-between">
					<div <?php ctc_print_html($this->get_render_attribute_string('count')); ?>><?php
					  // Count
				  	genzia_leading_zero($count, '', '');
					  ?></div>
					<?php
					genzia_elementor_icon_image_render($this, $settings, [
						'size'        => 64,
						'class'       => 'cms-picon cms-eicon',
						'color'       => $this->get_setting('icon_start_color', 'accent'),
						'color_hover' => $this->get_setting('icon_end_color', 'accent'),
						'icon_tag'    => 'div'
					], $_process);
					genzia_elementor_image_render($_process, [
						'name' => 'banner',
						'size' => 'custom',
						'custom_size' => ['width' => 64, 'height' => 64],
						'img_class' => '',
						'max_height' => true,
						'min_height' => false,
						'before' => '',
						'after' => ''
					]);
					?>
				</div>
				<div class="flex-basic">
					<h5 <?php ctc_print_html($this->get_render_attribute_string($title_key)); ?>><?php
					  ctc_print_html($_process['title']);
					  ?></h5>
					<div <?php ctc_print_html($this->get_render_attribute_string($desc_key)); ?>><?php
					  ctc_print_html($_process['desc']);
					  ?></div>
					<?php if (!empty($features)) { ?>
						<div <?php ctc_print_html($this->get_render_attribute_string('features-wrap')); ?>>
							<?php
							$count_feature = 0;
							foreach ($features as $fkey => $cms_feature):
								$count_feature++;
								// Items
								$fitem_key = $this->get_repeater_setting_key('fitem', 'cms_process', $fkey);
								$this->add_render_attribute($fitem_key, [
									'class' => [
										'cms-item',
										'd-flex gap-12 flex-nowrap',
										'pt-7',
										'elementor-invisible'
									],
									'data-settings' => wp_json_encode([
										'animation' => 'fadeInUp',
										'animation_delay' => 100
									])
								]);
								//
								$ftitle_key = $this->get_repeater_setting_key('ftitle', 'cms_process', $fkey);
								$this->add_render_attribute($ftitle_key, [
									'class' => [
										'feature-title',
										'flex-basic'
									]
								]);
								?>
								<div <?php ctc_print_html($this->get_render_attribute_string($fitem_key)); ?>>
									<?php
									genzia_svgs_icon([
										'icon' => 'core/check',
										'icon_size' => 12,
										'icon_class' => 'cms-icon pt-7'
									]);
									?>
									<div <?php ctc_print_html($this->get_render_attribute_string($ftitle_key)); ?>>
										<?php echo esc_html($cms_feature['ftitle']) ?></div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php } ?>
					<?php
					genzia_elementor_link_render($this, $_process, [
						'name' => 'link1_',
						'loop' => true,
						'loop_key' => $key,
						'mode' => 'link',
						'text_icon' => genzia_svgs_icon([
							'icon' => 'arrow-right',
							'icon_size' => 11,
							'icon_class' => '',
							'echo' => false
						]),
						'class' => [
							'cms-btn1',
							'cms-link',
							'cms-hover-move-icon-right',
							'cms-underline',
							'cms-hover-underline',
							'text-btn font-700',
							'mt-23'
						],
						'text_color' => $this->get_setting('link_btn_text_color', 'menu'),
						'text_color_hover' => $this->get_setting('link_btn_text_color_hover', 'accent-regular')
					]);
					?>
				</div>
			</div>
		</div>
	<?php } ?>
</div>