<?php
// Sources
$source  = $this->get_setting('source', []);
$orderby = $this->get_setting('orderby', 'date');
$order   = $this->get_setting('order', 'desc');
$limit   = $this->get_setting('limit', 4);

$tax = [];
foreach ($source as $category) {
    $category_arr = explode('|', $category);
    $tax[] = $category_arr[0];
}
// Main Post Query
$main_posts = ctc_get_posts_of_grid('post', [
    'post_type' => 'post',
    'source' => $source,
    'orderby' => $orderby,
    'order' => $order,
    'limit' => 1,
    'tax' => $tax
]);
// Second Post Query
$second_posts = ctc_get_posts_of_grid(
    'post',
    [
        'post_type' => 'post',
        'source' => $source,
        'orderby' => $orderby,
        'order' => $order,
        'limit' => $limit - 1,
        'tax' => $tax
    ],
    [],
    [
        'offset' => 1
    ]
);
// Wrap
$this->add_render_attribute('wrap', [
    'class' => [
        'cms-eblog',
        'cms-eblog-' . $settings['layout'],
        'd-flex',
        'bdr-b-1 bdr-divider'
    ]
]);
// Main Content
$this->add_render_attribute('main-content', [
    'class' => [
        'cms-main-posts col-6 col-tablet-6 col-mobile-12',
        'elementor-invisible',
        'max-w',
        'pt-40'
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInLeft'
    ])
]);
// Side Content
$this->add_render_attribute('side-content', [
    'class' => [
        'cms-second-posts col-6 col-tablet-6 col-mobile-12',
        'elementor-invisible',
        'max-w',
        'bdr-l-1 bdr-divider',
        'p-tb-40'
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInRight'
    ])
]);
// Large Heading
$this->add_inline_editing_attributes( 'heading_text', 'none' );
$this->add_render_attribute( 'heading_text', [
    'class' => [
        'cms-title',
        'cms-nl2br',
        'elementor-invisible',
        'cms-heading empty-none',
        'text-'.$this->get_setting('heading_color','heading-regular'),
        'pb-40 pb-tablet-30 bdr-b-1 bdr-divider'
    ],
    'data-settings' => wp_json_encode([
        'animation'       => 'fadeInUp',
        'animation_delay' => 200
    ])
]);
?>

<h3 <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>>
    <?php echo nl2br( $settings['heading_text'] ); ?>
</h3>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
    <div <?php ctc_print_html($this->get_render_attribute_string('main-content')); ?>>
        <div class="hover-image-zoom-out pr-32 pr-mobile-0">
            <?php 
            // Content
            foreach ($main_posts['posts'] as $post):
                // Post Term
                ob_start();
                    genzia_the_terms($post->ID, 'category', ', ', 'text-white text-hover-white cms-hover-underline', [
                        'before' => '<div class="bg-menu absolute top left mt-8 ml-8 p-lr-12 p-tb-5 text-xs text-white">',
                        'after'  => '</div>'
                    ]);
                $thumb_content = ob_get_clean();
                //
                genzia_elementor_post_thumbnail_render($settings, [
                    'post_id'       => $post->ID,
                    'custom_size'   => ['width' => 588, 'height' => 318],
                    'img_class'     => 'img-cover',
                    'as_background' => false,
                    'max_height'    => true,
                    'before'        => '<div class="relative overflow-hidden mb-30">',
                    'after'         => $thumb_content.'</div>'
                ]);
            ?>
                <div class="cms-post-meta d-flex gap-12 align-items-center text-sub-text text-sm pb-10">
                    <div class="meta-item post-date"><?php echo get_the_date('', $post->ID); ?></div>
                    <span class="separator"></span>
                    <?php
                    genzia_the_author_posts_link([
                        'id'         => $post->ID,
                        'link_class' => 'text-accent-regular text-hover-accent-regular cms-hover-underline',
                        'before'     => '<div class="meta-item author">',
                        'after'      => '</div>'
                    ]);
                    ?>
                </div>
                <a class="cms-heading h5 text-menu text-hover-accent-regular"
                    href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php 
                    echo get_the_title($post->ID); 
                ?></a>
                <div class="cms-excerpt text-line-4 pt-15"><?php 
                    echo get_the_excerpt($post->ID);
                ?></div>
            <?php endforeach; ?>
        </div>
    </div>
    <div <?php ctc_print_html($this->get_render_attribute_string('side-content')); ?>>
        <?php // Content
        foreach ($second_posts['posts'] as $key => $post):
            ?>
            <div
                class="cms-content d-flex align-items-center hover-image-zoom-out gap-32 pl-40 pl-mobile-0 <?php if ($key > 0)
                    echo 'bdr-t-1 bdr-divider mt-32 pt-32'; ?>">
                <?php
                genzia_elementor_post_thumbnail_render($settings, [
                    'post_id'     => $post->ID,
                    'custom_size' => ['width' => 220, 'height' => 153],
                    'img_class'   => 'img-cover',
                    'max_height'  => true,
                    'before'      => '<div class="flex-auto flex-smobile-full overflow-hidden max-w" style="--max-w:36.2%;--max-w-tablet:36.2%;--max-w-mobile-extra:36.2%;--max-w-smobile:100%;">',
                    'after'       => '</div>'
                ]);
                ?>
                <div class="flex-basic flex-smobile-full">
                    <div class="cms-post-meta d-flex gap-12 align-items-center text-sm pb-7">
                        <div class="post-date text-sub-text"><?php echo get_the_date('', $post->ID); ?></div>
                        <div class="separator"></div>
                        <?php
                        genzia_the_author_posts_link([
                            'id'         => $post->ID,
                            'link_class' => 'text-accent-regular text-hover-accent-regular cms-hover-underline',
                            'before'     => '<div class="meta-item author">',
                            'after'      => '</div>'
                        ]);
                        ?>
                    </div>
                    <a class="cms-heading text-xl text-menu text-hover-accent-regular"
                        href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php echo get_the_title($post->ID); ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php 
    // Button
    genzia_elementor_link_render($widget, $settings, [
        'name'             => 'link1_',
        'mode'             => 'link',
        'text_icon'        => genzia_svgs_icon([
            'icon'      => 'arrow-right',
            'icon_size' => 11,
            'echo'      => false
        ]),
        'class' => [
            'cms-link',
            'cms-hover-move-icon-right',
            'elementor-invisible',
            'text-btn font-500 d-flex gap-8 align-items-center',
            'cms-underline cms-hover-underline',
            'mt-33'
        ],
        'text_color'       => 'accent-regular',
        'text_color_hover' => 'accent-regular',
        'attrs'            => [
            'data-settings' => wp_json_encode([
                'animation' => 'fadeInRight'
            ])
        ],
        'before' => '<div class="text-center">',
        'after'  => '</div>'
    ]);
?>