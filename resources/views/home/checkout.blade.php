@include("home.header")
<div class="bg-light">
  <div class="breadcumb_area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>Checkout</h2>
                </div>
            </div>
        </div>
    </div>
  </div>
  <!-- ##### Breadcumb Area End ##### -->
  
  <!-- ##### Checkout Area Start ##### -->
  <div class="checkout_area section-padding-80">
    <div class="container">
        <div class="row">
  
            <div class="col-12 col-md-6">
                <div class="checkout_details_area mt-50 clearfix">
  
                    <div class="cart-page-heading mb-30">
                        <h5>Billing Address</h5>
                    </div>
  
                    <form action="#" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name">First Name <span>*</span></label>
                                <input type="text" class="form-control" id="first_name" value="" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name">Last Name <span>*</span></label>
                                <input type="text" class="form-control" id="last_name" value="" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="street_address">Address <span>*</span></label>
                                <input type="text" class="form-control mb-3" id="street_address" value="">
                                <input type="text" class="form-control" id="street_address2" value="">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="postcode">Postcode <span>*</span></label>
                                <input type="text" class="form-control" id="postcode" value="">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="city">Town/City <span>*</span></label>
                                <input type="text" class="form-control" id="city" value="">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="state">Province <span>*</span></label>
                                <input type="text" class="form-control" id="state" value="">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="phone_number">Phone No <span>*</span></label>
                                <input type="number" class="form-control" id="phone_number" min="0" value="">
                            </div>
                            <div class="col-12 mb-4">
                                <label for="email_address">Email Address <span>*</span></label>
                                <input type="email" class="form-control" id="email_address" value="">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
  
            <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">
                <div class="order-details-confirmation">
  
                    <div class="cart-page-heading">
                        <h5>Order Summary</h5>
                    </div>
  
                    <ul class="order-details-form mb-4">
                        <li><span>Shipping</span> <span>Free</span></li>
                        <li><span>Total</span> <span>$59.90</span></li>
                    </ul>
  
                    <div id="accordion" role="tablist" class="mb-4">
                        <div class="card">
                            <div class="card-header" role="tab" id="headingOne">
                                <h6 class="mb-0">
                                  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAMAAABF0y+mAAAA+VBMVEVHcEwEmkT/YwL/mgD1sM8Am0b1r8v/mwD/mwD7lXX/VgT1r8v1r8kAmkT6mwP/YgT1r8v1r8v/WAP/VwX/VwMAoEwAmUg4kC79WAX/VgP/mwD1r8v/mwD/mgD/mgD0sdX/mwD/mwAAmUb/mwAAm0b/TgD1r8z1r8sAmkb/WAUAmkb1r8wAmkb/mwD/WAX/WAUAlh11on/zut/8oEf9oENdhjT/SQD1q8H2qb7/WAX1r8v/bgRqmjb/WAUWomH6h37/mwD2r8wAmkb/WAT3sdD/VQD/VwBNljn7pXT7fmfQZhd9jzD/dwOZppT+YiWpmyQtkz/5jISgppmjT2gwAAAAQHRSTlMAtRUKee7kpvUG0KMWUtkgjMT7be0oGQyc45f1bStaPMZLNVTRNWpQjo5rsd7kPVA7yC7r/KNBx/Sy0d6KYEyZNOzC8wAAAXpJREFUKJGlkddawkAQhSchDaKhSAdBmgpi731mNgF7e/+HcZcFEr3Uc5Hsyf/NmdkJwD+0Yvm+1U58SHfqrttMqeMmzdTIrWi07qJWB+DgNXR8P694Lg1gKuRt1F0PX7Jg8OEse9Mhcto9DzFoqcTUtaiCzavzVhbRg6xqze2ayABzdznZCeJxeuH2RS1RCRuID+EOJCoN3o5ZS0b7c3spe47Y1kaO2Zs1zunLFsQ+lFnnNhGb6p0j2tKpBdne4LG6OmJdJ+SpodZRFEP5LDGPAALcXSyvQXKooSiYym0zlzuI64sxt4iOBkKsaTfmfoBuvPg8ndfkPbRKPEXMxrBN9KZDlVbfMUj8MrgIH89iF+CzsTSpzGeYj1nKwyn3y9pka9Fj6PyANzxfxq0Q0X0Swi72SjZzvzTICFEzLbpKQBe9QcX4eH6aRFG1ckdkJaDpvYhicRJNoqepbfOXk05AyMo4IYrVUxnObFTgp8y9vdkeyt3ub/QHfQM65DidY7xmmAAAAABJRU5ErkJggg==" alt="">  Flutterwave
                                </h6>
                            </div>
                        </div>
                    </div>
  
                    <a href="#" class="btn essence-btn">Confim Order</a>
                </div>
            </div>
        </div>
    </div>
  </div>
  <!-- ##### Checkout Area End ##### -->
</div>

@include("home.footer")