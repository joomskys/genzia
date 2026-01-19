<?php
// Silence is golden.
$args = [
    'title'    => esc_html__('Content', 'genzia'),
    'sections' => [
        'general' => [
            'title' => esc_html__('General', 'genzia'),
            'fields' => [
                'content_width' => genzia_theme_content_width_opts(),
                'search_field_placeholder' => [
                    'type'        => CSH_Theme_Core::TEXT_FIELD,
                    'title'       => esc_html__('Search Form - Text Placeholder', 'genzia'),
                    'description' => esc_html__('Default: Search Keywords...', 'genzia'),
                ]
            ]
        ],
        'archive' => [
            'title'  => esc_html__('Archive', 'genzia'),
            'fields' => [
                // Post Meta
                'archive_meta_heading' => [
                    'type'     => CSH_Theme_Core::HEADING_FIELD,
                    'title'    => esc_html__('Archive Meta', 'genzia')
                ],
                'archive_author_on' => [
                    'type'     => CSH_Theme_Core::SWITCH_FIELD,
                    'title'    => esc_html__('Author', 'genzia'),
                    'subtitle' => esc_html__('Show author name on each post.', 'genzia'),
                    'default'  => 1,
                ],
                'archive_date_on' => [
                    'type'     => CSH_Theme_Core::SWITCH_FIELD,
                    'title'    => esc_html__('Date', 'genzia'),
                    'subtitle' => esc_html__('Show date posted on each post.', 'genzia'),
                    'default'  => 1,
                ],
                'archive_categories_on' => [
                    'type'     => CSH_Theme_Core::SWITCH_FIELD,
                    'title'    => esc_html__('Categories', 'genzia'),
                    'subtitle' => esc_html__('Show category names on each post.', 'genzia'),
                    'default'  => 1,
                ],
                'archive_comments_on' => [
                    'type'     => CSH_Theme_Core::SWITCH_FIELD,
                    'title'    => esc_html__('Comments', 'genzia'),
                    'subtitle' => esc_html__('Show comments count on each post.', 'genzia'),
                    'default'  => 1,
                ]
            ],
        ],
        'single-post' => [
            'title'  => esc_html__('Single Post', 'genzia'),
            'fields' => [
                // Post Meta
                'post_meta_heading' => [
                    'type'     => CSH_Theme_Core::HEADING_FIELD,
                    'title'    => esc_html__('Post Meta', 'genzia')
                ],
                'post_author_on' => [
                    'type'     => CSH_Theme_Core::SWITCH_FIELD,
                    'title'    => esc_html__('Author', 'genzia'),
                    'subtitle' => esc_html__('Show author name on single post.', 'genzia'),
                    'default'  => 1,
                ],
                'post_author_info_on' => [
                    'type'     => CSH_Theme_Core::SWITCH_FIELD,
                    'title'    => esc_html__('Author Info', 'genzia'),
                    'subtitle' => esc_html__('Show author info on single post.', 'genzia'),
                ],
                'post_date_on' => [
                    'type'     => CSH_Theme_Core::SWITCH_FIELD,
                    'title'    => esc_html__('Date', 'genzia'),
                    'subtitle' => esc_html__('Show date on single post.', 'genzia'),
                    'default'  => 1,
                ],
                'post_categories_on' => [
                    'type'     => CSH_Theme_Core::SWITCH_FIELD,
                    'title'    => esc_html__('Categories', 'genzia'),
                    'subtitle' => esc_html__('Show category names on single post.', 'genzia'),
                    'default'  => 1,
                ],
                'post_tags_on' => [
                    'type'     => CSH_Theme_Core::SWITCH_FIELD,
                    'title'    => esc_html__('Tags', 'genzia'),
                    'subtitle' => esc_html__('Show tag names on single post.', 'genzia'),
                    'default'  => 1,
                ],
                'post_comments_on' => [
                    'type'     => CSH_Theme_Core::SWITCH_FIELD,
                    'title'    => esc_html__('Comments', 'genzia'),
                    'subtitle' => esc_html__('Show comments count on single post.', 'genzia'),
                    'default'  => 1,
                ],
                'post_social_share_on' => [
                    'type'     => CSH_Theme_Core::SWITCH_FIELD,
                    'title'    => esc_html__('Social Share', 'genzia'),
                    'subtitle' => esc_html__('Show social share on single post.', 'genzia')
                ],
                'post_navigation_on' => [
                    'type'     => CSH_Theme_Core::SWITCH_FIELD,
                    'title'    => esc_html__('Navigation', 'genzia'),
                    'subtitle' => esc_html__('Show navigation on single post.', 'genzia'),
                    'default'  => 1,
                ],
                'post_comments_form_on' => [
                    'type'     => CSH_Theme_Core::SWITCH_FIELD,
                    'title'    => esc_html__('Comments Form', 'genzia'),
                    'subtitle' => esc_html__('Show comments form on single post.', 'genzia'),
                    'default'  => 1,
                ]
            ]
        ]
    ]
];
return $args;