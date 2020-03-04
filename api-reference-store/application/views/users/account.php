<!DOCTYPE html>
<html lang="en">  
<head>
<link href="<?php echo base_url(); ?>assets/css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2 class="alert alert-info">User Account</h2>
    
    <h3>Welcome <?php echo $firstName . ' ' . $lastName; ?>!</h3>
    <div class="account-info">
      
    </div>

    <a href="/users/logout">Logout</a>
    <form action="" method="post">
      <div class="form-group">
        <input type="submit" name="logoutSubmit" class="btn btn-success pull-right" value="Submit"/>
      </div>
    </form>
</div>
</body>
</html>