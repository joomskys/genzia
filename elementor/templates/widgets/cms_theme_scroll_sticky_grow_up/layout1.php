<?php 
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-scroll-sticky-grow-up',
		'text-center'
	],
	'style' => ['height:300vh']
]);
// Wrap Inner
$this->add_render_attribute('wrap-inner',[
	'class' => [
		'cms-scroll-sticky--grow-up',
		'cms-sticky',
		'overflow-hidden',
		'd-flex align-items-center justify-content-center',
	],
	'style' => 'height:100vh;--cms-sticky:0;'
]);
// Scroll Sticky
$this->add_render_attribute('scroll-sticky',[
	'class' => [
		'cms-scroll-sticky---grow-up',
		'overflow-hidden',
		'absolute center'
	],
	'style' => [
		'width:600px;',
		'height:400px;'
	]
]);
// Large Heading
$this->add_inline_editing_attributes( 'heading_text', 'none' );
$this->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-heading empty-none',
		'text-'.$this->get_setting('heading_color','heading'),
		'lh-107',
		'text-3xl',
		'absolute center',
		'cms-scroll-sticky--show'
	],
	'style' => [
		'width:1216px;max-width:calc(100vw - 32px);'
	]
]);
$this->add_render_attribute( 'heading_text2', [
	'class' => [
		'cms-heading empty-none',
		'text-'.$this->get_setting('heading_color','white'),
		'text-mixed2',
		'lh-107',
		'text-3xl',
		'absolute center z-top',
		'cms-scroll-sticky--show'
	],
	'style' => [
		'width:1216px;max-width:calc(100vw - 32px);'
	]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div <?php ctc_print_html($this->get_render_attribute_string('wrap-inner')); ?>>
		<h2 <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
		<div <?php ctc_print_html($this->get_render_attribute_string('scroll-sticky')); ?>>
			<?php 
				genzia_elementor_image_render($settings,[
					'name'                => 'banner',
					'size'				  => 'custom',
					'custom_size'         => ['width' => 864, 'height' => 576],
					'img_class'			  => 'img-cover'
				]);
			?>
			<h2 <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text2' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
		</div>
	</div>
</div>