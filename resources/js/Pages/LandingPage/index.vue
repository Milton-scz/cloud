<template>
    <div>
      <!-- Contenido de la página -->
      <Header @search="handleSearch" />
      <LandigHero />
      <!-- Sección principal del contenido -->
      <MainContent />
      <Catalogo :productos="productos" /> <!-- Pasa los productos aquí -->
      <!-- El contenido principal de la página -->

      <!-- Footer -->
      <Footer :pageview="pageview" />
    </div>
  </template>

  <script setup>
  import { onMounted, ref } from 'vue';
  import axios from 'axios';
  import Header from '@/Pages/LandingPage/Components/Header.vue';  // Importa el Header
  import Footer from '@/Pages/LandingPage/Components/Footer.vue';  // Importa el Footer
  import MainContent from '@/Pages/LandingPage/Components/Maincontent.vue';
  import LandigHero from '@/Pages/LandingPage/Components/landing-hero.vue';
  import Catalogo from '@/Pages/LandingPage/Components/Catalogo.vue';
  import { usePage } from '@inertiajs/vue3';

  const page = usePage();
  let productos = ref(page.props.productos);
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

  <script>

 // Lógica para manejar el tema
const HSThemeAppearance = {
  init() {
    const defaultTheme = 'default';
    let theme = localStorage.getItem('hs_theme') || defaultTheme;
    this.setAppearance(theme);
  },
  setAppearance(theme) {
    if (theme === 'auto') {
      theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'default';
    }
    document.querySelector('html').classList.remove('dark', 'default');
    document.querySelector('html').classList.add(theme);
    localStorage.setItem('hs_theme', theme);
  },
  setThemeBasedOnTime() {
    const currentHour = new Date().getHours();
    const theme = currentHour >= 19 || currentHour < 6 ? 'dark' : 'default';
    this.setAppearance(theme);
  }
};


HSThemeAppearance.init();
setInterval(HSThemeAppearance.setThemeBasedOnTime(), 3000);
  HSThemeAppearance.setThemeBasedOnTime();


  </script>

  <style scoped>
  /* Estilos generales de la página */
  </style>
