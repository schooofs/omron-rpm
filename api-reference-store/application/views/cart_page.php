<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// load the header file 
$this->load->view('header', $header);
$subtotal = $active_cart['cart']['pricing']['formattedSubtotal'];
$shipping_charges = $active_cart['cart']['pricing']['formattedShippingAndHandling'];
if ( isset($user_login) ) {
    //echo 'user is logged in';
}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/cart.css">
<div class="container" id="cartCheckout">
    <section id="title">
        <article>
            <div class="row" style="padding-bottom: 14px;">
                <div class="col-sm-12 col-md-12">
                    <h3>DR Shopping Cart</h3>
                </div>
            </div>
        </article>
    </section>
    <div id="empty_cart"><h3> Cart is empty. Please add products to cart</h3></div>
    <?php 
        if ( !isset($active_cart['cart']['lineItems']['lineItem'])) {
            echo '<h1> Cart is empty. Please add products to cart';
            die();
        }
     ?>
    <section id="prod_section" class="cart_details">
        <form name="shopping_cart" action="">
            <input type="hidden" name="edit_cart" id="edit_cart" value="0">
            <!-- Mobile product details -->
            <div class="visible">
                <?php foreach ( $active_cart['cart']['lineItems']['lineItem'] as $lineItem ) {
                    $product_quantity = $lineItem['quantity'];
                    $lineitem_id = $lineItem['id'];
                    $product_array = $lineItem['product'];
                    $product_name = $product_array ['displayName'];
                    $product_image = $product_array ['thumbnailImage'];
                    $lineitem_price = $lineItem['pricing']['formattedSalePriceWithQuantity'];
                ?>
                    <div class="card">
                        <div class="card-header"></div>
                        <div class="row" id="<?php echo $lineitem_id.'_wrap_mob';?>">
                            <div class="col-4">
                                <img src="<?php echo $product_image; ?>" alt="">
                            </div>
                            <div class="col-8 cart_products">
                                <div class="row">
                                    <div class="col-4 label-txt"  style="padding-right: 2px;">Product Name:</div>
                                    <div class="col-8 label-txt product-name"><?php echo $product_name; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-4 label-txt">Quantity:</div>
                                    <div class="col-8 label-txt">
                                        <input type="number" value="<?php echo $product_quantity;?>" 
                                         style="padding-left: 2px; width:40px; border: 1px solid #343a40bf;" onKeyPress="if(this.value.length==8) return false;" min="1" id="<?php echo $lineitem_id.'_qty_mob';?>" >
                                        <span class="update">
                                            <a href="javascript:void(0)" 
                                                onclick="update_lineitem('<?php echo $lineitem_id;?>',
                                                '<?php echo $product_id;?>', '<?php echo $lineitem_id.'_qty_mob';?>')">
                                                 Update
                                            </a>
                                        </span>
                                        <span>
                                            <a href="javascript:void(0)" onclick="remove_lineitem('<?php echo $lineitem_id;?>')">
                                                Remove
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 label-txt">Price:</div>
                                    <div class="col-8 label-txt" id='<?php echo $lineitem_id.'_price_mob';?>'>
                                        <?php echo $lineitem_price; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- Desktop product details -->
            <div class="visible-m">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">Product Name</div>
                            <div class="col-md-1"></div>
                            <div class="col-md-3">Quantity</div>
                            <div class="col-md-1"></div>
                            <div class="col-md-3">Price</div>
                        </div>
                    </div>
                </div>
                <?php foreach ( $active_cart['cart']['lineItems']['lineItem'] as $lineItem ) {
                    $product_quantity = $lineItem['quantity'];
                    $lineitem_id = $lineItem['id'];
                    $product_array = $lineItem['product'];
                    $product_name = $product_array ['displayName'];
                    $product_image = $product_array ['thumbnailImage'];
                    $lineitem_price = $lineItem['pricing']['formattedSalePriceWithQuantity'];
                ?>
                    <div class="row quantRow" id="<?php echo $lineitem_id.'_wrap';?>">
                        <div class="col-md-4 prod_image">
                            <span><img src="<?php echo $product_image; ?>" alt="<?php echo $product_name; ?>"> </span>
                            <span class="drTxt"><?php echo $product_name; ?></span>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                            <input type="number" value="<?php echo $product_quantity;?>" 
                                style="width:40px; border: 1px solid #343a40bf;" onKeyPress="if(this.value.length==8) return false;" min="1" id="<?php echo $lineitem_id.'_qty';?>" >
                            <span>
                                <a href="javascript:void(0)" 
                                    onclick="update_lineitem('<?php echo $lineitem_id;?>',
                                        '<?php echo $product_id;?>', '<?php echo $lineitem_id.'_qty';?>')">
                                     Update
                                </a> 
                            </span> &nbsp;
                            <span>
                                <a href="javascript:void(0)" onclick="remove_lineitem('<?php echo $lineitem_id;?>')">
                                    Remove
                                </a>
                            </span>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-3 numTotal" id='<?php echo $lineitem_id.'_price';?>'>
                            <?php echo $lineitem_price; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header est-b est-font">Estimated Shipping</div>
                    </div>
                </div>
            </div>
            <div class="row shipMethod">
                <div class="col-md-4">
                <label class="col-form-label label-txt">Shipping Method</label>
                 <select class="col-4 form-control">
                        <option>Standard</option>
                 </select>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-3"></div>
                <div class="col-md-1"></div>
                <div class="col-md-3 numTotal" id="cartShippingCharges"><?php echo $shipping_charges;?></div>
            </div>
            <div class="card">
                <div class="card-header est-b">
                     <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-1"></div>
                         <div class="col-md-3 subTotal">SubTotal</div>
                         <div class="col-md-1"></div>
                         <div class="col-md-3 label-txt" id='cartSubtotal'><?php echo $subtotal;?></div>
                     </div>
                </div>
            </div>
        </form>
    </section>
    <section id="loginInfo" class="cart_details">
        <form name="user_login">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Account Login Information</h4>
                        </div>
                        <span class="accountTxt">Please enter your email address and password,click on login button</span>
                        <div class="form-row  btnGrp">
                            <div class="col-md-4">
                                <label class="sr-only" for="inlineFormInput">Email Address</label>
                                <input type="text" class="form-control mb-2" id="user_email" name="user_email" placeholder="Email Address" required>
                            </div>
                            <div class="col-md-4">
                                <label class="sr-only" for="inlineFormInputGroup">Password</label>
                                <div class="input-group mb-2">
                                    <input type="password" class="form-control" id="user_pass" name="user_pass" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" id="userLogin" class="btn btn-info mb-2 mgl"><i class="fa fa-lock lock-icon" aria-hidden="true"></i>LOGIN</button>
                                <label data-toggle="modal" data-target="#forgotPass" class="fp">Forgot Password?</label>
                            </div>
                        </div>
                     </div>
                  </div>
            </div>
        </form>
        <form id="createAccount">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>New Customers</h4>
                        </div>
                        <span class="accountTxt">Create an account for faster checkout and convenient access to your order history</span>
                        <div class="form-row align-items-center btnGrp">
                            <form>
                               <button type="button" class="btn btn-info" onclick="createAccount('new_user');"><i class="fa fa-lock lock-icon" aria-hidden="true"></i>CREATE ACCOUNT</button>
                                <input type="hidden" name="checkoutType" value="CREATE_ACCOUNT">
                            </form>
                                   <span class="OR">OR</span>
                            <form>
                                <button type="button" class="btn btn-info" onclick="createAccount('guest');"><i class="fa fa-lock lock-icon" aria-hidden="true"></i>CHECKOUT AS GUEST</button>
                                <input type="hidden" name="checkoutType" value="CHECKOUT_AS_GUEST">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal" id="forgotPass">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Forgot Password?</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form name="forgot_pass" action="">
                            <div class="forgotText">Your password will be emailed to you to the email address that you supplied when you placed your order</div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Please Enter Email Address</label>
                                <input type="email" class="form-control" name="forgotemail" id="forgotemail" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Please Verify Your Email Address</label>
                                <input type="email" class="form-control"  name="verifyForgotemail" id="verifyForgotemail" required>
                            </div>
                            <button class="btn btn-info" id="forgot_pass_btn">SUBMIT</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <div id="billing_info" style="display: none;">
        <section>
            <article>
                <form name="billing_payment" action="">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card" style="border: none">
                                <div class="card-header bg-light text-dark label-txt"><h5>Billing Information</h5></div>
                                <div class="card-body card-m">
                                    <div class="row" id="user_address_option">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                            <label for="addressBook" class="col-sm-5 col-form-label label-txt">Address Book:<span class="asterisk">*</span></label>
                                            <div class="col-sm-7">
                                                <select class="selectBox" name="address_book" id="address_book"></select>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="user_add_book_name">
                                            <div class="form-group row">
                                            <label for="addressBookName" class="col-sm-5 col-form-label label-txt">Address Book Name:<span class="asterisk">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="inputControl" name="address_book_name" id="address_book_name"/>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                            <label for="firstName" class="col-sm-5 col-form-label label-txt">First Name<span class="asterisk">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="inputControl" name="firstName" id="firstName">
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                            <label class="col-sm-5 col-form-label label-txt">Last Name<span class="asterisk">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="inputControl" name="lastName" id="lastName" required>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label label-txt">Address Line 1<span class="asterisk">*</span></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="inputControl" name="address1" id="address1" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label label-txt">Address Line 2</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="inputControl" name="address2" id="address2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label label-txt">City<span class="asterisk">*</span></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="inputControl" name="city" id="city" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label label-txt">Zip/Postal Code<span class="asterisk">*</span></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="inputControl" name="zip" id="zip" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label label-txt">Country <span class="asterisk">*</span></label>
                                                <div class="col-sm-7">
                                                    <select class="selectBox" name="country" id="country" required>
                                                         <option value="">Select</option>
                                                         <option value="usa">USA</option>
                                                         <option value="uk">UK</option>
                                                         <option value="india">India</option>
                                                    </select>
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id ="email_option">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label label-txt">Email Address<span class="asterisk">*</span></label>
                                                <div class="col-sm-7">
                                                    <input type="email" class="inputControl" name="email" id="email" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label label-txt">Verify Email Address<span class="asterisk">*</span></label>
                                                <div class="col-sm-7">
                                                    <input type="email" class="inputControl" name="verifyEmail" id="verifyEmail" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row" id="billing_pass">
                                                <label class="col-sm-5 col-form-label label-txt">Password<span class="asterisk">*</span></label>
                                                <div class="col-sm-7">
                                                    <input type="password" class="inputControl" name="password" id="password" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row" id="billing_confirm_pass">
                                                <label class="col-sm-5 col-form-label label-txt">Verify Password<span class="asterisk">*</span></label>
                                                <div class="col-sm-7">
                                                    <input type="password" class="inputControl" name="verifyPassword" id="verifyPassword" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label label-txt">Phone Number<span class="asterisk">*</span></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="inputControl" name="phoneNum" id="phoneNum" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                    <div class="col-md-4">
                        <form id="payment-form">
                            <div class="card">
                                <div class="card-header bg-light text-dark label-txt payment_info"><h5>Payment Information</h5></div>
                                <div class="card-body card-m">
                                    <div class="form-group"  id="user_payment_option">
                                        <label for="paymentOption" class="label-txt">Saved Payment Option:<span class="asterisk">*</span></label>
                                        <select class="selectBox" name="paymentOption" id="paymentOption"></select>
                                    </div>
                                    <div class="form-group" id="user_payment_name">
                                        <label for="paymentOptionName" class="label-txt">Payment Name:<span class="asterisk">*</span></label>
                                        <input type="text" class="selectBox" name="paymentOptionName" id="paymentOptionName" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="card-number" class="label-txt">Credit Card<span class="asterisk">*</span></label>
                                        <div id="card-number"></div>
                                        <input type="text" class="selectBox" style="display:none;" 
                                               id="cardLastDigit" readonly="true" />
                                        <span id="cardNumberError" class="error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="card-expiration" class="label-txt">Credit Card Expiration<span class="asterisk">*</span></label>
                                        <div id="card-expiration"></div>
                                         <input type="text" class="selectBox" style="display:none;" 
                                               id="cardExpire" readonly="true" />
                                        <span id="cardExpirationError" class="error"></span>
                                    </div>
                                    <div class="form-group" id="card_cvv_wrap">
                                        <label for="card-cvv" class="label-txt">Credit Card CVV<span class="asterisk">*</span></label>
                                        <div id="card-cvv"></div>
                                         <!-- <input type="text" class="selectBox" name="cardCvv" id="cardCvv"  /> -->
                                        <span id="cardSecurityError" class="error"></span>
                                    </div>  
                                </div>
                            </div>
                        </form>
                        <button type="submit" class="checkout-btn">CHECKOUT</button>
                    </div>
                    </div>
                </form>
            </article>
        </section>
    </div>
