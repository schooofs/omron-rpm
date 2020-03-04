# About the Digital River PHP API Reference Implementation 
The Digital River PHP API Implementation is an e-commerce store built using PHP and DR commerce APIs.  This implementation includes various pages such as Home, Category, Product, Cart, and others. Multiple APIs have been used to develop these pages.
Using this implementation, you can:
* Search products 
* Check product details 
* Select products
* Shop products
For more information, refer to [docs folder](/api-reference-store/docs).

## Requirements 
Following are the requirements to access DR API library.
* [PHP 7.0 or Higher](https://www.php.net)
* [Composer](https://getcomposer.org)

Following are the installation steps to install DR API library.
1. Use Composer to get access of this library in your code base.  
2. Add the following dependency in the composer.json.
	```
	{
	"require": 
	{
	"dr-php-commerce-api-library": "1.*"
	}
	}
	```
3. Update your dependencies in the composer.
	```
	Composer Update
	```

## Configuration of DR PHP API Library
Following are the configuration details which are used to consume APIs. You can set these details in the store configuration file and then pass the details when you create API library object.

* SiteId = "DR_SITE_ID"
* PublicApiKey = "DR_PUBLIC_API_KEY"
* PrivateApiKey = "DR_PRIVATE_API_KEY"
* SecretKey = "DR_SECRET_KEY" 

# About Developer Documentation
This API guide helps you understand the usage of Digital River’s (DR) Commerce APIs, which have been used for implementing functionality on this reference store. This guide covers details of the store the pages, steps to access the pages, API details for each page with sample Request, Response, and Implementation codes.
The API guides are placed at [docs folder](/api-reference-store/docs).

## Intended Audience
The intended audience for this guide is a user who want to understand the details of DR Commerce APIs that have been used for various pages of this reference website. The users must have knowledge of how to pass the Request and Response code of the DR APIs.

## Guide Conventions
Following are the text conventions used throughout this guide:

Style | Convention
----- | -----------
Courier New | Code text, request, response, other.
Note | Note includes additional useful information.


