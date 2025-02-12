<script setup>
import { defineProps, ref } from 'vue';
import Producto from '@/Pages/LandingPage/Components/producto.vue'; // Importa el componente Producto
import Carrito from '@/Pages/LandingPage/Components/Carrito.vue';    // Importa el componente Carrito

// Definir las propiedades que recibe el componente
const props = defineProps({
  productos: {
    type: Array,
    required: true,
  },
});

const carrito = ref([]);

// Función para manejar la actualización de la lista de ventas
const vaciarCarrito = () => {
  carrito.value = [];
};

// Función para agregar productos al carrito
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
 <Header />
<template>
  <div>
    <!-- Sección de productos -->
    <div class="dark:bg-gray-500 contenido-principal ">
      <div class=" max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="contenido-principal mt-16">
              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Usamos el componente Producto dentro de un bucle -->
                <Producto
                  v-for="producto in props.productos"
                  :key="producto.id"
                  :producto="producto"
                     @agregar-carrito="agregarCarrito"

                />
              </div>
            </div>
          </div>
        </div>
        <Carrito :carrito="carrito" @compra-realizada="vaciarCarrito" />
      </div>
    </div>

  </div>
</template>
