jQuery( document ).ready( function() {

    if ( jQuery( '#fobvPaymentGiftAid' ).attr( 'checked' ) ) {
        jQuery( '#fobvGiftAidDeclaration' ).show();
    } else {
        jQuery( '#fobvGiftAidDeclaration' ).hide();
    }

    jQuery( '#fobvPaymentGiftAid' ).on( 'change', function () {

        if ( this.checked ) {

            jQuery( '#fobvGiftAidDeclaration' ).show( 'slow', function () {
            } );

            jQuery( '#fobvGiftAidForm' ).validate( {
                rules: {
                    fobv_payment_first_name: {
                        required: true
                    },
                    fobv_payment_surname: {
                        required: true
                    },
                    fobv_payment_address_line_1: {
                        required: true
                    },
                    fobv_payment_address_line_2: {
                        required: true
                    },
                    fobv_payment_postcode: {
                        required: true
                    }
                }
            } );

        } else {

            jQuery( '#fobvGiftAidDeclaration' ).hide( 'slow', function () {
            } );

        }

    } );

} );