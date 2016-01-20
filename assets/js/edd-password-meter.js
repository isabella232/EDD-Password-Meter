/*global jQuery, document, edd_password_meter_vars*/
jQuery(document).ready(function ($) {
    'use strict';

    var show_toggle, show_generate, show_tip;

    if (edd_password_meter_vars.show_toggle === '1') {
        show_toggle = true;
    } else {
        show_toggle = false;
    }

    if (edd_password_meter_vars.show_generate === '1') {
        show_generate = true;
    } else {
        show_generate = false;
    }

    if (edd_password_meter_vars.show_tooltip === '1') {
        show_tip = true;
    } else {
        show_tip = false;
    }

    $('body').on('blur', '#edd_user_pass', function () {
        if ($('#edd_user_pass').getPassValidationMessage() !== undefined && $('#edd_invalid_password_strength').length === 0) {
            $('#edd-user-pass-wrap').append('<input type="hidden" value="1" id="edd_invalid_password_strength" name="edd_invalid_password_strength" />');
        } else if ($('#edd_user_pass').getPassValidationMessage() === undefined) {
            $('#edd_invalid_password_strength').remove();
        }

        if ($('#edd_user_pass').val() === $('#edd_user_pass_confirm').val()) {
            $('#edd_user_pass_confirm_warn').remove();
        }
    });

    $('body').on('blur', '#edd_user_pass_confirm', function () {
        if ($('#edd_user_pass').val() !== $('#edd_user_pass_confirm').val()) {
            if ($('#edd_user_pass_confirm_warn').length === 0) {
                $('<div class="a_pf-wrap"><div id="edd_user_pass_confirm_warn" class="a_pf-warn help-inline" title="' + edd_password_meter_vars.match_error + '" style="margin: 0px 0px 0px 3px;">' + edd_password_meter_vars.match_error + '</div></div>').insertAfter('#edd_user_pass_confirm');
            }
        } else {
            $('#edd_user_pass_confirm_warn').remove();
        }
    });

    // Shortcode registration form
    $('#edd-user-pass').passField({
        showToggle: show_toggle,
        showGenerate: show_generate,
        showTip: show_tip,
        acceptRate: edd_password_meter_vars.strength,
        checkmode: edd_password_meter_vars.checkmode,
        length: {
            min: edd_password_meter_vars.min_length,
            max: edd_password_meter_vars.max_length
        }
    });

    $('body').on('blur', '#edd-user-pass', function () {
        if ($('#edd-user-pass').getPassValidationMessage() !== undefined && $('#edd_invalid_password_strength').length === 0) {
            $('#edd-user-pass').closest('p').append('<input type="hidden" value="1" id="edd_invalid_password_strength" name="edd_invalid_password_strength" />');
        } else if ($('#edd-user-pass').getPassValidationMessage() === undefined) {
            $('#edd_invalid_password_strength').remove();
        }

        if ($('#edd-user-pass').val() === $('#edd-user-pass2').val()) {
            $('#edd_user_pass_confirm_warn').remove();
        }
    });

    $('body').on('blur', '#edd-user-pass2', function () {
        if ($('#edd-user-pass').val() !== $('#edd-user-pass2').val()) {
            if ($('#edd_user_pass_confirm_warn').length === 0) {
                $('<div class="a_pf-wrap"><div id="edd_user_pass_confirm_warn" class="a_pf-warn help-inline" title="' + edd_password_meter_vars.match_error + '" style="margin: 0px 0px 0px 3px;">' + edd_password_meter_vars.match_error + '</div></div>').insertAfter('#edd-user-pass2');
            }
        } else {
            $('#edd_user_pass_confirm_warn').remove();
        }
    });
});
