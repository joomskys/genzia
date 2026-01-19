<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use CSH_Theme_Core;

/**
 * Fancy Box Widget.
 *
 * A widget that displays content in fancy boxes with icons, images,
 * and customizable styles in grid or carousel layout.
 *
 * @since 1.0.0
 */
class Widget_Fancy_Box extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_fancy_box');
        $this->set_title(esc_html__('CMS Fancy Box', 'genzia'));
        $this->set_icon('eicon-info-box');
        $this->set_keywords(['fancy', 'box', 'info', 'cms', 'genzia']);
        $this->set_script_depends(['cms-elementor-custom','cms-post-carousel-widget-js']);
        $this->set_style_depends(['swiper']);

        parent::__construct($data, $args);
    }

    /**
     * Register Fancy Box widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls(): void
    {
        // Layout Section Start
        $this->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'genzia'),
                'tab' => Controls_Manager::TAB_LAYOUT,
            ]
        );
            $this->add_control(
                'layout_mode',
                [
                    'label'   => esc_html__('Layout Mode', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'grid'     => esc_html__('Grid', 'genzia'),
                        'carousel' => esc_html__('Carousel', 'genzia')
                    ],
                    'default' => 'grid'
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_fancy_box/layout/1.webp'
                        ],
                        '-career' => [
                            'title' => esc_html__('Career', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_fancy_box/layout/career.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Fancy Box Section
        $this->start_controls_section(
            'fancy_box_career_section',
            [
                'label' => esc_html__('Career', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );  
            // Fancy Box
            $fancy_box = new Repeater();
                genzia_elementor_icon_image_settings($fancy_box, [
                    'group' => false,
                    'color' => false
                ]);
                $fancy_box->add_control(
                    'title',
                    [
                        'label'       => esc_html__('Title', 'genzia'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'default'     => 'This is the Heading',
                        'placeholder' => esc_html__('Enter your title', 'genzia'),
                        'label_block' => true
                    ]
                );
                $fancy_box->add_control(
                    'description',
                    [
                        'label'       => esc_html__('Description', 'genzia'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'default'     => 'This is the Description',
                        'placeholder' => esc_html__('Enter your description', 'genzia'),
                        'rows'        => 10,
                        'show_label'  => true
                    ]
                );
                genzia_elementor_link_settings($fancy_box, [
                    'name'  => 'link1_',
                    'mode'  => 'link',
                    'label' => esc_html__('Link Settings', 'genzia'),
                    'group' => false,
                    'color' => false
                ]);
            $fancy_box->add_control(
                'features',
                [
                    'label'       => esc_html__('Features List', 'genzia'),
                    'type'        => CSH_Theme_Core::REPEATER_CONTROL,
                    'label_block' => true,
                    'separator'   => 'before',
                    'button_text' => esc_html__('Add Feature', 'genzia'),
                    'controls'    => array(
                        array(
                            'name'        => 'ftitle',
                            'label'       => esc_html__('Feature Text', 'genzia'),
                            'type'        => Controls_Manager::TEXTAREA,
                            'default'     => 'Your feature text',
                            'label_block' => false
                        )
                    ),
                    'classes' => 'cms-title-full'
                ]
            );
            $this->add_control(
                'fancy_box',
                [
                    'label'       => esc_html__('Fancy Box', 'genzia'),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $fancy_box->get_controls(),
                    'title_field' => '{{title}}',
                    'default'     => [
                        [
                            'icon_type'     => 'icon',
                            'selected_icon' => [
                                'library' => 'fa-brands',
                                'value'   => 'fab fa-star'
                            ],
                            'title' => 'This is Heading'
                        ]
                    ],
                    'button_text' => esc_html__('Add Fancy Item', 'genzia'),
                    'condition'   => [
                        'layout!' => '-career'
                    ]
                ]
            );
            // Career
            $career = new Repeater();
                $career->add_control(
                    'title',
                    [
                        'label'       => esc_html__('Title', 'genzia'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'default'     => 'This is the Heading',
                        'placeholder' => esc_html__('Enter your title', 'genzia'),
                        'label_block' => true
                    ]
                );
                $career->add_control(
                    'description',
                    [
                        'label'       => esc_html__('Description', 'genzia'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'default'     => 'This is the Description',
                        'placeholder' => esc_html__('Enter your description', 'genzia'),
                        'rows'        => 10,
                        'show_label'  => true
                    ]
                );
                $career->add_control(
                    'job_type',
                    [
                        'label'       => esc_html__('Job Type', 'genzia'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'default'     => 'Full Time',
                        'rows'        => 10
                    ]
                );
                $career->add_control(
                    'job_add',
                    [
                        'label'       => esc_html__('Job Address', 'genzia'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'default'     => 'San Francisco',
                        'rows'        => 10
                    ]
                );
                genzia_elementor_link_settings($career, [
                    'name' => 'link1_',
                    'mode' => 'link',
                    'group' => false,
                    'label' => esc_html__('Link Settings', 'genzia'),
                    'color' => false
                ]);
            
            $this->add_control(
                'career',
                [
                    'label'       => esc_html__('Career', 'genzia'),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $career->get_controls(),
                    'title_field' => '{{title}}',
                    'default'     => [
                        [
                            'title'       => 'Global Sales & Marketing',
                            'description' => 'A chief executive officer (CEO) is the highest-ranking executive in a company, and their primary responsibilities include making major corporate decisions.',
                            'job_type'    => 'Part Time',
                            'job_add'     => 'San Francisco'
                        ],
                        [
                            'title'       => 'Chief Executive Officer',
                            'description' => 'A chief executive officer (CEO) is the highest-ranking executive in a company, and their primary responsibilities include making major corporate decisions.',
                            'job_type'    => 'Full Time',
                            'job_add'     => 'New York'
                        ],
                        [
                            'title'       => 'Chief Financial Officer',
                            'description' => 'A chief executive officer (CEO) is the highest-ranking executive in a company, and their primary responsibilities include making major corporate decisions.',
                            'job_type'    => 'Full Time',
                            'job_add'     => 'Latin America'
                        ]
                    ],
                    'button_text' => esc_html__('Add career', 'genzia'),
                    'condition'   => [
                        'layout' => '-career'
                    ]
                ]
            );
            // Career
        $this->end_controls_section();
        
        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'genzia'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            // Icon
            genzia_elementor_colors_opts($this, [
                'name'      => 'icon_color',
                'label'     => esc_html__('Icon Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-ficon' => 'color:{{VALUE}};'
                ]
            ]);
            // Title
            genzia_elementor_colors_opts($this, [
                'name'      => 'title_color',
                'label'     => esc_html__('Title Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-title' => 'color:{{VALUE}};'
                ]
            ]);
            // Description
            genzia_elementor_colors_opts($this, [
                'name'      => 'description_color',
                'label'     => esc_html__('Description Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-desc' => 'color:{{VALUE}};'
                ]
            ]);
            // Features Color
            genzia_elementor_colors_opts($this, [
                'name'      => 'fcolor',
                'label'     => esc_html__('Feature Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .feature-item' => 'color:{{VALUE}};'
                ]
            ]);
            // Read More
            genzia_elementor_colors_opts($this, [
                'name'      => 'btn_color',
                'label'     => esc_html__('Button Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn' => '--cms-bg-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'btn_text_color',
                'label'     => esc_html__('Button Text Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-link' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'btn_color_hover',
                'label'     => esc_html__('Button Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn:hover' => '--cms-bg-hover-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'btn_text_color_hover',
                'label'     => esc_html__('Button Text Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-link' => '--cms-text-hover-custom:{{VALUE}};'
                ]
            ]);
            // Item Border
            genzia_elementor_colors_opts($this, [
                'name'      => 'item_bdr_color',
                'label'     => esc_html__('Item Border Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}}' => '--cms-bdr-custom:{{VALUE}};'
                ]
            ]);
        $this->end_controls_section();
        // Grid Settings
        genzia_elementor_grid_columns_settings($this, [
            'conditions' => [
                'layout_mode' => 'grid'
            ]
        ]);
        // Carousel Settings
        genzia_elementor_carousel_settings($this, [
            'slides_to_show'   => 1,
            'slides_to_scroll' => 1,
            'condition'        => [
                'layout_mode' => 'carousel'
            ]
        ]);
    }
}
