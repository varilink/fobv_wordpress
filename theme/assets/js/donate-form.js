jQuery( document ).ready( function() {

    // Enable/disable other amount value on page load

    if ( jQuery( "#fobvDonateAmountOther" ).is( ":checked" ) ) {
        jQuery( '#fobvDonateAmountOtherValue' ).prop( "disabled", false );
    } else {
        jQuery( '#fobvDonateAmountOtherValue' ).prop( "disabled", true );
    }

    // Enable/disable other amount value on amount change

    jQuery( "input:radio[name=fobv_donate_amount]").change( function () {

        if ( jQuery( "#fobvDonateAmountOther" ).is( ":checked" ) ) {
            jQuery( '#fobvDonateAmountOtherValue' ).prop( "disabled", false );
        } else {
            jQuery( '#fobvDonateAmountOtherValue' ).prop( "disabled", true );
        }

    } );

    // Hide help for unchecked payment methods on page load

    if ( ! jQuery( '#fobvDonateMethodCheque' ).attr('checked') ) {
        jQuery( '#fobvDonateMethodChequeHelp' ).hide();
    }

    if ( ! jQuery( '#fobvDonateMethodBankTransfer' ).attr('checked') ) {
        jQuery( '#fobvDonateMethodBankTransferHelp' ).hide();
    }

    if ( ! jQuery( '#fobvDonateMethodOnline' ).attr('checked') ) {
        jQuery( '#fobvDonateMethodOnlineHelp' ).hide();
    }

    // Show/hide help for payment methods on payment method change

    jQuery(
        'input[type=radio][name=fobv_donate_method]'
    ).change( function () {
        if ( this.value == 'Cheque' ) {
            jQuery( '#fobvDonateMethodChequeHelp' ).show(
                'slow', function () {
            } );
            jQuery( '#fobvDonateMethodBankTransferHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvDonateMethodOnlineHelp' ).hide(
                'slow', function () {
            } );
        } else if ( this.value == 'Bank Transfer' ) {
            jQuery( '#fobvDonateMethodChequeHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvDonateMethodBankTransferHelp' ).show(
                'slow', function () {
            } );
            jQuery( '#fobvDonateMethodOnlineHelp' ).hide(
                'slow', function () {
            } );
        } else if ( this.value == 'Online' ) {
            jQuery( '#fobvDonateMethodChequeHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvDonateMethodBankTransferHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvDonateMethodOnlineHelp' ).show(
                'slow', function () {
            } );
        }
    } );

    // Enable/disable confirm email address on page load

    if ( jQuery( "#fobvDonateEmailAddress" ).val() ) {
        jQuery( '#fobvDonateConfirmEmailAddress' ).prop( "disabled", false );
    } else {
        jQuery( '#fobvDonateConfirmEmailAddress' ).prop( "disabled", true );
    }

    // Enable/disable confirm email address on email address change

    jQuery( "#fobvDonateEmailAddress" ).on( "keydown", function() {

        setTimeout(() => {

            if ( jQuery( "#fobvDonateEmailAddress" ).val() ) {
                jQuery(
                    '#fobvDonateConfirmEmailAddress'
                ).prop( "disabled", false );
            } else {
                jQuery(
                    '#fobvDonateConfirmEmailAddress'
                ).prop( "disabled", true );
            }

        }, 200)

    } );

    // Include the reCAPTCHA user response in the form submission

    jQuery( "#fobvDonateFormSubmit" ).on( "click", function( e ) {

        e.preventDefault();

        if ( jQuery( "#fobvDonateForm" ).valid() ) {

            grecaptcha.ready( function() {

                grecaptcha.execute(
                    "6LdpFqcZAAAAAKRjxMkXmIS3ABny6VUVlnbc9AcB",
                    { action: "donate" }
                ).then( function( token ) {
                    jQuery( "#fobvDonateForm" ).append(
                        '<input type="hidden" name="g-recaptcha-response" ' +
                        'value="' + token + '">'
                    );
                    jQuery( "#fobvDonateForm" ).submit();
                  }
                );

            } );

        }

    } );

    // Define validation rules for this form

    jQuery( "#fobvDonateForm" ).validate( {

        rules: {
            fobv_donate_amount: {
                required: true
            },
            fobv_donate_email_address: {
                email: true
            },
            fobv_donate_confirm_email_address: {
                equalTo: "#fobvDonateEmailAddress"
            },
            fobv_donate_amount_other_value: {
                required: function () {
                    if ( jQuery( "#fobvDonateAmountOther" ).is( ":checked" ) ) {
                        return true;
                    } else {
                        return false;
                    }
                },
                digits: true
            }
        }

    } );

} );
