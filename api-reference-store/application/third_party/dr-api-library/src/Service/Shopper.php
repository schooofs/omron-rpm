<?php
namespace Digitalriver\Service;
/***
 * The Shoppers API provides access to the current shopper and shopper data. Use 
 * the Shoppers API to retrieve shopper information and to set the shopper preferred 
 * locale and currency. After you get an access token, you can use the POST 
 * shoppers/me method to update the shopper to immediately use the specified locale 
 * and currency for that shopper. All subsequent API calls are done in the context 
 * of that locale and currency for that shopper.
 * 
 * Version : 1.0
 * Date : 09/09/2019
 *  
*/
class Shopper extends \Digitalriver\Service {
   
    public function __construct(\Digitalriver\Client $client) {
        parent::__construct($client);
    }

    public function getShopperToken() {
        $url = $this->client->getConfig()->get('shoppersUrl') . '/token?apiKey='. $this->client->getConfig()->get('apiKey');
        return  $this->getRequest($url);
    }
    /* 
     * Creates a shopper record
     * Required Access Token and user field array as input 
    */
    public function createShopper( $userDetails = array()) {
        if ( !$userDetails ) {
            throw new \Exception("Shopper Details Missing");
        }
        $url = $this->client->getConfig()->get('shoppersUrl').'?apiKey='.$this->client->getConfig()->get('apiKey').'&format=json';
        $jsonData = [ 'shopper' => $userDetails ];
        $headers = array(
            'Content-Type' => 'application/json'
        );
        return  $this->postJsonRequest($url, $jsonData, $headers); 
    }
    
    /* 
     * Retrieve the current (annonymous and authenticated) shopper and shopper data.
     * Required Authorized token for a shopper
    */
    public function getShopperData( $accessToken, $queryParm = null) {
        if ( !$accessToken ) {
            throw new \Exception("Access Token is missing");
        }
        $url = $this->client->getConfig()->get('shoppersUrl').'/me?token='.
                $accessToken.'&expand=all';
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        $apiKeyToken = base64_encode($this->client->getConfig()->get('privateApiKey').':'
            .$this->client->getConfig()->get('secretKey'));
        
        $headers = [ 'Authorization' => 'Basic '.$apiKeyToken ];
        return  $this->getRequest($url, $headers);
    }
    
    /* 
     * Create/Update shoppers address.
     * Required Authorized token and billing address of shopper
    */
    public function updateShopperAddress( $accessToken, $billingAddress) {
        if ( !$accessToken ) {
            throw new \Exception("Access Token is missing");
        }
        $url = $this->client->getConfig()->get('shoppersUrl').'/me/addresses?token='.
                $accessToken.'&expand=all';
        
        $headers = [ 'Content-Type' => 'application/json' ];
       
        $jsonData = [ 'address' => $billingAddress ];
        $headers = array(
            'Content-Type' => 'application/json'
        );
        return  $this->postJsonRequest($url, $jsonData, $headers); 
    }
    
    /* 
     * Retrieve the current shopper address.
     * Required Authorized token for a shopper
    */
    public function getShopperAddress( $accessToken, $queryParm=null ) {
        if ( !$accessToken ) {
            throw new \Exception("Access Token is missing");
        }
        $url = $this->client->getConfig()->get('shoppersUrl').'/me/addresses?token='.
                $accessToken.'&expand=all';
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        $apiKeyToken = base64_encode($this->client->getConfig()->get('privateApiKey').':'
            .$this->client->getConfig()->get('secretKey'));
        
        $headers = [ 'Authorization' => 'Basic '.$apiKeyToken ];
        return  $this->getRequest($url, $headers);
    }
    
    /* 
     * Create shoppers payments
     * Required Authorized token and payload array
    */
    public function updateShopperPayment( $accessToken, $payLoad) {
        if ( !$accessToken ) {
            throw new \Exception("Access Token is missing");
        }
        $url = $this->client->getConfig()->get('shoppersUrl').'/me/payment-options?token='.
                $accessToken.'&expand=all';
        
        $headers = [ 'Content-Type' => 'application/json' ];
       
        $jsonData = [ 'paymentOption' => $payLoad ];
        
        $headers = array(
            'Content-Type' => 'application/json'
        );
        return  $this->postJsonRequest($url, $jsonData, $headers); 
    }
    
