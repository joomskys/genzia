<?php 
$download_lists = $this->get_setting('download_lists', []);
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-edownload',
		'cms-edownload-'.$settings['layout'],
		'p-40 p-lr-tablet-20',
		'bg-bg-light'
	]
]);
// Title
$this->add_inline_editing_attributes('title');
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-title h6 empty-none',
		'text-'.$this->get_setting('title_color', 'heading-regular'),
		'pb-30 m-tb-n5'
	]
]);
// Items
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div <?php ctc_print_html($this->get_render_attribute_string('title')) ?>><?php echo nl2br($settings['title']); ?></div>
	<div class="cms-download-list"><?php
		$count = 0;
		foreach ($download_lists as $key => $download) {
			$count++;
			$download_key = $this->get_repeater_setting_key( 'link', 'cms_download_link', $key );
			$download_file = isset( $download['link']['url'] ) ? $download['link']['url'] : '#';
			//$divider_color = ($download['divider_color']!='custom')?'var(--cms-'.$download['divider_color'].')':$download['divider_color_custom'];
			$this->add_render_attribute($download_key, [
				'class' => [
					'cms-dowload-item',
					'elementor-repeater-item-' . $download['_id'],
					'd-flex flex-nowrap',
					'text-md font-500',
					'text-'.$download['name_color'],
					'text-hover-'.$download['name_color_hover'],
					'cms-hover-change',
					'bg-'.$download['item_bg'],
					'bg-hover-'.$download['item_bg_hover'],
					'p-24',
					($key>0) ? 'mt-12' : ''
				],
				'href'       => $download_file,
				'aria-label' => $download['name'],
				//'style'      => '--cms-bdr-custom:'.$divider_color.';'
			]);
			// icon 
			$icon_classes = [
				'cms-icon flex-auto cms-transition', 
				//'text-'.$download['icon_img_color'],
				//'text-hover-'.$download['icon_img_color_hover'],
				'text-on-hover-'.$download['icon_img_color_hover'],
				'pr-20',
				'bdr-r-1 bdr-'.$download['divider_color']
			];
			// Name #2
			$name2_key = $this->get_repeater_setting_key('name2', 'cms_download_link', $key);
			$this->add_render_attribute($name2_key, [
				'class' => [
					'cms-dname2',
					'text-'.$download['name2_color'],
					'text-sm font-400',
					'w-100',
					'empty-none'
				]
			]);
    ?>
    	<a <?php ctc_print_html($this->get_render_attribute_string($download_key)) ?>><?php 
    		//icon
    		genzia_elementor_icon_image_render($widget, $settings, [ 
					'aria-hidden' => 'true', 
					'class'       => genzia_nice_class($icon_classes),
					'img_size'	  => 'custom', 
					'size'        => 20,
					'custom_size' => ['width' => 20, 'height' => 20],
					'color'		  => $download['icon_img_color'],
					'color_hover' => $download['icon_img_color_hover'],
					//'before'	  => '<div class="'.genzia_nice_class($icon_classes).'">',
					//'after'		  => '</div>'
    			],
    			$download
    		);
    		?>
	    	<div class="flex-basic d-flex align-items-center pl-20"><?php
	    		//text
	    		ctc_print_html('<div class="cms-dname w-100 empty-none">'.$download['name'].'</div>');
	    		// Text 2
	    		ctc_print_html('<div '.$this->get_render_attribute_string($name2_key).'>'.$download['name2'].'</div>');
	    	?></div>
	    </a>
  <?php
		}
	?></div>
</div>