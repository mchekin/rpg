

require('./bootstrap');

window.Vue = require('vue');

Vue.component(
    'store-management',
    require('./components/StoreManagement.vue').default
);

const app = new Vue({
    el: '#app',
});

require('./notifications.js');
