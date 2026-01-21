<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/**
 * Posts Grid Widget.
 *
 * Displays posts in a responsive grid layout with filtering,
 * pagination, and various display options.
 *
 * @since 1.0.0
 */
class Widget_Posts_Grid extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_posts_grid');
        $this->set_title(esc_html__('CMS Posts Grid', 'genzia'));
        $this->set_icon('eicon-posts-grid');
        $this->set_keywords(['posts', 'grid', 'blog', 'cms', 'genzia']);

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
                    'options'     => genzia_elementor_post_layouts([],[
                        '-project' => [
                            'title' => esc_html__( 'Project Scroll', 'genzia' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_posts_grid/layout/project.webp'
                        ]
                    ]),
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Heading Content
        $this->start_controls_section(
            'section_heading',
            [
                'label'     => esc_html__('Heading Content', 'genzia'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['-project']
                ]
            ]
        );
            $this->add_control(
                'heading_text',
                [
                    'label'       => esc_html__('Heading', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is Heading',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true,
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'heading_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-etitle' => '--cms-custom-color:{{VALUE}};'
                ],
                'condition' => [
                    'heading_text!' => ''
                ]
            ]);
        $this->end_controls_section();
        // Source Settings
        genzia_elementor_post_source_settings($this);

        // Display Section
        $this->start_controls_section(
            'display_section',
            [
                'label' => esc_html__('Content Display', 'genzia'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );
            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'      => 'thumbnail',
                    'default'   => 'medium',
                    'separator' => 'after'
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

        // Grid Section
        $this->start_controls_section(
            'grid_section',
            [
                'label'     => esc_html__('Grid Settings', 'genzia'),
                'tab'       => Controls_Manager::TAB_SETTINGS,
                'condition' => [
                    'layout!' => ['-project']
                ]
            ]
        );
            $this->add_responsive_control(
                'col',
                [
                    'label'        => esc_html__('Columns', 'genzia'),
                    'type'         => Controls_Manager::SELECT,
                    'default'      => '',
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
                        '6' => '6',
                    ],
                    'separator' => 'after',
                    'condition' => [
                        'layout!' => ['6']
                    ]
                ]
            );
            genzia_elementor_filter_settings($this);

            $this->add_control(
                'pagination_type',
                [
                    'label'   => esc_html__('Pagination Type', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'pagination' => esc_html__('Pagination', 'genzia'),
                        'loadmore'   => esc_html__('Loadmore', 'genzia'),
                        'false'      => esc_html__('Disable', 'genzia'),
                    ],
                    'default'   => 'false',
                    'separator' => 'before'
                ]
            );
        $this->end_controls_section();
    }
}
