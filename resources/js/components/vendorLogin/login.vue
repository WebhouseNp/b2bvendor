<template>
  <div>
     <div class="container">
            <div class="row">
                <div class="col-md-12 my-3">
                    <nav>
                        <a href="javascript:void(0)" @click="vendorHomepage">
                            <img class="logo" src="/images/logo.png" alt="logo">
                        </a>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="vendor-section">
                        <div class="vendor-bg">
                            <div class="vendor-overlay">
                                <h2 class="vendor-title text-center">
                                    Become Vendor,<br>
                                    Grow Your Business
                                </h2>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-md-12 my-4">
                                <h3 class="text-center text-uppercase">Welcome to Seller market</h3>
                                <p class="text-center step-subtitle">3 Easy Steps to Sell on Sasto Wholesale</p>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="step-group">
                                    <div class="step-div text-center">
                                        <h1 class="step-div-h1">1</h1>
                                        <div class="vendor-img-wrap">
                                            
                                        </div>
                                        <p class="step-div-p">Sign-up<br>store profile</p>
                                    </div>
                                    <div class="step-div text-center">
                                        <h1 class="step-div-h1">2</h1>
                                        <div class="vendor-img-wrap">
                                           
                                        </div>
                                        <p class="step-div-p">Upload product<br>to start selling</p>
                                    </div>
                                    <div class="step-div text-center">
                                        <h1 class="step-div-h1">3</h1>
                                        <div class="vendor-img-wrap">
                                            
                                        </div>
                                        <p class="step-div-p">Adopt tools to<br>maximize sales</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Closing -->
                    </div>
                    <button type="button" class="btn btn-primary btn-block vendor-btn">Click here to list your product as a vendor !!!</button>
                </div>
                <div class="col-md-4">
                    <div class="vendor-sign-in-form">
                       <error v-if="error" :error="error"/>
                        <div style="text-align:center; front-size: 20px;" v-if="loading">loading....</div>
                        <form class="vendor-form"  @submit.prevent="onSubmit()">
                            <Input
                              label="Username"
                              type="email"
                              placeholder="example@gmail.com"
                              v-model="email"
                              
                            ></Input>
                            <Input
                              label="Password"
                              type="password"
                              placeholder="Enter Password"
                              v-model="password"
                            
                            ></Input>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input"
                                 id="rememberMe"
                                 style="margin-left:0; margin-top: 6px;">
                                <label class="form-check-label" for="rememberMe">Remember Me</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Sign in</button>
                        </form>
                        <div class="vendor-form-bt">
                            <a href="javascript:void(0)" @click="onClickSingup"> New around here? Sign Up</a><br>
                            <a href="javascript:void(0)" @click="onClickForget">Forgot Password?</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Task 1 Finished -->
        </div>
  </div>
</template>

<script>

import Input from "../vendorLogin/Input.vue";
import axios from 'axios';
import error from '../vendorLogin/Error.vue'
import validation from "./../../services/validation";

export default {
  name: "login",
  components: { Input, error },
  data() {
    return {
         validation: new validation(),
         email: "",
          password: "",
          loading: false,
          error: '',
    };
  },
  methods: {
      vendorHomepage(){
        window.location.href = "/vendor-homepage";
    },
     async onSubmit() {
       this.loading = true;
       try{  
          const response = await axios.post('/vendor/login',{
            email : this.email,
            password : this. password
          });
        if (response.status === 200) {
           localStorage.setItem('token', response.data.token);
            this.loading = false;
            window.location.href = '/vendor/dashboard'
        }
       }catch (e){
        if(e.response.status === 400){
             this.loading = false;
            this.error = e.response.data.message;
            this.validation.setMessages(this.error);
        }
        else{
            this.loading = false;
            this.error = "Invalid username/password!";
        }
       }
    },
    onClickSingup(){
        window.location.href = "/vendor-registor";
    },
    onClickForget(){
        window.location.href = "/forget-password";
    }
  },
};
</script>
 
<style>
.logo{
    height: 80px;
}
.vendor-bg {
    background: url("/images/pexels-photo-5668841.jpeg") no-repeat;
    background-size: cover;
    background-position: center center;
}

.vendor-overlay {
    padding: 104px 0;
    background-color: rgba(0, 0, 0, 0.3);
}

.vendor-title {
    color: #FFFFFF;
    font-size: 2.8rem;
    font-weight: 500;
    line-height: 1.5;
}

.vendor-sign-in-form, .vendor-section {
    background: #F2F3F7;
}

.vendor-btn {
    margin-bottom: 2rem;
}

.vendor-form {
    padding: 18px 20px;
    border: 1px solid lightgray;
}

.vendor-form-bt{
    padding: 18px 20px;
    border: 1px solid lightgray
}
.form-check {
    margin-bottom: 1rem;
}

/*************** Steps ****************/
.step-div {
    display: inline-block;
    width: 200px;
    padding: 12px;
    background: #FFFFFF;
    box-shadow: 1px 1px 6px 0px lightblue;
}

.step-group {
    display: flex;
    justify-content: space-around;
}

.step-subtitle {
    color: #FFA500;
    font-size: 1.2rem;
    font-weight: 500;
}

.step-div-h1 {
    color: #1e76bd;
}

.step-div-p {
    font-weight: 500;
}

.vendor-img-wrap {
    margin: 1.4rem 0;
}

@media screen and (max-width: 600px) {
    .step-group {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .step-div:not(:last-child) {
        margin-bottom: 1.8rem;
    }
}
</style>