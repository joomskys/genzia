<?php 
$cms_tabs   = $widget->get_setting('contents', []);
$tabs       = $widget->get_setting('tabs', []);
$active_tab = $widget->get_setting('active_tab',1);
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-tabs',
		'cms-tabs-'.$settings['layout'],
		'd-flex'
	]
]);
// Banner 
$banner_custom_size = [
    'width'  => !empty($settings['banner_custom_dimension']['width']) ? $settings['banner_custom_dimension']['width'] : 800,
    'height' => !empty($settings['banner_custom_dimension']['height']) ? $settings['banner_custom_dimension']['height'] : 874
];
// Title 
$widget->add_render_attribute('title', [
    'class' => [
        'cms-heading empty-none cms-nl2br',
        'text-'.$widget->get_setting('tab_content_title_color','white'),
        'text-xl',
        'm-tb-n7',
        'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
    	'animation' => 'fadeInUp'
    ])
]);
// Description
$widget->add_render_attribute('desc', [
    'class' =>  [
        'cms-desc empty-none cms-nl2br',
        'text-'.$widget->get_setting('tab_content_desc_color', 'white'),
        'text-lg text-line-4',
        'm-tb-n7 pt-25',
        'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
    	'animation' => 'fadeInUp'
    ])
]);
// Feature
$widget->add_render_attribute('features-wrap', [
    'class' => [
        'cms-features empty-none',
        'pt-23',
        'text-md',
        'text-'.$widget->get_setting('tab_content_feature_color','white'),
        'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInUp'
    ])
]);
// Element Heading
// Small Heading
$widget->add_inline_editing_attributes( 'smallheading_text' );
$widget->add_render_attribute( 'smallheading_text', [
	'class' => [
		'elementor-invisible',
		'cms-smallheading',
		'text-lg',
		'text-'.$widget->get_setting('smallheading_color','accent-regular'),
		'pb-12 m-tb-n5',
		'empty-none',
		'd-flex gap-12 flex-nowrap'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 100
	])
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'elementor-invisible',
		'cms-heading empty-none',
		'text-'.$widget->get_setting('heading_color','white'),
		'm-tb-n5'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
// Description #1
$widget->add_inline_editing_attributes( 'edesc' );
$widget->add_render_attribute( 'edesc', [
	'class' => array_filter([
		'cms-desc empty-none',
		'text-'.$widget->get_setting('desc_color','on-dark'),
		'text-lg',
		'elementor-invisible',
		'm-tb-n5',
		'pt-30'
	]),
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
?>
<div <?php ctc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div class="cms-tabs-title col-6 col-mobile-extra-12 bg-primary-lighten cms-radius-trbr-24 d-flex align-items-center justify-content-center p-tb p-lr-mobile-12" style="--p-tb:128px;--p-tb-tablet:60px;--p-tb-mobile:40px;">
		<div class="cms-tabs--title d-flex flex-column justify-content-between align-items-between h-100" style="max-width: 480px;">
			<div class="cms-tabs--eheading pb-40">
				<div <?php ctc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php 
					// Icon
					genzia_elementor_icon_image_render($widget, $settings,[
						'size'        => 18,
				        'color'       => $widget->get_setting('smallheading_color','accent-regular'),
				        'color_hover' => $widget->get_setting('smallheading_color','accent-regular'),
				        // icon
				        'icon_tag'    => 'span',
				        'icon_default' => [],
				        // image
				        'img_size'	 => 'custom',
				        // default
				        'class'      => 'pt-3',
				        'before'     => '',
				        'after'      => '',
				        'echo'       => true	
					]);
					echo nl2br( $settings['smallheading_text'] ); 
				?></div>
				<h3 <?php ctc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h3>
				<div <?php ctc_print_html( $widget->get_render_attribute_string( 'edesc' ) ); ?>><?php echo nl2br( $settings['desc'] ); ?></div>
			</div>
			<div class="cms-tabs--title cms-hidden-mobile-extra">
				<?php 
				$count = 0;
				foreach ($cms_tabs as $key => $cms_tab) {
					$count ++;
					$is_active = ( $key + 1 ) === $active_tab ? true : false;
					$title = !empty($cms_tab['tab_title']) ? $cms_tab['tab_title'] : 'Tab #'.($key+1);
					// title
					$title_key = $widget->get_repeater_setting_key( 'tab_title', 'cms_tabs', $key );
					$widget->add_render_attribute( $title_key, [
						'class' => [ 
							'cms-tab-title',
							$is_active ? 'active' : '',
							'relative',
							'cms-transition',
							'cms-hover-change',
							'text-'.$widget->get_setting('tab_title_color','divider-50'),
							'text-hover-'.$widget->get_setting('tab_title_active_color','white'),
							'text-active-'.$widget->get_setting('tab_title_active_color','white'),
							($key>0)?'pt-23' : ''
						],
						'data-target' => '#cms-'.$cms_tab['_id'],
						'data-active' => $is_active?'active':'',
						'data-current' => genzia_leading_zero($count,['echo' => false])
					]);
				?>
					<h4 <?php ctc_print_html( $widget->get_render_attribute_string( $title_key ) ); ?>><?php 
						// text
						echo '<span class="relative">'.nl2br($title).'</span>';
					?></h4>
					
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="cms-tabs-contents col-6 col-mobile-extra-12 relative"><?php 
		// Tabs Content
		$c_count = 0;
		foreach ($cms_tabs as $c_key => $cms_tab) {
			$features = json_decode($cms_tab['features'], true);
			//
			$c_count++;
			$c_is_active = ( $c_key + 1 ) === $active_tab ? true : false;
			$c_title = !empty($cms_tab['tab_title']) ? $cms_tab['tab_title'] : 'Tab #'.($c_key+1);
			$content_key = $widget->get_repeater_setting_key( 'tab_content', 'cms_tabs', $c_key );
			$widget->add_render_attribute( $content_key, [
				'id'	=> 'cms-'.$cms_tab['_id'],
				'class' => array_filter([
					'cms-tabs-content',
					$c_is_active ? 'active' : '',
					'cms-show-max-mobile-extra',
					'relative'
				]),
				'style' => $c_is_active ? 'display:block;' : 'display:none;'
			] );
			// Content on image
			$content_img_key = $widget->get_repeater_setting_key( 'tab_content_img', 'cms_tabs', $c_key );
			$widget->add_render_attribute( $content_img_key, [
				'class' => array_filter([
					'absolute bottom left m-12 bg-backdrop cms-radius-16 p-40 elementor-invisible',
					'cms-width'
				]),
				'data-settings' =>  wp_json_encode([
					'animation' => 'fadeInRight'
				]),
				'style' => '--width:384px;--width-smobile:auto;'
			] );
			// Mobile Title
			$mobile_title_key = $widget->get_repeater_setting_key( 'mobile_tab_title', 'cms_tabs', $c_key );
			$widget->add_render_attribute( $mobile_title_key, [
				'class' => [ 
					'cms-mobile-tab-title',
					'relative',
					'cms-transition',
					'cms-hover-change',
					'text-'.$widget->get_setting('mobile_tab_title_color','heading-regular'),
					'text-hover-'.$widget->get_setting('mobile_tab_title_active_color','accent-regular'),
					'text-active-'.$widget->get_setting('mobile_tab_title_active_color','accent-regular'),
					'cms-hidden-min-mobile-extra',
					'p-tb-40 p-lr-20'
				]
			]);
		?>
		<h4 <?php ctc_print_html( $widget->get_render_attribute_string( $mobile_title_key ) ); ?>><?php
			// text
			echo '<span class="relative">'.nl2br($c_title).'</span>';
		?></h4>
		<?php // Tab Content ?>
		<div <?php ctc_print_html( $widget->get_render_attribute_string( $content_key ) ); ?>>
			<?php
                genzia_elementor_image_render($cms_tab,[
                    'name'           => 'banner',
                    'image_size_key' => 'banner',
                    'img_class'      => 'cms-tab-banner h-100 cms-radius-tlbl-24 img-cover elementor-invisible',
                    'size'           => 'custom',
                    'custom_size'    => ['width' => 800, 'height' => 874],
                    'attrs'          => [
                    	'style' => 'min-height: 480px;',
                        'data-settings' => wp_json_encode([
                            'animation' => 'fadeIn'
                        ])
                    ],
                    'min_height' => false,
                    'max_height' => true,
                    'before'     => '',
                    'after'      => ''
                ]);
            ?>
            <div <?php ctc_print_html($widget->get_render_attribute_string($content_img_key)); ?>>
            	<?php 
            		// Icon
		            genzia_elementor_icon_render( $cms_tab['icon'], [], [
						'aria-hidden'      => 'true', 
						'class'            => 'cms-icon pb-30', 
						'icon_size'        => 64, 
						'icon_color'       => $widget->get_setting('icon_color','white'), 
						'icon_color_hover' => $widget->get_setting('icon_color','white')
					], 
		            'div');
            	?>
				<h5 <?php ctc_print_html($widget->get_render_attribute_string('title')); ?>><?php echo esc_html($cms_tab['title']); ?></h5>
				<div <?php ctc_print_html($widget->get_render_attribute_string('desc')); ?>><?php echo nl2br($cms_tab['desc']); ?></div>
				<div <?php ctc_print_html($widget->get_render_attribute_string('features-wrap')); ?>><?php
	                if(!empty($features)){ 
	                    $count_feature = 0;
	                    foreach ( $features as $fkey => $cms_feature ):
	                        $count_feature++;
	                        // Items
	                        $fitem_key = $widget->get_repeater_setting_key( 'fitem', 'cms_tabs', $fkey );
	                        $widget->add_render_attribute($fitem_key, [
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
	                        $ftitle_key = $widget->get_repeater_setting_key( 'ftitle', 'cms_tabs', $fkey );
	                        $widget->add_render_attribute($ftitle_key, [
	                            'class' => [
	                                'feature-title',
	                                'flex-basic'
	                            ]
	                        ]);
	                    ?>
	                        <div <?php ctc_print_html($widget->get_render_attribute_string($fitem_key)); ?>>
	                            <?php
	                                genzia_svgs_icon([
	                                    'icon'       => 'core/check',
	                                    'icon_size'  => 10,
	                                    'icon_class' => 'cms-icon pt-7'
	                                ]);
	                            ?>
	                            <div <?php ctc_print_html( $widget->get_render_attribute_string( $ftitle_key ) ); ?>><?php echo esc_html( $cms_feature['ftitle'] ) ?></div>
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
	                    'btn_color'        => 'accent-regular',
	                    'text_color'       => 'menu',
	                    'btn_color_hover'  => 'primary-regular',
	                    'text_color_hover' => 'accent-regular',
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
		<?php } 
	?></div>
</div>