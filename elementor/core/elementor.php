<?php
use Elementor\Controls_Manager;
use \Elementor\Icons_Manager;
use \Elementor\Utils;
use \Elementor\Group_Control_Image_Size;

if (!function_exists('genzia_add_hidden_device_controls')) {
    function genzia_add_hidden_device_controls($widget = [], $args = [])
    {
        $args = wp_parse_args($args, [
            'prefix'    => 'cms_',
            'condition' => []
        ]);
        // The 'Hide On X' controls are displayed from largest to smallest, while the method returns smallest to largest.
        $active_devices = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list(['reverse' => true]);
        $active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();

        foreach ($active_devices as $breakpoint_key) {
            $label = 'desktop' === $breakpoint_key ? esc_html__('Desktop', 'genzia') : $active_breakpoints[$breakpoint_key]->get_label();

            $widget->add_control(
                $args['prefix'] . 'hide_' . $breakpoint_key,
                [
                    /* translators: %s: Device name. */
                    'label'     => sprintf(__('Hide On %s', 'genzia'), $label),
                    'type'      => Controls_Manager::SWITCHER,
                    'default'   => '',
                    'label_on'  => esc_html__('Hide', 'genzia'),
                    'label_off' => esc_html__('Show', 'genzia'),
                    'condition' => $args['condition']
                ]
            );
        }
    }
}
if (!function_exists('genzia_add_hidden_device_controls_render')) {
    function genzia_add_hidden_device_controls_render($settings = [], $prefix = '', $args = [])
    {
        $args = wp_parse_args($args, [
            'min-max' => true
        ]);
        $minmax = '';
        if ($args['min-max'] == true)
            $minmax = 'minmax-';
        $active_devices = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list(['reverse' => true]);
        $active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
        $hidden = [];
        foreach ($active_devices as $device) {
            $hidden[] = ($settings[$prefix . 'hide_' . $device] === 'yes') ? 'cms-hidden-' . $minmax . $device : '';
        }
        return implode(' ', array_filter($hidden));
    }
}
// Display Alignment
if (!function_exists('genzia_elementor_reponsive_flex_alignment')) {
    function genzia_elementor_responsive_flex_alignment($widget = [], $args = [])
    {
        $args = wp_parse_args($args, [
            'name' => 'align',
            'condition' => [],
            'label' => esc_html__('Alignment', 'genzia')
        ]);
        return $widget->add_responsive_control(
            $args['name'],
            [
                'label' => $args['label'],
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'genzia'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'genzia'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'genzia'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'between' => [
                        'title' => esc_html__('Between', 'genzia'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'condition' => $args['condition']
            ]
        );
    }
}
// Responsive Class
if (!function_exists('genzia_elementor_get_responsive_class')) {
    function genzia_elementor_get_responsive_class($widget = [], $settings = [], $args = [])
    {
        $args = wp_parse_args($args, [
            'name'         => '',
            'default'      => '',
            'prefix_class' => 'text-',
            'desktop'      => '',
            'widescreen'   => '',
            'laptop'       => '',
            'tablet_extra' => '',
            'tablet'       => '',
            'mobile_extra' => '',
            'mobile'       => '',
            'smobile'      => '',
            //
            'class' => ''
        ]);

        $active_devices = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list(['reverse' => true]);
        $align_class = [];
        if (!empty($settings[$args['name']]) || !empty($args['default'])) {
            $align_class[] = $args['prefix_class'] . $widget->get_setting($args['name'], $args['default']);
        }
        // Align Class
        foreach ($active_devices as $key => $breakpoint_key) {
            $breakpoint_key_class = str_replace('_', '-', $breakpoint_key);

            $setting_breakpoint_key = $widget->get_setting($args['name'] . '_' . $breakpoint_key, $args[$breakpoint_key]);

            if ($breakpoint_key !== 'desktop' && !empty($setting_breakpoint_key)) {
                //$align_class[] = $args['prefix_class'].$breakpoint_key_class.'-'.$settings[$args['name'].'_' . $breakpoint_key];
                $align_class[] = $args['prefix_class'] . $breakpoint_key_class . '-' . $setting_breakpoint_key;
            }
        }
        $align_class[] = $args['class'];
        // remove duplicate value
        $align_class = array_values(array_unique($align_class));

        // return
        return genzia_nice_class($align_class);
    }
}

// Responsive inline CSS 
if (!function_exists('genzia_elementor_responsive_inline_css')) {
    function genzia_elementor_responsive_inline_css($widget = [], $settings = [], $args = [])
    {
        $args = wp_parse_args($args, [
            'name'         => '',
            'default'      => '',
            'prefix_css'   => '--cms-',
            'desktop'      => '',
            'widescreen'   => '',
            'laptop'       => '',
            'tablet_extra' => '',
            'tablet'       => '',
            'mobile_extra' => '',
            'mobile'       => '',
            'smobile'      => ''
        ]);

        $active_devices = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list(['reverse' => true]);
        $align_class = [];
        if (!empty($settings[$args['name']]) || !empty($args['default'])) {
            $align_class[] = $args['prefix_css'] . ':' . $widget->get_setting($args['name'], $args['default']) . 'px';
        }
        // Align Class
        foreach ($active_devices as $key => $breakpoint_key) {
            $breakpoint_key_class = str_replace('_', '-', $breakpoint_key);
            $setting_breakpoint_key = $widget->get_setting($args['name'] . '_' . $breakpoint_key, $args[$breakpoint_key]);
            if ($breakpoint_key !== 'desktop' && !empty($setting_breakpoint_key)) {
                $align_class[] = $args['prefix_css'] . '-' . $breakpoint_key_class . ':' . $setting_breakpoint_key . 'px';
            }
        }
        // remove duplicate value
        $align_class = array_values(array_unique($align_class));

        // return
        return implode(';', $align_class);
    }
}

// Grid Columns
if(!function_exists('genzia_elementor_gap_lists')){
    function genzia_elementor_gap_lists(){
        return [
            ''     => esc_html__('Default', 'genzia'),
            'none' => 0,
            6      => 6,
            8      => 8, 
            10     => 10,
            12     => 12,
            15     => 15,
            20     => 20,
            24     => 24,
            30     => 30,
            32     => 32,
            40     => 40
        ];
    }
}
if (!function_exists('genzia_elementor_grid_columns_settings')) {
    function genzia_elementor_grid_columns_settings($widget, $args = [])
    {
        $args = wp_parse_args($args, [
            'name'      => 'col',
            'label'     => esc_html__('Grid Settings', 'genzia'),
            'tab'       => Controls_Manager::TAB_SETTINGS,
            'divider'   => false,
            'separator' => 'after',
            'condition' => [],
            'group'     => true,
            'gap'       => false,
            'align'     => false
        ]);
        if ($args['group']) {
            $widget->start_controls_section(
                $args['name'] . '_grid_section',
                [
                    'label' => $args['label'],
                    'tab' => $args['tab'],
                    'condition' => $args['condition']
                ]
            );
        }

        $widget->add_responsive_control(
            $args['name'],
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
                    '5' => '5',
                    '6' => '6',
                    'auto' => esc_html__('Auto', 'genzia'),
                ],
                //'separator' => $args['separator']
            ]
        );
        if ($args['gap']) {
            $widget->add_control(
                $args['name'] . '_gap',
                [
                    'label'     => esc_html__('Gap', 'genzia'),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => genzia_elementor_gap_lists(),
                    'default'   => '',
                    'separator' => $args['separator']
                ]
            );
        }
        if($args['align']){
            $widget->add_responsive_control(
                $args['name'] . '_align',
                [
                    'label'   => esc_html__('Column Alignment', 'genzia'),
                    'type'    => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'start' => [
                            'title' => esc_html__('Start', 'genzia'),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', 'genzia'),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'end' => [
                            'title' => esc_html__('End', 'genzia'),
                            'icon'  => 'fa fa-align-right',
                        ],
                    ]
                ]
            );
        }
        if ($args['divider']) {
            $widget->add_control(
                $args['name'] . 'col_separator',
                [
                    'label' => esc_html__('Add separator?', 'genzia'),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes'
                ]
            );
        }
        if ($args['group']) {
            $widget->end_controls_section();
        }
    }
}
if (!function_exists('genzia_elementor_get_grid_columns')) {
    function genzia_elementor_get_grid_columns($widget = [], $settings = [], $args = [])
    {
        $args = wp_parse_args($args, [
            'name'          => 'col',
            'prefix_class'  => 'flex-col-',
            'default'       => '',
            'widescreen'    => '',
            'desktop'       => '',
            'laptop'        => '',
            'tablet_extra'  => '',
            'tablet'        => '',
            'mobile_extra'  => '',
            'mobile'        => '',
            'smobile'       => '1',
            'gap'           => 40,
            'gap_prefix'    => 'gutter-',
            'align'         => 'center',
            'align_default' => ''
        ]);
        $active_devices = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list(['reverse' => true]);
        $align_class = [];
        if($args['align']==true){
            $align_class[] = genzia_elementor_get_responsive_class($widget, $settings, [
                'name'         => $args['name'].'_align',
                'default'      => $args['align_default'],
                'prefix_class' => 'justify-content-'
            ]);
        } else {
            $align_class[] = 'justify-content-'.$args['align'];
        }
        if (!empty($settings[$args['name']]) || !empty($args['default'])) {
            $class = (isset($settings[$args['name']]) && !empty($settings[$args['name']])) ? $settings[$args['name']] : $args['default'];
            $align_class[] = $args['prefix_class'] . $class;
        }
        // Align Class
        foreach ($active_devices as $key => $breakpoint_key) {
            $breakpoint_key_class = str_replace('_', '-', $breakpoint_key);
            $setting_breakpoint_key = (isset($settings[$args['name'] . '_' . $breakpoint_key]) && !empty($settings[$args['name'] . '_' . $breakpoint_key])) ? $settings[$args['name'] . '_' . $breakpoint_key] : $args[$breakpoint_key];

            if ($breakpoint_key !== 'desktop' && !empty($setting_breakpoint_key)) {
                $align_class[] = $args['prefix_class'] . $breakpoint_key_class . '-' . $setting_breakpoint_key;
            }
        }
        $align_class[] = 'flex-col-smobile-' . $args['smobile'];
        $align_class[] = $args['gap_prefix'] . $widget->get_setting($args['name'] . '_gap', $args['gap']);
        // remove duplicate value
        $align_class = array_values(array_unique($align_class));

        // return
        return genzia_nice_class($align_class);
    }
}
if (!function_exists('genzia_elementor_get_masonsry_columns')) {
    function genzia_elementor_get_masonsry_columns($widget = [], $settings = [], $args = [])
    {
        $args = wp_parse_args($args, [
            'name'         => 'col',
            'prefix_class' => '--cms-columns',
            'default'      => '',
            'widescreen'   => '',
            'desktop'      => '',
            'laptop'       => '',
            'tablet_extra' => '',
            'tablet'       => '',
            'mobile_extra' => '',
            'mobile'       => '',
            'smobile'      => '1',
            'gap'          => 40,
            'gap_prefix'   => '--cms-columns-gap'
        ]);
        $active_devices = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list(['reverse' => true]);
        $styles = [];
        if (!empty($settings[$args['name']]) || !empty($args['default'])) {
            $column = (isset($settings[$args['name']]) && !empty($settings[$args['name']])) ? $settings[$args['name']] : $args['default'];
            $styles[] = $args['prefix_class'] . ':' . $column;
        }
        // Align Class
        foreach ($active_devices as $key => $breakpoint_key) {
            $breakpoint_key_class = str_replace('_', '-', $breakpoint_key);
            $setting_breakpoint_key = (isset($settings[$args['name'] . '_' . $breakpoint_key]) && !empty($settings[$args['name'] . '_' . $breakpoint_key])) ? $settings[$args['name'] . '_' . $breakpoint_key] : $args[$breakpoint_key];

            if ($breakpoint_key !== 'desktop' && !empty($setting_breakpoint_key)) {
                $styles[] = $args['prefix_class'] . '-' . $breakpoint_key_class . ':' . $setting_breakpoint_key;
            }
        }
        $styles[] = $args['prefix_class'] . '-smobile:' . $args['smobile'];
        $styles[] = $args['gap_prefix'] . ':' . $widget->get_setting($args['name'] . '_gap', $args['gap']) . 'px';
        // remove duplicate value
        $styles = array_values(array_unique(array_filter($styles)));

        // return
        return implode(';', $styles);
    }
}
// Grid Classes
if (!function_exists('genzia_elementor_get_grid_classes')) {
    function genzia_elementor_get_grid_classes($widget = [], $settings = [], $count = 0, $args = [])
    {
        $args = wp_parse_args($args, [
            'name'         => 'col',
            'prefix_class' => '',
            'suffix_class' => '',
            'default'      => '',
            'widescreen'   => '',
            'desktop'      => '',
            'laptop'       => '',
            'tablet_extra' => '',
            'tablet'       => '',
            'mobile_extra' => '',
            'mobile'       => ''
        ]);

        $active_devices = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list(['reverse' => true]);
        $align_class = [];
        if (!empty($settings[$args['name']]) || !empty($args['default'])) {
            $class = (isset($settings[$args['name']]) && !empty($settings[$args['name']])) ? $settings[$args['name']] : $args['default'];
            if ($count % $class == 0) {
                //$align_class[] = 'item-last';
                //$align_class[] = $args['prefix_class'].$class.$args['suffix_class'];
                $align_class[] = $args['prefix_class'] . $args['suffix_class'];
            }
        }
        // Align Class
        foreach ($active_devices as $key => $breakpoint_key) {
            $breakpoint_key_class = str_replace('_', '-', $breakpoint_key);
            $setting_breakpoint_key = (isset($settings[$args['name'] . '_' . $breakpoint_key]) && !empty($settings[$args['name'] . '_' . $breakpoint_key])) ? $settings[$args['name'] . '_' . $breakpoint_key] : $args[$breakpoint_key];

            if ($breakpoint_key !== 'desktop' && !empty($setting_breakpoint_key)) {
                if ($count % $setting_breakpoint_key == 0) {
                    //$align_class[] = $args['prefix_class'].$breakpoint_key_class.'-'.$setting_breakpoint_key.$args['suffix_class'];
                    //$align_class[] = 'item-'.$breakpoint_key_class.'-last';
                    $align_class[] = $args['prefix_class'] . $breakpoint_key_class . '-' . $args['suffix_class'];
                }
            }
        }
        // remove duplicate value
        $align_class = array_values(array_unique($align_class));
        // return
        return genzia_nice_class($align_class);
    }
}
// Color
function genzia_get_color_store($custom = false, $backdrop = false) {
    static $color_store = null;
    $colors = [
        'accent'    => genzia_configs('accent_color'),
        'primary'   => genzia_configs('primary_color'),
        'heading'   => genzia_configs('heading_color'),
    ];
    $opts = [
        'default' => [
            'id'    => '',
            'label' => __( 'Default', 'genzia' ),
            'group' => 'base',
        ]
    ];
    foreach ($colors as $key => $value) {
        if(is_array($value)){
            foreach ($value as $_key => $_value) {
                $opts[$key.'-'.$_key] = [
                    'id'    => $key.'-'.$_key,
                    'label' =>  ucwords($key.' '.$_key).'('.$_value.')',
                    'group' => 'base'
                ];
            }
        } else {
            $opts[$key] = [
                'id'    => $key,
                'label' => $key.'('.$value.')',
                'group' => 'base'
            ];
        }
    }
    //
    $opts['body']        = [
        'id'    => 'body',
        'label' => esc_html__('Body','genzia'),
        'group' => 'base'
    ];
    $opts['white']       = [
        'id'    => 'white',
        'label' => esc_html__('White','genzia'),
        'group' => 'base'
    ];
    $opts['transparent'] = [
        'id'    => 'transparent',
        'label' => esc_html__('Transparent','genzia'),
        'group' => 'base'
    ];
    // Custom Color
    $custom_color = genzia_configs('custom_color');
    foreach ($custom_color as $c_key => $c_value) {
        if(is_array($value)){
            $opts[$c_key] = [
                'id'    => $c_key,
                'label' => $c_value['title'].' ('.$c_value['value'].')',
                'group' => 'base'
            ];
        } else {
            $opts[$c_key] = [
                'id'    => $c_key,
                'label' => $c_key.' ('.$c_value.')',
                'group' => 'base'
            ];
        }
    }
    // Backdrop
    if($backdrop){
        $opts['backdrop'] = [
            'id'    => 'backdrop',
            'label' => esc_html__('Backdrop','genzia'),
            'group' => 'base'
        ];
    }
    //
    if($custom){
        $opts['custom'] = [
            'id'    => 'custom',
            'label' => esc_html__('Custom','genzia'),
            'group' => 'base'
        ];
    }
    // Custom Color
    $customs = apply_filters('genzia_elementor_theme_custom_colors_store', []);
        
    if ( $color_store === null ) {
        $color_store = array_merge($opts, $customs);
        
        $color_store = apply_filters( 'genzia_color_store', $color_store );
    }
    
    return $color_store;
}
function genzia_get_color_options( $custom = false, $backdrop = false, $color_ids = [], $include_all = false, $extra_colors = [] ) {
    if ( ! empty( $color_ids ) && is_array( $color_ids ) ) {
        $is_associative = array_keys( $color_ids ) !== range( 0, count( $color_ids ) - 1 );
        if ( $is_associative ) {
            $extra_colors = $color_ids;
            $color_ids    = [];
        }
    }

    $store   = genzia_get_color_store($custom, $backdrop);
    $options = [];

    $add_option = static function( $id, $label ) use ( &$options ) {
        $label = is_string( $label ) ? $label : '';
        if ( $label === '' ) {
            return;
        }

        $sanitized_id = ( $id === '' ) ? '' : sanitize_key( $id );
        if ( $sanitized_id === '' && $id !== '' ) {
            return;
        }

        $options[ $sanitized_id ] = $label;
    };

    if ( ! empty( $store ) ) {
        if ( empty( $color_ids ) ) {
            foreach ( $store as $color ) {
                if ( ! isset( $color['id'], $color['label'] ) ) {
                    continue;
                }

                $is_base = isset( $color['group'] ) && $color['group'] === 'base';
                if ( $include_all || $is_base ) {
                    $add_option( $color['id'], $color['label'] );
                }
            }
        } else {
            foreach ( $color_ids as $requested_id ) {
                $search_key = ( $requested_id === '' || $requested_id === 'default' )
                    ? 'default'
                    : sanitize_key( $requested_id );

                if ( $search_key && isset( $store[ $search_key ] ) ) {
                    $color = $store[ $search_key ];
                    if ( isset( $color['id'], $color['label'] ) ) {
                        $add_option( $color['id'], $color['label'] );
                    }
                }
            }
        }
    }

    if ( ! empty( $extra_colors ) && is_array( $extra_colors ) ) {
        foreach ( $extra_colors as $extra_id => $extra_label ) {
            $label = is_string( $extra_label ) ? wp_strip_all_tags( $extra_label ) : '';
            if ( $label === '' ) {
                continue;
            }

            $sanitized_id = sanitize_key( $extra_id );
            if ( $sanitized_id === '' && $extra_id !== '' ) {
                continue;
            }

            $options[ $sanitized_id ] = $label;
        }
    }

    if ( empty( $options ) ) {
        $options['']          = __( 'Default', 'genzia' );
        $options['primary']   = __( 'Primary', 'genzia' );
        $options['secondary'] = __( 'Secondary', 'genzia' );
    }

    return $options;
}
add_filter( 'elementor/editor/localize_settings', function( $settings ) {
    if ( ! isset( $settings['genziaColorStore'] ) ) {
        $settings['genziaColorStore'] = genzia_get_color_store();
    }
    
    if ( ! isset( $settings['genziaColors'] ) ) {
        $settings['genziaColors'] = genzia_get_color_options();
    }
    
    return $settings;
}, 10, 1 );
//
if (!function_exists('genzia_elementor_colors_opts')) {
    function genzia_elementor_colors_opts($widget = [], $args = [])
    {
        $args = wp_parse_args($args, [
            'name'        => '',
            'selectors'   => [],
            'label'       => esc_html__('Color', 'genzia'),
            'description' => '',
            'classes'     => '',
            'separator'   => '',
            'condition'   => [],
            'conditions'  => [],
            'label_block' => false,
            'default'     => '',
            //
            'custom'      => true,
            'backdrop'    => false,
            'extra'       => [
                //'extra-1' => esc_html__('Extra 1', 'genzia')
            ]
        ]);
        $widget->add_control(
            $args['name'],
            [
                'label'       => $args['label'],
                'type'        => Controls_Manager::SELECT,
                'options'     => genzia_get_color_options($args['custom'], $args['backdrop'],$args['extra']),
                'default'     => '',
                'separator'   => $args['separator'],
                'condition'   => $args['condition'],
                'conditions'  => $args['conditions'],
                'description' => $args['description'],
                'classes'     => $args['classes'],
                'label_block' => $args['label_block'],
                'default'     => $args['default']
            ]
        );
        if ($args['custom']) {
            $widget->add_control(
                $args['name'] . '_custom',
                [
                    'label'     => $args['label'] . ' ' . esc_html__('Custom', 'genzia'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => $args['selectors'],
                    'condition' => array_merge(
                        $args['condition'],
                        [
                            $args['name'] => 'custom'
                        ]
                    ),
                    'separator' => 'after'
                ]
            );
        }
    }
}

// Carousel Setting
if (!function_exists('genzia_elementor_carousel_settings')) {
    function genzia_elementor_carousel_settings($widget, $args = [])
    {
        $args = wp_parse_args($args, [
            'label'             => esc_html__('Carousel Settings', 'genzia'),
            'tab'               => Controls_Manager::TAB_SETTINGS,
            'condition'         => [],
            'slides_to_show'    => '',
            'slides_to_scroll'  => '',
            'show_arrows'       => 'yes',
            'show_dots'         => 'yes',
            'loop'              => 'yes',
            'arrows_conditions' => [],
            'dots_conditions'   => []
        ]);
        $widget->start_controls_section(
            'carousel_section',
            [
                'label'     => $args['label'],
                'tab'       => $args['tab'],
                'condition' => $args['condition']
            ]
        );
            $widget->add_control(
                'item_shadow',
                [
                    'label'   => esc_html__('Item Shadow?', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'yes' => esc_html__('Yes', 'genzia'),
                        'no' => esc_html__('No', 'genzia')
                    ],
                    'default' => 'no',
                    'dynamic' => [
                        'active' => true
                    ],
                    'style_transfer' => true,
                    'prefix_class' => 'cms-carousel-item-shadow-',

                ]
            );
            $widget->add_control(
                'content_width',
                [
                    'label'   => esc_html__('Content Width', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''               => esc_html__('Default', 'genzia'),
                        //'start-small'  => esc_html__('Full to Start (Small)', 'genzia'),
                        //'end-small'    => esc_html__('Full to End (Small)', 'genzia'),
                        'start'          => esc_html__('Full to Start', 'genzia'),
                        'end'            => esc_html__('Full to End', 'genzia'),
                        'start-large'  => esc_html__('Full to Start (Large)', 'genzia'),
                        'end-large'    => esc_html__('Full to End (Large)', 'genzia'),
                        'start-mlarge' => esc_html__('Full to Start (Medium Large)', 'genzia'),
                        'end-mlarge'   => esc_html__('Full to End (Medium Large)', 'genzia'),
                        'start-xlarge' => esc_html__('Full to Start (Extra Large)', 'genzia'),
                        'end-xlarge'   => esc_html__('Full to End (Extra Large)', 'genzia'),
                        //'start-2xlarge' => esc_html__('Full to Start (Extra Large #2)', 'genzia'),
                        //'end-2xlarge'   => esc_html__('Full to End (Extra Large #2)', 'genzia'),
                        //'both'         => esc_html__('Full to Both', 'genzia'),
                        //'both2'        => esc_html__('Full to Both #2', 'genzia'),
                        //'both-small'   => esc_html__('Full to Both (Small)', 'genzia'),
                        //'both-large'   => esc_html__('Full to Both (Large)', 'genzia'),
                        //'both-xlarge'  => esc_html__('Full to Both (Extra Large)', 'genzia'),
                        //'both-fit'     => esc_html__('Full to Both (Fit Screen)', 'genzia')
                    ],
                    'default'      => '',
                    'prefix_class' => 'cms-swiper-full-',
                    'separator'    => 'after'
                ]
            );
            $widget->add_control(
                'slide_direction',
                [
                    'label' => esc_html__('Slide Direction', 'genzia'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'false' => esc_html__('Right to Left', 'genzia'),
                        'true' => esc_html__('Left to Right', 'genzia'),
                    ],
                    'default' => 'false',
                    'frontend_available' => true,
                ]
            );
            $slides_to_show = range(1, 10);
            $slides_to_show = array_combine($slides_to_show, $slides_to_show);
            $widget->add_responsive_control(
                'slides_to_show',
                [
                    'label'   => esc_html__('Slides to Show', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''     => esc_html__('Default', 'genzia'),
                        'auto' => esc_html__('Auto', 'genzia'),
                    ] + $slides_to_show,
                    'frontend_available' => true,
                    'default' => $args['slides_to_show']
                ]
            );

            $widget->add_responsive_control(
                'slides_to_scroll',
                [
                    'label'       => esc_html__('Slides to Scroll', 'genzia'),
                    'type'        => Controls_Manager::SELECT,
                    'description' => esc_html__('Set how many slides are scrolled per swipe.', 'genzia'),
                    'options'     => [
                        '' => esc_html__('Default', 'genzia'),
                    ] + $slides_to_show,
                    'default'            => $args['slides_to_scroll'],
                    'frontend_available' => true,
                ]
            );
            $widget->add_responsive_control(
                'space_between',
                [
                    'label' => esc_html__('Space Between', 'genzia'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 200,
                            'min' => 0.001
                        ],
                    ],
                    'default' => [
                        'size' => 40,
                    ],
                    'condition' => [
                        //'slides_to_show!' => '1',
                    ],
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
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
            $widget->add_control(
                'effect_scroll',
                [
                    'label'              => esc_html__('Scroll Effect', 'genzia'),
                    'description'        => esc_html__('When this option is YES, please change \'Autoplay Speed\' to 0, and \'Animation Speed\' to 9000', 'genzia'),
                    'content_classes'    => 'elementor-panel-alert elementor-panel-alert-info',
                    'type'               => Controls_Manager::SWITCHER,
                    'frontend_available' => true,
                    'return_value'       => 'scroll',
                    'prefix_class'       => 'cms-swiper-effect-'
                ]
            );
            // Mousewheel
            $widget->add_control(
                'mousewheel',
                [
                    'label'              => esc_html__('Mousewheel Control', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'no',
                    'frontend_available' => true
                ]
            );
            $widget->add_control(
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
            $widget->add_control(
                'mousewheel_sensitivity',
                [
                    'label' => esc_html__('Mousewheel sensitivity', 'genzia'),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 5,
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
            // Drag Cursor
            $widget->add_control(
                'dragcursor',
                [
                    'label'              => esc_html__('Drag Cursor', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'no',
                    'frontend_available' => true
                ]
            );
            $widget->add_control(
                'dragcursor-style',
                [
                    'label'   => esc_html__('Drag Cursor Style', 'genzia'),
                    'type'    => Controls_Manager::SELECT,
                    'default' => '',
                    'options' => [
                        ''       => esc_html__('Default','genzia'),
                        'black'  => esc_html__('Black', 'genzia'),
                        'white'  => esc_html__('White', 'genzia'),
                        'accent' => esc_html__('Accent', 'genzia')
                    ],
                    'condition' => [
                        'dragcursor' => 'yes'
                    ]
                ]
            );
            //
            $widget->add_control(
                'centeredslide',
                [
                    'label'              => esc_html__('Centered Slide', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
                'lazyload',
                [
                    'label'              => esc_html__('Lazyload', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
                'infinite',
                [
                    'label'              => esc_html__('Infinite Loop', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => $args['loop'],
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
                'autoplay',
                [
                    'label'              => esc_html__('Autoplay', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                ]
            );
            $widget->add_control(
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
            $widget->add_control(
                'pause_on_hover',
                [
                    'label'              => esc_html__('Pause on Hover', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => 'yes',
                    'frontend_available' => true,
                    'condition'          => [
                        'autoplay' => 'yes',
                    ],
                ]
            );
            $widget->add_control(
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
            $widget->add_control(
                'speed',
                [
                    'label'              => esc_html__('Animation Speed', 'genzia'),
                    'type'               => Controls_Manager::NUMBER,
                    'default'            => 500,
                    //'render_type'      => 'none',
                    'frontend_available' => true
                ]
            );
            $widget->add_control(
                'arrows',
                [
                    'label'              => esc_html__('Show Arrows', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => $args['show_arrows'],
                    'frontend_available' => true,
                    'label_block'        => true
                ]
            );
            genzia_elementor_colors_opts($widget, [
                'name'      => 'arrows_color',
                'label'     => esc_html__('Arrows Color', 'genzia'),
                'condition' => array_merge(
                    [
                        'arrows' => 'yes'
                    ],
                    $args['arrows_conditions']
                ),
                'selectors' => [
                    '{{WRAPPER}} .cms-carousel-button' => 'color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($widget, [
                'name'      => 'arrows_bg_color',
                'label'     => esc_html__('Arrows Background Color', 'genzia'),
                'condition' => array_merge(
                    [
                        'arrows' => 'yes'
                    ],
                    $args['arrows_conditions']
                ),
                'selectors' => [
                    '{{WRAPPER}} .cms-carousel-button' => 'background-color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($widget, [
                'name'      => 'arrows_border_color',
                'label'     => esc_html__('Arrows Border Color', 'genzia'),
                'condition' => array_merge(
                    [
                        'arrows' => 'yes'
                    ],
                    $args['arrows_conditions']
                ),
                'selectors' => [
                    '{{WRAPPER}} .cms-carousel-button' => 'border-color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($widget, [
                'name'      => 'arrows_hover_color',
                'label'     => esc_html__('Arrows Hover Color', 'genzia'),
                'condition' => array_merge(
                    [
                        'arrows' => 'yes'
                    ],
                    $args['arrows_conditions']
                ),
                'selectors' => [
                    '{{WRAPPER}} .cms-carousel-button:hover' => 'color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($widget, [
                'name'      => 'arrows_bg_hover_color',
                'label'     => esc_html__('Arrows Background Hover Color', 'genzia'),
                'condition' => array_merge(
                    [
                        'arrows' => 'yes'
                    ],
                    $args['arrows_conditions']
                ),
                'selectors' => [
                    '{{WRAPPER}} .cms-carousel-button:hover' => 'background-color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($widget, [
                'name'      => 'arrows_border_hover_color',
                'label'     => esc_html__('Arrows Border Hover Color', 'genzia'),
                'condition' => array_merge(
                    [
                        'arrows' => 'yes'
                    ],
                    $args['arrows_conditions']
                ),
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .cms-carousel-button:hover' => 'border-color:{{VALUE}};'
                ]
            ]);
            genzia_add_hidden_device_controls($widget, [
                'prefix'    => 'arrows_',
                'condition' => [
                    'arrows' => 'yes'
                ]
            ]);
            // Dots
            $widget->add_control(
                'dots',
                [
                    'label'              => esc_html__('Show Dots', 'genzia'),
                    'type'               => Controls_Manager::SWITCHER,
                    'default'            => $args['show_dots'],
                    'frontend_available' => true,
                    'label_block'        => true
                ]
            );
            genzia_elementor_colors_opts($widget, [
                'name'      => 'dots_color',
                'label'     => esc_html__('Dot Color', 'genzia'),
                'condition' => array_merge(
                    [
                        'dots' => 'yes'
                    ],
                    $args['dots_conditions']
                ),
                'backdrop' => true,
                'selectors'=>[
                    '{{WRAPPER}} .cms-carousel-dots' => '--cms-dots-color:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($widget, [
                'name'      => 'dots_active_color',
                'label'     => esc_html__('Dot Hover/Active Color', 'genzia'),
                'condition' => [
                    'dots' => 'yes'
                ],
                'backdrop'  => true,
                'separator' => 'after',
                'selectors'=>[
                    '{{WRAPPER}} .cms-carousel-dots' => '--cms-dots-hover-color:{{VALUE}};--cms-dots-hover-shadow:{{VALUE}};'
                ]
            ]);
            genzia_add_hidden_device_controls($widget, [
                'prefix'    => 'dots_',
                'condition' => array_merge(
                    [
                        'dots' => 'yes'
                    ],
                    $args['dots_conditions']
                )
            ]);
        $widget->end_controls_section();
    }
}
if(!function_exists('genzia_swiper_wrapper_class')){
    function genzia_swiper_wrapper_class($widget = [], $args=[]){
        $args = wp_parse_args($args, [
            'class'        => '',
            'cursor-style' => 'accent'
        ]);
        echo implode(' ',array_filter([
            'swiper-wrapper',
            ($widget->get_setting('dragcursor') == 'yes') ? 'drag-cursor cms-cursor-drag-'.$widget->get_setting('dragcursor-style', $args['cursor-style']) : '',
            ($widget->get_setting('slides_to_show') == 'auto') ? 'cms-swiper-wrapper-'.$widget->get_setting('slides_to_show') : '',
            $args['class']
        ]));
    }
}
// Filter Settings
if (!function_exists('genzia_elementor_filter_settings')) {
    function genzia_elementor_filter_settings($widget = [])
    {
        $widget->add_control(
            'filter',
            [
                'label'        => esc_html__('Enable Filter', 'genzia'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'false',
                'return_value' => 'true'
            ]
        );
        $widget->add_control(
            'filter_default_title',
            [
                'label'     => esc_html__('Filter Default Title', 'genzia'),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__('All', 'genzia'),
                'condition' => [
                    'filter' => 'true',
                ],
            ]
        );
        $widget->add_control(
            'filter_alignment',
            [
                'label'   => esc_html__('Filter Alignment', 'genzia'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'center' => esc_html__('Center', 'genzia'),
                    'start'  => esc_html__('Start', 'genzia'),
                    'end'    => esc_html__('End', 'genzia'),
                ],
                'default'   => 'center',
                'condition' => [
                    'filter' => 'true',
                ],
            ]
        );
        $widget->add_control(
            'filter_layout',
            [
                'label'   => esc_html__('Filter Layout', 'genzia'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''  => esc_html__('Default', 'genzia'),
                    '1' => esc_html__('Layout 1', 'genzia')
                ],
                'default'   => '',
                'condition' => [
                    'filter' => 'true',
                ],
            ]
        );
    }
}
// Filter Render 
if (!function_exists('genzia_elementor_filter_render')) {
    function genzia_elementor_filter_render($widget = [], $settings = [], $args = [])
    {
        $args = wp_parse_args($args, [
            'layout'     => 1,
            'categories' => '',
            'class'      => 'mb-32 text-btn font-500',
            'gap'        => 32,
            'title'      => esc_html__('All', 'genzia'),
            'alignment'  => 'center',
            //
            'color'        => 'menu',
            'color_hover'  => 'accent-regular',
            'color_active' => 'accent-regular',
            //
            'bg_color'        => 'transparent',
            'bg_color_hover'  => 'accent-regular',
            'bg_color_active' => 'accent-regular',
            //
            'border_color'        => 'divider',
            'border_color_hover'  => 'accent-regular',
            'border_color_active' => 'accent-regular',
            //
            'item_class' => 'cms-hover-underline cms-active-underline',
            // icon
            'icon'  => ''
        ]);
        $filter               = $widget->get_setting('filter', 'false');
        $filter_default_title = $widget->get_setting('filter_default_title', $args['title']);
        $filter_alignment     = $widget->get_setting('filter_alignment', $args['alignment']);
        //
        $filter_color        = $args['color'];
        $filter_color_hover  = $args['color_hover'];
        $filter_color_active = $args['color_active'];
        //
        $filter_bg_color        = $args['bg_color'];
        $filter_bg_color_hover  = $args['bg_color_hover'];
        $filter_bg_color_active = $args['bg_color_active'];
        //
        $filter_border_color        = $args['border_color'];
        $filter_border_color_hover  = $args['border_color_hover'];
        $filter_border_color_active = $args['border_color_active'];

        // item attribute
        $widget->add_render_attribute('filter', [
            'class' => [
                'grid-filter-wrap',
                'grid-filter-'.$args['layout'],
                'd-flex justify-content-' . $filter_alignment,
                'gap-' . $args['gap'],
                $args['class']
            ],
            'style' => [
                '--cms-filter-color:var(--cms-' . $filter_color . ');',
                '--cms-filter-color-hover:var(--cms-' . $filter_color_hover . ');',
                '--cms-filter-color-active:var(--cms-' . $filter_color_active . ');',
                //
                '--cms-filter-bg-color:var(--cms-' . $filter_bg_color . ');',
                '--cms-filter-bg-color-hover:var(--cms-' . $filter_bg_color_hover . ');',
                '--cms-filter-bg-color-active:var(--cms-' . $filter_bg_color_active . ');',
                //
                '--cms-filter-bdr-color:var(--cms-' . $filter_border_color . ');',
                '--cms-filter-bdr-color-hover:var(--cms-' . $filter_border_color_hover . ');',
                '--cms-filter-bdr-color-active:var(--cms-' . $filter_border_color_active . ');',
            ]
        ]);
        $widget->add_render_attribute('filter-item', [
            'class'       => 'active filter-item ' . $args['item_class'],
            'data-filter' => '*'
        ]);
        if ($filter == "true"): ?>
        <div <?php ctc_print_html($widget->get_render_attribute_string('filter')); ?>>
            <div <?php ctc_print_html($widget->get_render_attribute_string('filter-item')); ?>>
                <?php
                    echo esc_html($filter_default_title).$args['icon'];
                ?>
            </div>
            <?php foreach ($args['categories'] as $key => $category):
                $category_arr = explode('|', $category);
                $tax[] = $category_arr[1];
                $term = get_term_by('slug', $category_arr[0], $category_arr[1]);

                $item_key = $widget->get_repeater_setting_key('item', 'filter', $key);
                $widget->add_render_attribute($item_key, [
                    'class'       => 'filter-item ' . $args['item_class'],
                    'data-filter' => $category
                ]);
                ?>
                    <div <?php ctc_print_html($widget->get_render_attribute_string($item_key)); ?>>
                        <?php echo esc_html($term->name).$args['icon']; ?>
                    </div>
            <?php endforeach; ?>
        </div>
        <?php endif;
    }
}
/**
 * Elementor Circle Text Settings
 * 
 * */
function genzia_elementor_circle_text_settings($widget = [], $args = [])
{
    $args = wp_parse_args($args, [
        // Group
        'label'     => esc_html__('Circle Text Settings', 'genzia'),
        'tab'       => Controls_Manager::TAB_CONTENT,
        'condition' => [],
        'group'     => true,
        'skin'      => 'inline',
        //
        'prefix' => '',
        'name'   => 'circle',
        'type'   => 'icon',
        // icon
        'icon_label'   => __('Choose Icon', 'genzia'),
        'icon_default' => [
            'library' => 'svg',
            'value' => [
                'url' => get_template_directory() . '/assets/svgs/core/star.svg'
            ]
        ],
        // image
        'img_label'        => __('Choose Image', 'genzia'),
        'img_default'      => [],
        'img_size'         => false,
        'img_default_size' => 'custom',
        // Link
        'link'      => false,
        'link_type' => [],
        //
        'separator' => '',
        'classes'   => ''
    ]);
    if ($args['group']) {
        $widget->start_controls_section(
            $args['prefix'] . 'icon_img_section',
            [
                'label'     => $args['label'],
                'tab'       => $args['tab'],
                'condition' => $args['condition']
            ]
        );
    }
    $widget->add_control(
        $args['prefix'] . $args['name'] . '_text',
        [
            'label'     => esc_html__('Circle Text', 'genzia'),
            'type'      => Controls_Manager::TEXTAREA,
            'separator' => $args['separator'],
            'classes'   => $args['classes'],
            'condition' => $args['condition'],
            'default'   => 'Your Text Here'
        ]
    );
    $widget->add_control(
        $args['prefix'] . $args['name'] . '_type',
        [
            'label'   => esc_html__('Icon Type', 'genzia'),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'icon'  => esc_html__('Icon', 'genzia'),
                'image' => esc_html__('Image', 'genzia'),
                ''      => esc_html__('None', 'genzia'),
            ],
            'default'   => $args['type'],
            'condition' => array_merge(
                $args['condition'],
                [
                    $args['prefix'] . $args['name'] . '_text!' => '',
                ]
            )
        ]
    );
    $widget->add_control(
        $args['prefix'] . $args['name'] . '_icon',
        [
            'label'       => $args['icon_label'],
            'type'        => Controls_Manager::ICONS,
            'default'     => $args['icon_default'],
            'skin'        => $args['skin'],
            'label_block' => false,
            'condition'   => array_merge(
                $args['condition'],
                [
                    $args['prefix'] . $args['name'] . '_text!' => '',
                    $args['prefix'] . $args['name'] . '_type' => 'icon'
                ]
            )
        ]
    );
    $widget->add_control(
        $args['prefix'] . $args['name'] . '_image',
        [
            'label'   => $args['img_label'],
            'type'    => Controls_Manager::MEDIA,
            'default' => [
                'url' => Utils::get_placeholder_image_src()
            ],
            'skin'        => $args['skin'],
            'label_block' => false,
            'condition'   => array_merge(
                $args['condition'],
                [
                    $args['prefix'] . $args['name'] . '_type' => 'image'
                ]
            )
        ]
    );
    if ($args['link']) {
        $link_type = array_merge(
            $args['link_type'],
            [
                'page' => esc_html__('Page', 'genzia'),
                'custom' => esc_html__('Custom', 'genzia')
            ]
        );
        $widget->add_control(
            $args['prefix'] . $args['name'] . 'link_type',
            [
                'label'     => esc_html__('Link Type', 'genzia'),
                'type'      => Controls_Manager::SELECT,
                'options'   => $link_type,
                'default'   => 'custom',
                'condition' => array_merge(
                    $args['condition'],
                    [
                        $args['prefix'] . $args['name'] . '_text!' => ''
                    ]
                )
            ]
        );
        unset($link_type['custom']); // remove custom
        foreach ($link_type as $key => $value) {
            $widget->add_control(
                $args['prefix'] . $args['name'] . $key,
                [
                    'label'        => sprintf('%1$s %2$s', esc_html__('Select', 'genzia'), $value),
                    'type'         => CSH_Theme_Core::POSTS_CONTROL,
                    'return_value' => 'ID',
                    'multiple'     => false,
                    'post_type'    => [
                        $key
                    ],
                    'condition' => array_merge(
                        $args['condition'],
                        [
                            $args['prefix'] . $args['name'] . '_text!' => '',
                            $args['prefix'] . $args['name'] . 'link_type' => $key
                        ]
                    ),
                    'label_block' => false
                ]
            );
        }
        $widget->add_control(
            $args['prefix'] . $args['name'] . 'link_custom',
            [
                'label'       => esc_html__('Custom Link', 'genzia'),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'genzia'),
                'default'     => [
                    'url' => '#',
                ],
                'condition' => [
                    $args['prefix'] . $args['name'] . 'link_type' => 'custom'
                ],
                'label_block' => false
            ]
        );
    }
    if ($args['group']) {
        $widget->end_controls_section();
    }
}
// Render circle text 
if (!function_exists('genzia_circle_text')) {
    function genzia_circle_text($widget = [], $settings = [], $args = [])
    {
        $args = wp_parse_args($args, [
            'class'          => '',
            'dimensions'     => 120,
            'background'     => 'white',
            'color'          => 'primary',
            'color_end'      => 'accent',
            'text'           => '',
            'text_size'      => 20,
            'letter_spacing' => 2,
            'echo'           => true,
            'before'         => '',
            'after'          => '',
            'wrap_before'    => '',
            'wrap_after'     => '',
            // 
            'svg_class' => 'cms-spin',
            // icon
            'icon'       => true,
            'prefix'     => '',
            'name'       => 'circle',
            'icon_class' => '',
            'icon_size'  => 48,
            'icon_color' => '',
            // link
            'link'          => false,
            'link_class'    => '',
            'link_loop'     => false,
            'link_loop_key' => '',
            //
            'position' => 'relative',
            'style'    => '',
            //
            'circle_type' => '',
            'clippath_id' => 'cms-criclePath'
        ]);

        $text = !empty($args['text']) ? $args['text'] : $settings[$args['prefix'] . $args['name'] . '_text'];
        $background = $args['background'];
        $color = $args['color'];
        $dimensions = $args['dimensions'];

        $classes = ['cms-circle-text circle', $args['position'], 'bg-' . $background, 'text-' . $args['color'], $args['class']];

        ob_start();
        // Wrap Before 
        printf('%s', $args['wrap_before']);
        ?>
            <div class="<?php echo genzia_nice_class($classes); ?>" style="width:<?php echo esc_attr($dimensions); ?>px; height: <?php echo esc_attr($dimensions); ?>px; font-size:<?php echo esc_attr($args['text_size']); ?>px;letter-spacing: <?php echo esc_attr($args['letter_spacing']); ?>px;<?php echo esc_attr($args['style']); ?>">
                <?php
                // Before 
                printf('%s', $args['before']);
                // Icon
                if ($args['icon']) {
                    genzia_elementor_icon_image_render($widget, $settings, [
                        'prefix' => $args['prefix'],
                        'name' => $args['name'],
                        'size' => $args['icon_size'],
                        'color' => $args['icon_color'],
                        'color_hover' => $args['icon_color'],
                        // icon
                        'icon_tag' => 'div',
                        'class' => $args['icon_class'] . ' absolute center z-top',
                        'attrs' => []
                    ]);
                }
                ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300" xml:space="preserve" class="<?php echo esc_attr($args['svg_class']); ?>" style="letter-spacing: <?php echo esc_attr($args['letter_spacing'] . 'px'); ?>;--cms-color-start:var(--cms-<?php echo esc_attr($args['color']); ?>);--cms-color-end:var(--cms-<?php echo esc_attr($args['color_end']); ?>);">
                    <defs>
                        <path id="<?php echo esc_attr($args['clippath_id']); ?>" d="M 150, 150 m -120, 0 a 120,120 0 0,1 240,0 a 120,120 0 0,1 -240,0"/>
                    </defs>
                    <text>
                        <textPath href="#<?php echo esc_attr($args['clippath_id']); ?>"><?php echo esc_html($text); ?></textPath>
                    </text>
                </svg>
                <?php
                // After
                printf('%s', $args['after']);
                // Link
                if ($args['link']) {
                    $link_type = $settings[$args['prefix'] . $args['name'] . 'link_type'];
                    $page_ID = $settings[$args['prefix'] . $args['name'] . $link_type];
                    switch ($link_type) {
                        case 'custom':
                            $url = $settings[$args['prefix'] . $args['name'] . 'link_custom']['url'];
                            break;
                        default:
                            $url = !empty($page_ID) ? get_permalink($page_ID) : '#';
                            break;
                    }
                    $link_loop_key = $widget->get_repeater_setting_key($args['prefix'] . $args['name'] . 'key', $args['prefix'] . $args['name'] . 'key', $args['prefix'] . $args['name'] . $args['link_loop_key']);
                    $link_attrs_key = $args['link_loop'] ? $link_loop_key : $args['prefix'] . $args['name'] . '_attr_key';

                    $widget->add_render_attribute($link_attrs_key, [
                        'class' => $args['link_class'],
                        'href' => $url,
                        'data-title' => $text
                    ]);
                    ?>
                        <a <?php ctc_print_html($widget->get_render_attribute_string($link_attrs_key)); ?>><span class="screen-reader-text"><?php echo esc_html($text); ?></span></a>
                <?php } ?>
            </div>
            <?php
            // Wrap After
            printf('%s', $args['wrap_after']);
            //
            if ($args['echo']) {
                echo ob_get_clean();
            } else {
                return ob_get_clean();
            }
    }
}
// Elementor default Icon
if (!function_exists('genzia_elementor_icon_default')) {
    function genzia_elementor_icon_default($icon = ['value' => '', 'library' => ''], $default = ['value' => '', 'library'])
    {
        if (empty($icon['value']))
            $icon = $default;
        return $icon;
    }
}
if (!function_exists('genzia_elementor_icon_render')) {
    function genzia_elementor_icon_render($icon = [], $default = ['value' => '', 'library' => ''], $args = [], $tag = 'span')
    {
        if (empty($icon['library']))
            $icon = $default;
        if (empty($icon['library']))
            return;
        $args = wp_parse_args($args, [
            'icon_size'        => '',
            'icon_color'       => '',
            'icon_color_hover' => '',
            'icon_class'       => 'cms-eicon',
            'class'            => '',
            'echo'             => true,
            'before'           => '',
            'after'            => '',
            'content'          => '',
            'style'            => [],
            'attrs'            => []
        ]);
        $args['class'] = is_string($args['class']) ? explode(' ', $args['class']) : $args['class'];
        $classes = array_unique(array_filter(array_merge(
            [
                'cms-svg-icon',
                $args['icon_class'],
                !empty($args['icon_size']) ? 'text-' . $args['icon_size'] : '',
                'text-' . $args['icon_color'],
                'text-hover-' . $args['icon_color_hover'],
                'lh-0'
            ],
            $args['class']
        )));
        $attrs = $args['attrs'];
        $attrs['class'] = $classes;
        $args['style'] = (array) $args['style'];
        $args['style'][] = '--svg-size:' . $args['icon_size'] . 'px';
        $args['style'][] = '--cms-start-color:var(--cms-' . $args['icon_color'] . ')';
        $args['style'][] = '--cms-end-color:var(--cms-' . $args['icon_color_hover'] . ')';
        if (isset($args['attrs']['style']))
            $args['style'][] = $args['attrs']['style'];
        $attrs['style'] = implode(';', $args['style']);
        //
        ob_start();
            printf('%s', $args['before']);
            ?>
            <<?php ctc_print_html($tag . ' ' . \Elementor\Utils::render_html_attributes($attrs)); ?>><?php
                  if (isset($icon['library']) && $icon['library'] === 'svg' && (!isset($icon['value']['id']) || empty($icon['value']['id'])) && !empty($icon['value']['url'])) {
                      include $icon['value']['url'];
                  } else {
                      Icons_Manager::render_icon($icon, [], $tag);
                  }
                  printf('%s', $args['content']);
            ?></<?php ctc_print_html($tag) ?>>   
            <?php
            printf('%s', $args['after']);
        //
        if ($args['echo']) {
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
// Icon & Image Settings 
if (!function_exists('genzia_elementor_icon_image_settings')) {
    function genzia_elementor_icon_image_settings($widget, $args = [])
    {
        $args = wp_parse_args($args, [
            // Group
            'label'               => esc_html__('Icon/Image Settings', 'genzia'),
            'tab'                 => Controls_Manager::TAB_CONTENT,
            'condition'           => [],
            'conditions'          => [],
            'group'               => true,
            'color'               => true,
            'default_color'       => '',
            'default_color_hover' => '',
            'skin'                => 'inline',
            //
            'prefix' => '',
            'name'   => 'icon_img',
            'type'   => 'icon',
            //
            'label_type' => esc_html__('Icon Type', 'genzia'),
            // icon
            'icon_label'   => __('Choose Icon', 'genzia'),
            'icon_default' => [
                'library' => 'fa-solid',
                'value'   => 'fas fa-star'
            ],
            // image
            'img_label'        => __('Choose Image', 'genzia'),
            'img_default'      => [],
            'img_size'         => false,
            'img_default_size' => 'custom',
            //
            'separator' => '',
            'classes'   => ''
        ]);
        if (!empty($args['conditions'])) {
            $condition_tag = 'conditions';
            $condition_value = $args['conditions'];
            $condition_relation_icon = array_merge(
                [
                    $args['prefix'] . $args['name'] . '_type' => 'icon'
                ],
                $args['conditions']
            );
            $condition_relation_img = array_merge(
                [
                    $args['prefix'] . $args['name'] . '_type' => 'image',
                ],
                $args['conditions']
            );
            $condition_relation_img_size = array_merge(
                [
                    $args['prefix'] . $args['name'] . '_type' => 'image',
                    $args['prefix'] . $args['name'] . '_image[url]!' => '',
                ],
                $args['conditions']
            );
        } else {
            $condition_tag = 'condition';
            $condition_value = $args['condition'];
            $condition_relation_icon = array_merge(
                [
                    $args['prefix'] . $args['name'] . '_type' => 'icon'
                ],
                $args['condition']
            );
            $condition_relation_img = array_merge(
                [
                    $args['prefix'] . $args['name'] . '_type' => 'image',
                ],
                $args['condition']
            );
            $condition_relation_img_size = array_merge(
                [
                    $args['prefix'] . $args['name'] . '_type' => 'image',
                    $args['prefix'] . $args['name'] . '_image[url]!' => '',
                ],
                $args['condition']
            );
        }
        if ($args['group']) {
            $widget->start_controls_section(
                $args['prefix'] . 'icon_img_section',
                [
                    'label' => $args['label'],
                    'tab' => $args['tab'],
                    $condition_tag => $condition_value
                ]
            );
        }
        $widget->add_control(
            $args['prefix'] . $args['name'] . '_type',
            [
                'label'   => $args['label_type'],
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'icon'  => esc_html__('Icon', 'genzia'),
                    'image' => esc_html__('Image', 'genzia'),
                    ''      => esc_html__('None', 'genzia'),
                ],
                'default'      => $args['type'],
                $condition_tag => $condition_value,
                'separator'    => $args['separator'],
                'classes'      => $args['classes']
            ]
        );
        $widget->add_control(
            $args['prefix'] . $args['name'] . '_icon',
            [
                'label'        => $args['icon_label'],
                'type'         => Controls_Manager::ICONS,
                $condition_tag => $condition_relation_icon,
                'default'      => $args['icon_default'],
                'skin'         => $args['skin'],
                'label_block'  => false
            ]
        );
        $widget->add_control(
            $args['prefix'] . $args['name'] . '_image',
            [
                'label'        => $args['img_label'],
                'type'         => Controls_Manager::MEDIA,
                $condition_tag => $condition_relation_img,
                'default'      => [
                    'url' => Utils::get_placeholder_image_src()
                ],
                'skin'        => $args['skin'],
                'label_block' => false
            ]
        );
        if ($args['color']) {
            genzia_elementor_colors_opts($widget, [
                'name'      => $args['prefix'] . $args['name'] . '_color',
                'selectors' => [
                    '{{WRAPPER}} .cms-icon-'.$args['prefix'] . $args['name'] => 'color:{{VALUE}};'
                ],
                'condition' => $condition_relation_icon,
                'default'   => $args['default_color']
            ]);
            genzia_elementor_colors_opts($widget, [
                'name'      => $args['prefix'] . $args['name'] . '_color_hover',
                'label'     => esc_html__('Hover Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .cms-icon-'.$args['prefix'] . $args['name'].':hover' => 'color:{{VALUE}};'
                ],
                'condition' => $condition_relation_icon,
                'default'   => $args['default_color_hover']
            ]);
        }
        if ($args['group']) {
            $widget->end_controls_section();
        }
    }
}
// Icon & Image Render
if (!function_exists('genzia_elementor_icon_image_render')) {
    function genzia_elementor_icon_image_render($widget = [], $settings = [], $args = [], $data = [])
    {
        $args = wp_parse_args($args, [
            'prefix'      => '',
            'name'        => 'icon_img',
            'size'        => 64,
            'size_tablet' => '',
            'size_mobile' => '',
            'color'       => 'accent',
            'color_hover' => 'accent',
            // icon
            'icon_tag'   => 'div',
            'icon_class' => 'cms-eicon',
            // image
            'img_size'        => 'custom',
            'img_custom_size' => [],
            // default
            'class'  => '',
            'before' => '',
            'after'  => '',
            //
            'attrs' => [],
            //
            'echo' => true
        ]);
        if (!empty($data)) {
            $settings = $data;
        }
        $icon_type = $settings[$args['prefix'].$args['name'].'_type'];
        $img_size = !empty($args['img_custom_size']) ? $args['img_custom_size'] : ['width' => $args['size'], 'height' => $args['size']];
        // Render Icon / Image
        switch ($icon_type) {
            case 'image':
                genzia_elementor_image_render($settings, [
                    'name'           => $args['prefix'] . $args['name'] . '_image',
                    'size'           => $args['img_size'],
                    'image_size_key' => '',
                    'custom_size'    => ['width' => $img_size['width'], 'height' => $img_size['height']],
                    'img_class'      => genzia_nice_class($args['class']) . ' cms-eicon',
                    'before'         => $args['before'],
                    'after'          => $args['after'],
                    'attrs'          => $args['attrs'],
                    'echo'           => $args['echo']
                ]);
                break;
            case 'icon':
                genzia_elementor_icon_render($settings[$args['prefix'] . $args['name'] . '_icon'], [], [
                    'aria-hidden'      => 'true',
                    'class'            => 'cms-icon-'.$args['prefix'] . $args['name'].' '.$args['class'],
                    'icon_size'        => $args['size'],
                    'icon_size_tablet' => $args['size_tablet'],
                    'icon_size_mobile' => $args['size_mobile'],
                    'icon_color'       => $widget->get_setting($args['prefix'] . $args['name'] . '_color', $args['color']),
                    'icon_color_hover' => $widget->get_setting($args['prefix'] . $args['name'] . '_color_hover', $args['color_hover']),
                    'icon_class'       => $args['icon_class'],
                    'before'           => $args['before'],
                    'after'            => $args['after'],
                    'attrs'            => $args['attrs'],
                    'echo'             => $args['echo']
                ], $args['icon_tag']);
                break;
        }
    }
}
/**
 * Link Settings
 * 
 * */
function genzia_elementor_link_settings($widget, $args = [])
{
    $args = wp_parse_args($args, [
        'name'  => 'link_',
        'type'  => [],
        'mode'  => '', // value: 'text','btn' //get output html as text or button,
        'color' => true,
        'text'  => '',
        //
        'group' => false,
        'label' => esc_html__('Link Settings', 'genzia'),
        // Color
        'color_label' => esc_html__('Text', 'genzia'),
        // Icon
        'icon_settings' => [
            'enable' => false,
            'selector' => '.cms-btn-icon'
        ],
        //
        'tab'       => Controls_Manager::TAB_CONTENT,
        'condition' => []
    ]);
    $label_classes = $args['group'] ? '' : 'cms-description-as-label';
    $description = $args['group'] ? '' : $args['label'];
    
    if ($args['group']) {
        $widget->start_controls_section(
            $args['name'] . 'section',
            [
                'label'     => $args['label'],
                'tab'       => $args['tab'],
                'condition' => $args['condition']
            ]
        );
    }
    $widget->add_control(
        $args['name'] . 'text',
        [
            'label'       => esc_html__('Link Text', 'genzia'),
            'type'        => Controls_Manager::TEXT,
            'description' => $description,
            'classes'     => $label_classes,
            'condition'   => $args['condition'],
            'default'     => $args['text']
        ]
    );
    $widget->add_control(
        $args['name'] . 'url',
        [
            'label'       => esc_html__('Your Link', 'genzia'),
            'type'        => Controls_Manager::URL,
            'placeholder' => esc_html__('https://your-link.com', 'genzia'),
            'default'     => [
                'url' => '#',
            ],
            'condition' => array_merge(
                [
                    $args['name'] . 'text!' => ''
                ],
                $args['condition']
            ),
            'label_block' => false
        ]
    );
    if ($args['color']) {
        genzia_elementor_colors_opts($widget, [
            'name'      => $args['name'] .'text_color',
            'label'     => esc_html__('Text Color', 'genzia'),
            'selectors' => [
                '{{WRAPPER}} .'.$args['name'].'text' => 'color: {{VALUE}};'
            ],
            'condition' => array_merge(
                [
                    $args['name'] . 'text!' => '',
                ],
                $args['condition']
            )
        ]);
        if ($args['mode'] == 'btn') {
            genzia_elementor_colors_opts($widget, [
                'name'      => $args['name'] .'btn_color',
                'label'     => esc_html__('Button Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .'.$args['name'].'bg' => 'background-color: {{VALUE}};'
                ],
                'condition' => array_merge(
                    [
                        $args['name'] . 'text!' => '',
                    ],
                    $args['condition']
                )
            ]);
        }
        genzia_elementor_colors_opts($widget, [
            'name'      => $args['name'] .'text_color_hover',
            'label'     => esc_html__('Text Color Hover', 'genzia'),
            'selectors' => [
                '{{WRAPPER}} .'.$args['name'].'text:hover' => 'color: {{VALUE}};'
            ],
            'condition' => array_merge(
                [
                    $args['name'] . 'text!' => '',
                ],
                $args['condition']
            )
        ]);
        if ($args['mode'] == 'btn') {
            genzia_elementor_colors_opts($widget, [
                'name'      => $args['name'] .'btn_color_hover',
                'label'     => esc_html__('Button Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} .'.$args['name'].'bg:hover' => 'background-color: {{VALUE}};'
                ],
                'condition' => array_merge(
                    [
                        $args['name'] . 'text!' => '',
                    ],
                    $args['condition']
                )
            ]);
        }
        if($args['icon_settings']['enable']){
            genzia_elementor_colors_opts($widget, [
                'name'      => $args['name'].'_icon_bg',
                'label'     => esc_html__('Icon Background Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} '.$args['icon_settings']['selector'] => '--cms-bg-custom:{{VALUE}};'
                ],
                'separator' => 'before',
                'classes'   => 'cms-eseparator'
            ]);
            genzia_elementor_colors_opts($widget, [
                'name'      => $args['name'].'_icon_color',
                'label'     => esc_html__('Button Icon Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} '.$args['icon_settings']['selector'] => '--cms-text-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($widget, [
                'name'      => $args['name'].'_icon_bg_hover',
                'label'     => esc_html__('Icon Background Hover Color', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} '.$args['icon_settings']['selector'] => '--cms-bg-hover-custom:{{VALUE}};--cms-bg-on-hover-custom:{{VALUE}};'
                ]
            ]);
            genzia_elementor_colors_opts($widget, [
                'name'      => $args['name'].'_icon_color_hover',
                'label'     => esc_html__('Icon Color Hover', 'genzia'),
                'selectors' => [
                    '{{WRAPPER}} '.$args['icon_settings']['selector'] => '--cms-text-hover-custom:{{VALUE}};--cms-text-on-hover-custom:{{VALUE}};'
                ]
            ]);
        }
    }
    if ($args['group']) {
        $widget->end_controls_section();
    }
}
// Link Render
function genzia_elementor_link_render($widget = [], $settings = [], $args = [])
{
    $args = wp_parse_args($args, [
        'name'             => 'link_',
        'mode'             => '',
        'color'            => true,
        'btn_prefix'       => 'btn-',
        'btn_hover_prefix' => 'btn-hover-',
        'btn_color'        => 'primary-regular',
        'btn_color_hover'  => 'accent-regular',
        'text_color'       => '',
        'text_color_hover' => '',
        // default
        'class'       => '',
        'before'      => '',
        'after'       => '',
        'echo'        => true,
        'text'        => '',
        'text_icon'   => '',
        'before_text' => '',
        'after_text'  => '',
        // Icon
        'icon_settings' => [
            'class'            => '',
            'bg_color'         => '',
            'bg_color_hover'   => '',
            'text_color'       => '',
            'text_color_hover' => ''
        ],
        // Loop
        'loop'     => false,
        'loop_key' => '',
        'attrs'    => []
    ]);
    if (!empty($data)) {
        $settings = $data;
    }
    if (empty($settings[$args['name'] . 'text']))
        return;
    $text = !empty($args['text']) ? $args['text'] : $settings[$args['name'] . 'text'];

    $loop_key = $widget->get_repeater_setting_key($args['name'] . 'key', $args['name'] . 'key', $args['name'] . $args['loop_key']);
    $attrs_key = $args['loop'] ? $loop_key : $args['name'] . '_attr_key';
    $attrs = [
        'class' => $args['class']
    ] + (array) $args['attrs'];
    $widget->add_render_attribute($attrs_key, $attrs);
    $widget->add_link_attributes( $attrs_key, $settings[$args['name'].'url']);

    if ($args['color']) {
        switch ($args['mode']) {
            case 'btn':
                $widget->add_render_attribute($attrs_key, [
                    'class' => [
                        'cms-btn',
                        $args['btn_prefix'].$widget->get_setting($args['name'] .'btn_color', $args['btn_color']),
                        'text-' . $widget->get_setting($args['name'] .'text_color', $args['text_color']),
                        $args['btn_hover_prefix'] . $widget->get_setting($args['name'] .'btn_color_hover', $args['btn_color_hover']),
                        'text-hover-' . $widget->get_setting($args['name'] .'text_color_hover', $args['text_color_hover']),
                        $args['name'].'text',
                        $args['name'].'bg'
                    ]
                ]);
                break;
            default:
                $widget->add_render_attribute($attrs_key, [
                    'class' => [
                        'text-' . $widget->get_setting($args['name'] .'text_color', $args['text_color']),
                        'text-hover-'.$widget->get_setting($args['name'] .'text_color_hover', $args['text_color_hover']),
                        $args['name'].'text'
                    ]
                ]);
                break;
        }
    }
    // render
    ob_start();
    printf('%s', $args['before']);
    ?>
        <a <?php ctc_print_html($widget->get_render_attribute_string($attrs_key)); ?>><?php ctc_print_html($args['before_text'] . $text . $args['after_text'].  $args['text_icon']); ?></a>
    <?php
    printf('%s', $args['after']);
    if ($args['echo']) {
        echo ob_get_clean();
    } else {
        return ob_get_clean();
    }
}

function genzia_elementor_link_url_settings($widget, $args = [])
{
    $args = wp_parse_args($args, [
        'name' => 'link_',
        'type' => [],
        //
        'group' => false,
        'label' => esc_html__('Link Settings', 'genzia'),
        // Color
        'color_label' => esc_html__('Text', 'genzia'),
        //
        'tab' => Controls_Manager::TAB_CONTENT,
        'condition' => []
    ]);
    $label_classes = $args['group'] ? '' : 'cms-description-as-label';
    $description = $args['group'] ? '' : $args['label'];
    
    if ($args['group']) {
        $widget->start_controls_section(
            $args['name'] . 'section',
            [
                'label'     => $args['label'],
                'tab'       => $args['tab'],
                'condition' => $args['condition']
            ]
        );
    }
        $widget->add_control(
            $args['name'].'url',
            [
                'label'       => esc_html__('Link', 'genzia'),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'genzia'),
                'default'     => [
                    'url' => '#',
                ],
                'condition'   => $args['condition'],
                'label_block' => false
            ]
        );
    if ($args['group']) {
        $widget->end_controls_section();
    }
}
function genzia_elementor_link_url_render($widget = [], $settings = [], $args = [])
{
    $args = wp_parse_args($args, [
        'name'   => 'link_',
        'echo'   => true,
        'suffix' => true
    ]);
    $url = ($args['suffix']) ? $settings[$args['name'].'url'] : $settings[$args['name']];
    if ($args['echo']) {
        echo esc_url($url['url']);
    } else {
        return $url['url'];
    }
}
/**
 * Signature Settings
 * 
 * */
if(!function_exists('genzia_signature_settings')){
    function genzia_signature_settings($widget = [], $args = []){
        $args = wp_parse_args($args, [
            'condition' => '',
            'group'     => true,
            'prefix'    => 'signature_'
        ]);
        if($args['group']){
            $widget->start_controls_section(
                $args['prefix'].'section',
                [
                    'label'     => esc_html__('Signature Settings', 'genzia'),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                    'condition' => $args['condition']
                ]
            );
        }
            $widget->add_control(
                $args['prefix'].'name',
                [
                    'label'       => esc_html__('Name', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Signature Name',
                    'placeholder' => esc_html__('Signature Name', 'genzia')
                ]
            );
            $widget->add_control(
                $args['prefix'].'pos',
                [
                    'label'       => esc_html__('Position', 'genzia'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => 'Your Position',
                    'placeholder' => esc_html__('Your Position', 'genzia')
                ]
            );
            $widget->add_control(
                $args['prefix'].'img',
                [
                    'label'   => esc_html__('Image', 'genzia'),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src()
                    ],
                    'label_block' => false,
                    'skin'        => 'inline'
                ]
            );
        if($args['group']){    
            $widget->end_controls_section();
        }
    }
}
if(!function_exists('genzia_signature_render')){
    function genzia_signature_render($widget = [], $settings = [], $args = []){
        $args = wp_parse_args($args, [
            'prefix'         => 'signature_',
            'class'          => '',
            'attrs'          => [],
            'name_class'     => 'text-lg font-500 text-heading-regular',
            'position_class' => 'text-sm text-body',
            'img_class'      => 'absolute top left',
            'img_attrs'      => []   
        ]);
        $widget->add_render_attribute('signature',array_merge([
            'class' => [
                'cms-signature',
                'relative',
                $args['class']
            ],
        ],$args['attrs']));
        $widget->add_render_attribute('signature-title',[
            'class' => [
                'cms-signature-title',
                'relative z-top',
                'empty-none',
                $args['name_class']
            ]
        ]);
        $widget->add_render_attribute('signature-pos',[
            'class' => [
                'cms-signature-pos',
                'relative z-top',
                'empty-none',
                $args['position_class']
            ]
        ]);
    ?>
    <div <?php ctc_print_html($widget->get_render_attribute_string('signature')); ?>>
        <?php 
            genzia_elementor_image_render($settings,[
                'name'                => $args['prefix'].'img',
                'size'                => 'custom',
                'custom_size'         => ['width' => 172, 'height' => 67],
                'img_class'           => $args['img_class'],
                'attrs'               => $args['img_attrs']  
            ]);
        ?>
        <div <?php ctc_print_html($widget->get_render_attribute_string('signature-title')); ?>><?php ctc_print_html($settings[$args['prefix'].'name']); ?></div>
        <div <?php ctc_print_html($widget->get_render_attribute_string('signature-pos')); ?>><?php ctc_print_html($settings[$args['prefix'].'pos']); ?></div>
    </div>
    <?php
    }
}
/**
 * Transform Settings
 * 
 * **/
if (!function_exists('genzia_elementor_transform_settings')) {
    function genzia_elementor_transform_settings($widget = [], $settings = [], $args = [])
    {
        $args = wp_parse_args($args, [
            'name' => 'cms_transform'
        ]);
        $widget->add_control(
            $args['name'] . '_rotateZ',
            [
                'label' => esc_html__('Rotate', 'genzia') . ' (deg)',
                'description' => esc_html__('Transform Settings', 'genzia'),
                'classes' => 'cms-description-as-label',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ],
                ],
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => '--cms-transform-rotateZ: {{SIZE}}deg',
                ]
            ]
        );
        $widget->add_control(
            $args['name'] . '_rotate_3d',
            [
                'label' => esc_html__('3D Rotate', 'genzia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'genzia'),
                'label_off' => esc_html__('Off', 'genzia'),
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => '--cms-transform-rotateX: 1{{UNIT}};--cms-transform-perspective: 20px;',
                ]
            ]
        );
        $widget->add_control(
            $args['name'] . '_rotateX',
            [
                'label' => esc_html__('Rotate X', 'genzia') . ' (deg)',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ],
                ],
                'condition' => [
                    $args['name'] . '_rotate_3d' => 'yes'
                ],
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => '--cms-transform-rotateX: {{SIZE}}deg;',
                ]
            ]
        );
        $widget->add_control(
            $args['name'] . '_rotateY',
            [
                'label' => esc_html__('Rotate Y', 'genzia') . ' (deg)',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ],
                ],
                'condition' => [
                    $args['name'] . '_rotate_3d' => 'yes'
                ],
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => '--cms-transform-rotateY: {{SIZE}}deg;',
                ]
            ]
        );
        $widget->add_control(
            $args['name'] . '_perspective',
            [
                'label' => esc_html__('Perspective', 'genzia') . ' (px)',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1000,
                    ],
                ],
                'condition' => [
                    $args['name'] . '_rotate_3d' => 'yes',
                ],
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => '--cms-transform-perspective: {{SIZE}}px',
                ]
            ]
        );
        // Offset
        $widget->add_control(
            $args['name'] . '_translateX',
            [
                'label' => esc_html__('Offset X', 'genzia'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => '--cms-transform-translateX: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
                'classes' => 'cms-eseparator'
            ]
        );
        $widget->add_control(
            $args['name'] . '_translateY',
            [
                'label' => esc_html__('Offset Y', 'genzia'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'custom'],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => '--cms-transform-translateY: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        // Scale
        $widget->add_control(
            $args['name'] . '_keep_proportions',
            [
                'label'     => esc_html__('Scale Keep Proportions', 'genzia'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('On', 'genzia'),
                'label_off' => esc_html__('Off', 'genzia'),
                'default'   => 'yes',
                'separator' => 'before',
                'classes'   => 'cms-eseparator'
            ]
        );
        $widget->add_control(
            $args['name'] . '_scale',
            [
                'label' => esc_html__('Scale', 'genzia'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'condition' => [
                    $args['name'] . '_keep_proportions' => '',
                ],
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => '--cms-transform-scale: {{SIZE}};',
                ]
            ]
        );
        $widget->add_control(
            $args['name'] . '_scaleX',
            [
                'label' => esc_html__('Scale X', 'genzia'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'condition' => [
                    $args['name'] . '_keep_proportions' => 'yes',
                ],
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => '--cms-transform-scaleX: {{SIZE}};',
                ]
            ]
        );
        $widget->add_control(
            $args['name'] . '_scaleY',
            [
                'label' => esc_html__('Scale Y', 'genzia'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'condition' => [
                    $args['name'] . '_keep_proportions' => 'yes',
                ],
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => '--cms-transform-scaleY: {{SIZE}};',
                ]
            ]
        );
        // Skew
        $widget->add_control(
            $args['name'] . '_skewX',
            [
                'label' => esc_html__('Skew X', 'genzia') . ' (deg)',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ],
                ],
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => '--cms-transform-skewX: {{SIZE}}deg;',
                ],
                'separator' => 'before',
                'classes' => 'cms-eseparator'
            ]
        );
        $widget->add_control(
            $args['name'] . '_skewY',
            [
                'label' => esc_html__('Skew Y', 'genzia') . ' (deg)',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ],
                ],
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => '--cms-transform-skewY: {{SIZE}}deg;',
                ]
            ]
        );
        $widget->add_control(
            $args['name'] . '_x_origin',
            [
                'label' => esc_html__('X Origin', 'genzia'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'genzia'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'genzia'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'genzia'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'separator' => 'before',
                'classes' => 'cms-eseparator',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--cms-transform-origin-x: {{VALUE}}',
                ],
            ]
        );

        // Will override motion effect transform-origin.
        $widget->add_control(
            $args['name'] . '_y_origin',
            [
                'label' => esc_html__('Y Origin', 'genzia'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'genzia'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'genzia'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'genzia'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--cms-transform-origin-y: {{VALUE}}',
                ],
            ]
        );
    }
}
/**
 * Elementor Taxonomies List
 * */
if (!function_exists('genzia_elementor_taxonomies_list')) {
    function genzia_elementor_taxonomies_list($args = [])
    {
        $args = wp_parse_args($args, [
            'custom' => false,
            'default' => true
        ]);
        $_taxonomies = get_taxonomies(array('show_tagcloud' => true), 'object');
        unset($_taxonomies['elementor_library_category']);
        unset($_taxonomies['wpc_group_badge']);
        unset($_taxonomies['wpc-badge-group']);
        unset($_taxonomies['link_category']);
        $taxonomies = [];
        if (!$args['default']) {
            $taxonomies[] = esc_html__('Default', 'genzia');
        }
        foreach ($_taxonomies as $key => $tax):
            $taxonomies[$key] = esc_html($tax->labels->name);
        endforeach;
        if ($args['custom']) {
            $taxonomies['custom'] = esc_html__('Custom', 'genzia');
        }
        return $taxonomies;
    }
}
/**
 * 
 * Elemenor Taxonomies List Settings
 * */
if (!function_exists('genzia_elementor_taxonomies_settings')) {
    function genzia_elementor_taxonomies_settings($widget = [], $args = [])
    {
        $args = wp_parse_args($args, [
            'prefix' => '',
            'label' => esc_html__('Taxonomy', 'genzia'),
            'tab' => Controls_Manager::TAB_CONTENT,
            'default' => '',
            'condition' => [],
            'custom' => false,
            'multiple' => true
        ]);
        $widget->start_controls_section(
            $args['prefix'] . '_taxonomy_section',
            [
                'label' => $args['label'] . ' ' . esc_html__('Settings', 'genzia'),
                'tab' => $args['tab'],
                'condition' => $args['condition']
            ]
        );
        $widget->add_control(
            $args['prefix'] . '_taxonomy',
            [
                'type' => Controls_Manager::SELECT,
                'label' => $args['label'],
                'options' => genzia_elementor_taxonomies_list(['custom' => $args['custom']]),
                'default' => $args['default']
            ]
        );
        genzia_elementor_term_by_taxonomy_settings($widget, [
            'prefix' => $args['prefix'],
            'custom' => $args['custom'],
            'multiple' => $args['multiple']
        ]);

        $widget->end_controls_section();
    }
}
/**
 * 
 * Elemenor Term list by Taxonomy
 * */
if (!function_exists('genzia_elementor_term_by_taxonomy_settings')) {
    function genzia_elementor_term_by_taxonomy_settings($widget = [], $args = [])
    {
        $args = wp_parse_args($args, [
            'prefix' => '',
            'custom_condition' => [],
            'multiple' => true
        ]);
        $_taxonomies = get_taxonomies(array('show_tagcloud' => true), 'object');
        unset($_taxonomies['elementor_library_category']);
        foreach ($_taxonomies as $tax) {
            $widget->add_control(
                $args['prefix'] . 'term_' . $tax->name,
                [
                    'label' => sprintf(esc_html__('Select Term of %s', 'genzia'), $tax->labels->name),
                    'type' => Controls_Manager::SELECT2,
                    'multiple' => $args['multiple'],
                    'options' => genzia_elementor_term_by_taxonomy($tax->name),
                    'condition' => array_merge(
                        [
                            $args['prefix'] . '_taxonomy' => [$tax->name]
                        ],
                        $args['custom_condition']
                    ),
                    'label_block' => true
                ]
            );
        }
    }
}
if (!function_exists('genzia_elementor_term_by_taxonomy')) {
    function genzia_elementor_term_by_taxonomy($tax = '')
    {
        $term_list = array();
        $terms = get_terms(
            array(
                'taxonomy' => $tax,
                'hide_empty' => true,
                'orderby' => 'include'
            )
        );
        foreach ($terms as $term) {
            //$term_list[$term->slug . '|' . $tax] = $term->name;
            $term_list[$term->term_id] = $term->name;
        }
        return $term_list;
    }
}

// Exclude Post type 
function genzia_excluded_post_type()
{
    return [
        // Theme
        'cms-header-top',
        'cms-footer',
        'cms-popup',
        'cms-sidenav',
        // Elementor
        'e-floating-buttons'
    ];
}
add_filter('tco_get_post_types', 'genzia_excluded_post_type');
/**
 * 
 * Elemenor Term list by Post Type
 * */
if (!function_exists('genzia_elementor_term_by_post_type_settings')) {
    function genzia_elementor_term_by_post_type_settings($widget = [], $args = [])
    {
        $args = wp_parse_args($args, [
            'multiple' => true
        ]);
        $args = wp_parse_args($args, ['condition' => 'post_type', 'custom_condition' => []]);
        $post_types = get_post_types([
            'public' => true,
            //'_builtin' => false
        ], 'objects');
        $excludedPostTypes = []; //    = genzia_excluded_post_type();
        $result = [];
        if (!is_array($post_types))
            return $result;
        foreach ($post_types as $post_type) {
            if (!$post_type instanceof WP_Post_Type)
                continue;
            if (in_array($post_type->name, $excludedPostTypes))
                continue;
            $result[] = $widget->add_control(
                'source_' . $post_type->name,
                [
                    'label' => sprintf(esc_html__('Select Term of %s', 'genzia'), $post_type->labels->singular_name),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => ctc_get_grid_term_options($post_type->name),
                    'condition' => array_merge(
                        [
                            $args['condition'] => [$post_type->name]
                        ],
                        $args['custom_condition']
                    )
                ]
            );
        }
        return $result;
    }
}
/**
 * Element Post Source Settings
 * 
 * **/
if (!function_exists('genzia_elementor_post_source_settings')) {
    function genzia_elementor_post_source_settings($widget = [], $args = [])
    {
        $args = wp_parse_args($args, []);

        $widget->start_controls_section(
            'source_section',
            [
                'label' => esc_html__('Source Settings', 'genzia'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $widget->add_control(
            'post_type',
            [
                'label' => esc_html__('Post Type', 'genzia'),
                'type' => Controls_Manager::SELECT,
                'options' => ctc_get_post_type_options(),
                'default' => 'post'
            ]
        );
        genzia_elementor_term_by_post_type_settings($widget);
        $widget->add_control(
            'taxonomy_by',
            [
                'label' => esc_html__('Taxonomy By', 'genzia'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'genzia'),
                    'category' => esc_html__('Category', 'genzia'),
                    'tag' => esc_html__('Tags', 'genzia')
                ]
            ]
        );
        $widget->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'genzia'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => esc_html__('Date', 'genzia'),
                    'ID' => esc_html__('ID', 'genzia'),
                    'author' => esc_html__('Author', 'genzia'),
                    'title' => esc_html__('Title', 'genzia'),
                    'rand' => esc_html__('Random', 'genzia'),
                ],
            ]
        );
        $widget->add_control(
            'order',
            [
                'label' => esc_html__('Sort Order', 'genzia'),
                'type' => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'desc' => esc_html__('Descending', 'genzia'),
                    'asc' => esc_html__('Ascending', 'genzia'),
                ],
            ]
        );
        $widget->add_control(
            'limit',
            [
                'label' => esc_html__('Total items', 'genzia'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
            ]
        );
        $widget->end_controls_section();
    }
}

/**
 * Ribbon
 * 
 * */
if (!function_exists('genzia_elementor_ribbon_render')) {
    function genzia_elementor_ribbon_render($args = [])
    {
        $args = wp_parse_args($args, [
            'ribbon' => 1,
            'class' => '',
            'before' => '',
            'after' => '',
            'content_before' => '',
            'content_after' => '',
            'content' => '',
            'color' => 'primary',
            'color_hover' => 'accent',
            'size' => ['width' => '10px', 'height' => '19px'],
            'echo' => true
        ]);
        if (empty($args['ribbon']))
            return;
        $classes = ['cms-ribbon-' . $args['ribbon'], 'bg-' . $args['color'], 'bg-hover-' . $args['color_hover'], 'd-inline-block', $args['class']];
        $style = 'width:' . $args['size']['width'] . ';height:' . $args['size']['height'] . ';';
        ob_start();
        printf('%1$s%2$s%3$s%4$s%5$s%6$s%7$s', $args['before'], '<div class="' . esc_attr(genzia_nice_class($classes)) . '" style="' . esc_attr($style) . '">', $args['content_before'], $args['content'], $args['content_after'], '</div>', $args['after']);
        if ($args['echo']) {
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
/**
 * Form Style Settings
 * 
 * **/
function genzia_elementor_form_style_settings($widget = [], $args = [])
{
    $args = wp_parse_args($args, [
        'tab'           => Controls_Manager::TAB_STYLE,
        'wrap_selector' => '{{WRAPPER}}'
    ]);
    $widget->start_controls_section(
        'section_form_style_settins',
        [
            'label' => esc_html__('Form Style Settings', 'genzia'),
            'tab'   => $args['tab']
        ]
    );
        genzia_elementor_colors_opts($widget, [
            'name'      => 'label_color',
            'label'     => esc_html__('Label Color', 'genzia'),
            'selectors' => [
                $args['wrap_selector'].' form' => '--cms-label-color:{{VALUE}};'
            ]
        ]);
        $widget->add_control(
            'form_field_height',
            [
                'label' => esc_html__('Field Height', 'genzia'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 40,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'separator' => 'before',
                'selectors' => [
                    $args['wrap_selector'].' form' => '--cms-form-field-height:{{SIZE}}px;'
                ]
            ]
        );
        genzia_elementor_colors_opts($widget, [
            'name'      => 'field_color',
            'label'     => esc_html__('Field Color', 'genzia'),
            'selectors' => [
                $args['wrap_selector'].' form' => '--cms-form-field-color:{{VALUE}};'
            ]
        ]);
        genzia_elementor_colors_opts($widget, [
            'name'      => 'placeholder_color',
            'label'     => esc_html__('Placeholder Color', 'genzia'),
            'selectors' => [
                $args['wrap_selector'].' form' => '--cms-placeholder-color:{{VALUE}};'
            ]
        ]);
        genzia_elementor_colors_opts($widget, [
            'name'      => 'field_bg_color',
            'label'     => esc_html__('Field Background Color', 'genzia'),
            'selectors' => [
                $args['wrap_selector'].' form' => '--cms-form-field-bg-color:{{VALUE}};'
            ]
        ]);
        genzia_elementor_colors_opts($widget, [
            'name'      => 'field_bg_hover_color',
            'label'     => esc_html__('Field Background Hover Color', 'genzia'),
            'selectors' => [
                $args['wrap_selector'].' form' => '--cms-form-field-bg-hover-color:{{VALUE}};'
            ]
        ]);
        $widget->add_control(
            'form_field_border_style',
            [
                'label'   => esc_html__('Field Border Style', 'genzia'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''       => esc_html__('Default', 'genzia'),
                    'none'   => esc_html__('None', 'genzia'),
                    'solid'  => esc_html__('Solid', 'genzia'),
                    'dotted' => esc_html__('Dotted', 'genzia'),
                    'double' => esc_html__('Double', 'genzia'),
                    'dashed' => esc_html__('Dashed', 'genzia')
                ],
                'default'   => '',
                'selectors' => [
                    $args['wrap_selector'].' form' => '--cms-form-field-border-style:{{VALUE}};--cms-form-field-border-style-hover:{{VALUE}};'
                ]
            ]
        );
        $widget->add_control(
            'form_field_border_width',
            [
                'label'      => esc_html__('Field Border Width', 'genzia'),
                'label_block'=> false,
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors'  => [
                    $args['wrap_selector'].' form' => '--cms-form-field-border-width:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};--cms-form-field-textarea-border-width:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $widget->add_control(
            'form_field_border_width_hover',
            [
                'label'      => esc_html__('Field Border Width Hover', 'genzia'),
                'label_block'=> false,
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors'  => [
                    $args['wrap_selector'].' form' => '--cms-form-field-border-width-hover:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};--cms-form-field-textarea-border-width-hover:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        genzia_elementor_colors_opts($widget, [
            'name'      => 'field_border_color',
            'label'     => esc_html__('Field Border Color', 'genzia'),
            'selectors' => [
                $args['wrap_selector'].' form' => '--cms-form-field-border-color:{{VALUE}};'
            ]
        ]);
        genzia_elementor_colors_opts($widget, [
            'name'      => 'field_border_color_hover',
            'label'     => esc_html__('Field Border Hover Color', 'genzia'),
            'selectors' => [
                $args['wrap_selector'].' form' => '--cms-form-field-border-color-hover:{{VALUE}};'
            ]
        ]);
        $widget->add_control(
            'form_field_radius',
            [
                'label' => esc_html__('Field Radius', 'genzia'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    $args['wrap_selector'].' form' => '--cms-form-field-radius:{{SIZE}}px;'
                ]
            ]
        );
        $widget->add_control(
            'form_field_padding_start',
            [
                'label' => esc_html__('Field Padding Start', 'genzia'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    $args['wrap_selector'].' form' => '--cms-form-field-padding-start:{{SIZE}}px;'
                ]
            ]
        );
        $widget->add_control(
            'form_field_padding_end',
            [
                'label' => esc_html__('Field Padding End', 'genzia'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    $args['wrap_selector'].' form' => '--cms-form-field-padding-end:{{SIZE}}px;--cms-form-select-padding-end:{{SIZE}}px;'
                ]
            ]
        );
        genzia_elementor_colors_opts($widget, [
            'name'      => 'field_border_checkbox_color',
            'label'     => esc_html__('Checkbox/Radio Border Color', 'genzia'),
            'selectors' => [
                $args['wrap_selector'].' form' => '--cms-form-field-checkbox-border:0 0 0 2px {{VALUE}};'
            ],
            'separator' => 'before'
        ]);
        $widget->add_control(
            'field_select_arrow',
            [
                'label'       => esc_html__('Field Select Arrow', 'genzia'),
                'type'        => Controls_Manager::MEDIA,
                'label_block' => false,
                'selectors'   => [
                    $args['wrap_selector'].' form' => '--cms-form-select-arrow:url({{URL}});'
                ],
                'separator' => 'before'
            ]
        );
        $widget->add_control(
            'textarea_height',
            [
                'label' => esc_html__('Textarea Height', 'genzia'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    $args['wrap_selector'].' form' => '--cms-form-textarea-height:{{SIZE}}px;--cms-form-textarea-max-height:{{SIZE}}px;'
                ],
                'separator' => 'before'
            ]
        );
        // button
        $widget->add_control(
            'form_btn_height',
            [
                'label' => esc_html__('Button Height', 'genzia'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 40,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'separator' => 'before',
                'classes'   => 'cms-eseparator',
                'selectors' => [
                    $args['wrap_selector'].' form' => '--cms-form-btn-height:{{SIZE}}px;'
                ]
            ]
        );
        $widget->add_control(
            'form_btn_radius',
            [
                'label' => esc_html__('Button Radius', 'genzia'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 999,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    $args['wrap_selector'].' form' => '--cms-btn-radius:{{SIZE}}px;'
                ]
            ]
        );
        genzia_elementor_colors_opts($widget, [
            'name'      => 'btn_color',
            'label'     => esc_html__('Button Color', 'genzia'),
            'selectors' => [
                $args['wrap_selector'].' form' => '--cms-form-btn-color:{{VALUE}};'
            ]
        ]);
        genzia_elementor_colors_opts($widget, [
            'name'      => 'btn_bg_color',
            'label'     => esc_html__('Button Background Color', 'genzia'),
            'selectors' => [
                $args['wrap_selector'].' form' => '--cms-form-btn-bg:{{VALUE}};'
            ]
        ]);
        genzia_elementor_colors_opts($widget, [
            'name'      => 'btn_hover_color',
            'label'     => esc_html__('Button Color Hover', 'genzia'),
            'selectors' => [
                $args['wrap_selector'].' form' => '--cms-form-btn-color-hover:{{VALUE}};'
            ]
        ]);
        genzia_elementor_colors_opts($widget, [
            'name'      => 'btn_bg_hover_color',
            'label'     => esc_html__('Button Background Color Hover', 'genzia'),
            'selectors' => [
                $args['wrap_selector'].' form' => '--cms-form-btn-bg-hover:{{VALUE}};'
            ]
        ]);
        genzia_elementor_colors_opts($widget, [
            'name'      => 'invalid_color',
            'label'     => esc_html__('Invalid Color', 'genzia'),
            'selectors' => [
                $args['wrap_selector'].' form' => '--cms-invalid-color:{{VALUE}};'
            ],
            'separator' => 'before'
        ]);
        genzia_elementor_colors_opts($widget, [
            'name'      => 'invalid_bg',
            'label'     => esc_html__('Invalid Background', 'genzia'),
            'selectors' => [
                $args['wrap_selector'].' form' => '--cms-invalid-bg:{{VALUE}};'
            ]
        ]);
    $widget->end_controls_section();
}
function genzia_elementor_form_style_render($widget = [], $settings = [], $args = [])
{
    $args = wp_parse_args($args, [
        'label_color'              => 'heading-regular',
        'field-height'             => 58,
        'field-width'              => '',
        'field-min-width'          => '',
        'field-color'              => 'body',
        'field-bg-color'           => 'transparent',
        'field-bg-hover-color'     => 'transparent',
        'field-border-style'       => 'solid',
        'field-border-width'       => '0 0 2px 0',
        'field-border-width-hover' => '0 0 2px 0',
        'field-border'             => 'form-stroke',
        'field-border-hover'       => 'accent',
        'field-radius'             => 0,
        'field-padding-start'      => 0,
        'field-padding-end'        => 0,
        'placeholder-color'        => 'body',
        'select-arrow'             => 'url('.get_template_directory_uri().'/assets/images/select-arrow-black.png)',
        'textarea-height'          => 108,
        // Button
        'btn-height'        => 58,
        'btn-height-mobile' => '',
        'btn-color'         => 'white',
        'btn-color-hover'   => 'white',
        'btn-bg'            => 'menu',
        'btn-bg-hover'      => 'accent',
        'btn-radius'        => 0,
        'btn-padding'       => '0 32px'
    ]);
    // Form
    $label_color              = $widget->get_setting('label_color', 'heading');
    $field_height             = !empty($widget->get_setting('form_field_height')['size']) ? $widget->get_setting('form_field_height')['size'] : $args['field-height'];
    $args['field-width']      = !empty($args['field-width']) ? $args['field-width'] : '';  
    $args['field-min-width']  = !empty($args['field-min-width']) ? $args['field-min-width'] : '';  
    $field_color              = $widget->get_setting('field_color', $args['field-color']);
    $placeholder_color        = $widget->get_setting('placeholder_color', $args['placeholder-color']);
    $field_bg_color           = $widget->get_setting('field_bg_color', $args['field-bg-color']);
    $field_bg_hover_color     = $widget->get_setting('field_bg_hover_color', $args['field-bg-hover-color']);
    $field_border_style       = $widget->get_setting('form_field_border_style', $args['field-border-style']);
    $field_border_width       = $args['field-border-width'];
    $field_border_width_hover = $args['field-border-width-hover'];
    $field_border_color       = $widget->get_setting('field_border_color', $args['field-border']);
    $field_border_color_hover = $widget->get_setting('field_border_color_hover', $args['field-border-hover']);
    $field_radius             = !empty($widget->get_setting('form_field_radius')['size']) ? $widget->get_setting('form_field_radius')['size'] : $args['field-radius'];
    $field_padding_start      = !empty($widget->get_setting('form_field_padding_start')['size']) ? $widget->get_setting('form_field_padding_start')['size'] . 'px;' : $args['field-padding-start'] . ';';
    $field_padding_end        = !empty($widget->get_setting('form_field_padding_end')['size']) ? $widget->get_setting('form_field_padding_end')['size'] . 'px;' : $args['field-padding-end'] . ';';
    $field_checkbox_border    = '0 0 0 2px var(--cms-' . $widget->get_setting('field_border_checkbox_color', 'accent') . ') inset;';
    if (!empty($settings['field_select_arrow']['id'])) {
        $field_seclect_arrow = 'url(' . genzia_elementor_image_src_render($settings, ['name' => 'field_select_arrow', 'echo' => false, 'default' => false]) . ')';
    } else {
        $field_seclect_arrow = $args['select-arrow'];
    }
    //$field_seclect_arrow   = 'url('.genzia_elementor_image_src_render($settings, ['name' => 'field_select_arrow', 'echo'=>false, 'default' => false]).');';
    $field_textarea_height = !empty($widget->get_setting('textarea_height')['size']) ? $widget->get_setting('textarea_height')['size'] . 'px;' : $args['textarea-height'] . 'px;';

    $form_btn_height        = !empty($widget->get_setting('form_btn_height')['size']) ? $widget->get_setting('form_btn_height')['size'] : $args['btn-height'];
    $form_btn_height_mobile = !empty($args['btn-height-mobile']) ? $args['btn-height-mobile'] : $form_btn_height;
    $form_btn_radius        = !empty($widget->get_setting('form_btn_radius')['size']) ? $widget->get_setting('form_btn_radius')['size'] : $args['btn-radius'];

    $form_btn_color          = 'var(--cms-'.$widget->get_setting('btn_color', $args['btn-color']).');';
    $form_btn_bg_color       = 'var(--cms-'.$widget->get_setting('btn_bg_color', $args['btn-bg']).');';
    $form_btn_hover_color    = 'var(--cms-'.$widget->get_setting('btn_hover_color',$args['btn-color-hover']).');';
    $form_btn_bg_hover_color = 'var(--cms-'.$widget->get_setting('btn_bg_hover_color',$args['btn-bg-hover']).');';
    
    $form_invalid_bg         = $widget->get_setting('invalid_bg','primary-darken');
    $form_invalid_color      = $widget->get_setting('invalid_color', 'white');
    //
    $styles = [
        '--cms-label-color:var(--cms-' . $label_color . ');',
        '--cms-form-field-height:' . $field_height . 'px;',
        (!empty($args['field-width'])) ? '--cms-form-field-width:' . $args['field-width'] . ';':'',
        (!empty($args['field-min-width'])) ? '--cms-form-field-min-width:' . $args['field-min-width'].';':'',
        '--cms-form-field-color:var(--cms-' . $field_color . ');',
        '--cms-placeholder-color:var(--cms-' . $placeholder_color . ');',
        '--cms-form-field-bg-color:var(--cms-' . $field_bg_color . ');',
        '--cms-form-field-bg-hover-color:var(--cms-' . $field_bg_hover_color . ');',
        '--cms-form-field-border-style: ' . $field_border_style . ';',
        '--cms-form-field-border-width: ' . $field_border_width . ';',
        '--cms-form-field-border-width-hover: ' . $field_border_width_hover . ';',
        '--cms-form-field-border-color:var(--cms-' . $field_border_color . ');',
        '--cms-form-field-border-color-hover:var(--cms-' . $field_border_color_hover . ');',
        '--cms-form-field-radius:' . $field_radius . 'px;',
        '--cms-form-field-border: ' . $field_border_style . ' ' . $field_border_width . ' var(--cms-' . $field_border_color . ');',
        '--cms-form-field-border-hover:' . $field_border_style . ' ' . $field_border_width . ' var(--cms-' . $field_border_color_hover . ');',
        '--cms-form-field-padding-start:' . $field_padding_start . ';',
        '--cms-form-field-padding-end:' . $field_padding_end . ';',
        '--cms-form-field-checkbox-border:' . $field_checkbox_border,
        '--cms-form-select-radius:'. $field_radius . 'px;',
        '--cms-form-select-arrow:' . $field_seclect_arrow . ';',
        '--cms-form-textarea-height:' . $field_textarea_height,
        '--cms-form-textarea-radius:' . $field_radius . 'px;',
        '--cms-form-btn-height:' . $form_btn_height . 'px;',
        '--cms-form-btn-height-mobile:' . $form_btn_height_mobile . 'px;',
        '--cms-form-btn-color:' . $form_btn_color,
        '--cms-form-btn-bg:' . $form_btn_bg_color,
        '--cms-form-btn-color-hover:' . $form_btn_hover_color,
        '--cms-form-btn-bg-hover:' . $form_btn_bg_hover_color,
        '--cms-btn-padding:' . $args['btn-padding'] . ';',
        '--cms-invalid-bg:var(--cms-' . $form_invalid_bg . ');',
        '--cms-invalid-color:var(--cms-' . $form_invalid_color . ');',
        //
        '--cms-btn-color:' . $form_btn_color,
        '--cms-btn-bg:' . $form_btn_bg_color,
        '--cms-btn-color-hover:' . $form_btn_hover_color,
        '--cms-btn-bg-hover:' . $form_btn_bg_hover_color,
        '--cms-btn-radius:' . $form_btn_radius.'px;',
    ];

    return $styles;
}

// Scan files to register controls for each new custom widget
// $files = scandir(get_template_directory() . '/elementor/core/widgets');
// foreach ($files as $file) {
//     $pos = strrpos($file, ".php");
//     if ($pos !== false) {
//         require_once get_template_directory() . '/elementor/core/widgets/' . $file;
//     }
// }