<?php 
$overflow = $this->get_setting('overflow');
// wrap
$this->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-swiper-container swiper-container',
		'cms-text-scroll',
		'heading',
		'text-'.$this->get_setting('text_color', 'divider'),
		'text-2xl lh-09',
		($overflow=='yes')?'overflow-hidden':''
	]),
	'data-direction'            => $this->get_setting('direction', 'false'),
	'data-speed'                => $this->get_setting('speed', 4000),
	'data-spacebetween'         => $this->get_setting('spaceBetween', 40),
	'data-hoverpause'           => 'no',
	'data-disableoninteraction' => 'yes',
	'data-loop'                 => 'yes'
]);
$cms_texts = $this->get_setting('cms_texts', []);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div class="cms-swiper-wrapper swiper-wrapper">
		<?php foreach ($cms_texts as $key => $value) { ?>
			<div class="cms-swiper-slide swiper-slide" data-title="<?php echo esc_html($value['text']); ?>">
				<div class="relative lh-0"><?php
					genzia_elementor_image_render($value, [
						'name'           => 'banner',
						'image_size_key' => 'banner',
						'size'			 => 'full'
					]);
					genzia_elementor_video_background_render($widget, $settings, [
	                    'url'      => $value['banner_video'], 
	                    'loop'     => true, 
	                    'loop_key' => $key,
	                    'class'    => 'cms-overlay elementor-repeater-item-' . $value['_id'],
	                    'fit'      => false 
	                ]);
				?></div>
			</div>
		<?php } ?>
	</div>
</div>