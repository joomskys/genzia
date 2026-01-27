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

/**
 * Social Icons Widget.
 *
 * Social Icons widget that displays process steps or workflow with features and descriptions
 * in various layout configurations including sticky layouts.
 *
 * @since 1.0.0
 */
class Widget_Social_Icons extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_social_icons');
        $this->set_title(esc_html__('CMS Social Icons', 'genzia'));
        $this->set_icon('eicon-social-icons');
        $this->set_keywords(['social', 'icon', 'cms', 'genzia']);

        parent::__construct($data, $args);
    }

    /**
     * Register Social Icons widget controls.
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
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_social_icons/layout/1.webp'
                    ],
                    '2' => [
                        'title' => esc_html__('Layout 2', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_social_icons/layout/2.webp'
                    ],
                ],
                'label_block' => true
            ]
        );
        $this->end_controls_section();
        // Content
        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__('Content Settings', 'genzia'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['2']
                ]
            ]
        );
            $this->add_control(
                'banner',
                [
                    'label'   => esc_html__('Banner', 'genzia'),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'label_block' => false,
                    'skin' => 'inline'
                ]
            );
            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'      => 'banner',
                    'label'     => esc_html__('Image Size', 'genzia'),
                    'default'   => 'custom',
                    'condition' => [
                        'banner[url]!' => ''
                    ],
                    'label_block' => false
                ]
            );
            // Desc
            $this->add_control(
                'desc',
                [
                    'label'       => esc_html__('Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => esc_html__('Your Description','genzia'),
                    'label_block' => false,
                    'classes'     => 'cms-title-full'
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'desc_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-desc' => '--cms-text-custom: {{VALUE}};'
                ],
                'condition' => [
                    'desc!' => ''
                ]
            ]);
        $this->end_controls_section();
        // icon Section Start
        $this->start_controls_section(
            'section_icon',
            [
                'label' => esc_html__('Socials Icons', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            $repeater = new Repeater();
            $repeater->add_control(
                'social_icon',
                [
                    'label'   => esc_html__('Icon', 'genzia'),
                    'type'    => Controls_Manager::ICONS,
                    'default' => [
                        'value'   => 'fas fas-star',
                        'library' => 'fa-solid'
                    ],
                    'skin'        => 'inline',
                    'label_block' => false
                ]
            );
            $repeater->add_control(
                'title',
                [
                    'label'   => esc_html__('Title', 'genzia'),
                    'type'    => Controls_Manager::TEXT,
                    'default' => 'Social Title',
                ]
            );
            $repeater->add_control(
                'link',
                [
                    'label'   => esc_html__('Link', 'genzia'),
                    'type'    => Controls_Manager::URL,
                    'default' => [
                        'is_external' => 'true'
                    ],
                    'placeholder' => esc_html__('https://your-link.com', 'genzia'),
                ]
            );
            
            $this->add_control(
                'icons',
                [
                    'label'         => esc_html__('Icons', 'genzia'),
                    'type'          => Controls_Manager::REPEATER,
                    'fields'        => $repeater->get_controls(),
                    'prevent_empty' => false,
                    'default' => [
                        [
                            'social_icon' => [
                                'value'   => 'fab fa-facebook',
                                'library' => 'fa-brands'
                            ],
                            'title' => 'Facebook',
                            'link'  => [
                                'is_external' => true,
                                'url' => 'https://facebook.com'
                            ]
                        ],
                        [
                            'social_icon' => [
                                'value'   => 'fab fa-x-twitter-square',
                                'library' => 'fa-brands'
                            ],
                            'title' => 'X',
                            'link'  => [
                                'is_external' => true,
                                'url' => 'https://x.com'
                            ]
                        ],
                        [
                            'social_icon' => [
                                'value'   => 'fab fa-linkedin',
                                'library' => 'fa-brands'
                            ],
                            'title' => 'LinkedIn',
                            'link'  => [
                                'is_external' => true,
                                'url' => 'https://linkedin.com'
                            ]
                        ],
                    ],
                    //'title_field' => '{{{ "<i class=\"" + social_icon.value + "\"></i>" + " " + title }}}',
                    'title_field' => '{{{ elementor.helpers.renderIcon( this, social_icon, {}, "i", "panel" ) || \'<i class="{{ social_icon.value }}" aria-hidden="true"></i>\' }}} {{{ title }}}',
                ]
            );
        $this->end_controls_section();

        // Style Tab Start
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Content Settings', 'genzia'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->add_responsive_control(
                'align',
                [
                    'label'      => esc_html__('Alignment', 'genzia'),
                    'type'       => Controls_Manager::CHOOSE,
                    'responsive' => true,
                    'options' => [
                        'start' => [
                            'title' => esc_html__('Left', 'genzia'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', 'genzia'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'end' => [
                            'title' => esc_html__('Right', 'genzia'),
                            'icon' => 'eicon-text-align-right',
                        ],
                        'justify' => [
                            'title' => esc_html__('Justified', 'genzia'),
                            'icon' => 'eicon-text-align-justify',
                        ]
                    ]
                ]
            );
            $this->add_control(
                'gap',
                [
                    'label'   => esc_html__('Gap', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => genzia_elementor_gap_lists(),
                    'default' => ''
                ]
            );
        $this->end_controls_section();
        // Icons Style Section Start
        $this->start_controls_section(
            'icons_style_section',
            [
                'label' => esc_html__('Icons', 'genzia'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            genzia_elementor_colors_opts($this, [
                'name'      => 'icon_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-social-item' => '--cms-text-custom: {{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'icon_color_hover',
                'label'     => esc_html__('Hover Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-social-item' => '--cms-text-hover-custom: {{VALUE}};--cms-text-on-hover-custom: {{VALUE}};'
                ]
            ]);
        $this->end_controls_section();
        //
        $this->start_controls_section(
            'title_section',
            [
                'label' => esc_html__('Title', 'genzia'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->add_control(
                'show_title',
                [
                    'label'        => esc_html__('Show Title', 'genzia'),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => 'no'
                ]
            );
            genzia_add_hidden_device_controls($this, [
                'prefix'    => 'title_',
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'title_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-title' => '--cms-text-custom: {{VALUE}};'
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]);
        $this->end_controls_section();
    }
}