<template>
  <div class="container">
    <h2 class="text-center">Add new article</h2>
    <div v-if="errors" class="alert alert-danger">
      <ul>
        <li v-for="(fieldErrors, fieldName) in errors" :key="fieldName">
          {{ fieldErrors[0] }}
        </li>
      </ul>
    </div>
    <div class="form">
        <form @submit.prevent="addNewArticle">
            <div class="form-group">
                <label for="name">Title</label>
                <input class="form-control" v-model="title" type="text"  >
            </div>
            <div class="form-group">
                <label for="name">Content:</label>
                <textarea class="form-control" name="" v-model="content"  id="" cols="80" rows="7"></textarea>
            </div>
            <div class="form-group">
                <label for="name">Destination:</label>
                <select  v-model="destinationId" class="form-control" name="" id="">
                    <option disabled  value="">Choose destination...</option>
                    <option v-for="destination in destinations" :key="destination.id" :value="destination.id">{{ destination.name }}</option>
                </select>
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
                <button class="btn btn-primary">Add new</button>
            </div>
        </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import router from '@/router';

var title = ref(null);
var content = ref(null);
var destinationId = ref(null);
var destinations = ref([]);
var activities = ref([]);
var selectedActivities = ref([]);
var userId = getUserID();
var errors = ref(null);


async function getDestinations(){
 
 await axios.get('http://127.0.0.1:8000/api/destinations')
 .then((response) => {
   console.log(response.data.destinations);
   destinations.value = response.data.destinations;
   console.log(destinations.value);
   
 })
 .catch((err) =>{
   console.error(err);
   
 })
}
function getUserID(){
    const response = localStorage.getItem('user');
    if(response){
        var user = JSON.parse(response);
        return user.id;
    }
    return 0;
}
async function addNewArticle(){
    await axios.post(`http://127.0.0.1:8000/api/add/article`,{
        title : title.value,
        content : content.value,
        destination_id : destinationId.value,
        user_id : userId,
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
        } 
        else {
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


getDestinations();
getActivities();
</script>

<style>

</style>