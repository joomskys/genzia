<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Language Switcher Widget.
 *
 * Displays a language switcher with various display options.
 *
 * @since 1.0.0
 */
class Widget_Language_Switcher extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_language_switcher');
        $this->set_title(esc_html__('CMS Language Switcher', 'genzia'));
        $this->set_icon('eicon-globe');
        $this->set_keywords(['language', 'switcher', 'translator', 'multilingual', 'genzia']);
        parent::__construct($data, $args);
    }

    /**
     * Register Language Switcher widget controls.
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_language_switcher/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__('Layout 2', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_language_switcher/layout/2.webp'
                        ]
                    ]
                ]
            );
        $this->end_controls_section();

        // Settings
        $this->start_controls_section(
            'setting_section',
            [
                'label' => esc_html__('Settings', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );
            $this->add_control(
                'show_flag',
                [
                    'label'   => esc_html__('Show Flag', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''    => esc_html__('Default', 'genzia'),
                        'yes' => esc_html__('Yes', 'genzia'),
                        'no'  => esc_html__('No', 'genzia')
                    ]
                ]
            );
            $this->add_control(
                'show_name',
                [
                    'label'   => esc_html__('Show Name', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''    => esc_html__('Default', 'genzia'),
                        'yes' => esc_html__('Yes', 'genzia'),
                        'no'  => esc_html__('No', 'genzia')
                    ]
                ]
            );
            $this->add_control(
                'name_as',
                [
                    'label'   => esc_html__('Name As', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''      => esc_html__('Default', 'genzia'),
                        'full'  => esc_html__('Full', 'genzia'),
                        'short' => esc_html__('Short', 'genzia')
                    ],
                    'condition' => [
                        'show_name' => ['yes']
                    ]
                ]
            );

            $this->add_control(
                'dropdown_pos',
                [
                    'label'   => esc_html__('Dropdown Position', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''       => esc_html__('Default', 'genzia'),
                        'top'    => esc_html__('Top', 'genzia'),
                        'bottom' => esc_html__('Bottom', 'genzia')
                    ]
                ]
            );
        $this->end_controls_section();

        // Style
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
            genzia_elementor_colors_opts($this, [
                'name'     => 'color',
                'label'    => esc_html__('Color', 'genzia'),
                'selector' => [
                    '{{WRAPPER}} .current-language' => 'color: {{VALUE}};',
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'     => 'color_hover',
                'label'    => esc_html__('Color Hover & Active', 'genzia'),
                'selector' => [
                    '{{WRAPPER}} .current-language:hover' => 'color: {{VALUE}};',
                ]
            ]);
        $this->end_controls_section();
    }
}