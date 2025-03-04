<template>
    <span v-if="formattedDateTime">Posted: {{ formattedDateTime }}</span>
    <span v-else>Posted: No information...</span>
  </template>
<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
      dateTime : String
})

const formattedDateTime = computed(() => {
  if (!props.dateTime) return '';

  const date = new Date(props.dateTime);
  return date.toLocaleString('sr-RS', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
  });
});

</script>

