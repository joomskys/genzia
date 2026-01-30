<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

/**
 * Quick Contact Widget.
 *
 * Quick Contact widget that displays process steps or workflow with features and descriptions
 * in various layout configurations including sticky layouts.
 *
 * @since 1.0.0
 */
class Widget_Quick_Contact extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_quickcontact');
        $this->set_title(esc_html__('CMS Quick Contact', 'genzia'));
        $this->set_icon('eicon-mail');
        $this->set_keywords(['contact', 'quick', 'cms', 'genzia']);
        $this->set_script_depends(['cms-elementor-custom']);

        parent::__construct($data, $args);
    }

    /**
     * Register Quick Contact widget controls.
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
                'tab' => Controls_Manager::TAB_LAYOUT,
            ]
        );
        $this->add_responsive_control(
            'align',
            [
                'label'   => esc_html__('Alignment', 'genzia'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'genzia'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'genzia'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'genzia'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justified', 'genzia'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
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
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_quickcontact/layout/1.webp'
                    ],
                    '2' => [
                        'title' => esc_html__('Layout 2', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_quickcontact/layout/2.webp'
                    ],
                    '3' => [
                        'title' => esc_html__('Layout 3', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_quickcontact/layout/3.webp'
                    ],
                    '4' => [
                        'title' => esc_html__('Layout 4', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_quickcontact/layout/4.webp'
                    ],
                    '5' => [
                        'title' => esc_html__('Layout 5', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_quickcontact/layout/5.webp'
                    ]
                ],
                'label_block' => true
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'eheading',
            [
                'label'     => esc_html__('Element Heading', 'genzia'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['2']
                ]
            ]
        );
            $this->add_control(
                'title',
                [
                    'label'   => esc_html__('Title', 'genzia'),
                    'type'    => Controls_Manager::TEXT,
                    'default' => esc_html__('Your Title','genzia')
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'title_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-title' => 'color:{{VALUE}};'
                ],
                'condition' => [
                    'title!' => ''
                ]
            ]);
        $this->end_controls_section();
        // Email Section Start
        $this->start_controls_section(
            'email_section',
            [
                'label' => esc_html__('Email', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
            $this->add_control(
                'email_icon',
                [
                    'label'   => esc_html__('Icon', 'genzia'),
                    'type'    => Controls_Manager::ICONS,
                    'default' => [
                        'value'   => 'far fa-envelope',
                        'library' => 'fa-regular'
                    ],
                    'skin'        => 'inline',
                    'label_block' => false,
                    'condition'   => [
                        'email!' => '',
                    ]
                ]
            );
            //
            $this->add_control(
                'email_title',
                [
                    'label'     => esc_html__('Title', 'genzia'),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => 'Email:',
                    'separator' => 'before',
                    'classes'   => 'cms-eseparator',
                    'condition' => [
                        'email!' => '',
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'email_title_color',
                'label'     => esc_html__('Title Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-email-title' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'email!'       => '',
                    'email_title!' => ''
                ]
            ]);
            $this->add_control(
                'email',
                [
                    'label'       => '',
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Genzia@mail.com',
                    'placeholder' => 'Genzia@mail.com',
                    'separator'   => 'before',
                    'classes'     => 'cms-eseparator'
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'email_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-email' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'email!'       => ''
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'email_color_hover',
                'label'     => esc_html__('Hover Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-email:hover' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'email!'       => ''
                ]
            ]);
        $this->end_controls_section();
        // Phone Section Start
        $this->start_controls_section(
            'phone_section',
            [
                'label' => esc_html__('Phone Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
            $this->add_control(
                'phone_icon',
                [
                    'label'   => esc_html__('Phone Icon', 'genzia'),
                    'type'    => Controls_Manager::ICONS,
                    'default' => [
                        'value'   => 'fas fa-phone-alt',
                        'library' => 'fa-solid'
                    ],
                    'skin'        => 'inline',
                    'label_block' => false,
                    'condition'   => [
                        'phone!' => ''
                    ]
                ]
            );
            //
            $this->add_control(
                'phone_title',
                [
                    'label'       => esc_html__('Title', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Call Us:',
                    'label_block' => false,
                    'separator'   => 'before',
                    'classes'     => 'cms-eseparator',
                    'condition' => [
                        'phone!' => ''
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'phone_title_color',
                'label'     => esc_html__('Title Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-phone-title' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'phone!'       => '',
                    'phone_title!' => ''
                ]
            ]);
            $this->add_control(
                'phone',
                [
                    'label'       => esc_html__('Number', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '02 01061245741',
                    'placeholder' => '02 01061245741',
                    'separator'   => 'before',
                    'classes'     => 'cms-eseparator'
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'phone_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-phone' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'phone!' => ''
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'phone_color_hover',
                'label'     => esc_html__('Hover Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-phone:hover' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'phone!' => ''
                ]
            ]);
        $this->end_controls_section();

        // Address Section Start
        $this->start_controls_section(
            'address_section',
            [
                'label'     => esc_html__('Address Settings', 'genzia'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout!' => ['5']
                ]
            ]
        );
            //
            $this->add_control(
                'address_icon',
                [
                    'label'   => esc_html__('Icon', 'genzia'),
                    'type'    => Controls_Manager::ICONS,
                    'default' => [
                        'value'   => 'fas fa-map-marker-alt',
                        'library' => 'fa-solid'
                    ],
                    'skin'        => 'inline',
                    'label_block' => false,
                    'condition'   => [
                        'address!' => ''
                    ]
                ]
            );
            //
            $this->add_control(
                'address_title',
                [
                    'label'       => esc_html__('Title', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Location',
                    'label_block' => false,
                    'condition'   => [
                        'address!' => ''
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'address_title_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-address-title' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'address!'       => '',
                    'address_title!' => ''
                ]
            ]);
            $this->add_control(
                'address',
                [
                    'label'       => '',
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '2307 Beverley Rd Brooklyn, New York 11226 United States.',
                    'placeholder' => esc_html__('Enter your address', 'genzia')
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'address_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-address' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'address!' => ''
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'address_color_hover',
                'label'     => esc_html__('Hover Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-address:hover' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'address!' => ''
                ]
            ]);
        $this->end_controls_section();
        // Time
        $this->start_controls_section(
            'time_section',
            [
                'label'     => esc_html__('Time Settings', 'genzia'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout!' => ['4','5']
                ]
            ]
        );
            $this->add_control(
                'time_icon',
                [
                    'label'   => esc_html__('Icon', 'genzia'),
                    'type'    => Controls_Manager::ICONS,
                    'default' => [
                        'value'   => 'far fa-clock',
                        'library' => 'fa-regular'
                    ],
                    'skin'        => 'inline',
                    'label_block' => false,
                    'condition'   => [
                        'time!' => ''
                    ]
                ]
            );
            //
            $this->add_control(
                'time_title',
                [
                    'label'       => esc_html__('Title', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Mon - Fri:',
                    'label_block' => false,
                    'condition' => [
                        'time!' => ''
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'time_title_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-time-title' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'time!'       => '',
                    'time_title!' => ''
                ]
            ]);
            $this->add_control(
                'time',
                [
                    'label'       => esc_html__('Time', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '8AM - 5PM',
                    'label_block' => false
                ]
            );
            $this->add_control(
                'exclude_time',
                [
                    'label' => esc_html__('Exclude Time', 'genzia'),
                    'type' => Controls_Manager::TEXT,
                    'default' => '*Excludes Holidays',
                    'label_block' => false,
                    'condition' => [
                        'time!' => ''
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'time_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-time' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'time!' => ''
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'time_color_hover',
                'label'     => esc_html__('Hover Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-time:hover' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'time!' => ''
                ]
            ]);
        $this->end_controls_section();
        // Socials
        $this->start_controls_section(
            'social_section',
            [
                'label' => esc_html__('Socials', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['4','5']
                ]
            ]
        );
            // Social
            $social = new Repeater();
                $social->add_control(
                    'social_icon',
                    [
                        'label' => esc_html__('Icon', 'genzia'),
                        'type' => Controls_Manager::ICONS,
                        'default' => [
                            'value' => 'fas fas-star',
                            'library' => 'fa-solid'
                        ],
                        'skin' => 'inline',
                        'label_block' => false
                    ]
                );
                $social->add_control(
                    'title',
                    [
                        'label' => esc_html__('Title', 'genzia'),
                        'type' => Controls_Manager::TEXT,
                        'default' => 'Social Title',
                    ]
                );
                $social->add_control(
                    'link',
                    [
                        'label' => esc_html__('Link', 'genzia'),
                        'type' => Controls_Manager::URL,
                        'default' => [
                            'is_external' => 'true'
                        ],
                        'placeholder' => esc_html__('https://your-link.com', 'genzia'),
                    ]
                );
            $this->add_control(
                'icons',
                [
                    'label'       => esc_html__('Social Icons', 'genzia'),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $social->get_controls(),
                    'label_block' => true,
                    'default'     => [
                        [
                            'social_icon' => [
                                'value'   => 'fab fa-facebook',
                                'library' => 'fa-brands'
                            ],
                            'title' => 'Facebook',
                            'link'  => [
                                'is_external' => true,
                                'url'         => 'https://facebook.com'
                            ]
                        ],
                        [
                            'social_icon' => [
                                'value'   => 'fab fa-x-twitter-square',
                                'library' => 'fa-brands'
                            ],
                            'title' => 'X',
                            'link'  => [
                                'is_external' => true,
                                'url' => 'https://x.com'
                            ]
                        ],
                        [
                            'social_icon' => [
                                'value'   => 'fab fa-linkedin',
                                'library' => 'fa-brands'
                            ],
                            'title' => 'LinkedIn',
                            'link'  => [
                                'is_external' => true,
                                'url'         => 'https://linkedin.com'
                            ]
                        ],
                    ],
                    'title_field' => '{{{ elementor.helpers.renderIcon( this, social_icon, {}, "i", "panel" ) || \'<i class="{{ social_icon.value }}" aria-hidden="true"></i>\' }}} {{{ title }}}'
                ]
            );
        $this->end_controls_section();
        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
            genzia_elementor_colors_opts($this, [
                'name'      => 'icon_color',
                'label'     => esc_html__('Icon Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-eicon' => 'color: {{VALUE}};'
                ],
                'dynamic' => ['active' => true]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'bdr_color',
                'label'     => esc_html__('Border Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-border' => 'border-color: {{VALUE}};'
                ]
            ]);
        $this->end_controls_section();
    }
}