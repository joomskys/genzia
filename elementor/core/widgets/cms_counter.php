<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
/**
 * Counter Widget.
 *
 * A widget that displays animated counters with various
 * layout options and customizable styles.
 *
 * @since 1.0.0
 */
class Widget_Counter extends Widget_Base
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
        $this->set_name('cms_counter');
        $this->set_title(esc_html__('CMS Counter', 'genzia'));
        $this->set_icon('eicon-counter');
        $this->set_keywords(['counter', 'number', 'animation', 'cms', 'genzia']);
        $this->set_script_depends(['jquery-numerator','cms-elementor-custom','cms-pointer']);

        parent::__construct($data, $args);
    }

    /**
     * Register Counter widget controls.
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
            'layout_mode',
            [
                'label'   => esc_html__('Layout Mode', 'genzia'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'grid'     => esc_html__('Grid', 'genzia'),
                    'carousel' => esc_html__('Carousel', 'genzia')
                ],
                'default'   => 'grid'
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_counter/layout/1.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Reapeater Counter
        $this->start_controls_section(
            'section_counters',
            [
                'label' => esc_html__('Counters Settings', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );
            $counters = new Repeater();
                $counters->add_control(
                    'starting_number',
                    [
                        'label'   => esc_html__( 'Starting Number', 'genzia' ),
                        'type'    => Controls_Manager::NUMBER,
                        'default' => 1,
                    ]
                );
                $counters->add_control(
                    'ending_number',
                    [
                        'label'   => esc_html__( 'Ending Number', 'genzia' ),
                        'type'    => Controls_Manager::NUMBER,
                        'default' => 100,
                    ]
                );
                $counters->add_control(
                    'prefix',
                    [
                        'label'       => esc_html__( 'Number Prefix', 'genzia' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => '',
                        'placeholder' => '1',
                    ]
                );
                $counters->add_control(
                    'suffix',
                    [
                        'label'       => esc_html__( 'Number Suffix', 'genzia' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => '',
                        'placeholder' => '+',
                    ]
                );
                $counters->add_control(
                    'duration',
                    [
                        'label'   => esc_html__( 'Animation Duration', 'genzia' ),
                        'type'    => Controls_Manager::NUMBER,
                        'default' => 3000,
                        'min'     => 100,
                        'step'    => 100,
                    ]
                );
                $counters->add_control(
                    'thousand_separator_char',
                    [
                        'label'     => esc_html__( 'Separator', 'genzia' ),
                        'type'      => Controls_Manager::SELECT,
                        'options'   => [
                            ''  => 'Default',
                            ',' => 'Comma',
                            '.' => 'Dot',
                            ' ' => 'Space',
                        ],
                        'default'   => '',
                    ]
                );
                genzia_elementor_icon_image_settings($counters, [
                    'group'            => false,
                    'color'            => false,
                    'name'             => 'counter_icon',
                    'type'             => 'icon',
                    // icon
                    'icon_default'     => [],
                    //image
                    'img_default_size' => 'custom',
                    'separator'        => 'before'
                ]);
                $counters->add_control(
                    'title',
                    [
                        'label'       => esc_html__( 'Title', 'genzia' ),
                        'type'        => Controls_Manager::TEXTAREA,
                        'label_block' => true,
                        'default'     => 'Counter',
                        'placeholder' => esc_html__( 'Enter your Title', 'genzia' ),
                    ]
                );
                $counters->add_control(
                    'description',
                    [
                        'label'       => esc_html__( 'Description', 'genzia' ),
                        'type'        => Controls_Manager::TEXTAREA,
                        'label_block' => true,
                        'default'     => 'Turpis massa tincidunt dui ut. Sit amet nisl purus in mollis nunc. Id neque aliquam vestibulum morbi blandit cursus risus',
                        'placeholder' => esc_html__( 'Enter your text', 'genzia' )
                    ]
                );
                $counters->add_control(
                    'link_text',
                    [
                        'label'       => esc_html__( 'Link Text', 'genzia' ),
                        'description' => esc_html__( 'Link Settings', 'genzia' ),
                        'type'        => Controls_Manager::TEXT,
                        'label_block' => false,
                        'classes'     => 'cms-description-as-label'  
                    ]
                );
                $counters->add_control(
                    'link_url',
                    [
                        'label'       => esc_html__( 'Link URL', 'genzia' ),
                        'type'        => Controls_Manager::URL,
                        'label_block' => false,
                    ]
                );
            // add counter item
            $this->add_control(
                'counters',
                [
                    'label'  => esc_html__('Counters List', 'genzia'),
                    'type'   => Controls_Manager::REPEATER,
                    'fields' => $counters->get_controls(),
                    'default' => [
                        [
                            'starting_number' => '1',
                            'ending_number'   => '300',
                            'prefix'          => '',
                            'suffix'          => 'K',
                            'title'           => 'Counter Title #1',
                            'postion'         => [
                                'unit' => '%',
                                'top'  => '18',
                                'left' => '32'
                            ]
                        ],
                        [
                            'starting_number' => '1',
                            'ending_number'   => '99',
                            'prefix'          => '',
                            'suffix'          => '%',
                            'title'           => 'Counter Title #2',
                            'postion'         => [
                                'unit' => '%',
                                'top'  => '58',
                                'left' => '42'
                            ]
                        ]
                    ],
                    'title_field' => '{{{ title }}}'
                ]
            );
        $this->end_controls_section();
        // Style Section Start
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style Settings', 'genzia'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );  
            $this->add_responsive_control(
                'text_align',
                [
                    'label'   => esc_html__('Text Alignment', 'genzia'),
                    'type'    => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'start' => [
                            'title' => esc_html__('Start', 'genzia'),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', 'genzia'),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'end' => [
                            'title' => esc_html__('End', 'genzia'),
                            'icon'  => 'fa fa-align-right',
                        ],
                    ],
                    'condition' => [
                        'layout' => ['3']
                    ],
                    'prefix_class' => 'text%s-'
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'number_color',
                'label'     => esc_html__('Number Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-counter-numbers' => 'color: {{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'icon_color',
                'label'     => esc_html__('Icon Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-counter-icon' => 'color: {{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'icon_color_end',
                'label'     => esc_html__('Icon Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-counter-icon:hover' => 'color: {{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'title_color',
                'label'     => esc_html__('Title Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-counter-title' => 'color: {{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'desc_color',
                'label'     => esc_html__('Description Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-counter-desc' => 'color: {{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_color',
                'label'     => esc_html__('Link Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-link' => 'color: {{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_color_hover',
                'label'     => esc_html__('Link Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-link:hover' => 'color: {{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'border_color',
                'label'     => esc_html__('Border Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-divider' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .cms-bdr'     => 'border-color: {{VALUE}};',
                ]
            ]);
        $this->end_controls_section();
        // Start Settings
        genzia_elementor_grid_columns_settings($this,[
            'align'     => true,
            'condition' => [
                'layout_mode' => 'grid'
            ]
        ]);
        // Carousel
        genzia_elementor_carousel_settings($this, [
            'condition' => [
                'layout_mode' => 'carousel'
            ]
        ]);
    }
}
