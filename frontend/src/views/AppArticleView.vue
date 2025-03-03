<template>
  <div class="container">
    <SingleArticle :article="article" />
    <ReadComments :comments="comments"  />
    <div v-if="errors" class="alert alert-danger">
      <ul>
        <li v-for="(fieldErrors, fieldName) in errors" :key="fieldName">
          {{ fieldErrors[0] }}
        </li>
      </ul>
    </div>
    <ArticleAddComments :article_id="id" @comment-added="getComments"  @comment-error="handleCommentError"/>
  </div>
</template>

<script setup>
import { watch,onMounted, computed, ref } from 'vue';
import { useRoute } from 'vue-router';
import { singleArticle } from '@/stores/singleArticle';
import SingleArticle from '@/components/SingleArticle.vue';
import ArticleAddComments from '@/components/ArticleAddComments.vue';
import axios from 'axios';
import ReadComments from '@/components/ReadComments.vue';


const route = useRoute()
const id = route.params.id
const store = singleArticle()
const article = computed(() => store.article);
var comments = ref([])
const errors = ref(null)  

const loadArticle = () => {
    store.article = {
        title: '',
        destination: { name: '' },
        user: { name: '' },
        activities: []
    };

    store.getArticle(route.params.id);
};

async function getComments(){
  try{
    const response = await axios.get(`http://127.0.0.1:8000/api/app/add/comment/article/${id}`)
    comments.value = response.data.data
    console.log(comments.value);
    errors.value = null
  }catch(error){
    console.error(error);
  }
}

function handleCommentError(errorMessages) {
  errors.value = errorMessages;
}

onMounted(loadArticle)
onMounted(getComments)


watch(() => route.params.id, () => {
    loadArticle();
});


</script>

<style scoped>

</style>