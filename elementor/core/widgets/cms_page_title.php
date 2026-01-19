<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

/**
 * Page Title Widget.
 *
 * Page title widget that displays the title, description and breadcrumb
 * with various layout options and customization settings.
 *
 * @since 1.0.0
 */
class Widget_Page_Title extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_page_title');
        $this->set_title(esc_html__('CMS Page Title', 'genzia'));
        $this->set_icon('eicon-site-title');
        $this->set_keywords(['page title', 'title', 'heading', 'breadcrumb', 'genzia']);
        
        parent::__construct($data, $args);
    }

    /**
     * Register Page Title widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls(): void
    {
        // Layout Tab Start

        // Layout Section Start
        $this->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'genzia'),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            ]
        );

        $this->add_responsive_control(
            'content_width',
            [
                'label' => esc_html__('Content Width', 'genzia'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min'  => 510, 
                        'max'  => 1280,
                        'step' => 10
                    ]
                ],
                'condition' => [
                    'layout!' => ['-breadcrumb']
                ]
            ]
        );

        $this->add_control(
            'layout',
            [
                'label'   => esc_html__('Templates', 'genzia'),
                'type'    => Controls_Manager::VISUAL_CHOICE,
                'default' => '-blog',
                'options' => [
                    '1' => [
                        'title' => esc_html__('Layout 1', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_page_title/layout/1.webp'
                    ],
                    '2' => [
                        'title' => esc_html__('Layout 2', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_page_title/layout/2.webp'
                    ],
                    '3' => [
                        'title' => esc_html__('Layout 3', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_page_title/layout/3.webp'
                    ],
                    '4' => [
                        'title' => esc_html__('Layout 4', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_page_title/layout/4.webp'
                    ],
                    '-breadcrumb' => [
                        'title' => esc_html__('Breadcrumb', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_page_title/layout/breadcrumb.webp'
                    ],
                    '-blog' => [
                        'title' => esc_html__('Blog', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_page_title/layout/blog.webp'
                    ]
                ],
                'label_block' => true
            ]
        );
        $this->end_controls_section();
        // Icon Section Start
        $this->start_controls_section(
            'page_title_section',
            [
                'label' => esc_html__('Content Setting', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout!' => ['-breadcrumb']
                ]
            ]
        );
            // Small Title
            $this->add_control(
                'small_title',
                [
                    'label'       => esc_html__('Small Title', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'placeholder' => esc_html__('Enter your title', 'genzia'),
                    'label_block' => true,
                    'condition' => [
                        'layout' => ['2']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'small_title_color',
                'label'     => esc_html__('Color', 'genzia'),
                'condition' => [
                    'layout'       => ['2'],
                    'small_title!' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .cms-small' => 'color:{{VALUE}};'
                ]
            ]);
            // Title
            $this->add_control(
                'title',
                [
                    'label'       => esc_html__('Title', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'placeholder' => esc_html__('Enter your title', 'genzia'),
                    'label_block' => true,
                    'condition' => [
                        'layout' => ['1','2','3','4','-blog']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'title_color',
                'label'     => esc_html__('Color', 'genzia'),
                'condition' => [
                    'layout' => ['1','2','3','4','-blog'],
                    'title!' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .cms-title' => 'color:{{VALUE}};'
                ]
            ]);
            // Description
            $this->add_control(
                'desc',
                [
                    'label'       => esc_html__('Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['1','2','3']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'desc_color',
                'label'     => esc_html__('Color', 'genzia'),
                'condition' => [
                    'layout' => ['1','2','3'],
                    'desc!'  => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .cms-desc' => 'color:{{VALUE}};'
                ]
            ]);
            // Button #1
            genzia_elementor_link_settings($this, [
                'name'        => 'link1_',
                'mode'        => 'btn',
                'group'       => false,
                'label'       => esc_html__('Button #1 Settings', 'genzia'),
                'color_label' => esc_html__('Button', 'genzia'),
                'condition'   => [
                    'layout' => ['1','2','3']
                ]
            ]);
            // Button #2
            genzia_elementor_link_settings($this, [
                'name'        => 'link2_',
                'mode'        => 'btn',
                'group'       => false,
                'label'       => esc_html__('Button #2 Settings', 'genzia'),
                'color_label' => esc_html__('Button', 'genzia'),
                'condition'   => [
                    'layout' => ['1','2','3']
                ]
            ]);
        $this->end_controls_section();
        // Background 
        $this->start_controls_section(
            'section_background',
            [
                'label' => esc_html__('Background Settings','genzia'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            $this->add_control(
                'bg_image',
                [
                    'label'       => esc_html__('Background Image', 'genzia'),
                    'type'        => Controls_Manager::MEDIA,
                    'default'     => [
                        'url' => Utils::get_placeholder_image_src()
                    ]
                ]
            );
            $this->add_control(
                'bg_overlay',
                [
                    'label'        => esc_html__('Gradient Overlay', 'genzia'),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => genzia_elementor_gradient_opts(),
                    'default'      => '',
                    'condition'    => [
                        'layout!' => ['-blog']
                    ]
                ]
            );
        $this->end_controls_section();
    }
}