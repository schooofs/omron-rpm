# Update Cart Payment Method
This API updates the payment method of a cart. When you pass a full access token as well as a payment method ID in the Request, the payment  method to the shopper's cart will be updated.

## Digital River Global Commerce (GC) link
Click the following GC link to open the Update Cart Payment Method API reference.

[https://developers.digitalriver.com/reference#v1shoppersmecartsactiveapplypaymentmethodpost] (https://developers.digitalriver.com/reference#v1shoppersmecartsactiveapplypaymentmethodpost ) 
## API Library Service Class 
Cart.php

## Class Method
updateCartPayment()

## Parameters
The Update Cart Payment Method API includes the following parameters.

### Query parameters
Parameters | Description
---------- | ------------
token | This is an authorized token for a shopper.
expand | This provides additional parameters of the resources. This parameter is used if you want to get the values of all the fields Response.
fields	This reduces the set of fields in the resource which you have specifically request.
**_Note_**: The parameters for Update Cart Payment Method API are included in the API library. However, for sample Request, only few parameters have been used. You can use the parameters as per your requirement.

## Sample Request 
The following is a sample Request to update the cart payment method.
```
$accessToken = ‘dsfdgdgdfgfg65hgfhfgh56657’;
$sourcePayment = array('sourceId' => ‘ffggg-gfdg-545fd-fdfd5’);
$cartService->updateCartPayment($accessToken, $sourcePayment);
```
## Sample Response  
No content

## Output Manipulation using Response :
In this API, the Response object is empty for the Request as it is a POST request. You can use Retrieve a Cart API to get a updated cart detail. Refer to Retrieve a Cart.

## Sample Implementation
The following is a sample Implementation of the Update Cart Payment Method API. Here, the response Array Object $cartService in the Retrieve a Cart API Response to update the cart details.
```
$activeCart = $cartService->retrieveCart($accessToken);
```




