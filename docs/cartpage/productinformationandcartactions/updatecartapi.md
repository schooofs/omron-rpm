# Update a Cart API
This API is run to create and update active cart to display the cart information. In the API Request, when the product ID of the product is passed, the API Response will return the content to updated  cart. The cart is created or updated with the product information. 
## Digital River Global Commerce (GC) link
Click the following GC link to **Update a Cart API** reference.

[https://developers.digitalriver.com/reference#v1shoppersmecartsactivepost](https://developers.digitalriver.com/reference#v1shoppersmecartsactivepost)

## API Library Service Class
Cart.php

## Class Method
updateCart()

## Parameters
The **Update a Cart API** includes the following parameters.

### Query parameters

Parameters | Description
---------- | ------------
token | This is an authorized token for a shopper.
externalReferenceId | This specifies the product external reference identifiers to restrict the response as per requirement.
offerId	| This is a client Offer identification ID of the particular offer type. You need to pass this offer ID in the API to display the respective offer on the DR store page. For more information, refer to Offer API.
productId | This is a client Product identification ID of the particular product. You need to pass this ID in the API Request to display the respective product information on the Cart page. 
To add multiple products, you can add comma-separated list of product IDs.
promoCode | This a promotional code to apply the coupon code to the product on the Cart page.
>**_Note_**: *To apply a coupon code to the product, the promoCode query parameter is required in the Request*.
quantity | This a number of products added to the cart. The quantity must be a valid integer value. If quantity is not specified, the default value is 1.
termId	| This is a finance term ID associated with the cart. The termId must be in conjunction with the productId or externalReferenceId.
expand	| This provides additional parameters of the resources. This parameter is used if you want to get the values of all the fields Response.
fields	| This reduces the set of fields in the resource which you have specifically request.
>**_Note_**: *The parameters for **Update a Cart API** are included in the API library. However, for sample Request, only few parameters have been used. You can use the parameters as per your requirement*.

## Sample Request  
The following is a sample Request to create or update a cart.
 
```
$productID = ‘566445666’;
$cartService->updateCart($authdata['access_token'], $productID);
```

## Sample Response  
The following is a sample Response to create or update the cart. 

```
array(1) {
  ["cart"]=>
  array(13) {
    ["uri"]=>
    string(56) "https://api.digitalriver.com/v1/shoppers/me/carts/active"
    ["paymentMethods"]=>
    array(1) {
      ["uri"]=>
      string(72) "https://api.digitalriver.com/v1/shoppers/me/carts/active/payment-methods"
    }
    ["webCheckout"]=>
    array(1) {
      ["uri"]=>
      string(69) "https://api.digitalriver.com/v1/shoppers/me/carts/active/web-checkout"
    }
    ["id"]=>
    int(15385970010)
    ["lineItems"]=>
    array(2) {
      ["uri"]=>
      string(67) "https://api.digitalriver.com/v1/shoppers/me/carts/active/line-items"
      ["lineItem"]=>
      array(1) {
        [0]=>
        array(5) {
          ["uri"]=>
          string(79) "https://api.digitalriver.com/v1/shoppers/me/carts/active/line-items/17766861610"
          ["id"]=>
          int(17766861610)
          ["quantity"]=>
          int(1)
          ["product"]=>
          array(4) {
            ["uri"]=>
            string(63) "https://api.digitalriver.com/v1/shoppers/me/products/5102182900"
            ["parentProduct"]=>
            array(1) {
              ["uri"]=>
              string(63) "https://api.digitalriver.com/v1/shoppers/me/products/5102182800"
            }
            ["displayName"]=>
            string(32) "Digital River - Safari Adventure"
            ["thumbnailImage"]=>
            string(135) "https://drh1.img.digitalriver.com/DRHM/Storefront/Company/drdod19/images/product/thumbnail/Safari-Adventure_Computer-Game_Large-NEW.png"
          }
          ["pricing"]=>
          array(6) {
            ["listPrice"]=>
            array(2) {
              ["currency"]=>
              string(3) "USD"
              ["value"]=>
              float(14.99)
            }
            ["listPriceWithQuantity"]=>
            array(2) {
              ["currency"]=>
              string(3) "USD"
              ["value"]=>
              float(14.99)
            }
            ["salePriceWithQuantity"]=>
            array(2) {
              ["currency"]=>
              string(3) "USD"
              ["value"]=>
              float(11.99)
            }
            ["formattedListPrice"]=>
            string(6) "$14.99"
            ["formattedListPriceWithQuantity"]=>
            string(6) "$14.99"
            ["formattedSalePriceWithQuantity"]=>
            string(6) "$11.99"
          }
        }
      }
    }
    ["totalItemsInCart"]=>
    int(1)
    ["businessEntityCode"]=>
    string(13) "DR_INC-ENTITY"
    ["billingAddress"]=>
    array(1) {
      ["uri"]=>
      string(72) "https://api.digitalriver.com/v1/shoppers/me/carts/active/billing-address"
    }
    ["shippingAddress"]=>
    array(1) {
      ["uri"]=>
      string(73) "https://api.digitalriver.com/v1/shoppers/me/carts/active/shipping-address"
    }
    ["payment"]=>
    array(0) {
    }
    ["shippingMethod"]=>
    array(2) {
      ["code"]=>
      int(265200)
      ["description"]=>
      string(8) "Standard"
    }
    ["shippingOptions"]=>
    array(1) {
      ["uri"]=>
      string(73) "https://api.digitalriver.com/v1/shoppers/me/carts/active/shipping-options"
    }
    ["pricing"]=>
    array(10) {
      ["subtotal"]=>
      array(2) {
        ["currency"]=>
        string(3) "USD"
        ["value"]=>
        float(11.99)
      }
      ["discount"]=>
      array(2) {
        ["currency"]=>
        string(3) "USD"
        ["value"]=>
        int(0)
      }
      ["shippingAndHandling"]=>
      array(2) {
        ["currency"]=>
        string(3) "USD"
        ["value"]=>
        float(8.21)
      }
      ["tax"]=>
      array(2) {
        ["currency"]=>
        string(3) "USD"
        ["value"]=>
        int(0)
      }
      ["orderTotal"]=>
      array(2) {
       ["currency"]=>
        string(3) "USD"
        ["value"]=>
        float(20.2)
      }
      ["formattedSubtotal"]=>
      string(6) "$11.99"
      ["formattedDiscount"]=>
      string(5) "$0.00"
      ["formattedShippingAndHandling"]=>
      string(5) "$8.21"
      ["formattedTax"]=>
      string(5) "$0.00"
      ["formattedOrderTotal"]=>
      string(6) "$20.20"
    }
  }
}
```


## Output Manipulation using Response
In the API Response, the active cart object $active_cart is received. This object holds all the information of the active cart and display the respective information on the cart.

## Sample Implementation
The following is a sample Implementation of the _Update a Cart API_. Here, the response Array Object $active_cart holds all the information to create or update a cart. 

```
<?php 
$subtotal = $active_cart['cart']['pricing']['formattedSubtotal'];
$shipping_charges = $active_cart['cart']['pricing']['formattedShippingAndHandling'];  
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
                                    <div class="col-4 label-txt">Product Name:</div>
                                    <div class="col-8 label-txt"><?php echo $product_name; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-4 label-txt">Quantity:</div>
                                    <div class="col-8 label-txt">
                                        <input type="number" value="<?php echo $product_quantity;?>" 
                                         style="padding-left: 2px; width:50px;" onKeyPress="if(this.value.length==8) return false;" min="1" id="<?php echo $lineitem_id.'_qty_mob';?>" >
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
                                style="width:50px;" onKeyPress="if(this.value.length==8) return false;" min="1" id="<?php echo $lineitem_id.'_qty';?>" >
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
	```

