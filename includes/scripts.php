<?php
/**
 * Scripts
 *
 * @package     EDD\PasswordMeter\Scripts
 * @since       1.0.0
 * @copyright   Copyright (c) 2013-2014, Daniel J Griffiths
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;


/**
 * Load scripts
 *
 * @since       1.0.0
 * @return      void
 */
function edd_password_meter_load_scripts() {
    wp_enqueue_script( 'edd-password-meter-passfield', EDD_PASSWORD_METER_URL . 'assets/js/passfield/js/passfield.js', array( 'jquery' ), EDD_PASSWORD_METER_VER );
    wp_enqueue_script( 'edd-password-meter-passfield-locales', EDD_PASSWORD_METER_URL . 'assets/js/passfield/js/locales.js', array( 'edd-password-meter-passfield' ), EDD_PASSWORD_METER_VER );
    wp_enqueue_style( 'edd-password-meter-passfield', EDD_PASSWORD_METER_URL . 'assets/js/passfield/css/passfield.css', array(), EDD_PASSWORD_METER_VER );
    wp_enqueue_script( 'edd-password-meter', EDD_PASSWORD_METER_URL . 'assets/js/edd-password-meter.js', array( 'edd-password-meter-passfield' ), EDD_PASSWORD_METER_VER );
    wp_localize_script( 'edd-password-meter', 'edd_password_meter_vars', array(
        'show_toggle'   => ( edd_get_option( 'edd_password_meter_hide_toggle', false ) ? false : true ),
        'show_generate' => ( edd_get_option( 'edd_password_meter_hide_gen', false ) ? false : true ),
        'show_tooltip'  => ( edd_get_option( 'edd_password_meter_hide_tooltip', false ) ? false : true ),
        'strength'      => edd_get_option( 'edd_password_meter_strength', 0.8 ),
        'checkmode'     => edd_get_option( 'edd_password_meter_checkmode', 'STRICT' ),
        'match_error'   => __( 'passwords do not match!', 'edd-password-meter' )
    ) );
}
add_action( 'wp_enqueue_scripts', 'edd_password_meter_load_scripts' );
