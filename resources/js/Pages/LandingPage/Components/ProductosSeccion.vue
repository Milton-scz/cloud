<template>
    <div>
        <Header @search="handleSearch" />

<div class="contenido-principal mt-16">
      <Catalogo :productos="productos"/>
      <Footer :pageview="pageview" />
    </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import Header from '@/Pages/LandingPage/Components/Header.vue';
  import Footer from '@/Pages/LandingPage/Components/Footer.vue';
  import Catalogo from '@/Pages/LandingPage/Components/Catalogo.vue';
  import {usePage } from '@inertiajs/vue3';

const page = usePage();
const productos = ref(page.props.productos);
const pageview = ref(page.props.pageview);
const handleSearch = async (searchTerm) => {
    try {
      const response = await axios.get(route('landing.productos.search'), {
        params: { search: searchTerm },
      });

      productos.value = response.data.productos.data;
      console.log('Productos encontrados:', productos.value);
    } catch (error) {
      console.error('Error buscando productos:', error);
    }
  };
  </script>
  <style scoped>
  </style>
