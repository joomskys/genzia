<?php 
// Progress Bar
$progressbar_list = $this->get_setting('progressbar_list', []);
$this->add_render_attribute('progressbar-wrap', [
	'class' => [
		'cms-eprogress-bar',
		'cms-eprogress-bar-'.$settings['layout']
	],
	'style' => '--cms-progress-bg:var(--cms-'.$this->get_setting('pbar_bg', 'divider').');'
]);
$progressbar_h = $this->get_setting('pbar_height', 8);
//
$this->add_render_attribute('cms-progress-bar-wrap', [
	'class' => [
		'cms-progress-bar-wrap',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('progressbar-wrap')); ?>>
	<?php 
		$count = 0;
		foreach ( $progressbar_list as $key => $progressbar ):
			$count++;
			$title_key         = $this->get_repeater_setting_key( 'title', 'progressbar_list', $key );
			$wrapper_key       = $this->get_repeater_setting_key( 'wrapper', 'progressbar_list', $key );
			$progress_bar_key  = $this->get_repeater_setting_key( 'progress_bar', 'progressbar_list', $key );
			$progressbar_color = !empty($progressbar['color']) ? $progressbar['color'] : 'accent-regular';
			$this->add_inline_editing_attributes( $title_key );
			$this->add_render_attribute( $title_key, [
				'class'=>[
					'cms-progress-bar-title',
					'text-sm font-600 heading',
					'text-'.$this->get_setting('ptitle_color','heading-regular'),
					'd-flex justify-content-between no-wrap',
					'pb-5',
					($count == 1) ? '' : 'pt-25'
				],
				'style' => 'width:'.$progressbar['percent']['size'].'%'
			]);

			$this->add_render_attribute( $wrapper_key, [
				'class'         => 'cms-progress-wrap cms-progress-wrap-w',
				'role'          => 'progressbar',
				'aria-valuemin' => '0',
				'aria-valuemax' => '100',
				'aria-valuenow' => $progressbar['percent']['size'],
				'style'		    => '--height:'.$progressbar_h.'px'
			] );
			
			$this->add_render_attribute( $progress_bar_key, [
				'class'      => [
					'cms-progress-bar cms-progress-bar-w bg-'.$progressbar_color,
					'elementor-repeater-item-'.$progressbar['_id']
				],
				'data-width' => $progressbar['percent']['size'],
				'style'		 => '--height:'.$progressbar_h.'px'
			] );
		?>
		<div <?php ctc_print_html($this->get_render_attribute_string('cms-progress-bar-wrap')); ?>>
			<?php if ( ! empty( $progressbar['title'] ) ) { ?>
	            <div <?php ctc_print_html( $this->get_render_attribute_string( $title_key ) ); ?>>
	            	<?php echo esc_html( $progressbar['title'] ); ?>
	            	<span class="cms-progress-barnumber text-sm"><span class="cms-progress-bar-number" data-duration="2000" data-delimiter="" data-to-value="<?php echo esc_attr($progressbar['percent']['size']); ?>"></span>%</span>	
	            </div>
			<?php } ?>
	        <div <?php ctc_print_html( $this->get_render_attribute_string( $wrapper_key ) ); ?>>
	            <div <?php ctc_print_html( $this->get_render_attribute_string( $progress_bar_key ) ); ?>></div>
	        </div>
        </div>
	<?php endforeach; ?>
</div>