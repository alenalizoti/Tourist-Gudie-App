<template>
  <div v-if="article.title" class="container">
    <h3 class="text-center mt-4">{{ article.title }}</h3>
    <h6 class="text-center">Destination: {{ article.destination.name }}</h6>
    <div class="content ">
        <p>{{ article.content }}</p>
    </div>
  </div>
  <div v-else class="d-flex justify-content-center align-items-center vh-100">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</template>

<script setup>
defineProps({
    article : Object
})
</script>

<style scoped>
.content{
  margin-top: 5em;
  font-size: 1.4em;
  display: flex;
  justify-content: center;
}
.content > p{
  padding: 0 10em;
}
</style>