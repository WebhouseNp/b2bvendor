<template>
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
        <h4 class="text-center">Rest new password</h4>
        <form @submit.prevent="submitData">
          <div class="form-group">
            <label for="">New Password</label>
            <input
              type="password"
              class="form-control"
              v-model.trim="$v.password.$model"
              :class="{ 'is-invalid': validationStatus($v.password) }"
              placeholder="Enter new password"
            />
            <div v-if="!$v.password.required" class="invalid-feedback text-danger">
              The Password field is required.
            </div>
            <div v-if="!$v.password.minLength" class="text-danger">Password must be minimum 6 characters</div>
          </div>

          <div class="form-group">
            <label for="">Confirm Password</label>
            <input
              type="password"
              class="form-control"
              v-model.trim="$v.confirm_password.$model"
              :class="{ 'is-invalid': validationStatus($v.confirm_password) }"
              placeholder="Enter confirm password"
            />
            <div v-if="!$v.confirm_password.required" class="invalid-feedback text-danger">
              The Confirm Password field is required.
            </div>
            <div v-if="$v.password && !$v.confirm_password.sameAsPassword" class="text-danger">
              Password and Confirm Password should match
            </div>
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
</template>

<script>
import axios from "axios";
import swal from "sweetalert";
import { required, sameAs, minLength } from "vuelidate/lib/validators";
export default {
  name: "registor",
  props: ["token"],
  data() {
    return {
      password: "",
      confirm_password: "",
      loading: false,
    };
  },
  validations: {
    password: { required, minLength: minLength(6)},
    confirm_password: { required, sameAsPassword: sameAs('password')},
  },
  methods: {
    validationStatus: function (validation) {
      return typeof validation != "undefined" ? validation.$error : false;
    },
    async submitData() {
      this.$v.$touch();
      if (this.$v.$pendding || this.$v.$error) return;
      this.loading = true;
      try {
        const response = await axios.post(
          "https://b2badmin.webhouse.com.np/api/vendor/reset-password",
          {
            password: this.password,
            confirm_password: this.confirm_password,
            token: this.token,
          }
        );
        if (response.status === 200) {
          this.loading = false;
          swal("Good Job!", "Your password is Reset successfuly!", "success");
          window.location.href = "/vendor-login";
        }
      } catch (e) {
        //    console.log('scscsdcs',e);
        this.loading = false;
      }
    },
    vendorHomepage(){
        window.location.href = "/vendor-homepage";
    }
  },
};
</script>

<style>
</style>