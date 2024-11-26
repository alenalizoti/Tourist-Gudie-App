<template>
  <div class="container">
    <h1 class="text-center">Articles</h1>
    <div @click="addNewArticle" class="d-flex justify-content-center mt-3"><button class="btn btn-primary">Add new</button></div>
    <table class="table mt-5">
        <thead>
            <tr>
              <th>Name</th>
              <th>Description</th>
              <th>Author</th>
              <th>Activities</th>
              <th class="text-center" colspan="2">Action</th>
            </tr>
        </thead>
       <tbody>

         <tr v-for="article in articles" :key="article.id">
           <td>{{ article.title.slice(0,20) }}...</td>
           <td>{{ article.content.slice(0,30) }}...</td>
           <td>{{ article.user.name }}</td>
           <td >
            <span v-for="(activityId,index) in article.activityIds" :key="index" class="activity-item">
              <router-link :to="`/activity/${activityId}`">
                {{ article.activities[index].name }}
              </router-link>
            </span>
          </td>
           <td><button @click="updatePage(article.id)" class="btn btn-primary">Update</button></td>
           <td><button @click="confirmDelete(article.id)" class="btn btn-danger">Delete</button></td>
         </tr>
       </tbody>
  
      </table>
  </div>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
var articles = ref([]);
var activities = ref([]);

async function getArticles() {
  await axios.get(`http://127.0.0.1:8000/api/articles`)
  .then((res) => {
    console.log(res);
    
    articles.value = res.data.data.map(article => {
      return {
        ...article,
        activityNames : article.activities.map(activity => activity.name).join(', '),
        activityIds: article.activities.map(activity => activity.id)
      }
    })
  })
  .catch((error) => {
    console.error(error);
  })
}

async function deleteArticle(id){
  await axios.delete(`http://127.0.0.1:8000/api/delete/article/${id}`)
  .then((response) => {
    console.log(response);
    articles.value = articles.value.filter(article => article.id !== id);
  })
  .catch((error) => {
    console.error(error);
    
  })
}

function confirmDelete(id){
  if(confirm('Are you sure you want to delete this article?')){
    deleteArticle(id);
  }
}

function updatePage(id){
  router.push({name : 'updateArticle', params : {id}});
}

function addNewArticle(){
  router.push({name : 'addArticle'});
}

getArticles();
</script>

<style scoped>
.activity-item{
  margin-right: 4px;
}
</style>