<?php
$subtotal = $activeCart['cart']['pricing']['formattedSubtotal'];
$shippingCharges = $activeCart['cart']['pricing']['formattedShippingAndHandling'];
$shippingTax = $activeCart['cart']['pricing']['formattedTax'];
$orderTotal = $activeCart['cart']['pricing']['formattedOrderTotal'];

$firstName = $activeCart['cart']['billingAddress']['firstName'];
$lastName = $activeCart['cart']['billingAddress']['lastName'];
$companyName = $activeCart['cart']['billingAddress']['companyName'];
$line1 = $activeCart['cart']['billingAddress']['line1'];
$line2 = $activeCart['cart']['billingAddress']['line2'];
$city = $activeCart['cart']['billingAddress']['city'];
$countrySubdivision = $activeCart['cart']['billingAddress']['countrySubdivision'];
$postalCode = $activeCart['cart']['billingAddress']['postalCode'];
$country = $activeCart['cart']['billingAddress']['country'];
$phoneNumber = $activeCart['cart']['billingAddress']['phoneNumber'];
?>           
<div class="container">
    <section id="checkout-banner">
        <div class="row">
            <div class="col-md-3 checkout-banner-txt">CHECKOUT</div>
            <div class="col-md-3 gyColor"><span class="one">1</span><span class="bill">Billing</span><span class="info">Information</span></div>
            <div class="col-md-3 skyColor"><span class="one">2</span> <span class="verify">Verify</span> <span class="order">Order</span></div>
            <div class="col-md-3 gyColor"><span class="one">3</span> <span class="orderNew">Order</span> <span class="complete-order">Completed</span></div>
        </div>	  
    </section>
    <section id="shipping">
        <div class="card" style="margin-bottom: 7px;">
            <div class="card-body" style="padding: 10px;">
                <div class="row">
                    <div class="col-md-6">Shipping Method</div>
                    <div class="col-md-6">
                        <label class="label-txt">Shipping Method</label>
                        <select class="col-md-3 form-control">
                           <option selected>Standard</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row refNo">
        <div class="col-md-12" style="display:none;"><a href="#">Reference Number : 63713978200</a></div>
    </div>
    <div class="row">
        <div class="col-md-11"></div>
        <div class="col-md-1 edit"><a href="javascipt:void(0);" onClick="editCart();">EDIT</a></div>
    </div>
    <section id="checkout_info">
        <div class="visible">
            <?php foreach ( $activeCart['cart']['lineItems']['lineItem'] as $lineItem ) {
                $product_quantity = $lineItem['quantity'];
                $lineitem_id = $lineItem['id'];
                $product_array = $lineItem['product'];
                $product_name = $product_array ['displayName'];
                $product_image = $product_array ['thumbnailImage'];
                $lineitem_price = $lineItem['pricing']['formattedSalePriceWithQuantity'];
            ?>
            <div class="card">
                <div class="card-header"></div>
                <div class="row quant-sm">
                    <div class="col-5 label-txt">Quantity</div>
                    <div class="col-1">:</div>
                    <div class="col-5 fs"><?= $product_quantity ?></div>
                </div>
                <div class="row quant-sm">
                    <div class="col-5 label-txt">Product Name</div>
                    <div class="col-1">:</div>
                    <div class="col-5 fs"><?= $product_name ?></div>
                </div>
                <div class="row quant-sm">
                    <div class="col-5 label-txt">Delivery Method</div>
                    <div class="col-1">:</div>
                    <div class="col-5 fs">Boxed Shippment</div>
                </div>
                <div class="row quant-sm">
                    <div class="col-5 label-txt">Price</div>
                    <div class="col-1">:</div>
                    <div class="col-5 fs"><?= $subtotal ?></div>
                </div>
                <div class="row quant-sm">
                    <div class="col-5 label-txt">Shipping</div>
                    <div class="col-1">:</div>
                    <div class="col-5 fs"><?= $shippingCharges ?></div>
                </div>
                <div class="row quant-sm">
                    <div class="col-5 label-txt">Tax</div>
                    <div class="col-1">:</div>
                    <div class="col-5 fs"><?= $shippingTax ?></div>
                </div>
                <div class="row quant-sm">
                    <div class="col-5 label-txt">Total</div>
                    <div class="col-1">:</div>
                    <div class="col-5 fs"><?= $orderTotal ?></div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="visible-m">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2">Quantity</div>
                        <div class="col-md-4">Product Name</div>
                        <div class="col-md-3">Delivery Method</div>
                        <div class="col-md-1"></div>
                        <div class="col-md-2 price">Price</div>
                    </div>
                </div>
            </div>
            <?php foreach ( $activeCart['cart']['lineItems']['lineItem'] as $lineItem ) {
                $product_quantity = $lineItem['quantity'];
                $lineitem_id = $lineItem['id'];
                $product_array = $lineItem['product'];
                $product_name = $product_array ['displayName'];
                $product_image = $product_array ['thumbnailImage'];
                $lineitem_price = $lineItem['pricing']['formattedSalePriceWithQuantity'];
            ?>
            <div class="row quantity">
                <div class="col-md-2 quantNo"><?= $product_quantity ?></div>
                <div class="col-md-4"><?= $product_name ?></div>
                <div class="col-md-3">Boxed Shippment</div>
                <div class="col-md-2"></div>
                <div class="col-md-1 price-ipad"><?= $lineitem_price ?></div>
            </div>
            <?php } ?>
            <div class="row quantity">
                <div class="col-md-2"></div>
                <div class="col-md-4"></div>
                <div class="col-md-3"></div>
                <div class="col-md-1">Shipping</div>
                <div class="col-md-2 price-ipad"><?= $shippingCharges ?></div>
            </div>
            <div class="row quantity">
                <div class="col-md-2"></div>
                <div class="col-md-4"></div>
                <div class="col-md-3"></div>
                <div class="col-md-1">Tax</div>
                <div class="col-md-2 price-ipad"><?= $shippingTax ?></div>
            </div>
            <div class="row quantity">
                <div class="col-md-2"></div>
                <div class="col-md-4"></div>
                <div class="col-md-3"></div>
                <div class="col-md-1 label-txt">Total</div>
                <div class="col-md-2 label-txt price-ipad"><?= $orderTotal ?></div>
            </div>
        </div>
    </section>
    <section id="checkout_details">
        <div class="row">
            <div class="col-md-4 sm-m">
                <div class="card">
                    <div class="card-header text-dark checkoutCards">BILLING ADDRESS <span class="edit"><a href="javascipt:void(0);" onClick="editCart();">EDIT</a> </span></div>
                    <div class="card-body card-detail">
                        <div><?= $firstName.' '.$lastName ?></div>
                        <div><?= $companyName ?></div>
                        <div><?= $line1.' '.$line2 ?></div>
                        <div><?= $city.','.$countrySubdivision.' '.$postalCode ?></div>
                        <div><?= $country ?></div>
                        <div><?= $phoneNumber ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 sm-m">
                <div class="card">
                    <div class="card-header text-dark checkoutCards">SHIPPING ADDRESS <span class="edit"><a href="javascipt:void(0);" onClick="editCart();">EDIT</a> </span></div>
                    <div class="card-body card-detail">
                        <div><?= $firstName.' '.$lastName ?></div>
                        <div><?= $companyName ?></div>
                        <div><?= $line1.' '.$line2 ?></div>
                        <div><?= $city.','.$countrySubdivision.' '.$postalCode ?></div>
                        <div><?= $country ?></div>
                        <div><?= $phoneNumber ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 sm-m">
                <div class="card">
                    <div class="card-header text-dark checkoutCards">PAYMENT METHOD<span class="edit"><a href="javascipt:void(0);" onClick="editCart();">EDIT</a> </span></div>
                    <div class="card-body card-detail">
                        <div><?= $cardDetails['brand'] ?></div>
                        <div>Ending in <?= $cardDetails['lastFourDigits'] ?></div>
                        <div>Expiration Date :</div>
                        <div><?= $cardDetails['expirationMonth'] ?>/
                            <?= $cardDetails['expirationYear'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12 termsOfSale">
        <input type="checkbox" id="acceptTerms" class="check"><span class="terms">
                By submitting my order,I agree to the <b>Terms of Sale</b> and the 
                <b>Privacy Policy</b> of Digital River .Inc
        </span><br>
        <span class="error" id="acceptTermsError">
            Please agree to the Terms and Policy
        </span>
    </div>
    </div>
    <div class="row">
        <button class="order-btn" onclick="submitCart();">SUBMIT ORDER</button>
    </div>
    <div class="row">
      <div class="col-md-12 terms termsOfSale">By submitting my order you acknowledge to pay the total price as stated</div>
    </div>
    <div class="row">
        <div class="col-md-12 terms termsOfSale"><b>Digital River, Inc.</b> is the authorize reseller and merchant of the products and services offered within this store</div>
    </div>
    <div class="row privacyPolicy-p">
        <div class="privacyPolicy"><b><a href="#">Privacy Policy</a> </b>&nbsp;&nbsp;&nbsp;<b><a href="#">Terms of Sale</a></b></div>
    </div>
</div>