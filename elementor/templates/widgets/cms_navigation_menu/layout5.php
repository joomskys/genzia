<?php
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-emenu',
		'cms-emenu-'.$settings['layout'],
		'p-40 p-lr-tablet-20 p-lr-smobile-20',
		'bg-bg-light',
		'cms-radius-16'
	],
	'style' => '--cms-divider-color:'.$this->get_setting('divider_color','var(--cms-divider)').';'
]);
// Title
$this->add_inline_editing_attributes( 'title', 'none' );
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-title empty-none',
		'text-xl',
		'text-'.$this->get_setting('title_color', 'heading-regular'),
		'pb-33 m-tb-nxl'
	]
]);
// Menu
$menu = $this->get_setting('menu','');
$link_class = implode(' ', array_filter([
	'text-'.$this->get_setting('link_color', 'white'),
	'text-hover-'.$this->get_setting('link_color_hover', 'white'),
	'text-active-'.$this->get_setting('link_color_hover', 'white'),
	'bg-menu bg-hover-gradient-1 bg-active-gradient-1',
	'cms-hover-move-icon-right',
	'cms-hover-change',
	'cms-radius-6'
]));
// icon
$menu_icon = genzia_svgs_icon([
	'icon'      => 'arrow-right',
	'icon_size' => 10,
	'class'     => genzia_nice_class([
		'menu-icon',
		'cms-eicon',
		'cms-box-48 cms-radius-6',
		'bg-'.$this->get_setting('link__icon_bg','white'),
		'text-'.$this->get_setting('link__icon_color','menu'),
		'bg-hover-'.$this->get_setting('link__icon_bg_hover','white'),
		'bg-on-hover-'.$this->get_setting('link__icon_bg_hover','white'),
		'text-hover-'.$this->get_setting('link__icon_color_hover','accent-regular'),
		'text-on-hover-'.$this->get_setting('link__icon_color_hover','accent-regular')
	]),
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