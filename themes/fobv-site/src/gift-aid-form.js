jQuery( document ).ready( function() {

    // Show/hide gift aid declaration on page load

    if ( jQuery( '#fobvGiftAidToggle' ).attr( 'checked' ) ) {
        jQuery( '#fobvGiftAidDeclaration' ).show();
    } else {
        jQuery( '#fobvGiftAidDeclaration' ).hide();
    }


    // Show/hide gift aid declaration on gift aid toggle

    jQuery( '#fobvGiftAidToggle' ).on( 'change', function () {

        if ( this.checked ) {

            jQuery( '#fobvGiftAidDeclaration' ).show( 'slow', function () { } );

            // Validate gift aid declaration if gift aid is selected

            jQuery( '#fobvGiftAidForm' ).validate( {
                rules: {
                    fobv_gift_aid_first_name: {
                        required: true
                    },
                    fobv_gift_aid_surname: {
                        required: true
                    },
                    fobv_gift_aid_address_line_1: {
                        required: true
                    },
                    fobv_gift_aid_address_line_2: {
                        required: true
                    },
                    fobv_gift_aid_postcode: {
                        required: true
                    }
                }
            } );

        } else {

            jQuery( '#fobvGiftAidDeclaration' ).hide( 'slow', function () { } );

        }

    } );

} );