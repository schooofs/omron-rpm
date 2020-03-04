<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shoppers extends CI_Controller {
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
    
    public function createShopper() {
        $this->load->library('session');
        $formData = $this->input->post('formData', TRUE);
        $sourceId = $this->input->post('sourceId', TRUE);
        $cardDetails = $this->input->post('card_details', TRUE);
        $accessToken = $this->input->post('access_token', TRUE);
        $drSessionToken = $this->input->post('dr_session_token', TRUE);
        $editCart = $this->input->post('edit_cart', TRUE);
        $shopperService =  new Digitalriver\Service\Shopper($this->_client);
        $authService =  new Digitalriver\Service\Authenticate($this->_client);
        $cartService =  new Digitalriver\Service\Cart($this->_client);
        
        $postDataArray = array();
        foreach(explode('&', $formData) as $value) {
            $value1 = explode('=', $value);
            $postDataArray[$value1[0]] = $value1[1];
        }
        $userDetails = array (
            'externalReferenceId' => $postDataArray['email'],
            'username' => $postDataArray['email'],
            'password' => base64_encode($postDataArray['password']),
            'emailAddress' => $postDataArray['email'],
            'firstName' => $postDataArray['firstName'],
            'lastName' => $postDataArray['lastName'],
            'locale' => 'en_US',
            'currency'=> 'USD'
        );
        $billingDetails =  array(
            "nickName" => 'Default Address',
            "isDefault"=> "true",
            "firstName"=> $postDataArray['firstName'],
            "lastName"=> $postDataArray['lastName'],
            "line1"=> $postDataArray['address1'],
            "line2"=> $postDataArray['address2'],
            "city"=> $postDataArray['city'],
            "country"=> 'US',
            "postalCode"=> $postDataArray['zip'],
            "countryName"=> $postDataArray['country'],
            "phoneNumber"=> $postDataArray['phoneNum']
        );
        try {
            if ( $editCart == 0 ) { 
                $shopperService->createShopper( $userDetails );
            }
            
            $getFullAccessToken = $authService->getFullAccessToken(
                    $postDataArray['email'], $postDataArray['password'], $drSessionToken);
            
            // Set shoppers billing address
            $shopperAddress = $shopperService->updateShopperAddress(
                $getFullAccessToken['access_token'], $billingDetails );
            
            $billingAddressArray = $shopperService->getShopperAddress($getFullAccessToken['access_token']);
            $billingID = $billingAddressArray['addresses']['address'][0]['id'];
            // Create shopper payment
            $paymentDetails = array(
                "nickName"  => 'Default Payment',
                "isDefault" => 'true',
                "sourceId"  => $sourceId 
            );
            
            if ( $editCart == 0 ) { 
            $shopperService->updateShopperPayment(
                $getFullAccessToken['access_token'], $paymentDetails );
            }
            
            $shopperPaymentArray = $shopperService->getShopperPayments($getFullAccessToken['access_token']);
            $paymentID = $shopperPaymentArray['paymentOptions']['paymentOption'][0]['id'];
            
            // Apply shopper to cart
            $activeCart = $cartService->applyShopper( $getFullAccessToken['access_token']);
            $response['activeCart'] = $cartService->retrieveCart( $accessToken );
            $response['cardDetails'] = $cardDetails;
            $response_html = $this->load->view('review_order',$response, TRUE);
            $data['review_order'] = $response_html;
            
            // Set shoppers session
            $this->session->set_userdata(
                'access_token', $getFullAccessToken['access_token']
            );
            $this->session->set_userdata(
                'dr_session_token', $drSessionToken
            );
            $this->session->set_userdata(
                'user_login', $postDataArray['email']
            );
            
            $data['fullAccessToken'] = $getFullAccessToken['access_token'];
            $data['status'] = 'ok';            
        } catch ( Exception  $e) {;
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            $data['status'] = 'error';
            $data['error_response'] = $responseBodyAsString->errors->error[0]->description;
        }
        
        echo json_encode( $data );
    }
    
    public function login() {
        $this->load->library('session');
        $formData = $this->input->post('formData', TRUE);
        $drSessionToken = $this->input->post('dr_session_token', TRUE);
        $postDataArray = array();
        foreach(explode('&', $formData) as $value) {
            $value1 = explode('=', $value);
            $postDataArray[$value1[0]] = $value1[1];
        }
        
        $authService =  new Digitalriver\Service\Authenticate($this->_client);
        $shopperService =  new Digitalriver\Service\Shopper($this->_client);
        $cartService =  new Digitalriver\Service\Cart($this->_client);
        
        try {
            $getFullAccessToken = $authService->getFullAccessToken(
                    $postDataArray['user_email'], $postDataArray['user_pass'], $drSessionToken);
            
            // Set shoppers session
            $this->session->set_userdata(
                'access_token', $getFullAccessToken['access_token']
            );
             $this->session->set_userdata(
                'dr_session_token', $drSessionToken
            );
            $this->session->set_userdata(
                'user_login', $postDataArray['user_email']
            );
             
            // Get the shoppers addresses
            $getShoopperAddress = $shopperService->getShopperAddress($getFullAccessToken['access_token']);
            if ( isset($getShoopperAddress['addresses']['address']) ) {
                $data['shoppersAddresses'] =  $getShoopperAddress['addresses']['address'];
            } else {
                $data['shoppersAddresses'] = 'set_new';
            }
            
            $shopperPaymentArray = $shopperService->getShopperPayments($getFullAccessToken['access_token']);
            if ( isset($shopperPaymentArray['paymentOptions']['paymentOption']) ) {
                $data['shoppersPayment'] =  $shopperPaymentArray['paymentOptions']['paymentOption'];
            } else {
                $data['shoppersPayment'] = 'set_new';
            }
            
            $data['status'] = 'ok';
            $data['fullAccessToken'] = $getFullAccessToken['access_token'];
            
        } catch (Exception $ex) {
            $response = $ex->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            $data['status'] = 'error';
            $data['error_response'] = $responseBodyAsString->error_description;
        }
        
        echo json_encode( $data );
    }
    
    public function updateDetails(){
        $accessToken = $this->input->post('access_token', TRUE);
        $addressDetails = $this->input->post('address_details', TRUE);
        $sourceId = $this->input->post('sourceId', TRUE);
        $nickName = $this->input->post('paymentNickName', TRUE);
        $paymentId = $this->input->post('paymentId', TRUE);
        $cardDetails = $this->input->post('card_details', TRUE);
        $shopperService =  new Digitalriver\Service\Shopper($this->_client);
        $cartService =  new Digitalriver\Service\Cart($this->_client);
        
        $billingId = 0;
        if ( !$addressDetails && !$accessToken ) {
            $data['error'] = 'BillingDetails Or Access Token is Missing';
        } else {
            $address = json_decode($addressDetails, true);
            try {
                $shopperService->updateShopperAddress(
                $accessToken, $address );
                
                if ( $sourceId != '0') { 
                    $paymentDetails = array(
                        "nickName"  => $nickName,
                        "isDefault" => 'true',
                        "sourceId"  => $sourceId 
                    );
                    $shopperService->updateShopperPayment($accessToken, $paymentDetails);
                    
                    $shopperPaymentArray = $shopperService->getShopperPayments($accessToken);
                    foreach ( $shopperPaymentArray['paymentOptions']['paymentOption'] as $paymentArray ) {
                        if ( $paymentArray['nickName'] == $nickName ) {
                            $paymentId = $paymentArray['id'];
                        }
                    }
                    $paymentID = $shopperPaymentArray['paymentOptions']['paymentOption'][0]['id'];
                }
                
                $getShoopperAddress = $shopperService->getShopperAddress($accessToken);
                foreach ( $getShoopperAddress['addresses']['address'] as $addressArray ){
                    if ( $addressArray['nickName'] == $address['nickName'] ) {
                        $billingId = $addressArray['id'];
                    }
                }
                
                 // Apply shopper to cart
                $activeCart = $cartService->applyShopper( $accessToken, 
                        'billingAddressId='.$billingId.'&paymentOptionId='.$paymentId);
                
                $response['activeCart'] = $cartService->retrieveCart( $accessToken );
                $response['cardDetails'] = $cardDetails;
                $response_html = $this->load->view('review_order',$response, TRUE);
                $data['review_order'] = $response_html;
            
                $data['status'] = 'ok';
            } catch (Exception $ex) {
                $response = $ex->getResponse();
                $responseBodyAsString = json_decode($response->getBody()->getContents());
                $data['status'] = 'error';
                $data['error_response'] = $responseBodyAsString;
            }
        }
        
        echo json_encode( $data );
    }
    
    
    public function logout(){
        $this->load->library('session');
        $this->session->sess_destroy();
        redirect('home/index');
    }
    
    
}
