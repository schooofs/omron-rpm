<?php
namespace Digitalriver;

class OfferTest extends TestCase {
    protected $_clientObj;
    protected $_offerService;
    
    public function __construct() {
        parent::__construct();
        $this->_clientObj = $this->createClient();
        $this->_offerService = new Service\Offer($this->_clientObj);
    }
    
    public function testGetOffer(){
        $offerDetails = $this->_offerService->getOffer($this->settings['offerId']);
        $hasSessionToken = false;
        if(isset($offerDetails['offer'])){
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testGetCategoryOffers(){
        $offerDetails = $this->_offerService->getCategoryOffers($this->settings['offerId']);
        $hasSessionToken = false;
        if(isset($offerDetails['categoryOffers'])){
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testGetProductOffers(){
        $offerDetails = $this->_offerService->getProductOffers($this->settings['offerId']);
        $hasSessionToken = false;
        if(isset($offerDetails['productOffers'])){
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);
    }
}

