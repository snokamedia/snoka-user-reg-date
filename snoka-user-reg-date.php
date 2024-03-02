<?php
/**
 * Plugin Name: User Registration Date Display
 * Plugin URI: http://snoka.ca
 * Description: Adds user registration date information to user profiles for admins.
 * Version: 1.0
 * Author: Snoka Media
 * Author URI: http://snoka.ca
 */

// Register actions to display registration date in user profiles for admins
add_action('show_user_profile', 'display_user_registration_date');
add_action('edit_user_profile', 'display_user_registration_date');

/**
 * Displays the user registration date in the user profile for admins.
 *
 * @param WP_User $user The user object.
 */
function display_user_registration_date($user) {
    // Exit if the current user does not have administrator privileges
    if (!current_user_can('manage_options')) {
        return;
    }

    // Section title for user registration information
    $section_title = __("User Registration Information", "user-registration-date-display");

    // Label for the registration date and time
    $date_label = __("Registration Date and Time", "user-registration-date-display");

    // Format and escape the user's registration date and time
    $registration_date = esc_html(date("F j, Y, g:i a", strtotime($user->user_registered)));

    // Output the custom user meta section
    echo <<<HTML
    <h3>{$section_title}</h3>
    <table class="form-table">
        <tr>
            <th><label for="registration-date">{$date_label}</label></th>
            <td>{$registration_date}</td>
        </tr>
    </table>
HTML;
}
?>
