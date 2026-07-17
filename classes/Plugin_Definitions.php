<?php
/**
 * Plugin Definitions
 *
 * @package Nanato_Schemas
 */

// Define the namespace
namespace Nanato_Schemas;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Plugin_Definitions
 */
class Plugin_Definitions {

	/**
	 * Get the plugin prefix.
	 *
	 * @return string Plugin prefix (kebab-case).
	 */
	public static function plugin_prefix() {
		return 'nanato-schemas';
	}
}
