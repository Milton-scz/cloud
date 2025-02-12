<template>
   <div class="relative bg-white dark:bg-gray-700 shadow rounded-lg p-4 flex flex-col">


        <Link  :href="route('landing.miproducto.details', producto.id)" method="get" >
        <img
          :src=" producto.imagen"
          alt="Imagen del producto"
          class="h-48 w-full object-cover rounded-t-lg"
        />
        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mt-2">{{ producto.nombre }}</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ producto.descripcion }}</p>
        </Link>

      <!-- Mostrar las estrellas y hacerlas clickeables -->
      <div class="flex items-center mt-2">
        <template v-for="n in 5" :key="n">
          <svg
            v-if="n <= producto.averageRating"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            class="w-5 h-5 text-yellow-500 cursor-pointer"
            viewBox="0 0 20 20"
            @click="openModal(n)"
          >
            <path
              fill-rule="evenodd"
              d="M10 15.27l4.18 2.18-1.64-5.15L18 7.27l-5.19-.42L10 2 7.19 6.85 2 7.27l4.46 4.03-1.64 5.15L10 15.27z"
              clip-rule="evenodd"
            />
          </svg>
          <svg
            v-else
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            stroke="currentColor"
            class="w-5 h-5 text-gray-300"
            viewBox="0 0 20 20"
            stroke-width="2"
             @click="openModal(n)"
          >
            <path
              fill-rule="evenodd"
              d="M10 15.27l4.18 2.18-1.64-5.15L18 7.27l-5.19-.42L10 2 7.19 6.85 2 7.27l4.46 4.03-1.64 5.15L10 15.27z"
              clip-rule="evenodd"
            />
          </svg>
        </template>
        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">{{ producto.averageRating }}</span>
      </div>

      <p class="text-lg font-semibold text-gray-800 dark:text-gray-100 mt-2">$ {{ producto.precio }}</p>

    </div>

    <!-- Modal para ingresar datos -->
    <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
        <h2 class="text-xl font-bold mb-4">Califica este Producto</h2>
        <form @submit.prevent="submitForm">
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" id="name" v-model="formData.name" class="w-full px-4 py-2 mt-2 border rounded-md" required />
          </div>
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
            <input type="email" id="email" v-model="formData.email" class="w-full px-4 py-2 mt-2 border rounded-md" required />
          </div>
          <div class="mb-4">
            <label for="cedula" class="block text-sm font-medium text-gray-700">Cédula</label>
            <input type="text" id="cedula" v-model="formData.cedula" class="w-full px-4 py-2 mt-2 border rounded-md" required />
          </div>
          <div class="mb-4">
            <label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
            <input type="text" id="celular" v-model="formData.celular" class="w-full px-4 py-2 mt-2 border rounded-md" required />
          </div>
          <div class="mb-4">
            <label for="puntuacion" class="block text-sm font-medium text-gray-700">Calificación</label>
            <input type="number" id="puntuacion" v-model="formData.puntuacion" class="w-full px-4 py-2 mt-2 border rounded-md" min="1" max="5" required />
          </div>
          <div class="mb-4">
    <label for="comentario" class="block text-sm font-medium text-gray-700">Comentario</label>
    <textarea
        id="comentario"
        v-model="formData.comentario"
        class="w-full px-4 py-2 mt-2 border rounded-md"
        rows="4"
    ></textarea>
</div>

          <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Enviar</button>
            <button @click="closeModal" type="button" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-md">Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';
import { defineProps, defineEmits } from 'vue';
  const props = defineProps({
    producto: Object,
  });
  if (props.producto && typeof props.producto.isOfert === 'string') {
  props.producto.isOfert = parseInt(props.producto.isOfert, 10);
}
  const emit = defineEmits();
  const isModalOpen = ref(false);
  const formData = ref({
    name: '',
    email: '',
    cedula: '',
      celular: '',
      producto_id: props.producto.id,
      puntuacion: 0,
      comentario: '',
  });


  const openModal = (rating) => {
    formData.value.puntuacion = rating;
    isModalOpen.value = true;
  };


  const closeModal = () => {
    isModalOpen.value = false;
  };


  const submitForm = () => {
      console.log(formData.value);
      axios.post(route('landing.ratings.storerating'), formData.value)
    .then(response => {
        console.log('Exito', response);
        window.location.reload();
    })
    .catch(error => {
      console.log('Hubo un error', error.response.data);
    });
    closeModal();
  };

  const agregarCarrito = () => {
    emit('agregar-carrito', props.producto);
  };


  </script>

  <style scoped>

  .fixed {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }
  .bg-opacity-50 {
    background-color: rgba(0, 0, 0, 0.5);
  }



  </style>
