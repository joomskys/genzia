<?php
/**
 * 
 * @package CMS Theme
 * @subpackage Allianz
 * @since 1.0
 * 
*/
if(!class_exists('WPCF7')) return;
/**
 * removing default submit tag
 */
remove_action('wpcf7_init', 'wpcf7_add_form_tag_submit');
/**
 * adding action with function which handles our button markup
 */
add_action('wpcf7_init', 'genzia_cf7_submit_button');
/**
 * adding out submit button tag
 */
if (!function_exists('genzia_cf7_submit_button')) {
	function genzia_cf7_submit_button() {
		wpcf7_add_form_tag('submit', 'genzia_cf7_submit_button_handler');
	}
}
/**
 * out button markup inside handler
 */
if (!function_exists('genzia_cf7_submit_button_handler')) {
	function genzia_cf7_submit_button_handler($tag) {
		$tag              = new WPCF7_FormTag($tag);
		$class            = wpcf7_form_controls_class($tag->type);
		$atts             = array();
		$atts['class']    = $tag->get_class_option($class);
		$atts['id']       = $tag->get_id_option();
		$atts['tabindex'] = $tag->get_option('tabindex', 'int', true);
		$value            = isset($tag->values[0]) ? $tag->values[0] : '';
		if (empty($value)) {
			$value = esc_html__('Send', 'genzia');
		}
		$atts['type'] = 'submit';
		// icon type
		$atts['icon_type'] = genzia_cf7_get_icon_type($tag->options);
		// icon
		$atts['icon'] = genzia_cf7_get_icon($tag->options);
		$atts['icon_class'] = genzia_cf7_get_icon_class($tag->options);
		$icon = '';
		if(isset($atts['icon']) && $atts['icon'] != ''){
			switch($atts['icon_type']){
				case 'svg':
					$icon = genzia_svgs_icon([
						'icon'      => $atts['icon'],
						'icon_size' => 10,
						'echo'      => false,
						'class'     => 'wpcf7-submit-icon rtl-flip '.$atts['icon_class']
					]);
					break;
				default:
					$icon = '<span class="wpcf7-submit-icon rtl-flip '.$atts['icon'].' '.$atts['icon_class'].'"></span>';
					break;
			}
		}
		// icon position
		$atts['icon_position'] = genzia_cf7_get_icon_position($tag->options);
		$icon_before = $icon_after = '';
		if(isset($atts['icon_position']) && $atts['icon_position'] === 'before'){
			$icon_before = $icon;
		} else{
			$icon_after = $icon;
		}
		$icon_loading = genzia_svgs_icon([
			'icon'  => 'core/spinner',
			'class' => 'loading',
			'echo'  => false
		]);
		//
		//
		unset($atts['icon_type']);
		unset($atts['icon']);
		unset($atts['icon_position']);
		unset($atts['icon_class']);
		$atts = wpcf7_format_atts($atts);	
		
		$html = sprintf('<button %1$s>%2$s%3$s%4$s%5$s</button>', $atts, $icon_before, '<span class="cms-on-hover-underline">'.$value.'</span>', $icon_after, $icon_loading);
		return $html;
	}
}
if(!function_exists('genzia_cf7_get_icon_type')){
	function genzia_cf7_get_icon_type($data, $default=''){
		if ( is_string( $default ) ) {
			$default = explode( ' ', $default );
		}
		$options = array_merge(
			(array) $default,
			(array) genzia_cf7_get_atts( $data, 'icon_type', 'icon_type' ) 
		);

		$options = array_filter( array_unique( $options ) );

		return implode( ' ', $options );
	}
}

if(!function_exists('genzia_cf7_get_icon')){
	function genzia_cf7_get_icon($data, $default=''){
		if ( is_string( $default ) ) {
			$default = explode( ' ', $default );
		}
		$options = array_merge(
			(array) $default,
			(array) genzia_cf7_get_atts( $data, 'icon', 'icon' )
		);

		$options = array_filter( array_unique( $options ) );

		return implode( ' ', $options );
	}
}
if(!function_exists('genzia_cf7_get_icon_class')){
	function genzia_cf7_get_icon_class($data, $default=''){
		if ( is_string( $default ) ) {
			$default = explode( ' ', $default );
		}
		$options = array_merge(
			(array) $default,
			(array) genzia_cf7_get_atts( $data, 'icon_class', 'icon_class' )
		);

		$options = array_filter( array_unique( $options ) );

		return implode( ' ', $options );
	}
}

