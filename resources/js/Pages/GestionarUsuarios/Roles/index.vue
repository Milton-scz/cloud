<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const roles = ref(page.props.roles);
const permissions = ref(page.props.permissions || []); // Todos los permisos disponibles
const selectedPermissions = ref([]); // Array para almacenar los permisos seleccionados
const roleToAssignPermissions = ref(null); // Rol al que se le asignarán los permisos
const showModalAssignPermissions = ref(false); // Estado para controlar la visibilidad del modal
const showModalRemovePermissions = ref(false); // Estado para el modal de eliminar permisos
const roleToRemovePermissions = ref(null); // Guardará el rol seleccionado para eliminar permisos
const selectedPermissionsToRemove = ref([]); // Guardará los permisos a eliminar

const openRemovePermissionsModal = (role) => {
  roleToRemovePermissions.value = role;
  selectedPermissionsToRemove.value = []; // Resetear selección
  showModalRemovePermissions.value = true;
};
const rolesu = computed(() => window.Laravel?.roles || []);
const permissionsu = computed(() => window.Laravel?.permissions || []);
const userData = computed(() => window.Laravel?.user || {});

const hasRole = (role) => {
  return rolesu.value.includes(role);
};

const hasPermission = (permission) => {
  return permissionsu.value[permission] === true;
};
// Función para filtrar los permisos que no tiene el rol
const getAvailablePermissions = (role) => {
  // Filtramos los permisos para excluir aquellos que ya están asignados a este rol
  return permissions.value.filter(permission =>
    !role.permissions.some(assignedPermission => assignedPermission.id == permission.id)
  );
};

const openAssignPermissionsModal = (role) => {
  roleToAssignPermissions.value = role; // Guardamos el rol seleccionado

  // Filtramos los permisos disponibles para este rol
  const availablePermissions = getAvailablePermissions(role);

  selectedPermissions.value = availablePermissions.map(p => p.id); // Preseleccionamos los permisos que no tiene el rol

    showModalAssignPermissions.value = true;
    console.log(showModalAssignPermissions.value);
};

const removePermissions = () => {
  if (!roleToRemovePermissions.value) return;

  axios.post(route('admin.roles.removePermissions', roleToRemovePermissions.value.id), {
    permissions: selectedPermissionsToRemove.value,
  }).then(response => {
    showModalRemovePermissions.value = false;
    const updatedRole = response.data.role;
    const index = roles.value.findIndex(role => role.id === updatedRole.id);
    if (index !== -1) {
      roles.value[index] = updatedRole;
    }
  }).catch(error => {
    console.error(error);
  });
};

const savePermissions = () => {
  if (!roleToAssignPermissions.value) return;

  // Enviar los permisos seleccionados al servidor
  axios.post(route('admin.roles.assignPermissions', roleToAssignPermissions.value.id), {
    permissions: selectedPermissions.value,
  }).then(response => {
    // Cerrar el modal y actualizar los permisos
    showModalAssignPermissions.value = false;
    // Actualizar el rol con los nuevos permisos
    const updatedRole = response.data.role;
    const index = roles.value.findIndex(role => role.id === updatedRole.id);
    if (index !== -1) {
      roles.value[index] = updatedRole;
    }
  }).catch(error => {
    console.error(error);
  });
};
</script>

