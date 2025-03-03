import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";

export const singleArticle = defineStore('articles', () => {
    const article = ref({})

    const getArticle = async (id) => {
        try{
            const response = await axios.get(`http://127.0.0.1:8000/api/app/article/${id}`)
            article.value = response.data.data   
        }
        catch(error){
            console.error(error);
        }   
    }

    return {article,getArticle}
})