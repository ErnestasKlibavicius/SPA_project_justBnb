import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler.js';

import router from './routes';
import Index from './index.vue';

import moment from "moment";

const app = createApp({
    components: {
        "index": Index
    }
})

app.config.globalProperties.$filters = {
    fromNow(value) {
        return moment(value).fromNow();
    }
}

app.use(router)
app.mount('#app')