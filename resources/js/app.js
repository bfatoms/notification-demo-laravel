import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia';

const app = createApp(App);

// Use Pinia for state management
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.mount('#app');
