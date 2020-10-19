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
        // $shopperService = new Digitalriver\Service\Shopper($this->_client);

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

                $user = $this->user->getById($submission->user_id);

                if(!$user){
                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                    echo 'User was not found with ID [' . $submission->user_id . '] ' . PHP_EOL;
                    echo 'Failed to process submission with ID [' . $submission->id . '] ' . PHP_EOL;
                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                    continue;
                }

                if( $submission->order_submitted ) {
                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                    echo 'Submission with ID "' . $submission->id . '" and Account Number "'. $user->physician_id .'" was already processed on ' . date("D M j G:i:s T Y", $submission->data_processed_time )  . ' ' . PHP_EOL;
                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                    continue;
                }

                $accessToken = $authService->generateAccessTokenByRefId($user->gc_reference);
                $fullAccessToken = $accessToken['access_token'];

                if (empty($fullAccessToken)){
                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                    echo 'Failed to authenticate user [' . $user->gc_reference . '] within DR Global Commerce.' . PHP_EOL;
                    echo 'Failed to process submission with ID [' . $submission->id . '] and Account Number ['. $user->physician_id .']' . PHP_EOL;
                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                    continue;
                }

                $submittion_data = json_decode($submission->data, true);
                $cartService->applyShopper($fullAccessToken);
                $payment_type = $cartService->retrieveCart($fullAccessToken)['cart']['paymentMethod']['type'];
                $items = json_decode($submission->items, true);
                $cart_total = $cartService->retrieveCart( $fullAccessToken )['cart']['pricing']['orderTotal']['value'];

                if( isset($items) ) {
                    if ( $payment_type !== 'creditCard' ) {
                        foreach($items as $item) {
                            $cartService->updateLineItem( $item['sku'], $fullAccessToken, 'add', $item['quantity'] );
                        }
                    } else {
                        foreach($items as $item) {
                            $item_qty = $item['quantity'];
                            $added_qty = 0;
                            $cart_limit = 59999;
                            
                            $cartService->updateLineItem( $item['sku'], $fullAccessToken, 'add', 1 );
                            $added_qty++;
                            
                            $single_item_price = $cartService->retrieveCart( $fullAccessToken )['cart']['pricing']['orderTotal']['value'] - $cart_total;

                            $cart_total = $cartService->retrieveCart( $fullAccessToken )['cart']['pricing']['orderTotal']['value'];
                            
                            if ( $cart_total > $cart_limit ) {
                                $cartService->updateLineItem( $item['sku'], $fullAccessToken, 'update', -1 );
                                $cart_total = $cartService->retrieveCart( $fullAccessToken )['cart']['pricing']['orderTotal']['value'];
                                $added_qty--;

                                $cartService->applyShopper($fullAccessToken);
                                $cartService->submitCart($fullAccessToken);
                                
                                echo '---------------------------------------------------------------------------' . PHP_EOL;
                                echo ' --- Submit Part of Submission with total: ' . $cart_total . PHP_EOL;
                                echo '---------------------------------------------------------------------------' . PHP_EOL;
                            }

                            while( $added_qty < $item_qty ) {
                                if ( $single_item_price * ( $item['quantity'] - $added_qty ) < $cart_limit ) {
                                    $cartService->updateLineItem( $item['sku'], $fullAccessToken, 'add', $item['quantity'] - $added_qty );
                                    $added_qty = $item_qty;
                                } else {
                                    $remaining_to_limit = $cart_limit - $cart_total;
                                    $qty_to_limit = intval( $remaining_to_limit / $single_item_price );
                                    $cartService->updateLineItem( $item['sku'], $fullAccessToken, 'add', $qty_to_limit );
                                    $cart_total = $cartService->retrieveCart( $fullAccessToken )['cart']['pricing']['orderTotal']['value'];
                                    $added_qty += $qty_to_limit;
                                    
                                    $cartService->applyShopper($fullAccessToken);
                                    $cartService->submitCart($fullAccessToken);
                                    
                                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                                    echo ' --- Submit Part of Submission with total: ' . $cart_total . PHP_EOL;
                                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                                }

                                $cart_total = $cartService->retrieveCart( $fullAccessToken )['cart']['pricing']['orderTotal']['value'];
                            }
                        }
                    }

                    $cartService->submitCart($fullAccessToken);

                    $this->submission->update([
                        'data_processed_time' => time(),
                        'order_submitted'     => 1,
                    ], $submission->id);

                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                    echo ' --- Submit Cart with total: ' . $cart_total . PHP_EOL;
                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                    echo 'Submission with ID "' . $submission->id . '" and Account Number "'. $user->physician_id .'" was processed.' . PHP_EOL;
                    echo '---------------------------------------------------------------------------' . PHP_EOL;

                } else {

                    echo '---------------------------------------------------------------------------' . PHP_EOL;
                    echo 'Submission with ID "' . $submission->id . '" and Account Number "'. $user->physician_id .'" was NOT processed.' . PHP_EOL;
                    echo '---------------------------------------------------------------------------' . PHP_EOL;

                }


            }

            echo '---Done---' . PHP_EOL;

        } else {
            echo "You dont have access";
        }
    }
}