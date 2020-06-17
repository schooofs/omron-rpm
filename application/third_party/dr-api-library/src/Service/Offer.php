<?php
/* 
 * An offer is a promotion or discount intended to entice shoppers to purchase 
 * from a store. The Offers API provides access to offers.
 * Use the Offers API to get a specific offer by its identifier or retrieve all 
 * offers for a shopper, product, or cart.
 * Version : 1.0
 * Date : 19/08/2019
 */
namespace Digitalriver\Service;

class Offer extends \Digitalriver\Service {

    public function __construct(\Digitalriver\Client $client) {
        parent::__construct($client);
    }
    
    /****
     *  Retrieve the detail of an offer. 
     *  Required Offer ID
    */
    public function getOffer( $offerId, $queryParm = null ) {
        if( !$offerId ) {
            throw new \Exception("Product id or POPName is missing");
        }
        
        $url = $this->client->getConfig()->get('offerUrl').$offerId
                .'/?apiKey='.$this->client->getConfig()->get('apiKey');
        
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /****
     *  Returns a list of categories for an offer. 
     *  Required Offer ID
     */
    public function getCategoryOffers($offerId, $queryParm = null) {
        if (!$offerId) {
            throw new \Exception("Product id or POPName is missing");
        }

        $url = $this->client->getConfig()->get('offerUrl') . $offerId
                . '/category-offers/?apiKey=' . $this->client->getConfig()->get('apiKey');

        if ($queryParm) {
            $url .= '&' . $queryParm;
        }

        return $this->getRequest($url);
    }
    
    /****
     *  Returns a list of products that apply to an offer. 
     *  Required Offer ID
    */
    public function getProductOffers($offerId, $queryParm = null) {
        if (!$offerId) {
            throw new \Exception("Product id or POPName is missing");
        }

        $url = $this->client->getConfig()->get('offerUrl') . $offerId
                . '/product-offers/?apiKey=' . $this->client->getConfig()->get('apiKey');

        if ($queryParm) {
            $url .= '&' . $queryParm;
        }

        return $this->getRequest($url);
    }

}