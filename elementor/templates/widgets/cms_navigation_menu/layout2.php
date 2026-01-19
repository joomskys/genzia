<?php
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-emenu',
		'cms-emenu-'.$this->get_setting('layout','1')
	],
	'style' => '--cms-divider-color:'.$this->get_setting('divider_color','var(--cms-divider)').';'
]);
// Title
$this->add_inline_editing_attributes( 'title', 'none' );
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-title empty-none',
		'heading text-xl font-500',
		'text-'.$this->get_setting('title_color', 'heading-regular'),
		'pb-23'
	]
]);
// Menu
$menu = $this->get_setting('menu','');
$link_class = implode(' ', array_filter([
	'text-'.$this->get_setting('link_color','menu'),
	'text-hover-'.$this->get_setting('link_color_hover','accent-regular'),
	'text-active-'.$this->get_setting('link_color_hover','accent-regular'),
	'justify-content-between'
]));

if ( ! empty( $menu ) ) : ?>
	<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
		<div <?php ctc_print_html( $this->get_render_attribute_string( 'title' ) ); ?>><?php 
			echo ctc_print_html( $settings['title'] ); 
		?></div>
		<?php 
			wp_nav_menu( array(
				'fallback_cb'     => '',
				'walker'          => new Genzia_Toggle_Menu_Walker,
				'container'		  => '',
				'container_class' => '',
				'menu'            => $menu,
				'menu_class'      => 'cms-navigation-menu cms-menu cms-menu-toggle text-md font-500',
				'link_class'	  => $link_class,
				'link_lv1_class'  => 'link_lv1_class',
				'link_lv2_class'  => 'link_lv2_class',
				'depth'           => 2,
				// extra option
				'sub_menu_class'  => 'text-14',
				'icon_class'	  => '',
				'theme_location'  => '',
				// Level 1
				'lv1_class'	      => 'w-100',
				// Parent Icon
				'parent_icon'	  		=> 'core/chevron-down',	
				'dropdown_parent_icon'  => 'core/chevron-down',
				'parent_icon_class'		=> 'text-8 cms-box-20 bg-accent-regular text-white cms-radius-4'
			)); 
		?>
	</div>
<?php  endif;  ?>