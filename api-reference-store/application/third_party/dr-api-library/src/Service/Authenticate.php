<?php
/* 
 * The Authenticate Class provides access to get deffernt access token of site.
 * Use the Authenticate Class class to:
 *      Retrieve an access token
 *      Delete an access token
 * Version : 1.0
 * Date : 05/08/2019
 */
namespace Digitalriver\Service;

class Authenticate extends \Digitalriver\Service {
    public function __construct(\Digitalriver\Client $client) {
        parent::__construct($client);
    }
    
    /** 
     * This function is used to get limited access token by session token
     * This is an annonumes access token
     * return access token array with the details
    */  
    public function getAccessToken() {
        $url = $this->client->getConfig()->get('AcccessTokenUrl').
                $this->client->getConfig()->get('siteId') .'/SessionToken?apiKey='. 
                $this->client->getConfig()->get('apiKey');

        return  $this->getRequest($url);
    }

    /** 
     * Get a dr_session_token from the sessionToken siteAction with no APIKey
     * 
     * return access token array with the details
    */  
    public function getDrSessionToken() {
        $url = $this->client->getConfig()->get('StoreEndpointUrl').$this->client->getConfig()->get('siteId').
                '/SessionToken?'
            .'&format=json';
        
        return  $this->getRequest($url);
    }
    
    /****
    *  Get a dr_session_token from the sessionToken siteAction (with no APIKey)
    *  POST the dr_session_token to the oauth20 endpoint, to get a limitedAccessToken 
    */
    public function getLimitedOauthToken( $drSessionToken ){
        if( !$drSessionToken ) {
            throw new \Exception("DR Session Token is missing");
        }
        $url = $this->client->getConfig()->get('OauthEndpointUrl').'token'
                . '?dr_session_token='.$drSessionToken.'&grant_type=password&format=json';
        
        $form_data = array();
         
        $apiKeyToken = base64_encode($this->client->getConfig()->get('apiKey').':'
            .$this->client->getConfig()->get('secretKey'));
        
        $headers = [ 'Authorization' => 'Basic '.$apiKeyToken ];
        
        return  $this->postRequest($url, $form_data, $headers);
    }
    
    /** 
     * Get Full access auth token
     * Required  Username, Password
     * return access token array with the details
    */  
    public function getFullAccessToken( $username, $password, $drSessionToken ) {
        if( !$username || !$password) {
            throw new \Exception("Invalid parametres");
        }
        $url = $this->client->getConfig()->get('OauthEndpointUrl').'token?'
                . 'username='.$username.'&password='.base64_encode($password).
                '&dr_session_token='.$drSessionToken.'&grant_type=password';
        
        $form_data = array();
        
        $apiKeyToken = base64_encode($this->client->getConfig()->get('apiKey').':'
            .$this->client->getConfig()->get('secretKey'));
        
        $headers = [ 'Authorization' => 'Basic '.$apiKeyToken ];
        
        return  $this->postRequest($url, $form_data, $headers);
    }
    
    /***
     * Retrieve an access token.
     * 
     * return access token object with the token information
    */  
    public function getTokenInformation( $accessToken ) {
        if( !$accessToken ) {
            throw new \Exception("Access Token is missing");
        }
        
        $url = $this->client->getConfig()->get('OauthEndpointUrl').'access-tokens?token='.
            $accessToken.'&format=json';
        
        return  $this->getRequest($url);
    }
    
    /**
	 * Generate full access token
	 *
	 * @param string $username
	 * @param string $password
	 *
	 * @return mixed $data
	 */
	public function generateAccessTokenByRefId( $externalReferenceId ) {

        if( !$externalReferenceId ) {
            throw new \Exception("External Ref ID is missing");
        }

		$data = array (
			'dr_external_reference_id' => $externalReferenceId,
			'grant_type'               => 'client_credentials'
		);


        $form_data = array();

        $url = $this->client->getConfig()->get('OauthEndpointUrl').'token?'
                . 'dr_external_reference_id='.$externalReferenceId.'&grant_type=client_credentials';


        $apiKeyToken = base64_encode($this->client->getConfig()->get('apiKey').':'
            .$this->client->getConfig()->get('secretKey'));
        
        $headers = [ 'Authorization' => 'Basic '.$apiKeyToken ];

        return  $this->postRequest($url, $form_data, $headers);
	}
}
