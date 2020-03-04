# Home Page 
The Home page of the demo store displays the product categories and offers. 
![Home Page](/api-reference-store/docs/media/homepage.png)
_The Home page_

The Home page includes the following page elements.

Page Element | Description
------------ | -----------
Category list |	Category list is the list of categories of the products. Along with header, the list is also displayed in footer of all the pages of the DR store.
Offers | Offers are used to highlight products under different promotional categories, such as our product, product with special offer, popular product. The Shop option is also displayed with individual category.

## Home Page APIs
The Home page includes APIs to achieve each of the functionality such as Categories and Offers. You need to run the API to get the specific functionality. The following provides a list of all APIs that are used in the Home page.

APIs | Description
----- | --------------
Category API | When you run this API, the list of categories on the product catalog will be displayed on the header and footer on all the pages of the store. For more information, refer to Category API.

Offers API | The Offers API is run to pull the current promotional offers on the site, which may have discounts or other offers tagged to the products included in the Global commerce offer. When you run this API, the offer whose ID you have added in the API call will be displayed. You can call multiple Offer APIs for single page. You need to only change the Offer ID. For Home page, four Offers have been used. For more information, refer to Offers API. 


## Category API
The Category API provides access to the various product categories that are available to a shopper. This API is used to pull the various categories under which the products are grouped on the site. This is usually needed to display items of a menu, either in the header/footer or sides of the page. Here, the products in the GC catalog are segregated into various categories such as Electronics, Software. Since the menu is being used on all pages of this store, the API is common for all. When you run the Category API, the list of categories is then displayed on the header and footer of all the pages. When you click the category in the list, the respective page of the category is displayed. 

![Header](/api-reference-store/docs/media/header.png)
_The Category list in the header_

![Footer](/api-reference-store/docs/media/footer.png)
_The Category list in the footer_

### Steps to Access the Category List
1. Open the DR store.
2. Go to the header and then click a category, for example, **ELECTRONICS**.

>**_Note_**: Alternatively, you can go to the footer and select a category. 
The ELECTRONICS page is displayed.

![Electronics](/api-reference-store/docs/media/electronics.png)
_The ELECTRONICS page_

For Category API details, refer [Category API](/api-reference-store/docs/categoryapi.md)

## Offers API
The Offer is a promotion or discount to attract shoppers to purchase from a store. The Offers API provides access to offers. Once you run the Category API, you can run the Offers API. The Offers API helps to display Offer functionality to the store.
Multiple Offers APIs can be called for single page. You need to change only the Offer ID to display an offer. Each offer has a unique Offer ID. The following offers are shown on the Home page. 
 
![Offers](/api-reference-store/docs/media/offers.png)
_Offers_
 
Offers	| Description	| Action
------- | -------------- | -------
TIME FOR AN UPGRADE	| This offer displays the sales pitch (banner) with the recommended text and Shop Now option. |	Click Shop Now, the page of the respective product is displayed.
OUR PRODUCTS | This offer displays an individual category of the product with Shop Now option. | Click Shop Now, the page of the respective product is displayed.
SPECIAL OFFERS | This offer displays special offer on the product with Shop Now option. | Click Shop Now, the page of the respective product is displayed.
CROWD FAVORITES | This offer displays the popular product with product with Shop Now option. | Click Shop Now, the page of the respective product is displayed.

### Steps to Check the Offers
1. Open the DR store.
2. On the Home page, click **SPECIAL OFFERS**.
The respective page of the category of the product is displayed.
 
![Special Offers](/api-reference-store/docs/media/specialoffers.png)
_SPECIAL OFFERS_

For Offers API details, refer [Offers API](/api-reference-store/docs/offersapi.md)