if(!function_exists('genzia_cf7_get_icon_position')){
	function genzia_cf7_get_icon_position($data, $default=''){
		if ( is_string( $default ) ) {
			$default = explode( ' ', $default );
		}
		$options = array_merge(
			(array) $default,
			(array) genzia_cf7_get_atts( $data, 'icon_position', 'icon_position' )
		);

		$options = array_filter( array_unique( $options ) );

		return implode( ' ', $options );
	}
}

if(!function_exists('genzia_cf7_get_atts_name')){
	function genzia_cf7_get_atts_name($data, $name = '', $default=''){
		if ( is_string( $default ) ) {
			$default = explode( ' ', $default );
		}
		$options = array_merge(
			(array) $default,
			(array) genzia_cf7_get_atts( $data, $name, $name )
		);

		$options = array_filter( array_unique( $options ) );

		return implode( ' ', $options );
	}
}

function genzia_cf7_get_atts( $data, $opt, $pattern = '', $single = false ) {
	$preset_patterns = array(
		'date'          => '([0-9]{4}-[0-9]{2}-[0-9]{2}|today(.*))',
		'int'           => '[0-9]+',
		'signed_int'    => '-?[0-9]+',
		'class'         => '[-0-9a-zA-Z_]+',
		'icon_type'     => '[-0-9a-zA-Z_]+',
		//'icon'          => '[-0-9a-zA-Z_]+',
		'icon'          => '',
		'icon_position' => '[-0-9a-zA-Z_]+',
		'icon_class'    => '[-0-9a-zA-Z_]+',
		'id'            => '[-0-9a-zA-Z_]+',
		'before_text'   => '',
		'after_text'    => '',
	);

	if ( isset( $preset_patterns[$pattern] ) ) {
		$pattern = $preset_patterns[$pattern];
	}

	if ( '' == $pattern ) {
		$pattern = '.+';
	}

	$pattern = sprintf( '/^%s:%s$/i', preg_quote( $opt, '/' ), $pattern );

	if ( $single ) {
		$matches = genzia_cf7_get_first_match_option( $data, $pattern );

		if ( ! $matches ) {
			return false;
		}

		return substr( $matches[0], strlen( $opt ) + 1 );
	} else {
		$matches_a = genzia_cf7_get_all_match_options( $data, $pattern );

		if ( ! $matches_a ) {
			return false;
		}

		$results = array();

		foreach ( $matches_a as $matches ) {
			$results[] = substr( $matches[0], strlen( $opt ) + 1 );
		}

		return $results;
	}
}
function genzia_cf7_get_first_match_option( $options, $pattern ) {
	foreach( (array) $options as $option ) {
		if ( preg_match( $pattern, $option, $matches ) ) {
			return $matches;
		}
	}

	return false;
}
function genzia_cf7_get_all_match_options( $options, $pattern ) {
	$result = array();

	foreach( (array) $options as $option ) {
		if ( preg_match( $pattern, $option, $matches ) ) {
			$result[] = $matches;
		}
	}

	return $result;
}

