<template>
  <nav  class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">CMS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav d-flex align-items-center justify-content-between w-100">
        <div class="d-flex">
          <router-link v-for="(item,index) in menu" :key="index" class="nav-link" aria-current="page" :to=" item.url">{{ item.name }}</router-link>
        </div>
        <div class="ml-auto mr-13">
          <button @click="logout" class="btn btn-danger">Logout</button>
        </div>
      </div>
    </div>
  </div>
</nav>
</template>

<script>
import { useAuthStore } from '@/stores/auth';


export default {
    data(){
        return{
            menu : [
                {name : 'Destinations', url : '/destinations'},
                {name : 'Articles', url : '/articles'},
            ]
        }
    },
    methods : {
      async logout(){
        const authStore = useAuthStore();
        await authStore.logout();
        this.$router.push({ name: 'login' });
      }
    },
      
}
</script>

<style>

</style>