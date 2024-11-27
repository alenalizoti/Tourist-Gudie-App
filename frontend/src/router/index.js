import AboutView from '@/views/AboutView.vue'
import HomeView from '@/views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import RegistrationView from '@/views/RegistrationView.vue'
import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth';
import UpdateView from '@/views/UpdateView.vue'
import ArticlesView from '@/views/ArticlesView.vue'
import NewDestinationView from '@/views/NewDestinationView.vue'
import UpdateArticleView from '@/views/UpdateArticleView.vue'
import AddArticleView from '@/views/AddArticleView.vue'
import UsersView from '@/views/UsersView.vue'
import UpdateUserView from '@/views/UpdateUserView.vue'
import ActivityItemView from '@/views/ActivityItemView.vue'
import DestinationArticlesView from '@/views/DestinationArticlesView.vue'

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
      path: '/addDestination',
      name: 'addDestination',
      component : NewDestinationView,
      meta : {
        requiresAuth : true
      }
    },
    {
      path: '/update/destination/:id',
      name: 'update',
      component : UpdateView,
      meta : {
        requiresAuth : true
      }
    },
    {
      path: '/destination/articles/:id',
      name: 'articlesByDestination',
      component : DestinationArticlesView,
      meta : {
        requiresAuth : true
      }
    },
    {
      path: '/articles',
      name: 'articles',
      component : ArticlesView,
      meta : {
        requiresAuth : true
      }
    },
    {
      path: '/update/article/:id',
      name: 'updateArticle',
      component : UpdateArticleView,
      meta : {
        requiresAuth : true
      }
    },
    {
      path: '/activity/:id',
      name: 'activityArticles',
      component : ActivityItemView,
      meta : {
        requiresAuth : true
      }
    },
    {
      path: '/add/article',
      name: 'addArticle',
      component : AddArticleView,
      meta : {
        requiresAuth : true
      }
    },
    {
      path: '/users',
      name: 'users',
      component : UsersView,
      meta : {
        requiresAuth : true,
        requiresAdmin: true
      }
    },
    {
      path: '/update/user/:id',
      name: 'updateUser',
      component : UpdateUserView,
      meta : {
        requiresAuth : true,
        requiresAdmin: true
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
    }
    else if (to.meta.requiresAdmin && !authStore.isAdmin()){
      next('/');
    }
    else {
      next(); // Ako ništa od navedenog nije tačno, dozvoli pristup
    }
  });



export default router;
