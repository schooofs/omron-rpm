<?php
// load the header file 
// $this->load->view('header');
?>
<div class="login-wrapper">
  <div class="container ">
      <div class="row">
        <div class="col-md-7 login-content">
          <img src="<?php echo base_url(); ?>assets/images/vital-sight-logo.png" alt="vital-sight-logo">
          <h2 class="section-title">Welcome to VitalSight &#8482;
</h2>
        <div class="form-wrapper">
          <p class="footInfo">Don't have an account? <a href="<?php echo base_url(); ?>users/registration">Register for one now</a></p>
          <?php
          if(!empty($success_msg)){
            echo '<div class="alert alert-success" role="alert">'.$success_msg.'</div>';
          }elseif(!empty($error_msg)){
            echo '<div class="alert alert-danger" role="alert">'.$error_msg.'</div>';
          }
          ?>
          <form action="" method="post">
              <div class="form-group has-feedback">
                <label for="">Email</label>
                <input type="email" class="form-control" name="email" placeholder="example@mail.com" required="" value="<?php echo !empty($user_login)?$user_login:''; ?>">
                  <?php echo form_error('email','<span class="help-block">','</span>'); ?>
              </div>
              <div class="form-group">
                <label for="">Password</label>
                <input type="password" class="form-control" name="password" placeholder="" required="">
                <?php echo form_error('password','<span class="help-block">','</span>'); ?>
                <a class="forgot-password" data-toggle="modal" data-target="#resetPassword" href="<?php echo base_url(); ?>users/reset">Forgot your password or email?</a>
              </div>
              <div class="form-group">
                  <input type="submit" name="loginSubmit" class="btn btn-success" value="Login"/>
              </div>
          </form>
        </div>
      </div>
        <div class="col-md-5">
          
        </div>
      </div>
      
  </div>
</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="resetPassword" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModal" aria-hidden="true" <?php echo !empty($reset_pass_modal_msg) ? 'data-trigger="true"': ''; ?>>
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Password Reset</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-wrapper">
        <?php
          if(!empty($reset_pass_modal_msg)){
            echo '<div class="alert alert-danger" role="alert">'.$reset_pass_modal_msg.'</div>';
          } ?>
          <form action="<?php echo base_url();?>users/resetPassword" method="post">
            <div class="form-group has-feedback">
              <label for="">Email</label>
              <input type="email" class="form-control" name="email" placeholder="example@mail.com" required="" value="<?php echo !empty($user_login)?$user_login:''; ?>">
                <?php echo form_error('email','<span class="help-block">','</span>'); ?>
            </div>
            <div class="form-group">
              <input type="submit" name="passwordReset" class="btn btn-success" value="Submit"/>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if($reset_pass): ?>
  <!-- Reset Password Modal -->
  <div class="modal fade" id="resetPasswordSubmit" tabindex="-1" role="dialog" aria-labelledby="resetPasswordSubmitModal" aria-hidden="true" <?php echo !empty($reset_pass) ? 'data-trigger="true"': ''; ?>>
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Password Reset</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-wrapper">
            <form action="<?php echo base_url();?>users/resetPassword" method="post">
              <div class="form-group">
                <label for="">New Password*</label>
                <input type="password" class="form-control" name="new_password" placeholder="Password" required="">
                <?php echo form_error('new_password','<span class="help-block">','</span>'); ?>
              </div>
              <div class="form-group">
                <label for="">Confirm New Password*</label>
                <input type="password" class="form-control" name="conf_new_password" placeholder="Confirm password" required="">
                <?php echo form_error('conf_new_password','<span class="help-block">','</span>'); ?>
              </div>
              <div class="form-group">
                <input type="submit" name="passSubmit" class="btn btn-success" value="Submit"/>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php 
    // $this->load->view('footer');