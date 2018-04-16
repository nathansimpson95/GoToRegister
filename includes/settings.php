<?php

function GoToRegister_settings_init() {
 // register a new setting for "GoToRegister" page
 register_setting( 'GoToRegister', 'GoToRegister_username' );
 register_setting( 'GoToRegister', 'GoToRegister_password' );
 register_setting( 'GoToRegister', 'GoToRegister_apiClientId' );
 register_setting( 'GoToRegister', 'GoToRegister_organiserKey' );
 register_setting( 'GoToRegister', 'GoToRegister_disclaimer' );

 // register a new section in the "GoToRegister" page
 add_settings_section(
 'GoToRegister_section_developers',
 __( 'Your GoToWebinar Credentials.', 'GoToRegister' ),
 'GoToRegister_section_developers_cb',
 'GoToRegister'
 );

 // register a new field in the "GoToRegister_section_developers" section, inside the "GoToRegister" page
 add_settings_field(
 'GoToRegister_username', // as of WP 4.6 this value is used only internally
 __( 'GoToWebinar Username', 'GoToRegister' ),
 'GoToRegister_field_username_cb',
 'GoToRegister',
 'GoToRegister_section_developers',
 [
 'label_for' => 'GoToRegister_username',
 'class' => 'GoToRegister_row',
 'GoToRegister_custom_data' => 'custom',
 ]
 );

 add_settings_field(
 'GoToRegister_password', // as of WP 4.6 this value is used only internally
 __( 'GoToWebinar Password', 'GoToRegister' ),
 'GoToRegister_field_password_cb',
 'GoToRegister',
 'GoToRegister_section_developers',
 [
 'label_for' => 'GoToRegister_password',
 'class' => 'GoToRegister_row',
 'GoToRegister_custom_data' => 'custom',
 ]
 );

 add_settings_field(
 'GoToRegister_apiClientId', // as of WP 4.6 this value is used only internally
 __( 'GoToWebinar API Client ID', 'GoToRegister' ),
 'GoToRegister_field_apiClientId_cb',
 'GoToRegister',
 'GoToRegister_section_developers',
 [
 'label_for' => 'GoToRegister_apiClientId',
 'class' => 'GoToRegister_row',
 'GoToRegister_custom_data' => 'custom',
 ]
 );

 add_settings_field(
 'GoToRegister_organiserKey', // as of WP 4.6 this value is used only internally
 __( 'Default Organiser Key', 'GoToRegister' ),
 'GoToRegister_field_organiserKey_cb',
 'GoToRegister',
 'GoToRegister_section_developers',
 [
 'label_for' => 'GoToRegister_organiserKey',
 'class' => 'GoToRegister_row',
 'GoToRegister_custom_data' => 'custom',
 ]
 );

 add_settings_field(
 'GoToRegister_disclaimer', // as of WP 4.6 this value is used only internally
 __( 'GoToWebinar Disclaimer', 'GoToRegister' ),
 'GoToRegister_field_disclaimer_cb',
 'GoToRegister',
 'GoToRegister_section_developers',
 [
 'label_for' => 'GoToRegister_disclaimer',
 'class' => 'GoToRegister_row',
 'GoToRegister_custom_data' => 'custom',
 ]
 );
}

/**
 * register our GoToRegister_settings_init to the admin_init action hook
 */
add_action( 'admin_init', 'GoToRegister_settings_init' );

/**
 * custom option and settings:
 * callback functions
 */

// developers section cb

// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function GoToRegister_section_developers_cb( $args ) {
 ?>
 <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'GoToRegister' ); ?></p>
 <?php
}

// pill field cb

// field callbacks can accept an $args parameter, which is an array.
// $args is defined at the add_settings_field() function.
// wordpress has magic interaction with the following keys: label_for, class.
// the "label_for" key value is used for the "for" attribute of the <label>.
// the "class" key value is used for the "class" attribute of the <tr> containing the field.
// you can add custom key value pairs to be used inside your callbacks.

