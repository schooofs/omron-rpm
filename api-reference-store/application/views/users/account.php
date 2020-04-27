<?php
// load the header file 
// $this->load->view('header');
?>
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
<?php 
// $this->load->view('footer');