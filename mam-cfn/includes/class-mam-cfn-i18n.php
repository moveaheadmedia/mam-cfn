<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://moveaheadmedia.com
 * @since      1.0.0
 *
 * @package    Mam_Cfn
 * @subpackage Mam_Cfn/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mam_Cfn
 * @subpackage Mam_Cfn/includes
 * @author     Move Ahead Media <info@moveaheadmedia.com>
 */
class Mam_Cfn_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mam-cfn',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
