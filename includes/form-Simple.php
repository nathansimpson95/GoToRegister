<?php
$formHTML = '<form action="" method="POST" id="registration-form" class="webinar-signup">
  <input name="webinar_key" type="hidden" value="'.$a['webinar_key'].'" />
  <input name="organizer_key" type="hidden" value="'.$a['organiser_key'].'" />
  <label for="fname">First Name</label>
  <input type="text" class="GoToRegister_Input" name="fname">
  <label for="lname">Last Name</label>
  <input type="text" class="GoToRegister_Input" name="lname">
  <label for="email">Email address</label>
  <input type="email" class="GoToRegister_Input" name="email" placeholder="example@example.com">
  <small class="form-text text-muted">' . get_option( 'GoToRegister_disclaimer' ) . '</small>
  <input type="submit" class="GoToRegister_Button" value="Register For Webinar" name="registration-submission" />
</form>';
?>
