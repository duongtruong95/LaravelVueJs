import Home from '../components/HomeComponent';
import Login from '../components/LoginComponent';
import Product from '../components/ProductComponent';
import Register from '../components/RegisterComponent';
import CreateNotification from "../components/CreateNotification";
import DetailNotification from "../components/DetailNotificationComponent";
import Forbidden from "../components/ForbiddenComponent";

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
            auth: true,
            adminRole: true
        },
    },
    {
        path: '/notification/detail/:id',
        component: DetailNotification,
        name: 'detailNotification',
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
    },
    {
        path: '/403',
        component: Forbidden,
        name: '403',
    },
];

export default routes;
