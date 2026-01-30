<?php
/**
 * The template for displaying all single CMS Service
 *
 * @package CMS Theme
 * @subpackage Genzia
 */
get_header();
    while ( have_posts() ) {
    	the_post();
	    the_content();
    }
get_footer();
