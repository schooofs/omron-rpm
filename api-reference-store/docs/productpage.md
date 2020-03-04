# Product Page
The Product page displays category list, product information, and recommended products. When you select a category or offer, you will redirect to the respective Category page. The Category page displays the list of products which are belong to the selected category. You can select the product to open the respective Product page. 
The RECOMMENDED PRODUCTS section displays the similar products which are similar to selected products. To display the RECOMMENDED PRODUCTS, Offers API with correct Offer ID has been called. 

![Product Page](/api-reference-store/docs/media/productpage.png)
_The Product page_

## Steps to access the Product Page
1. Open the DR Store.
2. Go to Our Products offer and then click a category, for example, Software.
>**_Note_**: Alternatively, you can go another offer to select a product OR you can go to Category list in the header or footer of the page.
The respective page of the category of the product is displayed.
3.	Select the product from the product catalog. 
The Product page with the selected product information is displayed.

![Product Page Steps](/api-reference-store/docs/media/productpagesteps.png)
_Accessing the Product Page_

## Product Page APIs
The Product page provides access to the various product and product information to a shopper. Also, the Product page includes APIs to achieve each of the functionality such as Retrieve Product Information, and Offers. You need to run the API to get the specific functionality. The following provides a list of all APIs that are used in the Product page.

APIs | Description
----- | --------------
Retrieve Product API | The Retrieve Product API is run to retrieve the product information from specific category and default category using Product ID.

Offers API | The Offers API is run to display the products in the **Recommended Products** section. You need to pass the correct Offer ID to in the Request of Offers API. You can call multiple Offers APIs for a single page. For more information, refer to Offers API. 

## Retrieve Product API
The Retrieve Product API retrieves the product information of the products in the product catalog configured in the store. This API also retrieves all the products for a specific category. The API also retrieve the products the default catalog configured for the store. The Product ID is passed in the Request to retrieve the product information.
The product information includes the product image, product description, product subscription details, product features, and product specification. Using Retrieve Product API, you can also add the product in the Cart to shop.
 
![Retrieve Product](/api-reference-store/docs/media/retrieveproduct.png)
_Product information_

For Retrieve a Product API details, refer [Retrieve a Product](/api-reference-store/docs/retrieveproductapi.md)

## Offers API
The Offer is a promotion or discount to attract shoppers to purchase from a store. The Offers API provides access to offers. Once you run the Category API, you can run the Offers API. The Offers API helps to display Offer functionality to the store.
Multiple Offers APIs can be called for single page. You need to change only the Offer ID to display an offer. Each offer has a unique Offer ID. The following offers are shown on the Home page. 
 

### Steps to check the Offers
1. Open the DR store.
2. On the Product page, click **RECOMMENDED PRODUCTS**.

The respective page of the category of the product is displayed.

For Offers API details, refer [Offers API](/api-reference-store/docs/offersapi.md)

