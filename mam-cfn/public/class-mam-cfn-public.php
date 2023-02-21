<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://moveaheadmedia.com
 * @since      1.0.0
 *
 * @package    Mam_Cfn
 * @subpackage Mam_Cfn/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mam_Cfn
 * @subpackage Mam_Cfn/public
 * @author     Move Ahead Media <info@moveaheadmedia.com>
 */
class Mam_Cfn_Public {

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
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( string $plugin_name, string $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mam_Cfn_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mam_Cfn_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mam-cfn-public.js', array( 'jquery' ), $this->version, false );
		$data                  = array();
		$data['phone_numbers'] = get_field( 'mam_cfn_phone_numbers', 'option' );
		wp_localize_script( $this->plugin_name, 'mam_cfn', $data );
	}

}
