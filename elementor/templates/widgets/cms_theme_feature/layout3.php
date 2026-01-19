<?php
$galleries = $this->get_setting('gallery',[]);
$bdr_color = $this->get_setting('item_bdr_color', 'divider');
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-genzia-features',
		'cms-genzia-features-'.$settings['layout'],
		'bg-white',
		'bdr-1 bdr-'.$bdr_color,
		'cms-radius-16',
		'p-tb-40 p-lr-38',
		'd-flex flex-column justify-content-between',
		'relative',
		'cms-shadow-2'
	],
	'style' => 'min-height:512px;'
]);
//Title
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-title heading empty-none',
		'text-'.$this->get_setting('title_color','heading-regular'),
		'h6 mt-nh6',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// Description
$this->add_render_attribute( 'desc', [
	'class' => [
		'cms-desc empty-none',
		'text-'.$this->get_setting('description_color','body'),
		'text-md',
		'pt-10',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// Testimonial
$this->add_render_attribute('ttm-wrap',[
	'class' => [
		'cms-feature-ttmn',
		'relative',
		'text-sm text-sub-text',
		'align-self-end'
	]
]);
// Output HTMl
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php 
		// Icon
		genzia_elementor_icon_render( $settings['item_icon'], [], ['class' => 'absolute top right mt-16 mr-16', 'icon_size' => 6, 'icon_color' => 'accent-regular'] );
	?>
	<div class="align-sefl-start relative">
		<h6 <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php 
			echo nl2br($settings['title']);
		?></h6>
		<div <?php ctc_print_html($this->get_render_attribute_string('desc')); ?>><?php 
			echo nl2br($settings['description']);
		?></div>
	</div>
	<div <?php ctc_print_html($this->get_render_attribute_string('ttm-wrap')); ?>>
		<div class="cms-feature-rate text-warning pb-5 d-flex gap-5"><?php 
			genzia_svgs_icon(['icon' => 'core/star', 'icon_size' => 12]);
			genzia_svgs_icon(['icon' => 'core/star', 'icon_size' => 12]);
			genzia_svgs_icon(['icon' => 'core/star', 'icon_size' => 12]);
			genzia_svgs_icon(['icon' => 'core/star', 'icon_size' => 12]);
			genzia_svgs_icon(['icon' => 'core/star', 'icon_size' => 12]);
		?></div>
		<?php echo esc_html($settings['ttmn']); ?>
		<div class="d-flex gap-8 align-items-center text-xs pt-15">
			<?php 
				// Avatar
				genzia_elementor_image_render($settings,[
					'name'        => 'ttmn_avatar',
					'size'        => 'custom',
					'custom_size' => ['width' => 32, 'height' => 32],
					'img_class'	  => 'circle'
				]);
			?>
			<div class="heading font-700 text-heading-regular">
				<?php echo esc_html($settings['ttmn_name']); ?>
				<span class="font-400"><?php echo esc_html($settings['ttmn_pos']); ?></span>
			</div>
		</div>
	</div>
</div>