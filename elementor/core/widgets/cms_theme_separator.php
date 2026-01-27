<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Heading Widget.
 *
 * Displays headings with customizable features like small heading, description,
 * buttons, features list and banner image.
 *
 * @since 1.0.0
 */
class Widget_Genzia_Separator extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_theme_separator');
        $this->set_title(esc_html__('CMS Genzia Separator', 'genzia'));
        $this->set_icon('eicon-divider');
        $this->set_keywords(['divider', 'separator', 'cms', 'genzia', 'cms divider', 'cms separator']);
        $this->set_script_depends(['']);
        $this->set_style_depends(['e-animation-fadeInUp']);

        parent::__construct($data, $args);
    }

    /**
     * Register Heading widget controls.
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
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_theme_separator/layout/1.webp'
                    ],
                    '2' => [
                        'title' => esc_html__('Layout 2', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_theme_separator/layout/2.webp'
                    ]
                ],
                'label_block' => true
            ]
        );
        $this->end_controls_section();
        // Heading Content
        $this->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__('Separator Content', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            $this->add_control(
                'separaror_icon',
                [
                    'label'   => esc_html__('Icon', 'genzia'),
                    'type'    => Controls_Manager::ICONS,
                    'default' => [
                        'value'   => 'fas fa-star',
                        'library' => 'fa-solid'
                    ],
                    'skin'        => 'inline',
                    'label_block' => false,
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'separator_icon_color',
                'label'     => esc_html__('Icon Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}}' => '--cms-text-custom: {{VALUE}};'
                ],
                'condition' => [
                    //'separaror_icon[value]!' => ''
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'separator_color',
                'label'     => esc_html__('Separator Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}}' => '--cms-bdr-custom: {{VALUE}};'
                ]
            ]);
        $this->end_controls_section();
        // Style
        $this->start_controls_section(
            'style_settings',
            [
                'label' => esc_html__('Style Settings','genzia'),
                'tab'   => Controls_Manager::TAB_SETTINGS
            ]
        );
            $this->add_control(
                'e_classes',
                [
                    'label'   => esc_html__('CSS Classes', 'genzia'),
                    'type'    => Controls_Manager::TEXT,
                    'default' => '',
                    'title'   => esc_html__('Add your custom class WITHOUT the dot. e.g: my-class', 'genzia'),
                    'classes' => 'elementor-control-direction-ltr',
                ]
            );
        $this->end_controls_section();
    }
}
