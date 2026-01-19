<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/**
 * Posts Carousel Widget.
 *
 * Posts carousel widget that displays posts in a carousel/slider format
 * with various layout options and customization settings.
 *
 * @since 1.0.0
 */
class Widget_Posts_Carousel extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_posts_carousel');
        $this->set_title(esc_html__('CMS Posts Carousel', 'genzia'));
        $this->set_icon('eicon-posts-carousel');
        $this->set_keywords(['posts', 'carousel', 'slider', 'blog', 'genzia']);
        $this->set_script_depends(['cms-elementor-custom', 'cms-post-carousel-widget-js']);
        $this->set_style_depends(['swiper']);
        
        parent::__construct($data, $args);
    }

    /**
     * Register Posts Carousel widget controls.
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
                    'options'     => genzia_elementor_post_layouts(),
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Element Heading
        $this->start_controls_section(
            'e_heading',
            [
                'label'     => esc_html__('Element Heading', 'genzia'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['1']
                ]
            ]
        ); 
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
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};'
                ]
            ]);
        $this->end_controls_section();
        // Source Section Start
        genzia_elementor_post_source_settings($this);
        
        // Display Section Start
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
                    'name'    => 'thumbnail',
                    'default' => 'custom',
                ]
            );

            $this->add_control(
                'num_line',
                [
                    'label'       => esc_html__('Excerpt Length', 'genzia'),
                    'description' => esc_html__('Enter number of line you want to show, max is 10', 'genzia'),
                    'type'        => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 10,
                        ]
                    ],
                    'default' => [
                        'size' => '',
                    ],
                    'separator'   => 'before',
                ]
            );

            $this->add_control(
                'readmore_text',
                [
                    'label'       => esc_html__('Readmore Text', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Read More','genzia'),
                ]
            );
        $this->end_controls_section();
        // Filter Section
        $this->start_controls_section(
            'filter_section',
            [
                'label' => esc_html__('Filter', 'genzia'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );
            genzia_elementor_filter_settings($this);
        $this->end_controls_section();

        // Carousel Section
        genzia_elementor_carousel_settings($this);
    }
}
