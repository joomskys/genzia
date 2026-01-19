<?php 
$cms_tabs   = $widget->get_setting('contents', []);
$tabs       = $widget->get_setting('tabs', []);
$active_tab = $widget->get_setting('active_tab',1);
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-tabs',
		'cms-tabs-'.$settings['layout']
	]
]);
// Banner 
$banner_custom_size = [
    'width'  => !empty($settings['banner_custom_dimension']['width']) ? $settings['banner_custom_dimension']['width'] : 624,
    'height' => !empty($settings['banner_custom_dimension']['height']) ? $settings['banner_custom_dimension']['height'] : 460
];
// Title 
$widget->add_render_attribute('title', [
    'class' => [
        'heading empty-none cms-nl2br',
        'text-xl',
        'text-'.$widget->get_setting('tab_content_title_color','heading-regular'),
        'm-tb-n7 pt-25',
        'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
    	'animation' => 'fadeInUp'
    ])
]);
// Count
$widget->add_render_attribute('count', [
	'class' => [
		'count',
		'text-lg font-400',
		'text-'.$widget->get_setting('count_color', 'accent-regular')
	]
]);
// Description
$widget->add_render_attribute('desc', [
    'class' =>  [
        'cms-desc empty-none cms-nl2br',
        'text-'.$widget->get_setting('tab_content_desc_color', 'body'),
        'text-lg',
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
        'text-'.$widget->get_setting('tab_content_feature_color','sub-text'),
        'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInUp'
    ])
]);
// Buttons
$widget->add_render_attribute('buttons',[
	'class' => [
		'cms-tabs-btns empty-none',
		'pt-40',
		'd-flex gap-24'
	]
]);
?>
<div <?php ctc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div class="d-flex gutter-32">
		<div class="cms-tabs-contents col-7 col-tablet-6 col-mobile-12 cms-hidden-max-mobile">
			<div class="cms-tabs--contents pr-72 pr-tablet-extra-0 overflow-hidden cms-sticky" style="--cms-sticky:40px;"><?php 
				// Tabs Content
				$c_count = 0;
				foreach ($cms_tabs as $c_key => $cms_tab) {
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
							'relative'
						]),
						'style' => $c_is_active ? 'display:block;' : 'display:none;'
					] );
					// Content on image
					$content_img_key = $widget->get_repeater_setting_key( 'tab_content_img', 'cms_tabs', $c_key );
					$widget->add_render_attribute( $content_img_key, [
						'class' => array_filter([
							'absolute bottom right m-12 elementor-invisible',
							'd-flex flex-nowrap'
						]),
						'data-settings' =>  wp_json_encode([
							'animation' => 'fadeInRight'
						])
					] );
				?>
				<?php // Tab Content ?>
				<div <?php ctc_print_html( $widget->get_render_attribute_string( $content_key ) ); ?>>
					<?php
		                genzia_elementor_image_render($cms_tab,[
		                    'name'           => 'banner',
		                    'image_size_key' => 'banner',
		                    'img_class'      => 'cms-tab-banner cms-radius-16 img-cover elementor-invisible',
		                    'size'           => $widget->get_setting('banner_size','custom'),
		                    'custom_size'    => $banner_custom_size,
		                    'attrs'          => [
		                    	'style' => 'min-height: 400px;',
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
								'class'            => 'cms-icon p-tb-32 p-lr-24 cms-box- cms-radius-8 bg-accent-regular', 
								'icon_size'        => 64, 
								'icon_color'       => $widget->get_setting('icon_color','sub-text'), 
								'icon_color_hover' => $widget->get_setting('icon_color','sub-text')
							], 
				            'div');
		            	?>
						<div class="cms-icon-title bg-white cms-radius-8 p-32 text-lg cms-heading d-flex align-items-center" style="max-width:260px;"><?php 
							echo nl2br($cms_tab['icon_title']);
						?></div>
		            </div>
				</div>
				<?php } 
			?></div>
		</div>
		<div class="cms-tabs-title col-5 col-tablet-6 col-mobile-12">
			<?php 
			$count = 0;
			foreach ($cms_tabs as $key => $cms_tab) {
				$count ++;
				$is_active = ( $key + 1 ) === $active_tab ? true : false;
				$title = !empty($cms_tab['tab_title']) ? $cms_tab['tab_title'] : 'Tab #'.($key+1);
				//
				$features = json_decode($cms_tab['features'], true);
				// Items
				$item_key = $widget->get_repeater_setting_key( 'tab_item', 'cms_tabs', $key );
				$widget->add_render_attribute( $item_key, [
					'class' => [ 
						'cms-tab-title',
						$is_active ? 'active' : '',
						'bdr-t-1 bdr-'.$widget->get_setting('tab_content_bdr_color', 'divider'),
						($count == count($cms_tabs)) ? 'bdr-b-1' : '',
						'p-tb-40',
						'elementor-invisible'
					],
					'data-target' => '#cms-'.$cms_tab['_id'],
					'data-active' => $is_active?'active':'',
					'data-current' => genzia_leading_zero($count,['echo' => false]),
					'data-settings' => wp_json_encode([
						'animation' => 'fadeInUp'
					])
				]);
				// Banner Mobile
				$banner_mobile_key = $widget->get_repeater_setting_key('banner_mobile', 'cms_tabs', $key);
				$widget->add_render_attribute($banner_mobile_key,[
					'class' => [
						'banner-mobile',
						'cms-hidden-min-tablet',
						'relative mb-40'
					]
				]);
				// title
				$title_key = $widget->get_repeater_setting_key( 'tab_title', 'cms_tabs', $key );
				$widget->add_render_attribute( $title_key, [
					'class' => [
						'text-'.$widget->get_setting('tab_title_color','heading-regular'),
						'text-hover-'.$widget->get_setting('tab_title_active_color','primary-regular'),
						'text-active-'.$widget->get_setting('tab_title_active_color','primary-regular'),
						'm-tb-n5',
						'd-flex justify-content-between'
					]
				]);
			?>
				<div <?php ctc_print_html( $widget->get_render_attribute_string( $item_key ) ); ?>>
					<div <?php ctc_print_html( $widget->get_render_attribute_string( $banner_mobile_key ) ); ?>>
						<?php
			                genzia_elementor_image_render($cms_tab,[
			                    'name'           => 'banner',
			                    'image_size_key' => 'banner',
			                    'img_class'      => 'cms-tab-banner cms-radius-16 img-cover elementor-invisible',
			                    'size'           => $widget->get_setting('banner_size','custom'),
			                    'custom_size'    => $banner_custom_size,
			                    'attrs'          => [
			                    	'style' => 'min-height: 400px;',
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
									'class'            => 'cms-icon p-tb-32 p-lr-24 cms-box- cms-radius-16 bg-accent-regular', 
									'icon_size'        => 64, 
									'icon_color'       => $widget->get_setting('icon_color','sub-text'), 
									'icon_color_hover' => $widget->get_setting('icon_color','sub-text')
								], 
					            'div');
			            	?>
							<div class="cms-icon-title bg-white cms-radius-16 p-32 text-lg cms-heading d-flex align-items-center" style="max-width:260px;"><?php 
								echo nl2br($cms_tab['icon_title']);
							?></div>
			            </div>
					</div>
					<h6 <?php ctc_print_html( $widget->get_render_attribute_string( $title_key ) ); ?>><?php 
						// text
						echo nl2br($title);
						// Count
						genzia_leading_zero($count,[
							'before' => '<span '.$widget->get_render_attribute_string('count').'>',
							'after' => '</span>'
						]);
					?></h6>
					<div <?php ctc_print_html($widget->get_render_attribute_string('title')); ?>><?php echo esc_html($cms_tab['title']); ?></div>
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
		                    'btn_color_hover'  => 'white',
		                    'text_color_hover' => 'menu',
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
			<?php } // End Foreach ?>
			<div <?php ctc_print_html($widget->get_render_attribute_string('buttons'));?>><?php 
				// Button #1
				genzia_elementor_link_render($widget, $settings, [
					'name'             => 'link1_',
					'mode'             => 'btn',
					'text_icon'        => genzia_svgs_icon([
						'icon'      => 'arrow-right',
						'icon_size' => 11,
						'echo'      => false
					]),
					'class'            => [
						'cms-hover-move-icon-right',
						'elementor-invisible'
					],
					//'btn_prefix'       => 'btn-outline-',
					//'btn_hover_prefix' => 'btn-hover-',
					'btn_color'        => 'primary-regular',
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
				genzia_elementor_link_render($widget, $settings, [
					'name'             => 'link2_',
					'mode'             => 'btn',
					'text_icon'        => '',
					'class'            => [
						'elementor-invisible'
					],
					'btn_prefix'       => 'btn-outline-',
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
		</div>
	</div>
</div>