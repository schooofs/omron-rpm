<?php
namespace Digitalriver;

class TestCase extends \PHPUnit\Framework\TestCase {
    protected $settings;
    public function __construct(){
        $this->settings = $this->loadConfigIni();
        parent::__construct();
    }
    protected function loadConfigIni(){
        return parse_ini_file( __DIR__ . DIRECTORY_SEPARATOR, true);
    }
    protected function createClient(){
        // load settings from .ini file
        $settings = $this->settings;
        // validate username, password and MERCHANTAccount
        if ( !empty($settings['applicationname']) && !empty($settings['siteid']) 
            && !empty($settings['privateapikey'])) {
            $client = new Client();
            $client->setApplicationName($settings['applicationname']);
            $client->setSiteId($settings['siteid']);
            $client->setApiKey($settings['apikey']);
            $client->setApiVersion($settings['apiversion']);
            $client->setEnvironment($settings['environment']);
            $client->setTestOrder($settings['testorder']);
            $client->setPrivateApiKey($settings['privateapikey']);
            $client->setSecretKey($settings['secretkey']);
            return $client;
        } else {
            $this->skipTest("Skipped the test. Configure your WebService details in the config");
        }
    }
    protected function skipTest($msg){
        $this->markTestSkipped($msg);
    }

}