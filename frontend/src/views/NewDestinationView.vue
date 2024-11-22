<template>
  <div class="container">
    <h2 class="text-center">Add new destination</h2>
    <div v-if="errors || msg" class="alert alert-danger">
      <ul>
        <li v-for="(fieldErrors, fieldName) in errors" :key="fieldName">
          {{ fieldErrors[0] }}
        </li>
        <li v-if="msg">{{ msg }}</li>
      </ul>
    </div>
    <div class="form">
        <form @submit.prevent="addDestination">
            <div class="form-group">
                <label for="name">Destination</label>
                <input class="form-control" v-model="name" type="text"  >
            </div>
            <div class="form-group">
                <label for="name">About destination:</label>
                <textarea class="form-control" name="" v-model="description"  id="" cols="80" rows="7"></textarea>
            </div>
            <div class="d-flex mt-5 justify-content-center">
                <button class="btn btn-primary">Add new</button>
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
var name = null;
var description = null;
var errors = ref(null);
var msg = ref(null)

async function addDestination(){
    await axios.post(`http://127.0.0.1:8000/api/add/destination`,{
        name : name,
        description : description
    })
    .then((res) => {
        console.log(res);
        router.push({name : 'home'});
    })
    .catch((error) => {
        console.error(error);
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        } else if(error.response && error.response.status === 409){
            msg.value = error.response.data.message; 
            console.log(msg.value);
            
        }
        else {
            console.error("An unexpected error occurred:", error);
        }
        
    })
}
</script>

<style>

</style>