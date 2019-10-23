<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/Pacjonek
 * @since             1.0.0
 * @package           Todo
 *
 * @wordpress-plugin
 * Plugin Name:       Todo
 * Plugin URI:        https://github.com/Pacjonek/todo
 * Description:       Simple todo plugin activated via [todo] shortcode
 * Version:           1.0.0
 * Author:            Patryk Rajba
 * Author URI:        https://github.com/Pacjonek
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       todo
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
define( 'TODO_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-todo-activator.php
 */
function activate_todo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-todo-activator.php';
	Todo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-todo-deactivator.php
 */
function deactivate_todo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-todo-deactivator.php';
	Todo_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_todo' );
register_deactivation_hook( __FILE__, 'deactivate_todo' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-todo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_todo() {

	$plugin = new Todo();
	$plugin->run();

}
run_todo();
