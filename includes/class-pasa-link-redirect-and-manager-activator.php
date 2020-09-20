<?php

/**
 * Fired during plugin activation
 *
 * @link       http://sahilbuddhadev.me/
 * @since      1.0.0
 *
 * @package    Pasa_Link_Redirect_And_Manager
 * @subpackage Pasa_Link_Redirect_And_Manager/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Pasa_Link_Redirect_And_Manager
 * @subpackage Pasa_Link_Redirect_And_Manager/includes
 * @author     Sahil Buddhadev <hello@sahilbuddhadev.me>
 */
class Pasa_Link_Redirect_And_Manager_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {
		$this->check_table();
	}

	public function table_name() {
		global $wpdb;

		return $wpdb->prefix . 'pasa_link_redirector';
	}

	public function check_table() {
		global $wpdb;

		$schema = "SHOW TABLES LIKE '{$this->table_name()}'";
		$result = $wpdb->query( $schema );
		
		if ( $result != 1 ) {
			$this->create_table();
		}
	}

	public function create_table() {
		global $wpdb;

		$schema = "CREATE TABLE {$this->table_name()} (
			id BIGINT(20) PRIMARY KEY AUTO_INCREMENT,
			`title` VARCHAR(32),
			`links_group` VARCHAR(32) NULL,
			`new_link` TEXT,
			`old_link` TEXT,
			`created_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
		)";
		
		$wpdb->query( $schema );
	}

}
