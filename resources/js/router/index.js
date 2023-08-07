import { createRouter, createWebHistory } from 'vue-router';

import dashboard from '../components/dashboard.vue';
import categoryIndex from '../components/category/index.vue';
import createCategory from '../components/category/create.vue';
import editCategory from '../components/category/edit.vue';

import indexCoa from '../components/coa/index.vue';
import createCoa from '../components/coa/create.vue';
import editCoa from '../components/coa/edit.vue';

import indexTransaction from '../components/transaction/index.vue';
import createTransaction from '../components/transaction/create.vue';
import editTransaction from '../components/transaction/edit.vue';

import indexReport from '../components/report/index.vue';

import notFound from '../components/NotFound.vue';

const routes = [
    {
        path: '/',
        name: 'dashboard',
        component: dashboard
    },
    {
        path: '/category',
        name: 'category',
        component: categoryIndex
    },
    {
        path: '/new-category',
        name: 'new-category',
        component: createCategory
    },
    {
        path: '/edit-category/:id',
        name: 'edit-category',
        component: editCategory
    },
    {
        path: '/coa',
        name: 'coa',
        component: indexCoa
    },
    {
        path: '/create-coa',
        name: 'create-coa',
        component: createCoa
    },
    {
        path: '/edit-coa/:id',
        name: 'edit-coa',
        component: editCoa
    },
    {
        path: '/transaction',
        name: 'transaction',
        component: indexTransaction
    },
    {
        path: '/create-transaction',
        name: 'create-transaction',
        component: createTransaction
    },
    {
        path: '/edit-transaction/:id',
        name: 'edit-transaction',
        component: editTransaction
    },
    {
        path: '/report',
        name: 'report',
        component: indexReport
    },
    {
        path: '/:pathMatch(.*)*',
        component: notFound
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;