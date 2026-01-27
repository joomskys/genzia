<?php
$active_section     = $this->get_settings('active_section', 1);
$accordions         = $this->get_settings('cms_accordion');
// wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-accordion-'.$settings['layout'],
		'relative',
		'max-w',
		'm-lr-auto'
	],
	'style' => '--max-w:736px;'
]);
// Feature Desc
$this->add_render_attribute('fdesc',[
	'class' => [
		'cms-ac-feature-desc empty-none',
		'text-md',
		'text-'.$this->get_setting('fdesc_color','on-dark'),
		'pt-25'
	]
]);
// Heading
$this->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-title',
		'elementor-invisible',
		'cms-nl2br',
		'text-sm',
		'text-'.$this->get_setting('heading_color','heading-regular'),
		'empty-none',
		'm-tb-nsm',
		'text-center',
		'pb'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 100
	]),
	'style' => '--pb:96px;'
]);
$heading_icon_classes = genzia_nice_class([
	'cms-heading-icon',
	'text-'.$this->get_setting('heading_icon_color', 'accent-regular'),
	'pt-10'
]);
// Description
$this->add_render_attribute( 'desc', [
	'class' => [
		'cms-desc',
		'elementor-invisible',
		'cms-nl2br',
		'text-lg',
		'text-'.$this->get_setting('desc_color','body'),
		'empty-none',
		'm-tb-nlg m-lr-auto',
		'text-center',
		'max-w',
		'pt'
	],
	'data-settings' => wp_json_encode([
		'animation'       => 'fadeInUp',
		'animation_delay' => 100
	]),
	'style' => [
		'--max-w:540px;',
		'--pt:90px;'
	]
]);
// Scroll Text
$this->add_render_attribute('scroll-text-wrap', [
	'class' => [
		'cms-swiper-container swiper-container',
		'cms-text-scroll',
		'heading',
		'text-'.$this->get_setting('text_color', 'body'),
		'text-3xl',
		'absolute center'
	],
	'data-direction'            => $this->get_setting('scroll_direction', 'false'),
	'data-speed'                => $this->get_setting('scroll_speed', 4000),
	'data-spacebetween'         => $this->get_setting('scroll_spaceBetween', 40),
	'data-hoverpause'           => 'no',
	'data-disableoninteraction' => 'yes',
	'data-loop'                 => 'yes'
]);
$cms_texts = $this->get_setting('cms_texts', []);
?>
<div <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>><?php 
	// Text
	echo nl2br( $settings['heading_text'] );
	// Icon
	genzia_elementor_icon_render( $settings['heading_icon'], [], ['class' => $heading_icon_classes, 'icon_size' => 12 ],'div');
