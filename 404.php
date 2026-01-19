<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package CMS Theme
 * @subpackage Genzia
 * 
 */
$title_404_page    = genzia_get_opt( 'title_404_page' );
$content_404_page  = str_replace("\'","'", genzia_get_opt( 'content_404_page' ));
$btn_text_404_page = genzia_get_opt( 'btn_text_404_page' );
get_header(); 
?>
<div class="d-flex gap-40 justify-content-center align-items-center text-center">
    <h1 class="w-100 lh-1 text-">404</h1>
    <h3 class="w-100">
        <?php if ( ! empty( $title_404_page ) ) {
            printf( '%s', $title_404_page );
        } else {
            echo esc_html__( "Oops! That page can’t be found.", "genzia" );
        } ?>
    </h3>
    <div class="page-content w-100">
        <?php if ( ! empty( $content_404_page ) ) {
            printf( '%s', $content_404_page );
        } else {
            echo esc_html__( "The page requested couldn't be found. This could be a spelling error in the URL or a removed page.", "genzia" );
        } ?>
    </div>
    <div class="w-100">
        <a class="btn btn-primary text-white btn-hover-outline-primary text-hover-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <i class="cmsi-arrow-left rtl-flip text-10"></i>
            <?php if ( ! empty( $btn_text_404_page ) ) {
                printf( '%s', $btn_text_404_page );
            } else {
                echo esc_html__( 'Back To Home', 'genzia' );
            } ?>
        </a>
    </div>
</div>
<?php
get_footer();
