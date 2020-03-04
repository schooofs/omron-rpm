<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// load the header file 
$this->load->view('header', $header);
$categoryImage = base_url().'assets/images/Software_Banner_Image.png';
if ( $category['category']['thumbnailImage'] ) {
    $categoryImage = $category['category']['thumbnailImage'];
}
?>
<section id="category-banner">
    <div class="container-fluid pl-0 pr-0">
       <div class="row no-gutters">
          <div class="col-md-7 background-category">
             <div class="centered">
                <p><?= $category['category']['displayName'] ?></p>
             </div>
          </div>
          <div class="col-md-5 ">
             <img src="<?= $categoryImage ?>" alt="image" class="img-fluid" style="width:100%"/> 
          </div>
       </div>
    </div>
</section>
<div class="container" id="categories">
    <div class="row">
        <div class="col-md-3 col-12" id="filter-categories">
            <h5 class="mt-2">Filters</h5>
            <hr class="line">
            <div id="filter-name">
                <h6>Display Name</h6>
                <div class="form-check">
                    <label class="form-check-label" for="check1">
                        <input type="checkbox" class="form-check-input" id="check1" name="option1" value="something">
                        <?= $category['category']['displayName'] ?>
                    </label>
                </div>
                <hr class="line">
            </div>
            <div id="filter-price">
                <h6>List Price</h6>
                <div class="form-check">
                    <label class="form-check-label" for="check2">
                        <input type="checkbox" class="form-check-input" id="check2" name="option2" value="something">Less than $50
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label" for="check3">
                        <input type="checkbox" class="form-check-input" id="check3" name="option3" value="something">$51-$100
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label" for="check4">
                        <input type="checkbox" class="form-check-input" id="check4" name="option4" value="something">$101-$200
                    </label>
                </div>
                <hr class="line">
           </div>
        </div>
        <div class="col-md-9">
            <?php
                $i = $row = $j= $noCards = 1;
                $len = count($products);
                // Check if offer is not available , display all cards
                if ( empty($offer) ) {
                    foreach( $products AS $product ) {
                    $productId = 0;
                    $productArray = explode('products/', $product['uri']);
                    if( isset($productArray[1])) {
                        $productId = $productArray[1];
                    }
                    if ( $product['thumbnailImage'] == '' ) {
                        $product['thumbnailImage'] = base_url().'assets/images/img_not_available.png';
                    }
                ?>
                    <?php if ( $i==1) {
                    ?>
                        <div class="row <?php echo ($j != 1 ? 'mt-4':'');?>">
                    <?php } ?>
                            <div class="col-md-4 col-12 product-spacing">
                                <div class="card product-information h-100">
                                    <div id="parent-outer">
                                        <div id="child-inner">
                                            <img class="card-img-top" 
                                                src="<?= $product['thumbnailImage'] ?>" 
                                                alt="<?= $product['displayName'] ?>" 
                                                style="width:100%"/>
                                            <div class="position-relative btn-position" >
                                                <button onClick="checkoutPage('<?= $productId; ?>')" 
                                                class="buy-button">BUY NOW</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Subscription | Digital</h6>
                                        <p class="card-text product-name"><?= $product['displayName'] ?></p>
                                        <div class="price">
                                            <p class="old-price">
                                                <?= $product['pricing']['formattedListPrice'] ?>
                                            </p>
                                            <p><?= $product['pricing']['formattedSalePriceWithQuantity'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php if ( $j%3 == 0 || $j == $len ) {
                        $i = 0;
                    ?>
                        </div>
                    <?php } ?>
                <?php 
                    $i++;
                    $j++;
                } // closing for each
            } else { //Offer is not empty if
                foreach( $products AS $product ) {
                    $productId = 0;
                    $productArray = explode('products/', $product['uri']);
                    if( isset($productArray[1])) {
                        $productId = $productArray[1];
                    }
                    if ( $product['thumbnailImage'] == '' ) {
                        $product['thumbnailImage'] = base_url().'assets/images/img_not_available.png';
                    }
                ?>
                    <?php if ( $i==1) {
                    ?>
                        <div class="row <?php echo ($j != 1 ? 'mt-4':'');?>">
                    <?php } 
                        if ( $row == 2 && ( $noCards == 5 ) ) {
                            $i = 0;
                            $j++;
                            $row++;
                            ?>
                            <div class="col-md-8 product-spacing">
                                <img src="<?= $offer['image'] ?>" alt="banner-image" class="img-fluid myclass"/>
                                <div class="offer-text">
                                   <p class="heading-software"><?php echo strip_tags($offer['salesPitch'][0]); ?></p>
                                </div>
                            </div>
                        </div>  
                            <?php
                        } else {
                        ?>
                            <div class="col-md-4 col-12 product-spacing">
                                <div class="card product-information  h-100">
                                    <div id="parent-outer">
                                        <div id="child-inner">
                                            <img class="card-img-top" 
                                                src="<?= $product['thumbnailImage'] ?>" 
                                                alt="<?= $product['displayName'] ?>" 
                                                style="width:100%"/>
                                            <div class="position-relative btn-position" >
                                                <button onClick="checkoutPage('<?= $productId; ?>')" 
                                                class="buy-button">BUY NOW</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Subscription | Digital</h6>
                                        <p class="card-text product-name"><?= $product['displayName'] ?></p>
                                        <div class="price">
                                            <p class="old-price">
                                                <?= $product['pricing']['formattedListPrice'] ?>
                                            </p>
                                            <p><?= $product['pricing']['formattedSalePriceWithQuantity'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                </div>
                        <?php if ( $j%3 == 0 || $j == ($len+1) ) {
                            $i = 0;
                            $row++;
                        ?>
                            </div>
                        <?php }
                    } // closing of offer html elase ?>
                <?php 
                    $i++;
                    $j++;
                    $noCards++;
                }// Closing foreach 
                if ( $len == 4 || $len == 1 ) {
                    ?>
                        <div class="col-md-8 product-spacing">
                            <img src="<?= $offer['image'] ?>" alt="banner-image" class="img-fluid myclass"/>
                                <div class="offer-text">
                                   <p class="heading-software"><?php echo strip_tags($offer['salesPitch'][0]); ?></p>
                                </div>
                        </div>
                    </div>    
                    <?php
                }
            } 
            ?>
        </div>
    </div>
</div>
<?php $this->load->view('footer', $header); ?>
<script>
    function checkoutPage(productID) {
        var productUrl = '<?php echo site_url('product/showProduct/').'?productId=';?>'+productID;
        window.location.href = productUrl;
    }
</script>