?></div>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div <?php ctc_print_html($this->get_render_attribute_string('scroll-text-wrap')); ?>>
		<div class="cms-swiper-wrapper swiper-wrapper">
			<?php foreach ($cms_texts as $key => $value) { ?>
				<div class="cms-swiper-slide swiper-slide cms-scroll-item" data-title="<?php echo esc_html($value['text']); ?>">
					<?php echo nl2br($value['text']); ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php 
		$count = 0;
		foreach ( $accordions as $key => $value ):
			$count ++;
			$ac_title   = isset( $value['ac_title'] ) ? $value['ac_title'] : '';
			$ac_content = isset( $value['ac_content'] ) ? $value['ac_content'] : '';
			$ac_document_text = isset( $value['ac_document_text'] ) ? $value['ac_document_text'] : '';
			$ac_document = isset( $value['ac_document']['url'] ) ? $value['ac_document']['url'] : '';
			$ac_feature_feature = isset($value['ac_feature_feature']) ? json_decode($value['ac_feature_feature'], true) : [];
			
			// item
			$item_key = $this->get_repeater_setting_key( 'item_key', 'cms_accordion', $key );
			$this->add_render_attribute( $item_key, [
				'class' => array_filter([ 
					'cms-accordion-item',
					$is_active ? 'active' : '',
					'bdr-1',
					'bdr-'.$this->get_setting('border_color', 'menu'),
					'cms-bdr',
					'p-64 p-smobile-20',
					'bg-'.$this->get_setting('bg_color', 'accent-regular'),
					($count>1) ? 'absolute top left right' : ''
				]),
				'style' => [
					($count%2==0) ? 'transform:rotate(5deg);' : 'transform:rotate(-5deg);'
				]
			]);
			// item title
			$item_title_key = $this->get_repeater_setting_key( 'item_title', 'cms_accordion', $key );
			$this->add_render_attribute( $item_title_key, [
				'class' => [ 
					'cms-accordion-title h3',
					'cursor-pointer',
					'text-'.$this->get_setting('title_color','white'),
					'text-hover-'.$this->get_setting('title_active_color','white'),
					'text-on-hover-'.$this->get_setting('title_active_color','white'),
					'text-active-'.$this->get_setting('title_active_color','white'),
					'mt-nh3'
				]
			]);
			// content
			$content_key = $this->get_repeater_setting_key( 'ac_content', 'cms_accordion', $key );
			$this->add_render_attribute( $content_key, [
				'id'    => $_id,
				'class' => [ 
					'cms-accordion-content',
					'text-md',
					'text-'.$this->get_setting('content_color', 'on-dark'),
					'pt'
				],
				'style' => '--pt:87px;'
			] );
		?>
		<div <?php ctc_print_html( $this->get_render_attribute_string( $item_key ) ); ?>>
		    <div <?php ctc_print_html( $this->get_render_attribute_string( $item_title_key ) ); ?>>
		    	<?php echo esc_html( $ac_title ); ?>
		    </div>
		    <div <?php ctc_print_html( $this->get_render_attribute_string( $content_key ) ); ?>>
				<?php 
					// text
					echo nl2br( $ac_content );
					// download 
					if(!empty($ac_document_text) && !empty($ac_document)){
					$this->add_render_attribute('download', [
						'class' => [
							'cms-dl-btn cms-btn',
							'btn-'.$this->get_setting('dl_btn_color','menu'),
							'text-'.$this->get_setting('dl_btn_text_color', 'white'),
							'btn-hover-'.$this->get_setting('dl_btn_color_hover', 'white'),
							'text-hover-'.$this->get_setting('dl_btn_text_color_hover','menu'),
							'cms-hover-move-icon-right',
							'cms-hover-change',
							'mt-10'
						],
						'href'   => esc_url($value['ac_document']['url']),
						'target' => "_blank"
					]);
				?>
					<a <?php ctc_print_html($this->get_render_attribute_string('download')); ?>><?php
						// Icon
						genzia_svgs_icon([
							'icon'       => 'arrow-right',
							'icon_size'  => 10,
							'class' => implode(' ', [
								'cms-dl-btn-icon',
								'cms-box-48 cms-radius-6 order-first',
								'bg-'.$this->get_setting('dl_btn_icon_bg','white'),
								'bg-hover-'.$this->get_setting('dl_btn_icon_bg_hover','menu'),
								'bg-on-hover-'.$this->get_setting('dl_btn_icon_bg_hover','menu'),
								'text-'.$this->get_setting('dl_btn_icon_color','menu'),
								'text-hover-'.$this->get_setting('dl_btn_icon_color_hover','white'),
								'text-on-hover-'.$this->get_setting('dl_btn_icon_color_hover','white'),
							])
						]);
						// Text
						ctc_print_html($ac_document_text); 
					?></a>
				<?php }
					// Button
					genzia_elementor_link_render($this, $value, [
						'loop'			   => true,
						'name'			   => 'ac_link_',	
						'mode'			   => 'btn',
						'class'            => 'mt-33 cms-hover-change cms-hover-move-icon-right',
						'btn_color'        => $this->get_setting('ac_link_bg','white'),
						'text_color'       => $this->get_setting('ac_link_color','menu'),
						'btn_color_hover'  => $this->get_setting('ac_link_bg_hover','menu'),
						'text_color_hover' => $this->get_setting('ac_link_color_hover','white'),
						// Icons
						'text_icon' => genzia_svgs_icon([
							'icon'       => 'arrow-right',
							'icon_size'  => 10,
							'icon_class' =>  genzia_nice_class([
								'cms-eicon cms-btn-icon',
								'cms-box-48 cms-radius-6',
								'order-first',
								'bg-'.$this->get_setting('ac_link_icon_bg','accent-regular'),
								'bg-hover-'.$this->get_setting('ac_link_icon_bg_hover','white'),
								'bg-on-hover-'.$this->get_setting('ac_link_icon_bg_hover','white'),
								'text-'.$this->get_setting('ac_link_icon_color','white'),
								'text-hover-'.$this->get_setting('ac_link_icon_color_hover','menu'),
								'text-on-hover-'.$this->get_setting('ac_link_icon_color_hover','menu'),
							]),
							'echo' => false
						]),
						'before'   => '<div class="clearfix"></div>',
						'loop'     => true,
						'loop_key' => $key
					]);
				// Feature
				if(!empty($ac_feature_feature) || !empty($value['ac_feature_text'])){
				?>
					<div class="cms-ac-feature">
						<div <?php ctc_print_html($this->get_render_attribute_string('fdesc')); ?>><?php echo esc_html($value['ac_feature_text']); ?></div>
						<div class="cms-ac-feature-list d-flex gap-8 pt-25">
							<?php 
								// Features
								foreach ($ac_feature_feature as $fkey => $feature) {
									// Feature
									$fitem_attrs = [
										'class' => [
											'cms-ac-fitem',
											'bg-'.$this->get_setting('bg-fitem','sub-text'),
											'text-'.$this->get_setting('fitem-color','white'),
											'bg-hover-'.$this->get_setting('bg-fitem-hover','white'),
											'text-hover-'.$this->get_setting('fitem-color-hover','menu'),
											'text-xs p-tb-12 p-lr-20 cms-radius-rounded'
										],
										'href' => esc_url($feature['furl'])
									];
								?>
									<a <?php ctc_print_html(genzia_render_attrs($fitem_attrs)); ?>><?php 
										echo esc_html($feature['ftitle']);
									?></a>
								<?php
								}
							?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php
		endforeach;
	?>
</div>
<div <?php ctc_print_html( $this->get_render_attribute_string( 'desc' ) ); ?>><?php 
	// Text
	echo nl2br( $settings['desc'] );
?></div>