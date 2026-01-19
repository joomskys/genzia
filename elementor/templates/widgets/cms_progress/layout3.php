<?php 
// Render Background Image
if(!empty($settings['bg_image']['url'])){
	$background_img = 'url('.$settings['bg_image']['url'].')';
} elseif(get_the_post_thumbnail_url('', 'full')) {
	$background_img = 'url('.get_the_post_thumbnail_url('', 'full').')';
} else {
	$background_img = 'var(--cms-ptitle-bg-image)';
}
// Wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-eprogress',
		'cms-eprogress-'.$this->get_setting('layout'),
		'cms-gradient-render cms-gradient-'.$this->get_setting('bg_overlay', '1'),
		'bg-bg-light',
		'd-flex gap-40',
		'cms-bg-cover cms-lazy',
		'p-tb p-lr'
	],
	'style' => [
		'--cms-bg-lazyload:'.$background_img.';background-image:var(--cms-bg-lazyload-loaded);',
		'--p-tb:110px;--p-tb-tablet:60px;',
		'--p-lr:110px;--p-lr-tablet:50px;--p-lr-mobile:20px;'
	]
]);
// Progress Bar
$progressbar_list = $this->get_setting('progressbar_list', []);
$progressbar_h = $this->get_setting('pbar_height', 80);
$this->add_render_attribute('progressbar-wrap', [
	'class' => [
		'cms-eprogress-bar',
		'cms-eprogress-bar-'.$settings['layout'],
		'p-tb p-lr',
		'bg-backdrop',
		'cms-radius-16'
	],
	'style' => [
		'--cms-progress-bg:var(--cms-'.$this->get_setting('pbar_bg', 'transparent').');',
		'--height:'.$progressbar_h.'px;',
		'--cms-progress-radius:12px;',
		'--p-tb:60px;',
		'--p-lr:55px;--p-lr-mobile:40px;--p-lr-smobile:20px;'
	]
]);
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
// Small Title
$this->add_render_attribute('small-title', [
	'class' => [
		'cms-small',
		'empty-none',
		'text-'.$this->get_setting('small_title_color','white'),
		'm-tb-n7',
		'pb-20'
	]
]);
// Title
$this->add_render_attribute('title', [
	'class' => [
		'cms-title cms-heading',
		'text-'.$this->get_setting('title_color','white'),
		'empty-none',
		'm-tb-n10'
	]
]);
// Description
$this->add_render_attribute('text',[
	'class' => [
		'cms-desc',
		'text-'.$this->get_setting('text_color','white'),
		'text-md',
		'empty-none',
		'm-tb-n7',
		'pt-25'
	]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div class="flex-auto flex-mobile-full d-flex flex-column justify-content-between max-w" style="--max-w: 40%;--max-w-mobile:100%;">
		<div class="top">
			<div <?php ctc_print_html($this->get_render_attribute_string('small-title')); ?>><?php 
				echo nl2br($settings['small_title']);
			?></div>
			<h2 <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php 
				echo nl2br($settings['title']);
			?></h2>
		</div>
		<div <?php ctc_print_html($this->get_render_attribute_string('text')); ?>><?php 
			echo nl2br($settings['text']);
		?></div>
	</div>
	<div class="flex-basic pl-70 pl-tablet-extra-0">
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
							'cms-progress-bar-title cms-heading',
							'text-white',
							'text-xl',
							'd-flex justify-content-between flex-nowrap',
							'pb-15 mt-n5',
							($count > 1) ? 'pt-30' : ''
						],
						'style' => 'width:'.$progressbar['percent']['size'].'%'
					]);
					$this->add_render_attribute( $wrapper_key, [
						'class'         => 'cms-progress-wrap cms-progress-wrap-w flex-basic',
						'role'          => 'progressbar',
						'aria-valuemin' => '0',
						'aria-valuemax' => '100',
						'aria-valuenow' => $progressbar['percent']['size']
					] );
					$this->add_render_attribute( $progress_bar_key, [
						'class'      => [
							'cms-progress-bar cms-progress-bar-w bg-'.$progressbar_color,
							'elementor-repeater-item-'.$progressbar['_id'],
							'd-flex align-items-center justify-content-end p-lr-30'
						],
						'data-width' => $progressbar['percent']['size']
					] );
					// Number
					$number_key         = $this->get_repeater_setting_key( 'number', 'progressbar_list', $key );
					$this->add_render_attribute( $number_key, [
						'class'=>[
							'cms-progress-barnumber',
							'text-20 font-700 text-nowrap',
							'text-'.$this->get_setting('pnumber_color','white')
						]
					]);
				?>
				<div <?php ctc_print_html($this->get_render_attribute_string('cms-progress-bar-wrap')); ?>>
					<?php if ( ! empty( $progressbar['title'] ) ) { ?>
			            <div <?php ctc_print_html( $this->get_render_attribute_string( $title_key ) ); ?>>
			            	<?php echo esc_html( $progressbar['title'] ); ?>
			            </div>
					<?php } ?>
			        <div <?php ctc_print_html( $this->get_render_attribute_string( $wrapper_key ) ); ?>>
			            <div <?php ctc_print_html( $this->get_render_attribute_string( $progress_bar_key ) ); ?>>
			            	<div <?php ctc_print_html( $this->get_render_attribute_string( $number_key ) ); ?>>
					        	<?php echo esc_html($progressbar['prefix']) ?><span class="cms-progress-bar-number" data-duration="2000" data-delimiter="" data-to-value="<?php echo esc_attr($progressbar['percent']['size']); ?>"></span><?php echo esc_html($progressbar['suffix']) ?>
					        </div>
			            </div>
			        </div>
		        </div>
			<?php endforeach; ?>
		</div>
	</div>
</div>