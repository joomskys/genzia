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
		'cms-title',
		'heading h5',
		'text-'.$this->get_setting('title_color', 'heading-regular'),
		'm-tb-n7 pb-23',
	]
]);
// Menu
$menu = $this->get_setting('menu','');
$menu2 = $this->get_setting('menu2','');
$link_class = implode(' ', array_filter([
	'text-'.$this->get_setting('link_color', 'menu'),
	'text-hover-'.$this->get_setting('link_color_hover', 'white'),
	'text-active-'.$this->get_setting('link_color_hover', 'white'),
	'bg-hover-accent-regular bg-active-accent-regular',
	'p-lr-hover-24 p-lr-active-24',
	'd-flex flex-nowrap justify-content-between w-100',
	'cms-hover-move-icon-right',
]));
$menu_icon = genzia_svgs_icon(['icon' => 'arrow-right', 'icon_size' => 10, 'icon_class' => 'cms-menu-icon order-last', 'echo' => false]);
//
if ( ! empty( $menu ) ) : ?>
	<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
		<div <?php ctc_print_html( $this->get_render_attribute_string( 'title' ) ); ?>>
			<?php echo ctc_print_html( $settings['title'] ); ?>
        </div>
        <div class="d-flex gutter-40 gutter-smobile-0">
        	<div class="col-6 col-smobile-12"><?php 
				wp_nav_menu( array(
					'fallback_cb'     => '',
					'walker'          => '',
					'container'       => '',
					'container_class' => '',
					'menu'            => $menu,
					'menu_class'      => 'cms-navigation-menu cms-menu text-sm font-500',
					'link_class'      => $link_class,
					'link_before'	  => $menu_icon,	
					'depth'           => 1,
					'theme_location'  => ''
				)); 
			?></div>
			<div class="col-6 col-smobile-12"><?php 
				wp_nav_menu( array(
					'fallback_cb'     => '',
					'walker'          => '',
					'container'       => '',
					'container_class' => '',
					'menu'            => $menu2,
					'menu_class'      => 'cms-navigation-menu cms-menu text-sm font-500',
					'link_class'      => $link_class,
					'link_before'	  => $menu_icon,	
					'depth'           => 1,
					'theme_location'  => ''
				)); 
			?></div>
		</div>
	</div>
<?php  endif;  ?>