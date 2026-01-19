<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Posts Grid Widget.
 *
 * Displays posts in a responsive grid layout with filtering,
 * pagination, and various display options.
 *
 * @since 1.0.0
 */
class Widget_Genzia_Posts_Scroll_Grow extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_theme_posts_scroll_grow');
        $this->set_title(esc_html__('CMS Genzia Posts Scroll Grow', 'genzia'));
        $this->set_icon('eicon-posts-grid');
        $this->set_keywords(['posts scroll grow', 'posts', 'scroll', 'grow', 'genzia']);

        parent::__construct($data, $args);
    }

    /**
     * Register Posts Grid widget controls.
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
            $this->add_control(
                'layout',
                [
                    'label'       => esc_html__('Templates', 'genzia'),
                    'type'        => Controls_Manager::VISUAL_CHOICE,
                    'default'     => '1',
                    'options'     => [
                        '1' => [
                            'title' => esc_html__('Layout 1', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_theme_posts_scroll_grow/layout/1.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Source Settings
        genzia_elementor_post_source_settings($this);
        // Heading Content
        $this->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__('Heading Content', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT,
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
                ]
            ]);
        $this->end_controls_section();
        // Display Section
        $this->start_controls_section(
            'display_section',
            [
                'label' => esc_html__('Content Display', 'genzia'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );
            $this->add_control(
                'num_line',
                [
                    'label' => esc_html__('Excerpt Length', 'genzia'),
                    'description' => esc_html__('Enter number of line you want to show, max is 10', 'genzia'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 10,
                        ]
                    ],
                    'default' => [
                        'size' => '',
                    ],
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'readmore_text',
                [
                    'label' => esc_html__('Readmore Text', 'genzia'),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Read More', 'genzia'),
                ]
            );
        $this->end_controls_section();
    }
}
