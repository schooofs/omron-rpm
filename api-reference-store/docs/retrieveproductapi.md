# Retrieve Product API

The **Retrieve Product API** retrieves the product information of the products in the product catalog configured in the store. This API also retrieves all the products for a specific category. The API also retrieve the products the default catalog configured for the store. The Product ID is passed in the Request to retrieve the product information.

The product information includes the product image, product description, product subscription details, product features, and product specification. Using Retrieve Product API, you can also add the product in the Cart to shop.

## Digital River Global Commerce (GC) link
Click the following GC link to open the **Retrieve a Product API** reference.

[https://developers.digitalriver.com/reference#v1shoppersmeproductsbyproductidget](https://developers.digitalriver.com/reference#v1shoppersmeproductsbyproductidget)

## API Library Service Class
Products.php

## Class Method
getProductByID ($productId)

## Parameters 
The Retrieve Product API includes the following parameters.

### Path parameters
Parameters | Description
---------- | ------------
ProductId* | This is a client Product identification Id of the particular product. You need to pass this offer ID in the API to display the respective product information on the DR store page. For more information, refer to Retrieve Product API for more details.

### Query parameters
Parameters | Description
---------- | -----------
apiKey* | This is a client identification key of the DR store. This key is common for all the APIs of this store.
token	| This is an authorized token for a shopper.
expand	| This provides additional parameters of the resources. This parameter is used if you want to get the values of all the fields Response.
fields	| This reduces the set of fields in the resource which you have specifically request.
currency | This is the preferred currency for the pricing information returned for a product. The currency parameter is set based on the country where this store will be used.
locale	| This is the pricing information of the product in the local region. The locale parameter is set based on the usage and availability of the product.

>**Note:** The parameters of the Retrieve Product API are included in the API library. However, for the sample Request, only few parameters have been used. You can use the parameters as per your requirement.

## Sample Request 
The following is a sample Request to display product information.

```
$productID = ‘3674974332’
$queryString  = ‘expand=all’;
$productObj->getProductByID ($productID, $queryString);
```


## Sample Response 
The following is a sample Response to display the product information.

```
array(1) {
  ["product"]=>
  array(27) {
    ["uri"]=>
    string(63) "https://api.digitalriver.com/v1/shoppers/me/products/5102182500"
    ["categories"]=>
    array(1) {
      ["uri"]=>
      string(74) "https://api.digitalriver.com/v1/shoppers/me/products/5102182500/categories"
    }
    ["familyAttributes"]=>
    array(1) {
      ["uri"]=>
      string(81) "https://api.digitalriver.com/v1/shoppers/me/products/5102182500/family-attributes"
    }
    ["id"]=>
    int(5102182500)
    ["name"]=>
    string(20) "Digital River Tablet"
    ["displayName"]=>
    string(20) "Digital River Tablet"
    ["shortDescription"]=>
    string(107) "Digital River Tablet has the power and performace of a laptop in an incredibly lightweight, versatile form."
    ["longDescription"]=>
    NULL
    ["productType"]=>
    string(8) "PHYSICAL"
    ["sku"]=>
    string(6) "sdg436"
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
    string(99) "https://drh1.img.digitalriver.com/DRHM/Storefront/Company/drdod19/images/product/thumbnail/aaaa.png"
    ["productImage"]=>
    string(97) "https://drh1.img.digitalriver.com/DRHM/Storefront/Company/drdod19/images/product/detail/blk_1.png"
    ["keywords"]=>
    NULL
    ["baseProduct"]=>
    string(4) "true"
    ["customAttributes"]=>
    array(1) {
      ["attribute"]=>
      array(23) {
        [0]=>
        array(3) {
          ["name"]=>
          string(17) "clonedFromStaging"
          ["type"]=>
          string(7) "Boolean"
          ["value"]=>
          string(5) "false"
        }
        [1]=>
        array(3) {
          ["name"]=>
          string(9) "tabTitle1"
          ["type"]=>
          string(6) "String"
          ["value"]=>
          string(8) "FEATURES"
        }
		```

		
## Sample Implementation  
The following is a sample Implementation of the Offer API. Here, the response Array Object **$category**  holds all the information to display the offer. 

```
<?php
// Get product Specification
$prodSpecificationArray = array();
$prodCustomAttribute = $product['product']['customAttributes'];
foreach ( $prodCustomAttribute AS $customAttribute ) {
    foreach ( $customAttribute AS $prodSpecification ) {
        $prodSpecificationArray[$prodSpecification['name']] = (isset($prodSpecification['value'])? $prodSpecification['value'] : '');
    }
}
// Get product Tab Titles
$prodTabTitle = array();
foreach ( $prodSpecificationArray AS $key => $value ) {
    if( preg_match('/^tabTitle/',$key) &&  !empty(trim($value)) && $value != "&nbsp;") {
        $prodTabTitle[$key] = $value;
    }
}

// Get Product Tab Content
$prodTabContent = array();
foreach ( $prodTabTitle AS $key => $value ) {
    $tabContentKey = str_replace("Title","Content",$key);
    if ( isset($prodSpecificationArray[$tabContentKey]) ) {
        $prodTabContent[$tabContentKey] = $prodSpecificationArray[$tabContentKey];
    }
}

// Get variation array 
$productVariations = array();
if( isset($product['product']['variations']) ) {
    $productVariations = $product['product']['variations']['product'];
}
$productVariationsArray = array();
$i = 0;
foreach ( $productVariations AS $variationAttribute ) {
    $productVariationsArray[]= array ( 
        'cartUri' => $variationAttribute['addProductToCart']['cartUri'],
        'id' => $variationAttribute['id'],
        'price'=> $variationAttribute['pricing']['formattedSalePriceWithQuantity'],
        'name' => $variationAttribute['name'],
        'image' => $variationAttribute['productImage']
    );
}

$selected_product_id = (isset($product['product']['variations']['product'][0]['id'])
    ?$product['product']['variations']['product'][0]['id']:$product['product']['id']);
?>
<section id="product-description">
    <div class="container mt-4">
       <p id="product-tabs">Home>Software><?php echo $product['product']['name']; ?></p>
        <div class="row">
            <div class="col-md-7 product">
                <img class="img-fluid" 
                    src="<?php echo $product['product']['productImage'];?>" 
                    alt="<?php echo $product['product']['name']; ?>" /> 
            </div>
            <div class="col-md-5 pt-3 prod-details">
                <div id="product-heading">
                    <h3><?php echo $product['product']['name']; ?></h3>
                </div>
                <div class="pt-2 pl-3 pr-4">
                   <p><?php echo $product['product']['shortDescription']; ?></p>
                </div>
                <div class="pt-2 pb-2" id="price-type">
                    <input type="hidden" id="selectedProductID" value="<?= $selected_product_id ?>" />
                    <form class="pl-3">
                        <?php 
                        $i = 0;
                        foreach ( $productVariationsArray AS $variationAttribute ) {
                            $selected = '';
                            if ( $i == 0 ) {
                                $selected = 'checked';
                            }
                        ?>
                            <div class="form-check">
                                <label class="form-check-label" for="radio<?php echo $variationAttribute['id']; ?>">
                                 <input type="radio" class="form-check-input" 
                                         id="radio1" name="optradio" value="<?php echo $variationAttribute['id']; ?>" 
                                         <?php echo $selected; ?> onclick="setProductID('<?php echo $variationAttribute['id']; ?>')">
                                 <?php echo $variationAttribute['name'].' - '.$variationAttribute['price'] ?>;
                                </label>
                            </div>
                        <?php $i++; } ?>
                    </form>
                </div>
                <div class="pt-4">
                    <button id="add-to-cart">ADD TO CART</button>
                    <button class="mt-3 mb-4" id="add-to-wishlist">ADD TO WISHLIST</button>
                </div>
                <div class="mb-3">
                   <?php 
                    $hasProdReviews = 0;
                    foreach ( $prodTabTitle AS $key=>$tabTitle ) { 
                        if ( $tabTitle != 'REVIEWS' ) {
                            $tabContentKey = str_replace("Title","Content",$key);
                            ?>
                            <div data-toggle="collapse" data-target="#<?php echo $tabTitle;?>" class="pb-2 collapse-feature">
                                <?php echo strtoupper($tabTitle);?><i class="fa fa-caret-right pl-2 collapse-arrow"></i>
                            </div>
                            <div id="<?php echo $tabTitle;?>" class="collapse">
                                <?php echo isset($prodTabContent[$tabContentKey])?$prodTabContent[$tabContentKey]:''; ?>
                            </div>
                       <?php 
                        } else {
                            $hasProdReviews = str_replace("Title","Content",$key);;
                        }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>
```