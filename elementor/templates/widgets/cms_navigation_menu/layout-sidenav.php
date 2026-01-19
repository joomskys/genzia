<?php
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-emenu',
		'cms-emenu-'.$settings['layout']
	]
]);
// Menu
$menu = $this->get_setting('menu','');
$link_class = implode(' ', array_filter([
	'text-'.$this->get_setting('link_color','menu'),
	'text-hover-'.$this->get_setting('link_color_hover','accent-regular'),
	'text-active-'.$this->get_setting('link_color_hover','accent-regular'),
	'heading-regular',
	'justify-content-between w-100'
]));

if ( ! empty( $menu ) ) : ?>
	<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
		<?php 
			wp_nav_menu( array(
				'fallback_cb'     => '',
				'container'       => '',
				'container_class' => '',
				'menu'            => $menu,
				'menu_class'      => 'cms-sidenav-menu cms-menu cms-menu-toggle level1-uppercase',
				'link_class'      => $link_class,		
				'depth'           => 0,
				'link_before'     => '',
				'link_after'      => '',
				// extra option
				'sub_menu_class'  => '',
				'icon_class'      => '',
				'count'           => '0',
				'tax_image'       => '0',
				'walker'          => new Genzia_Toggle_Menu_Walker,
				'theme_location'  => '',
				// Parent Icon
				'parent_icon'	  		=> 'core/chevron-down',	
				'dropdown_parent_icon'  => 'core/chevron-down',
				'parent_icon_class'		=> 'text-8 cms-box-20 bg-accent-regular text-white cms-radius-4'
			)); 
		?>
	</div>
<?php  endif;  ?>