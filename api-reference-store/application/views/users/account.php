<?php
// load the header file 
// $this->load->view('header');
?>
<div class="register-wrapper">
  <div class="container">
    <h1 class="page-heading">User Account</h1>
  </div>
  <div class="container white-bg">
    <div class="content-wrapper">
        <h2 class="section-heading">User Information</h2>
        <a class="pull-right" href="/users/logout">Logout</a>
        <div class="sec-divider"></div>
        <?php
        if(!empty($success_msg)){
          echo '<div class="alert alert-success" role="alert">'.$success_msg.'</div>';
        }elseif(!empty($error_msg)){
          echo '<div class="alert alert-danger" role="alert">'.$error_msg.'</div>';
        }
        ?>
        <div class="form-wrapper">
          <form action="" method="post">
            <div class="row">
                <div class="col-md-3 d-none d-sm-none d-md-block d-lg-block">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-12">
                        <p>To make changes, edit the form fields to the right and click "save" at the bottom of the page.</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-6 col-12">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="">First Name*</label>
                        <input type="text" class="form-control" name="firstName" placeholder="First Name" required="" value="<?php echo !empty($user['firstName'])?$user['firstName']:''; ?>">
                    <?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
                      </div>
                      <div class="col-md-6">
                        <label for="">Last Name*</label>
                        <input type="text" class="form-control" name="lastName" placeholder="Last Name" required="" value="<?php echo !empty($user['lastName'])?$user['lastName']:''; ?>">
                      <?php echo form_error('lastname','<span class="help-block">','</span>'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">Email*</label>
                        <p>For multiple email addresses, separate with a comma.</p>
                        <textarea type="email" class="form-control" name="email" placeholder="Email" required="" ><?php echo !empty($user['email'])?$user['email']:''; ?></textarea>
                    <?php echo form_error('email','<span class="help-block">','</span>'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">EHR ID*</label>
                        <input type="text" class="form-control" name="physicianId" placeholder="111-222-333-444" required="" value="<?php echo !empty($user['physicianId'])?$user['physicianId']:''; ?>">
                      <?php echo form_error('physicianid','<span class="help-block">','</span>'); ?>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="form-group">
                    <label for="">Password*</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" required="">
                    <?php echo form_error('password','<span class="help-block">','</span>'); ?>
                  </div>
                  <div class="form-group">
                    <label for="">Confirm Password*</label>
                    <input type="password" class="form-control" name="conf_password" placeholder="Confirm password" required="">
                    <?php echo form_error('conf_password','<span class="help-block">','</span>'); ?>
                  </div> -->
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="">Phone Number*</label>
                        <input type="text" class="form-control" name="phone" placeholder="Phone" value="<?php echo !empty($user['phone'])?$user['phone']:''; ?>">
                        <?php echo form_error('phone','<span class="help-block">','</span>'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="">Address 1*</label>
                        <input type="text" class="form-control" name="address1" placeholder="Address Line 1" required="" value="<?php echo !empty($user['address1'])?$user['address1']:''; ?>">
                        <?php echo form_error('address','<span class="help-block">','</span>'); ?>
                      </div>
                      <div class="col-md-6">
                        <label for="">Address 2</label>
                        <input type="text" class="form-control" name="address2" placeholder="Address Line 2" value="<?php echo !empty($user['address2'])?$user['address2']:''; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="">Zip Code*</label>
                        <input type="text" class="form-control" name="zip" placeholder="Zip/Postal Code" required="" value="<?php echo !empty($user['zip'])?$user['zip']:''; ?>">
                        <?php echo form_error('zip','<span class="help-block">','</span>'); ?>
                      </div>
                      <div class="col-md-6">
                        <label for="">State*</label>
                        <select name="state" id="">
                          <option value="">Select State</option>
                          <?php foreach ($stateCodes as $key => $state):?>
                            <option value="<?php echo $key;?>"><?php echo $state; ?></option>
                          <?php endforeach; ?>
                        </select>
                        <?php echo form_error('state','<span class="help-block">','</span>'); ?>
                      </div>
                    </div>
                  </div> 
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="">City</label>
                        <input type="text" class="form-control" name="city" placeholder="City" required="" value="<?php echo !empty($user['city'])?$user['city']:''; ?>">
                        <?php echo form_error('city','<span class="help-block">','</span>'); ?>
                      </div>
                      <div class="col-md-6">
                        <label for="">Country*</label>
                        <select name="" id="">
                          <option value="">Select Country</option>
                          <option value="US" selected>US</option>
                        </select>
                          <?php echo form_error('country','<span class="help-block">','</span>'); ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <h2 class="section-heading">Payment Information</h2>
              <div class="sec-divider"></div>
              <div class="row">
                <div class="col-md-3 d-none d-sm-none d-md-block d-lg-block">
                  <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                          <p>To make changes, edit the form fields to the right and click "save" at the bottom of the page.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-12">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label class="cards-label" for="">We accept:</label>
                          <ul class="payment-cards">
                            <li><img src="<?php echo base_url(); ?>assets/images/card1.jpg" alt=""></li>
                            <li><img src="<?php echo base_url(); ?>assets/images/card2.png" alt=""></li>
                            <li><img src="<?php echo base_url(); ?>assets/images/card3.png" alt=""></li>
                            <li><img src="<?php echo base_url(); ?>assets/images/card4.png" alt=""></li>
                            <li><img src="<?php echo base_url(); ?>assets/images/master.png" alt=""></li>
                            <li><img src="<?php echo base_url(); ?>assets/images/visa.png" alt=""></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <label for="">Cardholder's Full Name*</label>
                          <input type="text" class="form-control" name="cardName" placeholder="John Doe" required="" value="<?php echo !empty($user['cardName'])?$user['cardName']:''; ?>">
                        <?php echo form_error('cardName','<span class="help-block">','</span>'); ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <label for="">Card Number*</label>
                          <input type="text" class="form-control" name="cardNumber" placeholder="" required="" value="<?php echo !empty($user['cardNumber'])?$user['cardNumber']:''; ?>">
                          <img class="card-img" src="<?php echo base_url(); ?>assets/images/visa.png" alt="">
                        <?php echo form_error('cardNumber','<span class="help-block">','</span>'); ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-6">
                          <label for="">Exp. Date*</label>
                          <select name="" id="" class="exp-date">

                          </select>
                          <select name="" id="" class="exp-year">

                          </select>
                        </div>
                        <div class="col-6">
                          <label for="">CVC*</label>
                          <input type="text" class="form-control" name="cardCvc" placeholder="" required="" value="<?php echo !empty($user['cardCvc'])?$user['cardCvc']:''; ?>">
                        <?php echo form_error('cardCvc','<span class="help-block">','</span>'); ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <label for="cardBilling">My billing address is different from the address above.</label>
                          <input id="cardBilling" type="checkbox" name="cardBilling" >
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                      <div class="col-12">
                          <input type="submit" name="regisSubmit" class="btn btn-success" value="Save"/>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
          </form>
        </div>      
    </div>     
  </div>
</div>
<?php 
  // $this->load->view('footer');