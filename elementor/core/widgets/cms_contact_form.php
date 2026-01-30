<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

/**
 * Contact Form Widget.
 *
 * A widget that displays contact forms with integrated styling
 * and layout options.
 *
 * @since 1.0.0
 */
class Widget_Contact_Form extends Widget_Base
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
        $this->set_name('cms_contact_form');
        $this->set_title(esc_html__('CMS Contact Form', 'genzia'));
        $this->set_icon('eicon-form-horizontal');
        $this->set_keywords(['contact', 'form', 'cms', 'genzia']);
        $this->set_script_depends(['cms-elementor-custom']);

        parent::__construct($data, $args);
    }

    /**
     * Register Contact Form widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls(): void
    {
        $cf7 = get_posts(['post_type' => 'wpcf7_contact_form', 'numberposts' => -1]);
        $contact_forms = array();
        if ($cf7) {
            foreach ($cf7 as $cform) {
                $form_ID = substr(get_post_meta($cform->ID, '_hash', true), 0, absint(7)); // Get hash form ID
                //
                $contact_forms[$form_ID] = $cform->post_title;
            }
        } else {
            $contact_forms[0] = esc_html__('No contact forms found', 'genzia');
        }
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
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_contact_form/layout/1.webp'
                        ],
                        '2' => [
                            'title' => esc_html__('Layout 2', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_contact_form/layout/2.webp'
                        ],
                        '-popup' => [
                            'title' => esc_html__('Popup', 'genzia'),
                            'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_contact_form/layout/popup.webp'
                        ]
                    ],
                    'label_block' => true
                ]
            );
        $this->end_controls_section();
        // Content Tab Start

        // Source Section Start
        $this->start_controls_section(
            'source_section',
            [
                'label' => esc_html__('Form Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            $this->add_control(
                'ctf7_popup_title',
                [
                    'label'       => esc_html__('Popup Field Title', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'label_block' => true,
                    'separator'   => 'before',
                    'condition'   => [
                        'layout' => ['-popup']
                    ]
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'ctf7_popup_title_color',
                'label'     => esc_html__('Pupup Title Color', 'genzia'),
                'condition' => [
                    'layout' => ['-popup']
                ],
                'selectors' => [
                    '{{WRAPPER}} .cms-popup-text' => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($this, [
                'name'      => 'ctf7_popup_title_color_hover',
                'label'     => esc_html__('Pupup Title Color Hover', 'genzia'),
                'condition' => [
                    'layout' => ['-popup']
                ],
                'selectors' => [
                    '{{WRAPPER}} .cms-popup-text' => '--cms-text-hover-custom:{{VALUE}};'
                ]
            ]);
            $this->add_control(
                'popup_cursor_color',
                [
                    'label'   => esc_html__('Pupup Cursor Color', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''       => esc_html__('Default', 'genzia'),
                        '-white' => esc_html__('White', 'genzia'),
                        '-black' => esc_html__('Black', 'genzia')
                    ],
                    'condition' => [
                        'layout' => ['-popup']
                    ]
                ]
            );
            $this->add_control(
                'ctf7_slug',
                [
                    'label'       => esc_html__('Select Form', 'genzia'),
                    'type'        => Controls_Manager::SELECT,
                    'options'     => $contact_forms,
                    'label_block' => true,
                    'separator'   => 'before'
                ]
            );
            genzia_elementor_icon_image_settings($this, [
                'name'         => 'ctf7_title_icon',
                'group'        => false,
                'icon_default' => []
            ]);

            $this->add_control(
                'ctf7_small_title',
                [
                    'label'       => esc_html__('Form Small Title', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'label_block' => true
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'small_title_color',
                'selectors' => [
                    '{{WRAPPER}} .cms-small' => 'color:{{VALUE}}'
                ],
                'condition' => [
                    'ctf7_small_title!' => ''
                ]
            ]);
            $this->add_control(
                'ctf7_title',
                [
                    'label'       => esc_html__('Form Title', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'label_block' => true
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'title_color',
                'selectors' => [
                    '{{WRAPPER}} .cms-title' => 'color:{{VALUE}}'
                ],
                'condition' => [
                    'ctf7_title!' => ''
                ]
            ]);
            $this->add_control(
                'ctf7_description',
                [
                    'label'       => esc_html__('Form Description', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'label_block' => true
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'desc_color',
                'selectors' => [
                    '{{WRAPPER}} .cms-desc' => 'color:{{VALUE}}'
                ],
                'condition' => [
                    'ctf7_description!' => ''
                ]
            ]);
            $this->add_control(
                'ctf7_note',
                [
                    'label'       => esc_html__('Form Note', 'genzia'),
                    'description' => esc_html__('Add your note after Submit button', 'genzia'),
                    'type'        => Controls_Manager::TEXTAREA,
                    'label_block' => true
                ]
            );
            genzia_elementor_colors_opts($this, [
                'name'      => 'note_color',
                'selectors' => [
                    '{{WRAPPER}} .cms-note' => 'color:{{VALUE}}'
                ],
                'condition' => [
                    'ctf7_note!' => ''
                ]
            ]);
        $this->end_controls_section();
        // Style
        genzia_elementor_form_style_settings($this);
        //
        $this->start_controls_section(
            'background_section',
            [
                'label' => esc_html__('Style Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
            genzia_elementor_colors_opts($this, [
                'name'      => 'bg_color',
                'label'     => esc_html__('Background Color','genzia'), 
                'selectors' => [
                    '{{WRAPPER}} .cms-ecf7' => 'background-color:{{VALUE}}'
                ]
            ]);
        $this->end_controls_section();
    }
}
?>