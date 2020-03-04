<?php
namespace Digitalriver;

class AuthenticateTest extends TestCase {
    protected $_clientObj;
    protected $_authService;
    
    public function __construct() {
        parent::__construct();
        $this->_clientObj = $this->createClient();
        $this->_authService = new Service\Authenticate($this->_clientObj);
    }

    public function testGetDrSessionToken() {
        $authDrData = $this->_authService->getDrSessionToken();
        $hasSessionToken = false;
        if(isset($authDrData['session_token'])) {
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testGetLimitedOauthToken() {
        $authDrData = $this->_authService->getDrSessionToken();
        $hasSessionToken = false;
        if(isset($authDrData['session_token'])) {
            $authdata= $this->_authService->getLimitedOauthToken($authDrData['session_token']);
            if(isset($authdata['access_token'])) {
                $hasSessionToken = true;
            }
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testGetFullAccessToken(){
        $authDrData = $this->_authService->getDrSessionToken();
        $hasSessionToken = false;
        if (isset($authDrData['session_token']) ) {
            $oauthToken = $this->_authService->getFullAccessToken(
                    $this->settings['shopperEmail'],$this->settings['shopperPassword'],
                    $authDrData['session_token'] );
            if(isset($oauthToken['access_token'])) {
                $hasSessionToken = true;
            }
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testGetTokenInformation(){
        $authDrData = $this->_authService->getDrSessionToken();
        $hasSessionToken = false;
        if (isset($authDrData['session_token']) ) {
            $oauthToken = $this->_authService->getFullAccessToken(
                    $this->settings['shopperEmail'],$this->settings['shopperPassword'],
                    $authDrData['session_token'] );
            if(isset($oauthToken['access_token'])) {
                $tokenInfo = $this->_authService->getTokenInformation($oauthToken['access_token']);
                if ( isset($tokenInfo['sessionId']) ) {
                    $hasSessionToken = true;
                }
            }
        }
        $this->assertEquals(true, $hasSessionToken);
    }
}