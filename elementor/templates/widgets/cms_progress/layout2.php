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

$this->add_render_attribute('cms-progress-bar-wrap', [
	'class' => [
		'cms-progress-bar-wrap',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// Title
$this->add_render_attribute('title', [
	'class' => [
		'cms-title cms-heading',
		'empty-none',
		'text-'.$this->get_setting('title_color','heading-regular'),
		'm-tb-n10',
		'pb-30'
	]
]);
// Description
$this->add_render_attribute('text',[
	'class' => [
		'cms-desc',
		'text-mobile-16',
		'text-'.$this->get_setting('text_color','body'),
		'empty-none',
		'm-tb-n7',
		'pb-40'
	]
]);
?>
<h2 <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php 
	echo nl2br($settings['title']);
?></h2>
<div <?php ctc_print_html($this->get_render_attribute_string('text')); ?>><?php 
	echo nl2br($settings['text']);
?></div>
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
					'cms-progress-bar-title heading',
					'text-'.$this->get_setting('ptitle_color','heading-regular'),
					'text-sm font-600',
					'd-flex justify-content-between no-wrap',
					'pb-5',
					($count == 1) ? '' : 'pt-25'
				],
				'style' => 'width:'.$progressbar['percent']['size'].'%'
			]);
			$this->add_render_attribute( $wrapper_key, [
				'class'         => 'cms-progress-wrap cms-progress-wrap-w flex-basic',
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
			// Number
			$number_key         = $this->get_repeater_setting_key( 'number', 'progressbar_list', $key );
			$this->add_render_attribute( $number_key, [
				'class'=>[
					'cms-progress-barnumber',
					'text-sm lh-1',
					'text-'.$this->get_setting('ptitle_color','heading-regular')
				]
			]);
		?>
		<div <?php ctc_print_html($this->get_render_attribute_string('cms-progress-bar-wrap')); ?>>
			<?php if ( ! empty( $progressbar['title'] ) ) { ?>
	            <div <?php ctc_print_html( $this->get_render_attribute_string( $title_key ) ); ?>>
	            	<?php echo esc_html( $progressbar['title'] ); ?>
	            </div>
			<?php } ?>
			<div class="d-flex gap-15 flex-nowap align-items-center">
		        <div <?php ctc_print_html( $this->get_render_attribute_string( $wrapper_key ) ); ?>>
		            <div <?php ctc_print_html( $this->get_render_attribute_string( $progress_bar_key ) ); ?>></div>
		        </div>
		        <div <?php ctc_print_html( $this->get_render_attribute_string( $number_key ) ); ?>>
		        	<?php echo esc_html($progressbar['prefix']) ?><span class="cms-progress-bar-number" data-duration="2000" data-delimiter="" data-to-value="<?php echo esc_attr($progressbar['percent']['size']); ?>"></span><?php echo esc_html($progressbar['suffix']) ?>
		        </div>	
		    </div>
        </div>
	<?php endforeach; ?>
</div>
<?php if(!empty($settings['gallery'])) { ?>
	<div class="cms-progressbar-gallery text-accent-regular pt" style="--pt:95px;--pt-mobile:50px;">	
		<div class="cms-video--gallery flex-auto d-flex">
			<?php 
				foreach ( $settings['gallery'] as $key => $value){
					$value['gallery_size'] = 'thumbnail';
					$value['gallery'] = $value;
					genzia_elementor_image_render($value,[
						'name'        => 'gallery', 
						'img_class'   => genzia_nice_class([
							'circle',
							($key > 0) ? 'ml-n8' : ''
						]),
						'attrs'		  => [
							'style' => 'max-width:56px;'
						]	
					]);
				}
				genzia_svgs_icon([
					'icon'      => 'plus',
					'icon_size' => 14,
					'class'     => 'cms-box-56 circle ml-n8 bg-accent-regular text-menu'		
				]);
			?>
		</div>
		<div class="cms-video--rate d-flex gap-5 align-items-center pt-5 mb-n5 text-sm">
			<?php 
				// icon
				genzia_svgs_icon([
					'icon'       => 'core/star',
					'icon_size'  => 14,
					'icon_color' => 'sub-text'
				]);
				// text
				echo esc_html($settings['rate_text']); 
			?>
		</div>
	</div>
<?php } ?>