<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    private $_client;
    public $_logger;
    public function __construct() {
        parent::__construct();
        $this->_client = new Digitalriver\Client();
        $this->_client->setApplicationName($this->config->item('application_name'));
        $this->_client->setSiteId($this->config->item('site_id'));
        $this->_client->setApiKey($this->config->item('api_key'));
        $this->_client->setApiVersion($this->config->item('api_version'));
        $this->_client->setEnvironment($this->config->item('environment'));
        $this->_client->setPrivateApiKey($this->config->item('privateApiKey'));
        $this->_client->setSecretKey($this->config->item('secretKey'));
    }
    
    /**** First Controller which call is index ***/
    public function index(){
        $this->load->library('session');
        if ( $this->session->userdata( 'access_token' ) != '' ) {
            $data['user_login'] = true;
        }
        
        // Loading product library functions for get product details
        $offerService =  new Digitalriver\Service\Offer($this->_client);
        $data['header']['categories'] = $this->headerData();
        
        $upgrade = $offerService->getOffer($this->config->item('home_offer_upgrade'));
        $data['offers']['upgrade'] = $upgrade['offer'];
        if ( $this->config->item('display_api_console') ) {
            $this->_logger[] = array(
                'apiName' => 'OfferApi',
                'functionName' => 'getOffer',
                'method' => 'GET',
                'url' =>( isset($upgrade['url']) ? $upgrade['url'] : ''),
                'queryParm' => json_encode(array( $this->config->item('home_offer_upgrade'))),
                'response' => $upgrade['offer']
            );
        }
        
        $electronics = $offerService->getOffer($this->config->item('home_offer_electronics'));
        $data['offers']['electronics'] = $electronics['offer'];
        if ( $this->config->item('display_api_console') ) {
            $this->_logger[] = array(
                'apiName' => 'OfferApi',
                'functionName' => 'getOffer',
                'method' => 'GET',
                'url' =>( isset($electronics['url']) ? $electronics['url'] : ''),
                'queryParm' => json_encode(array( $this->config->item('home_offer_electronics'))),
                'response' => $electronics['offer']
            );
        }
        
        $software = $offerService->getOffer($this->config->item('home_offer_software'));
        $data['offers']['software'] = $software['offer'];
        if ( $this->config->item('display_api_console') ) {
            $this->_logger[] = array(
                'apiName' => 'OfferApi',
                'functionName' => 'getOffer',
                'method' => 'GET',
                'url' =>( isset($software['url']) ? $software['url'] : ''),
                'queryParm' => json_encode(array( $this->config->item('home_offer_software'))),
                'response' => $software['offer']
            );
        }
        
        $games = $offerService->getOffer($this->config->item('home_offer_games'));
        $data['offers']['games'] = $games['offer'];
        if ( $this->config->item('display_api_console') ) {
            $this->_logger[] = array(
                'apiName' => 'OfferApi',
                'functionName' => 'getOffer',
                'method' => 'GET',
                'url' =>( isset($games['url']) ? $games['url'] : ''),
                'queryParm' => json_encode(array( $this->config->item('home_offer_games'))),
                'response' => $games['offer']
            );
        }
        
        $specialOffer = $offerService->getOffer($this->config->item('home_special_offer'));
        $data['offers']['specialOffer'] = $specialOffer['offer'];
        if ( $this->config->item('display_api_console') ) {
            $this->_logger[] = array(
                'apiName' => 'OfferApi',
                'functionName' => 'getOffer',
                'method' => 'GET',
                'url' =>( isset($specialOffer['url']) ? $specialOffer['url'] : ''),
                'queryParm' => json_encode(array( $this->config->item('home_special_offer'))),
                'response' => $specialOffer['offer']
            );
        }
        
        $futureProduct = $offerService->getOffer($this->config->item('future_product'));
        $data['offers']['futureProduct'] = $futureProduct['offer']['productOffers']['productOffer'];
        if ( $this->config->item('display_api_console') ) {
            $this->_logger[] = array(
                'apiName' => 'OfferApi',
                'functionName' => 'getOffer',
                'method' => 'GET',
                'url' =>( isset($futureProduct['url']) ? $futureProduct['url'] : ''),
                'queryParm' => json_encode(array( $this->config->item('future_product'))),
                'response' => $futureProduct['offer']['productOffers']['productOffer']
            );
        }
        
        $data['logger'] = $this->_logger;
        $this->load->view('home_page', $data);
    }
    
    private function headerData() {
        $categoryService = new Digitalriver\Service\Category($this->_client);
        $allCategories = $categoryService->listAllCategories();
        if ( $this->config->item('display_api_console') ) {
            $this->_logger[] = array(
                'apiName' => 'CategoryApi',
                'functionName' => 'listAllCategories',
                'method' => 'GET',
                'url' =>( isset($allCategories['url']) ?$allCategories['url'] : ''),
                'queryParm' => array(),
                'response' => $allCategories['categories']['category']
            );
        }
        return $allCategories['categories']['category'];
    }
}
