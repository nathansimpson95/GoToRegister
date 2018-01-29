<?php
/**
* Plugin Name: GoToRegisterWP
* Plugin URI:
* Version: 0.1
* Description: This plugin generates a registration form for a specified Webinar.
* Author: Nathan Simpson
* Author URI: http://www.nathansimpson.design
* Text Domain: webinar_rego
* Domain Path:
*/

$token = "";
$username = get_option('gotousername');
$password = get_option('gotopassword');
$clientID = get_option('APIClientID');
$defaultOrganiserKey = get_option('defaultOrganiserKey');

//generates an access token for a gotowebinar api request
function generateToken(){
	global $username;
	global $password;
	global $clientID;
	global $token;
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.getgo.com/oauth/access_token",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "grant_type=password&user_id=".$username."&password=".$password."&client_id=".$clientID,
	  CURLOPT_HTTPHEADER => array(
	    "accept: application/json",
	    "cache-control: no-cache",
	    "content-type: application/x-www-form-urlencoded",
	    "postman-token: 9485b0bd-cd06-6c49-a72b-e0befdf6ab30"
	  ),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  $decodedjson = json_decode($response);
	  $token = $decodedjson->access_token;
	}
}


//the HTML markup of the form that will be displayed.
function outputForm(){
	echo '<h2>Register for this Webinar</h2>
	<form action="" method="POST" id="registration-form" class="webinar-signup">
		<div class="row">
			<input name="webinar_key" type="hidden" value="'.$a['webinar_key'].'" />
			<input name="organizer_key" type="hidden" value="'.$a['organiser_key'].'" />
			<div class="col-sm-4 form-group">
			    <label for="fname">First Name</label>
			    <input type="text" class="form-control" name="fname">
			</div>

			<div class="col-sm-4 form-group">
			    <label for="lname">Last Name</label>
			    <input type="text" class="form-control" name="lname">
			</div>

		    <div class="col-sm-4 form-group">
			    <label for="email">Email address</label>
			    <input type="email" class="form-control" name="email" placeholder="example@example.com">
			</div>
		</div>
	  <small id="emailHelp" class="form-text text-muted">' . get_option('gotodisclaimer') . '</small>

	  <input type="submit" class="btn btn-primary" value="Register For Event" name="registration-submission" />
	</form>';
}


// generates a form using shortcodes and displays it on the page.
function generateFormFunc($atts){

	$a = shortcode_atts(array(
		'webinar_key' => "123",
		'organiser_key' => "100000000001300988",
	), $atts, 'generateForm' );

	global $token;

	if (isset($_POST['registration-submission'])) {
		generateToken();

		$vals['body'] = (object) array('firstName' => $_POST['fname'],'lastName' => $_POST['lname'],'email' => $_POST['email']);

		$long_url = 'https://api.getgo.com/G2W/rest/organizers/'.$a['organiser_key'].'/webinars/'.$a['webinar_key'].'/registrants';
		$header = array();
    $header[] = 'Content-type: application/json';
    $header[] = 'Accept: application/vnd.citrix.g2wapi-v1.1+json';
    $header[] = 'Authorization:' . $token;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $long_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($vals['body']));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($ch);
		$decoded_response = json_decode($response);

		if ($decoded_response->status == 'APPROVED') {
			echo '<div class="alert alert-success" role="alert"><strong>Success!</strong> You have been registered for this webinar. Expect an email shortly!</div>';
			$register_result = true;
		} else {
			echo '<div class="alert alert-danger" role="alert"><strong>Whoops!</strong> Something has gone wrong. Please try registering <a href="https://register.gotowebinar.com/rt/'.$a['webinar_key'].'" target="_blank">here</a> instead.</div>';
			$register_result = false;
		}
	}

	ob_start();
	outputForm();
  $output = ob_get_clean();
  return $output;
}


function gtwwp_add_plugin_page(){
	add_plugins_page(
		'GoToWebinar Forms',        //page title
		'GoToWebinar Forms',        //menu title
		'manage_options',           //user capability
		'gtwwp_menu',               //menu slug
		'gtwwp_options_display'     //callable function
	);
}

//add settings page to WP navigation
function gtwwp_init_options(){

	add_settings_section(
			'gotowebinarformssettings',         // ID used to identify this section and with which to register options
			'GoToWebinar Forms',                  // Title to be displayed on the administration page
			'sandbox_general_options_callback', // Callback used to render the description of the section
			'general'                           // Page on which to add this section of options
	);

	//add_settings_field(fieldID, label,callbackfunction,target page, target section,array of arguments)
	add_settings_field('gotousername','GoToWebinar Username','goto_username_callback','general','gotowebinarformssettings',array('Your username for GoToWebinar'));
	add_settings_field('gotopassword','GoToWebinar Password','goto_password_callback','general','gotowebinarformssettings',array('Your password for GoToWebinar'));
	add_settings_field('APIClientID','GoToWebinar API Client ID','goto_apikey_callback','general','gotowebinarformssettings',array('Your GoToWebinar application api client id'));
  add_settings_field('defaultOrganiserKey','Default Webinar Organiser Key','goto_default_organiser_callback','general','gotowebinarformssettings',array('The key for your default GoToWebinar organiser'));
	add_settings_field('gotodisclaimer','Disclaimer that appears under form','goto_disclaimer_callback','general','gotowebinarformssettings',array('Disclaimer that appears under form'));

	register_setting( 'general', 'gotousername' );
	register_setting( 'general', 'gotopassword' );
	register_setting( 'general', 'APIClientID' );
	register_setting( 'general', 'defaultOrganiserKey' );
	register_setting( 'general', 'gotodisclaimer' );
}

function sandbox_general_options_callback() {
    echo '<p>Please enter your credentials below.</p>';
} // end sandbox_general_options_callback

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

add_action('admin_init', 'gtwwp_init_options');
add_action('admin_menu', 'gtwwp_add_plugin_page', 11 );

require('tinymce.php');
add_shortcode('generateForm', 'generateFormFunc');
?>
