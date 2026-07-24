jQuery( document ).ready( function() {

    // Define validation rules for this form

    jQuery( '#fobvSubscribeForm' ).validate( {
        rules: {
            fobv_subscribe_email_address: {
                required: true,
                email: true
            }
        }
    } );

    // Include the reCAPTCHA user response in the form submission

    jQuery( "#fobvSubscribeFormSubmit" ).on( "click", function( e ) {

        e.preventDefault();

        if ( jQuery( "#fobvSubscribeForm" ).valid() ) {

            grecaptcha.ready( function() {

                grecaptcha.execute(
                    "6LdpFqcZAAAAAKRjxMkXmIS3ABny6VUVlnbc9AcB",
                    { action: "subscribe" }
                ).then( function( token ) {
                    jQuery( "#fobvSubscribeForm" ).append(
                        '<input type="hidden" name="g-recaptcha-response" ' +
                        'value="' + token + '">'
                    );
                    jQuery( "#fobvSubscribeForm" ).submit();
                  }
                );

            } );

        }

    } );

} );
