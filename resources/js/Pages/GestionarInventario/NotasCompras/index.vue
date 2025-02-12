<script setup>
import { computed, ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const page = usePage();

// Notas de compra y paginación
const notascompras = ref(page.props.notascompras.data);
const currentPage = ref(page.props.notascompras.current_page);
const totalPages = ref(page.props.notascompras.last_page);
console.log("notas compras:",notascompras.value);
// Roles y permisos
const roles = computed(() => window.Laravel?.roles || []);
const permissions = computed(() => window.Laravel?.permissions || []);
const userData = computed(() => window.Laravel?.user || {});

const hasRole = (role) => {
  return roles.value.includes(role);
};

const hasPermission = (permission) => {
  return permissions.value[permission] === true;
};

// Método para manejar éxito en eliminación
const onDeleteSuccess = (e) => {
  notascompras.value = e.props.notascompras.data;
};

// Estado del modal
const isModalOpen = ref(false);
const selectedNotaCompra = ref(null);

// Abrir el modal con los datos de la nota seleccionada
const openModal = (notacompra) => {
  selectedNotaCompra.value = notacompra;
  console.log("nota compra:",selectedNotaCompra.value);
  isModalOpen.value = true;
};

// Cerrar el modal
const closeModal = () => {
  isModalOpen.value = false;
  selectedNotaCompra.value = null;
};
</script>

<template>
  <Head title="Notas Compras" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Notas de Compra</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <section id="contenido_principal">
              <div class="col-md-12" style="margin-top: 10px;">
                <div v-if="hasPermission('crear-nota-compra')" class="col-md-12 mb-4">
                  <Link :href="route('admin.notascompras.create')" class="bg-blue-500 text-white px-4 py-2 rounded">Crear</Link>
                </div>
              </div>

              <div class="col-md-12">
                <div class="box box-default" style="border: 1px solid #0c0c0c;">
                  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding: 10px;">
                    <div style="height: 100%; overflow: auto;">
                      <table class="table table-bordered table-condensed table-striped" style="width: 100%;">
                        <thead style="background-color: #dff1ff;">
                          <th style="text-align: center;">Nit Proveedor</th>
                          <th style="text-align: center;">Fecha</th>
                          <th style="text-align: center;">Glosa</th>
                          <th style="text-align: center;">Acción</th>
                        </thead>
                        <tbody>
                          <tr v-for="notacompra in notascompras" :key="notacompra.id">
                            <td style="text-align: center;">{{ notacompra.proveedor.nit }}</td>
                            <td style="text-align: center;">{{ notacompra.fecha }}</td>
                            <td style="text-align: center;">{{ notacompra.glosa }}</td>
                            <td style="text-align: center;">
                              <button @click="openModal(notacompra)" class="bg-green-500 text-white p-2 rounded">Ver</button>
                              <Link v-if="hasPermission('eliminar-nota-compra')" @success="onDeleteSuccess" :href="route('admin.notascompras.destroy', notacompra)" method="delete" class="bg-red-500 text-white p-2 rounded">Eliminar</Link>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="my-4">
                    <pagination :current-page="currentPage" :total-pages="totalPages" @change="loadUsers"></pagination>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white rounded-lg shadow-lg w-2/3 p-4">
        <h3 class="text-xl font-bold mb-4">Detalle de Nota de Compra</h3>
        <p><strong>Proveedor NIT:</strong> {{ selectedNotaCompra.proveedor.nit }}</p>
        <p><strong>Fecha:</strong> {{ selectedNotaCompra.fecha }}</p>
        <p><strong>Glosa:</strong> {{ selectedNotaCompra.glosa }}</p>
        <p><strong>Productos:</strong></p>
        <ul>
          <li v-for="producto in selectedNotaCompra.productos" :key="producto.id">
            {{ producto.nombre }} - {{ producto.cantidad }} x {{ producto.precio }}
          </li>
        </ul>
        <button @click="closeModal" class="bg-red-500 text-white px-4 py-2 rounded mt-4">Cerrar</button>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
