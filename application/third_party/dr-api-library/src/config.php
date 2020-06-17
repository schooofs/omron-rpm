<?php
namespace Digitalriver;

class Config  {
    const ENDPOINT_DEV = "https://api.digitalriver.com/";
    const ENDPOINT_LIVE = "https://api.digitalriver.com/";
    
    const ENDPOINT_ADMIN_DEV = "https://store.digitalriver.com/";
    const ENDPOINT_STORE = "https://store.digitalriver.com/";
    const ENDPOINT_OAUTH = "https://api.digitalriver.com/";
    const API_VERSION = "v1";
    
    protected $data = array();
   
    public function setEnvironment($environment){
        $this->set('environment', $environment);
        if(\Digitalriver\Environment::PRODUCTION == $this->get('environment'))
            $this->production();
        elseif(\Digitalriver\Environment::STAGING ==$this->get('environment'))
            $this->staging();
        elseif(\Digitalriver\Environment::LOCAL == $this->get('environment'))
            $this->local();
        else
            die('<h1>Where am I?</h1> <p>You need to setup your environment');
    }

    private function local(){
        ini_set('display_errors', '1');
        ini_set('error_reporting', E_ALL);
        if (!defined('WEB_ROOT')) {
            define('WEB_ROOT', '/');
        }
        $apiVersion = $this->get('apiVersion') ? $this->get('apiVersion') :  self::API_VERSION;
        $this->set('categoriesUrl', self::ENDPOINT_DEV . $apiVersion . '/shoppers/me/categories');
        $this->set('shoppersUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers");
        $this->set('productsUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/products");
        $this->set('cartUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/carts");
        $this->set('cartTaxUrl', self::ENDPOINT_DEV . $apiVersion. "/carts/");
        $this->set('customerUrl', self::ENDPOINT_DEV . $apiVersion. "/customers/");
        $this->set('offerUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/offers/");
        $this->set('promotionUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/point-of-promotions/");
        $this->set('PrivateStoreUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/purchase-plan/");
        $this->set('AcccessTokenUrl', self::ENDPOINT_ADMIN_DEV .'store/');
        $this->set('StoreEndpointUrl', self::ENDPOINT_STORE .'store/');
        $this->set('OauthEndpointUrl', self::ENDPOINT_OAUTH .'oauth20/');
        $this->set('orderUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/orders/");
    }
    
    private function staging(){
        ini_set('display_errors', '1');
        ini_set('error_reporting', E_ALL);
        if (!defined('WEB_ROOT')) {
            define('WEB_ROOT', '/');
        }
        $apiVersion = $this->get('apiVersion') ? $this->get('apiVersion') :  self::API_VERSION;
        $this->set('categoriesUrl', self::ENDPOINT_DEV . $apiVersion . '/shoppers/me/categories');
        $this->set('shoppersUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers");
        $this->set('productsUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/products");
        $this->set('cartUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/carts");
        $this->set('cartTaxUrl', self::ENDPOINT_DEV . $apiVersion. "/carts/");
        $this->set('customerUrl', self::ENDPOINT_DEV . $apiVersion. "/customers/");
        $this->set('offerUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/offers/");
        $this->set('promotionUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/point-of-promotions/");
        $this->set('PrivateStoreUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/purchase-plan/");
        $this->set('AcccessTokenUrl', self::ENDPOINT_ADMIN_DEV .'store/');
        $this->set('StoreEndpointUrl', self::ENDPOINT_STORE .'store/');
        $this->set('OauthEndpointUrl', self::ENDPOINT_OAUTH .'oauth20/');
        $this->set('orderUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/orders/");
    }
    
    private function production(){
        ini_set('display_errors', '1');
        ini_set('error_reporting', E_ALL);
        if (!defined('WEB_ROOT')) {
            define('WEB_ROOT', '/');
        }
        $apiVersion = $this->get('apiVersion') ? $this->get('apiVersion') :  self::API_VERSION;
        $this->set('categoriesUrl', self::ENDPOINT_DEV . $apiVersion . '/shoppers/me/categories');
        $this->set('shoppersUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers");
        $this->set('productsUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/products");
        $this->set('cartUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/carts");
        $this->set('cartTaxUrl', self::ENDPOINT_DEV . $apiVersion. "/carts/");
        $this->set('customerUrl', self::ENDPOINT_DEV . $apiVersion. "/customers/");
        $this->set('offerUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/offers/");
        $this->set('promotionUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/point-of-promotions/");
        $this->set('PrivateStoreUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/purchase-plan/");
        $this->set('AcccessTokenUrl', self::ENDPOINT_ADMIN_DEV .'store/');
        $this->set('StoreEndpointUrl', self::ENDPOINT_STORE .'store/');
        $this->set('OauthEndpointUrl', self::ENDPOINT_OAUTH .'oauth20/');
        $this->set('orderUrl', self::ENDPOINT_DEV . $apiVersion. "/shoppers/me/orders/");
    }

    public function get($key){
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
    
    public function set($key, $value) {
        $this->data[$key] = $value;
    }
}