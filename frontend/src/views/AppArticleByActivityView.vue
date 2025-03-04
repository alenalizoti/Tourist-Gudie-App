<template>
  <div v-if="articles.length > 0" class="container">
    <h1 class="text-center mt-3 mb-3">Articles by {{ activity.name }}</h1>
    <ItemCard :items="articles" />
  </div>
</template>

<script setup>
import { ref,onMounted, watch } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';
import ItemCard from '@/components/ItemCard.vue';

const articles = ref([])
const activity = ref({})
const route = useRoute()
const id = route.params.id

const getArticles = async (id) => {
    try{
        const response = await axios.get(`http://127.0.0.1:8000/api/articles/activity/${id}`)
        articles.value = response.data.data
        console.log(articles.value);
        
        activity.value = articles.value
            .flatMap(article => article.activities) 
            .find(activity => activity.id === Number(id)); 
        
        
    }catch(error){
        console.error(error);
    }
}

onMounted(() => getArticles(id));
watch(() => route.params.id, (newID) => {
    if (newID) getArticles(newID)
});

</script>

<style>

</style>