import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
  state : () => ({
    user : null || JSON.parse(localStorage.getItem('user')),
    token : null || localStorage.getItem('token')
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
        return response;
      }catch(error){
        
        console.error(error);
        return Promise.reject(error.response.data.message);
        
        
      }
    },
    async login(email,password){
      try{
        const response = await axios.post('http://127.0.0.1:8000/api/login',{
          email,
          password
        });
        console.log(response);

        this.token = response.data.token;
        this.user = response.data.user;
        localStorage.setItem('token',this.token);
        localStorage.setItem('user', JSON.stringify(this.user));
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
        return response.data;
      }
      catch(error){
        console.log(error);
        const errorMessage = error.response?.data?.message || "An error occurred";
        return Promise.reject(errorMessage);
        
      }
    },
    async refreshUser(){
      if(this.token){
        try{
          axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
          const response = await axios.get('http://127.0.0.1:8000/api/user');
          this.user = response.data;
          localStorage.setItem('user',JSON.stringify(this.user));
        }
        catch(error){
          console.error(error);
        }
      }
    },
    async logout(){
      try{
        await axios.post('http://127.0.0.1:8000/api/logout');
        this.token = null;
        this.user = null;
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        delete axios.defaults.headers.common['Authorization'];
      }
      catch(error){
        console.log(error);
   
      }
      
    }
  }
  
});