// Add time tag
add_action( 'wpcf7_init', 'genzia_add_form_tag_time' );
function genzia_add_form_tag_time() {
    wpcf7_add_form_tag( ['time','time*'], 'genzia_time_form_tag_handler', array( 'name-attr' => true ) ); // "time" is the type of the form-tag
}
function genzia_time_form_tag_handler( $tag ) {
	if ( empty( $tag->name ) ) {
		return '';
	}

	$validation_error = wpcf7_get_validation_error( $tag->name );

	$class = wpcf7_form_controls_class( $tag->type, 'wpcf7-text' );

	if ( in_array( $tag->basetype, array( 'time', 'time*' ) ) ) {
		$class .= ' wpcf7-validates-as-' . $tag->basetype;
	}
	if ( $validation_error ) {
		$class .= ' wpcf7-not-valid';
	}
	$atts = array();
	$atts['class']    = $tag->get_class_option( $class );
	$atts['id']       = $tag->get_id_option();
	$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );

	if ( $tag->is_required() ) {
		$atts['aria-required'] = 'true';
	}

	if ( $validation_error ) {
		$atts['aria-invalid'] = 'true';
		$atts['aria-describedby'] = wpcf7_get_validation_error_reference(
			$tag->name
		);
	} else {
		$atts['aria-invalid'] = 'false';
	}
	// icon
	$atts['icon']          = genzia_cf7_get_icon($tag->options);
	$atts['icon_position'] = genzia_cf7_get_icon_position($tag->options);
	$icon_before = $icon_after = '';
	if ( $tag->has_option( 'icon' ) && $atts['icon'] !== ''){
		if($atts['icon_position'] === 'before'){
			$icon_before = '<span class="wpcf7-field-icon cms-field-icon '.$atts['icon'].'"> </span>';
		} else {
			$icon_after = '<span class="wpcf7-field-icon cms-field-icon '.$atts['icon'].'"> </span>';
		}
	}
	
	// placeholder
	$value = (string) reset( $tag->values );
	$placeholder = '';
	if ( $tag->has_option( 'placeholder' )
	or $tag->has_option( 'watermark' ) ) {
		$atts['placeholder'] = $value;
		$placeholder = '<span class="cms-time-placeholder cms-placeholder">'.$icon_before.$value.$icon_after.'</span>';
		$value = '';
	}
	
	$value = $tag->get_default_option( $value );
	$value = wpcf7_get_hangover( $tag->name, $value );
	$atts['value'] = $value;
	if ( wpcf7_support_html5() ) {
		$atts['type'] = $tag->basetype;
	} else {
		$atts['type']        = 'text';
		$atts['onfocus']     = '(this.type="time")';
		$atts['onmouseover'] = '(this.type="time")';
		$atts['onblur']      = '(this.type="time")';
	}

	$atts['name'] = $tag->name;
	unset($atts['icon']);
	unset($atts['icon_position']);
	unset($atts['placeholder']);
	// Generate attributes
	$atts = wpcf7_format_atts( $atts ); 
	$html = sprintf(
		'<span class="wpcf7-form-control-wrap cms-date-time cms-time %1$s">%2$s<input %3$s />%4$s</span>',
		sanitize_html_class( $tag->name ), $placeholder, $atts, $validation_error
	);

	return $html;
}
/* Time Tag generator */
//add_action( 'wpcf7_admin_init', 'wpcf7_add_tag_generator_cms_time', 10 );
function wpcf7_add_tag_generator_cms_time() {
	$tag_generator = WPCF7_TagGenerator::get_instance();
	$tag_generator->add( 'time', __( 'CMS Time', 'genzia' ),
		'wpcf7_tag_generator_cms_time' );
}
function wpcf7_tag_generator_cms_time( $contact_form, $args = '' ) {
	$args = wp_parse_args( $args, array() );

	$description = __( "Generate a form-tag for a CMS Time. For more details, see %s.", 'genzia' );

	$desc_link = wpcf7_link( __( 'https://contactform7.com/date-field/', 'genzia' ), __( 'CMS Time', 'genzia' ) );

?>
<div class="control-box">
<fieldset>
<legend><?php echo sprintf( esc_html( $description ), $desc_link ); ?></legend>

<table class="form-table">
<tbody>
	<tr>
	<th scope="row"><?php echo esc_html( __( 'Field type', 'genzia' ) ); ?></th>
	<td>
		<fieldset>
		<legend class="screen-reader-text"><?php echo esc_html( __( 'Field type', 'genzia' ) ); ?></legend>
		<label><input type="checkbox" name="required" /> <?php echo esc_html( __( 'Required field', 'genzia' ) ); ?></label>
		</fieldset>
	</td>
	</tr>

	<tr>
	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'genzia' ) ); ?></label></th>
	<td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
	</tr>

	<tr>
	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-values' ); ?>"><?php echo esc_html( __( 'Default value', 'genzia' ) ); ?></label></th>
	<td><input type="text" name="values" class="oneline" id="<?php echo esc_attr( $args['content'] . '-values' ); ?>" /><br />
	<label><input type="checkbox" name="placeholder" class="option" /> <?php echo esc_html( __( 'Use this text as the placeholder of the field', 'genzia' ) ); ?></label></td>
	</tr>


	<tr>
	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php echo esc_html( __( 'Id attribute', 'genzia' ) ); ?></label></th>
	<td><input type="text" name="id" class="idvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-id' ); ?>" /></td>
	</tr>

	<tr>
	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Class attribute', 'genzia' ) ); ?></label></th>
	<td><input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" /></td>
	</tr>

