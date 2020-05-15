require('./bootstrap');

import Vue from 'vue';
import App from './components/App';
import store from './store/index';
import router from './router';
import i18n from '../plugin/i18n';
import api from './api';
import BootstrapVue from 'bootstrap-vue';
Object.defineProperty(Vue.prototype, '$api', { value: api });
Vue.use(BootstrapVue);

const app = new Vue({
    el: '#app',
    i18n,
    store,
    router,
    render: h => h(App)
});

export default app;
