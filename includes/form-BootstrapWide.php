<?php
$formHTML = '<form action="" method="POST" id="registration-form" class="webinar-signup">
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
  <small class="form-text text-muted">' . get_option( 'GoToRegister_disclaimer' ) . '</small>

  <input type="submit" class="btn btn-primary" value="Register For Webinar" name="registration-submission" />
</form>';
?>
