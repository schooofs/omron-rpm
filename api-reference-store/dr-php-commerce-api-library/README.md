# About Digital River Commerce API Client Library for PHP 
The Digital River (DR) Client Library provides ability to use Commerce APIs. This library contains service classes and functions for each API.

## Requirements 
Following are the requirements to access the client library for PHP.
* [PHP 7.0 or Higher](https://www.php.net)
* [Composer](https://getcomposer.org)

## Installation
Following are the installation steps to install the client library for PHP.
1.	Use Composer to get access of this library in your code base.  
2.	Add the following dependency in the composer. json.

```
{
"require": 
{
"dr-php-commerce-api-library": "1.*"
}
}
```
3.	Update your dependencies in the composer.
```
Composer Update
```

## Configuration of DR PHP API Library
Following are the configuration details which are used to consume APIs. You can set these details in the store configuration file and then pass the details when you create API library object.
* SiteId = "DR_SITE_ID"
* PublicApiKey = "DR_PUBLIC_API_KEY"
* PrivateApiKey = "DR_PRIVATE_API_KEY"
* SecretKey = "DR_SECRET_KEY" 

### Steps to configure the DR reference Store 
Following are the configuration steps.
1.	Configure a Client Object. 
Following is the sample code to configure a client object.
```
private $_client;
public function __construct() 
{
$this->_client = new Digitalriver\Client();
$this->_client->setApplicationName(“YOUR_APPLICATION NAME”);
$this->_client->setSiteId(“YOUR_DR_SITE_ID”);
$this->_client->setApiKey(“YOUR_PUBLIC_API_KEY”);
$this->_client->setApiVersion(“v1”);
$this->_client->setEnvironment(“PRODUCTION/STAGING/LOCAL”);
$this->_client->setTestOrder(“SET_TRUE_FOR_TEST_ORDER”);
$this->_client->setPrivateApiKey(“YOUR_PRIVATE_KEY”);
$this->_client->setSecretKey(“YOUR_SECRET_KEY”);
}
```

2.	Create an object of Service Class by passing by passing Client Object to this class constructor. 
Following is the sample code to create an object for Category Service. 
```
$categoryService = new Digitalriver\Service\Category($this->_client);

```
3.	Call Service Call API Function using Class Object. 
Following is the sample code of API to get all product categories. 

```
$allCategories = $categoryService->listAllCategories();
```

## About Developer Documentation
This API guide helps you understand the usage of Digital River’s (DR) Commerce APIs, which have been used for implementing functionality on this reference library. This guide covers details of the store te pages, steps to access the pages, API details for each page with sample Request, Response, and Implementation codes.
The API Guide segregated according to the common APIs and pages in the DR website. The API guides are placed at [docs folder](/api-reference-store/dr-php-commerce-api-librarycommerce-api-library/docs). 

### Intended Audience
The intended audience for this guide is a user who want to understand the details of DR Commerce APIs that have been used for various pages of this reference website. The users must have knowledge of how to pass the Request and Response code of the DR APIs.

### Guide Conventions
Following are the text conventions used throughout this guide:

Style | Convention
----- | -----------
Courier New | Code text, request, response, other.
Note | Note includes additional useful information.


