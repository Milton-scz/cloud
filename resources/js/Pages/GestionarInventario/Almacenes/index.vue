<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';

// Obtener los datos de almacenes desde las props de la página
const page = usePage();
const almacenesData = ref(page.props.almacenes || {});
const almacenes = ref(almacenesData.value.data || []);
const currentPage = ref(almacenesData.value.current_page || 1);
const lastPage = ref(almacenesData.value.last_page || 1);
const roles = computed(() => window.Laravel?.roles || []);
const permissions = computed(() => window.Laravel?.permissions || []);
const userData = computed(() => window.Laravel?.user || {});

const hasRole = (role) => {
  return roles.value.includes(role);
};

const hasPermission = (permission) => {
  return permissions.value[permission] === true;
};
// Función para cambiar de página
const changePage = (url) => {
  if (url) {
    Inertia.get(url, {}, { preserveState: true, replace: true });
  }
};

// Cálculo de páginas visibles (máximo 3 botones numerados)
const visiblePages = computed(() => {
  let startPage = currentPage.value - 1;
  let endPage = currentPage.value + 1;

  if (startPage < 1) {
    startPage = 1;
    endPage = Math.min(3, lastPage.value);
  }

  if (endPage > lastPage.value) {
    endPage = lastPage.value;
    startPage = Math.max(lastPage.value - 2, 1);
  }

  return almacenesData.value.links.filter((link) => {
    if (isNaN(link.label)) {
      return false;
    }
    const pageNumber = Number(link.label);
    return pageNumber >= startPage && pageNumber <= endPage;
  });
});

// Actualizar almacenes al cambiar de página
const updateAlmacenesData = (newData) => {
  almacenesData.value = newData;
  almacenes.value = newData.data;
  currentPage.value = newData.current_page;
  lastPage.value = newData.last_page;
};
</script>

<template>
  <Head title="Almacenes" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Almacenes</h2>
    </template>

    <div>
      <!-- Contenedor principal -->
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
              <section id="contenido_principal">
                <div class="col-md-12" style="margin-top: 10px;">
                  <div v-if="hasPermission('crear-almacen')" class="col-md-12 mb-4">
                    <Link
                      :href="route('admin.almacenes.create')"
                      method="get"
                      as="button"
                      class="bg-blue-500 text-white px-4 py-2 rounded"
                    >
                      Crear Almacén
                    </Link>
                  </div>
                </div>

                <!-- Tabla de Almacenes -->
                <div class="col-md-12">
                  <div class="box box-default" style="border: 1px solid #0c0c0c;">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding: 10px;">
                      <div style="height: 100%; overflow: auto;">
                        <table class="table table-bordered table-condensed table-striped" style="width: 100%;">
                          <!-- Encabezados de la tabla -->
                          <thead>
                            <tr style="background-color: #dff1ff;">
                              <th style="text-align: center;">Nro</th>
                              <th style="text-align: center;">Nombre</th>
                              <th style="text-align: center;">Dirección</th>
                              <th style="text-align: center;">Capacidad</th>
                              <th style="text-align: center;">Acción</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="almacen in almacenes" :key="almacen.id">
                              <td style="text-align: center;">{{ almacen.id }}</td>
                              <td style="text-align: center;">{{ almacen.nombre }}</td>
                              <td style="text-align: center;">{{ almacen.direccion }}</td>
                              <td style="text-align: center;">{{ almacen.capacidad }}</td>
                              <td style="text-align: center;">
                                <!-- Ver productos y stock -->
                                <Link
                                  :href="route('admin.almacenes.productos', almacen)"
                                  method="get"
                                  class="bg-green-500 text-white px-4 py-2 rounded"
                                  as="button"
                                >
                                  Ver Productos
                                </Link>



                                <!-- Botón Editar -->
                                <Link v-if="hasPermission('editar-almacen')"
                                  :href="route('admin.almacenes.edit', almacen)"
                                  method="get"
                                  class="bg-yellow-500 text-white px-4 py-2 rounded"
                                  as="button"
                                >
                                  Editar
                                </Link>
                                <!-- Botón Eliminar -->
                                <Link v-if="hasPermission('eliminar-almacen')"
                                  @success="onDeleteSuccess"
                                  :href="route('admin.almacenes.destroy', almacen)"
                                  method="delete"
                                  class="bg-red-500 text-white px-4 py-2 rounded"
                                  as="button"
                                >
                                  Eliminar
                                </Link>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Paginación -->
                <div class="mt-4 flex justify-center gap-2">
                  <!-- Botón "Anterior" -->
                  <button
                    v-if="almacenesData.prev_page_url"
                    @click="changePage(almacenesData.prev_page_url)"
                    class="px-4 py-2 rounded border bg-gray-100 text-gray-600 hover:bg-gray-200"
                  >
                    Anterior
                  </button>

                  <!-- Botones numerados -->
                  <button
                    v-for="link in visiblePages"
                    :key="link.url"
                    @click="changePage(link.url)"
                    :disabled="!link.url || link.active"
                    class="px-4 py-2 rounded border"
                    :class="{
                      'bg-blue-500 text-white': link.active,
                      'bg-gray-100 text-gray-600 hover:bg-gray-200': !link.active,
                    }"
                  >
                    {{ link.label }}
                  </button>

                  <!-- Botón "Siguiente" -->
                  <button
                    v-if="almacenesData.next_page_url"
                    @click="changePage(almacenesData.next_page_url)"
                    class="px-4 py-2 rounded border bg-gray-100 text-gray-600 hover:bg-gray-200"
                  >
                    Siguiente
                  </button>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
