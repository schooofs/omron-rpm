# Get Limited Access Token 
This API returns a DR Limited Access Token. This token is used as Shopper token for each API call such as to update or remove a line item, to view the product information.

## Digital River Global Commerce (GC) link

Click the following GC link to open the Get Limited Access Token API reference.
[https://developers.digitalriver.com/reference#oauth20tokenclientcredentialspost] (https://developers.digitalriver.com/reference#oauth20tokenclientcredentialspost)

## API Library Service Class 
Authenticate.php

## Class Method
getLimitedOauthToken ()
 
## Parameters
The Get Limited Access Token API includes the following parameters.

### Form Data
Parameters | Description
----------- | -----------
dr_session_token | This is a DR session token that identifies a shopper session. This token is required to create a shopper session-aware token. For details, refer to Get DR Session Token API. 


### Query parameters
Parameters | Description
---------- | ------------
dr_limited_token* | This token identifies an anonymous shopper session.
response_type	The response_type must contain a value of token for a public application.
**_Note_**: The parameters of the Get Limited Access Token API are included in the API library. However, for the sample Request, only few parameters have been used. You can use the parameters as per your requirement.

## Sample request 
The following is a sample Request to get a limited access token.
```
$authData = $authService>getLimitedOauthToken($authDrData['session_token']);
```

## Sample response 
The following is a sample Response to get a limited access token.
```
array(4) {
  ["access_token"]=>
  string(160) "f27a999fbd528d5e86e92196ce59f9673f1d25a877f5f4e8b516a2ada0a0bbbf0bba979f67aeacf1d82d37869218096abf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08"
  ["token_type"]=>
  string(6) "bearer"
  ["expires_in"]=>
  int(86398)
  ["refresh_token"]=>
  string(176) "f27a999fbd528d5e86e92196ce59f9673f1d25a877f5f4e8b516a2ada0a0bbbf681f8acdc82a27150a3c92d0285a5f7e94a7b8ef9d00691471e20af8294fa1cd1cca49d976d22ef33ddfb1eca0a32415271b4177a307c9dd"
}
```

## Output Manipulation using Response :
The $authData token is received in the API response. Store this token in the session. The token will used as a shopper token for each API request.

## Sample Implementation 
The following is a sample Implementation of the Get Limited Access Token API. Here, the response Array Object $authDrData holds all the information of DR Limited Session Token. 
```
$this->session->set_userdata(
‘access_token, $authData [‘access_token’] 
 );
```