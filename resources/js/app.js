


require('./bootstrap');

window.Vue = require('vue');

Vue.component('series-component', require('./components/Series.vue').default);


const app = new Vue({
    el: '#app',
});
