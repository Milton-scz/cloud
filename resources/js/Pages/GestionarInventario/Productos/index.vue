<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link,usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
const page = usePage();
const productos = ref(page.props.productos);
const productoSelected = ref(null);
const onDeleteSuccess = (e) => {
    console.log(e);
    productos.value = e.props.productos;
}
const showModal = ref(false);
const roles = computed(() => window.Laravel?.roles || []);
const permissions = computed(() => window.Laravel?.permissions || []);
const userData = computed(() => window.Laravel?.user || {});

const hasRole = (role) => {
  return roles.value.includes(role);
};
const openModal = (producto) => {
    productoSelected.value = producto;  // Asignar el producto seleccionado
    console.log("dddd",productoSelected);
  showModal.value = true;
};

const hasPermission = (permission) => {
  return permissions.value[permission] === true;
};
</script>

<template>
    <Head title="Productos" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Productos
            </h2>
        </template>

        <div>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <section id="contenido_principal">
              <div class="col-md-12" style="margin-top: 10px;">
                <div  v-if="hasPermission('crear-producto')" class="col-md-12 mb-4">
                 <Link :href="route('admin.productos.create')" method="get" as="button" class="bg-blue-500 text-white px-4 py-2 rounded">
                      Crear Producto
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
                          <th style="text-align: center;">Stock</th>
                          <th style="text-align: center;">Precio</th>
                          <th style="text-align: center;">Categoria</th>
                          <th style="text-align: center;">Imagen</th>
                          <th style="text-align: center;">Descripcion</th>
                          <th style="text-align: center;">Acción</th>
                        </thead>
                        <tbody>
                          <tr v-for="producto in productos" :key="producto.id">
                            <td style="text-align: center;">{{ producto.id }}</td>
                            <td style="text-align: center;">{{ producto.nombre }}</td>
                            <td style="text-align: center;">{{ producto.stock_total }}</td>

                            <td style="text-align: center;">{{ producto.precio }}</td>
                            <td style="text-align: center;">
                            {{ producto.categoria ? producto.categoria.nombre : 'Sin categoría' }}
                            </td>
                            <td ><img class="h-16" :src=" producto.imagen"></td>
                            <td style="text-align: center;">{{ producto.descripcion }}</td>
                            <td style="text-align: center;">
                                <button @click="openModal(producto)" class="bg-green-500 text-white p-2 rounded">Ver stock</button>

                                <Link  v-if="hasPermission('editar-producto')" :href="route('admin.productos.edit',producto)" method="get" class="bg-yellow-500 text-white p-2 rounded" as="button"> Editar</Link>
                            <Link  v-if="hasPermission('eliminar-producto')" @success="onDeleteSuccess" :href="route('admin.productos.destroy',producto)" method="delete" class="bg-red-500 text-white p-2 rounded"  as="button"> Eliminar</Link>


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
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm z-50 transition-opacity">
  <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-xl w-96 transform transition-all scale-95 hover:scale-100">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 text-center">
      Stock en almacenes del producto: <span class="text-blue-500">{{ productoSelected.nombre }}</span>
    </h2>

    <div class="mb-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding: 10px;">
                    <div style="height: 100%; overflow: auto;">
                      <table class="table table-bordered table-condensed table-striped" style="width: 100%;">
                        <!-- Encabezados de la tabla -->
                        <thead>
                          <th colspan="5"></th>
                        </thead>
                        <thead style="background-color: #dff1ff;">
                       <th style="text-align: center;">Nombre almacen</th>
                          <th style="text-align: center;">Stock</th>
                        </thead>
                        <tbody>
                          <tr v-for="almacen in productoSelected.almacenes" :key="almacen.id">
                            <td style="text-align: center;">{{ almacen.nombre }}</td>
                            <td style="text-align: center;">{{ almacen.pivot.stock }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
    </div>

    <div class="flex justify-end gap-2">
      <button @click="showModal = false" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg transition">Cancelar</button>
    </div>
  </div>
</div>
  </div>
    </AuthenticatedLayout>
</template>
