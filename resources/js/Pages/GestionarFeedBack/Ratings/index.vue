<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link,usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
const page = usePage();
const ratings = ref(page.props.ratings);
const onDeleteSuccess = (e) => {
    console.log(e);
    ratings.value = e.props.ratings;
}
</script>

<template>
    <Head title="Ratings" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Ratings
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
                <div class="box box-default" style="border: 1px solid #574B90; min-height: 35px;">
                    <Link  :href="route('admin.ratings.create')" method="get" as="button"> Crear Rating</Link>
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
                          <th style="text-align: center;">Usuario</th>
                          <th style="text-align: center;">Producto</th>
                          <th style="text-align: center;">Puntuacion</th>
                          <th style="text-align: center;">Acción</th>
                        </thead>
                        <tbody>
                            <tr v-for="rating in ratings" :key="rating.id">
    <td style="text-align: center;">{{ rating.id }}</td>
    <td style="text-align: center;">{{ rating.user?.name || 'Sin usuario' }}</td>
    <td style="text-align: center;">{{ rating.producto?.nombre || 'Sin producto' }}</td>
    <td style="text-align: center;">{{ rating.puntuacion }}</td>
    <td style="text-align: center;">
        <Link
            :href="route('admin.ratings.destroy',rating)"
            method="delete"
            as="button">
            Eliminar
        </Link>
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
