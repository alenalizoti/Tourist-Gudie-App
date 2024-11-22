<template>
  <div class="container">
    <h1 class="text-center">Update destination</h1>
    <div v-if="errors" class="alert alert-danger">
      <ul>
        <li v-for="(fieldErrors, fieldName) in errors" :key="fieldName">
          {{ fieldErrors[0] }}
        </li>
      </ul>
    </div>
    <div class="form">
        <form @submit.prevent="updateDestination">
            <div class="form-group">
                <label for="name">Destination</label>
                <input class="form-control" type="text" v-model="destination.name" >
            </div>
            <div class="form-group">
                <label for="name">About destination:</label>
                <textarea class="form-control" name="" v-model="destination.description" id="" cols="80" rows="7"></textarea>
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
import { useRouter } from 'vue-router';


const route = useRoute();
let destination = ref({});
const id = route.params.id;
let errors = ref(null);

async function getDestination(){
    await axios.get(`http://127.0.0.1:8000/api/destination/${id}`)
    .then((response) => {
        console.log(response.data.data);
        destination.value = response.data.data;
        console.log(destination.value);
        
        
    })
    .catch((err) => {
        console.error(err);
    })
}

async function updateDestination(){
    await axios.put(`http://127.0.0.1:8000/api/update/destination/${id}`,{
        name : destination.value.name,
        description : destination.value.description
    })
    .then((res) => {
        // console.log(res);
        router.push({name : 'home'});
        
    })
    .catch((error) => {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        } else {
            console.error("An unexpected error occurred:", error);
        }
        
    })
}

getDestination(id);
</script>

<style>

</style>