<?php
	if ( empty( $settings['map_address'] ) ) {
		return;
	}
	if ( 0 === absint( $settings['zoom']['size'] ) ) {
		$settings['zoom']['size'] = 10;
	}
	$api_key = genzia_get_opt('gm_api_key');;
	$params = [
		rawurlencode( $settings['map_address'] ),
		absint( $settings['zoom']['size'] ),
	];
	if ( $api_key ) {
		$params[] = $api_key;
		$map_url = 'https://www.google.com/maps/embed/v1/place?key=%3$s&q=%1$s&amp;zoom=%2$d';
	} else {
		$map_url = 'https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;output=embed&amp;iwloc=near';
	}
// Wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-egmap',
		'cms-egmap-'.$settings['layout'],
		'relative'
	]
]);
// Container
$this->add_render_attribute('overlay-box', [
	'class' => [
		'overlay-box',
		'bg-white cms-shadow-2',
		'p-40 p-lr-smobile-20',
		'absolute left-center z-top ml-container'
	],
	'style' => 'width:360px; max-width: calc(100% - 40px);'
]);
// Office Lists
$timetable = $this->get_settings('cms_timetable');
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php wealth_print_iframe([
		'src'        => esc_url( vsprintf( $map_url, $params ) ),
		'title'      => $settings['map_address'],
		'aria-label' => $settings['map_address']
	]); ?>
	<div <?php ctc_print_html($this->get_render_attribute_string('overlay-box')); ?>>
		<h6 class="cms-heading empty-none pb-10 mt-n7"><?php ctc_print_html($settings['title']); ?></h6>
		<div class="pb-15 text-md">
			<?php echo esc_html($settings['map_address_title'].' '.$settings['map_address']); ?>
		</div>
		<div class="cms-timetable text-sm">
			<?php 
				foreach ( $timetable as $key => $value ):
					$time_title = isset( $value['time_title'] ) ? $value['time_title'] : '';
					$time_value = isset( $value['time_value'] ) ? $value['time_value'] : '';
					// item
					$item_key = $this->get_repeater_setting_key( 'item_key', 'cms_timetable', $key );
					$this->add_render_attribute( $item_key, [
						'class' => [ 
							'cms-timetable-item',
							'd-flex gap-30 gap-smobile-10',
							'justify-content-between',
							'p-tb-15',
							($key>0)?'bdr-t-1 bdr-divider' : ''
						]
					]);
					// title
					$title_key = $this->get_repeater_setting_key( 'time_title', 'cms_timetable', $key );
					$this->add_render_attribute( $title_key, [
						'class' => [ 
							'cms-time-title',
							'text-'.$this->get_setting('title_color','body')
						]
					] );
					// content
					$content_key = $this->get_repeater_setting_key( 'time_value', 'cms_timetable', $key );
					$this->add_render_attribute( $content_key, [
						'class' => [ 
							'cms-time-value',
							'text-'.$this->get_setting('content_color','body')
						] 
					] );
				?>
				<div <?php ctc_print_html( $this->get_render_attribute_string( $item_key ) ); ?>>
				    <span <?php ctc_print_html( $this->get_render_attribute_string( $title_key ) ); ?>>
				    	<?php echo esc_html( $time_title ); ?>
				    </span>
				    <span <?php ctc_print_html( $this->get_render_attribute_string( $content_key ) ); ?>>
						<?php echo nl2br( $time_value ); ?>
					</span>
				</div>
				<?php
				endforeach;
			?>
		</div>
		<a href="<?php echo esc_url(vsprintf( $map_url, $params )) ?>" target="_blank" class="cms-btn btn-menu text-white btn-hover-accent-regular text-hover-white cms-hover-change w-100 mt-20"><?php echo esc_html($settings['direction_text']) ?></a>
	</div>
</div>