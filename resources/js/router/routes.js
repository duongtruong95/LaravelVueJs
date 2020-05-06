import Home from '../components/HomeComponent';
import Login from '../components/LoginComponent';
import Product from '../components/ProductComponent';
import Register from '../components/RegisterComponent';

const routes = [
    {
        path: '/',
        component: Home,
        name: 'index',
        meta: {
            auth: true
        },
    },
    {
        path: '/login',
        component: Login,
        name: 'login',
    },
    {
        path: '/register',
        component: Register,
        name: 'register',
    },
    {
        path: '/product',
        component: Product,
        name: 'product',
        meta: {
            auth: true
        },
    }
];

export default routes;
