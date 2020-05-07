require('./bootstrap');

import Vue from 'vue';
import App from './components/AppComponent';
import store from './store/index';
import router from './router';
import i18n from '../plugin/i18n';

const app = new Vue({
    el: '#app',
    i18n,
    store,
    router,
    render: h => h(App)
});

export default app;
