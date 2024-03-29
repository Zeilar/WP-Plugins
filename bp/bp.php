<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              wordpress.test
 * @since             1.0.0
 * @package           Bp
 *
 * @wordpress-plugin
 * Plugin Name:       Boiler Plate
 * Plugin URI:        wordpress.test
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Philip Angelin
 * Author URI:        wordpress.test
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BP_VERSION', '1.0.0' );

/**
 * Fetches random dogs from API with this URL.
 * Rename this for your plugin and update it as you release new versions.
 */
define('BP_RANDOM_DOG_URL', 'https://random.dog/woof.json');

/**
 * Current version av Mappy Weathery widget
 */
define('BP_MAPPY_WEATHERY_VERSION', '1.0.0');

/**
 * Path and URL for Mappy Weathery widget
 */
define('BP_MAPPY_WEATHERY_DIR_URL', plugin_dir_url(__FILE__));
define('BP_MAPPY_WEATHERY_DIR_PATH', plugin_dir_path(__FILE__));

/**
 * Fetches random dogs from API with this URL.
 * Rename this for your plugin and update it as you release new versions.
 */
define('BP_OWM_URL', "http://api.openweathermap.org/data/2.5/weather?q={$owm_city},
{$owm_country}&units={$owm_measurement}&appid=5ae275d1a0023fc435486dc31a45cd67");

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bp-activator.php
 */
function activate_bp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bp-activator.php';
	Bp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bp-deactivator.php
 */
function deactivate_bp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bp-deactivator.php';
	Bp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bp' );
register_deactivation_hook( __FILE__, 'deactivate_bp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bp() {

	$plugin = new Bp();
	$plugin->run();

}
run_bp();
