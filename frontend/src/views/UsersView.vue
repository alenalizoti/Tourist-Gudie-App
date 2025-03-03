<template>
  <div class="container">
    <h2 class="text-center">Admin panel</h2>
    <div v-if="msg" class="alert alert-danger">
        <ul>
           <li>{{ msg }}</li>
        </ul>
      </div>
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

         <tr v-for="user in paginatedUsers" :key="user.id">
           <td>{{ user.name}}</td>
           <td>{{ user.email }}</td>
           <td>{{ user.user_type }}</td>
           <td>{{ user.status }}</td>
           <td><button @click="updatePage(user.id)" class="btn btn-primary">Update</button></td>
           <td><button @click="confirmDelete(user.id)"  class="btn btn-danger">Delete</button></td>
         </tr>
       </tbody>
      </table>
      <Pagination :items="users" :per-page="5" @update-paginated-items="paginatedUsers = $event" />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import router from '@/router';
import Pagination from '@/components/Pagination.vue';

var users = ref([]);
var msg = ref('')
const paginatedUsers = ref([])

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
        msg.value = ''
    }
    catch(error){
        console.error(error);
        msg.value = error.response.data.message
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