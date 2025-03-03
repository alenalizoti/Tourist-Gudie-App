<template>
    <div v-if="articles.length > 0" class="container">
        <h1 class="text-center mt-3 mb-4">Latest Articles</h1>
        <ItemCard :items="articles" />
    </div>
    <div v-else class="d-flex justify-content-center align-items-center vh-100">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { onMounted } from 'vue';
import ItemCard from '@/components/ItemCard.vue';

const articles = ref([])

async function getArticles(){
    try{
        const response = await axios.get('http://127.0.0.1:8000/api/app/top/articles');
        articles.value = response.data.data
        console.log(articles.value);
    }catch(error){
        console.error(error);
    }
}
onMounted(() => {
    getArticles();
});
</script>

<style>

</style>