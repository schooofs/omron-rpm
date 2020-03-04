<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
    private  $_client;
    public function __construct() {
        parent::__construct();
        $this->_client = new Digitalriver\Client();
        $this->_client->setApplicationName($this->config->item('application_name'));
        $this->_client->setSiteId($this->config->item('site_id'));
        $this->_client->setApiKey($this->config->item('api_key'));
        $this->_client->setApiVersion($this->config->item('api_version'));
        $this->_client->setEnvironment($this->config->item('environment'));
        $this->_client->setTestOrder($this->config->item('test_order'));
        $this->_client->setPrivateApiKey($this->config->item('privateApiKey'));
        $this->_client->setSecretKey($this->config->item('secretKey'));
    }
    
    public function products() {
        // Get the product id from 
        $this->load->library('session');
        $categoryID = $this->input->get('id', TRUE);
        $data['category_id'] = $categoryID;
        
        $categoryService =  new Digitalriver\Service\Category($this->_client);
        $offerService =  new Digitalriver\Service\Offer($this->_client);

        $data['category'] = $categoryService->retrieveCategoryById($categoryID);
        $offerIdsArray = $this->config->item('category_page_offer');
        if ( isset($offerIdsArray[trim($data['category']['category']['displayName'])])) {
            $offer = $offerService->getOffer($offerIdsArray[trim($data['category']
                                        ['category']['displayName'])]);
            $data['offer'] = $offer['offer'];
        } else {
           $data['offer'] = '';
        }
        $productDetails = $categoryService->listProductsByCategoryId($categoryID);
        $data['products'] = $productDetails['products']['product'];
        $data['header']['categories'] = $this->headerData();
        $this->load->view('category_page', $data);
    }
    
    private function headerData() {
        $categoryService = new Digitalriver\Service\Category($this->_client);
        $allCategories = $categoryService->listAllCategories();
        
        return $allCategories['categories']['category'];
    }
}
