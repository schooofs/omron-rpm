<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Digital River Demo Store</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <script src="https://js.digitalriver.com/v1/DigitalRiver.js"></script> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">       
    </head>
    <body>
        <header>
            <div class="flex-container">
                <div class="usa-flag">
                    <span class="usa">
                        <img src="<?php echo base_url(); ?>assets/images/usa_country_flag.png" alt="usaFlag"/>
                        <span class="country">USA </span>
                    </span> 
                </div>
                <div  class="shipping-info d-none d-md-none d-lg-block">
                    This site is intended for demonstration purpose only. Actual products will not be shipped.
                </div>
                <!-- <div  class="login-signup">
                    <a href="#">LOGIN</a>
                    <a class="signUp" href="#">Sign Up</a>
                </div> -->
            </div>
            <div class="card">
                <nav class="navbar navbar-light navbar-expand-lg navbar-template">
                    <a class="navbar-brand brand-logo" href="<?php echo base_url(); ?>">
                        <img src="<?php echo base_url(); ?>assets/images/DR-Demo-Store_New.png" alt="logo"/></a>
                    <div class="d-flex flex-row order-2 order-lg-3 cart-search-toggler">
                        <ul class="navbar-nav flex-row ">
                            <li class="nav-item">
                                <a class="nav-link px-2" href="#"><span class="quantityItem"> 
                                    <img src="<?php echo base_url(); ?>assets/images/cart.png" alt="cart-icon"/>
                                    <span id="total" class="bg-dark text-white rounded-circle px-2 py-0.5 h6">1</span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2" href="#">
                                    <span id="search-img">
                                       <img id="search" src="<?php echo base_url(); ?>assets/images/search1.png" alt="search-icon"/>
                                       <div class="search-box">
                                          <!--<form>-->
                                                <input type="text" placeholder="Search.." title="search here" name="search2">
                                                <button aria-label="Search Icon" title="Search Icon" type="submit">
                                                    <i aria-hidden="true" class="fa fa-search"></i>
                                                </button>
                                          <!--</form>-->
                                       </div>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <button class="navbar-toggler" id="toggler" 
                                aria-label="Toggle Icon" title="Toggle Icon" type="button" data-toggle="collapse" data-target="#navbarNavDropdown">
                            <span aria-hidden="true" class="navbar-toggler-icon" id="toggler-icon"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse order-3 order-lg-2" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <?php /* foreach ( $categories as $category ) {
                              $categoryId = '';
                              $categoryArray = explode('categories/', 
                                               $category['uri']);
                              if( isset($categoryArray[1])) {
                                  $categoryId = $categoryArray[1];
                              }
                              ?> 
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo site_url('category/products/').'?id='.$categoryId;?>">
                                        <?php echo strtoupper($category['displayName']); ?>
                                    </a>
                                </li>
                           <?php } */ ?>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>