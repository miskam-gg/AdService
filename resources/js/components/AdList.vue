<template>
    <div>
      <h1>Список объявлений</h1>
      <router-link to="/create-ad">Создать новое объявление</router-link> <!-- Добавленная ссылка -->
      <div v-if="ads.length">
        <div v-for="ad in ads" :key="ad.id" class="ad-item">
          <h3>{{ ad.title }}</h3>
          <img :src="ad.photos[0]" alt="Главное фото">
          <p>Цена: {{ ad.price }} руб.</p>
          <router-link :to="'/ad/' + ad.id">Подробнее</router-link>
        </div>
        <pagination :current-page="currentPage" :last-page="lastPage" @page-changed="fetchAds" />
      </div>
      <div v-else>
        <p>Объявлений пока нет.</p>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';
  import Pagination from './Pagination.vue';

  export default {
    data() {
      return {
        ads: [],
        currentPage: 1,
        lastPage: 1,
      };
    },
    components: {
      Pagination,
    },
    methods: {
      fetchAds(page = 1) {
        axios.get(`/api/ads?page=${page}`)
          .then(response => {
            this.ads = response.data.data;
            this.currentPage = response.data.current_page;
            this.lastPage = response.data.last_page;
          });
      },
    },
    mounted() {
      this.fetchAds();
    }
  };
  </script>