function GoToRegister_field_username_cb( $args ) {
 // get the value of the setting we've registered with register_setting()
 $option = get_option( 'GoToRegister_username' );
 // output the field
 ?>
 <input
 type="text"
 id="<?php echo esc_attr( $args['label_for'] ); ?>"
 name="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['GoToRegister_custom_data'] ); ?>"
 value="<?php echo $option; ?>"
 />
 <p class="description">
 <?php esc_html_e( 'Your username for GoToWebinar.', 'GoToRegister' ); ?>
 </p>
 <?php
}

function GoToRegister_field_password_cb( $args ) {
 // get the value of the setting we've registered with register_setting()
 $option = get_option( 'GoToRegister_password' );
 // output the field
 ?>
 <input
 type="password"
 id="<?php echo esc_attr( $args['label_for'] ); ?>"
 name="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['GoToRegister_custom_data'] ); ?>"
 value="<?php echo $option; ?>"
 />
 <p class="description">
 <?php esc_html_e( 'Your password for GoToWebinar.', 'GoToRegister' ); ?>
 </p>
 <?php
}

function GoToRegister_field_apiClientId_cb( $args ) {
 // get the value of the setting we've registered with register_setting()
 $option = get_option( 'GoToRegister_apiClientId' );
 // output the field
 ?>
 <input
 type="text"
 id="<?php echo esc_attr( $args['label_for'] ); ?>"
 name="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['GoToRegister_custom_data'] ); ?>"
 value="<?php echo $option; ?>"
 />
 <p class="description">
 <?php esc_html_e( 'Your GoToWebinar API Client ID.', 'GoToRegister' ); ?>
 </p>
 <?php
}

function GoToRegister_field_organiserKey_cb( $args ) {
 // get the value of the setting we've registered with register_setting()
 $option = get_option( 'GoToRegister_organiserKey' );
 // output the field
 ?>
 <input
 type="text"
 id="<?php echo esc_attr( $args['label_for'] ); ?>"
 name="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['GoToRegister_custom_data'] ); ?>"
 value="<?php echo $option; ?>"
 />
 <p class="description">
 <?php esc_html_e( 'Your Default GoToWebinar Organiser ID.', 'GoToRegister' ); ?>
 </p>
 <?php
}

function GoToRegister_field_disclaimer_cb( $args ) {
 // get the value of the setting we've registered with register_setting()
 $option = get_option( 'GoToRegister_disclaimer' );
 // output the field
 ?>
 <input
 type="text"
 id="<?php echo esc_attr( $args['label_for'] ); ?>"
 name="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['GoToRegister_custom_data'] ); ?>"
 value="<?php echo $option; ?>"
 />
 <p class="description">
 <?php esc_html_e( 'Your message to be shown below the form.', 'GoToRegister' ); ?>
 </p>
 <?php
}

/**
 * top level menu
 */
function GoToRegister_options_page() {
 // add top level menu page
 add_menu_page(
 'GoToRegister',
 'GoToRegister Options',
 'manage_options',
 'GoToRegister',
 'GoToRegister_options_page_html'
 );
}

/**
 * register our GoToRegister_options_page to the admin_menu action hook
 */
add_action( 'admin_menu', 'GoToRegister_options_page' );

/**
 * top level menu:
 * callback functions
 */
function GoToRegister_options_page_html() {
 // check user capabilities
 if ( ! current_user_can( 'manage_options' ) ) {
 return;
 }

 // add error/update messages

 // check if the user have submitted the settings
 // wordpress will add the "settings-updated" $_GET parameter to the url
 if ( isset( $_GET['settings-updated'] ) ) {
 // add settings saved message with the class of "updated"
 add_settings_error( 'GoToRegister_messages', 'GoToRegister_message', __( 'Settings Saved', 'GoToRegister' ), 'updated' );
 }

 // show error/update messages
 settings_errors( 'GoToRegister_messages' );
 ?>
 <div class="wrap">
 <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
 <form action="options.php" method="post">
 <?php
 // output security fields for the registered setting "GoToRegister"
 settings_fields( 'GoToRegister' );
 // output setting sections and their fields
 // (sections are registered for "GoToRegister", each field is registered to a specific section)
 do_settings_sections( 'GoToRegister' );
 // output save settings button
 submit_button( 'Save Settings' );
 ?>
 </form>
 </div>
 <?php
}
