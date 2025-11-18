import './bootstrap';
import { createApp } from 'vue';
import ScheduleForm from './components/ScheduleForm.vue';

const app = createApp({});

app.component('schedule-form', ScheduleForm);

app.mount('#app');
