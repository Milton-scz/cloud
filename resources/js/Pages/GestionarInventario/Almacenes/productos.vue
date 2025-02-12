
<template>
    <Head title="Crear Almacén" />

    <AuthenticatedLayout>
      <template #header>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Productos en el Almacen</h2>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
              <!-- Formulario para crear almacén -->
              <div style="height: 100%; overflow: auto;">
                        <table class="table table-bordered table-condensed table-striped" style="width: 100%;">
                          <!-- Encabezados de la tabla -->
                          <thead>
                            <tr style="background-color: #dff1ff;">
                              <th style="text-align: center;">Nro</th>
                              <th style="text-align: center;">ID del Producto</th>
                              <th style="text-align: center;">Stock</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in productos" :key="item.id">
                              <td style="text-align: center;">{{ item.id }}</td>
                              <td style="text-align: center;">{{ item.producto.nombre}}</td>
                              <td style="text-align: center;">{{ item.stock }}</td>
                              <td style="text-align: center;">

                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
              <div>


    </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>


  <script setup>
  import { ref, onMounted } from 'vue';
  import { usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const page = usePage();
const productos = ref(page.props.productos || {});

console.log("productos en el almacen:", productos.value);


  </script>
