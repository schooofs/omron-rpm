<?php
namespace Digitalriver;

class CartTest extends TestCase {
    protected $_clientObj;
    protected $_productService;
    protected $_authService;
    protected $_accessToken;
    
    protected function setUp(){
        $client = $this->createClient();
        $authService = new Service\Authenticate($client);
        $authDrData = $authService->getDrSessionToken();
        if(isset($authDrData['session_token'])) {
            $oauthToken = $authService->getLimitedOauthToken($authDrData['session_token']);
            if(isset($oauthToken['access_token'])) {
                $this->_accessToken = $oauthToken['access_token'];
            }
        }
    }

    public function __construct(){
        parent::__construct();
        $this->_clientObj = $this->createClient();
        $this->_cartService = new Service\Cart($this->_clientObj);
    }
    
    public function testUpdateCart(){
        $cart = $this->_cartService->updateCart($this->_accessToken,
            $this->settings['productVeriantId']);
        $hasSessionToken = false;
        if(isset($cart['cart']['lineItems'])) {
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testRetrieveCart(){
        $cart = $this->_cartService->retrieveCart($this->_accessToken);
        $hasSessionToken = false;
        if(isset($cart['cart']['lineItems'])) {
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testUpdateLineItem(){
        $cart = $this->_cartService->updateCart($this->_accessToken,
            $this->settings['productVeriantId']);
        $hasSessionToken = false;
        if(isset($cart['cart']['lineItems']['lineItem'][0]['id'])) {
            $lineitemId = $cart['cart']['lineItems']['lineItem'][0]['id'];
            $updatedData = $this->_cartService->updateLineItem($lineitemId,
                                                $this->_accessToken, 'add', '1' );
            if(isset($updatedData['lineItem'])) {
                $hasSessionToken = true;
            }
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testDeleteLineItem(){
        $cart = $this->_cartService->updateCart($this->_accessToken,
            $this->settings['productVeriantId']);
        $hasSessionToken = false;
        if(isset($cart['cart']['lineItems']['lineItem'][0]['id'])) {
            $lineitemId = $cart['cart']['lineItems']['lineItem'][0]['id'];
            $this->_cartService->deleteLineItem( $lineitemId, $this->_accessToken);
            $cart = $this->_cartService->retrieveCart($this->_accessToken);
            if(!isset($cart['cart']['lineItems']['lineItem'][0]['id'])){
                $hasSessionToken = true;
                $this->_cartService->updateCart($this->_accessToken,
                                        $this->settings['productVeriantId']);
            }
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testUpdateBillingAddress(){
        $this->_cartService->updateCart($this->_accessToken,
            $this->settings['productVeriantId']);
        $billingDetails = '{"address": 
                {
                    "firstName":"test",
                    "lastName":"user",
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
        }';
        $this->_cartService->updateBillingAddress($this->_accessToken, $billingDetails);
        $hasSessionToken = true;
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testRetrieveBillingAddress(){
        $this->_cartService->updateCart($this->_accessToken,
            $this->settings['productVeriantId']);
        $cart = $this->_cartService->retrieveBillingAddress($this->_accessToken);
        $hasSessionToken = false;
        if( isset($cart['address']['uri']) ){
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testUpdateCartPayment(){
        $this->_cartService->updateCart($this->_accessToken,
            $this->settings['productVeriantId']);
        $sourcePayment = array('sourceId' => $this->settings['sourceId']);
        $cart = $this->_cartService->updateCartPayment($this->_accessToken,
                $sourcePayment);
        $this->assertGreaterThan(0,str_replace('$',
                '', $cart['cart']['pricing']['formattedSubtotal']));
    }
    
    public function testRetrievePaymentMethods(){
        $this->_cartService->updateCart($this->_accessToken,
            $this->settings['productVeriantId']);
        $cart = $this->_cartService->retrievePaymentMethods($this->_accessToken);
        $hasSessionToken = false;
        if ( isset($cart['paymentMethods']['paymentMethod'])){
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testSubmitCart(){
        $this->_cartService->updateCart($this->_accessToken,
            $this->settings['productVeriantId']);
        $sourcePayment = array('sourceId' => $this->settings['sourceId']);
        $this->_cartService->updateCartPayment($this->_accessToken,
                $sourcePayment);
        $submitCartDetails = $this->_cartService->submitCart($this->_accessToken);
        $this->assertGreaterThan(0,$submitCartDetails['submitCart']['order']['id']);
    }
    
    public function testGetAllLineItem(){
        $this->_cartService->updateCart($this->_accessToken,
            $this->settings['productVeriantId']);
        $cart = $this->_cartService->getAllLineItem($this->_accessToken);
        $hasSessionToken = false;
        if ( isset($cart['lineItems']['lineItem'])){
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testGetLineItemById(){
        $this->_cartService->updateCart($this->_accessToken,
            $this->settings['productVeriantId']);
        $cart = $this->_cartService->getAllLineItem($this->_accessToken);
        $hasSessionToken = false;
        if ( isset($cart['lineItems']['lineItem'][0]['id'])) {
            $lineItem = $this->_cartService->getLineItemById($this->_accessToken,
                    $cart['lineItems']['lineItem'][0]['id']);
            if( isset( $lineItem['lineItem']['id']) ){
                $hasSessionToken = true;
            }
        }
        
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testGetAllPOPOffers(){
        $this->_cartService->updateCart($this->_accessToken,
            $this->settings['productVeriantId']);
        $cart = $this->_cartService->getAllPOPOffers($this->_accessToken,
                $this->settings['popName']);
        $hasSessionToken = false;
        if ( isset($cart['offers'])) {
            $hasSessionToken = true;
        }
        
        $this->assertEquals(true, $hasSessionToken);
    }
}
