import { createRouter, createWebHistory } from "vue-router";

const Home = () => import('@/views/Home.vue')
const About = () => import('@/views/About.vue')

const router = createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/about',
            name: 'about',
            component: About,
        }
    ], // short for `routes: routes`
})

export default router
