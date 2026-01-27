<?php
$teams       = $this->get_setting('teams', []);
$layout_mode = $this->get_setting('layout_mode', '-sticky-scroll');
//
$thumbnail_custom_dimension = [
 'width'  => !empty($settings['image_custom_dimension']['width']) ? $settings['image_custom_dimension']['width'] : 384,
 'height' => !empty($settings['image_custom_dimension']['height']) ? $settings['image_custom_dimension']['height'] : 452
];
// Small Heading
$this->add_inline_editing_attributes( 'smallheading_text' );
$this->add_render_attribute( 'smallheading_text', [
    'class' => [
        'cms-small',
        'elementor-invisible',
        'cms-nl2br',
        'text-sm',
        'text-'.$this->get_setting('smallheading_color','sub-text'),
        'empty-none',
        'm-tb-nsm',
        'cms-sticky',
        'd-flex gap-8 flex-nowrap'
    ],
    'data-settings' => wp_json_encode([
        'animation'       => 'fadeInLeft',
        'animation_delay' => 100
    ])
]);
$small_icon_classes = genzia_nice_class([
    'cms-small-icon pt-7',
    'text-'.$this->get_setting('smallheading_icon_color', 'accent-regular')
]);
// Large Heading
$this->add_inline_editing_attributes( 'heading_text' );
$this->add_render_attribute( 'heading_text', [
    'class' => [
        'cms-title empty-none',
        'text-'.$this->get_setting('heading_color','heading-regular'),
        'cms-nl2br',
        'elementor-invisible',
        'm-tb-nh2'
    ],
    'data-settings' => wp_json_encode([
        'animation'       => 'fadeInUp',
        'animation_delay' => 200
    ])
]);
// Heading Wrap
$this->add_render_attribute('heading-wrap',[
    'class' => [
        'cms-eteam-heading',
        'd-flex gutter',
        'pb-120 pb-tablet-40'
    ]
]);
// wrap
$this->add_render_attribute('wrap', [
    'class' => [
        'cms-eteam',
        'cms-eteam-'.$settings['layout'],
        'relative'
    ]
]);
// Grid Wrap
$wrap_styles = [
    '--cms-stroke-width:3;',
    '--cms-stroke-dash-length:1650px;'
];
$this->add_render_attribute('grid-wrap',[
    'class' => [
        'cms-eteam',
        'cms-eteam-'.$settings['layout'],
        'cms-team-grid',
        'd-flex gap-20',
        'flex-nowrap',
        'cms-scroll-sticky-horizontal-content',
        // tablet
        'flex-tablet-wrap',
        'flex-col-tablet-3 flex-col-mobile-extra-2',
        'flex-col-smobile-1',
        'gap-tablet-0 gutter-tablet-20'
    ],
    'style'      => $wrap_styles,
    'data-break' => 1024
]);
// team item Classes
$team_item_classes = [
    'cms-team-item'
];
// Team Item
$title_color = $this->get_setting('title_color', 'heading-regular');
$title_color_hover = $this->get_setting('title_color_hover', 'accent-regular');
$this->add_render_attribute('team-name',[
    'class' => [
        'team-heading m-tb-nxl',
        'heading text-xl',
        'text-'.$title_color,
        'text-hover-'.$title_color_hover
    ]
]);
$this->add_render_attribute('team-pos',[
    'class' => [
        'team-position text-md empty-none m-tb-nmd pt-10',
        'text-'.$this->get_setting('pos_color','body')
    ]
]);
$this->add_render_attribute('team-desc',[
    'class' => [
        'team-desc empty-none',
        'text-sm m-tb-nsm',
        'text-'.$this->get_setting('desc_color','body'),
        'pt-15'
    ]
]);
?>
<div class="cms-scroll-sticky-horizontal" data-breakpoint='1024'>
    <div <?php ctc_print_html( $this->get_render_attribute_string( 'heading-wrap' ) ); ?>>
        <div class="col-5 col-tablet-4 col-mobile-12">
            <div <?php ctc_print_html( $this->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php
                // Icon
                genzia_elementor_icon_render( $settings['smallheading_icon'], [], [ 'aria-hidden' => 'true', 'class' => $small_icon_classes, 'icon_size' => 12 ] );
                // Text
                echo nl2br( $settings['smallheading_text'] ); 
            ?></div>
        </div>
        <div class="col-7 col-tablet-8 col-mobile-12">
            <h2 <?php ctc_print_html( $this->get_render_attribute_string( 'heading_text' ) ); ?>><?php 
                echo nl2br( $settings['heading_text'] ); 
            ?></h2>
        </div>
    </div>
    <div class="d-flex gutter">
        <div class="col-5 col-tablet-2 col-mobile-12 cms-hidden-tablet"> </div>
        <div class="col-7 col-tablet-12">
            <div <?php ctc_print_html($this->get_render_attribute_string('grid-wrap')) ?>>
                <?php
                $count = 0;
                foreach ($teams as $key => $team) {
                    $count ++;
                    $item_key = $this->get_repeater_setting_key( 'item', 'cms_team', $key );
                    $this->add_render_attribute( $item_key,[
                        'class' => array_filter([
                            'cms-team-item',
                            'cms-hover-stroke-dasharray',
                            'cms-hover-change',
                            'elementor-invisible',
                            'cms-scroll-sticky-horizontal-item'
                        ]),
                        'data-settings' => json_encode([
                            'animation'       => 'fadeInUp',
                            'animation_delay' => $key*100
                        ])
                    ]);
                    // link
                    $link_key = $this->get_repeater_setting_key( 'link', 'cms_team', $key );
                    $this->add_render_attribute( $link_key, [
                        'class' => [
                            'team-name',
                            'd-block text-center',
                            'overflow-hidden'
                        ],
                        'href'       => genzia_elementor_link_url_render($this, $team, ['name' => 'link', 'echo' => false, 'suffix' => false]),
                        'aria-label' => $team['name']
                    ]);
                    $link_key2 = $this->get_repeater_setting_key( 'link2', 'cms_team', $key );
                    $this->add_render_attribute( $link_key2, [
                        'class'      => [
                            'team-name',
                            'text-'.$title_color,
                            'text-hover-'.$title_color_hover
                        ],
                        'href' => genzia_elementor_link_url_render($this, $team, ['name' => 'link', 'echo' => false, 'suffix' => false]),
                        'aria-label' => $team['name']
                    ]);
                    ob_start();
                    ?>
                        <div class="cms-team-socials cms-hover-show move-left bg-backdrop cms-radius-16 d-flex flex-column justify-content-center gap-16 cms-transition absolute top left mt-10 ml-10 p-16"><?php
                            for ($i = 1; $i <= 4; $i++) {
                                $social_icon = isset($team["social_icon_{$i}"]) ? $team["social_icon_{$i}"] : null;
                                $social_link = isset($team["social_link_{$i}"]) ? $team["social_link_{$i}"] : null;
                                if($social_icon && !empty($social_icon['value']) && $social_link){
                                    if ( ! empty( $social_link['url'] ) ) {
                                        $social_link_key = $this->get_repeater_setting_key( "social_link_{$i}", 'cms_team', $key );
                                        $this->add_link_attributes( $social_link_key, $social_link );
                                        $this->add_render_attribute( $social_link_key, 'class', 'team-social text-white text-hover-accent-regular lh-0' );
                                        ?>
                                            <a <?php ctc_print_html($this->get_render_attribute_string( $social_link_key )); ?>><?php 
                                                echo '<span class="screen-reader-text">'.esc_html($team['name']).'</span>';
                                                genzia_elementor_icon_render( $social_icon, [], [ 
                                                    'aria-hidden' => 'true', 
                                                    'class'       => 'cms-eicon d-inline-block', 
                                                    'icon_size'   => 20 
                                                ]); 
                                            ?></a>
                                        <?php
                                    }
                                }
                            }
                        ?></div>
                    <?php
                    $socials_html = ob_get_clean();
                    // Shape Icon
                    $shape_icon = genzia_svgs_icon([
                        'icon'       => 'team-shape',
                        'icon_class' => 'cms-stroke-dasharray absolute center text-accent-regular',
                        'icon_size'  => 232,
                        'echo'       => false
                    ]);
                    ?>
                    <div <?php ctc_print_html($this->get_render_attribute_string( $item_key )); ?>>
                        <div class="cms-team--item cms-hover-change hover-image-zoom-out cms-transition relative overflow-hidden min-w" style="--min-w:312px;">
                            <?php
                                $team['image_size'] = $this->get_setting('image_size');
                                $team['image_custom_dimension'] = $thumbnail_custom_dimension;
                                genzia_elementor_image_render($team,[
                                    'name'           => 'image',
                                    'image_size_key' => 'image',
                                    'img_class'      => 'cms-radius-16',
                                    'custom_size'    => $thumbnail_custom_dimension,
                                    'max_height'     => true,
                                    'before'         => '<div class="relative overflow-hidden cms-radius-16 mb-30">',
                                    'after'          => $socials_html.$shape_icon.'</div>'
                                ]);
                            ?>
                            <div <?php ctc_print_html($this->get_render_attribute_string('team-name')) ?>>
                                <a <?php ctc_print_html($this->get_render_attribute_string( $link_key2 )); ?>>
                                    <?php echo esc_html($team['name']); ?>
                                </a>
                            </div>
                            <div <?php ctc_print_html($this->get_render_attribute_string('team-pos')) ?>><?php 
                                ctc_print_html($team['position']); 
                            ?></div>
                            <div <?php ctc_print_html($this->get_render_attribute_string('team-desc')) ?>><?php 
                                ctc_print_html($team['description']); 
                            ?></div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>