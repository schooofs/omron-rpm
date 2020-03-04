<?php
/**
 * User Management class
 */
class Users extends CI_Controller 
{
    private  $_client;
    
    function __construct() 
    {
        parent::__construct();
        $this->load->library('form_validation');

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
    
    /*
     * User account information
     */
    public function account()
    {
        $shopperService =  new Digitalriver\Service\Shopper($this->_client);
        $authService =  new Digitalriver\Service\Authenticate($this->_client);
        // $cartService =  new Digitalriver\Service\Cart($this->_client);

        $data = array();

        // var_dump($authService);
        // exit;
        if ( $this->session->userdata( 'access_token' ) != '' ){
            $tokenInformation = $authService->getTokenInformation($this->session->userdata( 'access_token'));

            if ($tokenInformation['authenticated'] !== 'true') {
                redirect('users/login');
            }

            $fullAccessToken = $this->session->userdata( 'access_token' );

            // Get the shopper data
            $getShopperData = $shopperService->getShopperData($fullAccessToken);
            if ( isset($getShopperData['shopper']) )
            {
                $data['firstName'] = $getShopperData['shopper']['firstName'];
                $data['lastName'] = $getShopperData['shopper']['lastName'];
            } else {
                $data['firstName'] = 'set_new';
                $data['lastName'] = 'set_new';
            }

            // Get the shoppers addresses
            $getShoopperAddress = $shopperService->getShopperAddress($fullAccessToken);
            // var_dump($getShoopperAddress);
            // exit;
            if ( isset($getShoopperAddress['addresses']['address']) ) {
                $data['shoppersAddresses'] =  $getShoopperAddress['addresses']['address'];
            } else {
                $data['shoppersAddresses'] = 'set_new';
            }
            
            // Get the shopper payment data
            $shopperPaymentArray = $shopperService->getShopperPayments($fullAccessToken);
            // var_dump($shopperPaymentArray);
            // exit;
            if ( isset($shopperPaymentArray['paymentOptions']['paymentOption']) ) {
                $data['shoppersPayment'] =  $shopperPaymentArray['paymentOptions']['paymentOption'];
            } else {
                $data['shoppersPayment'] = 'set_new';
            }

            //load the view
            $this->load->view('header');
            $this->load->view('users/account', $data);
            $this->load->view('footer');
        }
        else
        {
            redirect('users/login');
        }
    }
    
    /*
     * User login
     */
    public function login()
    {
        $data = array();
        if($this->session->userdata('success_msg'))
        {
            $data['success_msg'] = $this->session->userdata('success_msg');
            $this->session->unset_userdata('success_msg');
        }
        if($this->session->userdata('error_msg'))
        {
            $data['error_msg'] = $this->session->userdata('error_msg');
            $this->session->unset_userdata('error_msg');
        }
        if($this->session->userdata('user_login'))
        {
            $data['user_login'] = $this->session->userdata('user_login');
        }
        if($this->input->post('loginSubmit'))
        {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'required');

            if ($this->form_validation->run() == true) 
            {
                $authService =  new Digitalriver\Service\Authenticate($this->_client);
                $authDrData = $authService->getDrSessionToken();
                $drSessionToken = $authDrData['session_token'];
                // $shopperService =  new Digitalriver\Service\Shopper($this->_client);

                try {
                    $getFullAccessToken = $authService->getFullAccessToken(
                        $this->input->post('email'), $this->input->post('password'), $drSessionToken);

                    // Set shoppers session
                    $this->session->set_userdata(
                        'access_token', $getFullAccessToken['access_token']
                    );
                    $this->session->set_userdata(
                        'refresh_token', $getFullAccessToken['refresh_token']
                    );
                    $this->session->set_userdata(
                        'dr_session_token', $drSessionToken
                    );
                    $this->session->set_userdata(
                        'user_login', $this->input->post('email')
                    );
                     
                    // Get the shoppers addresses
                    // $getShoopperAddress = $shopperService->getShopperAddress($getFullAccessToken['access_token']);
                    // if ( isset($getShoopperAddress['addresses']['address']) ) {
                    //     $data['shoppersAddresses'] =  $getShoopperAddress['addresses']['address'];
                    // } else {
                    //     $data['shoppersAddresses'] = 'set_new';
                    // }
                    
                    // $shopperPaymentArray = $shopperService->getShopperPayments($getFullAccessToken['access_token']);
                    // if ( isset($shopperPaymentArray['paymentOptions']['paymentOption']) ) {
                    //     $data['shoppersPayment'] =  $shopperPaymentArray['paymentOptions']['paymentOption'];
                    // } else {
                    //     $data['shoppersPayment'] = 'set_new';
                    // }
                    
                    $data['status'] = 'ok';
                    $data['fullAccessToken'] = $getFullAccessToken['access_token'];
                    redirect('users/account/');

                } catch (Exception $ex) {
                    $response = $ex->getResponse();
                    $responseBodyAsString = json_decode($response->getBody()->getContents());
                    $data['status'] = 'error';
                    $data['error_msg'] = $responseBodyAsString->error_description;
                }
                
            }
            else
            {
                $data['error_msg'] = 'Wrong email or password, please try again.';
            }
        }
        //load the view
        $this->load->view('header');
        $this->load->view('users/login', $data);
        $this->load->view('footer');
    }
    
