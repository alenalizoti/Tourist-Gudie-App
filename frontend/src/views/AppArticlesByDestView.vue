<template>
  <div class="container">
    <h1 class="text-center mt-3 mb-3">Articles by destination</h1>
    <div class="form d-flex justify-content-center">
        <form>
            <div>
                <label class="form-label">Select destination:</label>
                <select v-model="destinationID" aria-placeholder="Choose destination">
                    <option selected value="">Choose destination</option>
                    <option  :value="destination.id"  v-for="destination in destinations" :key="destination.id">{{ destination.name }}</option>
                </select>
            </div>
        </form>
    </div>
    <ItemCard class="mt-4" v-if="articles.length > 0" :items="articles" />
    <div class="d-flex justify-content-center align-items-end spinner">
        <Spinner />
    </div>
  </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted, watch} from 'vue';
import ItemCard from '@/components/ItemCard.vue';
import Spinner from '@/components/Spinner.vue';

const destinations = ref([])
const destinationID = ref('')
const articles = ref([])

const getDestinations = async () => {
    try{
        const response = await axios.get('http://127.0.0.1:8000/api/destinations')
        console.log(response.data.destinations);
        destinations.value = response.data.destinations
    }catch(error){
        console.error(error);
    }
}

const getArticlesByDest = async (id) => {
    try{
        const response = await axios.get(`http://127.0.0.1:8000/api/destination/articles/${id}`)
        console.log(response);
        articles.value = response.data.data
    }catch(error){
        console.error(error);
    }
}
watch(destinationID,(newID) => {
    if(newID) getArticlesByDest(newID)
})
onMounted(getDestinations)

</script>

<style scoped>
.spinner{
    height: 40vh;
}
</style>