<template>
  <div class="container">
    <h1 class="text-center">Update article</h1>
    <div v-if="errors" class="alert alert-danger">
      <ul>
        <li v-for="(fieldErrors, fieldName) in errors" :key="fieldName">
          {{ fieldErrors[0] }}
        </li>
      </ul>
    </div>
    <div class="form">
        <form @submit.prevent="updateArticle">
            <div class="form-group">
                <label for="name">Destination</label>
                <input class="form-control" type="text" v-model="article.title" >
            </div>
            <div class="form-group">
                <label for="name">About destination:</label>
                <textarea class="form-control" name="" v-model="article.content" id="" cols="80" rows="7"></textarea>
            </div>
            <div class="form-group">
                <label>Assign Activities</label>
                <div v-for="activity in activities" :key="activity.id" class="form-check">
                    <input 
                        type="checkbox"
                        class="form-check-input"
                        :value="activity.id"
                        v-model="selectedActivities"
                    />
                    <label class="form-check-label">
                        {{ activity.name }}
                    </label>
                </div>
            </div>
            <div class="d-flex mt-5 justify-content-center">
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
  </div>
</template>

<script setup>
import router from '@/router';
import axios from 'axios';
import { ref } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const id = route.params.id;
let article = ref({});
let activities = ref([]);
let selectedActivities = ref([]);
let errors = ref(null);

async function getArticle(id){
    await axios.get(`http://127.0.0.1:8000/api/article/${id}`)
    .then((response) => {
        console.log(response);
        article.value = response.data.data;
        selectedActivities.value = article.value.activities.map(activity => activity.id);
        console.log(article.value);
        
    })
    .catch((error) =>{
        console.error(error);  
    })
}

async function updateArticle(){
    await axios.put(`http://127.0.0.1:8000/api/update/article/${id}`,{
        title : article.value.title,
        content : article.value.content,
        activities : selectedActivities.value
    })
    .then((response) => {
        console.log(response);
        router.push({name : 'articles'});
    })
    .catch((error) => {
        console.error(error);
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        } else {
            console.error("An unexpected error occurred:", error);
        }
    })

}
async function getActivities(){
    try{
        const response = await axios.get(`http://127.0.0.1:8000/api/activities`)
        console.log(response);
        activities.value = response.data.data;
    }
    catch(error){
        console.error(error);
    }
}

getArticle(id);
getActivities();

</script>

<style>

</style>