</div>
<div id="cartReviewOrder"></div>
<!-- Load footer section -->
<?php $this->load->view('footer', $header); ?>
<script src="<?php echo base_url(); ?>assets/js/cart.js"></script>
<script type="text/javascript">
    var userCheckoutOption = 'guest';
    var submit_form = 0;
    var sourceId = 0;
    var cardDetails = '';
    var formRequestData = '';
    var access_token = '<?php echo $access_token; ?>';
    var dr_session_token = '<?php echo $dr_session_token; ?>';
    var oAuthToken = '';
    var updateLineItemUrl = '<?php echo site_url('cart/updateLineItem/');?>';
    var removeLineItemUri = '<?php echo site_url('cart/removeLineItem/');?>';
    var updateBillingDetailsUri = '<?php echo site_url('cart/updateBillingDetails/');?>';
    var updatePaymentMethodsUri = '<?php echo site_url('cart/updatePaymentDetails/');?>';
    var submitCartUri = '<?php echo site_url('cart/submitCart/');?>';
    var successRedirectUrl = '<?php echo site_url('review/reviewOrder/');?>';
    var thankYouUrl = '<?php echo site_url('order/thankYou/');?>';
    var createShopperUrl = '<?php echo site_url('shoppers/createShopper/');?>';
    var shopperLoginUrl = '<?php echo site_url('shoppers/login/');?>';
    var updateShoppersDetailsUrl = '<?php echo site_url('shoppers/updateDetails/');?>';
    var shoppersAddress = {};
    var shoppersPayments = {};
</script>