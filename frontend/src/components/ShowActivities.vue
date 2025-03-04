<template>
  <div class="d-flex flex-wrap gap-2">
    <router-link v-for="activity in props.activities" :key="activity.id" :to="`/app/articles/activity/${activity.id}`" class="badge bg-primary">{{ activity.name }}</router-link>
</div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    activities : Array
})
</script>

<style>

</style>