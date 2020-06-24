<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller  {

    public function __construct() {
        parent::__construct();

        $this->_client = new Digitalriver\Client();
        $this->_client->setApplicationName($this->config->item('application_name'));
        $this->_client->setSiteId($this->config->item('site_id'));
        $this->_client->setApiKey($this->config->item('api_key'));
        $this->_client->setApiVersion($this->config->item('api_version'));
        $this->_client->setEnvironment($this->config->item('environment'));
        $this->_client->setTestOrder($this->config->item('test_order'));
        $this->_client->setSecretKey($this->config->item('secretKey'));

    }


    /**
     * Used to charge users automatically
     * This function is called by cron job once at 25th of the month at midnight 00:00 
     */
    public function monthlySubmissions() {
        $authService = new Digitalriver\Service\Authenticate($this->_client);
        $cartService = new Digitalriver\Service\Cart($this->_client);
        $shopperService = new Digitalriver\Service\Shopper($this->_client);

        // Allow only cli access
        if($this->input->is_cli_request()) {
            
            $submissions = $this->submission->getThisMonth();
            // $submissions = $this->submissions->getUnprocessed();
            if (!$submissions) {
                echo '---------------------------------------------------------------------------' . PHP_EOL;
                echo 'No data submissions were found!' . PHP_EOL;
                echo '---------------------------------------------------------------------------' . PHP_EOL;
                exit;
            }

            foreach($submissions as $key => $submission) {

                if( $submission->order_submitted ) {
                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                    echo 'No unprocessed submissions were found for ' . date('m-Y') . PHP_EOL;
                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                    exit;
                    continue;
                }

                $user = $this->user->getById($submission->user_id);
                $accessToken = $authService->generateAccessTokenByRefId($user->gc_reference);
                $fullAccessToken = $accessToken['access_token'];

                if (empty($fullAccessToken)){
                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                    echo 'Failed to authenticate user [' . $user->gc_reference . '] within DR Global Commerce.' . PHP_EOL;
                    echo 'Failed to process submission with ID [' . $submission->id . '] and EHR ID ['. $user->physician_id .']' . PHP_EOL;
                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                    continue;
                }

                $items = json_decode($submission->items, true);
                foreach($items as $item) {
                    $cartService->updateLineItem( $item['sku'], $fullAccessToken, 'add', $item['quantity'] );
                }

                $cartService->applyShopper($fullAccessToken);
                $cartService->submitCart($fullAccessToken);

                $this->submission->update([
                    'data_processed_time' => time(),
                    'order_submitted'     => 1,
                ], $submission->id);

                echo '---------------------------------------------------------------------------' . PHP_EOL;
                echo 'Submission with ID "' . $submission->id . '" and EHR ID "'. $user->physician_id .'" was processed.' . PHP_EOL;
                echo '---------------------------------------------------------------------------' . PHP_EOL;
            }

            echo '---Done---' . PHP_EOL;

        } else {
            echo "You dont have access";
        }
    }
}