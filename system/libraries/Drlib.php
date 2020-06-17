<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Drlib
{
    public function __construct()
    {
        require_once APPPATH.'third_party/dr-api-library/src/environment.php';
        require_once APPPATH.'third_party/dr-api-library/src/client.php';
        require_once APPPATH.'third_party/dr-api-library/src/config.php';
        require_once APPPATH.'third_party/dr-api-library/src/Service.php';
        require_once APPPATH.'third_party/dr-api-library/src/Service/Authenticate.php';
        require_once APPPATH.'third_party/dr-api-library/src/Service/Offer.php';
        require_once APPPATH.'third_party/dr-api-library/src/Service/Cart.php';
        require_once APPPATH.'third_party/dr-api-library/src/Service/Category.php';
        require_once APPPATH.'third_party/dr-api-library/src/Service/Order.php';
        require_once APPPATH.'third_party/dr-api-library/src/Service/PrivateStore.php';
        require_once APPPATH.'third_party/dr-api-library/src/Service/Products.php';
        require_once APPPATH.'third_party/dr-api-library/src/Service/Promotion.php';
        require_once APPPATH.'third_party/dr-api-library/src/Service/Shopper.php';
    }
}
