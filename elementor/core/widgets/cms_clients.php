<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Repeater;

/**
 * Clients Widget.
 *
 * A widget that displays a carousel of client logos and information.
 *
 * @since 1.0.0
 */
class Widget_Clients extends Widget_Base
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
        $this->set_name('cms_clients');
        $this->set_title(esc_html__('CMS Clients', 'genzia'));
        $this->set_icon('eicon-person');
        $this->set_keywords(['cms', 'genzia', 'client', 'clients', 'carousel']);
        $this->set_script_depends(['cms-elementor-custom', 'cms-post-carousel-widget-js']);
        $this->set_style_depends(['swiper']);

        parent::__construct($data, $args);
    }

    /**
     * Register Clients widget controls.
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
                            'label' => esc_html__('Layout 1', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_clients/layout/1.webp'
                        ],
                        '2' => [
                            'label' => esc_html__('Layout 2', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_clients/layout/2.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // List Section Start
        $this->start_controls_section(
            'list_section',
            [
                'label' => esc_html__('Clients List', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            $repeater = new Repeater();
            $repeater->add_control(
                'image',
                [
                    'label' => esc_html__('Image', 'genzia'),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                    'label_block' => false
                ]
            );
            $repeater->add_control(
                'name',
                [
                    'label' => esc_html__('Name', 'genzia'),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Client Name', 'genzia'),
                ]
            );
            $repeater->add_control(
                'link',
                [
                    'label' => esc_html__('Link', 'genzia'),
                    'type' => Controls_Manager::URL,
                    'default' => [
                        'url' => '#',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
            );
            $this->add_control(
                'clients',
                [
                    'label'   => esc_html__('Clients', 'genzia'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $repeater->get_controls(),
                    'default' => [
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Client Name', 'genzia'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Client Name', 'genzia'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Client Name', 'genzia'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Client Name', 'genzia'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Client Name', 'genzia'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ],
                        [
                            'image' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'name' => esc_html__('Client Name', 'genzia'),
                            'link' => [
                                'url' => '#',
                                'is_external' => true,
                                'nofollow' => true,
                            ],
                        ]
                    ],
                    'title_field' => '{{{ name }}}',
                ]
            );
            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'image',
                    'default' => 'full',
                ]
            );
        $this->end_controls_section();
        // Carousel Settings
        genzia_elementor_carousel_settings($this, [
            'slides_to_show' => '6',
            'condition' => [
                'layout!' => ['2']
            ]
        ]);
        // Style Settings
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->add_control(
                'opacity',
                [
                    'label' => esc_html__('Opacity', 'genzia'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 1,
                            'min' => 0.01,
                            'step' => 0.01,
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .client-item:not(:hover) > img' => 'opacity:{{SIZE}};'
                    ]
                ]
            );
        $this->end_controls_section();
    }
}