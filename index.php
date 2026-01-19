<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package CMS Theme
 * @subpackage Genzia
 */
get_header();
	
	genzia_content_has_sidebar_open('sidebar-post');

	if ( have_posts() ) {
		$count = 0;
		while ( have_posts() ) {
			the_post();
			$count ++;
			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called loop-post-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', '', ['count' => $count]);
		}
		genzia_posts_pagination();
	} else {
		get_template_part( 'template-parts/content', 'none' );
	}

	genzia_content_has_sidebar_close('sidebar-post');

	if(genzia_show_sidebar('sidebar-post')){ 
		$sidebar_pos = genzia_get_opt('sidebar_pos', 'order-last');
	?>
		<div id="cms-sidebar" class="<?php echo esc_attr($sidebar_pos); ?> order-mobile-extra-last flex-basic">
			<?php dynamic_sidebar('sidebar-post'); ?>
		</div>
	<?php
	}
get_footer();
