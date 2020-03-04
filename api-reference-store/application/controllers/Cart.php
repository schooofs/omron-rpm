<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {
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
    
    public function activeCart() {
        // Get the product id from 
        $this->load->library('session');
        $productID = $this->input->get('productId', TRUE);
        $data['product_id'] = $productID;
        $shopperService =  new Digitalriver\Service\Shopper($this->_client);
        $cartService =  new Digitalriver\Service\Cart($this->_client);
        $authService =  new Digitalriver\Service\Authenticate($this->_client);
        $this->load->library('session');
        if ( $this->session->userdata( 'access_token' ) != '' ){
            $data['user_login'] = $this->session->userdata( 'user_login' );
        }
        if ( $this->session->userdata( 'access_token' ) != '' && 
            $this->session->userdata( 'dr_session_token') != '' && false ) {
            $authDrData['session_token'] = $this->session->userdata( 'dr_session_token') ;
            $authdata['access_token'] = $this->session->userdata( 'access_token') ;
        }else { 
            $authDrData = $authService->getDrSessionToken();
            $authdata = $authService->getLimitedOauthToken($authDrData['session_token']);
        }
        if ( !isset($authdata['access_token'])) {
            throw new \Exception("Access token not found");
        } else {
            $data['dr_session_token'] = $authDrData['session_token'];
            $data['access_token'] = $authdata['access_token'];
            $this->session->set_userdata(
                'access_token', $authdata['access_token'] 
            );
            $data['active_cart'] = $cartService->updateCart($authdata['access_token'], $productID);
        }
        $data['header']['categories'] = $this->headerData();
        $this->load->view('cart_page', $data);
    }
    
    public function updateLineItem() {
        $lineitemId = $this->input->post('lineitem_id', TRUE);
        $accessToken = $this->input->post('access_token', TRUE);
        $action = $this->input->post('action', TRUE);
        $qty = $this->input->post('qty', TRUE);
        $productID = $this->input->post('product_id', TRUE);
        if ( !$lineitemId && $accessToken ) {
            $data['error'] = 'Lineitem Or Access Token is Missing';
        } else {
            $data['product_id'] = $productID;
            $data['lineitem_id'] = $lineitemId;
            
            $cartService =  new Digitalriver\Service\Cart($this->_client);
            $cartService->updateLineItem( $lineitemId,$accessToken,$action, $qty);
            $activeCart = $cartService->retrieveCart($accessToken);
            foreach ( $activeCart['cart']['lineItems']['lineItem'] as $lineItem ) {
                if ( $lineitemId == $lineItem['id']  ) {
                    $data['lineitem_price'] = $lineItem['pricing']['formattedSalePriceWithQuantity'];
                    break;
                }
            }
            $data['subtotal'] = $activeCart['cart']['pricing']['formattedSubtotal'];
            $data['shipping_charges'] = $activeCart['cart']['pricing']['formattedShippingAndHandling'];
        }
        echo json_encode($data);
    }
    
    public function removeLineItem() {
        $lineitemId = $this->input->post('lineitem_id', TRUE);
        $accessToken = $this->input->post('access_token', TRUE);
        if ( !$lineitemId && $accessToken ) {
            $data['error'] = 'Lineitem Or Access Token is Missing';
        } else {
            $data['lineitem_id'] = $lineitemId;
           
            $cartService =  new Digitalriver\Service\Cart($this->_client);
            $cartService->deleteLineItem( $lineitemId,$accessToken);
            $activeCart = $cartService->retrieveCart($accessToken);
            if ( !isset($activeCart['cart']['lineItems']['lineItem']) ) {
                $data['lineitem_count'] = 0; 
            } else {
                $data['lineitem_count'] = count($activeCart['cart']['lineItems']['lineItem']);
                foreach ( $activeCart['cart']['lineItems']['lineItem'] as $lineItem ) {
                    if ( $lineitemId == $lineItem['id']  ) {
                        $data['lineitem_price'] = $lineItem['pricing']['formattedSalePriceWithQuantity'];
                        break;
                    }
                }
                $data['subtotal'] = $activeCart['cart']['pricing']['formattedSubtotal'];
                $data['shipping_charges'] = $activeCart['cart']['pricing']['formattedShippingAndHandling'];
            }
        }
        echo json_encode($data);
    }
    
    public function updateBillingDetails() {
        $accessToken = $this->input->post('access_token', TRUE);
        $addressDetails = $this->input->post('address_details', TRUE);
        if ( !$addressDetails && $accessToken ) {
            $data['error'] = 'BillingDetails Or Access Token is Missing';
        } else {
            $data['accessToken'] = $accessToken;
            $cartService =  new Digitalriver\Service\Cart($this->_client);
            $cartService->updateBillingAddress($accessToken, $addressDetails);
        }
        echo json_encode($data);
    }
    
    public function updatePaymentDetails() {
        $accessToken = $this->input->post('access_token', TRUE);
        $sourceId = $this->input->post('source_id', TRUE);
        $cardDetails = $this->input->post('card_details', TRUE);
        $userCheckoutOption= $this->input->post('userCheckoutOption', TRUE);
        if ( !$sourceId && $accessToken ) {
            $data['error'] = 'BillingDetails Or Access Token is Missing';
        } else {
            $data['accessToken'] = $accessToken;
            $data['cardDetails'] = $cardDetails;
            $sourcePayment = array('sourceId' => $sourceId);
            $cartService =  new Digitalriver\Service\Cart($this->_client);
            try {
                if ( $userCheckoutOption != 'new_user' ) {
                    $cartService->updateCartPayment($accessToken, $sourcePayment);
                }
                $response['activeCart'] = $cartService->retrieveCart( $accessToken );
                $response['cardDetails'] = $cardDetails;
                $response_html = $this->load->view('review_order',$response, TRUE);
                $data['review_order'] = $response_html;
            } catch ( Exception  $e) {;
                $response = $e->getResponse();
                $responseBodyAsString = json_decode($response->getBody()->getContents());
                $data['status'] = 'error';
                $data['error_response'] = $responseBodyAsString->errors->error[0]->description;
            }
        }
        echo json_encode($data);
    }
    
    public function submitCart() {
        $accessToken = $this->input->post('access_token', TRUE);
        if ( !$accessToken ) {
            $data['error'] = 'BillingDetails Or Access Token is Missing';
        } else {
            $data['accessToken'] = $accessToken;
            $cartService =  new Digitalriver\Service\Cart($this->_client);
            $submitCartDetails = $cartService->submitCart($accessToken);
            $data['orderId']= $submitCartDetails['submitCart']['order']['id'];
        }
        echo json_encode($data);
    }
    
    private function headerData() {
        $categoryService = new Digitalriver\Service\Category($this->_client);
        $allCategories = $categoryService->listAllCategories();
        
        return $allCategories['categories']['category'];
    }
}
