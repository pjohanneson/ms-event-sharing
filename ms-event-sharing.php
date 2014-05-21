<?php
/**
 * 
 * @package   Multisite_Event_Sharing
 * @author    Patrick Johanneson <pat@patj.ca>
 * @license   GPL-2.0+
 * @link      http://patj.ca/
 * @copyright 2014 Patrick Johanneson
 *
 * @wordpress-plugin
 * Plugin Name:       Multisite Event Sharing
 * Plugin URI:        http://patj.ca/wp/plugins/ms-event-sharing
 * Description:       Share Tri.be events between sites in a Multisite network.
 * Version:           1.0.0
 * Author:            Patrick Johanneson
 * Author URI:        http://patj.ca/wp/
 * Text Domain:       ms-event-sharing-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/vodou/ms-event-sharing
 * Thanks: WordPress-Plugin-Boilerplate: v2.6.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-ms-event-sharing.php` with the name of the plugin's class file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/class-ms-event-sharing.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * @TODO:
 *
 * - replace MS_Event_Sharing with the name of the class defined in
 *   `class-ms-event-sharing.php`
 */
register_activation_hook( __FILE__, array( 'MS_Event_Sharing', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'MS_Event_Sharing', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace MS_Event_Sharing with the name of the class defined in
 *   `class-ms-event-sharing.php`
 */
add_action( 'plugins_loaded', array( 'MS_Event_Sharing', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-ms-event-sharing-admin.php` with the name of the plugin's admin file
 * - replace MS_Event_Sharing_Admin with the name of the class defined in
 *   `class-ms-event-sharing-admin.php`
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-ms-event-sharing-admin.php' );
	add_action( 'plugins_loaded', array( 'MS_Event_Sharing_Admin', 'get_instance' ) );

}
