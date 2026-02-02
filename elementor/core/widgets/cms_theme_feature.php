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
        $this->set_script_depends(['cms-parallax-mouse-move']);
        $this->set_style_depends(['e-animation-fadeInUp','e-animation-fadeInDown']);

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
                        ],
                        '9' => [
                            'title' => esc_html__('Layout 9', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_theme_feature/layout/9.webp'
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
                        'layout' => ['1','2','4','5','6','9']
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
                        'layout' => ['1','2','3','4','5','6','9']
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
                        'layout' => ['1','2','3','4','5','6','9']
                    ]
                ]
            );
            $this->add_control(
                'gallery',
                [
                    'label'       => esc_html__('Galleries', 'genzia'),
                    'type'        => Controls_Manager::GALLERY,
                    'condition'   => [
                        'layout' => ['1','9']
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
                        'layout' => ['1','9']
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
                        'layout' => ['1','9']
                    ],
                    'label_block' => false
                ]
            );
            genzia_elementor_link_settings($this,[
                'name'      => 'gallery_link_',
                'label'     => esc_html__('Gallery Link','genzia'),
                'text'      => 'Click Here',
                'condition' => [
                    'layout' => ['1','9']
                ]
            ]);
            // Button
            genzia_elementor_link_settings($this,[
                'name'      => 'btn_',
                'label'     => esc_html__('Button Settings','genzia'),
                'text'      => 'Click Here',
                'icon_settings' => [
                    'enable' => true
                ],
                'condition' => [
                    'layout' => ['9']
                ]
            ]);
            genzia_elementor_link_settings($this,[
                'name'      => 'phone_',
                'mode'      => 'link',
                'label'     => esc_html__('Phone Settings','genzia'),
                'text'      => '+2 011 6114 5741',
                'condition' => [
                    'layout' => ['9']
                ]
            ]);
            genzia_elementor_link_settings($this,[
                'name'      => 'email_',
                'mode'      => 'link',
                'label'     => esc_html__('Email Settings','genzia'),
                'text'      => 'Genzia@mail.com',
                'condition' => [
                    'layout' => ['9']
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
            // SEO
            $seo = new Repeater();
                // Title
                $seo->add_control(
                    'seo_title',
                    [
                        'label'       => esc_html__('Title', 'genzia'),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => 'Your title',
                        'label_block' => false,
                        'skin'        => 'inline'
                    ]
                );
                // Color
                genzia_elementor_colors_opts($seo, [
                    'name'      => 'seo_color',
                    'label'     => esc_html__('Title Color', 'genzia'),
                    'custom'    => false
                ]);
                // Background
                genzia_elementor_colors_opts($seo, [
                    'name'      => 'seo_bg',
                    'label'     => esc_html__('Background Color', 'genzia'),
                    'custom'    => false
                ]);
                // Dimension
                $seo->add_control(
                    'seo_dimentions',
                    [
                        'label'       => esc_html__('Dimensions', 'genzia'),
                        'type'        => Controls_Manager::SLIDER,
                        'default'     => [],
                        'label_block' => true,
                        'default'     => [
                            'size' => 124,
                        ],
                        'range' => [
                            'px' => [
                                'min'  => 80,
                                'max'  => 400,
                                'step' => 1
                            ]
                        ],
                    ]
                );
                // X Position
                $seo->add_control(
                    'seo_xpos',
                    [
                        'label'       => esc_html__('X Position', 'genzia'),
                        'type'        => Controls_Manager::SLIDER,
                        'default'     => [],
                        'label_block' => true,
                        'range' => [
                            'px' => [
                                'min'  => -1200,
                                'max'  => 1200,
                                'step' => 1
                            ]
                        ],
                        'default'     => [
                            'size' => '',
                        ],
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}}.seo-item' => 'left:{{SIZE}}px;',
                        ]
                    ]
                );
                // Y Position
                $seo->add_control(
                    'seo_ypos',
                    [
                        'label'       => esc_html__('Y Position', 'genzia'),
                        'type'        => Controls_Manager::SLIDER,
                        'default'     => [],
                        'label_block' => true,
                        'range' => [
                            'px' => [
                                'min'  => -1200,
                                'max'  => 1200,
                                'step' => 1
                            ]
                        ],
                        'default'     => [
                            'size' => '',
                        ],
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}}.seo-item' => 'top:{{SIZE}}px;',
                        ]
                    ]
                );
            $this->add_control(
                'seo',
                [
                    'label'       => esc_html__('Seo List', 'genzia'),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $seo->get_controls(),
                    'title_field' => '{{seo_title}}',
                    'default'     => [
                        [
                            'seo_title' => 'Development',
                            'seo_color' => 'menu',
                            'seo_bg'    => 'white',
                            'seo_dimentions' => [
                                'size'  => 136
                            ],
                            'seo_xpos' => -100,
                            'seo_ypos' => 30
                        ],
                        [
                            'seo_title' => 'Marketing',
                            'seo_color' => 'white',
                            'seo_bg'    => 'accent-regular',
                            'seo_dimentions' => [
                                'size'  => 127
                            ],
                            'seo_xpos' => 209,
                            'seo_ypos' => 119
                        ],
                        [
                            'seo_title' => 'Illustrations',
                            'seo_color' => 'menu',
                            'seo_bg'    => 'white',
                            'seo_dimentions' => [
                                'size'  => 140
                            ],
                            'seo_xpos' => 296,
                            'seo_ypos' => 110
                        ],
                        [
                            'seo_title' => 'Ecommerce',
                            'seo_color' => 'white',
                            'seo_bg'    => 'warning',
                            'seo_dimentions' => [
                                'size'  => 140
                            ],
                            'seo_xpos' => 242,
                            'seo_ypos' => 40
                        ],
                        [
                            'seo_title' => 'Strategy',
                            'seo_color' => 'menu',
                            'seo_bg'    => 'white',
                            'seo_dimentions' => [
                                'size'  => 116
                            ],
                            'seo_xpos' => 0,
                            'seo_ypos' => 106
                        ],
                        [
                            'seo_title' => 'UI/UX',
                            'seo_color' => 'white',
                            'seo_bg'    => 'warning',
                            'seo_dimentions' => [
                                'size'  => 92
                            ],
                            'seo_xpos' => 84,
                            'seo_ypos' => 110
                        ],
                        [
                            'seo_title' => 'Analysis',
                            'seo_color' => 'white',
                            'seo_bg'    => 'accent-regular',
                            'seo_dimentions' => [
                                'size'  => 124
                            ],
                            'seo_xpos' => 40,
                            'seo_ypos' => 0
                        ],
                        [
                            'seo_title' => 'Branding',
                            'seo_color' => 'white',
                            'seo_bg'    => 'menu',
                            'seo_dimentions' => [
                                'size'  => 140
                            ],
                            'seo_xpos' => 138,
                            'seo_ypos' => 20
                        ],
                        [
                            'seo_title' => 'Seo',
                            'seo_color' => 'menu',
                            'seo_bg'    => 'white',
                            'seo_dimentions' => [
                                'size'  => 80
                            ],
                            'seo_xpos' => 232,
                            'seo_ypos' => -10
                        ],
                        [
                            'seo_title' => 'SMM',
                            'seo_color' => 'menu',
                            'seo_bg'    => 'white',
                            'seo_dimentions' => [
                                'size'  => 86
                            ],
                            'seo_xpos' => 138,
                            'seo_ypos' => 146
                        ]
                    ],
                    'button_text' => esc_html__('Add Seo', 'genzia'),
                    'condition'   => [
                        'layout' => ['5']
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
