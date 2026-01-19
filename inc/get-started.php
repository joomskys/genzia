<?php
if (!class_exists('CMS_PORTAL')) {
	// Welcome page
	add_action('admin_menu', 'genzia_add_welcome_page');
	function genzia_add_welcome_page()
	{
		$current_theme = wp_get_theme();
		if (is_child_theme()) {
			$current_theme = $current_theme->parent();
		}
		add_submenu_page('themes.php', esc_html__('About', 'genzia') . ' ' . $current_theme->get('Name'), esc_html__('About', 'genzia') . ' ' . $current_theme->get('Name'), 'manage_options', "{$current_theme->get('TextDomain')}-welcome", 'genzia_welcome_page');
	}

	function genzia_welcome_page()
	{
		$current_theme = wp_get_theme();
		if (is_child_theme()) {
			$current_theme = $current_theme->parent();
		}
		$theme_name = $current_theme->get('Name');
		$theme_version = $current_theme->get('Version');
		?>
		<div class="welcome-page">
			<div class="welcome-page-inner">
				<div class="welcome-page-content">
					<div class="welcome-page-title">
						<span>
							<?php esc_html_e('Welcome to', 'genzia') ?>
						</span>
						<span>
							<?php echo esc_html($theme_name . ' v' . $theme_version); ?>
						</span>
					</div>
					<div class="welcome-page-description">
						<span>
							<?php esc_html_e('In order to continue, please install and activate', 'genzia') ?>
						</span>
						<span class="font-weight-bold font-italic">
							<?php echo esc_html('CMS Portal Plugin') ?>
						</span>
					</div>
					<div class="welcome-page-actions">
						<?php if (genzia_is_installed_portal_plugin()): ?>
							<button type="button" id="btn-cms-get-started" class="button button-primary btn-activate"
								data-nonce="<?php echo wp_create_nonce('genzia_get_started_nonce'); ?>"><?php esc_html_e('Activate', 'genzia') ?></button>
						<?php else: ?>
							<button type="button" id="btn-cms-get-started" class="button button-primary btn-install"
								data-nonce="<?php echo wp_create_nonce('genzia_get_started_nonce'); ?>"><?php esc_html_e('Install', 'genzia') ?></button>
						<?php endif; ?>
						<p id="cms-alert" style="display: none; color: red;"></p>
					</div>
					<div class="welcome-page-note font-italic">
						<span style="color: red;">*</span>
						<span>
							<?php esc_html_e("CMS Portal Plugin will allow you to update theme, install required plugins", 'genzia') ?>
						</span>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	function genzia_is_installed_portal_plugin()
	{
		$cms_portal = get_plugins('/cms-portal');
		return is_array($cms_portal) && count($cms_portal) > 0;
	}

	function genzia_activate_portal_plugin()
	{
		return activate_plugin('cms-portal/cms-portal.php') === null;
	}

	if (!function_exists('genzia_admin_notice_get_started')) {
		add_action('admin_notices', 'genzia_admin_notice_get_started');
		function genzia_admin_notice_get_started()
		{
			$current_theme = wp_get_theme();
			if (is_child_theme()) {
				$current_theme = $current_theme->parent();
			}
			$screen = get_current_screen();
			if ($screen->parent_file == $current_theme->get('TextDomain') . '-welcome' || $screen->parent_file == 'themes.php') {
				return;
			}

			$theme_name = $current_theme->get('Name');
			$theme_desc = $current_theme->get('Description');
			$theme_author = $current_theme->get('Author');
			$theme_author_uri = $current_theme->get('AuthorURI');
			$theme_logo = get_template_directory_uri() . '/assets/images/logo/logo.png';
			?>
			<div class="gt-notice notice is-dismissible">
				<div class="gt-notice-inner">
					<div class="gt-notice-logo">
						<img src="<?php echo esc_attr($theme_logo) ?>" alt="<?php echo esc_attr($theme_name) ?>"
							style="max-width: 200px;">
					</div>
					<div class="gt-notice-body">
						<span class="gt-theme-author">
							<?php echo esc_html__('By', 'genzia') ?>
							<a href="<?php echo esc_attr($theme_author_uri); ?>"><?php echo esc_html($theme_author); ?></a>
						</span>
						<hr class="gt-divide">
						<div class="gt-theme-description">
							<?php echo esc_html($theme_desc); ?>
						</div>
						<hr class="gt-divide">
						<div class="gt-notice-actions">
							<div class="gt-notice-actions-description">
								<span>
									<?php esc_html_e('In order to continue, please install and activate', 'genzia') ?>
								</span>
								<span class="font-weight-bold font-italic">
									<?php echo esc_html('CMS Portal Plugin') ?>
								</span>
							</div>
							<?php if (genzia_is_installed_portal_plugin()): ?>
								<button type="button" id="btn-cms-get-started" class="button button-primary btn-activate"
									data-nonce="<?php echo wp_create_nonce('genzia_get_started_nonce'); ?>"><?php esc_html_e('Activate', 'genzia') ?></button>
							<?php else: ?>
								<button type="button" id="btn-cms-get-started" class="button button-primary btn-install"
									data-nonce="<?php echo wp_create_nonce('genzia_get_started_nonce'); ?>"><?php esc_html_e('Install', 'genzia') ?></button>
							<?php endif; ?>
							<span id="cms-alert" style="display: none; color: red; margin-left: 15px;"></span>
							<div class="gt-notice-actions-note font-italic">
								<span style="color: red;">*</span>
								<span>
									<?php esc_html_e("CMS Portal Plugin will allow you to update theme, install required plugins", 'genzia') ?>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}

	add_action('wp_ajax_get_started', 'genzia_get_started');
	if (!function_exists('genzia_get_started')) {
		function genzia_get_started()
		{
			try {
				if (!check_ajax_referer('genzia_get_started_nonce'))
					throw new Exception(esc_html__('Invalid nonce!', 'genzia'));

				// Check if user is administrator
				$current_user = wp_get_current_user();
				if (!in_array('administrator', (array) $current_user->roles))
					throw new Exception(esc_html__('You are not allowed to do this!', 'genzia'));

				// Install CMS Portal plugin if not installed
				if (!genzia_is_installed_portal_plugin()) {
					// Get CMS Portal plugin link
					$request = wp_remote_post(
						'https://core.7oroofthemes.com/wp-json/api-bearer-auth/v1/get-started'
					);
					$responseCode = wp_remote_retrieve_response_code($request);
					if ($responseCode !== 200) {
						throw new Exception(esc_html__('Fail to get plugin link!', 'genzia'));
					}
					$body = @json_decode(wp_remote_retrieve_body($request));
					if (!isset($body->download_link) || empty($body->download_link))
						throw new Exception(esc_html__('Not found plugin link!', 'genzia'));
					if (strpos($body->download_link, 'https://core.7oroofthemes.com/') !== 0) {
						throw new Exception(esc_html__('Invalid plugin source!', 'genzia'));
					}

					require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
					include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

					$skin = new WP_Ajax_Upgrader_Skin();
					$upgrader = new Plugin_Upgrader($skin);
					$install_result = $upgrader->install($body->download_link);

					if (!$install_result)
						throw new Exception(esc_html__('Fail to install plugin!', 'genzia'));
				}
				if (!genzia_activate_portal_plugin())
					throw new Exception(esc_html__('Fail to activate plugin!', 'genzia'));

				$current_theme = wp_get_theme();
				if (is_child_theme()) {
					$current_theme = $current_theme->parent();
				}

				$result = [
					'stt' => true,
					'msg' => esc_html__('Successfully!', 'genzia'),
					'data' => [
						'redirect_url' => admin_url('admin.php?page=' . $current_theme->get('TextDomain'))
					],
				];
			} catch (Exception $e) {
				$result = [
					'stt' => false,
					'msg' => $e->getMessage(),
					'data' => '',
				];
			}

			wp_send_json($result);
			die();
		}
	}
}

add_action('after_switch_theme', 'genzia_redirect_to_welcome_page');
function genzia_redirect_to_welcome_page()
{
	$current_theme = wp_get_theme();
	if (is_child_theme()) {
		$current_theme = $current_theme->parent();
	}

	if (class_exists('CMS_PORTAL')) {
		wp_safe_redirect(admin_url("themes.php?page={$current_theme->get('TextDomain')}"));
	} else {
		wp_safe_redirect(admin_url("themes.php?page={$current_theme->get('TextDomain')}-welcome"));
	}
}

?>