require('./bootstrap');

import { createApp } from 'vue';

import router from './router';

import  App  from './App.vue';

import communservice from './services/communservice.js';

import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';




import TopbarComponent from "./compenents/template/TopbarComponent.vue";
import SidebarComponent from "./compenents/template/SidebarComponent.vue";
import RightbarComponent from "./compenents/template/RightbarComponent.vue";

const app = createApp(App) ;


app.component('v-select', vSelect);
app.component('Datepicker', Datepicker);
app.mixin(communservice);
app.component('top-bar', TopbarComponent);
app.component('side-bar',SidebarComponent );
app.component('right-bar',RightbarComponent );

app.use(ToastPlugin );

app.use(router).mount("#app");
