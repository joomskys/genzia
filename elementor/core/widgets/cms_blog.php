<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/**
 * Blog Widget.
 *
 * A widget that displays blog posts with various layouts and filtering options.
 *
 * @since 1.0.0
 */
class Widget_Blog extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_blog');
        $this->set_title(esc_html__('CMS Blog', 'genzia'));
        $this->set_icon('eicon-posts-group');
        $this->set_keywords(['genzia', 'blog', 'cms blog']);

        parent::__construct($data, $args);
    }

    /**
     * Register Blog widget controls.
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
                    'label'   => esc_html__('Templates', 'genzia'),
                    'type'    => Controls_Manager::VISUAL_CHOICE,
                    'default' => '1',
                    'options' => [
                        '1' => [
                            'label' => esc_html__('Layout 1', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_blog/layout/1.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Heading Section Start
        $this->start_controls_section(
            'heading_section',
            [
                'label' => esc_html__('Heading Settings', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            // Heading
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
                    '{{WRAPPER}} .cms-title' => 'color:{{VALUE}};'
                ],
                'condition' => [
                    'heading_text!' => ''
                ]
            ]);

            // Button #1
            genzia_elementor_link_settings($this, [
                'name'        => 'link1_',
                'mode'        => 'link',
                'group'       => false,
                'label'       => esc_html__('Link Settings', 'genzia'),
                'color_label' => esc_html__('Link', 'genzia'),
                'condition'   => [
                    'layout' => ['1']
                ]
            ]);
        $this->end_controls_section();
        // Source Section Start
        $this->start_controls_section(
            'source_section',
            [
                'label' => esc_html__('Source Settings', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            $this->add_control(
                'source',
                [
                    'label'    => esc_html__('Select Categories', 'genzia'),
                    'type'     => Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options'  => ctc_get_grid_term_options('post', ['category']),
                ]
            );
            $this->add_control(
                'orderby',
                [
                    'label'   => esc_html__('Order By', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'date',
                    'options' => [
                        'date'   => esc_html__('Date', 'genzia'),
                        'ID'     => esc_html__('ID', 'genzia'),
                        'author' => esc_html__('Author', 'genzia'),
                        'title'  => esc_html__('Title', 'genzia'),
                        'rand'   => esc_html__('Random', 'genzia'),
                    ],
                ]
            );
            $this->add_control(
                'order',
                [
                    'label'   => esc_html__('Sort Order', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'desc',
                    'options' => [
                        'desc' => esc_html__('Descending', 'genzia'),
                        'asc'  => esc_html__('Ascending', 'genzia'),
                    ],
                ]
            );
            $this->add_control(
                'limit',
                [
                    'label' => esc_html__('Total items', 'genzia'),
                    'type'  => Controls_Manager::NUMBER
                ]
            );
        $this->end_controls_section();
    }
}