    /* 
     * Retrieve the shopper's payment options
     * Required Authorized token for a shopper
    */
    public function getShopperPayments( $accessToken, $queryParm=null ) {
        if ( !$accessToken ) {
            throw new \Exception("Access Token is missing");
        }
        $url = $this->client->getConfig()->get('shoppersUrl').'/me/payment-options?token='.
                $accessToken.'&expand=all';
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        $apiKeyToken = base64_encode($this->client->getConfig()->get('privateApiKey').':'
            .$this->client->getConfig()->get('secretKey'));
        
        $headers = [ 'Authorization' => 'Basic '.$apiKeyToken ];
        
        return  $this->getRequest($url, $headers);
    }
    
    /***
     * Updates shopper information for the current shopper.
     * 
     * Required access token and update parameter array as input  
    */
    public function updateShopper( $accessToken, $updateParam, $queryParm=null ){
        if ( !$accessToken || !$updateParam ) {
            throw new \Exception("Access Token or Update Parameter is missing");
        }
        $url = $this->client->getConfig()->get('shoppersUrl').'/me?token='.
                $accessToken.'&expand=all';
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        $jsonData = [ 'shopper' => $updateParam ];
        $headers = array(
            'Content-Type' => 'application/json'
        );
        return  $this->postJsonRequest($url, $jsonData, $headers);  
    } 
    
    /***
     * Allows shoppers to manage their account information.
     * The Account API is only available for authenticated sessions. If an authenticated 
     * shopper has an account in Global Commerce, the shopper can configure their 
     * account to have a billing and shipping address and a payment option. 
     *
     *  Required access token as input parameter 
    */   
    public function getShopperAccount( $accessToken, $redirectUri=null ) {
        if ( !$accessToken ) {
            throw new \Exception("Access Token is missing");
        }
        $url = $this->client->getConfig()->get('shoppersUrl').'/me/account?token='.
            $accessToken;
        
        if ( $redirectUri ) {
            $url .= '&redirect_uri='.$redirectUri;
        }
        
        return  $this->getRequest($url);
    }
    
    /***
     * Retrieve an address book record.
     * 
     * Required access token and address id as input parameter 
    */
    public function getAddressById ($accessToken, $addressId, $queryParm=null) {
        if ( !$accessToken || !$addressId) {
            throw new \Exception("Access Token or Address ID is missing");
        }
        $url = $this->client->getConfig()->get('shoppersUrl').'/me/addresses/'.$addressId.'?token='.
                $accessToken;
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /***
     * Delete an address
     * 
     * Required access token and address id as input parameter
    */
    public function deleteShopperAddress($accessToken, $addressId){
        if ( !$accessToken || !$addressId) {
            throw new \Exception("Access Token or Address ID is missing");
        }
        $url = $this->client->getConfig()->get('shoppersUrl').'/me/addresses/'.$addressId.'?token='.
                $accessToken;
        
        $headers = array(
            'Accept' => 'application/json'
        );
        return  $this->deleteRequest($url, array(), $headers);
    }
    
    /***
     * Retrieves the detail of a saved payment record.
     * 
     * Required paymentOptionId and access token as input 
    */
    public function getPaymentOptionById($accessToken, $paymentOptionId, $queryParm=null){
        if ( !$accessToken || !$paymentOptionId) {
            throw new \Exception("Access Token or Payment Option ID is missing");
        }
        $url = $this->client->getConfig()->get('shoppersUrl').'/me/payment-options/'.$paymentOptionId
                . '?token='.$accessToken;
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /***
     * Get a customer tax registration details.
     * 
     * Required Customer ID as input 
    */
    public function getCustomerTax( $customerId, $queryParm=null){
        if ( !$customerId) {
            throw new \Exception("Customer ID is missing");
        }
        $url = $this->client->getConfig()->get('customerUrl').$customerId.'/tax-registration';
        if ( $queryParm ) {
            $url .= '?'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /* 
     * Creates or updates a customer tax registration record.
     * 
     * Required Customer Id and TaxPayLoad as input 
    */
    public function updateTaxRegistration( $customerId, $taxPayLoad, $queryParm=null) {
        if ( !$customerId || !$taxRegistration) {
            throw new \Exception("Cart ID and Tax Registration Details Missing");
        }
        $url = $this->client->getConfig()->get('cartTaxUrl').$customerId.'/tax-registration';
        if ( $queryParm ) {
            $url .= '?'.$queryParm;
        }
        $jsonData = [ 'tax' => $taxPayLoad ];
        $headers = array(
            'Content-Type' => 'application/json'
        );
        
        return  $this->postJsonRequest($url, $jsonData, $headers); 
    }
}