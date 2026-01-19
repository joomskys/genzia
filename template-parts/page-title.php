<?php
    //
    $titles = genzia_get_page_titles();
    ob_start();
    if ( $titles['title'] ) {
        printf( '<h1 class="title">%s</h1>', wp_kses_post( $titles['title'] ) );
    }
    $titles_html = ob_get_clean();

    $classes = [
        $args['class'], 
        'relative',
        'overflow-hidden',
        'text-center'
    ];
?>
<div id="cms-ptitle" class="<?php echo genzia_nice_class($classes); ?>">
    <div class="<?php echo esc_attr($args['container']); ?> relative z-top pb" style="--pb:148px;--pb-tablet:70px;">
        <?php
            // Title
            printf( '%s', $titles_html );
        ?>
    </div>
</div>