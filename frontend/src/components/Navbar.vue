<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">CMS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <router-link v-for="(item,index) in menu" :key="index" class="nav-link" aria-current="page" :to=" item.url">{{ item.name }}</router-link>
      </div>
    </div>
  </div>
</nav>
</template>

<script>
export default {
    data(){
        return{
            menu : [
                {name : 'Destinations', url : '/destinations'},
                {name : 'Articles', url : '/articles'},
            ]
        }
    }
}
</script>

<style>

</style>