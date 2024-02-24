import { createRouter, createWebHistory } from 'vue-router'

const history = createWebHistory()

const routes = [
    { path: '/', redirect: '/users' },
    { path: '/login', component: () => import('../views/Login.vue') },
    { path: '/users', component: () => import('../views/Users.vue') },
]

export const router = createRouter({ history, routes })