jQuery( document ).ready( function() {

    if ( jQuery( "#fobvDonateAmountOther" ).is( ":checked" ) ) {
        jQuery( '#fobvDonateAmountOtherValue' ).prop( "disabled", false );
    } else {
        jQuery( '#fobvDonateAmountOtherValue' ).prop( "disabled", true );
    }

    jQuery( "input:radio[name=fobv_donate_amount]").change( function () {

        if ( jQuery( "#fobvDonateAmountOther" ).is( ":checked" ) ) {
            jQuery( '#fobvDonateAmountOtherValue' ).prop( "disabled", false );
        } else {
            jQuery( '#fobvDonateAmountOtherValue' ).prop( "disabled", true );
        }

    } );

    if ( jQuery( "#fobvDonateEmailAddress" ).val() ) {
        jQuery( '#fobvDonateConfirmEmailAddress' ).prop( "disabled", false );
    } else {
        jQuery( '#fobvDonateConfirmEmailAddress' ).prop( "disabled", true );
    }

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
