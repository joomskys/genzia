<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;

/**
 * CMS Features Widget.
 *
 * A widget that displays content in fancy boxes with icons, images,
 * and customizable styles in grid or carousel layout.
 *
 * @since 1.0.0
 */
class Widget_Genzia_Feature extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_theme_feature');
        $this->set_title(esc_html__('CMS Genzia Features', 'genzia'));
        $this->set_icon('eicon-featured-image');
        $this->set_keywords(['cms feature', 'feature', 'cms', 'genzia']);
        $this->set_script_depends(['']);
        $this->set_style_depends(['']);

        parent::__construct($data, $args);
    }

    /**
     * Register CMS Features widget controls.
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
                'layout',
                [
                    'label'   => esc_html__('Templates', 'genzia'),
                    'type'    => Controls_Manager::VISUAL_CHOICE,
                    'default' => '1',
                    'options' => [
                        '1' => [
                            'title' => esc_html__('Layout 1', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_theme_feature/layout/1.webp'
                        ],
                        '2' => [
                            'title' => esc_html__('Layout 2', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_theme_feature/layout/2.webp'
                        ],
                        '3' => [
                            'title' => esc_html__('Layout 3', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_theme_feature/layout/3.webp'
                        ],
                        '4' => [
                            'title' => esc_html__('Layout 4', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_theme_feature/layout/4.webp'
                        ],
                        '5' => [
                            'title' => esc_html__('Layout 5', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_theme_feature/layout/5.webp'
                        ],
                        '6' => [
                            'title' => esc_html__('Layout 6', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_theme_feature/layout/6.webp'
                        ],
                        '7' => [
                            'title' => esc_html__('Layout Awards', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_theme_feature/layout/7.webp'
                        ],
                        '8' => [
                            'title' => esc_html__('Layout Awards #2', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_theme_feature/layout/8.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // CMS Features Section
        $this->start_controls_section(
            'feature_section',
            [
                'label' => esc_html__('Features', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );  
            // CMS Features
            $this->add_control(
                'item_icon',
                [
                    'label'       => esc_html__('Icon', 'genzia'),
                    'type'        => Controls_Manager::ICONS,
                    'default'     => [
                        'value'   => 'fas fa-star',
                        'library' => 'fa-solid'
                    ],
                    'condition' => [
                        'layout' => ['1','3','5']
                    ],
                    'skin'        => 'inline',  
                    'label_block' => false
                ]
            );
            $this->add_control(
                'banner',
                [
                    'label'   => esc_html__('Banner', 'genzia'),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'label_block' => false,
                    'skin'        => 'inline',
                    'condition'   => [
                        'layout' => ['1','2','4','5','6']
                    ]
                ]
            );
            $this->add_control(
                'title',
                [
                    'label'       => esc_html__('Title', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the Heading',
                    'placeholder' => esc_html__('Enter your title', 'genzia'),
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['1','2','3','4','5','6']
                    ]
                ]
            );
            $this->add_control(
                'description',
                [
                    'label'       => esc_html__('Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the Description',
                    'placeholder' => esc_html__('Enter your description', 'genzia'),
                    'rows'        => 10,
                    'show_label'  => true,
                    'condition'   => [
                        'layout' => ['1','2','3','4','5','6']
                    ]
                ]
            );
            $this->add_control(
                'gallery',
                [
                    'label'       => esc_html__('Galleries', 'genzia'),
                    'type'        => Controls_Manager::GALLERY,
                    'condition'   => [
                        'layout' => ['1']
                    ]
                ]
            );
            $this->add_control(
                'gallery_icon',
                [
                    'label'       => esc_html__('Gallery Icon', 'genzia'),
                    'type'        => Controls_Manager::ICONS,
                    'default'     => [
                        'value'   => 'fas fa-star',
                        'library' => 'fa-solid'
                    ],
                    'condition' => [
                        'layout' => ['1']
                    ],
                    'skin'        => 'inline',  
                    'label_block' => false
                ]
            );
            $this->add_control(
                'gallery_desc',
                [
                    'label'       => esc_html__('Gallery Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Gallery Description',
                    'condition' => [
                        'layout' => ['1']
                    ],
                    'label_block' => false
                ]
            );
            genzia_elementor_link_settings($this,[
                'name'      => 'gallery_link_',
                'label'     => esc_html__('Gallery Link','genzia'),
                'text'      => 'Click Here',
                'condition' => [
                    'layout' => ['1']
                ]
            ]);
            // Testimonial
            $this->add_control(
                'ttmn',
                [
                    'label'       => esc_html__('Testimonial', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Testimonial Text',
                    'condition' => [
                        'layout' => ['3']
                    ]
                ]
            );
            $this->add_control(
                'ttmn_avatar',
                [
                    'label'   => esc_html__('Avatar', 'genzia'),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'label_block' => false,
                    'skin'        => 'inline',
                    'condition' => [
                        'layout' => ['3'],
                        'ttmn!'  => ''
                    ]
                ]
            );
            $this->add_control(
                'ttmn_name',
                [
                    'label'       => esc_html__('Name', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Mario Andaloro.,',  
                    'label_block' => false,
                    'condition'   => [
                        'layout' => ['3'],
                        'ttmn!'  => ''
                    ]
                ]
            );
             $this->add_control(
                'ttmn_pos',
                [
                    'label'       => esc_html__('Position', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'CMO, Brightwave',
                    'label_block' => false,
                    'condition'   => [
                        'layout' => ['3'],
                        'ttmn!'  => ''
                    ]
                ]
            );
            // Chatbot
            $chatbot = new Repeater();
                $chatbot->add_control(
                    'chat_avatar',
                    [
                        'label'   => esc_html__('Avatar', 'genzia'),
                        'type'    => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src()
                        ],
                        'label_block' => false,
                        'skin'        => 'inline'
                    ]
                );
                $chatbot->add_control(
                    'chat_text',
                    [
                        'label'       => esc_html__('Text', 'genzia'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'default'     => 'Hello',
                        'label_block' => false
                    ]
                );
            $this->add_control(
                'chatbot',
                [
                    'label'       => esc_html__('Chat List', 'genzia'),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $chatbot->get_controls(),
                    'title_field' => '{{chat_text}}',
                    'default'     => [
                        [
                            'chat_avatar' => [
                                'url' => Utils::get_placeholder_image_src()
                            ],
                            'chat_text' => 'Hello there!'
                        ],
                        [
                            'chat_avatar' => [
                                'url' => Utils::get_placeholder_image_src()
                            ],
                            'chat_text' => 'Hello! What would you like to create or edit today?'
                        ]
                    ],
                    'button_text' => esc_html__('Add Chat', 'genzia'),
                    'condition'   => [
                        'layout' => ['2']
                    ]
                ]
            );
            // Awards
            $awards = new Repeater();
                $awards->add_control(
                    'awards_title',
                    [
                        'label'       => esc_html__('Title', 'genzia'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'label_block' => false,
                        'default'     => 'Title'
                    ]
                );
                $awards->add_control(
                    'awards_desc',
                    [
                        'label'       => esc_html__('Description', 'genzia'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'label_block' => false,
                        'default'     => 'Description' 
                    ]
                );
                $awards->add_control(
                    'awards_year',
                    [
                        'label'       => esc_html__('Year', 'genzia'),
                        'type'        => Controls_Manager::NUMBER,
                        'default'     => '2026',
                        'label_block' => false
                    ]
                );
                $awards->add_control(
                    'awards_link',
                    [
                        'label'       => esc_html__('Link', 'genzia'),
                        'type'        => Controls_Manager::URL,
                        'label_block' => false
                    ]
                );
            $this->add_control(
                'awards',
                [
                    'label'       => esc_html__('Awards List', 'genzia'),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $awards->get_controls(),
                    'title_field' => '{{awards_title}}',
                    'default'     => [
                        [
                            'awards_title' => 'Award Title #1',
                            'chat_text'    => 'Award Description #1',
                            'awards_year'  => 2026 
                        ],
                        [
                            'awards_title' => 'Award Title #2',
                            'chat_text'    => 'Award Description #2',
                            'awards_year'  => 2025
                        ],
                        [
                            'awards_title' => 'Award Title #3',
                            'chat_text'    => 'Award Description #3',
                            'awards_year'  => 2024
                        ],
                        [
                            'awards_title' => 'Award Title #4',
                            'chat_text'    => 'Award Description #4',
                            'awards_year'  => 2023
                        ],
                        [
                            'awards_title' => 'Award Title #5',
                            'chat_text'    => 'Award Description #5',
                            'awards_year'  => 2022
                        ]
                    ],
                    'button_text' => esc_html__('Add Award', 'genzia'),
                    'condition'   => [
                        'layout' => ['7','8']
                    ]
                ]
            );
        $this->end_controls_section();
        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'genzia'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            // Title
            genzia_elementor_colors_opts($this, [
                'name'      => 'title_color',
                'label'     => esc_html__('Title Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .fitem-title,{{WRAPPER}} .fitem-year' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'title_color_hover',
                'label'     => esc_html__('Title Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .fitem-title,{{WRAPPER}} .fitem-year' => '--cms-text-hover-custom:{{VALUE}};--cms-text-on-hover-custom:{{VALUE}};'
                ]
            ]);
            // Description
            genzia_elementor_colors_opts($this, [
                'name'      => 'description_color',
                'label'     => esc_html__('Description Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .fitem-desc' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'description_color_hover',
                'label'     => esc_html__('Description Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .fitem-desc' => '--cms-text-hover-custom:{{VALUE}};--cms-text-on-hover-custom:{{VALUE}};'
                ]
            ]);
            // Background
            $this->add_control(
                'bg',
                [
                    'label'   => esc_html__('Background', 'genzia'),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'label_block' => false,
                    'skin'        => 'inline',
                    'condition' => [
                        'layout' => ['2']
                    ]
                ]
            );
            // Item Border
            genzia_elementor_colors_opts($this, [
                'name'      => 'item_bdr_color',
                'label'     => esc_html__('Border Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}}' => '--cms-bdr-custom:{{VALUE}};'
                ],
                'condition' => [
                    'layout' => ['1','3','7','8']
                ]
            ]);
        $this->end_controls_section();
    }
}
