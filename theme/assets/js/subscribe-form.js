jQuery( document ).ready( function() {

    jQuery( '#fobvSubscribeForm' ).validate( {
        rules: {
            fobv_subscribe_email_address: {
                required: true,
                email: true
            }
        }
    } );

} );
