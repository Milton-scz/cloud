<template>
    <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-4 flex flex-col">
      <img :src=" producto.imagen" alt="Imagen del producto" class="h-48 w-full object-cover rounded-t-lg" />
      <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">{{ producto.nombre }}</h3>
      <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ producto.descripcion }}</p>
      <p class="text-lg font-semibold text-gray-800 dark:text-gray-100 mt-2">$ {{ producto.precio }}</p>
      <button
          @click="agregarCarrito"
        class="mt-auto bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md"
      >
        Agregar al Carrito
      </button>
    </div>
  </template>

  <script setup>
  import { defineProps, defineEmits } from 'vue';

  const props = defineProps({
    producto: Object,
  });

  const emit = defineEmits();

  const agregarCarrito = () => {
    emit('agregar-carrito', props.producto);
  };
  </script>
