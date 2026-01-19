<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use CSH_Theme_Core;

/**
 * Post Feature Widget.
 *
 * A widget that displays featured posts with image and video options,
 * allowing users to showcase specific content prominently.
 *
 * @since 1.0.0
 */
class Widget_Post_Feature extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_post_feature');
        $this->set_title(esc_html__('CMS Post Feature', 'genzia'));
        $this->set_icon('eicon-post');
        $this->set_keywords(['post', 'feature', 'highlight', 'cms', 'genzia']);

        parent::__construct($data, $args);
    }

    /**
     * Register Post Feature widget controls.
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
                'label' => esc_html__('Templates', 'genzia'),
                'type' => CSH_Theme_Core::LAYOUT_CONTROL,
                'default' => '1',
                'options' => [
                    '1' => [
                        'label' => esc_html__('Layout 1', 'genzia'),
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_post_feature/layout/1.webp'
                    ]
                ]
            ]
        );
        $this->end_controls_section();

        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'banner',
            [
                'label' => esc_html__('Replace Feature Image?', 'genzia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'label_block' => true
            ]
        );

        $this->add_control(
            'video_link',
            [
                'label' => esc_html__('Video', 'genzia'),
                'description' => esc_html__('Video url from YouTube/Vimeo', 'genzia'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'frontend_available' => true,
                'label_block' => true,
                'condition' => [
                    'layout' => ['1']
                ]
            ]
        );
        $this->end_controls_section();
    }
}
