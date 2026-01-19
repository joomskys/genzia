<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

/**
 * Google Map Widget.
 *
 * Displays a Google Map with customizable location, zoom level, and interactive
 * features like address accordion and timetable.
 *
 * @since 1.0.0
 */
class Widget_Google_Map extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_google_map');
        $this->set_title(esc_html__('CMS Google Map', 'genzia'));
        $this->set_icon('eicon-google-maps');
        $this->set_keywords(['map', 'google', 'location', 'cms', 'genzia']);
        $this->set_script_depends(['cms-elementor-custom']);

        parent::__construct($data, $args);
    }

    /**
     * Register Google Map widget controls.
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_google_map/layout/1.jpg'
                        ],
                        '2' => [
                            'title' => esc_html__('Layout 2', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_google_map/layout/2.webp'
                        ],
                        '3' => [
                            'title' => esc_html__('Layout 3', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_google_map/layout/3.webp'
                        ]
                    ]
                ]
            );
        $this->end_controls_section();
        // Content Tab Start
        $this->start_controls_section(
            'map_section',
            [
                'label' => esc_html__('Map Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
            $default_address = esc_html__('The Great Kings Building Management 2307 Beverley Road, Brooklyn, NY 145784', 'genzia');
            $this->add_control(
                'map_address',
                [
                    'label' => esc_html__('Address', 'genzia'),
                    'type' => Controls_Manager::TEXTAREA,
                    'dynamic' => [
                        'active' => true
                    ],
                    'placeholder' => $default_address,
                    'default' => $default_address,
                    'label_block' => true,
                ]
            );
            $this->add_control(
                'map_address_title',
                [
                    'label' => esc_html__('Address title', 'genzia'),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => '',
                    'default' => '',
                    'label_block' => false,
                    'condition' => [
                        'layout' => ['3'],
                        'map_address!' => ''
                    ]
                ]
            );
            $this->add_control(
                'zoom',
                [
                    'label' => esc_html__('Zoom', 'genzia'),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 15,
                    ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 20,
                        ],
                    ],
                    'separator' => 'before',
                ]
            );
            $this->add_responsive_control(
                'height',
                [
                    'label' => esc_html__('Height', 'genzia'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 100,
                            'max' => 1000,
                        ],
                    ],
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} iframe' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'default' => [
                        'size' => 400,
                        'unit' => 'px',
                    ]
                ]
            );
            $this->add_control(
                'view',
                [
                    'label' => esc_html__('View', 'genzia'),
                    'type' => Controls_Manager::HIDDEN,
                    'default' => 'traditional',
                ]
            );
        $this->end_controls_section();
        // Content
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
            $this->add_control(
                'title',
                [
                    'label' => esc_html__('Title', 'genzia'),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => 'Global Locations',
                    'placeholder' => esc_html__('Enter your title', 'genzia'),
                    'label_block' => false,
                    'condition' => [
                        'layout' => ['2', '3']
                    ]
                ]
            );

            $this->add_control(
                'active_section',
                [
                    'label' => esc_html__('Active section', 'genzia'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => '1',
                    'min' => '0',
                    'max' => '50',
                    'description' => esc_html__('Locations Settings', 'genzia'),
                    'classes' => 'cms-description-as-label',
                    'condition' => [
                        'layout' => ['2']
                    ]
                ]
            );
            // Accordion
            $accordions = new Repeater();
            $accordions->add_control(
                'ac_title',
                [
                    'label' => esc_html__('Title', 'genzia'),
                    'type' => Controls_Manager::TEXT,
                    'default' => 'Title',
                    'placeholder' => esc_html__('Enter your title', 'genzia'),
                    'label_block' => true,
                ]
            );
            $accordions->add_control(
                'ac_content',
                [
                    'label' => esc_html__('Content', 'genzia'),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => 'Item content. Click the edit button to change this text.',
                    'placeholder' => esc_html__('Enter your content', 'genzia'),
                    'label_block' => true,
                ]
            );
                $this->add_control(
                    'cms_accordion',
                    [
                        'label' => esc_html__('Locations List', 'genzia'),
                        'type' => Controls_Manager::REPEATER,
                        'fields' => $accordions->get_controls(),
                        'default' => [
                            [
                                'ac_title' => 'London Office',
                                'ac_content' => 'Phone: 01061245741<br/>Email: Genzia@cmsheroes.com<br/>Address: Brooklyn, New York, USA<br/>Hours: Mon-Fri: 8am – 7pm',
                            ],
                            [
                                'ac_title' => 'Berlin Office',
                                'ac_content' => 'Phone: 01061245741<br/>Email: Genzia@cmsheroes.com<br/>Address: Berlin Office Address<br/>Hours: Mon-Fri: 8am – 7pm',
                            ],
                            [
                                'ac_title' => 'Manchester Office',
                                'ac_content' => 'Phone: 01061245741<br/>Email: Genzia@cmsheroes.com<br/>Address: Manchester Office Address<br/>Hours: Mon-Fri: 8am – 7pm',
                            ]
                        ],
                        'title_field' => '{{{ ac_title }}}',
                        'condition' => [
                            'layout' => ['2']
                        ]
                    ]
                );
            // Timetable
            $timetable = new Repeater();
            $timetable->add_control(
                'time_title',
                [
                    'label' => esc_html__('Title', 'genzia'),
                    'type' => Controls_Manager::TEXT,
                    'default' => 'Title',
                    'placeholder' => esc_html__('Enter your title', 'genzia'),
                    'label_block' => true,
                ]
            );
                $timetable->add_control(
                    'time_value',
                    [
                        'label' => esc_html__('Value', 'genzia'),
                        'type' => Controls_Manager::TEXT,
                        'default' => 'Your Value',
                        'placeholder' => esc_html__('Enter your value', 'genzia'),
                        'label_block' => true,
                    ]
                );
            $this->add_control(
                'cms_timetable',
                [
                    'label' => esc_html__('Timetable List', 'genzia'),
                    'label_block' => true,
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $timetable->get_controls(),
                    'default' => [
                        [
                            'time_title' => 'Monday - Friday',
                            'time_value' => '09.00 - 24:00'
                        ],
                        [
                            'time_title' => 'Saturday',
                            'time_value' => '08:00 - 03.00'
                        ],
                        [
                            'time_title' => 'Sunday',
                            'time_value' => 'Closed'
                        ]
                    ],
                    'condition' => [
                        'layout' => ['3']
                    ]
                ]
            );
            // Get Directions
            $this->add_control(
                'direction_text',
                [
                    'label' => esc_html__('Get Directions', 'genzia'),
                    'type' => Controls_Manager::TEXT,
                    'default' => 'Get Directions',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'condition' => [
                        'layout' => ['3']
                    ]
                ]
            );
        $this->end_controls_section();
    }
}
