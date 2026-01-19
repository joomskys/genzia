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
// Align
$menu_class = [
	'cms-menu cms-menu-horz',
	genzia_elementor_get_responsive_class($widget, $settings, ['name' => 'align', 'prefix_class' => 'justify-content-'])
];
$link_class = implode(' ', array_filter([
	'text-'.$this->get_setting('link_color','menu'),
	'text-hover-'.$this->get_setting('link_color_hover','accent-regular'),
	'text-active-'.$this->get_setting('link_color_hover','accent-regular'),
	'cms-hover-underline'
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
				'link_class'	  => $link_class,
				'depth'           => 1,
				'theme_location'  => ''
			)); 
		?>
	</div>
<?php  endif;  ?>