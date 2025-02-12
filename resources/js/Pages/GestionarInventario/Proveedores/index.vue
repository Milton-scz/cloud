<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';

// Obtener los datos de proveedores y la información de la paginación desde las props
const page = usePage();
const proveedoresData = ref(page.props.proveedores || {});
const proveedores = ref(proveedoresData.value.data || []);
const currentPage = ref(proveedoresData.value.current_page || 1);
const lastPage = ref(proveedoresData.value.last_page || 1);
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

  return proveedoresData.value.links.filter((link) => {
    if (isNaN(link.label)) {
      return false;
    }
    const pageNumber = Number(link.label);
    return pageNumber >= startPage && pageNumber <= endPage;
  });
});

// Actualizar proveedores al cambiar de página
const updateProveedoresData = (newData) => {
  proveedoresData.value = newData;
  proveedores.value = newData.data;
  currentPage.value = newData.current_page;
  lastPage.value = newData.last_page;
};
</script>

<template>
  <Head title="Proveedores" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Proveedores</h2>
    </template>

    <div>
      <!-- Contenedor principal -->
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
              <section id="contenido_principal">
                <div class="col-md-12" style="margin-top: 10px;">
                  <div  v-if="hasPermission('crear-proveedor')"class="col-md-12 mb-4">
                    <Link
                      :href="route('admin.proveedores.create')"
                      method="get"
                      as="button"
                      class="bg-blue-500 text-white px-4 py-2 rounded"
                    >
                      Crear
                    </Link>
                  </div>
                </div>

                <!-- Tabla de Proveedores -->
                <div class="col-md-12">
                  <div class="box box-default" style="border: 1px solid #0c0c0c;">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding: 10px;">
                      <div style="height: 100%; overflow: auto;">
                        <table class="table table-bordered table-condensed table-striped" style="width: 100%;">
                          <!-- Encabezados de la tabla -->
                          <thead style="background-color: #dff1ff;">
                            <tr>
                              <th style="text-align: center;">Nro</th>
                              <th style="text-align: center;">NIT</th>
                              <th style="text-align: center;">Razón Social</th>
                              <th style="text-align: center;">Celular</th>
                              <th style="text-align: center;">Email</th>
                              <th style="text-align: center;">Acción</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="proveedor in proveedores" :key="proveedor.id">
                              <td style="text-align: center;">{{ proveedor.id }}</td>
                              <td style="text-align: center;">{{ proveedor.nit }}</td>
                              <td style="text-align: center;">{{ proveedor.razonsocial }}</td>
                              <td style="text-align: center;">{{ proveedor.celular }}</td>
                              <td style="text-align: center;">{{ proveedor.email }}</td>
                              <td style="text-align: center;">
                                <Link  v-if="hasPermission('editar-proveedor')"
                                  :href="route('admin.proveedores.edit', proveedor)"
                                  method="get"
                                  class="bg-yellow-500 text-white p-2 rounded"
                                  as="button"
                                >
                                  Editar
                                </Link>
                                <Link  v-if="hasPermission('eliminar-proveedor')"
                                  @success="onDeleteSuccess"
                                  :href="route('admin.proveedores.destroy', proveedor)"
                                  method="delete"
                                  class="bg-red-500 text-white p-2 rounded"
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
                    v-if="proveedoresData.prev_page_url"
                    @click="changePage(proveedoresData.prev_page_url)"
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
                    v-if="proveedoresData.next_page_url"
                    @click="changePage(proveedoresData.next_page_url)"
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
