<!DOCTYPE html>
<html lang="en">  
<head>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel='stylesheet' type='text/css' />
  <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2 class="alert alert-info">User Registration</h2>
    <?php
    if(!empty($success_msg)){
      echo '<div class="alert alert-success" role="alert">'.$success_msg.'</div>';
    }elseif(!empty($error_msg)){
      echo '<div class="alert alert-danger" role="alert">'.$error_msg.'</div>';
    }
    ?>
    <form action="" method="post">
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" name="firstName" placeholder="First Name" required="" value="<?php echo !empty($user['firstName'])?$user['firstName']:''; ?>">
          <?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control" name="lastName" placeholder="Last Name" required="" value="<?php echo !empty($user['lastName'])?$user['lastName']:''; ?>">
            <?php echo form_error('lastname','<span class="help-block">','</span>'); ?>
            </div>
          </div>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email" required="" value="<?php echo !empty($user['email'])?$user['email']:''; ?>">
          <?php echo form_error('email','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Password" required="">
          <?php echo form_error('password','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="conf_password" placeholder="Confirm password" required="">
          <?php echo form_error('conf_password','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" name="address1" placeholder="Address Line 1" required="" value="<?php echo !empty($user['address1'])?$user['address1']:''; ?>">
              <?php echo form_error('address','<span class="help-block">','</span>'); ?>
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control" name="phone" placeholder="Phone" value="<?php echo !empty($user['phone'])?$user['phone']:''; ?>">
              <?php echo form_error('phone','<span class="help-block">','</span>'); ?>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
            <input type="text" class="form-control" name="address2" placeholder="Address Line 2" value="<?php echo !empty($user['address2'])?$user['address2']:''; ?>">
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control" name="zip" placeholder="Zip/Postal Code" required="" value="<?php echo !empty($user['zip'])?$user['zip']:''; ?>">
              <?php echo form_error('zip','<span class="help-block">','</span>'); ?>
            </div>
          </div>
        </div> 
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" class="form-control" name="city" placeholder="City" required="" value="<?php echo !empty($user['city'])?$user['city']:''; ?>">
            <?php echo form_error('city','<span class="help-block">','</span>'); ?>
              </div>
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control" name="country" placeholder="Country" value="<?php echo !empty($user['country'])?$user['country']:''; ?>">
              <?php echo form_error('country','<span class="help-block">','</span>'); ?>
            </div>
          </div>
        </div>
        
        <div class="form-group">
            <input type="submit" name="regisSubmit" class="btn btn-success" value="Submit"/>
        </div>
    </form>
    <p class="footInfo">Already have an account? <a href="<?php echo base_url(); ?>users/login">Login here</a></p>              
</div>
</body>
</html>
