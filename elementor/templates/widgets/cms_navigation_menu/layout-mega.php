<?php
// Wrap
$this->add_render_attribute('wrap',[
	'class' => [
		'cms-emenu',
		'cms-emenu-'.$settings['layout']
	]
]);
// Title
$this->add_render_attribute( 'title', [
	'class' => [
		'cms-title',
		'heading text-xl',
		'text-'.$this->get_setting('title_color', 'heading-regular'),
		'pb-23',
	]
]);
$this->add_render_attribute( 'title_link', [
	'class' => [
		'text-'.$this->get_setting('title_color', 'heading-regular'),
		'cms-hover-underline',
		'd-inline-block'
	],
	'href' => genzia_elementor_link_url_render($this, $settings, ['name' => 'custom_link', 'echo' => false, 'suffix' => false])
]);
// Menu
$menu = $this->get_setting('menu','');
if ( ! empty( $menu ) ) : ?>
	<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
		<div <?php ctc_print_html($this->get_render_attribute_string('title')) ?>>
			<a <?php ctc_print_html($this->get_render_attribute_string('title_link')) ?>><?php echo ctc_print_html( $settings['title'] ); ?></a>
		</div>
		<?php 
			wp_nav_menu( array(
				'fallback_cb'     => '',
				'walker'          => '',
				'container'       => '',
				'container_class' => '',
				'menu'            => $menu,
				'menu_class'      => 'cms-dropdown-mega',
				'li_class'		  => 'cms-dropdown-mega-item',
				'link_class'      => '',
				'depth'           => 1,
				'link_before' 	  => '', //genzia_cms_menu_child_icon(),
				'theme_location'  => ''
			)); 
		?>
	</div>
<?php  endif;  ?>