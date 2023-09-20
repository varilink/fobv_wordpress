jQuery( document ).ready( function() {

    if ( ! jQuery( '#fobvJoinUsPaymentMethodCash' ).attr('checked') ) {
        jQuery( '#fobvJoinUsPaymentMethodCashHelp' ).hide();
    }

    if ( ! jQuery( '#fobvJoinUsPaymentMethodCheque' ).attr('checked') ) {
        jQuery( '#fobvJoinUsPaymentMethodChequeHelp' ).hide();
    }

    if ( ! jQuery( '#fobvJoinUsPaymentMethodBankTransfer' ).attr('checked') ) {
        jQuery( '#fobvJoinUsPaymentMethodBankTransferHelp' ).hide();
    }

    if ( ! jQuery( '#fobvJoinUsPaymentMethodOnline' ).attr('checked') ) {
        jQuery( '#fobvJoinUsPaymentMethodOnlineHelp' ).hide();
    }

    jQuery(
        'input[type=radio][name=fobv_join_us_payment_method]'
    ).change( function () {
        if ( this.value == 'Cash' ) {
            jQuery( '#fobvJoinUsPaymentMethodCashHelp' ).show(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsPaymentMethodChequeHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsPaymentMethodBankTransferHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsPaymentMethodOnlineHelp' ).hide(
                'slow', function () {
            } );
        } else if ( this.value == 'Cheque' ) {
            jQuery( '#fobvJoinUsPaymentMethodCashHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsPaymentMethodChequeHelp' ).show(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsPaymentMethodBankTransferHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsPaymentMethodOnlineHelp' ).hide(
                'slow', function () {
            } );
        } else if ( this.value == 'Bank Transfer' ) {
            jQuery( '#fobvJoinUsPaymentMethodCashHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsPaymentMethodChequeHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsPaymentMethodBankTransferHelp' ).show(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsPaymentMethodOnlineHelp' ).hide(
                'slow', function () {
            } );
        } else if ( this.value == 'Online' ) {
            jQuery( '#fobvJoinUsPaymentMethodCashHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsPaymentMethodChequeHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsPaymentMethodBankTransferHelp' ).hide(
                'slow', function () {
            } );
            jQuery( '#fobvJoinUsPaymentMethodOnlineHelp' ).show(
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