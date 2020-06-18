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
        $this->_client->setPrivateApiKey($this->config->item('privateApiKey'));
        $this->_client->setSecretKey($this->config->item('secretKey'));

        $this->destination_verification_token = config_item('destination_token');
    }

    // Verify connection with Redox
    public function physicians_get()
    {
    	$headers = $this->input->request_headers();

    	if ( array_key_exists('verification-token', $headers) && $headers['verification-token'] === $this->destination_verification_token ) {
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
        $db_data = array();
        $items = array();
		$raw_submission = $this->input->raw_input_stream;
        $submission = json_decode($raw_submission, true);

        if(!empty($submission) && array_key_exists('FacilityCode', $submission['Meta'])) {
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

            // Retrieve the user if suck FacilityCode/PhysicianId exists
            $gcReference = $this->getGCreferenceById($physicianId);

            // Create cart object based on the transmision
            $activeCart = $this->buildCart($gcReference, $items);

            var_dump($activeCart['cart']['billingAddress']['companyName'], $activeCart);

            $cordial = array(
                'channels.email.address'=> $gcReference,
                'vs_company_name'       => $activeCart['cart']['billingAddress']['companyName'],
                'vs_payment_amount'     => $activeCart['cart']['pricing']['formattedSubtotal'],
                'vs_numberofproducts'   => $activeCart['cart']['lineItems']['lineItem'][0]['quantity'],
            );

            var_dump($cordial);
            exit;
            // Amount for the email $activeCart['cart']['pricing']['formattedSubtotal'];
            // TODO: Send mail here and note if successful in the `email_notified`=>1 column

            // 
            $db_data = array(
                'physician_id'       => $physicianId,
                'data'               => $raw_submission,
                'items'              => json_encode($items),
                'email_notified'     => $cordial,
                'data_received_time' => time(),
                'data_processed_time'=> null,
            );

            $this->db->insert('ci_data_models', $db_data);

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
        
        $accessToken = $authService->generateAccessTokenByRefId($gcReference);
        $fullAccessToken = $accessToken['access_token'];

        // Attaches a shopper record to an active cart
        $cartService->applyShopper($fullAccessToken);

        foreach($items as $item) {
            $cartService->updateLineItem( $item['sku'], $fullAccessToken, 'add', $item['quantity']);
        }

        return $cartService->retrieveCart($fullAccessToken);
    }

    public function getGCreferenceById( $physicianId ) {
        if( !$physicianId ) {
            throw new \Exception("PhysicianId or Items are missing");
        }

        //Get Physician
        $gcReference = null;
        $query = $this->db->query("SELECT `gc_reference` FROM `ci_users` WHERE physician_id='".$physicianId."';");
        foreach ($query->result() as $row) {
            $gcReference = $row->gc_reference;
            break;
        }

        if( !$gcReference ) {
            throw new \Exception("This username ". $gcReference ." is not registered on the server");
        }

        return $gcReference;
    }
}
