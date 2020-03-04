<?php
/* 
 * The Promotion Class provides access to promotion and promotion data. 
 * This class perform all necessory action required for promotion
 *      
 * Version : 1.0
 * Date : 09/09/2019
 */
namespace Digitalriver\Service;

class Promotion extends \Digitalriver\Service {
    public function __construct(\Digitalriver\Client $client) {
        parent::__construct($client);
    }
    
    /***
     * Returns a list of shopper specific Point of Promotions. This method will 
     * only return the following offer types: custom bundle, banner, default, 
     * feature products, and bundles
     * 
     * Required access token as input parameter
    */
    public function getPOPList($accessToken, $queryParm= null) {
        if ( !$accessToken ) {
            throw new \Exception("Token information is missing");
        }        
        $url = $this->client->getConfig()->get('promotionUrl')
            . '?apiKey='.$this->client->getConfig()->get('apiKey').'&token='.$accessToken;
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /***
     *  Retrieve a shopper specific Point of Promotion. This method will only return 
     * the following offer types: custom bundle, banner, default, feature products, 
     * and bundles.
     * 
     * Required access token and popName as input parameters
    */
    public function getPOPByName($accessToken, $popName, $queryParm= null) {
        if ( !$accessToken || !$popName ) {
            throw new \Exception("Token or POP Name information is missing");
        }
        $url = $this->client->getConfig()->get('promotionUrl').$popName.
            '?apiKey='.$this->client->getConfig()->get('apiKey').'&token='.$accessToken;
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /***
     * Get a specific Point of Promotion (POP) offers.
     * 
     * Required access token and popName as input parameters
    */
    
    public function getPOPOffers($accessToken, $popName, $queryParm= null) {
        if ( !$accessToken || !$popName ) {
            throw new \Exception("Token or POP Name information is missing");
        }
        $url = $this->client->getConfig()->get('promotionUrl').$popName.'/offers'.
            '?apiKey='.$this->client->getConfig()->get('apiKey').'&token='.$accessToken;
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
}
