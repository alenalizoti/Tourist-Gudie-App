<template>
  <div class="container">
    <h2 class="text-center">Admin panel</h2>
    <table class="table mt-5">
        <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>User type</th>
              <th>Status</th>
              <th class="text-center" colspan="2">Action</th>
            </tr>
        </thead>
       <tbody>

         <tr v-for="user in users" :key="user.id">
           <td>{{ user.name}}</td>
           <td>{{ user.email }}</td>
           <td>{{ user.user_type }}</td>
           <td>{{ user.status }}</td>
           <td><button @click="updatePage(user.id)" class="btn btn-primary">Update</button></td>
           <td><button @click="confirmDelete(user.id)"  class="btn btn-danger">Delete</button></td>
         </tr>
       </tbody>
  
      </table>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import router from '@/router';

var users = ref([]);

async function getUsers() {
    try{
        const response = await axios.get(`http://127.0.0.1:8000/api/users`);
        console.log(response);
        users.value = response.data.data;
        console.log(users.value);
        
    }
    catch(error){
        console.error(error);
    }
}

async function deleteUser(id){
    try{
        const response = await axios.delete(`http://127.0.0.1:8000/api/delete/user/${id}`)
        console.log(response);
        users.value = users.value.filter(user => user.id !== id);
    }
    catch(error){
        console.error(error);
    }
}

function confirmDelete(id){
    if(confirm('Are you sure you want to delete this user?')){
        deleteUser(id);
    }
}

function updatePage(id){
    router.push({name : 'updateUser', params : {id}});
}

getUsers();
</script>

<style>

</style>