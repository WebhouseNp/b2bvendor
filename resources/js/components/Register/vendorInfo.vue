<template>
  <div>
    <!-- <button @click="visibility" v-show="visible">Back</button> -->
    <div class="general-information" v-show="visible">
      <div class="container">
        <div class="row">
          <div class="row">
        <div class="col-md-12 my-3">
          <nav>
            <a href="javascript:void(0)" @click="vendorHomepage">
              <img class="logo" src="/images/logo.png" alt="logo" />
            </a>
          </nav>
        </div>
      </div>
        </div>
        <div class="row general-row">
          <div class="col-md-12 mb-4">
            <h3 class="general-title text-center">
              Vendor Details Information
            </h3>
            <form @submit.prevent="onclick">
              <div class="col-md-12 mb-4">
                <h4 class="text-center general-subtitle">
                  General Information
                </h4>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="inputShop">Shop Name</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                      id="inputShop"
                      v-model.trim="$v.shop_name.$model"
                      :class="{ 'is-invalid': validationStatus($v.shop_name) }"
                      placeholder=""
                    />
                    <div v-if="!$v.shop_name.required" class="invalid-feedback">
                      The Shop Name field is required.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputCompany">Company Name</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                      id="inputCompany"
                      v-model.trim="$v.company_name.$model"
                      :class="{
                        'is-invalid': validationStatus($v.company_name),
                      }"
                      placeholder=""
                    />
                    <div
                      v-if="!$v.company_name.required"
                      class="invalid-feedback"
                    >
                      The Email field is required.
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Representative Name</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                       v-model.trim="$v.representative_name.$model"
                      :class="{ 'is-invalid': validationStatus($v.representative_name) }"
                      placeholder="Enter representative name"
                    />
                    <div
                      v-if="!$v.representative_name.required"
                      class="invalid-feedback"
                    >
                      The Representative field is required.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">Company Address</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                       v-model.trim="$v.company_address.$model"
                      :class="{ 'is-invalid': validationStatus($v.company_address) }"
                      placeholder="Enter your company address"
                    />
                    <div
                      v-if="!$v.company_address.required"
                      class="invalid-feedback"
                    >
                      The Company Address field is required.
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Country</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <select class="form-control" v-model.trim="$v.country_id.$model"
                     :class="{ 'is-invalid': validationStatus($v.country_id) }">
                     <option value="" disabled>Select Country</option>
                      <option v-for="(country,index) in countries" 
                      :key="index" :value="country.id">{{country.name}}</option>
                    </select>
                    <div
                      v-if="!$v.country_id.required"
                      class="invalid-feedback"
                    >
                      Country field is required.
                    </div>
                  </div>
                </div>
              </div>
              <!-- col-md-12 closing -->
              <div class="col-md-12 mb-4">
                <h4 class="text-center general-subtitle">Main Contact</h4>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Name on Card</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                      v-model.trim="$v.name_on_card.$model"
                      :class="{ 'is-invalid': validationStatus($v.name_on_card) }"
                      placeholder="Enter your name on id card"
                    />
                     <div
                      v-if="!$v.name_on_card.required"
                      class="invalid-feedback"
                    >
                      The Name on Card field is required.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">ID Card Number</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                      v-model.trim="$v.id_card_number.$model"
                      :class="{ 'is-invalid': validationStatus($v.id_card_number) }"
                      placeholder="Enter your id card number"
                    />
                     <div
                      v-if="!$v.id_card_number.required"
                      class="invalid-feedback"
                    >
                      The Id Card Number field is required.
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Email Address</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                       class="form-control"
                      v-model.trim="$v.email_address.$model"
                      :class="{ 'is-invalid': validationStatus($v.email_address) }"
                      placeholder="Enter your email address"
                    />
                    <div
                      v-if="!$v.email_address.required"
                      class="invalid-feedback"
                    >
                      The Email Address field is required.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">Phone Number (With Area Code)</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                       v-model.trim="$v.phone_number.$model"
                      :class="{ 'is-invalid': validationStatus($v.phone_number) }"
                      placeholder="+299-1212324234324"
                    />
                    <div
                      v-if="!$v.phone_number.required"
                      class="invalid-feedback"
                    >
                      The Phone Number field is required.
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-12">
                    <label for="">Mobile Number</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                      v-model.trim="$v.mobile_number.$model"
                      :class="{ 'is-invalid': validationStatus($v.mobile_number) }"
                      placeholder="+299-79797983473"
                    />
                     <div
                      v-if="!$v.mobile_number.required"
                      class="invalid-feedback"
                    >
                      The Mobile number field is required.
                    </div>
                  </div>
                </div>
              </div>
              <!-- col-md-12 closing -->

              <!-- col-md-12 closing -->

              <div class="col-md-12 mb-4">
                <h4 class="text-center general-subtitle">
                  Payment Information
                </h4>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Bank Name</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                      v-model.trim="$v.bank_name.$model"
                      :class="{ 'is-invalid': validationStatus($v.bank_name) }"
                      placeholder="Enter your bank name"
                    />
                    <div
                      v-if="!$v.bank_name.required"
                      class="invalid-feedback"
                    >
                      The Bank Name field is required.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">Account Number</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                      v-model.trim="$v.account_number.$model"
                      :class="{ 'is-invalid': validationStatus($v.account_number) }"
                      placeholder="Enter your account number"
                    />
                    <div
                      v-if="!$v.account_number.required"
                      class="invalid-feedback"
                    >
                      The Account Number field is required.
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Name On Bank Account</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                       v-model.trim="$v.account_holber_name.$model"
                      :class="{ 'is-invalid': validationStatus($v.account_holber_name) }"
                      placeholder="Enter account holder name"
                    />
                    <div
                      v-if="!$v.account_holber_name.required"
                      class="invalid-feedback"
                    >
                      The Account holber name field is required.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">Paypal ID</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                      v-model.trim="$v.paypal_id.$model"
                      :class="{ 'is-invalid': validationStatus($v.paypal_id) }"
                      placeholder="Enter your paypal id"
                    />
                    <div
                      v-if="!$v.paypal_id.required"
                      class="invalid-feedback"
                    >
                      The Paypal Id field is required.
                    </div>
                  </div>
                </div>
              </div>
              <!-- col-md-12 closing -->

              <div class="col-md-12 mb-4">
                <h4 class="text-center general-subtitle">
                  Operation Information
                </h4>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Store Location</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                      v-model.trim="$v.store_location.$model"
                      :class="{ 'is-invalid': validationStatus($v.store_location) }"
                      placeholder="Enter your store location"
                    />
                    <div
                      v-if="!$v.store_location.required"
                      class="invalid-feedback"
                    >
                      The store location field is required.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">Store Contact Number</label
                    ><img
                      class="img-asterik"
                      src="/images/asterik-20.png"
                      alt="asterik-image"
                    />
                    <input
                      type="text"
                      class="form-control"
                      v-model.trim="$v.store_contact_number.$model"
                      :class="{ 'is-invalid': validationStatus($v.store_contact_number) }"
                      placeholder="Enter your store contact number"
                    />
                    <div
                      v-if="!$v.store_contact_number.required"
                      class="invalid-feedback"
                    >
                      The store contact number field is required.
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-12 text-center">
                <button class="btn btn-primary custom-submit-btn">Next</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div v-show="!visible">
      <VendorSave :vendorinfo="vendorinfo" :visibility3="visibility3" />
    </div>
  </div>
