<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       wordpress.test
 * @since      1.0.0
 *
 * @package    Bp
 * @subpackage Bp/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Bp
 * @subpackage Bp/includes
 * @author     Philip Angelin <philip_angelin@hotmail.com>
 */
class Bp {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Bp_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'BP_VERSION' ) ) {
			$this->version = BP_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'bp';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		// widgets
		$this->register_widget('WeatherWidget');
		$this->register_widget('DogWidget');

		// ajax
		$this->register_ajax_action('bp_random_dog__get');
		$this->register_ajax_action('ajax_bp_current_weather__get');
		$this->ajax_bp_current_weather__get();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Bp_Loader. Orchestrates the hooks of the plugin.
	 * - Bp_i18n. Defines internationalization functionality.
	 * - Bp_Admin. Defines all hooks for the admin area.
	 * - Bp_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bp-loader.php';

		/**
		 * The class that controls the weather widget.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bp-weather-widget.php';

		/**
		 * The logic for the OWM API.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/owmapi.php';

		/**
		 * The class that controls the dog widget.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bp-dog-widget.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bp-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-bp-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-bp-public.php';

		$this->loader = new Bp_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Bp_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Bp_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Bp_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Bp_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * Registers widgets.
	 * 
	 * Params: (string $widget) - class name of the widget file, required
	 *
	 * @since    1.0.0
	 */
	public function register_widget(string $widget) {
		add_action('widgets_init', function() use ($widget){
			register_widget($widget);
		});
	}

	/**
	 * Registers Ajax actions.
	 * 
	 * Params: (string $ajax_action) - name of the Ajax action, required
	 *
	 * @since    1.0.0
	 */
	public function register_ajax_action(string $ajax_action) {
		add_action('wp_ajax_' . $ajax_action, [$this, 'ajax_' . $ajax_action]);
		add_action('wp_ajax_nopriv_' . $ajax_action, [$this, 'ajax_' . $ajax_action]);
	}

	public function ajax_bp_current_weather__get() {
		/*$current_weather_request = owm_get_current_weather($_POST['city'], $_POST['country']);

		if ($current_weather_request['success']) {
			wp_send_json_success($current_weather_request['data']);
		} else {
			wp_send_json_error($current_weather_request['error']);
		}*/
	}

	public function ajax_bp_random_dog__get() {
		$response = wp_remote_get(BP_RANDOM_DOG_URL);
		if (is_wp_error($response) || wp_remote_retrieve_response_code($response) != 200) {
			wp_send_json_error([
				'error_code' => wp_remote_retrieve_response_code($response),
				'error_msg' => wp_remote_retrieve_response_message($response)
			]);
		}

		$file_extension = strtolower(
			pathinfo(
				parse_url(
					json_decode(wp_remote_retrieve_body($response))->url,
					PHP_URL_PATH
				), 
				PATHINFO_EXTENSION
			)
		);
		$video_extensions = ['mp4', 'avi', 'ogv'];

		wp_send_json_success([
			'type' => in_array($file_extension, $video_extensions) ? 'video' : 'image',
			'src' => json_decode(wp_remote_retrieve_body($response))->url,
		]);
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Bp_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
