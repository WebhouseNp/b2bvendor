require('./bootstrap');

import Vue from 'vue'
import Vuelidate from 'vuelidate'

Vue.use(Vuelidate);

Vue.component('loginhomepage',require('./components/vendorLogin/vendorHomepage.vue').default);
Vue.component('login',require('./components/vendorLogin/login.vue').default);
Vue.component('register',require('./components/Register/selectCategory.vue').default);
Vue.component('forgetpassword', require('./components/vendorLogin/forgetpassword.vue').default);
Vue.component('verification',require('./components/vendorLogin/accountVerification.vue').default);
Vue.component('resetpassword',require('./components/vendorLogin/Reset.vue').default);
Vue.component('createdeal',require('./components/vendorDashboard/createDeal.vue').default);

// Chat components
Vue.component ('chatbox', require('./components/chat/chatbox.vue').default);

const app = new Vue({
    el: "#app",
})
