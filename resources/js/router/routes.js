import Home from '../components/HomeComponent';
import Login from '../components/LoginComponent';
import Product from '../components/ProductComponent';
import Register from '../components/RegisterComponent';
import CreateNotification from "../components/CreateNotification";

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
        path: '/create',
        component: CreateNotification,
        name: 'createNotification',
        meta: {
            auth: true
        },
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
