<?php
 /**
  * Sends fatal error emails to users with the admin role who optin
  *
  * @package    CoreFunctionality
  * @since      2.0.0
  * @copyright  Copyright (c) 2020, Patrick Boehner
  * @license    GPL-2.0+
  */


//* Block Acess
//**********************
if( !defined( 'ABSPATH' ) ) exit;

 
// Add custom checkbox field to user profile
add_action( 'show_user_profile', 'add_custom_checkbox_field' );
add_action( 'edit_user_profile', 'add_custom_checkbox_field' );
function add_custom_checkbox_field( $user ) {

    // Exit if the user can't edit_users
    if ( !current_user_can( 'edit_users' ) ) {
        return $user;
    }

    // Retrieve meta values
    $is_recovery_email = get_user_meta( $user->ID, 'is_recovery_email', true );
    $checked = $is_recovery_email ? 'checked' : '';

    // Setup form
    ?>
    <h3><?php esc_html_e( 'Recovery Mode Emails', 'core-functionality' ); ?></h3>
    <table class="form-table">
        <tr>
            <th>
                <label for="is_recovery_email"><?php esc_html_e( 'Receive Recovery Mode Emails', 'core-functionality' ); ?></label>
            </th>
            <td>
                <input type="checkbox" id="is_recovery_email" name="is_recovery_email" <?php echo esc_attr( $checked ); ?>>
                <span class="description"><?php esc_html_e( 'Check this box to receive recovery mode emails.', 'core-functionality' ); ?></span>
            </td>
        </tr>
    </table>
    <?php

}


// Save custom checkbox field
add_action( 'personal_options_update', 'save_custom_checkbox_field' );
add_action( 'edit_user_profile_update', 'save_custom_checkbox_field' );
function save_custom_checkbox_field( $user_id ) {

    // Exist if the user can't edit users
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return;
    }


    // Nonce verification
    if (! isset( $_POST[ '_wpnonce' ] ) || ! wp_verify_nonce( $_POST[ '_wpnonce' ], 'update-user_' . $user_id ) ) {
        return;
    }

    // Sanitize and save the checkbox value
    update_user_meta( $user_id, 'is_recovery_email', sanitize_text_field( $_POST['is_recovery_email'] ) );
    
}

 

// Set email address for recovery mode emails
add_filter( 'recovery_mode_email', 'set_recovery_mode_email_address', 10, 2 );
function set_recovery_mode_email_address( $email, $url ) {
    

    // Get the admin useres
    $users = get_users( array( 'role' => 'administrator' ) );
    $recovery_email_addresses = array();

    foreach ( $users as $user ) {

        $is_recovery_email = get_user_meta( $user->ID, 'is_recovery_email', true );

        // If the user is set to recieve emails and the value is an email address, add to array
        if ( $is_recovery_email && filter_var( $user->user_email, FILTER_VALIDATE_EMAIL ) ) {
            $recovery_email_addresses[] = $user->user_email;
        }
    }

    // Add the recovery emails to the list of addresses
    if ( ! empty( $recovery_email_addresses ) ) {
        $additional_email_addresses = implode( ',', $recovery_email_addresses );
        $email .= ',' . $additional_email_addresses;
    }

    return $email;

}