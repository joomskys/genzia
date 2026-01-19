<?php 
$cms_tabs   = $this->get_setting('contents', []);
$tabs       = $this->get_setting('tabs', []);
$active_tab = $this->get_setting('active_tab',1);
// Wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-tabs',
		'cms-tabs-'.$settings['layout']
	]
]);
// Banner 
$banner_custom_size = [
    'width'  => !empty($settings['banner_custom_dimension']['width']) ? $settings['banner_custom_dimension']['width'] : 384,
    'height' => !empty($settings['banner_custom_dimension']['height']) ? $settings['banner_custom_dimension']['height'] : 268
];
// Title 
$this->add_render_attribute('title', [
    'class' => [
        'cms-heading empty-none cms-nl2br',
        'text-'.$this->get_setting('tab_content_title_color','heading-regular'),
        'm-tb-nh4 pb-33',
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
        'm-tb-nlg',
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
// Element Heading
// Wrap
$this->add_render_attribute('heading-wrap',[
	'class' => [
		'cms-eheading',
		'cms-eheading-'.$settings['layout'],
		'd-flex gutter',
		'justify-content-between',
		'pb-120 pb-tablet-40'
	]
]);
// Small Heading
$this->add_inline_editing_attributes( 'smallheading_text' );
$this->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-small',
		'elementor-invisible',
		'cms-nl2br',
		'text-sm',
		'text-'.$this->get_setting('smallheading_color','sub-text'),
		'empty-none',
		'm-tb-nsm',
		'cms-sticky',
		'd-flex gap-8 flex-nowrap'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInLeft',
		'animation_delay' => 100
	])
]);
$small_icon_classes = genzia_nice_class([
	'cms-small-icon pt-7',
	'text-'.$this->get_setting('smallheading_icon_color', 'accent-regular')
]);
// Large Heading
$this->add_inline_editing_attributes( 'heading_text' );
$this->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-title empty-none',
		'text-'.$this->get_setting('heading_color','heading-regular'),
		'cms-nl2br',
		'elementor-invisible',
		'm-tb-nh2'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
