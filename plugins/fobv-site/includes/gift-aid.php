<?php
/**
 *  Implements the action invoked by submitting the gift aid form.
 */

function fobv_gift_aid() {

    // -------------------------------------------------------------------------
    // 1. Nonce security check
    // -------------------------------------------------------------------------

    if (
        ! array_key_exists( 'fobv_gift_aid_nonce', $_POST ) ||
        ! wp_verify_nonce(
            $_POST[ 'fobv_gift_aid_nonce' ], FOBV_GIFT_AID_CONTEXT
        )
    ) {
        die( __( 'Security check', 'textdomain' ) );
    }

    // -------------------------------------------------------------------------
    // 2. Update the transaction
    // -------------------------------------------------------------------------

    $transaction = $_POST[ 'transaction' ];

    $query = http_build_query( [ 'transaction' => $transaction ] );

    foreach ( [
        'toggle', 'first_name', 'surname', 'address_line_1', 'address_line_2',
        'address_line_3', 'address_line_4', 'postcode'
    ] as $var ) {

        $post_var = 'fobv_gift_aid_' . $var;

        if (
            array_key_exists( $post_var, $_POST )
            && ! empty( $_POST[ $post_var ] )
        ) {
            $$var = $_POST[ $post_var ];
        } else {
            $$var = NULL;
        }

        $_SESSION[ $transaction ][ $post_var ] = $$var;

    }

    // -------------------------------------------------------------------------
    // 3. Validate the form inputs just received
    // -------------------------------------------------------------------------

    foreach ( [
        'first_name_class', 'first_name_error', 'surname_class',
        'surname_error', 'address_line_1_class', 'address_line_1_error',
        'address_line_2_class', 'address_line_2_error', 'postcode_class',
        'postcode_error'
    ] as $var ) {

        unset( $_SESSION[ $transaction ][ "fobv_gift_aid_$var" ] );

    }

    $errors = FALSE;

    if ( $toggle === 'on' ) {

        if ( ! isset( $first_name ) ) {

            $_SESSION[ $transaction ][ 'fobv_gift_aid_first_name_class' ]
                = 'error';
            $_SESSION[ $transaction ][ 'fobv_gift_aid_first_name_error' ]
                = 'This field is required.';
            $errors = TRUE;

        }

        if ( ! isset( $surname ) ) {

            $_SESSION[ $transaction ][ 'fobv_gift_aid_surname_class' ]
                = 'error';
            $_SESSION[ $transaction ][ 'fobv_gift_aid_surname_error' ]
                = 'This field is required.';
            $errors = TRUE;

        }

        if ( ! isset( $address_line_1 ) ) {

            $_SESSION[ $transaction ][ 'fobv_gift_aid_address_line_1_class' ]
                = 'error';
            $_SESSION[ $transaction ][ 'fobv_gift_aid_address_line_1_error' ]
                = 'This field is required.';
            $errors = TRUE;

        }

        if ( ! isset( $address_line_2 ) ) {

            $_SESSION[ $transaction ][ 'fobv_gift_aid_address_line_2_class' ]
                = 'error';
            $_SESSION[ $transaction ][ 'fobv_gift_aid_address_line_2_error' ]
                = 'This field is required.';
            $errors = TRUE;

        }

        if ( ! isset( $postcode ) ) {

            $_SESSION[ $transaction ][ 'fobv_gift_aid_postcode_class' ]
                = 'error';
            $_SESSION[ $transaction ][ 'fobv_gift_aid_postcode_error' ]
                = 'This field is required.';
            $errors = TRUE;

        }

    }

    if ( $errors ) {

        wp_redirect( "/gift-aid/?$query#fobvGiftAidForm" );
        exit();

    }

    // -------------------------------------------------------------------------
    // 4. Notification
    // -------------------------------------------------------------------------

    $fobv_env = FOBV_ENV;

    if ( preg_match( '/^fobv_donate/', $transaction ) ) {

        // This is a donation

        foreach ( [
            'amount', 'amount_other_value', 'method', 'reference',
            'email_address'
        ] as $var ) {

            $$var = $_SESSION[ $transaction ][ "fobv_donate_$var" ];

        }

        if ( $amount === 'Other') {
            $amount = $amount_other_value;
        }

        $subject = 'Donation Notification';

        if ( $fobv_env != 'live' ) {
            $subject .= " ($fobv_env)";
        }

        $message = <<<"EOD"
A donation of £$amount using payment method $method was initiated via the
$fobv_env website.

EOD;

        if ( $method === 'Cheque' ) {

            $message .= <<<"EOD"

They were requested to write the payment reference $reference on the back of the
back of the cheque.

EOD;

        } elseif ( $method === 'Bank Transfer' ) {

            $message .= <<<"EOD"

They were requested to use the payment reference $reference when instructing
their bank transfer.

EOD;

        } elseif ( $method === 'Online' ) {

            $message .= <<<"EOD"

Since they chose to pay online, they would have been passed through to PayPal to
authorise the payment. This does not mean that they followed through but if they
did then the transaction in PayPal will have the reference $reference.

EOD;

        }

        if ( isset( $email_address ) ) {

            $message .= <<<"EOD"

The donor gave their email address as $email_address.

EOD;

        } else {

            $message .= <<<'EOD'

The donor chose not to provide their email address.

EOD;

        }

        $notifications = fobv_notification_email_addresses( 'donate' );

    } elseif ( preg_match( '/^fobv_join_us/', $transaction ) ) {

        // This is a membership renewal or a new joiner.

        foreach ( [
            'first_name', 'surname', 'email_address', 'address_lines_toggle',
            'postcode', 'telephone', 'amount', 'method', 'reference'
        ] as $var ) {

            $$var = $_SESSION[$transaction]["fobv_join_us_$var"];

        }

        // First notify the relevant officers of The FoBV.

        $subject = 'Membership Notification';

        if ( $fobv_env != 'live' ) {
            $subject .= " ($fobv_env)";
        }

        $message = <<<"EOD"
Someone used the website to either register as a member or renew their
membership. They entered their contact details as follows:
First Name=$first_name
Surname=$surname
Email Address=$email_address
EOD;

        if ( $address_lines_toggle === 'on' ) {

            foreach ( [
                'address_line_1', 'address_line_2', 'address_line_3',
                'address_line_4'
            ] as $var ) {

                $$var = $_SESSION[$transaction]["fobv_join_us_$var"];

            }

            $message .= <<<"EOD"
Address Line 1=$address_line_1
Address Line 2=$address_line_2
Address Line 3=$address_line_3
Address Line 4=$address_line_4
EOD;

        }

        $message = <<<"EOD"
Postcode=$postcode
Telephone=$telephone

EOD;

        // Ensure that the member is subscribed to our Mailchimp audience with
        // an interest in membership registered.

        if ( FOBV_MAILCHIMP_LIST_ID === FOBV_MAILCHIMP_TEST_LIST_ID ) {
            // In the test list interests are in the interests field (correct).
            $fields = 'status,interests';
        } else {
            // In the live list interests are in merge fields (a frig).
            $fields = 'status,merge_fields';
        }

        $response = varilink_mailchimp_get_member_info(
            FOBV_MAILCHIMP_API_KEY,
            FOBV_MAILCHIMP_API_ROOT,
            FOBV_MAILCHIMP_LIST_ID,
            $email_address,
            [ 'fields' => $fields]
        );

        if ( $response ) {

            if ( $response[ 'body' ][ 'status' ] === 'subscribed' ) {

                // The member is already subscribed to our Mailchimp audience so
                // just make sure that they have an interest in membership
                // registered too.

                if ( fobv_mailchimp_volunteer( $response ) ) {
                    $interests = ['volunteering', 'membership'];
                } else {
                    $interests = ['membership'];
                }

                $subscriber = fobv_mailchimp_subscriber(
                    $email_address, $first_name, $surname, $interests
                );

                $merge_fields = array_pop( $subscriber );

                $request = [
                    'email_address' => $email_address,
                    'status_if_new' => 'subscribed',
                    'status' => 'subscribed',
                    'merge_fields' => $merge_fields
                ];

                if ( $subscriber ) {
                    $request['interests'] = array_pop( $subscriber );
                }

                varilink_mailchimp_add_or_update_list_member(
                    FOBV_MAILCHIMP_API_KEY,
                    FOBV_MAILCHIMP_API_ROOT,
                    FOBV_MAILCHIMP_LIST_ID,
                    $request
                );

                $message .= <<<'EOD'
The member was already subscribed to our Mailchimp list. Their subscription has
been tagged with an interest in membership news, if it wasn't already.
EOD;

            } elseif ( $response[ 'body' ][ 'status' ] === 'unsubscribed' ) {

                // What to do is TBC

            } elseif ( $response[ 'body' ][ 'status' ] === 'cleaned' ) {

                // What to do is TBC

            } elseif ( $response[ 'body' ][ 'status' ] === 'pending' ) {

                // The member has a pending subscription, in the sense that
                // Mailchimp is waiting for them to confirm their email address.

                if ( fobv_mailchimp_volunteer( $response ) ) {
                    $interests = ['volunteering', 'membership'];
                } else {
                    $interests = ['membership'];
                }

                $subscriber = fobv_mailchimp_subscriber(
                    $email_address, $first_name, $surname, $interests
                );

                $merge_fields = array_pop( $subscriber );

                $request = [
                    'email_address' => $email_address,
                    'status_if_new' => 'pending',
                    'status' => 'pending',
                    'merge_fields' => $merge_fields
                ];

                if ( $subscriber ) {
                    $request['interests'] = array_pop( $subscriber );
                }

                varilink_mailchimp_add_or_update_list_member(
                    FOBV_MAILCHIMP_API_KEY,
                    FOBV_MAILCHIMP_API_ROOT,
                    FOBV_MAILCHIMP_LIST_ID,
                    $request
                );

                $message .= <<<'EOD'

The member already had a PENDING subscription to our Mailchimp list, meaning
that they have subscribed but haven't yet confirmed their email address using
the link in the email that Mailchimp has sent them to do this. Their
subscription has been tagged with an interest in membership news, if it wasn't
already.

EOD;

            } elseif ( $response[ 'body' ][ 'status' ] === 'transactional' ) {

                // What to do is TBC

            }

        } else {

            // The member is not a subscriber to our Mailchimp audience, so
            // subscribe them with an interest in membership registered.

            $interests = ['membership'];

            $subscriber = fobv_mailchimp_subscriber(
                $email_address, $first_name, $surname, $interests
            );

            $merge_fields = array_pop( $subscriber );

            $request = [
                'email_address' => $email_address,
                'status_if_new' => 'pending',
                'status' => 'pending',
                'merge_fields' => $merge_fields
            ];

            if ( $subscriber ) {
                $request['interests'] = array_pop( $subscriber );
            }

            varilink_mailchimp_add_or_update_list_member(
                FOBV_MAILCHIMP_API_KEY,
                FOBV_MAILCHIMP_API_ROOT,
                FOBV_MAILCHIMP_LIST_ID,
                $request
            );

            $message .= <<<'EOD'

The member is not a subscriber to our Mailchimp list. A PENDING subscription,
including an interest in membership news has been created and they have been
sent an email asking them to confirm their subscription.

EOD;

        }

        $message .= <<<"EOD"

The member gave their payment details as follows:
Amount=£$amount
Method=$method

EOD;

        if ( $method === 'Cheque' ) {

            $message .= <<<"EOD"

They were requested to write the payment reference $reference on the back of the
back of the cheque.

EOD;

        } elseif ( $method === 'Bank Transfer' ) {

            $message .= <<<"EOD"

They were requested to use the payment reference $reference when instructing
their bank transfer.

EOD;

        } elseif ( $method === 'Online' ) {

            $message .= <<<"EOD"

Since they chose to pay online, they would have been passed through to PayPal to
authorise the payment. This does not mean that they followed through but if they
did then the transaction in PayPal will have the reference $reference.

EOD;

        }

        $notifications = fobv_notification_email_addresses( 'join_us' );

    }

    // Report gift aid details, which we do for any payment, whether it is
    // associated with a donation or a new or renewing member.

    if ( $toggle === 'on' ) {

        $message .= <<<"EOD"

The payee made a Gift Aid declaration and provided details as follows:
First name=$first_name
Surname=$surname
Address Line 1=$address_line_1
Address Line 2=$address_line_2
Address Line 3=$address_line_3
Address Line 4=$address_line_4
Postcode=$postcode

EOD;

    } else {

        $message .= <<<'EOD'

The payee did NOT make a Gift Aid declaration.

EOD;

    }

    // Now send the notification email to the relevant officers of The FoBV,
    // either for a donation or a new or rejoining member.

    if ( fobv_test_email_address() ) {

        // We are in test mode for email notifications. In this mode all emails
        // go to the current logged in user rather than the usual recipients.
        // We also report who the true recipients would have been if we weren't
        // in test mode within the email.

        $true_to = implode( PHP_EOL, $notifications );
        $message .= <<<"EOD"

We are in test mode in respect of email notifications. The "true" recipients of
this email would have been (if we weren't in test mode):
$true_to
EOD;
        $to = fobv_test_email_address();
    } else {
        $to = $notifications;
    }

    wp_mail( $to, $subject, $message );

    // For new or rejoining members (not for donations) also go on to send a
    // welcome email to the member.

    if ( preg_match( '/^fobv_join_us/', $transaction ) ) {

        function fobv_set_html_mail_content_type () {
            return 'text/html';
        }

        add_filter( 'wp_mail_content_type', 'fobv_set_html_mail_content_type' );

        if ( fobv_test_email_address() ) {
            $to = fobv_test_email_address();
        } else {
            $to = $email_address;
        }

        $site_url = site_url();

        $message = <<<"EOD"
<p>
    Thank you for signing up to become a Friend of Bennerley Viaduct, and a warm
    welcome to you. If you are a new member, thank you for joining us: if you
    are returning or renewing, welcome back, your continued support is much
    appreciated.
</p>
<p>
    The fee you pay for your membership is vital to support our ongoing work, it
    is one of the major income streams for our charity. The strength of our
    membership proves to external funders and potential partners how much
    community support we have – whether you live and work near the Iron Giant or
    are part of our global community, here because you love heritage, railways
    or historic civil engineering.
</p>
<p>
    You are also the lifeblood of the organisation: our members help us raise
    the profile of the viaduct with their own friends, families and colleagues,
    they volunteer in a host of ways, and they are part of our committees,
    making important decisions for our future.
</p>
<p>
    To find out more about your membership and our group please read this
    <a href=
    "$site_url/wp-content/uploads/2022/12/Members-Welcome-Pack-1.pdf"
    >Welcome Pack</a>.
</p>
<p>
    To understand the terms of your membership and how we store our data you can
    read <a href=
    "$site_url/wp-content/uploads/2022/12/Membership-Information-Sheet-.pdf"
    >Membership Ts and Cs</a>.
</p>
<p>
    We’re very happy you’ve taken the step to become a member, and please do get
    in touch if you have any questions, or feedback, on your experience of being
    part of FoBV.
</p>
<p>
    You can email <a href="mailto:info@bennerleyviaduct.org.uk">
    info@bennerleyviaduct.org.uk</a> to speak to the main office and volunteers
    If you have questions about your membership or data you can contact our
    Membership Secretary on <a href="mailto:membership@bennerleyviaduct.org.uk">
    membership@bennerleyviaduct.org.uk</a>.
</p>

EOD;

        if ( fobv_test_email_address() ) {

            // We are in test mode for email notifications. In this mode all
            // emails go to the current logged in user rather than the usual
            // recipients. We also report who the true recipients would have
            // been if we weren't in test mode within the email.

            $true_to = $email_address;
            $message .= <<<"EOD"
<p>
    We are in test mode in respect of email notifications. The "true" recipient
    of this email would have been (if we weren't in test mode) $email_address.
</p>

EOD;
            $to = fobv_test_email_address();

        } else {
            $to = $email_address;
        }

        wp_mail(
            $to, 'Welcome to the Friends of Bennerley Viaduct', $message,
            [ 'Reply-To: membership@bennerleyviaduct.org.uk' ]
        );

        remove_filter(
            'wp_mail_content_type', 'fobv_set_html_mail_content_type'
        );

    }

    // -------------------------------------------------------------------------
    // 6. Execution
    // -------------------------------------------------------------------------

    if ( $method === 'Online' ) {

        $approve_link = fobv_paypal_create_order(
            $transaction, $amount, $reference
        );

        wp_redirect( $approve_link );
        exit();

    } elseif ( preg_match( '/^fobv_donate/', $transaction ) ) {

        wp_redirect( "/donation-pledged/?$query" );
        exit();

    } elseif ( preg_match( '/^fobv_join_us/', $transaction ) ) {

        wp_redirect( '/membership-confirmed/' );
        exit();

    }

}

add_action( 'admin_post_nopriv_fobv_gift_aid', 'fobv_gift_aid' );
add_action( 'admin_post_fobv_gift_aid', 'fobv_gift_aid' );
