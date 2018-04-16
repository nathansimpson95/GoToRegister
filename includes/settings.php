<?php

function GoToRegister_settings_init() {
  // register settings
  register_setting( 'GoToRegister', 'GoToRegister_username' );
  register_setting( 'GoToRegister', 'GoToRegister_password' );
  register_setting( 'GoToRegister', 'GoToRegister_apiClientId' );
  register_setting( 'GoToRegister', 'GoToRegister_organiserKey' );
  register_setting( 'GoToRegister', 'GoToRegister_disclaimer', array('default' => 'Bootstrap'));
  register_setting( 'GoToRegister', 'GoToRegister_theme', array('default' => 'Bootstrap'));
  register_setting( 'GoToRegister', 'GoToRegister_title', array('default' => '<h2>Register for this Webinar</h2>'));

  // register sections in the "GoToRegister" settings page
  add_settings_section(
  'GoToRegister_section_credentials',
  __( 'GoToWebinar Credentials.', 'GoToRegister' ),
  'GoToRegister_section_credentials_cb',
  'GoToRegister'
  );

  add_settings_section(
  'GoToRegister_section_styles',
  __( 'Style Settings.', 'GoToRegister' ),
  'GoToRegister_section_styles_cb',
  'GoToRegister'
  );

  // register a new field in the "GoToRegister_section_credentials" section, inside the "GoToRegister" page
  add_settings_field(
  'GoToRegister_username',
  __( 'GoToWebinar Username', 'GoToRegister' ),
  'GoToRegister_field_username_cb',
  'GoToRegister',
  'GoToRegister_section_credentials',
  [
  'label_for' => 'GoToRegister_username',
  'class' => 'GoToRegister_row',
  'GoToRegister_custom_data' => 'custom',
  ]
  );

  add_settings_field(
  'GoToRegister_password',
  __( 'GoToWebinar Password', 'GoToRegister' ),
  'GoToRegister_field_password_cb',
  'GoToRegister',
  'GoToRegister_section_credentials',
  [
  'label_for' => 'GoToRegister_password',
  'class' => 'GoToRegister_row',
  'GoToRegister_custom_data' => 'custom',
  ]
  );

  add_settings_field(
  'GoToRegister_apiClientId',
  __( 'GoToWebinar API Client ID', 'GoToRegister' ),
  'GoToRegister_field_apiClientId_cb',
  'GoToRegister',
  'GoToRegister_section_credentials',
  [
  'label_for' => 'GoToRegister_apiClientId',
  'class' => 'GoToRegister_row',
  'GoToRegister_custom_data' => 'custom',
  ]
  );

  add_settings_field(
  'GoToRegister_organiserKey',
  __( 'Default Organiser Key', 'GoToRegister' ),
  'GoToRegister_field_organiserKey_cb',
  'GoToRegister',
  'GoToRegister_section_credentials',
  [
  'label_for' => 'GoToRegister_organiserKey',
  'class' => 'GoToRegister_row',
  'GoToRegister_custom_data' => 'custom',
  ]
  );

  add_settings_field(
  'GoToRegister_disclaimer',
  __( 'Form Disclaimer', 'GoToRegister' ),
  'GoToRegister_field_disclaimer_cb',
  'GoToRegister',
  'GoToRegister_section_styles',
  [
  'label_for' => 'GoToRegister_disclaimer',
  'class' => 'GoToRegister_row',
  'GoToRegister_custom_data' => 'custom',
  ]
  );

  add_settings_field(
  'GoToRegister_theme',
  __( 'Form CSS Theme', 'GoToRegister' ),
  'GoToRegister_field_theme_cb',
  'GoToRegister',
  'GoToRegister_section_styles',
  [
  'label_for' => 'GoToRegister_theme',
  'class' => 'GoToRegister_row',
  'GoToRegister_custom_data' => 'custom',
  ]
  );
}

add_action( 'admin_init', 'GoToRegister_settings_init' );

function GoToRegister_section_credentials_cb( $args ) {
 ?><p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Please enter your credentials for GoToWebinar.', 'GoToRegister' ); ?></p><?php
}

function GoToRegister_section_styles_cb( $args ) {
 ?><p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Define your styles.', 'GoToRegister' ); ?></p><?php
}

function GoToRegister_field_username_cb( $args ) {
 $option = get_option( 'GoToRegister_username' );
 ?>
 <input
   type="text"
   id="<?php echo esc_attr( $args['label_for'] ); ?>"
   name="<?php echo esc_attr( $args['label_for'] ); ?>"
   data-custom="<?php echo esc_attr( $args['GoToRegister_custom_data'] ); ?>"
   value="<?php echo $option; ?>"
 />
 <p class="description"><?php esc_html_e( 'Your username for GoToWebinar.', 'GoToRegister' ); ?></p>
 <?php
}

