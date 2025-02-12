<template>
    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
      <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Carrito</h2>
      <div v-if="carrito && carrito.length > 0">
        <!-- Tabla con productos -->
        <table class="w-full table-auto border-collapse border border-gray-300 dark:border-gray-700">
          <thead>
            <tr class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
              <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">Producto</th>
              <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">Candtida</th>
              <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">Precio</th>
              <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">Total</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in carrito" :key="item.id" class="border-b border-gray-300 dark:border-gray-700">
              <td class="border border-gray-300 dark:border-gray-700 px-4 py-2  dark:text-white">{{ item.nombre }}</td>
              <td class="border border-gray-300 dark:border-gray-700 px-4 py-2  dark:text-white">{{ item.cantidad }}</td>
              <td class="border border-gray-300 dark:border-gray-700 px-4 py-2  dark:text-white">{{ item.precio }} USD</td>
              <td class="border border-gray-300 dark:border-gray-700 px-4 py-2  dark:text-white"> {{ (item.cantidad * item.precio).toFixed(2) }} USD
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Botón de realizar compra -->
        <div class="mt-4 flex justify-end">
    <Link :href="route('landing.pagos.create')" @click="emitirCompra" class="inline-block px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
        Ir a Pagar
    </Link>
</div>


      </div>
      <!-- Mensaje si el carrito está vacío -->
      <div v-else class="text-gray-500 dark:text-gray-400 mt-4">
        El carrito está vacío.
      </div>
    </div>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3';


  const props = defineProps({
    carrito: {
      type: Array,
      required: true,
    },
  });

  // Emitir eventos al componente padre
  const emit = defineEmits(["compra-realizada"]);

  const emitirCompra = () => {
    if (props.carrito.length === 0) {
      alert("El carrito está vacío.");
      return;
    }
    localStorage.removeItem('carrito');
    // Guardar los detalles del carrito en localStorage
    localStorage.setItem('carrito', JSON.stringify(props.carrito));


  };
  </script>
