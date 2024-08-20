import { createRouter, createWebHistory } from 'vue-router';
import AdList from '../components/AdList.vue';
import AdDetails from '../components/AdDetails.vue';
import CreateAd from '../components/CreateAd.vue'; // Импортируем компонент CreateAd.vue

const routes = [
  { path: '/', component: AdList },
  { path: '/ad/:id', component: AdDetails },
  { path: '/create-ad', component: CreateAd }, // Добавляем маршрут для создания объявления
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
