<?php
$post_type   = $this->get_setting('post_type', 'post');
$tax         = array();
$taxonomy_by = $this->get_setting('taxonomy_by', 'category');
$source      = $this->get_setting('source_'.$post_type);
$orderby     = $this->get_setting('orderby', 'date');
$order       = $this->get_setting('order', 'desc');
$limit       = $this->get_setting('limit', 6);
$layout_type = 'grid';
$filter      = $this->get_setting('filter', 'false');
extract(ctc_get_posts_of_grid($post_type, [
    'source'   => $source,
    'orderby'  => $orderby,
    'order'    => $order,
    'limit'    => $limit
], [genzia_taxonomy_by_post_type($post_type, 'category')]));

$numn_line = !empty($this->get_setting('num_line')['size']) ? $this->get_setting('num_line')['size'] : 1;

// Wrap attributes
$this->add_render_attribute('wrap',[
    'class'       => [
        'cms-theme-post-scroll-grow',
        'cms-theme-post-scroll-grow-'.$settings['layout'],
        'd-flex',
        'gutter-custom-x gutter-custom-y',
        'cms-gradient-render cms-gradient-3'
    ],
    'data-cursor' => $this->get_setting('readmore_text', esc_html__('Explore More','genzia')),
    'style' => [
        '--gutter-x:32px;',
        '--gutter-y:176px;--gutter-y-tablet:88px;--gutter-y-mobile:32px;'
    ]
]);
// Small Heading
$this->add_inline_editing_attributes( 'smallheading_text' );
$this->add_render_attribute( 'smallheading_text', [
    'class' => [
        'cms-small',
        'elementor-invisible',
        'cms-smallheading cms-nl2br',
        'text-sm',
        'text-'.$this->get_setting('smallheading_color','sub-text'),
        'empty-none',
        'm-tb-nsm',
        'pb-25',
        'text-center'
    ],
    'data-settings' => wp_json_encode([
        'animation' => 'fadeInUp',
        'animation_delay' => 100
    ])
]);
$small_icon_classes = genzia_nice_class([
    'cms-small-icon pb-20',
    'text-'.$this->get_setting('smallheading_icon_color', 'accent-regular'),
    'text-center'
]);
// Large Heading
$this->add_inline_editing_attributes( 'heading_text', 'none' );
$this->add_render_attribute( 'heading_text', [
    'class' => [
        'cms-title',
        'text-'.$this->get_setting('heading_color','heading-regular'),
        'cms-nl2br',
        'elementor-invisible',
        'cms-heading empty-none',
        'm-tb-n7',
        'text-center'
    ],
    'data-settings' => wp_json_encode([
        'animation'       => 'fadeInUp',
        'animation_delay' => 200
    ])
]);
// Heading 
$this->add_render_attribute('heading',[
    'class' => [
        'cms-sticky cms-mobile-relative',
        'max-w',
        'm-lr-auto',
        'pb',
        'cms-parallax-tablet-no'
    ],
    'data-parallax' => wp_json_encode([
        'scale'   => '0.5',
        //'opacity' => 1  
        //'from-scroll' => 400 
    ]),
    'style' => '--max-w:670px;--pb:270px;--pb-tablet:135px;--pb-mobile:40px;'
]);
$readmore_text = $this->get_setting('readmore_text', esc_html__('View project'));
?>
<div <?php ctc_print_html( $this->get_render_attribute_string( 'heading' ) ); ?>>
    <div <?php ctc_print_html( $this->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php 
        // Text
        echo nl2br( $settings['smallheading_text'] ); 
    ?></div>
    <?php 
        // Icon
        genzia_elementor_icon_render( $settings['smallheading_icon'], [], [ 'aria-hidden' => 'true', 'class' => $small_icon_classes, 'icon_size' => 12 ], 'div' );
    ?>
    <h2 <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>>
        <?php echo nl2br( $settings['heading_text'] ); ?>
    </h2>
</div>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
    <?php 
        $count = 0;
        $small_item = $medium_item = $large_item = false;
        foreach ($posts as $key => $post){
        $count ++;
        if(in_array($count, [1, 5])){
            $medium_item = true;
        }
        // Items
        $item_key = $this->get_repeater_setting_key('item', 'cms_theme_posts_scroll_grow', $key);
        $this->add_render_attribute($item_key, [
            'class' => array_filter([
                'cms-item',
                (in_array($count, [1, 5, 7, 11]))? 'col-7' : '',
                (in_array($count, [2, 4, 8, 10]))? 'col-5' : '',
                (in_array($count, [3, 6, 9]))? 'col-8 m-lr-auto' : '',
                'col-mobile-12'
            ])
        ]);
        // Items Inner
        $item_inner_key = $this->get_repeater_setting_key('item-inner', 'cms_theme_posts_scroll_grow', $key);
        $this->add_render_attribute($item_inner_key, [
            'class' => array_filter([
                'cms--item',
                'm-lr-tablet-0',
                (in_array($count, [1, 7, 10]))? 'mr-70' : '',
                (in_array($count, [5, 8, 11]))? 'ml-70' : '',
                //
                (in_array($count, [2]))? 'ml-70' : '',
                (in_array($count, [4]))? 'mr-70' : '',
                'cms-parallax-tablet-no',
                'relative',
                'cms-hover-change'
            ]),
            'data-parallax' => wp_json_encode([
                'scale'   => "1.2",
                'opacity' => "1"
            ]),
            'style' => [
                //'transform:scaleX(0.5) scaleY(0.5) scaleZ(0.5);',
                //'opacity:0.5;'
            ]
        ]);

    ?>
        <div <?php ctc_print_html($this->get_render_attribute_string( $item_key )); ?>>
            <div <?php ctc_print_html($this->get_render_attribute_string( $item_inner_key )); ?>>
                <?php
                    // Post Image
                    ob_start();
                ?>
                    <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="cms-box-123 circle bg-accent-regular text-white bg-hover-primary-regular text-hover-white text-xs font-700 p-20 text-center absolute center z-top cms-hidden-min-tablet-extra"><?php 
                        ctc_print_html($readmore_text); 
                    ?></a>
                <?php
                    $readmore = ob_get_clean();
                    genzia_elementor_post_thumbnail_render($settings, [
                        'post_id'     => $post->ID,
                        'custom_size' => ['width' => 800, 'height' => 560],
                        'img_class'   => 'cms-radius-16', 
                        'max_height'  => true,
                        'before'      => '<div class="relative mb-33">',
                        'after'       => $readmore.'</div>'
                    ]);
                ?>
                <h6><?php echo get_the_title($post->ID);?></h6>
                <div class="cms-excerpt text-md text-line-1 pt-5 mb-n5"><?php 
                    echo wp_kses_post($post->post_excerpt);
                ?></div>
                <?php
                // Taxonomy
                genzia_the_terms($post->ID, $taxonomy_by, '', 'bg-white text-menu bdr-1 bdr-divider text-hover-white bg-hover-accent-regular bdr-hover-accent-regular cms-radius-4 p-lr-10 p-tb-5', ['before' => '<div class="d-flex gap-4 text-xs pt-30">', 'after' => '</div>']);
                ?>
                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="cms-overlay cms-hidden-mobile drag-cursor cms-cursor-text" data-cursor-text="<?php echo esc_attr($readmore_text); ?>">
                    <span class="screen-reader-text"><?php ctc_print_html($readmore_text); ?></span>
                </a>
            </div>
        </div>
    <?php } ?>
</div>