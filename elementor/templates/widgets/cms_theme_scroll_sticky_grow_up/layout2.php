<?php 
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-scroll-sticky-grow-up',
		'text-center'
	]
]);
// Wrap Inner
$this->add_render_attribute('wrap-inner',[
	'class' => [
		'cms-scroll--sticky-grow-up',
		'd-flex justify-content-center',
		'relative'
	]
]);
// Scroll Sticky
$this->add_render_attribute('scroll-sticky',[
	'class' => [
		'cms-scroll--sticky',
		'relative overflow-hidden'
	],
	'style' => [
		'width:864px;',
		'max-width:100vw;',
		'height:576px;'
	]
]);
// Wrap Text
$this->add_render_attribute('wrap-text', [
	'class' => [
		'absolute',
		'lh-09 text-size',
		'text-'.$this->get_setting('heading_color','heading-regular'),
	],
	'style' => [
		'top:50%; left:50%;transform: translate(-50%, -50%) scale(1.3);',
		'--text-size:168px;--text-size-tablet:136px;--text-size-mobile:80px;'
	]
]);
$this->add_render_attribute('wrap-text2', [
	'class' => [
		'absolute z-top',
		'lh-09 text-size',
		'text-'.$this->get_setting('heading_color2','white'),
		'text-mixed2'
	],
	'style' => [
		'top:50%; left:50%;transform: translate(-50%, -50%) scale(1.3);',
		'--text-size:168px;--text-size-tablet:136px;--text-size-mobile:80px;'
	]
]);
// Large Heading
$this->add_inline_editing_attributes( 'heading_text', 'none' );
$this->add_render_attribute( 'heading_text', [
	'class' => [
		'heading empty-none'
	],
	'style' => [
		'width:1216px;max-width:calc(100vw - 32px);'
	],
	'data-parallax' => wp_json_encode(['z' => '-600'])
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div <?php ctc_print_html($this->get_render_attribute_string('wrap-inner')); ?>>
		<div <?php ctc_print_html($this->get_render_attribute_string('wrap-text')); ?>>
			<div <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></div>
		</div>
		<div <?php ctc_print_html($this->get_render_attribute_string('scroll-sticky')); ?>>
			<?php 
				genzia_elementor_image_render($settings,[
					'name'                => 'banner',
					'size'				  => 'custom',
					'custom_size'         => ['width' => 864, 'height' => 576],
					'img_class'			  => 'img-cover',
					'attrs'				  => [
						'data-parallax' => wp_json_encode([
							'y'           => '-80',
							//'from-scroll' => '200vh'
						])
					],
					'before'     => '<div class="cms-translateY" style="--cms-translateY:80px;">',
					'after'      => '</div>',
					'min_height' => true
				]);
			?>
			<div <?php ctc_print_html($this->get_render_attribute_string('wrap-text2')); ?>>
				<div <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></div>
			</div>
		</div>
	</div>
</div>