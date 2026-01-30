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
 * Testimonials Widget.
 *
 * Testimonials widget that displays process steps or workflow with features and descriptions
 * in various layout configurations including sticky layouts.
 *
 * @since 1.0.0
 */
class Widget_Testimonials extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_testimonials');
        $this->set_title(esc_html__('CMS Testimonials', 'genzia'));
        $this->set_icon('eicon-testimonial');
        $this->set_keywords(['testimonials', 'carousel', 'cms', 'genzia']);
        $this->set_script_depends(['cms-post-carousel-widget-js']);
        $this->set_style_depends(['swiper','e-animation-fadeInUp','e-animation-fadeInLeft','e-animation-fadeInRight','e-animation-rotateInUpRight']);

        parent::__construct($data, $args);
    }

    /**
     * Register Testimonials widget controls.
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
                    'grid'     => esc_html__('Grid', 'genzia'),
                    'carousel' => esc_html__('Carousel', 'genzia')
                ],
                'default' => 'carousel',
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
                'default' => '1',
                'options' => [
                    '1' => [
                        'title' => esc_html__('Layout 1', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_testimonials/layout/1.webp'
                    ],
                    '2' => [
                        'title' => esc_html__('Layout 2', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_testimonials/layout/2.webp'
                    ],
                    '3' => [
                        'title' => esc_html__('Layout 3', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_testimonials/layout/3.webp'
                    ],
                    '-sticky-scroll' => [
                        'title' => esc_html__('Scroll Sticky', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_testimonials/layout/sticky-scroll.webp'
                    ]
                ],
                'label_block' => true
            ]
        );
        $this->end_controls_section();
        // List
        $this->start_controls_section(
            'list_section',
            [
                'label' => esc_html__('Testimonials', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            // Testimonials
            $repeater = new Repeater();
            $repeater->add_control(
                'image',
                [
                    'label'   => esc_html__('Avatar', 'genzia'),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                    'label_block' => false
                ]
            );
            $repeater->add_control(
                'name',
                [
                    'label'   => esc_html__('Name', 'genzia'),
                    'type'    => Controls_Manager::TEXT,
                    'default' => esc_html__('Author Name', 'genzia'),
                ]
            );
            $repeater->add_control(
                'position',
                [
                    'label'   => esc_html__('Position', 'genzia'),
                    'type'    => Controls_Manager::TEXT,
                    'default' => esc_html__('Position', 'genzia'),
                ]
            );
            $repeater->add_control(
                'description',
                [
                    'label'   => esc_html__('Description', 'genzia'),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => esc_html__('Testimonial Description', 'genzia'),
                ]
            );
            $this->add_control(
                'testimonials',
                [
                    'label'   => esc_html__('Testimonials', 'genzia'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $repeater->get_controls(),
                    'default' => [
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name'        => esc_html__('Testimonial Name', 'genzia'),
                            'position'    => esc_html__('Testimonial Position', 'genzia'),
                            'description' => esc_html__('#1 Testimonial Description. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'genzia'),
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name'        => esc_html__('Testimonial Name #2', 'genzia'),
                            'position'    => esc_html__('Testimonial Position #2', 'genzia'),
                            'description' => esc_html__('#2 Testimonial Description. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'genzia'),
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name'        => esc_html__('Testimonial Name #3', 'genzia'),
                            'position'    => esc_html__('Testimonial Position #3', 'genzia'),
                            'description' => esc_html__('#3 Testimonial Description. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'genzia'),
                        ],
                    ],
                    'title_field' => '{{{ name }}}',
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Heading Content
        $this->start_controls_section(
            'section_heading',
            [
                'label'     => esc_html__('Heading Content', 'genzia'),
                'tab'       => Controls_Manager::TAB_CONTENT
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
                        'layout' => ['2']
                    ]
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
                        'smallheading_text!' => '',
                        'layout'             => ['3']
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
                    'smallheading_icon[value]!' => '',
                    'layout'             => ['3']
                ]
            ]);
            $this->add_control(
                'smallheading_text',
                [
                    'label'       => esc_html__('Small Heading', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is Small Heading',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['1','3','-sticky-scroll']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'smallheading_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-small' => 'color:{{VALUE}};'
                ],
                'condition' => [
                    'smallheading_text!' => '',
                    'layout' => ['1','3','-sticky-scroll']
                ]
            ]);
            //
            $this->add_control(
                'heading_text',
                [
                    'label'       => esc_html__('Heading', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the heading',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['2','3']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'heading_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-title' => '--text-custom-color: {{VALUE}};'
                ],
                'condition'   => [
                    'layout'        => ['2','3'],
                    'heading_text!' => ''
                ]
            ]);
            // Description
            $this->add_control(
                'desc_text',
                [
                    'label'       => esc_html__('Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the Description',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['2']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'box_desc_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-box-desc' => '--text-custom-color: {{VALUE}};'
                ],
                'condition'   => [
                    'layout'        => ['2'],
                    'heading_text!' => ''
                ]
            ]);
            $this->add_control(
                'gallery',
                [
                    'label'       => esc_html__('Galleries', 'genzia'),
                    'type'        => Controls_Manager::GALLERY,
                    'condition'   => [
                        'layout' => ['2']
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
                        'layout' => ['2']
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
                        'layout' => ['2']
                    ],
                    'label_block' => false
                ]
            );
            genzia_elementor_link_settings($this,[
                'name'      => 'gallery_link_',
                'label'     => esc_html__('Gallery Link','genzia'),
                'text'      => 'Click Here',
                'condition' => [
                    'layout' => ['2']
                ]
            ]);
        $this->end_controls_section();
        
        // Carousel Settings
        genzia_elementor_carousel_settings($this, [
            'condition' => [
                'layout_mode' => 'carousel',
                'layout!'     => '-sticky-scroll'
            ],
            'slides_to_show'   => 1,
            'slides_to_scroll' => 1
        ]);
        // Grid Settings
        genzia_elementor_grid_columns_settings($this, [
            'condition' => [
                'layout_mode' => ['grid'],
                'layout!'     => '-sticky-scroll'
            ],
            'divider' => false,
            'gap'     => true
        ]);

        // Style
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style Settings', 'genzia'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            genzia_elementor_colors_opts($this, [
                'name'  => 'desc_color',
                'label' => esc_html__('Testimonial Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-ttmn-desc' => 'color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'  => 'author_color',
                'label' => esc_html__('Author Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-ttmn--name' => 'color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'  => 'author_pos_color',
                'label' => esc_html__('Position Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-ttmn--pos' => 'color:{{VALUE}};'
                ]
            ]);
        $this->end_controls_section();
    }
}