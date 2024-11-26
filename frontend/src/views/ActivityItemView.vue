<template>
  <div class="container">
    <h1 class="text-center mt-3">Articles</h1>
    <div v-for="article in articles" :key="article.id" class="card mb-4">
      <div class="card-header">
        <h5 class="card-title">{{ article.title }}</h5>
      </div>
      <div class="card-body">
        <!-- Article Description -->
        <p class="card-text">{{ article.content }}</p>

        <!-- Author Section -->
        <p><strong>Author:</strong> {{ article.user.name }}</p>

        <!-- Activities Section -->
        <div>
          <strong>Activities:</strong>
          <div>
            <span v-for="(activity,index) in formattedActivities(article.activities)" :key="activity.id" class="badge badge-info mr-2 text-primary">
                <router-link :to="`/activity/${activity}`">
                    {{ article.activities[index].name }}
                </router-link>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRoute, onBeforeRouteUpdate } from 'vue-router';

const route = useRoute();
var id = route.params.id;
var articles = ref({})


async function getArticles(){
    try{
        const response = await axios.get(`http://127.0.0.1:8000/api/articles/activity/${id}`);
        articles.value = response.data.data;
        console.log(articles.value);
    }
    catch(error){
        console.error(error);
    }
}
function formattedActivities(activities) {
  return  activities.map(activity => activity.id)
}
onBeforeRouteUpdate((to, from) => {
    if (to.params.id !== from.params.id) {
        id = to.params.id;
        getArticles(); 
    }
});

getArticles();

</script>

<style>

</style>