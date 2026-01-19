<?php
// Silence is golden.
$args = genzia_footer_opts([
	'default'       => $default,
	'default_value' => $default_value,
	'default_on'    => $default_off,
	'custom'        => $custom_opts
]);

return $args;