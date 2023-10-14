jQuery( document ).ready( function() {

    if ( ! jQuery( '#fobvJoinUsMethodCash' ).attr('checked') ) {
        jQuery( '#fobvJoinUsMethodCashHelp' ).hide();
    }

    if ( ! jQuery( '#fobvJoinUsMethodCheque' ).attr('checked') ) {
        jQuery( '#fobvJoinUsMethodChequeHelp' ).hide();
    }

    if ( ! jQuery( '#fobvJoinUsMethodBankTransfer' ).attr('checked') ) {
        jQuery( '#fobvJoinUsMethodBankTransferHelp' ).hide();
    }

    if ( ! jQuery( '#fobvJoinUsMethodOnline' ).attr('checked') ) {
        jQuery( '#fobvJoinUsMethodOnlineHelp' ).hide();
    }

    jQuery(
        'input[type=radio][name=fobv_join_us_method]'
    ).change( function () {
        if ( this.value == 'Cash' ) {
            jQuery( '#fobvJoinUsMethodCashHelp' ).show(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsMethodChequeHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsMethodBankTransferHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsMethodOnlineHelp' ).hide(
                'slow', function () {
            } );
        } else if ( this.value == 'Cheque' ) {
            jQuery( '#fobvJoinUsMethodCashHelp' ).hide(
                'slow', function () {
            } );
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
            jQuery( '#fobvJoinUsMethodCashHelp' ).hide(
                'slow', function () {
            } );
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
            jQuery( '#fobvJoinUsMethodCashHelp' ).hide(
                'slow', function () {
            } );
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
