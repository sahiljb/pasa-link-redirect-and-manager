<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://sahilbuddhadev.me/
 * @since             1.0.0
 * @package           Pasa_Link_Redirect_And_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       PASA Link Redirect
 * Plugin URI:        http://sahilbuddhadev.me/wordpress-plugin/pasa-link-redirect-and-manager
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Sahil Buddhadev
 * Author URI:        http://sahilbuddhadev.me/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pasa-link-redirect-and-manager
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
define( 'PASA_LINK_REDIRECT_AND_MANAGER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pasa-link-redirect-and-manager-activator.php
 */
function activate_pasa_link_redirect_and_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pasa-link-redirect-and-manager-activator.php';

	$activator = new Pasa_Link_Redirect_And_Manager_Activator();
	
	$activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pasa-link-redirect-and-manager-deactivator.php
 */
function deactivate_pasa_link_redirect_and_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pasa-link-redirect-and-manager-deactivator.php';
	Pasa_Link_Redirect_And_Manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pasa_link_redirect_and_manager' );
register_deactivation_hook( __FILE__, 'deactivate_pasa_link_redirect_and_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pasa-link-redirect-and-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pasa_link_redirect_and_manager() {

	$plugin = new Pasa_Link_Redirect_And_Manager();
	$plugin->run();

}
run_pasa_link_redirect_and_manager();
