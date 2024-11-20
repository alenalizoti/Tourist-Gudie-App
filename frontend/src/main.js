// import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

const app = createApp(App)
const pinia = createPinia()


app.use(createPinia())
app.use(router)

app.mount('#app')
 constauthStore = pinia.use(() => import('./stores/auth')).then(({ useAuthStore }) => {
    const store = useAuthStore();
    if (store.token) {
      store.refreshUser(); 
    }
  });