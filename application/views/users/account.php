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
        <!-- USER INFO SECTION -->
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
                          <label for="">City</label>
                          <input type="text" class="form-control" name="city" placeholder="City" required="" value="<?php echo !empty($city)?$city:''; ?>">
                          <?php echo form_error('city','<span class="help-block">','</span>'); ?>
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
                        <label for="">Zip Code*</label>
                        <input type="text" class="form-control" name="zip" placeholder="Zip/Postal Code" required="" value="<?php echo !empty($zip)?$zip:''; ?>">
                        <?php echo form_error('zip','<span class="help-block">','</span>'); ?>
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
              
              <!-- PAYMENT SECTION -->
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

                    <?php if(isset($paymentOption[0]['id']) && 0 !== $paymentOption[0]['id']): ?>
                      <div class="form-group">
                      <label class="cards-label" for="">Payment Options</label>
                        <div class="row">
                          <div class="col-12">
                            <table class="table table-hover payment-options">
                              <thead>
                              <tr>
                                <th scope="col"></th>
                                <th scope="col">Name</th>
                                <th scope="col">Number</th>
                                <th scope="col">Type</th>
                                <th scope="col"></th>
                              </tr>
                              </thead>
                              <tbody>
                                <?php foreach($paymentOption as $key => $payment) :?>
                                  <tr data-payment-id="<?php echo $payment['id']; ?>" class="<?php echo 'true' == $payment['isDefault'] ? 'default-payment' : ''; ?>">
                                    <th scope="row"><?php echo 'true' == $payment['isDefault'] ? 'Default' : ''; ?></th>
                                    <td><?php echo $payment['nickName']; ?></td>
                                    <td>**** <?php echo $payment['creditCard']['lastFourDigits']; ?></td>
                                    <td><?php echo $payment['creditCard']['brand']; ?></td>
                                    <td>
                                      <?php if('true' != $payment['isDefault']) :?>
                                        <a href="<?php echo base_url(); ?>users/deletePayment?id=<?php echo $payment['id']; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i>
</a>
                                      <?php endif; ?>
                                    </td>
                                  </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                            <div class="table-overlay"></div>
                            <div class="">
                              <a href="#" class="payment-option-add-new pull-right">+ Add New</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endif; ?>
                    <div id="payment-option" style="<?php echo (isset($paymentOption[0]['id']) && 0 !== $paymentOption[0]['id']) ? 'display: none;' : ''; ?>" >
                      <div class="form-group" id="user_payment_name">
                        <div class="row">
                          <div class="col-12">
                            <label for="paymentOptionName" class="label-txt">Payment Name*</span></label>
                            <input type="text" class="form-control" name="paymentOptionName" id="paymentOptionName" <?php echo (isset($paymentOption[0]['id']) && 0 !== $paymentOption[0]['id']) ? '' : 'required'; ?>">
                            <?php echo form_error('paymentOptionName','<span class="help-block">','</span>'); ?>
                          </div>
                        </div>
                      </div>
                        <div class="form-group">
                          <label for="card-number" class="label-txt">Credit Card Number*</span></label>
                          <div id="card-number"></div>
                          <div class="invalid-feedback" id="card-number-error"></div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-6">
                              <label for="">Exp. Date*</label>
                              <div id="card-expiration"></div>
                              <div class="invalid-feedback" id="card-expiration-error"></div>
                            </div>
                          <div class="col-6">
                            <label for="">CVC*</label>
                            <div id="card-cvv"></div>
                            <div class="invalid-feedback" id="card-cvv-error"></div>
                          </div>
                        </div>
                      </div>
                      <input type="hidden" name="paymentSourceId" value="0">
                    </div>
                    <!-- <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <label for="cardBilling" class="pl-2">My billing address is different from the address above.</label>
                          <input id="cardBilling" type="checkbox" name="cardBilling" >
                        </div>
                      </div>
                    </div> -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <p>As the person creating this account, you represent and warrant that you have the authority to provide the information required and to create the account. If you do not have the appropriate authority and/or cannot provide the required information, please exit this form now. If you have the appropriate authority and can provide the required information, please click on the check box below.</p>
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <label for="agreeAcc" class="pl-2">* Yes, I have the appropriate authority to create this account and certify that the answers provided are true and accurate. I agree to comply with all terms in my Company’s agreements with VitalSight. I understand that failure to comply with all of the terms in these agreements will result in suspension or termination of my account.</label>
                          <input id="agreeAcc" type="checkbox" name="agreeAcc" value="yes" <?php echo (!empty($agreeTerms) && $agreeAcc == 'yes') ? 'checked': ''; ?> required>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <label for="agreeTerms" class="pl-2">* By creating this account, I agree to the Terms of Sale and the Privacy Policy of DR globalTech Inc. You expressly authorize and permit Digital River to store your payment information and automatically bill your payment method on file on a monthly basis based on usage. You will be provided with an order confirmation email each month. You can discontinue participation in this program at any time by contacting OMRON Healthcare, Inc.</label>
                          <input id="agreeTerms" type="checkbox" name="agreeTerms" value="yes" <?php echo (!empty($agreeTerms) && $agreeTerms == 'yes') ? 'checked': ''; ?> required>
                        </div>
                      </div>
                    </div>

                    <input type="hidden" name="accountForm" value="1">

                    <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <input type="submit" name="accountSub" class="btn btn-success" value="Save"/>
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
<script>
  var updatePaymentUrl = "<?php echo base_url(); ?>users/updatePayment";
</script>