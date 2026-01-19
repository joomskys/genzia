<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

/**
 * Newsletter Widget.
 *
 * Displays a newsletter signup form with various layout options and customization settings.
 *
 * @since 1.0.0
 */
class Widget_Newsletter extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_newsletter');
        $this->set_title(esc_html__('CMS Newsletter', 'genzia'));
        $this->set_icon('eicon-email-field');
        $this->set_keywords(['newsletter', 'email', 'subscription', 'form', 'genzia']);

        parent::__construct($data, $args);
    }

    /**
     * Register Newsletter widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls(): void
    {
        // Layout Settings
        $this->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'genzia'),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            ]
        );
            $this->add_control(
                'layout_mode',
                [
                    'label'   => esc_html__( 'Layout Mode', 'genzia' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'plain', 
                    'options' => [
                        'plain' => esc_html__('Plain','genzia'),
                        'popup' => esc_html__('Popup','genzia')
                    ] 
                ]
            );
            $this->add_control(
                'layout',
                [
                    'label'   => esc_html__('Templates', 'genzia'),
                    'type'    => Controls_Manager::VISUAL_CHOICE,
                    'default' => '1',
                    'options' => [
                        '1' => [
                            'title' => esc_html__('Layout 1', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_newsletter/layout/1.webp'
                        ],
                        '-custom' => [
                            'title' => esc_html__('HTML Forms', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_newsletter/layout/custom.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Popup Setting
        $this->start_controls_section(
            'popup_section',
            [
                'label'     => esc_html__('Popup Settings', 'genzia' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout_mode' => ['popup']
                ]
            ]
        );
            $this->add_control(
                'popup_title',
                [
                    'label'       => esc_html__('Popup Title', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Sign up for alerts, monthly insights, strategic business perspectives and exclusive content in your inbox.',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'popup_title_color',
                'label'     => esc_html__('Popup Title Color', 'genzia'),
                'condition' => [
                    'popup_title!' => ''
                ],
                'selectors'   => [
                    '{{WRAPPER}} .cms-newsletter-popup-text' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            //
            $this->add_control(
                'popup_btn_text',
                [
                    'label'       => esc_html__('Popup Button Text', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Subscribe',
                    'placeholder' => esc_html__('Subscribe', 'genzia'),
                    'label_block' => true
                ]
            );
            //
            genzia_elementor_colors_opts($this, [
                'name'      => 'popup_btn_color',
                'label'     => esc_html__('Button Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn' => '--cms-btn-bg: {{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'popup_btn_text_color',
                'label'     => esc_html__('Button Text Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn' => '--cms-text-custom: {{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'popup_btn_hover_color',
                'label'     => esc_html__('Button Hover Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn' => '--cms-btn-bg-hover: {{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'popup_btn_hover_text_color',
                'label'     => esc_html__('Button Hover Text Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn' => '--cms-text-hover-custom: {{VALUE}};'
                ]
            ]);
        $this->end_controls_section();
        // Heading Setting
        $this->start_controls_section(
            'title_section',
            [
                'label' => esc_html__('Heading', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout!' => ['-custom']
                ]
            ]
        );
            // Title
            $this->add_control(
                'title',
                [
                    'label'       => esc_html__('Title', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Newsletter',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'title_color',
                'selectors' => [
                    '#cms-newsletter-{{ID}} .cms-title' => '--cms-text-custom:{{VALUE}};'
                ],
                'condition' => [
                    'title!' => ''
                ]
            ]);
            // Description
            $this->add_control(
                'description',
                [
                    'label'       => esc_html__('Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__('Description', 'genzia'),
                    'label_block' => true,
                    'default'     => 'Sign up for story alerts, deals, news and insights from us.'
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'desc_color',
                'selectors' => [
                    '#cms-newsletter-{{ID}} .cms-desc' => '--cms-text-custom:{{VALUE}};'
                ],
                'condition' => [
                    'description!' => ''
                ]
            ]);
        $this->end_controls_section();
        // Form Settings
        $this->start_controls_section(
            'form_section',
            [
                'label'     => esc_html__('Form Settings', 'genzia'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout!' => '-custom'
                ]
            ]
        );
            $this->add_control(
                'layout_form',
                [
                    'label'   => esc_html__('Newsletter Form Layout', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''       => esc_html__('Default', 'genzia'),
                        'custom' => esc_html__('Custom', 'genzia')
                    ]
                ]
            );
            $this->add_control(
                'form_id',
                [
                    'label'   => esc_html__('Choose Form ID', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        '1'  => '1',
                        '2'  => '2',
                        '3'  => '3',
                        '4'  => '4',
                        '5'  => '5',
                        '6'  => '6',
                        '7'  => '7',
                        '8'  => '8',
                        '9'  => '9',
                        '10' => '10'
                    ],
                    'default'   => '1',
                    'condition' => [
                        'layout_form' => 'custom'
                    ],
                    'description' => sprintf(
                        esc_html__('%sClick Here%s to add your custom form. More about its, please read %s Document here%s', 'genzia'),
                        '<a href="' . esc_url(admin_url('admin.php?page=newsletter_subscription_forms')) . '" target="_blank">',
                        '</a>',
                        '<a href="' . esc_url('https://www.thenewsletterplugin.com/documentation/subscription/subscription-form-shortcodes/') . '"  target="_blank">',
                        '</a>'
                    )
                ]
            );
            $this->add_control(
                'show_name',
                [
                    'label'   => esc_html__('Show Field Name', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''    => esc_html__('Default', 'genzia'),
                        'yes' => esc_html__('Yes', 'genzia'),
                        'no'  => esc_html__('No', 'genzia'),
                    ],
                    'condition' => [
                        'layout_form!' => 'custom'
                    ]
                ]
            );
            $this->add_control(
                'name_text',
                [
                    'label'       => esc_html__('Name Text', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Enter placeholder text', 'genzia'),
                    'label_block' => true,
                    'conditions'  => [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'show_name',
                                'operator' => 'in',
                                'value' => ['', 'yes']
                            ],
                            [
                                'name' => 'layout_form',
                                'operator' => '==',
                                'value' => ''
                            ]
                        ]
                    ]
                ]
            );
            $this->add_control(
                'email_text',
                [
                    'label'       => esc_html__('Email Text', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Enter placeholder text', 'genzia'),
                    'label_block' => true,
                    'condition'   => [
                        'layout_form' => ''
                    ]
                ]
            );
            $this->add_control(
                'button_text',
                [
                    'label'       => esc_html__('Button Text', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__('Enter button text', 'genzia'),
                    'label_block' => true,
                    'condition'   => [
                        'layout_form' => ''
                    ]
                ]
            );
            // Privacy Policy Settings
            $this->add_control(
                'privacy_policy_page',
                [
                    'label'        => esc_html__('Privacy Policy Page', 'genzia'),
                    'type'         => Controls_Manager::URL,
                    'label_block'  => true,
                    'separator'    => 'before'
                ]
            );
            $this->add_control(
                'privacy_policy_text',
                [
                    'label'       => esc_html__('Privacy Policy Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__('By subscribing, you accept the', 'genzia'),
                    'default'     => 'By subscribing, you accept the',
                    'condition'   => [
                        'privacy_policy_page[url]!' => ''
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'privacy_policy_text_color',
                'label'     => esc_html__('Privacy Policy Description Color', 'genzia'),
                'selectors' => [
                    '#cms-newsletter-{{ID}} .pp-text' => '--cms-text-custom: {{VALUE}};'
                ],
                'condition' => [
                    'privacy_policy_page[url]!' => '',
                    'privacy_policy_text!'      => ''
                ]
            ]);
            $this->add_control(
                'privacy_policy_link_text',
                [
                    'label'       => esc_html__('Privacy Policy Text', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'description' => esc_html__('Default is title of page', 'genzia'),
                    'placeholder' => esc_html__('Privacy Policy', 'genzia'),
                    'condition'   => [
                        'privacy_policy_page[url]!' => ''
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'privacy_policy_link_text_color',
                'label'     => esc_html__('Privacy Policy Link Color', 'genzia'),
                'selectors' => [
                    '#cms-newsletter-{{ID}} .pp-link' => '--cms-text-custom: {{VALUE}};'
                ],
                'condition' => [
                    'privacy_policy_link_text!' => ''
                ]
            ]);
        $this->end_controls_section();
        // Custom Form Settings
        $this->start_controls_section(
            'custom_form_section',
            [
                'label' => esc_html__('Form Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => '-custom'
                ]
            ]
        );
            $this->add_control(
                'custom_form_id',
                [
                    'label' => esc_html__('Choose Form ID', 'genzia'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10'
                    ],
                    'default' => '1',
                    'description' => sprintf(
                        esc_html__('%sClick Here%s to add your custom form. More about its, please read %s Document here%s', 'genzia'),
                        '<a href="' . esc_url(admin_url('admin.php?page=newsletter_subscription_forms')) . '" target="_blank">',
                        '</a>',
                        '<a href="' . esc_url('https://www.thenewsletterplugin.com/documentation/subscription/subscription-form-shortcodes/') . '"  target="_blank">',
                        '</a>'
                    )
                ]
            );
        $this->end_controls_section();
        // Style Form Settings
        $this->start_controls_section(
            'bg_section',
            [
                'label'     => esc_html__('Background Settings','genzia'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => ['3']
                ]
            ]
        );
            genzia_elementor_colors_opts($this, [
                'name'      => 'bg_color',
                'label'     => esc_html__('Background Color', 'genzia'),
                'selectors' => [
                    '#cms-newsletter-{{ID}}' => '--cms-bg-custom: {{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'bdr_color',
                'label'     => esc_html__('Boder Color', 'genzia'),
                'selectors' => [
                    '#cms-newsletter-{{ID}}' => '--cms-bdr-custom: {{VALUE}};'
                ]
            ]);
        $this->end_controls_section();
        // Form Style
        genzia_elementor_form_style_settings($this, [
            'wrap_selector' => '#cms-newsletter-{{ID}}'
        ]);
    }
}
?>