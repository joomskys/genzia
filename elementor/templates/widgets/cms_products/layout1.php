<?php
$layout_type = 'grid';
$source      = $widget->get_setting('category', []);
$orderby     = $widget->get_setting('orderby', 'date');
$order       = $widget->get_setting('order', 'desc');
$limit       = $widget->get_setting('limit', 8);
extract(ctc_get_posts_of_grid('product', [
    'source'   => $source,
    'orderby'  => $orderby,
    'order'    => $order,
    'limit'    => $limit
]));
// Get category
$cat = [];
foreach ($source as $key => $category){
    $category_arr = explode('|', $category);
    $cat[] = $category_arr[0];
}
// Shortcode Attributes
$widget->add_render_attribute( 'options', [
    'class' => [
        'shortcode',
        'cms-products-'.$settings['layout']
    ],
    'limit'        => $limit,
    'columns'      => $widget->get_setting('col', 4),
    'orderby'      => $widget->get_setting('orderby','date'),
    'order'        => $widget->get_setting('order'),

    'visibility'   => $widget->get_setting('featured'),
    'on_sale'      => $widget->get_setting('on_sale'),
    'best_selling' => $widget->get_setting('best_selling'),
    'top_rated'    => $widget->get_setting('top_rated'),

    'paginate'     => $widget->get_setting('paginate')
]);
if(!empty($cat)) {
    $widget->add_render_attribute('options', [
        'category' => implode(',',$cat)
    ]);
}
if(!empty($widget->get_setting('products_ids', []))) {
    $widget->add_render_attribute('options', [
        'ids' => implode(',', $widget->get_setting('products_ids',[]))
    ]);
}
// Wrap attributes
$widget->add_render_attribute('wrap',[
    'id'              => $this->get_name() . '-' . $this->get_id(),
    'class'           => [
        'cms-eproducts', 
        'cms-eproducts-'.$settings['layout']
    ]
]);
?>
<div <?php ctc_print_html($widget->get_render_attribute_string('wrap')); ?>><?php
    echo do_shortcode('[products '.$widget->get_render_attribute_string( 'options' ).']');
?></div>