<?php

namespace WML;



class WP_MAIL_LOG
{


	private $wml_title = "WP Mail Log";
	public static $instance;

	public $helper;

	public static function get_instance()
	{
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct()
	{
		$this->register_autoloader();

		//Register Rest API
		add_action('rest_api_init', [$this, 'init_rest_api']);

		//Add Adimn Menu Setting Page
		add_action('admin_menu', [$this, 'admin_menu']);

		//Add Setting Page Header
		add_action('in_admin_header',  array($this, 'in_admin_header'));

		//Create Table
		add_action('plugins_loaded', ['WML\Classes\DbTable', 'wml_plugin_activated']);

		// Caputure Mail Register Filter
		add_filter('wp_mail', ['WML\Classes\Capture_Mail', 'log_email']);

		// for admin scripts & styles
		add_action('admin_enqueue_scripts', [$this, '_admin_enqueue_scripts']);
	}

	public function admin_menu()
	{
		add_menu_page(
			__('WP Mail Log', 'wpv-wml'),
			__('WP Mail Log', 'wpv-wml'),
			'manage_options',
			'wp-mail-log',
			array($this, 'create_wp_mail_page'),
			// 'dashicons-chart-line',
			'dashicons-email-alt',
			25
		);
		add_submenu_page('wp-mail-log', __('WP Mail Logs', 'wpv-wml'), __('Emails Logs', 'wpv-wml'), 'manage_options', 'wp-mail-log', array($this, 'create_wp_mail_page'), 1);
		//add_submenu_page('wp-mail-log', __('WP Mail Analytics', 'wpv-wml'), 'Emails Analytics', 'publish_posts', 'wp-mail-analytics', array($this, 'show_mail_analytics'), 2);
	}


	public function in_admin_header()
	{
		$nav_links = $this->get_nav_links();
		$current_screen = get_current_screen();
		if (!isset($nav_links[$current_screen->id])) {
			return;
		} ?>
		<div class="wml-topbar">
			<div class="wml-branding">
				<div class="wml-logo">
					<svg width="831px" height="775px" viewBox="0 0 831 775" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
						<!-- Generator: Sketch 57.1 (83088) - https://sketch.com -->
						<title>El-logo-blue</title>
						<desc>Created with Sketch.</desc>
						<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<g id="El-logo-blue" fill-rule="nonzero">
								<path d="M227.7,160.1 C227.7,155.8 229,151.8 231.3,148.5 C232.4,146.8 233.8,145.3 235.3,144.1 C238.9,141.1 243.5,139.3 248.5,139.3 L582.7,139.3 C587,139.3 591,140.6 594.3,142.9 C596.5,144.4 598.4,146.3 599.9,148.5 C602.1,151.8 603.5,155.8 603.5,160.1 L603.5,394.9 L830.8,257.3 L446.5,10.2 C427.4,-2.1 402.9,-2.1 383.8,10.2 L0.3,257.2 L227.6,394.8 L227.6,160.1 L227.7,160.1 Z" id="Path" fill="#154DAE"></path>
								<path d="M599.9,148.5 C598.4,146.3 596.5,144.4 594.3,142.9 C591,140.7 587,139.3 582.7,139.3 L248.5,139.3 C243.5,139.3 238.9,141.1 235.3,144.1 C233.8,145.4 232.4,146.9 231.3,148.5 C229.1,151.8 227.7,155.8 227.7,160.1 L227.7,394.8 L283.2,428.4 L329.1,456.2 L382.3,488.4 C402.8,500.8 428.4,500.8 448.8,488.4 L503.7,455.7 L549.5,427.5 L603.4,394.9 L603.4,160.1 C603.5,155.8 602.2,151.8 599.9,148.5 Z M368.5,182.9 L462.7,182.9 C469.5,182.9 475,188.4 475,195.2 C475,202 469.5,207.5 462.7,207.5 L368.5,207.5 C361.7,207.5 356.2,202 356.2,195.2 C356.2,188.4 361.7,182.9 368.5,182.9 Z M495.6,384.8 L335.6,384.8 C328.8,384.8 323.3,379.3 323.3,372.5 C323.3,365.7 328.8,360.2 335.6,360.2 L495.6,360.2 C502.4,360.2 507.9,365.7 507.9,372.5 C507.9,379.3 502.4,384.8 495.6,384.8 Z M342.1,313.4 C342.1,306.6 347.6,301.1 354.4,301.1 L476.6,301.1 C483.4,301.1 488.9,306.6 488.9,313.4 C488.9,320.2 483.4,325.7 476.6,325.7 L354.5,325.7 C347.7,325.7 342.1,320.2 342.1,313.4 Z M515.5,266.6 L315.7,266.6 C308.9,266.6 303.4,261.1 303.4,254.3 C303.4,247.5 308.9,242 315.7,242 L515.5,242 C522.3,242 527.8,247.5 527.8,254.3 C527.8,261.1 522.3,266.6 515.5,266.6 Z" id="Shape" fill="#F2F2F2"></path>
								<polygon id="Path" fill="#154DAE" points="101.1 694.3 329.1 456.2 283.2 428.4"></polygon>
								<polygon id="Path" fill="#154DAE" points="732.3 694.3 549.6 427.5 503.8 455.7"></polygon>
								<path d="M830.8,736.5 L830.8,257.2 L830.8,257.2 L603.5,394.8 L549.6,427.4 L732.4,694.2 L503.8,455.7 L448.9,488.4 C428.4,500.8 402.8,500.8 382.4,488.4 L329.2,456.2 L101.1,694.3 L283.2,428.4 L227.7,394.8 L0.4,257.2 L0.4,707.7 L0.4,736.5 C0.4,757.8 17.7,775 38.9,775 L792.3,775 C813.6,775 830.8,757.8 830.8,736.5 Z" id="Path" fill="#1B5ED7"></path>
								<path d="M368.5,207.6 L462.7,207.6 C469.5,207.6 475,202.1 475,195.3 C475,188.5 469.5,183 462.7,183 L368.5,183 C361.7,183 356.2,188.5 356.2,195.3 C356.2,202.1 361.7,207.6 368.5,207.6 Z" id="Path" fill="#154DAE"></path>
								<path d="M515.5,242 L315.7,242 C308.9,242 303.4,247.5 303.4,254.3 C303.4,261.1 308.9,266.6 315.7,266.6 L515.5,266.6 C522.3,266.6 527.8,261.1 527.8,254.3 C527.8,247.5 522.3,242 515.5,242 Z" id="Path" fill="#154DAE"></path>
								<path d="M476.7,325.7 C483.5,325.7 489,320.2 489,313.4 C489,306.6 483.5,301.1 476.7,301.1 L354.5,301.1 C347.7,301.1 342.2,306.6 342.2,313.4 C342.2,320.2 347.7,325.7 354.5,325.7 L476.7,325.7 Z" id="Path" fill="#154DAE"></path>
								<path d="M495.6,360.1 L335.6,360.1 C328.8,360.1 323.3,365.6 323.3,372.4 C323.3,379.2 328.8,384.7 335.6,384.7 L495.6,384.7 C502.4,384.7 507.9,379.2 507.9,372.4 C507.9,365.6 502.4,360.1 495.6,360.1 Z" id="Path" fill="#154DAE"></path>
							</g>
						</g>
					</svg>
				</div>

				<h1><?php echo $this->wml_title; ?></h1>
				<span class="wml-version"><?php echo WML_VERSION; ?></span>
			</div>
		</div>

	<?php
	}

	function get_nav_links()
	{

		$nav = [
			'toplevel_page_wp-mail-log' => [
				'label' => __('Email Logs', 'wpv-wml'),
				'link'  => admin_url('admin.php?page=wp-mail-log'),
				'top_nav' => true
			],

			// 'wp-mail-log_page_wp-mail-analytics' => [
			// 	'label' => __('Email Analytics', 'wpv-wml'),
			// 	'link'  => admin_url('admin.php?page=wp-mail-analytics'),
			// 	'top_nav' => true
			// ],
		];

		$nav = apply_filters('wml/nav_links', $nav);

		return $nav;
	}

	public function create_wp_mail_page()
	{ ?>
		<div class="wml-content-section">
			<div id="wml-content"></div>
		</div>
<?php
	}


	function _admin_enqueue_scripts()
	{
		wp_enqueue_style('wml-admin-style', WML_URL . 'assets/css/admin.css', [], WML_VERSION);
		wp_enqueue_style('log-style', WML_URL . 'assets/js/app.css', [], WML_VERSION);
		wp_enqueue_script('log-js', WML_URL . 'assets/js/app.js', [], WML_VERSION,   true);
		wp_localize_script('log-js', 'WmlGlobalVar', [
			'site_url'        => site_url(),
			'ajax_url'        => admin_url('admin-ajax.php'),
			'admin_url'       => admin_url(),
			'rest_url'        => get_rest_url(),
			'nonce'           => wp_create_nonce('wp_rest'),
			'ajax_nonce'      => wp_create_nonce('fv_ajax_nonce'),
		]);
	}

	function init_rest_api()
	{
		$controllers = [
			new \WML\Classes\Api,
		];
		// echo "<pre>";
		// print_r($controllers);
		// echo "</pre>";
		foreach ($controllers as $controller) {
			$controller->register_routes();
		}
	}



	private function register_autoloader()
	{
		spl_autoload_register([__CLASS__, 'autoload']);
	}

	public function autoload($class)
	{

		if (0 !== strpos($class, __NAMESPACE__)) {
			return;
		}

		if (!class_exists($class)) {

			$filename = strtolower(
				preg_replace(
					['/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/'],
					['', '$1-$2', '-', DIRECTORY_SEPARATOR],
					$class
				)
			);

			$filename = WML_PATH . $filename . '.php';

			if (is_readable($filename)) {
				include $filename;
			}
		}
	}
}

WP_MAIL_LOG::get_instance();
