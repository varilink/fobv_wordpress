jQuery( document ).ready( function() {

    // Hide help for unchecked payment methods on page load

    if ( ! jQuery( '#fobvJoinUsMethodCheque' ).attr('checked') ) {
        jQuery( '#fobvJoinUsMethodChequeHelp' ).hide();
    }

    if ( ! jQuery( '#fobvJoinUsMethodBankTransfer' ).attr('checked') ) {
        jQuery( '#fobvJoinUsMethodBankTransferHelp' ).hide();
    }

    if ( ! jQuery( '#fobvJoinUsMethodOnline' ).attr('checked') ) {
        jQuery( '#fobvJoinUsMethodOnlineHelp' ).hide();
    }

    // Show/hide help for payment methods on payment method change

    jQuery(
        'input[type=radio][name=fobv_join_us_method]'
    ).change( function () {
        if ( this.value == 'Cheque' ) {
            jQuery( '#fobvJoinUsMethodChequeHelp' ).show(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsMethodBankTransferHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsMethodOnlineHelp' ).hide(
                'slow', function () {
            } );
        } else if ( this.value == 'Bank Transfer' ) {
            jQuery( '#fobvJoinUsMethodChequeHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsMethodBankTransferHelp' ).show(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsMethodOnlineHelp' ).hide(
                'slow', function () {
            } );
        } else if ( this.value == 'Online' ) {
            jQuery( '#fobvJoinUsMethodChequeHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsMethodBankTransferHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsMethodOnlineHelp' ).show(
                'slow', function () {
            } );
        }
    } );

    // Include the reCAPTCHA user response in the form submission

    jQuery( "#fobvJoinUsFormSubmit" ).on( "click", function( e ) {

        e.preventDefault();

        if ( jQuery( "#fobvJoinUsForm" ).valid() ) {

            grecaptcha.ready( function() {

                grecaptcha.execute(
                    "6LdpFqcZAAAAAKRjxMkXmIS3ABny6VUVlnbc9AcB",
                    { action: "join_us" }
                ).then( function( token ) {
                    jQuery( "#fobvJoinUsForm" ).append(
                        '<input type="hidden" name="g-recaptcha-response" ' +
                        'value="' + token + '">'
                    );
                    jQuery( "#fobvJoinUsForm" ).submit();
                  }
                );

            } );

        }

    } );

    // Define validation rules for this form

    jQuery( '#fobvJoinUsForm' ).validate( {

        rules: {
            fobv_join_us_first_name: {
                required: true
            },
            fobv_join_us_surname: {
                required: true
            },
            fobv_join_us_email_address: {
                required: true,
                email: true
            },
            fobv_join_us_confirm_email_address: {
                required: true,
                equalTo: '#fobvJoinUsEmailAddress'
            },
            fobv_join_us_postcode: {
                required: true
            }
        }

    } );

} );
