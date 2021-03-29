<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController {

	private $destination_verification_token;
    private  $_client;

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->_client = new Digitalriver\Client();
        $this->_client->setApplicationName($this->config->item('application_name'));
        $this->_client->setSiteId($this->config->item('site_id'));
        $this->_client->setApiKey($this->config->item('api_key'));
        $this->_client->setApiVersion($this->config->item('api_version'));
        $this->_client->setEnvironment($this->config->item('environment'));
        $this->_client->setTestOrder($this->config->item('test_order'));
        $this->_client->setSecretKey($this->config->item('secretKey'));

        $this->destination_verification_token = config_item('destination_token');

    }

    // Verify connection with Redox and return the challenge
    public function physicians_get()
    {
    	$verification_token = $this->input->get('verification-token');

    	if ( $verification_token && $verification_token === $this->destination_verification_token ) {
			$challenge = $this->get('challenge');

			$this->response($challenge, 200);
	    }

		$this->response( [
			'status' => false,
			'message' => 'verification-token did not match!'
		], 400 );
    }

    // Receive and process a submission from Redox  
    public function physicians_post()
    {
        //Verify source
        $raw_submission = $this->input->raw_input_stream;
        $submission = json_decode($raw_submission, true);
        
        if ( !array_key_exists('verification-token', $submission) || $submission['verification-token'] !== $this->destination_verification_token ) {
			$this->response( [
                'status' => false,
                'message' => 'verification-token did not match!'
            ], 400 );
	    }

        $db_data = array();
        $items = array();

        if( !empty($submission) && array_key_exists('FacilityCode', $submission['Meta']) ) {
            $physicianId = $submission['Meta']['FacilityCode'];

            if(array_key_exists('Items', $submission)) {

                foreach($submission['Items'] as $item) {
                    $items[] = array (
                        'sku'       => $item['Identifiers'][0]['IDType'] == 'SKU' ? $item['Identifiers'][0]['ID'] : null,
                        'quantity'  => !empty($item['Quantity']) ? $item['Quantity'] : null,
                    );
                }

            } else {
                $this->response( [
                    'status' => false,
                    'message' => 'No Items were found.'
                ], 400 );
            }

            // Get user from FacilityCode/PhysicianId
            $user = $this->user->getByPhysicianId($physicianId);

            // Create cart object based on the transmision
            $activeCart = $this->buildCart($user->gc_reference, $items);

            $qty = 0;
            foreach($activeCart['cart']['cart']['lineItems']['lineItem'] as $prod) {
                $qty += intval($prod['quantity']);
            }

            $cordialBody =  [
                'identifyBy'    => 'email',
                'to'            => [
                    'contact'       => [
                        'email'         => $user->username,
                    ],
                    'extVars'           => [
                        'vs_company_name'       => $activeCart['address']['addresses']['address'][0]['companyName'],
                        'vs_payment_amount'     => $activeCart['cart']['cart']['pricing']['formattedSubtotal'],
                        'vs_numberofproducts'   => $qty
                    ],
                ],
            ];
 
            $cordial = $this->user->cordialMonthlyNotification($cordialBody);

            $db_data = array(
                'user_id'            => intval($user->id),
                'data'               => $raw_submission,
                'items'              => json_encode($items),
                'email_notified'     => isset( $cordial['success'] ) ? 1 : 0,
                'data_received_time' => time(),
                'data_processed_time'=> null,
            );
            
            $this->submission->insert($db_data);

            $this->response( [
                'status' => true,
                'message' => 'success'
            ], 200 );
        } else {

            $this->response( [
                'status' => false,
                'message' => 'No data or FacilityCode was found.'
            ], 400 );
        }
    }

    // Create GC Cart from submission
    public function buildCart($gcReference, $items) {
        if( !$gcReference && !$items ) {
            throw new \Exception("GC reference ID or Items are missing");
        }

        $authService =  new Digitalriver\Service\Authenticate($this->_client);
        $cartService =  new Digitalriver\Service\Cart($this->_client);
        $shopperService =  new Digitalriver\Service\Shopper($this->_client);
        
        $accessToken = $authService->generateAccessTokenByRefId($gcReference);
        $fullAccessToken = $accessToken['access_token'];

        if (empty($fullAccessToken)) {
            throw new \Exception("Failed to authenticate with GC!");
        }

        foreach($items as $item) {
            $cartService->updateLineItem( $item['sku'], $fullAccessToken, 'add', $item['quantity'] );
        }

        return [ 'cart' => $cartService->retrieveCart($fullAccessToken), 'address' => $shopperService->getShopperAddress($fullAccessToken) ];
    }
}
