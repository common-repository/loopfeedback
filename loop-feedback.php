<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://loopinput.com
 * @since             1.0.0
 * @package           Loop_Feedback
 *
 * @wordpress-plugin
 * Plugin Name:       Loop Feedback
 * Plugin URI:        https://loopinput.com
 * Description:       Customer feedback is the fuel that improves your product and grows your revenue. Loop develops visual customer feedback management software, including a screenshot plugin that integrates directly into your website and an embeddable forum to vote on submitted feedback, to help you drive strategic product decisions and catch bugs.
 * Version:           1.0.0
 * Author:            Miguel
 * Author URI:        https://sample.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       loop-feedback
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
define( 'LOOP_FEEDBACK_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-loop-feedback-activator.php
 */
function activate_loop_feedback() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-loop-feedback-activator.php';
	Loop_Feedback_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-loop-feedback-deactivator.php
 */
function deactivate_loop_feedback() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-loop-feedback-deactivator.php';
	Loop_Feedback_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_loop_feedback' );
register_deactivation_hook( __FILE__, 'deactivate_loop_feedback' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-loop-feedback.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_loop_feedback() {

	$plugin = new Loop_Feedback();
	$plugin->run();

}
run_loop_feedback();
