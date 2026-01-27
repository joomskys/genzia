<?php
//
namespace Genzia\Elementor\Widgets;
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use CSH_Theme_Core;
//
if(!class_exists('CSH_Theme_Core')) return;
/**
 * Process Widget.
 *
 * Displays process steps or workflow with features and descriptions.
 *
 * @since 1.0.0
 */
class Widget_Process extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_process');
        $this->set_title(esc_html__('CMS Process', 'genzia'));
        $this->set_icon('eicon-flow');
        $this->set_script_depends([
            'swiper',
            'cms-carousel-vertical'
        ]);
        $this->set_style_depends([
            'swiper',
            'e-animation-fadeInUp',
            'e-animation-fadeInLeft',
            'e-animation-slideInUp'
        ]);
        $this->set_keywords(['process', 'workflow', 'steps', 'cms', 'genzia']);

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
    protected function register_controls()
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_process/layout/1.webp'
                        ],
                        '2' => [
                            'title' => esc_html__('Layout 2', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_process/layout/2.webp'
                        ],
                        '-carousel' => [
                            'title' => esc_html__('Layout Carousel', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_process/layout/carousel.webp'
                        ],
                        '-sticky' => [
                            'title' => esc_html__('Layout Sticky', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_process/layout/sticky.webp'
                        ],
                        '-sticky2' => [
                            'title' => esc_html__('Layout Sticky #2', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_process/layout/sticky2.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Process Section
        $this->start_controls_section(
            'section_process',
            [
                'label' => esc_html__('Process Content', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
            $process = new Repeater();
                // Icon
                genzia_elementor_icon_image_settings($process, [
                    'group'        => false,
                    'color'        => false,
                    'icon_default' => []
                ]);
                // Banner
                $process->add_control(
                    'banner',
                    [
                        'label'   => esc_html__('Banner', 'genzia'),
                        'type'    => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src()
                        ],
                        'label_block' => false,
                        'skin'        => 'inline'
                    ]
                );
                // Title
                $process->add_control(
                    'title',
                    [
                        'label'       => esc_html__('Title', 'genzia'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'placeholder' => esc_html__('Process Title', 'genzia'),
                        'default'     => esc_html__('Process Title', 'genzia'),
                        'label_block' => true,
                    ]
                );
                // Content Title
                $process->add_control(
                    'c_title',
                    [
                        'label'       => esc_html__('Content Title', 'genzia'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'placeholder' => esc_html__('Conntent Process Title', 'genzia'),
                        'default'     => esc_html__('Conntent Process Title', 'genzia'),
                        'label_block' => true,
                    ]
                );
                // Description
                $process->add_control(
                    'desc',
                    [
                        'label' => esc_html__('Description', 'genzia'),
                        'type' => Controls_Manager::TEXTAREA
                    ]
                );
                // Feature
                $process->add_control(
                    'features',
                    [
                        'label'       => esc_html__('Features', 'genzia'),
                        'type'        => CSH_Theme_Core::REPEATER_CONTROL,
                        'label_block' => true,
                        'separator'   => 'before',
                        'button_text' => esc_html__('Add Feature', 'genzia'),
                        'controls'    => array(
                            array(
                                'name'        => 'ftitle',
                                'label'       => esc_html__('Feature Text', 'genzia'),
                                'type'        => Controls_Manager::TEXTAREA,
                                'default'     => 'Your feature text',
                                'label_block' => false
                            )
                        ),
                        'classes' => 'cms-title-full'
                    ]
                );
                // Link #1
                genzia_elementor_link_settings($process, [
                    'name' => 'link1_',
                    'mode' => 'btn',
                    'group' => false,
                    'label' => esc_html__('Button #1', 'genzia'),
                    'color' => false
                ]);
                // Link #2
                genzia_elementor_link_settings($process, [
                    'name' => 'link2_',
                    'mode' => 'btn',
                    'group' => false,
                    'label' => esc_html__('Button #2', 'genzia'),
                    'color' => false
                ]);
                // Custom Color
                genzia_elementor_colors_opts($process, [
                    'name'      => 'icon_start_color',
                    'label'     => esc_html__('Icon Color', 'genzia'),
                    'separator' => 'before',
                    'classes'   => 'cms-eseparator',
                    'custom'    => false    
                ]);
                genzia_elementor_colors_opts($process, [
                    'name'      => 'ptitle_color',
                    'label'     => esc_html__('Title Color', 'genzia'),
                    'custom'    => false
                ]);
                genzia_elementor_colors_opts($process, [
                    'name'      => 'ptitle_color_hover',
                    'label'     => esc_html__('Title Color Hover', 'genzia'),
                    'custom'    => false
                ]);
                genzia_elementor_colors_opts($process, [
                    'name'      => 'ptitle_content_color',
                    'label'     => esc_html__('Content Title Color', 'genzia'),
                    'custom'    => false
                ]);
                genzia_elementor_colors_opts($process, [
                    'name'   => 'pdesc_color',
                    'label'  => esc_html__('Desc Color', 'genzia'),
                    'custom' => false
                ]);
                genzia_elementor_colors_opts($process, [
                    'name'   => 'feature_color',
                    'label'  => esc_html__('Feature Color', 'genzia'),
                    'custom' => false
                ]);
                genzia_elementor_colors_opts($process, [
                    'name'      => 'bg_color',
                    'label'     => esc_html__('Background Color', 'genzia'),
                    'custom'    => false
                ]);

            // Lists
            $this->add_control(
                'process_list',
                [
                    'label'   => esc_html__('Process List', 'genzia'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $process->get_controls(),
                    'default' => [
                        [
                            'icon_img_icon' => [],
                            'link1_text'    => 'Click Here',
                            'link2_text'    => 'Click Here #2',
                            'title'         => 'Process title #1',
                            'c_title'       => 'Content Process title #1',
                            'desc'          => 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit'
                        ],
                        [
                            'icon_img_icon' => [],
                            'link1_text'    => 'Click Here',
                            'title'         => 'Process title #2',
                            'c_title'       => 'Content Process title #2',
                            'desc'          => 'There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain'
                        ],
                        [
                            'icon_img_icon' => [],
                            'link1_text'    => 'Click Here',
                            'title'         => 'Process title #3',
                            'c_title'       => 'Content Process title #3',
                            'desc'          => 'Cras rutrum varius accumsan. Aenean ut ligula at libero viverra sodales. Vestibulum nec viverra metus'
                        ],
                        [
                            'icon_img_icon' => [],
                            'link1_text'    => 'Click Here',
                            'title'         => 'Process title #4',
                            'c_title'       => 'Content Process title #4',
                            'desc'          => 'Cras rutrum varius accumsan. Aenean ut ligula at libero viverra sodales. Vestibulum nec viverra metus'
                        ],
                    ],
                    'title_field' => '{{{ title }}}'
                ]
            );
        $this->end_controls_section();
        // Heading Section Start
        $this->start_controls_section(
            'section_heading',
            [
                'label'     => esc_html__('Heading Content', 'genzia'),
                'tab'       => Controls_Manager::TAB_CONTENT
            ]
        );
            // Small Heading
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
                        'layout'             => ['-carousel','-sticky'],
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
                    'layout'                    => ['-carousel','-sticky'],
                    'smallheading_text!'        => '',
                    'smallheading_icon[value]!' => ''
                ]
            ]);
            $this->add_control(
                'smallheading_text',
                [
                    'label'       => esc_html__( 'Small Heading', 'genzia' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is small heading',
                    'placeholder' => esc_html__( 'Enter your text', 'genzia' ),
                    'label_block' => true,
                    'condition' => [
                        'layout' => ['-carousel','-sticky'],
                    ]
                ]
            );
            genzia_elementor_colors_opts($this,[
                'name'      => 'smallheading_color',
                'label'     => esc_html__( 'Color', 'genzia' ),
                'selectors' => [
                    '{{WRAPPER}} .cms-small' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'layout' => ['-carousel','-sticky'],
                    'smallheading_text!' => ''
                ]
            ]);
            // Heading
            $this->add_control(
                'heading_text',
                [
                    'label'       => esc_html__( 'Heading', 'genzia' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the heading',
                    'placeholder' => esc_html__( 'Enter your text', 'genzia' ),
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['2','-carousel','-sticky'],
                    ]
                ]
            );
            genzia_elementor_colors_opts($this,[
                'name'      => 'heading_color',
                'label'     => esc_html__( 'Color', 'genzia' ),
                'selectors' => [
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'layout' => ['2','-carousel','-sticky'],
                    'heading_text!' => ''
                ]
            ]);
            // Description
            $this->add_control(
                'desc',
                [
                    'label'       => esc_html__( 'Description', 'genzia' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the Description',
                    'placeholder' => esc_html__( 'Enter your text', 'genzia' ),
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['-sticky']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this,[
                'name'      => 'desc_color',
                'label'     => esc_html__( 'Color', 'genzia' ),
                'selectors' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'desc!' => '',
                    'layout' => ['-sticky']
                ]
            ]);
            // Button
            genzia_elementor_link_settings($this, [
                'mode'          => 'btn',
                'group'         => false,
                'color_label'   => esc_html__('Button', 'genzia'),
                'text'          => 'Click Here',
                'icon_settings' => [
                    'enable' => true,
                    'selector' => '.cms-heading-btn-icon'
                ],
                'condition' => [
                    'layout' => ['2','-sticky']
                ]
            ]);
        $this->end_controls_section();
        // Style Settings
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Color Settings', 'genzia'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            //
            genzia_elementor_colors_opts($this, [
                'name'      => 'icon_start_color',
                'label'     => esc_html__('Icon Color', 'genzia'),
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .cms-picon' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'ptitle_color',
                'label'     => esc_html__('Title Color', 'genzia'),
                'separator' => 'before',
                'classes'   => 'cms-eseparator',
                'selectors' => [
                    '{{WRAPPER}} .cms-pc-title' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'ptitle_color_hover',
                'label'     => esc_html__('Title Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-pc-title' => '--cms-text-hover-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'ptitle_content_color',
                'label'     => esc_html__('Content Title Color', 'genzia'),
                'separator' => 'before',
                'classes'   => 'cms-eseparator',
                'selectors' => [
                    '{{WRAPPER}} .cms-content-title' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'  => 'pdesc_color',
                'label' => esc_html__('Desc Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-pdesc' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'  => 'feature_color',
                'label' => esc_html__('Feature Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-features' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            // Link/Button #1 Color
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_btn1_color',
                'label'     => esc_html__('Button #1 Color', 'genzia'),
                'separator' => 'before',
                'classes'   => 'cms-eseparator',
                'selectors' => [
                    '{{WRAPPER}} .cms-btn1' => 'background-color:{{VALUE}};'
                ]
            ]);
            // Link/Button #1 Text Color
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_btn1_text_color',
                'label'     => esc_html__('Link/Button #1 Text Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn1' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            // Link/Button #1 Color Hover
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_btn1_color_hover',
                'label'     => esc_html__('Button #1 Color Hover', 'genzia'),
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .cms-btn1:hover' => 'background-color:{{VALUE}};'
                ]
            ]);
            // Link/Button #1 Text Color Hover
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_btn1_text_color_hover',
                'label'     => esc_html__('Link/Button #1 Text Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn1:hover' => '--cms-text-hover-custom:{{VALUE}};'
                ]
            ]);
            // Link/Button #2 Color
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_btn2_color',
                'label'     => esc_html__('Button #2 Color', 'genzia'),
                'separator' => 'before',
                'classes'   => 'cms-eseparator',
                'selectors' => [
                    '{{WRAPPER}} .cms-btn2' => 'border-color:{{VALUE}};'
                ]
            ]);
            // Link/Button #2 Text Color
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_btn2_text_color',
                'label'     => esc_html__('Link/Button #2 Text Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn2' => 'color:{{VALUE}};'
                ]
            ]);
            // Link/Button #2 Color Hover
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_btn2_color_hover',
                'label'     => esc_html__('Button #2 Color Hover', 'genzia'),
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .cms-btn2:hover' => 'border-color:{{VALUE}}!important;background-color:{{VALUE}};'
                ]
            ]);
            // Link/Button #2 Text Color Hover
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_btn2_text_color_hover',
                'label'     => esc_html__('Link/Button #2 Text Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn2:hover' => 'color:{{VALUE}};'
                ]
            ]);
            // Border
            genzia_elementor_colors_opts($this, [
                'name'      => 'bdr_color',
                'label'     => esc_html__('Border Color', 'genzia'),
                'separator' => 'before',
                'classes'   => 'cms-eseparator',
                'selectors' => [
                    '{{WRAPPER}} .cms-border' => '--cms-bdr-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'bg_color',
                'label'     => esc_html__('Background Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-process' => '--cms-bg-custom:{{VALUE}};'
                ]
            ]);
        $this->end_controls_section();
        // Grid Settings
        genzia_elementor_grid_columns_settings($this, [
            'condition' => [
                'layout' => ['1']
            ]
        ]);
    }
}
