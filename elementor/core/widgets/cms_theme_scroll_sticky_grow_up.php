<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Widget_Theme_Scroll_Sticky_Grow_Up extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_theme_scroll_sticky_grow_up');
        $this->set_title(esc_html__('CMS Scroll Sticky Growup', 'genzia'));
        $this->set_icon('eicon-scroll');
        $this->set_keywords(['scroll sticky growup', 'scroll', 'sticky', 'growup']);
        $this->set_script_depends([
            'etc-scroller',
            'cms-scroll-sticky-grow-up'
        ]);
        //$this->set_style_depends(['e-animation-fadeLeft','e-animation-fadeInRight','e-animation-fadeInUp']);
        //
        parent::__construct($data, $args);
    }

    /**
     * Register Scroll Sticky GrowUp widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls(): void
    {
        // Layout
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout/1.webp'
                        ],
                        '2' => [
                            'title' => esc_html__('Layout 2', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout/2.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Content
        $this->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__('Heading Content', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            $this->add_control(
                'heading_text',
                [
                    'label'       => esc_html__( 'Heading', 'genzia' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the heading',
                    'placeholder' => esc_html__( 'Enter your text', 'genzia' ),
                    'label_block' => true
                ]
            );
            genzia_elementor_colors_opts($this,[
                'name'      => 'heading_color',
                'label'     => esc_html__( 'Color', 'genzia' ),
                'condition' => [
                    'heading_text!' => ''
                ]
            ]);
            genzia_elementor_colors_opts($this,[
                'name'      => 'heading_color2',
                'label'     => esc_html__( 'Color On Image', 'genzia' ),
                'condition' => [
                    'heading_text!' => ''
                ]
            ]);
            $this->add_control(
                'banner',
                [
                    'label'   => esc_html__( 'Banner', 'genzia' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'label_block' => false,
                    'skin'        => 'inline',
                    'condition' => [
                        'heading_text!' => ''
                    ]
                ]
            );
        $this->end_controls_section();
    }
}
