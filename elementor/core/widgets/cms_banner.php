<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;

/**
 * Banner Widget.
 *
 * A widget that displays banners with various layouts and customization options.
 *
 * @since 1.0.0
 */
class Widget_Banner extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_banner');
        $this->set_title(esc_html__('CMS Banner', 'genzia'));
        $this->set_icon('eicon-banner');
        $this->set_keywords(['genzia', 'banner', 'image']);
        $this->set_script_depends(['cms-slider-video']);
        $this->set_style_depends([
            'e-animation-fadeInUp',
            'e-animation-fadeInLeft',
            'e-animation-zoomIn'
        ]);

        parent::__construct($data, $args);
    }

    /**
     * Register Banner widget controls.
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
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_banner/layout/1.webp'
                    ],
                    '2' => [
                        'title' => esc_html__('Layout 2', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_banner/layout/2.webp'
                    ]
                ],
                'label_block' => true
            ]
        );
        $this->end_controls_section();
        // Banner
        $this->start_controls_section(
            'section_single_image',
            [
                'label' => esc_html__('Banner Image', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            $this->add_control(
                'banner',
                [
                    'label' => esc_html__('Banner', 'genzia'),
                    'type' => Controls_Manager::MEDIA,
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
                    'default'   => 'medium',
                    'condition' => [
                        'banner[url]!' => ''
                    ],
                    'label_block' => false
                ]
            );
            $this->add_control(
                'banner_small',
                [
                    'label'   => esc_html__('Banner Small', 'genzia'),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'label_block' => false,
                    'skin'        => 'inline',
                    'condition'   => [
                        'layout' => ['2']
                    ],
                    'separator' => 'before',
                    'classes'   => 'cms-eseparator'
                ]
            );
        $this->end_controls_section();
        // Heading Content
        $this->start_controls_section(
            'section_heading',
            [
                'label'     => esc_html__('Heading Content', 'genzia'),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => ['2']
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
                    'label_block' => true,
                    'condition'   => [
                        'layout' => ['2']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'heading_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-title' => '--text-custom-color: {{VALUE}};'
                ],
                'condition'   => [
                    'layout'        => ['2'],
                    'heading_text!' => ''
                ]
            ]);
            // Description #1
            $this->add_control(
                'desc',
                [
                    'label'       => esc_html__('Description #1', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Lorem Ipsum is simply dummy text of the printing and typesetting story. Lorem Ipsum has been the story standard dummy text ever since',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'rows'        => 10,
                    'show_label'  => true,
                    'condition'   => [
                        'layout' => ['2']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'desc_color',
                'label'     => esc_html__('Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-desc' => '--text-custom-color: {{VALUE}};'
                ],
                'condition'   => [
                    'desc!'  => '',
                    'layout' => ['2']
                ]
            ]);
            // Button
            genzia_elementor_link_settings($this, [
                'mode'          => 'btn',
                'group'         => false,
                'color_label'   => esc_html__('Button', 'genzia'),
                'text'          => 'Click Here',
                'icon_settings' => [
                    'enable'   => true,
                    'selector' => '.cms-btn-icon'
                ]
            ]);
        $this->end_controls_section();
        // Banner Settings
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Banner Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_SETTINGS
            ]
        );
            $this->add_control(
                'img_cover',
                [
                    'label'        => esc_html__('Image Cover?', 'genzia'),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => 'no'
                ]
            );
            $this->add_control(
                'as_background',
                [
                    'label'        => esc_html__('As Background', 'genzia'),
                    'description'  => esc_html__('Make your banner show as background', 'genzia'),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'condition'    => [
                        'layout' => ['1']
                    ],
                    'separator' => 'before',
                    'classes'   => 'cms-eseparator'
                ]
            );
            $this->add_control(
                'bg_pos',
                [
                    'label'   => esc_html__('Background Position', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''              => esc_html__('Default', 'genzia'),
                        'bg-center'     => esc_html__('Center', 'genzia'),
                        'bg-top-center' => esc_html__('Top Center', 'genzia')
                    ],
                    'condition' => [
                        'layout'        => ['1'],
                        'as_background' => ['yes']
                    ]
                ]
            );
            $this->add_control(
                'max_height',
                [
                    'label'        => esc_html__('Max Height', 'genzia'),
                    'description'  => esc_html__('Add image max-height', 'genzia'),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'condition'    => [
                        'layout' => ['1']
                    ]
                ]
            );
            $this->add_control(
                'e_classes',
                [
                    'label'   => esc_html__('CSS Classes', 'genzia'),
                    'type'    => Controls_Manager::TEXT,
                    'default' => '',
                    'title'   => esc_html__('Add your custom class WITHOUT the dot. e.g: my-class', 'genzia'),
                    'classes' => 'elementor-control-direction-ltr',
                ]
            );
        $this->end_controls_section();
    }
}

