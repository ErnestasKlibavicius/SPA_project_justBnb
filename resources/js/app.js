import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler.js';

import router from './routes';
import Index from './index.vue';

const app = createApp({
    components: {
        "index": Index
    }
})

app.use(router)
app.mount('#app')