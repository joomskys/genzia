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
                            'title' => esc_html__('Layout 2', 'genzia'),
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
                        '-sticky-black' => [
                            'title' => esc_html__('Layout Sticky (Black)', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_process/layout/sticky-black.webp'
                        ],
                        '-sticky2' => [
                            'title' => esc_html__('Layout Sticky #2', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_process/layout/sticky2.webp'
                        ],
                        '-sticky2-black' => [
                            'title' => esc_html__('Layout Sticky #2 (Black)', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_process/layout/sticky2-black.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Heading Section Start
        $this->start_controls_section(
            'section_heading',
            [
                'label'     => esc_html__('Heading Content', 'genzia'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => '-carousel'
                ]
            ]
        );
            // Small Heading
            $this->add_control(
                'smallheading_text',
                [
                    'label'       => esc_html__( 'Small Heading', 'genzia' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is small heading',
                    'placeholder' => esc_html__( 'Enter your text', 'genzia' ),
                    'label_block' => true
                ]
            );
            genzia_elementor_colors_opts($this,[
                'name'      => 'smallheading_color',
                'label'     => esc_html__( 'Color', 'genzia' ),
                'selectors' => [
                    '{{WRAPPER}} .cms-small' => 'color: {{VALUE}};',
                ],
                'condition' => [
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
                    'label_block' => true
                ]
            );
            genzia_elementor_colors_opts($this,[
                'name'      => 'heading_color',
                'label'     => esc_html__( 'Color', 'genzia' ),
                'selectors' => [
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'heading_text!' => ''
                ]
            ]);
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
                    'title_field' => '{{{ title }}}',
                    'condition'   => [
                        'layout!' => ['2']
                    ]
                ]
            );
            // Process #2
            $process2 = new Repeater();
                // Year
                $process2->add_control(
                    'year',
                    [
                        'label'       => esc_html__('Year', 'genzia'),
                        'type'        => Controls_Manager::TEXT,
                        'label_block' => true,
                    ]
                );
                // Title
                $process2->add_control(
                    'title',
                    [
                        'label'       => esc_html__('Title', 'genzia'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'placeholder' => esc_html__('Process Title', 'genzia'),
                        'default'     => esc_html__('Process Title', 'genzia'),
                        'label_block' => true,
                    ]
                );
            $this->add_control(
                'process_list2',
                [
                    'label'   => esc_html__('Process List', 'genzia'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $process2->get_controls(),
                    'default' => [
                        [
                            'year'    => '2020',
                            'title'   => 'Process title #1'
                        ],
                        [
                            'year'    => '2021',
                            'title'   => 'Process title #2'
                        ],
                        [
                            'year'    => '2022',
                            'title'   => 'Process title #3'
                        ],
                        [
                            'year'    => '2023',
                            'title'   => 'Process title #4'
                        ],
                        [
                            'year'    => '2024',
                            'title'   => 'Process title #5'
                        ],
                        [
                            'year'    => '2025',
                            'title'   => 'Process title #6'
                        ],
                    ],
                    'title_field' => '{{{ title }}}',
                    'condition'   => [
                        'layout' => ['2']
                    ]
                ]
            );
            //
            genzia_elementor_colors_opts($this, [
                'name'      => 'icon_start_color',
                'label'     => esc_html__('Icon Start Color', 'genzia'),
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .cms-picon' => 'color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'ptitle_color',
                'label'     => esc_html__('Title Color', 'genzia'),
                'separator' => 'before',
                'classes'   => 'cms-eseparator',
                'selectors' => [
                    '{{WRAPPER}} .cms-pc-title' => 'color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'  => 'pdesc_color',
                'label' => esc_html__('Desc Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-pdesc' => 'color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'  => 'feature_color',
                'label' => esc_html__('Feature Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-features' => 'color:{{VALUE}};'
                ]
            ]);
            // Link/Button #1 Color
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_btn_color',
                'label'     => esc_html__('Button #1 Color', 'genzia'),
                'separator' => 'before',
                'classes'   => 'cms-eseparator',
                'selectors' => [
                    '{{WRAPPER}} .cms-btn1' => 'background-color:{{VALUE}};'
                ]
            ]);
            // Link/Button #1 Text Color
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_btn_text_color',
                'label'     => esc_html__('Link/Button #1 Text Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn1' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            // Link/Button #1 Color Hover
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_btn_color_hover',
                'label'     => esc_html__('Button #1 Color Hover', 'genzia'),
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .cms-btn1:hover' => 'background-color:{{VALUE}};'
                ]
            ]);
            // Link/Button #1 Text Color Hover
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_btn_text_color_hover',
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
                    '{{WRAPPER}} .cms-border' => 'border-color:{{VALUE}};'
                ]
            ]);
            /*genzia_elementor_colors_opts($this, [
                'name'      => 'bg_color',
                'label'     => esc_html__('Background Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-process' => 'background-color:{{VALUE}};'
                ]
            ]);*/
        $this->end_controls_section();
        // Grid Settings
        genzia_elementor_grid_columns_settings($this, [
            'condition' => [
                'layout' => ['1']
            ]
        ]);
    }
}
