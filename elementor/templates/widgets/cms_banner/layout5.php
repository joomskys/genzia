<?php 
//wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-ebanner', 
		'cms-ebanner-'.$settings['layout'],
		'd-flex gutter',
		'align-items-end'
	]
]);
$img_class = genzia_nice_class([
	($settings['img_cover'] == 'yes') ? 'img-cover' : '',
	$this->get_setting('e_classes'),
	'cms-radius-16',
	'elementor-invisible'
]);
// Large Heading
$this->add_inline_editing_attributes( 'heading_text' );
$this->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-title heading empty-none',
		'text-xl',
		'text-'.$this->get_setting('heading_color','sub-text'),
		'cms-nl2br',
		'elementor-invisible',
		'm-tb-nxl'
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
		'text-lg',
		'text-'.$this->get_setting('desc_color','body'),
		'cms-nl2br',
		'elementor-invisible',
		'pt-33'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div class="col-6 col-mobile-12"><?php 
		genzia_elementor_image_render($settings,[
			'name'        => 'banner',
			'custom_size' => ['width' => 656, 'height' => 576],
			'img_class'   => $img_class,
			'max_height'  => true,
			'before'	  => '<div class="relative d-inline-block pr-70 pr-tablet-0 w-100 pb" style="--pb:114px;--pb-mobile:0;">',
			'after'		  => '</div>',
			'attrs'		  => [
				'data-settings' => wp_json_encode([
					'animation' => 'fadeInLeft'
				])
			]
		]);
	?></div>
	<div class="col-6 col-mobile-12">
		<div class="max-w pl" style="--max-w:590px;--pl:170px;--pl-laptop:70px;--pl-tablet:0;">
			<div <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>><?php 
				echo nl2br( $settings['heading_text'] ); 
			?></div>
			<div <?php ctc_print_html( $this->get_render_attribute_string( 'desc' ) ); ?>><?php 
				echo nl2br( $settings['desc'] ); 
			?></div>
			<?php 
				// Button
				genzia_elementor_link_render($this, $settings, [
					'mode'			   => 'btn',
					'class'            => 'cms-heading-btn mt-33 cms-hover-change cms-hover-move-icon-right elementor-invisible',
					'btn_color'        => 'menu',
					'text_color'       => 'white',
					'btn_color_hover'  => 'accent-regular',
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
							'text-'.$this->get_setting('link__icon_color','menu'),
							'bg-hover-'.$this->get_setting('link__icon_bg_hover','white'),
							'bg-on-hover-'.$this->get_setting('link__icon_bg_hover','white'),
							'text-hover-'.$this->get_setting('link__icon_color_hover','menu'),
							'text-on-hover-'.$this->get_setting('link__icon_color_hover','menu')
						]),
						'echo' => false
					]),
					'attrs' => [
						'data-settings' => wp_json_encode([
							'animation' => 'fadeInUp'
						])
					]
				]);
			?>
		</div>
		<div class="text-end pt-mobile-extra-30"><?php
			genzia_elementor_image_render($settings,[
				'name'        => 'banner_small',
				'size'		  => 'custom',
				'custom_size' => ['width' => 280, 'height' => 280],
				'img_class'   => 'cms-radius-16 elementor-invisible',
				'max_height'  => true,
				'attrs'		  => [
					'data-settings' => wp_json_encode([
						'animation' => 'fadeInLeft'
					])
				]
			]);
		?></div>
	</div>
</div>