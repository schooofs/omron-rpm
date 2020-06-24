<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Cordial
{

    protected $httpClient;

    protected $apiKey = '5eea0dbd5e720f2a561a03c9-xEw5Wygc494WdfSL2XKEJTXYZWxZmVUL';

    protected $endPoint = 'https://api.cordial.io/v2/automationtemplates/';

    public function __construct() {
        if (is_null($this->httpClient)) {
            $this->httpClient = new \GuzzleHttp\Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'accept' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode($this->apiKey.':'),
                ]
            ]);
        }
    }

    public function postMonthlyStatement($data) {
        $response = $this->httpClient->request('POST', $this->endPoint . 'physiciansportal_monthly_Statement/send' ,  [
            'form_params' => $data,
        ] );
        $response = json_decode($response->getBody(), true);
        $response['url'] = $this->endPoint;
        return $response;
    }

    // public function postPasswordReset($data) {
    //     $response = $this->httpClient->request('POST', $this->endPoint . 'test/send' ,  [
    //         'form_params' => $data,
    //     ] );
    //     $response = json_decode($response->getBody(), true);
    //     $response['url'] = $this->endPoint;
    //     return $response;
    // }
}