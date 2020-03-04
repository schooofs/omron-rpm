# Update Billing Details
This API updates the billing address on the active cart. 

## Digital River Global Commerce (GC) link
Click the following GC link to open the Update Billing Details API reference.
[https://developers.digitalriver.com/reference#v1shoppersmecartsactivebillingaddressput] (https://developers.digitalriver.com/reference#v1shoppersmecartsactivebillingaddressput)

## API Library Service Class 
Cart.php

## Class Method
updateBillingAddress()

## Parameters
The Update Billing Details API includes the following parameters.
### Query parameters

Parameters | Description
---------- | ----------
token | This is an authorized token for a shopper.
expand | This provides additional parameters of the resources. This parameter is used if you want to get the values of all the fields Response.
fields	This reduces the set of fields in the resource which you have specifically request.
**_Note_**: The parameters for Update Billing Details API are included in the API library. However, for sample Request, only few parameters have been used. You can use the parameters as per your requirement.

## Sample Request 
The following is a sample Request to update the billing details.
```
$accessToken = ‘dsfdgdgdfgfg65hgfhfgh56657’;
$billingDetails = ‘{"address": 
                {
                                "firstName":"tom",
                                "lastName":"marsh",
                                "city":"New York",
                                "countrySubdivision":"NA",
                                "postalCode":"10022",
                                "country":"US",
                                "countryName":"USA",
                                "line1":"Street 11",
                                "line2":"Flat No 23",
                                "phoneNumber":"433456232344",
                                "emailAddress":"tommarsh@test.com"
                }
}’;
$cartService->updateBillingAddress($accessToken, $addressDetails);
```

## Sample Response  
No content

## Output Manipulation using Response :
In this API, the Response object is empty for the Request as it is a PUT request. You can use Retrieve a Cart API to get a updated cart detail. Refer to Retrieve a Cart.

## Sample Implementation
The following is a sample Implementation of the Update Billing Details API. Here, the response Array Object $cartService in the Retrieve a Cart API Response to update the cart details.

```
$activeCart = $cartService->retrieveCart($accessToken);
```
