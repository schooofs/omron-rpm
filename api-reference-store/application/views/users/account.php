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
        <?php
        if(!empty($success_msg)){
          echo '<div class="alert alert-success" role="alert">'.$success_msg.'</div>';
        }elseif(!empty($error_msg)){
          echo '<div class="alert alert-danger" role="alert">'.$error_msg.'</div>';
        }
        ?>

        <h2 class="section-heading">User Information</h2>
        <a class="pull-right" href="/users/logout">Logout</a>
        <div class="sec-divider"></div>
        <div class="form-wrapper">
          <form action="" method="post" id="accountForm">
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
                      <div class="col-12">
                        <label for="">Company Name*</label>
                        <input type="text" class="form-control" name="companyName" placeholder="Company Name" required="" value="<?php echo !empty($companyName)?$companyName:''; ?>">
                      <?php echo form_error('companyName','<span class="help-block">','</span>'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="">First Name*</label>
                        <input type="text" class="form-control" name="firstName" placeholder="First Name" required="" value="<?php echo !empty($firstName)?$firstName:''; ?>">
                    <?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
                      </div>
                      <div class="col-md-6">
                        <label for="">Last Name*</label>
                        <input type="text" class="form-control" name="lastName" placeholder="Last Name" required="" value="<?php echo !empty($lastName)?$lastName:''; ?>">
                      <?php echo form_error('lastname','<span class="help-block">','</span>'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">Email*</label>
                        <p>For multiple email addresses, separate with a comma.</p>
                        <textarea type="email" class="form-control" name="email" placeholder="Email" required="" ><?php echo !empty($emailAddress)?$emailAddress:''; ?></textarea>
                    <?php echo form_error('email','<span class="help-block">','</span>'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">EHR ID*</label>
                        <input type="text" class="form-control" name="physicianId" placeholder="111-222-333-444" required="" value="<?php echo !empty($physicianId)?$physicianId:''; ?>">
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
                        <input type="text" class="form-control" name="phone" placeholder="Phone" value="<?php echo !empty($phone)?$phone:''; ?>">
                        <?php echo form_error('phone','<span class="help-block">','</span>'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="">Address 1*</label>
                        <input type="text" class="form-control" name="address1" placeholder="Address Line 1" required="" value="<?php echo !empty($address1)?$address1:''; ?>">
                        <?php echo form_error('address1','<span class="help-block">','</span>'); ?>
                      </div>
                      <div class="col-md-6">
                        <label for="">Address 2</label>
                        <input type="text" class="form-control" name="address2" placeholder="Address Line 2" value="<?php echo !empty($address2)?$address2:''; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="">Zip Code*</label>
                        <input type="text" class="form-control" name="zip" placeholder="Zip/Postal Code" required="" value="<?php echo !empty($zip)?$zip:''; ?>">
                        <?php echo form_error('zip','<span class="help-block">','</span>'); ?>
                      </div>
                      <div class="col-md-6">
                        <label for="">State*</label>
                        <select name="state" id="">
                          <option value="">Select State</option>
                          <?php foreach ($stateCodes as $key => $_state):?>
                            <option value="<?php echo $key; ?>" <?php echo (!empty($state) && $state==$key) ? 'selected' : ''; ?> ><?php echo $_state; ?></option>
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
                        <input type="text" class="form-control" name="city" placeholder="City" required="" value="<?php echo !empty($city)?$city:''; ?>">
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
                    <!-- <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <label for="">Cardholder's Full Name*</label>
                          <input type="text" class="form-control" name="cardName" placeholder="John Doe" required="" value="<?php echo !empty($cardName)?$cardName:''; ?>">
                        <?php echo form_error('cardName','<span class="help-block">','</span>'); ?>
                        </div>
                      </div>
                    </div> -->
                    <!-- <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <label for="">Card Number*</label>
                          <input type="text" class="form-control" name="cardNumber" placeholder="" required="" value="<?php echo !empty($cardNumber)?$cardNumber:''; ?>">
                          <img class="card-img" src="<?php echo base_url(); ?>assets/images/visa.png" alt="">
                        <?php echo form_error('cardNumber','<span class="help-block">','</span>'); ?>
                        </div>
                      </div>
                    </div> -->
                    <!-- <div class="form-group card-info">
                      <div class="row">
                        <div class="col-6">
                          <label for="">Exp. Date*</label>
                          <select name="cartExpDate" id="" class="exp-date">
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                          </select>
                          <span>/</span>
                          <select name="cardExpYear" id="" class="exp-year">
                            <option value="20">2020</option>
                            <option value="21">2021</option>
                            <option value="22">2022</option>
                            <option value="23">2023</option>
                            <option value="24">2024</option>
                            <option value="25">2025</option>
                            <option value="26">2026</option>
                          </select>
                          <?php echo form_error('cardDates','<span class="help-block">','</span>'); ?>
                        </div>
                        <div class="col-6">
                          <label for="">CVC*</label>
                          <input type="text" class="form-control" name="cardCvc" placeholder="" required="" value="<?php echo !empty($cardCvc)?$cardCvc:''; ?>">
                        <?php echo form_error('cardCvc','<span class="help-block">','</span>'); ?>
                        </div>
                      </div>
                    </div> -->
                    <div class="form-group"  id="user_payment_option">
                      <div class="row">
                        <div class="col-12">
                          <label for="paymentOption" class="label-txt">Saved Payment Option:</span></label>
                          <select class="selectBox" name="paymentOption" id="paymentOption">
                            <option value="create_new" selected>Create New</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group" id="user_payment_name">
                      <div class="row">
                        <div class="col-12">
                          <label for="paymentOptionName" class="label-txt">Payment Name*</span></label>
                          <input type="text" class="selectBox" name="paymentOptionName" id="paymentOptionName" required>
                          <?php echo form_error('paymentOptionName','<span class="help-block">','</span>'); ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="card-number" class="label-txt">Credit Card Number*</span></label>
                        <div id="card-number"></div>
                        <input type="text" class="selectBox" style="display:none;" 
                                id="cardLastDigit" readonly="true" />
                        <span id="cardNumberError" class="error"></span>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-6">
                          <label for="">Exp. Date*</label>
                          <div id="card-expiration"></div>
                          <input type="text" class="selectBox" style="display:none;" 
                                id="cardExpire" readonly="true" />
                          <span id="cardExpirationError" class="error"></span>
                        </div>
                        <div class="col-6">
                          <label for="">CVC*</label>
                          <div id="card-cvv"></div>
                          <input type="text" class="selectBox" name="cardCvv" id="cardCvv" style="display:none;" />
                          <span id="cardSecurityError" class="error"></span>
                        </div>
                      </div>
                    </div>
                    <!-- <div class="form-group">
                        <label for="card-expiration" class="label-txt">Credit Card Expiration*</span></label>
                        <div id="card-expiration"></div>
                          <input type="text" class="selectBox" style="display:none;" 
                                id="cardExpire" readonly="true" />
                        <span id="cardExpirationError" class="error"></span>
                    </div>
                    <div class="form-group" id="card_cvv_wrap">
                        <label for="card-cvv" class="label-txt">Credit Card CVV*</span></label>
                        <div id="card-cvv"></div>
                          <input type="text" class="selectBox" name="cardCvv" id="cardCvv"  />
                        <span id="cardSecurityError" class="error"></span>
                    </div> -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <label for="cardBilling" class="pl-2">My billing address is different from the address above.</label>
                          <input id="cardBilling" type="checkbox" name="cardBilling" >
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <p>As the person creating this account, you represent and warrant that you have the authority to provide the information required and to create the account. If you do not have the appropriate authority and/or cannot provide the required information, please exit this form now. If you have the appropriate authority and can provide the required information, please click on the check box below and click on the "I agree" button.</p>
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <label for="agreeAcc" class="pl-2">Yes, I have the appropriate authority to create this account and certify that the answers provided are true and accurate. I agree to comply with all terms in my Company’s agreements with VitalSight. I understand that failure to comply with all of the terms in these agreements will result in suspension or termination of my account.</label>
                          <input id="agreeAcc" type="checkbox" name="agreeAcc" value="yes" required>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <label for="agreeTerms" class="pl-2">By creating this account, I agree to the Terms of Sale and the Privacy Policy of DR globalTech Inc. You expressly authorize and permit Digital River to store your payment information and automatically bill your payment method on file on a monthly basis based on usage. You will be provided with an order confirmation email each month. You can discontinue participation in this program at any time by contacting OMRON Healthcare, Inc.</label>
                          <input id="agreeTerms" type="checkbox" name="agreeTerms" value="yes" required>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <input type="submit" name="accountSubmit" class="btn btn-success" value="Save"/>
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