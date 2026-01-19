<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Copyright Widget.
 *
 * A widget that displays copyright information with customizable text
 * and styling options.
 *
 * @since 1.0.0
 */
class Widget_Copyright extends Widget_Base
{
    /**
     * Constructor for initializing the widget.
     *
     * @since 1.0.0
     * @access public
     * @param array      $data Widget data.
     * @param array|null $args Widget arguments.
     */
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_copyright');
        $this->set_title(esc_html__('CMS Copyright', 'genzia'));
        $this->set_icon('eicon-menu-bar');
        $this->set_keywords(['copyright', 'footer', 'cms', 'genzia']);

        parent::__construct($data, $args);
    }

    /**
     * Register Copyright widget controls.
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
                'label' => esc_html__( 'Copyright', 'genzia' ),
                'tab' => Controls_Manager::TAB_LAYOUT,
            ]
        );
        $this->add_control(
            'layout',
            [
                'label'   => esc_html__( 'Templates', 'genzia' ),
                'type'    => Controls_Manager::VISUAL_CHOICE,
                'default' => '1',
                'options' => [
                    '1' => [
                        'label' => esc_html__( 'Layout 1', 'genzia' ),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_copyright/layout/1.webp'
                    ]
                ]
            ]
        );
        $this->end_controls_section();
        // Content Settings
        $this->start_controls_section(
            'setting_section',
            [
                'label'    => esc_html__('Settings', 'genzia'),
                'tab'      => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control(
            'copyright_text',
            [
                'label'       => esc_html__('Copyright Text', 'genzia'),
                'type'        => Controls_Manager::WYSIWYG,
                'description' => esc_html__('Use [[year]] variable to insert current year, [[name]] variable to insert site name.', 'genzia'),
                'label_block' => true,
                'default'     => genzia_default_copyright_text(),
            ]
        );
        
        $this->end_controls_section();
        // Style
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Style', 'genzia'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_responsive_control(
            'align',
            [
                'label'        => esc_html__( 'Alignment', 'genzia' ),
                'type'         => Controls_Manager::CHOOSE,
                'responsive'   => true,
                'options'      => [
                    'start'    => [
                        'title' => esc_html__( 'Left', 'genzia' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => esc_html__( 'Center', 'genzia' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'end'   => [
                        'title' => esc_html__( 'Right', 'genzia' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'genzia' ),
                        'icon' => 'eicon-text-align-justify',
                    ]
                ],
                'prefix_class' => 'text%s-'
            ]
        );
            genzia_elementor_colors_opts($this, [
                'name'      => 'text_color',
                'selectors' => [
                    '{{WRAPPER}} .cms-ecopyright' => 'color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_color',
                'label'     => esc_html__('Link Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} a' => 'color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_color_hover',
                'label'     => esc_html__('Link Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} a:hover' => 'color:{{VALUE}};'
                ]
            ]);
        $this->end_controls_section();
    }
}
?>