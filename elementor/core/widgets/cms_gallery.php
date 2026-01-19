<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

/**
 * Gallery Widget.
 *
 * Displays a gallery of images with customizable layout and settings.
 *
 * @since 1.0.0
 */
class Widget_Gallery extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_gallery');
        $this->set_title(esc_html__('CMS Gallery', 'genzia'));
        $this->set_icon('eicon-gallery-grid');
        $this->set_keywords(['gallery', 'image', 'cms', 'genzia']);
        $this->set_script_depends(['cms-galleries']);
        $this->set_style_depends(['e-swiper']);

        parent::__construct($data, $args);
    }

    /**
     * Register Gallery widget controls.
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
                'tab'   => Controls_Manager::TAB_LAYOUT,
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
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_gallery/layout/1.webp'
                    ]
                ],
                'label_block' => true
            ]
        );
        $this->end_controls_section();
        // Gallery
        $this->start_controls_section(
            'section_gallery',
            [
                'label' => esc_html__('Gallery Image', 'genzia'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'gallery',
            [
                'label'   => esc_html__('Add Images', 'genzia'),
                'type'    => Controls_Manager::GALLERY
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'gallery',
                'label'   => esc_html__('Image Size', 'genzia'),
                'default' => 'medium'
            ]
        );
        $this->end_controls_section();
        // Settings
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Settings','genzia'),
                'tab'   => Controls_Manager::TAB_SETTINGS
            ]
        );
        $this->add_responsive_control(
            'col',
            [
                'label'        => esc_html__('Columns', 'genzia'),
                'type'         => Controls_Manager::SELECT,
                'default'      => '',
                'default_args' => [
                    'tablet' => '',
                    'mobile' => ''
                ],
                'options' => [
                    ''     => esc_html__('Default', 'genzia'),
                    '1'    => '1',
                    '2'    => '2',
                    '3'    => '3',
                    '4'    => '4',
                    '6'    => '6',
                    'auto' => esc_html__('Auto', 'genzia'),
                ]
            ]
        );
        $this->add_control(
            'gallery_rand',
            [
                'label'   => esc_html__('Order By', 'genzia'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''     => esc_html__('Default', 'genzia'),
                    'rand' => esc_html__('Random', 'genzia'),
                ],
                'default' => '',
            ]
        );
        $this->add_control(
            'gallery_show',
            [
                'label'   => esc_html__('Number of item to show', 'genzia'),
                'type'    => Controls_Manager::NUMBER,
                'default' => ''
            ]
        );
        $this->add_control(
            'gallery_loadmore_show',
            [
                'label'   => esc_html__('Number of item to show on load more', 'genzia'),
                'type'    => Controls_Manager::NUMBER,
                'default' => ''
            ]
        );
        $this->add_control(
            'load_more_text',
            [
                'label'   => esc_html__('Load More Text', 'genzia'),
                'type'    => Controls_Manager::TEXT
            ]
        );
        // All
        $this->add_control(
            'open_lightbox',
            [
                'label'        => esc_html__('Open Lightbox', 'genzia'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes', 
                'return_value' => 'yes'
            ]
        );
        $this->add_control(
            'show_caption',
            [
                'label'        => esc_html__('Show Caption', 'genzia'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no', 
                'return_value' => 'yes'
            ]
        );
        $this->end_controls_section();
    }
}
