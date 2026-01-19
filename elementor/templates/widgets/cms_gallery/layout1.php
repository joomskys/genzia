<?php 
$randGallery = $this->get_setting('gallery', []);
$gallery_show = $this->get_setting('gallery_show', 6);
$gallery_loadmore_show = $this->get_setting('gallery_loadmore_show', 3);
if ($settings['gallery_rand'] == 'rand'){
    shuffle($randGallery);
}
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['gallery_custom_dimension']['width']) ? $settings['gallery_custom_dimension']['width'] : 768,
    'height' => !empty($settings['gallery_custom_dimension']['height']) ? $settings['gallery_custom_dimension']['height'] : 768
];
// Wrap
$this->add_render_attribute('wrap',[
    'class' => array_filter([
        'cms-egallery',
        'cms-egallery-'.$settings['layout'],
    ]),
    'data-show'     => $gallery_show,
    'data-loadmore' => $gallery_loadmore_show
]);
if($settings['open_lightbox'] === 'yes'){
    $this->add_render_attribute('wrap',[
        'class' => 'cms-egallery-lightbox'
    ]);
}
// Wrap Inner
$this->add_render_attribute('wrap-inner', [
    'class' => [
        'cms-images-light-box',
        'd-flex gutter-mobile-20',
        genzia_elementor_get_grid_columns($widget, $settings, [
            'default' => 3,
            'tablet'  => 2,
            'gap'     => 32 
        ])
    ]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
    <div <?php ctc_print_html($this->get_render_attribute_string('wrap-inner')); ?>>
        <?php
        foreach ( $randGallery as $key => $value):
            $value['gallery_size'] = $this->get_setting('gallery_size','custom');
        	$value['gallery_custom_dimension'] = $thumbnail_custom_dimension;
        	$value['gallery'] = $value;
            if(wp_get_attachment_caption($value['id'])!= false){
                $img_caption_text = wp_get_attachment_caption($value['id']);
            } else {
                $img_caption_text = get_the_title($value['id']);
            }
            $img_caption = '<div class="absolute center"><div class="caption bg-white cms-heading text-20 p-tb-10 p-lr-20 cms-hover-show move-up cms-transition z-top2 cms-radius-8">'.$img_caption_text.'</div></div>';
            // Gallery Item
            $item_key =  $this->get_repeater_setting_key('gallery-item', 'cms_gallery', $key);
            $this->add_render_attribute($item_key, [
                'class' => [
                    'cms-gallery-item',
                    'elementor-invisible',
                    ($key < $gallery_show) ? 'd-block' : 'd-none'
                ],
                'data-settings' => wp_json_encode([
                    'animation' => 'fadeInUp'
                ])
            ]);
            //
            $open_lightbox = $this->get_repeater_setting_key('open-lightbox', 'cms_gallery', $key);
            $this->add_render_attribute($open_lightbox, [
                'class' => [
                    'absolute',
                    ($settings['show_caption'] == 'yes') ? 'top-right mt-20 mr-20' : 'center'
                ]
            ]);
            $open_lightbox_inner = $this->get_repeater_setting_key('open--lightbox', 'cms_gallery', $key);
            $this->add_render_attribute($open_lightbox_inner, [
                'class' => [
                    'cms-icon cms-transition z-top',
                    'lh-0 cms-box-90 circle',
                    'bg-white text-menu bg-hover-accent-regular text-hover-white',
                    'cms-hover-show zoom-in'
                ]
            ]);
            ?>
            <div <?php ctc_print_html($this->get_render_attribute_string($item_key)); ?>>
                <div class="cms-hover-change relative">
                    <?php if($settings['open_lightbox'] === 'yes'){ ?>
                        <a data-elementor-lightbox-slideshow="<?php echo esc_attr($this->get_id());?>" class="grid-item-inner cms-galleries-light-box relative d-flex overflow-hidden" href="<?php echo esc_url(wp_get_attachment_image_url($value['id'], 'full')); ?>" title="<?php echo esc_attr(wp_get_attachment_caption($value['id']))?>">
                    <?php 
                    }
                        genzia_elementor_image_render($value,[
                            'name'        => 'gallery',
                            //'size'      => '',  
                            'img_class'   => 'img-cover',
                            'custom_size' => $thumbnail_custom_dimension
    					]);
                    if($settings['open_lightbox'] === 'yes'){ ?>
                            <span <?php ctc_print_html($this->get_render_attribute_string($open_lightbox)) ?>>
                                <span <?php ctc_print_html($this->get_render_attribute_string($open_lightbox_inner)) ?>>
                                    <?php 
                                        genzia_svgs_icon([
                                            'icon'      => 'plus',
                                            'icon_size' => 14
                                        ]);
                                    ?>
                                </span>
                            </span>
                        </a>
                    <?php } 
                        if($settings['show_caption'] == 'yes') printf('%s', $img_caption);
                    ?>
                </div>
            </div>
        <?php
        endforeach;
        ?>
    </div>
    <?php if(count($randGallery) > $this->get_setting('gallery_show', '6')): ?>
        <div class="text-center pt-40">
            <a href="#" class="cms-gallery-load cms-btn btn-outline-menu text-menu btn-hover-menu text-hover-white cms-hover-move-icon-right"><?php ctc_print_html($this->get_setting('load_more_text', 'Load More'));
                //
                genzia_svgs_icon([
                    'icon'      => 'arrow-right',
                    'icon_size' => 10
                ]);
            ?></a>
        </div>
    <?php endif; ?>
</div>