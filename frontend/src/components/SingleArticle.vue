<template>
  <div v-if="article.title" class="container">
    <h3 class="text-center mt-4">{{ article.title }}</h3>
    <h6 class="text-center">Destination: {{ article.destination.name }}</h6>
    <ShowActivities class="d-flex justify-content-center" :activities="article.activities" />
    <div class="about d-flex justify-content-between mt-4">
      <div>
        <DateTimeFormater :date-time="article.created_at" />
        <p>Number of visits: {{ article.visit_count }}</p>
      </div>
      <p>Author: {{ article.user.name }}</p>
    </div>
    <div class="content ">
        <p>{{ article.content }}</p>
    </div>
  </div>
  <div v-else class="d-flex justify-content-center align-items-center vh-100">
       <Spinner />
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
import DateTimeFormater from './DateTimeFormater.vue';
import Spinner from './Spinner.vue';
import ShowActivities from './ShowActivities.vue';

defineProps({
    article : Object
})
</script>

<style scoped>
.content{
  margin-top: 3em;
  font-size: 1.4em;
  display: flex;
  justify-content: center;
}
.content > p{
  padding: 0 10em;
}
.about{
  padding: 0 14em;
}
</style>