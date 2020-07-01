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
        }
        if($this->session->userdata('error_msg'))
        {
            $data['error_msg'] = $this->session->userdata('error_msg');
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

            $user = $this->user->getByUsername($this->session->userdata('user_login'));
            $data['physicianId'] = $user->physician_id;
            $data['agreeTerms'] = $user->terms_accepted;
            $data['agreeAcc'] = $user->policy_accepted;

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
                $data['paymentOption'] = $shopperPaymentArray['paymentOptions']['paymentOption'];
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

                    //Check for  duplicant Account Number
                    $query = $this->db->query("SELECT `physician_id` FROM `ci_users` WHERE username<>'".$this->session->userdata('user_login')."';");

                    $physicianId = strip_tags($this->input->post('physicianId'));

                    foreach ($query->result() as $row) {
                        if ($row->physician_id === $physicianId) {
                            $this->session->set_flashdata('error_msg', 'Account Number: '. $physicianId .' is already registered by another user.');
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

                    //Set shoppers payment options
                    $paymentDetails = array();
                    if (!empty($this->input->post('paymentSourceId'))) {

                        $paymentDetails = array(
                            'nickName'          => strip_tags($this->input->post('paymentOptionName')),
                            'isDefault'         => 'true',
                            'sourceId'          => strip_tags($this->input->post('paymentSourceId')),
                        );
                        $shopperService->updateShopperPayment( $fullAccessToken, $paymentDetails );
                        // Get the shopper payment data
                    }

                    $paymentDetails = $shopperService->getShopperPayments( $fullAccessToken );

                    //Set user local data
                    $userLocalData = array(
                        'physician_id' => $physicianId,
                        'policy_accepted' => strip_tags($this->input->post('agreeAcc')),
                        'terms_accepted' => strip_tags($this->input->post('agreeTerms')),
                    );

                    $this->user->update($userLocalData, $this->session->userdata('user_login'));

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
                        'paymentOption' => $paymentDetails['paymentOptions']['paymentOption'],
                        'agreeAcc'      => 'yes',
                        'agreeTerms'    => 'yes',
                        'success_msg'   => 'Changes successfully saved.',
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
        }
        if($this->session->userdata('error_msg'))
        {
            $data['error_msg'] = $this->session->userdata('error_msg');
        }
        if($this->session->userdata('user_login'))
        {
            $data['user_login'] = $this->session->userdata('user_login');
        }
        // if($this->session->userdata('reset_pass_modal_msg'))
        // {
        //     $data['reset_pass_modal_msg'] = $this->session->userdata('reset_pass_modal_msg');
        // }
        // if($this->session->userdata('pw_reset_id'))
        // {
        //     $data['reset_pass'] = true;
        // }

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

                    $this->session->set_flashdata('success_msg', 'Your login was successful. Please enter the required user and payment information below.');

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
        }
        if($this->session->userdata('error_msg'))
        {
            $data['error_msg'] = $this->session->userdata('error_msg');
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

                    $query = $this->db->query("SELECT `username`, `physician_id` FROM `ci_users`;");

                    foreach ($query->result() as $row) {
                        if ($row->physician_id === $physicianId) {
                            $this->session->set_flashdata('error_msg', 'Account Number: '. $physicianId .' is already registered by another user.');
                            redirect('users/registration', $data);
                        }
                        if ($row->username === $userDetails['username']) {
                            $this->session->set_flashdata('error_msg', 'User with email '. $userDetails['username'] .' is already registered.');
                            redirect('users/registration', $data);
                        }
                    }

                    $newShopper = $shopperService->createShopper( $userDetails, $limitedToken['access_token'] );

                    $userLocalData = array(
                        'physician_id' => $physicianId,
                        'username'  => $userDetails['emailAddress'],
                        'gc_reference'  => $userDetails['emailAddress']
                    );

                    $this->user->insert($userLocalData);

                    $this->session->set_userdata('dr_session_token', $drSessionToken);
                    $this->session->set_userdata('user_login', $userDetails['emailAddress']);

                    $data['status'] = 'ok';
                    $this->session->set_flashdata('success_msg', 'Your registration was successful. Please login to your account.');

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

    public function updatePayment() {
        $data = array(
            'success' => false
        );

        if(!empty($this->input->post('paymentId'))) {
            $paymentId = strip_tags($this->input->post('paymentId'));

            $shopperService =  new Digitalriver\Service\Shopper($this->_client);
            $authService =  new Digitalriver\Service\Authenticate($this->_client);

            if ( $this->session->userdata( 'access_token' ) != '' ) {
                $tokenInformation = $authService->getTokenInformation($this->session->userdata('access_token'));
    
                if ($tokenInformation['authenticated'] === 'true') {
    
                    $fullAccessToken = $this->session->userdata( 'access_token' );
                    $paymentOption = $shopperService->getPaymentOptionById($fullAccessToken, $paymentId);
                        
                    if(isset($paymentOption['paymentOption']) && intval($paymentId) === intval($paymentOption['paymentOption']['id'])) {
                        
                        $shopperService->updateShopperPayment($fullAccessToken, array(
                            'id'        => $paymentOption['paymentOption']['id'],
                            'sourceId'  => $paymentOption['paymentOption']['sourceId'],
                            'isDefault' => true,
                        ));
                        
                        $data['success'] = true;
                        $this->session->set_flashdata('success_msg', 'Changes successfully saved.');
                    }
                }
                
            }

        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($data));

    }
    /**
     * User delete payment
     */
    public function deletePayment() {
        if($this->input->get('id')) {
            $paymentId = strip_tags($this->input->get('id'));

            $shopperService =  new Digitalriver\Service\Shopper($this->_client);
            $authService =  new Digitalriver\Service\Authenticate($this->_client);
            
            if ( $this->session->userdata( 'access_token' ) != '' ) {
                $tokenInformation = $authService->getTokenInformation($this->session->userdata( 'access_token'));
    
                if ($tokenInformation['authenticated'] !== 'true') {
                    redirect('users/login');
                }
    
                $fullAccessToken = $this->session->userdata( 'access_token' );
                $paymentOption = $shopperService->getPaymentOptionById($fullAccessToken, $paymentId);

                if(isset($paymentOption['paymentOption']) && intval($paymentId) === intval($paymentOption['paymentOption']['id'])) {

                    $shopperService->deletePaymentOptionById($fullAccessToken, $paymentId);

                    $this->session->set_flashdata('success_msg', 'Changes successfully saved.');
                    redirect('users/account');
                }
                
            }
        }
        redirect('users/login');
    }
    /**
     * User Reset Password
     */

    // public function resetPassword() {
    //     $data = array();

    //     if($this->input->post('passwordReset'))
    //     {
    //         // Init password reset email
    //         $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

    //         if($this->form_validation->run() == true) {
    //             try {
    //                 $email = strip_tags($this->input->post('email'));
    //                 $user = $this->user->getByUsername($email);

    //                 if ($user) {
    //                     $authService =  new Digitalriver\Service\Authenticate($this->_client);
    //                     $shopperService =  new Digitalriver\Service\Shopper($this->_client);

    //                     $accessToken = $authService->generateAccessTokenByRefId($user->gc_reference);
    //                     $fullAccessToken = $accessToken['access_token'];

    //                     if( !empty($fullAccessToken) ) {
    //                         if( $this->user->forgotPassword($user) ) {
    //                             $this->session->set_flashdata( 'success_msg', 'Please check your email for your password reset link.' );
    //                             redirect('users/login');
    //                         } else {
    //                             $this->session->set_flashdata('reset_pass_modal_msg', 'Failed to authenticate. Please try again.');
    //                         };
    //                     }
    //                 }

    //                 $this->session->set_flashdata( 'reset_pass_modal_msg', $email . ' was not found!' );
    //                 redirect('users/login', $data);

    //             } catch ( Exception  $e) {
    //                 $response = $e->getResponse();
    //                 $responseBodyAsString = json_decode($response->getBody()->getContents());
    //                 $data['status'] = 'error';
    //                 $data['reset_pass_modal_msg'] = $responseBodyAsString->errors->error[0]->description;
    //             }
    //         }

    //     }
    //     else if( $this->input->get('key') && $this->input->get('email') && $this->input->get('action') ) {
    //         // Open password modal if the user has token created less than an hour ago
    //         $username = strip_tags($this->input->get('email'));
    //         $token = strip_tags($this->input->get('key'));
    //         $action = strip_tags($this->input->get('action'));

    //         $user = $this->user->getByUsername($username);

    //         if( $user && 'reset' === $action && $token === $user->pw_reset_token ) {

    //             if( intval($user->pw_reset_token_created_at) >= (time() - 3600) ) {
    //                 $this->session->set_userdata('user_login', $user->username);
    //                 $this->session->set_userdata('pw_reset_id', $user->id);
    //             } else {
    //                 $this->session->unset_userdata('user_login');
    //                 $this->session->unset_userdata('pw_reset_id');
    //                 $this->user->update( [ 'pw_reset_token' => null, 'pw_reset_token_created_at' => null ], $user->username );
    //                 $this->session->set_flashdata('error_msg', 'Your password reset link has expired');
    //             }
    //         } else {
    //             $this->session->set_flashdata('error_msg', 'Your password reset link has expired');
    //         }
    //     }
    //     else if ( $this->input->post('passSubmit') && $this->session->userdata('pw_reset_id') ) {
    //         // Reset password and delete reset pw token
    //         $this->form_validation->set_rules('new_password', 'password', 'required' );
    //         $this->form_validation->set_rules('conf_new_password', 'confirm password', 'required|matches[new_password]');

    //         if($this->form_validation->run() == true) {
    //             $user = $this->user->getById( $this->session->userdata('pw_reset_id') );

    //             $authService =  new Digitalriver\Service\Authenticate($this->_client);
    //             $shopperService =  new Digitalriver\Service\Shopper($this->_client);

    //             if($user) {
    //                 $accessToken = $authService->generateAccessTokenByRefId($user->gc_reference);
    //                 $fullAccessToken = $accessToken['access_token'];

    //                 if( !empty($fullAccessToken) ) {
    //                     $password = base64_encode($this->input->post('new_password'));

    //                     $shopperService->updateShopper( $fullAccessToken, [ 'password' => $password ] );
    //                     $this->session->set_flashdata( 'success_msg', 'Your password has been successfully reset' );

    //                 } else {
    //                     $this->session->set_flashdata('error_msg', 'Failed to authenticate');
    //                 }

    //                 $this->user->update( [ 'pw_reset_token' => null, 'pw_reset_token_created_at' => null ], $user->username );
    //             } else {
    //                 $this->session->set_flashdata('error_msg', 'Username not found');
    //             }

    //             $this->session->unset_userdata('pw_reset_id');
    //         }
    //     }

    //     redirect('users/login', $data);
    // }

    public function get_states() {
        return array('AL'=>"Alabama",  'AK'=>"Alaska",  'AZ'=>"Arizona",  'AR'=>"Arkansas",  'CA'=>"California",  'CO'=>"Colorado",  'CT'=>"Connecticut",  'DE'=>"Delaware",  'DC'=>"District Of Columbia",  'FL'=>"Florida",  'GA'=>"Georgia",  'HI'=>"Hawaii",  'ID'=>"Idaho",  'IL'=>"Illinois",  'IN'=>"Indiana",  'IA'=>"Iowa",  'KS'=>"Kansas",  'KY'=>"Kentucky",  'LA'=>"Louisiana",  'ME'=>"Maine",  'MD'=>"Maryland",  'MA'=>"Massachusetts",  'MI'=>"Michigan",  'MN'=>"Minnesota",  'MS'=>"Mississippi",  'MO'=>"Missouri",  'MT'=>"Montana",'NE'=>"Nebraska",'NV'=>"Nevada",'NH'=>"New Hampshire",'NJ'=>"New Jersey",'NM'=>"New Mexico",'NY'=>"New York",'NC'=>"North Carolina",'ND'=>"North Dakota",'OH'=>"Ohio",  'OK'=>"Oklahoma",  'OR'=>"Oregon",  'PA'=>"Pennsylvania",  'RI'=>"Rhode Island",  'SC'=>"South Carolina",  'SD'=>"South Dakota",'TN'=>"Tennessee",  'TX'=>"Texas",  'UT'=>"Utah",  'VT'=>"Vermont",  'VA'=>"Virginia",  'WA'=>"Washington",  'WV'=>"West Virginia",  'WI'=>"Wisconsin",  'WY'=>"Wyoming");
    }

}
