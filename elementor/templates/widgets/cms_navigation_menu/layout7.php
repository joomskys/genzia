<?php
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-emenu',
		'cms-emenu-'.$settings['layout']
	],
	'style' => '--cms-divider-color:var(--cms-'.$this->get_setting('divider_color','menu').');'
]);
// Menu
$menu = $this->get_setting('menu','');
$menu_class = [
	'cms-menu cms-menu-horz',
	genzia_elementor_get_responsive_class($widget, $settings, ['name' => 'align', 'prefix_class' => 'justify-content-', 'default' => 'between']),
	'text-md font-700 text-center',
	'bdr-t-1 bdr-l-1 bdr-r-1',
	'bdr-'.$this->get_setting('divider_color','menu'),
	'cms-radius-tltr-16',
	'cms-menu-hover-icon'
];
$link_class = implode(' ', array_filter([
	'text-'.$this->get_setting('link_color','menu'),
	'text-hover-'.$this->get_setting('link_color_hover','accent-regular'),
	'text-active-'.$this->get_setting('link_color_hover','accent-regular'),
	//'cms-hover-underline'
]));

if ( ! empty( $menu ) ) : ?>
	<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
		<?php 
			wp_nav_menu( array(
				'fallback_cb'     => '',
				'walker'          => '',
				'container'		  => '',
				'container_class' => '',
				'menu'            => $menu,
				'menu_class'      => genzia_nice_class($menu_class),
				'li_class'		  => 'p-20',
				'link_class'	  => $link_class,
				'link_before'	  => genzia_svgs_icon(['icon' => 'arrow-right', 'icon_size' => 10, 'icon_class' => 'cms-menu-icon', 'echo' => false]),
				'depth'           => 1,
				'theme_location'  => ''
			)); 
		?>
	</div>
<?php  endif;  ?>