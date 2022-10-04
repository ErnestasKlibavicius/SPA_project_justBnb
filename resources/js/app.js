import './bootstrap';
import '@fortawesome/fontawesome-free/scss/fontawesome.scss';
import '@fortawesome/fontawesome-free/scss/brands.scss';
import '@fortawesome/fontawesome-free/scss/regular.scss';
import '@fortawesome/fontawesome-free/scss/solid.scss';
import '@fortawesome/fontawesome-free/scss/v4-shims.scss';


import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { createStore } from 'vuex';

import router from './routes';
import Vuex from 'vuex';
import Index from './index.vue';
import StarRating from './shared/components/StarRating.vue';
import FatalError from './shared/components/FatalError.vue';
import Success from './shared/components/Success.vue';
import ValidationErrors from './shared/components/ValidationErrors.vue';
import storeDefinition from './store';


import moment from "moment";

// Create a new store instance.
const store = new createStore(storeDefinition);

const app = createApp({
    components: {
        "index": Index
    }
})

app.use(store);

app.config.globalProperties.$filters = {
    fromNow(value) {
        return moment(value).fromNow();
    }
}

app.component("star-rating", StarRating);
app.component("fatal-error", FatalError);
app.component("success", Success);
app.component("v-errors", ValidationErrors);

app.use(router);
app.mount('#app');