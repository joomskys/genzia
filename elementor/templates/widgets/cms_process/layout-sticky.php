<?php
// Wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-eprocess',
		'cms-eprocess-'.$settings['layout'],
		'relative',
		'd-flex gutter',
		'justify-content-between'
	]
]);
// Process Lists
$process = $this->get_setting('process_list', []);
$count_process = count($process);
// Small Heading
$this->add_inline_editing_attributes( 'smallheading_text' );
$this->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-small',
		'elementor-invisible',
		'cms-smallheading cms-nl2br',
		'text-sm',
		'text-'.$this->get_setting('smallheading_color','accent-regular'),
		'empty-none',
		'm-tb-nsm',
		'pb-10',
		'd-flex gap-8 flex-nowrap'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp',
		'animation_delay' => 100
	])
]);
$small_icon_classes = genzia_nice_class([
	'cms-small-icon pt-7',
	'text-'.$this->get_setting('smallheading_icon_color', 'accent-regular')
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
		'm-tb-nh2'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
// Description
$this->add_inline_editing_attributes( 'desc' );
$this->add_render_attribute( 'desc', [
	'class' => [
		'cms-desc empty-none',
		'heading text-xl',
		'text-'.$this->get_setting('desc_color','sub-text'),
		'cms-nl2br',
		'elementor-invisible',
		'pt-15',
		'mr-n30 mr-tablet-n0'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);

?>	
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div class="col-4 col-mobile-12 max-h d-flex flex-column justify-content-between cms-sticky cms-mobile-relative" style="--max-h:100vh;--max-h-mobile:auto;">
		<div class="w-100 align-self-start">
			<div <?php ctc_print_html( $this->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php 
				// Icon
				genzia_elementor_icon_render( $settings['smallheading_icon'], [], [ 'aria-hidden' => 'true', 'class' => $small_icon_classes, 'icon_size' => 12 ] );
				// Text
				echo nl2br( $settings['smallheading_text'] ); 
			?></div>
			<h2 <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>>
				<?php echo nl2br( $settings['heading_text'] ); ?>
			</h2>
		</div>
		<div class="w-100 align-self-end">
			<div <?php ctc_print_html( $this->get_render_attribute_string( 'desc' ) ); ?>><?php 
				// Text
				echo nl2br( $settings['desc'] ); 
			?></div>
			<?php 
				// Button
				genzia_elementor_link_render($this, $settings, [
					'mode'			   => 'btn',
					'class'            => 'cms-heading-btn mt-25 cms-hover-change cms-hover-move-icon-right elementor-invisible',
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
							'order-first',
							'bg-'.$this->get_setting('link__icon_bg','white'),
							'text-'.$this->get_setting('link__icon_color','accent-regular'),
							'bg-hover-'.$this->get_setting('link__icon_bg_hover','white'),
							'bg-on-hover-'.$this->get_setting('link__icon_bg_hover','white'),
							'text-hover-'.$this->get_setting('link__icon_color_hover','accent-regular'),
							'text-on-hover-'.$this->get_setting('link__icon_color_hover','accent-regular')
						]),
						'echo' => false
					]),
					'before' => '<div class="clearfix"></div>',
					'attrs'	 => [
						'data-settings' => wp_json_encode([
							'animation' => 'fadeInUp'
						])
					]
				]);
			?>
		</div>
	</div>
	<div class="col-6 col-tablet-8 col-mobile-12">
		<div class="pl" style="--pl:52px;--pl-tablet:0;"><?php 
		$count = 0;
		$count_sticky = -1;
		$process_item_class = [
			'cms-process',
			'cms-sticky cms-mobile-relative',
			'elementor-invisible',
			'cms-transition',
			'h-100vh h-mobile-auto',
			'd-flex align-items-center'
		];
		$process__item_class = [
			'cms--process',
			'p-48 p-lr-smobile-20',
			'cms-radius-16',
			'cms-shadow-1',
			'w-100'
		];
		foreach($process as $key => $_process){ 
			$count ++;
			$count_sticky ++;
			$picon_color   = !empty($_process['icon_start_color'])?$_process['icon_start_color'] : $this->get_setting('icon_start_color','menu');
			$heading_color = !empty($_process['ptitle_color']) ? $_process['ptitle_color']: $this->get_setting('ptitle_color','white');
			$pdesc_color   = !empty($_process['pdesc_color'])?$_process['pdesc_color']:$this->get_setting('pdesc_color','body');
			$feature_color = !empty($_process['feature_color'])?$_process['feature_color']:$this->get_setting('feature_color','body');
			$bg_color      = !empty($_process['bg_color'])?$_process['bg_color']:$this->get_setting('bg_color','bg-image');
 			//
			$features = json_decode($_process['features'], true);
			// Items
			$item_key = $this->get_repeater_setting_key('item_key', 'cms_process', $key);
			$this->add_render_attribute($item_key, [
				'class' => array_merge(
					$process_item_class,
					[
						($count>1) ? 'mt-80 mt-tablet-40' : ''
					]
				),
				'data-settings' => wp_json_encode([
					'animation'       => 'fadeInUp',
					'animation_delay' => $count*100
				]),
				'style' => [
					'z-index:'.$count.';',
					'--cms-sticky:'.($count_sticky*63).'px;',
					'--cms-sticky-tablet:'.($count_sticky*40).'px;',
					//($count%2==0)?'transform:rotate(-5deg);':'transform:rotate(5deg);'
				]
			]);
			// Items
			$item__key = $this->get_repeater_setting_key('item__key', 'cms_process', $key);
			$this->add_render_attribute($item__key, [
				'class' => array_merge(
					$process__item_class,
					[
						'bg-'.$bg_color
					]
				)
			]);
			// Items Inner
			$item_inner_key = $this->get_repeater_setting_key('item_inner_key', 'cms_process', $key);
			$this->add_render_attribute($item_inner_key, [
				'class' => [
					'cms--process',
					'p-tb-40',
					'd-flex gutter',
					'justify-content-between'
				]
			]);
			// Item Title
			$title_key = $this->get_repeater_setting_key('title_key', 'cms_process', $key);
			$this->add_render_attribute($title_key, [
				'class' => [
					'cms-pc-title h3',
					'text-' . $heading_color,
					'mb-nh3',
					'elementor-invisible',
					'pt'
				],
				'data-settings' => wp_json_encode([
					'animation' => 'fadeInUp'
				]),
				'style' => [
					'--pt:90px;',
					'--pt-tablet:50px;',
					'--pt-mobile:0px;'
				]
			]);
			// Item Content Title
			$c_title_key = $this->get_repeater_setting_key('c_title_key', 'cms_process', $key);
			$this->add_render_attribute($c_title_key, [
				'class' => [
					'cms-pc-title h5',
					'empty-none',
					'text-' . $heading_color,
					'elementor-invisible',
					'pb-15'
				],
				'data-settings' => wp_json_encode([
					'animation' => 'fadeInUp'
				])
			]);
			// Item Desc
			$desc_key = $this->get_repeater_setting_key('desc_key', 'cms_process', $key);
			$this->add_render_attribute($desc_key, [
				'class' => [
					'cms-pdesc empty-none',
					'text-' . $pdesc_color,
					'text-md',
					'mt-n5',
					'elementor-invisible'
				],
				'data-settings' => wp_json_encode([
					'animation' => 'fadeInUp'
				])
			]);
			// Item Feature
			$feature_key = $this->get_repeater_setting_key('feature_key','cms_process',$key);
			$this->add_render_attribute($feature_key, [
				'class' => [
					'cms-features',
					'text-'.$feature_color,
					'pt-23',
					'text-md'
				]
			]);
		?>
			<div <?php ctc_print_html($this->get_render_attribute_string($item_key)); ?>>
			<div <?php ctc_print_html($this->get_render_attribute_string($item__key)); ?>>
				<div class="d-flex gap-24 flex-nowrap justify-content-between relative">
					<?php 
						genzia_elementor_icon_image_render($this, $settings, [
							'size'        => 64,
							'class'       => 'cms-picon cms-eicon relative z-top',
							'color'		  => $picon_color,		
							'color_hover' => $picon_color,
							'icon_tag'	  => 'div'
						], $_process);
						// Count Number
						genzia_leading_zero($count,[
							'before' => '<div class="cms--process-count text-'.$heading_color.' text-2xl heading lh-07">',
							'after'  => '</div>'
						]);
					?>
				</div>
				<div <?php ctc_print_html($this->get_render_attribute_string($item_inner_key)); ?>>
					<div class="flex-auto"><?php
						genzia_elementor_image_render($_process,[
							'name'        => 'banner',
							'size'        => 'custom',
							'img_class'   => 'cms-radius-10',
							'custom_size' => ['width' => 100, 'height' => 100],
							'max_height'  => true	
						]);
					?></div>
					<div class="flex-basic text-end max-w" style="--max-w:300px;">
						<div <?php ctc_print_html($this->get_render_attribute_string($c_title_key)); ?>><?php 
							ctc_print_html($_process['c_title']); 
						?></div>
						<div <?php ctc_print_html($this->get_render_attribute_string($desc_key)); ?>><?php 
							ctc_print_html($_process['desc']); 
						?></div>
						<?php if(!empty($features)){ ?>
						<div <?php ctc_print_html($this->get_render_attribute_string($feature_key)); ?>>
							<?php 
								$count_feature = 0;
								foreach ( $features as $fkey => $cms_feature ):
									$count_feature++;
									// Items
									$fitem_key = $this->get_repeater_setting_key( 'fitem', 'cms_process', $fkey );
									$this->add_render_attribute($fitem_key, [
										'class' => [
											'cms-item',
											'd-flex gap-12 flex-nowrap',
											'elementor-invisible',
											($count_feature>1) ? 'bdr-t-1 cms-border pt-15 mt-15' : '',
											'bdr-'.$this->get_setting('bdr_color','divider')
										],
										'data-settings' => wp_json_encode([
											'animation'       => 'fadeInUp',
											'animation_delay' => 200
										])
									]);
									//
									$ftitle_key = $this->get_repeater_setting_key( 'ftitle', 'cms_process', $fkey );
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
												'icon'       => 'core/check',
												'icon_size'  => 12,
												'icon_class' => 'cms-icon pt-7 text-accent-regular'
								        	]);
								        ?>
									    <div <?php ctc_print_html( $this->get_render_attribute_string( $ftitle_key ) ); ?>><?php echo esc_html( $cms_feature['ftitle'] ) ?></div>
								    </div>
							<?php endforeach; ?>
						</div>
						<?php } ?>
						<div class="d-flex gap-24 empty-none pt-33"><?php 
							// Button #1
							genzia_elementor_link_render($this, $_process, [
								'name' 		=> 'link1_',
								'loop' 		=> true,
								'loop_key'  => $key,
								'mode'		=> 'btn',
								'text_icon'	=> genzia_svgs_icon([
									'icon'       => 'arrow-right',
									'icon_size'	 => 10,
									'icon_class' => '',
									'echo'       => false
								]),
								'class' => [
									'cms-btn1',
									'cms-hover-move-icon-right',
									'cms-hover-change',
									'elementor-invisible'
								],
								'btn_color'    	   => $this->get_setting('link_btn_color','menu'),
								'text_color'       => $this->get_setting('link_btn_text_color','white'),
								'btn_color_hover'  => $this->get_setting('link_btn_color_hover','accent-regular'),
								'text_color_hover' => $this->get_setting('link_btn_text_color_hover','white'),
								'before'           => '',
								'after'            => '',
								'attrs'			   => [
									'data-settings' => wp_json_encode([
										'animation' => 'fadeInLeft'
									])
								]	
							]);
							// Button #2
							genzia_elementor_link_render($this, $_process, [
								'name' 		=> 'link2_',
								'loop' 		=> true,
								'loop_key'  => $key,
								'mode'		=> 'btn',
								'text_icon'	=> '',
								'class' => [
									'cms-btn2',
									'cms-hover-move-icon-right',
									'cms-hover-change',
									'elementor-invisible'
								],
								'btn_prefix'	   => 'btn-outline-',	
								'btn_color'    	   => $this->get_setting('link_btn2_color','menu'),
								'text_color'       => $this->get_setting('link_btn2_text_color','menu'),
								'btn_color_hover'  => $this->get_setting('link_btn2_color_hover','menu'),
								'text_color_hover' => $this->get_setting('link_btn2_text_color_hover','white'),
								'before'           => '',
								'after'            => '',
								'attrs'			   => [
									'data-settings' => wp_json_encode([
										'animation' => 'fadeInRight'
									])
								]	
							]);
						?></div>
					</div>
				</div>
				<div <?php ctc_print_html($this->get_render_attribute_string($title_key)); ?>><?php 
					echo nl2br($_process['title']); 
				?></div>
			</div>
			</div>
		<?php } 
	?></div>
	</div>
</div>