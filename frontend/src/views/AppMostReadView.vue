<template>
  <div v-if="articles.length > 0" class="container">
    <h1 class="text-center mt-3 mb-4">Most read articles</h1>
    <p class="text-center">Most read articles in the past month</p>
    <ItemCard :items="articles" />
    <Pagination class="mt-3" :items="articles" :per-page="4" @update-paginated-items="paginatedArticles = $event" />
  </div>
  <div v-else class="d-flex justify-content-center align-items-center vh-100">
    <Spinner />
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import Spinner from '@/components/Spinner.vue';
import ItemCard from '@/components/ItemCard.vue';
import Pagination from '@/components/Pagination.vue';

const paginatedArticles = ref([])
const articles = ref([])

const getArticles = async () => {
    try{
        const response = await axios.get('http://127.0.0.1:8000/api/app/most-read/articles')
        console.log(response.data.data);
        articles.value = response.data.data
    }catch(error){
        console.error(error);
    }
} 

watch(() => articles , (paginateArticles) => {
  paginatedArticles.value = paginateArticles;
  }, { immediate: true });

onMounted(getArticles)
</script>

