<?php 
namespace Digitalriver\Service;

class Category extends \Digitalriver\Service {
   
    public function __construct(\Digitalriver\Client $client) {
        parent::__construct($client);
    }
    
    /***
     * Returns all of the categories and sub-categories within a product catalog
    */
    public function listAllCategories( $queryParm = null ){
        $url = $this->client->getConfig()->get('categoriesUrl'). 
            '?apiKey='. $this->client->getConfig()->get('apiKey');
        
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /*** 
    *  Returns all base products for a specified category.
    *  Requires category ID as input
    */
    public function listProductsByCategoryId($categoryId, $queryParm = null){
        if ( !$categoryId ) {
            throw new \Exception("Category id is not passed");
        }
        $url = $this->client->getConfig()->get('categoriesUrl') . '/'. $categoryId.
            '/products' . '?apiKey='. $this->client->getConfig()->get('apiKey');
        
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /*
     * Retrieves a single category and its subcategories. 
     *  Requires category ID as input
    */
    public function retrieveCategoryById($categoryId, $queryParm = null ){
        if ( !$categoryId ) {
            throw new \Exception("Category id is not passed");
        }
        $url = $this->client->getConfig()->get('categoriesUrl') .'/'. $categoryId 
            . '?apiKey='. $this->client->getConfig()->get('apiKey');
        
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);   
    }
}
