import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Register from '../views/Websites/Register.vue'
import Login from '../views/Websites/Login.vue'
import WebsiteIndex from '../views/Websites/websiteList.vue'


const routes = [
  
  {path: '/login',component: Login },
  
  { path: '/', component: Register },
  { path: '/website/:email', component: WebsiteIndex, name:'WebsiteIndex' }
  
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router

    
   

