<?php
// Wrap
$this->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-eprocess',
		'cms-eprocess-' . $settings['layout']
	])
]);
// Process Lists
$process = $this->get_setting('process_list2', []);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>><?php
  $count = 0;
  foreach ($process as $key => $_process) {
	  $count++;
	  // Items
  	$item_key = $this->get_repeater_setting_key('item_key', 'cms_process', $key);
	  $this->add_render_attribute($item_key, [
	  	'class' => [
	  		'cms-process',
	  		'elementor-invisible',
	  		'd-flex flex-nowrap gap',
	  		'align-items-start',
	  		'p-tb-20',
	  		'bdr-b-1 cms-border bdr-'.$this->get_setting('bdr_color','divider'),
	  		($count==1) ? 'bdr-t-1' : ''
	  	],
			'style'         => '--cms-gap:48px;--cms-gap-smobile:24px;',
			'data-settings' => wp_json_encode([
				'animation'       => 'fadeInUp'
	  	])
	  ]);
	  // Item Year
  	$year_key = $this->get_repeater_setting_key('year_key', 'cms_process', $key);
	  $this->add_render_attribute($year_key, [
	  	'class' => [
	  		'cms-year empty-none',
	  		'text-xs',
	  		'text-' . $this->get_setting('year_color', 'white'),
	  		'text-nowrap',
	  		'p-tb-2 p-lr-8',
	  		'bg-accent-regular',
	  		'd-flex flex-nowrap align-items-center gap-8'
	  	]
	  ]);
	  // Item Title
  	$title_key = $this->get_repeater_setting_key('title_key', 'cms_process', $key);
	  $this->add_render_attribute($title_key, [
	  	'class' => [
	  		'cms-pc-title empty-none',
	  		'text-md',
	  		'text-' . $this->get_setting('ptitle_color', 'sub-text')
	  	]
	  ]);
	  ?>
		<div <?php ctc_print_html($this->get_render_attribute_string($item_key)); ?>>
			<div <?php ctc_print_html($this->get_render_attribute_string($year_key)); ?>>
				<span class="cms-box-4 circle bg-white"></span>
				<?php 
				ctc_print_html($_process['year']);
			?></div>
			<div <?php ctc_print_html($this->get_render_attribute_string($title_key)); ?>><?php
			  ctc_print_html($_process['title']);
			?></div>
		</div>
	<?php } ?>
</div>