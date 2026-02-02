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
		'd-flex justify-content-between',
		'relative',
		'cms-shadow-2',
		'overflow-hidden'
	],
	'style' => 'min-height:512px;',
	//'data-px-throwable-scene' => true
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
$this->add_render_attribute( 'banner', [
	'class' => [
		'cms-banner empty-none',
		'align-self-end',
		'w-100',
		'text-md font-700',
		'relative'
	],
	'style' => 'height:210px;'
]);
$this->add_render_attribute( 'banner-inner', [
	'class' => [
		'cms--banner',
		'absolute bottom left right',
		'overflow-hidden'
	]
]);
// SEO
$seos = $this->get_setting('seo',[]);
// Output HTMl
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php 
		// Icon
		genzia_elementor_icon_render( $settings['item_icon'], [], ['class' => 'absolute top right mt-16 mr-16', 'icon_size' => 6, 'icon_color' => 'accent-regular'] );
	?>
	<div class="align-sefl-start relative p-40 w-100">
		<h6 <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php 
			echo nl2br($settings['title']);
		?></h6>
		<div <?php ctc_print_html($this->get_render_attribute_string('desc')); ?>><?php 
			echo nl2br($settings['description']);
		?></div>
	</div>
	<div <?php ctc_print_html($this->get_render_attribute_string('banner')); ?>>
			<?php 
			$count = 0;
			foreach ($seos as $seo_key => $seo) {
				$count++;
				$item_key = $this->get_repeater_setting_key('item', 'cms_theme_feature', $seo_key);
				$this->add_render_attribute($item_key, [
					'class' => [
						'item seo-item',
						'absolute top left',
						'elementor-repeater-item-' . $seo['_id'],
						'cms-parallax-mouse-move',
						'cms-transition'
					],
					'data-offset' => $count*10,
					'style'       => 'width:'.$seo['seo_dimentions']['size'].'px;height:'.$seo['seo_dimentions']['size'].'px;top:'.$seo['seo_ypos']['size'].'px;left:'.$seo['seo_xpos']['size'].'px;'
				]);
				//
				$item_inner_key = $this->get_repeater_setting_key('item-inner', 'cms_theme_feature', $seo_key);
				$this->add_render_attribute($item_inner_key, [
					'class' => [
						'item-inner',
						'cms-box- circle',
						'text-'.$seo['seo_color'],
						'bg-'.$seo['seo_bg'],
						($seo['seo_bg']=='white') ? 'bdr-1 bdr-divider' : '',
						'elementor-invisible'
					],
					'style'       => 'width:'.$seo['seo_dimentions']['size'].'px;height:'.$seo['seo_dimentions']['size'].'px;',
					'data-settings' => wp_json_encode([
						'animation' => 'fadeInDown',
						'animation_delay' => 100+($count*100)
					]),
					'data-width'  => $seo['seo_dimentions']['size'],
					'data-height' => $seo['seo_dimentions']['size']
				]);
			?>
			<div <?php ctc_print_html($this->get_render_attribute_string($item_key)); ?>>
				<div <?php ctc_print_html($this->get_render_attribute_string($item_inner_key)); ?>>
					<?php 
						echo esc_html($seo['seo_title']);
					?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>