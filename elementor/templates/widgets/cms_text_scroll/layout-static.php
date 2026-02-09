<?php 
$overflow = $this->get_setting('overflow');
// wrap
$this->add_render_attribute('wrap', [
	'class' => array_filter([
		'heading',
		'text-'.$this->get_setting('text_color', 'divider'),
		'text-hover-'.$this->get_setting('text_color_hover', 'divider'),
		($overflow=='yes')?'overflow-hidden':'',
		'text-size font-500 lh-07',
		'm-tb',
		'd-flex gap',
		'text-nowrap',
		'cms-transition'
	]),
	'style' => [
		'--m-tb:-0.9445rem;--text-size:384px;--text-size-tablet:250px;--text-size-mobile:160px',
		'--cms-gap:'.$this->get_setting('spaceBetween', 40).'px;'
	]
]);
$cms_texts = $this->get_setting('cms_texts', []);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php foreach ($cms_texts as $key => $value) { ?>
		<div class="cms-text-scroll-item" data-title="<?php echo esc_html($value['text']); ?>">
			<div class="text empty-none"><?php echo nl2br($value['text']); ?></div>
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