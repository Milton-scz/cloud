<script setup>

import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const form = useForm({
  nombre: '',
  descripcion: '',

});

const submitForm = () => {
  form.post(route('admin.categorias.store'), {
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
  <Head title="Crear Categoria" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Categoria</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submitForm">
              <div class="space-y-4">
                <div>
                  <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                  <input v-model="form.nombre" type="text" id="nombre" name="nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"  />
                  <p v-if="form.errors.nombre" class="text-sm text-red-500 mt-2">{{ form.errors.nombre }}</p>
                </div>

                <div>
                  <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripcion</label>
                  <input v-model="form.descripcion" type="text" id="descripcion" name="descripcion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"  />
                  <p v-if="form.errors.descripcion" class="text-sm text-red-500 mt-2">{{ form.errors.descripcion }}</p>
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
