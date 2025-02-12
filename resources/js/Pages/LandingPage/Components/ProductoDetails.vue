<script setup>
import { defineProps, ref } from 'vue';
import Producto from '@/Pages/LandingPage/Components/producto.vue';
import Carrito from '@/Pages/LandingPage/Components/Carrito.vue';
import Header from '@/Pages/LandingPage/Components/Header.vue';
import Footer from '@/Pages/LandingPage/Components/Footer.vue';

// Definir las propiedades que recibe el componente
const props = defineProps({
  producto: {
    type: Object,
    required: true,
  },
});
const carrito = ref([]);
const vaciarCarrito = () => {
  carrito.value = [];
};
const agregarCarrito = (producto) => {
  const item = carrito.value.find((p) => p.id === producto.id);
  if (item) {
    item.cantidad += 1;
    item.total = item.cantidad * item.precio;
  } else {
    carrito.value.push({ ...producto, cantidad: 1, total: producto.precio });
  }
};
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
                  <Producto
                    :key="producto.id"
                    :producto="producto"
                    @agregar-carrito="agregarCarrito"
                  />
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
      <Carrito :carrito="carrito" @compra-realizada="vaciarCarrito" />
    </div>
    <router-view></router-view>
    <Footer :pageview="pageview" />
  </template>

