<template>
  <div>
    <div class="container">
      <div class="row">
        <div class="col-md-12 my-3">
          <nav>
            <a href="javascript:void(0)" @click="vendorHomepage">
              <img class="logo" src="/images/logo.png" alt="logo" />
            </a>
          </nav>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 m-auto login-row" style="padding: 30px 26px">
          <div style="text-align: center; front-size: 20px" v-if="loading">
            loding....
          </div>
          <h4 class="text-center">Login Info</h4>
          <form @submit.prevent="submitData">
            <div class="form-group">
              <label for="">Full Name</label>
              <input
                type="text"
                class="form-control"
                v-model="name"
                id=""
                aria-describedby=""
                placeholder="Enter Your Full Name"
              />
               <div class="text-danger">
               {{ validation_rule.getMessage('name') }}
             </div>
            </div>
            <div class="form-group">
              <label for="">Email address</label>
              <input
                type="email"
                class="form-control"
                v-model="email"
                id=""
                aria-describedby=""
                placeholder="email@example.com"
              />
              <div class="text-danger">
               {{ validation_rule.getMessage('email') }}
             </div>
            </div>
            <div class="form-group">
              <label for="">Password</label>
              <input
                type="password"
                class="form-control"
                v-model="password"
                id=""
                placeholder="Password"
              />
              <div class="text-danger">
               {{ validation_rule.getMessage('password') }}
             </div>
            </div>
            <div class="form-group">
              <label for="">Confirm Password</label>
              <input
                type="password"
                class="form-control"
                v-model="confirm_password"
                id=""
                placeholder="Confirm Password"
              />
              <div class="text-danger">
               {{ validation_rule.getMessage('confirm_password') }}
             </div>
            </div>
            <div class="form-check mb-3">
              <input type="checkbox" class="form-check-input"
               v-model.trim="$v.terms.$model"
               :class="{ 'is-invalid': validationStatus($v.terms) }"
               style="margin-left:0;" />
              <label class="form-check-label" for=""
                >I accept all the terms and condition.</label
              >
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary btn-signup">
                Sign Up
              </button>
            </div>
          </form>
        </div>
        <!-- col-md-12 closing -->
      </div>
    </div>
    <!-- /.register-box -->
  </div>
</template>

<script>
import axios from "axios";
import validation from "./../../services/validation";
import swal from "sweetalert";
import { sameAs} from "vuelidate/lib/validators";


export default {
  props: ["vendorinfo"],
  name: "registor",
  data() {
    return {
      validation_rule: new validation(),
      name: "",
      email: "",
      password: "",
      confirm_password: "",
      terms: false,
      loading: false,
      errors: {},
    };
  },
  validations:{
    terms: {
        sameAs: sameAs( () => true )
      }
  },
  methods: {
     validationStatus: function (validation) {
      return typeof validation != "undefined" ? validation.$error : false;
    },
    vendorHomepage(){
        window.location.href = "/vendor-homepage";
    },
    async submitData() {
      this.$v.$touch();
      if (this.$v.$pendding || this.$v.$error) return;
      this.loading = true;
      try {
        const response = await axios.post("api/vendor/register", {
          name: this.name,
          email: this.email,
          password: this.password,
          confirm_password: this.confirm_password,
          category: this.vendorinfo.categoryinfo.mainSeller,
          plan: this.vendorinfo.categoryinfo.category,
          company_name: this.vendorinfo.company_name,
          shop_name: this.vendorinfo.shop_name,
          representative_name: this.vendorinfo.representative_name,
          company_address: this.vendorinfo.company_address,
          country: this.vendorinfo.country,
          name_on_card: this.vendorinfo.name_on_card,
          id_card_number: this.vendorinfo.id_card_number,
          email_address: this.vendorinfo.email_address,
          phone_number: this.vendorinfo.phone_number,
          monile_number: this.vendorinfo.monile_number,
          bank_name: this.vendorinfo.bank_name,
          account_holder_name: this.vendorinfo.account_holder_name,
          account_number: this.vendorinfo.account_number,
          paypal_id: this.vendorinfo.paypal_id,
          store_location: this.vendorinfo.store_location,
          store_contact_number: this.vendorinfo.store_contact_number
        });
        if (response.status === 200) {
          this.loading = false;
          swal("Good Job!", "Your are registered!", "success");
          window.location.href = "/account-verification";
        }
      } catch (error) {
        if (error.response.status === 422) {
          this.loading = false;
          this.errors = error.response.data;
          this.validation_rule.setMessages(this.errors.data);
        }
      }
    },
  },
};
</script>

<style>
</style>