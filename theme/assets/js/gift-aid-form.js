jQuery( document ).ready( function() {

    if ( jQuery( '#fobvGiftAidToggle' ).attr( 'checked' ) ) {
        jQuery( '#fobvGiftAidDeclaration' ).show();
    } else {
        jQuery( '#fobvGiftAidDeclaration' ).hide();
    }

    jQuery( '#fobvGiftAidToggle' ).on( 'change', function () {

        if ( this.checked ) {

            jQuery( '#fobvGiftAidDeclaration' ).show( 'slow', function () {
            } );

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

            jQuery( '#fobvGiftAidDeclaration' ).hide( 'slow', function () {
            } );

        }

    } );

} );