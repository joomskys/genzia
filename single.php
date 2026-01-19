<?php
/**
 * The template for displaying all single posts
 *
 * @package CMS Theme
 * @subpackage Genzia
 */
$sidebar_name = 'sidebar-post';
get_header();
	if(genzia_is_built_with_elementor()){
		while ( have_posts() ) {
			the_post();
			the_content();
		}
	} else {
		genzia_content_has_sidebar_open($sidebar_name);
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content-single/content', get_post_format() );
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			}
		genzia_content_has_sidebar_close($sidebar_name);

		if(genzia_get_opt('sidebar_on', 'off') === 'on' && is_active_sidebar($sidebar_name)){ 
			$sidebar_pos = genzia_get_opt('sidebar_pos', 'order-last');
		?>
			<div id="cms-sidebar" class="<?php echo esc_attr($sidebar_pos); ?> flex-basic">
				<?php dynamic_sidebar($sidebar_name); ?>
			</div>
		<?php
		}
	}
get_footer();
