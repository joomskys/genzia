<?php 
/**
 * Custom WooCommerce Currency Switcher
 * 
 * https://currency-switcher.com/codex/
 * 
 * **/
if(!function_exists('genzia_woocs_currency_switcher')){
	function genzia_woocs_currency_switcher($args = []){
		$args = wp_parse_args($args, [
			'class'			   => '',
			'item_class'	   => '',
			'link_class'	   => '',
			'sub_link_class'   => 'd-flex flex-nowrap align-items-center gap-10',			
			'show_flags_parent'=> 'no',
			'show_flags'       => 'yes',
			'show_money_signs' => 'no',
			'show_text'        => 'yes',
			'text_as'          => 'description', // value: name / description
			'dropdown_pos'	   => 'bottom'	
		]);
		global $WOOCS;
		$all_currencies   = $WOOCS->get_currencies();
		$current_currency = $WOOCS->current_currency;
		$empty_flag       = WOOCS_LINK . 'img/no_flag.png';
		$show_flags_parent= $args['show_flags_parent'];
		$show_flags       = $args['show_flags'];
		$show_money_signs = $args['show_money_signs'];
		$show_text        = $args['show_text'];
		$text_as          = $args['text_as'];

		$item_classes = ['cms-woocs-item', $args['item_class']];
		$link_classes = ['cms-woocs-current', $args['link_class']];
		$sub_link_classes = ['cms-woocs', $args['sub_link_class']];
 	?>
	<ul class="cms-woocs-menu cms-dropdown dropdown-<?php echo esc_attr($args['dropdown_pos']);?> cms-touchedside">
		<li class="<?php echo genzia_nice_class(array_merge($item_classes, ['current-item'])); ?>">
			<?php 
				foreach ($all_currencies as $key => $currency) {
					if (isset($currency['hide_on_front']) && $currency['hide_on_front']) {
	                        continue;
	                    }
			            $option_txt = $currency[$args['text_as']];
			            if ($show_money_signs === 'yes') {
			                if (!empty($option_txt)) {
			                    $option_txt .= ', ' . $currency['symbol'];
			                } else {
			                    $option_txt = $currency['symbol'];
			                }
			            }
			            //***
			            if (isset($txt_type) && $txt_type == 'desc') {
		                    if (!empty($currency['description'])) {
		                        $option_txt = $currency['description'];
		                    }
			            }
			            // Flag
			            $flag_url = !empty($currency['flag']) ? $currency['flag'] : $empty_flag;
					if($current_currency === $key){
					?>
					<a href="#" class="<?php echo genzia_nice_class($link_classes); ?>" data-currency="<?php echo esc_attr($currency['name']) ?>" title="<?php echo esc_attr($currency['name']) . ', ' . esc_attr($currency['symbol']) . ' ' . esc_attr($currency['description']) ?>" onclick="event.preventDefault()">
	        			<?php if($show_flags_parent === 'yes') { ?>
	        				<img src="<?php echo esc_attr($flag_url) ?>" alt="<?php echo esc_attr($currency['name']) . ', ' . esc_attr($currency['symbol']) ?>" class="cms-woocs-parent-flag" />
	        			<?php } ?>
	        			<?php if($show_text === 'yes') { ?>
	        				<span class="name">
		        				<span class="money-name cms-hidden-laptop-"><?php echo esc_html($option_txt); ?></span>
		        				<span class="money-sign cms-hidden-desktop-"><?php echo esc_html('('.$currency['name'].' '.$currency['symbol'].')');?></span>
		        			</span>
	        			<?php } 
	        				genzia_svgs_icon([
								'icon'      => 'core/chevron-down',
								'icon_size' => 8
	        				]);
	        			?>
	        		</a>
					<?php
					}
				}
			?>
			<ul class="dropdown cms--touchedside">
				<?php
					foreach ($all_currencies as $key => $currency) {
						if (isset($currency['hide_on_front']) AND $currency['hide_on_front']) {
			                        continue;
			                    }
			            $option_txt = $currency[$args['text_as']];
			            if ($show_money_signs === 'yes') {
			                if (!empty($option_txt)) {
			                    $option_txt .= ', ' . $currency['symbol'];
			                } else {
			                    $option_txt = $currency['symbol'];
			                }
			            }
			            //***
			            if (isset($txt_type) && $txt_type == 'desc') {
		                    if (!empty($currency['description'])) {
		                        $option_txt = $currency['description'];
		                    }
			            }
			            // Flag
			            $flag_url = !empty($currency['flag']) ? $currency['flag'] : $empty_flag;

			            if($current_currency !== $key){
			        ?>
			        	<li class="<?php echo genzia_nice_class($item_classes); ?>">
			        		<a href="#" class="<?php echo genzia_nice_class($sub_link_classes); ?>" data-currency="<?php echo esc_attr($currency['name']) ?>" title="<?php echo esc_attr($currency['name']) . ', ' . esc_attr($currency['symbol']) . ' ' . esc_attr($currency['description']) ?>" class="">
			        			<?php if($show_flags === 'yes') { ?>
			        				<img src="<?php echo esc_attr($flag_url) ?>" alt="<?php echo esc_attr($currency['name']) . ', ' . esc_attr($currency['symbol']) ?>" class="cms-woocs-flag" />
			        			<?php } ?>
			        			<span class="name">
				        			<span class="money-name"><?php echo esc_html($option_txt); ?></span>
				        			<?php if($show_money_signs){ ?><span class="money-sign">(<?php echo esc_html($currency['name'].' '.esc_attr($currency['symbol'])); ?>)</span><?php } ?>
				        		</span>
			        		</a>
			        	</li>
			        <?php
			        	}
					}
				?>
			</ul>
		</li>
	</ul>
	<?php
	}
}
?>