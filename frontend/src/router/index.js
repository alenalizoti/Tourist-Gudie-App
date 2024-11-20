import AboutView from '@/views/AboutView.vue'
import HomeView from '@/views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import RegistrationView from '@/views/RegistrationView.vue'
import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      // redirect : '/login',
      name: 'home',
      component : HomeView,
      meta : {
        requiresAuth : true
      }
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component : AboutView
    },
    {
      path : '/register',
      name : 'register',
      component : RegistrationView,
      meta : {
        hideNavbar : true,
      }
    },
    {
      path : '/login',
      name : 'login',
      component : LoginView,
      meta : {
        hideNavbar : true,
      }
    },
  ]
})




  router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();
  
    // Ako je korisnik ulogovan i pokušava da ide na login ili register, preusmeriti na home
    if ((to.name === 'login' || to.name === 'register') && authStore.token) {
      next('/');
    } else if (to.meta.requiresAuth && !authStore.token) {
      // Ako ruta zahteva autentifikaciju i korisnik nije ulogovan, preusmeri ga na login
      next({ name: 'login' });
    } else {
      next(); // Ako ništa od navedenog nije tačno, dozvoli pristup
    }
  });



export default router;
