<?php 
require_once __DIR__ . '/vendor/autoload.php';

$applicationName = "Dr demo Store";
$siteId = "drdod19";
$apiKey = "5b3cbb55681c48bab419e17c8b52b7d7";
$privateApiKey = 'ac96b8dd0ad74e6485e9d5549b4b750a';
$secretKey = '5b2333960edc4e868221eaf8aa18f272';
$environment = Digitalriver\Environment::LOCAL;
$apiVersion = "v1";
$token = '36a901961740797a9880a2082fb16705d1614175445e6dc2348310d68c24f1cde190680d273a4233708473e2b15ca327ad61f8942d0bd20e5a06d1ee8387bb8afeb90973f2d1cee2';
$testOrder = 'true';
/*** Set client account ***/
$client = new Digitalriver\Client();
$client->setApplicationName($applicationName);
$client->setSiteId($siteId);
$client->setApiKey($apiKey);
$client->setApiVersion($apiVersion);
$client->setEnvironment($environment);
$client->setTestOrder($testOrder);
$client->setPrivateApiKey($privateApiKey);
$client->setSecretKey($secretKey);

/*** Loding services for site module ***/
$authService =  new Digitalriver\Service\Authenticate($client);
$productsService =  new Digitalriver\Service\Products($client);
$cartService =  new Digitalriver\Service\Cart($client);
$categoryService = new Digitalriver\Service\Category($client);
$shopperService =  new Digitalriver\Service\Shopper($client);
$offerService =  new Digitalriver\Service\Offer($client);
$promotionService =  new Digitalriver\Service\Promotion($client);
$privateStoreService =  new Digitalriver\Service\PrivateStore($client);


