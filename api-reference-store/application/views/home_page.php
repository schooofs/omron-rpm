<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// load the header file 
$this->load->view('header', $header);
?>
<section id="offer">
    <div class="container-fluid pl-0 pr-0">
        <div class="row no-gutters">
            <div class="col-md-6 background1">
               <div class="offer-details1 text-center">
                  <h1><?= $offers['upgrade']['salesPitch'][0] ?></h1>
                  <h5><?= $offers['upgrade']['salesPitch'][1] ?></h5>
                  <a  href="<?php echo site_url('category/products/').'?id=70229700';?>" 
                      class="offer-button">SHOP NOW</a>
               </div>
            </div>
            <div class="col-md-6">
                <img src="<?= $offers['upgrade']['image']?>" alt="" style="width:100%;"/>
            </div>
        </div>
    </div>
</section>
<section id="shopProducts">
    <div class="container mt-4">
        <h3 id="products">OUR PRODUCTS</h3>
        <div class="row">
            <div class="col-md-7">
               <div class="wrapper">
                  <img src="<?= $offers['electronics']['image']?>" alt="" />
                  <div class="overlay">
                     <div class="positioning">
                        <h2 class="prod-item1"><?= $offers['electronics']['salesPitch'][0]?></h2>
                        <a href="<?php echo site_url('category/products/').'?id=70229700';?>" 
                           class="shop-btn">SHOP NOW</a> 
                     </div>
                  </div>
               </div>
            </div>
           <div class="col-md-5">
                <div class="wrapper">
                    <img src="<?= $offers['software']['image']?>" alt="" />
                    <div class="overlay">
                        <div class="positioning">
                            <h2 class="prod-item2"><?= $offers['software']['salesPitch'][0]?></h2>
                            <a href="<?php echo site_url('category/products/').'?id=70229600';?>" 
                               class="shop-btn">SHOP NOW</a> 
                        </div>
                    </div>
                </div>
                <div class="wrapper1">
                    <img src="<?= $offers['games']['image']?>" alt="" />
                    <div class="overlay">
                        <div class="positioning">
                            <h2 class="prod-item3"><?= $offers['games']['salesPitch'][0]?></h2>
                            <a href="<?php echo site_url('category/products/').'?id=70229800';?>" class="shop-btn">SHOP NOW</a> 
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="wrapper3">
        <img src="<?= $offers['specialOffer']['image']?>" alt="" style="width:100%";/>
        <div class="overlay3">
            <div class="offer">
                <p class="heading"><?= $offers['specialOffer']['salesPitch'][0]?></p>
                <p class="offer-price"><?= $offers['specialOffer']['salesPitch'][1]?><p>
                <a  href="<?php echo site_url('category/products/').'?id=70230200';?>" 
                    class="shop">SHOP NOW</a>
            </div> 
        </div>
    </div>
</div>
<section id="popularProducts">
    <div class="container-fluid background-img mt-5 mb-4">
        <div class="crowd-favorites text-center">
            <p class="heading">CROWD FAVORITES</p>
            <p class="content">Our most popular products</p>
        </div>
        <div class="row list">
            <?php foreach ( $offers['futureProduct'] AS $product ) {
                ?>
                <div class="col-12 col-md-4">
                    <a href="<?= site_url('product/showProduct/').'?productId='.$product['id'];?>">
                    <div id="parent" class="parent-border h-100">
                        <div id="child">
                            <img class="img-fluid" src="<?= $product['product']['thumbnailImage'] ?>" alt="<?= $product['product']['displayName'] ?>" />
                            <div>
                                <?= $product['product']['displayName'] ?>
                               <br/>
                                <?= $product['pricing']['formattedSalePriceWithQuantity'] ?>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            <?php } ?>
       </div>
    </div>
</section>
<?php 
    $this->load->view('footer', $header);
    /*if ( $logger ) { ?>
        <script>
            <?php
                foreach( $logger AS $value ) {
                    ?>
                    sessionStorage.setItem('apiReferanceLog'+':'+Math.floor(Math.random() * 10000),
                    '<?php echo json_encode($value); ?>');
                    <?php
                }
            ?>
        </script>
        <?php
    }*/
?>
<script>
    //var apiLogs = '<?php echo json_encode($logger); ?>';
    function setProductID(productID) {
        $('#selectedProductID').val(productID);
    }
    $("#addToCart").click(function(){
        var cartUrl = '<?php echo site_url('cart/activeCart/').'?productId=';?>';
        window.location.href = cartUrl+ $("#selectedProductID").val();
    });
</script>