<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Controller {
    private  $_client;
    public function __construct() {
        parent::__construct();
        $this->_client = new Digitalriver\Client();
        $this->_client->setApplicationName($this->config->item('application_name'));
        $this->_client->setSiteId($this->config->item('site_id'));
        $this->_client->setApiKey($this->config->item('api_key'));
        $this->_client->setApiVersion($this->config->item('api_version'));
        $this->_client->setEnvironment($this->config->item('environment'));
        $this->_client->setPrivateApiKey($this->config->item('privateApiKey'));
        $this->_client->setSecretKey($this->config->item('secretKey'));
    }
    
    public function reviewOrder() {
        
        $shopperService =  new Digitalriver\Service\Shopper($this->_client);
        $cartService =  new Digitalriver\Service\Cart($this->_client);
        
        $authdata = $shopperService->getShopperToken();
        echo $authdata['access_token'];
        if ( !isset($authdata['access_token'])) {
            throw new \Exception("Access token not found");
        } else { 
            $data['access_token'] = $authdata['access_token'];
            $data['active_cart'] = $cartService->retrieveCart($authdata['access_token']);
        }
        echo '<pre>';
        var_dump($data['active_cart']);
        die();
        $this->load->view('cart_page', $data);
    }
   
}
