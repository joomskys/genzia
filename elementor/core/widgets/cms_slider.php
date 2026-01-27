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
 * Sliders Widget.
 *
 * Sliders widget that displays process steps or workflow with features and descriptions
 * in various layout configurations including sticky layouts.
 *
 * @since 1.0.0
 */
class Widget_Sliders extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_slider');
        $this->set_title(esc_html__('CMS Slider', 'genzia'));
        $this->set_icon('eicon-slides');
        $this->set_keywords(['slider', 'cms', 'genzia']);
        $this->set_script_depends([ 
            'cms-post-carousel-widget-js',
            'cms-slider-video'
        ]);
        $this->set_style_depends([
            'swiper', 
            'e-animation-fadeLeft', 
            'e-animation-fadeInRight', 
            'e-animation-fadeInUp'
        ]);

        parent::__construct($data, $args);
    }

    /**
     * Register Sliders widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls(): void
    {
        // Layout Tab Start
        $this->start_controls_section('layout_section', [
            'label' => esc_html__('Layout', 'genzia'),
            'tab'   => Controls_Manager::TAB_LAYOUT,
        ]);
            $this->add_control('header_transparent', [
                'label'        => esc_html__('Header Transparent', 'genzia'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'prefix_class' => 'cms-eslider-header-transparent-',
                'description'  => esc_html__('Make arrows alignment middle when have Header Transparent', 'genzia'),
            ]);
            //
            $this->add_control('layout', [
                'label'   => esc_html__('Choose Layout', 'genzia'),
                'type'    => Controls_Manager::VISUAL_CHOICE,
                'default' => '1',
                'options' => [
                    '1' => [
                        'title' => esc_html__('Layout 1', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_slider/layout/1.webp',
                    ],
                    '2' => [
                        'title' => esc_html__('Layout 2', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_slider/layout/2.webp',
                    ],
                    '3' => [
                        'title' => esc_html__('Layout 3', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_slider/layout/3.webp',
                    ],
                    '4' => [
                        'title' => esc_html__('Layout 4', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_slider/layout/4.webp',
                    ]
                ],
                'label_block' => true
            ]);
        $this->end_controls_section();

        // Slider List Section Start
        $this->start_controls_section('slider_list_section', [
            'label' => esc_html__('Slider List', 'genzia'),
            'tab'   => Controls_Manager::TAB_CONTENT
        ]);
            $repeater = new Repeater();
            $repeater->add_control(
                'slide_type',
                [
                    'label'       => esc_html__('Slider Type', 'genzia'),
                    'type'        => Controls_Manager::SELECT,
                    'label_block' => false,
                    'options'     => [
                        'img' => esc_html__('Image', 'genzia'),
                        'video' => esc_html__('Youtube Video', 'genzia')
                    ],
                    'default' => 'img'
                ]
            );
            $repeater->add_control(
                'image',
                [
                    'label'       => esc_html__('Main Image', 'genzia'),
                    'type'        => Controls_Manager::MEDIA,
                    'label_block' => false,
                    'default'     => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                    'condition' => [
                        //'slide_type' => 'img'
                    ]
                ]
            );
            $repeater->add_control(
                'slide_video',
                [
                    'label'       => esc_html__('Youtube Video', 'genzia'),
                    'description' => esc_html__('Just enter Youtube video URL', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
                    'placeholder' => '',
                    'label_block' => true,
                    'condition'   => [
                        'slide_type' => 'video'
                    ],
                    'frontend_available' => true
                ]
            );
            $repeater->add_control(
                'slide_video_overlay',
                [
                    'label'     => esc_html__('Overlay Video', 'genzia'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.cms-evideo-bg:after' => 'background-color:{{VALUE}};'
                    ],
                    'condition' => [
                        'slide_type'   => 'video',
                        'slide_video!' => ''
                    ]
                ]
            );
            $repeater->add_control(
                'subtitle',
                [
                    'label'       => esc_html__('Sub Title', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => esc_html__('This is the subtitle', 'genzia'),
                    'placeholder' => esc_html__('Enter your subtitle', 'genzia'),
                    'label_block' => true
                ]
            );
            $repeater->add_control(
                'title',
                [
                    'label'       => esc_html__('Title', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => esc_html__('This is the title', 'genzia'),
                    'placeholder' => esc_html__('Enter your title', 'genzia'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'title_img',
                [
                    'label'       => esc_html__('Title Image', 'genzia'),
                    'type'        => Controls_Manager::MEDIA,
                    'default'     => [],
                    'placeholder' => [],
                    'label_block' => false,
                    'skin'        => 'inline',
                    'condition'   => [
                        'title!' => ''
                    ],
                    'description' => esc_html__('Use {{title_img}} to insert image where you want','genzia')
                ]
            );
            $repeater->add_control(
                'description',
                [
                    'label'       => esc_html__('Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => esc_html__('This is the description', 'genzia'),
                    'placeholder' => esc_html__('Enter your description', 'genzia'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'button_primary',
                [
                    'label'       => esc_html__('Button Text', 'genzia'),
                    'description' => esc_html__('Button Primary', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__('Button Primary', 'genzia'),
                    'label_block' => true,
                    'classes'     => 'cms-description-as-label'
                ]
            );
            $repeater->add_control(
                'button_primary_link',
                [
                    'label'       => esc_html__('Button Link', 'genzia'),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__('https://your-link.com', 'genzia'),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'button_primary!'     => ''
                    ],
                    'description' => esc_html__('Type text to find Post/Page name or just enter your custom URL', 'genzia')
                ]
            );
            // Button Secondary 
            $repeater->add_control(
                'button_secondary',
                [
                    'label'       => esc_html__('Button Text', 'genzia'),
                    'description' => esc_html__('Button Secondary', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__('Button Secondary', 'genzia'),
                    'label_block' => true,
                    'classes'     => 'cms-description-as-label'
                ]
            );
            $repeater->add_control(
                'button_secondary_link',
                [
                    'label'       => esc_html__('Button Link', 'genzia'),
                    'type'        => Controls_Manager::URL,
                    'placeholder' => esc_html__('https://your-link.com', 'genzia'),
                    'default'     => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'button_secondary!'     => ''
                    ],
                    'description' => esc_html__('Type text to find Post/Page name or just enter your custom URL', 'genzia')
                ]
            );
            // Video Button
            $repeater->add_control(
                'video_link',
                [
                    'label'       => esc_html__('Button Video', 'genzia'),
                    'description' => esc_html__('Video url from  YouTube/Vimeo/Dailymotion.', 'genzia') . ' EX: https://www.youtube.com/watch?v=XHOmBV4js_E',
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'dynamic'     => [
                        'active' => true
                    ],
                    'label_block'        => true,
                    'frontend_available' => true,
                ]
            );
            $repeater->add_control(
                'video_text',
                [
                    'label'       => '',
                    'description' => esc_html__('Text beside play icon', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'How it works',
                    'condition'   => [
                        'video_link!' => ''
                    ],
                    'label_block' => true
                ]
            );
            // Feature
            $repeater->add_control(
                'feature_title',
                [
                    'label'       => esc_html__('Feature Title', 'genzia'),
                    'description' => esc_html__('Features', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true,
                    'classes'     => 'cms-description-as-label'
                ]
            );
            $repeater->add_control(
                'feature_desc',
                [
                    'label'       => esc_html__('Feature Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true
                ]
            );
            $repeater->add_control(
                'features',
                [
                    'label'       => esc_html__('Features List', 'genzia'),
                    'type'        => CSH_Theme_Core::REPEATER_CONTROL,
                    'label_block' => false,
                    'separator'   => 'before',
                    'button_text' => esc_html__('Add Feature', 'genzia'),
                    'controls'    => array(
                        array(
                            'name'        => 'ftitle',
                            'label'       => esc_html__('Feature Text', 'genzia'),
                            'type'        => Controls_Manager::TEXTAREA,
                            'default'     => 'Your feature text',
                            'label_block' => false
                        ),
                        array(
                            'name'        => 'furl',
                            'label'       => esc_html__('Feature Link', 'genzia'),
                            'type'        => Controls_Manager::TEXTAREA,
                            'default'     => '#',
                            'label_block' => false,
                            'description' => esc_html__('add your link here', 'genzia')
                        )
                    ),
                    'classes' => 'cms-title-full cms-eseparator'
                ]
            );
        // Start List
        $this->add_control(
            'cms_slides',
            [
                'label'   => esc_html__('Slides', 'genzia'),
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [
                    [
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'title'       => 'This is Slider Title',
                        'subtitle'    => '',
                        'description' => 'This is slider description. Lorem Ipsum is simply dummy text of the printing and typesetting story.',
                    ],
                    [
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'title'       => 'This is Slider Title',
                        'subtitle'    => '',
                        'description' => 'This is slider description. Lorem Ipsum is simply dummy text of the printing and typesetting story.',
                    ],
                ],
                'title_field' => '{{{ title }}}',
                'button_text' => esc_html__('Add Slide', 'genzia'),
            ]
        );
        $this->end_controls_section();
        // Static Layer
        $this->start_controls_section(
            'static_section',
            [
                'label' => esc_html__('Static Layer', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['1','2']
                ]
            ]
        );
            $statics = new Repeater();
                genzia_elementor_icon_image_settings($statics, [
                    'prefix' => 'static_',
                    'group' => false,
                    'color' => false
                ]);
                $statics->add_control(
                    'title',
                    [
                        'label'   => esc_html__('Title', 'genzia'),
                        'type'    => Controls_Manager::TEXT,
                        'default' => 'Your Title'
                    ]
                );
            // Icon
            $this->add_control(
                'statics',
                [
                    'label'       => esc_html__('Static Icons', 'genzia'),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $statics->get_controls(),
                    'title_field' => '{{title}}',
                    'prevent_empty' => false,
                    'default' => [
                        [
                            'icon_type'     => 'icon',
                            'selected_icon' => [
                                'library' => 'fa-brands',
                                'value'   => 'fab fa-star'
                            ],
                            'title' => 'Your Title'
                        ]
                    ],
                    'button_text' => esc_html__('Add Static Item', 'genzia')
                ]
            );
            $this->add_control(
                'static_color',
                [
                    'label'     => esc_html__('Static Color', 'genzia'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cms-static' => 'color:{{VALUE}};'
                    ]
                ]
            );
            $this->add_control(
                'static_animation',
                [
                    'label'              => esc_html__('Animation', 'genzia'),
                    'type'               => Controls_Manager::ANIMATION,
                    'default'            => 'fadeInRight',
                    'frontend_available' => true
                ]
            );
            $this->add_control(
                'static_animation_delay',
                [
                    'label'              => esc_html__('Animation Delay', 'genzia'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 50,
                    'step'               => 50,
                    'default'            => 300,
                    'frontend_available' => true
                ]
            );
            genzia_add_hidden_device_controls($this, ['prefix' => 'static_']);
        $this->end_controls_section();
        // General Style Section Start
        $this->start_controls_section(
            'general_style_section',
            [
                'label' => esc_html__('General', 'genzia'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->add_control('overlay_style', [
                'label'   => esc_html__('Overlay Style', 'genzia'),
                'type'    => Controls_Manager::SELECT,
                'options' => genzia_elementor_gradient_opts(),
                'default' => ''
            ]);
            $this->add_control(
                'overlay_shadow',
                [
                    'label' => esc_html__('Overlay Shadow', 'genzia'),
                    'type' => Controls_Manager::MEDIA,
                    'label_block' => false,
                    'condition' => [
                        'layout' => ['1'],
                        'overlay_style!' => 'none'
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-slider-item:before' => 'background-image:url("{{URL}}");'
                    ]
                ]
            );
            $this->add_responsive_control(
                'content_width',
                [
                    'label' => esc_html__('Content Width', 'genzia'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range' => [
                        'px' => [
                            'min' => 300,
                            'max' => 1280,
                            'step' => 5
                        ],
                        '%' => [
                            'min' => 10,
                            'max' => 100,
                            'step' => 1
                        ]
                    ],
                    'default' => [
                        'size' => 700,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-slider--content' => 'max-width: {{SIZE}}{{UNIT}};--cms-slider-content-w:{{SIZE}}{{UNIT}};',
                    ]
                ]
            );
            $this->add_responsive_control(
                'content_move_top',
                [
                    'label'      => esc_html__('Content Move Top', 'genzia'),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => ['px'],
                    'range'      => [
                        'px' => [
                            'min' => 0,
                            'max' => 300,
                            'step' => 1
                        ]
                    ],
                    'default' => [
                        'size' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-slider-content' => 'transform: translateY({{SIZE}}{{UNIT}});',
                    ]
                ]
            );
        $this->end_controls_section();
        // Subtitle Style Section Start
        $this->start_controls_section(
            'subtitle_style_section',
            [
                'label'     => esc_html__('Subtitle', 'genzia'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );
            $this->add_control(
                'subtitle_animation',
                [
                    'label'              => esc_html__('Animation', 'genzia'),
                    'type'               => Controls_Manager::ANIMATION,
                    'default'            => 'fadeInLeft',
                    'frontend_available' => true,
                ]
            );
            $this->add_control(
                'subtitle_animation_delay',
                [
                    'label'              => esc_html__('Animation Delay', 'genzia'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 50,
                    'step'               => 50,
                    'default'            => 500,
                    'frontend_available' => true,
                ]
            );
            genzia_add_hidden_device_controls($this, ['prefix' => 'subtitle_']);
        $this->end_controls_section();
        // Title Style Section Start
        $this->start_controls_section(
            'title_style_section',
            [
                'label'     => esc_html__('Title', 'genzia'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );
            $this->add_control(
                'title_animation',
                [
                    'label'              => esc_html__('Animation', 'genzia'),
                    'type'               => Controls_Manager::ANIMATION,
                    'default'            => 'fadeInLeft',
                    'frontend_available' => true,
                ]
            );
            $this->add_control(
                'title_animation_delay',
                [
                    'label'              => esc_html__('Animation Delay', 'genzia'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 50,
                    'step'               => 50,
                    'default'            => 600,
                    'frontend_available' => true,
                ]
            );
            genzia_add_hidden_device_controls($this, ['prefix' => 'title_']);
        $this->end_controls_section();
        // Description Style Section Start
        $this->start_controls_section(
            'description_style_section',
            [
                'label'     => esc_html__('Description', 'genzia'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );
            $this->add_responsive_control(
                'desc_width',
                [
                    'label' => esc_html__('Width', 'genzia'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 300,
                            'max' => 1280,
                            'step' => 5
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-slider-desc' => 'max-width: {{SIZE}}{{UNIT}};',
                    ]
                ]
            );
            $this->add_control(
                'description_animation',
                [
                    'label'              => esc_html__('Animation', 'genzia'),
                    'type'               => Controls_Manager::ANIMATION,
                    'default'            => 'fadeInLeft',
                    'frontend_available' => true,
                ]
            );
            $this->add_control(
                'description_animation_delay',
                [
                    'label'              => esc_html__('Animation Delay', 'genzia'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 50,
                    'step'               => 50,
                    'default'            => 700,
                    'frontend_available' => true,
                ]
            );
            genzia_add_hidden_device_controls($this, ['prefix' => 'desc_']);
        $this->end_controls_section();
        // Button Primary Style Section Start
        $this->start_controls_section(
            'button_primary_style_section',
            [
                'label'     => esc_html__('Button Primary', 'genzia'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );
            $this->add_control(
                'button_primary_animation',
                [
                    'label'              => esc_html__('Animation', 'genzia'),
                    'type'               => Controls_Manager::ANIMATION,
                    'default'            => 'fadeInLeft',
                    'frontend_available' => true,
                ]
            );
            $this->add_control(
                'button_primary_animation_delay',
                [
                    'label'              => esc_html__('Animation Delay', 'genzia'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 50,
                    'step'               => 50,
                    'default'            => 800,
                    'frontend_available' => true,
                ]
            );
            genzia_add_hidden_device_controls($this, ['prefix' => 'btn1_']);
        $this->end_controls_section();
        // Button Secondary Style Section Start
        $this->start_controls_section(
            'button_secondary_style_section',
            [
                'label' => esc_html__('Button Secondary', 'genzia'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            $this->add_control(
                'button_secondary_animation',
                [
                    'label'              => esc_html__('Animation', 'genzia'),
                    'type'               => Controls_Manager::ANIMATION,
                    'default'            => 'fadeInLeft',
                    'frontend_available' => true,
                ]
            );
            $this->add_control(
                'button_secondary_animation_delay',
                [
                    'label'              => esc_html__('Animation Delay', 'genzia'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 50,
                    'step'               => 50,
                    'default'            => 900,
                    'frontend_available' => true,
                ]
            );
            genzia_add_hidden_device_controls($this, ['prefix' => 'btn2_']);
        $this->end_controls_section();
        // Button Video Style Section Start
        $this->start_controls_section(
            'button_video_style_section',
            [
                'label' => esc_html__('Button Video', 'genzia'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            //
            $this->add_control(
                'button_video_animation',
                [
                    'label'              => esc_html__('Animation', 'genzia'),
                    'type'               => Controls_Manager::ANIMATION,
                    'default'            => 'fadeInLeft',
                    'frontend_available' => true,
                ]
            );
            //
            $this->add_control(
                'button_video_animation_delay',
                [
                    'label'              => esc_html__('Animation Delay', 'genzia'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 50,
                    'step'               => 50,
                    'default'            => 1000,
                    'frontend_available' => true,
                ]
            );
            genzia_add_hidden_device_controls($this, ['prefix' => 'btn_video_']);
        $this->end_controls_section();
        // Features Style Section Start
        $this->start_controls_section(
            'feature_style_section',
            [
                'label' => esc_html__('Features', 'genzia'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );
            //
            $this->add_control(
                'feature_animation',
                [
                    'label'              => esc_html__('Animation', 'genzia'),
                    'type'               => Controls_Manager::ANIMATION,
                    'default'            => 'fadeInRight',
                    'frontend_available' => true,
                ]
            );
            //
            $this->add_control(
                'feature_animation_delay',
                [
                    'label'              => esc_html__('Animation Delay', 'genzia'),
                    'type'               => Controls_Manager::NUMBER,
                    'min'                => 50,
                    'step'               => 50,
                    'default'            => 1200,
                    'frontend_available' => true,
                ]
            );
            genzia_add_hidden_device_controls($this, ['prefix' => 'feature_']);
        $this->end_controls_section();
        // Carousel Settings
        $this->start_controls_section(
            'carousel_section',
            [
                'label'     => esc_html__('Carousel Settings', 'genzia'),
                'tab'       => Controls_Manager::TAB_SETTINGS
            ]
        );
            $this->add_responsive_control(
                'slides_height',
                [
                    'label'   => esc_html__('Slider Height', 'genzia'),
                    'type'    => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => '780',
                        'unit' => 'px'
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-eslider' => 'height: {{SIZE}}{{UNIT}};'
                    ],
                    'size_units' => ['px', 'vh', 'custom'],
                    'range' => [
                        'px' => [
                            'min' => 100,
                            'max' => 2000,
                        ],
                        'vh' => [
                            'min' => 20,
                            'max' => 100,
                        ]
                    ]
                ]
            );
            $this->add_control(
                'effect',
                [
                    'label'   => esc_html__('Effect', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'slide',
                    'options' => [
                        'slide' => esc_html__('Slide', 'genzia'),
                        'fade' => esc_html__('Fade', 'genzia'),
                    ],
                    'condition' => [
                        'slides_to_show' => '1',
                    ],
                    'frontend_available' => true,
                ]
            );
            $slides_to_show = range(1, 3);
            $slides_to_show = array_combine($slides_to_show, $slides_to_show);
            $this->add_responsive_control(
                'slides_to_show',
                [
                    'label'   => esc_html__('Slides to Show', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        '' => esc_html__('Default', 'genzia'),
                    ] + $slides_to_show,
                    'default' => 1,
                    'tablet_default' => 1,
                    'mobile_default' => 1,
                    'frontend_available' => true
                ]
            );

            $this->add_responsive_control(
                'slides_to_scroll',
                [
                    'label'       => esc_html__('Slides to Scroll', 'genzia'),
                    'type'        => Controls_Manager::SELECT,
                    'description' => esc_html__('Set how many slides are scrolled per swipe.', 'genzia'),
                    'options'     => [
                        '' => esc_html__('Default', 'genzia'),
                    ] + $slides_to_show,
                    'condition' => [
                        'slides_to_show!' => '1',
                    ],
                    'frontend_available' => true
                ]
            );

            $this->add_responsive_control(
                'space_between',
                [
                    'label' => esc_html__('Space Between', 'genzia'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'size' => 30,
                    ],
                    'condition' => [
                        'slides_to_show!' => '1',
                    ],
                    'frontend_available' => true,
                ]
            );
            // Mousewheel
            $this->add_control(
                'mousewheel',
                [
                    'label'              => esc_html__('Mousewheel Control', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'no',
                    'frontend_available' => true
                ]
            );
            $this->add_control(
                'mousewheel_releaseOnEdges',
                [
                    'label'     => esc_html__('Mousewheel release On Edges', 'genzia'),
                    'type'      => Controls_Manager::SWITCHER,
                    'default'   => 'yes',
                    'condition' => [
                        'mousewheel' => 'yes',
                    ],
                    'frontend_available' => true,
                    'description'        => esc_html__('Swiper will release mousewheel event and allow page scrolling when swiper is on edge positions (in the beginning or in the end)', 'genzia')
                ]
            );
            $this->add_control(
                'mousewheel_sensitivity',
                [
                    'label' => esc_html__('Mousewheel sensitivity', 'genzia'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min'  => 1,
                            'max'  => 5,
                            'step' => 1
                        ]
                    ],
                    'default' => [
                        'size' => 1,
                        'unit' => 'px'
                    ],
                    'size_units' => ['px'],
                    'condition'  => [
                        'mousewheel' => 'yes',
                    ],
                    'frontend_available' => true,
                    'description'        => esc_html__('Multiplier of mousewheel data, allows to tweak mouse wheel sensitivity', 'genzia'),
                    'separator'          => 'after'
                ]
            );
            $this->add_control(
                'lazyload',
                [
                    'label'              => esc_html__('Lazyload', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'frontend_available' => true,
                    'default'            => 'yes',
                    'separator'          => 'before'
                ]
            );
            $this->add_control(
                'infinite',
                [
                    'label'              => esc_html__('Infinite Loop', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                ]
            );
            // Auto Play
            $this->add_control(
                'autoplay',
                [
                    'label'              => esc_html__('Autoplay', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                ]
            );
            $this->add_control(
                'autoplay_speed',
                [
                    'label'     => esc_html__('Autoplay Speed', 'genzia'),
                    'type'      => Controls_Manager::NUMBER,
                    'default'   => 5000,
                    'condition' => [
                        'autoplay' => 'yes',
                    ],
                    'frontend_available' => true,
                ]
            );
            $this->add_control(
                'pause_on_hover',
                [
                    'label'              => esc_html__('Pause on Hover', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'condition'          => [
                        'autoplay' => 'yes',
                    ]
                ]
            );
            $this->add_control(
                'pause_on_interaction',
                [
                    'label'              => esc_html__('Pause on Interaction', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'condition'          => [
                        'autoplay' => 'yes',
                    ],
                ]
            );
            // Speed
            $this->add_control(
                'speed',
                [
                    'label'              => esc_html__('Animation Speed', 'genzia'),
                    'type'               => Controls_Manager::NUMBER,
                    'default'            => 500,
                    'render_type'        => 'none',
                    'frontend_available' => true,
                ]
            );
            // Arrows
            $this->add_control(
                'arrows',
                [
                    'label'              => esc_html__('Show Arrows', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'separator'          => 'before',
                    'classes'            => 'cms-eseparator'
                ]
            );
            genzia_add_hidden_device_controls($this, [
                'prefix'    => 'arrows_',
                'condition' => [
                    'arrows' => 'yes'
                ],
                'separator' => 'before'
            ]);
            // Dots
            $this->add_control(
                'dots',
                [
                    'label'              => esc_html__('Show Dots', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'separator'          => 'before',
                    'classes'            => 'cms-eseparator'
                ]
            );
            genzia_add_hidden_device_controls($this, [
                'prefix'    => 'dots_',
                'condition' => [
                    'dots' => 'yes'
                ]
            ]);
            $this->add_control(
                'dots_type',
                [
                    'label'   => esc_html__('Dots Type', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'progressbar'      => esc_html__('Progressbar', 'genzia'),
                        'bullets'          => esc_html__('Dots', 'genzia'),
                        'circle'           => esc_html__('Dots Circle', 'genzia'),
                        'number'           => esc_html__('Number', 'genzia'),
                        'fraction'         => esc_html__('Fraction (Current/Total)', 'genzia'),
                        'current-of-total' => esc_html__('Current of Total', 'genzia'),
                        'custom'           => esc_html__('Custom', 'genzia')
                    ],
                    'default'            => 'circle',
                    'frontend_available' => true,
                    'condition'          => [
                        'dots' => 'yes'
                    ]
                ]
            );
        $this->end_controls_section();
    }
}