<?php
/**
 * Plugin Name: Nanato Schemas
 * Description: A plugin for managing and outputting structured data schemas.
 * Version: 1.0.0
 * Author: gabrielac-nanato
 * Author URI: https://github.com/gabrielac-nanato
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 *
 * @package Nanato_Schemas
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin version.
define( 'NANATO_SCHEMAS_VERSION', '1.0.0' );

// Load plugin textdomain for translations.
add_action(
	'plugins_loaded',
	function () {
		load_plugin_textdomain( 'nanato-schemas', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
);

// Include Composer's autoload file.
if ( file_exists( plugin_dir_path( __FILE__ ) . 'vendor/autoload.php' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
} else {
	// Fallback: manually include the classes.
	require_once plugin_dir_path( __FILE__ ) . 'classes/Plugin_Definitions.php';
	require_once plugin_dir_path( __FILE__ ) . 'classes/Plugin_Paths.php';
	require_once plugin_dir_path( __FILE__ ) . 'classes/ACF_Settings.php';
	require_once plugin_dir_path( __FILE__ ) . 'classes/Hooks.php';
	require_once plugin_dir_path( __FILE__ ) . 'classes/Admin.php';
}

// Include helper functions.
require_once plugin_dir_path( __FILE__ ) . 'helpers/helpers.php';

// Instantiate the classes.
$nanato_schemas_classes = array(
	\Nanato_Schemas\Plugin_Definitions::class,
	\Nanato_Schemas\Plugin_Paths::class,
	\Nanato_Schemas\ACF_Settings::class,
	\Nanato_Schemas\Hooks::class,
	\Nanato_Schemas\Admin::class,
);

// Instantiate each class.
foreach ( $nanato_schemas_classes as $nanato_schemas_class ) {
	new $nanato_schemas_class();
}
