<?php
namespace Digitalriver\Service;

class Order extends \Digitalriver\Service {

    public function __construct(\Digitalriver\Client $client) {
        parent::__construct($client);
    }
    
    /**** 
     *  Retrieve a shopper order. 
     *  Provide Access Token , order id, order state
    */
    public function getOrder($orderId , $accessToken, $orderState = 'Open' ) {
        if( !$orderId || !$accessToken ) {
            throw new \Exception("Order Id or Access Token is missing");
        }
        $url = $this->client->getConfig()->get('orderUrl').$orderId.'?token='
            .$accessToken.'&expand=all&orderState='.$orderState;
        
        return  $this->getRequest($url);
    }
    
}