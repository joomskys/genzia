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
 * Pricing Widget.
 *
 * Displays pricing plans with features and pricing information.
 *
 * @since 1.0.0
 */
class Widget_Pricing extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_pricing');
        $this->set_title(esc_html__('CMS Pricing', 'genzia'));
        $this->set_icon('eicon-price-table');
        $this->set_keywords(['pricing', 'price', 'table', 'cms', 'genzia']);
        $this->set_script_depends(['cms-switcher']);

        parent::__construct($data, $args);
    }

    /**
     * Register Pricing widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {
        // Layout Section
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_pricing/layout/1.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();

        // Pricing Section
        $this->start_controls_section(
            'pricing_section',
            [
                'label' => esc_html__('Pricing Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            $pricings = new Repeater();
            $pricings->add_control(
                'featured',
                [
                    'label' => esc_html__('Featured?', 'genzia'),
                    'type' => Controls_Manager::SWITCHER
                ]
            );
            $pricings->add_control(
                'badge_text',
                [
                    'label' => esc_html__('Badge Text', 'genzia'),
                    'type' => Controls_Manager::TEXT,
                    'default' => '',
                    'label_block' => false,
                    'separator' => 'after'
                ]
            );
            $pricings->add_control(
                'price',
                [
                    'label' => esc_html__('Price', 'genzia'),
                    'type' => Controls_Manager::TEXT,
                    'default' => '150',
                    'label_block' => false
                ]
            );
            $pricings->add_control(
                'heading_text',
                [
                    'label' => esc_html__('Heading', 'genzia'),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__('Starter Plan', 'genzia'),
                    'placeholder' => esc_html__('Enter your title', 'genzia'),
                    'label_block' => true
                ]
            );
            $pricings->add_control(
                'description_text',
                [
                    'label' => esc_html__('Description', 'genzia'),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => 'Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                    'placeholder' => esc_html__('Enter your description', 'genzia'),
                    'rows' => 10,
                    'show_label' => true,
                    'separator' => 'before'
                ]
            );
            // Button #1
            genzia_elementor_link_settings($pricings, [
                'name' => 'link1_',
                'mode' => 'btn',
                'group' => false,
                'label' => esc_html__('Button Settings', 'genzia'),
                'color_label' => esc_html__('Button', 'genzia'),
                'text' => 'Get Started',
                'color' => false
            ]);
            // Features
            $this->add_control(
                'feature_title',
                [
                    'label'       => esc_html__('Feature Title', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Feature Title',
                    'placeholder' => esc_html__('Enter your feature title', 'genzia'),
                    'rows'        => 5,
                    'show_label'  => true,
                    'separator'   => 'before'
                ]
            );
            $pricings->add_control(
                'features',
                [
                    'label' => esc_html__('Features', 'genzia'),
                    'type' => CSH_Theme_Core::REPEATER_CONTROL,
                    'label_block' => true,
                    'separator' => 'before',
                    'button_text' => esc_html__('Add Feature', 'genzia'),
                    'controls' => array(
                        array(
                            'name' => 'available',
                            'label' => esc_html__('Available?', 'genzia'),
                            'type' => Controls_Manager::SELECT,
                            'options' => [
                                'yes' => esc_html__('Yes', 'genzia'),
                                'no' => esc_html__('No', 'genzia')
                            ],
                            'default' => 'yes',
                            'label_block' => false
                        ),
                        array(
                            'name' => 'title',
                            'label' => esc_html__('Feature Text', 'genzia'),
                            'type' => Controls_Manager::TEXTAREA,
                            'default' => 'Your feature text',
                            'label_block' => false
                        )
                    )
                ]
            );
            //
            $this->add_control(
                'cms_pricings',
                [
                    'label' => esc_html__('Pricing Lists', 'genzia'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $pricings->get_controls(),
                    'default' => [
                        [
                            'price' => '5.99',
                            'price_pack' => '/Month',
                            'heading_text' => 'Basic Plan',
                            'description_text' => 'Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
                            'features' => ''
                        ],
                        [
                            'price' => '10.99',
                            'price_pack' => '/Month',
                            'heading_text' => 'Standard Plan',
                            'description_text' => 'Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
                            'featured' => 'yes',
                            'features' => ''
                        ],
                        [
                            'price' => '19.99',
                            'price_pack' => '/Month',
                            'heading_text' => 'Pro Plan',
                            'description_text' => 'Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
                            'features' => ''
                        ]
                    ],
                    'title_field' => '{{{ heading_text }}}',
                    'button_text' => esc_html__('Add Pricing', 'genzia')
                ]
            );
        $this->end_controls_section();
        // Settings
        $this->start_controls_section(
            'settings_section',
            [
                'label' => esc_html__('Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );
            $this->add_control(
                'currency',
                [
                    'label' => esc_html__('Currency', 'genzia'),
                    'type' => Controls_Manager::TEXT,
                    'default' => '$',
                    'placeholder' => 'Currency',
                    'label_block' => false
                ]
            );
            $this->add_control(
                'price_pack',
                [
                    'label' => esc_html__('Price Pack', 'genzia'),
                    'type' => Controls_Manager::TEXT,
                    'default' => '/Month',
                    'label_block' => false
                ]
            );
            // Sale Off
            $this->add_control(
                'show_sale_off',
                [
                    'label' => esc_html__('Show Sale Off Calculator', 'genzia'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'no',
                    'label_block' => true
                ]
            );
            $this->add_control(
                'sale_off',
                [
                    'label' => esc_html__('Sale Off', 'genzia') . ' (%)',
                    'type' => Controls_Manager::NUMBER,
                    'default' => 30,
                    'placeholder' => 30,
                    'label_block' => false,
                    'min' => 0,
                    'max' => 100,
                    'condition' => [
                        'show_sale_off' => 'yes'
                    ]
                ]
            );
            // Switcher
            genzia_elementor_colors_opts($this, [
                'name' => 'text_color',
                'label' => esc_html__('Text', 'genzia'),
                'description' => esc_html__('Color Settings', 'genzia'),
                'classes' => 'cms-description-as-label',
                'condition' => [
                    'show_sale_off' => 'yes'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name' => 'switcher_text_color',
                'label' => esc_html__('Switcher Text', 'genzia'),
                'condition' => [
                    'show_sale_off' => 'yes'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name' => 'switched_text_color',
                'label' => esc_html__('Switched Text', 'genzia'),
                'condition' => [
                    'show_sale_off' => 'yes'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name' => 'switcher_color',
                'label' => esc_html__('Switcher', 'genzia'),
                'condition' => [
                    'show_sale_off' => 'yes'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name' => 'switcher_bg',
                'label' => esc_html__('Switcher Background', 'genzia'),
                'condition' => [
                    'show_sale_off' => 'yes'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name' => 'switched_bg',
                'label' => esc_html__('Switched Background', 'genzia'),
                'condition' => [
                    'show_sale_off' => 'yes'
                ]
            ]);
        $this->end_controls_section();
        // Carousel Settings
        genzia_elementor_carousel_settings($this, [
            'condition' => [
                'layout' => '4'
            ],
            'slides_to_show'   => 1,
            'slides_to_scroll' => 1
        ]);
    }
}
