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
		'relative',
		'cms-accordion-wrap'
	]
]);
// Container
$this->add_render_attribute('overlay-box', [
	'class' => [
		'overlay-box',
		'bg-white cms-shadow-1',
		'absolute left-center z-top ml-container'
	],
	'style' => 'width:340px; max-width: calc(100% - 40px);'
]);
// Office Lists
$accordions = $this->get_settings('cms_accordion');
$active_section = $this->get_settings('active_section', 1);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php wealth_print_iframe([
		'src'        => esc_url( vsprintf( $map_url, $params ) ),
		'title'      => $settings['map_address'],
		'aria-label' => $settings['map_address']
	]); ?>
	<div <?php ctc_print_html($this->get_render_attribute_string('overlay-box')); ?>>
		<h6 class="cms-heading text-white p-tb-30 p-lr-40 p-lr-smobile-20 empty-none bg-primary-regular"><?php ctc_print_html($settings['title']); ?></h6>
		<div class="cms-accordion">
			<?php 
				foreach ( $accordions as $key => $value ):
					$is_active = ( $key + 1 ) == $active_section;
					$_id        = 'cms-accordion-'.$value['_id'];
					$ac_title   = isset( $value['ac_title'] ) ? $value['ac_title'] : '';
					$ac_content = isset( $value['ac_content'] ) ? $value['ac_content'] : '';
					// item
					$item_key = $this->get_repeater_setting_key( 'item_key', 'cms_accordion', $key );
					$this->add_render_attribute( $item_key, [
						'class' => [ 
							'cms-accordion-item',
							$is_active ? 'active' : '',
							'bdr-t-1 bdr-divider'
						]
					]);
					// item title
					$item_title_key = $this->get_repeater_setting_key( 'item_title', 'cms_accordion', $key );
					$this->add_render_attribute( $item_title_key, [
						'class' => [ 
							'cms-accordion-title',
							$is_active ? 'active' : '',
							'd-flex gap-30 gap-smobile-10 align-items-start',
							'p-tb p-lr-40 p-lr-smobile-20',
							'cms-hover-change',
							'text-'.$this->get_setting('title_color','primary'),
							'text-hover-'.$this->get_setting('title_active_color','accent'),
							'text-active-'.$this->get_setting('title_active_color','accent'),
							'plus-minus'
						],
						'data-target' => '#'.$_id,
						'style'       => '--p-tb:18px;'
					]);
					// title
					$title_key = $this->get_repeater_setting_key( 'ac_title', 'cms_accordion', $key );
					$this->add_render_attribute( $title_key, [
						'class' => [ 
							'cms-accordion-title-text',
							'flex-basic',
							'text-17 font-700'
						]
					] );
					// content
					$content_key = $this->get_repeater_setting_key( 'ac_content', 'cms_accordion', $key );
					$this->add_render_attribute( $content_key, [
						'id'    => $_id,
						'class' => [ 
							'cms-accordion-content',
							'text-'.$this->get_setting('content_color','body'),
							'text-md',
							'pb-25 p-lr-40 p-lr-smobile-20'
						] 
					] );
					if ( $is_active ) {
						$this->add_render_attribute( $content_key, 'style', 'display:block;' );
					}
					else{
						$this->add_render_attribute( $content_key, 'style', 'display:none;' );
					}
				?>
				<div <?php ctc_print_html( $this->get_render_attribute_string( $item_key ) ); ?>>
				    <div <?php ctc_print_html( $this->get_render_attribute_string( $item_title_key ) ); ?>>
				    	<span <?php ctc_print_html( $this->get_render_attribute_string( $title_key ) ); ?>><?php echo esc_html( $ac_title ); ?></span>
				    	<?php genzia_svgs_icon([
								'icon'      => 'core/chevron-up-down',
								'icon_size' => '10',
								'class'     => 'cms-acc-icon cms-transition text-white text-12 cms-box-26 circle bg-menu bg-on-hover-accent-regular bg-on-active-primary-regular'
				    	]) ?>
				    </div>
				    <div <?php ctc_print_html( $this->get_render_attribute_string( $content_key ) ); ?>>
						<?php echo nl2br( $ac_content ); ?>
					</div>
				</div>
				<?php
				endforeach;
			?>
		</div>
	</div>
</div>