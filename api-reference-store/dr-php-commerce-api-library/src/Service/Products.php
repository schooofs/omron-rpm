<?php
/* 
 * The Products Class provides access to products and product data. 
 * This class returns products across all categories. Use the Products class to:
 *      Retrieve all products for a specified category
 *      Retrieve all products from the default catalog configured for a site
 *      Get a product by ID
 * Version : 1.0
 * Date : 02/08/2019
 */
namespace Digitalriver\Service;

class Products extends \Digitalriver\Service {

    public function __construct(\Digitalriver\Client $client) {
        parent::__construct($client);
    }
    
    /**** 
     *  Returns all product data from your Digital River catalog
    */
    public function listAllProducts( $queryParm = null) {
        
        $url = $this->client->getConfig()->get('productsUrl') . '?apiKey='. 
                $this->client->getConfig()->get('apiKey');
        
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /****
     *  Retrieves the detail of a product. Required product ID as input
    */
    public function getProductByID( $productId,  $queryParm = '&expand=all' ) {
        if( !$productId ) {
            throw new \Exception("Product id is not found");
        }
        $url = $this->client->getConfig()->get('productsUrl').'/'.$productId. 
                '?apiKey='. $this->client->getConfig()->get('apiKey').$queryParm;
        
        return  $this->getRequest($url);
    }
    
    /****
     *  Retrieve the inventory status for a product. Required product ID as input
    */
    public function getInventoryStatus( $productId, $queryParm = null ) {
        if( !$productId ) {
            throw new \Exception("Product id is not found");
        }
        $url = $this->client->getConfig()->get('productsUrl').'/'.$productId. 
                '/inventory-status/?apiKey='. $this->client->getConfig()->get('apiKey');
        
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /****
     *  Retrieve product pricing. Required product ID as input
    */
    public function getProductPrice( $productId, $queryParm = null ) {
        if( !$productId ) {
            throw new \Exception("Product id is not found");
        }
        $url = $this->client->getConfig()->get('productsUrl').'/'.$productId. 
                '/pricing/?apiKey='. $this->client->getConfig()->get('apiKey');
        
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /****
     *  Retrieve a specific Point of Promotion of product
     *  Required product ID, popName, ApiKey
    */
    public function getPOP( $productId, $popName, $queryParm=null ) {
        if( !$productId || !$popName ) {
            throw new \Exception("Product id or POPName is missing");
        }
        $url = $this->client->getConfig()->get('productsUrl').'/'.$productId. 
                '/point-of-promotions/'.$popName.'/?apiKey='. 
                $this->client->getConfig()->get('apiKey');
        
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /***
     * Returns all product variants
     * Required product ID as input
    */
    public function getProductVariations( $productId, $queryParm = null ) {
        if( !$productId ) {
            throw new \Exception("Product id is not found");
        }
        $url = $this->client->getConfig()->get('productsUrl').'/'.$productId. 
                '/variations/?apiKey='. $this->client->getConfig()->get('apiKey');
        
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /***
     * Returns all categories for a specific product.
     * Required product ID as input
    */
    public function getProductCategories( $productId, $queryParm = null ) {
        if( !$productId ) {
            throw new \Exception("Product id is not found");
        }
        $url = $this->client->getConfig()->get('productsUrl').'/'.$productId. 
                '/categories/?apiKey='. $this->client->getConfig()->get('apiKey');
        
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /***
     * Retrieve financing terms for a product.
     * Required product ID as input
    */
    public function getProductFinancing( $productId, $queryParm = null ) {
        if( !$productId ) {
            throw new \Exception("Product id is not found");
        }
        $url = $this->client->getConfig()->get('productsUrl').'/'.$productId. 
                '/financing/?apiKey='. $this->client->getConfig()->get('apiKey');
        
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
    /****
     *  Returns the all Point of Promotion (POPs) offers for a product. 
     *  Required product ID as input
    */
    public function getListOfPOP( $productId, $queryParm=null ) {
        if( !$productId ) {
            throw new \Exception("Product id or POPName is missing");
        }
        $url = $this->client->getConfig()->get('productsUrl').'/'.$productId. 
                '/point-of-promotions/?apiKey='. 
                $this->client->getConfig()->get('apiKey');
        
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
     /****
     *  Retrieve all offers for a product and Point of Promotion (POPs). 
     *  Required product ID, Pop Name as input
    */
    public function getAllOffers( $productId, $popName, $queryParm=null ) {
        if( !$productId || !$popName ) {
            throw new \Exception("Product id or POPName is missing");
        }
        $url = $this->client->getConfig()->get('productsUrl').'/'.$productId. 
                '/point-of-promotions/'.$popName.'/offers/?apiKey='. 
                $this->client->getConfig()->get('apiKey');
        
        if ( $queryParm ) {
            $url .= '&'.$queryParm;
        }
        
        return  $this->getRequest($url);
    }
    
}