</template>

<script>
import VendorSave from "./registerVendor.vue";
import { required } from "vuelidate/lib/validators";

export default {
  props: ["categoryinfo", "visibility2","countries"],
  name: "VendorInfo",
  components: { VendorSave },
  data() {
    return {
      visible: true,
      vendorinfo: {},
      shop_name: "",
      company_name: "",
      representative_name:'',
      company_address:'',
      country_id:'',
      name_on_card:'',
      id_card_number:'',
      email_address:'',
      phone_number:'',
      mobile_number:'',
      bank_name:'',
      account_number:'',
      account_holber_name:'',
      paypal_id:'',
      store_location:'',
      store_contact_number:'',
    };
  },
  validations: {
    shop_name: { required},
    company_name: { required },
    representative_name:{ required },
    company_address: {required},
    country_id:{ required },
    name_on_card:{required},
    id_card_number:{required},
    email_address: {required},
    phone_number:{required},
     mobile_number:{required},
      bank_name:{required},
      account_number:{required},
      account_holber_name:{required},
      paypal_id:{required},
      store_location:{required},
      store_contact_number:{required},
  },
  methods: {
     validationStatus: function (validation) {
      return typeof validation != "undefined" ? validation.$error : false;
    },
  
    onclick() {
      this.$v.$touch();
      if (this.$v.$pendding || this.$v.$error) return;
      this.vendorinfo = {
        categoryinfo: this.categoryinfo,
        shop_name: this.shop_name,
        company_name: this.company_name,
        representative_name: this.representative_name,
        company_address: this.company_name,
        name_on_card: this.name_on_card,
        id_card_number: this.id_card_number,
        email_address: this.email_address,
        phone_number: this.phone_number,
        mobile_number: this.mobile_number,
        bank_name: this.bank_name,
        account_number: this.account_number,
        account_holber_name: this.account_holber_name,
        paypal_id: this.paypal_id,
        store_location: this.store_location,
        store_contact_number: this.store_contact_number,
      };
      this.visible = false;
    },
    visibility() {
      this.visibility2();
    },
    visibility3() {
      this.visible = !this.visible;
    },
     vendorHomepage(){
        window.location.href = "/vendor-homepage";
    },
  },
};
</script>

<style>
</style>