# Remove Line Item
This API is run to remove one or more line items from an active cart on the Cart page.

## Digital River Global Commerce (GC) link
Click the following GC link to Remove Line Item API reference.
[https://developers.digitalriver.com/reference#v1shoppersmecartsactivelineitemsdelete] (https://developers.digitalriver.com/reference#v1shoppersmecartsactivelineitemsdelete
)
## API Library Service Class 
Cart.php

## Class Method 
deleteLineItem ()

## Parameters  
The Remove a Line Item API includes the following parameters.
### Query parameters
Parameters | Description
---------- | ------------
token | This is an authorized token for a shopper.
lineItemId | This is a comma-separated list of one or more line items identifiers.
**_Note_**: The parameters for Remove Line Item API are included in the API library. However, for sample Request, only few parameters have been used. You can use the parameters as per your requirement.

## Sample Request  
The following is a sample Request to remove the line item. 

```
$lineitemId = ‘566445666’;
$accessToken = ‘sdcsfds65476ghfhf6676868’;
$cartService->deleteLineItem ( $lineitemId,$accessToken);
```

## Sample Response  
No content

## 
Output Manipulation using Response
The API Response object is empty for this API Request. You can use Retrieve a Cart API to get a updated cart detail. Refer to Retrieve a Cart.

## Sample Implementation
The following is a sample Implementation of the Remove Line Item API. Here, the response Array Object $cartService in the Retrieve a Cart API Response to update the cart details.
```
$activeCart = $cartService->retrieveCart($accessToken);
```

