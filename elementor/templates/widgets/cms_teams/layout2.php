<?php
$teams       = $this->get_setting('teams', []);
$layout_mode = $this->get_setting('layout_mode', 'carousel');
// Arrows
$arrows = $this->get_setting('arrows');
$this->add_render_attribute('arrows', [
    'class' => [
        'cms-swiper-buttons d-flex gap-12 flex-auto',
        genzia_add_hidden_device_controls_render($settings, 'arrows_')
    ]
]);
$arrows_classes = [
    'cms-carousel-button',
    'cms-box-58 circle',
    'text-menu',
    'bg-transparent',
    'text-hover-white',
    'bg-hover-menu',
    'bdr-1 bdr-menu',
    'bdr-hover-menu'
];
$arrows_classes_prev = genzia_nice_class(array_merge(['cms-carousel-button-prev prev cms-hover-move-icon-left'],$arrows_classes));
$arrows_classes_next = genzia_nice_class(array_merge(['cms-carousel-button-next next cms-hover-move-icon-right'],$arrows_classes));
// Dots
$dots = $this->get_setting('dots');
$this->add_render_attribute('dots', [
    'class' => [
        'flex-basic gap-12',
        'cms-carousel-dots cms-carousel-dots-circle',
        ($arrows == 'yes') ? 'justify-content-end':'justify-content-center',
        genzia_add_hidden_device_controls_render($settings, 'dots_'),
    ],
    'style' => [
        '--cms-dots-color:var(--cms-menu);',
        '--cms-dots-hover-color:var(--cms-accent-regular);',
        '--cms-dots-hover-shadow:var(--cms-accent-regular);',
        '--cms-dots-opacity:0;',
        '--cms-dots-hover-opacity:1;'
    ]
]);
// Arrows Dots
$this->add_render_attribute('arrows-dots',[
    'class' => [
        'd-flex justify-content-between gap-32 empty-none',
        ($arrows=='yes') ? 'pt-40' : ''
    ]
]);
//
$thumbnail_custom_dimension = [
 'width'  => !empty($settings['image_custom_dimension']['width']) ? $settings['image_custom_dimension']['width'] : 384,
 'height' => !empty($settings['image_custom_dimension']['height']) ? $settings['image_custom_dimension']['height'] : 452
];
// wrap
$this->add_render_attribute('wrap', [
    'class' => [
        'cms-eteam',
        'cms-eteam-'.$settings['layout'],
        'relative'
    ]
]);
// Grid Wrap
$default_col = $this->get_setting('col', 3);
switch ($default_col) {
    case '6':
        $aligns = array('start','center','center', 'center', 'center', 'end');
        break;
    case '5':
        $aligns = array('start','center','center', 'center', 'end');
        break;
    case '4':
        $aligns = array('start','center','center', 'end');
        break;
    case '3':
        $aligns = array('start','center', 'end');
        break;
    case '2':
        $aligns = array('start', 'end');
        break;
    default:
        $aligns = array('center');
        break;
}
$wrap_styles = [
    '--gutter-x:32px;',
    '--gutter-y:64px;',
    '--cms-stroke-width:3;',
    '--cms-stroke-dash-length:1650px;'
];
$this->add_render_attribute('grid-wrap',[
    'class' => [
        'cms-eteam',
        'cms-eteam-'.$settings['layout'],
        'cms-team-grid',
        'd-flex justify-content-center',
        genzia_elementor_get_grid_columns($this, $settings, [
            'default' => $default_col,
            'tablet'  => 2,
            'gap'     => 'custom-x gutter-custom-y'
        ])
    ],
    'style' => $wrap_styles
]);
// Carousels
$this->add_render_attribute('carousel-wrap',[
    'class' => [
        'cms-eteam',
        'cms-eteam-'.$settings['layout'],
        'cms-carousel swiper'
    ],
    'style' => $wrap_styles
]);
// team item Classes
$team_item_classes = [
    'cms-team-item',
    ($settings['layout_mode'] === 'carousel') ? 'cms-swiper-item swiper-slide' : ''
];
// Team Item
$title_color = $this->get_setting('title_color', 'white');
$title_color_hover = $this->get_setting('title_color_hover', 'white');
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
        'text-'.$this->get_setting('pos_color','on-dark')
    ]
]);
$this->add_render_attribute('team-desc',[
    'class' => [
        'team-desc empty-none',
        'text-sm m-tb-nsm',
        'text-'.$this->get_setting('desc_color','on-dark'),
        'pt-15'
    ]
]);
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
if(!empty($settings['smallheading_text']) || !empty($settings['heading_text'])){
?>
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
<?php 
}
switch ($settings['layout_mode']) {
    case 'grid':
?>
    <div <?php ctc_print_html($this->get_render_attribute_string('grid-wrap')) ?>>
<?php
        break;
    default:
?>
    <div <?php ctc_print_html($this->get_render_attribute_string('carousel-wrap')) ?>>
        <div class="<?php genzia_swiper_wrapper_class($this); ?>">
<?php
        break;
} ?>
    <?php
    $count = 0;
    foreach ($teams as $key => $team) {
        $count ++;
        $item_key = $this->get_repeater_setting_key( 'item', 'cms_team', $key );
        $this->add_render_attribute( $item_key,[
            'class' => array_filter([
                'cms-team-item',
                ($settings['layout_mode'] === 'carousel') ? 'cms-swiper-item swiper-slide' : '',
                'd-flex',
                //'justify-content-'.$aligns[$key % $default_col],
                (in_array($count, [3,4,7,8,11,12,15,16])) ? 'justify-content-end' : '',
                'justify-content-tablet-extra-center',
                'cms-hover-stroke-dasharray',
                'cms-hover-change'
            ]),
            'style' => [
                '--cms-stroke-dasharray:1650px;'
            ]
        ]);
        if($settings['layout_mode'] == 'grid'){
            $this->add_render_attribute($item_key, [
                'class'         => 'elementor-invisible',
                'data-settings' => json_encode([
                    'animation'       => 'fadeInUp',
                    'animation_delay' => $key*100
                ])
            ]);
        }

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
                'text-hover-'.$title_color_hover,
                'cms-hover-underline'
            ],
            'href'       => genzia_elementor_link_url_render($this, $team, ['name' => 'link', 'echo' => false, 'suffix' => false]),
            'aria-label' => $team['name']
        ]);
        ob_start();
        ?>
            <div class="cms-team-socials cms-hover-show move-left d-flex gap-16 cms-transition pb-33"><?php
                for ($i = 1; $i <= 4; $i++) {
                    $social_icon = isset($team["social_icon_{$i}"]) ? $team["social_icon_{$i}"] : null;
                    $social_link = isset($team["social_link_{$i}"]) ? $team["social_link_{$i}"] : null;
                    if($social_icon && !empty($social_icon['value']) && $social_link){
                        if ( ! empty( $social_link['url'] ) ) {
                            $social_link_key = $this->get_repeater_setting_key( "social_link_{$i}", 'cms_team', $key );
                            $this->add_link_attributes( $social_link_key, $social_link );
                            $this->add_render_attribute( $social_link_key, 'class', 'team-social text-white text-hover-white cms-hover-zoomout lh-0' );
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
        ?>
        <div <?php ctc_print_html($this->get_render_attribute_string( $item_key )); ?>>
            <div class="cms-team--item cms-hover-change hover-image-zoom-out cms-transition relative overflow-hidden cms-radius-16">
                <?php
                    $team['image_size'] = $this->get_setting('image_size');
                    $team['image_custom_dimension'] = $thumbnail_custom_dimension;
                    genzia_elementor_image_render($team,[
                        'name'           => 'image',
                        'image_size_key' => 'image',
                        'img_class'      => 'cms-radius-16',
                        'custom_size'    => $thumbnail_custom_dimension,
                        'max_height'     => true,
                        'before'         => '',
                        'after'          => ''
                    ]);
                ?>
                <div class="cms-overlay cms-gradient-render cms-gradient-6 cms-hover-gradient-7 d-flex align-items-end">
                    <div class="cms-team-info p-32 p-lr-smobile-20">
                        <?php printf('%s',$socials_html); ?>
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
            </div>
        </div>
        <?php
    }
    ?>
<?php switch ($settings['layout_mode']) {
    case 'grid':
    // close .cms-grid
?>
    </div>
<?php
        break;
    default:
    // close .cms-carouse .swiper-wrapper
?>
        </div>
    </div>
    <div <?php ctc_print_html($this->get_render_attribute_string('arrows-dots')); ?>><?php
        // Arrows
        if ($arrows == 'yes'){ ?>
            <div <?php ctc_print_html($this->get_render_attribute_string('arrows')); ?>><?php 
                genzia_svgs_icon([
                    'icon'      => 'arrow-left',
                    'icon_size' => 12,
                    'class'     => $arrows_classes_prev,
                    'tag'       => 'div'
                ]);
                genzia_svgs_icon([
                    'icon'      => 'arrow-right',
                    'icon_size' => 12,
                    'class'     => $arrows_classes_next,
                    'tag'       => 'div'
                ]);
            ?></div>
        <?php }
        // Dots
       if ($dots == 'yes') { ?>
            <div <?php ctc_print_html($this->get_render_attribute_string('dots')); ?>></div>
        <?php }
    ?></div>
<?php
        break;
} ?>