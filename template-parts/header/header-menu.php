<?php
/**
 * Template part for displaying the primary menu of the site
 */
$args_menu_class = isset( $args['menu_class']) ?  $args['menu_class'] : '';
$menu_classes = ['cms-primary-menu','cms-primary-menu-dropdown', $args_menu_class];
$menu_ID = genzia_get_opts('header_menu', 'primary', 'header_custom');
$args['content'] = isset($args['content']) ? $args['content'] : '';
$attrs = isset($args['attrs']) ? $args['attrs'] : '';
printf('%s', $args['before']);
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array(
			'menu'			 => $menu_ID,
			'theme_location' => 'primary',
			'container'      => '',
			'menu_id'        => 'mastmenu',
			'menu_class'     => genzia_nice_class($menu_classes),
			'link_class'     => '',
			'walker'         => class_exists('CSH_Theme_Core') ?  new Genzia_Mega_Menu_Walker : '',
			'icon_class'	 => '',
			'items_wrap'     => '<ul id="%1$s" class="%2$s" '.$attrs.'>%3$s</ul>'
		) );
	} else { 
		$menu_classes[] = 'primary-menu-not-set';
		printf(
	        '<ul class="%1$s"><li><a href="%2$s">%3$s</a></li></ul>',
	        genzia_nice_class($menu_classes),
	        esc_url( admin_url( 'nav-menus.php' ) ),
	        esc_html__( 'Create New Menu', 'genzia' )
	    );
	}
printf('%s', $args['content']);
printf('%s', $args['after']);