/*global jQuery, document, edd_password_meter_vars*/
jQuery(document).ready(function ($) {
    'use strict';

    var show_toggle, show_generate, show_tip, checkmode = edd_password_meter_vars.checkmode;

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

    $('#edd_user_pass').passField({
        showToggle: show_toggle,
        showGenerate: show_generate,
        showTip: show_tip,
        acceptRate: edd_password_meter_vars.strength,
        checkmode: edd_password_meter_vars.checkmode,
    });
});
