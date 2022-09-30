import { createRouter, createWebHistory } from 'vue-router';  
import Bookables from './bookables/Bookables.vue';

const About = {template: '<div> about page </div>'}

const routes =  [
    { 
        path: '/',
        name: 'home',
        component: Bookables,
       
    }, 
    {
        path: '/about',
        name: 'apie',
        component: About
    }
];


const router = createRouter({
    history: createWebHistory(),
    routes // short for routes: routes
})

export default router;