<template>
<div class="container">
    <h3 class="text-center title">Comments</h3>
    <div class="form-container">
    <form class="form" @submit.prevent="postComment">
        <div class="form-item author mb-3 mt-3">
            <label class="form-label">Author:</label>
            <input type="text" class="form-control" v-model="newComment.author_name"/>
        </div>
        <div class="form-item comment-item mb-3 mt-3">
            <label class="form-label">Comment:</label>
            <textarea rows="8" class="form-control" v-model="newComment.content"></textarea>
        </div>
            <div class="form-button d-flex justify-content-center mt-3 mb-3">
            <button  class="btn btn-success">Send</button>
        </div>
    </form>
    </div>
</div>
</template>
<script setup>
import { defineProps,defineEmits, reactive, ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    article_id : Number,
})  

const emit = defineEmits(['comment-added','comment-error'])

const newComment = reactive({
  author_name: '',
  content : ''
})

const msg = ref([])

async function postComment(){
  try{
    const response = await axios.post('http://127.0.0.1:8000/api/app/add/comment',{
        article_id : props.article_id,
        author_name : newComment.author_name,
        content : newComment.content
    })
    console.log(response);

    if(response.status == 201){
        alert('Comment added successfully');
        newComment.author_name = ''
        newComment.content = ''
        emit('comment-added')
        msg.value = null
    }
  }catch(error){
    console.error(error);
    msg.value = error.response.data.errors
    emit('comment-error',msg.value)
  }
}

</script>

<style scoped>
.title {
    margin-top: 1em;
}
  
.form-container {
    display: flex;
    justify-content: center;
}

.form {
    display: flex;
    flex-direction: column;
    width: 40em;
}


.author {
    width: 100%;
}

.comment-item {
    width: 100%;
}
</style>
  