try {
    echo '<pre>';
    // get limited access token 
    $authDrData = $authService->getDrSessionToken();
    // Get Outh Token 
    //echo $authDrData['session_token'];
    //$limitedOauthToken = $authService->getLimitedOauthToken($authDrData['session_token']);
    //$tokenInformation = $authService->getTokenInformation($limitedOauthToken['access_token']);
    //var_dump($tokenInformation);
    
    //$authdata = $authService->getAccessToken();
    /*$authdata = $shopperService->getShopperToken();
    $cartService->updateCart($authdata['access_token'], 5102182600);
            
    $activeCart = $cartService->retrieveCart($authdata['access_token']);
    */
    //$allLineItem = $cartService->getAllLineItem($authdata['access_token']);
    //$lineItem = $cartService->getLineItemById('36a901961740797a9880a2082fb16705d1614175445e6dc2348310d68c24f1cdbe63261ae2acc3c45792d0fe2f4f022cbf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08', '17738277710');
    //$cartOfferList = $cartService->getAllPOPOffers('36a901961740797a9880a2082fb16705d1614175445e6dc2348310d68c24f1cd96b62a44e537e490f9ed56076e83303cbf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08', 'product_on_sale_special_offers');
    //$shippingAddress = $cartService->retrieveShippingAddress('36a901961740797a9880a2082fb16705d1614175445e6dc2348310d68c24f1cd96b62a44e537e490f9ed56076e83303cbf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08');
    //$shippingOptions = $cartService->getAllShippingOptions('36a901961740797a9880a2082fb16705d1614175445e6dc2348310d68c24f1cd96b62a44e537e490f9ed56076e83303cbf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08');
    //$shippingOptionDetails = $cartService->getShippingOptionById('36a901961740797a9880a2082fb16705d1614175445e6dc2348310d68c24f1cd96b62a44e537e490f9ed56076e83303cbf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08',167400);
    //$applyShippingOption = $cartService->applyShippingOption('36a901961740797a9880a2082fb16705d1614175445e6dc2348310d68c24f1cd96b62a44e537e490f9ed56076e83303cbf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08',167400);
    //$webCheckout =  $cartService->webCheckout('36a901961740797a9880a2082fb16705d1614175445e6dc2348310d68c24f1cd96b62a44e537e490f9ed56076e83303cbf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08');
    //$taxRegistration = $cartService->getTaxRegistrationJson('36a901961740797a9880a2082fb16705d1614175445e6dc2348310d68c24f1cd07eedc182afddf2c46016ea9649624bcbf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08', '17760057910', 'drd19');
    //$promotionList = $promotionService->getPOPList('36a901961740797a9880a2082fb16705d1614175445e6dc2348310d68c24f1cd96b62a44e537e490f9ed56076e83303cbf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08');
    //$popDetails = $promotionService->getPOPByName('36a901961740797a9880a2082fb16705d1614175445e6dc2348310d68c24f1cd96b62a44e537e490f9ed56076e83303cbf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08','Banner_ShoppingCartLocal');
    //$popOffers = $promotionService->getPOPOffers('36a901961740797a9880a2082fb16705d1614175445e6dc2348310d68c24f1cd96b62a44e537e490f9ed56076e83303cbf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08','Banner_ShoppingCartLocal');
    //$products = $productsService->listAllProducts();
    //$products = $productsService->getProductByID('5102182500');
    //$productVariations = $productsService->getProductVariations('5102182500');
    //$productCategories = $productsService->getProductCategories('5102182500');
    //$productFinancing = $productsService->getProductFinancing('5102182500');
    //$listOfPOP = $productsService->getListOfPOP('5102182500');
    $allOffers = $productsService->getAllOffers('5102182500','Interstitial_CrossSell');
    //$products = $productsService->getInventoryStatus('5102182500');
    //$products = $productsService->getProductPrice('5102182500');
    //$lineitem_id = $activeCart['cart']['lineItems']['lineItem'][0]['id'];
    //$cartService->updateLineItem( $lineitem_id, $authdata['access_token'], 'add', '1' );
    /*$cartService->deleteLineItem( $lineitem_id, $authdata['access_token']);
    $activeCart = $cartService->retrieveCart('f27a999fbd528d5e86e92196ce59f9673f1d25a877f5f4e8b516a2ada0a0bbbf5ef1bc5ea992236ff364524344f7e441bf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08');
    /*$userDetails = array (
        'externalReferenceId' => 'pradeepja6',
        'username' => 'pradeepja6',
        'password' => base64_encode('cybage@123'),
        'emailAddress' => 'pradeepja@cybage.com',
        'firstName' => 'Pradeep',
        'lastName' => 'Jadhav',
        "locale" => "en_US",
        "currency"=> "USD"
    );*/
    //$createShopperRes = $shopperService->createShopper( $authdata['access_token'], $userDetails);
    /*$billingDetails =  array(
        "nickName"=> "pradeep",
        "isDefault"=> "true",
        "firstName"=> "Pradeep",
        "lastName"=> "Jadhav",
        "line1"=> "18251 Flying Cloud Drive",
        "line2"=> "Suite 100",
        "city"=> "Eden Prairie",
        "countrySubdivision"=> "MN",
        "postalCode"=> "55344",
        "country"=> "US",
        "countryName"=> "United States",
        "phoneNumber"=> "999-111-2222"
        );
    
    $shopperService->UpdateShopperAddress('f27a999fbd528d5e86e92196ce59f9673f1d25a877f5f4e8b516a2ada0a0bbbfab3cad4357811f3f3b197522ab9099e0bf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08',$billingDetails);*/
    //$sourcePayment = array('sourceId' => $sourceId);
    /*$sourcePayment = array(
        "nickName" => "Visa ************1111",
        "isDefault"  => "false",
        "type"  => "CreditCardMethod",
        "creditCard"  => array (
          "expirationMonth" =>  1,
          "expirationYear" => 2024,
          "issueCode" => null,
          "startMonth" => null,
          "startYear" => null,
          "displayableNumber" => null,
          "type" => "visa",
          "displayName" => "Visa"
        )
    );
    $shopperService->UpdateShopperPayment('f27a999fbd528d5e86e92196ce59f9673f1d25a877f5f4e8b516a2ada0a0bbbfab3cad4357811f3f3b197522ab9099e0bf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08',
            $sourcePayment);
    */
    //$shopperTokenDetails = $shopperService->getShopperPayments('f27a999fbd528d5e86e92196ce59f9673f1d25a877f5f4e8b516a2ada0a0bbbf90c8dba9cd877b5a24fa77df36e83122bf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08');
    //$activeCart = $cartService->retrieveCart('36a901961740797a9880a2082fb16705d1614175445e6dc2348310d68c24f1cd42c8b99ab01386adfceb6be872a2f3b6bf2c6e30e718130f6d124a3d58c2f02792a32f9ec4ecf882e4d9d3854d423b08');
    
    //$shopperTokenDetails = $authService->getShopperOauthToken($authdata['access_token'], 'pradeepja', 'cybage@123');
    
    /*
    
    $cartService->updateBillingAddress( $authdata['access_token'], json_encode($billingDetails));*/
    
    /*$source_id = 'cf2778f0-ee8e-4876-bd08-875a092954af';
    $sourceDetails = array('sourceId' => "cf2778f0-ee8e-4876-bd08-875a092954af"); // '{"paymentMethod":{"sourceId":"cf2778f0-ee8e-4876-bd08-875a092954af"}}';
    $cartService->updateCartPayment($authdata['access_token'], $sourceDetails);*/
    //$getFullAccessToken = $authService->getFullAccessToken('pradeepja@cybage.com', 'Cybage@123', $authDrData['session_token'] );
    //$shopperDetail = $shopperService->getShopperData($getFullAccessToken['access_token']);
    // Update shopper details 
    /*$userDetails = array (
        'firstName' => 'Pradeep',
        'lastName' => 'Jadhav',
        "locale" => "en_US",
        "currency"=> "USD"
    );
    $shopperService->updateShopper($getFullAccessToken['access_token'], $userDetails);*/
    //$shopperAccount = $shopperService->getShopperAccount($getFullAccessToken['access_token'],'http://apitest.com/');
    //$shopperAddress = $shopperService->getShopperAddress($getFullAccessToken['access_token']);
    //$shopperService->deleteShopperAddress($getFullAccessToken['access_token'], '16617611912');
    //$shopperAddressById = $shopperService->getAddressById($getFullAccessToken['access_token'], '16617610612');
    //$shoppersPayments = $shopperService->getShopperPayments($getFullAccessToken['access_token']);
    //$shoppersPaymentsById = $shopperService->getPaymentOptionById($getFullAccessToken['access_token'],13547044612);
    //$shopperDetail = $shopperService->getShopperData($getFullAccessToken['access_token']);
    //$customerTax = $shopperService->getCustomerTax('12344222', 'token='.$getFullAccessToken['access_token']);
    //$productsPOP = $productsService->getPOP( 5102133700, 'Interstitial_CrossSell');
    //$offerDetails = $offerService->getOffer('59442374001');
    //$categoriesOfOffers = $offerService->getCategoryOffers('59442374001');
    //$productOffers = $offerService->getProductOffers('59442374001');
    //$allCategories = $categoryService->listAllCategories();
    //$privateStoreDetails = $privateStoreService->getPrivateStore($getFullAccessToken['access_token']);

    //var_dump($shopperTokenDetails);
    var_dump($allOffers);
}
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
} 
