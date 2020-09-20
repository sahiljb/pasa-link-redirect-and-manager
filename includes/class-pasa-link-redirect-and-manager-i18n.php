<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://sahilbuddhadev.me/
 * @since      1.0.0
 *
 * @package    Pasa_Link_Redirect_And_Manager
 * @subpackage Pasa_Link_Redirect_And_Manager/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Pasa_Link_Redirect_And_Manager
 * @subpackage Pasa_Link_Redirect_And_Manager/includes
 * @author     Sahil Buddhadev <hello@sahilbuddhadev.me>
 */
class Pasa_Link_Redirect_And_Manager_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'pasa-link-redirect-and-manager',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
