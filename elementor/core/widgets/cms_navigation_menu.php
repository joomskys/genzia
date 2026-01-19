<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Navigation Menu Widget.
 *
 * Displays a WordPress menu with various layout options.
 *
 * @since 1.0.0
 */
class Widget_Navigation_Menu extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_navigation_menu');
        $this->set_title(esc_html__('CMS Navigation Menu', 'genzia'));
        $this->set_icon('eicon-nav-menu');
        $this->set_keywords(['menu', 'navigation', 'nav', 'genzia']);
        parent::__construct($data, $args);
    }

    /**
     * Register Navigation Menu widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls(): void
    {
        $menus = get_terms('nav_menu', array('hide_empty' => false));
        $custom_menus = [];
        if (is_array($menus) && !empty($menus)) {
            foreach ($menus as $single_menu) {
                if (is_object($single_menu) && isset($single_menu->name, $single_menu->term_id)) {
                    $custom_menus[$single_menu->term_id] = $single_menu->name;
                }
            }
        }

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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/1.webp'
                        ],
                        '2' => [
                            'title' => esc_html__('Layout 2', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/2.webp'
                        ],
                        '3' => [
                            'title' => esc_html__('Layout 3', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/3.webp'
                        ],
                        '4' => [
                            'title' => esc_html__('Layout 4', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/4.webp'
                        ],
                        '5' => [
                            'title' => esc_html__('Layout 5', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/5.webp'
                        ],
                        '6' => [
                            'title' => esc_html__('Layout 6', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/6.webp'
                        ],
                        '7' => [
                            'title' => esc_html__('Layout 7', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/7.webp'
                        ],
                        '-mega' => [
                            'title' => esc_html__('Mega Menu', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/mega.webp'
                        ],
                        '-sidenav' => [
                            'title' => esc_html__('Side Navigation', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_navigation_menu/layout/sidenav.webp'
                        ]
                    ],
                    'label_block' => true,
                    'dynamic'     => [
                        'active' => true,
                    ]
                ]
            );
        $this->end_controls_section();
        // Menu Section Start
        $this->start_controls_section(
            'navigation_menu_section',
            [
                'label' => esc_html__('Navigation Menu', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            $this->add_control(
                'title',
                [
                    'label'       => esc_html__('Title', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Enter your title', 'genzia'),
                    'label_block' => true,
                    'condition'   => [
                        'layout!' => ['3', '4', '-sidenav']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'title_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};'
                ]
            ]);
            $this->add_control(
                'title_link',
                [
                    'label'       => esc_html__('Title Link', 'genzia'),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__('https://your-link.com', 'genzia'),
                    'default'     => [],
                    'condition'   => [
                        'menu!'     => '',
                        'title!'    => '',
                        'layout!'   => ['mega'],
                    ]
                ]
            );

            $this->add_control(
                'menu',
                [
                    'label'     => esc_html__('Select Menu', 'genzia'),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => $custom_menus,
                    'separator' => 'before',
                    'classes'   => 'cms-eseparator'
                ]
            );
            $this->add_control(
                'menu2',
                [
                    'label'     => esc_html__('Select Menu #2', 'genzia'),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => $custom_menus,
                    'condition' => [
                        'layout' => ['6']
                    ]
                ]
            );
            genzia_elementor_responsive_flex_alignment($this, [
                'label'     => esc_html__('Menu Alignment','genzia'),
                'condition' => [
                    'menu!' => '',
                ]
            ]);
        $this->end_controls_section();

        // Link Style
        $this->start_controls_section(
            'section_style_link',
            [
                'label'     => esc_html__('Link', 'genzia'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'menu!'   => '',
                    'layout!' => ['-mega']
                ]
            ]
        );
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_color',
                'label'     => esc_html__('Color', 'genzia'),
                'dynamic'  => [
                    'active' => true,
                ],
                'selectors'=> [
                    '{{WRAPPER}} .cms-menu a:not(:hover)' => 'color: {{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'link_color_hover',
                'label'     => esc_html__('Color', 'genzia'),
                'dynamic'  => [
                    'active' => true,
                ],
                'selectors'=> [
                    '{{WRAPPER}} .cms-menu a:hover, {{WRAPPER}} .cms-menu li.current-menu-item > a, {{WRAPPER}} .cms-menu li.current-menu-ancestor > a' => 'color: {{VALUE}};'
                ]   
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'divider_color',
                'label'     => esc_html__('Color', 'genzia'),
                'label'    => esc_html__('Divider Color', 'genzia'),
                'dynamic'  => [
                    'active' => true,
                ]   
            ]);
        $this->end_controls_section();
    }
}