<template>
  <Head title="Roles" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Roles
      </h2>
    </template>

    <div>
      <!-- Tabla de roles -->
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
              <section id="contenido_principal">
                <div class="col-md-12" style="margin-top: 10px;">
                  <div class="col-md-12 mb-4">
                    <Link :href="route('admin.roles.create')" method="get" as="button" class="bg-blue-500 text-white px-4 py-2 rounded">
                      Crear
                    </Link>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="box box-default" style="border: 1px solid #0c0c0c;">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding: 10px;">
                      <div style="height: 100%; overflow: auto;">
                        <table class="table table-bordered table-condensed table-striped" style="width: 100%;">
                          <thead style="background-color: #dff1ff;">
                            <th style="text-align: center;">Nro</th>
                            <th style="text-align: center;">Nombre</th>
                            <th style="text-align: center;">Descripcion</th>
                            <th style="text-align: center;">Acción</th>
                          </thead>
                          <tbody>
                            <tr v-for="rol in roles" :key="rol.id">
                              <td style="text-align: center;">{{ rol.id }}</td>
                              <td style="text-align: center;">{{ rol.name }}</td>
                              <td style="text-align: center;">{{ rol.guard_name }}</td>
                              <td style="text-align: center;">
                                <Link :href="route('admin.roles.edit', rol)" method="get" class="bg-yellow-500 text-white p-2 rounded" as="button">Editar</Link>
                                <Link @success="onDeleteSuccess" :href="route('admin.roles.destroy', rol)" method="delete" class="bg-red-500 text-white p-2 rounded" as="button">Eliminar</Link>
                                <!-- Botón para asignar permisos -->
                                <button @click="openAssignPermissionsModal(rol)" class="bg-green-500 text-white p-2 rounded">Asignar Permisos</button>
                                <button @click="openRemovePermissionsModal(rol)" class="bg-red-600 text-white p-2 rounded">Eliminar Permisos</button>

                            </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </section>


<!-- Modal para asignar permisos -->
<div v-if="showModalAssignPermissions" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm z-50 transition-opacity">
  <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-xl w-96 transform transition-all scale-95 hover:scale-100">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 text-center">
      Asignar Permisos a: <span class="text-blue-500">{{ roleToAssignPermissions.name }}</span>
    </h2>

    <div class="mb-4">
      <label class="block text-gray-700 dark:text-gray-300 font-semibold">Seleccionar Permisos</label>
      <div class="mt-2 space-y-2 max-h-40 overflow-y-auto p-2 border rounded-lg">
        <div v-for="permission in getAvailablePermissions(roleToAssignPermissions)" :key="permission.id" class="flex items-center gap-2">
          <input type="checkbox" v-model="selectedPermissions" :value="permission.id" class="rounded border-gray-300 text-blue-500 focus:ring focus:ring-blue-300">
          <span class="text-gray-900 dark:text-gray-100">{{ permission.name }}</span>
        </div>
      </div>
    </div>

    <div class="flex justify-end gap-2">
      <button @click="showModalAssignPermissions = false" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg transition">Cancelar</button>
      <button @click="savePermissions" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">Guardar</button>
    </div>
  </div>
</div>

<!-- Modal para eliminar permisos -->
<div v-if="showModalRemovePermissions" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm z-50 transition-opacity">
  <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-xl w-96 transform transition-all scale-95 hover:scale-100">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 text-center">
      Eliminar Permisos de: <span class="text-red-500">{{ roleToRemovePermissions.name }}</span>
    </h2>

    <div class="mb-4">
      <label class="block text-gray-700 dark:text-gray-300 font-semibold">Seleccionar Permisos a Eliminar</label>
      <div class="mt-2 space-y-2 max-h-40 overflow-y-auto p-2 border rounded-lg">
        <div v-for="permission in roleToRemovePermissions.permissions" :key="permission.id" class="flex items-center gap-2">
          <input type="checkbox" v-model="selectedPermissionsToRemove" :value="permission.id" class="rounded border-gray-300 text-red-500 focus:ring focus:ring-red-300">
          <span class="text-gray-900 dark:text-gray-100">{{ permission.name }}</span>
        </div>
      </div>
    </div>

    <div class="flex justify-end gap-2">
      <button @click="showModalRemovePermissions = false" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg transition">Cancelar</button>
      <button @click="removePermissions" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">Eliminar</button>
    </div>
  </div>
</div>





            </div>
          </div>
        </div>
      </div>


    </div>
  </AuthenticatedLayout>
</template>
