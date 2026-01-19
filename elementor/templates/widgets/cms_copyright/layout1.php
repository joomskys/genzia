<?php 
$current_year = date('Y');
$theme_name = get_bloginfo('name');
// wrap
$this->add_inline_editing_attributes('copyright_text');
$this->add_render_attribute('copyright_text',[
	'class' => [
		'cms-ecopyright cms-ecopyright-'.$settings['layout'],
		'text-'.$this->get_setting('text_color','body')
	]
]);
$link_color = 'text-'.$this->get_setting('link_color', 'primary-regular');
$link_color_hover = 'text-'.$this->get_setting('link_color_hover', 'accent-regular');
$link_class = '<a aria-label="'.get_bloginfo('name').'" class="'.$link_color.' '.$link_color_hover.' cms-hover-underline ';

$copyright_text = $this->get_settings('copyright_text');
$copyright_text = str_replace(['[[year]]','[[name]]'], [$current_year, $theme_name], $copyright_text);
$copyright_text = str_replace('<a class="', $link_class, $copyright_text);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('copyright_text')); ?>>
<?php
	ctc_print_html($copyright_text); 
?>
</div>