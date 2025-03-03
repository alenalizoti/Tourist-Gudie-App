  <template>
    <div class="container mt-3">
      <div class="d-flex flex-column align-items-center" v-if="props.comments.length > 0">
          <div v-for="comment in paginatedComments" :key="comment.id" class="card mb-3 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <h5 class="card-title text-primary">{{ comment.author_name }}</h5>
                <DateTimeFormater :date-time="comment.created_at" />
              </div>
              <p class="card-text">{{ comment.content }}</p>
            </div>
          </div>
      </div>
      <Pagination :items="props.comments" :per-page="3" @update-paginated-items="paginatedComments = $event" />
    </div>
    
    
  </template>

  <script setup>
  import { defineProps, ref, watch } from 'vue';
  import Pagination from '@/components/Pagination.vue';
  import DateTimeFormater from './DateTimeFormater.vue';
  const props = defineProps({
      comments : Array
  })
  const paginatedComments = ref([]) 

  watch(() => props.comments, (newComments) => {
  paginatedComments.value = newComments;
}, { immediate: true });
  </script>

  <style scoped>
  .card{
      width: 70%;
  }

  </style>