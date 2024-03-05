<?php
/**
 * Plugin Name: User Registration Date Display
 * Plugin URI: http://snoka.ca
 * Description: Adds user registration date information to user profiles for admins.
 * Version: 1.0
 * Author: Snoka Media
 * Author URI: http://snoka.ca
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Hook to 'show_user_profile' & 'edit_user_profile' to add custom user meta
add_action('show_user_profile', 'urdd_display_registration_date');
add_action('edit_user_profile', 'urdd_display_registration_date');

/**
 * Displays the registration date on user profiles for administrators.
 *
 * @param WP_User $user User object for the current profile.
 */
function urdd_display_registration_date($user) {
    // Check if the current user has the 'administrator' role.
    if (!current_user_can('manage_options')) {
        return;
    }

    // Use the site's date and time format settings or default to WordPress format if not set.
    $date_format = get_option('date_format') ?: 'F j, Y';
    $time_format = get_option('time_format') ?: 'g:i a';
    // Combine the date and time formats.
    $format = $date_format . ', ' . $time_format;
    // Format and escape the user's registration date and time according to site settings.
    $registration_date = esc_html(date_i18n($format, strtotime($user->user_registered)));

    ?>
    <h3><?php _e("User Registration Information", "user-registration-date-display"); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="registration-date"><?php _e("Registration Date and Time", "user-registration-date-display"); ?></label></th>
            <td>
                <?php 
                // Display the formatted and escaped registration date and time
                echo $registration_date; 
                ?>
            </td>
        </tr>
    </table>
    <?php
}