    /*
     * User registration
     */
    public function registration()
    {
        $shopperService =  new Digitalriver\Service\Shopper($this->_client);
        $authService =  new Digitalriver\Service\Authenticate($this->_client);
        $authDrData = $authService->getDrSessionToken();
        $drSessionToken = $authDrData['session_token'];

        $userDetails = array();
        $data = array();

        if($this->input->post('regisSubmit'))
        {

            $this->form_validation->set_rules('firstName', 'firstname', 'required');
            $this->form_validation->set_rules('lastName', 'firstname', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[password]');
            // $this->form_validation->set_rules('address1', 'address', 'required');
            // $this->form_validation->set_rules('phone', 'phone', 'required');
            // $this->form_validation->set_rules('zip', 'zip', 'required');
            // $this->form_validation->set_rules('city', 'city', 'required');
            // $this->form_validation->set_rules('country', 'country', 'required');

            $userDetails = array (
                'externalReferenceId' => strip_tags($this->input->post('email')),
                'username' => strip_tags($this->input->post('email')),
                'password' => base64_encode($this->input->post('password')),
                'emailAddress' => strip_tags($this->input->post('email')),
                'firstName' => strip_tags($this->input->post('firstName')),
                'lastName' => strip_tags($this->input->post('lastName')),
                'locale' => 'en_US',
                'currency'=> 'USD'
            );

            // $billingDetails =  array(
            //     "nickName" => 'Default Address',
            //     "isDefault"=> "true",
            //     "firstName"=> strip_tags($this->input->post('firstName')),
            //     "lastName"=> strip_tags($this->input->post('lastName')),
            //     "line1"=> strip_tags($this->input->post('address1')),
            //     "line2"=> strip_tags($this->input->post('address2')),
            //     "city"=> strip_tags($this->input->post('city')),
            //     "country"=> 'US',
            //     "postalCode"=> strip_tags($this->input->post('zip')),
            //     "countryName"=> strip_tags($this->input->post('country')),
            //     "phoneNumber"=> strip_tags($this->input->post('phone'))
            // );

            // $paymentDetails = array();

            if($this->form_validation->run() == true)
            {
                try {
                    $newShopper = $shopperService->createShopper( $userDetails );

                    // $getFullAccessToken = $authService->getFullAccessToken(
                    //     $userDetails['emailAddress'], $userDetails['password'], $drSessionToken);

                    // // Set shoppers billing address
                    // $shopperAddress = $shopperService->updateShopperAddress(
                    //     $getFullAccessToken['access_token'], $billingDetails);
                    
                    // $billingAddressArray = $shopperService->getShopperAddress($getFullAccessToken['access_token']);
                    // $billingID = $billingAddressArray['addresses']['address'][0]['id'];
                    // Create shopper payment
                    // $paymentDetails = array(
                    //     "nickName"  => 'Default Payment',
                    //     "isDefault" => 'true',
                    //     "sourceId"  => $sourceId 
                    // );
                    // $shopperService->updateShopperPayment(
                    //     $getFullAccessToken['access_token'], $paymentDetails );
                    // $shopperPaymentArray = $shopperService->getShopperPayments($getFullAccessToken['access_token']);
                    // $paymentID = $shopperPaymentArray['paymentOptions']['paymentOption'][0]['id'];

                    // Set shoppers session
                    // $this->session->set_userdata(
                    //     'access_token', $getFullAccessToken['access_token']
                    // );
                    $this->session->set_userdata(
                        'dr_session_token', $drSessionToken
                    );
                    $this->session->set_userdata(
                        'user_login', $userDetails['emailAddress']
                    );

                    // $data['fullAccessToken'] = $getFullAccessToken['access_token'];
                    $data['status'] = 'ok';
                    $this->session->set_userdata('success_msg', 'Your registration was successfully. Please login to your account.');
                    
                    // var_dump($newShopper, $data, $this->session);
                    // exit;
                    redirect('users/login');
                } catch ( Exception  $e) {
                    $response = $e->getResponse();
                    $responseBodyAsString = json_decode($response->getBody()->getContents());
                    $data['status'] = 'error';
                    $data['error_msg'] = $responseBodyAsString->errors->error[0]->description;
                }
            }
            else
            {
                $data['error_msg'] = 'Some problems occured, please try again.';
            }
            
        }

        $data['user'] = $userDetails;
        //load the view
        $this->load->view('header');
        $this->load->view('users/registration', $data);
        $this->load->view('footer');
    }
    
    /*
     * User logout
     */
    public function logout()
    {
        $this->session->unset_userdata('dr_session_token');
        $this->session->unset_userdata('access_token');
        $this->session->unset_userdata('refresh_token');
        $this->session->sess_destroy();
        redirect('users/login/');
    }

}