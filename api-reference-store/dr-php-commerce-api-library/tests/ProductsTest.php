<?php
namespace Digitalriver;

class ProductsTest extends TestCase {
    protected $_clientObj;
    protected $_productService;
    
    public function __construct(){
        parent::__construct();
        $this->_clientObj = $this->createClient();
        $this->_productService = new Service\Products($this->_clientObj);
    }
    
    public function testListAllProducts(){
        $products = $this->_productService ->listAllProducts();
        $hasSessionToken = false;
        if(isset($products['products']['product'])) {
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testGetProductByID(){
        $product = $this->_productService->getProductByID($this->settings['productId']);
        $hasSessionToken = false;
        if(isset($product['product'])) {
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testGetInventoryStatus() {
        $product = $this->_productService->getInventoryStatus($this->settings['productId']);
        $hasSessionToken = false;
        if(isset($product['inventoryStatus'])) {
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testGetProductPrice(){
        $product = $this->_productService->getProductPrice($this->settings['productId']);
        $hasSessionToken = false;
        if(isset($product['pricing'])) {
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken); 
    }
    
    public function testGetPOP(){
        $product = $this->_productService->getPOP($this->settings['productId'],
                                        $this->settings['popName']);
        $hasSessionToken = false;
        if(isset($product['pointOfPromotion'])) {
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken); 
    }
    
    public function testGetProductVariations(){
        $product = $this->_productService->getProductVariations($this->settings['productId']);
        $hasSessionToken = false;
        if(isset($product['variations'])) {
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken); 
    }
    
    public function testGetProductCategories(){
        $product = $this->_productService->getProductCategories($this->settings['productId']);
        $hasSessionToken = false;
        if(isset($product['categories'])) {
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken); 
    }
    
    public function testGetProductFinancing(){
        $product = $this->_productService->getProductFinancing($this->settings['productId']);
        $hasSessionToken = false;
        if(isset($product['financing'])) {
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken); 
    }
    
    public function testGetListOfPOP(){
        $product = $this->_productService->getListOfPOP($this->settings['productId']);
        $hasSessionToken = false;
        if(isset($product['pointOfPromotions'])) {
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken); 
    }
    
    public function testGetAllOffers(){
        $product = $this->_productService->getAllOffers($this->settings['productId'],
                                            $this->settings['popName']);
        $hasSessionToken = false;
        if(isset($product['offers'])) {
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);   
    }
}

