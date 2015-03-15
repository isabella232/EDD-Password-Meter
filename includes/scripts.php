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
    if( edd_is_checkout() ) {
        wp_enqueue_script( 'edd-password-meter-passfield', EDD_PASSWORD_METER_URL . 'assets/js/passfield.js', array( 'jquery' ), EDD_PASSWORD_METER_VER );
        wp_enqueue_style( 'edd-password-meter-passfield', EDD_PASSWORD_METER_URL . 'assets/css/passfield.min.css', array(), EDD_PASSWORD_METER_VER );
        wp_enqueue_script( 'edd-password-meter', EDD_PASSWORD_METER_URL . 'assets/js/edd-password-meter.js', array( 'edd-password-meter-passfield' ), EDD_PASSWORD_METER_VER );
        wp_localize_script( 'edd-password-meter', 'edd_password_meter_vars', array(
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'edd_password_meter_load_scripts' );


/**
 * Add password meter
 *
 * @since       1.0.0
 * @global      $edd_options
 * @return      void
 */
function edd_display_password_meter() {
    global $edd_options;

?>
<script>
jQuery(document).ready(function () {
    jQuery('#edd_user_pass').passField({
        <?php
            echo ( isset( $edd_options['edd_password_meter_hide_toggle'] ) ? '        showToggle: false,' : '' );
            echo ( isset( $edd_options['edd_password_meter_hide_gen'] ) ? '        showGenerate: false,' : '' );
            echo ( isset( $edd_options['edd_password_meter_hide_tooltip'] ) ? '        showTip: false,' : '' );
            if( isset( $edd_options['edd_password_meter_strength'] ) && is_numeric( $edd_options['edd_password_meter_strength'] ) && $edd_options['edd_password_meter_strength'] >= 0 && $edd_options['edd_password_meter_strength'] <= 1 )
                echo '        acceptRate: ' . $edd_options['edd_password_meter_strength'];
        ?>
    },
        PassField.CheckModes.<?php echo ( isset( $edd_options['edd_password_meter_checkmode'] ) ? $edd_options['edd_password_meter_checkmode'] : 'STRICT' ); ?>
    );
    jQuery('body').on('blur', '#edd_user_pass', function () {
        if(jQuery('#edd_user_pass').getPassValidationMessage() !== undefined && jQuery('#edd_invalid_password_strength').length === 0) {
            jQuery('#edd-user-pass-wrap').append('<input type="hidden" value="1" id="edd_invalid_password_strength" name="edd_invalid_password_strength" />');
        } else if(jQuery('#edd_user_pass').getPassValidationMessage() === undefined) {
            jQuery('#edd_invalid_password_strength').remove();
        }
        if(jQuery('#edd_user_pass').val() == jQuery('#edd_user_pass_confirm').val()) {
            jQuery('#edd_user_pass_confirm_warn').remove();
        }
    });
    jQuery('body').on('blur', '#edd_user_pass_confirm', function () {
        if(jQuery('#edd_user_pass').val() != jQuery('#edd_user_pass_confirm').val()) {
            if(jQuery('#edd_user_pass_confirm_warn').length === 0) {
                jQuery('<div class="a_pf-wrap"><div id="edd_user_pass_confirm_warn" class="a_pf-warn help-inline" title="<?php _e( 'passwords do not match!', 'edd_password_meter' ); ?>" style="margin: 0px 0px 0px 3px;"><?php _e( 'passwords do not match!', 'edd_password_meter' ); ?></div></div>').insertAfter('#edd_user_pass_confirm');
            }
        } else {
            jQuery('#edd_user_pass_confirm_warn').remove();
        }
    });
});
</script>
<?php
}
add_action( 'edd_after_purchase_form', 'edd_display_password_meter' );
