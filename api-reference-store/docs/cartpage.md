# Cart Page
The Cart page displays a list products that you have added in the cart to shop. When you click on the Add to Cart option, you will redirect to the Cart page. 
The Cart page includes following four sections.

Sections | Description
--------- | -----------
Product information and cart actions | In this section, the product information of the product that you have added in the cart is displayed. You can also perform various cart actions such as update the quantity of the product, change the shipping method.
Log on with existing user and checkout | In this section, you can type your Shopper’s credential to log on to the DR store to shop the product. 
Create Shopper and Checkout | In this section, you can create your Shopper’s account on the DR store to shop the product.
Guest Checkout | In this section, you can shop the product as a guest if you do not want to become an authorized shopper of the DR store. 

![Cart Page](/api-reference-store/docs/media/cartpage.png)
_The Cart page_
 
## Steps to Access the Cart Page
1. Open the DR store.
2. Go to Our Products offer and then click a category, for example, Software.
> **Note**: Alternatively, you can go another offer to select a product OR you can go to Category list in the header or footer of the page.
The respective page of the category of the product is displayed.
3. Select the product from the product catalog. 
The Product page with the selected product information is displayed.
4. On the Product page, click Add to Cart. Select the product from the product catalog. 
The Cart page with selected product information is displayed.

 
![Cart Page Steps](/api-reference-store/docs/media/cartpagesteps.png)
_Accessing the Cart Page_

## Cart Page APIs
Each section on eh Cart page includes multiple APIs. To display the particular section, the respective APIs need to be called in sequence. The APIs are developed to achieve the functionality of the page such as get product information and perform cart actions, create Shoppers account. 
Following are the APIs are used for each section on the Cart page. 
Sections | APIs
--------- | ------
Product information and cart actions | 	1. Get DR session Token
					                    2. Get limited access token
					                    3. Update a cart
					                    4. Update line item 
					                    5. Remove line item
					                    6. Retrieve a Cart 
Log on with existing user and checkout 	| 	 												
Create Shopper and Checkout |	 
Guest Checkout	|  1. Update billing details
		           2. Update cart payment method
>**Note**: The APIs must be run in sequence only.
 
### Product Information and  Cart Actions
This section displays the product name, product image, product price. You can update or remove the quantity of the product using Cart page. You can also select the Shipping method from the drop-down list  
Product Information
Following are the APIs that need to be run in sequence to display the product information and to perform the cart actions. 

1. [Get DR Session Token API](/api-reference-store/docs/cartpage/productinformationandcartactions/getdrsessiontokenapi.md)
2. [Get Limited Access Token API](/api-reference-store/docs/cartpage/productinformationandcartactions/getlimitedaccesstokenapi.md)
3. [Update a Cart API](/api-reference-store/docs/cartpage/productinformationandcartactions/updatecartapi.md)		
4. [Update Line Item API](/api-reference-store/docs/cartpage/productinformationandcartactions/updatelineitemapi.md)	
5. [Remove Line Item API](/api-reference-store/docs/cartpage/productinformationandcartactions/removelineitemapi.md)
5. [Retrieve a Cart API](/api-reference-store/docs/cartpage/productinformationandcartactions/retrieveacartapi.md)	

### Guest Checkout 
In this section, you can place the order as a Guest. To checkout as a Guest, no need to create a Shopper account on the DR store.
On the cart page, click **CHECKOUT AS GUEST** to shop the product. In the Billing Information and Payment Information boxes, add the respective information to shop the product.
 
Following are the APIs that need to be run in sequence to checkout as a guest. 
1. [Update Billing Method](/api-reference-store/docs/cartpage/guestcheckout/updatebillingdetailsapi.md)2. [Update Cart Payment Method](/api-reference-store/docs/cartpage/guestcheckout/updatecartpaymentmethodapi.md)