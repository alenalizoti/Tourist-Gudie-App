<template>
  <nav class="navbar navbar-expand-lg navbar-white bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">GuideApp</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <router-link class="nav-link active" aria-current="page" to="/app">Home</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link"  to="/app/most-read">Most read</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link"  to="/app/destination/articles">Articles by Destination</router-link>
        </li>
      </ul>
    </div>
  </div>
</nav>
</template>

<script>
export default {

}
</script>

<style>

</style>