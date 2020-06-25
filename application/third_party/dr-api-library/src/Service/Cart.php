<?php
/* 
 * The Cart Class provides access to cart and cart data. 
 * This class perform all necessory action required for cart  
 * Use the Cart class to:
 *      Update Cart, Retrive Cart, Update Line items,
 *      
 * Version : 1.0
 * Date : 02/08/2019
 */
namespace Digitalriver\Service;

class Cart extends \Digitalriver\Service {
    public function __construct(\Digitalriver\Client $client) {
        parent::__construct($client);
    }

    /*
     * Updates an active cart with a product or coupon code. 
     * Provide product ID Digital River will add that product to the shopper's cart.
     */
    public function updateCart( $accessToken, $productId ) {
        if( !$accessToken || !$productId ) {
            throw new \Exception("Product or token information missing ");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active?productId='.
            $productId.'&token='.$accessToken.
                '&testOrder='.$this->client->getConfig()->get('testOrder').'&sendEmail=true';
        
        $form_data = array();
        
        $headers = array(
            'Accept' => 'application/json'
        );
        return  $this->postRequest($url, $form_data, $headers);
    }

    /****
     *  Retrieve the contents of an active cart. Accespt access token as input parameter 
    */
    
    public function retrieveCart( $accessToken, $queryParm = 'expand=all'  ) {
        if( !$accessToken ) {
            throw new \Exception("Token information is missing");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active?token='.$accessToken.
                '&testOrder='.$this->client->getConfig()->get('testOrder');
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }        
        return  $this->getRequest($url);
    }

    /*
     * Update and/or add product line-items to an active cart.
     *  Supply one or more product ID's or your system's product ID's 
     * (external reference ID) or update a line-item by providing the 
     *  corrisponding line-item ID
    */
    public function updateLineItem( $lineitemId, $accessToken, $action = 'update', 
            $qunatity = '1', $queryParm = null ) {
        if( !$lineitemId || !$accessToken ) {
            throw new \Exception("Line Item Id or Access Token is missing");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active/line-items/?productId='
                . $lineitemId.'&token='.$accessToken.'&action='.$action.'&quantity='.$qunatity.
                '&testOrder='.$this->client->getConfig()->get('testOrder').'&sendEmail=true';
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        $headers = array(
            'Accept' => 'application/json'
        );
        return $this->postRequest($url, array(), $headers);
    }

    /*
     * Deletes a specific cart line item. 
     * Provide the line-item ID 
    */
    public function deleteLineItem( $lineitemId, $accessToken ) {
        if( !$lineitemId || !$accessToken ) {
            throw new \Exception("Line Item Id or Access Token is missing");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active/line-items/'
                . $lineitemId.'?token='.$accessToken;
        $headers = array(
            'Accept' => 'application/json'
        );
        return  $this->deleteRequest($url, array(), $headers);
    }

    /*
     * Updates the billing address for a cart.
     * You can use this resource to override the default billing address on the cart. 
     * Provide the accessToken and billing details as input
    */
    public function updateBillingAddress( $accessToken, $billingDetails, $queryParm = null ) {
        if( !$billingDetails || !$accessToken ) {
            throw new \Exception("Billing Details or Access Token is missing");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active/billing-address/'
                .'?token='.$accessToken;
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        $headers = array(
            'accept' => 'application/json'
        );
        return  $this->putRequest($url, $billingDetails, $headers);
    }

    /****
     *  Retrieve a cart billing address. 
     *  Accespt access token as input parameter 
    */
    public function retrieveBillingAddress( $accessToken ) {
        if( !$accessToken ) {
            throw new \Exception("Token information is missing");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active/billing-address/'
                . '?token='.$accessToken;
        return  $this->getRequest($url);
    }

    /****
     *  Updates the payment method of a cart. 
     *  Supply a full access token as well as a payment method ID 
     *
    */
    public function updateCartPayment( $accessToken, $sourceId = array(), $queryParm = null ) {
        if( !$accessToken || !$sourceId ) {
            throw new \Exception("Access Token Or Payment ID is missing");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active/apply-payment-method?'
                .'token='.$accessToken.'&expand=all&format=json';
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        $jsonData = [ 'paymentMethod' => $sourceId ];
        $headers = json_encode(array(
            "accept: application/json",
            "content-type: application/json"
        ));
        return  $this->postJsonRequest($url, $jsonData ,$headers);
    }

    /*
     * Submit a cart and creates an order. 
     * Provide access token as input.
     */
    public function submitCart( $accessToken ) {
        if( !$accessToken  ) {
            throw new \Exception("Access Token is missing");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active/submit-cart?token='
                .$accessToken.'&expand=all&format=json&sendEmail=true';
        $headers = array(
            'Accept' => 'application/json'
        );
        return  $this->postRequest($url, array(), $headers);
    }

    /****
     *  Retrieve a cart payment Details 
     *  Accespt access token as input parameter 
    */
    public function retrievePaymentMethods( $accessToken = null ) {
        if( !$accessToken ) {
            throw new \Exception("Token information is missing");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active/payment-methods/'
                . '?token='.$accessToken;
        return  $this->getRequest($url);
    }

    /*
     * Attaches a shopper record to an active cart 
     * (sets payment method, billing and shipping address).. 
     * Accespt access token as input parameter
    */
    public function applyShopper( $accessToken , $queryParm = null, $oauthToken = null ) {
        if( !$accessToken) {
            throw new \Exception("Token information is missing");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active/apply-shopper?token='.
            $accessToken;
        
        $form_data = array();
        
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        $apiKeyToken = base64_encode($this->client->getConfig()->get('apiKey').':'
            .$this->client->getConfig()->get('secretKey'));
        
        $headers = [ 'Authorization' => 'Basic '.$apiKeyToken ];

        return  $this->postRequest($url, $form_data, $headers);
    }

    /**
     * Returns a list of all cart line-items.
     * Accept access token as input paramete
    */
     public function getAllLineItem( $accessToken = null ) {
        if( !$accessToken ) {
            throw new \Exception("Token information is missing");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active/line-items/'
                . '?token='.$accessToken;
        return  $this->getRequest($url);
    }

    /**
     * Retrieve a cart line-item.
     * Accept access token and line itemId as input paramete
    */
    public function getLineItemById( $accessToken, $lineItemId ) {
        if( !$accessToken || !$lineItemId) {
            throw new \Exception("Token or Line Item ID information is missing");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active/line-items/'.$lineItemId.'/'
                . '?token='.$accessToken;
        return  $this->getRequest($url);
    }

    /*
     * Returns a list of all offers for a specific cart POP.
     * Required Access Token,popName as input
    */
    public function getAllPOPOffers($accessToken, $popName, $queryParm= null) {
        if( !$accessToken || !$popName) {
            throw new \Exception("Token or POP Name information is missing");
        }
        
        $url = $this->client->getConfig()->get('cartUrl').'/active/point-of-promotions/'.$popName.'/offers'
            .'?apiKey='. $this->client->getConfig()->get('apiKey').'&token='.$accessToken;
       
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /****
     *  Retrieve a cart shipping address. 
     *  Accept access token as input parameter 
    */
    public function retrieveShippingAddress( $accessToken, $queryParm= null ) {
        if( !$accessToken ) {
            throw new \Exception("Token information is missing");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active/shipping-address/'
            . '?token='.$accessToken;
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }

        return  $this->getRequest($url);
    }
    
    /****
     * Returns a list of all available shipping options for a cart.
     * Accept access token as input parameter 
    */
    public function getAllShippingOptions( $accessToken, $queryParm= null ) {
        if( !$accessToken ) {
            throw new \Exception("Token information is missing");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active/shipping-options/'
            . '?token='.$accessToken;
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /***
     *  Retrieve a specific cart shipping option.
     *  Accepts access_token and shipping option id as input 
    */
    
    public function getShippingOptionById ( $accessToken, $shippingId, $queryParm= null ) {
        if ( !$accessToken || !$shippingId ) {
            throw new \Exception("Token or Shipping Id information is missing");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active/shipping-options/'.$shippingId.''
                . '?token='.$accessToken;
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /***
     * Updates the cart shipping option. 
     * Accepts Shipping Option ID and Access Token as input
    */
    public function applyShippingOption ( $accessToken, $shippingId, $queryParm= null ) {
        if ( !$accessToken || !$shippingId ) {
            throw new \Exception("Token or Shipping Id information is missing");
        }
        $url = $this->client->getConfig()->get('cartUrl').'/active/apply-shipping-option/'
                . '?token='.$accessToken.'&shippingOptionId='.$shippingId;
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        $headers = array(
            'Accept' => 'application/json'
        );
        return  $this->postRequest($url, array(), $headers);
    }
    
    /***
     * Redirects a shopper to a Global Commerce hosted checkout experience in order 
     * to collect PCI sensitive shopper data and to complete the checkout process. 
     * Accepts Access Token as input
    */
    public function webCheckout( $accessToken,  $queryParm= null ) {
         if ( !$accessToken ) {
             throw new \Exception("Token information is missing");
         }
         $url = $this->client->getConfig()->get('cartUrl').'/active/web-checkout/'
                 . '?token='.$accessToken;
         if ( $queryParm ) {
             $url .= '&'.$queryParm;
         }

         return  $this->getRequest($url);
    }
    
    /***
     * Gets all tax regitrations data to the customer's cart.
     * Accepts Accss Token  and cartId as input
    */
    public function getTaxRegistration( $accessToken, $cartId ) {
        if ( !$cartId || !$accessToken) {
            throw new \Exception("Access Token or Cart Id is missing");
        }
        $url = $this->client->getConfig()->get('cartTaxUrl').$cartId.'/tax-registrations/'
                . '?token='.$accessToken;
         
        return  $this->getRequest($url);
    }
    
    /***
     *  Gets JSON schema for tax-registrations
     *  Accepts Access Token, cartId and x-siteid as input
    */
    public function getTaxRegistrationJson( $accessToken, $cartId, $xSiteId ) {
        if ( !$cartId || !$accessToken || !$xSiteId ) {
            throw new \Exception("Access Token, Cart Id pr X-SiteId is missing");
        }
        $url = $this->client->getConfig()->get('cartTaxUrl').$cartId.'/tax-registrations/schema'
                . '?token='.$accessToken;
         
        $headers = [ 'x-siteid' => $xSiteId ];
        return  $this->getRequest($url, $headers);
    }
    
    /* 
     * Updates the tax regitrations data to the customer's cart.
     * Required Cart Id and Tax Registration array as input 
    */
    public function updateTaxRegistration( $cartId, $taxRegistration) {
        if ( !$cartId || !$taxRegistration) {
            throw new \Exception("Cart ID and Tax Registration Details Missing");
        }
        $url = $this->client->getConfig()->get('cartTaxUrl').$cartId.'/tax-registrations';
        $jsonData = [ 'customerType' => $taxRegistration ];
        $headers = array(
            'Content-Type' => 'application/json'
        );
        
        return  $this->postJsonRequest($url, $jsonData, $headers); 
    }
}
