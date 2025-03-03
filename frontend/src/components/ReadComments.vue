<template>
  <div class="container mt-3">
    <div class="d-flex flex-column align-items-center" v-if="props.comments.length > 0">
        <div v-for="comment in props.comments" :key="comment.id" class="card mb-3 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-primary">{{ comment.author_name }}</h5>
            <p class="card-text">{{ comment.content }}</p>
          </div>
        </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    comments : Array
})
</script>

<style scoped>
.card{
    width: 70%;
}

</style>