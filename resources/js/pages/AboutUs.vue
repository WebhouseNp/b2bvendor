<template>
  <frontmaster>
    <div class="container">
      <!-- section heading start -->
      <div class="heading mt-5">
        <h2>About Us</h2>
      </div>
      <div class="row mt-5">
        <div class="description">
          <ol>
            <li>About Sastowholesale.com 
            <ul>
              <li>Sastowholesale.com is a dynamic marketing/selling online venue for manufacturer, supplier, wholesaler, or any organization; who are seeking their product worldwide. Managed and handled by be the best Pvt. Ltd., B2B, B2C Ecommerce having both product and service which connect Buyers & Suppliers around the world.</li>
            </ul>
            </li>
            <li>Our Partners
              <ul>
                <li>Send to our partner page & also add option become a partner option & give form, for which category partner they want to be.</li>
              </ul>
            </li>
            <li>Help Center
              <ul>
                <li>Currently we can use FAQs, but need to make help center category wise.</li>
              </ul>
            </li>
            <li>Our Blogs
              <ul><li>Blogs Page</li></ul>
            </li>
          </ol>
          <ol style="list-style:none;">
            <li><strong>Sell on Sastowholesale.com</strong><br><br>
            <ol>
              <li>Become a Seller
                <ul><li>Seller page </li></ul></li></ol></li>
            <li>Logistics Management</li>
          </ol>
          <ol style="list-style:none;">
            <li><strong>Legal</strong><br><br>
            <ol><li><a href="javascript:void(0)" @click="termsConditations">Vendor terms & Condition</a> </li>
            <li><a href="javascript:void(0)" @click="termsUse">Terms of use</a></li>
            <li><a href="javascript:void(0)" @click="privacyPolicy">Privacy Policy</a></li></ol></li>
          </ol><br><br>
        </div>
      </div>
    </div>
  </frontmaster>
</template>

<script>
export default {
  name:"AboutUS",
   methods:{
    termsConditations(){
      window.location.href="/terms-conditations";
    },
    termsUse(){
      window.location.href="/terms-of-use";
    },
    privacyPolicy(){
      window.location.href="/privacy-policy";
    },
  }
};
</script>

<style scoped>
.description{
  padding-right: 16px;
   padding-left: 32px;
}
ol{
  padding-left: 20px;
  padding-right: 20px;
  margin-bottom: 20px;
}
ol li{
  margin-bottom: 20px;
}
ol li ul li{
  list-style: lower-latin;
  margin-left: 20px;
  margin-top: 20px;
}
</style>