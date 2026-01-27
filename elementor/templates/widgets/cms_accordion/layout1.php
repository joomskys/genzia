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
					$is_active ? 'active' : '',
					($key === 0) ? 'bdr-t-1' : '',
					'bdr-b-1',
					'bdr-'.$this->get_setting('border_color', 'divider'),
					'cms-bdr',
					'p-tb-48',
					'elementor-invisible',
				],
				'data-settings' => wp_json_encode([
					'animation' => 'fadeInUp'
				])
			]);
			// item title
			$item_title_key = $this->get_repeater_setting_key( 'item_title', 'cms_accordion', $key );
			$this->add_render_attribute( $item_title_key, [
				'class' => [ 
					'cms-accordion-title h4',
					'cursor-pointer',
					$is_active ? 'active' : '',
					'd-flex gap-24 align-items-center',
					'cms-hover-change',
					'text-'.$this->get_setting('title_color','menu'),
					'text-hover-'.$this->get_setting('title_active_color','accent-regular'),
					'text-on-hover-'.$this->get_setting('title_active_color','accent-regular'),
					'text-active-'.$this->get_setting('title_active_color','accent-regular'),
					'lh-1',
					'plus-minus'
				],
				'data-target' => '#'.$_id
			]);
			// title
			$title_key = $this->get_repeater_setting_key( 'ac_title', 'cms_accordion', $key );
			$this->add_render_attribute( $title_key, [
				'class' => [ 
					'cms-accordion-title-text',
					'flex-basic',
					'm-tb-nh4'
				]
			] );
			// content
			$content_key = $this->get_repeater_setting_key( 'ac_content', 'cms_accordion', $key );
			$this->add_render_attribute( $content_key, [
				'id'    => $_id,
				'class' => [ 
					'cms-accordion-content',
					'text-xl',
					'text-'.$this->get_setting('content_color', 'body'),
					'mt-nxl',
					'pt-33'
				]
			] );
			if($count == count($accordions)){
				/*$this->add_render_attribute( $item_key, [
					'class' => [
						'bdr-b-1 bdr-'.$this->get_setting('border_color', 'divider')
					]
				]);*/
			}
			if ( $is_active ) {
				$this->add_render_attribute( $content_key, 'style', 'display:block;' );
			} else{
				$this->add_render_attribute( $content_key, 'style', 'display:none;' );
			}
		?>
		<div <?php ctc_print_html( $this->get_render_attribute_string( $item_key ) ); ?>>
		    <div <?php ctc_print_html( $this->get_render_attribute_string( $item_title_key ) ); ?>>
		    	<span <?php ctc_print_html( $this->get_render_attribute_string( $title_key ) ); ?>><?php echo esc_html( $ac_title ); ?></span>
		    	<?php genzia_svgs_icon([
					'icon'      => 'accordion-icon',
					'icon_size' => 12,
					'class'     => genzia_nice_class([
						'cms-acc-icon cms-transition',
						'text-'.$this->get_setting('explain_icon_color','menu'),
						'text-active-'.$this->get_setting('explain_icon_active_color','accent-regular'),
						'bg-'.$this->get_setting('explain_icon_bg_color', 'transparent'),
						'bg-on-hover-'.$this->get_setting('explain_icon_active_bg_color','transparent'),
						'bg-active-'.$this->get_setting('explain_icon_active_bg_color','transparent'),
						'cms-box-24 justify-content-end cursor-pointer'
					])
		    	]); ?>
		    </div>
		    <div <?php ctc_print_html( $this->get_render_attribute_string( $content_key ) ); ?>>
				<?php 
					// text
					echo wpautop( $ac_content );
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
						'class'            => 'mt-33 cms-hover-change cms-hover-move-icon-right',
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
						'before'   => '<div class="clearfix"></div>',
						'loop'     => true,
						'loop_key' => $key
					]);
				// Feature
				if(!empty($ac_feature_feature) || !empty($value['ac_feature_text'])){
				?>
					<div class="cms-ac-feature pt-50">
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
		</div>
		<?php
		endforeach;
	?>
</div>