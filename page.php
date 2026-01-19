<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package CMS Theme
 * @subpackage Genzia
 */
get_header();
if(genzia_is_built_with_elementor()){
	while ( have_posts() ) {
		the_post();
		the_content();
	}
} else {
	while ( have_posts() ) {
		the_post();
		the_content();
		genzia_entry_link_pages();

		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	}
}
get_footer();