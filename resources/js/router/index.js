import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';

Vue.use(VueRouter);

const router = new VueRouter({
    routes,
    mode: 'history'
});

router.beforeEach((to, from, next) => {
    const loggedIn = JSON.parse(localStorage.getItem('user'));
    if (to.matched.some(record => record.meta.auth) && !loggedIn) {
        next('/login')
        return
    } else if ((to.path == '/login' && loggedIn) || (to.matched.some(record => record.meta.adminRole) && loggedIn.level == 0)) {
        next('/')
        return
    }
    next()
})

export default router;
