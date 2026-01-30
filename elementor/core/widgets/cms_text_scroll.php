<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use CSH_Theme_Core;

/**
 * Text Scroll Widget.
 *
 * Text Scroll widget that displays process steps or workflow with features and descriptions
 * in various layout configurations including sticky layouts.
 *
 * @since 1.0.0
 */
class Widget_Text_Scroll extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_text_scroll');
        $this->set_title(esc_html__('CMS Text Scroll', 'genzia'));
        $this->set_icon('eicon-scroll');
        $this->set_keywords(['scroll', 'text scroll', 'cms text scroll', 'genzia']);
        $this->set_script_depends(['cms-elementor-custom', 'cms-slider-video',]);
        $this->set_style_depends(['swiper', 'e-animation-fadeInRight']);

        parent::__construct($data, $args);
    }

    /**
     * Register Text Scroll widget controls.
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
                'tab'   => Controls_Manager::TAB_LAYOUT,
            ]
        );
        $this->add_control(
            'layout',
            [
                'label'   => esc_html__('Templates', 'genzia'),
                'type'    => CSH_Theme_Core::LAYOUT_CONTROL,
                'default' => '1',
                'options' => [
                    '1' => [
                        'label' => esc_html__('Layout 1', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_text_scroll/layout/1.webp'
                    ],
                    '2' => [
                        'label' => esc_html__('Layout 2', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_text_scroll/layout/2.webp'
                    ],
                    '3' => [
                        'label' => esc_html__('Layout 3', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_text_scroll/layout/3.webp'
                    ],
                    '4' => [
                        'label' => esc_html__('Layout 4', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_text_scroll/layout/4.webp'
                    ],
                    '5' => [
                        'label' => esc_html__('Layout 5', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_text_scroll/layout/3.webp'
                    ],
                    '6' => [
                        'label' => esc_html__('Layout 6', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_text_scroll/layout/6.webp'
                    ]
                ]
            ]
        );
        $this->end_controls_section();
        // Text Settings
        $this->start_controls_section(
            'text_section',
            [
                'label' => esc_html__('Text Settings', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );
            //
            $text = new Repeater();
            $text->add_control(
                'banner',
                [
                    'label'   => esc_html__('Banner Image', 'genzia'),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                    'label_block' => false
                ]
            );
            $text->add_control(
                'banner_video',
                [
                    'label'              => esc_html__('Banner Video', 'genzia'),
                    'description'        => esc_html__('Just enter Youtube video URL', 'genzia'),
                    'type'               => Controls_Manager::TEXTAREA,
                    'default'            => '',
                    'label_block'        => false,
                    'frontend_available' => true
                ]
            );
            $text->add_control(
                'text',
                [
                    'label'   => esc_html__('Text', 'genzia'),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => 'Your Text'
                ]
            );
            // Start List
            $this->add_control(
                'cms_texts',
                [
                    'label'   => esc_html__('Scoll Texts', 'genzia'),
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $text->get_controls(),
                    'default' => [
                        [
                            'banner' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'text' => 'Dummy Text #1'
                        ],
                        [
                            'banner' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'text' => 'Dummy Text #2'
                        ],
                        [
                            'banner' => [
                                'url' => Utils::get_placeholder_image_src(),
                            ],
                            'text' => 'Dummy Text #3'
                        ]
                    ],
                    'title_field' => '{{{ text }}}'
                ]
            );
        $this->end_controls_section();
        // style
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'genzia'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            $this->add_control(
                'overflow',
                [
                    'label'        => esc_html__('Overflow Hidden?', 'genzia'),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => 'yes'
                ]
            );
            $this->add_control(
                'spaceBetween',
                [
                    'label'   => esc_html__('Space Between', 'genzia'),
                    'type'    => Controls_Manager::NUMBER,
                    'default' => '',
                    'min'     => 0,
                    'max'     => 200
                ]
            );
            $this->add_control(
                'speed',
                [
                    'label'   => esc_html__('Speed', 'genzia'),
                    'type'    => Controls_Manager::NUMBER,
                    'default' => 4000
                ]
            );
            $this->add_control(
                'direction',
                [
                    'label'   => esc_html__('Direction', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'false' => esc_html__('Right to Left', 'genzia'),
                        'true'  => esc_html__('Left to Right', 'genzia'),
                    ],
                    'default'   => 'false',
                    'separator' => 'after',
                    'classes'   => 'cms-eseparator'
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'  => 'text_color',
                'label' => esc_html__('Text Color', 'genzia')
            ]);
            genzia_elementor_colors_opts($this, [
                'name'  => 'text_color_hover',
                'label' => esc_html__('Text Color On Hover', 'genzia')
            ]);
        $this->end_controls_section();
    }
}