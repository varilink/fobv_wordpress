jQuery ( function ( $ ) {

  // Add custom script here

  // Run the script once the document is ready

  $ ( document ) . ready ( function ( ) {

    // On any event that may have changed the value of #inputEmailAddress
    $ ( '#inputEmailAddress' ) . on ( 'change keyup blur input' , function ( ) {

      if ( $ ( this ) . val ( ) === '' ) {
        $ ( '#inputConfirmEmailAddress' ) . val ( '' ) ;
        $ ( '#inputConfirmEmailAddress' ) . get ( 0 ) . setCustomValidity ( '' ) ;
        $ ( '#inputConfirmEmailAddress' ) . prop ( 'disabled' , true ) ;
      } else {
        $ ( '#inputConfirmEmailAddress' ) . prop ( 'disabled' , false ) ;
      }

    } ) ;

    $ ( '#inputEmailAddress,#inputConfirmEmailAddress' ) . change ( function ( ) {

      if ( $ ( '#inputConfirmEmailAddress' ) . val ( ) === $ ( '#inputEmailAddress' ) . val ( ) ) {
        $ ( '#inputConfirmEmailAddress' ) . get ( 0 ) . setCustomValidity ( '' ) ;
      } else {
        $ ( '#inputConfirmEmailAddress' ) . get ( 0 ) . setCustomValidity ( 'Email address mismatch' ) ;
      }

    } ) ;

    // Ensure #giftAid checkbox is unchecked on page reload
    if ( $ ( '#giftAid' ) . prop ( 'checked' ) == true ) {
      $ ( '#giftAidDeclaration' ) . removeClass ( 'collapse' ) ;
    } else {
      $ ( '#giftAidDeclaration' ) . addClass ( 'collapse' ) ;
    }

    // On change of #giftAid checkbox
    $ ( "#giftAid" ) . change ( function ( ) {
      if ( $ ( "#giftAid" ) . prop ( "checked" ) == true ) {
        // User has elected to make a Gift Aid declaration
        // Add required attribute to mandatory input fields
        $ ( "#inputFirstName" ) . attr ( "required" , "true" ) ;
        $ ( "#inputSurname" ) . attr ( "required" , "true" ) ;
        $ ( "#inputAddress1" ) . attr ( "required" , "true" ) ;
        $ ( "#inputAddress2" ) . attr ( "required" , "true" ) ;
        $ ( "#inputPostcode" ) . attr ( "required" , "true" ) ;
      } else {
        // User has not elected to make a Gift Aid declaration
        // Remove required attribute from all text input fields
        $ ( ":text" ) . removeAttr ( "required" ) ;
      }
    } ) ;

  } ) ;

  // Run the script once the window finishes loading

  $ ( window ) . load ( function ( ) {

    $ ( 'form.needs-validation' ) . submit ( function ( ) {

      if ( this . checkValidity ( ) === false ) {
        event . preventDefault ( ) ;
        event . stopPropagation ( ) ;
      }

      $ ( this ) . addClass ( 'was-validated' ) ;

    } ) ;

  } ) ;

  // Run the script once the window finishes loading

  $ ( window ) . load ( function ( ) {

    $ ( 'form.needs-validation' ) . submit ( function ( ) {

      if ( this . checkValidity ( ) === false ) {
        event . preventDefault ( ) ;
        event . stopPropagation ( ) ;
      }

      $ ( this ) . addClass ( 'was-validated' ) ;

    } ) ;

  } ) ;

} ) ;