</tbody>
</table>
</fieldset>
</div>

<div class="insert-box">
	<input type="text" name="time" class="tag code" readonly="readonly" onfocus="this.select()" />

	<div class="submitbox">
	<input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'genzia' ) ); ?>" />
	</div>

	<br class="clear" />

	<p class="description mail-tag"><label for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"><?php echo sprintf( esc_html( __( "To use the value input through this field in a mail field, you need to insert the corresponding mail-tag (%s) into the field on the Mail tab.", 'genzia' ) ), '<strong><span class="mail-tag"></span></strong>' ); ?><input type="text" class="mail-tag code hidden" readonly="readonly" id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>" /></label></p>
</div>
<?php
}

// Custom date tag
remove_action('wpcf7_init', 'wpcf7_add_form_tag_date');
add_action( 'wpcf7_init', 'genzia_add_form_tag_cms_date' );
function genzia_add_form_tag_cms_date() {
    wpcf7_add_form_tag( ['date','date*'], 'genzia_cms_date_form_tag_handler', array( 'name-attr' => true ) ); // "time" is the type of the form-tag
}
function genzia_cms_date_form_tag_handler( $tag ) {
	if ( empty( $tag->name ) ) {
		return '';
	}

	$validation_error = wpcf7_get_validation_error( $tag->name );

	$class = wpcf7_form_controls_class( $tag->type, 'wpcf7-text' );

	if ( in_array( $tag->basetype, array( 'date', 'date*', 'tel' ) ) ) {
		$class .= ' wpcf7-validates-as-' . $tag->basetype;
	}
	if ( $validation_error ) {
		$class .= ' wpcf7-not-valid';
	}
	$atts = array();
	$atts['class']    = $tag->get_class_option( $class );
	$atts['id']       = $tag->get_id_option();
	$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );

	if ( $tag->is_required() ) {
		$atts['aria-required'] = 'true';
	}

	if ( $validation_error ) {
		$atts['aria-invalid'] = 'true';
		$atts['aria-describedby'] = wpcf7_get_validation_error_reference(
			$tag->name
		);
	} else {
		$atts['aria-invalid'] = 'false';
	}
	// icon
	$atts['icon']          = genzia_cf7_get_icon($tag->options);
	$atts['icon_position'] = genzia_cf7_get_icon_position($tag->options);
	$icon_before = $icon_after = '';
	if ( $tag->has_option( 'icon' ) && $atts['icon'] !== ''){
		if($atts['icon_position'] === 'before'){
			$icon_before = '<span class="wpcf7-field-icon cms-field-icon '.$atts['icon'].' pr-10"> </span>';
		} else {
			$icon_after = '<span class="wpcf7-field-icon cms-field-icon '.$atts['icon'].' pl-10"> </span>';
		}
	}

	// placeholder
	$value = (string) reset( $tag->values );
	$placeholder = '';
	if ( $tag->has_option( 'placeholder' )
	or $tag->has_option( 'watermark' ) ) {
		$atts['placeholder'] = $value;
		$placeholder = '<span class="cms-date-placeholder cms-placeholder">'.$icon_before.$value.$icon_after.'</span>';
		$value = '';
	}

	$value = $tag->get_default_option( $value );
	$value = wpcf7_get_hangover( $tag->name, $value );
	$atts['value'] = $value;
	if ( wpcf7_support_html5() ) {
		$atts['type'] = $tag->basetype;
		$atts['min'] = date('Y-m-d');
	} else {
		$atts['type']        = 'text';
		$atts['onfocus']     = '(this.type="date")';
		$atts['onmouseover'] = '(this.type="date")';
		$atts['onblur']      = '(this.type="date")';
	}
	$atts['name'] = $tag->name;
	
	unset($atts['icon_type']);
	unset($atts['icon']);
	unset($atts['icon_position']);
	unset($atts['placeholder']);
	// Generate attributes
	$atts = wpcf7_format_atts( $atts ); 
	$html = sprintf(
		'<span class="wpcf7-form-control-wrap cms-date-time cms-date %1$s">%2$s<input %3$s />%4$s</span>',
		sanitize_html_class( $tag->name ), $placeholder, $atts, $validation_error
	);

	return $html;
}