<?php
$active_section     = $this->get_settings('active_section', 1);
$accordions         = $this->get_settings('cms_accordion');
// wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-accordion',
		'cms-accordion-'.$settings['layout']
	]
]);
// Feature Desc
$this->add_render_attribute('fdesc',[
	'class' => [
		'cms-ac-feature-desc text-md',
		'text-'.$this->get_setting('fdesc_color','body')
	]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php 
		$count = 0;
		foreach ( $accordions as $key => $value ):
			$count ++;
			$is_active = ( $key + 1 ) == $active_section;
			$_id        = 'cms-accordion-'.$value['_id'];
			$ac_title   = isset( $value['ac_title'] ) ? $value['ac_title'] : '';
			$ac_content = isset( $value['ac_content'] ) ? $value['ac_content'] : '';
			$ac_document_text = isset( $value['ac_document_text'] ) ? $value['ac_document_text'] : '';
			$ac_document = isset( $value['ac_document']['url'] ) ? $value['ac_document']['url'] : '';
			$ac_feature_feature = isset($value['ac_feature_feature']) ? json_decode($value['ac_feature_feature'], true) : [];
			
			// item
			$item_key = $this->get_repeater_setting_key( 'item_key', 'cms_accordion', $key );
			$this->add_render_attribute( $item_key, [
				'class' => [ 
					'cms-accordion-item',
					'elementor-invisible',
					'cms-sticky',
					'd-flex gap',
					'bg-white'
				],
				'style' => [
					'--cms-gap:272px;--cms-gap-tablet:32px;'
				],
				'data-settings' => wp_json_encode([
					'animation' => 'fadeInUp'
				])
			]);
			// item title
			$item_title_key = $this->get_repeater_setting_key( 'item_title', 'cms_accordion', $key );
			$item_title_key_tag = (isset($value['ac_title_link']) && !empty($value['ac_title_link']['url']))?'a':'h2';
			$this->add_render_attribute( $item_title_key, [
				'class' => [ 
					'cms-accordion-title h2 m-tb-nh2',
					'text-'.$this->get_setting('title_color','menu'),
					'text-hover-'.$this->get_setting('title_active_color','accent-regular'),
					'text-on-hover-'.$this->get_setting('title_active_color','accent-regular'),
					'text-active-'.$this->get_setting('title_active_color','accent-regular'),
				]
			]);
			$this->add_link_attributes( $item_title_key, $value['ac_title_link']);
			// content
			$content_key = $this->get_repeater_setting_key( 'ac_content', 'cms_accordion', $key );
			$this->add_render_attribute( $content_key, [
				'class' => [ 
					'cms-accordion-content',
					'text-xl',
					'text-'.$this->get_setting('content_color', 'body'),
					'p-tb-48',
					'flex-auto',
					'max-w',
					'd-flex'
				],
				'style' => '--max-w:536px;'
			] );
			// Desc
			$item_desc_key = $this->get_repeater_setting_key( 'ac_desc', 'cms_accordion', $key );
			$this->add_render_attribute( $item_desc_key, [
				'class' => [ 
					'cms-accordion-desc',
					'pt-32'
				]
			]);
		?>
		<div <?php ctc_print_html( $this->get_render_attribute_string( $item_key ) ); ?>>
			<div <?php ctc_print_html( $this->get_render_attribute_string( $content_key ) ); ?>>
				<div class="w-100">
				    <<?php echo esc_attr($item_title_key_tag); ?> <?php ctc_print_html( $this->get_render_attribute_string( $item_title_key ) ); ?>><?php 
				    	echo esc_html( $ac_title ); 
				    ?></<?php echo esc_attr($item_title_key_tag); ?>>
				    <div <?php ctc_print_html( $this->get_render_attribute_string( $item_desc_key ) ); ?>><?php 
				    	// text
						echo wpautop( $ac_content );
				    ?></div>
					<div class="d-flex gap-20 empty-none pt-32"><?php 
						// download 
						if(!empty($ac_document_text) && !empty($ac_document)){
						$this->add_render_attribute('download', [
							'class' => [
								'cms-dl-btn cms-btn',
								'btn-'.$this->get_setting('dl_btn_color','menu'),
								'text-'.$this->get_setting('dl_btn_text_color', 'white'),
								'btn-hover-'.$this->get_setting('dl_btn_color_hover', 'accent-regular'),
								'text-hover-'.$this->get_setting('dl_btn_text_color_hover','white'),
								'cms-hover-move-icon-right',
								'cms-hover-change'
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
									'bg-hover-'.$this->get_setting('dl_btn_icon_bg_hover','white'),
									'bg-on-hover-'.$this->get_setting('dl_btn_icon_bg_hover','white'),
									'text-'.$this->get_setting('dl_btn_icon_color','menu'),
									'text-hover-'.$this->get_setting('dl_btn_icon_color_hover','menu'),
									'text-on-hover-'.$this->get_setting('dl_btn_icon_color_hover','menu'),
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
							'class'            => 'cms-hover-change cms-hover-move-icon-right',
							'btn_color'        => $this->get_setting('ac_link_bg','menu'),
							'text_color'       => $this->get_setting('ac_link_color','white'),
							'btn_color_hover'  => $this->get_setting('ac_link_bg_hover','accent-regular'),
							'text_color_hover' => $this->get_setting('ac_link_color_hover','white'),
							// Icons
							'text_icon' => genzia_svgs_icon([
								'icon'       => 'arrow-right',
								'icon_size'  => 10,
								'icon_class' =>  genzia_nice_class([
									'cms-eicon cms-btn-icon',
									'cms-box-48 cms-radius-6',
									'order-first',
									'bg-'.$this->get_setting('ac_link_icon_bg','white'),
									'bg-hover-'.$this->get_setting('ac_link_icon_bg_hover','white'),
									'bg-on-hover-'.$this->get_setting('ac_link_icon_bg_hover','white'),
									'text-'.$this->get_setting('ac_link_icon_color','menu'),
									'text-hover-'.$this->get_setting('ac_link_icon_color_hover','menu'),
									'text-on-hover-'.$this->get_setting('ac_link_icon_color_hover','menu'),
								]),
								'echo' => false
							]),
							'before'   => '',
							'loop'     => true,
							'loop_key' => $key
						]);
					?></div>
				</div>
				<?php
				// Feature
				if(!empty($ac_feature_feature) || !empty($value['ac_feature_text'])){
				?>
					<div class="cms-ac-feature align-self-end pt-32">
						<div <?php ctc_print_html($this->get_render_attribute_string('fdesc')); ?>><?php echo esc_html($value['ac_feature_text']); ?></div>
						<div class="cms-ac-feature-list d-flex gap-8 pt-25">
							<?php 
								// Features
								foreach ($ac_feature_feature as $fkey => $feature) {
									// Feature
									$fitem_attrs = [
										'class' => [
											'cms-ac-fitem',
											'bg-'.$this->get_setting('bg-fitem','bg-light'),
											'text-'.$this->get_setting('fitem-color','menu'),
											'bg-hover-'.$this->get_setting('bg-fitem-hover','accent-regular'),
											'text-hover-'.$this->get_setting('fitem-color-hover','white'),
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
			<?php 
				genzia_elementor_image_render($value,[
					'name'        => 'ac_banner',
					'size'        => 'custom',
					'custom_size' => ['width' => 696, 'height' => 488],
					'img_class'   => 'img-cover',
					'max_height'  => true,
					'default'	  => true,	
					'before'	  => '<div class="flex-basic flex-mobile-full order-mobile-first">',
					'after'		  => '</div>'		
				]);
			?>
		</div>
		<?php
		endforeach;
	?>
</div>