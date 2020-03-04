<div id="loading">
    <div class="loader"></div>
    <div id="overlay_popup"></div>
</div>
    <footer>
        <div class="container-fluid">
           <div class="container">
                <div class="row pt-2">
                    <div class="col-md-2">
                        <h6>Shop Categories</h6>
                        <ul class="list-unstyled quick-links">
                            <?php /* foreach ( $categories as $category ) {
                              $categoryId = '';
                              $categoryArray = explode('categories/', 
                                                $category['uri']);
                              if( isset($categoryArray[1])) {
                                  $categoryId = $categoryArray[1];
                              }
                              ?> 
                                <li>
                                    <a href="<?php echo site_url('category/products/').'?id='.$categoryId;?>">
                                        <?= $category['displayName']; ?>
                                    </a>
                                </li>
                           <?php } */ ?>
                        </ul>
                    </div>
                 <div class="col-md-2">
                    <h6>About</h6>
                    <ul class="list-unstyled quick-links">
                       <li><a href="#">Privacy Policy</a></li>
                       <li><a href="#">Terms Of Sale</a></li>
                       <li><a href="#">Site Map</a></li>
                    </ul>
                 </div>
                 <div class="col-md-2">
                    <h6>Help</h6>
                    <ul class="list-unstyled quick-links">
                       <li><a href="#">All Help Topics</a></li>
                       <li><a href="#">Orders</a></a></li>
                       <li><a href="#">Returns</a></li>
                       <li><a href="#">Contact Us</a></li>
                       <li><a href="#">FAQ</a></li>
                    </ul>
                 </div>
                 <div class="col-md-3">
                    <h6>Newsletter</h6>
                    <form class="input-group">
                       <input type="text" class="form-control form-control-sm" title="enter email" placeholder="Your e-mail address">
                       <div class="input-group-append">
                          <button type="button" class="btn btn-sm" id="input-email">Go!</button>
                       </div>
                    </form>
                    <h6>Connect</h6>
                    <ul class="list-unstyled list-inline social ">
                       <li class="list-inline-item"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icons_14.png" alt="facebook" /></a></li>
                       <li class="list-inline-item"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icons_16.png" alt="twitter" /></a></li>
                       <li class="list-inline-item"><a href="#"><img src="<?php echo base_url(); ?>assets/images/pinterest-256.png" height="25px" alt="pininterest" /></a></li>
                       <li class="list-inline-item"><a href="#"><img src="<?php echo base_url(); ?>assets/images/instagram-png-instagram-png-logo-400.png" height="32px" alt="instagram"/></a></li>
                    </ul>
                 </div>
                 <div class="col-md-3">
                    <a href="#"><img src="<?php echo base_url(); ?>assets/images/DR-Demo-Store_New.png" class="img-fluid" alt=" DR-logo" /></a>
                 </div>
              </div>
           </div>
           <div class="container-fluid footer-border"></div>
           <div class="container">
              <div class="row ft-copyright pt-2 pb-2">
                 <div class="col-md-7">
                    <ul class="list-unstyled list-inline pull-left payment_options_li">
                       <li class="list-inline-item"><span style="font-size:13px;">Payment Options</span></li>
                       <li class="list-inline-item"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icons_25.png" alt="payment"/></a></li>
                       <li class="list-inline-item"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icons_27.png" alt="diners club entertainment"/></a></li>
                       <li class="list-inline-item"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icons_29.png" alt="discover"/></a></li>
                       <li class="list-inline-item"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icons_31.png" alt="UCB"/></a></li>
                       <li class="list-inline-item"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icons_33.png" alt="mastercard"/></a></li>
                       <li class="list-inline-item"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icons_35.png" alt="visa"/></a></li>
                       <li class="list-inline-item"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icons_37.png" alt="paypal"/></a></li>
                    </ul>
                 </div>
                 <div class="col-md-5">
                    <div class="copyright-text">
                       <p>© 2019 Digital River,Inc. This site is hosted by Digital River</p>
                    </div>
                 </div>
              </div>
           </div>
        </div>
    </footer>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//drh.img.digitalriver.com/DRHM/Storefront/Library/scripts/jquery/plugins/jquery.validate.js"></script>
<script type="text/javascript" src="//drh.img.digitalriver.com/DRHM/Storefront/Library/scripts/jquery/plugins/jquery.additional-methods.js"></script>
<script src="<?php echo base_url(); ?>assets/js/common.js"></script>
</html>