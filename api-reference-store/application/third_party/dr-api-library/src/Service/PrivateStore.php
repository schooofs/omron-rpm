<?php
/* 
 * The Purchase Plan API (also called Private Store) provides the functionality 
 *  behind API-driven private stores.
 * A private store is an online store that caters exclusively to a known group of 
 *  customers. The private store offers a custom shopping experience with special
 *  discounts or merchandising offers. The site owner, who has a Private Store 
 *  Manager role in Global Commerce, configures private stores at the site level.
 * Private stores allow sites to target segmented shoppers, called a target market.
 *  Sites can deploy, rotate, and retire private stores to suit current product 
 *  marketing trends.
 * 
 * Version : 1.0
 * Date : 10/09/2019
 */
namespace Digitalriver\Service;

class PrivateStore extends \Digitalriver\Service {

    public function __construct(\Digitalriver\Client $client) {
        parent::__construct($client);
    }
    
    /****
     *  Retrieve a shopper specific private store. 
     *  
     *  Required access token as input
    */
    public function getPrivateStore($accessToken, $queryParm = null ) {
        if( !$accessToken ) {
            throw new \Exception("Access Token is missing");
        }   
        $url = $this->client->getConfig()->get('PrivateStoreUrl')
                .'/?token='.$accessToken;
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /****
     *  Returns a list of private stores via search parameters
     *  
     *  Required access token as input
    */
    public function listPrivateStores($accessToken, $queryParm = null ) {
        if( !$accessToken ) {
            throw new \Exception("Access Token is missing");
        }
        $url = $this->client->getConfig()->get('PrivateStoreUrl')
                .'/search/?token='.$accessToken;
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /* 
     * Authorize a shopper into the private store
     * 
     * Required Access Token and purchasePlanAuthorize PayLoad as input 
    */
    public function authorizeShopper( $accessToken, $purchasePlanAuthorize, $queryParm=null) {
        if ( !$accessToken || !$purchasePlanAuthorize) {
            throw new \Exception("Access Token or Purchase Plan Authorize Missing");
        }
        $url = $this->client->getConfig()->get('PrivateStoreUrl')
                .'/authorize/?token='.$accessToken;
        if ( $queryParm ) {
            $url .= '?'.$queryParm;
        }
        $jsonData = [ 'purchasePlanAuthorize' => $purchasePlanAuthorize ];
        $headers = array(
            'Content-Type' => 'application/json'
        );
        
        return  $this->postJsonRequest($url, $jsonData, $headers); 
    }
}