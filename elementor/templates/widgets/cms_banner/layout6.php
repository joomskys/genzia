<?php
//wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-ebanner',
		'cms-ebanner-' . $settings['layout'],
		'relative',
		$this->get_setting('css_classes')
	]
]);
$img_class = genzia_nice_class([
	($settings['img_cover'] == 'yes') ? 'img-cover' : '',
	$this->get_setting('e_classes'),
	'mb-25'
]);
// Title
$this->add_render_attribute('title',[
	'class' => [
		'cms-title empty-none',
		'heading text-xl',
		'text-'.$this->get_setting('title_color', 'sub-text')
	]
]);
// Social
$icons = $this->get_setting('icons', []);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php
	// Banner
	genzia_elementor_image_render($settings, [
		'name'        => 'banner',
		'custom_size' => ['width' => 148, 'height' => 47],
		'img_class'   => $img_class
	]); ?>
	<div <?php ctc_print_html($this->get_render_attribute_string('title'));?>><?php ctc_print_html($settings['title']); ?></div>
	<div class="d-flex gap-8 pt-25">
		<?php
			foreach ( $icons as $key => $value ) {
				$_id = isset( $value['_id'] ) ? $value['_id'] : '';			
				$link_key = $this->get_repeater_setting_key( 'link', 'icons', $key );
				$this->add_render_attribute( $link_key, [
					'class' => [
						'cms-social-item',
						'elementor-repeater-item-' . $_id,
						'text-white',
						'text-hover-white',
						'cms-box-44',
						'bg-menu',
						'bg-hover-accent-regular'
					],
					'aria-label' => $value['title']
				]);
				$this->add_link_attributes( $link_key, $value['link'] );
		?>
		<a <?php ctc_print_html($this->get_render_attribute_string( $link_key )); ?>>
			<span class="screen-reader-text"><?php echo esc_html($value['title']); ?></span>
			<?php genzia_elementor_icon_render( $value['social_icon'], [], [ 'aria-hidden' => 'true', 'class' => 'cms-icon ', 'icon_size' => 20 ] ); ?>
		</a>
		<?php } ?>
	</div>
</div>