<?php
$chatbot = $this->get_setting('chatbot',[]);
$bdr_color = $this->get_setting('item_bdr_color', 'divider');
// Render Background Image
if(!empty($settings['bg']['id'])){
	$background_img = 'url('.$settings['bg']['url'].')';
} elseif(get_the_post_thumbnail_url('', 'full')) {
	$background_img = 'url('.get_the_post_thumbnail_url('', 'full').')';
} else {
	$background_img = 'var(--cms-ptitle-bg-image)';
}
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-genzia-features',
		'cms-genzia-features-'.$settings['layout'],
		'bg-bg-light',
		'cms-radius-16',
		'p-40 pb-0',
		'd-flex flex-column justify-content-between',
		'relative',
		'cms-shadow-2',
		'text-center',
		'cms-bg-cover',
		'cms-lazy',
		'overflow-hidden'
	],
	'style' => [
		'min-height:512px;',
		'--cms-bg-lazyload:'.$background_img.';background-image:var(--cms-bg-lazyload-loaded);'
	]
]);
//Title
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-title heading empty-none',
		'text-'.$this->get_setting('title_color','white'),
		'h6 mt-nh6',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// Description
$this->add_render_attribute( 'desc', [
	'class' => [
		'cms-desc empty-none',
		'text-'.$this->get_setting('description_color','on-dark'),
		'text-md',
		'pt-10',
		'elementor-invisible'
	],
	'data-settings' => wp_json_encode([
		'animation' => 'fadeInUp'
	])
]);
// Output HTMl
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<div class="align-sefl-start relative">
		<h6 <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php 
			echo nl2br($settings['title']);
		?></h6>
		<div <?php ctc_print_html($this->get_render_attribute_string('desc')); ?>><?php 
			echo nl2br($settings['description']);
		?></div>
	</div>
	<?php 
		ob_start();
	?>
		<div class="cms-feature-chat p-25 pb-55 overflow-hidden absolute left right bottom text-sm text-start">
			<?php 
				$count = 0;
				foreach ($chatbot as $key => $chat) {
					$count++;
				$item_key = $this->get_repeater_setting_key( 'item', 'cms_feature', $key );
		        $this->add_render_attribute( $item_key, [
		            'class' => [
		                'd-flex gap-8 flex-nowrap',
		                ($count%2==0) ? 'justify-content-end' : '',
		                ($count>1) ? 'pt-16' : '',
		                'elementor-invisible'
		            ],
		            'data-settings' => wp_json_encode([
		            	'animation' => 'fadeInUp'
		            ])
		        ]);
		        //
		        $item_avatar_key = $this->get_repeater_setting_key( 'item-avatar', 'cms_feature', $key );
		        $this->add_render_attribute( $item_avatar_key, [
		            'class' => [
		                'cms-chat-avatar flex-auto',
		                ($count%2!=0) ? '' : 'order-last'
		            ]
		        ]);
		        //
		        $item_text_key = $this->get_repeater_setting_key( 'item-text', 'cms_feature', $key );
		        $this->add_render_attribute( $item_text_key, [
		            'class' => [
		                'cms-chat-text bg-white p-tb-10 p-lr-16',
		                ($count%2==0) ? 'cms-radius-tlblbr-16' : 'cms-radius-trblbr-16'
		            ]
		        ]);
			?>
				<div <?php ctc_print_html($this->get_render_attribute_string($item_key)); ?>>
					<div <?php ctc_print_html($this->get_render_attribute_string($item_avatar_key)); ?>><?php
						genzia_elementor_image_render($chat,[
							'name'      => 'chat_avatar',
							'size'      => 'custom',
							'img_class' => 'circle',
		                    'custom_size'    => ['width' => 42, 'height' => 42]
		                ]);
					?></div>
					<div <?php ctc_print_html($this->get_render_attribute_string($item_text_key)); ?>><?php echo esc_html($chat['chat_text']); ?></div>
				</div>
			<?php	
				}
			?>
		</div>
	<?php
		$chatbot = ob_get_clean();
		// Banner
		genzia_elementor_image_render($settings,[
			'name'        => 'banner',
			'size'        => 'custom',
			'custom_size' => ['width' => 320, 'height' => 364],
			'img_class'   => 'mt-n25 img-cover',
			'before'      => '<div class="align-items-end relative d-flex justify-content-end pt-25">',
			'after'       => '<div class="overflow-hidden cms-overlay mt-25">'.$chatbot.'</div></div>'
		]);
	?>
</div>