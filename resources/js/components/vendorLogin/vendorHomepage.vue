<template>
  <div>
    <!-- header start -->
    <header data-v-cbdddaa2="" class="header position-sticky">
      <nav
        data-v-cbdddaa2=""
        class="navbar navbar-expand-lg navbar-light bg-light"
      >
        <div data-v-cbdddaa2="" class="container">
          <a data-v-cbdddaa2="" href="javascript:void(0)" class="navbar-brand"
            ><img
              data-v-cbdddaa2=""
              src="/images/logo.png"
              alt="site logo"
              class="img-fluid site-logo"
          /></a>
          <button
            data-v-cbdddaa2=""
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
            class="navbar-toggler"
          >
            <span data-v-cbdddaa2="" class="navbar-toggler-icon"></span>
          </button>
          <div
            data-v-cbdddaa2=""
            id="navbarSupportedContent"
            class="collapse navbar-collapse"
          >
            <ul data-v-cbdddaa2="" class="navbar-nav ml-auto">
              <li data-v-cbdddaa2="" class="nav-item active">
                <a data-v-cbdddaa2="" href="#" class="nav-link">Home</a>
              </li>
              <li data-v-cbdddaa2="" class="nav-item">
                <a data-v-cbdddaa2="" href="javascript:void(0)" class="nav-link" @click="onClickPartners">Partners</a>
              </li>
              <li data-v-cbdddaa2="" class="nav-item">
                <a data-v-cbdddaa2="" href="#" class="nav-link">Blog</a>
              </li>
              <li data-v-cbdddaa2="" class="nav-item">
                <a data-v-cbdddaa2="" href="javascript:void(0)" class="nav-link"  @click="onClickFaq">FAQ</a>
              </li>
              <li data-v-cbdddaa2="" class="nav-item">
                <a data-v-cbdddaa2="" href="javascript:void(0)" class="nav-link"  @click="onClickSingup">Register</a>
              </li>
              <li data-v-cbdddaa2="" class="nav-item">
                <a data-v-cbdddaa2="" href="javascript:void(0)" class="nav-link" @click="onClickLogin">Login</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <!-- header end -->

    <!-- slider start -->
    <div class="slider-wrapper">
      <div
        id="carouselExampleCaptions"
        class="carousel slide"
        data-ride="carousel"
      >
        <!-- <ol class="carousel-indicators">
                <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
            </ol> -->
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="slider-overlay"></div>
            <img
              src="/images/vendorImages/slider (1).jpg"
              class="d-block w-100"
              alt="..."
            />
          </div>
          <div class="carousel-item">
            <div class="slider-overlay"></div>
            <img
              src="/images/vendorImages/slider (2).jpg"
              class="d-block w-100"
              alt="..."
            />
          </div>
          <div class="carousel-item">
            <div class="slider-overlay"></div>
            <img
              src="/images/vendorImages/slider (3).jpg"
              class="d-block w-100"
              alt="..."
            />
          </div>
        </div>
        <button
          class="carousel-control-prev"
          type="button"
          data-target="#carouselExampleCaptions"
          data-slide="prev"
        >
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-target="#carouselExampleCaptions"
          data-slide="next"
        >
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
        <a
          href="javascript:void(0)"
          class="btn btn-slider"
          @click="onClickSingup"
          >Start Selling</a
        >
        <div class="alert-login">
          <span>Already a Seller?</span><br><br>
          <a href="javascript:void(0)" class="btn btn-slider mb-5" @click="onClickLogin"
              >Login here</a>
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
        <div class="row mt-5">
          <div class="description">
            <p>
              B2B, C2C Ecommerce is growing rapidly in Nepalese market. Most of
              the users are using online payment, doing online purchase these
              days. Internet user is growing every year. We have many B2B, B2C
              Ecommerce in Nepal, while we are going into a digital era, B2B
              Ecommerce is the future of Nepal. We believe in promoting B2B
              Ecommerce and making Digital Nepal. By registering in
              Sastowholesale.com you can reach more customers, more engagements
              & more sales.
            </p>
          </div>
        </div>
        <div class="row mt-5">
          <div class="heading">
            <h2>Here are some of our benefits choosing Sastowholesale.com:</h2>
          </div>
          <div class="list mt-5">
            <ul>
              <li>
                <i class="fa fa-check pt-1"></i>
                Sastowholesale.com is fully dedicated in promoting National and
                International products around the world.
              </li>
              <li>
                <i class="fa fa-check pt-1"></i> Sastowholesale.com provides
                payment assurance to vendor and buyer.
              </li>
              <li>
                <i class="fa fa-check pt-1"></i> Sastowholesale.com helps in
                providing Local & International logistic Management and custom
                clearance management.
              </li>
              <li>
                <i class="fa fa-check pt-1"></i> Sastowholesale.com provides
                different guidelines to vendor for exporting/importing goods to
                Nepal.
              </li>
              <li>
                <i class="fa fa-check pt-1"></i>
                Registration is free for 1st year.
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>
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
          <div data-v-cbdddaa2="" class="col-sm-12 col-md-6 col-lg-3 mx-auto">
            <div data-v-cbdddaa2="" class="process-single-item">
              <div data-v-cbdddaa2="" class="process-single-thumb">
                <i data-v-cbdddaa2="" class="fas fa-comments"></i>
                <div data-v-cbdddaa2="" class="process-number">
                  <span data-v-cbdddaa2="">05</span>
                </div>
              </div>
              <div data-v-cbdddaa2="" class="process-content">
                <div data-v-cbdddaa2="" class="process-content-title">
                  <h4 data-v-cbdddaa2="">Inquiries/messages</h4>
                </div>
                <p data-v-cbdddaa2="">
                  You need to reply to inquiries/messages
                </p>
              </div>
            </div>
          </div>
          <div data-v-cbdddaa2="" class="col-sm-12 col-md-6 col-lg-3 mx-auto">
            <div data-v-cbdddaa2="" class="process-single-item">
              <div data-v-cbdddaa2="" class="process-single-thumb">
                <i data-v-cbdddaa2="" class="fas fa-chart-line"></i>
                <div data-v-cbdddaa2="" class="process-number">
                  <span data-v-cbdddaa2="">06</span>
                </div>
              </div>
              <div data-v-cbdddaa2="" class="process-content">
                <div data-v-cbdddaa2="" class="process-content-title">
                  <h4 data-v-cbdddaa2="">Start Selling</h4>
                </div>
                <p data-v-cbdddaa2="">Protect your order &amp; payments</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- footer start -->
    <footer class="footer">
      <div class="container">
        <!-- <div class="row">
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
                <a href="mailto:vendor@sastowholsale.com"
                  >vendor@sastowholsale.com</a
                >
              </li>
            </ul>
          </div>
        </div>
        <hr /> -->

        <div class="row">
          <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="pt-we-accept">
              <h3>We Accept</h3>
              <ul class="list-unstyled">
                <li>
                  <img
                    src="https://b2bfrontend.webhouse.com.np/assets/image/partner1.png"
                  />
                </li>
                <li>
                  <img
                    src="https://b2bfrontend.webhouse.com.np/assets/image/partner2.png"
                  />
                </li>
                <li>
                  <img
                    src="https://b2bfrontend.webhouse.com.np/assets/image/partner3.png"
                  />
                </li>
                <li>
                  <img
                    src="https://b2bfrontend.webhouse.com.np/assets/image/partner4.png"
                  />
                </li>
                <li>
                  <img
                    src="https://b2bfrontend.webhouse.com.np/assets/image/partner5.png"
                  />
                </li>
                <li>
                  <img
                    src="https://b2bfrontend.webhouse.com.np/assets/image/partner1.png"
                  />
                </li>
                <li>
                  <img
                    src="https://b2bfrontend.webhouse.com.np/assets/image/partner2.png"
                  />
                </li>
              </ul>
            </div>
          </div>
        </div>
        <hr />
        <div class="bottom-footer">
          <p>
            Product Listing Policy -Intellectual Property Protection - Privacy
            Policy - Terms of Use - User Information Legal Enquiry Guide
          </p>
          <p><b>©2021 Sasto Wholesale Pvt. Ltd. All rights Reserved.</b></p>
          <p><b>Head Office:</b> Krishna Galli Pulchowk-04, Kathamandu Nepal</p>
          <p>Email: info@sastowholesale.com</p>
          <p><b>Designed &amp; Developed By: Web House Nepal</b></p>
        </div>
        <hr />
      </div>
    </footer>
    <!-- footer end -->
  </div>
</template>

<script>
export default {
  name: "LoginHomePage",
  methods: {
    onClickSingup() {
      window.location.href = "/vendor-register";
    },
    onClickLogin() {
      window.location.href = "/vendor-login";
    },
    vendorHomepage() {
      window.location.href = "/vendor-homepage";
    },
    onClickPartners(){
      window.location.href = "https://staging.sastowholesale.com/partners"
    },
    onClickFaq(){
      window.location.href = "/faq";
    }
  },
};
</script>

<style scoped>
.description p,
.list {
  margin-left: 50px;
  margin-right: 50px;
}
.list ul li {
  list-style: none;
}
.list i {
  color: #ffa500;
}
</style>