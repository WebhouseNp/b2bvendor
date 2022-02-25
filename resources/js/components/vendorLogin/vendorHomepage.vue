<template>
  <div>
          <!-- header start -->
    <header class="header position-sticky">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="javascript:void(0)">
                    <img src="/images/logo.png" alt="site logo" @click="vendorHomepage" class="img-fluid site-logo">
                </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="#">Home</a>
                </li>
                <!-- <li class="nav-item">
                  <a class="nav-link" href="#">About Us</a>
                </li> -->
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Why Us</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="#">Blog</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Become a Partner</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="#">FAQ</a>
                </li>

              </ul>
              
            </div>
            </div>
        </nav>
    </header>
    <!-- header end -->
    

    <!-- slider start -->
    <div class="slider-wrapper">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
            <!-- <ol class="carousel-indicators">
                <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
            </ol> -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="slider-overlay"></div>
                    <img src="/images/vendorImages/slider (1).jpg" class="d-block w-100" alt="...">
                
                </div>
                <div class="carousel-item">
                    <div class="slider-overlay"></div>
                    <img src="/images/vendorImages/slider (2).jpg" class="d-block w-100" alt="...">
                    
                </div>
                <div class="carousel-item">
                    <div class="slider-overlay"></div>
                    <img src="/images/vendorImages/slider (3).jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </button>
        </div>

        <!-- content -->
        <div class="slider-content">
            <h1>Moving Into The Digital Era</h1>
            <p>
                Sastowholesale.com is the dynamic marketplace for Manufacturers, 
                Wholesalers & Traders: who are seeking to engage with more customers 
                online, Sales lead or Business growth.
            </p>
            <a href="javascript:void(0)" class="btn btn-slider" @click="onClickSingup">Start Selling</a>
            <div class="alert-login">
                <span>Already a Seller? <a href="javascript:void(0)" @click="onClickLogin">Login here</a></span>
            </div>
        </div>
        <!-- content end -->

        <!-- feature -->
        <div class="feature">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <div class="card border-0">
                            <div class="card-body">
                                <i class="fas fa-phone-volume mr-2"></i>
                                <span>24 /7 Support</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-12">
                        <div class="card border-0">
                            <div class="card-body">
                                <i class="fas fa-envelope mr-2"></i>
                                <a href="mailto:vendor@sastowholsale.com" class="card-link">
                                    vendor@sastowholsale.com
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- feature end -->
    </div>
    <!-- slider end -->


    <!-- why join sastowholsale start -->
    <section class="why-join">
        <div class="container">
            <!-- section heading start -->
            <div class="heading">
                <h2>Why Join Sastowholsale.com?</h2>
            </div>
            <!-- section heading end -->
            <div class="row mt-5">
                <div class="col-lg-2 col-md-6 col-6 mx-auto mb-4">
                    <div class="why-join-box">
                        <div class="why-join-box-icon">
                            <i class="fas fa-money-check"></i>
                        </div>
                        <h5 class="why-join-box-title">Free Registration</h5>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-6 mx-auto mb-4">
                    <div class="why-join-box">
                        <div class="why-join-box-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h5 class="why-join-box-title">Business Support & Training</h5>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-6 mx-auto mb-4">
                    <div class="why-join-box">
                        <div class="why-join-box-icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h5 class="why-join-box-title">Weekly Payments After Sales</h5>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-6 mx-auto mb-4">
                    <div class="why-join-box">
                        <div class="why-join-box-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5 class="why-join-box-title">Minimum Marketplace Fees</h5>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-6 mx-auto mb-4">
                    <div class="why-join-box">
                        <div class="why-join-box-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <h5 class="why-join-box-title">Guidance In International Trade</h5>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-6 mx-auto mb-4">
                    <div class="why-join-box">
                        <div class="why-join-box-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h5 class="why-join-box-title">Lower Cost To Maximize Your Profit</h5>
                    </div>
                </div>
                

                
            </div>
        </div>
    </section>
    <!-- why join sastowholsale end -->

    <!-- steps start -->
    <section class="step">
        <div class="container">
            <!-- section heading start -->
            <div class="heading">
                <h2>SIX EASY STEPS TO SELL ON SASTOWHOLESALE.COM</h2>
            </div>
            <!-- section heading end -->
            
            <div class="row mt-5">
                <div class="col-sm-12 col-md-6 col-lg-3 mx-auto">
                    <div class="process-single-item">
                        <div class="process-single-thumb">
                            <i class="fas fa-user-plus"></i>
                            <div class="process-number">
								<span>01</span>
							</div>
                        </div>
                        <div class="process-content">
							<div class="process-content-title">
								<h4>Register Now</h4>
							</div>
							<p>Click Register now and fill the form with your details.</p>
						</div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mx-auto">
                    <div class="process-single-item">
                        <div class="process-single-thumb">
                            <i class="fas fa-file-alt"></i>
                            <div class="process-number">
								<span>02</span>
							</div>
                        </div>
                        <div class="process-content">
							<div class="process-content-title">
								<h4>Documents and Details</h4>
							</div>
							<p>Provide us the Business related documents & Bank details</p>
						</div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mx-auto">
                    <div class="process-single-item">
                        <div class="process-single-thumb">
                            <i class="fas fa-check-circle"></i>
                            <div class="process-number">
								<span>03</span>
							</div>
                        </div>
                        <div class="process-content">
							<div class="process-content-title">
								<h4>Get Verified</h4>
							</div>
							<p>You will get verified</p>
						</div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mx-auto">
                    <div class="process-single-item">
                        <div class="process-single-thumb">
                            <i class="fas fa-list"></i>
                            <div class="process-number">
								<span>04</span>
							</div>
                        </div>
                        <div class="process-content">
							<div class="process-content-title">
								<h4>List Products</h4>
							</div>
							<p>List your products by providing their details</p>
						</div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mx-auto">
                    <div class="process-single-item">
                        <div class="process-single-thumb">
                            <i class="fas fa-comments"></i>
                            <div class="process-number">
								<span>05</span>
							</div>
                        </div>
                        <div class="process-content">
							<div class="process-content-title">
								<h4>Inquiries/messages</h4>
							</div>
							<p>You need to reply to inquiries/messages</p>
						</div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mx-auto">
                    <div class="process-single-item">
                        <div class="process-single-thumb">
                            <i class="fas fa-chart-line"></i>
                            <div class="process-number">
								<span>06</span>
							</div>
                        </div>
                        <div class="process-content">
							<div class="process-content-title">
								<h4>Start Selling</h4>
							</div>
							<p>Protect your order & payments</p>
						</div>
                    </div>
                </div>

            </div>
        </div>
    </section>
        <!-- footer start -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="footer-title">Quick links</h4>
                    <ul class="footer-list">
                        <li>
                            <a href="#">Payment Terms</a>
                        </li>
                        <li>
                            <a href="#">Local Seller Guidelines</a>
                        </li>
                        <li>
                            <a href="#">International Seller Guidelines</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <h4 class="footer-title">Contact Us</h4>
                    <ul class="footer-list">
                        <li>
                            <a href="mailto:vendor@sastowholsale.com">vendor@sastowholsale.com</a>
                        </li>
                        <li>
                            <a href="tel:+9779803020102">+977 9803020102</a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr>

            <!-- <div class="row">
                <div class="col-sm-12 col-lg-12 col-md-12">
                    <div class="pt-we-accept">
                        <h3>We Accept</h3>
                        <ul class="list-unstyled">
                            <li>
                                <img src="https://b2bfrontend.webhouse.com.np/assets/image/partner1.png">
                            </li>
                            <li>
                                <img src="https://b2bfrontend.webhouse.com.np/assets/image/partner2.png">
                            </li>
                            <li>
                                <img src="https://b2bfrontend.webhouse.com.np/assets/image/partner3.png">
                            </li>
                            <li>
                                <img src="https://b2bfrontend.webhouse.com.np/assets/image/partner4.png">
                            </li>
                            <li>
                                <img src="https://b2bfrontend.webhouse.com.np/assets/image/partner5.png">
                            </li>
                            <li>
                                <img src="https://b2bfrontend.webhouse.com.np/assets/image/partner1.png">
                            </li>
                            <li>
                                <img src="https://b2bfrontend.webhouse.com.np/assets/image/partner2.png">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr> -->
            <div class="bottom-footer">
                <p>Product Listing Policy -Intellectual Property Protection - Privacy Policy - Terms of Use - User Information Legal Enquiry Guide</p>
                <p><b>©2021 Sasto Wholesale Pvt. Ltd. All rights Reserved.</b></p>
                <p><b>Head Office:</b> Krishna Galli Pulchowk-04, Kathamandu Nepal</p>
                <p><b>Tel:</b> +977-01-4563782 Customer Services: +977-01-23452312 Email: info@sastowholesale.com Fax: +977-01-4234345</p>
                <p><b>Designed &amp; Developed By: Web House Nepal</b></p>
            </div>
            <hr>

        </div>
    </footer>
    <!-- footer end -->

  </div>
</template>

<script>
export default {
    name:'LoginHomePage',
    methods:{
        onClickSingup(){
        window.location.href = "/vendor-registor";
    },
    onClickLogin(){
        window.location.href = "/vendor-login";
    },
    vendorHomepage(){
        window.location.href = "/vendor-homepage";
    }
    }
}
</script>

<style>

</style>