<script setup>

import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    users: Array,
});

const form = useForm({
  user_id: '',
    descripcion: '',

});

const submitForm = () => {
  form.post(route('admin.comentarios.store'), {
    onSuccess: () => {
      // Redirigir o mostrar un mensaje de éxito
      console.log('creado exitosamente');
    },
    onError: () => {
      console.log('Hubo un error al crear');
    },
  });
};
</script>

<template>
  <Head title="Crear Comentario" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Comentario</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submitForm">
              <div class="space-y-4">
                        <!-- Select de Rol -->
              <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">Usuario</label>
                <select v-model="form.user_id" id="user_id" name="user_id" class="mt-1 block w-full border-2 border-gray-400 text-gray-800 bg-white rounded-md shadow-sm" required>
                    <option value="">Seleccionar Usuario</option>
                    <option v-for="user in props.users" :key="user.id" :value="user.id">{{ user.name }}</option>
                </select>
                </div>

                <div>
                  <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripcion</label>
                  <input v-model="form.descripcion" type="text" id="descripcion" name="descripcion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>


              <div class="mt-6 flex items-center justify-end">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Agregar</button>
              </div>
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
