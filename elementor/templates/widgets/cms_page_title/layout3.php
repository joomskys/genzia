<?php
$default_align = 'center';
// Render Background Image
if(!empty($settings['bg_image']['id'])){
	$background_img = 'url('.$settings['bg_image']['url'].')';
} elseif(get_the_post_thumbnail_url('', 'full')) {
	$background_img = 'url('.get_the_post_thumbnail_url('', 'full').')';
} else {
	$background_img = 'var(--cms-ptitle-bg-image)';
}
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-eptitle',
		'cms-eptitle-'.$settings['layout'],
		'cms-gradient-render cms-gradient-'.$this->get_setting('bg_overlay', 1),
		'text-'.$default_align,
		'text-white',
        'cms-bg-parallax',
		'cms-lazy'
	],
	'style' => [
		'--cms-bg-lazyload:'.$background_img.';background-image:var(--cms-bg-lazyload-loaded);'
	]
]);
// Container
$this->add_render_attribute('container',[
	'class' => [
		'cms-content container',
		'relative z-top2',
		'd-flex justify-content-'.$default_align
	]
]);
// Content
$content_width = !empty($settings['content_width']['size']) ? $settings['content_width']['size'] : '100%';
$this->add_render_attribute('cms--content',[
	'class' => [
		'cms--content',
		'max-w',
		'pt pb'
	],
	'style' => [
		'--max-w:'.$content_width.'px;',
		'--pt:calc(137px + var(--cms-wrap-header-height, 0px));',
		'--pt-tablet:calc(60px + var(--cms-wrap-header-height, 0px));',
		'--pb:145px;--pb-tablet:65px;'
	]
]);
// Title
$this->add_inline_editing_attributes('title');
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-nl2br lh-107',
		'cms-title',
		'text-'.$this->get_setting('title_color','white'),
		'empty-none',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 300
	]),
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div <?php ctc_print_html($this->get_render_attribute_string('container')); ?>>
		<div <?php ctc_print_html($this->get_render_attribute_string('cms--content')); ?>>
			<h1 <?php ctc_print_html( $this->get_render_attribute_string( 'title' ) ); ?>><?php 
				echo nl2br( $this->get_setting('title', get_the_title()) ); 
			?></h1>
		</div>
	</div>
</div>