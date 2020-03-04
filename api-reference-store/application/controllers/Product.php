<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
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
    
    public function showProduct() {
        $this->load->library('session');
        if ( $this->session->userdata( 'access_token' ) != '' ) {
            $data['user_login'] = true;
        }
        $productId = $this->input->get('productId', TRUE);
        
        // Loading product library functions for get product details
        $products_service =  new Digitalriver\Service\Products($this->_client);
        $offerService =  new Digitalriver\Service\Offer($this->_client);
        
        $data['header']['categories'] = $this->headerData();
        $data['product'] = $products_service->getProductByID($productId);
        
        $offerDetails = $offerService->getOffer($this->config->item('recommonded_prod'));
        $data['product']['offers'] = (isset($offerDetails['offer']['productOffers']['productOffer'])? 
            $offerDetails['offer']['productOffers']['productOffer'] : '');
        
        $this->load->view('product_page', $data);
    }
    
    private function headerData() {
        $categoryService = new Digitalriver\Service\Category($this->_client);
        $allCategories = $categoryService->listAllCategories();
        
        return $allCategories['categories']['category'];
    }
}
