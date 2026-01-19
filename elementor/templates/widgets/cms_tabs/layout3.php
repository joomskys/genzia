<?php 
$cms_tabs   = $this->get_setting('contents', []);
$tabs       = $this->get_setting('tabs', []);
$active_tab = $this->get_setting('active_tab',1);
// Wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-tabs',
		'cms-tabs-'.$settings['layout'],
		'd-flex gutter-32'
	]
]);
// Banner 
$banner_custom_size = [
    'width'  => !empty($settings['banner_custom_dimension']['width']) ? $settings['banner_custom_dimension']['width'] : 400,
    'height' => !empty($settings['banner_custom_dimension']['height']) ? $settings['banner_custom_dimension']['height'] : 501
];
// Title 
$this->add_render_attribute('title', [
    'class' => [
        'cms-heading empty-none cms-nl2br',
        'text-'.$this->get_setting('tab_content_title_color','heading-regular'),
        'm-tb-n7',
        'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
    	'animation' => 'fadeInUp'
    ])
]);
// Description
$this->add_render_attribute('desc', [
    'class' =>  [
        'cms-desc empty-none cms-nl2br',
        'text-'.$this->get_setting('tab_content_desc_color', 'body'),
        'text-lg',
        'm-tb-n7 pt-25',
        'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
    	'animation' => 'fadeInUp'
    ])
]);
// Feature
$this->add_render_attribute('features-wrap', [
    'class' => [
        'cms-features empty-none',
        'pt-23',
        'text-md',
        'text-'.$this->get_setting('tab_content_feature_color','sub-text'),
        'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInUp'
    ])
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div class="cms-tabs-title col-4 cms-hidden-mobile-extra">
		<div class="d-flex align-items-between justify-content-between flex-column h-100 mr-32 mr-tablet-extra-0 bdr-t-1 bdr-b-1 bdr-divider-dark pt-20 pb-23">
			<div class="cms-tabs--count text-<?php echo esc_attr($this->get_setting('total_count_color','accent-regular')); ?> text-lg">
				<span class="current-count text-<?php echo esc_attr($this->get_setting('count_color','menu')); ?>"><?php 
					genzia_leading_zero($active_tab);
				?></span>/<span class="total"><?php genzia_leading_zero(count($cms_tabs)); ?></span>
			</div>
			<div class="cms-tabs--title">
				<?php 
				$count = 0;
				foreach ($cms_tabs as $key => $cms_tab) {
					$count ++;
					$is_active = ( $key + 1 ) === $active_tab ? true : false;
					$title = !empty($cms_tab['tab_title']) ? $cms_tab['tab_title'] : 'Tab #'.($key+1);
					// title
					$title_key = $this->get_repeater_setting_key( 'tab_title', 'cms_tabs', $key );
					$this->add_render_attribute( $title_key, [
						'class' => [ 
							'cms-tab-title h5',
							$is_active ? 'active' : '',
							'relative',
							'cms-transition',
							'cms-hover-change',
							'pt-20 mb-20',
							'text-'.$this->get_setting('tab_title_color','menu'),
							'text-hover-'.$this->get_setting('tab_title_active_color','accent-regular'),
							'text-active-'.$this->get_setting('tab_title_active_color','accent-regular'),
						],
						'data-target' => '#cms-'.$cms_tab['_id'],
						'data-active' => $is_active?'active':'',
						'data-current' => genzia_leading_zero($count,['echo' => false])
					]);
				?>
					<div <?php ctc_print_html( $this->get_render_attribute_string( $title_key ) ); ?>><?php 
						// Icon
		                genzia_elementor_icon_render( $cms_tab['icon'], [], [
							'aria-hidden'      => 'true', 
							'class'            => 'cms-icon absolute bottom right cms-hover-show cms-transition', 
							'icon_size'        => 96, 
							'icon_color'       => $this->get_setting('icon_color','divider-dark'), 
							'icon_color_hover' =>  $this->get_setting('icon_color','divider-dark'),
							'attrs'			   => [
								//'aria-label' => $cms_tab['icon_title']
							]
						], 
		                'div');
						// text
						echo '<span class="relative">'.nl2br($title).'</span>';
					?></div>
					
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="cms-tabs-contents col-8 col-mobile-extra-12 relative"><?php 
		// Tabs Content
		$c_count = 0;
		foreach ($cms_tabs as $c_key => $cms_tab) {
			$features = json_decode($cms_tab['features'], true);
			//
			$c_count++;
			$c_is_active = ( $c_key + 1 ) === $active_tab ? true : false;
			$c_title = !empty($cms_tab['tab_title']) ? $cms_tab['tab_title'] : 'Tab #'.($c_key+1);
			$content_key = $this->get_repeater_setting_key( 'tab_content', 'cms_tabs', $c_key );
			$this->add_render_attribute( $content_key, [
				'id'	=> 'cms-'.$cms_tab['_id'],
				'class' => array_filter([
					'cms-tabs-content',
					$c_is_active ? 'active' : '',
					'cms-show-max-mobile-extra'
				]),
				'style' => $c_is_active ? 'display:block;' : 'display:none;'
			] );
			// Mobile Title
			$mobile_title_key = $this->get_repeater_setting_key( 'mobile_tab_title', 'cms_tabs', $c_key );
			$this->add_render_attribute( $mobile_title_key, [
				'class' => [ 
					'cms-mobile-tab-title h5',
					'relative',
					'cms-transition',
					'cms-hover-change',
					'text-'.$this->get_setting('mobile_tab_title_color','menu'),
					'text-hover-'.$this->get_setting('mobile_tab_title_active_color','accent-regular'),
					'text-active-'.$this->get_setting('mobile_tab_title_active_color','accent-regular'),
					'cms-hidden-min-mobile-extra',
					($c_key > 0) ? 'pt-40' : '',
					'pb-40'
				]
			]);
		?>
		<div <?php ctc_print_html( $this->get_render_attribute_string( $mobile_title_key ) ); ?>><?php 
			// Icon
            genzia_elementor_icon_render( $cms_tab['icon'], [], [
				'aria-hidden'      => 'true', 
				'class'            => 'cms-icon absolute bottom right cms-hover-show cms-transition z-top2', 
				'icon_size'        => 96, 
				'icon_color'       => $this->get_setting('icon_color','divider-dark'), 
				'icon_color_hover' => $this->get_setting('icon_color','divider-dark')
			], 
            'div');
			// text
			echo '<span class="relative">'.nl2br($c_title).'</span>';
		?></div>
		<?php // Tab Content ?>
		<div <?php ctc_print_html( $this->get_render_attribute_string( $content_key ) ); ?>>
			<div class="d-flex">
				<?php
	                genzia_elementor_image_render($cms_tab,[
	                    'name'           => 'banner',
	                    'image_size_key' => 'banner',
	                    'img_class'      => 'cms-tab-banner cms-radius-16 elementor-invisible img-cover',
	                    'size'           => $this->get_setting('banner_size','custom'),
	                    'custom_size'    => $banner_custom_size,
	                    'attrs'          => [
	                        'data-settings' => wp_json_encode([
	                            'animation' => 'fadeInRight'
	                        ])
	                    ],
	                    'min_height' => true,
	                    'max_height' => true,
	                    'before'     => '<div class="flex-auto max-w" style="--max-w:50%;--max-w-smobile:100%;">',
	                    'after'      => '</div>'
	                ]);
	            ?>
	            <div class="flex-basic bg-white cms-radius-16 p-48 p-lr-smobile-20 cms-shadow-2 d-flex flex-column align-items-between justify-content-between relative z-top2">
					<h5 <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php echo esc_html($cms_tab['title']); ?></h5>
					<div class="">
						<div <?php ctc_print_html($this->get_render_attribute_string('desc')); ?>><?php echo nl2br($cms_tab['desc']); ?></div>
						<div <?php ctc_print_html($this->get_render_attribute_string('features-wrap')); ?>><?php
			                if(!empty($features)){ 
			                    $count_feature = 0;
			                    foreach ( $features as $fkey => $cms_feature ):
			                        $count_feature++;
			                        // Items
			                        $fitem_key = $this->get_repeater_setting_key( 'fitem', 'cms_tabs', $fkey );
			                        $this->add_render_attribute($fitem_key, [
			                            'class' => [
			                                'cms-item',
			                                'hover-icon-bounce',
			                                'p-tb-5',
			                                ($count_feature == count($features)) ? 'pb-0 mb-n7' : '',
			                                'd-flex gap-12 flex-nowrap',
			                                'elementor-invisible'
			                            ],
			                            'data-settings' => wp_json_encode([
			                                'animation'       => 'fadeInUp',
			                                'animation_delay' => 100
			                            ])
			                        ]);
			                        //
			                        $ftitle_key = $this->get_repeater_setting_key( 'ftitle', 'cms_tabs', $fkey );
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
			                                    'icon_size'  => 10,
			                                    'icon_class' => 'cms-icon pt-10 text-accent-regular'
			                                ]);
			                            ?>
			                            <div <?php ctc_print_html( $this->get_render_attribute_string( $ftitle_key ) ); ?>><?php echo esc_html( $cms_feature['ftitle'] ) ?></div>
			                        </div>
			                    <?php endforeach;
			                } 
			            ?></div>
			            <?php 
			                // Button
			                genzia_elementor_link_render($widget, $cms_tab, [
			                    'name'      => 'link1_',
			                    'loop'      => true,
			                    'loop_key'  => $c_key,
			                    'mode'      => 'btn',
			                    'text_icon' => genzia_svgs_icon([
			                    'icon'       => 'arrow-right',
				                    'icon_size'  => 13, 
				                    'icon_class' => [],
				                    'echo'       => false,
				                    'class'      => ''
				                ]),
			                    'class'            => ['btn-smd','cms-hover-move-icon-right','elementor-invisible','mt-33'],
			                    'btn_color'        => 'menu',
			                    'text_color'       => 'white',
			                    'btn_color_hover'  => 'accent-regular',
			                    'text_color_hover' => 'white',
			                    'attrs'            => [
			                        'data-settings' => wp_json_encode([
			                            'animation'       => 'fadeInUp',
			                            'animation_delay' => 200
			                        ])
			                    ],
			                    'after_text'      => ''
			                ]);
			            ?>
			        </div>
	            </div>
	        </div>
		</div>
		<?php } 
	?></div>
</div>