<template>
  <div class="container">
    <h2 class="text-center">Update user {{ id }}</h2>
    <div v-if="errors" class="alert alert-danger">
      <ul>
        <li v-for="(fieldErrors, fieldName) in errors" :key="fieldName">
          {{ fieldErrors[0] }}
        </li>
      </ul>
    </div>
    <div class="form">
        <form @submit.prevent="updateUser">
            <div class="form-group">
                <label for="name">Name:</label>
                <input class="form-control" type="text" v-model="user.name" >
            </div>
            <div class="form-group">
                <label for="name">Email:</label>
                <input class="form-control" type="text" v-model="user.email">
            </div>
            <div class="form-group">
                <label for="name">Status:</label>
                <select class="form-control" v-model=" user.status" name="" id="">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label for="name">User type:</label>
                <select class="form-control" v-model=" user.user_type" name="" id="">
                    <option value="admin">Admin</option>
                    <option value="content_creator">Content creator</option>
                </select>
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

var user = ref([])
const route = useRoute();
const id = route.params.id;
var errors = ref(null);


async function getUser(){
    try{
        const response = await axios.get(`http://127.0.0.1:8000/api/user/${id}`)
        console.log(response);
        user.value = response.data.data;
    }
    catch(error){
        console.error(error);
        
    }
}

async function updateUser(){
    try{
        const response = await axios.put(`http://127.0.0.1:8000/api/update/user/${id}`,{
            name : user.value.name,
            email : user.value.email,
            status : user.value.status,
            user_type : user.value.user_type,
        });
        console.log(response);
        router.push({name : 'users'});
    }
    catch(error){
        console.error(error);
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        } else {
            console.error("An unexpected error occurred:", error);
        }
    }
}

getUser();
</script>

<style>

</style>