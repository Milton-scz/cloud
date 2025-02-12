<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Producto from '@/Components/producto.vue'; // Importa el componente Producto
import Carrito from '@/Components/Carrito.vue';    // Importa el componente Carrito
const page = usePage();
const productos = ref(page.props.productos);
const carrito = ref([]);
// Función para manejar la actualización de la lista de ventas
const vaciarCarrito = () => {
  carrito.value = [];
};
const roles = computed(() => window.Laravel?.roles || []);
const permissions = computed(() => window.Laravel?.permissions || []);
const userData = computed(() => window.Laravel?.user || {});

const hasRole = (role) => {
  return roles.value.includes(role);
};

const hasPermission = (permission) => {
  return permissions.value[permission] === true;
};
// Función para agregar productos al carrito
const agregarCarrito = (producto) => {
  const item = carrito.value.find((p) => p.id === producto.id);
  if (item) {
      item.cantidad += 1;
      item.total = item.cantidad * item.precio;

  } else {
    carrito.value.push({ ...producto, cantidad: 1 ,total:producto.precio});
  }
};
</script>

<template>
  <Head title="Productos" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Ventas
      </h2>
    </template>

    <div>
      <!-- Sección de productos -->
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
              <section id="contenido_principal">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                  <!-- Usamos el componente Producto dentro de un bucle -->
                  <Producto
                    v-for="producto in productos"
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
      <Carrito
        :carrito="carrito"
        @compra-realizada="vaciarCarrito"
      />
    </div>
  </AuthenticatedLayout>
</template>
