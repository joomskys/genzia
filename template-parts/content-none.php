<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * @package 
 */
?>
<div>
    <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'genzia' ); ?></h1>
    <?php if ( is_search() ) : ?>
        <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'genzia' ); ?></p>
    	<?php
    	get_search_form();

    else : ?>

        <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'genzia' ); ?></p>
    	<?php
    	get_search_form();

    endif; 
    ?>
</div>
