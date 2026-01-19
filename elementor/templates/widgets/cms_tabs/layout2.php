<?php 
$cms_tabs   = $this->get_setting('contents2', []);
$tabs       = $this->get_setting('tabs', []);
$active_tab = $this->get_setting('active_tab',1);
// Wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-tabs',
		'cms-tabs-'.$settings['layout']
	]
]);
// Small Heading
$this->add_inline_editing_attributes( 'smallheading_text' );
$this->add_render_attribute( 'smallheading_text', [
	'class' => [
		'elementor-invisible',
		'cms-smallheading',
		'text-'.$this->get_setting('smallheading_color','accent'),
		'pb-20 m-tb-n7',
		'empty-none'
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
		'elementor-invisible',
		'cms-heading empty-none',
		'text-'.$this->get_setting('heading_color','heading-regular'),
		'm-tb-n5'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
// Description #1
$this->add_inline_editing_attributes( 'desc' );
$this->add_render_attribute( 'desc', [
	'class' => array_filter([
		'cms-desc empty-none',
		'text-'.$this->get_setting('desc_color','sub-text'),
		'font-700',
		'elementor-invisible',
		'mt-n7',
		'pt-40'
	]),
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
// Description #2
$this->add_inline_editing_attributes( 'desc2' );
$this->add_render_attribute( 'desc2', [
	'class' => array_filter([
		'cms-desc pt-25 empty-none',
		'text-'.$this->get_setting('desc2_color','body'),
		'elementor-invisible'
	]),
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
// Tab Content
$this->add_render_attribute('tab_desc', [
	'class' => [
		'tab-desc',
		'font-500 empty-none',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
$this->add_render_attribute('tab_desc2', [
	'class' => [
		'tab-desc2',
		'pt-25 empty-none',
		'text-'.$this->get_setting('tab_content_desc2_color', 'body'),
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// Tab Feature
$this->add_render_attribute('features-wrap', [
    'class' => [
        'cms-features empty-none',
        'pt-25',
        'text-'.$this->get_setting('tab_content_feature_color', 'sub-text'),
        'text-md'
    ]
]);
$this->add_render_attribute('features-item',[
    'class' => [
        'cms-list',
        'elementor-invisible'
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInUp'
    ])
]);
// Tab title Mobile
$this->add_render_attribute('tab-title-mobile',[
	'class' => [
		'cms-hidden-min-mobile-extra',
		'cms-heading text-xl',
		'text-'.$this->get_setting('mobile_tab_title_color','menu'),
		'text-hover-'.$this->get_setting('mobile_tab_title_active_color','accent-regular'),
		'text-active-'.$this->get_setting('mobile_tab_title_active_color','accent-regular'),
		'bdr-b-1 bdr-'.$this->get_setting('mobile_tab_title_bdr_active_color','accent-regular'),
		'pb-20',
		'mb-30'
	]
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
<div <?php ctc_print_html( $this->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
<h3 <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h3>
<div <?php ctc_print_html( $this->get_render_attribute_string( 'desc' ) ); ?>><?php echo nl2br( $settings['desc'] ); ?></div>
<div <?php ctc_print_html( $this->get_render_attribute_string( 'desc2' ) ); ?>><?php echo nl2br( $settings['desc2'] ); ?></div>
<?php if(!empty($settings['smallheading_text']) || !empty($settings['heading_text']) || !empty($settings['desc']) || !empty($settings['desc2'])){
	echo  '<div style="height:62px;"></div>';
}
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div class="cms-tabs-title d-flex gap-40 cms-hidden-mobile-extra bdr-b-1 bdr-<?php ctc_print_html($this->get_setting('tab_title_bdr_color','divider')); ?> mb-40">
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
					'cms-tab-title',
					$is_active ? 'active' : '',
					'text-sm font-700',
					'text-'.$this->get_setting('tab_title_color','menu'),
					'text-hover-'.$this->get_setting('tab_title_active_color','accent-regular'),
					'text-active-'.$this->get_setting('tab_title_active_color','accent-regular'),
					'bdr-b-1 bdr-transparent',
					'bdr-active-'.$this->get_setting('tab_title_bdr_active_color','accent-regular'),
					'bdr-hover-'.$this->get_setting('tab_title_bdr_active_color','accent-regular'),
					'relative pb-20',
					'cms-transition',
					'cursor-pointer'
				],
				'data-target' => '#cms-'.$cms_tab['_id'],
				'data-active' => $is_active?'active':''
			]);
		?>
			<div <?php ctc_print_html( $this->get_render_attribute_string( $title_key ) ); ?>><?php 
				// text
				echo nl2br($title);
			?></div>
			
		<?php } ?>
	</div>
	<div class="cms-tabs-contents relative text-<?php ctc_print_html($this->get_setting('tab_content_desc_color', 'body')); ?>"><?php 
		// Tabs Content
		$c_count = 0;
		foreach ($cms_tabs as $c_key => $cms_tab) {
			$c_count++;
			$c_is_active = ( $c_key + 1 ) === $active_tab ? true : false;
			$c_title = !empty($cms_tab['tab_title']) ? $cms_tab['tab_title'] : 'Tab #'.($c_key+1);
			//
			$content_key = $this->get_repeater_setting_key( 'tab_content', 'cms_tabs', $c_key );
			$this->add_render_attribute( $content_key, [
				'id'	=> 'cms-'.$cms_tab['_id'],
				'class' => array_filter([
					'cms-tabs-content',
					$c_is_active ? 'active' : '',
					'm-tb-n7',
					($c_count < count($cms_tabs)) ? 'pb-mobile-extra-40' : '',
					'cms-show-max-mobile-extra'
				]),
				'style' => $c_is_active ? 'display:block;' : 'display:none;'
			] );
		?>
		<div <?php ctc_print_html($this->get_render_attribute_string('tab-title-mobile')); ?>><?php 
			// text
			echo nl2br($c_title);
		?></div>
		<?php // Tab Content ?>
		<div <?php ctc_print_html( $this->get_render_attribute_string( $content_key ) ); ?>>
			<div <?php ctc_print_html($this->get_render_attribute_string('tab_desc')); ?>><?php echo nl2br($cms_tab['desc']); ?></div>
			<div <?php ctc_print_html($this->get_render_attribute_string('tab_desc2')); ?>><?php echo nl2br($cms_tab['desc2']); ?></div>
			<div <?php ctc_print_html($this->get_render_attribute_string('features-wrap')); ?>><?php
				$features = json_decode($cms_tab['features'], true);
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
                                'p-tb-12',
                                'bdr-'.$this->get_setting('tab_content_bdr_color', 'divider'),
                                ($count_feature > 1) ? 'bdr-t-1' : '',
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
                                    'icon_size'  => 9,
                                    'icon_class' => 'cms-icon cms-box-24 circle bg-accent-regular text-menu'
                                ]);
                            ?>
                            <div <?php ctc_print_html( $this->get_render_attribute_string( $ftitle_key ) ); ?>><?php echo esc_html( $cms_feature['ftitle'] ) ?></div>
                        </div>
                    <?php endforeach;
                } 
            ?></div>
		</div>
		<?php } 
	?></div>
</div>
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
			'btn-lg',
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
			'btn-lg',
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