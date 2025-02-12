<template>
    <Head title="Ajuste Inventario" />

    <AuthenticatedLayout>
      <template #header>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Ajuste inventario</h2>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
              <!-- Título -->


            <!-- Formulario para agregar producto -->
<form @submit="submitForm" class="space-y-4">
  <div class="flex flex-wrap gap-2">
    <!-- Descripción -->
    <div class="w-1/6">
      <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción:</label>
      <input
        v-model="form.descripcion"
        type="text"
        required
        class="mt-1 block w-full px-2 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
      />
      <p v-if="form.errors.descripcion" class="text-red-500 text-xs mt-1">{{ form.errors.descripcion }}</p>
    </div>

    <!-- Selección de producto -->
    <div class="w-1/5">
      <label for="producto_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Producto:</label>
      <select v-model="form.producto_id" required class="mt-1 block w-full px-2 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <option value="">Seleccione</option>
        <option v-for="producto in productos" :key="producto.id" :value="producto.id">
          {{ producto.nombre }}
        </option>
      </select>
      <p v-if="form.errors.producto_id" class="text-red-500 text-xs mt-1">{{ form.errors.producto_id }}</p>
    </div>

    <!-- Selección de almacén -->
    <div class="w-1/5">
      <label for="almacen_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Almacén:</label>
      <select v-model="form.almacen_id" required class="mt-1 block w-full px-2 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <option value="">Seleccione</option>
        <option v-for="almacen in almacenes" :key="almacen.id" :value="almacen.id">
          {{ almacen.nombre }}
        </option>
      </select>
      <p v-if="form.errors.almacen_id" class="text-red-500 text-xs mt-1">{{ form.errors.almacen_id }}</p>
    </div>

    <!-- Tipo de ajuste -->
    <div class="w-1/6">
      <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de Ajuste</label>
      <select v-model="form.tipo" id="tipoServicio" class="mt-1 block w-full border px-2 py-1 rounded-md shadow-sm">
        <option value="1">Ingreso</option>
        <option value="2">Egreso</option>
      </select>
      <p v-if="form.errors.tipo" class="text-sm text-red-500 mt-2">{{ form.errors.tipo }}</p>
    </div>

    <!-- Cantidad -->
    <div class="w-1/6">
      <label for="cantidad" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad:</label>
      <input
        v-model="form.cantidad"
        type="number"
        min="1"
        required
        class="mt-1 block w-full px-2 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
      />
      <p v-if="form.errors.cantidad" class="text-red-500 text-xs mt-1">{{ form.errors.cantidad }}</p>
    </div>
  </div>

  <!-- Botón de submit -->
  <button type="submit"  class="mt-4 w-full py-2 px-4 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"  :disabled="form.processing"
  >
    Agregar Ajuste
  </button>
</form>


              <!-- Mensaje si no hay productos disponibles -->
              <div v-if="productos.length === 0" class="mt-4 text-center text-gray-600">
                <p>No hay productos disponibles para agregar a este almacén.</p>
              </div>

              <!-- Mensaje de éxito o error (si hay flash) -->
              <div v-if="flash?.value?.success" class="mt-4 text-green-500 text-center">
                <p>{{ flash.success }}</p>
              </div>
              <div v-if="flash?.value?.error" class="mt-4 text-red-500 text-center">
                <p>{{ flash.error }}</p>
              </div>

              <!-- Indicador de carga -->
              <div v-if="form.processing" class="mt-4 text-center">
                <span class="loader"></span>
                <p class="text-gray-500">Cargando...</p>
              </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding: 10px;">
                    <div style="height: 100%; overflow: auto;">
                      <table class="table table-bordered table-condensed table-striped" style="width: 100%;">
                        <!-- Encabezados de la tabla -->
                        <thead>
                          <th colspan="5"></th>
                        </thead>
                        <thead style="background-color: #dff1ff;">
                          <th style="text-align: center;">Nro</th>
                          <th style="text-align: center;">Producto</th>
                          <th style="text-align: center;">Almacen</th>
                          <th style="text-align: center;">Tipo de Ajuste</th>
                          <th style="text-align: center;">Cantidad</th>
                          <th style="text-align: center;">Descripcion</th>
                          <th style="text-align: center;">Acción</th>
                        </thead>
                        <tbody>
                          <tr v-for="ajusteinventario in ajustesData" :key="ajusteinventario.id">
                            <td style="text-align: center;">{{ ajusteinventario.id }}</td>
                            <td style="text-align: center;">{{ ajusteinventario.producto?.nombre }}</td>
                            <td style="text-align: center;">{{ ajusteinventario.almacen?.nombre }}</td>
                            <td style="text-align: center;">
                            {{ ajusteinventario.tipo === 1 ? 'Ingreso' : ajusteinventario.tipo === 2 ? 'Egreso' : 'Desconocido' }}
                            </td>

                            <td style="text-align: center;">{{ ajusteinventario.cantidad }}</td>
                            <td style="text-align: center;">{{ ajusteinventario.descripcion }}</td>

                            <Link v-if="hasPermission('eliminar-ajuste-inventario')" @success="onDeleteSuccess" :href="route('admin.ajustesinventarios.destroy',ajusteinventario)" method="delete" class="bg-red-500 text-white p-2 rounded"  as="button"> Eliminar</Link>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div>

            </div>

          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
import { Head, Link, usePage,useForm } from '@inertiajs/vue3';

  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { computed, watch, ref } from 'vue';
const permissions = computed(() => window.Laravel?.permissions || []);

  const props = defineProps({
    almacenes: Array,
      productos: Array,
      error: String,
      success:String

  });
  const page = usePage();
const ajustesData = ref(page.props.ajustes || {});

  const hasPermission = (permission) => {
  return permissions.value[permission] === true;
};
const onDeleteSuccess = (e) => {
    ajustesData.value = e.props.ajustes;
}

const onSuccess = (e) => {
    ajustesData.value = e.props.ajustes;
}

  const form = useForm({
      producto_id: '',
     almacen_id: '',
    tipo: 0,
      cantidad: 1,
        descripcion: '',

  });



  const selectedAlmacen = computed(() => {
    const almacen = props.almacenes.find(p => p.id === form.almacen_id);
    return almacen ? almacen.nombre : '';
  });

  const selectedProducto = computed(() => {
    const producto = props.productos.find(p => p.id === form.producto_id);
    return producto ? producto.nombre : '';
  });


  watch(() => form.producto_id, (newValue) => {
    form.nombre = selectedProducto.value;
  });

  watch(() => form.almacen_id, (newValue) => {
    form.nombre = selectedAlmacen.value;
  });

const submitForm = () => {

    axios.post(route('admin.ajustesinventarios.agregar'), form)
    .then(response => {
        alert(response.data.message);

    })
    .catch(error => {
        console.log('Hubo un error ', error);
        alert(error);
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
