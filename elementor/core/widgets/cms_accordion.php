<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use CSH_Theme_Core;

/**
 * Accordion Widget.
 *
 * Accordion widget that displays a collapsible display of content in an
 * accordion style, showing only one item at a time.
 *
 * @since 1.0.0
 */
class Widget_Accordion extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_accordion');
        $this->set_title(esc_html__('CMS Accordion', 'genzia'));
        $this->set_icon('eicon-accordion');
        $this->set_keywords(['accordion', 'toggle', 'collapse', 'cms', 'genzia']);
        $this->set_script_depends(['cms-elementor-custom']);
        $this->set_style_depends(['e-animation-fadeInUp', 'e-animation-rotateInUpLeft']);

        parent::__construct($data, $args);
    }

    /**
     * Register Accordion widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls(): void
    {
        // Layout Section Start 
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
                    'label'   => esc_html__('Templates', 'genzia'),
                    'type'    => Controls_Manager::VISUAL_CHOICE,
                    'default' => '1',
                    'options' => [
                        '1' => [
                            'title' => esc_html__('Layout 1', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_accordion/layout/1.webp'
                        ],
                        '2' => [
                            'title' => esc_html__('Layout 2', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_accordion/layout/2.webp'
                        ],
                        '3' => [
                            'title' => esc_html__('Layout 3', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_accordion/layout/3.webp'
                        ],
                        '4' => [
                            'title' => esc_html__('Layout 4', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_accordion/layout/4.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Element Heading
        $this->start_controls_section(
            'eheading_section',
            [
                'label'     => esc_html__('Element Heading'),
                'tab'       =>  Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['2','3']
                ]
            ]
        );
            $this->add_control(
                'heading_text',
                [
                    'label'       => esc_html__('Heading', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the heading',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'heading_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-title' => '--text-custom-color: {{VALUE}};'
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
                ]
            ]);
        $this->end_controls_section();
        // accordion Section Start
        $this->start_controls_section(
            'section_cms_accordion',
            [
                'label' => esc_html__('Accordion Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            $this->add_control(
                'active_section',
                [
                    'label'     => esc_html__('Active section', 'genzia'),
                    'type'      => Controls_Manager::NUMBER,
                    'default'   => 1,
                    'min'       => 0,
                    'max'       => 50,
                    'separator' => 'after',
                ]
            );
            $repeater = new Repeater();
            $repeater->add_control(
                'ac_title',
                [
                    'label'       => esc_html__('Title', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Title',
                    'placeholder' => esc_html__('Enter your title', 'genzia'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'ac_content',
                [
                    'label'       => esc_html__('Content', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Item content. Click the edit button to change this text.',
                    'placeholder' => esc_html__('Enter your content', 'genzia'),
                    'label_block' => true,
                ]
            );
            // Document
            $repeater->add_control(
                'ac_document_text',
                [
                    'label'       => esc_html__('Document', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '',
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'ac_document',
                [
                    'label'       => esc_html__('Upload Document', 'genzia'),
                    'type'        => Controls_Manager::MEDIA,
                    'media_types' => ['image', 'video', 'svg', 'application/pdf', 'application/doc', 'application/docx'],
                    'default'     => [
                        'url' => get_parent_theme_file_uri() . '/assets/doc/CMS-Brochure.pdf',
                    ],
                    'condition' => [
                        'ac_document_text!' => ''
                    ],
                    'label_block' => false,
                    'skin'        => 'inline'
                ]
            );
            // Button
            genzia_elementor_link_settings($repeater, [
                'name'          => 'ac_link_',
                'mode'          => 'btn',
                'group'         => false,
                'color_label'   => esc_html__('Button', 'genzia'),
                'text'          => 'Click Here',
                'color'         => false,
                'icon_settings' => false
            ]);
            // Features
            $repeater->add_control(
                'ac_feature_text',
                [
                    'label'       => esc_html__('Features Title', 'genzia'),
                    'description' => esc_html__('Features Settings', 'genzia'),
                    'classes'     => 'cms-description-as-label',  
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'label_block' => true,
                ]
            );
            // Features
            $repeater->add_control(
                'ac_feature_feature',
                [
                    'label'       => esc_html__('Features List', 'genzia'),
                    'type'        => CSH_Theme_Core::REPEATER_CONTROL,
                    'label_block' => true,
                    'separator'   => 'before',
                    'button_text' => esc_html__('Add Feature', 'genzia'),
                    'controls'    => array(
                        array(
                            'name'        => 'ftitle',
                            'label'       => esc_html__('Title', 'genzia'),
                            'type'        => Controls_Manager::TEXTAREA,
                            'default'     => 'Your Feature',
                            'label_block' => false
                        ),
                        array(
                            'name'        => 'furl',
                            'label'       => esc_html__('URL', 'genzia'),
                            'type'        => Controls_Manager::TEXTAREA,
                            'default'     => '#',
                            'label_block' => false
                        )
                    )
                ]
            );
            $this->add_control(
                'cms_accordion',
                [
                    'label'   => esc_html__('List', 'genzia'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $repeater->get_controls(),
                    'default' => [
                        [
                            'ac_title'   => 'Title',
                            'ac_content' => 'Item content. Click the edit button to change this text.',
                        ],
                        [
                            'ac_title'   => 'Title',
                            'ac_content' => 'Item content. Click the edit button to change this text.',
                        ],
                    ],
                    'title_field' => '{{{ ac_title }}}',
                    'button_text' => esc_html__('Add Accordion','genzia')
                ]
            );
        $this->end_controls_section(); // accordion Section End
        //  Style tab
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
            genzia_elementor_colors_opts($this, [
                'name'      => 'border_color',
                'label'     => esc_html__('Border Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-bdr' => 'border-color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'title_color',
                'label'     => esc_html__('Title Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-accordion-title:not(.active)' => 'color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'title_active_color',
                'label'     => esc_html__('Title Active Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-accordion-title:hover, {{WRAPPER}} .cms-accordion-title.active' => 'color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'content_color',
                'label'     => esc_html__('Content Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-accordion-content' => 'color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'explain_icon_color',
                'label'     => esc_html__('Explain Icon Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-accordion-item:not(.active) .cms-acc-icon' => 'color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'explain_icon_active_color',
                'label'     => esc_html__('Explain Icon Active Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .active .cms-acc-icon, {{WRAPPER}} .cms-accordion-item:hover .cms-acc-icon' => 'color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'explain_icon_bg_color',
                'label'     => esc_html__('Explain Icon Background Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-accordion-item:not(.active) .cms-acc-icon' => 'background-color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'explain_icon_active_bg_color',
                'label'     => esc_html__('Explain Icon Active Background Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .active .cms-acc-icon, {{WRAPPER}} .cms-accordion-item:hover .cms-acc-icon' => 'background-color:{{VALUE}};'
                ]
            ]);
            // Download Button
            genzia_elementor_colors_opts($this, [
                'name'      => 'dl_btn_color',
                'label'     => esc_html__('Download Button Background Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-dl-btn' => '--cms-bg-custom:{{VALUE}};'
                ],
                'separator' => 'before',
                'classes'   => 'cms-eseparator'
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'dl_btn_text_color',
                'label'     => esc_html__('Download Button Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-dl-btn' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'dl_btn_color_hover',
                'label'     => esc_html__('Download Button Background Hover Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-dl-btn' => '--cms-bg-hover-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'dl_btn_text_color_hover',
                'label'     => esc_html__('Download Button Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-dl-btn' => '--cms-text-hover-custom:{{VALUE}};'
                ]
            ]);
            // Download Button Icon
            genzia_elementor_colors_opts($this, [
                'name'      => 'dl_btn_icon_bg',
                'label'     => esc_html__('Download Button Icon Background Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-dl-btn-icon' => '--cms-bg-custom:{{VALUE}};'
                ],
                'separator' => 'before',
                'classes'   => 'cms-eseparator'
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'dl_btn_icon_color',
                'label'     => esc_html__('Download Button Icon Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-dl-btn-icon' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'dl_btn_icon_bg_hover',
                'label'     => esc_html__('Download Button Icon Background Hover Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-dl-btn-icon' => '--cms-bg-hover-custom:{{VALUE}};--cms-bg-on-hover-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'dl_btn_icon_color_hover',
                'label'     => esc_html__('Download Button Icon Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-dl-btn-icon' => '--cms-text-hover-custom:{{VALUE}};--cms-text-on-hover-custom:{{VALUE}};'
                ]
            ]);
            // Button
            genzia_elementor_colors_opts($this, [
                'name'      => 'ac_link_bg',
                'label'     => esc_html__('Button Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn' => '--cms-bg-custom:{{VALUE}};'
                ],
                'separator' => 'before',
                'classes'   => 'cms-eseparator'
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'ac_link_color',
                'label'     => esc_html__('Button Text Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'ac_link_bg_hover',
                'label'     => esc_html__('Button Hover Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn' => '--cms-bg-hover-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'ac_link_color_hover',
                'label'     => esc_html__('Button Text Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn' => '--cms-text-hover-custom:{{VALUE}};'
                ]
            ]);
            // Button Icon
            genzia_elementor_colors_opts($this, [
                'name'      => 'ac_link_icon_bg',
                'label'     => esc_html__('Button Icon Background Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn-icon' => '--cms-bg-custom:{{VALUE}};'
                ],
                'separator' => 'before',
                'classes'   => 'cms-eseparator'
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'ac_link_icon_color',
                'label'     => esc_html__('Button Icon Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn-icon' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'ac_link_icon_bg_hover',
                'label'     => esc_html__('Button Icon Background Hover Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn-icon' => '--cms-bg-hover-custom:{{VALUE}};--cms-bg-on-hover-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'ac_link_icon_color_hover',
                'label'     => esc_html__('Button Icon Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-btn-icon' => '--cms-text-hover-custom:{{VALUE}};--cms-text-on-hover-custom:{{VALUE}};'
                ]
            ]);
            // Feature
            genzia_elementor_colors_opts($this, [
                'name'      => 'fdesc_color',
                'label'     => esc_html__('Feature Description Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-ac-feature-desc' => '--cms-color-custom:{{VALUE}};'
                ],
                'separator' => 'before',
                'classes'   => 'cms-eseparator'
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'bg-fitem',
                'label'     => esc_html__('Feature Item Background Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-ac-fitem' => '--cms-bg-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'fitem-color',
                'label'     => esc_html__('Feature Item Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-ac-fitem' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'bg-fitem-hover',
                'label'     => esc_html__('Feature Item Background Hover Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-ac-fitem' => '--cms-bg-hover-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'fitem-color-hover',
                'label'     => esc_html__('Feature Item Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-ac-fitem' => '--cms-text-hover-custom:{{VALUE}};'
                ]
            ]);
        $this->end_controls_section();
    }
}