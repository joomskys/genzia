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
            // Description   
            $this->add_control(
                'text',
                [
                    'label'       => esc_html__('Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                    'placeholder' => esc_html__('Enter your text', 'genzia'),
                    'condition'   => [
                        'layout' => ['1']
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
                    'layout' => ['1']
                ]
            ]);
            // Link
            genzia_elementor_link_settings($this, [
                'name'      => 'link_',
                'text'      => 'Click Here',
                'group'     => false,
                'separator' => 'before'
            ]);
        $this->end_controls_section();
    }
}
