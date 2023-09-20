jQuery( document ).ready( function() {

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
                console.log('Donate email address does NOT have a value');
            }

        }, 200)

    } );
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
            }
        }
    } );
} );
