<?php
class CSS_Generator
{
	/**
	 * scssc class instance
	 *
	 * @access protected
	 * @var scssc
	 */
	protected $scssc = null;
	protected $child_scssc = null;

	/**
	 * Debug mode is turn on or not
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $dev_mode = true;
	/**
	 * Create CSS Map file
	 *
	 */
	protected $dev_mode_map = true;
	/**
	 * opt_name
	 *
	 * @access protected
	 * @var string
	 */
	protected $opt_name = '';

	/**
	 * Constructor
	 */
	function __construct()
	{
		$this->opt_name = genzia_get_opt_name();

		if (empty($this->opt_name)) {
			return;
		}
		$this->dev_mode = genzia_get_opt('dev_mode', '0') === '1' ? true : false;
		add_action('init', array($this, 'init'));
		if ($this->dev_mode !== true && file_exists($this->delete_css_map())) {
			wp_delete_file($this->delete_css_map());
		}
	}

	/**
	 * init hook - 10
	 */
	function init()
	{
		if (!class_exists('\ScssPhp\ScssPhp\Compiler')) {
			return;
		}
		add_action('wp', array($this, 'generate_with_dev_mode'));
	}

	function generate_with_dev_mode()
	{
		if ($this->dev_mode === true) {
			$this->generate_file();
			$this->generate_min_file();
		}
	}
	function delete_css_map()
	{
		return get_template_directory() . '/assets/css/theme.css.map';
	}
	/**
	 * Generate options and css files
	 */
	function generate_file()
	{
		global $wp_filesystem;
		if (!is_a($wp_filesystem, 'WP_Filesystem_Base')) {
			$creds = request_filesystem_credentials(home_url());
			wp_filesystem($creds);
		}
		$scss_dir = get_template_directory() . '/assets/scss/';
		$css_dir = get_template_directory() . '/assets/css/';
		$css_file = $css_dir . 'theme.css';
		// Build CSS
		$this->scssc = new \ScssPhp\ScssPhp\Compiler();
		$this->scssc->setImportPaths($scss_dir);
		// Optimize CSS
		$this->scssc->setOutputStyle(\ScssPhp\ScssPhp\OutputStyle::COMPRESSED);
		// Build Theme Options
		$_options = $scss_dir . 'theme_variables.scss';
		$wp_filesystem->put_contents(
			$_options,
			preg_replace("/(?<=[^\r]|^)\n/", "\r\n", $this->options_output()),
			FS_CHMOD_FILE
		);
		// Source Map
		$this->scssc->setSourceMap(\ScssPhp\ScssPhp\Compiler::SOURCE_MAP_FILE);
		$this->scssc->setSourceMapOptions([
			// relative or full url to the above .map file
			'sourceMapWriteTo' => $css_file . ".map",
			'sourceMapURL' => 'theme.css.map',

			// (optional) relative or full url to the .css file
			'sourceMapFilename' => $css_file,

			// partial path (server root) removed (normalized) to create a relative url
			'sourceMapBasepath' => $scss_dir, //'/var/www/vhost',

			// (optional) prepended to 'source' field entries for relocating source files
			'sourceRoot' => $scss_dir,
		]);

		// CSS
		$result = $this->scssc->compileString('@import "theme.scss";');
		$wp_filesystem->put_contents(
			$css_file . '.map',
			preg_replace("/(?<=[^\r]|^)\n/", "\r\n", $result->getSourceMap()),
			FS_CHMOD_FILE
		);
		$wp_filesystem->put_contents(
			$css_file,
			preg_replace("/(?<=[^\r]|^)\n/", "\r\n", $result->getCss()),
			FS_CHMOD_FILE
		);
		// Build Child-Theme CSS
		if (is_child_theme()) {
			// Child Theme
			$child_scss_dir = get_stylesheet_directory() . '/assets/scss/';
			$child_css_dir = get_stylesheet_directory() . '/assets/css/';
			$this->child_scssc = new \ScssPhp\ScssPhp\Compiler();
			$this->child_scssc->setImportPaths($child_scss_dir);
			$this->child_scssc->setOutputStyle(\ScssPhp\ScssPhp\OutputStyle::COMPRESSED);
			$child_css_file = $child_css_dir . 'child-theme.css';
			$child_result = $this->child_scssc->compileString('@import "child-theme.scss";');

			$wp_filesystem->put_contents(
				$child_css_file,
				preg_replace("/(?<=[^\r]|^)\n/", "\r\n", $child_result->getCss()),
				FS_CHMOD_FILE
			);
		}
	}
	/**
	 * Generate options and min css files
	 */
	function generate_min_file()
	{
		global $wp_filesystem;
		if (!is_a($wp_filesystem, 'WP_Filesystem_Base')) {
			$creds = request_filesystem_credentials(home_url());
			wp_filesystem($creds);
		}
		$scss_dir = get_template_directory() . '/assets/scss/';
		$css_dir = get_template_directory() . '/assets/css/';
		$css_file = $css_dir . 'theme.min.css';
		// Build CSS
		$this->scssc = new \ScssPhp\ScssPhp\Compiler();
		$this->scssc->setImportPaths($scss_dir);
		// Optimize CSS
		$this->scssc->setOutputStyle(\ScssPhp\ScssPhp\OutputStyle::COMPRESSED);
		// Build Theme Options
		$_options = $scss_dir . 'theme_variables.scss';
		$wp_filesystem->put_contents(
			$_options,
			preg_replace("/(?<=[^\r]|^)\n/", "\r\n", $this->options_output()),
			FS_CHMOD_FILE
		);
		// CSS
		$result = $this->scssc->compileString('@import "theme.scss";');
		$wp_filesystem->put_contents(
			$css_file,
			preg_replace("/(?<=[^\r]|^)\n/", "\r\n", $result->getCss()),
			FS_CHMOD_FILE
		);
	}
	protected function options_output()
	{
		ob_start();
		// single css options
		printf('%s', $this->print_single_scss_opt());
		// Theme Colors
		printf('%s', $this->print_theme_colors());
		return ob_get_clean();
	}
	protected function print_single_scss_opt()
	{
		ob_start();
		$accent_color = genzia_configs('accent_color');
		$primary_color = genzia_configs('primary_color');
		$custom_color = genzia_configs('custom_color');
		$container_width = genzia_configs('container_width');
		// Container Width
		printf('$elementor_container_width:%1$spx;', $container_width);
		// color
		foreach ($accent_color as $key => $value) {
			printf('$accent_color_%1$s: %2$s;', str_replace(['#', ' '], [''], $key), $value);
		}
		foreach ($primary_color as $key => $value) {
			printf('$primary_color_%1$s: %2$s;', str_replace(['#', ' '], [''], $key), $value);
		}
		foreach ($custom_color as $key => $value) {
			printf('$custom_color_%1$s: %2$s;', str_replace(['#', ' '], [''], $key), $value['value']);
		}
		return ob_get_clean();
	}
	protected function print_theme_colors()
	{
		$color = genzia_theme_colors();
		$_color = [];
		unset($color['']);
		unset($color['custom']);
		foreach ($color as $key => $value) {
			$_color[] = '\'' . $key . '\'';
		}
		return '$cms_theme_colors:(' . implode(',', $_color) . ');';
	}
}

new CSS_Generator();