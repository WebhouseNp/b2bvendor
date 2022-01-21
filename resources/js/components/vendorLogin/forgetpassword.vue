<template>
  <div>
    <div class="container">
      <div class="row">
        <div class="col-md-12 my-3">
          <nav>
            <a href="">
              <img class="logo" src="/images/logo.png" alt="logo" />
            </a>
          </nav>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 m-auto">
          <div class="otp-form-wrapper">
            <div style="text-align: center; front-size: 20px" v-if="loading">
              Sending....
            </div>
            <h3 class="text-center">Password Reset</h3>
            <p class="otp-verification-status">
              We'll sent you password reset link in this email
            </p>
            <form @submit.prevent="onSubmit">
              <div class="form-group">
                <label for="">Email</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="email"
                  id=""
                  aria-describedby=""
                  placeholder="Enter Your Email"
                />
                <div class="text-danger">
                  {{ validation.getMessage("email") }}
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-block">
                Send
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import validation from "./../../services/validation";
import swal from 'sweetalert';
export default {
  name: "Forgot",
  data() {
    return {
      validation: new validation(),
      email: "",
      errors: {},
      loading: false,
    };
  },
  methods: {
    async onSubmit() {
      this.loading = true;
      try {
        const response = await axios.post("api/vendor/send-email-link", {
          email: this.email,
        });
        if (response.status === 200) {
          this.loading = false;
          swal("Good Job!", "Password reset link is send to you mail!", "success");
          window.location.href = "/vendor-homepage";
        }
      } catch (error) {
        if (error.response.status === 422) {
          this.loading = false;
          this.errors = error.response.data;
          this.validation.setMessages(this.errors.data);
        }
      }
    },
  },
};
</script>

<style>
</style>