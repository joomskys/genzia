<?php
$default_bg = 'white';
// Wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-eprocess',
		'cms-eprocess-'.$settings['layout'],
		'relative'
	]
]);
// Process Lists
$process = $this->get_setting('process_list', []);
$count_process = count($process);
// Feature
$this->add_render_attribute('features-wrap', [
	'class' => [
		'cms-features',
		'pt-23',
		'text-md'
	]
]);
?>	
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php 
	$count = 0;
	$count_sticky = -1;
	$process_item_class = [
		'cms-process',
		'cms-sticky cms-mobile-relative',
		'bg-'.$default_bg,
		'p-48 p-lr-smobile-20',
		'cms-shadow-1 cms-hover-shadow-2'
	];
	foreach($process as $key => $_process){ 
		$count ++;
		$count_sticky ++;
		//
		$features = json_decode($_process['features'], true);
		// Items
		$item_key = $this->get_repeater_setting_key('item_key', 'cms_process', $key);
		$this->add_render_attribute($item_key, [
			'class' => array_merge(
				$process_item_class,
				[
					'elementor-invisible',
					'relative',
					($count>1) ? 'mt-40' : ''
				]
			),
			'data-settings' => wp_json_encode([
				'animation'       => 'fadeInUp',
				'animation_delay' => $count*100
			]),
			'style' => [
				'z-index:'.$count.';',
				'--cms-sticky:'.($count_sticky*93).'px;',
				'--cms-sticky-tablet:'.($count_sticky*70).'px;'
			]
		]);
		// Items Inner
		$item_inner_key = $this->get_repeater_setting_key('item_inner_key', 'cms_process', $key);
		$this->add_render_attribute($item_inner_key, [
			'class' => [
				'cms--process',
				'pt-32'
			]
		]);
		// Item Title
		$title_key = $this->get_repeater_setting_key('title_key', 'cms_process', $key);
		$this->add_render_attribute($title_key, [
			'class' => [
				'cms-title h6',
				'm-tb-n10 pb-33',
				'elementor-invisible'
			],
			'data-settings' => wp_json_encode([
				'animation' => 'fadeInUp'
			])
		]);
		// Item Content Title
		$c_title_key = $this->get_repeater_setting_key('c_title_key', 'cms_process', $key);
		$this->add_render_attribute($c_title_key, [
			'class' => [
				'cms-title heading',
				'text-xl',
				'm-tb-n10 pb-33',
				'elementor-invisible'
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
				'text-md',
				'mt-n5',
				'elementor-invisible'
			],
			'data-settings' => wp_json_encode([
				'animation' => 'fadeInUp'
			])
		]);
	?>
		<div <?php ctc_print_html($this->get_render_attribute_string($item_key)); ?>>
			<div class="d-flex gap-24 flex-nowrap bdr-b-1 bdr-divider justify-content-between cms-border">
				<div <?php ctc_print_html($this->get_render_attribute_string($title_key)); ?>><?php 
					// Icon
					genzia_elementor_icon_image_render($this, $settings, [
						'size'        => 56,
						'class'       => 'cms-eicon relative z-top',
						'color'		  => 'accent-regular',		
						'color_hover' => 'accent-regular',
						'icon_tag'	  => 'span'
					], $_process);
					// Title
					ctc_print_html($_process['title']); 
				?></div>
				<?php echo genzia_leading_zero($count, [
					'before' => '<div class="align-items-end lh-07 h2 text-on-dark mb-n7">', 
					'after'  => '</div>'
				]); ?>
			</div>
			<div <?php ctc_print_html($this->get_render_attribute_string($item_inner_key)); ?>>
				<?php
					genzia_elementor_image_render($_process,[
						'name'        => 'banner',
						'size'        => 'custom',
						'custom_size' => ['width' => 496, 'height' => 396],
						'max_height'  => true,
						'img_class'   => 'mb-40'	
					]);
				?>
				<div <?php ctc_print_html($this->get_render_attribute_string($c_title_key)); ?>><?php 
					ctc_print_html($_process['c_title']); 
				?></div>
				<div <?php ctc_print_html($this->get_render_attribute_string($desc_key)); ?>><?php 
					ctc_print_html($_process['desc']); 
				?></div>
				<?php if(!empty($features)){ ?>
				<div <?php ctc_print_html($this->get_render_attribute_string('features-wrap')); ?>>
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
									($count_feature>1) ? 'bdr-t-1 bdr-divider cms-border pt-15 mt-15' : ''
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
				<div class="d-flex gap-24 empty-none"><?php 
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
							'text-sm font-500',
							'mt-33',
							'cms-hover-change',
							'elementor-invisible'
						],
						'btn_color'    	   => 'menu',
						'text_color'       => 'white',
						'btn_color_hover'  => 'accent-regular',
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
					genzia_elementor_link_render($this, $_process, [
						'name' 		=> 'link2_',
						'loop' 		=> true,
						'loop_key'  => $key,
						'mode'		=> 'btn',
						'text_icon'	=> '',
						'class' => [
							'cms-btn2',
							'cms-hover-move-icon-right',
							'text-sm font-500',
							'mt-33',
							'cms-hover-change',
							'elementor-invisible'
						],
						'btn_prefix'	   => 'btn-outline-',	
						'btn_color'    	   => 'menu',
						'text_color'       => 'menu',
						'btn_color_hover'  => 'accent-regular',
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
			</div>
		</div>
	<?php } ?>
</div>