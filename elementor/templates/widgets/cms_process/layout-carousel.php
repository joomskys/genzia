<?php
// Small Heading
$this->add_inline_editing_attributes( 'smallheading_text' );
$this->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-small',
		'elementor-invisible',
		'cms-nl2br',
		'text-lg text-'.$this->get_setting('smallheading_color','accent-regular'),
		'empty-none',
		'm-tb-n5',
		'pb-10'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp',
		'animation_delay' => 100
	])
]);
// Large Heading
$this->add_inline_editing_attributes( 'heading_text', 'none' );
$this->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-title',
		'text-'.$this->get_setting('heading_color','heading-regular'),
		'cms-nl2br',
		'elementor-invisible',
		'cms-heading empty-none',
		'm-tb-n7'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
$default_align = 'start';
// Wrap
$this->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-eprocess',
		'cms-eprocess-'.$settings['layout'],
		'text-'.$this->get_setting('align', $default_align),
		'd-flex flex-nowrap',
		'align-items-start'
	])
]);
// Process
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
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div class="cms-process-left flex-auto pt-112 pt-tablet-40">
		<div class="cms-eheading-wrap pb-64">
			<div <?php ctc_print_html( $this->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
			<h3 <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h3>
		</div>
		<div class="cms-hidden-min-tablet">
			<?php 
					// Process Item
					foreach($process as $key => $_process){ 
						$features = json_decode($_process['features'], true);
				?>
					<div class="cms-process-item hover-icon-bounce">
						<div class="d-flex gutter">
							<div class="col-6 col-mobile-12">
								<div class="cms-sticky"><?php 
										// Icon/ Image
										genzia_elementor_icon_image_render($this, $_process, [
											'size'        => 48,
											'color'       => $this->get_setting('icon_start_color', 'primary'),
											'color_hover' => $this->get_setting('icon_end_color', 'accent'),
											'icon_class'  => 'cms-picon cms-icon',
											//
											'class'	 => '',
											'before' => '<div class="process-icon-img mb-30">',
											'after'	 => '</div>'
										]);
									?>
									<div class="cms-pc-title text-22 lh-12727 font-600 text-primary mt-n7 pb-8"><?php ctc_print_html($_process['title']); ?></div>
									<div class="cms-pdesc text-15"><?php ctc_print_html($_process['desc']); ?></div>
									<?php if (!empty($features)) { ?>
										<div <?php ctc_print_html($this->get_render_attribute_string('features-wrap')); ?>>
											<?php
											$count_feature = 0;
											foreach ($features as $fkey => $cms_feature):
												$count_feature++;
												// Items
												$fitem_attrs = [
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
												];
												//
												$ftitle_key = [
													'class' => [
														'feature-title',
														'flex-basic'
													]
												];
												?>
												<div <?php echo genzia_render_attrs($fitem_attrs); ?>>
													<?php
													genzia_svgs_icon([
														'icon'       => 'core/check',
														'icon_size'  => 12,
														'icon_class' => 'cms-icon pt-7'
													]);
													?>
													<div <?php echo genzia_render_attrs($ftitle_key); ?>>
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
							<?php 
								// Banner
								genzia_elementor_image_render($_process, [
									'name'        => 'banner',
									'size'        => 'custom',
									'custom_size' => ['width' => 400, 'height' => 450],
									'img_class'   => 'process-banner',
									'max_height'  => true,
									'before'      => '<div class="col-6 col-mobile-12 order-mobile-first">',
									'after'       => '</div>'
								]);
							?>
						</div>
					</div>
				<?php } ?>
		</div>
		<div class="cms-swiper-vertical swiper cms-hidden-mobile">
			<div class="cms-swiper-wrapper swiper-wrapper drag-cursor cms-cursor-drag-vert">
				<?php 
					// Process Item
					foreach($process as $key => $_process){ 
						$features = json_decode($_process['features'], true);
				?>
					<div class="cms-process-item cms-swiper-slide swiper-slide hover-icon-bounce d-flex gap" style="--cms-gap:76px;--cms-gap-tablet:30px;">
						<div class="left flex-auto relative" style="width: 28px;">
							<?php 
								genzia_svgs_icon([
									'icon'       => 'core/check',
									'icon_size'  => 10,
									'icon_class' => 'cms-icon',
									'class'      => 'cms-box-30 circle bg-accent-regular text-white'
								]);
							?>
							<div class="process-divider bg-accent-regular" style="width: 2px; height: calc(100% - 44px); margin-top:8px; margin-inline-start: 13px;"></div>
						</div>
						<div class="right flex-basic">
							<?php 
								// Icon/ Image
								genzia_elementor_icon_image_render($this, $_process, [
									'size'        => 48,
									'color'       => $this->get_setting('icon_start_color', 'primary'),
									'color_hover' => $this->get_setting('icon_end_color', 'accent'),
									'icon_class'  => 'cms-picon cms-icon',
									//
									'class'	 => '',
									'before' => '<div class="process-icon-img mb-30">',
									'after'	 => '</div>'
								]);
							?>
							<h6 class="cms-pc-title text-heading-regular mt-n7"><?php ctc_print_html($_process['title']); ?></h6>
							<div class="cms-pdesc text-md pt-10"><?php ctc_print_html($_process['desc']); ?></div>
							<?php if (!empty($features)) { ?>
								<div <?php ctc_print_html($this->get_render_attribute_string('features-wrap')); ?>>
									<?php
									$count_feature = 0;
									foreach ($features as $fkey => $cms_feature):
										$count_feature++;
										// Items
										$fitem_attrs = [
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
										];
										//
										$ftitle_key = [
											'class' => [
												'feature-title',
												'flex-basic'
											]
										];
										?>
										<div <?php echo genzia_render_attrs($fitem_attrs); ?>>
											<?php
											genzia_svgs_icon([
												'icon'       => 'core/check',
												'icon_size'  => 12,
												'icon_class' => 'cms-icon pt-7'
											]);
											?>
											<div <?php echo genzia_render_attrs($ftitle_key); ?>>
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
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="cms-process-right flex-basic pl-120 pl-laptop-40 cms-hidden-mobile cms-sticky">
		<div class="cms-process-banners swiper">
			<div class="cms-process-banner swiper-wrapper">
				<?php 
					// Process Item
					foreach($process as $key => $_process){ 
				?>
					<div class="swiper-slide">
						<?php 
							// Banner
							genzia_elementor_image_render($_process, [
								'name'        => 'banner',
								'size'        => 'custom',
								'custom_size' => ['width' => 800, 'height' => 900],
								'img_class'   => 'process-banner img-cover',
								'max_height'	=> true
							]);
						?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>