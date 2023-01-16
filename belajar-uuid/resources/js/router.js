import { createRouter, createWebHistory } from "vue-router";
import { useUserStore } from "./store/user";

const Home = () => import('@/views/Home.vue')
const About = () => import('@/views/About.vue')
const Campaign = () => import('@/views/Campaign.vue')
const Verification = () => import('@/views/Verification.vue')

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
            path: '/campaign',
            name: 'campaign',
            component: Campaign,
            meta: {
                requiredAdmin: true
            }
        },
        {
            path: '/verification',
            name: 'verification',
            component: Verification,
            meta: {
                requiredVeri: true
            }
        },
        {
            path: '/cacthAll(.*)',
            redirect: '/'
        }
    ], // short for `routes: routes`
})

router.beforeEach((to, from) => {
    const auth = useUserStore()
    if(to.meta.requiredVeri){
        if(!auth.isNotVerification){
            alert("Anda Tidak Memiliki akses di halaman ini")
            return {
                path: '/'
            }
        }
    }

    if(to.meta.requiredAdmin){
        if(!auth.isAdmin){
            alert("Halaman ini hanya bisa diakses oleh admin")
            return {
                path: '/'
            }
        }
    }
})

export default router
