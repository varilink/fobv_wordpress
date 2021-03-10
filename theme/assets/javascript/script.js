jQuery ( function ( $ ) {

  // Add custom script here

  // Run the script once the document is ready

  $ ( document ) . ready ( function ( ) {

    var prefices = [ '' , 'join' , 'renew' ] ;

    function isConfirmId ( id ) {
      if ( id . includes ( 'Confirm' ) ) {
        return true ;
      } else {
        return false ;
      }
    }

    function id4ConfirmId ( idIn ) {
      var idOut ;
      if ( idIn === 'joinInputConfirmEmailAddress' ) {
        idOut = 'joinInputEmailAddress' ;
      } else if ( idIn === 'renewInputConfirmEmailAddress' ) {
        idOut = 'renewInputEmailAddress' ;
      } else {
        idOut = 'inputEmailAddress' ;
      }
      return idOut ;
    }

    function confirmId4Id ( idIn ) {
      var idOut ;
      if ( idIn === 'joinInputEmailAddress' ) {
        idOut = 'joinInputConfirmEmailAddress' ;
      } else if ( idIn === 'renewInputEmailAddress' ) {
        idOut = 'renewInputConfirmEmailAddress' ;
      } else {
        idOut = 'inputConfirmEmailAddress' ;
      }
      return idOut ;
    }

    for ( let i = 0 ; i < prefices . length ; i++ ) {

      var suffix , confirmSuffix ;

      prefices [ i ] === ''
        ? suffix = 'inputEmailAddress'
        : suffix = 'InputEmailAddress' ;

      var id = prefices [ i ] + suffix ;
      var confirmId = confirmId4Id ( id ) ;

      $ ( '#' + id ) . on ( 'change keyup blur input' , function ( ) {

        id = $ ( this ) . attr ( 'id' ) ;
        confirmId = confirmId4Id ( id ) ;

        if ( $ ( this ) . val ( ) === '' ) {
          $ ( '#' + confirmId ) . val ( '' ) ;
          $ ( '#' + confirmId ) . get ( 0 ) . setCustomValidity ( '' ) ;
          if ( confirmId === 'inputConfirmEmailAddress' ) {
            $ ( '#' + confirmId ) . prop ( 'disabled' , true ) ;
          }
        } else {
          if ( confirmId === 'inputConfirmEmailAddress' ) {
            $ ( '#' + confirmId ) . prop ( 'disabled' , false ) ;
          }
        }

      } ) ;

      $ ( '#' + id + ',' + '#' + confirmId ) . change ( function ( ) {

        var idIn = $ ( this ) . attr ( 'id' ) ;

        if ( isConfirmId ( idIn ) ) {
          confirmId = idIn ;
          id = id4ConfirmId ( confirmId ) ;
        } else {
          id = idIn ;
          confirmId = confirmId4Id ( id ) ;
        }

        if ( $ ( '#' + confirmId ) . val ( ) == $ ( '#' + id ) . val ( ) ) {
          $ ( '#' + confirmId ) . get ( 0 ) . setCustomValidity ( '' ) ;
        } else {
          $ ( '#' + confirmId ) . get ( 0 ) . setCustomValidity ( 'Email address mismatch' ) ;
        }

      } ) ;

    }

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
