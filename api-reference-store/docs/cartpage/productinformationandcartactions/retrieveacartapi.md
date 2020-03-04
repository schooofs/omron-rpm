# Retrieve a Cart
This API is called to retrieve the contents of an active cart. When you pass an access token in the Request, the corresponding cart information such as products information, links to billing and shipping address, and shipping options are updated in the Response.

## Digital River Global Commerce (GC) link
Click the following GC link to Retrieve a Cart API reference.
[https://developers.digitalriver.com/reference#v1shoppersmecartsactiveget] (https://developers.digitalriver.com/reference#v1shoppersmecartsactiveget)
 
## API Library Service Class 
Cart.php

## Class Method 
retrieveCart ()

## Parameters
The Retrieve a Cart API includes the following parameters.
###Query parameters

Parameters | Description
----------- | ------------
token | This is an authorized token for a shopper.
expand | This provides additional parameters of the resources. This parameter is used if you want to get the values of all the fields Response.
fields	This reduces the set of fields in the resource which you have specifically request.
**_Note_**: The parameters for Retrieve a Cart API are included in the API library. However, for sample Request, only few parameters have been used. You can use the parameters as per your requirement.

## Sample Request  
The following is a sample Request to retrieve a cart. 
```
$accessToken = ‘sdcsfds65476ghfhf6676868’;
$activeCart = $cartService->retrieveCart($accessToken);
``` 

##Sample Request  
The following is a sample Response to retrieve a cart.
```
array(1) {
  ["cart"]=>
  array(16) {
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
    int(15386171810)
    ["lineItems"]=>
    array(2) {
      ["uri"]=>
      string(67) "https://api.digitalriver.com/v1/shoppers/me/carts/active/line-items"
      ["lineItem"]=>
      array(1) {
        [0]=>
        array(6) {
          ["uri"]=>
          string(79) "https://api.digitalriver.com/v1/shoppers/me/carts/active/line-items/17767073210"
          ["id"]=>
          int(17767073210)
          ["quantity"]=>
          int(1)
          ["product"]=>
          array(23) {
            ["uri"]=>
            string(63) "https://api.digitalriver.com/v1/shoppers/me/products/5102182900"
            ["parentProduct"]=>
            array(21) {
              ["uri"]=>
              string(63) "https://api.digitalriver.com/v1/shoppers/me/products/5102182800"
              ["id"]=>
              int(5102182800)
              ["name"]=>
              string(42) "Digital River - Safari Adventure (Console)"
              ["displayName"]=>
              string(32) "Digital River - Safari Adventure"
              ["shortDescription"]=>
              string(242) "In Digital River Safari Adventures there are new neighbors in town — and they're a little bit wild. The charming world of  Digital River Safari Adventure bursts to life for the first time ever and it's bringing along a lot of new surprises."
              ["longDescription"]=>
              NULL
              ["productType"]=>
              string(8) "DOWNLOAD"
              ["sku"]=>
              string(5) "hdm57"
              ["externalReferenceId"]=>
              NULL
              ["companyId"]=>
              string(7) "drdod19"
              ["displayableProduct"]=>
              string(4) "true"
              ["purchasable"]=>
              string(4) "true"
              ["manufacturerName"]=>
              NULL
              ["manufacturerPartNumber"]=>
              NULL
              ["minimumQuantity"]=>
              NULL
              ["maximumQuantity"]=>
              NULL
              ["thumbnailImage"]=>
              string(135) "https://drh1.img.digitalriver.com/DRHM/Storefront/Company/drdod19/images/product/thumbnail/Safari-Adventure_Computer-Game_Large-NEW.png"
              ["productImage"]=>
              string(128) "https://drh1.img.digitalriver.com/DRHM/Storefront/Company/drdod19/images/product/detail/Safari-Adventure_Computer-Game_Large.png"
              ["keywords"]=>
              NULL
              ["baseProduct"]=>
              string(4) "true"
              ["variationAttributes"]=>
              array(1) {
                ["attribute"]=>
                array(2) {
                  [0]=>
                  array(3) {
                    ["name"]=>
                    string(11) "productType"
                    ["displayName"]=>
                    NULL
                    ["domainValues"]=>
                    array(2) {
                      [0]=>
                      string(8) "PHYSICAL"
                      [1]=>
                      string(8) "DOWNLOAD"
                    }
                  }
                  [1]=>
                  array(3) {
                    ["name"]=>
                    string(5) "sizes"
                    ["displayName"]=>
                    string(5) "Sizes"
                    ["domainValues"]=>
                    array(11) {
                      [0]=>
                      string(2) "XS"
                      [1]=>
                      string(1) "S"
                      [2]=>
                      string(1) "M"
                      [3]=>
                      string(1) "L"
                      [4]=>
                      string(2) "XL"
                      [5]=>
                      string(3) "XXL"
                      [6]=>
                      string(11) "Playstation"
                      [7]=>
                      string(3) "Wii"
                      [8]=>
                      string(4) "Xbox"
                      [9]=>
                      string(24) "Digital for PC - Monthly"
                      [10]=>
                      string(23) "Digital for PC - Annual"
                    }
                  }
                }
              }
            }
            ["id"]=>
            int(5102182900)
            ["name"]=>
            string(42) "Digital River - Safari Adventure (Console)"
            ["displayName"]=>
           string(32) "Digital River - Safari Adventure"
            ["shortDescription"]=>
            string(242) "In Digital River Safari Adventures there are new neighbors in town — and they're a little bit wild. The charming world of  Digital River Safari Adventure bursts to life for the first time ever and it's bringing along a lot of new surprises."
            ["longDescription"]=>
            NULL
            ["productType"]=>
            string(8) "PHYSICAL"
            ["sku"]=>
            string(5) "hdm57"
            ["externalReferenceId"]=>
            NULL
            ["companyId"]=>
            string(7) "drdod19"
            ["displayableProduct"]=>
            string(4) "true"
            ["purchasable"]=>
            string(4) "true"
            ["manufacturerName"]=>
            NULL
            ["manufacturerPartNumber"]=>
            NULL
            ["minimumQuantity"]=>
            NULL
            ["maximumQuantity"]=>
            NULL
            ["thumbnailImage"]=>
            string(135) "https://drh1.img.digitalriver.com/DRHM/Storefront/Company/drdod19/images/product/thumbnail/Safari-Adventure_Computer-Game_Large-NEW.png"
            ["productImage"]=>
            string(128) "https://drh1.img.digitalriver.com/DRHM/Storefront/Company/drdod19/images/product/detail/Safari-Adventure_Computer-Game_Large.png"
            ["keywords"]=>
            NULL
            ["baseProduct"]=>
            string(5) "false"
            ["customAttributes"]=>
            array(1) {
              ["attribute"]=>
              array(67) {
                [0]=>
                array(3) {
                  ["name"]=>
                  string(9) "tabTitle1"
                  ["type"]=>
                  string(6) "String"
                  ["value"]=>
                  string(8) "FEATURES"
                }
                [1]=>
                array(3) {
                  ["name"]=>
                  string(9) "tabTitle2"
                  ["type"]=>
                  string(6) "String"
                  ["value"]=>
                  string(5) "SPECS"
                }
                [2]=>
                array(3) {
                  ["name"]=>
                  string(17) "numberOfDownloads"
                  ["type"]=>
                  string(6) "String"
                  ["value"]=>
                  string(1) "5"
                }
                [3]=>
                array(3) {
                  ["name"]=>
                  string(29) "suppressDRMInUpgradeDowngrade"
                  ["type"]=>
                  string(7) "Boolean"
                  ["value"]=>
                  string(4) "true"
                }
                [4]=>
                array(3) {
                  ["name"]=>
                  string(29) "needsRestrictedShippingOption"
                  ["type"]=>
                  string(7) "Boolean"
                  ["value"]=>
                  string(5) "false"
                }
                [5]=>
                array(3) {
                  ["name"]=>
                  string(29) "suppressDRMInQuantityIncrease"
                  ["type"]=>
                  string(7) "Boolean"
                  ["value"]=>
                  string(4) "true"
                }
                [6]=>
                array(3) {
                  ["name"]=>
                  string(17) "downloadDisplayed"
                  ["type"]=>
                  string(6) "String"
                  ["value"]=>
                  string(4) "true"
                }
                [7]=>
                array(3) {
                  ["name"]=>
                  string(19) "downloadDisplayName"
                  ["type"]=>
                  string(6) "String"
                  ["value"]=>
                  string(27) "electronics-accessories.png"
                }
               [8]=>
                array(3) {
                  ["name"]=>
                  string(20) "autoRenewalDateBasis"
                  ["type"]=>
                  string(6) "String"
                  ["value"]=>
                  string(12) "PurchaseDate"
                }
                [9]=>
                array(3) {
                  ["name"]=>
                  string(56) "timeIntervalForUpgradeReminderNotificationsPreExpiration"
                  ["type"]=>
                  string(4) "List"
                  ["value"]=>
                  string(2) "[]"
                }
                [10]=>
                array(3) {
                  ["name"]=>
                  string(14) "purchasedUnits"
                  ["type"]=>
                  string(6) "String"
                  ["value"]=>
                  string(1) "0"
                }
                [11]=>
                array(3) {
                  ["name"]=>
                  string(5) "sizes"
                  ["type"]=>
                  string(6) "String"
                  ["value"]=>
                  string(11) "Playstation"
                }
                [12]=>
                array(3) {
                  ["name"]=>
                  string(17) "isCombinedRenewal"
                  ["type"]=>
                  string(7) "Boolean"
                  ["value"]=>
                  string(5) "false"
                }
                [13]=>
                array(3) {
                  ["name"]=>
                  string(9) "tabTitle3"
                  ["type"]=>
                  string(6) "String"
                  ["value"]=>
                  string(7) "REVIEWS"
                }
                [14]=>
                array(3) {
                  ["name"]=>
                  string(18) "originalIsViewable"
                  ["type"]=>
                  string(7) "Boolean"
                  ["value"]=>
                  string(4) "true"
                }
                [15]=>
                array(3) {
                  ["name"]=>
                  string(9) "tabTitle4"
                  ["type"]=>
                  string(6) "String"
                  ["value"]=>
                  string(11) "RECOMMENDED"
                }
                [16]=>
                array(3) {
                  ["name"]=>
                  string(10) "landedCost"
                  ["type"]=>
                  string(7) "Boolean"
                  ["value"]=>
                  string(5) "false"
                }
                [17]=>
                array(3) {
                  ["name"]=>
                  string(19) "colorVaryingProduct"
                  ["type"]=>
                  string(7) "Boolean"
                  ["value"]=>
                  string(5) "false"
                }
                [18]=>
                array(3) 
. . . . . 
```

## Output Manipulation using Response :
In the API Response, the active cart object $active_cart is received. This object holds all the information of the active cart and display the respective information on the cart.

## Sample Implementation
The following is a sample Implementation of the Retrieve a Cart API. Here, the response Array Object $active_cart holds all the information to retrieve the cart.
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






