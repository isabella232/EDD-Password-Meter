<?php
/**
 * Plugin Name:     Easy Digital Downloads - Password Meter
 * Plugin URI:      https://easydigitaldownloads.com/extension/password-meter/
 * Description:     Adds a password strength meter to the integrated signup form
 * Version:         1.0.4b
 * Author:          Daniel J Griffiths
 * Author URI:      http://ghost1227.com
*/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;


if( !class_exists( 'EDD_Password_Meter' ) ) {

	class EDD_Password_Meter {

		private static $instance;


		/**
		 * Get active instance
		 *
		 * @since		1.0.2
		 * @access		public
		 * @static
		 * @return		object self::$instance
		 */
		public static function get_instance() {
			if( !self::$instance )
				self::$instance = new EDD_Password_Meter();

			return self::$instance;
		}


		/**
		 * Class constructor
		 * 
		 * @since		1.0.2
		 * @access		public
		 * @return		void
		 */
		public function __construct() {
			define( 'EDD_PASSWORD_METER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			define( 'EDD_PASSWORD_METER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

			// Load our custom updater
			if( !class_exists( 'EDD_License' ) )
				include( dirname( __FILE__ ) . '/includes/EDD_License_Handler.php' );

			$this->init();
		}


		/**
		 * Run action and filter hooks
		 *
		 * @since		1.0.2
		 * @access		private
		 * @global		$edd_options
		 * @return		void
		 */
		private function init() {
			// Make sure EDD is active
			if( !class_exists( 'Easy_Digital_Downloads' ) ) return;

			global $edd_options;

			// Include scripts
			require_once( 'includes/scripts.php' );

			// Internationalization
			add_action( 'init', array( $this, 'textdomain' ) );

			// Register settings
			add_filter( 'edd_settings_extensions', array( $this, 'settings' ), 1 );

			// Handle licensing
			$license = new EDD_License( __FILE__, 'Password Meter', '1.0.4', 'Daniel J Griffiths' );

			// Add error check
			add_action( 'edd_checkout_error_checks', array( $this, 'error_check' ) );
		}


		/**
		 * Internationalization
		 *
		 * @since		1.0.2
		 * @access		public
		 * @static
		 * @return		void
		 */
		public static function textdomain() {
			// Set filter for languages directory
			$edd_lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
			$edd_lang_dir = apply_filters( 'edd_password_meter_languages_directory', $edd_lang_dir );

			// Load translations
			load_plugin_textdomain( 'edd_password_meter', false, $edd_lang_dir );
		}
			

		/**
		 * Add settings
		 *
		 * @since		1.0.0
		 * @access		public
		 * @param		array $settings the existing EDD settings array
		 * @return		array $settings the filtered EDD settings array
		 */
		public function settings( $settings ) {
			$password_meter_settings = array(
				array(
					'id'	=> 'edd_password_meter_settings',
					'name'	=> '<strong>' . __( 'Password Meter Settings', 'edd_password_meter' ) . '</strong>',
					'desc'	=> __( 'Configure Password Meter Settings', 'edd_password_meter' ),
					'type'	=> 'header'
				),
				array(
					'id'	=> 'edd_password_meter_checkmode',
					'name'	=> __( 'Check Mode', 'edd_password_meter' ),
					'desc'	=> __( 'Specify strict or moderate password checking', 'edd_password_meter' ),
					'type'	=> 'select',
					'options'	=> array(
						'STRICT'	=> __( 'Strict', 'edd_password_meter' ),
						'MODERATE'	=> __( 'Moderate','edd_password_meter' )
					),
					'std'	=> 'STRICT'
				),
				array(
					'id'	=> 'edd_password_meter_strength',
					'name'	=> __( 'Required Strength', 'edd_password_meter' ),
					'desc'	=> __( 'Set the minimum required password strength Min: 0, Max: 1, Default: 0.8', 'edd_password_meter' ),
					'type'	=> 'text',
					'size'	=> 'small',
					'std'	=> '0.8'
				),
				array(
					'id'	=> 'edd_password_meter_hide_toggle',
					'name'	=> __( 'Disallow Show Password', 'edd_password_meter' ),
					'desc'	=> __( 'Select to disable the \'show password\' toggle', 'edd_password_meter' ),
					'type'	=> 'checkbox'
				),
				array(
					'id'	=> 'edd_password_meter_hide_gen',
					'name'	=> __( 'Disallow Password Generation', 'edd_password_meter' ),
					'desc'	=> __( 'Select to disabled the \'generate password\' button', 'edd_password_meter' ),
					'type'	=> 'checkbox'
				),
				array(
					'id'	=> 'edd_password_meter_hide_tooltip',
					'name'	=> __( 'Hide Tooltips', 'edd_password_meter' ),
					'desc'	=> __( 'Select to hide generation guideline tooltips', 'edd_password_meter' ),
					'type'	=> 'checkbox'
				)
			);

			return array_merge( $settings, $password_meter_settings );
		}


		/**
		 * Add required field
		 *
		 * @since		1.0.0
		 * @access		public
		 * @return		array
		 */
		public function error_check() {
			if( !empty( $_POST['edd_invalid_password_strength'] ) )
				edd_set_error( 'edd_invalid_password_strength', __( 'Your password is insecure. Please enter a stronger password.', 'edd_password_meter' ) );
		}
	}
}


function edd_password_meter_load() {
	$edd_password_meter = new EDD_Password_Meter();
}
add_action( 'plugins_loaded', 'edd_password_meter_load' );
