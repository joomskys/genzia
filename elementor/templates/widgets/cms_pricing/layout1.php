<?php 
$cms_pricings = $this->get_setting('cms_pricings', []);
// wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-epricing',
		'cms-epricing-'.$settings['layout'],
		'cms-switch-values'
	]
]);
// wrap inner
$this->add_render_attribute('wrap-inner', [
	'class' => [
		'cms--epricing',
		'd-flex justify-content-center align-items-center',
		'flex-col-3 flex-col-tablet-2 flex-col-mobile-1',
		'gutter'
	]
]);
// Switcher Wrap
$this->add_render_attribute('switcher-wrap',[
	'class' => [
		'd-flex gap-15 justify-content-center text-sm font-500 pb-40',
		'text-'.$this->get_setting('text_color','menu')
	]
]);
// Month
$this->add_render_attribute('month', [
	'class' => [
		'default',
		'text-'.$this->get_setting('switcher_text_color','accent')
	],
	'data-color' => $this->get_setting('switcher_text_color','accent')
]);
// Year
$this->add_render_attribute('year', [
	'class' => [
		'switched relative',
		//'text-'.$this->get_setting('switched_text_color','primary')
	],
	'data-color' => $this->get_setting('switched_text_color','primary')
]);
// Switcher
$this->add_render_attribute('switcher',[
	'class' => [
		'cms-toggle cms-toggle-switcher round cms-switch-value'
	],
	'style' => [
		'--cms-switch-circle-color:var(--cms-'.$this->get_setting('switcher_color','white').');',
		'--cms-switch-color:var(--cms-'.$this->get_setting('switcher_bg','accent').');',
		'--cms-switched-color:var(--cms-'.$this->get_setting('switched_bg','primary').');'
	]
]);
$sale_off = $this->get_setting('sale_off', 30);
// Feature Title
$this->add_render_attribute('feature-title',[
	'class' => [
		'feature-title empty-none',
		'text-sm font-700',
		'pt-35'
	]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php if($settings['show_sale_off'] == 'yes') : ?>
		<div <?php ctc_print_html($this->get_render_attribute_string('switcher-wrap')); ?>>
			<div <?php ctc_print_html($this->get_render_attribute_string('month')); ?>><?php esc_html_e('Monthly','genzia'); ?></div>
			<div <?php ctc_print_html($this->get_render_attribute_string('switcher')); ?>></div>
			<div <?php ctc_print_html($this->get_render_attribute_string('year')); ?>>
				<?php esc_html_e('Yearly','genzia'); 
				if(!empty($sale_off)){
				?>
					<span class="sale-off absolute" style="left:calc(100% + 10px); bottom: 5px;">
						<span class="sale-off-label text-nowrap absolute" style="left:22px; top: -25px;"><?php 
							echo esc_html__('Save','genzia').' '.$sale_off.'%'; 
						?></span>
						<?php 
							genzia_svgs_icon([
								'icon'      => '',
								'icon_size' => 48
							]);
						?>
					</span>
				<?php } ?>
			</div>
		</div>
	<?php endif; ?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap-inner')); ?>>
	<?php foreach ($cms_pricings as $key => $pricing) { 
		// Items 
		$item_key = $this->get_repeater_setting_key('item','cms_pricing', $key);
		$this->add_render_attribute($item_key, [
			'class' => [
				'pricing-item',
			]
		]);
		//
		$item_inner_key = $this->get_repeater_setting_key('item-inner','cms_pricing', $key);
		$this->add_render_attribute($item_inner_key, [
			'class' => array_filter([
				'cms-pricing--item',
				'relative',
				'p-40',
				($pricing['featured'] == 'yes') ? 'cms-pricing-featured' : '',
				'bdr-1',
				($pricing['featured'] == 'yes') ? 'bdr-bg-light' : 'bdr-divider',
				($pricing['featured'] == 'yes') ? 'bg-bg-light' : 'bg-white',
				'cms-transition',
				'elementor-invisible',
				//($pricing['featured'] == 'yes') ? 'cms-shadow-2 cms-hover-shadow-1' : 'cms-shadow-1 cms-hover-shadow-2',
				'cms-radius-12'
			]),
			'data-settings' => wp_json_encode([
				'animation'       => 'fadeInUp',
				'animation_delay' => $key*100
			])
		]);
		// Pricing Title
		$item_pricing_title_key = $this->get_repeater_setting_key('pricing-title', 'cms_pricing', $key);
		$this->add_render_attribute($item_pricing_title_key,[
			'class' => [
				'cms-title text-xl empty-none',
				($pricing['featured'] == 'yes') ? 'text-heading-regular' : 'text-heading-regular',
				'm-tb-nxl pb-15'
			]
		]);
		// Pricing Desc
		$item_pricing_desc_key = $this->get_repeater_setting_key('pricing-desc', 'cms_pricing', $key);
		$this->add_render_attribute($item_pricing_desc_key,[
			'class' => [
				'cms-desc empty-none',
				($pricing['featured'] == 'yes') ? 'text-body' : 'text-body',
				'text-md',
				'm-tb-n5 pt-35'
			]
		]);
		// Pricing Price
		$item_pricing_price_key = $this->get_repeater_setting_key('pricing-price', 'cms_pricing', $key);
		$this->add_render_attribute($item_pricing_price_key,[
			'class' => [
				'cms-price cms-heading',
				($pricing['featured'] == 'yes') ? 'text-heading-regular' : 'text-heading-regular',
				'lh-09'
			]
		]);
		// Pricing Price Package
		$item_pricing_price_pack_key = $this->get_repeater_setting_key('pricing-price-pack', 'cms_pricing', $key);
		$this->add_render_attribute($item_pricing_price_pack_key,[
			'class' => [
				'price-pack text-md lh-1',
				($pricing['featured'] == 'yes') ? 'text-sub-text' : 'text-sub-text',
				'cms-switch',
				'pb-5'
			]
		]);
		$item_pricing_price_pack_sale_key = $this->get_repeater_setting_key('pricing-price-pack-sale', 'cms_pricing', $key);
		$this->add_render_attribute($item_pricing_price_pack_sale_key,[
			'class' => [
				'price-pack text-md lh-1',
				($pricing['featured'] == 'yes') ? 'text-sub-text' : 'text-sub-text',
				'cms-switch d-none',
				'pb-5'
			]
		]);
		// Pricing Feature
		$item_pricing_feature = $this->get_repeater_setting_key('pricing-features','cms_pricing', $key);
		$this->add_render_attribute($item_pricing_feature,[
			'class' => [
				'cms-pricing-features empty-none',
				($pricing['featured'] == 'yes') ? 'text-sub-text' : 'text-sub-text',
				'text-md font-500',
				'mt-30'
			]
		]);
		// Pricing Yearly
		$price_yearly = $settings['currency'].($pricing['price'] - $pricing['price']*($sale_off/100));
	?>
	<div <?php ctc_print_html($this->get_render_attribute_string($item_key)); ?>>
		<div <?php ctc_print_html($this->get_render_attribute_string($item_inner_key)); ?>>
			<?php // Ribbon ?>
			<div class="cms-pricing-badge bg-menu text-white text-xs text-center empty-none p-tb p-lr absolute top right mt-10 mr-10 cms-radius-10" style="--p-tb:6px;--p-lr:10px;"><?php 
				ctc_print_html($pricing['badge_text']); 
			?></div>
			<h6 <?php ctc_print_html($this->get_render_attribute_string($item_pricing_title_key)); ?>><?php ctc_print_html($pricing['heading_text']) ?></h6>
			<?php if(!empty($pricing['price'])) { ?>
				<div class="cms-pricing-price d-flex gap-5 align-items-end empty-none pt-20">
					<h3 <?php ctc_print_html($this->get_render_attribute_string($item_pricing_price_key )); ?> data-current-value="<?php echo esc_attr($settings['currency'].$pricing['price']); ?>" data-switch-value="<?php echo esc_attr($price_yearly); ?>">
						<span class="current cms-switch"><?php ctc_print_html($settings['currency'].$pricing['price']); ?></span>	
						<span class="cms-price-sale sale cms-switch d-none"><?php ctc_print_html($price_yearly); ?></span>	
					</h3>
					<span <?php ctc_print_html($this->get_render_attribute_string($item_pricing_price_pack_key)); ?>><?php ctc_print_html($settings['price_pack']); ?></span>
					<span <?php ctc_print_html($this->get_render_attribute_string($item_pricing_price_pack_sale_key )); ?>><?php ctc_print_html($settings['price_pack']); ?></span>
				</div>
			<?php } ?>
			<div <?php ctc_print_html($this->get_render_attribute_string($item_pricing_desc_key)); ?>><?php ctc_print_html($pricing['description_text']) ?></div>
			<?php 
				genzia_elementor_link_render($widget, $pricing, [
					'name' 		=> 'link1_',
					'loop' 		=> true,
					'loop_key'  => $key,
					'mode'		=> 'btn',
					'text_icon' => '',
					'class' => [
						'cms-hover-move-icon-right',
						'w-100',
						'mt-40'
					],
					'btn_color'        => ($pricing['featured'] == 'yes') ? $this->get_setting('btn_featured_color','accent-regular') : $this->get_setting('btn_color','menu'),
					'text_color'       => ($pricing['featured'] == 'yes') ? $this->get_setting('btn_featured_text_color','white') :  $this->get_setting('btn_text_color','white'),
					'btn_color_hover'  => ($pricing['featured'] == 'yes') ? $this->get_setting('btn_featured_color_hover','menu') : $this->get_setting('btn_color_hover','accent-regular'),
					'text_color_hover' => ($pricing['featured'] == 'yes') ? $this->get_setting('btn_featured_text_color_hover','white') :  $this->get_setting('btn_text_color_hover','white')
				]);
			?>
			<div <?php ctc_print_html($this->get_render_attribute_string('feature-title')); ?>><?php 
				echo esc_html($settings['feature_title']);
			?></div>
			<div <?php ctc_print_html($this->get_render_attribute_string($item_pricing_feature)); ?>><?php 
				$fcount = 0;
				$features = (array)json_decode($pricing['features'], true);
				foreach ( $features as $fkey => $cms_feature ):
					$fcount ++;
					// Items
					$fitem_key = $this->get_repeater_setting_key('fitem', 'cms_pricing', $fkey);
					$this->add_render_attribute($fitem_key, [
						'class' => genzia_nice_class([
							'cms-list',
							($cms_feature['available'] == 'no') ? 'invi' : '',
							'd-flex gap-12',
							($fcount > 1) ? 'mt-16' : '',
							//($fcount > 1) ? 'bdr-t-1' : '',
							//($pricing['featured'] == 'yes') ? 'bdr-'.$this->get_setting('featured_border_color','divider-light') : 'bdr-'.$this->get_setting('feature_border_color','divider'),
						])
					]);
					// icons
					$ficon_classes =  [
						'cms--ficon',
						($cms_feature['available'] == 'no') ? 'invi' : '',
						'flex-auto',
						'cms-box-22 circle',
						'text-accent-regular'
					];
					if($pricing['featured'] == 'yes'){
						$ficon_classes[] = ($cms_feature['available'] == 'yes' ) ? 'bg-white' : 'bg-divider';
					} else {
						$ficon_classes[] = ($cms_feature['available'] == 'yes' ) ? 'bg-bg-light' : 'bg-divider';
					}
					// Title
					$ftitle_key = $this->get_repeater_setting_key( 'ftitle', 'cms_list', $fkey );
					if($pricing['featured'] == 'yes'){
						$ftitle_key_class = ($cms_feature['available'] == 'yes' ) ? 'text-sub-text' : 'text-stroke-dark';
					} else {
						$ftitle_key_class = ($cms_feature['available'] == 'yes' ) ? 'text-sub-text' : 'text-stroke-dark';
					}
					$this->add_render_attribute($ftitle_key, [
						'class' => [
							'flex-basic',
							'feature-title',
							$ftitle_key_class
						]
					]);
				?>
			        <div <?php ctc_print_html($this->get_render_attribute_string($fitem_key)); ?>>
			            <?php 
			            	genzia_svgs_icon([
								'icon'      => 'dot',
								'icon_size' => 6,
								'class'     => genzia_nice_class(array_filter($ficon_classes))
			            	]);
			            ?>
			            <span <?php ctc_print_html( $this->get_render_attribute_string( $ftitle_key ) ); ?>><?php echo esc_html( $cms_feature['title'] ) ?></span>
			        </div>
				<?php endforeach;
			?></div>
		</div>
	</div>
	<?php } ?>
</div>
</div>