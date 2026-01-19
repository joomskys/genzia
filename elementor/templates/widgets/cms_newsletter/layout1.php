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
    'class' => [
        'cms-newsletter',
        'cms-newsletter-'.$settings['layout']
    ],
    'style' => genzia_elementor_form_style_render($widget, $settings)
]);
// Content
$widget->add_render_attribute('content', [
    'class' => [
        'cms-newsletter-content',
        'd-flex gapY-40',
        'align-items-center justify-content-between'
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
// title 
$this->add_inline_editing_attributes('title');
$this->add_render_attribute('title', [
    'class' => [
        'cms-title heading',
        'empty-none',
        'text-xl',
        'text-'.$this->get_setting('title_color','heading-regular')
    ]
]);
// Desccription
$this->add_inline_editing_attributes('description');
$this->add_render_attribute('description', [
    'class' => [
        'cms-desc empty-none',
        'text-'.$settings['desc_color'],
        'text-md',
        'pt-20'
    ]
]);
// Privacy Policy
$this->add_render_attribute('privacy_policy_text_wrap', [
    'class' => [
        'cms-pp text-xs empty-none',
        'pt-10'
    ]
]);
// Privacy Policy text
$this->add_inline_editing_attributes('privacy_policy_text');
$this->add_render_attribute('privacy_policy_text',[
    'class' => [
        'pp-text',
        'text-'.$this->get_setting('privacy_policy_text_color','body')
    ]
]);
// Privacy Policy link
$this->add_render_attribute( 'privacy_policy_link_text', [
    'class' =>[
        'pp-link',
        'cms-underline cms-hover-underline',
        'text-'.$this->get_setting('privacy_policy_link_text_color','primary-regular'),
        'text-hover-'.$this->get_setting('privacy_policy_link_text_color','primary-regular')
    ],
    'href'  => get_permalink($this->get_setting('privacy_policy_page'))
]);
// Form Fields
$show_name = $this->get_setting('show_name','no');
// Shortcode
$fields = '[newsletter_form button_label="'.$this->get_setting('button_text',esc_html__('Subscribe','genzia')).'" class="cms-nlf-1 relative d-flex gap-20"]';
    if($show_name == 'yes'){
        $fields .= '[newsletter_field name="first_name" label="" placeholder="'.$this->get_setting('name_text',esc_html__('Your Name','genzia')).'"]';
    }
    $fields .= '[newsletter_field name="email" label="" placeholder="'.$this->get_setting('email_text',esc_html__('Your Email Address','genzia')).'"]';
$fields .= '[/newsletter_form]';
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
            <div class="col-5 col-tablet-6 col-mobile-12">
                <h2 <?php ctc_print_html($this->get_render_attribute_string('title')); ?>><?php 
                    echo nl2br($settings['title']); 
                ?></h2>
                <div <?php ctc_print_html($this->get_render_attribute_string('description')); ?>><?php 
                    echo wpautop($settings['description']); 
                ?></div>
            </div>
            <div class="col-5 col-tablet-6 col-mobile-12">
                <?php 
                    switch ($settings['layout_form']) {
                        case 'custom':
                            newsletter_form($settings['form_id']); 
                            break;
                        default:
                            echo do_shortcode($fields); 
                            break;
                    }
                //
                if(!empty($this->get_setting('privacy_policy_page')['url'])){
                ?>
                    <div <?php ctc_print_html($this->get_render_attribute_string('privacy_policy_text_wrap')); ?>>
                        <span <?php ctc_print_html($this->get_render_attribute_string('privacy_policy_text')); ?>><?php 
                            // text
                            ctc_print_html($settings['privacy_policy_text']).'&nbsp;';
                        ?></span>
                        <?php 
                            // link
                            ctc_print_html(
                                '<a '.$this->get_render_attribute_string('privacy_policy_link_text').'>'.$this->get_setting('privacy_policy_link_text', esc_html__('Privacy Policy','genzia')).'</a>'
                            );
                        ?>
                    </div>
                <?php } ?>
            </div>
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