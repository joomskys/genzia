<?php
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-emenu',
		'cms-emenu-'.$settings['layout'],
		'p-40 p-lr-tablet-20 p-lr-smobile-20',
		'bg-bg-light'
	],
	'style' => '--cms-divider-color:'.$this->get_setting('divider_color','var(--cms-divider)').';'
]);
// Title
$this->add_inline_editing_attributes( 'title', 'none' );
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-title empty-none',
		'text-'.$this->get_setting('title_color', 'heading-regular'),
		'pb-30 m-tb-n5'
	]
]);
// Menu
$menu = $this->get_setting('menu','');
$link_class = implode(' ', array_filter([
	'text-'.$this->get_setting('link_color', 'white'),
	'text-hover-'.$this->get_setting('link_color_hover', 'white'),
	'text-active-'.$this->get_setting('link_color_hover', 'white'),
	'bg-menu bg-hover-accent-regular bg-active-accent-regular',
	'cms-hover-move-icon-right',
	'cms-hover-change'
]));
// icon
$menu_icon = genzia_svgs_icon([
	'icon'      => 'arrow-right',
	'icon_size' => 10,
	'class'     => 'menu-icon',
	'echo'      => false
]);
if ( ! empty( $menu ) ) : ?>
	<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
		<h6 <?php ctc_print_html( $this->get_render_attribute_string( 'title' ) ); ?>><?php 
			echo ctc_print_html( $settings['title'] ); 
		?></h6>
		<?php 
			wp_nav_menu( array(
				'fallback_cb'     => '',
				'walker'          => '',
				'container'		  => '',
				'container_class' => '',
				'menu'            => $menu,
				'menu_class'      => 'cms-menu',
				'link_class'	  => $link_class,
				'depth'           => 1,
				'link_after'	  => $menu_icon,
				'theme_location'  => ''
			)); 
		?>
	</div>
<?php  endif;  ?>