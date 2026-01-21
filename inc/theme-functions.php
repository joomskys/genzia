<?php 
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

function genzia_nice_class($classes = []){
    $classes = (array) $classes;
    if(empty($classes)) return;
    return implode(' ', array_unique(array_filter($classes)));
}
/**
 * Create the rating interface.
 * 
 * 
*/
if(!function_exists('genzia_comment_rating_fields')){
    function genzia_comment_rating_fields ($args =[]) {
        $args = wp_parse_args($args, [
            'echo'  => true,
            'class' => ''
        ]);
        $show_rating = genzia_get_opts('post_comments_rating_on', '0', 'on');
        if('1' != $show_rating || !is_singular('post')) return;
        ob_start();
    ?>
        <div class="cms-comment-form-rating cms-comment-form-fields-wrap <?php echo esc_attr($args['class']); ?>">
            <div  class="comment-form-field">
                <?php echo esc_html__('Your Rating','genzia');?><span class="required text-red">*</span>
            </div>
            <div class="comment-form-field comments-rating">
                <span class="rating-container stars">
                    <?php for ( $i = 5; $i >= 1; $i-- ) : ?>
                        <input type="radio" id="rating-<?php echo esc_attr($i);?>" class="star-<?php echo esc_attr($i);?>" name="rating" value="<?php echo esc_attr($i);?>" />
                        <label for="rating-<?php echo esc_attr($i);?>"><span class="d-none"><?php echo esc_html($i);?></span></label>
                    <?php endfor; ?>
                    <input type="radio" id="rating-0" class="star-cb-clear star-0" name="rating" value="0" /><label for="rating-0"><span class="d-none">0</span></label>
                </span>
                </div>
            </div>
        <?php
        if($args['echo']){
            printf('%s', ob_get_clean() );
        } else {
            return ob_get_clean();
        }
    }
}
if(!function_exists('genzia_woocommerce_comment_rating_fields')){
    function genzia_woocommerce_comment_rating_fields($args =[]){
        $args = wp_parse_args($args, [
            'echo' => true,
            'class' => ''
        ]);
        $rating = '';
        if(!function_exists('wc_review_ratings_enabled')) return;
        if (wc_review_ratings_enabled() && is_singular('product') ) {
            $rating .= '<div class="cms-comment-form-rating cms-comment-form-fields-wrap '.esc_attr($args['class']).'">';
                $rating .= '<div class="comment-form-field">' . esc_html__( 'Your rating', 'genzia' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required text-red">*</span>' : '' ) . '</div>';
                $rating .= '<div class="comment-form-field comments-rating">';
                    $rating .= '<select name="rating" id="rating" required>
                        <option value="">' . esc_html__( 'Rate&hellip;', 'genzia' ) . '</option>
                        <option value="5">' . esc_html__( 'Perfect', 'genzia' ) . '</option>
                        <option value="4">' . esc_html__( 'Good', 'genzia' ) . '</option>
                        <option value="3">' . esc_html__( 'Average', 'genzia' ) . '</option>
                        <option value="2">' . esc_html__( 'Not that bad', 'genzia' ) . '</option>
                        <option value="1">' . esc_html__( 'Very poor', 'genzia' ) . '</option>
                    </select>';
                $rating .= '</div>';
            $rating .= '</div>';
        }
        if($args['echo']){
            printf('%s', $rating);
        } else {
            return $rating;
        }
    }
}
// add rating to after comment form fields
add_filter('comment_form_fields', 'genzia_comment_rating_default_fields' );
if(!function_exists('genzia_comment_rating_default_fields')){
    function genzia_comment_rating_default_fields ($fields) {
        //$fields_rating = [];
        ob_start();
            genzia_comment_rating_fields();
            genzia_woocommerce_comment_rating_fields();
        $rating = ob_get_clean();
        //$fields_rating['rating'] = ob_get_clean();
        //$fields = array_merge($fields_rating, $fields);
        $fields['comment'] = $rating.$fields['comment'];
        return $fields;
    }
}

//Save the new meta added by theme  submitted by the user.
add_action( 'comment_post', 'genzia_comment_rating_save_comment_meta' );
if(!function_exists('genzia_comment_rating_save_comment_meta')){
    function genzia_comment_rating_save_comment_meta( $comment_id ) {
        $rating = $address = '';
        // rating
        if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) )
        $rating = intval( $_POST['rating'] );
        // address
        if ( ( isset( $_POST['address'] ) ) && ( '' !== $_POST['address'] ) )
        $address = sanitize_text_field($_POST['address']);
        add_comment_meta( $comment_id, 'rating', $rating );
        add_comment_meta( $comment_id, 'address', $address );
    }
}
// Make the rating required.
add_filter( 'preprocess_comment', 'genzia_comment_rating_require_rating' );
if(!function_exists('genzia_comment_rating_require_rating')){
    
    function genzia_comment_rating_require_rating( $commentdata ) {
        $show_rating = genzia_get_opt('post_comments_rating_on','0');
        if('1' !== $show_rating) return $commentdata;

        if ( ! is_admin() && ( ! isset( $_POST['rating'] ) || 0 === intval( $_POST['rating'] ) ) )
        wp_die( esc_html__( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.','genzia' ) );
        return $commentdata;
    }
}

//Display the rating on a submitted comment.
if(!function_exists('genzia_comment_rating_display_rating')){
    //add_filter( 'comment_text', 'genzia_comment_rating_display_rating');
    function genzia_comment_rating_display_rating( $comment_text ){
        if ( $rating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
            $stars = '<div class="stars">';
            for ( $i = 1; $i <= $rating; $i++ ) {
                $stars .= '<span class="rating-icon cms-rating-icon-filled"></span>';
            }
            $stars .= '</div>';
            $comment_text = $comment_text . $stars;
            return $comment_text;
        } else {
            return $comment_text;
        }
    }
}

//Get the average rating of a post.
if(!function_exists('genzia_comment_rating_get_average_ratings')){
    function genzia_comment_rating_get_average_ratings( $id ) {
        $comments = get_approved_comments( $id );
        if ( $comments ) {
            $i = 0;
            $total = 0;
            foreach( $comments as $comment ){
                $rate = get_comment_meta( $comment->comment_ID, 'rating', true );
                if( isset( $rate ) && '' !== $rate ) {
                    $i++;
                    $total += $rate;
                }
            }

            if ( 0 === $i ) {
                return false;
            } else {
                return round( $total / $i, 1 );
            }
        } else {
            return false;
        }
    }
}
// Display the star average rating only
if(!function_exists('genzia_comment_rating_display_average')){
    function genzia_comment_rating_display_average($args = []) {

        global $post;

        if ( false === genzia_comment_rating_get_average_ratings( $post->ID ) ) {
            return false;
        }
        $args = wp_parse_args($args, [
            'width' => 20,
            'class' => ''
        ]);
        $stars   = '';
        $average = genzia_comment_rating_get_average_ratings( $post->ID );

        for ( $i = 1; $i <= $average + 1; $i++ ) {
            
            $width = intval( $i - $average > 0 ? $args['width'] - ( ( $i - $average ) * $args['width'] ) : $args['width'] );

            if ( 0 === $width ) {
                continue;
            }
            $stars .= '<span style="overflow:hidden; width:' . $width . 'px" class="rating-icon cms-rating-icon-filled"></span>';

            if ( $i - $average > 0 ) {
                $stars .= '<span style="overflow:hidden; position:relative; left:-' . ($width - 1) .'px;" class="cms-rating-icon cms-rating-icon-empty"></span>';
            }
        }
        $classes = ['cms-average-rating cms-average-rating-star', $args['class']];
        $custom_content  = '<div class="'.implode(' ', $classes).'">' . $stars .'</div>';
        return $custom_content;
    }
}

//Display the average rating above the content.
if(!function_exists('genzia_comment_rating_display_average_rating')){
    //add_filter( 'the_content', 'genzia_comment_rating_display_average_rating' );
    function genzia_comment_rating_display_average_rating( $content ) {

        global $post;

        if ( false === genzia_comment_rating_get_average_ratings( $post->ID ) ) {
            return $content;
        }
        
        $stars   = '';
        $average = genzia_comment_rating_get_average_ratings( $post->ID );

        for ( $i = 1; $i <= $average + 1; $i++ ) {
            
            $width = intval( $i - $average > 0 ? 20 - ( ( $i - $average ) * 20 ) : 20 );

            if ( 0 === $width ) {
                continue;
            }

            $stars .= '<span style="overflow:hidden; width:' . $width . 'px" class="rating-icon cms-rating-icon-filled"></span>';

            if ( $i - $average > 0 ) {
                $stars .= '<span style="overflow:hidden; position:relative; left:-' . $width .'px;" class="rating-icon cms-rating-icon-empty"></span>';
            }
        }
        
        $custom_content  = '<div class="average-rating">This post\'s average rating is: ' . $average .' ' . $stars .'</div>';
        $custom_content .= $content;
        return $custom_content;
    }
}
if(!function_exists('genzia_comment_rating_display_feedback')){
    function genzia_comment_rating_display_feedback($args=[]){
        $args = wp_parse_args($args,[
            'id'        => get_the_ID(),
            'mode'      => 'good', //bad
            'good_text' => esc_html__('positive feedback', 'genzia'),
            'bad_text'  => esc_html__('negative feedback', 'genzia'),
            'good_icon' => 'icofont-simple-smile',
            'bad_icon'  => 'icofont-sad'
        ]);
        $comments = get_approved_comments( $args['id'] );
        if ( $comments ) {
            $i = 0;
            $total = 0;
            $good_rate = $bad_rate = 0;
            foreach( $comments as $comment ){
                $rate = get_comment_meta( $comment->comment_ID, 'rating', true );
                if( isset( $rate ) && '' !== $rate ) {
                    $i++;
                    $total += $rate;
                }
                if(isset($rate) && $rate > 3){
                    $good_rate ++;
                }
                if(isset($rate) && $rate <= 3){
                    $bad_rate ++;
                }
            }

            if ( 0 === $i ) {
                return false;
            } else {
                //return  $total .' good:'.$good_rate.' bad:'.$bad_rate ;
                if($args['mode'] == 'good'){
                    return '<span class="cms-rating-good text-accent text-17 '.$args['good_icon'].'"></span> <span class="cms-rating-percent text-accent font-700">'.number_format_i18n( $good_rate*100 / $i, 2 ).'%</span> '.$args['good_text'];
                } else {
                    return '<span class="cms-rating-bad text-accent text-17 '.$args['bad_icon'].'"></span> <span class="cms-rating-percent text-accent font-700">'.number_format_i18n( $bad_rate*100 / $i, 2 ).'%</span> '.$args['bad_text'];
                }
            }
        } else {
            return false;
        }
    }
}
// Display the address on a submitted comment.
if(!function_exists('genzia_comment_display_address')){
    //add_filter( 'comment_text', 'genzia_comment_rating_display_rating');
    function genzia_comment_display_address(){
        $address =  get_comment_meta( get_comment_ID(), 'address', true ) ;
        if(empty($address)) return;
        ?>
            <div class="cms-comment-address"><?php echo esc_html($address); ?></div>
        <?php
    }
}
/**
 * Elementor Gradient Options
 * */
if(!function_exists('genzia_elementor_gradient_opts')){
    function genzia_elementor_gradient_opts(){
        return array(
            ''     => esc_html__('Default', 'genzia' ),
            '1'    => esc_html__('Gradient #1', 'genzia' ),
            '2'    => esc_html__('Gradient #2', 'genzia' ),
            '3'    => esc_html__('Gradient #3', 'genzia' ),
            '4'    => esc_html__('Gradient #4', 'genzia' ),
            '5'    => esc_html__('Gradient #5', 'genzia' ),
            'none' => esc_html__('None','genzia')
        );
    }
}
/**
 * Custom Elementor
 * Elementor Container
 * 
 * */
if(!function_exists('genzia_custom_container_register_controls')){
    add_action('etc-custom-container-register-controls', 'genzia_custom_container_register_controls');
    function genzia_custom_container_register_controls($container){
        // Custom
        $container->start_controls_section(
            'genzia_container_custom',
            [
                'label' => esc_html__( 'Genzia Custom', 'genzia' ),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            ]
        );  
            $container->add_control(
                'container_width',
                [
                    'label'   => esc_html__( 'Container Width', 'genzia' ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''                 => esc_html__( 'Default', 'genzia' ),
                        'boxed'            => esc_html__( 'Boxed', 'genzia' ),
                        'boxed-full-left'  => esc_html__( 'Boxed Full Left', 'genzia' ),
                        'boxed-full-right' => esc_html__( 'Boxed Full Right', 'genzia' )
                    ],
                    'default'      => '',
                    'prefix_class' => 'cms-econ-',
                    'hide_in_inner' => true
                ]
            );
            $container->add_control(
                'container_space',
                [
                    'label'   => esc_html__( 'Container Space', 'genzia' ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''                 => esc_html__( 'Default', 'genzia' ),
                        'nospace'          => esc_html__( 'No Space', 'genzia' ),
                        'small-space'      => esc_html__( 'Small Space', 'genzia' ).' (20)',
                        'space-header-top' => esc_html__( 'Header Top', 'genzia' ),
                    ],
                    'default' => '',
                    'prefix_class' => 'cms-econ-',
                    'hide_in_inner' => true
                ]
            );
            // Container Gradient
            $container->add_control(
                'container_gradient',
                [
                    'label'              => esc_html__( 'Container Gradient', 'genzia' ),
                    'type'               => Controls_Manager::SELECT,
                    'default'            => '',
                    'options'            => genzia_elementor_gradient_opts(),
                    'frontend_available' => true,
                    'hide_in_inner' => true
                ]
            );
            // Content Width
            $container->add_control(
                'content_width_full_custom',
                [
                    'label'   => esc_html__( 'Content Width (Full)', 'genzia' ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''                 => esc_html__( 'Default', 'genzia' ),
                        'boxed-wide'       => esc_html__( 'Boxed Wide', 'genzia' ),
                        'full-space-start' => esc_html__( 'Full Width - Space Start', 'genzia' ),
                        'full-space-end'   => esc_html__( 'Full Width - Space End', 'genzia' ),
                        'full-header-left' => esc_html__( 'Full Width - Header Left', 'genzia' )
                    ],
                    'default'            => '',
                    'render_type'        => 'template',
                    'prefix_class'       => 'e-con-',
                    'editor_available'   => true,
                    'condition'          => [
                        'content_width' => [
                            'full'
                        ]
                    ],
                    'hide_in_inner' => true,
                    'separator'     => 'before',
                    'classes'       => 'cms-eseparator' 
                ]
            );
            // Container Background Attachment
            $container->add_control(
                'container_bg_attachment',
                [
                    'label'         => esc_html__( 'Container background attachment fixed?', 'genzia' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__('On', 'genzia'),
                    'label_off'     => esc_html__('Off', 'genzia'),
                    'default'       => 'fixed',
                    'return_value'  => 'fixed',
                    'hide_in_inner' => true,
                    'prefix_class'  => 'cms-bg-'
                ]
            );
        $container->end_controls_section();
    }
}
/**
 * Add custom CSS Class to Container
 * @hook Action:  elementor/frontend/{$element_type}/before_render 
 * 
 * */
add_action( 'elementor/frontend/container/before_render', 'genzia_elementor_custom_container_class' ); 
function genzia_elementor_custom_container_class( $widget ) { 
    $settings = $widget->get_settings_for_display();
    //
    // if( in_array( $widget->get_name(), ['container']) && '' !== $settings['draw_svg']['id']){ 
    //     $widget->add_render_attribute( '_wrapper', [ 'class' => [ 'cms-econdrawsvg relative' ] ] ); 
    // }
}
/**
 * Add custom HTML to Elementor Container
 * in Elementor Editor
 * 
 * */
add_filter('etc-custom-container/before-elementor-editor-container-inner','genzia_before_elementor_editor_container_inner');
if(!function_exists('genzia_before_elementor_editor_container_inner')){
    function genzia_before_elementor_editor_container_inner(){
    ?>
        <# if('' !== settings.container_gradient) { #>
            <div class="cms-gradient-wrap cms-overlay">
                <div class="cms-sticky cms-gradient-render cms-econ-gradient cms-gradient-{{settings.container_gradient}} h-100" style="max-height: 100vh;"></div>
            </div>
        <# } #>
    <?php
    }
}
/**
 * Add custom HTML to Elementor Container
 * in Elementor FrontEnd
 * 
 * */
add_filter('etc-custom-container/before-elementor-container-inner', 'genzia_before_elementor_container_inner', 10, 2);
if(!function_exists('genzia_before_elementor_container_inner')){
    function genzia_before_elementor_container_inner($html, $settings){
        // Gradient Overlay
        if( isset($settings['container_gradient']) && ('none' !== $settings['container_gradient'] && '' !== $settings['container_gradient']) ) {
            echo '<div class="cms-gradient-wrap cms-overlay"><div class="cms-sticky cms-gradient-render cms-econ-gradient cms-gradient-'.$settings['container_gradient'].' h-100" style="max-height: 100vh;"></div></div>';
        }
        //
        return $html;
    }
}
/**
 * Custom Elementor
 * Elementor Shapes
 * 
 * */
add_filter('elementor/shapes/additional_shapes', 'genzia_additional_shapes');
function genzia_additional_shapes(){
    $shapes = [
        'cms-shape-top' => [
            'title'        => esc_html__( 'CMS Shape Top', 'genzia' ),
            'url'          => get_template_directory_uri() . '/assets/shapes/cms-shape-top.svg',
            'path'         => get_template_directory() . '/assets/shapes/cms-shape-top.svg',
            'has_flip'     => true,
            'has_negative' => false,
            //'color'      => false 
            'height_only'  => true
        ],
        'cms-shape-bottom' => [
            'title'        => esc_html__( 'CMS Shape Bottom', 'genzia' ),
            'url'          => get_template_directory_uri() . '/assets/shapes/cms-shape-bottom.svg',
            'path'         => get_template_directory() . '/assets/shapes/cms-shape-bottom.svg',
            'has_flip'     => true,
            'has_negative' => false,
            //'color'      => false 
            'height_only'  => true
        ],
        'cms-shape-top-2' => [
            'title'        => esc_html__( 'CMS Shape Top #2', 'genzia' ),
            'url'          => get_template_directory_uri() . '/assets/shapes/cms-shape-top-2.svg',
            'path'         => get_template_directory() . '/assets/shapes/cms-shape-top-2.svg',
            'has_flip'     => true,
            'has_negative' => false,
            //'color'      => false 
            'height_only'  => true
        ],
        'cms-shape-bottom-2' => [
            'title'        => esc_html__( 'CMS Shape Bottom #2', 'genzia' ),
            'url'          => get_template_directory_uri() . '/assets/shapes/cms-shape-bottom-2.svg',
            'path'         => get_template_directory() . '/assets/shapes/cms-shape-bottom-2.svg',
            'has_flip'     => true,
            'has_negative' => false,
            //'color'      => false 
            'height_only'  => true
        ],
        'cms-shape-top-3' => [
            'title'        => esc_html__( 'CMS Shape Top #3', 'genzia' ),
            'url'          => get_template_directory_uri() . '/assets/shapes/cms-shape-top-3.svg',
            'path'         => get_template_directory() . '/assets/shapes/cms-shape-top-3.svg',
            'has_flip'     => true,
            'has_negative' => false,
            //'color'      => false 
            'height_only'  => true
        ],
        'cms-shape-bottom-3' => [
            'title'        => esc_html__( 'CMS Shape Bottom #3', 'genzia' ),
            'url'          => get_template_directory_uri() . '/assets/shapes/cms-shape-bottom-3.svg',
            'path'         => get_template_directory() . '/assets/shapes/cms-shape-bottom-3.svg',
            'has_flip'     => true,
            'has_negative' => false,
            //'color'      => false 
            'height_only'  => true
        ],
        'cms-shape-top-4' => [
            'title'        => esc_html__( 'CMS Shape Top #4', 'genzia' ),
            'url'          => get_template_directory_uri() . '/assets/shapes/cms-shape-top-4.svg',
            'path'         => get_template_directory() . '/assets/shapes/cms-shape-top-4.svg',
            'has_flip'     => true,
            'has_negative' => false,
            //'color'      => false 
            'height_only'  => true
        ],
        'cms-shape-bottom-4' => [
            'title'        => esc_html__( 'CMS Shape Bottom #4', 'genzia' ),
            'url'          => get_template_directory_uri() . '/assets/shapes/cms-shape-bottom-4.svg',
            'path'         => get_template_directory() . '/assets/shapes/cms-shape-bottom-4.svg',
            'has_flip'     => true,
            'has_negative' => false,
            //'color'      => false 
            'height_only'  => true
        ]
    ];
    return $shapes;
}

/**
 *  Filter add svg icon to image content
 * 
*/
add_filter('elementor/extended_allowed_html_tags/image', function () {
    $image = \Elementor\Utils::EXTENDED_ALLOWED_HTML_TAGS['image'];
    $svg = \Elementor\Utils::EXTENDED_ALLOWED_HTML_TAGS['svg'];
    return array_merge($image, $svg);
});
// Change html tag for Elementor image render
add_filter('elementor/image_size/get_attachment_image_html','genzia_elementor_image_size_get_attachment_image_html', 10, 4);
if(!function_exists('genzia_elementor_image_size_get_attachment_image_html')){
    function genzia_elementor_image_size_get_attachment_image_html($html, $settings, $image_size_key, $image_key){
        // Check variation for custom
        $settings['attachment_id'] = isset($settings['attachment_id']) ? $settings['attachment_id'] : '';
        $settings['as_background'] = isset($settings['as_background']) ? $settings['as_background'] : false;
        if($settings['as_background'] === true) $settings['as_background'] = 'yes';
        $settings['as_background_class'] = isset($settings['as_background_class']) ? $settings['as_background_class'] : '';
        $settings['max_height'] = isset($settings['max_height']) ? $settings['max_height'] : false;
        $settings['min_height'] = isset($settings['min_height']) ? $settings['min_height'] : false;
        $settings['duration'] = isset($settings['duration']) ? $settings['duration'] : '';
        $settings['attrs'] = isset($settings['attrs']) ? $settings['attrs'] : [];

        //
        if ( ! $image_key ) {
            $image_key = $image_size_key;
        }
        $image = $settings[ $image_key ];
        if ( ! isset($settings[ $image_size_key . '_size' ]) || empty($settings[ $image_size_key . '_size' ]) ) {
            $settings[ $image_size_key . '_size' ] = $settings['size'];
        }

        $size          = $settings[ $image_size_key . '_size' ];
        $image_class   = $overlay_class = ['cms-lazy lazy-loading'];
        $image_class[] = isset($settings['img_class']) ? $settings['img_class'] : '';
        $image_class[] = ! empty( $settings['hover_animation'] ) ? 'elementor-animation-' . $settings['hover_animation'] : '';
        $image_class   = implode(' ', array_filter($image_class));
        $overlay_class = implode(' ', array_filter($overlay_class));
        $html = '';
        // If is the new version - with image size.
        $image_sizes = get_intermediate_image_sizes();
        $image_sizes[] = 'full';

        if ( ! empty( $image['id'] ) && ! wp_attachment_is_image( $image['id'] ) ) {
            $image['id'] = '';
        }
        $is_static_render_mode = \Elementor\Plugin::$instance->frontend->is_static_render_mode();
        // On static mode don't use WP responsive images.
        if ( ! empty($image['id']) ) {
            $image_bg = wp_get_attachment_image_src( $image['id'], 'full');
        } else {
            $image_bg = [Utils::get_placeholder_image_src()];
        }

        // custom attrs class
        if(isset($settings['attrs']['class'])){
            $image_class .= ' '.$settings['attrs']['class'];
            unset($settings['attrs']['class']);
        }
        // overlay background
        if($settings['as_background'] == 'overlay'){
            $settings['min_height'] = true;
            $overlay_class .= ' relative '.$settings['img_class'];
            $image_class .= ' cms-overlay img-cover';
        }
        // as background
        if($settings['as_background'] == 'yes' ){
            $overlay_class .= ' cms-bg-cover '.$settings['as_background_class'];
        }
        // Render
        if ( ! empty( $image['id'] ) && in_array( $size, $image_sizes ) && ! $is_static_render_mode ) {
            // image attributes
            $image_attr = wp_get_attachment_image_src( $image['id'], $size);
            $image_attr['style'] = $image_overlay_style = '';
            // if have max-height style
            if($settings['max_height']){
                $image_attr['style'] .= 'max-height:'.$image_attr[2].'px;';
                $image_overlay_style .= 'max-height:'.$image_attr[2].'px;';
            }
            if($settings['min_height']){
                $image_attr['style'] .= 'min-height:'.$image_attr[2].'px;';
                $image_overlay_style .= 'min-height:'.$image_attr[2].'px;';
            }
            // As background style
            if($settings['as_background']){
                $image_attr['style'] .= '--cms-bg-lazyload:url('.$image_bg[0].');background-image:var(--cms-bg-lazyload-loaded);';
                if($settings['aspect_ratio']){
                    $image_attr['style'] .= 'aspect-ratio:'.$image_attr[1].'/'.$image_attr[2].';';
                }
            }
            // As Background Fix 
            $as_backgound_fix = '<div style="aspect-ratio:'.$image_attr[1].'/'.$image_attr[2].';max-width:'.$image_attr[1].'px; max-height:'.$image_attr[2].'px;"></div>';
            // image html
            $image_html_attrs = [ 'class'=> $image_class];
            if(!empty($settings['duration'])) $image_html_attrs['data-duration'] =  $settings['duration'];
            $image_html_attrs['style'] = isset($settings['attrs']['style']) ? $image_attr['style'].$settings['attrs']['style'] : $image_attr['style'];

            // custom attrs
            foreach ($settings['attrs'] as $key => $value) {
                $image_html_attrs[$key] = $value;
            }

            $image_html = wp_get_attachment_image( $image['id'], $size, false, $image_html_attrs);
            switch ($settings['as_background']) {
                case 'overlay':
                        $html = sprintf(
                            '<div class="%s" style="%s" data-as-background="%s">%s%s</div>',
                            $overlay_class,
                            $image_overlay_style,
                            $settings['as_background'],
                            $image_html,
                            $settings['content']
                        );
                        break;
                case 'yes' :
                    $html = sprintf(
                        '<div class="%s" style="%s" data-as-background="%s">%s%s</div>',
                        $overlay_class,
                        $image_attr['style'],
                        $settings['as_background'],
                        empty($settings['content']) ? $as_backgound_fix : '',
                        $settings['content']
                    );
                break;
                default:
                    $html = $image_html;
                break;
            }
        } else {
            $custom_dimension = isset($settings[ $image_key . '_custom_dimension' ]) ? $settings[ $image_key . '_custom_dimension' ] : ['width' => get_option('large_size_w'), 'height' => get_option('large_size_h')];
            $custom_dimension =  wp_parse_args($custom_dimension, ['width'=>'','height' => '']);
            $image_src = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $image['id'], $image_size_key, $settings );
            if ( ! $image_src && isset( $image['url'] ) ) {
                $image_src = $image['url'];
            }

            if ( ! empty( $image_src ) ) {
                //$image_class_html = ! empty( $image_class ) ? ' class="' . $image_class . '"' : '';
                $image_style = $image_overlay_style = $data_bg = '';
                
                if($settings['as_background']){
                    $data_bg = '';
                    $image_style .= '--cms-bg-lazyload:url('.$image_bg[0].');background-image:var(--cms-bg-lazyload-loaded);';
                    
                    if($settings['aspect_ratio']){
                        $image_style .= 'aspect-ratio:'.$custom_dimension['width'].'/'.$custom_dimension['height'].';';
                    }
                }
                
                // if have max-height style
                $max_height = $min_height = '';
                if($settings['max_height']){
                    $max_height = 'max-height:'.$custom_dimension['height'].'px;';
                    $image_style .= $max_height;
                    $image_overlay_style .= $max_height;
                }
                if($settings['min_height']){
                    $min_height = 'min-height:'.$custom_dimension['height'].'px;';
                    $image_style .= $min_height;
                    $image_overlay_style .= $min_height;
                }
                if(!empty($settings['attrs']['style'])){
                    $image_style .= $settings['attrs']['style'];
                }
                if(!empty($image_style)) $image_style = ' style="'.$image_style.'"';
                if(!empty($image_overlay_style)) $image_overlay_style = ' style="'.$image_overlay_style.'"';

                // As Background Fix
                $aspect_ratio_padding = '56.25';
                if($custom_dimension['height']!== 0){
                    //$aspect_ratio_padding = ($custom_dimension['width']/$custom_dimension['height'])*100;
                }
                /*$as_backgound_fix = '<div style="aspect-ratio:'.$custom_dimension['width'].'/'.$custom_dimension['height'].';max-width:'.$custom_dimension['width'].'px;max-height:'.$custom_dimension['height'].'px;padding-top:'.$aspect_ratio_padding.'%;"></div>';*/
                $as_backgound_fix = sprintf( '<img width="%s" height="%s" src="%s" class="%s" alt="%s" fetchpriority="high" loading="lazy" />', 
                    $custom_dimension['width'],
                    $custom_dimension['height'],
                    esc_attr( $image_src ), 
                    'as-bg-fix cms-lazy cms-invisible', 
                    \Elementor\Control_Media::get_image_alt( $image )
                );
                // Render
                switch ($settings['as_background']) {
                    case 'overlay':
                        $image = sprintf( '<img data-as-background="overlay" width="%s" height="%s" src="%s" class="%s" alt="%s" loading="lazy" />', 
                            $custom_dimension['width'],
                            $custom_dimension['height'],
                            esc_attr( $image_src ), 
                            $image_class, 
                            \Elementor\Control_Media::get_image_alt( $image )
                        );
                        $html = sprintf(
                            '<div class="%1$s" %2$s data-as-background="%3$s">%4$s%5$s</div>',
                            $overlay_class,
                            $image_overlay_style,
                            $settings['as_background'],
                            $image,
                            $settings['content']
                        );
                        break;
                    case 'yes' :
                        $html = sprintf(
                            '<div class="%1$s"%2$s data-as-background="%3$s">%4$s%5$s</div>',
                            $overlay_class,
                            $image_style,
                            $settings['as_background'],
                            empty($settings['content']) ? $as_backgound_fix : '',
                            $settings['content']
                        );
                        break;
                    default:
                        // custom attrs
                        $image_attrs = [];
                        foreach ($settings['attrs'] as $key => $value) {
                            $image_attrs[] = $key.'=\''.$value.'\'';
                        }
                        $_image_attrs = implode(' ', $image_attrs);
                        $html = sprintf( '<img data-as-background="default" width="%1$s" height="%2$s" src="%3$s" alt="%4$s" %5$s%6$s %7$s/>', 
                            $custom_dimension['width'],
                            $custom_dimension['height'],
                            esc_attr( $image_src ),
                            \Elementor\Control_Media::get_image_alt( $image ),
                            !empty($image_class) ? 'class="'.$image_class.'"' : '',
                            $image_style,
                            $_image_attrs
                        );
                        break;
                }
            }
        }
        return $html;
    }
}
// Elementor Image Render
if(!function_exists('genzia_elementor_image_render')){
    function genzia_elementor_image_render( $settings = [], $args = []){
        if(!class_exists('\Elementor\Plugin') || !class_exists('CSH_Theme_Core')) return;
        $args = wp_parse_args($args, [
            'name'                => 'image',
            'attachment_id'       => '',
            'size'                => 'medium',
            'image_size_key'      => '',
            'img_class'           => '',
            'duration'            => '',
            'custom_size'         => ['width' => get_option('medium_size_w'), 'height' => get_option('medium_size_h')],
            'max_height'          => false,
            'min_height'          => false,
            'as_background'       => false,
            'as_background_class' => '',
            'content'             => '',   
            'before'              => '',
            'after'               => '',
            'edge'                => [],
            'attrs'               => [],
            'aspect_ratio'        => false,
            'echo'                => true
        ]);
        
        if(empty($args['image_size_key'])) $args['image_size_key'] = $args['name'];
        // image by attachment ID
        if(in_array($args['attachment_id'], ['','0', '-1'])){
            $attachment_url = Utils::get_placeholder_image_src();
        } else {
            $attachment_url = wp_get_attachment_image_url($args['attachment_id'], 'full');
        }
        if(!empty($args['attachment_id']) || $args['attachment_id'] == '0'  || $args['attachment_id'] == '-1'){
            $settings[$args['name']] = [
                'id'  => $args['attachment_id'],
                'url' => $attachment_url
            ];
        }
        $settings['img_class']    = $args['img_class'];
        $settings['duration']     = $args['duration'];
        $settings['aspect_ratio'] = $args['aspect_ratio'];
        
        if(!isset($settings[$args['name'].'_custom_dimension'])){
            $settings[$args['name'].'_custom_dimension'] = $args['custom_size'];
        } else {
            $settings[$args['name'].'_custom_dimension']['width'] = !empty($settings[$args['name'].'_custom_dimension']['width']) ? $settings[$args['name'].'_custom_dimension']['width'] : $args['custom_size']['width'];
            
            $settings[$args['name'].'_custom_dimension']['height'] = !empty($settings[$args['name'].'_custom_dimension']['height']) ? $settings[$args['name'].'_custom_dimension']['height'] : $args['custom_size']['height'];
        }
        // as Background
        $settings['as_background']       = $args['as_background'];
        $settings['as_background_class'] = $args['as_background_class'];
        $settings['content']             = $args['content'];
        // set min/max height
        $settings['min_height'] = $args['min_height'];
        $settings['max_height'] = $args['max_height'];
        //
        $settings['size']     = $args['size'];
        $settings['attrs']    = $args['attrs'];
        
        if(empty($settings[$args['name']]['url'])) return;
        ob_start();
            printf('%s', $args['before']);
                // Print image
                \Elementor\Group_Control_Image_Size::print_attachment_image_html( $settings, $args['image_size_key'], $args['name'] );
            printf('%s', $args['after']);
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
// Elementor Image Src Render
if(!function_exists('genzia_elementor_image_src_render')){
    function genzia_elementor_image_src_render($settings = [], $args = []){
        $args = wp_parse_args($args, [
            'name'           => 'image',
            'attachment_id'  => '',
            'size'           => 'full',
            'custom_size'    => ['width'=>768,'height'=>768],
            'image_size_key' => '',
            'default'        => true,
            'echo'           => true
        ]);
        $settings[$args['image_size_key'].'_size'] = $args['size'];
        $settings[$args['image_size_key'].'_custom_dimension'] = $args['custom_size'];

        $attachment_id = !empty($settings[$args['name']]['id']) ? $settings[$args['name']]['id'] : $args['attachment_id'];
        $image_src = \Elementor\Group_Control_Image_Size::get_attachment_image_src($attachment_id, $args['image_size_key'], $settings);
        if(empty($image_src) && $args['default']){
            $image_src = Utils::get_placeholder_image_src();
        }
        if(empty($image_src)) return false;
        
        if($args['echo']){
            printf('%s', $image_src);
        } else {
            return $image_src;
        }
    }
}
/**
 *  Elementor Button Video Render
 * */
// Elementor Button Video Stroke
if(!function_exists('genzia_elementor_button_video_stroke')){
    function genzia_elementor_button_video_stroke($args = []){
        $args = wp_parse_args($args, [
            'width'                  => 232,
            'height'                 => 232,
            'color'                  => 'var(--cms-primary)',
            'color_hover'            => 'var(--cms-accent)',
            'stroke_dasharray'       => 940,
            'stroke_dasharray_hover' => 940,
            'class'                  => '',
            'icon'                   => ''
        ]);
        $classes = ['cms-video-play-stroke', $args['class']];
    ?>
        <div class="cms-video-playstroke relative cms-transition" style="--stroke-dasharray:<?php echo esc_attr($args['stroke_dasharray']);?>;--stroke-dasharray-hover:<?php echo esc_attr($args['stroke_dasharray_hover']); ?>;">
            <svg class="<?php echo genzia_nice_class($classes); ?>" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="<?php echo esc_attr($args['width']).'px'; ?>" height="<?php echo esc_attr($args['height'].'px'); ?>" viewBox="0 0 300 300" style="enable-background:new 0 0 300 300;" xml:space="preserve">
                <circle class="cms-stroke-1" fill="none" stroke="<?php echo esc_attr($args['color']); ?>" cx="150" cy="150" r="149"></circle>
                <circle class="cms-stroke-2" fill="none" stroke="<?php echo esc_attr($args['color_hover']) ?>" cx="150" cy="150" r="149"></circle>
            </svg>
            <?php printf('%s', $args['icon']); ?>
        </div>
    <?php
    }
}
// Background Video Render
if(!function_exists('genzia_elementor_video_background_render')){
    function genzia_elementor_video_background_render($widget=[], $settings=[], $args = []){
        $args = wp_parse_args($args, [
            'url'      => '',
            'class'    => '',
            'loop'     => false,
            'loop_key' => '',
            'fit'      => true 
        ]);
        if(empty($args['url'])) return;
        $video_url    = $args['url'];
        $embed_params = [
            'loop'           => '1',
            'controls'       => '0',
            'mute'           => '1',
            'rel'            => '0',
            'modestbranding' => '0',
            'playsinline'    => '1',
            'autoplay'       => '1'
        ];

        $embed_options = [];
        $url = \Elementor\Embed::get_embed_url( $video_url, $embed_params, $embed_options );
        $video_attrs = [
            'class' => array_filter([
                'cms-evideo-bg',
                'cms-evideo-playback',
                ($args['fit'] == true) ? 'cms-evideo-fit' : '',
                $args['class']
            ]),
            'data-video-link' => $args['url'],
            'style' => 'width: 100%;height:100%;'
        ];
        $yt_attrs = [
            'class'           => 'cms-yt-bg-video',
            'data-video-link' => $args['url'],
            'style'           => 'width: 100%;height:100%;'
        ];
        if(!$args['loop']){
            $video_key = 'video';
            $video_key_yt = 'cms-yt-bg-video';
            // 
            $widget->add_render_attribute($video_key, $video_attrs);
            // YT Video
            $widget->add_render_attribute($video_key_yt, $yt_attrs);
        } else {
            $video_key = $widget->get_repeater_setting_key( 'loop-video', 'bg_video', $args['loop_key'] );
            $video_key_yt = $widget->get_repeater_setting_key( 'loop-yt-video', 'bg_video', $args['loop_key'] );
            //
            $widget->add_render_attribute( $video_key, $video_attrs);
            $widget->add_render_attribute( $video_key_yt, $yt_attrs);
        }
        
    ?>
        <div <?php ctc_print_html($widget->get_render_attribute_string($video_key)); ?>>
            <div <?php ctc_print_html($widget->get_render_attribute_string($video_key_yt)); ?>></div>
        </div>
    <?php
    }
}
// Button Video Render
if(!function_exists('genzia_elementor_button_video_render')){
    function genzia_elementor_button_video_render($widget = [], $settings = [], $args = []){
        $args = wp_parse_args($args, [
            '_id'        => uniqid(),   
            'name'       => 'video_link',
            'layout'     => '1',
            // text
            'text'       => '',
            'text_class' => 'flex-basic',
            'text_attrs' => [],
            //icon
            'icon'       => [
                'value'   => 'fab fa-play',
                'library' => 'fa-solid'
            ],
            'icon_class'     => 'flex-auto',
            'icon_size'      => 20,
            'icon_color'     => '',
            'icon_before'    => '',
            'icon_after'     => '', 
            'icon_content'   => '',
            'icon_dimension' => '',
            //class
            'class'         => '',
            // inner
            'inner_class'   => '',
            //content
            'content_class' => 'd-flex gap-10 align-items-center',

            'echo'          => true,
            'attrs'         => [],
            'loop'          => false,
            'loop_key'      => '',
            // circle
            'circle_settings' => [
                'class'      => '',
                'dimensions' => 145,
                'background' => 'white',
                'color'      => 'primary',
                'text'       => '',
                'text_size'  => 20,
                'echo'       => true,
                'before'     => '',
                'after'      => '',
                'style'      => '',
                // 
                'svg_class'  => 'cms-spin ls-4',
                'icon'       => false
            ],
            // stroke 
            'stroke'      => false,
            'stroke_opts' => [
                'width'  => 140,
                'height' => 140,
                'color'       => '',
                'color_hover' => '',
                'class'       => '' 
            ],
            // Default
            'default'        => '',
            // custom html
            'before'         => '',
            'after'          => '',
            'inner_before'   => '',
            'inner_after'    => '', 
            'content_before' => '',
            'content_after'  => '',
            'lightbox'       => 'yes',
            'autoplay'       => 'no'
        ]);

        if($args['lightbox'] != 'yes' && $args['autoplay'] == 'yes') return;

        $video_url = !empty($settings[$args['name']]) ? $settings[$args['name']] : $args['default'];
        if(empty($video_url)) return;

        $lightbox_id = 'cms-lightbox-'.$widget->get_setting('element_id', $args['_id']);
        
        $embed_params = [
            'mode'           => 'opaque',   
            'loop'           => 1,
            'autoplay'       => 1,
            'controls'       => 1,
            'mute'           => 0,
            'rel'            => 0,
            'modestbranding' => 0
        ];
        $embed_options = [];
        $lightbox_options = [
            'type'         => 'video',
            'videoType'    => 'youtube',
            'url'          => \Elementor\Embed::get_embed_url( $video_url, $embed_params, $embed_options ),
            'modalOptions' => [
                'id'                       => $lightbox_id,
                'entranceAnimation'        => '',
                'entranceAnimation_tablet' => '',
                'entranceAnimation_mobile' => '',
                'videoAspectRatio'         => 169 
            ],
        ];

        if(!$args['loop']){
            $video_key = 'video-attrs';
            $widget->add_render_attribute($video_key, [
                'class' => genzia_nice_class([
                    'cms-btn-video',
                    'cms-btn-video-bg',
                    'layout-'.$args['layout'], 
                    $args['class'], 
                    'cms-transition'
                ])
            ]);
            if($args['lightbox']){
                $widget->add_render_attribute($video_key, [
                    'data-elementor-open-lightbox' => 'yes',
                    'data-elementor-lightbox'      => wp_json_encode( $lightbox_options )
                ]);
            }
            $widget->add_render_attribute($video_key, $args['attrs']);
            // inner
            $video_inner_key = 'video-inner-key';
            $widget->add_render_attribute($video_inner_key, [
                'class' => genzia_nice_class([
                    'cms-btn--video',
                    $args['inner_class']
                ])
            ]);
            // Stroke
            if($args['stroke']){
                $widget->add_render_attribute($video_key, [
                    'class' => 'has-stroke'
                ]);
                //
                $widget->add_render_attribute($video_inner_key, [
                    'style' => 'width:'.$args['stroke_opts']['width'].'px;height:'.$args['stroke_opts']['height'].'px;'
                ]);
            }
        } else {
            $video_key = $widget->get_repeater_setting_key( 'video_key', 'cms_video', $args['loop_key'] );
            $widget->add_render_attribute($video_key, [
                'class' => genzia_nice_class([
                    'cms-btn-video',
                    'cms-btn-video-bg',
                    'layout-'.$args['layout'], 
                    $args['class'], 
                    'cms-transition'
                ])
            ]);
            if($args['lightbox']){
                $widget->add_render_attribute($video_key, [
                    'data-elementor-open-lightbox' => 'yes',
                    'data-elementor-lightbox'      => wp_json_encode( $lightbox_options )
                ]);
            }
            $widget->add_render_attribute($video_key, $args['attrs']);
            // inner
            $video_inner_key = $widget->get_repeater_setting_key( 'video-inner-key', 'cms_video', $args['loop_key'] );
            $widget->add_render_attribute($video_inner_key, [
                'class' => genzia_nice_class([
                    'cms-btn--video',
                    $args['inner_class']
                ])
            ]);
            // Stroke
            if($args['stroke']){
                $widget->add_render_attribute($video_key, [
                    'class' => 'has-stroke'
                ]);
                //
                $widget->add_render_attribute($video_inner_key, [
                    'style' => 'width:'.$args['stroke_opts']['width'].'px;height:'.$args['stroke_opts']['height'].'px;'
                ]);
            }
        }
        // content class
        $video_content_classe = ['cms-btn-video-content', $args['content_class']];
        $widget->add_render_attribute('cms-btn-video-content', [
            'class' => $video_content_classe,
        ]);
        // Text
        $widget->add_render_attribute('text',[
            'class' => [
                'cms-text empty-none',
                $args['text_class']
            ]
        ]);
        $widget->add_render_attribute('text',$args['text_attrs']);
        // Output
        ob_start();
            printf('%s', $args['before']);
        ?>
            <div <?php ctc_print_html($widget->get_render_attribute_string($video_key)); ?>>
                <?php printf('%s', $args['inner_before']); ?>
                <div <?php ctc_print_html($widget->get_render_attribute_string($video_inner_key)); ?>>
                    <?php printf('%s', $args['content_before']); ?>
                    <div <?php ctc_print_html($widget->get_render_attribute_string('cms-btn-video-content')); ?>>
                        <?php 
                        $play_icon_attrs = [
                            'arial-hidden'   => "true", 
                            'class'          => ['cms-play-icon', 'cms-transition'],
                            'icon_class'     => $args['icon_class'],
                            'icon_size'      => $args['icon_size'], 
                            'icon_color'     => $args['icon_color'],
                            'before'         => $args['icon_before'], 
                            'after'          => $args['icon_after'],
                            'content'        => $args['icon_content']
                        ];
                        if(!empty($args['icon_dimension'])){
                            $play_icon_attrs['attrs'] = [
                                'style' => 'width:'.$args['icon_dimension'].'px;height:'.$args['icon_dimension'].'px;'
                            ];
                        }
                        switch ($args['layout']) {
                            case 'circle-text':
                                // play icon
                                $play_icon_attrs['echo'] = false;
                                $play_icon_attrs['class'][] = 'absolute center z-top';
                                $args['circle_settings']['after'] = genzia_elementor_icon_render($args['icon'], [], $play_icon_attrs);
                                // Circle Text
                                genzia_circle_text($widget, $settings, $args['circle_settings']);
                                break;
                            default:
                                    if($args['stroke']){
                                        genzia_elementor_button_video_stroke($args['stroke_opts']);
                                    }
                                    genzia_elementor_icon_render($args['icon'], [], $play_icon_attrs);
                                ?>
                                <span <?php ctc_print_html($widget->get_render_attribute_string('text')); ?>><?php ctc_print_html($args['text']) ?></span>
                        <?php 
                            break;
                        } ?>
                    </div>
                    <?php  printf('%s', $args['content_after']); ?>
                </div>
                <?php  printf('%s', $args['inner_after']); ?>
            </div>
        <?php
            printf('%s', $args['after']);
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
// Elementor Post Image Render
if(!function_exists('genzia_elementor_post_thumbnail_render')){
    function genzia_elementor_post_thumbnail_render( $settings = [], $args = []){
        if(!class_exists('\Elementor\Plugin') || !class_exists('CSH_Theme_Core')) return;
        $args = wp_parse_args($args, [
            'post_id'        => '',
            'image_size_key' => 'thumbnail',
            'size'           => 'custom',
            'custom_size'    => ['width' => get_option('medium_size_w'), 'height' => get_option('medium_size_h')],
            'lazy'           => true,
            'as_background'  => false,
            'max_height'     => false,   
            'min_height'     => false,
            'img_class'      => '',
            'content'        => '',
            'before'         => '',
            'after'          => '',
            'attrs'          => []
        ]);

        $settings['img_class']  = $args['img_class'];
        $settings['min_height'] = $args['min_height'];
        $settings['max_height'] = $args['max_height'];
        $settings['size']       = $args['size'];
        $settings['lazy']       = $args['lazy'];
        // as Background
        $settings['as_background'] = $args['as_background'];
        $settings['content'] = $args['content'];
        $settings['attrs'] = $args['attrs'];
        
        // post thumbnail or placeholder image
        $settings[$args['image_size_key']] = [
            'id'  => get_post_thumbnail_id($args['post_id']),
            'url' => !empty(get_the_post_thumbnail_url($args['post_id'])) ? get_the_post_thumbnail_url($args['post_id']) : \Elementor\Utils::get_placeholder_image_src()
        ];
        $settings[$args['image_size_key'].'_size'] = isset($settings[$args['image_size_key'].'_size']) ? $settings[$args['image_size_key'].'_size'] : $args['size'];

        if(!isset($settings[$args['image_size_key'].'_custom_dimension'])){
            $settings[$args['image_size_key'].'_custom_dimension'] = $args['custom_size'];
        } else {
            $settings[$args['image_size_key'].'_custom_dimension']['width'] = !empty($settings[$args['image_size_key'].'_custom_dimension']['width']) ? $settings[$args['image_size_key'].'_custom_dimension']['width'] : $args['custom_size']['width'];
            
            $settings[$args['image_size_key'].'_custom_dimension']['height'] = !empty($settings[$args['image_size_key'].'_custom_dimension']['height']) ? $settings[$args['image_size_key'].'_custom_dimension']['height'] : $args['custom_size']['height'];
        }
        printf('%s', $args['before']);
        // Print image
        \Elementor\Group_Control_Image_Size::print_attachment_image_html( $settings, $args['image_size_key'], $args['image_size_key'] );
        printf('%s', $args['after']);
    }
}

/**
 * Elementor Post Layout Options
 * use for layout option in : cms_blog_grid, cms_blog_carousel
 * cms_practice_grid, cms_practice_carousel, ...
 * 
 * */
function genzia_elementor_post_layouts($unset = [], $extra = []){
    $layout = [
        '1' => [
            'title' => esc_html__( 'Layout 1', 'genzia' ),
            'image' => get_template_directory_uri() . '/elementor/templates/layout/1.webp'
        ],
        '2' => [
            'title' => esc_html__( 'Layout 2', 'genzia' ),
            'image' => get_template_directory_uri() . '/elementor/templates/layout/2.webp'
        ],
        '3' => [
            'title' => esc_html__( 'Layout 3', 'genzia' ),
            'image' => get_template_directory_uri() . '/elementor/templates/layout/3.webp'
        ],
        '4' => [
            'title' => esc_html__( 'Layout 4', 'genzia' ),
            'image' => get_template_directory_uri() . '/elementor/templates/layout/4.webp'
        ],
        '5' => [
            'title' => esc_html__( 'Layout 5', 'genzia' ),
            'image' => get_template_directory_uri() . '/elementor/templates/layout/5.webp'
        ],
        '6' => [
            'title' => esc_html__( 'Layout 6', 'genzia' ),
            'image' => get_template_directory_uri() . '/elementor/templates/layout/6.webp'
        ],
        '7' => [
            'title' => esc_html__( 'Layout 7', 'genzia' ),
            'image' => get_template_directory_uri() . '/elementor/templates/layout/7.webp'
        ],
        '8' => [
            'title' => esc_html__( 'Layout 8', 'genzia' ),
            'image' => get_template_directory_uri() . '/elementor/templates/layout/8.webp'
        ],
        '9' => [
            'title' => esc_html__( 'Layout 9', 'genzia' ),
            'image' => get_template_directory_uri() . '/elementor/templates/layout/9.webp'
        ]
    ];
    //
    foreach ($unset as $key => $value) {
        unset($layout[$value]);
    }
    //
    return $layout+$extra;
}
// Elementor Build Post Layout 
if(!function_exists('genzia_get_post_grid')){
    function genzia_get_post_grid($settings = [], $posts = [], $posts_data = [], $args = []){
        if(!class_exists('\Elementor\Plugin') || !class_exists('CSH_Theme_Core')) return;
        //
        if(empty($posts) || !is_array($posts) || empty($posts_data) || !is_array($posts_data)){
            return false;
        }
        extract($posts_data); 
        // Start build post item 
        $count = 0;
        // Item
        $items_classes = [
            'cms-item',
            'cms-transition',
            $posts_data['item_class']
        ];
        // Item Attributes
        $items_attrs=[
            'class'       => genzia_nice_class($items_classes)
        ];
        // Render HTML
        foreach ($posts as $key => $post):
            $count ++;
            ?>
            <div <?php echo genzia_render_attrs($items_attrs); ?> data-settings=<?php printf('%s', $posts_data['data-settings']); ?>>
                <?php
                switch ($layout) {
                    default:
                    ob_start();
                ?>
                    <div class="absolute center">
                        <a class="cms-readmore bg-white text-menu bg-hover-accent-regular text-hover-white cms-box-78 circle cms-hover-show zoom-out" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                            <span class="screen-reader-text"><?php 
                                // Text
                                ctc_print_html($posts_data['readmore_text']);
                            ?></span>
                            <?php
                            // Icon
                            genzia_svgs_icon([
                                'icon'      => 'plus',
                                'icon_size' => 14
                            ]);
                        ?></a>
                    </div>
                <?php
                    $thumb_content = ob_get_clean();                
                ?>
                <div class="cms--item hover-image-zoom-out relative bg-white cms-shadow-2 cms-hover-shadow-1 p-10 cms-radius-16 cms-transition cms-hover-change">
                    <?php
                        // Post Image
                        genzia_elementor_post_thumbnail_render($settings, [
                            'post_id'     => $post->ID,
                            'custom_size' => $posts_data['thumbnail_custom_dimension'],
                            'img_class'   => 'img-cover swiper-nav-vert', 
                            'max_height'  => true,
                            'before'      => '<div class="overflow-hidden relative cms-radius-10" style="max-height:'.$posts_data['thumbnail_custom_dimension']['height'].'px;">',
                            'after'       => $thumb_content.'</div>'
                        ]);
                    ?>
                    <div class="cms---item p-22 p-lr-smobile-12 relative z-top">
                        <div class="d-flex gapX-12 text-sm text-sub-text pt-5 pb-8" style="--cms-separator-color:var(--cms-divider-dark);">
                            <?php 
                                // Taxonomy
                                genzia_the_terms($post->ID, $posts_data['taxonomy'], ', ', 'text-accent-regular text-hover-accent-regular cms-hover-underline', ['before' => '<div class="meta-item category empty-none text-accent-regular"><span class="cms-post-meta-cate-dot cms-box-8 bg-current d-inline-block mt-5 mr-8"></span>', 'after' => '</div>']);
                                // Separator
                                echo '<span class="separator separator-1 align-self-center"></span>';
                            ?>
                            <div class="meta-item date"><?php echo get_the_date('',$post->ID); ?></div>
                        </div>
                        <a class="h6 text-line-3 text-heading-regular text-hover-accent-regular" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php 
                            echo get_the_title($post->ID); 
                        ?></a>
                        <div class="cms-excerpt text-md text-line-<?php echo esc_attr($posts_data['num_line']);?> pt-18 pr-40 pr-smobile-0 mb-n5"><?php 
                            echo wp_kses_post($post->post_excerpt);
                        ?></div>
                    </div>
                </div>
                <?php
                    break;
                case 'all':
                    // Job Details
                    genzia_post_career_render(['id' => $post->ID, 'class' => 'mb-20']);
                    // post icon
                    genzia_post_icon_render([
                        'id'         => $post->ID, 
                        'class'      => 'cms-moving cms-moving-4 rtl-flip',
                        'icon_color' => 'primary text-on-hover-accent',
                        'after'      => '<span class="triangle cms-transition"></span>'   
                    ]);
                    // Post Date
                    ob_start();
                ?>
                    <div class="cms-post-thumb-date absolute top-left text-white text-13 d-flex z-top2">
                        <div class="date bg-primary"><?php echo zeroise( get_the_date('j', $post->ID), 2 );?></div>
                        <div class="month bg-accent"><?php echo get_the_date('M Y', $post->ID);?></div>
                    </div>
                <?php $post_date = ob_get_clean(); ?>
                <div class="cms--item cms-shadow-2 cms-hover-shadow-1 cms-transition bg-white mt-40 hover-divider-date hover-image-zoom-out">
                    <?php
                        // Post Image
                        genzia_elementor_post_thumbnail_render($settings, [
                            'post_id'     => $post->ID,
                            'custom_size' => $posts_data['thumbnail_custom_dimension'],
                            'img_class'   => 'img-cover swiper-nav-vert', 
                            'max_height'  => true,
                            'before'      => '<div class="cms-post-thumbnail overflow-hidden relative ml-40 cms-translateY--40 divider divider-date divider-top divider-accent">',
                            'after'       => $post_date.'</div>'
                        ]);
                    ?>
                    <div class="cms-content p-lr-40 pb-40 p-lr-smobile-20 mt-n10">
                        <div class="cms-post-meta text-13 pb-10 mt-n5 d-flex gap-20"><?php 
                            // Taxonomy
                            genzia_the_terms($post->ID, $posts_data['taxonomy'], '', 'tag-thumb-link cms-radius-20 lh-1 p-tb-8 p-lr-12 bg-grey2 text-menu bg-hover-accent text-hover-white', ['before' => '<div class="tag-thumb post-tag absolute top-left d-flex gap-5 text-12 pt-20 pl-20 z-top">', 'after' => '</div>']);
                            // Author
                            genzia_the_author_posts_link([
                                'id'         => $post->ID,
                                'before'     => '<div class="meta-item text-accent">', 
                                'after'      => '</div>'
                            ]);
                        ?></div>
                        <h3 class="cms-heading text-line-2 text-21 lh-1238 pr-10"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo get_the_title($post->ID); ?></a></h3>
                        <div class="cms-excerpt text-15 pb-5 text-line-<?php echo esc_attr($posts_data['num_line']);?> pt-20 mb-15"><?php 
                            echo wp_kses_post($post->post_excerpt);
                            // Read More
                        ?></div>
                        <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>" class="btn btn-smd btn-outline-border text-primary btn-hover-primary text-hover-white" aria-label="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                            <?php 
                                //text
                                ctc_print_html($posts_data['readmore_text']);
                                //icon
                                genzia_svgs_icon(['icon' => 'arrow-right', 'class' => 'text-12']); 
                            ?>
                        </a>
                    </div>
                </div>
                <?php    
                    break;
                } ?>
            </div>
        <?php
        endforeach;
    }
}
/**
 * Custom Post 
 * 
 * */
/**
 * Icon 
*/
if(!function_exists('genzia_post_icon_opts')){
    function genzia_post_icon_opts($args = []){
        $args = wp_parse_args($args, [
            'label'    => esc_html__('Icon', 'genzia'),
            'icon'     => true,
            'video'    => false,
            'name'     => false,
            'position' => false
        ]);
        $fields = [];
        if($args['icon']){
            $fields['icon'] = [
                'type'        => CSH_Theme_Core::MEDIA_FIELD,
                'title'       => __('Choose Icon', 'genzia'),
                'default'     => ''  
            ];
        }
        //video
        if($args['video']){
            $fields['video'] = [
                'type'        => CSH_Theme_Core::TEXT_FIELD,
                'title'       => __('YouTube Link', 'genzia'),
                'default'     => 'https://www.youtube.com/watch?v=XHOmBV4js_E'  
            ];
        }
        //name
        if($args['name']){
            $fields['name'] = [
                'type'        => CSH_Theme_Core::TEXT_FIELD,
                'title'       => __('Name', 'genzia'),
                'default'     => 'John Doe'  
            ];
        }
        // position
        if($args['position']){
            $fields['position'] = [
                'type'        => CSH_Theme_Core::TEXT_FIELD,
                'title'       => __('Position', 'genzia'),
                'default'     => 'Manager'  
            ];
        }
        return [
            'title'  => $args['label'],
            'fields' => $fields
        ];
    }
}
/**
 * Render Icon
*/
if(!function_exists('genzia_post_icon_render')){
    function genzia_post_icon_render($args = []){
        $args = wp_parse_args($args, [
            'id'                  => get_the_ID(),
            'class'               => '', 
            'before'              => '',
            'after'               => '',
            'wrap_before'         => '',
            'wrap_after'          => '',
            'icon_class'          => '',
            'icon_color'          => 'accent',
            'icon_color_hover'    => 'primary',
            'icon_color_on_hover' => 'primary',
            'size'                => 64,
            'img_class'           => '',
            'echo'                => true
        ]);
        $icon = genzia_get_post_format_value($args['id'], 'icon', '');
        if(empty($icon) && get_post_thumbnail_id($args['id']) != false ){
            $icon = [
                'url' => get_the_post_thumbnail_url($args['id']),
                'id'  => get_post_thumbnail_id($args['id']) 
            ];
        }
        if(empty($icon['url']) || !class_exists('\Elementor\Plugin') ) return;
        $icon_mime = substr($icon['url'], -4);
        
        ob_start();
            switch ($icon_mime) {
                case '.svg':
                    if(isset($icon['id'])){
                        $icon_path = get_attached_file($icon['id']);
                        if($icon_path){
                            include $icon_path;
                        }
                    }
                break;
                
                default:
                    genzia_elementor_image_render([], [
                        'attachment_id' => $icon['id'],
                        'img_class'     => $args['icon_class'],
                        'size'          => 'custom',
                        'custom_size'   => ['width'=>$args['size'], 'height' => $args['size']] 
                    ]);
                    break;
            }
        $icon_html = ob_get_clean();

        ob_start();
            printf('%s', $args['wrap_before']);
            ?>
                <div class="<?php echo implode(' ',array_filter(['cms-post-icon', 'text-'.$args['icon_color'], 'text-hover-'.$args['icon_color_hover'], 'text-on-hover-'.$args['icon_color_on_hover'],'text-'.$args['size'],'lh-0', $args['class']]));?>" style="--svg-size:<?php echo esc_attr($args['size']).'px;--cms-start-color:var(--cms-'.$args['icon_color'].');--cms-end-color:var(--cms-'.$args['icon_color_hover'].');' ?>"><?php 
                    printf('%1$s%2$s%3$s', $args['before'], $icon_html, $args['after'] ); 
                ?></div>
            <?php
            printf('%s', $args['wrap_after']);
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
/**
 * Post Features 
*/
if(!function_exists('genzia_post_feature_opts')){
    function genzia_post_feature_opts($args = []){
        return [
            'title'  => esc_html__('Features', 'genzia'),
            'fields' => [
                'features' => [
                    'type'        => CSH_Theme_Core::REPEATER_FIELD,
                    'title'       => __('Add your feature', 'genzia'),
                    'fields' => [
                        'text' => [
                            'type' => CSH_Theme_Core::TEXT_FIELD,
                            'title' => __('Your feature','genzia')
                        ]
                    ],
                    'title_field' => 'text'
                ]
            ]
        ];
    }
}
if(!function_exists('genzia_post_feature_render')){
    function genzia_post_feature_render($args = []){
        $args = wp_parse_args($args, [
            'id'         => get_the_ID(),
            'name'       => 'features',
            'before'     => '<div class="cms-post-feature text-secondary font-700 text-15">',
            'after'      => '</div>',
            'icon'       => 'cmsi-check text-10',
            'icon_class' => 'text-secondary-lighten',
            'item_class' => 'cms-list-item',
            'echo'       => true
        ]);
        $features = genzia_get_post_format_value($args['id'], $args['name']);
        if(empty( $features)) return;
        ob_start();
            printf('%s', $args['before']);
                foreach ($features as $feature) {
                    $_icon = (isset($feature['icon']) && !empty($feature['icon'])) ? $feature['icon'] : $args['icon'];
                    $icon = !empty($_icon) ? '<div class="'.genzia_nice_class(['flex-auto cms-list-icon', $args['icon_class'], $_icon]).'"></div>' : '';
                    printf('<div class="%s d-flex gap-15">%s<div class="flex-basic">%s</div></div>',$args['item_class'],$icon,$feature['text']);
                }
            printf('%s', $args['after']);
        if($args['echo']){
            echo ob_get_clean();
        } else  {
            return ob_get_clean();
        }
    }
}
/**
 * Career Opts 
*/
if(!function_exists('genzia_post_career_opts')){
    function genzia_post_career_opts($args = []){
        return [
            'title'  => esc_html__('General', 'genzia'),
            'fields' => [
                'job_type' => [
                    'type'        => CSH_Theme_Core::TEXT_FIELD,
                    'title'       => __('Job Type', 'genzia')
                ],
                'job_address' => [
                    'type'        => CSH_Theme_Core::TEXT_FIELD,
                    'title'       => __('Job Address', 'genzia')
                ],
                'job_salary' => [
                    'type'        => CSH_Theme_Core::TEXT_FIELD,
                    'title'       => __('Job Salary', 'genzia')
                ]
            ]
        ];
    }
}
if(!function_exists('genzia_post_career_render')){
    function genzia_post_career_render($args = []){
        $args = wp_parse_args($args, [
            'id'    => null,
            'class' => ''
        ]);
        if(!$args['id']) return;
        $job_type   = genzia_get_post_format_value($args['id'], 'job_type', '');
        $job_add    = genzia_get_post_format_value($args['id'], 'job_address', '');
        $job_salary = genzia_get_post_format_value($args['id'], 'job_salary', '');

        $classes = ['cms-job-details d-inline-flex align-items-center gap-5', $args['class']];
    ?>
    <div class="<?php echo implode(' ', array_filter($classes)); ?>">
        <div class="job-type empty-none"><?php
            echo esc_html($job_type).','; 
        ?></div>
        <div class="job-add empty-none"><?php 
            echo esc_html($job_add); 
        ?></div>
        <div class="job-sallary empty-none"><?php 
            echo esc_html($job_salary); 
        ?></div>
    </div>
    <?php
    }
}
if(!function_exists('genzia_chart_data_settings')){
    function genzia_chart_data_settings($widget, $settings, $args = []){
        $args = wp_parse_args($args, [
            'name'             => 'cms_chart',
            'chart_container'  => 'cms-charts',
            'wrap_class'       => '',  
            'class'            => '',
            'chart_type'       => 'doughnut',
            'chart_dimensions' => 400,
            'chart_mode'       => 'circle',
            'chart_cutout'     => '50%',
            'custom_data'      => '',
            'before'           => '',
            'after'            => '' 
        ]);
        if($args['chart_mode'] === 'half-circle'){
            $chart_dimensions_height = $args['chart_dimensions']/2;
        } else {
            $chart_dimensions_height = $args['chart_dimensions'];
        }
        $charts = $widget->get_settings($args['name']);
        $chart_title = $chart_main_title = $chart_value = $chart_color = [];
        foreach ($charts as $key => $value) {
            $chart_title[] = $value['chart_title'];
            $chart_main_title[] = $value['chart_main_title'];
            $chart_value[] = $value['chart_value'];
            $chart_color[] = $value['chart_color'];
        }
        // Chart Wrap
        $widget->add_render_attribute('charts-wrap', [
            'class' => [
                'cms-charts-wrap',
                $args['wrap_class'],
                ($args['chart_mode'] === 'half-circle') ? 'cms-charts-half overflow-hidden' : ''
            ],
            'style' => 'max-width:'.$args['chart_dimensions'].'px;height:'.$chart_dimensions_height.'px;--cms-chart-width:'.$args['chart_dimensions'].'px;--cms-chart-height:'.$chart_dimensions_height.'px;'
        ]);
        // Chart Settings   
        $opts = [
            'type'            => $widget->get_setting('cms_chart_type', $args['chart_type']),   
            'labels'          => $chart_title,
            'value'           => $chart_value,
            'colors'          => $chart_color,
            'legend_display'  => $settings['legend_display'],
            'legend_position' => $settings['legend_position'],
            'title_display'   => $settings['title_display'],
            'title_position'  => $settings['title_position'],
            'title_text'      => $widget->get_setting('title_text','CMS Charts'),
            'chart_mode'      => $widget->get_setting('cms_chart_mode', $args['chart_mode']),
            'chart_cutout'    => $args['chart_cutout']
        ];

        if(!empty($args['custom_data'])){
            $opts = $args['custom_data'];
        }

        $widget->add_render_attribute( 'cms-chart-settings', [
            'id'            => $widget->get_name() . '-' . $widget->get_id(),
            'class'         => genzia_nice_class( implode( ' ', [$args['chart_container'], $args['class']] ) ),
            'data-settings' => wp_json_encode($opts)
        ]);
    ?>
        <div <?php ctc_print_html($widget->get_render_attribute_string( 'charts-wrap' )); ?>>
            <?php printf('%s', $args['before']); ?>
            <canvas <?php ctc_print_html($widget->get_render_attribute_string( 'cms-chart-settings' )); ?>></canvas>
            <?php printf('%s', $args['after']); ?>
        </div>
    <?php
    }
}
if(!function_exists('genzia_chart_bar_data_settings')){
    function genzia_chart_bar_data_settings($widget, $settings, $args = []){
        $args = wp_parse_args($args, [
            'name'            => 'cms_chart',
            'chart_container' => 'cms-charts-bar',
            'wrap_class'      => '',  
            'class'           => '',
            'chart_type'      => 'bar',
            'title1'          => $widget->get_setting('chart1_title','Title #1'),
            'color1'          => $widget->get_setting('chart1_color','#616161'),
            'title2'          => $widget->get_setting('chart2_title','Title #2'),
            'color2'          => $widget->get_setting('chart2_color','#161616'),
            'title3'          => $widget->get_setting('chart3_title','Title #3'),
            'color3'          => $widget->get_setting('chart3_color','#ef3d23'),
            //
            'bar-thickness'     => $widget->get_setting('bar-thickness',['size' => 22])['size'],
            'max-bar-thickness' => $widget->get_setting('max-bar-thickness',['size' => 15])['size'],
            'border-radius'     => $widget->get_setting('border-radius',['size' => 0])['size'],
            'border-width'      => $widget->get_setting('border-width', ['size' => 0])['size']
        ]);
        $charts = $widget->get_settings($args['name']);
        $chart_title = $chart_value = $chart_color = $chart_datasets = $charts_databar = [];
        $chart_datasets = [
            [
                'label'           => $args['title1'],
                'data'            => [],
                'backgroundColor' => $args['color1'],
                'borderColor'     => $args['color1'],
                'borderWidth'     => $args['border-width'],
                'borderRadius'    => $args['border-radius'],
                'borderSkipped'   => false,
                'barThickness'    => $args['bar-thickness'],
                'maxBarThickness' => $args['max-bar-thickness'],
            ],
            [
                'label'           => $args['title2'],
                'data'            => [],
                'backgroundColor' => $args['color2'],
                'borderColor'     => $args['color2'],
                'borderWidth'     => $args['border-width'],
                'borderRadius'    => $args['border-radius'],
                'borderSkipped'   => false,
                'barThickness'    => $args['bar-thickness'],
                'maxBarThickness' => $args['max-bar-thickness'],
            ],
            [
                'label'           => $args['title3'],
                'data'            => [],
                'backgroundColor' => $args['color3'],
                'borderColor'     => $args['color3'],
                'borderWidth'     => $args['border-width'],
                'borderRadius'    => $args['border-radius'],
                'borderSkipped'   => false,
                'barThickness'    => $args['bar-thickness'],
                'maxBarThickness' => $args['max-bar-thickness'],
            ]
        ];
        foreach ($charts as $key => $value) {
            $chart_title[] = $value['chart_title'];
            if(isset($value['chart1_value']) && !empty($value['chart1_value'])){
                $chart_datasets[0]['data'][] = explode(',', $value['chart1_value']);
            }
            if(isset($value['chart2_value']) && !empty($value['chart2_value'])){
                $chart_datasets[1]['data'][] = explode(',', $value['chart2_value']);
            }
            if(isset($value['chart3_value']) && !empty($value['chart3_value'])){
                $chart_datasets[2]['data'][] = explode(',', $value['chart3_value']);
            }
        }
        // Chart Wrap
        $widget->add_render_attribute('charts-wrap', [
            'class' => [
                'cms-charts-wrap',
                $args['wrap_class']
            ]
        ]);
        // Chart Settings   
        $opts = [
            'type'            => $widget->get_setting('cms_chart_type', $args['chart_type']),
            'labels'          => $chart_title,
            'datasets'        => $chart_datasets,
            'legend_display'  => $settings['legend_display'],
            'legend_position' => $settings['legend_position'],
            'title_display'   => $widget->get_setting('title_display', false),
            'title_position'  => $widget->get_setting('title_position','top'),
            'title_text'      => $widget->get_setting('title_text','CMS Charts')
        ];
        $widget->add_render_attribute( 'cms-chart-settings', [
            'id'            => $widget->get_name() . '-' . $widget->get_id(),
            'class'         => implode( ' ', array_filter([$args['chart_container'], $args['class']]) ),
            'data-settings' => wp_json_encode($opts)
        ]);
    ?>
        <div <?php ctc_print_html($widget->get_render_attribute_string( 'charts-wrap' )); ?>>
            <canvas <?php ctc_print_html($widget->get_render_attribute_string( 'cms-chart-settings' )); ?>></canvas>
        </div>
    <?php
    }
}
if(!function_exists('genzia_chart_line_data_settings')){
    function genzia_chart_line_data_settings($widget, $settings, $args = []){
        $args = wp_parse_args($args, [
            'name'            => 'cms_chart_line',
            'chart_container' => 'cms-charts-line',
            'wrap_class'      => '',  
            'class'           => '',
            'chart_type'      => 'line',
            'labels'          => '',
            'border_width'    => 2,
            'point_radius'    => 0,
            'tension'         => '0.5',
            'fill'            => false  
        ]);
        $charts = $widget->get_settings($args['name']);
        $labels = explode(',', $args['labels']);
        foreach ($charts as $key => $value) {
            $chart_datasets[] = [
                'label'           => $value['chart_title'],
                'data'            => explode(',', $value['chart_value']),
                'borderColor'     => $value['chart_color'],
                'borderDash'      => explode(',', $value['chart_dash']),
                'borderWidth'     => $args['border_width'],
                'pointRadius'     => $args['point_radius'],
                'tension'         => $args['tension'],
                'fill'            => $args['fill']  
            ];
        }
        // Chart Wrap
        $widget->add_render_attribute('charts-wrap', [
            'class' => [
                'cms-charts-wrap',
                $args['wrap_class']
            ]
        ]);
        // Chart Settings   
        $opts = [
            'type'            => $args['chart_type'],
            'labels'          => explode(',', $args['labels']),
            'datasets'        => $chart_datasets,
            'legend_display'  => $widget->get_setting('legend_display','no'),
            'legend_position' => $widget->get_setting('legend_position','bottom'),
            'title_display'   => $widget->get_setting('title_display', 'no'),
            'title_position'  => $widget->get_setting('title_position', 'top'),
            'title_text'      => $widget->get_setting('title_text','CMS Charts Line')
        ];
        $widget->add_render_attribute( 'cms-chart-settings', [
            'id'            => $widget->get_name() . '-' . $widget->get_id(),
            'class'         => implode( ' ', array_filter([$args['chart_container'], $args['class']]) ),
            'data-settings' => wp_json_encode($opts)
        ]);
    ?>
        <div <?php ctc_print_html($widget->get_render_attribute_string( 'charts-wrap' )); ?>>
            <canvas <?php ctc_print_html($widget->get_render_attribute_string( 'cms-chart-settings' )); ?>></canvas>
        </div>
    <?php
    }
}
/**
 * Custom Post Type
 * 
 * **/
add_filter('cms_extra_post_types', 'genzia_add_post_type');
if(!function_exists('genzia_add_post_type')){
    function genzia_add_post_type($postypes){
        // Portfolio
        $portfolio_slug      = genzia_get_opt('portfolio_slug', 'portfolio');
        $portfolio_name = genzia_get_opt(
            'portfolio_name',
            esc_attr__('Portfolio', 'genzia')
        );
        $postypes['portfolio'] = [
            'status'     => apply_filters('genzia_enable_portfolio', false),
            'item_name'  => $portfolio_name,
            'items_name' => $portfolio_name,
            'args' => [
                'menu_icon'          => 'dashicons-admin-post',
                'supports'           => ['title', 'thumbnail', 'editor','excerpt'],
                'public'             => true,
                'publicly_queryable' => true,
                'rewrite'            => [
                    'slug' => $portfolio_slug,
                ],
            ],
            'labels' => [],
        ];
        // Service
        $service_slug      = genzia_get_opt('service_slug', 'cms-service');
        $service_name = genzia_get_opt(
            'service_name',
            esc_attr__('CMS Service', 'genzia')
        );
        $postypes['cms-service'] = [
            'status'     => apply_filters('genzia_enable_service', false),
            'item_name'  => $service_name,
            'items_name' => $service_name,
            'args' => [
                'menu_icon'          => 'dashicons-admin-post',
                'supports'           => ['title', 'thumbnail', 'editor','excerpt'],
                'public'             => true,
                'publicly_queryable' => true,
                'rewrite'            => [
                    'slug' => $service_slug,
                ],
            ],
            'labels' => [],
        ];
        // Side Nav
        $postypes['cms-sidenav'] = [
            'status'     => apply_filters('genzia_enable_sidenav', false),
            'item_name'  => esc_html__('Side Nav', 'genzia'),
            'items_name' => esc_html__('Side Navs', 'genzia'),
            'args'       => [
                'menu_icon'          => 'dashicons-editor-insertmore',
                'supports'           => ['title', 'editor', 'thumbnail'],
                'public'             => true,
                'publicly_queryable' => true,
                'exclude_from_search' => true
            ],
            'labels' => []
        ];
        // Header Top
        $postypes['cms-header-top'] = [
            'status'     => apply_filters('genzia_enable_header_top', false),
            'item_name'  => esc_html__('Header Top', 'genzia'),
            'items_name' => esc_html__('Headers Top', 'genzia'),
            'args'       => [
                'menu_icon'          => 'dashicons-editor-insertmore',
                'supports'           => ['title', 'editor', 'thumbnail'],
                'public'             => true,
                'publicly_queryable' => true,
                'exclude_from_search' => true
            ],
            'labels' => []
        ];
        // Footer
        $postypes['cms-footer'] = [
            'status'     => apply_filters('genzia_enable_footer', false),
            'item_name'  => esc_html__('Footer', 'genzia'),
            'items_name' => esc_html__('Footers', 'genzia'),
            'args'       => [
                'menu_icon'           => 'dashicons-editor-insertmore',
                'supports'            => ['title', 'editor', 'thumbnail'],
                'public'              => true,
                'publicly_queryable'  => true,
                'exclude_from_search' => true
            ],
            'labels' => []
        ];
        // Popup
        $postypes['cms-popup'] = [
            'status'     => apply_filters('genzia_enable_popup', false),
            'item_name'  => esc_html__('Pop Up', 'genzia'),
            'items_name' => esc_html__('Pop Ups', 'genzia'),
            'args'       => [
                'menu_icon'           => 'dashicons-editor-insertmore',
                'supports'            => ['title', 'editor', 'thumbnail'],
                'public'              => true,
                'publicly_queryable'  => true,
                'exclude_from_search' => true
            ],
            'labels' => []
        ];
        return $postypes;
    }
}
add_filter('cms_extra_taxonomies', 'genzia_add_tax');
if(!function_exists('genzia_add_tax')){
    function genzia_add_tax($taxonomies){
        // Portfolio
        $taxonomies['portfolio-category'] = [
            'status'      => apply_filters('genzia_enable_portfolio', false),
            'post_type'   => ['portfolio'],
            'taxonomy'    => esc_html__('Portfolio Category', 'genzia'),
            'taxonomies'  => esc_html__('Portfolio Categories', 'genzia'),
            'args'        => [],
            'labels'      => [],
        ];
        if(apply_filters('genzia_enable_service', false)){
            $taxonomies['service-category'] = [
                'status'      => apply_filters('genzia_enable_service', false),
                'post_type'   => ['cms-service'],
                'taxonomy'    => esc_html__('Service Category', 'genzia'),
                'taxonomies'  => esc_html__('Services Categories', 'genzia'),
                'args'        => [],
                'labels'      => [],
            ];
            $taxonomies['service-tag'] = [
                'status'      => apply_filters('genzia_enable_service', false),
                'post_type'   => ['cms-service'],
                'taxonomy'    => esc_html__('Service Tag', 'genzia'),
                'taxonomies'  => esc_html__('Services Tags', 'genzia'),
                'args'        => [],
                'labels'      => [],
            ];
        }
        return $taxonomies;
    }
}
/**
 * ================================================
 * All function for Demo Data
 * 
 * @package CMS Theme
 * @subpackage Genzia
 * @since 1.0
 * 
 * ================================================
 * 
*/
/* Create Demo Data */
if(!function_exists('genzia_enable_export_mode')){
    function genzia_enable_export_mode() {
        return defined('DEV_MODE') && DEV_MODE == true ? true : false;
    }
}
add_filter('swa_ie_export_mode', 'genzia_enable_export_mode');
if (!function_exists('genzia_cpt_dev_mode')) {
    function genzia_cpt_dev_mode()
    {
        return defined('DEV_MODE') && DEV_MODE == true ? true : false;
    }
}
add_filter('cpt_dev_mode', 'genzia_cpt_dev_mode');
/**
 * Update custom post type edit with Elementor
 * **/
if (!function_exists('genzia_elementor_cpts')) {
    add_action('theme_core_ie_after_import', 'genzia_elementor_cpts');
    add_action('after_switch_theme', 'genzia_elementor_cpts');
    function genzia_elementor_cpts(){
        $default = (array)get_option('elementor_cpt_support');
        $cpt_support = array_merge(
            $default, 
            [
                //core
                'post',
                'page',
                'cms-footer',
                'cms-header-top',
                'cms-mega-menu',
                'portfolio',
                // theme
                'cms-career',
                'cms-case',
                'cms-service',
                'cms-practice',
                'cms-sidenav',
                'cms-popup',
                // WooCommerce
                //'product'
            ]
        );
        update_option( 'elementor_cpt_support', $cpt_support );
    }
}
/*
 *  Dashboard Configurations
 */
if (!function_exists('genzia_cms_cpt_dashboard_config')) {
    function genzia_cms_cpt_dashboard_config()
    {
        return [
            'documentation_link'  => 'https://cmssuperheroes.gitbook.io/genzia-wordpress-theme/',
            'ticket_link'         => 'https://cmssuperheroes.ticksy.com/',
            'video_tutorial_link' => 'https://www.youtube.com/c/CMSSuperheroes',
            'demo_link'           => 'https://demo.cmssuperheroes.com/themeforest/genzia',
        ];
    }
}
if (!function_exists('genzia_7oroof_cpt_dashboard_config')) {
    function genzia_7oroof_cpt_dashboard_config()
    {
        return [
            'documentation_link'  => 'https://7oroof-themes.gitbook.io/genzia-wordpress-theme/',
            'ticket_link'         => 'https://7oroofthemes.com/support/',
            'video_tutorial_link' => 'https://www.youtube.com/channel/UCR57ptzvmUEhJ_jIB7QQavg',
            'demo_link'           => 'https://7oroofthemes.com/genzia/',
        ];
    }
}
if (!function_exists('genzia_farost_cpt_dashboard_config')) {
    function genzia_farost_cpt_dashboard_config()
    {
        return [
            'documentation_link'  => 'https://farost.gitbook.io/genzia-wordpress-theme',
            'ticket_link'         => 'mailto:farost.agency@gmail.com',
            'video_tutorial_link' => 'https://www.youtube.com/channel/UCR57ptzvmUEhJ_jIB7QQavg',
            'demo_link'           => 'http://demo.farost.net/genzia',
        ];
    }
}
$theme_upload_by = '';
switch ($theme_upload_by) {
    case 'farost':
        add_filter('cpt_dashboard_config', 'genzia_farost_cpt_dashboard_config');
        add_filter('cms_documentation_link', function(){ return genzia_farost_cpt_dashboard_config()['documentation_link'];});
        add_filter('cms_ticket_link', function(){ return ['type' => 'url', 'link' => genzia_farost_cpt_dashboard_config()['ticket_link']];});
        add_filter('cms_video_tutorial_link', function(){ return genzia_farost_cpt_dashboard_config()['video_tutorial_link'];});
        break;

    case '7or':
        add_filter('cpt_dashboard_config', 'genzia_7oroof_cpt_dashboard_config');
        add_filter('cms_documentation_link', function(){ return genzia_7oroof_cpt_dashboard_config()['documentation_link'];});
        add_filter('cms_ticket_link', function(){ return ['type' => 'url', 'link' => genzia_7oroof_cpt_dashboard_config()['ticket_link']];});
        add_filter('cms_video_tutorial_link', function(){ return genzia_7oroof_cpt_dashboard_config()['video_tutorial_link'];});
        break;

    default:
        add_filter('cpt_dashboard_config', 'genzia_cms_cpt_dashboard_config');
        add_filter('cms_documentation_link', function(){ return genzia_cms_cpt_dashboard_config()['documentation_link'];});
        add_filter('cms_ticket_link', function(){ return ['type' => 'url', 'link' => genzia_cms_cpt_dashboard_config()['ticket_link']];});
        add_filter('cms_video_tutorial_link', function(){ return genzia_cms_cpt_dashboard_config()['video_tutorial_link'];});
        break;
}


/**
 * The Newsletter
 * 
 * Update Custom HTML Form
 * 
 * */
if(!function_exists('genzia_thenewsletter_custom_html_form')){
    add_action('theme_core_ie_after_import', 'genzia_thenewsletter_custom_html_form');
    function genzia_thenewsletter_custom_html_form(){
        $htmlforms = (array)get_option('newsletter_htmlforms');
        $htmlforms['form_1'] = '';
        //
        update_option( 'newsletter_htmlforms', $htmlforms );
    }
}

/**
 * =========================
 * End Demo Data
 * =========================
 * */
?>