<?php
/**
 * Setup a menu page for FoBV site specific settings.
 */

function fobv_add_menu_page () {

    // This function adds the menu page including its content and associated
    // help tabs.

    global $fobv_menu_page;

    // Callback function that outputs the menu page's content.

    function fobv_show_menu_page () {

        global $fobv_menu_page;

?>
<div class="wrap">
<h1>FoBV Settings</h1>
<p>These are the site specific settings for the Friends of Bennerley Viaduct (FoBV) website. See the help above for guidance.</p>
<form method="post" action="options.php">
<?php

        settings_fields( 'fobv' );
        settings_errors();
        do_settings_sections( $fobv_menu_page );

?>
<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
</form>
</div>
<?php

    }

    // Callback function that outputs the help tabs for the menu page.

    function fobv_show_menu_page_help () {

        $content = <<<'EOD'
<p>The FoBV website contains several "calls to action" for website visitors as follows:</p>
<ul>
<li>Donate - make a financial contribution to the FoBV</li>
<li>Join Us - become a friend of the FoBV (includes membership renewals)</li>
<li>Subscribe - receive FoBV email bulletins</li>
</ul>
<p>When a website visitor responds to one of these calls to action the website can email the details to one or more email addresses, typically corresponding to officers of the FoBV. Those email addresses are configured below for each of the calls to action.</p>
<p>Email addresses must be entered one address to a line. If the address is <em>something</em>@bennerleyviaduct.org.uk you can enter just <em>something</em> and the bennerleyviaduct.org.uk domain will be assumed. For email addresses in other domains you must enter the full address.</p>
EOD;

        $screen = get_current_screen();
        $screen->add_help_tab( [
            'id'      => 'notifications',
            'title'   => __( 'Notifications' ),
            'content' => $content
        ] );
    
    }

    // Register the menu page and hook the associated content and help tabs
    // callbacks to it

    $fobv_menu_page = add_menu_page(
        'FoBV Settings'      , # Page title
        'FoBV'               , # Menu title
        'fobv_manage_options', # Capability
        'fobv'               , # Menu slug
        'fobv_show_menu_page'
    );

    add_action( 'load-' . $fobv_menu_page, 'fobv_show_menu_page_help' );

}

add_action( 'admin_menu', 'fobv_add_menu_page' );

function fobv_add_settings () {

    // This function registers the settings for the menu page, including
    // associated validation and how those settings are displayed on the menu
    // page.

    global $fobv_menu_page;

    function sanitize_fobv_notification_email_addresses (
        $value, $option
    ) {

        $errors_found = FALSE;
        $return_value = get_option( $option );
        $reconstructed_value = NULL;

        foreach ( explode( PHP_EOL, $value ) as $line ) {

            $line = trim($line);

            if ( $line ) {

                if ( preg_match( '/@/', $line ) ) {
                    $email_address = $line;
                } else {
                    $email_address = "$line@bennerleyviaduct.org.uk";
                }

                if ( filter_var( $email_address, FILTER_VALIDATE_EMAIL ) ) {

                    if ( isset( $reconstructed_value ) ) {
                        $reconstructed_value .= PHP_EOL . $line;
                    } else {
                        $reconstructed_value = $line;
                    }

                } else {

                    $errors_found = TRUE;

                    preg_match(
                        '/^fobv_(\w+)_notification_email_addresses$/',
                        $option,
                        $matches
                    );

                    $title = ucwords( str_replace( '_', ' ', $matches[ 1 ] ) );

                    add_settings_error(
                        $option,
                        $option,
                        "Line \"$line\" for option \"$title\" is invalid and has been ignored"
                    );

                }

            }


        }

        if ( ! $errors_found ) { $return_value = $reconstructed_value; }

        return $return_value;

    }

    register_setting(
        'fobv'                                       , # Option group
        'fobv_donate_notification_email_addresses'   , # Option name
    );

    add_filter(
        'sanitize_option_fobv_donate_notification_email_addresses',
        'sanitize_fobv_notification_email_addresses',
        10, 2
    );

    register_setting(
        'fobv'                                       , # Option group
        'fobv_join_us_notification_email_addresses'    # Option name
    );

    add_filter(
        'sanitize_option_fobv_join_us_notification_email_addresses',
        'sanitize_fobv_notification_email_addresses',
        10, 2
    );

    register_setting(
        'fobv'                                       , # Option group
        'fobv_subscribe_notification_email_addresses'  # Option name
    );

    add_filter(
        'sanitize_option_fobv_subscribe_notification_email_addresses',
        'sanitize_fobv_notification_email_addresses',
        10, 2
    );

    add_settings_section (
        'fobvNotificationEmailAddresses', # Id
        'Notifications'  , # Title
        function () { echo NULL; }      , # Callback (for content at the top)
        $fobv_menu_page                   # Page
    );

    add_settings_field (
        'Donate'                        , # Id
        'Donate'                        , # Title
        function () {
?>
<textarea name="fobv_donate_notification_email_addresses" rows="6" cols="32">
<?php echo get_option( 'fobv_donate_notification_email_addresses' ); ?>
</textarea>
<?php
        }                               , # Callback
        $fobv_menu_page                 , # Page
        'fobvNotificationEmailAddresses'  # Section
    );
    
    add_settings_field (
        'JoinUs'                        , # Id
        'Join Us'                       , # Title
        function () {
?>
<textarea name="fobv_join_us_notification_email_addresses" rows="6" cols="32">
<?php
echo get_option( 'fobv_join_us_notification_email_addresses' );
?>
</textarea>
<?php
        }                               , # Callback
        $fobv_menu_page                 , # Page
        'fobvNotificationEmailAddresses'  # Section
    );

    add_settings_field (
        'Subscribe'                     , # Id
        'Subscribe'                     , # Title
        function () {
?>
<textarea name="fobv_subscribe_notification_email_addresses" rows="6" cols="32">
<?php echo get_option( 'fobv_subscribe_notification_email_addresses' ); ?>
</textarea>
<?php
        }                               , # Callback
        $fobv_menu_page                 , # Page
        'fobvNotificationEmailAddresses'  # Section
    );

}

add_action( 'admin_init', 'fobv_add_settings' );

function fobv_notification_email_addresses( $call_to_action ) {

    // This function looks up the email addresses to notify when calls-to-action
    // are executed. It gets these from the relevant option that's set for each
    // call to action. The logic that enables these options to be set is above.

    $email_addresses = [];

    $value = get_option(
        "fobv_${call_to_action}_notification_email_addresses"
    );

    foreach ( explode( PHP_EOL, $value ) as $line ) {

        if ( preg_match( '/@/', $line ) ) {
            $email_address = $line;
        } else {
            $email_address = "$line@bennerleyviaduct.org.uk";
        }

        $email_addresses[] = $email_address;

    }

    return $email_addresses;

}

function fobv_test_email_address () {

    // This function returns a test email address if we are in test mode or NULL
    // if we aren't. Test mode is defined as being logged in to WordPress as a
    // user with the admin role. When in test mode, we send email notifications
    // to the test user only, not the normal notification addresses.

    $testing = FALSE; # Start with the assumption that we are using it for real

    if ( is_user_logged_in() ) {

        $user = wp_get_current_user();
        $roles = (array) $user->roles;
        if ( in_array( 'administrator', $roles ) ) {
            $testing = TRUE;
        }

    }

    if ( $testing ) {
        return $user->user_email;
    } else {
        return NULL;
    }

}
