<template>
    <div>
      <h1>Создать объявление</h1>
      <form @submit.prevent="createAd">
        <div>
          <label for="title">Название:</label>
          <input type="text" v-model="title" id="title" required maxlength="200">
        </div>
        <div>
          <label for="description">Описание:</label>
          <textarea v-model="description" id="description" maxlength="1000"></textarea>
        </div>
        <div>
          <label for="photos">Ссылки на фотографии (через запятую):</label>
          <input type="text" v-model="photos" id="photos">
        </div>
        <div>
          <label for="price">Цена:</label>
          <input type="number" v-model="price" id="price" required step="0.01">
        </div>
        <button type="submit">Создать объявление</button>
      </form>
      <div v-if="message">
        <p>{{ message }}</p>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        title: '',
        description: '',
        photos: '',
        price: null,
        message: '',
      };
    },
    methods: {
      createAd() {
        const adData = {
          title: this.title,
          description: this.description,
          photos: this.photos.split(',').map(photo => photo.trim()), // Преобразуем строку в массив ссылок
          price: this.price,
        };

        axios.post('/api/ads', adData)
          .then(response => {
            this.message = 'Объявление создано успешно!';
            this.clearForm();
          })
          .catch(error => {
            this.message = 'Ошибка при создании объявления.';
          });
      },
      clearForm() {
        this.title = '';
        this.description = '';
        this.photos = '';
        this.price = null;
      }
    }
  };
  </script>
