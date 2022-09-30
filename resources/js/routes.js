import { createRouter, createWebHistory } from 'vue-router';  
import Bookables from './bookables/Bookables.vue';
import Bookable from './bookable/Bookable.vue';

const routes =  [
    { 
        path: '/',
        name: 'home',
        component: Bookables,
    },
    { 
        path: '/bookable/:id',
        name: 'bookable',
        component: Bookable,
    }
];


const router = createRouter({
    history: createWebHistory(),
    routes // short for routes: routes
})

export default router;