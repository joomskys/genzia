<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

/**
 * Download Widget.
 *
 * Download widget that displays a list of downloadable files with icons
 * and customizable styles.
 *
 * @since 1.0.0
 */
class Widget_Download extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_download');
        $this->set_title(esc_html__('CMS Download', 'genzia'));
        $this->set_icon('eicon-download-button');
        $this->set_keywords(['download', 'file', 'document', 'cms', 'genzia']);
        $this->set_script_depends(['cms-elementor-custom']);

        parent::__construct($data, $args);
    }

    /**
     * Register Download widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls(): void
    {
        // Layout Section
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
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_download/layout/1.webp'
                    ]
                ]
            ]
        );
        $this->end_controls_section();
        // Download Section
        $this->start_controls_section(
            'download_section',
            [
                'label' => esc_html__('Download List', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            // Download List
            $repeater = new Repeater();
                genzia_elementor_icon_image_settings($repeater, [
                    'group'        => false,
                    'icon_default' => [
                        'library' => 'fa-regular',
                        'value'   => 'far fa-file-pdf' 
                    ],
                    'default_color'       => 'white',
                    'default_color_hover' => 'white'
                ]);
                $repeater->add_control(
                    'name',
                    [
                        'label'     => esc_html__('Title', 'genzia'),
                        'type'      => Controls_Manager::TEXT,
                        'default'   => 'Your Title',
                        'separator' => 'before',
                        'classes'   => 'cms-eseparator'
                    ]
                );
                genzia_elementor_colors_opts($repeater, [
                    'name'      => 'name_color',
                    'label'     => esc_html__('Title Color', 'genzia'),
                    'condition' => [
                        'name!' => ''
                    ],
                    'default'   => 'white',
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .cms-dname' => 'color:{{VALUE}};'
                    ]
                ]);
                genzia_elementor_colors_opts($repeater, [
                    'name'      => 'name_color_hover',
                    'label'     => esc_html__('Title Hover Color', 'genzia'),
                    'condition' => [
                        'name!'  => '',
                        'name2!' => ''
                    ],
                    'default'   => 'white',
                    'selectors' => [
                        '{{WRAPPER}} .cms-dowload-item{{CURRENT_ITEM}}:hover .cms-dname' => 'color:{{VALUE}};'
                    ]
                ]);
                $repeater->add_control(
                    'link',
                    [
                        'label'   => esc_html__('File URL', 'genzia'),
                        'type'    => Controls_Manager::URL,
                        'default' => [
                            'url'         => '#',
                            'is_external' => true,
                            'nofollow'    => true,
                        ],
                        'description' => esc_html__('Go to Dashboard -> Media -> Add New Media File -> Upload file -> Copy URL', 'genzia')
                    ]
                );
                genzia_elementor_colors_opts($repeater, [
                    'name'      => 'item_bg',
                    'label'     => esc_html__('Background Color', 'genzia'),
                    'default'   => 'accent-regular',
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color:{{VALUE}};'
                    ]
                ]);
                genzia_elementor_colors_opts($repeater, [
                    'name'    => 'item_bg_hover',
                    'label'   => esc_html__('Background Hover Color', 'genzia'),
                    'default' => 'primary-regular',
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'background-color:{{VALUE}};'
                    ]
                ]);
                genzia_elementor_colors_opts($repeater, [
                    'name'    => 'divider_color',
                    'label'   => esc_html__('Divider Color', 'genzia'),
                    'default' => 'divider',
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}' => '--cms-bdr-custom:{{VALUE}};'
                    ]
                ]);
            $this->add_control(
                'download_lists',
                [
                    'label'       => esc_html__('Download Lists', 'genzia'),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $repeater->get_controls(),
                    'label_block' => true,
                    'default'     => [
                        [
                            'name' => 'Our Report 2026',
                            'link'  => [
                                'url' => '#'
                            ],
                            'icon_img_icon' => [
                                'library' => 'fa-regular',
                                'value'   => 'far fa-file-pdf' 
                            ],
                            'icon_img_color'       => 'white',
                            'icon_img_color_hover' => 'white',
                            'name_color'           => 'white',
                            'name2_color'          => 'white',
                            'name_color_hover'     => 'white',
                            'item_bg'              => 'accent-regular',
                            'item_bg_hover'        => 'menu',
                            'divider_color'        => 'divider-30' 
                        ],
                        [
                            'name' => 'Our Brochure',
                            'link'  => [
                                'url' => '#'
                            ],
                            'icon_img_icon' => [
                                'library' => 'fa-regular',
                                'value'   => 'far fa-file-pdf' 
                            ],
                            'icon_img_color'       => 'white',
                            'icon_img_color_hover' => 'white',
                            'name_color'           => 'white',
                            'name2_color'          => 'white',
                            'name_color_hover'     => 'white',
                            'item_bg'              => 'menu',
                            'item_bg_hover'        => 'accent-regular',
                            'divider_color'        => 'divider-30'
                        ]
                    ],
                    'title_field' => '{{{ name }}}',
                ]
            );
        $this->end_controls_section();
    }
}
