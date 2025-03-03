<template>
  <div class="row justify-content-center gap-2">               
    <div v-for="item in items" :key="item.id" class="card col-md-3" style="width: 18rem;">
      <div class="card-body">
        <router-link :to="`/app/article/${item.id}`">
          <h5 class="card-title">{{ shortTitle(item.title)}} ...</h5>
        </router-link>
        <h6 class="card-subtitle mb-2 text-muted">{{ item.destination.name }}</h6>
        <p class="card-text">{{ shortContent(item.content) }} ...</p>
        <div  v-if="item.activities.length">
            <p class="text-center">Activities:</p>
            <a  v-for="activity in item.activities" :key="activity.id" href="#" class="card-link">{{ activity.name }}</a>
        </div>
        <p  class="card-text">Author: {{ item.user.name }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import router from '@/router'
import { watch } from 'vue';

const props = defineProps({
    items : Array,
})
watch(() => props.items, (newItems) => {
  console.log('Items updated:', newItems);
});

const shortContent = (text) => {
  let shorter = text.slice(0,200)
  return shorter
}

const shortTitle = (title) => {
  let shorter = title.slice(0,20)
  return shorter
}
</script>

<style scoped>
.card-title,.card-link{
  color: black;
  text-decoration: none;
  transition: 0.3s;
}
.card-link::before{
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  background-color: black;
  height: 2px;
  width: 0%;
  transition: width 0.3s ease-in-out;
}
.card-link{
  position: relative;
  overflow: hidden;
}
.card-link:hover::before{
  width: 100%;
}
.card-title:hover{
  color: rgba(128, 128, 128, 0.512);
}
.card-body > a{
  text-decoration: none;
}
</style>