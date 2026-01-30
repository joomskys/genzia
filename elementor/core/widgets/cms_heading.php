<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;

/**
 * Heading Widget.
 *
 * Displays headings with customizable features like small heading, description,
 * buttons, features list and banner image.
 *
 * @since 1.0.0
 */
class Widget_Heading extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_heading');
        $this->set_title(esc_html__('CMS Heading', 'genzia'));
        $this->set_icon('eicon-heading');
        $this->set_keywords(['heading', 'title', 'text', 'cms', 'genzia']);
        $this->set_script_depends(['cms-elementor-custom']);
        $this->set_style_depends(['e-animation-fadeInUp','e-animation-fadeInRight','e-animation-fadeLeft']);

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
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/1.webp'
                    ],
                    '2' => [
                        'title' => esc_html__('Layout 2', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/2.webp'
                    ],
                    '3' => [
                        'title' => esc_html__('Layout 3', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/3.webp'
                    ],
                    '4' => [
                        'title' => esc_html__('Layout 4', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/4.webp'
                    ],
                    '5' => [
                        'title' => esc_html__('Layout 5', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/5.webp'
                    ],
                    '6' => [
                        'title' => esc_html__('Layout 6', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/6.webp'
                    ],
                    '7' => [
                        'title' => esc_html__('Layout 7', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/7.webp'
                    ],
                    '8' => [
                        'title' => esc_html__('Layout 8', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/8.webp'
                    ],
                    '9' => [
                        'title' => esc_html__('Layout 9', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/9.webp'
                    ],
                    '10' => [
                        'title' => esc_html__('Layout 10', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_heading/layout/10.webp'
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
                'label' => esc_html__('Heading Content', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT,
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
                        'layout' => ['2','3','5','6','8','10'],
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
                    'layout'                    => ['2','3','5','6','8','10'],
                    'smallheading_text!'        => '',
                    'smallheading_icon[value]!' => ''
                ]
            ]);
            $this->add_control(
                'smallheading_text',
                [
                    'label'       => esc_html__('Small Heading', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is Small Heading',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['2','3','5','6','8','10']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'smallheading_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-small' => '--text-custom-color: {{VALUE}};'
                ],
                'condition' => [
                    'layout' => ['2','3','5','6','8','10'],
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
                        'layout!' => ['6','8']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'heading_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-title' => '--text-custom-color: {{VALUE}};'
                ],
                'condition'   => [
                    'layout!'       => ['6','8'],
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
                    'show_label'  => true,
                    'condition'   => [
                        'layout' => ['4','7','9','10']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'desc_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-desc' => '--text-custom-color: {{VALUE}};'
                ],
                'condition'   => [
                    'desc!'  => '',
                    'layout' => ['4','7','9','10']
                ]
            ]);
            // Description #2
            $this->add_control(
                'desc2',
                [
                    'label'       => esc_html__('Description #2', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '#2 Lorem Ipsum is simply dummy text of the printing and typesetting story. Lorem Ipsum has been the story standard dummy text ever since',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'rows'        => 10,
                    'show_label'  => true,
                    'condition'   => [
                        'layout' => ['10']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'desc2_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-desc2' => '--text-custom-color: {{VALUE}};'
                ],
                'condition'   => [
                    'desc!'  => '',
                    'layout' => ['10']
                ]
            ]);
            // Feature
            $features = new Repeater();
                $features->add_control(
                    'ftitle',
                    [
                        'label'   => esc_html__('Title', 'genzia'),
                        'type'    => Controls_Manager::TEXT,
                        'default' => esc_html__('Title', 'genzia'),
                    ]
                );
            $this->add_control(
                'features',
                [
                    'label'   => esc_html__('Feature Lists', 'genzia'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $features->get_controls(),
                    'default' => [
                        [
                            'ftitle' => esc_html__('Title', 'genzia'),
                        ]
                    ],
                    'label_block'  => true,
                    'title_field'  => '{{{ ftitle }}}',
                    'button_label' => esc_html__('Add Feature','genzia'),
                    'condition'    => [
                        'layout' => ['9','10']
                    ],
                    'prevent_empty' => false
                ]
            );
            // Feature #2
            $features2 = new Repeater();
                $features2->add_control(
                    'ftitle',
                    [
                        'label'   => esc_html__('Title', 'genzia'),
                        'type'    => Controls_Manager::TEXT,
                        'default' => esc_html__('Title', 'genzia'),
                    ]
                );
            $this->add_control(
                'features2',
                [
                    'label'   => esc_html__('Feature Lists #2', 'genzia'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $features2->get_controls(),
                    'default' => [
                        [
                            'ftitle' => esc_html__('Title', 'genzia'),
                        ]
                    ],
                    'label_block'  => true,
                    'title_field'  => '{{{ ftitle }}}',
                    'button_label' => esc_html__('Add Feature','genzia'),
                    'condition'    => [
                        'layout' => ['10']
                    ],
                    'prevent_empty' => false
                ]
            );
            // Button
            genzia_elementor_link_settings($this, [
                'mode'          => 'btn',
                'group'         => false,
                'color_label'   => esc_html__('Button', 'genzia'),
                'text'          => 'Click Here',
                'icon_settings' => [
                    'enable'   => true,
                    'selector' => '.cms-btn-icon'
                ],
                'condition' => [
                    'layout' => ['7']
                ]
            ]);
        $this->end_controls_section();
    }
}
