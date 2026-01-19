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
		'heading text-lg',
		'text-'.$this->get_setting('title_color', 'heading-regular'),
		'pb-20 m-tb-nlg'
	]
]);
// Menu
$menu = $this->get_setting('menu','');
$link_class = genzia_nice_class([
	'text-'.$this->get_setting('link_color','menu'),
	'text-hover-'.$this->get_setting('link_color_hover','accent-regular'),
	'text-active-'.$this->get_setting('link_color_hover','accent-regular')
]);
if ( ! empty( $menu ) ) : ?>
	<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
		<div <?php ctc_print_html( $this->get_render_attribute_string( 'title' ) ); ?>>
			<?php echo ctc_print_html( $settings['title'] ); ?>
        </div>
		<?php 
			wp_nav_menu( array(
				'fallback_cb'     => '',
				'walker'          => '',
				'container'       => '',
				'container_class' => '',
				'menu'            => $menu,
				'menu_class'      => 'cms-navigation-menu cms-menu cms-menu-hover-icon text-sm font-500',
				'link_class'      => $link_class,
				'link_before'	  => genzia_svgs_icon(['icon' => 'arrow-right', 'icon_size' => 10, 'icon_class' => 'cms-menu-icon', 'echo' => false]),	
				'depth'           => 1,
				'theme_location'  => ''
			)); 
		?>
	</div>
<?php  endif;  ?>