// Call To Action
// Wrap
$this->add_render_attribute('cta-wrap', [
	'class' => array_filter([
		'cms-etabs-cta',
		'pt-100 pt-mobile-0'
	])
]);
// Text
$this->add_render_attribute('cta-text', [
	'class' => [
		'cms-cta-desc',
		'heading',
		'cms-nl2br',
		'text-xl m-tb-nxl',
		'text-'.$this->get_setting('cta_text_color','sub-text'),
		'empty-none',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
?>
<div <?php ctc_print_html( $this->get_render_attribute_string( 'heading-wrap' ) ); ?>>
	<div class="col-4 col-mobile-12">
		<div <?php ctc_print_html( $this->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php
			// Icon
			genzia_elementor_icon_render( $settings['smallheading_icon'], [], [ 'aria-hidden' => 'true', 'class' => $small_icon_classes, 'icon_size' => 12 ] );
			// Text
			echo nl2br( $settings['smallheading_text'] ); 
		?></div>
	</div>
	<div class="col-7 col-tablet-8 col-mobile-12">
		<h2 <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>><?php 
			echo nl2br( $settings['heading_text'] ); 
		?></h2>
	</div>
</div>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div class="d-flex gutter justify-content-between">
		<div class="cms-tabs-contents col-4 col-tablet-7 col-mobile-12 relative"><?php 
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
						'cms-show-max-mobile',
						'relative',
						'cms-sticky cms-mobile-relative',
						'mb-mobile-40'
					]),
					'style' => $c_is_active ? 'display:block;' : 'display:none;'
				] );
				// Content on image
				$content_img_key = $this->get_repeater_setting_key( 'tab_content_img', 'cms_tabs', $c_key );
				$this->add_render_attribute( $content_img_key, [
					'class' => array_filter([
						'absolute bottom left m-12 bg-backdrop cms-radius-10 p-40 elementor-invisible',
						'text-center'
					]),
					'data-settings' =>  wp_json_encode([
						'animation' => 'fadeInRight'
					])
				] );
				// Mobile Title
				$mobile_title_key = $this->get_repeater_setting_key( 'mobile_tab_title', 'cms_tabs', $c_key );
				$this->add_render_attribute( $mobile_title_key, [
					'class' => [ 
						'cms-mobile-tab-title',
						'relative',
						'cms-transition',
						'cms-hover-change',
						'text-'.$this->get_setting('mobile_tab_title_color','heading-regular'),
						'text-hover-'.$this->get_setting('mobile_tab_title_active_color','accent-regular'),
						'text-active-'.$this->get_setting('mobile_tab_title_active_color','accent-regular'),
						'cms-hidden-min-tablet',
						'pb-20',
						'd-flex gap-32 flex-nowrap align-items-end'
					]
				]);
			?>
			<h4 <?php ctc_print_html( $this->get_render_attribute_string( $mobile_title_key ) ); ?>><?php
				// Count
				echo genzia_leading_zero($c_count, [
					'before' => '<span class="flex-auto text-lg font-body">',
					'after'	 => '</span>'
				]);
				// text
				echo '<span class="relative">'.nl2br($c_title).'</span>';
			?></h4>
			<?php // Tab Content ?>
			<div <?php ctc_print_html( $this->get_render_attribute_string( $content_key ) ); ?>>
				<div class="relative mb-40 overflow-hidden">
					<?php
		                genzia_elementor_image_render($cms_tab,[
		                    'name'           => 'banner',
		                    'image_size_key' => 'banner',
		                    'img_class'      => 'cms-tab-banner cms-radius-16 img-cover elementor-invisible',
		                    'size'           => $this->get_setting('banner_size','custom'),
		                    'custom_size'    => $banner_custom_size,
		                    'attrs'          => [
		                        'data-settings' => wp_json_encode([
		                            'animation' => 'fadeInRight'
		                        ]),
		                        'style' => 'max-height:400px;'
		                    ],
		                    'min_height' => true,
		                    'max_height' => false,
		                    'before'     => '',
		                    'after'      => ''
		                ]);
		            if(!empty($cms_tab['icon']['value'])){
		            ?>
			            <div <?php ctc_print_html($this->get_render_attribute_string($content_img_key)); ?>>
			            	<?php 
			            		// Icon
					            genzia_elementor_icon_render( $cms_tab['icon'], [], [
									'aria-hidden'      => 'true', 
									'class'            => 'cms-icon', 
									'icon_size'        => 96, 
									'icon_color'       => $this->get_setting('icon_color','white'), 
									'icon_color_hover' => $this->get_setting('icon_color','white')
								], 
					            'div');
			            	?>
			            	<div class="text-lg text-<?php echo esc_attr($this->get_setting('icon_color','white')); ?> pt-10"><?php echo esc_html($cms_tab['icon_title']); ?></div>
			            </div>
			        <?php } ?>
		        </div>
	            <h4 <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php echo esc_html($cms_tab['title']); ?></h4>
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
	                                    'icon_class' => 'cms-icon pt-7'
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
		                    'icon_size'  => 10, 
		                    'icon_class' => [],
		                    'echo'       => false,
		                    'class'      => genzia_nice_class([
								'cms-eicon cms-heading-btn-icon',
								'cms-box-48 cms-radius-6',
								'order-first',
								'bg-'.$this->get_setting('link__icon_bg','white'),
								'text-'.$this->get_setting('link__icon_color','menu'),
								'bg-hover-'.$this->get_setting('link__icon_bg_hover','white'),
								'bg-on-hover-'.$this->get_setting('link__icon_bg_hover','white'),
								'text-hover-'.$this->get_setting('link__icon_color_hover','menu'),
								'text-on-hover-'.$this->get_setting('link__icon_color_hover','menu')
							])
		                ]),
	                    'class'            => ['cms-hover-move-icon-right','elementor-invisible','mt-33'],
	                    'btn_color'        => 'primary-regular',
	                    'text_color'       => 'white',
	                    'btn_color_hover'  => 'accent-regular',
	                    'text_color_hover' => 'white',
	                    'attrs'            => [
	                        'data-settings' => wp_json_encode([
	                            'animation'       => 'fadeInUp',
	                            'animation_delay' => 200
	                        ])
	                    ],
	                    'after_text' => ''
	                ]);
	            ?>
			</div>
			<?php } 
		?></div>
		<div class="cms-tabs-title col-7 col-tablet-5 col-mobile-12">
			<div class="cms-tabs--title cms-hidden-mobile">
				<?php 
				$count = 0;
				foreach ($cms_tabs as $key => $cms_tab) {
					$count ++;
					$is_active = ( $key + 1 ) === $active_tab ? true : false;
					$title = !empty($cms_tab['tab_title']) ? $cms_tab['tab_title'] : 'Tab #'.($key+1);
					// title
					$title_key = $this->get_repeater_setting_key( 'tab_title', 'cms_tabs', $key );
					$this->add_render_attribute( $title_key, [
						'class' => array_filter([ 
							'cms-tab-title',
							$is_active ? 'active' : '',
							'relative',
							'cms-transition',
							'cms-hover-change',
							'text-'.$this->get_setting('tab_title_color','menu'),
							'text-hover-'.$this->get_setting('tab_title_active_color','accent-regular'),
							'text-active-'.$this->get_setting('tab_title_active_color','accent-regular'),
							'p-tb-38',
							'bdr-b-1',
							($count==1) ? 'bdr-t-1' : '',
							'bdr-'.$this->get_setting('tab_title_bdr_color','divider'),
							'bdr-active-'.$this->get_setting('tab_title_bdr_active_color','divider'),
							'd-flex gap-32 flex-nowrap align-items-end'
						]),
						'data-target' => '#cms-'.$cms_tab['_id'],
						'data-active' => $is_active?'active':'',
						'data-current' => genzia_leading_zero($count,['echo' => false])
					]);
				?>
					<h4 <?php ctc_print_html( $this->get_render_attribute_string( $title_key ) ); ?>><?php 
						// Count
						echo genzia_leading_zero($count, [
							'before' => '<span class="flex-auto text-lg min-w font-body" style="--min-w:70px;--min-w-tablet:auto;padding-bottom:2px;">',
							'after'	 => '</span>'
						]);
						// text
						echo '<span class="relative">'.nl2br($title).'</span>';
					?></h4>
					
				<?php } ?>
			</div>
			<div <?php ctc_print_html($this->get_render_attribute_string('cta-wrap')); ?>>
				<div <?php ctc_print_html($this->get_render_attribute_string('cta-text')) ?>><?php echo nl2br($settings['cta_text']);?></div>
				<?php 
					genzia_elementor_link_render($widget, $settings, [
						'name'             => 'cta_link_',
						'mode'             => 'btn',
						'text_icon'        => genzia_svgs_icon([
							'icon'      => 'arrow-right',
							'icon_size' => 10,
							'echo'      => false,
							'class'     => genzia_nice_class([
								'cms-eicon cms-cta-btn-icon',
								'cms-box-48 cms-radius-6',
								'order-first',
								'bg-'.$this->get_setting('cta_link__icon_bg','white'),
								'text-'.$this->get_setting('cta_link__icon_color','menu'),
								'bg-hover-'.$this->get_setting('cta_link__icon_bg_hover','white'),
								'bg-on-hover-'.$this->get_setting('cta_link__icon_bg_hover','white'),
								'text-hover-'.$this->get_setting('cta_link__icon_color_hover','menu'),
								'text-on-hover-'.$this->get_setting('cta_link__icon_color_hover','menu')
							])
						]),
						'class'            => [
							'cms-hover-move-icon-right',
							'mt-32',
							'elementor-invisible',
							'cms-hover-change'
						],
						'btn_color'        => 'primary-regular',
						'text_color'       => 'white',
						'btn_color_hover'  => 'accent-regular',
						'text_color_hover' => 'white',
						'attrs' 		   => [
							'data-settings' => wp_json_encode([
								'animation' => 'fadeInUp'
							])
						]
					]);
				?>
			</div>
		</div>
	</div>
</div>