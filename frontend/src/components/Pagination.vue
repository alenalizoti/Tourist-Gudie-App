<template>
    <div class="container d-flex align-items-center gap-3 justify-content-center">
         <button :disabled="currentPage === 1" class="btn btn-secondary mb-2 mr-3" @click="firstPage">First page</button>
         <button :disabled="currentPage === 1" class="btn btn-secondary mb-2 mr-3" @click="prevPage">Previous</button>
         <p>{{ currentPage }} / {{ totalPages }}</p>
         <button :disabled="currentPage === totalPages" class="btn btn-secondary mb-2" @click="nextPage">Next</button>
         <button :disabled="currentPage === totalPages" class="btn btn-secondary mb-2 mr-3" @click="lastPage">Last page</button>
     </div>
 </template>
 
 <script setup>
 import { computed, ref, watch } from 'vue';
 
 const props = defineProps({
     items: Array,
     perPage: Number
 });
 
 const emit = defineEmits(['updatePaginatedItems']);
 
 const currentPage = ref(1);
 const totalPages = computed(() => Math.ceil(props.items.length / props.perPage) || 1);
 
 const paginatedItems = computed(() => {
     const start = (currentPage.value - 1) * props.perPage;
     return props.items.slice(start, start + props.perPage);
 });
 
 watch(paginatedItems, () => {
     emit('updatePaginatedItems', paginatedItems.value);
 });
 
 const firstPage = () => (currentPage.value = 1);
 const lastPage = () => (currentPage.value = totalPages.value);
 const prevPage = () => { if (currentPage.value > 1) currentPage.value--; };
 const nextPage = () => { if (currentPage.value < totalPages.value) currentPage.value++; };
 
 </script>
 