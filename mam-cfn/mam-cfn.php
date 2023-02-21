<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://moveaheadmedia.com
 * @since             1.0.0
 * @package           Mam_Cfn
 *
 * @wordpress-plugin
 * Plugin Name:       Move Ahead Media Custom Forwarding Numbers
 * Plugin URI:        https://github.com/moveaheadmedia/mam-cfn
 * Description:       A Plugin that allows you to replace the current phone number on the website with custom forwarding numbers based on UTM data, referral or current page.
 * Version:           1.0.0
 * Author:            Move Ahead Media
 * Author URI:        https://moveaheadmedia.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mam-cfn
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
define( 'MAM_CFN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mam-cfn-activator.php
 */
function activate_mam_cfn() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mam-cfn-activator.php';
	Mam_Cfn_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mam-cfn-deactivator.php
 */
function deactivate_mam_cfn() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mam-cfn-deactivator.php';
	Mam_Cfn_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mam_cfn' );
register_deactivation_hook( __FILE__, 'deactivate_mam_cfn' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mam-cfn.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mam_cfn() {

	$plugin = new Mam_Cfn();
	$plugin->run();

}
run_mam_cfn();
