<?php 
$form_id = 'cms-newsletter-'.$this->get_id();
// Modal
$this->add_render_attribute('modal-btn-attrs',[
    'class'            => [
        'cms-btn',
        'btn-'.$this->get_setting('popup_btn_color', 'primary-regular'),
        'text-'.$this->get_setting('popup_btn_text_color', 'white'),
        'btn-hover-'.$this->get_setting('popup_btn_hover_color', 'accent-regular'),
        'text-hover-'.$this->get_setting('popup_btn_hover_text_color', 'white'),
        'popup-btn',
        'cms-modal',
        'mt-40',
        'cms-hover-move-icon-right'
    ],
    'data-modal-move'  => '#'.$form_id.'-move',
    'data-modal'       => '#'.$form_id,
    'data-modal-mode'  => "slide",
    'data-modal-slide' => "up", 
    'data-modal-class' => "center"
]);
$this->add_render_attribute('wrap-move', [
    'id'    => $form_id.'-move'
]);
// wrap
$this->add_render_attribute('wrap', [
    'id'    => $form_id,
    'style' => genzia_elementor_form_style_render($widget, $settings)
]);
// Content
$widget->add_render_attribute('content', [
    'class' => [
        'cms-newsletter-content'
    ]
]);
// Popup Text
$this->add_render_attribute('popup-title', [
    'class' => [
        'cms-newsletter-popup-text heading text-xl',
        'text-'.$this->get_setting('popup_title_color','heading'),
        'm-tb-n6'
    ]
]);
// Popup
switch ($settings['layout_mode']) {
    case 'popup':
        $widget->add_render_attribute('wrap', [
            'class' => [
                'cms-modal-html',
                'bg-white p-40 p-lr-smobile-20',
                'cms-shadow-1'
            ],
            'style'                      => [
                '--cms-modal-width:800px;',
                '--cms-modal-content-width:800px;'
            ]
        ]);
        $widget->add_render_attribute('content', [
            'class' => [
                //'cms-modal-content'
            ]
        ]);
        break;
    default:
        break;
}
// Popup
switch ($settings['layout_mode']) {
    case 'popup':
?>
    <div class="cms-newsletter-popup">
        <div <?php ctc_print_html($this->get_render_attribute_string('popup-title')); ?>><?php ctc_print_html($settings['popup_title']); ?></div>
        <div <?php ctc_print_html($widget->get_render_attribute_string('modal-btn-attrs')); ?>><?php 
            // text
            ctc_print_html($settings['popup_btn_text']);
            // icon
            genzia_svgs_icon([
                'icon'      => 'arrow-right',
                'icon_size' => 10
            ]);
        ?></div>
    </div>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap-move')); ?>>
<?php
        break;
    default:
        // code...
        break;
}
?>
	<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
        <div <?php ctc_print_html($this->get_render_attribute_string('content')); ?>>
        	<?php
				newsletter_form($settings['custom_form_id']);  
			?>
		</div>
        <?php if($settings['layout_mode']=="popup"){ ?>
            <span class="cms-modal--close cms-close d-flex align-items-center absolute top right cms-box-40 bg-accent-regular text-white bg-hover-error text-hover-white cms-transition">
                <?php
                    genzia_svgs_icon(['icon' => 'core/close', 'icon_size' => 16])
                ?>
            </span>
        <?php } ?>
	</div>
<?php
switch ($settings['layout_mode']) {
    case 'popup':
?>
</div> <?php // Clode 'wrap-move' ?>
<?php
        break;
    default:
        // code...
        break;
} ?>