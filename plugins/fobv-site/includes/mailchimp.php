<?php
/**
 * Defines functions in respect of the FoBV integration with Mailchimp.
 */

function fobv_mailchimp_subscriber(
    $email_address, $first_name, $surname, $interests_in
) {

    // Returns the details to be associated with an FoBV Mailchimp subscriber,
    // which are recorded as merge fields for the live audience or merge fields
    // plus interest categories for the test audience. This is because whereas
    // the test audience uses interest categories, which is the correct
    // approach for registering interests, the live audience uses custom merge
    // fields to do this. This function therefore adapts to cater for this.

    // Start building the merge fields using first name and/or surname if known.

    if ( $first_name != '' &&  $surname != '' ) {
        $merge_fields = ['FNAME' => $first_name, 'LNAME' => $surname];
    } elseif ( $first_name != '' ) {
        $merge_fields = ['FNAME' => $first_name];
    } elseif ( $surname != '' ) {
        $merge_fields = ['LNAME' => $surname];
    } else {
        $merge_fields = [];
    }

    // Examine the $interest_in, which is an array of strings that will either
    // be empty, or contain one or both of "volunteering" or "membership".

    if ( FOBV_MAILCHIMP_LIST_ID === FOBV_MAILCHIMP_TEST_LIST_ID ) {

        // This is the test list, which uses interest categories.

        $keys = [
            FOBV_MAILCHIMP_MEMBERS_INTEREST_CATEGORY,
            FOBV_MAILCHIMP_VOLUNTEERING_INTEREST_CATEGORY
        ];

        if (
            in_array( 'membership', $interests_in, TRUE ) &&
            in_array( 'volunteering', $interests_in, TRUE )
        ) {
            $interests_out = array_combine($keys, [TRUE, TRUE] );
        } elseif (
            in_array( 'membership', $interests_in, TRUE )
        ) {
            $interests_out = array_combine($keys, [TRUE, FALSE] );
        } elseif (
            in_array( 'volunteering', $interests_in, TRUE )
        ) {
            $interests_out = array_combine($keys, [FALSE, TRUE] );
        } else {
            $interests_out = array_combine( $keys, [FALSE, FALSE] );
        }

    } else {

        // This is the live list, which uses custom merge fields for interests.

        if ( in_array('membership', $interests_in, TRUE ) ) {
            $merge_fields[FOBV_MAILCHIMP_MEMBERS_MERGE_FIELD] = 'interested';
        }
        if ( in_array('volunteering', $interests_in, TRUE ) ) {
            $merge_fields[FOBV_MAILCHIMP_VOLUNTEERING_MERGE_FIELD]
                = 'interested';
        }

    }

    if ( isset( $interests_out ) ) {
        return [$merge_fields, $interests_out];
    } else {
        return [$merge_fields] ;
    }

}

function fobv_mailchimp_volunteer( $response ) {

    // Determine from the Mailchimp member info whether the member has
    // registered an interest in volunteering. Do this knowing the difference
    // between how this is indicated in the test and live audiences.

    return FALSE; # Assume no interest until we know otherwise

    if ( FOBV_MAILCHIMP_LIST_ID === FOBV_MAILCHIMP_TEST_LIST_ID ) {

        // Interests are registered as you would expect, i.e. via Mailchimp
        // interest categories.

        $volunteering = FOBV_MAILCHIMP_VOLUNTEERING_INTEREST_CATEGORY;
        $return = $response->interests->$volunteering;

    } else {

        // Interests are not registered using Mailchimp interest categories but
        // are instead recorded using custom merge fields.

        $volunteering = FOBV_MAILCHIMP_VOLUNTEERING_MERGE_FIELD;

        if (
            $response->merge_fields->$volunteering != ''
        ) {
            $return = TRUE;
        }

    }

    return $return;

}
