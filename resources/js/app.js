

require('./bootstrap');

window.Vue = require('vue');

Vue.filter('underscoreToWhitespace', function (value) {
    return value.split('_').join(' ');
});

Vue.filter('capitalize', function (value) {
    return value.charAt(0).toUpperCase() + value.slice(1)
});

Vue.filter('plusForPositiveNumber', function (value) {
    return (Number.isInteger(value) && value > 0)
        ? '+' + value
        : value;
});

Vue.component(
    'popup-modal',
    require('./components/PopupModal.vue').default
);

Vue.component(
    'store-management',
    require('./components/StoreManagement.vue').default
);

Vue.component(
    'store-trade',
    require('./components/StoreTrade.vue').default
);

Vue.component(
    'flash-messages',
    require('./components/FlashMessages.vue').default
);


const app = new Vue({
    el: '#app',
});
