<?php
$post_type   = $this->get_setting('post_type', 'post');
$tax         = array();
$taxonomy_by = $this->get_setting('taxonomy_by', 'category');
$source      = $this->get_setting('source_'.$post_type);
$orderby     = $this->get_setting('orderby', 'date');
$order       = $this->get_setting('order', 'desc');
$limit       = $this->get_setting('limit', 6);

extract(ctc_get_posts_of_grid($post_type, [
    'source'   => $source,
    'orderby'  => $orderby,
    'order'    => $order,
    'limit'    => $limit
], [genzia_taxonomy_by_post_type($post_type, 'category')]));

$numn_line = !empty($this->get_setting('num_line')['size']) ? $this->get_setting('num_line')['size'] : 1;

// Wrap attributes
$this->add_render_attribute('wrap',[
    'class' => ['cms-post-grid', 'cms-grid', 'cms-grid-'.$settings['layout']]
]);
// Element Heading 
$this->add_inline_editing_attributes( 'heading_text' );
$this->add_render_attribute( 'heading_text', [
    'class' => [
        'cms-small cms-nl2br',
        'text-'.$this->get_setting('heading_color','heading-regular'),
        'text-2xl',
        'h-100vh',
        'cms-sticky',
        'd-flex align-items-center justify-content-center',
        'text-center'
    ],
    'data-parallax' => wp_json_encode([
        'scale' => 1.5
    ])
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
    <h2 <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>>
        <span class="cms-gradient-render cms-gradient-4"><?php 
        echo nl2br( $settings['heading_text'] ); 
        ?></span>
    </h2>
    <?php
        $count = 0;
        // Render HTML
        foreach ($posts as $key => $post){
            $count ++;
        // item
        $item_key = $this->get_repeater_setting_key('item', 'cms_posts_grid', $key);
        $this->add_render_attribute($item_key, [
            'class' => [
                'cms-item relative cms-sticky cms-mobile-relative',
                ($count>1)?'mt-80 mt-mobile-40': '',
                'h-100vh h-mobile-auto d-flex align-items-center'
            ]
        ]);
        // item taxonomy
        $item_tax = $this->get_repeater_setting_key('item_tax','cms_posts_grid', $key);
        $this->add_render_attribute($item_tax,[
            'class' => [
                'category text-xs d-flex gap-4 w-100',
                'elementor-invisible'
            ],
            'data-settings' => wp_json_encode([
                'animation' => 'fadeInUp',
                'animation_delay' => 200
            ])
        ]);
        // item title
        $item_title_key = $this->get_repeater_setting_key('item_title', 'cms_posts_grid', $key);
        $this->add_render_attribute($item_title_key, [
            'class' => [
                'h2 text-line-3 text-white text-hover-white cms-hover-underline d-inline',
                'elementor-invisible'
            ],
            'href'          => get_permalink( $post->ID ),
            'data-settings' => wp_json_encode([
                'animation' => 'fadeInUp',
                'animation_delay' => 200
            ])
        ]);
        // item Excerpt
        $item_excerpt_key = $this->get_repeater_setting_key('item_excerpt', 'cms_posts_grid', $key);
        $this->add_render_attribute($item_excerpt_key, [
            'class' => [
                'cms-excerpt text-lg',
                'text-line-'.$numn_line,
                'text-on-dark pt-8',
                'elementor-invisible'
            ],
            'href'          => get_permalink( $post->ID ),
            'data-settings' => wp_json_encode([
                'animation' => 'fadeInUp',
                'animation_delay' => 200
            ])
        ]);
    ?>
    <div <?php ctc_print_html($this->get_render_attribute_string($item_key)); ?>>
        <div class="cms--item relative cms-radius-16 overflow-hidden cms-shadow-2">
            <?php
                // Post Image
                genzia_elementor_post_thumbnail_render($settings, [
                    'post_id'     => $post->ID,
                    'custom_size' => ['width' => 1216, 'height' => 736],
                    'img_class'   => 'img-cover cms-radius-16', 
                    'max_height'  => true,
                    'before'      => '',
                    'after'       => ''
                ]);          
            ?>
            <div class="cms--item cms-overlay d-flex flex-column gap-20 justify-content-between p-48 p-smobile-20">
                <div <?php ctc_print_html($this->get_render_attribute_string($item_tax)); ?>><?php 
                    // Taxonomy
                    genzia_the_terms($post->ID, $taxonomy_by, '', 'bg-white text-menu bg-hover-accent-regular text-hover-white cms-radius-4 p-tb-5 p-lr-10', ['before' => '', 'after' => '']);
                ?></div>
                <div class="w-100 align-self-end">
                    <a <?php ctc_print_html($this->get_render_attribute_string($item_title_key)); ?>><?php 
                        echo get_the_title($post->ID); 
                    ?></a>
                    <div <?php ctc_print_html($this->get_render_attribute_string($item_excerpt_key)); ?>><?php 
                        echo wp_kses_post($post->post_excerpt);
                    ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>