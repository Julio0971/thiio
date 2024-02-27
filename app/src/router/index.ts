import { useStore } from '../store'
import { User } from '../interfaces'
import { useFetch } from '../composables'
import { createRouter, createWebHistory } from 'vue-router'

const history = createWebHistory()

const routes = [
    { path: '/', redirect: '/users' },
    { path: '/login', component: () => import('../views/Login.vue') },
    { path: '/users', component: () => import('../views/Users.vue') },
    { path: '/register', component: () => import('../views/Register.vue') },
    { path: '/:catchAll(.*)', component: () => import('../views/NotFound.vue') },
]

export const router = createRouter({ history, routes })

router.beforeEach(async (to, _from) => {
    const store = useStore()

    try {
        const { response, res } = await useFetch('get', '/check')

        if (response.ok) {
            store.user = res.user as User

            if (to.path == '/login' || to.path == '/register') {
                return { path: '/users' }
            }
        } else {
            throw new Error
        }
    } catch (error) {
        localStorage.removeItem('access_token')

        store.user = {} as User
        store.access_token = ''

        if (to.path != '/login' && to.path != '/register') {
            return { path: '/login' }
        }
    }
})