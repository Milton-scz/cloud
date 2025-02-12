<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head ,usePage } from '@inertiajs/vue3';
const props = defineProps({
  roles: Array, // Define que se recibe un array de roles
});
const page = usePage();
const user = ref(page.props.user);
const form = useForm({
  name: user.value.name,
  cedula: user.value.cedula,
  celular: user.value.celular,
  direccion: user.value.direccion,
    email: user.value.email,
    password: user.value.password,
    password_confirmation: user.value.password_confirmation,
    role: user.value.roles,  // Campo para el rol
});

const submitForm = () => {
    form.post(route('admin.users.update', { user: user.value.id }), {
    data: form,  // Asegúrate de que todos los datos, incluyendo la imagen, se envíen correctamente
    onSuccess: () => {
        console.log('actualizado exitosamente');
    },
    onError: () => {
        console.log('Hubo un error al actualizar');
    },
});

};
</script>

<template>
  <Head title="Crear Usuario" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Usuario</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submitForm">
              <div class="space-y-4">
                <div>
                  <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                  <input v-model="form.name" type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"  />
                  <p v-if="form.errors.name" class="text-sm text-red-500 mt-2">{{ form.errors.name }}</p>
                </div>

                <div>
                  <label for="cedula" class="block text-sm font-medium text-gray-700">Cédula</label>
                  <input v-model="form.cedula" type="text" id="cedula" name="cedula" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                  <p v-if="form.errors.cedula" class="text-sm text-red-500 mt-2">{{ form.errors.cedula }}</p>
                </div>

                <div>
                  <label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
                  <input v-model="form.celular" type="text" id="celular" name="celular" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"  />
                  <p v-if="form.errors.celular" class="text-sm text-red-500 mt-2">{{ form.errors.celular }}</p>
                </div>

                <div>
                  <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                  <input v-model="form.direccion" type="text" id="direccion" name="direccion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                  <p v-if="form.errors.direccion" class="text-sm text-red-500 mt-2">{{ form.errors.direccion }}</p>
                </div>

                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                  <input v-model="form.email" type="email" id="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"  />

                </div>
              </div>


               <!-- Campos de Contraseña -->
               <div>
                  <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                  <input v-model="form.password" type="password" id="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"  />
                  <p v-if="form.errors.password" class="text-sm text-red-500 mt-2">{{ form.errors.password }}</p>
                </div>

                <div>
                  <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                  <input v-model="form.password_confirmation" type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"  />
                  <p v-if="form.errors.password" class="text-sm text-red-500 mt-2">{{ form.errors.password }}</p>
                </div>

              <!-- Select de Rol -->
              <div>
  <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
  <select v-model="form.role" id="role" name="role" class="mt-1 block w-full border-2 border-gray-400 text-gray-800 bg-white rounded-md shadow-sm" >
    <option value="">Seleccionar Rol</option>
    <option v-for="role in props.roles" :key="role.id" :value="role.id">{{ role.name }}</option>
  </select>
  <p v-if="form.errors.role" class="text-sm text-red-500 mt-2">{{ form.errors.role }}</p>
</div>


              <div class="mt-6 flex items-center justify-end">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Editar Usuario</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
/* Puedes agregar algunos estilos adicionales si lo deseas */
</style>
