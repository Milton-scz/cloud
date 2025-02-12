<script setup>

import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  guard_name: '',

});

const submitForm = () => {
  form.post(route('admin.roles.store'), {
    onSuccess: () => {
      console.log('Creado exitosamente');
    },
    onError: (errors) => {
      console.error('Error al crear:', errors); // Muestra todos los errores en consola
      alert('Error: ' + JSON.stringify(errors)); // Opción para mostrar en alerta
    },
  });
};

</script>

<template>
  <Head title="Crear Rol" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Rol</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submitForm">
              <div class="space-y-4">
                <div>
                  <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                  <input v-model="form.name" type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                  <p v-if="form.errors.name" class="text-sm text-red-500 mt-2">{{ form.errors.name }}</p>
                </div>

                <div>
                  <label for="guard_name" class="block text-sm font-medium text-gray-700">Descripcion</label>
                  <input v-model="form.guard_name" type="text" id="guard_name" name="guard_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                  <p v-if="form.errors.guard_name" class="text-sm text-red-500 mt-2">{{ form.errors.guard_name }}</p>
                </div>


              <div class="mt-6 flex items-center justify-end">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Agregar Rol</button>
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
