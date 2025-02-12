<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link,usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Inertia } from "@inertiajs/inertia";
const page = usePage();
const roles = computed(() => window.Laravel?.roles || []);
const permissions = computed(() => window.Laravel?.permissions || []);
const userData = computed(() => window.Laravel?.user || {});

const hasRole = (role) => {
  return roles.value.includes(role);
};

const hasPermission = (permission) => {
  return permissions.value[permission] === true;
};
const onDeleteSuccess = (e) => {
    console.log(e);
    users.value = e.props.users.data;
}
  // Datos de usuarios
  const usersData = ref(page.props.users || {});
    const users = ref(usersData.value.data || []);
    const currentPage = ref(usersData.value.current_page || 1);
const lastPage = ref(usersData.value.last_page || 1);

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

      return usersData.value.links.filter((link) => {
        if (isNaN(link.label)) {
          return false;
        }
        const pageNumber = Number(link.label);
        return pageNumber >= startPage && pageNumber <= endPage;
      });
    });
</script>

<template>
    <Head title="Usuarios" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Usuarios
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
                <div v-if="hasPermission('crear-usuario')" class="col-md-12 mb-4">
                                    <Link :href="route('admin.users.create')" method="get" as="button" class="bg-blue-500 text-white px-4 py-2 rounded">
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
                            <tr>
                                <th style="text-align: center;">Nro</th>
                                <th style="text-align: center;">Nombre</th>
                                <th style="text-align: center;">Cedula</th>
                                <th style="text-align: center;">Celular</th>
                                <th style="text-align: center;">Direccion</th>
                                <th style="text-align: center;">Roles</th>
                                <th style="text-align: center;">Email</th>
                                <th style="text-align: center;">Acción</th>
                            </tr>
                            </thead>

                        <tbody>
                          <tr v-for="user in users" :key="user.id">
                            <td style="text-align: center;">{{ user.id }}</td>
                            <td style="text-align: center;">{{ user.name }}</td>
                            <td style="text-align: center;">{{ user.cedula }}</td>
                            <td style="text-align: center;">{{ user.celular }}</td>
                            <td style="text-align: center;">{{ user.direccion }}</td>
                            <td>
                                {{ user.roles ? user.roles.map(role => role.name).join(', ') : 'No roles available' }}
                            </td>

                            <td style="text-align: center;">{{ user.email }}</td>
                            <td style="text-align: center;">

                                <Link v-if="hasPermission('editar-usuario')":href="route('admin.users.edit',user)" method="get" class="bg-yellow-500 text-white p-2 rounded" as="button"> Editar</Link>
                            <Link v-if="hasPermission('eliminar-usuario')" @success="onDeleteSuccess" :href="route('admin.users.destroy',user)" method="delete" class="bg-red-500 text-white p-2 rounded"  as="button"> Eliminar</Link>

                            </td>
                          </tr>
                        </tbody>
                      </table>
                        <!-- Paginación -->
        <div class="mt-4 flex justify-center gap-2">
          <!-- Botón "Anterior" -->
          <button
            v-if="usersData.prev_page_url"
            @click="changePage(usersData.prev_page_url)"
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
            v-if="usersData.next_page_url"
            @click="changePage(usersData.next_page_url)"
            class="px-4 py-2 rounded border bg-gray-100 text-gray-600 hover:bg-gray-200"
          >
            Siguiente
          </button>
        </div>
                    </div>
                  </div>
                  <div class="my-4">


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
