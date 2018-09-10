require('./bootstrap');

window.Vue = require('vue');

Vue.component('app', require('./client/App.vue'));
Vue.component('login', require('./client/Login.vue'));
Vue.component('locks-list', require('./client/LocksList.vue'));
Vue.component('lock-activity', require('./client/LockActivity.vue'));
Vue.component('loading-feedback', require('./components/LoadingFeedback.vue'));

const app = new Vue({
	el: '#app'
});
