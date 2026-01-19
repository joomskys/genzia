<?php
namespace Genzia\Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Widget_Base as Elementor_Widget_Base;
use Elementor\Utils;

/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
abstract class Widget_Base extends Elementor_Widget_Base
{
    protected $name;
    protected $title;
    protected $icon;
    protected $categories = ['genzia-widgets'];
    protected $keywords;
    protected $custom_help_url = '';
    protected $style_depends = [];
    protected $script_depends = [];

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
    }

    protected function set_name($name)
    {
        $this->name = $name;
    }

    /**
     * Get widget name.
     *
     * Retrieve widget name.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name()
    {
        return $this->name;
    }

    protected function set_title($title)
    {
        $this->title = $title;
    }

    /**
     * Get widget title.
     *
     * Retrieve widget title.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title()
    {
        return $this->title;
    }

    protected function set_icon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * Get widget icon.
     *
     * Retrieve widget icon.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return $this->icon;
    }

    protected function set_custom_help_url($custom_help_url)
    {
        $this->custom_help_url = $custom_help_url;
    }

    /**
     * Get custom help URL.
     *
     * Retrieve a URL where the user can get more information about the widget.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget help URL.
     */
    public function get_custom_help_url()
    {
        return $this->custom_help_url;
    }

    protected function set_categories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return $this->categories;
    }

    protected function set_keywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return $this->keywords;
    }

    /**
     * Set script dependencies.
     *
     * Retrieve the list of script dependencies the element requires.
     *
     * @since 1.3.0
     * @access protected
     *
     * @param array      $script_depends Widget data. Default is an empty array.
     */
    protected function set_script_depends($script_depends)
    {
        $this->script_depends = $script_depends;
    }

    /**
     * Get script dependencies.
     *
     * Retrieve the list of script dependencies the element requires.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Element scripts dependencies.
     */
    public function get_script_depends()
    {
        return $this->script_depends;
    }

    /**
     * Set style dependencies.
     *
     * Retrieve the list of style dependencies the element requires.
     *
     * @since 1.9.0
     * @access public
     *
     * @param array      $style_depends Widget data. Default is an empty array.
     */
    protected function set_style_depends($style_depends)
    {
        $this->style_depends = $style_depends;
    }

    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the element requires.
     *
     * @since 1.9.0
     * @access public
     *
     * @return array Element styles dependencies.
     */
    public function get_style_depends()
    {
        return $this->style_depends;
    }

    public function get_settings_for_display($setting_key = null, $setting_default = null)
    {
        $settings = parent::get_settings_for_display($setting_key);

        $settings = !empty($settings) ? $settings : $setting_default;

        return $settings;
    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $template_name = $this->get_name();
        $layout = $settings['layout'] ?? '1';
        $layout_name = "layout{$layout}.php";
        $template_path = "elementor/templates/widgets/{$template_name}/{$layout_name}";
        $template = get_theme_file_path($template_path);
        $widget = $this;
        if (file_exists($template)) {
            include $template;
        }
    }

    public function add_inline_editing_attributes($key, $toolbar = 'basic')
    {
        parent::add_inline_editing_attributes($key, $toolbar);
    }

    public function get_repeater_setting_key($setting_key, $repeater_key, $repeater_item_index)
    {
        return parent::get_repeater_setting_key($setting_key, $repeater_key, $repeater_item_index);
    }

    public function parse_text_editor($content)
    {
        return parent::parse_text_editor($content);
    }

    public function get_setting($setting, $default = '')
    {
        $setting_value = parent::get_settings($setting);
        $setting_value = !empty($setting_value) ? $setting_value : $default;
        return $setting_value;
    }
}