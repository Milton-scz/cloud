<script setup>
import { defineProps, ref } from 'vue';
import MiProducto from '@/Pages/LandingPage/Components/miproducto.vue';
import Header from '@/Pages/LandingPage/Components/Header.vue';
import Footer from '@/Pages/LandingPage/Components/Footer.vue';

// Definir las propiedades que recibe el componente
const props = defineProps({
  producto: {
    type: Object,
    required: true,
  },
});



</script>
<template>
    <Header />
    <div class="contenido-principal mt-16">
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
              <section id="contenido_principal">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                  <MiProducto
                    :key="producto.id"
                    :producto="producto"

                  />
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>

    </div>
    <router-view></router-view>
    <Footer :pageview="pageview" />
  </template>