function GoToRegister_field_password_cb( $args ) {
 $option = get_option( 'GoToRegister_password' );
 ?>
 <input
   type="password"
   id="<?php echo esc_attr( $args['label_for'] ); ?>"
   name="<?php echo esc_attr( $args['label_for'] ); ?>"
   data-custom="<?php echo esc_attr( $args['GoToRegister_custom_data'] ); ?>"
   value="<?php echo $option; ?>"
 />
 <p class="description"><?php esc_html_e( 'Your password for GoToWebinar.', 'GoToRegister' ); ?></p>
 <?php
}

function GoToRegister_field_apiClientId_cb( $args ) {
 $option = get_option( 'GoToRegister_apiClientId' );
 ?>
 <input
   type="text"
   id="<?php echo esc_attr( $args['label_for'] ); ?>"
   name="<?php echo esc_attr( $args['label_for'] ); ?>"
   data-custom="<?php echo esc_attr( $args['GoToRegister_custom_data'] ); ?>"
   value="<?php echo $option; ?>"
 />
 <p class="description"><?php esc_html_e( 'Your GoToWebinar API Client ID.', 'GoToRegister' ); ?></p>
 <?php
}

function GoToRegister_field_organiserKey_cb( $args ) {
 $option = get_option( 'GoToRegister_organiserKey' );
 ?>
 <input
   type="text"
   id="<?php echo esc_attr( $args['label_for'] ); ?>"
   name="<?php echo esc_attr( $args['label_for'] ); ?>"
   data-custom="<?php echo esc_attr( $args['GoToRegister_custom_data'] ); ?>"
   value="<?php echo $option; ?>"
 />
 <p class="description"><?php esc_html_e( 'Your Default GoToWebinar Organiser ID.', 'GoToRegister' ); ?></p>
 <?php
}

function GoToRegister_field_disclaimer_cb( $args ) {
 $option = get_option( 'GoToRegister_disclaimer' );
 ?>
 <input
   type="text"
   id="<?php echo esc_attr( $args['label_for'] ); ?>"
   name="<?php echo esc_attr( $args['label_for'] ); ?>"
   data-custom="<?php echo esc_attr( $args['GoToRegister_custom_data'] ); ?>"
   value="<?php echo $option; ?>"
 />
 <p class="description"><?php esc_html_e( 'Your message to be shown below the form.', 'GoToRegister' ); ?></p>
 <?php
}

function GoToRegister_field_theme_cb( $args ) {
 $option = get_option( 'GoToRegister_theme' );
 ?>
 <select id="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['GoToRegister_custom_data'] ); ?>"
 name="<?php echo esc_attr( $args['label_for'] ); ?>"
 >
  <option value="Bootstrap" <?php echo isset( $option[ $args['label_for'] ] ) ? ( selected( $option[ $args['label_for'] ], 'Bootstrap', false ) ) : ( '' ); ?> >
    <?php esc_html_e( 'Bootstrap', 'GoToRegister' ); ?>
  </option>
  <option value="blue" <?php echo isset( $option[ $args['label_for'] ] ) ? ( selected( $option[ $args['label_for'] ], 'blue', false ) ) : ( '' ); ?> >
    <?php esc_html_e( 'blue pill', 'GoToRegister' ); ?>
  </option>
 </select>
 <p class="description"><?php esc_html_e( 'Choose the CSS Theme to be applied to the form', 'GoToRegister' ); ?></p>
 <?php
}

// add page to Wordpress Admin > Settings
function GoToRegister_options_page() {
 add_options_page(
 'GoToRegister',
 'GoToRegister',
 'manage_options',
 'GoToRegister',
 'GoToRegister_options_page_html'
 );
}

add_action( 'admin_menu', 'GoToRegister_options_page' );


//Output Settings Page Content
function GoToRegister_options_page_html() {
 if ( ! current_user_can( 'manage_options' ) ) {
   return;
 }

 // check if the user have submitted the settings. Wordpress will add the "settings-updated" $_GET parameter to the url
 if ( isset( $_GET['settings-updated'] ) ) {
   add_settings_error( 'GoToRegister_messages', 'GoToRegister_message', __( 'Your GoToRegister settings have been saved', 'GoToRegister' ), 'updated' );
 }

 // show error/update messages
 settings_errors( 'GoToRegister_messages' );
 ?>
 <div class="wrap">
   <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
   <form action="options.php" method="post">
     <?php
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
