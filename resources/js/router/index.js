import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import About from '../pages/About';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';

import Companies from '../components/Companies';
import AddCompany from '../components/AddCompany';
import EditCompany from '../components/EditCompany';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'about',
        path: '/about',
        component: About
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'Companies',
        path: '/Companies',
        component: Companies
    },
    {
        name: 'addcompany',
        path: '/Companies/add',
        component: AddCompany
    },
    {
        name: 'editcompany',
        path: '/Companies/edit/:id',
        component: EditCompany
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
