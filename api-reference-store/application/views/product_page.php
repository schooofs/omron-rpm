<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// load the header file 
$this->load->view('header', $header);

// Get product Specification
$prodSpecificationArray = array();
$prodCustomAttribute = $product['product']['customAttributes'];
foreach ( $prodCustomAttribute AS $customAttribute ) {
    foreach ( $customAttribute AS $prodSpecification ) {
        $prodSpecificationArray[$prodSpecification['name']] = (isset($prodSpecification['value'])? $prodSpecification['value'] : '');
    }
}
// Get product Tab Titles
$prodTabTitle = array();
foreach ( $prodSpecificationArray AS $key => $value ) {
    if( preg_match('/^tabTitle/',$key) &&  !empty(trim($value)) && $value != "&nbsp;") {
        $prodTabTitle[$key] = $value;
    }
}

// Get Product Tab Content
$prodTabContent = array();
foreach ( $prodTabTitle AS $key => $value ) {
    $tabContentKey = str_replace("Title","Content",$key);
    if ( isset($prodSpecificationArray[$tabContentKey]) ) {
        $prodTabContent[$tabContentKey] = $prodSpecificationArray[$tabContentKey];
    }
}

// Get variation array 
$productVariations = array();
if( isset($product['product']['variations']) ) {
    $productVariations = $product['product']['variations']['product'];
}
$productVariationsArray = array();
$i = 0;
foreach ( $productVariations AS $variationAttribute ) {
    $productVariationsArray[]= array ( 
        'cartUri' => $variationAttribute['addProductToCart']['cartUri'],
        'id' => $variationAttribute['id'],
        'price'=> $variationAttribute['pricing']['formattedSalePriceWithQuantity'],
        'name' => $variationAttribute['name'],
        'image' => $variationAttribute['productImage']
    );
}

$selected_product_id = (isset($product['product']['variations']['product'][0]['id'])
    ?$product['product']['variations']['product'][0]['id']:$product['product']['id']);
?>
<section id="product-description">
    <div class="container mt-4">
       <p id="product-tabs">Home>Software><?php echo $product['product']['name']; ?></p>
        <div class="row">
            <div class="col-md-7 product">
                <img class="img-fluid" 
                    src="<?php echo $product['product']['productImage'];?>" 
                    alt="<?php echo $product['product']['name']; ?>" /> 
            </div>
            <div class="col-md-5 pt-3 prod-details">
                <div id="product-heading">
                    <h3><?php echo $product['product']['name']; ?></h3>
                </div>
                <div class="pt-2 pl-3 pr-4">
                    <p><?php echo $product['product']['shortDescription']; ?></p>
                </div>
                <div class="pt-2 pb-2" id="price-type">
                    <input type="hidden" id="selectedProductID" value="<?= $selected_product_id ?>" />
                    <form class="pl-3">
                        <?php 
                        $i = 0;
                        foreach ( $productVariationsArray AS $variationAttribute ) {
                            $selected = '';
                            if ( $i == 0 ) {
                                $selected = 'checked';
                            }
                        ?>
                            <div class="form-check">
                                <label class="form-check-label" for="radio<?php echo $variationAttribute['id']; ?>">
                                 <input type="radio" class="form-check-input" 
                                         id="radio1" name="optradio" value="<?php echo $variationAttribute['id']; ?>" 
                                         <?php echo $selected; ?> onclick="setProductID('<?php echo $variationAttribute['id']; ?>')">
                                 <?php echo $variationAttribute['name'].' - '.$variationAttribute['price'] ?>;
                                </label>
                            </div>
                        <?php $i++; } ?>
                    </form>
                </div>
                <div class="pt-4">
                    <button id="add-to-cart">ADD TO CART</button>
                    <button class="mt-3 mb-4" id="add-to-wishlist">ADD TO WISHLIST</button>
                </div>
                <div class="mb-3">
                   <?php 
                    $hasProdReviews = 0;
                    foreach ( $prodTabTitle AS $key=>$tabTitle ) { 
                        if ( $tabTitle != 'REVIEWS' ) {
                            $tabContentKey = str_replace("Title","Content",$key);
                            ?>
                            <div data-toggle="collapse" data-target="#<?php echo $tabTitle;?>" class="pb-2 collapse-feature">
                                <?php echo strtoupper($tabTitle);?><i class="fa fa-caret-right pl-2 collapse-arrow"></i>
                            </div>
                            <div id="<?php echo $tabTitle;?>" class="collapse">
                                <?php echo isset($prodTabContent[$tabContentKey])?$prodTabContent[$tabContentKey]:''; ?>
                            </div>
                       <?php 
                        } else {
                            $hasProdReviews = str_replace("Title","Content",$key);;
                        }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="video-img">
    <div class="container">
        <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-5">
                <img src="<?php echo base_url(); ?>assets/images/video-image.png" alt="video" style="width:100%;"/>
            </div>
        </div>
    </div>
</section>
<?php 
if ( !empty($product['offers'] ) ) { ?>
    <section id="listOfProducts">
        <div class="container-fluid background mt-5">
            <div class="recommendedProducts text-center">
              <h1>Recommended Products</h1>
            </div>
            <div class="container" id="aligning-products">
                <div class="row">
                    <?php 
                    $i = 0; 
                    foreach( $product['offers'] as $offer ) { 
                        if ( $i == 3 ) {
                            break;
                        }
                        $i++;
                    ?>
                    <div class="col-sm d-flex product-spacing">
                        <div class="card card-body flex-fill product-information">
                            <div id="child-inner">
                                <img class="card-img-top" 
                                    src="<?= $offer['product']['thumbnailImage'] ?>" 
                                    alt="<?= $offer['product']['displayName'] ?>"
                                    style="width:100%"/>
                                <div class="card-body">
                                    <div class="card-text">
                                        <a href="<?= site_url('product/showProduct/').'?productId='.$offer['id'];?>">
                                            <?= $offer['product']['displayName'] ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="price">
                                    <?= $offer['pricing']['formattedSalePriceWithQuantity'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
         </div>
    </section>
<?php
}
if( $hasProdReviews ) { ?>
    <section id="productReviews">
        <div class="container mt-3 mb-3" style="color:#8e8d8d";>
            <div class="row">
                <?php echo $prodTabContent[$hasProdReviews]; ?>
            </div>
        </div>
    </section>
<?php } ?>
<!-- Load footer section -->
<?php $this->load->view('footer', $header); ?>
<script>
    function setProductID(productID) {
        $('#selectedProductID').val(productID);
    }
    $("#add-to-cart").click(function(){
        var cartUrl = '<?php echo site_url('cart/activeCart/').'?productId=';?>';
        window.location.href = cartUrl+ $("#selectedProductID").val();
    });
</script>