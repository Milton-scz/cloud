<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

// Obtener los datos de la página
const page = usePage();
const permissions = ref(page.props.permissions || []); // Lista de permisos para renderizar

const onDeleteSuccess = (e) => {
    console.log(e);
    permissions.value = e.props.permissions;
};const rolesu = computed(() => window.Laravel?.roles || []);
const permissionsu = computed(() => window.Laravel?.permissions || []);
const userData = computed(() => window.Laravel?.user || {});

const hasRole = (role) => {
  return rolesu.value.includes(role);
};

const hasPermission = (permission) => {
  return permissionsu.value[permission] === true;
};

</script>

<template>
    <Head title="Permisos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Permisos</h2>
        </template>

        <div>
            <!-- Tabla de usuarios -->
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <section id="contenido_principal">
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <div class="col-md-12 mb-4">
                                        <!-- Botón para crear un permiso -->
                                        <Link
                                            v-if="hasPermission('crear-permiso')"
                                            :href="route('admin.permisos.create')"
                                            method="get"
                                            as="button"
                                            class="bg-blue-500 text-white px-4 py-2 rounded"
                                        >
                                            Crear
                                        </Link>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div
                                        class="box box-default"
                                        style="border: 1px solid #0c0c0c;"
                                    >
                                        <div
                                            class="max-w-7xl mx-auto sm:px-6 lg:px-8"
                                            style="padding: 10px;"
                                        >
                                            <div style="height: 100%; overflow: auto;">
                                                <table
                                                    class="table table-bordered table-condensed table-striped"
                                                    style="width: 100%;"
                                                >
                                                    <!-- Encabezados de la tabla -->
                                                    <thead style="background-color: #dff1ff;">
                                                        <th style="text-align: center;">Nro</th>
                                                        <th style="text-align: center;">Nombre</th>
                                                        <th style="text-align: center;">Guard name</th>
                                                        <th style="text-align: center;">Acción</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr
                                                            v-for="permission in permissions"
                                                            :key="permission.id"
                                                        >
                                                            <td style="text-align: center;">
                                                                {{ permission.id }}
                                                            </td>
                                                            <td style="text-align: center;">
                                                                {{ permission.name }}
                                                            </td>
                                                            <td style="text-align: center;">
                                                                {{ permission.guard_name }}
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <!-- Verificar permisos para editar -->
                                                                <Link
                                                                    v-if="hasPermission('editar-permiso')"
                                                                    :href="route('admin.permisos.edit', permission)"
                                                                    method="get"
                                                                    class="bg-yellow-500 text-white p-2 rounded"
                                                                    as="button"
                                                                >
                                                                    Editar
                                                                </Link>
                                                                <!-- Verificar permisos para eliminar -->
                                                                <Link
                                                                    v-if="hasPermission('eliminar-permiso')"
                                                                    @success="onDeleteSuccess"
                                                                    :href="route('admin.permisos.destroy', permission)"
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
                                        <div class="my-4">
                                            <!-- Paginación -->
                                            <pagination
                                                :current-page="currentPage"
                                                :total-pages="totalPages"
                                                @change="loadUsers"
                                            ></pagination>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
