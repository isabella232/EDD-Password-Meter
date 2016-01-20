<?php
/**
 * Register settings
 *
 * @package     EDD\PasswordMeter\Admin\Settings\Register
 * @since       1.2.0
 */


// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Add settings section
 *
 * @since       1.2.0
 * @param       array $sections The existing extensions sections
 * @return      array The modified extensions settings
 */
function edd_password_meter_add_settings_section( $sections ) {
	$sections['password_meter'] = __( 'Password Meter', 'edd-password-meter' );

	return $sections;
}
add_filter( 'edd_settings_sections_extensions', 'edd_password_meter_add_settings_section' );


/**
 * Add settings
 *
 * @since       1.2.0
 * @param       array $settings The existing plugin settings
 * @return      array The modified plugin settings
 */
function edd_password_meter_add_settings( $settings ) {
	if( EDD_VERSION >= '2.5' ) {
		$new_settings = array(
			'password_meter' => array(
				array(
					'id'      => 'edd_password_meter_checkmode',
					'name'    => __( 'Check Mode', 'edd-password-meter' ),
					'desc'    => __( 'Specify strict or moderate password checking', 'edd-password-meter' ),
					'type'    => 'select',
					'options' => array(
						'STRICT'   => __( 'Strict', 'edd-password-meter' ),
						'MODERATE' => __( 'Moderate','edd-password-meter' )
					),
					'std'     => 'STRICT'
				),
				array(
					'id'   => 'edd_password_meter_strength',
					'name' => __( 'Required Strength', 'edd-password-meter' ),
					'desc' => __( 'Set the minimum required password strength Min: 0, Max: 1, Default: 0.8', 'edd-password-meter' ),
					'type' => 'number',
					'min'  => '0',
					'max'  => '1',
					'step' => '0.1',
					'size' => 'small',
					'std'  => '0.8'
				),
				array(
					'id'   => 'edd_password_meter_min_length',
					'name' => __( 'Minimum Length', 'edd-password-meter' ),
					'desc' => __( 'Set the minimum allowed password length Default: 8', 'edd-password-meter' ),
					'type' => 'number',
					'min'  => '0',
					'step' => '1',
					'size' => 'small',
					'std'  => '8'
				),
				array(
					'id'   => 'edd_password_meter_max_length',
					'name' => __( 'Maximum Length', 'edd-password-meter' ),
					'desc' => __( 'Set the maximum allowed password length Default: 16', 'edd-password-meter' ),
					'type' => 'number',
					'min'  => '0',
					'step' => '1',
					'size' => 'small',
					'std'  => '16'
				),
				array(
					'id'   => 'edd_password_meter_hide_toggle',
					'name' => __( 'Disallow Show Password', 'edd-password-meter' ),
					'desc' => __( 'Select to disable the \'show password\' toggle', 'edd-password-meter' ),
					'type' => 'checkbox'
				),
				array(
					'id'   => 'edd_password_meter_hide_gen',
					'name' => __( 'Disallow Password Generation', 'edd-password-meter' ),
					'desc' => __( 'Select to disabled the \'generate password\' button', 'edd-password-meter' ),
					'type' => 'checkbox'
				),
				array(
					'id'   => 'edd_password_meter_hide_tooltip',
					'name' => __( 'Hide Tooltips', 'edd-password-meter' ),
					'desc' => __( 'Select to hide generation guideline tooltips', 'edd-password-meter' ),
					'type' => 'checkbox'
				)
			)
		);

		$settings = array_merge( $settings, $new_settings );
	}

	return $settings;
}
add_filter( 'edd_settings_extensions', 'edd_password_meter_add_settings' );


/**
 * Add settings (pre-2.5)
 *
 * @since       1.2.0
 * @param       array $settings The existing plugin settings
 * @return      array The modified plugin settings
 */
function edd_password_meter_add_settings_pre25( $settings ) {
	if( EDD_VERSION < '2.5' ) {
		$new_settings = array(
			array(
				'id'   => 'edd_password_meter_settings',
				'name' => '<strong>' . __( 'Password Meter', 'edd-password-meter' ) . '</strong>',
				'desc' => __( 'Configure Password Meter Settings', 'edd-password-meter' ),
				'type' => 'header'
			),
			array(
				'id'      => 'edd_password_meter_checkmode',
				'name'    => __( 'Check Mode', 'edd-password-meter' ),
				'desc'    => __( 'Specify strict or moderate password checking', 'edd-password-meter' ),
				'type'    => 'select',
				'options' => array(
					'STRICT'   => __( 'Strict', 'edd-password-meter' ),
					'MODERATE' => __( 'Moderate','edd-password-meter' )
				),
				'std'     => 'STRICT'
			),
			array(
				'id'   => 'edd_password_meter_strength',
				'name' => __( 'Required Strength', 'edd-password-meter' ),
				'desc' => __( 'Set the minimum required password strength Min: 0, Max: 1, Default: 0.8', 'edd-password-meter' ),
				'type' => 'number',
				'min'  => '0',
				'max'  => '1',
				'step' => '0.1',
				'size' => 'small',
				'std'  => '0.8'
			),
			array(
				'id'   => 'edd_password_meter_min_length',
				'name' => __( 'Minimum Length', 'edd-password-meter' ),
				'desc' => __( 'Set the minimum allowed password length Default: 8', 'edd-password-meter' ),
				'type' => 'number',
				'min'  => '0',
				'step' => '1',
				'size' => 'small',
				'std'  => '8'
			),
			array(
				'id'   => 'edd_password_meter_max_length',
				'name' => __( 'Maximum Length', 'edd-password-meter' ),
				'desc' => __( 'Set the maximum allowed password length Default: 16', 'edd-password-meter' ),
				'type' => 'number',
				'min'  => '0',
				'step' => '1',
				'size' => 'small',
				'std'  => '16'
			),
			array(
				'id'   => 'edd_password_meter_hide_toggle',
				'name' => __( 'Disallow Show Password', 'edd-password-meter' ),
				'desc' => __( 'Select to disable the \'show password\' toggle', 'edd-password-meter' ),
				'type' => 'checkbox'
			),
			array(
				'id'   => 'edd_password_meter_hide_gen',
				'name' => __( 'Disallow Password Generation', 'edd-password-meter' ),
				'desc' => __( 'Select to disabled the \'generate password\' button', 'edd-password-meter' ),
				'type' => 'checkbox'
			),
			array(
				'id'   => 'edd_password_meter_hide_tooltip',
				'name' => __( 'Hide Tooltips', 'edd-password-meter' ),
				'desc' => __( 'Select to hide generation guideline tooltips', 'edd-password-meter' ),
				'type' => 'checkbox'
			)
		);

		$settings = array_merge( $settings, $new_settings );
	}

	return $settings;
}
add_filter( 'edd_settings_extensions', 'edd_password_meter_add_settings_pre25' );