<?php
	if ( empty( $settings['map_address'] ) ) {
		return;
	}
	if ( 0 === absint( $settings['zoom']['size'] ) ) {
		$settings['zoom']['size'] = 10;
	}
	$api_key = genzia_get_opt('gm_api_key');;
	$params = [
		rawurlencode( $settings['map_address'] ),
		absint( $settings['zoom']['size'] ),
	];
	if ( $api_key ) {
		$params[] = $api_key;
		$map_url = 'https://www.google.com/maps/embed/v1/place?key=%3$s&q=%1$s&amp;zoom=%2$d';
	} else {
		$map_url = 'https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;output=embed&amp;iwloc=near';
	}
// Wrap
$this->add_render_attribute('wrap', [
	'class' => [
		'cms-egmap',
		'cms-egmap-'.$settings['layout'],
		'relative'
	]
]);
?>
<div <?php ctc_print_html($this->get_render_attribute_string('wrap')); ?>>
	<?php wealth_print_iframe([
		'src'        => esc_url( vsprintf( $map_url, $params ) ),
		'title'      => $settings['map_address'],
		'aria-label' => $settings['map_address']
	]); ?>
</div>