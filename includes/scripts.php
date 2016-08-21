<?php
/**
 * Scripts
 *
 * @package     EDD\PasswordMeter\Scripts
 * @since       1.0.0
 * @copyright   Copyright (c) 2013-2014, Daniel J Griffiths
 */


// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Load scripts
 *
 * @since       1.0.0
 * @return      void
 */
function edd_password_meter_load_scripts() {
	$min_length = edd_get_option( 'edd_password_meter_min_length', 8 );
	$max_length = edd_get_option( 'edd_password_meter_max_length', 16 );

	if( $min_length > $max_length ) {
		$held       = $max_length;
		$max_length = $min_length;
		$min_length = $held;
	}

	wp_enqueue_script( 'edd-password-meter-passfield', EDD_PASSWORD_METER_URL . 'assets/js/passfield/js/passfield.js', array( 'jquery' ), EDD_PASSWORD_METER_VER );
	wp_enqueue_script( 'edd-password-meter-passfield-locales', EDD_PASSWORD_METER_URL . 'assets/js/passfield/js/locales.js', array( 'edd-password-meter-passfield' ), EDD_PASSWORD_METER_VER );
	wp_enqueue_style( 'edd-password-meter-passfield', EDD_PASSWORD_METER_URL . 'assets/js/passfield/css/passfield.css', array(), EDD_PASSWORD_METER_VER );
	wp_enqueue_script( 'edd-password-meter', EDD_PASSWORD_METER_URL . 'assets/js/edd-password-meter.js', array( 'edd-password-meter-passfield' ), EDD_PASSWORD_METER_VER, true );
	wp_localize_script( 'edd-password-meter', 'edd_password_meter_vars', array(
		'show_toggle'   => ( edd_get_option( 'edd_password_meter_hide_toggle', false ) ? false : true ),
		'show_generate' => ( edd_get_option( 'edd_password_meter_hide_gen', false ) ? false : true ),
		'show_tooltip'  => ( edd_get_option( 'edd_password_meter_hide_tooltip', false ) ? false : true ),
		'strength'      => edd_get_option( 'edd_password_meter_strength', 0.8 ),
		'checkmode'     => edd_get_option( 'edd_password_meter_checkmode', 'STRICT' ),
		'match_error'   => __( 'passwords do not match!', 'edd-password-meter' ),
		'min_length'    => $min_length,
		'max_length'    => $max_length
	) );
	wp_enqueue_style( 'edd-password-meter', EDD_PASSWORD_METER_URL . 'assets/css/edd-password-meter.css', array(), EDD_PASSWORD_METER_VER );
}
add_action( 'wp_enqueue_scripts', 'edd_password_meter_load_scripts' );


/**
 * Add Password Meter on cart
 *
 * @since       1.1.1
 * @return      void
 */
function edd_password_meter_add_to_cart() {
	$min_length = edd_get_option( 'edd_password_meter_min_length', 8 );
	$max_length = edd_get_option( 'edd_password_meter_max_length', 16 );
	$checkmode  = edd_get_option( 'edd_password_meter_checkmode', 'STRICT' );

	if( $min_length > $max_length ) {
		$held       = $max_length;
		$max_length = $min_length;
		$min_length = $held;
	}

	if( $checkmode == 'STRICT' ) {
		$checkmode = 'PassField.CheckModes.STRICT';
	} else {
		$checkmode = 'PassField.CheckModes.MODERATE';
	}

	$html = '<script type="text/javascript">
jQuery(\'#edd_user_pass\').passField({
    showToggle: ' . ( edd_get_option( 'edd_password_meter_hide_toggle', false ) ? 'false' : 'true' ) . ',
    showGenerate: ' . ( edd_get_option( 'edd_password_meter_hide_gen', false ) ? 'false' : 'true' ) . ',
    showTip: ' . ( edd_get_option( 'edd_password_meter_hide_tooltip', false ) ? 'false' : 'true' ) . ',
    acceptRate: ' . edd_get_option( 'edd_password_meter_strength', 0.8 ) . ',
    checkmode: ' . $checkmode . ',
    length: {
        min: ' . $min_length . ',
        max: ' . $max_length . '
    }
});
</script>';

	echo $html;
}
add_action( 'edd_after_purchase_form', 'edd_password_meter_add_to_cart' );
