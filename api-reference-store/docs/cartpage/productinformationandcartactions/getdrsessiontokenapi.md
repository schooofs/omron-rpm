# Get DR Session Token API
This API returns a DR session token. This token is used for authentication of the shopper. This token is required when you create a limited access token.

## Digital River Global Commerce (GC) link
Not Available 

## API Library Service Class
Authenticate.php

## Class Method
getDrSessionToken ()

## Parameters
NA

## Sample Request
The following is a sample Request to get DR Session Token for authentication.

```
$authDrData = $authServiceObj->getDrSessionToken();
``` 

## Sample Response
The following is a sample Response to get DR Session Token for authentication.

```
array(1) {
  ["session_token"]=>
  string(32) "89BB409CF743A061618F7ED05C93ED7B"
}
```

## Output Manipulation using Response
The DR session token is received in the API Response. Store this token in the session. This token will be used to get limited access token API call. 

## Sample Implementation
The following is a sample Implementation of the Get DR Session Token API. Here, the response Array Object $authDrData holds all the information to get DR Session Token. 

```
$this->session->set_userdata(
‘dr_session_token', $authDrData [‘session_token’] 
 );
```


