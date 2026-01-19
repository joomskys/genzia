<?php
/**
 * Template part for displaying posts in loop
 *
 * @package 
 */
ob_start();
	genzia_entry_readmore();
$readmore = ob_get_clean();
?>
<article <?php post_class('cms-blog cms-radius-16 cms-shadow-2 p-10 mb-40 cms-hover-change'); ?>>
	<?php
		genzia_entry_thumbnail([
			'size'      => 'large',
			'class'     => 'mb-28',
			'img_class' => 'img-cover cms-radius-10',
			'style'		=> 'max-height:'.get_option('large_size_h').'px;',
			'content'	=> $readmore,
			'priority'  => ($args['count'] == 1) ? true : false
		]);
	?>
	<div class="p-lr-20 p-lr-smobile-10 pb-20"><?php 
		// Post Meta	
		genzia_post_meta([
			'opt_prefix'     => 'archive_',
			'gap'            => '',
			'class'          => 'cms-archive-meta gapX-20 text-sm pb-5 text-sub-text',
			'separator'      => '',
			'cat_class'		 => 'text-accent-regular',
			'cat_link_class' => 'text-accent-regular text-hover-accent-regular cms-hover-underline',
			'cat_separator'  => ', ',
			'date_class'	 => '',	
			'link_class'     => 'text-menu text-hover-accent-regular',
			'before'		 => ''
		]);
		// Post Title
		genzia_entry_title();
		// Post Excerpt
		genzia_entry_excerpt(['class' => 'text-line-4 pt-15']);
		//
		genzia_entry_link_pages();
	?></div>
</article>