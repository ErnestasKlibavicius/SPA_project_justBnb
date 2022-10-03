import { createRouter, createWebHistory } from 'vue-router';  
import Bookables from './bookables/Bookables.vue';
import Bookable from './bookable/Bookable.vue';
import Review from './review/Review.vue';

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
    },
    {
        path: '/review/:id',
        name: 'review',
        component: Review,
    }
];


const router = createRouter({
    history: createWebHistory(),
    routes // short for routes: routes
})

export default router;