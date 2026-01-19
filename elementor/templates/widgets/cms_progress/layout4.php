<?php 
// Render Background Image
if(!empty($settings['bg_image']['url'])){
	$background_img = 'url('.$settings['bg_image']['url'].')';
} elseif(get_the_post_thumbnail_url('', 'full')) {
	$background_img = 'url('.get_the_post_thumbnail_url('', 'full').')';
} else {
	$background_img = 'var(--cms-ptitle-bg-image)';
}
//
$progressbar_list = $this->get_setting('progressbar_list', []);
$progressbar_h = $this->get_setting('pbar_height', 128);
// Wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-eprogress',
		'cms-eprogress-'.$this->get_setting('layout'),
		'cms-gradient-render cms-gradient-'.$this->get_setting('bg_overlay', '1'),
		'cms-bg-cover cms-lazy',
		'p-tb p-lr',
		'd-flex justify-content-end'
	],
	'style' => [
		'--cms-bg-lazyload:'.$background_img.';background-image:var(--cms-bg-lazyload-loaded);',
		'--p-tb:104px;--p-tb-tablet:60px;',
		'--p-lr:104px;--p-lr-tablet:50px;--p-lr-mobile:16px;',
		//
		'--cms-w:'.$progressbar_h.'px;',
		'--cms-progress-radius:0;'
	]
]);
// Wrap Inner
$this->add_render_attribute('wrap-inner', [
	'class' => [
		'cms-eprogress-bar',
		'cms-eprogress-bar-'.$settings['layout'],
		'bg-backdrop',
		'p-48 p-lr-smobile-16',
		'cms-radius-8'
	]
]);
// Title
$this->add_render_attribute('title', [
	'class' => [
		'cms-title heading',
		'text-'.$this->get_setting('title_color','white'),
		'empty-none',
		'text-xl',
		'm-tb-n6',
		'pb-40'
	]
]);
// Progress Bar
$this->add_render_attribute('progressbar-wrap', [
	'class' => [
		'cms-eprogress--bar',
		'd-flex gap-32'
	]
]);
//
$this->add_render_attribute('cms-progress-bar-wrap', [
	'class' => [
		'cms-progress-bar-wrap',
		'cms-w'
	]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div <?php ctc_print_html($this->get_render_attribute_string('wrap-inner')); ?>>
		<div <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php 
			echo nl2br($settings['title']);
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
							'cms-progress-bar-title',
							'text-white',
							'text-lg',
							'w-100',
							'align-self-end'
						]
					]);
					$this->add_render_attribute( $wrapper_key, [
						'class'         => [
							'cms-progress-wrap cms-progress-wrap-h',
							'min-h',
							'relative'
						],
						'role'          => 'progressbar',
						'aria-valuemin' => '0',
						'aria-valuemax' => '100',
						'aria-valuenow' => $progressbar['percent']['size']
					] );
					$this->add_render_attribute( $progress_bar_key, [
						'class'      => [
							'cms-progress-bar cms-progress-bar-h bg-'.$progressbar_color,
							'elementor-repeater-item-'.$progressbar['_id'],
							'd-flex',
							'absolute bottom left right',
							'p-tb-20 p-lr-24'
						],
						'data-height' => $progressbar['percent']['size']
					] );
					// Number
					$number_key         = $this->get_repeater_setting_key( 'number', 'progressbar_list', $key );
					$this->add_render_attribute( $number_key, [
						'class'=>[
							'cms-progress-barnumber',
							'h4 text-nowrap',
							'text-white',
							'bdr-b-1 bdr-divider-light',
							'w-100',
							'align-self-start'
						]
					]);
				?>
				<div <?php ctc_print_html($this->get_render_attribute_string('cms-progress-bar-wrap')); ?>>
			        <div <?php ctc_print_html( $this->get_render_attribute_string( $wrapper_key ) ); ?>>
			            <div <?php ctc_print_html( $this->get_render_attribute_string( $progress_bar_key ) ); ?>>
			            	<div <?php ctc_print_html( $this->get_render_attribute_string( $number_key ) ); ?>>
					        	<?php echo esc_html($progressbar['prefix']) ?><span class="cms-progress-bar-number" data-duration="2000" data-delimiter="" data-to-value="<?php echo esc_attr($progressbar['percent']['size']); ?>"></span><?php echo esc_html($progressbar['suffix']) ?>
					        </div>
					        <?php 
					        //
					        if ( ! empty( $progressbar['title'] ) ) { ?>
					            <div <?php ctc_print_html( $this->get_render_attribute_string( $title_key ) ); ?>>
					            	<?php echo esc_html( $progressbar['title'] ); ?>
					            </div>
							<?php } ?>
			            </div>
			        </div>
		        </div>
			<?php endforeach; ?>
		</div>
	</div>
</div>