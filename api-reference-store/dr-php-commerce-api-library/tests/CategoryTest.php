<?php
namespace Digitalriver;

class CategoryTest extends TestCase {
    protected $_clientObj;
    protected $_categoryService;
    
    public function __construct() {
        parent::__construct();
        $this->_clientObj = $this->createClient();
        $this->_categoryService = new Service\Category($this->_clientObj);
    }
    
    public function testListAllCategories(){
        $allCategories = $this->_categoryService->listAllCategories();
        $hasSessionToken = false;
        if(isset($allCategories['categories']['category'])){
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testListProductsByCategoryId() {
        $allCategoryProducts = $this->_categoryService->
                listProductsByCategoryId($this->settings['categoryId']);
        $hasSessionToken = false;
        if(isset($allCategoryProducts['products']['totalResults'])){
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);
    }
    
    public function testRetrieveCategoryById(){
        $categoryDetails = $this->_categoryService->
                retrieveCategoryById($this->settings['categoryId']);
        $hasSessionToken = false;
        if(isset($categoryDetails['category'])){
            $hasSessionToken = true;
        }
        $this->assertEquals(true, $hasSessionToken);
    }
}

