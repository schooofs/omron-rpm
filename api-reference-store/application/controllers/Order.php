<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {
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
    
    public function thankYou() {
        // Get the product id from 
        $this->load->library('session');
        $orderID = $this->input->get('order_id', TRUE);
        $data['orderID'] = $orderID;
        $orderService =  new Digitalriver\Service\Order($this->_client);
        
        if ( $this->session->userdata( 'access_token' ) == '' ) {
            throw new \Exception("Access token not found");
        } else {
            $data['access_token'] = $this->session->userdata( 'access_token' );
            try {
                $data['orderDetails'] = $orderService->getOrder($orderID,
                $this->session->userdata( 'access_token' ));
            }catch (Exception $ex) {
                $response = $ex->getResponse();
                $responseBodyAsString = json_decode($response->getBody()->getContents());
                var_dump($responseBodyAsString);
                die();
            }
        }
        
        $data['header']['categories'] = $this->headerData();
        $this->load->view('thankyou_page', $data);
    }
    
    private function headerData() {
        $categoryService = new Digitalriver\Service\Category($this->_client);
        $allCategories = $categoryService->listAllCategories();
        
        return $allCategories['categories']['category'];
    }
}
