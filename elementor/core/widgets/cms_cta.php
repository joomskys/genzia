<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

/**
 * CTA Widget.
 *
 * Call to Action widget that displays styled content with links and buttons.
 *
 * @since 1.0.0
 */
class Widget_CTA extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_cta');
        $this->set_title(esc_html__('CMS CTA', 'genzia'));
        $this->set_icon('eicon-call-to-action');
        $this->set_keywords(['cta', 'call to action', 'button', 'link', 'cms', 'genzia']);
        parent::__construct($data, $args);
    }

    /**
     * Register CTA widget controls.
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/1.webp'
                        ],
                        '2' => [
                            'title' => esc_html__('Layout 2', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/2.webp'
                        ],
                        '3' => [
                            'title' => esc_html__('Layout 3', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/3.webp'
                        ],
                        '4' => [
                            'title' => esc_html__('Layout 4', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_cta/layout/4.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Content Section Start
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );  
            // Heading   
            $this->add_control(
                'heading',
                [
                    'label'       => esc_html__('Heading', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Your Heading',
                    'placeholder' => esc_html__('Enter your heading', 'genzia'),
                    'condition'   => [
                        'layout' => ['4']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'heading_color',
                'label'     => esc_html__('Heading Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-title' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'text!'  => '',
                    'layout' => ['4']
                ]
            ]);
            // Description   
            $this->add_control(
                'text',
                [
                    'label'       => esc_html__('Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'condition'   => [
                        'layout' => ['1','3','4']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'text_color',
                'label'     => esc_html__('Description Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-desc' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'text!'  => '',
                    'layout' => ['1','3','4']
                ]
            ]);
            // Link
            genzia_elementor_link_settings($this, [
                'name'          => 'link_',
                'mode'          => 'btn',
                'icon_settings' => [
                    'enable' => true
                ],
                'text'      => 'Click Here',
                'group'     => false,
                'separator' => 'before'
            ]);
            // Email
            genzia_elementor_link_settings($this, [
                'name'      => 'email_',
                'mode'      => 'link',
                'label'     => esc_html__('Email Settings','genzia'),
                'text'      => 'Genzia@mail.com',
                'group'     => false,
                'separator' => 'before',
                'condition' => [
                    'layout' => ['4']
                ]
            ]);
        $this->end_controls_section();
        // Style Settings
        $this->start_controls_section(
            'style_section',
            [
                'label'     => esc_html__('Style Settings', 'genzia'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => ['4']
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
                    'skin'        => 'inline'
                ]
            );
        $this->end_controls_section();
    }
}
