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
        $this->_client->setSecretKey($this->config->item('secretKey'));
    }
    
    /*
     * User account information
     */
    public function account()
    {
        $data= array();

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

        $shopperService =  new Digitalriver\Service\Shopper($this->_client);
        $authService =  new Digitalriver\Service\Authenticate($this->_client);
        // $cartService =  new Digitalriver\Service\Cart($this->_client);

        if ( $this->session->userdata( 'access_token' ) != '' ) {
            $tokenInformation = $authService->getTokenInformation($this->session->userdata( 'access_token'));

            if ($tokenInformation['authenticated'] !== 'true') {
                redirect('users/login');
            }

            $fullAccessToken = $this->session->userdata( 'access_token' );

            $query = $this->db->query("SELECT `physician_id`, `terms_accepted`, `policy_accepted` FROM `ci_users` WHERE username='".$this->session->userdata('user_login')."';");
            foreach ($query->result() as $row) {
                $data['physicianId'] = $row->physician_id;
                $data['agreeTerms'] = $row->terms_accepted;
                $data['agreeAcc'] = $row->policy_accepted;
                break;
            }

            // Get the shopper data
            $getShopperData = $shopperService->getShopperData($fullAccessToken);
            if ( isset($getShopperData['shopper']) )
            {
                $data['firstName'] = $getShopperData['shopper']['firstName'];
                $data['lastName'] = $getShopperData['shopper']['lastName'];
                $data['emailAddress'] = $getShopperData['shopper']['emailAddress'];
            } else {
                $data['firstName'] = 'set_new';
                $data['lastName'] = 'set_new';
                $data['emailAddress'] = 'set_new';
            }

            // Get the shoppers addresses
            $getShoopperAddress = $shopperService->getShopperAddress($fullAccessToken);

            if(isset($getShoopperAddress['addresses']['address'])) {
                foreach ($getShoopperAddress['addresses']['address'] as $key => $addressBook) {
                    if ('Default Address' == $addressBook['nickName']) {
                        $data['companyName'] = $addressBook['companyName'];
                        $data['address1'] = $addressBook['line1'];
                        $data['address2'] = $addressBook['line2'];
                        $data['city'] = $addressBook['city'];
                        $data['state'] = $addressBook['countrySubdivision'];
                        $data['zip'] = $addressBook['postalCode'];
                        $data['phone'] = $addressBook['phoneNumber'];
                        break;
                    } else {
                        $shopperService->deleteShopperAddress( $fullAccessToken, $addressBook['id'] );
                    }
                }
            }

            // Get the shopper payment data
            $shopperPaymentArray = $shopperService->getShopperPayments($fullAccessToken);

            if ( isset($shopperPaymentArray['paymentOptions']['paymentOption']) ) {
                $data['paymentInfo'][] =  array(
                    'paymentOptionId' => $shopperPaymentArray['paymentOptions']['paymentOption'][0]['id'],
                    'paymentOption' => $shopperPaymentArray['paymentOptions']['paymentOption'][0]['nickName'],
                    'expMonth'    => $shopperPaymentArray['paymentOptions']['paymentOption'][0]['creditCard']['expirationMonth'],
                    'expYear'    => $shopperPaymentArray['paymentOptions']['paymentOption'][0]['creditCard']['expirationYear'],
                    'creditCardNum' => '**** **** **** ' . $shopperPaymentArray['paymentOptions']['paymentOption'][0]['creditCard']['lastFourDigits'],
                );
            } else {
                $data['paymentInfo'][] =  array(
                    'paymentOptionId' => 0,
                    'paymentOption' => 'Add New',
                    'expMonth'    => '',
                    'expYear'    => '',
                    'creditCardNum' => '',
                );
            }

            $data['stateCodes'] = $this->get_states();

            if($this->input->post('accountForm')) {

                $this->form_validation->set_rules('firstName', 'firstname', 'required');
                $this->form_validation->set_rules('lastName', 'lastName', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                $this->form_validation->set_rules('physicianid', 'physicianid', 'required');
                $this->form_validation->set_rules('address1', 'address1', 'required');
                $this->form_validation->set_rules('phone', 'phone', 'required');
                $this->form_validation->set_rules('zip', 'zip', 'required');
                $this->form_validation->set_rules('city', 'city', 'required');
                $this->form_validation->set_rules('country', 'country', 'required');
                $this->form_validation->set_rules('state', 'state', 'required');
                // $this->form_validation->set_rules('paymentOptionName', 'paymentOptionName', 'required');

                try {

                    //Check for  duplicant EHRID
                    $query = $this->db->query("SELECT `physician_id` FROM `ci_users` WHERE username<>'".$this->session->userdata('user_login')."';");

                    $physicianId = strip_tags($this->input->post('physicianId'));

                    foreach ($query->result() as $row) {
                        if ($row->physician_id === $physicianId) {
                            $this->session->set_userdata('error_msg', 'EHR ID: '. $physicianId .' is already registered by another user.');
                            redirect('users/account');
                        }
                    }

                    $userDetails = array (
                        'emailAddress' => strip_tags($this->input->post('email')),
                        'firstName' => strip_tags($this->input->post('firstName')),
                        'lastName' => strip_tags($this->input->post('lastName')),
                    );

                    //Set shoppers details
                    $shopperDetails = $shopperService->updateShopper($fullAccessToken, $userDetails);

                    $billingDetails =  array(
                        'nickName' => 'Default Address',
                        'isDefault'=> true,
                        'companyName' => strip_tags($this->input->post('companyName')),
                        'firstName'=> strip_tags($this->input->post('firstName')),
                        'lastName'=> strip_tags($this->input->post('lastName')),
                        'line1'=> strip_tags($this->input->post('address1')),
                        'line2'=> strip_tags($this->input->post('address2')),
                        'city'=> strip_tags($this->input->post('city')),
                        'country'=> 'US',
                        'postalCode'=> strip_tags($this->input->post('zip')),
                        'countryName'=> strip_tags($this->input->post('country')),
                        'phoneNumber'=> strip_tags($this->input->post('phone')),
                        'countrySubdivision' => strip_tags($this->input->post('state')),
                    );

                    //Set shoppers billing address
                    $shopperAddress = $shopperService->updateShopperAddress($fullAccessToken, $billingDetails);

                    //Set shoppers payment options if doesnt exists
                    // TODO: be able save multiple payment methods so the shopper can choose from, update or delete
                    $paymentDetails = array();
                    if (!$this->input->post('paymentOption')) {

                        $paymentDetails = array(
                            'nickName'          => strip_tags($this->input->post('paymentOptionName')),
                            'isDefault'         => 'true',
                            'sourceId'          => strip_tags($this->input->post('paymentSourceId')),
                        );
                        $shopperService->updateShopperPayment( $fullAccessToken, $paymentDetails );
                        // Get the shopper payment data
                    } else {
                        $paymentDetails = $shopperService->getShopperPayments( $fullAccessToken );
                    }

                    //Set user local data
                    $userLocalData = array(
                        'physician_id' => $physicianId,
                        'policy_accepted' => strip_tags($this->input->post('agreeAcc')),
                        'terms_accepted' => strip_tags($this->input->post('agreeTerms')),
                    );

                    $this->db->update('ci_users', $userLocalData, array('username' => $this->session->userdata('user_login')));

                    // Prepare the updated data for the view
                    $data = array(
                        'firstName'     => $userDetails['firstName'],
                        'lastName'      => $userDetails['lastName'],
                        'emailAddress'  => $userDetails['emailAddress'],
                        'physicianId'   => $physicianId,
                        'companyName'   => $billingDetails['companyName'],
                        'address1'      => $billingDetails['line1'],
                        'address2'      => $billingDetails['line2'],
                        'phone'         => $billingDetails['phoneNumber'],
                        'zip'           => $billingDetails['postalCode'],
                        'city'          => $billingDetails['city'],
                        'country'       => $billingDetails['country'],
                        'state'         => $billingDetails['countrySubdivision'],
                        'stateCodes'    => $this->get_states(),
                        'paymentInfo'   => array(
                            array(
                                'paymentOptionId' => $paymentDetails['paymentOptions']['paymentOption'][0]['id'],
                                'paymentOption' => $paymentDetails['paymentOptions']['paymentOption'][0]['nickName'],
                                'expMonth'    => $paymentDetails['paymentOptions']['paymentOption'][0]['creditCard']['expirationMonth'],
                                'expYear'    => $paymentDetails['paymentOptions']['paymentOption'][0]['creditCard']['expirationYear'],
                                'creditCardNum' => '**** **** **** ' . $paymentDetails['paymentOptions']['paymentOption'][0]['creditCard']['lastFourDigits'],
                        ) ),
                        'agreeAcc'      => 'yes',
                        'agreeTerms'    => 'yes',
                    );

                } catch (Exception $ex) {
                    $response = $ex->getResponse();
                    $responseBodyAsString = json_decode($response->getBody()->getContents());
                    $data['status'] = 'error';
                    $data['error_msg'] = $responseBodyAsString->errors->error[0]->description;
                }
            }
        }
        else
        {
            redirect('users/login');
        }

        $this->load->view('header');
        $this->load->view('users/account', $data);
        $this->load->view('footer');
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
            $this->session->unset_userdata('user_login');
        }
        
        $authService =  new Digitalriver\Service\Authenticate($this->_client);
        $authDrData = $authService->getDrSessionToken();
        $drSessionToken = $authDrData['session_token'];
        $shopperService =  new Digitalriver\Service\Shopper($this->_client);

        if ( $this->session->userdata( 'access_token' ) != '' ) {
            $tokenInformation = $authService->getTokenInformation($this->session->userdata( 'access_token'));

            if ($tokenInformation['authenticated'] === 'true') {
                redirect('users/account');
            }
        }

        if($this->input->post('loginSubmit')) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'required');

            if ($this->form_validation->run() == true) 
            {

                // var_dump($this->input->post('email'), $this->input->post('password'), $drSessionToken);
                // exit;
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

                    $this->session->set_userdata('success_msg', 'Your login was successful. Please enter the required user and payment information bellow.');

                    $data['status'] = 'ok';
                    $data['fullAccessToken'] = $getFullAccessToken['access_token'];


                    redirect('users/account/', $data);

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
        $cartService =  new Digitalriver\Service\Cart($this->_client);

        if ( $this->session->userdata( 'access_token' ) != '' ) {
            $tokenInformation = $authService->getTokenInformation($this->session->userdata( 'access_token'));

            if ($tokenInformation['authenticated'] === 'true') {
                redirect('users/account');
            }
        }

        $authDrData = $authService->getDrSessionToken();
        $drSessionToken = $authDrData['session_token'];
        $limitedToken = $authService->getLimitedOauthToken($drSessionToken);

        $userDetails = array();
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

        if($this->input->post('regisSubmit'))
        {

            $this->form_validation->set_rules('firstName', 'firstname', 'required');
            $this->form_validation->set_rules('lastName', 'lastName', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('physicianId', 'physicianId', 'required');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[password]');

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

            if($this->form_validation->run() == true) {
                try {
                    $physicianId =strip_tags($this->input->post('physicianId'));

                    $query = $this->db->query("SELECT `physician_id` FROM `ci_users`;");

                    foreach ($query->result() as $row) {
                        if ($row->physician_id === $physicianId) {
                            $this->session->set_userdata('error_msg', 'EHR ID: '. $physicianId .' is already registered by another user.');
                            redirect('users/registration', $data);
                        }
                    }

                    $newShopper = $shopperService->createShopper( $userDetails, $limitedToken['access_token'] );

                    $userLocalData = array(
                        'physician_id' => $physicianId,
                        'username'  => $userDetails['emailAddress'],
                        'gc_reference'  => $userDetails['emailAddress']
                    );

                    $this->db->insert('ci_users',$userLocalData);

                    $this->session->set_userdata('dr_session_token', $drSessionToken);
                    $this->session->set_userdata('user_login', $userDetails['emailAddress']);

                    $data['status'] = 'ok';
                    $this->session->set_userdata('success_msg', 'Your registration was successful. Please login to your account.');

                    redirect('users/login', $data);
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
        $data = array();
        $this->session->unset_userdata('dr_session_token');
        $this->session->unset_userdata('access_token');
        $this->session->unset_userdata('refresh_token');
        $this->session->sess_destroy();
        redirect('users/login/', $data);
    }

    public function get_states() {
        return array('AL'=>"Alabama",  'AK'=>"Alaska",  'AZ'=>"Arizona",  'AR'=>"Arkansas",  'CA'=>"California",  'CO'=>"Colorado",  'CT'=>"Connecticut",  'DE'=>"Delaware",  'DC'=>"District Of Columbia",  'FL'=>"Florida",  'GA'=>"Georgia",  'HI'=>"Hawaii",  'ID'=>"Idaho",  'IL'=>"Illinois",  'IN'=>"Indiana",  'IA'=>"Iowa",  'KS'=>"Kansas",  'KY'=>"Kentucky",  'LA'=>"Louisiana",  'ME'=>"Maine",  'MD'=>"Maryland",  'MA'=>"Massachusetts",  'MI'=>"Michigan",  'MN'=>"Minnesota",  'MS'=>"Mississippi",  'MO'=>"Missouri",  'MT'=>"Montana",'NE'=>"Nebraska",'NV'=>"Nevada",'NH'=>"New Hampshire",'NJ'=>"New Jersey",'NM'=>"New Mexico",'NY'=>"New York",'NC'=>"North Carolina",'ND'=>"North Dakota",'OH'=>"Ohio",  'OK'=>"Oklahoma",  'OR'=>"Oregon",  'PA'=>"Pennsylvania",  'RI'=>"Rhode Island",  'SC'=>"South Carolina",  'SD'=>"South Dakota",'TN'=>"Tennessee",  'TX'=>"Texas",  'UT'=>"Utah",  'VT'=>"Vermont",  'VA'=>"Virginia",  'WA'=>"Washington",  'WV'=>"West Virginia",  'WI'=>"Wisconsin",  'WY'=>"Wyoming");
    }

}