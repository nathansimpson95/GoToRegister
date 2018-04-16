<?php

  function GoToRegister_settings_init(){
    //register settings for "GoToRegister" plugin
    register_setting( 'GoToRegister', 'gotousername' );
  	register_setting( 'GoToRegister', 'gotopassword' );
  	register_setting( 'GoToRegister', 'APIClientID' );
  	register_setting( 'GoToRegister', 'defaultOrganiserKey' );
  	register_setting( 'GoToRegister', 'gotodisclaimer' );

    //register a section in the "GoToRegister" settings page
    add_settings_section(
  			'GoToRegisterSettingsSection',         // ID used to identify this section and with which to register options
  			'GoToWebinar Forms',                  // Title to be displayed on the administration page
  			'GoToRegisterSettingsCallback', // Callback used to render the description of the section
  			'GoToRegister'                           // Page on which to add this section of options
  	);

    //register fields in the 'GoToRegisterSettingsSection' in the following syntax
  	//add_settings_field(fieldID, label,callbackfunction,target page, target section,array of arguments)
    add_settings_field('gotousername','GoToWebinar Username','goto_username_callback','GoToRegister','GoToRegisterSettingsSection',array('Your username for GoToWebinar'));
  	add_settings_field('gotopassword','GoToWebinar Password','goto_password_callback','GoToRegister','GoToRegisterSettingsSection',array('Your password for GoToWebinar'));
  	add_settings_field('APIClientID','GoToWebinar API Client ID','goto_apikey_callback','GoToRegister','GoToRegisterSettingsSection',array('Your GoToWebinar application api client id'));
    add_settings_field('defaultOrganiserKey','Default Webinar Organiser Key','goto_default_organiser_callback','GoToRegister','GoToRegisterSettingsSection',array('The key for your default GoToWebinar organiser'));
  	add_settings_field('gotodisclaimer','Disclaimer that appears under form','goto_disclaimer_callback','GoToRegister','GoToRegisterSettingsSection',array('Disclaimer that appears under form'));
  }

  add_action('admin_init', ' GoToRegister_settings_init');


   function GoToRegisterSettingsCallback() {
       echo '<p>Please enter your credentials below.</p>';
   } // end GoToRegisterSettingsCallback

   function gtwwp_options_display() {
   	$html = '<div class="wrap">';
   	$html .= '<h2>GoToWebinar Registration Forms</h2>';
   	$html .= '</div>';
   	echo $html;
   } // end gtwwp_options_display

   function goto_username_callback($args) {
   		$html = '<input type="text" name="gotousername" id="gotousername" value="' . get_option('gotousername') . '" />';
       // Here, we will take the first argument of the array and add it to a label next to the checkbox
       $html .= '<label for="gotousername"> '  . $args[0] . '</label>';
       echo $html;
   }

   function goto_password_callback($args) {
   		$html = '<input type="text" name="gotopassword" id="gotopassword" value="' . get_option('gotopassword') . '" />';
       // Here, we will take the first argument of the array and add it to a label next to the checkbox
       $html .= '<label for="gotopassword"> '  . $args[0] . '</label>';
       echo $html;
   }

   function goto_apikey_callback($args) {
   		$html = '<input type="text" name="APIClientID" id="APIClientID" value="' . get_option('APIClientID') . '" />';
       // Here, we will take the first argument of the array and add it to a label next to the checkbox
       $html .= '<label for="APIClientID"> '  . $args[0] . '</label>';
       echo $html;
   }

   function goto_default_organiser_callback($args) {
   		$html = '<input type="text" name="defaultOrganiserKey" id="defaultOrganiserKey" value="' . get_option('defaultOrganiserKey') . '" />';
       // Here, we will take the first argument of the array and add it to a label next to the checkbox
       $html .= '<label for="defaultOrganiserKey"> '  . $args[0] . '</label>';
       echo $html;
   }

   function goto_disclaimer_callback($args) {
   		$html = '<input type="text" name="gotodisclaimer" id="gotodisclaimer" value="' . get_option('gotodisclaimer') . '" />';
       // Here, we will take the first argument of the array and add it to a label next to the checkbox
       $html .= '<label for="gotodisclaimer"> '  . $args[0] . '</label>';
       echo $html;
   }


   function wporg_options_page() {
    // add top level menu page
    add_menu_page(
      'GoToRegister',           //page title
      'GoToRegister',           //menu title
      'manage_options',         //user capability
      'gtwwp_menu',             //menu slug
      'wporg_options_page_html' //callable function
    );
   }

      //add settings page
      function GoToRegister_options_page(){
        add_plugins_page(

          'gtwwp_options_display'
        );
      }


      add_action( 'admin_menu', 'GoToRegister_options_page' );




   function GoToRegister_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {return;}

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
