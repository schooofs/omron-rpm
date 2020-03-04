# Update Line Item 
This API is run to update the product information such as quantity and price of the product on the active cart. As you add the product, the corresponding product is created. 

## Digital River Global Commerce (GC) link
Click the following GC link to Update Line Item API reference.
[https://developers.digitalriver.com/reference#v1shoppersmecartsactivelineitemspost] (https://developers.digitalriver.com/reference#v1shoppersmecartsactivelineitemspost)

## API Library Service Class 
Cart.php

## Class Method 
updateLineItem ()
 
## Parameters
The Update Line Item API includes the following parameters.

### Query parameters
Parameters | Description
----------- | ----------
token | This is an authorized token for a shopper.
companyId | This is a company identification ID of the company that owns the product. If the companyID is not provided, the default company associated with the API key is used.
externalReferenceId | This specifies the product external reference identifiers which is used in conjunction with companyID . If the companyID is not provided, the default company associated with the API key is used.
To add multiple products, you can add comma-separated list of external reference IDs.  
offerId | This is a client Offer identification ID of the particular offer type. You need to pass this offer ID in the API to display the respective offer on the DR website page. For more information, refer to Offers API for more details.
productId | This is a client Product identification ID of the product to add the respective product on the cart. Adding product creates a corresponding line item on the cart. To add multiple products, you can add comma-separated list of product IDs.
quantity | This a number of products added to the cart. The quantity must be a valid integer value. If quantity is not specified, the default value is 1.
**_Note_**: The parameters for Update Line Item API are included in the API library. However, for sample Request, only few parameters have been used. You can use the parameters as per your requirement.

## Sample Request  
The following is a sample Request to update line item. 

```
$lineitemId = ‘566445666’;
$accessToken = ‘sdcsfds65476ghfhf6676868’;
$action= ‘add’;
$qty = ‘1’;
$cartService->updateLineItem( $lineitemId,$accessToken,$action, $qty);
```

### Sample Response  
The following is a sample Response to update line item. 
```
array(1) {
  ["lineItem"]=>
  array(5) {
    ["uri"]=>
    string(79) "https://api.digitalriver.com/v1/shoppers/me/carts/active/line-items/17766888610"
    ["id"]=>
    int(17766888610)
    ["quantity"]=>
    int(2)
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
        float(29.98)
      }
      ["salePriceWithQuantity"]=>
      array(2) {
        ["currency"]=>
        string(3) "USD"
        ["value"]=>
        float(23.98)
      }
      ["formattedListPrice"]=>
      string(6) "$14.99"
      ["formattedListPriceWithQuantity"]=>
      string(6) "$29.98"
      ["formattedSalePriceWithQuantity"]=>
      string(6) "$23.98"
    }
  }
}
```

## Output Manipulation using Response
In the API Response, the active cart object $lineItem is received. This object holds the information to update the product line such as quantity , price of the product. 

## Sample Implementation
The following is a sample Implementation of the Update Line Item API. Here, the response Array Object $lineitemId holds all the information to update the line item. 
```
foreach ( $activeCart ['lineItem'] as $lineItem ) {
                if ( $lineitemId == $lineItem['id']  ) {
                    $data['lineitem_price'] = $lineItem['pricing']['formattedSalePriceWithQuantity'];
                    break;
                }
}
```
