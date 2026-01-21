<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use CSH_Theme_Core;

/**
 * Teams Widget.
 *
 * Teams widget that displays process steps or workflow with features and descriptions
 * in various layout configurations including sticky layouts.
 *
 * @since 1.0.0
 */
class Widget_Teams extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_teams');
        $this->set_title(esc_html__('CMS Teams', 'genzia'));
        $this->set_icon('eicon-user-circle-o');
        $this->set_keywords(['teams', 'grid', 'carousel', 'cms', 'genzia']);
        $this->set_script_depends(['etc-scroller', 'cms-scroll-sticky-horizontal',]);
        $this->set_style_depends(['swiper']);

        parent::__construct($data, $args);
    }

    /**
     * Register Teams widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls(): void
    {
        // Layout Tab Start
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
                'label'   => esc_html__('Layout Mode', 'genzia'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'carousel' => esc_html__('Carousel', 'genzia'),
                    'grid'     => esc_html__('Grid', 'genzia'),
                ],
                'default'   => 'carousel',
                'condition' => [
                    'layout!' => ['-sticky-scroll']
                ]
            ]
        );
            $this->add_control(
                'layout',
                [
                    'label'   => esc_html__('Templates', 'genzia'),
                    'type'    => Controls_Manager::VISUAL_CHOICE,
                    'options' => [
                        '1' => [
                            'title' => esc_html__('Layout 1', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_teams/layout/1.webp'
                        ],
                        '2' => [
                            'title' => esc_html__('Layout 2', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_teams/layout/2.webp'
                        ],
                        '-sticky-scroll' => [
                            'title' => esc_html__('Sticky Scroll', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_teams/layout/sticky-scroll.webp'
                        ]
                    ],
                    'default' => '1',
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Heading Settings
        $this->start_controls_section(
            'heading_section',
            [
                'label' => esc_html__('Element Heading', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );
            $this->add_control(
                'smallheading_icon',
                [
                    'label'   => esc_html__('Icon', 'genzia'),
                    'type'    => Controls_Manager::ICONS,
                    'default' => [
                        'value'   => 'fas fa-star',
                        'library' => 'fa-solid'
                    ],
                    'skin'        => 'inline',
                    'label_block' => false,
                    'condition' => [
                        'smallheading_text!' => ''
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'smallheading_icon_color',
                'label'     => esc_html__('Icon Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-small-icon' => '--text-custom-color: {{VALUE}};'
                ],
                'condition' => [
                    'smallheading_text!'        => '',
                    'smallheading_icon[value]!' => ''
                ]
            ]);
            $this->add_control(
                'smallheading_text',
                [
                    'label'       => esc_html__('Small Heading', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is Small Heading',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'smallheading_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-small' => '--text-custom-color: {{VALUE}};'
                ],
                'condition' => [
                    'smallheading_text!' => ''
                ]
            ]);
            $this->add_control(
                'heading_text',
                [
                    'label'       => esc_html__('Heading', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the heading',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'heading_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-title' => '--text-custom-color: {{VALUE}};'
                ],
                'condition'   => [
                    'heading_text!' => ''
                ]
            ]);
        $this->end_controls_section();
        // List Section Start
        $this->start_controls_section(
            'list_section',
            [
                'label' => esc_html__('Teams Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            $repeater = new Repeater();
            $repeater->add_control(
                'image',
                [
                    'label' => esc_html__('Image', 'genzia'),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ]
            );
            $repeater->add_control(
                'name',
                [
                    'label' => esc_html__('Name', 'genzia'),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Name', 'genzia'),
                ]
            );
            $repeater->add_control(
                'position',
                [
                    'label' => esc_html__('Position', 'genzia'),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Position', 'genzia'),
                ]
            );
            $repeater->add_control(
                'description',
                [
                    'label' => esc_html__('Description', 'genzia'),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => '',
                    'label_block' => true
                ]
            );
            $repeater->add_control(
                'link',
                [
                    'label'       => esc_html__('Link', 'genzia'),
                    'type'        => Controls_Manager::URL,
                    'label_block' => true
                ]
            );
            for ($i = 1; $i <= 4; $i++) {
                $args = [
                    'label' => esc_html__("Social Icon", 'genzia'), //{$i}
                    'type' => Controls_Manager::ICONS,
                    'skin' => 'inline',
                    'label_block' => false,
                ];
                $args_link = [
                    'label' => esc_html__("Social Link", 'genzia'), //{$i}
                    'type' => Controls_Manager::URL,
                    'placeholder' => 'https://your-link.com',
                    'options' => ['url', 'is_external', 'nofollow'],
                    'separator' => 'after',
                ];
                if ($i == 1) {
                    $args['default'] = [
                        'value' => 'fab fa-facebook',
                        'library' => 'fa-brands'
                    ];
                    $args_link['default'] = [
                        'url' => 'https://facebook.com',
                        'is_external' => true,
                        'nofollow' => true,
                    ];
                } elseif ($i == 2) {
                    $args['default'] = [
                        'value' => 'fab fa-twitter',
                        'library' => 'fa-brands'
                    ];
                    $args_link['default'] = [
                        'url' => 'https://twitter.com/',
                        'is_external' => true,
                        'nofollow' => true,
                    ];
                } elseif ($i == 3) {
                    $args['default'] = [
                        'value' => 'fab fa-linkedin',
                        'library' => 'fa-brands'
                    ];
                    $args_link['default'] = [
                        'url' => 'https://linkedin.com/',
                        'is_external' => true,
                        'nofollow' => true,
                    ];
                } elseif ($i == 4) {
                    $args['default'] = [
                        'value' => 'fab fa-instagram',
                        'library' => 'fa-brands'
                    ];
                    $args_link['default'] = [
                        'url' => 'https://instagram.com/',
                        'is_external' => true,
                        'nofollow' => true,
                    ];
                }

                $repeater->add_control(
                    "social_icon_{$i}",
                    $args
                );
                $repeater->add_control(
                    "social_link_{$i}",
                    $args_link
                );
            }
            $this->add_control(
                'teams',
                [
                    'label' => esc_html__('Add member', 'genzia'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Name', 'genzia'),
                            'position' => esc_html__('Position', 'genzia'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Name', 'genzia'),
                            'position' => esc_html__('Position', 'genzia'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Name', 'genzia'),
                            'position' => esc_html__('Position', 'genzia'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                    ],
                    'title_field' => '{{{ name }}}',
                    'separator' => 'before',
                    'classes' => 'cms-eseparator'
                ]
            );
            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'image',
                    'label' => esc_html__('Avatar Size', 'genzia'),
                    'default' => 'custom',
                    'separator' => 'before',
                    'classes' => 'cms-eseparator'
                ]
            );
        $this->end_controls_section();
        // Color
        $this->start_controls_section(
            'color_section',
            [
                'label' => esc_html__('Color Settings', 'genzia'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            genzia_elementor_colors_opts($this, [
                'name'      => 'title_color',
                'label'     => esc_html__('Title Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .team-heading, {{WRAPPER}} .team-heading a' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'title_color_hover',
                'label'     => esc_html__('Title Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .team-heading, {{WRAPPER}} .team-heading a' => '--cms-text-hover-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'pos_color',
                'label'     => esc_html__('Position Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .team-position' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'desc_color',
                'label'     => esc_html__('Description Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .team-desc' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
        $this->end_controls_section();
        // Carousel Settings
        genzia_elementor_carousel_settings($this, [
            'condition' => [
                'layout_mode' => ['carousel']
            ]
        ]);
        // Grid Settings
        $this->start_controls_section(
            'grid_section',
            [
                'label' => esc_html__('Grid Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_SETTINGS,
                'condition' => [
                    'layout_mode' => 'grid'
                ]
            ]
        );
            $this->add_responsive_control(
                'col',
                [
                    'label' => esc_html__('Columns', 'genzia'),
                    'type' => Controls_Manager::SELECT,
                    'default' => '',
                    'default_args' => [
                        'tablet' => '',
                        'mobile' => ''
                    ],
                    'options' => [
                        '' => esc_html__('Default', 'genzia'),
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                    ],
                    'separator' => 'after'
                ]
            );
        $this->end_controls_section();
    }
}