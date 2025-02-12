<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link,usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
const page = usePage();
const categorias = ref(page.props.categorias);
const onDeleteSuccess = (e) => {
    console.log(e);
    categorias.value = e.props.categorias;
}
const roles = computed(() => window.Laravel?.roles || []);
const permissions = computed(() => window.Laravel?.permissions || []);
const userData = computed(() => window.Laravel?.user || {});

const hasRole = (role) => {
  return roles.value.includes(role);
};

const hasPermission = (permission) => {
  return permissions.value[permission] === true;
};
</script>

<template>
    <Head title="Categorias" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Categorias
            </h2>
        </template>

        <div>
    <!-- Tabla de usuarios -->
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <section id="contenido_principal">
              <div class="col-md-12" style="margin-top: 10px;">
                <div v-if="hasPermission('crear-categoria')" class="col-md-12 mb-4">
                                    <Link :href="route('admin.categorias.create')" method="get" as="button" class="bg-blue-500 text-white px-4 py-2 rounded">
                                        Crear
                                    </Link>
                                </div>
              </div>

              <div class="col-md-12">
                <div class="box box-default" style="border: 1px solid #0c0c0c;">
                  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding: 10px;">
                    <div style="height: 100%; overflow: auto;">
                      <table class="table table-bordered table-condensed table-striped" style="width: 100%;">
                        <!-- Encabezados de la tabla -->
                        <thead>
                          <th colspan="5"></th>
                        </thead>
                        <thead style="background-color: #dff1ff;">
                          <th style="text-align: center;">Nro</th>
                          <th style="text-align: center;">Nombre</th>
                          <th style="text-align: center;">Descripcion</th>
                          <th style="text-align: center;">Acción</th>
                        </thead>
                        <tbody>
                          <tr v-for="categoria in categorias" :key="categoria.id">
                            <td style="text-align: center;">{{ categoria.id }}</td>
                            <td style="text-align: center;">{{ categoria.nombre }}</td>
                            <td style="text-align: center;">{{ categoria.descripcion }}</td>
                            <td style="text-align: center;">


                                <Link v-if="hasPermission('editar-categoria')" :href="route('admin.categorias.edit',categoria)" method="get" class="bg-yellow-500 text-white p-2 rounded" as="button"> Editar</Link>
                            <Link v-if="hasPermission('eliminar-categoria')" @success="onDeleteSuccess" :href="route('admin.categorias.destroy',categoria)" method="delete" class="bg-red-500 text-white p-2 rounded"  as="button"> Eliminar</Link>

                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="my-4">
                    <!-- Paginación -->
                    <pagination :current-page="currentPage" :total-pages="totalPages" @change="loadUsers"></pagination>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de eliminación -->
    <modal v-if="showModal" @close="closeModal">
      <template #header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          ¿Estás seguro que deseas eliminar al usuario {{ modalUser.name }}?
        </h2>
      </template>
      <template #body>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          Una vez que se elimine, todos sus recursos y datos serán eliminados permanentemente.
        </p>
      </template>
      <template #footer>
        <button @click="closeModal" class="btn btn-secondary">Cancelar</button>
        <button @click="deleteUser(modalUser.id)" class="btn btn-danger">Eliminar Usuario</button>
      </template>
    </modal>
  </div>
    </AuthenticatedLayout>
</template>
