# Category API

The Category API provides access to the various product categories that are available to a shopper. This API is used to pull the various categories under which the products are grouped on the site. This is usually needed to display items of a menu, either in the header/footer or sides of the page. Here, the products in the GC catalog are segregated into various categories such as Electronics, Software. Since the menu is being used on all pages of this store, the API is common for all. When you run the Category API, the list of categories is then displayed on the header and footer of all the pages. When you click the category in the list, the respective page of the category is displayed. 

## Digital River Global Commerce (GC) link
Click the following GC link to open the **Category API** reference.
[https://developers.digitalriver.com/reference#v1shoppersmecategoriesget](https://developers.digitalriver.com/reference#v1shoppersmecategoriesget)

## API Library Service Class
Category.php

## Class Method
listAllCategories()

## Parameters 
The **Category API** includes the following parameters.

Parameters | Description
----------- | ------------
apiKey*	| This is a client identification key of the DR store. This key is common for all the APIs of this store.
token	| This is an authorized token for a shopper.
expand	| This provides additional parameters of the resources. This parameter is used if you want to get the values of all the fields Response.
fields	| This reduces the set of fields in the resource which you have specifically request.
currency | This is the preferred currency for the pricing information returned for a product. The currency parameter is set based on the country where this store will be used.
locale	| This is the pricing information of the product in the local region. The locale parameter is set based on the usage and availability of the product.
productsPageSize | This is used to display maximum number of the product in each category on the page. The value of this parameter must be a positive integer greater than zero and less than 100000. The Default value is 10.

>**_Note_:** *The parameters of the **Category API** are included in the API library. However, for the sample Request, only few parameters have been used. You can use the parameters as per your requirement*


## Sample Request 
The following is a sample Request to display category in the header of the page.

```
$queryParameter= ‘token=#token#&expand=all’;
$categoryObj->listAllCategories($queryParameter);
```
   
 
## Sample Response 
The following is a sample Response to display category in the header of the page.

```
array(1) {
  ["categories"]=>
  array(2) {
    ["uri"]=>
    string(54) "[https://api.digitalriver.com/v1/shoppers/me/categories](https://www.google.com)"
    ["category"]=>
    array(5) {
      [0]=>
      array(3) {
        ["uri"]=>
        string(63) "https://api.digitalriver.com/v1/shoppers/me/categories/70229600"
        ["displayName"]=>
        string(8) "Software"
        ["products"]=>
        array(1) {
          ["uri"]=>
          string(72) "https://api.digitalriver.com/v1/shoppers/me/categories/70229600/products"
        }
      }
      [1]=>
      array(3) {
        ["uri"]=>
        string(63) "https://api.digitalriver.com/v1/shoppers/me/categories/70229700"
        ["displayName"]=>
        string(11) "Electronics"
        ["products"]=>
        array(1) {
          ["uri"]=>
          string(72) "https://api.digitalriver.com/v1/shoppers/me/categories/70229700/products"
        }
      }
      [2]=>
      array(3) {
        ["uri"]=>
        string(63) "https://api.digitalriver.com/v1/shoppers/me/categories/70229800"
        ["displayName"]=>
        string(21) "Games & Entertainment"
        ["products"]=>
        array(1) {
          ["uri"]=>
          string(72) "https://api.digitalriver.com/v1/shoppers/me/categories/70229800/products"
        }
      }
      [3]=>
      array(3) {
        ["uri"]=>
        string(63) "https://api.digitalriver.com/v1/shoppers/me/categories/70230200"
        ["displayName"]=>
        string(14) "Special Offers"
        ["products"]=>
        array(1) {
          ["uri"]=>
          string(72) "https://api.digitalriver.com/v1/shoppers/me/categories/70230200/products"
        }
      }
      [4]=>
      array(3) {
        ["uri"]=>
        string(65) "https://api.digitalriver.com/v1/shoppers/me/categories/4951658000"
        ["displayName"]=>
        string(5) "Vizio"
        ["products"]=>
        array(1) {
          ["uri"]=>
          string(74) "https://api.digitalriver.com/v1/shoppers/me/categories/4951658000/products"
        }
      }
    }
  }
}
```
 

## Sample Implementation 
The following is a sample Implementation of the **Category API**. Here, the response Array Object $category holds all the information to display the offer. 

```
<div class="collapse navbar-collapse order-3 order-lg-2" id="navbarNavDropdown">
    <ul class="navbar-nav">
        <?php foreach ( $categories as $category ) {
          $categoryId = '';
          $categoryArray = explode('categories/', $category['uri']);
          if( isset($categoryArray[1])) {
              $categoryId = $categoryArray[1];
          }
          ?> 
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('category/products/').'?id='.$categoryId;?>">
                    <?php echo strtoupper($category['displayName']); ?>
                </a>
            </li>
       <?php } ?>
    </ul>
</div>
```
