# Offers API

The Offer is a promotion or discount to attract shoppers to purchase from a store. The **Offers API** provides access to offers. Once you run the Category API, you can run the **Offers API**. The **Offers API** helps to display Offer functionality to the website.

Multiple Offers APIs can be called for single page. You need to change only the Offer ID to display an offer. Each offer has a unique Offer ID. The following offers are shown on the Home page. 

## Digital River Global Commerce (GC) link
Click the following GC link to open the **Offers API** reference.

[https://developers.digitalriver.com/reference#v1shoppersmecategoriesget](https://developers.digitalriver.com/reference#v1shoppersmecategoriesget)

## API Library Service Class
Offer.php

## Class Method
getOffer()

## Parameters 
The **Offers API** includes the following parameters.

### Path parameters*
Parameters | Description
---------- | -----------
offerId* | This is a client Offer identification Id of the particular offer type. You need to pass this offer ID in the API to display the respective offer on the DR website page. For more information, refer to Offers API for more details.

### Query parameters**
Parameters | Description
---------- | -----------
apiKey*	| This is a client identification key of the DR website. This key is common for all the APIs of this website. 
token | This is an authorized token for a shopper.
expand | This provides additional parameters of the resources. This parameter is used if you want to get the values of all the fields Response.
fields | This reduces the set of fields in the resource which you have specifically request.

>**_Note_:** The parameters for **Offers API** are included in the API library. However, for sample Request, only few parameters have been used. You can use the parameters as per your requirement.

## Sample Request
The following is a sample Request to display SPECIAL OFFER and CROWED FAVORITES offer.

```
$offerId= ‘56432456710’
$queryString  = ‘token=#token#&expand=all’;
$categoryObj-> getOffer ( $offerId, $queryString );
```


## Sample Response 
The following is a sample Response to display SPECIAL OFFER and CROWED FAVORITES offer.

```
array(1) {
  ["offer"]=>
  array(10) {
    ["uri"]=>
    string(62) "https://api.digitalriver.com/v1/shoppers/me/offers/59442374801"
    ["id"]=>
    int(59442374801)
    ["name"]=>
    string(51) "drdod_home_category_promotions_with_subcategories_1"
    ["policyName"]=>
    NULL
    ["type"]=>
    string(6) "Banner"
    ["image"]=>
    NULL
    ["salesPitch"]=>
    array(4) {
      [0]=>
      string(0) ""
      [1]=>
      string(0) ""
      [2]=>
      string(8) "67969600"
      [3]=>
      string(0) ""
    }
    ["productOffers"]=>
    array(2) {
      ["uri"]=>
      string(77) "https://api.digitalriver.com/v1/shoppers/me/offers/59442374801/product-offers"
      ["productOffer"]=>
      array(3) {
        [0]=>
        array(4) {
          ["uri"]=>
          string(88) "https://api.digitalriver.com/v1/shoppers/me/offers/59442374801/product-offers/5102182500"
          ["id"]=>
          int(5102182500)
          ["product"]=>
          array(3) {
            ["uri"]=>
            string(63) "https://api.digitalriver.com/v1/shoppers/me/products/5102182500"
            ["displayName"]=>
            string(20) "Digital River Tablet"
            ["thumbnailImage"]=>
            string(99) "https://drh1.img.digitalriver.com/DRHM/Storefront/Company/drdod19/images/product/thumbnail/aaaa.png"
          }
          ["pricing"]=>
          array(5) {
            ["listPrice"]=>
            array(2) {
              ["currency"]=>
              string(3) "USD"
              ["value"]=>
              float(399.99)
            }
            ["salePriceWithQuantity"]=>
            array(2) {
              ["currency"]=>
              string(3) "USD"
              ["value"]=>
              float(319.99)
            }
            ["formattedListPrice"]=>
            string(7) "$399.99"
            ["formattedSalePriceWithQuantity"]=>
            string(7) "$319.99"
            ["listPriceIncludesTax"]=>
            string(5) "false"
          }
        }
        [1]=>
        array(4) {
          ["uri"]=>
          string(88) "https://api.digitalriver.com/v1/shoppers/me/offers/59442374801/product-offers/5102181900"
          ["id"]=>
          int(5102181900)
          ["product"]=>
          array(3) {
            ["uri"]=>
            string(63) "https://api.digitalriver.com/v1/shoppers/me/products/5102181900"
            ["displayName"]=>
            string(24) "Digital River Headphones"
            ["thumbnailImage"]=>
            string(103) "https://drh1.img.digitalriver.com/DRHM/Storefront/Company/drdod19/images/product/thumbnail/HEAD-NEW.png"
          }
          ["pricing"]=>
          array(5) {
            ["listPrice"]=>
            array(2) {
              ["currency"]=>
              string(3) "USD"
              ["value"]=>
              float(129.99)
            }
            ["salePriceWithQuantity"]=>
            array(2) {
              ["currency"]=>
              string(3) "USD"
              ["value"]=>
              float(103.99)
            }
            ["formattedListPrice"]=>
            string(7) "$129.99"
            ["formattedSalePriceWithQuantity"]=>
            string(7) "$103.99"
            ["listPriceIncludesTax"]=>
            string(5) "false"
          }
        }
        [2]=>
        array(4) {
          ["uri"]=>
          string(88) "https://api.digitalriver.com/v1/shoppers/me/offers/59442374801/product-offers/5102182200"
          ["id"]=>
          int(5102182200)
          ["product"]=>
          array(3) {
            ["uri"]=>
            string(63) "https://api.digitalriver.com/v1/shoppers/me/products/5102182200"
            ["displayName"]=>
            string(20) "Digital River Laptop"
            ["thumbnailImage"]=>
            string(103) "https://drh1.img.digitalriver.com/DRHM/Storefront/Company/drdod19/images/product/thumbnail/lappy123.png"
          }
          ["pricing"]=>
          array(5) {
            ["listPrice"]=>
            array(2) {
              ["currency"]=>
              string(3) "USD"
              ["value"]=>
              float(1259.99)
            }
            ["salePriceWithQuantity"]=>
            array(2) {
              ["currency"]=>
              string(3) "USD"
              ["value"]=>
              float(1007.99)
            }
            ["formattedListPrice"]=>
            string(9) "$1,259.99"
            ["formattedSalePriceWithQuantity"]=>
            string(9) "$1,007.99"
            ["listPriceIncludesTax"]=>
            string(5) "false"
          }
        }
      }
    }
    ["categoryOffers"]=>
    array(0) {
    }
    ["offerBundleGroups"]=>
    array(0) {
    }
  }
}
```


## Sample Implementation 

The following is a sample Implementation of the **Offers API**. Here, the response Array Object **$offers** holds all the information to display the offer. 

**Upgrade Offer:**

```
<section id="offer">
    <div class="container-fluid pl-0 pr-0">
        <div class="row no-gutters">
            <div class="col-md-6 background1">
               <div class="offer-details1 text-center">
                  <h1><?= $offers['upgrade']['salesPitch'][0] ?></h1>
                  <h5><?= $offers['upgrade']['salesPitch'][1] ?></h5>
                  <a  href="<?php echo site_url('category/products/').'?id=70229700';?>" 
                      class="offer-button">SHOP NOW</a>
               </div>
            </div>
            <div class="col-md-6">
               <img src="<?= $offers['upgrade']['image']?>" alt="" style="width:100%;"/>
            </div>
        </div>
    </div>
</section>
```

**Future Product Offer:** 

```
<section id="popularProducts">
    <div class="container-fluid background-img mt-5 mb-4">
        <div class="crowd-favorites text-center">
            <p class="heading">CROWD FAVORITES</p>
            <p class="content">Our most popular products</p>
        </div>
        <div class="row list">
            <?php foreach ( $offers['futureProduct'] AS $product ) {
                ?>
                <div class="col-12 col-md-4">
                    <a href="<?= site_url('product/showProduct/').'?productId='.$product['id'];?>">
                    <div id="parent" class="parent-border">
                        <div id="child">
                            <img class="img-fluid" src="<?= $product['product']['thumbnailImage'] ?>" alt="<?=      
                                 $product['product']['displayName'] ?>" />
                            <div>
                                <?= $product['product']['displayName'] ?>
                               <br/>
                                <?= $product['pricing']['formattedSalePriceWithQuantity'] ?>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            <?php } ?>
       </div>
    </div>
</section>
```