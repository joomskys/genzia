<?php
$layout_mode   = $this->get_setting('layout_mode', 'grid');
$default_align = $this->get_setting('text_align', 'center');
$fancy_boxs    = $this->get_setting('fancy_box', []);
$default_col   = 2;
$tablet_col    = 2;
$mobile_col    = 2;
//
// Arrows
$arrows = $this->get_setting('arrows');
$this->add_render_attribute('arrows', [
    'class' => [
        'cms-swiper-buttons d-flex gap-10 flex-auto',
        genzia_add_hidden_device_controls_render($settings, 'arrows_')
    ]
]);
$arrows_classes = [
    'cms-carousel-button',
    'cms-box-58 circle',
    'text-'.$this->get_setting('arrows_color','menu'),
    'bg-'.$this->get_setting('arrows_bg_color','transparent'),
    'text-hover-'.$this->get_setting('arrows_hover_color','white'),
    'bg-hover-'.$this->get_setting('arrows_bg_hover_color','menu'),
    'bdr-1 bdr-'.$this->get_setting('arrows_border_color','menu'),
    'bdr-hover-'.$this->get_setting('arrows_border_hover_color','menu')
];
$arrows_classes_prev = genzia_nice_class(array_merge(['cms-carousel-button-prev prev'],$arrows_classes));
$arrows_classes_next = genzia_nice_class(array_merge(['cms-carousel-button-next next'],$arrows_classes));
// Dots
$dots = $this->get_setting('dots');
$this->add_render_attribute('dots', [
    'class' => [
    	'flex-basic gap-10',
        'cms-carousel-dots cms-carousel-dots-circle',
        ($arrows == 'yes') ? 'justify-content-end':'justify-content-center',
        genzia_add_hidden_device_controls_render($settings, 'dots_'),
    ],
    'style' => [
        '--cms-dots-color:var(--cms-menu);',
        '--cms-dots-hover-color:var(--cms-accent-regular);',
        '--cms-dots-hover-shadow:var(--cms-accent-regular);',
        '--cms-dots-hover-opacity:0.2;'
    ]
]);
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-fancyboxs-'.$settings['layout'],
		'text-'.$default_align,
		$this->get_setting('e_classes','')
	],
	'style' => '--cms-separator-color:var(--cms-divider);'
]);
// Grid
if($layout_mode == 'grid'){
    $this->add_render_attribute('wrap', [
        'class' => [
            'd-flex gutter-custom-x gutter-custom-my',
			genzia_elementor_get_grid_columns($widget, $settings, [
				'default'    => $default_col,
				'tablet'     => $tablet_col,
				'mobile'     => $mobile_col,
				'gap'        => '',
				'gap_prefix' => '',
				'align'		 => $default_align
			])
        ],
        'style' => [
        	'--gutter-x:80px;--gutter-x-tablet:60px;--gutter-x-mobile:40px;',
        	'--gutter-y:80px;--gutter-y-mobile:40px;'
        ]
    ]);
}
//Title
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-title heading',
		'text-'.$this->get_setting('title_color','heading-regular'),
		'text-xl',
		'm-tb-n7'
	]
]);
// Description
$this->add_render_attribute( 'description', [
	'class' => [
		'cms-desc',
		'text-'.$this->get_setting('description_color','body'),
		'text-md',
		'pt-20 m-tb-n5',
		'empty-none'
	]
]);
// Features
$this->add_render_attribute('features',[
    'class' => [
        'cms-features empty-none',
        'text-'.$this->get_setting('fcolor', 'body'),
        'text-md',
        'pt-15 mb-n7',
        ($layout_mode=='carousel')? '' : 'elementor-invisible',
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInUp',
    ])
]);
// Output HTMl
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php switch ($layout_mode) {
        case 'carousel':
    ?>
        <div class="cms-carousel swiper">
            <div class="<?php genzia_swiper_wrapper_class($this); ?>">
    <?php
            break;
        case 'grid':
            break;
    }
	    // 
		$count = 0;
		foreach ($fancy_boxs as $key => $fancy_box) { 
			$count++;
			// Item
			$item_key = $this->get_repeater_setting_key( 'item', 'cms_fancy_box', $key );
			$this->add_render_attribute( $item_key, [
				'class' => array_filter([
					'fancy-box-item relative',
					($layout_mode == 'carousel') ? 'cms-carousel-item swiper-slide' : 'cms-grid-item',
					'bdr-l-1 bdr-color',
					'bdr-'.$this->get_setting('item_bdr_color','divider')
				])
			]);
			//
			$item_content_key = $this->get_repeater_setting_key( 'item-content', 'cms_fancy_box', $key );
			$this->add_render_attribute( $item_content_key, [
				'class' => array_filter([
					'cms-fancybox',
					'cms-fancybox-'.$settings['layout'],
					'hover-icon-bounce',
					'cms-transition',
					
					'relative',
					($layout_mode == 'grid') ? 'elementor-invisible' : ''
				]),
				'data-settings' => wp_json_encode([
					'animation'       => 'fadeInRight',
					'animation_delay' => $key*100
				])
			]);
		?>
		<div <?php ctc_print_html($this->get_render_attribute_string($item_key)); ?>>
			<div <?php ctc_print_html($this->get_render_attribute_string($item_content_key)); ?>>
				<?php
					// Icon
					genzia_elementor_icon_image_render($widget, $settings,[
						'size'           => 48,
						'color'          => $this->get_setting('icon_color','menu'),
						'color_hover'    => $this->get_setting('icon_color','accent-regular'),
			            // icon
						'icon_tag'     => 'div',
						'icon_default' => [],
			            // image
			            'img_size'	 => 'custom',
			            // default
			            'class'      => genzia_nice_class([
			            	'cms-ficon',
			            	'cms-box-88 cms-radius-8 mb-25',
			            	'bdr-1 bdr-color',
			            	'bdr-'.$this->get_setting('item_bdr_color','divider'),
			            	($default_align == 'center') ? 'm-lr-auto' : ''
			            ]),
			            'before'     => '',
			            'after'      => '',
			            'echo'       => true,
			            'attrs'		 => []		
					], $fancy_box);
				?>
				<div <?php ctc_print_html( $this->get_render_attribute_string( 'title' ) ); ?>><?php 
					echo nl2br( $fancy_box['title'] ); 
				?></div>
			    <div <?php ctc_print_html( $this->get_render_attribute_string( 'description' ) ); ?>><?php 
			    	echo wpautop( $fancy_box['description'] ); 
			    ?></div>
			    <div <?php ctc_print_html($this->get_render_attribute_string('features')); ?>><?php 
	                // Features
	                $fcount = 0;
	                $features = (array)json_decode($fancy_box['features'], true);
	                foreach ($features as $fkey => $feature) {
	                    $fcount++;
	                    $fitem_attrs = [
	                        'class' => [
	                            'feature-item d-flex gap-10',
	                            'justify-content-'.$default_align,
	                            'align-items-center',
	                            'flex-nowrap',
	                            'text-md',
	                            ($layout_mode=='carousel')?'':'elementor-invisible',
	                            ($fcount > 0) ? 'pt-7' : ''
	                        ],
	                        'data-settings' => wp_json_encode([
	                            'animation' => 'fadeInUp'
	                        ])
	                    ];
	            ?>
	                <div <?php ctc_print_html(genzia_render_attrs($fitem_attrs)); ?>><?php 
	                    // Icon
	                    genzia_svgs_icon([
	                        'icon'       => 'core/check',
	                        'icon_size'  => 12,
	                        'icon_class' => 'cms-icon',
	                        'class'      => ''
	                    ]);
	                    // Text
	                    echo esc_html($feature['ftitle']); 
	                ?></div>
	            <?php
	                }
	            ?></div>
			    <?php 
			    	genzia_elementor_link_render($widget, $fancy_box, [
						'name' 		=> 'link1_',
						'loop' 		=> true,
						'loop_key'  => $key,
						'mode'		=> 'link',
						'text_icon'	=> genzia_svgs_icon([
							'icon'             => 'arrow-right',
							'icon_size'        => 10,
							'icon_class'       => '',
							'echo'             => false 
	                    ]),
						'class' => [
							'mt-20',
							'cms-link',
							'cms-hover-move-icon-right',
							'text-btn font-500',
							'cms-underline cms-hover-underline'
						],
						'text_color'       => $this->get_setting('btn_text_color','menu'),
						'text_color_hover' => $this->get_setting('btn_text_color_hover','accent-regular')
					]);
			    ?>
			</div>
		</div>
	<?php }
	//
	switch ($layout_mode) {
        case 'carousel':
    ?>
        	</div>
        </div>
    <?php if ($arrows == 'yes' || $dots == 'yes') { ?>
    	<div class="cms-carousel-arrows-dots d-flex pt-40">
    <?php }
    	// Arrows
        if ($arrows == 'yes'){ ?>
        	<div <?php ctc_print_html($this->get_render_attribute_string('arrows')); ?>>
	            <?php 
	                genzia_svgs_icon([
	                    'icon'      => 'core/chevron-left',
	                    'icon_size' => 8,
	                    'class'     => $arrows_classes_prev,
	                    'tag'       => 'div'
	                ]);
	                genzia_svgs_icon([
	                    'icon'      => 'core/chevron-right',
	                    'icon_size' => 8,
	                    'class'     => $arrows_classes_next,
	                    'tag'       => 'div'
	                ]);
	            ?>
	        </div>
        <?php }
        // Dots
        if ($dots == 'yes') { ?>
            <div <?php ctc_print_html($this->get_render_attribute_string('dots')); ?>></div>
        <?php } 
        if ($arrows == 'yes' || $dots == 'yes') {
        ?>
	    	</div>
	    <?php }

            break;
        case 'grid':
            break;
    } ?>
</div>