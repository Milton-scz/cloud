<script setup>
import { defineProps, ref } from 'vue';
import MiProducto from '@/Pages/LandingPage/Components/miproducto.vue'; // Importa el componente Producto

// Definir las propiedades que recibe el componente
const props = defineProps({
  productos: {
    type: Array,
    required: true,
  },
});



</script>
 <Header />
<template>
  <div>
    <!-- Sección de productos -->
    <div class="contenido-principal ">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="contenido-principal mt-16">
              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Usamos el componente Producto dentro de un bucle -->
                <MiProducto
                  v-for="producto in props.productos"
                  :key="producto.id"
                  :producto="producto"

                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>
