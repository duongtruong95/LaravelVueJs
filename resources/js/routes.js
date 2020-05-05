import Home from './components/HomeComponent';
import Login from './components/LoginComponent';
import Dashboard from './components/DashboardComponent';

const routes = [
    {
        path: '/',
        component: Home,
        name: 'index',
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
    }
];

export default routes;
