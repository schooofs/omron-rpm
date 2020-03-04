<?php 
namespace Digitalriver;

class Client
{
    
    private $httpClient;
    public $config;

    public function __construct($config = null){
        if (!$config) {
            // create config
            $this->config = new \Digitalriver\Config();
        }
    }

    public function getHttpClient(){
        if (is_null($this->httpClient)) {
            $this->httpClient = new \GuzzleHttp\Client([
                'headers' => ['accept' => 'application/json']
            ]);
        }
        return $this->httpClient;
    }


    public function setEnvironment($environment) {
        $this->config->setEnvironment($environment);
    }

    public function setApiKey($apiKey){
        $this->config->set('apiKey',$apiKey);
    }

    public function setApiVersion($version){
        $this->config->set('apiVersion',$version);
    }

    public function setApplicationName($applicationName){
        $this->config->set('applicationName', $applicationName);
    }

    public function setSiteId($siteId){
        $this->config->set('siteId', $siteId);
    }
    
    public function setTestOrder($testOrder){
        $this->config->set('testOrder', $testOrder);
    }

    public function getConfig(){
        return $this->config;
    }
    
    public function setPrivateApiKey($privateApiKey){
        $this->config->set('privateApiKey', $privateApiKey);
    }
    
    public function setSecretKey($secretKey){
        $this->config->set('secretKey', $secretKey);
    }

}