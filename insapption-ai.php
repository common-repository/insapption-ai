<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://insapption.com
 * @since             1.0.0
 * @package           Insapption_Ai
 *
 * @wordpress-plugin
 * Plugin Name:       Insapption AI
 * Plugin URI:        https://ai.insapption.com
 * Description:       Content generator with ai.
 * Version:           1.0.0
 * Author:            Insapption Technology
 * Author URI:        https://insapption.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       insapption-ai
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
define( 'INSAPPTION_AI_VERSION', '1.0.0' );
define( 'INSAI_PLUGIN_DIR_URL', plugin_dir_url(__FILE__) );
define( 'INSAI_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-insapption-ai-activator.php
 */
function activate_insapption_ai() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-insapption-ai-activator.php';
	Insapption_Ai_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-insapption-ai-deactivator.php
 */
function deactivate_insapption_ai() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-insapption-ai-deactivator.php';
	Insapption_Ai_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_insapption_ai' );
register_deactivation_hook( __FILE__, 'deactivate_insapption_ai' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-insapption-ai.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_insapption_ai() {

	$plugin = new Insapption_Ai();
	$plugin->run();

}
run_insapption_ai();
