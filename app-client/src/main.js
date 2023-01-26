import "bootstrap/dist/css/bootstrap.min.css";
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios  from 'axios';
import VueAxios from 'vue-axios';
import bootstrap from "bootstrap/dist/js/bootstrap.js";
window.bootstrap = bootstrap;

import './assets/main.css'

const app = createApp(App)

app.use(router);
app.use(VueAxios, axios);

app.mount('#app');