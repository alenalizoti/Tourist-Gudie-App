<script setup>
import axios from 'axios';
import { ref } from 'vue';
const destinations = ref([]);


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
    })
      
  }

  function confirmDelete(id){
    if(confirm("Are you sure you want to delete this destination?")){
      deleteDestination(id)
    }
  }
  


getDestinations();

</script>

<template>
  <main>
    <h1 class="text-center">Destinations</h1>
    <div class="container">

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
           <td>{{ destination.name   }}</td>
           <td>{{ destination.description.slice(0,80) + "..." }}</td>
           <td><button class="btn btn-primary">Update</button></td>
           <td><button @click="confirmDelete(destination.id)" class="btn btn-danger">Delete</button></td>
         </tr>
       </tbody>
  
      </table>
    </div>
  </main>
</template>
