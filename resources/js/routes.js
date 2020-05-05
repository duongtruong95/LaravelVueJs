import Home from './components/HomeComponent';
import Login from './components/LoginComponent';
import Dashboard from './components/DashboardComponent';

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
        path: '/dashboard',
        component: Dashboard,
        name: 'dashboard',
        meta: {
            auth: true
        },
    }
];

export default routes;
