<?php
/**
 * Template part for displaying posts in loop
 *
 * @package 
 */
?>
<div class="cms-single-content cms-radius-16 bg-white cms-shadow-2 p-10">
	<?php
		genzia_entry_thumbnail([
			'size'      => 'large',
			'class'     => '',
			'img_class' => 'img-cover cms-radius-10 mb-25',
			'style'		=> 'max-height:'.get_option('large_size_h').'px;',
			'content'	=> ''
		]);
	?>
	<div class="p-lr-20 p-lr-smobile-0 pb-20">
		<?php 
			// Post Meta	
			genzia_post_meta([
				'opt_prefix'     => 'post_',
				'gap'            => '',
				'class'          => 'cms-archive-meta gapX-20 text-sm pb-10 text-sub-text',
				'separator'      => '',
				'cat_class'		 => 'text-accent-regular',
				'cat_link_class' => 'text-accent-regular text-hover-accent-regular cms-hover-underline',
				'cat_separator'  => ', ',
				'date_class'	 => '',	
				'link_class'     => 'text-menu text-hover-accent-regular cms-hover-underline',
				'before'		 => ''
			]);
			// Post Title
			genzia_entry_single_title();
		?>
		<div class="content clearfix mt-23"><?php 
			the_content(); 
			genzia_entry_link_pages();
		?></div>
		<div class="tags-share empty-none mt-32 pt-40 bdr-t-1 bdr-divider d-flex gap-20 justify-content-between align-items-center">
			<?php 
			genzia_entry_tagged_in([
				'class'     => 'text-xs',
				'tag_class' => 'd-flex justify-content-center',
				'ul_class'  => 'wp-tag-cloud',
				'title'     => '',
			]);
			genzia_socials_share_default([
				'title'       => '<div class="text-sm text-heading-regular">'.esc_html__('Share', 'genzia').'</div>',
				'class'       => 'd-flex gap-20 justify-content-center',
				'inner_class' => 'cms-social-share',
				'show'        => (bool)genzia_get_opt('post_social_share_on', false),
				'icon_size'   => 20,
				'icon_class'  => 'text-menu text-hover-accent-regular'
			]); 
		?></div>
	</div>
</div>
<?php
// Post Nav
genzia_post_nav_default([
	'class' => 'mt-40'
]);
// About Author
if(!empty(get_the_author_meta( 'description' )) && genzia_get_opt('post_author_info_on', false)){
?>
<div class="cms-author-info p-10 mt-40 cms-radius-16 d-flex gap-32 align-items-center bg-divider-light">
    <div class="author-avatar flex-auto flex-smobile-full">
		<?php 
			genzia_avatar([
				'custom' => true,
				'width'  => 176, 
				'height' => 208,
				'class'  => 'cms-radius-10'
			]);
		?>
    </div>
    <div class="author-desc flex-basic pr-30 pr-smobile-0">
    	<h6 class="author-name"><?php the_author_meta( 'display_name' ); ?></h6>
		<div class="author-bio pt-12 text-md"><?php  the_author_meta( 'description' ); ?></div>
		<?php
			// User Social
			genzia_get_user_social([
				'class'      => 'pt-20 cms-social-share',
				'gap'        => 8,
				'icon_class' => 'cms-box-40 cms-radius-6 bg-menu text-white bg-hover-accent-regular text-hover-white'
			]); 
		?>
    </div>
</div>
<?php 
	}
?>