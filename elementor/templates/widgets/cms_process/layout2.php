<?php
// Wrap
$this->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-eprocess',
		'cms-eprocess-' . $settings['layout'],
		'col-7 col-tablet-9 col-mobile-12',
		'align-self-end'
	])
]);
// Count
$this->add_render_attribute('count', [
	'class' => [
		'cms-eprocess-count',
		'text-lg text-nowrap',
		'min-w'
	],
	'style' => '--min-w:72px;--min-w-smobile:auto;'
]);
// Process Lists
$process = $this->get_setting('process_list', []);
// Feature
$this->add_render_attribute('features-item', [
	'class' => [
		'cms-list'
	]
]);
// Element Heading
$this->add_render_attribute('eheading',[
	'class' => [
		'cms-eprocess-heading',
		'text-lg',
		'text-'.$this->get_setting('heading_color','sub-text'),
		'mt-nlg',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
?>
<div class="cms-eprocess-wrap d-flex justify-content-between">
	<div class="col-5 col-tablet-7 col-mobile-12 pr-20 pr-tablet-0">
		<div <?php ctc_print_html($this->get_render_attribute_string('eheading')); ?>><?php 
			echo nl2br($settings['heading_text']);
		?></div>
		<?php 
			// Button
			genzia_elementor_link_render($this, $settings, [
				'mode'			   		 => 'btn',
				'class'            => 'cms-heading-btn mt-40 cms-hover-change cms-hover-move-icon-right elementor-invisible',
				'btn_color'        => 'accent-regular',
				'text_color'       => 'white',
				'btn_color_hover'  => 'menu',
				'text_color_hover' => 'white',
				// Icons
				'text_icon' => genzia_svgs_icon([
					'icon'       => 'arrow-right',
					'icon_size'  => 10,
					'icon_class' =>  genzia_nice_class([
						'cms-eicon cms-heading-btn-icon',
						'cms-box-48 cms-radius-6',
						'bg-'.$this->get_setting('link__icon_bg','white'),
						'text-'.$this->get_setting('link__icon_color','accent-regular'),
						'bg-hover-'.$this->get_setting('link__icon_bg_hover','white'),
						'bg-on-hover-'.$this->get_setting('link__icon_bg_hover','white'),
						'text-hover-'.$this->get_setting('link__icon_color_hover','accent-regular'),
						'text-on-hover-'.$this->get_setting('link__icon_color_hover','accent-regular')
					]),
					'echo' => false
				]),
				'before' => '',
				'attrs'  => [
					'data-settings' => wp_json_encode([
						'animation' => 'fadeInUp'
					])
				]
			]);
		?>
	</div>
	<div class="col-12 pb" style="--pb:136px;--pb-tablet:68px;--pb-mobile:40px;"></div>
	<div class="col-5 col-tablet-3 col-mobile-12"></div>
	<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>><?php
	  $count = 0;
	  $zindex = '';
	  $animation_delay = 1;
	  foreach ($process as $key => $_process) {
		  $count++;
		  $animation_delay++;
		  $features = json_decode($_process['features'], true);
		  $bg_color = !empty($_process['bg_color']) ? $_process['bg_color'] : $this->get_setting('bg_color','transparent');
		  $icon_color = !empty($_process['icon_start_color']) ? $_process['icon_start_color'] : $this->get_setting('icon_start_color', 'accent-regular');
		  // Items
	  	$item_key = $this->get_repeater_setting_key('item_key', 'cms_process', $key);
		  $this->add_render_attribute($item_key, [
		  	'class' => array_filter([
		  		'cms-process',
		  		'elementor-invisible',
		  		($count==1) ? 'bdr-t-1' : '',
		  		'bdr-b-1',
		  		'bdr-'.$this->get_setting('bdr_color','divider'),
		  		'cms-border',
		  		'cms-hover-change',
		  		'p-tb-20',
		  		'bg-'.$bg_color
		  	]),
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
		  	]
		  ]);
		  // Item Title
		  $title_color = !empty($_process['ptitle_color']) ? $_process['ptitle_color'] : $this->get_setting('ptitle_color','heading-regular');
		  $title_color_hover = !empty($_process['ptitle_color_hover']) ? $_process['ptitle_color_hover'] : $this->get_setting('ptitle_color_hover','accent-regular');
		  $title_key_wrap = $this->get_repeater_setting_key('title_key_wrap', 'cms_process', $key);
		  $this->add_render_attribute($title_key_wrap, [
		  	'class' => [
		  		'cms-pc-title-wrap',
		  		'empty-none',
		  		'text-'.$title_color,
		  		'text-hover-'.$title_color_hover,
		  		'flex-basic d-flex flex-nowrap gap-32 gap-smobile-20',
		  		'align-items-center',
		  		'cms-hover-change'
		  	]
		  ]);
		  //
	  	$title_key = $this->get_repeater_setting_key('title_key', 'cms_process', $key);
		  $this->add_render_attribute($title_key, [
		  	'class' => [
		  		'cms-pc-title',
		  		'empty-none',
		  		'm-tb-nh4',
		  		'text-'.$title_color,
		  		'text-hover-'.$title_color_hover,
		  		'text-on-hover-'.$title_color_hover
		  	]
		  ]);
		  // Item Content Title
	  	$content_title_key = $this->get_repeater_setting_key('content_title_key', 'cms_process', $key);
	  	$content_title_color = !empty($_process['ptitle_content_color']) ? $_process['ptitle_content_color'] : $this->get_setting('ptitle_content_color', 'heading-regular');
		  $this->add_render_attribute($content_title_key, [
		  	'class' => [
		  		'cms-content-title empty-none',
		  		'text-'.$content_title_color,
		  		'm-tb-nh5 pb-20'
		  	]
		  ]);
		  // Item Desc
	  	$desc_key = $this->get_repeater_setting_key('desc_key', 'cms_process', $key);
	  	$pdesc_color = !empty($_process['pdesc_color']) ? $_process['pdesc_color'] : $this->get_setting('pdesc_color','body');
		  $this->add_render_attribute($desc_key, [
		  	'class' => [
		  		'cms-pdesc empty-none',
		  		'text-' . $pdesc_color,
		  		'text-lg',
		  		'm-tb-n5'
		  	]
		  ]);
		  // Feature
		  $feature_key = $this->get_repeater_setting_key('feature_key','cms_process', $key);
		  $feature_color = !empty($_process['feature_color']) ? $_process['feature_color'] : $this->get_setting('feature_color', 'body');
		  $this->add_render_attribute($feature_key, [
				'class' => [
					'cms-features',
					'pt-23',
					'text-' . $feature_color
				]
			]);
		  ?>
			<div <?php ctc_print_html($this->get_render_attribute_string($item_key)); ?>>
				<div class="d-flex flex-nowrap gap-20 align-items-center justify-content-between">
					<div <?php ctc_print_html($this->get_render_attribute_string($title_key_wrap)); ?>>
						<div <?php ctc_print_html($this->get_render_attribute_string('count')); ?>><?php
						  // Count
					  	genzia_leading_zero($count, '', '');
						  ?></div>
						  <h4 <?php ctc_print_html($this->get_render_attribute_string($title_key)); ?>><?php
						  ctc_print_html($_process['title']);
						  ?></h4>
					</div>
					<?php 
						genzia_elementor_image_render($_process, [
							'name'        => 'banner',
							'size'        => 'custom',
							'custom_size' => ['width' => 115, 'height' => 80],
							'img_class'   => 'cms-radius-10',
							'max_height'  => true,
							'min_height'  => false,
							'before'      => '<div class="cms-hover-show move-right cms-transition flex-auto">',
							'after'       => '</div>'
						]);
					?>
				</div>
				<div <?php ctc_print_html($this->get_render_attribute_string($item_inner_key)); ?>>
						<?php
						genzia_elementor_icon_image_render($this, $settings, [
							'size'        => 64,
							'class'       => 'cms-picon cms-eicon mb-33',
							'color'       => $icon_color,
							'color_hover' => $icon_color,
							'icon_tag'    => 'div'
						], $_process);
						?>
						<h5 <?php ctc_print_html($this->get_render_attribute_string($content_title_key)); ?>><?php
						  ctc_print_html($_process['c_title']);
						?></h5>
						<div <?php ctc_print_html($this->get_render_attribute_string($desc_key)); ?>><?php
						  ctc_print_html($_process['desc']);
						?></div>
						<?php if (!empty($features)) { ?>
							<div <?php ctc_print_html($this->get_render_attribute_string($feature_key)); ?>>
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
							'name'     => 'link1_',
							'loop'     => true,
							'loop_key' => $key,
							'mode'     => 'btn',
							'text_icon' => genzia_svgs_icon([
								'icon'       => 'arrow-right',
								'icon_size'  => 10,
								'icon_class' =>  genzia_nice_class([
									'cms-eicon cms-btn-icon',
									'cms-box-48 cms-radius-6',
									'order-first',
									'bg-'.$this->get_setting('link__icon_bg','white'),
									'text-'.$this->get_setting('link__icon_color','accent-regular'),
									'bg-hover-'.$this->get_setting('link__icon_bg_hover','white'),
									'bg-on-hover-'.$this->get_setting('link__icon_bg_hover','white'),
									'text-hover-'.$this->get_setting('link__icon_color_hover','accent-regular'),
									'text-on-hover-'.$this->get_setting('link__icon_color_hover','accent-regular')
								]),
								'echo'       => false
							]),
							'class' => [
								'cms-hover-move-icon-right',
								'mt-23'
							],
							'btn_color'			   => $this->get_setting('link_btn1_color', 'menu'),
							'text_color'       => $this->get_setting('link_btn1_text_color', 'white'),
							'btn_color_hover'  => $this->get_setting('link_btn1_color_hover', 'accent-regular'),
							'text_color_hover' => $this->get_setting('link_btn1_text_color_hover', 'white')
						]);
						// Button 2
						genzia_elementor_link_render($this, $_process, [
							'name'     => 'link2_',
							'loop'     => true,
							'loop_key' => $key,
							'mode'     => 'btn',
							'text_icon' => genzia_svgs_icon([
								'icon'       => 'arrow-right',
								'icon_size'  => 10,
								'icon_class' =>  genzia_nice_class([
									'cms-eicon cms-btn-icon',
									'cms-box-48 cms-radius-6',
									'order-first',
									'bg-'.$this->get_setting('link__icon_bg','white'),
									'text-'.$this->get_setting('link__icon_color','accent-regular'),
									'bg-hover-'.$this->get_setting('link__icon_bg_hover','white'),
									'bg-on-hover-'.$this->get_setting('link__icon_bg_hover','white'),
									'text-hover-'.$this->get_setting('link__icon_color_hover','accent-regular'),
									'text-on-hover-'.$this->get_setting('link__icon_color_hover','accent-regular')
								]),
								'echo'       => false
							]),
							'class' => [
								'cms-hover-move-icon-right',
								'mt-23'
							],
							'btn_color'			   => $this->get_setting('link_btn2_color', 'menu'),
							'text_color'       => $this->get_setting('link_btn2_text_color', 'white'),
							'btn_color_hover'  => $this->get_setting('link_btn2_color_hover', 'accent-regular'),
							'text_color_hover' => $this->get_setting('link_btn2_text_color_hover', 'white')
						]);
						?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>