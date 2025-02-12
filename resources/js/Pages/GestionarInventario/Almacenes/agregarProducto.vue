<template>
    <Head title="Agregar Producto" />

    <AuthenticatedLayout>
      <template #header>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Agregar Producto</h2>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
              <!-- Título -->
              <h1 class="text-2xl font-bold mb-4">Agregar Producto al Almacén: {{ almacen.nombre }}</h1>

              <!-- Formulario para agregar producto -->
              <form @submit.prevent="submitForm" class="space-y-6">
                <!-- Selección de producto -->
                <div>
                  <label for="producto_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Selecciona el producto:</label>
                  <select v-model="form.producto_id" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Seleccione un producto</option>
                    <option v-for="producto in productos" :key="producto.id" :value="producto.id">
                      {{ producto.nombre }}
                    </option>
                  </select>
                  <p v-if="form.errors.producto_id" class="text-red-500 text-xs mt-1">{{ form.errors.producto_id }}</p>
                </div>

                <!-- Input de cantidad -->
                <div>
                  <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad:</label>
                  <input
                    v-model="form.stock"
                    type="number"
                    min="1"
                    required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                  />
                  <p v-if="form.errors.stock" class="text-red-500 text-xs mt-1">{{ form.errors.stock }}</p>
                </div>

                <!-- Botón de submit -->
                <button
                  type="submit"
                  class="w-full py-2 px-4 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                  :disabled="form.processing"
                >
                  Agregar Producto
                </button>
              </form>

              <!-- Mensaje si no hay productos disponibles -->
              <div v-if="productos.length === 0" class="mt-4 text-center text-gray-600">
                <p>No hay productos disponibles para agregar a este almacén.</p>
              </div>

              <!-- Mensaje de éxito o error (si hay flash) -->
              <div v-if="flash?.success" class="mt-4 text-green-500 text-center">
                <p>{{ flash.success }}</p>
              </div>
              <div v-if="flash?.error" class="mt-4 text-red-500 text-center">
                <p>{{ flash.error }}</p>
              </div>

              <!-- Indicador de carga -->
              <div v-if="form.processing" class="mt-4 text-center">
                <span class="loader"></span>
                <p class="text-gray-500">Cargando...</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import { useForm } from '@inertiajs/vue3';
  import { usePage } from '@inertiajs/inertia-vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { computed, watch } from 'vue';

  const props = defineProps({
    almacen: Object,
    productos: Array,
  });

  const { flash } = usePage();


  const form = useForm({
    producto_id: '',
    nombre: '',
    stock: 1,
    almacen_id: props.almacen.id
  });


  const selectedProducto = computed(() => {
    const producto = props.productos.find(p => p.id === form.producto_id);
    return producto ? producto.nombre : '';
  });


  watch(() => form.producto_id, (newValue) => {
    form.nombre = selectedProducto.value;
  });


  const submitForm = () => {
    form.post(route('admin.almacenes.agregarProductoAlmacen'), {
      onSuccess: () => {

        console.log('Producto agregado correctamente.');
      },
      onError: () => {

        console.log('Hubo un error al agregar el producto.');
      },
    });
  };
  </script>

  <style scoped>

  .loader {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  </style>
