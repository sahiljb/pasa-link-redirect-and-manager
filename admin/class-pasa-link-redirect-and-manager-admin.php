<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://sahilbuddhadev.me/
 * @since      1.0.0
 *
 * @package    Pasa_Link_Redirect_And_Manager
 * @subpackage Pasa_Link_Redirect_And_Manager/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pasa_Link_Redirect_And_Manager
 * @subpackage Pasa_Link_Redirect_And_Manager/admin
 * @author     Sahil Buddhadev <hello@sahilbuddhadev.me>
 */
class Pasa_Link_Redirect_And_Manager_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pasa_Link_Redirect_And_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pasa_Link_Redirect_And_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$plugin_pages_sulg = get_admin_page_parent();

		if ( $plugin_pages_sulg === 'pasa-link-redirect' ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pasa-link-redirect-and-manager-admin.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name.'-bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
		}		

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pasa_Link_Redirect_And_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pasa_Link_Redirect_And_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name.'-jquery-validate', plugin_dir_url( __FILE__ ) . 'js/jquery.validate.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pasa-link-redirect-and-manager-admin.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'pasa_link_redirect', array(
				"name"		=> 'PASA Link Redirect',
				"author"	=> 'Sahil Buddhadev',
				"ajaxurl"	=> admin_url( 'admin-ajax.php' )
		) );

	}

	function check_link_redirector_table()
	{
		global $wpdb;
		$schema = "SHOW TABLES LIKE '{$this->table_name()}'";
		$result = $wpdb->query( $schema );
		
		if ( $result != 1 ) {
			$this->create_link_redirector_table();
		}
	}

	public function table_name() {
		global $wpdb;

		return $wpdb->prefix . 'pasa_link_redirector';
	}

	public function pasa_link_redirect_menu() {
		add_menu_page (
			'PASA Link Redirect',
			'PASA Link Redirect',
			'manage_options',
			'pasa-link-redirect',
			[ $this, 'pasa_link_redirect' ],
			'dashicons-admin-links'
		);

		add_submenu_page (
			'pasa-link-redirect',
			'PASA Link Redirect',
			'PASA Link Redirect',
			'manage_options',
			'pasa-link-redirect',
			[ $this, 'pasa_link_redirect' ]
		);
		// add_submenu_page (
		// 	'pasa-link-redirect',
		// 	'Supports',
		// 	'Supports',
		// 	'manage_options',
		// 	'pasa-link-redirect-support',
		// 	[ $this, 'pasa_link_redirect_support' ]
		// );
	}

	public function pasa_link_redirect() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		include 'partials/admin-settings-page.php';
	}

	public function pasa_link_redirect_support() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		include 'partials/admin-support-page.php';
	}

	public function pasa_link_do_redirect() {
		$siteurl = get_bloginfo('url');
		$current_url = $this->pasa_link_get_current_url();

		$all_redirects = $this->get_all_redirectors();

		if ( $all_redirects ) {
			foreach ( $all_redirects as $redirect_id ) {
				$link_redirector = $this->get_redirector( $redirect_id );
				$pasa_old_link = str_replace( $siteurl, "", $link_redirector['old_link'] );

				if ( $current_url == $siteurl . $pasa_old_link ) {
					header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );
					header( 'Cache-Control: post-check=0, pre-check=0', false );
					header( 'Pragma: no-cache' );
					header( 'Location: ' . $link_redirector['new_link'], true, 301 );
					die();
				}
			}
		}
	}

	public function pasa_link_get_current_url()
	{
		$current_url = @($_SERVER["HTTPS"] != 'on') ? 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] : 'https://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
		
		return $current_url;
	}

	public function delete_redirector( $id ) {
		global $wpdb;

		$sql = "DELETE FROM {$this->table_name()} WHERE id={$id}";

		$wpdb->query( $sql );
	}

	public function add_redirector( $ruleData ) {
		global $wpdb;
		$schema = $wpdb->prepare( "INSERT INTO {$this->table_name()} ( title, links_group, new_link, old_link ) VALUES ( '%s', '%s', '%s', '%s' )", array(
				$ruleData['rule_name'],
				$ruleData['links_group'],
				$ruleData['new_link'],
				$ruleData['old_link']
			) );
		
		if ( $wpdb->query( $schema ) ) {
			$response['status']	= 'success';
			$response['message'] = 'Rule has been added!';
			
			wp_send_json( $response );
		} else {
			$response['satus'] = 'error';
			$response['message'] = 'Please check your data and try again';
			
			wp_send_json( $response );
		}
	}

	public function get_redirector( $id ) {
		global $wpdb;
		
		$schema = $wpdb->prepare ( "SELECT * FROM {$this->table_name()} WHERE id = '%s'", array( $id ) );
		$result = $wpdb->query( $schema );
		
		if ( $result !== 0 ) {
			$fields = array();
			foreach ( $wpdb->get_results( $schema ) as $row ) {
				$fields['title'] = $row->title;
				$fields['links_group'] = $row->links_group;
				$fields['new_link'] = $row->new_link;
				$fields['old_link'] = $row->old_link;
				$fields['created_date'] = $row->created_date;
			}

			return $fields;
		} else {
			return false;
		}
	}

	public function get_all_redirectors() {
		global $wpdb;

		$this->check_link_redirector_table();

		$schema = "SELECT * FROM {$this->table_name()} ORDER by id ASC";
		$result = $wpdb->query( $schema );
		
		if ( $result !== 0 ) {
			$id_arr = array();

			foreach ( $wpdb->get_results( $schema ) as $row ) {
				$id_arr[] = $row->id;
			}

			return $id_arr;
		} else {
			return false;
		}
	}

	public function remove_redirector( $custom_id ) {
		global $wpdb;

		$schema = $wpdb->prepare( "DELETE FROM {$this->table_name()} WHERE id = '%s'", array( $custom_id ) );
		
		if ( $wpdb->query( $schema ) ) {
			$response['status']	= 'success';
			$response['message'] = 'Rule has been deleted!';
			
			wp_send_json( $response );
		} else {
			$response['satus'] = 'error';
			$response['message'] = 'Please check your request and try again';
			
			wp_send_json( $response );
		}
	}

	public function pasa_link_redirect_request() {
		$todo_value = esc_html( sanitize_text_field( $_REQUEST['todo'] ) );
		$todo = isset( $todo_value ) ? $todo_value : "";

		if ( !empty( $todo ) ) {
			if ( $todo == "addNewRule" ) {
				$this->add_redirector( esc_html( sanitize_text_field( $_REQUEST ) ) );
			}
			elseif ( $todo == "deleteRule" ) {
				$this->remove_redirector( esc_html( sanitize_text_field( $_REQUEST['id'] ) ) );
			}
		}

		wp_die();
	}
}
