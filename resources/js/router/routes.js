import Home from '../components/Home';
import Login from '../components/Login';
import Register from '../components/Register';
import CreateNotification from "../components/admin/CreateNotification";
import DetailNotification from "../components/admin/DetailNotification";
import ListNotification from "../components/admin/ListNotification";
import UserListNotification from "../components/ListNotification";
import UserNotification from "../components/admin/UserNotification";
import User from "../components/admin/User";
import Forbidden from "../components/Forbidden";

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
        path: '/admin/notification/create',
        component: CreateNotification,
        name: 'createNotification',
        meta: {
            auth: true,
            adminRole: true
        },
    },
    {
        path: '/admin/users',
        component: User,
        name: 'users',
        meta: {
            auth: true,
            adminRole: true
        },
    },
    {
        path: '/admin/notification/list',
        component: ListNotification,
        name: 'listNotification',
        meta: {
            auth: true,
            adminRole: true
        },
    },
    {
        path: '/admin/notification-user/:id',
        component: UserNotification,
        name: 'userNotification',
        meta: {
            auth: true,
            adminRole: true
        },
    },
    {
        path: '/notification/list',
        component: UserListNotification,
        name: 'userListNotification',
        meta: {
            auth: true
        },
    },
    {
        path: '/notification/:id',
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
        path: '/403',
        component: Forbidden,
        name: '403',
    },
];

export default routes;
