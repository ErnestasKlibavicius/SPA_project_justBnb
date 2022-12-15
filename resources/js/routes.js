import { createRouter, createWebHistory } from 'vue-router';
import Bookables from './bookables/Bookables.vue';
import Bookable from './bookable/Bookable.vue';
import BookableEdit from './bookable/BookableEdit.vue';
import Review from './review/Review.vue';
import Basket from './basket/Basket.vue';
import Login from './auths/Login.vue';
import Register from './auths/Register.vue';
import Bookings from './auths/Bookings.vue';



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
        path: '/bookable/:id/edit',
        name: 'bookableEdit',
        component: BookableEdit,
    },
    {
        path: '/review/:id',
        name: 'review',
        component: Review,
    },
    {
        path: '/basket',
        component: Basket,
        name: "basket"
    },
    {
        path: '/login',
        component: Login,
        name: "login"
    },
    {
        path: '/register',
        component: Register,
        name: "register"
    },
    {
        path: '/bookings',
        component: Bookings,
        name: "bookings"
    }
];


const router = createRouter({
    history: createWebHistory(),
    routes // short for routes: routes
})

export default router;
