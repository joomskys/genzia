<?php
namespace Genzia\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Genzia\Elementor\Widget_Base;
use Elementor\Controls_Manager;
use CSH_Theme_Core;

/**
 * Products Widget.
 *
 * Products widget that displays process steps or workflow with features and descriptions
 * in various layout configurations including sticky layouts.
 *
 * @since 1.0.0
 */
class CMS_Widget_Products extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        $this->set_name('cms_products');
        $this->set_title(esc_html__('CMS Products', 'genzia'));
        $this->set_icon('eicon-products');
        $this->set_keywords(['products', 'shop', 'grid', 'cms', 'genzia']);

        parent::__construct($data, $args);
    }

    /**
     * Register Products widget controls.
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
                'tab' => Controls_Manager::TAB_LAYOUT,
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
                        'image' => get_template_directory_uri() . '/elementor/templates/widgets/cms_products/layout/1.webp'
                    ]
                ]
            ]
        );

        $this->end_controls_section();
        // Product Settings
        $this->start_controls_section(
            'products_section',
            [
                'label' => esc_html__('Products Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control(
            'category',
            [
                'label' => esc_html__('Select Categories', 'genzia'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => ctc_get_grid_term_options('product', ['product_cat']),
            ]
        );
        $this->add_control(
            'products_ids',
            [
                'label' => esc_html__('Choose products', 'genzia'),
                'type' => CSH_Theme_Core::POSTS_CONTROL,
                'post_type' => [
                    'product'
                ],
                'multiple' => true,
                'return_value' => 'ID'
            ]
        );
        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Products to show', 'genzia'),
                'type' => Controls_Manager::NUMBER,
                'default' => 8
            ]
        );
        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'genzia'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'genzia'),
                    'ASC' => 'ASC',
                    'DESC' => 'DESC'
                ]
            ]
        );
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Orderby', 'genzia'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    ''            => esc_html__('Default', 'genzia'),
                    'date'        => esc_html__('Date', 'genzia'),
                    'id'          => esc_html__('ID', 'genzia'),
                    'menu_order'  => esc_html__('Menu Order', 'genzia'),
                    'popularity'  => esc_html__('Popularity', 'genzia'),
                    'rand'        => esc_html__('Random', 'genzia'),
                    'rating'      => esc_html__('Rating', 'genzia'),
                    'title'       => esc_html__('Title', 'genzia'),
                    'total_sales' => esc_html__('Total Sales', 'genzia'),
                ]
            ]
        );
        $this->add_control(
            'featured',
            [
                'label' => esc_html__('Only Featured?', 'genzia'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'featured'
            ]
        );
        $this->add_control(
            'on_sale',
            [
                'label' => esc_html__('On Sale', 'genzia'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true'
            ]
        );
        $this->add_control(
            'best_selling',
            [
                'label' => esc_html__('Best Selling', 'genzia'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true'
            ]
        );
        $this->add_control(
            'top_rated',
            [
                'label' => esc_html__('Top Rated', 'genzia'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true'
            ]
        );
        $this->add_control(
            'paginate',
            [
                'label' => esc_html__('Paginate', 'genzia'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true'
            ]
        );
        $this->end_controls_section();
        // Grid Section Start
        $this->start_controls_section(
            'grid_section',
            [
                'label' => esc_html__('Grid Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );
        $this->add_responsive_control(
            'col',
            [
                'label' => esc_html__('Columns', 'genzia'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'default_args' => [
                    'tablet' => '',
                    'mobile' => ''
                ],
                'options' => [
                    '' => esc_html__('Default', 'genzia'),
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '6' => '6',
                ]
            ]
        );
        $this->end_controls_section();
    }
}