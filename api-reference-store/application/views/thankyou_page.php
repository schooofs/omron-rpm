<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$product_name = '';
foreach ( $orderDetails['order']['lineItems']['lineItem'] as $lineItem ) {
    $product_name .= $lineItem['product'] ['displayName'];
}
$orderDate = date('Y-m-d', strtotime($orderDetails['order']['submissionDate']));
$orderId = $orderDetails['order']['id'];
$orderTotal = $orderDetails['order']['pricing']['formattedTotal'];

$firstName = $orderDetails['order']['shippingAddress']['firstName'];
$lastName = $orderDetails['order']['shippingAddress']['lastName'];
$companyName = $orderDetails['order']['shippingAddress']['companyName'];
$line1 = $orderDetails['order']['shippingAddress']['line1'];
$line2 = $orderDetails['order']['shippingAddress']['line2'];
$city = $orderDetails['order']['shippingAddress']['city'];
$countrySubdivision = $orderDetails['order']['shippingAddress']['countrySubdivision'];
$postalCode = $orderDetails['order']['shippingAddress']['postalCode'];
$country = $orderDetails['order']['shippingAddress']['country'];
$phoneNumber = $orderDetails['order']['shippingAddress']['phoneNumber'];
// load the header file 
$this->load->view('header', $header);
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/cart.css">
<div id="container">
    <div class="container">
        <section id="checkout-banner">
            <div class="row">
                <div class="col-md-3 checkout-banner-txt">CHECKOUT</div>
                <div class="col-md-3 gyColor"><span class="one">1</span><span class="bill">Billing</span><span class="info">Information</span></div>
                <div class="col-md-3 gyColor"><span class="one">2</span> <span class="verify">Verify</span> <span class="order">Order</span></div>
                <div class="col-md-3 skyColor"><span class="one">3</span> <span class="orderNew">Order</span> <span class="complete-order">Completed</span></div>
            </div>	  
        </section>
        <div class="row">
            <div class="col-md-12 order-p">
                <b>If you have problem with your order or have any additional quetions or comments</b> , Please refer to the order confirmation email or contact <a href="#">Customer Service</a>  for assistance.
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 thankYou">
                <h5>Thank You again for your order !</h5>
            </div>
        </div>
        <section id="orderDetail">
            <div class="card">
                <div class="card-header">
                    <h5>Your Order Details</h5>
                </div>
                <div class="card-body">
                    <div><?= $product_name ?></div>
                    <div>Boxed Shipment</div>
                </div>
                <div class="card-footer">
                    <div>Order Date:  <b><?= $orderDate; ?></b> </div>
                    <div>Order No.:   <b><?= $orderId; ?></b></div>
                    <div>Order Total:   <b><?= $orderTotal; ?></b> </div>
                    <p></p>
                    <div>Change will happen to your credit card as *DRI*drdod19.</div>
                    <div class="shipAddress">when we have finished processing of your order,You will be sent a confirmation email at the address provided.</div>
                    <h6>Shipping Address</h6>
                    <div><?= $firstName.' '.$lastName; ?></div>
                    <div><?= $companyName; ?></div>
                    <div><?= $line1.' '.$line2; ?></div>
                    <div><?= $city.','.$countrySubdivision.' '.$postalCode; ?></div>
                    <div><?= $country; ?></div>
                    <div><?= $phoneNumber; ?></div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- Load footer section -->
<?php $this->load->view('footer', $header); ?>