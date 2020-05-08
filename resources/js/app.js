require('./bootstrap');

import Vue from 'vue';
import App from './components/AppComponent';
import store from './store/index';
import router from './router';
import i18n from '../plugin/i18n';
import api from './api'
Object.defineProperty(Vue.prototype, '$api', { value: api })
import CKEditor from 'ckeditor4-vue';
Vue.use( CKEditor );

const app = new Vue({
    el: '#app',
    i18n,
    store,
    CKEditor,
    router,
    render: h => h(App)
});

export default app;
