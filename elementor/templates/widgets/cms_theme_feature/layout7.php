<?php
// Awards
$awards = $this->get_setting('awards',[]);
//
$bdr_color = $this->get_setting('item_bdr_color', 'divider');
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-genzia-features',
		'cms-genzia-features-'.$settings['layout'],
		'bdr-t-1 bdr-'.$bdr_color
	]
]);
// Output HTMl
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php 
	$count = 0;
	foreach ($awards as $key => $award) { 
		if(empty($award['awards_link']['url'])) {
			$tag = 'div';
		} else {
			$tag = 'a';
		}
		//
		$count++;
		//
		$item_key = $this->get_repeater_setting_key('item', 'cms_theme_feature', $key);
		$this->add_render_attribute($item_key, [
			'class' => [
				'cms-genzia-fitem',
				'bdr-b-1 bdr-'.$bdr_color,
				'cms-hover-change',
				'bg-hover-accent-regular',
				'p-lr-hover-24',
				'p-tb-15',
				'overflow-hidden',
				'cms-transition',
				'text-md',
				'd-block',
				'elementor-invisible'
			],
			'data-settings' => wp_json_encode([
				'animation' => 'fadeInUp'
			])
		]);
		$this->add_link_attributes($item_key, $award['awards_link']);
		// Count
		$item_count = $this->get_repeater_setting_key('item-count', 'cms_theme_feature', $key);
		$this->add_render_attribute($item_count, [
			'class' => [
				'fitem-count col-2 col-mobile-auto',
				'text-body',
				'text-hover-on-dark',
				'text-on-hover-on-dark',
				'order-mobile-first'
			]
		]);
		// Title
		$item_title = $this->get_repeater_setting_key('item-title', 'cms_theme_feature', $key);
		$this->add_render_attribute($item_title, [
			'class' => [
				'fitem-title heading col-5 col-mobile-12',
				'text-xl',
				'text-heading-regular',
				'text-hover-white',
				'text-on-hover-white'
			]
		]);
		// Description
		$item_desc = $this->get_repeater_setting_key('item-desc', 'cms_theme_feature', $key);
		$this->add_render_attribute($item_desc, [
			'class' => [
				'fitem-desc col-4 col-mobile-12',
				'text-body',
				'text-hover-on-dark',
				'text-on-hover-on-dark'
			]
		]);
		// Year
		$item_year = $this->get_repeater_setting_key('item-year', 'cms_theme_feature', $key);
		$this->add_render_attribute($item_year, [
			'class' => [
				'fitem-year col-1 col-mobile-auto',
				'text-end text-mobile-start',
				'text-heading-regular',
				'text-hover-white',
				'text-on-hover-white',
				'text-nowrap',
				'order-mobile-first'
			]
		]);
	?> 
		<<?php ctc_print_html($tag.' '.$this->get_render_attribute_string($item_key)); ?>>
			<div class="d-flex gutter gutter-mobile-10 align-items-center">
				<div <?php ctc_print_html($this->get_render_attribute_string($item_count)); ?>>
					(<?php echo genzia_leading_zero($count, ['number' => 3]); ?>)
				</div>
				<div <?php ctc_print_html($this->get_render_attribute_string($item_title)); ?>><?php echo $award['awards_title']; ?></div>
				<div <?php ctc_print_html($this->get_render_attribute_string($item_desc)); ?>><?php  echo $award['awards_desc']; ?></div>
				<div <?php ctc_print_html($this->get_render_attribute_string($item_year)); ?>><?php  echo $award['awards_year']; ?></div>
			</div>
		</<?php ctc_print_html($tag);?>>
	<?php } ?>
</div>