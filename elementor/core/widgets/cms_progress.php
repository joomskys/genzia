<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use CSH_Theme_Core;

/**
 * Process Widget.
 *
 * Process widget that displays process steps or workflow with features and descriptions
 * in various layout configurations including sticky layouts.
 *
 * @since 1.0.0
 */
class Widget_Progress extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_progress');
        $this->set_title(esc_html__('CMS Progress', 'genzia'));
        $this->set_icon('eicon-skill-bar');
        $this->set_script_depends([
            'jquery-numerator',
            'cms-elementor-custom'
        ]);
        //$this->set_style_depends([]);
        
        $this->set_keywords(['progress', 'cms', 'genzia']);

        parent::__construct($data, $args);
    }

    /**
     * Register Process widget controls.
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_progress/layout/1.webp'
                        ],
                        '2' => [
                            'title' => esc_html__('Layout 2', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_progress/layout/2.webp'
                        ],
                        '3' => [
                            'title' => esc_html__('Layout 3', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_progress/layout/3.webp'
                        ],
                        '4' => [
                            'title' => esc_html__('Layout 4', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_progress/layout/4.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Content Section Start
        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__('Content Settings', 'genzia'),
                'tab'       => Controls_Manager::TAB_CONTENT
            ]
        );
            $this->add_control(
                'small_title',
                [
                    'label'       => esc_html__('Small Title', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Small Title',
                    'placeholder' => esc_html__('Enter your small title', 'genzia'),
                    'condition'   => [
                        'layout' => ['3']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'small_title_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-small' => 'color:{{VALUE}};'
                ],
                'condition' => [
                    'layout' => ['3'],
                    'small_title!' => ''
                ]
            ]);
            $this->add_control(
                'title',
                [
                    'label'       => esc_html__('Title', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Your Title',
                    'placeholder' => esc_html__('Enter your title', 'genzia'),
                    'condition' => [
                        'layout' => ['2','3','4']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'title_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-title' => 'color:{{VALUE}};'
                ],
                'condition' => [
                    'layout' => ['2','3','4'],
                    'title!' => ''
                ]
            ]);
            $this->add_control(
                'text',
                [
                    'label'       => esc_html__('Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Your Description',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'condition' => [
                        'layout' => ['2','3']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'text_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-desc' => 'color:{{VALUE}};'
                ],
                'condition' => [
                    'layout' => ['2','3'],
                    'text!' => ''
                ]
            ]);
        $this->end_controls_section();
        // Progressbar Section Start
        $this->start_controls_section(
            'section_progressbar',
            [
                'label' => esc_html__('Progressbar Content', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
            $progressbar = new Repeater();
                $progressbar->add_control(
                    'title',
                    [
                        'label'       => esc_html__( 'Title', 'genzia' ),
                        'type'        => Controls_Manager::TEXT,
                        'placeholder' => esc_html__( 'Enter your title', 'genzia' ),
                        'default'     => 'Your Title',
                        'label_block' => true,
                    ]
                );
                $progressbar->add_control(
                    'percent',
                    [
                        'label'       => esc_html__( 'Value', 'genzia' ),
                        'type'        => Controls_Manager::SLIDER,
                        'default'     => [
                            'size' => 80
                        ],
                        'label_block' => true,
                    ]
                );
                $progressbar->add_control(
                    'prefix',
                    [
                        'label'       => esc_html__( 'Prefix', 'genzia' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => '',
                        'label_block' => false,
                    ]
                );
                $progressbar->add_control(
                    'suffix',
                    [
                        'label'       => esc_html__( 'Suffix', 'genzia' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => '%',
                        'label_block' => false,
                    ]
                );
                genzia_elementor_colors_opts($progressbar, [
                    'name'      => 'color',
                    'label'     => esc_html__('Color', 'genzia'),
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.cms-progress-bar' => 'background-color:{{VALUE}};'
                    ]
                ]);
            $this->add_control(
                'progressbar_list',
                [
                    'label'   => esc_html__('List', 'genzia'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $progressbar->get_controls(),
                    'default' => [
                        [
                            'title'   => 'Your Title #1',
                            'percent' => [
                                'size' => 95
                            ]
                        ],
                        [
                            'title'   => 'Your Title #2',
                            'percent' => [
                                'size' => 88
                            ]
                        ],
                        [
                            'title'   => 'Your Title #3',
                            'percent' => [
                                'size' => 99
                            ]
                        ],
                        [
                            'title'   => 'Your Title #4',
                            'percent' => [
                                'size' => 85
                            ]
                        ]
                    ],
                    'title_field' => '{{{ title }}}',
                ]
            );
        $this->end_controls_section();
        // Color 
        $this->start_controls_section(
            'section_color',
            [
                'label' => esc_html__('Color Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
            $this->add_control(
                'pbar_wrap_width',
                [
                    'label'       => esc_html__( 'Progress wrap Width', 'genzia' ),
                    'type'        => Controls_Manager::NUMBER,
                    'min'         => 280,
                    //'max'         => 900,
                    'default'     => 384,
                    'label_block' => false,
                    'condition'   => [
                        'layout' => ['4']
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-eprogress-bar' => 'max-width:{{VALUE}}px;'
                    ]
                ]
            );
            $this->add_control(
                'pbar_wrap_height',
                [
                    'label'       => esc_html__( 'Progress wrap Height', 'genzia' ),
                    'type'        => Controls_Manager::NUMBER,
                    'min'         => 100,
                    'max'         => 900,
                    'default'     => 242,
                    'label_block' => false,
                    'condition'   => [
                        'layout' => ['4']
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-eprogress' => '--min-h:{{VALUE}}px;'
                    ]
                ]
            );
            $this->add_control(
                'pbar_height',
                [
                    'label'       => esc_html__( 'Progress bar Width/Height', 'genzia' ),
                    'type'        => Controls_Manager::NUMBER,
                    'min'         => 6,
                    'max'         => 600,
                    'label_block' => false
                ]
            );
            genzia_elementor_colors_opts($progressbar, [
                'name'      => 'pbar_bg',
                'label'     => esc_html__('Progress bar Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-progress-bar' => 'background-color:{{VALUE}};',
                    '{{WRAPPER}}' => '--cms-progress-bg:{{VALUE}}'
                ]
            ]);
            genzia_elementor_colors_opts($progressbar, [
                'name'      => 'ptitle_color',
                'label'     => esc_html__('Title Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-progress-bar-title' => 'color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($progressbar, [
                'name'      => 'pnumber_color',
                'label'     => esc_html__('Number Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-progress-barnumber' => 'color:{{VALUE}};'
                ]
            ]);
        $this->end_controls_section();
        // Background 
        $this->start_controls_section(
            'section_background',
            [
                'label'     => esc_html__('Background Settings', 'genzia'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => ['3','4']
                ]
            ]
        );
            $this->add_control(
                'bg_image',
                [
                    'label'   => esc_html__('Background Image', 'genzia'),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ]
                ]
            );
            $this->add_control(
                'bg_overlay',
                [
                    'label'   => esc_html__('Gradient Overlay', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => genzia_elementor_gradient_opts(),
                    'default' => ''
                ]
            );
        $this->end_controls_section();
    }
}