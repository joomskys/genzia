<?php
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
// Description
$this->add_inline_editing_attributes( 'desc' );
$this->add_render_attribute( 'desc', [
	'class' => [
		'cms-desc empty-none',
		'heading text-lg',
		'text-'.$this->get_setting('desc_color','sub-text'),
		'cms-nl2br',
		'elementor-invisible',
		'pt-35'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 200
	])
]);
?>
<h2 <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>><?php 
	echo nl2br( $settings['heading_text'] ); 
?></h2>
<div <?php ctc_print_html( $this->get_render_attribute_string( 'desc' ) ); ?>><?php 
	echo nl2br( $settings['desc'] ); 
?></div>
<?php 
	// Button
	genzia_elementor_link_render($this, $settings, [
		'mode'			   => 'btn',
		'class'            => 'cms-heading-btn mt-33 cms-hover-change cms-hover-move-icon-right',
		'btn_color'        => 'accent-regular',
		'text_color'       => 'white',
		'btn_color_hover'  => 'menu',
		'text_color_hover' => 'white',
		// Icons
		'text_icon' => genzia_svgs_icon([
			'icon'       => 'arrow-right',
			'icon_size'  => 10,
			'icon_class' =>  genzia_nice_class([
				'cms-eicon cms-btn-icon',
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
		'before' => '<div class="clearfix"></div>'
	]);
?>