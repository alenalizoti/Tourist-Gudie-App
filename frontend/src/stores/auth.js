import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
  state : () => ({
    user : null,
    token : null
  }),
  actions : {
    async register(name,email,password){
      try{
        const response = await axios.post('http://127.0.0.1:8000/api/register',{
          name,
          email,
          password
        });
        console.log(response.data);
      }catch(error){
        
        console.error(error);
        
      }
    }
  }
  
});
