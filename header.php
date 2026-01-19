<?php
/**
 * The header for our theme.
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package CMS Theme
 * @subpackage Genzia
 */
$body_style = '';
if(genzia_get_opts('body_top_space', '', 'body_top_space_custom') !=''){
	$body_style = 'style="--mt:'.genzia_get_opts('body_top_space', '0.0001', 'body_top_space_custom').'px;"';
}
$footer_fixed = genzia_get_opts('footer_fixed', 'off', 'footer_custom');
// Add meta description
	if ( is_single() || is_page() ) {
		global $post;
		if ( $post && $post->ID ) {
			if ( has_excerpt() ) {
				$description = get_the_excerpt();
			} else {
				$description = wp_trim_words( wp_strip_all_tags( get_the_content() ), 25, '...' );
			}
		} else {
			$description = get_bloginfo( 'description' );
		}
	} elseif ( is_archive() ) {
		$description = wp_strip_all_tags( get_the_archive_description() );
		if ( empty( $description ) ) {
			$description = get_bloginfo( 'description' );
		}
	} elseif ( is_search() ) {
		$description = sprintf( esc_html__( 'Search Results for: %s', 'genzia' ), get_search_query() );
	} else {
		$description = get_bloginfo( 'description' );
	}
	
	// Ensure description is not empty
	if ( empty( $description ) ) {
		$description = get_bloginfo( 'description' );
	}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo esc_attr( $description ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class();?> <?php echo printf('%s', $body_style); ?>>
	<?php 
	wp_body_open();
	if(!genzia_is_built_with_elementor() && $footer_fixed == 'on'){
		// fix Footer_Fixed 
		echo '<div class="cms-body">';
	}
		genzia_page_loading();
		genzia_header_layout();
		genzia_page_title_layout();
	?>
	<main id="cms-main" class="<?php genzia_main_content_classes(['class' => '']); ?>">