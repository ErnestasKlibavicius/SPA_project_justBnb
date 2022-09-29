import { createRouter, createWebHistory } from 'vue-router';  
import HelloWorld from './components/HelloWorld.vue';

const About = {template: '<div> about page </div>'}

const routes =  [
    { 
        path: '/',
        name: 'tava',
        component: HelloWorld,
       
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