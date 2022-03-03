require('./bootstrap');

import Vue from 'vue'

import Vuelidate from 'vuelidate'

Vue.use(Vuelidate);

import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

import ScrollAnimation from "./directive/ScrollAnimation";

Vue.directive('scrollanimation', ScrollAnimation);

Vue.component('loginhomepage',require('./components/vendorLogin/vendorHomepage.vue').default);
Vue.component('login',require('./components/vendorLogin/login.vue').default);
Vue.component('register', require('./components/Register/selectCategory.vue').default);
Vue.component('forgotpassword', require('./components/vendorLogin/forgotpassword.vue').default);
Vue.component('verification', require('./components/vendorLogin/accountVerification.vue').default);
Vue.component('resetpassword', require('./components/vendorLogin/Reset.vue').default);
Vue.component('createdeal', require('./components/vendorDashboard/createDeal.vue').default);
Vue.component('editdeal',require('./components/vendorDashboard/editDeal.vue').default);

// Chat components
Vue.component ('chatbox', require('./components/chat/Chatbox.vue').default);
Vue.component ('inbox-list', require('./components/chat/InboxList.vue').default);
Vue.component ('loading-inbox-list', require('./components/chat/LoadingInboxList.vue').default);

const app = new Vue({
    el: "#app",
})
