<?php
$icons = $this->get_setting('icons', []);
//wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-social-icons',
		'cms-social-icons-'.$settings['layout'],
		genzia_elementor_get_responsive_class($widget, $settings, [
			'name' 		   => 'align',
			'prefix_class' => 'justify-content-',
			'class'		   => 'd-flex align-items-center gap-'.$this->get_setting('gap', 15)
		])
	]
]);
// Description
$this->add_render_attribute('desc', [
	'class' => [
		'cms-desc empty-none',
		'text-'.$this->get_setting('desc_color', 'body'),
		'mb-25'
	]
]);
// Banner
genzia_elementor_image_render($settings,[
	'name'        => 'banner',
	'custom_size' => ['width' => 135, 'height' => 32],
	'img_class'   => 'mb-25'
]);
if(!empty($settings['desc'])){
?>
<div <?php ctc_print_html($this->get_render_attribute_string('desc')); ?>><?php 
	echo nl2br($settings['desc']);
?></div>
<?php } ?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php
		foreach ( $icons as $key => $value ) {
			$_id = isset( $value['_id'] ) ? $value['_id'] : '';			
			$link_key = $this->get_repeater_setting_key( 'link', 'icons', $key );
			$this->add_render_attribute( $link_key, [
				'class' => [
					'cms-social-item d-flex align-items-center gap-10',
					'elementor-repeater-item-' . $_id,
					'text-'.$this->get_setting('icon_color','menu'),
					'text-hover-'.$this->get_setting('icon_color_hover','accent-regular'),
					'cms-hover-change'
				]
			]);
			$this->add_link_attributes( $link_key, $value['link'] );

			$title_key = $this->get_repeater_setting_key( 'title', 'icons', $key );
			$this->add_render_attribute($title_key, [
				'class' => [
					'cms-title',
					'text-'.$this->get_setting('title_color','menu'),
					'text-on-hover-'.$this->get_setting('icon_color_hover','accent-regular'),
					genzia_add_hidden_device_controls_render($settings, 'title_')
				]
			]);
			$this->add_inline_editing_attributes($title_key);
	?>
	<a <?php ctc_print_html($this->get_render_attribute_string( $link_key )); ?>>
		<span class="screen-reader-text"><?php echo esc_html($value['title']); ?></span>
		<?php genzia_elementor_icon_render( $value['social_icon'], [], [ 'aria-hidden' => 'true', 'class' => 'cms-icon ', 'icon_size' => 20 ] ); ?>
		<?php if ( 'yes' === $settings['show_title'] ) { ?><span <?php ctc_print_html($this->get_render_attribute_string( $title_key )); ?>><?php echo esc_html($value['title']); ?></span><?php } ?>
	</a>
	<?php } ?>
</div>