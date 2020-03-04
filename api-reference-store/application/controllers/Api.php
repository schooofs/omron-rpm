<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController {

	private $destination_verification_token;

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->destination_verification_token = config_item('destination_token');
    }

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

    public function physicians_post()
    {
		print_r($this->post());

		$this->response( [
			'status' => true,
			'message' => 'Success'
		], 200 );
    }
}
