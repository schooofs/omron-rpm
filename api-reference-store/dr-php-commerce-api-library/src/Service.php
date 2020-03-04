<?php 
namespace Digitalriver;
use GuzzleHttp\Client;

class Service
{
    protected $client;
    protected $httpClient;

    public function __construct(\Digitalriver\Client $client)
    {

        if (!$client->getConfig()->get('environment')) {
            // throw exception
            $msg = "The Client does not have a correct environment, use " . \Digitalriver\Environment::STAGING . ' or ' . \Digitalriver\Environment::PRODUCTION;
            throw new \Exception($msg);
        }
        $this->client = $client;
        $this->httpClient = $this->client->getHttpClient();
        
    }

    public function getClient(){
        return $this->client;
    }
    
    protected function getRequest($url , $headers = ['Content-Type' => 'application/json']) {
        $response =  $this->httpClient->request('GET', $url,['headers' =>  $headers]);
        $response = json_decode($response->getBody(), true);
        $response['url'] = $url;
        return $response;
    }
    
    protected function postRequest($url, $data, $headers = null ) {
        $response = $this->httpClient->request('POST', $url, [
            'form_params' => [ $data ],
            'headers' =>  $headers
        ]);
        $response = json_decode($response->getBody(), true);
        $response['url'] = $url;
        return $response;
    }
    
    protected function postJsonRequest($url, $data, $headers=array() ) {
        $response = $this->httpClient->post($url, [
                'json' => $data,
                'headers' => [$headers]
            ]
        );

        $response = json_decode($response->getBody(), true);
        
        return $response;
    }
    
    
    protected function deleteRequest($url , $data, $headers = array() ) {
        $response = $this->httpClient->request('DELETE', $url, [
            'form_params' =>  $data,
            'headers' =>  $headers
        ]);
        return $response;
    }
    
    protected function putRequest($url , $data, $headers = array() ) {
        $response = $this->httpClient->request('PUT', $url, [
            'form_params' => [ $data ],
            'headers' =>  [ $headers ] 
        ]);
        return $response;
    }
}
