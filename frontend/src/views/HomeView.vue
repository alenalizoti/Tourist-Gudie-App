<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
const destinations = ref([]);
const msg = ref(null);
const router = useRouter();


async function getDestinations(){
 
    await axios.get('http://127.0.0.1:8000/api/destinations')
    .then((response) => {
      console.log(response.data.destinations);
      destinations.value = response.data.destinations;
      // console.log(destinations);
      
    })
    .catch((err) =>{
      console.error(err);
      
    })
}

  async function deleteDestination(id)  {
    await axios.delete(`http://127.0.0.1:8000/api/delete/${id}`)
    .then((response) => {
      destinations.value = destinations.value.filter(destination => destination.id !== id);
      console.log(response);
    })
    .catch((err) => {
      console.error(err);
      msg.value = err.response.data.message;
      
    })
      
  }

  function confirmDelete(id){
    if(confirm("Are you sure you want to delete this destination?")){
      deleteDestination(id)
    }
  }

  function updatePage(id){
    router.push({name : 'update',params : {id}});
  }

  function addNewDestination(){
    router.push({name : 'addDestination'});
  }
  


getDestinations();

</script>

<template>
  <main>
    <h1 class="text-center">Destinations</h1>
    <div @click="addNewDestination" class="d-flex justify-content-center mt-3"><button class="btn btn-primary">Add new</button></div>
    <div class="container">
      <div v-if="msg" class="alert alert-danger">
        <ul>
           <li>{{ msg }}</li>
        </ul>
      </div>
      <table class="table mt-5">
        <thead>
            <tr>
              <th>Name</th>
              <th>Description</th>
              <th class="text-center" colspan="2">Action</th>
            </tr>
        </thead>
       <tbody>

         <tr v-for="destination in destinations" :key="destination.id">
           <td>
            <router-link :to="`/destination/articles/${destination.id}`">
              {{ destination.name   }}
            </router-link>
          </td>
           <td>{{ destination.description.slice(0,80) + "..." }}</td>
           <td><button @click="updatePage(destination.id)" class="btn btn-primary">Update</button></td>
           <td><button @click="confirmDelete(destination.id)" class="btn btn-danger">Delete</button></td>
         </tr>
       </tbody>
  
      </table>
    </div>
  </main>
</template>
