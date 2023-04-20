<?php
/*
Plugin Name: Htaccess Editor
Description: This plugin is ONLY to edit an existing .htaccess file
Version: 1.0
Author: Aldo Curatolo
*/

// Create a new page in the WordPress admin area
function htaccess_editor_page() {
    add_menu_page( 'Htaccess Editor', 'Htaccess Editor', 'manage_options', 'htaccess-editor', 'htaccess_editor_display' );
}

// Display the page content
function htaccess_editor_display() {

    // Check if the user is authorized to view the page
    if ( !current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }

    // Check if the form has been submitted
    if ( isset( $_POST['htaccess_content'] ) ) {

        // Get the content of the .htaccess file
        $htaccess_content = $_POST['htaccess_content'];

        // Write the content to the .htaccess file
        $htaccess_file = ABSPATH . '.htaccess';
        file_put_contents( $htaccess_file, $htaccess_content );

        // Display a success message
        echo '<div class="updated"><p>The .htaccess file has been updated.</p></div>';

    }

    // Get the content of the .htaccess file
    $htaccess_file = ABSPATH . '.htaccess';
    
    if ( file_exists($htaccess_file) ) {
        $htaccess_content = file_get_contents( $htaccess_file );

        // Create the form to edit the .htaccess file
        echo '<div class="wrap">';
        echo '<h2>Htaccess Editor</h2>';
        echo '<form method="post">';
        echo '<textarea name="htaccess_content" rows="20" cols="100">' . esc_textarea( $htaccess_content ) . '</textarea>';
        echo '<p><input type="submit" class="button-primary" value="Save Changes"></p>';
        echo '</form>';
        echo '</div>';
    } else {
        echo '<div class="wrap">';
        echo '<div class="notice notice-error settings-error"><b>HTACCESS file not found</b></div>';
        echo '</div>';
    }
}

// Add the menu page to the admin area
add_action( 'admin_menu', 'htaccess_editor_page' );