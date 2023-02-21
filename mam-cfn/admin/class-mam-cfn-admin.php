<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://moveaheadmedia.com
 * @since      1.0.0
 *
 * @package    Mam_Cfn
 * @subpackage Mam_Cfn/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mam_Cfn
 * @subpackage Mam_Cfn/admin
 * @author     Move Ahead Media <info@moveaheadmedia.com>
 */
class Mam_Cfn_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private string $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private string $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( string $plugin_name, string $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * checks for ACF Pro, deactivates if missing.
	 *
	 * @since 1.0.0
	 */
	public function check_requirements() {
		// ACF Pro is not installed and active
		if ( ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
			deactivate_plugins( 'mam-cfn/mam-cfn.php' );
			echo '<div class="error"><p>' . _( 'ACF Pro plugin is not active. Please activate it to use Move Ahead Media Custom Forwarding Numbers.' ) . '</p></div>';
		}
	}

	/**
	 * Registers an ACF options page for the plugin.
	 *
	 * @since 1.0.0
	 */
	function add_options_page() {
		acf_add_options_page( array(
			'page_title' => 'Custom Forwarding Number',
			'menu_title' => 'Custom Forwarding Number',
			'menu_slug'  => 'mam-cfn',
			'icon_url'   => 'dashicons-phone',
			'capability' => 'edit_posts',
			'redirect'   => false
		) );
	}

	/**
	 * Registers an ACF options page for the plugin.
	 *
	 * @since 1.0.0
	 */
	function add_custom_fields() {
		$json = file_get_contents(dirname( __FILE__ ) . '/acf.json');
		$data = json_decode($json, true);
		acf_add_local_field_group( $data[0] );
	}

	/**
	 * Add the settings link to the plugin.
	 *
	 * @since 1.0.0
	 */
	function settings_link( $links ) {
		$links[] = sprintf( "<a href=\"admin.php?page=%s\">%s</a>", $this->plugin_name, __( 'Settings' ) );

		return $links;
	}

}
