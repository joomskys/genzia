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
 * Video Player Widget.
 *
 * Video Player widget that displays process steps or workflow with features and descriptions
 * in various layout configurations including sticky layouts.
 *
 * @since 1.0.0
 */
class Widget_Video_Player extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_video_player');
        $this->set_title(esc_html__('CMS Video Player', 'genzia'));
        $this->set_icon('eicon-play');
        $this->set_keywords(['video', 'player', 'cms', 'genzia']);
        $this->set_script_depends(['cms-elementor-custom','cms-video-widget-js']);
        $this->set_style_depends(['e-animation-fadeLeft','e-animation-fadeInRight','e-animation-fadeInUp']);

        parent::__construct($data, $args);
    }

    /**
     * Register Video Player widget controls.
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
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout/1.webp'
                    ],
                    '2' => [
                        'title' => esc_html__('Layout 2', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout/2.webp'
                    ],
                    '3' => [
                        'title' => esc_html__('Layout 3', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout/3.webp'
                    ],
                    '4' => [
                        'title' => esc_html__('Layout 4', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout/4.webp'
                    ],
                    '5' => [
                        'title' => esc_html__('Layout 5', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout/5.webp'
                    ],
                    '-single-practice' => [
                        'title' => esc_html__('Single Practice', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout/single-practice.webp'
                    ],
                    '-video-bg' => [
                        'title' => esc_html__('Background Video', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_video_player/layout/video-bg.webp'
                    ]
                ],
                'label_block'  => true
            ]
        );
        $this->end_controls_section();
        // video_player Section Start
        $this->start_controls_section(
            'section_video_player',
            [
                'label' => esc_html__('Video Content', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            $this->add_control(
                'video_link',
                [
                    'label'              => esc_html__('Video URL', 'genzia'),
                    'subtitle'           => esc_html__('Video url from  YouTube/Vimeo/Dailymotion', 'genzia'),
                    'type'               => Controls_Manager::TEXTAREA,
                    'default'            => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
                    'frontend_available' => true,
                    'label_block'        => true
                ]
            );
            $this->add_control(
                'video_icon',
                [
                    'label'   => esc_html__('Video Icon', 'genzia'),
                    'type'    => Controls_Manager::ICONS,
                    'skin'    => 'inline',
                    'default' => [
                        'value'   => 'fas fa-play',
                        'library' => 'fa-solid'
                    ],
                    'condition' => [
                        'video_link!' => ''
                    ],
                    'label_block' => false
                ]
            );
            $this->add_control(
                'video_text',
                [
                    'label'     => esc_html__('Video Text', 'genzia'),
                    'type'      => Controls_Manager::TEXTAREA,
                    'default'   => '',
                    'condition' => [
                        'layout!'     => ['-stroke'],
                        'video_link!' => ''
                    ],
                    'label_block' => false
                ]
            );
            // Banner
            $this->add_control(
                'image',
                [
                    'label'   => esc_html__('Video Banner', 'genzia'),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'label_block' => false,
                    'condition'   => [
                        'video_link!' => ''
                    ],
                    'before'  => 'separator',
                    'classes' => 'cms-eseparator'
                ]
            );
            // Banner Background
            $this->add_control(
                'banner_bg',
                [
                    'label'   => esc_html__('Video Banner Background', 'genzia'),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'label_block' => false,
                    'condition'   => [
                        'video_link!' => '',
                        'layout'      => ['5']
                    ],
                    'before'  => 'separator',
                    'classes' => 'cms-eseparator'
                ]
            );
        $this->end_controls_section();
        // Content settings
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
            $this->add_control(
                'heading_icon',
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
                        'layout'        => ['2'],
                        'heading_text!' => ''
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'heading_icon_color',
                'label'     => esc_html__('Icon Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-heading-icon' => '--text-custom-color: {{VALUE}};'
                ],
                'condition' => [
                    'layout'               => ['2'],
                    'heading_text!'        => '',
                    'heading_icon[value]!' => ''
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
                    'condition' => [
                        'layout' => ['2','3','4','-single-practice']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'heading_color',
                'label'     => esc_html__('Color', 'genzia'),
                'condition' => [
                    'layout'        => ['2','3','4','-single-practice'],
                    'heading_text!' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .cms-evideo-heading-text' => '--cms-custom-color:{{VALUE}};'
                ]
            ]);
            // Description
            $this->add_control(
                'desc',
                [
                    'label'       => esc_html__('Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the Description',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true,
                    'condition' => [
                        'layout' => ['3','4','-single-practice']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'desc_color',
                'label'     => esc_html__('Description Color', 'genzia'),
                'condition' => [
                    'layout' => ['3','4','-single-practice'],
                    'desc!'  => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .cms-evideo-heading-desc' => '--cms-custom-color:{{VALUE}};'
                ]
            ]);
            // Button
            genzia_elementor_link_settings($this, [
                'mode'          => 'btn',
                'group'         => false,
                'label'         => esc_html__('Button Settings', 'genzia'),
                'color_label'   => esc_html__('Button', 'genzia'),
                'text'          => 'Click Here',
                'icon_settings' => [
                    'enable' => true,
                    'selector' => '.cms-heading-btn-icon'
                ],
                'condition' => [
                    'layout' => ['3']
                ]
            ]);
            // Gallery
            $this->add_control(
                'gallery',
                [
                    'label'     => esc_html__('Add Gallery', 'genzia'),
                    'type'      => Controls_Manager::GALLERY,
                    'condition' => [
                        'layout' => ['3','4']
                    ]
                ]
            );
            // Description
            $this->add_control(
                'gallery_desc',
                [
                    'label'       => esc_html__('Gallery Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'This is the Description',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'label_block' => true,
                    'condition' => [
                        'layout' => ['3']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'gallery_desc_color',
                'label'     => esc_html__('Gallery Description Color', 'genzia'),
                'condition' => [
                    'layout'        => ['3'],
                    'gallery_desc!' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .cms-evideo-gallery-desc' => '--cms-custom-color:{{VALUE}};'
                ]
            ]);
        $this->end_controls_section();
        // Style Tab
        $this->start_controls_section(
            'section_video_bg_settings',
            [
                'label' => esc_html__('Video Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_SETTINGS,
                'condition' => [
                    'layout' => ['-video-bg']
                ]
            ]
        );
            $this->add_control(
                'lightbox',
                [
                    'label'              => esc_html__('Lightbox', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'return_value'       => 'yes',
                    'frontend_available' => true
                ]
            );
            $this->add_responsive_control(
                'video_height',
                [
                    'label'   => esc_html__('Video Height', 'genzia'),
                    'type'    => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => '',
                        'unit' => 'px'
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cms-evideo-playback' => 'height: {{SIZE}}{{UNIT}};',
                        //'{{WRAPPER}} .cms-evideo-playback iframe' => 'min-height: {{SIZE}}{{UNIT}};',
                    ],
                    'size_units' => ['px', 'vh'],
                    'range' => [
                        'px' => [
                            'min' => 100,
                            'max' => 2000,
                        ],
                        'vh' => [
                            'min' => 20,
                            'max' => 100,
                        ],
                    ],
                    'condition' => [
                        'lightbox!' => 'yes'
                    ],
                ]
            );
            $this->add_control(
                'autoplay',
                [
                    'label'              => esc_html__('Autoplay', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'condition'          => [
                        'lightbox!' => 'yes'
                    ],
                ]
            );
            $this->add_control(
                'loop',
                [
                    'label'              => esc_html__('Loop', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'condition'          => [
                        'lightbox!' => 'yes'
                    ],
                ]
            );
            $this->add_control(
                'mute',
                [
                    'label'              => esc_html__('Mute', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'condition'          => [
                        'lightbox!' => 'yes'
                    ],
                ]
            );
            $this->add_control(
                'controls',
                [
                    'label'              => esc_html__('Player Controls', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => '',
                    'frontend_available' => true,
                    'condition'          => [
                        'lightbox!' => 'yes'
                    ],
                ]
            );
            $this->add_control(
                'video_fit',
                [
                    'label'              => esc_html__('Video Fit?', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => '',
                    'frontend_available' => true,
                    'condition'          => [
                        'lightbox!' => 'yes'
                    ],
                ]
            );
            $this->add_control(
                'video_scale',
                [
                    'label' => esc_html__('Video Scale?', 'genzia'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 5,
                            'min' => 0.5,
                            'step' => 0.01,
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} iframe.yt-video' => 'scale:{{SIZE}};'
                    ],
                    'condition' => [
                        'video_fit!' => 'yes'
                    ],
                ]
            );
        $this->end_controls_section();
        // Style Tab
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
            genzia_elementor_colors_opts($this, [
                'name'      => 'stroke_color',
                'label'     => esc_html__('Stroke Color', 'genzia'),
                'condition' => [
                    'layout' => [
                        '-stroke'
                    ]
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'stroke_color_hover',
                'label'     => esc_html__('Stroke Color Hover', 'genzia'),
                'condition' => [
                    'layout' => [
                        '-stroke'
                    ]
                ]
            ]);
            //
            genzia_elementor_colors_opts($this, [
                'name'  => 'video_bg_color',
                'label' => esc_html__('Video Background Color', 'genzia')
            ]);
            //
            genzia_elementor_colors_opts($this, [
                'name'      => 'video_icon_color',
                'label'     => esc_html__('Video Icon Color', 'genzia'),
                'separator' => 'before'
            ]);
            genzia_elementor_colors_opts($this, [
                'name'  => 'video_text_color',
                'label' => esc_html__('Video Text Color', 'genzia'),

            ]);
            //
            genzia_elementor_colors_opts($this, [
                'name'      => 'bg_color',
                'label'     => esc_html__('Background Color', 'genzia'),
                'separator' => 'before'
            ]);
        $this->end_controls_section();
    }
}