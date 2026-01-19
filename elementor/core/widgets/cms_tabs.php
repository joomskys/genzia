<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use CSH_Theme_Core;

/**
 * Tabs Widget.
 *
 * Tabs widget that displays process steps or workflow with features and descriptions
 * in various layout configurations including sticky layouts.
 *
 * @since 1.0.0
 */
class Widget_Tabs extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_tabs');
        $this->set_title(esc_html__('CMS Tabs', 'genzia'));
        $this->set_icon('eicon-tabs');
        $this->set_keywords(['tabs', 'cms', 'genzia']);
        $this->set_script_depends(['cms-elementor-custom', 'cms-post-carousel-widget-js']);
        $this->set_style_depends(['swiper', 'e-animation-fadeIn']);

        parent::__construct($data, $args);
    }

    /**
     * Register Tabs widget controls.
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
                        'title' => esc_html__('Layout 1', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_tabs/layout/1.webp'
                    ],
                    '2' => [
                        'title' => esc_html__('Layout 2', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_tabs/layout/2.webp'
                    ],
                    '3' => [
                        'title' => esc_html__('Layout 3', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_tabs/layout/3.webp'
                    ],
                    '4' => [
                        'title' => esc_html__('Layout 4', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_tabs/layout/4.webp'
                    ],
                    '5' => [
                        'title' => esc_html__('Layout 5', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_tabs/layout/5.webp'
                    ],
                    '6' => [
                        'title' => esc_html__('Layout 6', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_tabs/layout/6.webp'
                    ]
                ],
                'label_block' => true
            ]
        );
        $this->end_controls_section();
        // Element Heading
        $this->start_controls_section(
            'section_heading',
            [
                'label'     => esc_html__('Element Heading', 'genzia'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => []
            ]
        );
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
                        'layout' => ['4'],
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
                    'layout'                    => ['4'],
                    'smallheading_text!'        => '',
                    'smallheading_icon[value]!' => ''
                ]
            ]);
            $this->add_control(
                'smallheading_text',
                [
                    'label'       => esc_html__('Small Heading', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Small Heading',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['2', '4', '5']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'smallheading_color',
                'label'     => esc_html__('Color', 'genzia'),
                'condition' => [
                    'layout'             => ['2', '4', '5'],
                    'smallheading_text!' => ''
                ]
            ]);
            $this->add_control(
                'heading_text',
                [
                    'label'       => esc_html__('Heading', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the heading',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['2', '4', '5']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'heading_color',
                'label'     => esc_html__('Color', 'genzia'),
                'condition' => [
                    'layout'        => ['2', '4', '5'],
                    'heading_text!' => ''
                ]
            ]);
            // Description #1
            $this->add_control(
                'desc',
                [
                    'label'       => esc_html__('Description #1', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Lorem Ipsum is simply dummy text of the printing and typesetting story. Lorem Ipsum has been the story standard dummy text ever since',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'rows'        => 10,
                    'condition'   => [
                        'layout' => ['2', '5']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'desc_color',
                'label'     => esc_html__('Color', 'genzia'),
                'condition' => [
                    'layout' => ['2', '5'],
                    'desc!' => ''
                ]
            ]);
            // Description #2
            $this->add_control(
                'desc2',
                [
                    'label'       => esc_html__('Description #2', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'rows'        => 10,
                    'condition'   => [
                        'layout' => ['2']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'desc2_color',
                'label'     => esc_html__('Color', 'genzia'),
                'condition' => [
                    'layout' => ['2'],
                    'desc2!' => ''
                ]
            ]);
        $this->end_controls_section();
        // Content Settings
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Tabs Settings', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            $content = new Repeater();
            $content->add_control(
                'tab_title',
                [
                    'label'   => esc_html__('Tab Title', 'genzia'),
                    'type'    => Controls_Manager::TEXT,
                    'default' => 'Tab Title',
                ]
            );
            $content->add_control(
                'title',
                [
                    'label'   => esc_html__('Title', 'genzia'),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => 'Your Title',
                ]
            );
            $content->add_control(
                'desc',
                [
                    'label'   => esc_html__('Description', 'genzia'),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                ]
            );
            $content->add_control(
                'banner',
                [
                    'label'   => esc_html__('Banner', 'genzia'),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                    'label_block' => false
                ]
            );
            $content->add_control(
                'icon',
                [
                    'label'   => esc_html__('Icon', 'genzia'),
                    'type'    => Controls_Manager::ICONS,
                    'default' => [
                        'value'   => 'fas fa-star',
                        'library' => 'fa-solid'
                    ],
                    'skin' => 'inline',
                    'label_block' => false
                ]
            );
            $content->add_control(
                'icon_title',
                [
                    'label'   => esc_html__('Icon Title', 'genzia'),
                    'type'    => Controls_Manager::TEXT,
                    'default' => 'Icon Title',
                    'condition' => [
                        'icon[value]!' => '' 
                    ]
                ]
            );
            $content->add_control(
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
            genzia_elementor_link_settings($content, [
                'name' => 'link1_',
                'mode' => 'link',
                'type' => [
                    //'post'        => esc_html__('Post','genzia'),
                    //'cms-practice' =>  esc_html__('CMS Practice','genzia'),
                    //'cms-case'    => esc_html__('CMS Case','genzia'),
                    //'cms-career'  => esc_html__('CMS Career','genzia')
                ],
                'group' => false,
                'label' => esc_html__('Link Settings', 'genzia'),
                'color' => false
            ]);
            $this->add_control(
                'contents',
                [
                    'label'   => esc_html__('Tabs Content', 'genzia'),
                    'type'    => \Elementor\Controls_Manager::REPEATER,
                    'fields'  => $content->get_controls(),
                    'default' => [
                        [
                            'banner' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'icon' => [
                                'value'   => 'fas fa-star',
                                'library' => 'fa-solid'
                            ],
                            'icon_title' => 'Icon Title #1',
                            'tab_title'  => 'Tab Title #1',
                            'title'      => 'Your Title #1',
                            'desc'       => '#1 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'
                        ],
                        [
                            'banner' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'icon' => [
                                'value'   => 'fas fa-star',
                                'library' => 'fa-solid'
                            ],
                            'icon_title' => 'Icon Title #2',
                            'tab_title'  => 'Tab Title #2',
                            'title'      => 'Your Title #2',
                            'desc'       => '#2 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'
                        ],
                        [
                            'banner' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'icon' => [
                                'value'   => 'fas fa-star',
                                'library' => 'fa-solid'
                            ],
                            'icon_title' => 'Icon Title #3',
                            'tab_title'  => 'Tab Title #3',
                            'title'      => 'Your Title #3',
                            'desc'       => '#3 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'
                        ],
                        [
                            'banner' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'icon' => [
                                'value' => 'fas fa-star',
                                'library' => 'fa-solid'
                            ],
                            'icon_title' => 'Icon Title #4',
                            'tab_title'  => 'Tab Title #4',
                            'title'      => 'Your Title #4',
                            'desc'       => '#4 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'
                        ],
                    ],
                    'title_field' => '{{{ tab_title }}}',
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['1', '3', '4', '5', '6']
                    ]
                ]
            );
            // For layout 2
            $content2 = new Repeater();
            $content2->add_control(
                'tab_title',
                [
                    'label'   => esc_html__('Tab Title', 'genzia'),
                    'type'    => Controls_Manager::TEXT,
                    'default' => 'Tab Title',
                ]
            );
            $content2->add_control(
                'desc',
                [
                    'label'   => esc_html__('Description', 'genzia'),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                ]
            );
            $content2->add_control(
                'desc2',
                [
                    'label'   => esc_html__('Description #2', 'genzia'),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => 'Description #2 Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                ]
            );
            $content2->add_control(
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
            $this->add_control(
                'contents2',
                [
                    'label'   => esc_html__('Tabs Content', 'genzia'),
                    'type'    => \Elementor\Controls_Manager::REPEATER,
                    'fields'  => $content2->get_controls(),
                    'default' => [
                        [
                            'tab_title' => 'Tab Title #1',
                            'desc' => '#1 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'
                        ],
                        [
                            'tab_title' => 'Tab Title #2',
                            'desc' => '#2 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'
                        ],
                        [
                            'tab_title' => 'Tab Title #3',
                            'desc' => '#3 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'
                        ]
                    ],
                    'title_field' => '{{{ tab_title }}}',
                    'label_block' => true,
                    'condition' => [
                        'layout' => ['2']
                    ]
                ]
            );
            // For Layout 1
            $this->add_control(
                'banner_heading',
                [
                    'label' => esc_html__('Banner Settings', 'genzia'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'classes' => 'cms-eseparator',
                    'condition' => [
                        'layout' => ['1']
                    ]
                ]
            );
            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'        => 'banner',
                    'label'       => esc_html__('Image Size', 'genzia'),
                    'default'     => 'custom',
                    'label_block' => false,
                    'condition'   => [
                        'layout' => ['1']
                    ]
                ]
            );
            $this->add_control(
                'banner_class',
                [
                    'label'       => esc_html__('Banner CSS Class', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '',
                    'label_block' => false,
                    'condition'   => [
                        'layout' => ['1']
                    ]
                ]
            );
        $this->end_controls_section();
        // Buttons Settings
        $this->start_controls_section(
            'btn_section',
            [
                'label'     => esc_html__('Button Settings', 'genzia'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['2','6']
                ]
            ]
        );
            // Button #1
            genzia_elementor_link_settings($this, [
                'name'        => 'link1_',
                'mode'        => 'btn',
                'group'       => false,
                'label'       => esc_html__('Button #1 Settings', 'genzia'),
                'color_label' => esc_html__('Button', 'genzia')
            ]);
            // Button #2
            genzia_elementor_link_settings($this, [
                'name'        => 'link2_',
                'mode'        => 'btn',
                'group'       => false,
                'label'       => esc_html__('Button #2 Settings', 'genzia'),
                'color_label' => esc_html__('Button', 'genzia')
            ]);
        $this->end_controls_section();
        // Call to Action
        $this->start_controls_section(
            'cta_section',
            [
                'label'     => esc_html__('Call To Actions', 'genzia'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['4']
                ]
            ]
        );  
            // Description   
            $this->add_control(
                'cta_text',
                [
                    'label'       => esc_html__('Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'cta_text_color',
                'label'     => esc_html__('Description Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-cta-desc' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'cta_text!' => ''
                ]
            ]);
            // Link
            genzia_elementor_link_settings($this, [
                'name'          => 'cta_link_',
                'mode'          => 'btn',
                'text'          => 'Click Here',
                'icon_settings' => [
                    'enable' => true
                ],
                'group'     => false,
                'separator' => 'before'
            ]);
        $this->end_controls_section();
        // Carousel Section Start
        genzia_elementor_carousel_settings($this, [
            'slides_to_show'   => '1',
            'slides_to_scroll' => '1',
            'condition'        => [
                'layout' => ['1']
            ]
        ]);
        //
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style Settings', 'genzia'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            genzia_elementor_colors_opts($this, [
                'name'      => 'count_color',
                'label'     => esc_html__('Count Color', 'genzia'),
                'condition' => [
                    'layout' => ['3', '6']
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'total_count_color',
                'label'     => esc_html__('Total Count Color', 'genzia'),
                'condition' => [
                    'layout' => ['3']
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'icon_color',
                'label'     => esc_html__('Icon Color', 'genzia'),
                'condition' => [
                    'layout' => ['3', '4', '5']
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'tab_title_color',
                'label'     => esc_html__('Tab Title Color', 'genzia'),
                'condition' => [
                    'layout' => ['2','3', '4', '5', '6']
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'tab_title_active_color',
                'label'     => esc_html__('Tab Title Active Color', 'genzia'),
                'condition' => [
                    'layout' => ['2','3', '4', '5', '6']
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'tab_title_bdr_color',
                'label'     => esc_html__('Tab Title Border Color', 'genzia'),
                'condition' => [
                    'layout' => ['2','3', '4', '5', '6']
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'tab_title_bdr_active_color',
                'label'     => esc_html__('Tab Title Border Active Color', 'genzia'),
                'condition' => [
                    'layout' => ['2','3', '4', '5', '6']
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'mobile_tab_title_color',
                'label'     => esc_html__('Mobile Tab Title Color', 'genzia'),
                'condition' => [
                    'layout' => ['2','3', '4', '5']
                ],
                'separator' => 'before',
                'classes'   => 'cms-eseparator'
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'mobile_tab_title_active_color',
                'label'     => esc_html__('Mobile Tab Title Active Color', 'genzia'),
                'condition' => [
                    'layout' => ['2','3', '4', '5']
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'tab_content_title_color',
                'label'     => esc_html__('Tab Content Title Color', 'genzia'),
                'condition' => [
                    'layout' => ['2','3', '4', '5', '6']
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'tab_content_desc_color',
                'label'     => esc_html__('Tab Content Description Color', 'genzia'),
                'condition' => [
                    'layout' => ['2','3', '4', '5', '6']
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'tab_content_desc2_color',
                'label'     => esc_html__('Tab Content Description #2 Color', 'genzia'),
                'condition' => [
                    'layout' => ['2']
                ]
            ]);
            //
            genzia_elementor_colors_opts($this, [
                'name'      => 'tab_content_feature_color',
                'label'     => esc_html__('Tab Content Feature Color', 'genzia'),
                'condition' => [
                    'layout' => ['2','3', '4', '5', '6']
                ],
                'separator' => 'before',
                'classes'   => 'cms-eseparator'
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'tab_content_bdr_color',
                'label'     => esc_html__('Border Color', 'genzia'),
                'separator' => 'before',
                'classes'   => 'cms-eseparator',
                'condition' => [
                    'layout' => ['2','6']
                ]
            ]);
        $this->end_controls_section();
    }
}