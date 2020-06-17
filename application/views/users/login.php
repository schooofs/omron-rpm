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
                <a class="forgot-password" href="<?php echo base_url(); ?>users/reset">Forgot your password or email?</a>
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
<?php 
    // $this->load->view('footer');