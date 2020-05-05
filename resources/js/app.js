/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import App from './components/AppComponent';
import i18n from '../plugin/i18n';
import store from './store';
import VueRouter from 'vue-router';
import routes from './routes';


Vue.component('home', require('./components/HomeComponent'));
Vue.component('login', require('./components/LoginComponent'));
Vue.component('app', require('./components/AppComponent'));
Vue.component('dashboard', require('./components/DashboardComponent'));
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.use(i18n);
Vue.use(VueRouter);

const router = new VueRouter({
    history: true,
    routes,
    mode: 'history'
});

router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem('user');
    if (to.matched.some(record => record.meta.auth) && !loggedIn) {
        next('/login')
        return
    }
    next()
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    i18n,
    store,
    router,
    render: h => h(App)
});
export default app
