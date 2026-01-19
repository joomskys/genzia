<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use CSH_Theme_Core;

/**
 * Button Widget.
 *
 * A widget that displays customizable buttons with various styles and layouts.
 *
 * @since 1.0.0
 */
class Widget_Button extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_button');
        $this->set_title(esc_html__('CMS Button', 'genzia'));
        $this->set_icon('eicon-button');
        $this->set_keywords(['genzia', 'cms button', 'button']);

        parent::__construct($data, $args);
    }

    /**
     * Register Button widget controls.
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
                'tab'   => Controls_Manager::TAB_LAYOUT,
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
                            'title' => esc_html__( 'Layout 1', 'genzia' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_button/layout/1.webp'
                        ],
                        '2' => [
                            'title' => esc_html__( 'Layout 2', 'genzia' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_button/layout/2.webp'
                        ],
                        '3' => [
                            'title' => esc_html__( 'Layout 3', 'genzia' ),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_button/layout/3.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Button Settings
        $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__('Button Settings', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );         
            // Button
            genzia_elementor_link_settings($this, [
                'mode'        => 'btn',
                'group'       => false,
                'color_label' => esc_html__('Button', 'genzia'),
                'text'        => 'Click Here'
            ]);
            //
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
            $this->add_control(
                'size',
                [
                    'label'        => esc_html__( 'Size', 'genzia' ),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => [
                        'btn-xs'  => esc_html__('Extra Small','genzia'),
                        'btn-sm'  => esc_html__('Small','genzia'),
                        'btn-smd' => esc_html__('Small Medium','genzia'),
                        ''        => esc_html__('Default','genzia'),
                        'btn-md'  => esc_html__('Medium','genzia'),
                        'btn-lg'  => esc_html__('Large','genzia'),
                        'btn-xl'  => esc_html__('Extra Large','genzia'),
                        'btn-2xl' => esc_html__('Extra Large #2','genzia'),

                    ],
                    'condition' => [
                        'layout!' => '3'
                    ]
                ]
            );
            $this->add_control(
                'btn_icon',
                [
                    'label'       => esc_html__( 'Icon', 'genzia' ),
                    'type'        => Controls_Manager::ICONS,
                    'skin'        => 'inline',
                    'skin_settings'    => [
                        'inline' => [
                            'icon' => [
                                'url' => get_template_directory().'/assets/svgs/arrow-up-right.svg',
                            ]
                        ]
                    ],
                    'default'     => [
                        /*'value'   => [
                            'url' => get_template_directory().'/assets/svgs/arrow-up-right.svg'
                        ],
                        'library' => 'svg'*/
                    ],
                    'label_block' => false  
                ]
            );
            $this->add_control(
                'icon_align',
                [
                    'label'     => esc_html__( 'Icon Position', 'genzia' ),
                    'type'      => Controls_Manager::SELECT,
                    'default'   => '',
                    'options'   => [
                        ''      => esc_html__( 'Default', 'genzia' ),
                        'first' => esc_html__( 'Before', 'genzia' ),
                        'last'  => esc_html__( 'After', 'genzia' ),
                    ],
                    'condition' => [
                        'btn_icon[value]!' => ''
                    ]
                ]
            );
            $this->add_control(
                'icon_font_size',
                [
                    'label'        => esc_html__( 'Icon Font Size', 'genzia' ),
                    'type'         => Controls_Manager::SLIDER,
                    'control_type' => 'responsive',
                    'size_units'   => [ 'px' ],
                    'range'        => [
                        'px' => [
                            'min' => 5,
                            'max' => 100,
                        ],
                    ],
                    'selectors'    => [
                        '{{WRAPPER}} .cms-btn-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .cms-btn-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'btn_icon[value]!' => ''
                    ]
                ]
            );
            $this->add_control(
                'btn_w',
                [
                    'label'     => esc_html__( 'Button Width', 'genzia' ),
                    'type'      => Controls_Manager::SELECT,
                    'default'   => '',
                    'options'   => [
                        ''      => esc_html__( 'Default', 'genzia' ),
                        'w-100' => esc_html__( 'Full', 'genzia' ),
                    ],
                    'separator' => 'before',
                    'classes'   => 'cms-eseparator'
                ]
            );
        $this->end_controls_section();
    }
}
