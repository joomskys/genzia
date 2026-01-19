<?php
$layout_mode   = $this->get_setting('layout_mode', 'grid');
$default_align = $this->get_setting('text_align', 'start');
$fancy_boxs    = $this->get_setting('career', []);
$default_col   = 3;
$tablet_col    = 2;
$mobile_col    = 1;
// Arrows
$arrows = $this->get_setting('arrows');
$this->add_render_attribute('arrows', [
    'class' => [
        'cms-swiper-buttons d-flex gap-12 flex-auto',
        genzia_add_hidden_device_controls_render($settings, 'arrows_')
    ]
]);
$arrows_classes = [
    'cms-carousel-button',
    'cms-box-58 circle',
    'text-'.$this->get_setting('arrows_color','menu'),
    'bg-'.$this->get_setting('arrows_bg_color','transparent'),
    'text-hover-'.$this->get_setting('arrows_hover_color','menu'),
    'bg-hover-'.$this->get_setting('arrows_bg_hover_color','accent-regular'),
    'bdr-1 bdr-'.$this->get_setting('arrows_border_color','transparent'),
    'bdr-hover-'.$this->get_setting('arrows_border_hover_color','accent-regular')
];
$arrows_classes_prev = genzia_nice_class(array_merge(['cms-carousel-button-prev prev mr-n12'],$arrows_classes));
$arrows_classes_next = genzia_nice_class(array_merge(['cms-carousel-button-next next'],$arrows_classes));
// Dots
$dots = $this->get_setting('dots');
$this->add_render_attribute('dots', [
    'class' => [
    	'flex-basic gap-12',
        'cms-carousel-dots cms-carousel-dots-bullets',
        ($arrows == 'yes') ? 'justify-content-end':'justify-content-center',
        genzia_add_hidden_device_controls_render($settings, 'dots_'),
    ],
    'style' => [
        '--cms-dots-color:var(--cms-'.$this->get_setting('dots_color','menu').');',
        '--cms-dots-hover-color:var(--cms-'.$this->get_setting('dots_active_color','menu').');',
        '--cms-dots-hover-shadow:var(--cms-'.$this->get_setting('dots_active_color','menu').');',
        '--cms-dots-hover-opacity:0.7;--cms-dots-hover-opacity:1;'
    ]
]);
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-fancyboxs-'.$settings['layout'],
		'text-'.$default_align,
		$this->get_setting('e_classes','')
	],
	'style' => '--cms-separator-color:var(--cms-'.$this->get_setting('item_bdr_color','divider').');'
]);
//
switch ($layout_mode) {
	case 'carousel':
		break;
	default:
		$this->add_render_attribute('wrap', [
			'class' => [
				'd-flex',
				'justify-content-'.$default_align,
				genzia_elementor_get_grid_columns($this, $settings, [
					'default'    => $default_col,
					'tablet'     => $tablet_col,
					'mobile'     => $mobile_col,
					'gap'        => 32,
					'gap_prefix' => 'gutter-'
				])
			]
		]);
		break;
}
// Output HTMl
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php 
	switch ($layout_mode) {
        case 'carousel':
    ?>
        <div class="cms-carousel swiper">
            <div class="swiper-wrapper">
    <?php
            break;
        case 'grid':
            break;
    }
		$count = 0;
		foreach ($fancy_boxs as $key => $fancy_box) { 
			$count++;
			// Item
			$item_key = $this->get_repeater_setting_key( 'item', 'cms_fancy_box', $key );
			$this->add_render_attribute( $item_key, [
				'class' => array_filter([
					'fancy-box-item relative',
					($layout_mode == 'carousel') ? 'cms-swiper-item swiper-slide' : 'cms-grid-item'
				])
			]);
			//
			$item_content_key = $this->get_repeater_setting_key( 'item-content', 'cms_fancy_box', $key );
			$this->add_render_attribute( $item_content_key, [
				'class' => array_filter([
					'cms-fancybox',
					'cms-fancybox-'.$settings['layout'],
					($layout_mode == 'grid') ? 'cms-transition elementor-invisible' : '',
					'p-40 p-lr-smobile-20',
					'bg-'.$this->get_setting('item_bg', 'bg-light')
				]),
				'data-settings' => wp_json_encode([
					'animation'       => 'fadeInRight',
					'animation_delay' => $key*100
				])
			]);
			//Title
			$title_key = $this->get_repeater_setting_key( 'item-title', 'cms_fancy_box', $key );
			$this->add_render_attribute( $title_key, [
				'class' => [
					'cms-title',
					'text-'.$this->get_setting('title_color','heading-regular'),
					'mb-n7'
				]
			]);
			// Description
			$desc_key = $this->get_repeater_setting_key( 'item-desc', 'cms_fancy_box', $key );
			$this->add_render_attribute( $desc_key, [
				'class' => [
					'cms-desc',
					'text-'.$this->get_setting('description_color','body'),
					'text-md',
					'pt-50 m-tb-n5',
					'empty-none'
				]
			]);
		?>
		<div <?php ctc_print_html($this->get_render_attribute_string($item_key)); ?>>
			<div <?php ctc_print_html($this->get_render_attribute_string($item_content_key)); ?>>
				<div class="d-flex gap-4 pb-15 text-xs" style="--cms-badge-color:white;--cms-badge-hover-color:white;">
					<div class="text-xs bg-accent-regular text-white bg-hover-primary-regular text-hover-white p-tb-2 p-lr-8 cms-transition"><?php 
						echo esc_html($fancy_box['job_type']);
					?></div>
					<div class="text-xs bg-white text-menu  bg-hover-primary-regular text-hover-white bdr-1 bdr-menu bdr-hover-primary-regular p-tb-2 p-lr-8 cms-transition"><?php 
						echo esc_html($fancy_box['job_add']);
					?></div>
				</div>
				<h6 <?php ctc_print_html( $this->get_render_attribute_string( $title_key ) ); ?>><?php 
					echo nl2br( $fancy_box['title'] ); 
				?></h6>
			    <div <?php ctc_print_html( $this->get_render_attribute_string( $desc_key ) ); ?>><?php 
			    	echo nl2br( $fancy_box['description'] ); 
			    ?></div>
			    <?php 
			    	genzia_elementor_link_render($this, $fancy_box, [
						'name'      => 'link1_',
						'loop'      => true,
						'loop_key'  => $key,
						'mode'      => 'btn',
						'text_icon' => genzia_svgs_icon([
							'icon'      => 'arrow-right',
							'icon_size' => 11,
							'echo'	 	=> false
						]),
						'class'     => [
							'mt-30',
							'cms-hover-move-icon-right'
						],
						'btn_prefix' 	   => 'btn-',
						'btn_hover_prefix' => 'btn-hover-',	
						'btn_color'        => $this->get_setting('btn_color','primary-regular'),
						'text_color'       => $this->get_setting('btn_text_color','white'),
						'btn_color_hover'  => $this->get_setting('btn_color_hover','accent-regular'),
						'text_color_hover' => $this->get_setting('btn_text_color_hover','white')
					]);
			    ?>
			</div>
		</div>
		<?php } ?>
	<?php //
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