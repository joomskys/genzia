<?php
// Silence is golden.
$args = [
    'title' => esc_html__('Footer', 'genzia'),
    'fields' => [
        'custom_footer' => [
            'type' => CSH_Theme_Core::SWITCH_FIELD,
            'title' => esc_html__('Custom Layout', 'genzia'),
        ],
        'footer_layout_custom' => [
            'type' => CSH_Theme_Core::SELECT_FIELD,
            'title' => esc_html__('Layout', 'genzia'),
            'description' => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom footer layout first.', 'genzia'), '<a href="' . esc_url(admin_url('edit.php?post_type=footer')) . '">', '</a>'),
            'options' => genzia_list_post('footer'),
            'default' => '',
            'required' => [
                'custom_footer',
                '=',
                '1'
            ],
        ],
    ]
];

return $args;