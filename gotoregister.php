<?php
/**
* Plugin Name: GoToRegisterWP
* Version: 0.2.0
* Description: This plugin generates a registration form for a specified Webinar.
* Author: Nathan Simpson
* Author URI: http://www.nathansimpson.design
*/


if ( ! defined( 'ABSPATH' ) ) exit;

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
		$header = array(
			'Content-type' => 'application/json',
			'Accept' => 'application/vnd.citrix.g2wapi-v1.1+json',
			'Authorization:' => $token,
		);

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



require('includes/settings.php');
require('includes/tinymce.php');
add_shortcode('gotoregister', 'generateFormFunc');
?>
